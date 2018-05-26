<?php
	session_start();
	require_once getcwd()."/config/variables.php";
	define("__ROOT__",dirname(dirname(dirname(dirname(dirname(__FILE__))))));
	require_once(__ROOT__."/core/funcionesbd.php");
	//Revisamos si la sesión es la correcta
	$usuario = $_SESSION['usuario'];
	if(!isset($_SESSION['usuario']) || $_SESSION['tipo'] != "alumno")
	{
	    header("location: ".urlBase);
	}
	// $bd = new funcionesBD();
	// //La condicion luego se actualizará conforme a los docentes que impartan en cada grupo
	// $res = $bd->SelectArray('Usuario','permiteModificacion','carnet="'.$_SESSION['usuario'].'"');
	// while($fila = $res->fetch_assoc())
	// {
	// 	if($fila['permiteModificacion'] == 1)
	// 	{
	// 		//Si es igual a 1 es decir que permite modificaciones, entonces habrá que redireccionar
	// 		header("location: ".urlBase."alumno/modificar");
	// 	}
	// }
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?= css ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?= css ?>material-icon/material.style.css">
		<link rel="stylesheet" href="<?= css ?>cust.css">
		<link rel="icon" href="<?= imagenes ?>favicon.png">
    <script src="<?= js ?>jquery.min.js"></script>
    <script src="<?= js ?>popper.min.js"></script>
    <script src="<?= js ?>bootstrap.min.js"></script>
    <script src="<?= js ?>sweetalert.min.js"></script>
    <script src="<?= js ?>alumno.js"></script>
    <title>ITCA Alumnos</title>
  </head>
