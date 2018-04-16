<?php
$usuario = $_SESSION['usuario'];
//Aca van las verificaciones de sesion y otras
?>
<script type="text/javascript">
  function cargarPracticas(val)
  {
    $.ajax({

      type      : 'post',
      url       : 'ajax/notaajax.php',
      data      : {grupo : val},
      success   : function(select)
      {
        $('#practicas').html(select)
      }
    })
  }

  function cargarAlumnos(grupo)
  {
    $.ajax({

      type      : 'post',
      url       : 'ajax/notaajax.php',
      data      : {practica : grupo},
      success   : function(select)
      {
        $('#tablaRes').html(select)
      }
    })
  }
</script>
<div class="text-center">
  <p>Usuario: <?php echo $usuario; ?></p>
  <h1>Asignar notas de prácticas</h1>
</div>
<div class="container">
  <div class="row">
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
      <form class="form-group" method="post">
          <div class="form-inline">
            <label class="form-label" for="grupo">Seleccione un grupo:</label>
            <select class="form-control" id="grupo" onchange="cargarPracticas(this.value)">
              <option value="">Seleccione uno....</option>
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
  <div class="row">
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
      <div id="practicas">
          <!-- Aqui cargarán las prácticas-->
      </div>
    </div>
    <div class="col-lg-4"></div>
  </div>
  <div class="row">
    <div class="col-lg-12">
      <div id="tablaRes">

      </div>
    </div>
  </div>
</div>
