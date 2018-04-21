<?php
  require_once "../config/variables.php";
  session_start();
  $_SESSION['usuario'] = $_POST['carnet'];

  if($_POST['enviar'] == "docente")
  {
    header("location: ".urlBase."docente");
  }
  else {
    header("location: ".urlBase."alumno");
  }
?>
