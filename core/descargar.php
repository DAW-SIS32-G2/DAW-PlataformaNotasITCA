<?php

$descargar=new DescargarArchivo();
$descargar->Descargar($_SESSION['archivoDescargar']);
header('location: /docente/admingrupo');

class DescargarArchivo
{
    public function Descargar($archivo)
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($archivo));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($archivo));
        ob_clean();
        flush();
        readfile($archivo);
    }
}



?>