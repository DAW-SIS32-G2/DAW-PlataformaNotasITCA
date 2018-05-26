<?php
session_start();
require_once("core/funcionesbd.php");
$funcion = $_POST['funcion'];

switch($funcion)
{
	case 1:
		//Actualizar Datos
		$carnet = ($_POST['carnet'] == $_SESSION['usuario']) ? "'".$_POST['carnet']."'" : "null";
		$telefono = ($_POST['telefono'] != "") ? "'".$_POST['telefono']."'" : "null";
		$sexo = ($_POST['sexo'] != "") ? "'".$_POST['sexo']."'" : "null";
		$correo = ($_POST['correo'] != "") ? "'".$_POST['correo']."'" : "null";
		$jornada = ($_POST['jornada'] != "") ? "'".$_POST['jornada']."'" : "null";

		if($carnet == "null")
		{
			echo "No se pueden modificar los datos de otra persona sin iniciar sesión en la respectiva cuenta";
		}
		else
		{
			$sql = "UPDATE Usuario SET telefonoMovil=$telefono, sexo=$sexo, email=$correo, jornada=$jornada WHERE carnet=$carnet";
			$objBD = new funcionesBD();
			$resultado = $objBD->ConsultaPersonalizada($sql);
			if(gettype($resultado) == "boolean" && $resultado === TRUE)
			{
				echo "1";
			}
			else
			{
				echo $resultado;
			}
		}
	break;
	case 2:
		//Actualizar Clave
	break;
}
?>