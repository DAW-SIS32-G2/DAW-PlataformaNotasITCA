<?php
  define("__ROOT__", dirname(__FILE__,3));
  require_once(__ROOT__.'/controladores/docente.controlador.php');
  $objDocenteControlador=new DocenteControlador('DocenteModelo');

  require_once(__ROOT__.'/core/funcionesbd.php');
  $objDocenteModelo=new docenteModelo();

  if (isset($_POST['administrar']))
  {

    $modulo = $_POST['modulo'];

    $resultado=$objDocenteModelo->BuscarPonderaciones($modulo);

    if(gettype($resultado)=="string")
    {
      echo $resultado;
    }
    else
    {
      if ($resultado->num_rows==0)
      {
        echo "<div class='alert alert-warning'>Este modulo no tiene ponderaciones asignadas. Por favor comuniquese con su administrador de bases de datos.</div>";
      }
      else
      {
        $i=0;
        while($arrayPonderaciones=$resultado->fetch_array(MYSQLI_ASSOC))
        {
          $ponderacionesOrdenadas[$i]=$arrayPonderaciones['nombrePonderacion'];
          $porcentajesOrdenados[$i]=$arrayPonderaciones['porcentaje'];
          $idPonderaciones[$i]=$arrayPonderaciones['idPonderacion'];
          $i++;
        }

        $conteo=count($ponderacionesOrdenadas);

        echo '<select class="form-control" name="ponderacion">';

        for ($i=0;$i<$conteo;$i++)
        { 
          ?>
            
            <option value="<?php echo $idPonderaciones[$i]; ?>"><?php echo $ponderacionesOrdenadas[$i]." - ".$porcentajesOrdenados[$i]."%"; ?></option>

          <?php
        }

        echo "</select>";
      }
      
    }

  }

  if(isset($_POST['ConfirmarBorrarPractica']))
  {
    session_start();
    $idTarea=$_REQUEST['idPractica'];
    $carnetDocente=$_SESSION['usuario'];
    $idPonderacion=$_REQUEST['idPonderacion'];

    $resultado=$objDocenteControlador->obtenerTareas($idTarea);


    $Tareas=$resultado->fetch_assoc();

    $nombreTarea=$Tareas['nombreTarea'];
    
    ?>
        <div class="alert alert-warning">
            ¿Esta seguro de borrar esta ponderacion?<br>
            "<?= $nombreTarea ?>"<br>
            Al borrarla se eliminaran todas los archivos y notas ligadas a esta practica. Tanto archivos, directorios y registros.
        </div>
        
        <form action="" method="post">

            <label for="contra">Contraseña actual de docente:
                <input type="password" name="contraDocente" id="contraDocente" class="form-control" required>
            </label><br>

            <input type="hidden" name="idTarea" value="<?= $idTarea ?>">
            <input type="hidden" name="idPonderacion" value="<?= $idPonderacion ?>">
            <input type="hidden" name="carnetDocente" id="carnetDocente" value="<?= $carnetDocente ?>">
            <input type="submit" name="eliminarTarea" value="Eliminar tarea" onclick="return verificarDocente()" class="btn btn-info">
        </form>
    <?php
  }

  if(isset($_POST['cambiarEstadoTarea']))
  {
    $idTarea=$_POST['idTarea'];
    $estado=$_POST['estado'];

    if($estado==0)
    {
      ?>
      <div class='alert alert-warning'>
        Al cerrar esta tarea ningun alumno podra subir archivos a ella.<br>¿Esta seguro que desea cerrar la Practica?
      </div>
      <form action="" method="post">
        <input type="hidden" name="idTarea" value="<?= $idTarea ?>">
        <input type="hidden" name="estado" value="<?= $estado ?>">
        <button class="btn btn-info" name="actualizarEstadoTarea">Cerrar practica</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </form>
      <?php
    }
    else
    {

      ?>
      <div class='alert alert-warning'>
        Abriendo tarea. Los alumnos podran subir archivos hasta la fecha limite que establezca o cuando usted cierre la practica.
      </div>
      <form action="" method="post">
        <label for="fecha">Fecha limite para la practica:
          <input type="date" name="fechaFin" min="<?= date('Y-m-').(date('d')+1) ?>" class="form-control" required>
        </label><br>
        <input type="hidden" name="fechaInicio" value="<?= date('Y-m-d') ?>">
        <input type="hidden" name="idTarea" value="<?= $idTarea ?>">
        <input type="hidden" name="estado" value="<?= $estado ?>">
        <button class="btn btn-info" name="actualizarEstadoTarea">Abrir practica</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
      </form>
      <?php
    }
  }

  if(isset($_POST['editarTarea']))
  {
    $idTarea=$_POST['idTarea'];
    $idModulo=$_POST['idModulo'];
    $idPonderacion=$_POST['idPonderacion'];

    ?>
      <form action="" method="post">
        <label for="nombre">Nuevo nombre de la practica:
          <input type="text" name="nombre" class="form-control" required>
        </label><br>
        <label for="cantidadEjercicios">Cantidad de ejercicios:
          <input type="number" name="cantidadEjercicios" min="1" class="form-control" required>
        </label><br>
        <input type="hidden" name="idTarea" value="<?= $idTarea ?>">
        <input type="hidden" name="idModulo" value="<?= $idModulo ?>">
        <input type="hidden" name="idPonderacion" value="<?= $idPonderacion ?>">
        <button class="btn btn-info" name="editarTarea">Editar practica</button>
      </form>
      <?php
  }
  

  if(isset($_POST['mostrar']))
  {
    $idModulo = $_POST['modulo'];

    $resultado=$objDocenteModelo->mostrarPracticas($idModulo);

    if ($resultado->num_rows<1)
    {
      echo "<div class='alert alert-warning'>Este modulo no tiene practicas asignadas.</div>";
    }
    else
    {
      require_once(__ROOT__.'/core/criptografia.php');

      ?>
        
        <table class="table table-bordered table-light table-hover">
            
          <tr>
            <th>Ponderación</th>
            <th>Práctica</th>
            <th># de<br>ejercicios</th>
            <th>Estado</th>
            <th>Fecha limite</th>
            <th>Opciones</th>
          </tr>

          <?php 
            while($arrayPracticas=$resultado->fetch_array(MYSQLI_ASSOC))
            {
              $nombrePonderacionP[]=$arrayPracticas['nombrePonderacion'];
              $nombreTarea[]=$arrayPracticas['nombreTarea'];
              $cantidadEjercicios[]=$arrayPracticas['cantidadEjercicios'];
              $idTarea[]=$arrayPracticas['idTarea'];
              $idPonderacion[]=$arrayPracticas['idPonderacion'];
              $estadoTarea[]=$arrayPracticas['activo'];
              $fechaFinalizacion[]=$arrayPracticas['fechaFin'];
            }

            $conteoPracticas=count($nombrePonderacionP);

            for($q=0;$q<$conteoPracticas;$q++)
            {
              $resultado=$objDocenteControlador->obtenerSiglas($idModulo);

              $infoModulo=$resultado->fetch_assoc();
              $anyo=$infoModulo['anyo'];
              $siglas=$infoModulo['siglas'];

              $ruta="Archivos/Practicas/".$siglas."-".$anyo."/Ponderacion_".$nombrePonderacionP[$q]."_".$idPonderacion[$q]."/".$nombreTarea[$q]."/";

              $aux=cifrar($ruta);
              $ruta=$aux;

              $archivo=$siglas."-".$anyo."-".$nombreTarea[$q];

              $aux=cifrar($archivo);
              $archivo=$aux;
              ?>
                
                <tr>
                  <td>
                    <?php echo $nombrePonderacionP[$q]; ?>
                  </td>
                  <td>
                    <?php echo $nombreTarea[$q]; ?>
                  </td>
                  <td>
                    <?php echo $cantidadEjercicios[$q]; ?>
                  </td>
                  <td>
                    <?php 
                      if($estadoTarea[$q]==1)
                      {
                        ?>
                          Abierta
                        <?php
                      }

                      else
                      {
                        ?>
                          Cerrada
                        <?php
                      }
                    ?>
                  </td>
                  <td>
                    <?php
                      if($fechaFinalizacion[$q]=="0000-00-00")
                      {
                        echo "";
                      }
                      else
                      {
                        echo $fechaFinalizacion[$q]; 
                      }
                    ?>
                  </td>
                  <td>
                    <button class="btn btn-info" type="button" data-toggle="modal" data-target="#editarModal" data-mod="<?= $idTarea[$q] ?>" data-idmodulo="<?= $idModulo ?>" data-idponderacion="<?= $idPonderacion[$q] ?>">Editar</button>
                  
                    <?php 
                      if($estadoTarea[$q]==1)
                      {
                        ?>
                          <button class="btn btn-info" type="button" data-toggle="modal" data-target="#activarModal" data-mod="<?= $idTarea[$q] ?>" data-estado=0>Cerrar</button>
                        <?php
                      }

                      else
                      {
                        ?>
                          <button class="btn btn-info" type="button" data-toggle="modal" data-target="#activarModal" data-mod="<?= $idTarea[$q] ?>" data-estado=1>Abrir</button>
                        <?php
                      }
                    ?>
                    
                  
                  
                    <button class="btn btn-info" type="button" data-toggle="modal" data-target="#borrarModal" data-mod="<?= $idTarea[$q] ?>" data-ponde="<?= $idPonderacion[$q] ?>">Borrar</button>
                  

                  
                    <button class="btn btn-info" type="button" onclick="comprimirDirectorio('<?= $ruta ?>','<?=  $archivo ?>')">Descargar Archivos</button>
                 
                </tr>

              <?php
            }

           ?>

        </table>
        <!-- Modal Editar  -->
        <div class="modal fade" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Practica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="container" id="divEditarPractica"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Modal activar  -->
        <div class="modal fade" id="activarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Activar/Desactivar Práctica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="container" id="divEstadoTarea">
                  
                </div>
              </div>

            </div>
          </div>
        </div>

        <!-- Modal borrar  -->
        <div class="modal fade" id="borrarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Borrar Practica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="container" id="divBorrarPractica">
                  
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      <?php
    }
  }

?>
