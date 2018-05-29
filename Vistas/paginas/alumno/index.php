<?php
$objAlumnoControlador = new alumnoControlador('alumnoModelo');
$objAlumnoControlador->verificarDatos();
?>
<!-- Se incluyen la cabecera y el menu de navegacion-->
<?php include_once 'plantillas/head.php'; ?>
<body>
	<?php include_once 'plantillas/nav.php'; ?>
	<div class="log">
	    <div id="res" style="display: none;">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="<?= imagenes ?>logo.jpg" alt="Logo" class="img-fluid">
                </div>
                <div class="col-md-8">
                    <h1>Instituto Tecnologico Centroamericano</h1>
                    <h1 class="text-center">ITCA-FEPADE</h1>
                </div>
            </div>
        </div>
	    </div>
	</div>
	<script>
	    $(document).ready(function () {
	        $('#res').show('slow');
	    });
	</script>
	</body>
	</html>
