<?php
  define('__ROOT__',dirname(dirname(dirname(dirname(__FILE__)))));
  require_once(__ROOT__.'/core/funcionesbd.php');
  $bd = new funcionesBD();
  //La condicion luego se actualizará conforme a los docentes que impartan en cada grupo
  $grupo = $_POST['grupo'];
  $res = $bd->SelectArray('grupo','*',"idGrupo='$grupo'");
  while($fila = $res->fetch_assoc())
  {
    $grupo = $fila['nombreGrupo'];
  }

?>
<div class="text-center">
  <h1>Horario de <?php echo $grupo ?></h1>
</div>
<div class="col-lg-12">
  <table class="table table-bordered">
    <thead class="thead-dark">
      <tr>
        <th scope="col">Hora/Día</th>
        <th scope="col">Lunes</th>
        <th scope="col">Martes</th>
        <th scope="col">Miércoles</th>
        <th scope="col">Jueves</th>
        <th scope="col">Viernes</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td scope="col">07:00:00<br>07:50:00</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td scope="col">07:50:00<br>08:40:00</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="table-secondary text-center">
        <td colspan="6"><h3>Cambio de clase</h3></td>
      </tr>
      <tr>
        <td scope="col">09:00:00<br>09:50:00</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td scope="col">09:50:00<br>10:40:00</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="table-secondary text-center">
        <td colspan="6"><h3>Cambio de clase</h3></td>
      </tr>
      <tr>
        <td scope="col">10:40:00<br>11:30:00</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td scope="col">11:30:00<br>12:20:00</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="table-secondary text-center">
        <td colspan="6"><h2>MEDIO DÍA</h2></td>
      </tr>
      <tr>
        <td scope="col">13:00:00<br>13:50:00</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td scope="col">13:50:00<br>14:40:00</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="table-secondary text-center">
        <td colspan="6"><h3>Cambio de clase</h3></td>
      </tr>
      <tr>
        <td scope="col">14:40:00<br>15:30:00</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td scope="col">15:30:00<br>16:20:00</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr class="table-secondary text-center">
        <td colspan="6"><h3>Cambio de clase</h3></td>
      </tr>
      <tr>
        <td scope="col">16:20:00<br>17:10:00</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td scope="col">17:10:00<br>18:00:00</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>
</div>
