<?php
  $usuario = $_SESSION['usuario'];
  define("__ROOT__", dirname(dirname(__FILE__,3)));
  require_once(__ROOT__.'/core/funcionesbd.php'); 
  $objDocenteModelo=new DocenteModelo();
//Aca van las verificaciones de sesion y otras
?>
<body style="padding-top:65px">
  <div class="container">
    <div class="text-center">
      <h1>Hoja de control de prácticas y laboratorios</h1>
    </div>
    <div class="row">
      <div class="col-lg-4"></div>
      <div class="col-lg-4 text-center">
        <form class="form-group" action="" method="post">
          <div class="form-inline">
            <label class="form-label" for="grupo">Seleccione un grupo:</label>
            <select class="form-control" name="grupo" onchange="consultarNotas(this.value)">
             <?php 
              $resultado=$objDocenteModelo->CargarGrupos();
              if (gettype($resultado)=="string")
              {
                echo "Error al cargar los grupos...";
              }
              else
              {
                $i=0;
                while($arrayGrupos=$resultado->fetch_array(MYSQLI_ASSOC))
                {
                  $nombreModulos[]=$arrayGrupos['nombreModulo'];
                  $nombreGrupos[]=$arrayGrupos['nombreGrupo'].$arrayGrupos['seccion'];
                  $idModulos[]=$arrayGrupos['idModulo'];
                  $tipo[]=$arrayGrupos['tipoModulo'];
                  $i++;
                }
                $conteo=count($nombreModulos);
                echo "<option value=''>--Seleccione una opcion--</option>";
                for($j=0;$j<$conteo;$j++)
                { 
                  ?>
                    <option value='<?php echo $idModulos[$j]; ?>'>
                      <?php echo $nombreGrupos[$j]." - ".$nombreModulos[$j]." (".$tipo[$j].")"; ?>
                    </option>
                  <?php
                }
              }
             ?>
            </select>
          </div>
        </form>
      </div>
      <div class="col-lg-4"></div>
    </div>
    <div id="resultado">
    <!-- Acá se cargan los datos de AJAX -->
    </div>
  </div>
</body>
<script type="text/javascript">
  function consultarNotas(val)
  {
    //procesar
    $.ajax({
      type      : 'post',
      url       : 'ajax/progrupo',
      data      : {grupo:val},
      success   : function(respuesta)
      {
        $('#resultado').html(respuesta);
      }
    });
  }
</script>
