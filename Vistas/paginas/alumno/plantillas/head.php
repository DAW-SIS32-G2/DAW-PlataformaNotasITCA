<?php
# se inicia la sesion
session_start();

# se incluyen las variables necesarias
require_once getcwd() . "/config/variables.php";

# se define la constante root
define("__ROOT__", dirname(dirname(dirname(dirname(dirname(__FILE__))))));

# se incluye la clase funcionesBD
require_once(__ROOT__ . "/core/funcionesbd.php");
# se verifica si la sesión es la correcta
$usuario = $_SESSION['usuario'];

# se verifica que la persona haya iniciado sesion
if (!isset($_SESSION['usuario']) || $_SESSION['tipo'] != "alumno") {
    header("location: " . urlBase);
}

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
