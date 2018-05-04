<?php
define("RAIZ",dirname(__FILE__,3));
require_once(RAIZ."/funcionesbd.php");
if(isset($_POST['grupo']))
{
  ?>
  <form class="form-group" method="post">
      <div class="form-inline">
        <label class="form-label" for="grupo">Seleccione una práctica:</label>
        <select class="form-control" id="grupo" onchange="cargarAlumnos(this.value)">
          <option value="">--Seleccione una opcion--</option>
            <?php
            $bd = new funcionesBD();
            $idModulo = $_POST['grupo'];
            $resultado = $bd->ConsultaPersonalizada("SELECT P.nombrePonderacion,T.nombreTarea,T.cantidadEjercicios from Ponderacion as P inner join Tarea as T on P.idPonderacion=T.idPonderacion where P.idModulo=$idModulo");
            while($arrayGrupos=$resultado->fetch_array(MYSQLI_ASSOC))
                {
                    echo "<option value=\"".$arrayGrupos['nombreTarea']."\">".$arrayGrupos['nombreTarea']."</option>";
                }
            ?>
        </select>
      </div>
  </form>
  <?php
}
else if(isset($_POST['practica']))
{
  ?>
  <table class="table table-bordered">
    <thead class="thead-dark">
      <tr>
        <th>#</th>
        <th>Carnet</th>
        <th>Nombre</th>
        <th>Ejercicios</th>
        <th>Hechos</th>
        <th>Nota</th>
        <th>Información de ejercicios desarrollados</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>carnet1</td>
        <td>Nombre de prueba</td>
        <td>100</td>
        <td><input type="number" step="1" min="0" max="100" name="nota[]" class="form-control" required></td>
        <td>0.00</td>
        <td>
          <input class="form-control" type="text" name="comentario[]" required>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="col-lg-12 text-center">
    <button type="submit" name="send" class="btn btn-success">Actualizar</button>
  </div>
  <?php
}
?>
