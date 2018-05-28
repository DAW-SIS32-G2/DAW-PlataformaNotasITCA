<?php
session_start();
require_once("core/funcionesbd.php");
require_once("core/criptografia.php");
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
		$carnet = $_SESSION['usuario'];
		$passOrig = ($_POST['passOrig'] != "") ? $_POST['passOrig'] : "null";
		$pass1 =  ($_POST['pass1'] != "") ? $_POST['pass1'] : "null";
		$pass2 =  ($_POST['pass2'] != "") ? $_POST['pass2'] : "null";

		$sql = "SELECT contra FROM Usuario WHERE carnet = '$carnet'";
		$objBD = new funcionesBD();
		$resultado = $objBD->ConsultaPersonalizada($sql);
		while($fila = mysqli_fetch_assoc($resultado))
		{
			$contra = $fila['contra'];
		}

		$contraDesc = descifrar($contra);

		if($contraDesc == $passOrig)
		{
			if($pass1 == $pass2)
			{
				$nvclave = cifrar($pass2);
				$sql = "UPDATE Usuario SET contra='$nvclave' WHERE carnet='$carnet'";
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
			else
			{
				echo "Las claves que ingresó no coinciden";
			}
		}
		else
		{
			echo "La contraseña que ingresó no es correcta";
		}
	break;
}
?>