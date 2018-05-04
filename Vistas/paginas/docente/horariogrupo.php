<?php
define("__ROOT__",dirname(dirname(dirname(dirname(__FILE__)))));
require_once(__ROOT__."/core/funcionesbd.php");
$carnet = $_SESSION['usuario'];
?>
<script type="text/javascript">
function proceso()
{
  //Procesar
  $.ajax({
      type      : 'post',
      url       : 'ajax/horariogrupo',
      data      : {grupo: $('#grupo').val()},
      success   : function(respuesta)
      {
        document.getElementById('resultado').innerHTML = respuesta;
      }
  })

}
</script>
<body style="padding-top:65px;">
  <div class="container">
    <div class="text-center">
      <form class="form-group" method="post">
          <div class="form-inline">
            <label for="grupo" class="col-lg-4">Seleccione un grupo</label>
            <select class="form-control col-lg-4" name="grupo" id="grupo" onchange="proceso();" >
              <?php
                  $bd = new funcionesBD();
                  //La condicion luego se actualizará conforme a los docentes que impartan en cada grupo
                  $res = $bd->ConsultaPersonalizada("select distinct G.nombreGrupo, G.idGrupo from Modulo as M inner join Horario as H on M.idHorario = H.idHorario inner join Grupo as G on H.idGrupo = G.idGrupo where M.carnet='".$_SESSION['usuario']."'");
                  while($fila = $res->fetch_assoc())
                  {
                    echo "<option whatever=\"".$fila['nombreGrupo']."\" value=\"".$fila['idGrupo']."\">".$fila['nombreGrupo']."</option>";
                  }
              ?>
            </select>
          </div>
      </form>
    </div>
    <div id="resultado">
      <!--Acá cargara el resultado del fetch-->
    </div>
  </div>
</body>
