<?php 
	session_start();
	$_SESSION['rutaArchivo']="";
	$_SESSION['rutaArchivo']=$_REQUEST['ruta'];
	echo $_SESSION['rutaArchivo'];
 ?>