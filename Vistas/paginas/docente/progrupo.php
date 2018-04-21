<?php
$usuario = $_SESSION['usuario'];
//Aca van las verificaciones de sesion y otras
?>
<body style="padding-top:65px">
  <div class="container">
    <div class="text-center">
      <p>Usuario: <?php echo $usuario; ?></p>
      <h1>Hoja de control de prácticas y laboratorios</h1>
    </div>
    <div class="row">
      <div class="col-lg-4"></div>
      <div class="col-lg-4 text-center">
        <form class="form-group" action="" method="post">
          <div class="form-inline">
            <label class="form-label" for="grupo">Seleccione un grupo:</label>
            <select class="form-control" name="grupo" onchange="consultarNotas(this.value)">
              <!-- Acá se deben cargar los grupos segun el docente -->
              <option value="">Seleccione uno...</option>
              <option value="g1">grupo 1</option>
              <option value="g2">grupo 2</option>
              <option value="g3">grupo 3</option>
              <option value="g4">grupo 4</option>
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
