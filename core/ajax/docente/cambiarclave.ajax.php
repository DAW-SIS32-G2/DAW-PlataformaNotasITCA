<?php
	session_start(); 
	require_once("core/funcionesbd.php"); 

	$objDocenteModelo = new docenteModelo();
	$carnet = $_POST['carnet'];
	$passOrig = $_POST['passOrig'];
	$passN1 = $_POST['pass1'];
	$passN2 = $_POST['pass2'];
	$res = $objDocenteModelo->cambiarPassDocente($carnet,$passOrig,$passN1,$passN2);
	echo $res;			
?>