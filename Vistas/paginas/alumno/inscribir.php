<?php
$objBD = new funcionesBD();
$inscritos = $objBD->ConsultaPersonalizada("SELECT * FROM UsuarioActivo WHERE UsuarioActivo.carnet = '".$_SESSION['usuario']."'");
$i=0;
while($fila2 = mysqli_fetch_assoc($inscritos))
{
  $modulosInscritos[$i] = $fila2['idModulo'];
  $i++;
}

print_r($modulosInscritos);
?>
  <div class="container" style="padding-top: 65px;">

  <h1>Inscribir Grupos</h1>

  <table class="table">
    <tr>
      <th>Docente</th>
      <th>Materia</th>
      <th>Inscribir</th>
    </tr>
      <?php
      $objBD = new funcionesBD();
      $modulos = $objBD->ConsultaPersonalizada("SELECT Grupo.nombreGrupo, CONCAT(docente.nombres,' ',docente.apellidos) AS Docente, CONCAT(Grupo.nombreGrupo,Grupo.seccion,' - ',modulo.nombreModulo) as Materia, modulo.protegidoPorContra, modulo.idModulo FROM Docente INNER JOIN Modulo ON docente.carnet = modulo.carnet INNER JOIN Horario ON horario.idHorario = modulo.idHorario INNER JOIN grupo ON grupo.idGrupo = horario.idGrupo WHERE modulo.activo = 1 AND modulo.estado = 1 AND grupo.idGrupo = (SELECT usuario.idGrupo FROM usuario WHERE usuario.carnet = '".$_SESSION['usuario']."')"); 
      $docentes = array();
      $materias = array();
      $idModulos = array();
      $protegidoPorContra = array();
      $i=0;
      while($fila = mysqli_fetch_assoc($modulos))
      {
          $docentes[$i] = $fila['Docente'];
          $materias[$i] = $fila['Materia'];
          $idModulos[$i] = $fila['idModulo'];
          $protegidoPorContra[$i] = $fila['protegidoPorContra'];
          $nomGrupo = $fila['nombreGrupo'];
          $i++;
      }

      //Ahora buscaremos los grupos teoricos 
      $objBD = new funcionesBD();
      $teoricos = $objBD->ConsultaPersonalizada("SELECT Grupo.nombreGrupo, CONCAT(docente.nombres,' ',docente.apellidos) AS Docente, CONCAT(Grupo.nombreGrupo,Grupo.seccion,' - ',modulo.nombreModulo) as Materia, modulo.protegidoPorContra, modulo.idModulo FROM Docente INNER JOIN Modulo ON docente.carnet = modulo.carnet INNER JOIN Horario ON horario.idHorario = modulo.idHorario INNER JOIN grupo ON grupo.idGrupo = horario.idGrupo WHERE modulo.activo = 1 AND modulo.estado = 1 AND Grupo.nombreGrupo = '$nomGrupo' AND Grupo.seccion = 'U'");
      while($fila = mysqli_fetch_assoc($teoricos))
      {
          $docentes[$i] = $fila['Docente'];
          $materias[$i] = $fila['Materia'];
          $idModulos[$i] = $fila['idModulo'];
          $protegidoPorContra[$i] = $fila['protegidoPorContra'];
          $nomGrupo = $fila['nombreGrupo'];
          $i++;
      }
      for($cant=0;$cant<$i;$cant++)
      {
        if($protegidoPorContra[$cant] == 1)
        {
          $modal = "data-toggle='modal' data-target='#inscribirModal'";
          $clave = "";
        }
        else
        {
          $modal = "";
          $clave = "onclick='inscribirSinClave(".$idModulos[$cant].",'".$_SESSION['usuario']."')'";
        }
        echo "<tr>";
        echo "<td>".$docentes[$cant]."</td>";
        echo "<td>".$materias[$cant]."</td>";
        //Variable para definir si se tendrá que poner un botón o no
        $coincidencias = 0;
        for($ins=0;$ins<count($modulosInscritos);$ins++)
        {
          if($modulosInscritos[$ins] == $idModulos[$cant])
          {
            //Si es igual, significa que se ha inscrito, entonces aumentamos el contador de coincidencias
            $coincidencias++;
          }
        }

        if($coincidencias > 0)
        {
            //Si hubo una coincidencia, ponemos el mensaje inscrito
            echo "<td>Inscrito</td>";
        }
        else
        {
          //Si no, entonces ponemos el botón para que se inscriba
          echo "<td><button class=\"btn btn-primary\" $modal $clave onclick='mandarModulo(".$idModulos[$cant].")'>Inscribir</button></td>";
        }
        echo "</tr>";
      }
      ?>
  </table>
<!-- <script src="js/jquery-latest.js"></script>
<script src="js/bootstrap.min.js"></script> -->

</div>
<script type="text/javascript">
  $('#inscribirModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // span que llamó al evento
      var recipient = button.data('') // extraer los datos del atributo data-*
      var modal = $(this)
      modal.find("#nombre").html(recipient)
      })
</script>
<div class="modal fade" id="inscribirModal" tabindex="-1" role="dialog" aria-labelledby="passModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="passModalLongTitle">Ingresar Contraseña</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <div class="form-group">
            <label for="pass">Contraseña</label>
            <input type="password" class="form-control" name="passwd" id="pass"><br>
            <input type="hidden" id="idenModulo">
            <input type="hidden" id="carnetIns" value="<?= $_SESSION['usuario'] ?>">
            <div id="resspass"></div>
          </div>
          <button class="btn btn-primary" type="button" onclick="inscribirConClave()">Inscribir</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="inscribirSinClave" tabindex="-1" role="dialog" aria-labelledby="passModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="passModalLongTitle">Inscrito Correctamente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Se ha inscrito correctamente en la materia
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="passModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="passModalLongTitle">Error</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Ha ocurrido un error al inscribirse<br>
        <div id="mensajeError"></div>
      </div>
    </div>
  </div>
</div>
