<?php
  define('__ROOT__',dirname(dirname(dirname(dirname(__FILE__)))));
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
        echo "Este modulo no tiene ponderaciones asignadas. Por favor comuniquese con su administrador de bases de datos.";
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
  elseif(isset($_POST['mostrar']))
  {
    $idModulo = $_POST['modulo'];

    $resultado=$objDocenteModelo->mostrarPracticas($idModulo);

    if ($resultado->num_rows<1)
    {
      echo "Este modulo no tiene practicas asignadas.";
    }
    else
    {
      ?>
        
        <table border="1px">
            
          <tr>
            <th>Evaluación</th>
            <th>Práctica</th>
            <th># de ejercicios</th>
            <th colspan="3">acciones</th>
          </tr>

          <?php 

            $i=0;
            while($arrayPracticas=$resultado->fetch_array(MYSQLI_ASSOC))
            {
              $nombrePonderacionP[]=$arrayPracticas['nombrePonderacion'];
              $nombreTarea[]=$arrayPracticas['nombreTarea'];
              $cantidadEjercicios[]=$arrayPracticas['cantidadEjercicios'];
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
                  <td><a href="#">Editar</a></td>
                  <td><a href="#">ON</a></td>
                  <td><a href="#">Borrar</a></td>
                </tr>

              <?php
            }

           ?>

        </table>

      <?php
    }
  }

?>
