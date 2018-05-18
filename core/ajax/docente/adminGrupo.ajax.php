<?php 
	define("__ROOT__", dirname(__FILE__,4));
	require_once(__ROOT__.'/controladores/docente.controlador.php');
	require_once(__ROOT__.'/core/funcionesbd.php');
	require_once(__ROOT__.'/core/criptografia.php');
	
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

    $contador=0;
    foreach ($guias as $guia)
    {
    	if(!($guia == ".") and !($guia==".."))
    	{
			echo "$contador - ".$guia." ";
    		$contador++;
    		
    		$rutaArchivo=$directorio."/".$guia;

    		$archivoAux=cifrar($rutaArchivo);

    		?>
    				<button onclick='descargar(<?php echo '"'.$archivoAux.'"';?>)'>Descargar</button>
    		<?php 
    		echo "<br><br>";
    	}

    }
    if($contador==0)
    {
    	echo "No hay guias en este modulo";
    }
?>