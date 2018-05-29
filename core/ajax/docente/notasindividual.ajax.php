<?php
require_once("core/funcionesbd.php");
$idModulo = $_POST['idmodulo'];
$carnet = $_POST['carnet'];

//PRIMERO SELECCIONAREMOS TODAS LAS PONDERACIÓNES DE UN ARCHIVO Y LAS PONDREMOS EN UN ARRAY
$objDocenteModelo = new docenteModelo();
$contponderaciones = 0;
$ponderaciones = array();
$idPonderaciones = array();
$porcentajesPonderacion = array();

$pond=$objDocenteModelo->BuscarPonderaciones($idModulo);
while($fila=$pond->fetch_array(MYSQLI_ASSOC))
{
  $idPonderaciones[$contponderaciones] = $fila['idPonderacion'];
  $ponderaciones[$fila['idPonderacion']] = $fila['nombrePonderacion'];
  $porcentajesPonderacion[$fila['idPonderacion']] = $fila['porcentaje'];
  $contponderaciones++;
}

$promediosModulo = array();
// Ahora, por cada ponderación, vamos a calcular el promedio
foreach($idPonderaciones as $i)
{
  $ponder = $i;
  $bd = new funcionesBD();
  $cons = "Select nota.valor, Tarea.porcentaje, Tarea.cantidadEjercicios, Ponderacion.porcentaje as 'porcentTotal' from Nota INNER JOIN Tarea on Tarea.idTarea = Nota.idTarea INNER JOIN ponderacion on Tarea.idPonderacion = Ponderacion.idPonderacion WHERE Nota.carnet = '".$carnet."' AND ponderacion.idPonderacion = '$ponder'";
  $notas = $bd->ConsultaPersonalizada($cons);
  $promfinal = 0;
  while($nota = mysqli_fetch_assoc($notas))
  {
     $not = ($nota['valor']/$nota['cantidadEjercicios'])*10;
     $promfinal += (($not*$nota['porcentaje'])/$nota['porcentTotal']);
  }
  $promediosModulo[$i] = number_format($promfinal,2);
}

//Ahora, por cada ponderación, buscaremos sus prácticas respectivas y sus ejercicios
$nombresPracticas = array();
$idsPracticas = array();
$notaPractica = array();
$ejerciciosPractica = array();
$hechosPractica = array();

foreach($idPonderaciones as $i)
{
  $ponder = $i;
  $bd = new funcionesBD();
  $cons = "SELECT * FROM Tarea WHERE idPonderacion='$ponder'";
  $practicas = $bd->ConsultaPersonalizada($cons);
  while($practica = mysqli_fetch_assoc($practicas))
  {
      $idP = $practica['idTarea'];
      $nombresPracticas[$ponder][$idP] = $practica['nombreTarea'];
      $idsPracticas[$ponder][$idP] = $practica['idTarea'];
      $ejerciciosPractica[$idP] = $practica['cantidadEjercicios'];
      //Dentro de cada práctica, buscaremos si tiene una nota, y la asignaremos a nuestro array
      $bd = new funcionesBD();
      $cons = "SELECT * FROM Nota WHERE idTarea = '$idP' AND carnet='$carnet'";
      $notaP = $bd->ConsultaPersonalizada($cons);
      //Si esta consulta no devuelve nada, entonces, asignamos nota 0
      if(mysqli_num_rows($notaP) == 0)
      {
         $notaPractica[$idP] = 0;
         $hechosPractica[$idP] = 0;
      }
      else
      {
        $filaP = mysqli_fetch_assoc($notaP);
        $notaPractica[$idP] = number_format(($filaP['valor']/$practica['cantidadEjercicios'])*10,2);
        $hechosPractica[$idP] = $filaP['valor'];
      }
  }
}
//Calcularemos el promedio final de la materia
$promedioModulo = 0;
foreach ($ponderaciones as $id => $nombPond) 
{
    $promedioModulo += ($promediosModulo[$id] * ($porcentajesPonderacion[$id]/100));
}

print_r($hechosPractica);
//Ahora solo queda generar la página
?><h4>Promedio Final de la Materia: <?= number_format($promedioModulo,2) ?></h4><?php
foreach ($ponderaciones as $id => $nombrePonderacion)
{
  //Cada ponderacion será un valor
  ?>
  <br>
  <div class="row">
    <div class="col-lg-4 h-100">
      <!-- Acá debe cargar cada evaluación-->
      <h4 class="align-middle"><?= $nombrePonderacion ?></h4>
    </div>
    <div class="col-lg-8">
        <!-- Acá debe cargar las notas por prácticas -->
        <p>Promedio: <?= $promediosModulo[$id] ?></p>
        <table class="table table-bordered">
            <thead class="thead-dark">
              <tr>
                <th>Practica</th>
                <th>Nota</th>
                <th>Hechos</th>
                <th>Ejercicios</th>
              </tr>
            </thead>
            <tbody>
              <?php
                //Acá será otro bucle que recorra las prácticas de una ponderacion
                foreach($nombresPracticas[$id] as $idP => $nomPractica)
                {
                  ?>
                  <tr>
                    <td><?= $nomPractica ?></td>
                    <td><?= $notaPractica[$idP] ?></td>
                    <td><?= $hechosPractica[$idP] ?></td>
                    <td><?= $ejerciciosPractica[$idP] ?></td>
                  </tr>
                  <?php
                }
              ?>
            </tbody>
        </table>
    </div>
  </div>
  <?php
}
?>
