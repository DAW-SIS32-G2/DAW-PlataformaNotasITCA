<?php
define("__ROOT__", dirname(__FILE__,4));
require_once(__ROOT__.'/core/criptografia.php');
class Zip
{
  function comprimir($folder,$nombreArchivo)
  {
    //Obteniendo la ruta real del directorio
    $rootPath = realpath($folder);
    // instanciando ZipArchive
    $zip = new ZipArchive();

    $ruta='Archivos/temp/';

    if(!file_exists($ruta))
    {
        mkdir($ruta,0777,true);
    }

    $archivo = 'Archivos/temp/'.$nombreArchivo."ZIP_guias.zip";

    $zip->open($archivo, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    //Creando iterador recursivo de directorios

    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath),RecursiveIteratorIterator::LEAVES_ONLY);

    foreach($files as $name => $file)
    {
        // Saltandonos los directorios
        if (!$file->isDir())
        {
            //Obtenemos la ruta real y la relativa para el archivo actual
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);

            //añadimos el archivo actual al zip
            $zip->addFile($filePath, $relativePath);
        }
    }
    //Cerrando la instancia para que se creee el zip
    $zip->close();
    return $archivo;
  }

  function borrarZip($ruta)
  {
    $aux=descifrar($ruta);

    unlink($aux);
    echo $aux;
  }

}

if(isset($_REQUEST['comprimir']))
{
  $ruta=$_REQUEST['ruta'];

  $archivo=$_REQUEST['archivo'];

  $objZip=new Zip();

  $resultado=$objZip->comprimir($ruta,$archivo);

  echo cifrar($resultado);
}


if(isset($_REQUEST['borrar']))
{
  $ruta=$_REQUEST['ruta'];

  $objZip=new Zip();

  $resultado=$objZip->borrarZip($ruta);
}
?>