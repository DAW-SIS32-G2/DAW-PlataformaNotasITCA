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
  if($grupo != "")
  {
    ?>
    <div class="text-center">
      <h1>Horario de <?php echo $grupo ?></h1>
      <div class="col-lg-12 text-center">
        <a class="btn btn-info" href="javascript: w=window.open('<?= urlBase ?>/core/ajax/docente/pdf.ajax.php?pdf=2&grupo=<?= $grupo ?>');">Imprimir este horario</a>
        <br>
        <br>
    </div>
    </div>
    <div class="col-lg-12">
    <?php
    $conn = new mysqli("localhost","usuarioItca","12345","SistemaNotasItca");
    $conn->set_charset("utf8");
    //Creamos el array con los días
    $dias = array('lunes','martes','miercoles','jueves','viernes');
    //Creamos el array con las horas de inicio
    $horas = array("07:00:00","07:50:00","09:00:00","09:50:00","10:40:00","11:30:00","13:00:00","13:50:00","14:40:00","15:30:00","16:20:00","17:10:00","18:00:00");

    //Creamos un array para cada día
    $horario = array();

    //Creamos un array con las posiciones del horario 
    $pos = array(array(1,1,1,1,1),array(2,2,2,2,2),array(3,3,3,3,3),array(4,4,4,4,4),array(5,5,5,5,5),array(6,6,6,6,6),array(7,7,7,7,7),array(8,8,8,8,8),array(9,9,9,9,9),array(10,10,10,10,10),array(11,11,11,11,11),array(12,12,12,12,12));

    for($i=0;$i<count($pos);$i++)
    {
      if($i%2 == 0 && $i>0)
      {
        for($j=0;$j<count($pos[0]);$j++)
        {
          //Acá debe de hacerse la consulta
          $res = $conn->query("Select Modulo.nombreModulo, DetalleModulo.aula, DetalleModulo.horas, CONCAT(Grupo.nombreGrupo,Grupo.seccion) as 'clase', CONCAT(Docente.nombres,' ',Docente.apellidos) as 'encargado', Grupo.seccion FROM DetalleModulo INNER JOIN Grupo on DetalleModulo.idGrupo = Grupo.idGrupo INNER JOIN Modulo on DetalleModulo.idModulo = Modulo.idModulo INNER JOIN Docente ON Docente.carnet = Modulo.carnet where DetalleModulo.horaInicio = '$horas[$i]' and DetalleModulo.dia = '$dias[$j]' and Grupo.nombreGrupo = '$grupo'");
          //Revisamos cuántos resultados nos dió
          if(mysqli_num_rows($res) == 0)
          {
            //Si no nos dió ningun resultado, procedemos a revisar el valor de la posición en la que está, esto con el fin de agregar o no una celda para mostrar espacio vacío
            if($pos[$i][$j] == 0)
            {
              //Si su valor es cero, significa que no podemos agregar una celda, ya que está ya es ocupada por otra celda
              $horario[$i][$j] = "";
            }
            else
            {
              //Si no, debemos agregar una, para mantener el orden
              $horario[$i][$j] = "<td colspan='2'>&nbsp</td>";
            }
          }
          elseif(mysqli_num_rows($res) == 1)
          {
            $arrayDatos = mysqli_fetch_assoc($res);

            //Vamos a evaluar primero si se trata de un bloque de dos horas, pues en este caso, debemos ocupar el valor de la celda subsiguiente
            if($arrayDatos['horas'] == 2)
            {
              //Si se trata de un bloque par, entonces definimos el rowspan en 2 y procedemos a descontar el valor de la siguiente
              $rowspan = 2;
              $pos[$i+1][$j] = 0;
            }
            else
            {
              //Si no, dejamos todo como está
              $rowspan = 1;
            }
            //Si nos devuelve un resultado, existen tres posibilidades, que se trate de una práctica para el grupo A, que se trate de una práctica para el grupo B o de una teórica, por tanto debemos evaluar eso 
            switch($arrayDatos['seccion'])
            {
              case "A":
                //Si se trata del A, primero va la clase y luego una celda vacía
                $horario[$i][$j] = "<td rowspan='$rowspan'><small>".$arrayDatos['nombreModulo']."<br>".$arrayDatos['encargado']."<br>".$arrayDatos['clase']."<br>".$arrayDatos['aula']."</small></td><td rowspan='$rowspan'>$nbsp</td>";
              break;
              case "B":
                //Si se trata del B, primero la celda vacía y luego la clase
                $horario[$i][$j] = "<td rowspan='$rowspan'>$nbsp</td><td rowspan='$rowspan'><small>".$arrayDatos['nombreModulo']."<br>".$arrayDatos['encargado']."<br>".$arrayDatos['clase']."<br>".$arrayDatos['aula']."</small></td>";
              break;
              case "U":
                //Si se trata de una sesión teórica, entonces debe ser una sola celda
                $horario[$i][$j] = "<td colspan='2' rowspan='$rowspan'><small>".$arrayDatos['nombreModulo']."<br>".$arrayDatos['encargado']."<br>".$arrayDatos['clase']."<br>".$arrayDatos['aula']."</small></td>";
              break;
            }
          }
          elseif(mysqli_num_rows($res) == 2)
          {
            //Si devuelve dos valores, entonces se trata de dos prácticas simultáneas por tanto deben ser dos celdas
            //Primero guardamos las dos filas en un solo array
            $contador = 0;
            while($arrayDatos = mysqli_fetch_assoc($res))
            {
              $datos[$contador] = $arrayDatos;
              $contador++;
              //Vamos a evaluar primero si se trata de un bloque de dos horas, pues en este caso, debemos ocupar el valor de la celda subsiguiente
              if($arrayDatos['horas'] == 2)
              {
                //Si se trata de un bloque par, entonces definimos el rowspan en 2 y procedemos a descontar el valor de la siguiente
                $rowspan = 2;
                $pos[$i+1][$j] = 0;
              }
              else
              {
                //Si no, dejamos todo como está
                $rowspan = 1;
              }
            }
            //Ahora procedemos a guardar las filas en nuestra tabla
            $horario[$i][$j] = "<td rowspan='$rowspan'><small>".$datos[0]['nombreModulo']."<br>".$datos[0]['encargado']."<br>".$datos[0]['clase']."<br>".$datos[0]['aula']."</small></td>"."<td rowspan='$rowspan'><small>".$datos[1]['nombreModulo']."<br>".$datos[1]['encargado']."<br>".$datos[1]['clase']."<br>".$datos[1]['aula']."</small></td>";
          }
          
        }
      }
      else
      {
        for($j=0;$j<count($pos[0]);$j++)
        {
          //Acá debe de hacerse la consulta
          $res = $conn->query("Select Modulo.nombreModulo, DetalleModulo.aula, DetalleModulo.horas, CONCAT(Grupo.nombreGrupo,Grupo.seccion) as 'clase', CONCAT(Docente.nombres,' ',Docente.apellidos) as 'encargado', Grupo.seccion FROM DetalleModulo INNER JOIN Grupo on DetalleModulo.idGrupo = Grupo.idGrupo INNER JOIN Modulo on DetalleModulo.idModulo = Modulo.idModulo INNER JOIN Docente ON Docente.carnet = Modulo.carnet where DetalleModulo.horaInicio = '$horas[$i]' and DetalleModulo.dia = '$dias[$j]' and Grupo.nombreGrupo = '$grupo'");
          //Revisamos cuántos resultados nos dió
          if(mysqli_num_rows($res) == 0)
          {
            //Si no nos dió ningun resultado, procedemos a revisar el valor de la posición en la que está, esto con el fin de agregar o no una celda para mostrar espacio vacío
            if($pos[$i][$j] == 0)
            {
              //Si su valor es cero, significa que no podemos agregar una celda, ya que está ya es ocupada por otra celda
              $horario[$i][$j] = "";
            }
            else
            {
              //Si no, debemos agregar una, para mantener el orden
              $horario[$i][$j] = "<td colspan='2'>&nbsp</td>";
            }
          }
          elseif(mysqli_num_rows($res) == 1)
          {
            $arrayDatos = mysqli_fetch_assoc($res);

            //Vamos a evaluar primero si se trata de un bloque de dos horas, pues en este caso, debemos ocupar el valor de la celda subsiguiente
            if($arrayDatos['horas'] == 2)
            {
              //Si se trata de un bloque par, entonces definimos el rowspan en 2 y procedemos a descontar el valor de la siguiente
              $rowspan = 2;
              $pos[$i+1][$j] = 0;
            }
            else
            {
              //Si no, dejamos todo como está
              $rowspan = 1;
            }
            //Si nos devuelve un resultado, existen tres posibilidades, que se trate de una práctica para el grupo A, que se trate de una práctica para el grupo B o de una teórica, por tanto debemos evaluar eso 
            switch($arrayDatos['seccion'])
            {
              case "A":
                //Si se trata del A, primero va la clase y luego una celda vacía
                $horario[$i][$j] = "<td rowspan='$rowspan'><small>".$arrayDatos['nombreModulo']."<br>".$arrayDatos['encargado']."<br>".$arrayDatos['clase']."<br>".$arrayDatos['aula']."</small></td><td rowspan='$rowspan'>$nbsp</td>";
              break;
              case "B":
                //Si se trata del B, primero la celda vacía y luego la clase
                $horario[$i][$j] = "<td rowspan='$rowspan'>$nbsp</td><td rowspan='$rowspan'><small>".$arrayDatos['nombreModulo']."<br>".$arrayDatos['encargado']."<br>".$arrayDatos['clase']."<br>".$arrayDatos['aula']."</small></td>";
              break;
              case "U":
                //Si se trata de una sesión teórica, entonces debe ser una sola celda
                $horario[$i][$j] = "<td colspan='2' rowspan='$rowspan'><small>".$arrayDatos['nombreModulo']."<br>".$arrayDatos['encargado']."<br>".$arrayDatos['clase']."<br>".$arrayDatos['aula']."</small></td>";
              break;
            }
          }
          elseif(mysqli_num_rows($res) == 2)
          {
            //Si devuelve dos valores, entonces se trata de dos prácticas simultáneas por tanto deben ser dos celdas
            //Primero guardamos las dos filas en un solo array
            $contador = 0;
            while($arrayDatos = mysqli_fetch_assoc($res))
            {
              $datos[$contador] = $arrayDatos;
              $contador++;
              //Vamos a evaluar primero si se trata de un bloque de dos horas, pues en este caso, debemos ocupar el valor de la celda subsiguiente
              if($arrayDatos['horas'] == 2)
              {
                //Si se trata de un bloque par, entonces definimos el rowspan en 2 y procedemos a descontar el valor de la siguiente
                $rowspan = 2;
                $pos[$i+1][$j] = 0;
              }
              else
              {
                //Si no, dejamos todo como está
                $rowspan = 1;
              }
            }
            //Ahora procedemos a guardar las filas en nuestra tabla
            $horario[$i][$j] = "<td rowspan='$rowspan'><small>".$datos[0]['nombreModulo']."<br>".$datos[0]['encargado']."<br>".$datos[0]['clase']."<br>".$datos[0]['aula']."</small></td>"."<td rowspan='$rowspan'><small>".$datos[1]['nombreModulo']."<br>".$datos[1]['encargado']."<br>".$datos[1]['clase']."<br>".$datos[1]['aula']."</small></td>";
          }
          
        }
      }
    }

    //Procedemos a mostrar el horario
    echo "
      <table class='table table-bordered table-hover'>
        <thead class='thead-dark text-center'>
          <tr>
            <th width='10%'>Dia</th>
            <th colspan='2' width='18%'>Lunes</th>
            <th colspan='2' width='18%'>Martes</th>
            <th colspan='2' width='18%'>Miércoles</th>
            <th colspan='2' width='18%'>Jueves</th>
            <th colspan='2' width='18%'>Viernes</th>
          </tr>
        </thead>
        <tbody>";
    for($i=0;$i<count($pos);$i++)
    {
      if($i%2==0 && $i>0)
      {
        if($i==2)
        {
          echo 
          "
            <tr>
              <td colspan='11' class='table-secondary text-center'><h3>Receso</h3></td>
            </tr>
            <tr>
              <td>$horas[$i]<br>".$horas[$i+1]."</td>
          ";
          }
        if($i==4)
        {
          echo 
          "
            <tr>
              <td colspan='11' class='table-secondary text-center'><h3>Cambio de Clase</h3></td>
            </tr>
            <tr>
              <td>$horas[$i]<br>".$horas[$i+1]."</td>
          ";
        }
        if($i==6)
        {
          echo 
          "
            <tr>
              <td colspan='11' class='table-secondary text-center'><h2>Medio Día</h2></td>
            </tr>
            <tr>
              <td>$horas[$i]<br>".$horas[$i+1]."</td>
          ";
        }
        if($i==8)
        {
          echo 
          "
            <tr>
              <td colspan='11' class='table-secondary text-center'><h3>Cambio de Clase</h3></td>
            </tr>
            <tr>
              <td>$horas[$i]<br>".$horas[$i+1]."</td>
          ";
        }
        if($i==10)
        {
          echo 
          "
            <tr>
              <td colspan='11' class='table-secondary text-center'><h3>Cambio de Clase</h3></td>
            </tr>
            <tr>
              <td>$horas[$i]<br>".$horas[$i+1]."</td>
          ";
        }
      }
      else
      {
        echo "<tr>
            <td>$horas[$i]<br>".$horas[$i+1]."</td>
        ";
      }
      for($j=0;$j<count($pos[$i]);$j++)
      {
        echo $horario[$i][$j];
      }
      echo "</tr>";
    }
    echo "</tbody>
      </table>";
  }
  else
  {
    echo "Seleccione un grupo para continuar";
  }
?>
</div>
