<?php
  define('__ROOT__',dirname(__FILE__,3));
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

        echo '<select name="ponderacion">';

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
      ?>
        
        <table class="table table-bordered table-light table-hover">
            
          <tr>
            <th>Evaluación</th>
            <th>Práctica</th>
            <th># de ejercicios</th>
            <th colspan="4">acciones</th>
          </tr>

          <?php 

            $i=0;
            while($arrayPracticas=$resultado->fetch_array(MYSQLI_ASSOC))
            {
              $nombrePonderacionP[]=$arrayPracticas['nombrePonderacion'];
              $nombreTarea[]=$arrayPracticas['nombreTarea'];
              $cantidadEjercicios[]=$arrayPracticas['cantidadEjercicios'];
              $idTarea[]=$arrayPracticas['idTarea'];
              $i++;
            }

            $conteoPracticas=count($nombrePonderacionP);

            for($q=0;$q<$conteoPracticas;$q++)
            { 
              ?>
                
                <tr>
                  <td><?php echo $nombrePonderacionP[$q]; ?></td>
                  <td><?php echo $nombreTarea[$q]; ?></td>
                  <td><?php echo $cantidadEjercicios[$q]; ?></td>
                  <td><a href="" data-toggle="modal" data-target="#editarModal">Editar</a></td>
                  <td><a href="" data-toggle="modal" data-target="#activarModal">ON</a></td>
                  <td><a href="" data-toggle="modal" data-target="#borrarModal">Borrar</a></td>
                  <td><a href="descargar/<?= $idTarea[$q]?>" >Descargar Archivos de esta prácticas</a></td>
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
                ...
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Guardar</button>
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
                ...
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar Cambios</button>
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
                ...
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Guardar Cambios</button>
              </div>
            </div>
          </div>
        </div>
      <?php
    }
  }

?>
