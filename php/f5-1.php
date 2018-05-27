<?php
require_once 'f4.php';

$act = new install($_POST['user'], $_POST['passwd'], '');
$act->desin('../DAW-PlataformaNotasITCA');
