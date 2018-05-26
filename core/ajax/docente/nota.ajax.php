<?php
define("RAIZ",dirname(__FILE__,3));
require_once(RAIZ."/funcionesbd.php");
if(isset($_POST['grupo']))
{
  if(!empty($_POST['grupo']))
  {
    $bd = new funcionesBD();
    $idModulo = $_POST['grupo'];
    $resultado = $bd->ConsultaPersonalizada("SELECT T.idTarea, P.nombrePonderacion,T.nombreTarea,T.cantidadEjercicios from Ponderacion as P inner join Tarea as T on P.idPonderacion=T.idPonderacion where P.idModulo=$idModulo");
    if(mysqli_num_rows($resultado) != 0)
    {
        ?>
        <form class="form-group" method="post">
            <div class="form-inline">
              <label class="form-label" for="grupo">Seleccione una práctica:</label>
              <select class="form-control" id="grupo" onchange="cargarAlumnos(this.value)">
                <option value="">--Seleccione una opcion--</option>
                  <?php
                  while($arrayGrupos=$resultado->fetch_array(MYSQLI_ASSOC))
                  {
                      echo "<option value=\"".$arrayGrupos['idTarea']."\">".$arrayGrupos['nombreTarea']."</option>";
                  }
                  ?>
              </select>
              <input type="hidden" name="idModulo" value="<?= $idModulo ?>">
            </div>
        </form>
    <?php
    }
    else
    {
      ?>
      <p>Este grupo no tiene prácticas asignadas</p>
      <a href="../docente/administrarPracticas">Asignar Prácticas</a>
      <?php
    }
  }
  else
  {
    ?>
      <p>Seleccione un grupo para continuar</p>
      <script type="text/javascript">
        $("#tablaRes").empty();
      </script>
    <?php
  }           
}
else if(isset($_POST['idTarea']))
{
  $idModulo = $_POST['idModulo'];
  $idTarea = $_POST['idTarea'];
  if(!empty($idTarea))
  {
      $bd = new funcionesBD();
      $sql = "Select Usuario.carnet, CONCAT(Usuario.nombres,' ',Usuario.apellidos) AS Estudiante, Nota.valor, Tarea.nombreTarea, Tarea.cantidadEjercicios, TareaSubidaPor.ruta FROM Usuario INNER JOIN Nota ON Nota.carnet = Usuario.carnet INNER JOIN Tarea ON Tarea.idTarea = Nota.idTarea INNER JOIN Ponderacion ON Tarea.idPonderacion = Ponderacion.idPonderacion INNER JOIN UsuarioActivo ON UsuarioActivo.carnet = Usuario.carnet INNER JOIN TareaSubidaPor ON TareaSubidaPor.idTarea = Tarea.idTarea WHERE Tarea.idTarea = '$idTarea' AND Ponderacion.idModulo = '$idModulo' AND UsuarioActivo.idModulo = '$idModulo'";
      $resultado = $bd->ConsultaPersonalizada($sql);
      if(mysqli_num_rows($resultado) != 0)
      {
          ?>
          <form method="post">
            <i class="text-center"><small>NOTA: Acá solo aparecerán los alumnos que ya hayan subido la práctica</small></i>
            <table class="table table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th>Carnet</th>
                  <th>Nombre</th>
                  <th>Ejercicios</th>
                  <th>Hechos</th>
                  <th>Nota</th>
                </tr>
              </thead>
              <tbody>
                <?php
                while($fila = mysqli_fetch_assoc($resultado))
                {
                  $i++;
                  $nota = number_format(($fila['valor']/$fila['cantidadEjercicios'])*10,2);
                  echo "
                    <tr>
                      <td><input type='hidden' name='carnet' value='".$fila['carnet']."'>".$fila['carnet']."</td>
                      <td><input type='hidden' id='ejercicios".$i."' value='".$fila['cantidadEjercicios']."'>".$fila['Estudiante']."</td>
                      <td>".$fila['cantidadEjercicios']."</td>
                      <td>
                        <input type='number' id='valores".$i."' class='form-control' name='valor' value='".$fila['valor']."' onchange='updNota($i)' onkeyup='updNota($i)' min=0 max='".$fila['cantidadEjercicios']."'>
                        <div id='valid".$i."' ></div>
                      </td>
                      <td><p id='nota".$i."'>$nota</p></td>
                    </tr>
                  ";
                }
                ?>
                <tr>
                  <td colspan='6' class='text-center'>
                    <input type="button" onclick="validarNotas(<?= $i ?>)" value="Actualizar Notas" class="btn btn-success">
                  </td>
                </tr>
              </tbody>
            </table>
          </form>
          <div id="mensajenotas">
            <!--acá cargará el mensaje de que se han actualizado las notas-->
          </div>
      <?php
      }
      else
      {
        ?>
          <p>Ningún alumno ha subido esta práctica aún</p>
        <?php
      }
  }
  else
  {
    ?>
    <p>Seleccione una práctica para continuar</p>
    <?php
  }
}
elseif($_POST['actualizar'])
{
  $idTarea = $_POST['tarea'];
  $valores = $_POST['valores'];
  $carnets = $_POST['carnets'];
  $cuenta = count($valores);
  $pasan = 0;
  for($i=0;$i<$cuenta;$i++)
  {
    $bd = new funcionesBD();
    $condicion = "carnet=".$carnets[$i]." AND idTarea=$idTarea";
    $res = $bd->ActualizarRegistro('Nota',"valor",$valores[$i],$condicion);
    if(gettype($res) == "string")
    {
      echo $res;
    }
    else
    {
      $pasan++;
    }
  }
  if($pasan == $cuenta)
  {
    ?>
    <div class="alert alert-success">Se han actualizado las notas correctamente<br><strong>Registros Actualizados: <?=$pasan?></strong></div>
    <?php
  }
  else
  {
    ?>
    <div class="alert alert-danger">No se pueden actualizar las notas</div>
    <?php 
  }
}
?>

