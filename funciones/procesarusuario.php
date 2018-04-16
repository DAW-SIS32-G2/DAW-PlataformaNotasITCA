<?php
  session_start();
  $_SESSION['usuario'] = $_POST['carnet'];

  if($_POST['enviar'] == "docente")
  {
    header("location: ../docente/index.php");
  }
  else {
    header("location: ../alumno/index.php");
  }
?>
