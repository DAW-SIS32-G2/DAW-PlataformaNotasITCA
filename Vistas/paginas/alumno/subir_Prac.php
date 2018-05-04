<div class="res" style="padding-top: 65px;">
  <?php 
    //Funcion para seleccionar las prácticas
    $objAlumno = new alumnoModelo();
    $respuesta = $objAlumno->seleccionarPracticas($_SESSION['usuario']);
  ?>
  <div class="container">
    <h1 class="text-center">Subir Practicas</h1>
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
                   <th></th>
                </tr>    
                <?php
                    echo "<tr>";
                    echo "
                        <td>".$fila['idTarea']."</td>
                        <td>".$fila['nombreTarea']."</td>
                        <td>".$fila['cantidadEjercicios']."</td>
                        <td>Aqui va el estado</td>
                    ";
                ?>
                <td>
                    <form action="" enctype="multipart/form-data" method="post">
                      <label>
                        <input type="file" class="form-control" name="guia">
                      </label>
                </td>
                <td>
                      <button class="btn btn-info">
                        Subir Practica
                      </button>
                    </form>
                </td>
                <?php
                echo "</tr>";
            }
        ?>
      </tr>
    </table>
  </div>
</div>
