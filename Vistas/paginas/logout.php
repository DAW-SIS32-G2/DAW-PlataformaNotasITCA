<?php
require_once getcwd()."/config/variables.php";
session_start();
session_unset();
session_destroy();
header("location: ".urlBase);
?>
