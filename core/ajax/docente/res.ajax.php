<?php
	$carnet = $_POST['carnet'];
	require_once("core/funcionesbd.php");
	require_once("core/criptografia.php");
	$objBase = new funcionesBD();
	$contra = cifrar("itca");
	$respuesta = $objBase->ConsultaPersonalizada("UPDATE Usuario SET contra='$contra' WHERE carnet='$carnet'");
	if($respuesta === TRUE)
	{
		?>
		<div class="alert alert-success alert-dismissible fade show" role="alert">
		  <strong><?php echo $carnet; ?></strong> Se ha cambiado su contraseña.
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<?php
	}
	else
	{
		?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
		  <strong><?php echo $carnet; ?></strong> Ha ocurrido un error.
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<?php
	}
?>
