<?php include 'plantillas/cabecera.php' ?>
<body style="padding-top:65px;">
  <?php include 'plantillas/menu.php' ?>
  <!-- Inicia el contenido de la página -->
  <div class="container h-100">
    <div class="row">
      <div class="col-lg-4">
        <img class="img-fluid" src="<?= imagenes ?>logo.png"  width="315" height="70">
      </div>
      <div class="col-lg-8">
        <h2>Escuela Especializada en Ingeniería ITCA-FEPADE</h2>
        <h2>Regional Santa Ana</h2>
      </div>
    </div>
    <div class="row">
      <!-- Acá iría el nombre del Ingeniero segun la BD -->
      <div class="col-lg-12 text-center">
        <h1>Bienvenido <?php echo $usuario; ?></h1>
      </div>
    </div>
  </div>
</body>
</html>
