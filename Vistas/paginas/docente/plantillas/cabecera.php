<?php
session_start();
require_once getcwd()."/config/variables.php";
$usuario = $_SESSION['usuario'];
if(!isset($_SESSION['usuario']) || $_SESSION['tipo'] != "docente")
{
    header("location: ".urlBase);
}
// Acá deberá ir el código de sesión y fetching de base de datos
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?= css ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?= css ?>material-icon/material.style.css">
    <script src="<?= js ?>jquery.min.js"></script>
    <script src="<?= js ?>popper.min.js"></script>
    <script src="<?= js ?>bootstrap.min.js"></script>
    <script src="<?= js ?>docente.js"></script>
    <title>ITCA Docentes</title>
  </head>
