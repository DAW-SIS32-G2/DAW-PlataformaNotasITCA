<?php
require_once("core/funcionesbd.php");
@session_start();
$carnet = $_SESSION['usuario'];
$docente = $_POST['docente'];
$programa = $_POST['programa'];
$carnet2 = $_POST['carnet'];

if($carnet != $carnet2 || $docente == "" || $programa == "")
{
	echo "Ha alterado el código del sistema para procesar solicitudes inválidas, su acción ha sido registrada y se ha procesado un reporte. Carnet: ".$carnet;
}
else
{
	$titulo = "Solicitud de programa";
	$descripcion = "El alumno con carnet <strong>$carnet2</strong> ha solicitado el programa: <strong>$programa</strong>";
	$objBD = new funcionesBD();
	$sql = "INSERT INTO Notificacion(emisor,destinatario,titulo,descripcion,estado) VALUES ('$carnet2','$docente','$titulo','$descripcion','1')";
	$res = $objBD->ConsultaPersonalizada($sql);
    if($res === TRUE)
    {
      echo "1";
    }
    else
    {
      echo "Error. no se pudo solicitar el programa:\n $res";
    }
 }
?>