<?php
require_once("core/criptografia.php");
require_once("core/funcionesbd.php");

if(isset($_POST['sinClave']))
{
	$sinClave = 1;
}
else
{
	$sinClave = 0;
}
if($sinClave == 1)
{
	$carnet = $_POST['carnet'];
	$modulo = $_POST['idModulo'];
	$objBD = new funcionesBD();

	$insercion = $objBD->insertar("UsuarioActivo","carnet,idModulo","'$carnet','$modulo'");
	if(gettype($insercion) != "string")
	{
		echo "1";
	}
	else
	{
		echo $insercion;
	}
}
else
{
	$carnet = $_POST['carnet'];
	$clave = $_POST['contra'];
	$modulo = $_POST['idModulo'];

	$objetoBD = new funcionesBD();
	$contrasena = $objetoBD->ConsultaPersonalizada("SELECT contraModulo from Modulo where idModulo = ".$modulo);

	while($fila = mysqli_fetch_assoc($contrasena))
	{
		$claveReal = $fila['contraModulo'];
	}

	$claveDescifrada = descifrar($claveReal);


	if($claveDescifrada == $clave)
	{
		$objBD = new funcionesBD();
		$insercion = $objBD->insertar("UsuarioActivo","carnet,idModulo","'$carnet','$modulo'");
		if(gettype($insercion) != "string")
		{
			echo "2";
		}
	}
	else
	{
		echo "1";
	}
}
?>