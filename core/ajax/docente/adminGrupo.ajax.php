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

    $directorio="Archivos/Guias/".$carpetaMod."-".$anyoModulo;

    $guias=scandir($directorio);

    header('location: http://localhost/repositorios/DAW-PlataformaNotasITCA/docente/admingrupo');
    	

    /*$contador=0;
    foreach ($guias as $guia)
    {
    	if(!($guia == ".") and !($guia==".."))
    	{
			echo "$contador - ".$guia."<br>";
    		$contador++;


    		@session_start();
    		
    		/*$_SESSION['archivoDescargar']=$directorio."/".$guia;
    		header('location: /core/descargar.php');
    	
    	}

    }*/
?>