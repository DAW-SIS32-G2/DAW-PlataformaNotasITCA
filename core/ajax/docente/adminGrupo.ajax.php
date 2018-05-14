<?php 
	define("__ROOT__", dirname(__FILE__,4));
	require_once(__ROOT__.'/controladores/docente.controlador.php');
	require_once(__ROOT__.'/core/funcionesbd.php');

	$idModulo=$_REQUEST['idModulo'];

	$objDocenteControlador=new DocenteControlador('DocenteModelo');

	$resultado=$objDocenteControlador->ObtenerSiglas($idModulo);

	while($arrayModulo=$resultado->fetch_array(MYSQLI_ASSOC))
    {
        $carpetaMod = $arrayModulo['siglas'];
        $anyoModulo=$arrayModulo['anyo'];
    }

    $guias=scandir("Archivos/Guias/".$carpetaMod."-".$anyoModulo);

    $contador=0;
    foreach ($guias as $guia)
    {
    	echo "$contador - ".$guia."<br>";
    	$contador++;
    }
?>