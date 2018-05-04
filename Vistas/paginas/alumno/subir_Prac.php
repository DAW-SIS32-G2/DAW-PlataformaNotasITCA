<div class="res" style="padding-top: 65px;">
  <?php 

    //Funcion para seleccionar las prácticas
    $objAlumno = new alumnoModelo();
    $respuesta = $objAlumno->seleccionarPracticas($_SESSION['usuario']);
  ?>
  <div class="container">
    <h1 class="text-center">Subir Practicas</h1>
    <div align="center">
     <table class="table-hover table-bordered">
        <?php
            while($fila = $respuesta->fetch_array(MYSQLI_ASSOC))
            {
                echo "
                <tr>
                    <td colspan='7' class='text-center'><h4>".$fila['nombreModulo']."</h4></td>
                </tr>";
                ?>
                <tr>
                   <th>ID Practica</th>
                   <th>Descripcion</th>
                   <th>Cantidad de ejercicios</th>
                   <th>Estado</th>
                   <th colspan="2">Subir</th>
                </tr>    
                <?php
                    echo "<tr>";
                    echo "
                        <td>".$fila['idTarea']."</td>
                        <td>".$fila['nombreTarea']."</td>
                        <td>".$fila['cantidadEjercicios']."</td>
                    ";
                    $valid = $objAlumno->verificarSubida($_SESSION['usuario'],$fila['idTarea']);
                    $activ = $objAlumno->verificarActivo($fila['idTarea']);
                    if($valid == 0)
                    {
                        if($activ == 1)
                        {
                            ?>
                                <td>Pendiente</td>
                                <td>
                                    <form action="subir_Prac.php" enctype="multipart/form-data" method="post">
                                      <label>
                                        <input type="file" class="form-control" name="guia<?=$fila['idTarea'] ?>">
                                      </label>
                                </td>
                                <td>
                                      <button class="btn btn-info" type="submit" name="subir" value="<?= $fila['idTarea']?>">
                                        Subir Practica
                                      </button>
                                    </form>
                                </td>
                            <?php
                        }
                        else
                        {
                            ?>
                        <td colspan="2">Práctica Cerrada</td>
                        <?php
                        }
                    }
                    else
                    {
                        ?>
                        <td colspan="2">Práctica Enviada</td>
                        <?php
                    }
                echo "</tr>";
            }
        ?>
      </tr>
    </table>
    <?php
    if(isset($_POST['subir']))
    {
        //Si se cargan varias tareas, necesitamos saber cuál campo se ha usado
        $nomControl = "guia".$_POST['subir'];

        //Obtenemos el nombre original
        $nomOriginal = $_FILES[$nomControl]['name'];

        //Ahora obtendremos la carpeta en donce se subiurá el archivo
        $objBD = new funcionesBD();
        $res = $objBD->ConsultaPersonalizada("SELECT directorio from tarea where idTarea = '".$_POST['subir']."'");
        while($fila = $res->fetch_array(MYSQLI_ASSOC))
        {
            $ruta = $fila['directorio'];
        }

        //Ahora generamos el nombre que le daremos al archivo subido
        $nuevoNom = $_POST['subir']."-".$_SESSION['usuario']."-".$nomOriginal;

        //Finalmente subimos el archivo con el nuevo nombre a la carpeta correspondiente
        if(move_uploaded_file($_FILES[$nomControl]['tmp_name'], dirname(__FILE__,4)."/Practicas/".$ruta."/".$nuevoNom))
        {
            //El archivo se movió con exito, procedemos a insertar el registro en tareas, para poder cerrarlo
            if($respuesta = $objBD->insertar("TareaSubidaPor","carnet,idTarea,ruta","'".$_SESSION['usuario']."','".$_POST['subir']."','".$ruta."/".$nuevoNom."'"))
            {
                //Si la inserción funciona, termina el proceso, se recarga
                echo "Subido con éxito";
            }
            else
            {
                echo "Algo salió mal con la insercion en la BD";
            }
        }
        else
        {
            echo "No se pudo subir el archivo";
        }
    }
    ?>
    </div>
  </div>
</div>
