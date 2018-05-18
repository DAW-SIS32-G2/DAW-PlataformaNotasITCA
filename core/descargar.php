<?php
echo "<br><br><br>";
define("__ROOT__", dirname(__FILE__,2));
require_once(__ROOT__.'/core/criptografia.php');

$rutaArchivo=$_SESSION['rutaArchivo'];

$descargar=new DescargarArchivo();
$descargar->Descargar($rutaArchivo);

class DescargarArchivo
{
    public function Descargar($archivo)
    {
        $aux=descifrar($archivo);
        $archivo=$aux;
        
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