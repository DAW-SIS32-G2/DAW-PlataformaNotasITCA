<?php
define("__ROOT__", dirname(__FILE__,4));
require_once(__ROOT__.'/core/criptografia.php');

class Zip
{
  public function comprimirTodosArchivos($folderGuias,$nombreArchivo,$folderPracticas)
  {
    session_start();
    $usuario=$_SESSION['usuario'];

    //Creando ruta donde se guardara el zip y el nombre que tendra
    $ruta="Archivos/temp/$usuario/";

    if(!file_exists($ruta))
    {
        mkdir($ruta,0777,true);
    }

    //nombre del archivo de guias
    $archivo = "Archivos/temp/$usuario/".$nombreArchivo."autoZIP_guias.zip";

    if(file_exists($folderGuias))
    {
      //Obteniendo la ruta real del directorio de las guias
      $directorioRaizGuias = realpath($folderGuias);

      //Contador que verificara si existen arcivos a comprimir
      $contador=0;

      $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directorioRaizGuias),RecursiveIteratorIterator::LEAVES_ONLY);
        
      foreach($files as $name => $file)
      {
          // Saltandonos los directorios
          if (!$file->isDir())
          {
            $contador++;
          }
      }

      if(!($contador==0))
      {
        // instanciando ZipArchive
        $zip = new ZipArchive();

        $zip->open($archivo, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        //Creando iterador recursivo de directorios

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directorioRaizGuias),RecursiveIteratorIterator::LEAVES_ONLY);
        

        foreach($files as $name => $file)
        {
            // Saltandonos los directorios
            if (!$file->isDir())
            {
                //Obtenemos la ruta real y la relativa para el archivo actual
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($directorioRaizGuias) + 1);

                //añadimos el archivo actual al zip
                $zip->addFile($filePath, $relativePath);
            }

        }
        //Cerrando la instancia para que se creee el zip
        $zip->close();

        //guardamos la direccion del primer archivo
        $archivosParaComprimir[0]=$archivo;
      }
    }


    

    //nombre del archivo de practicas
    $archivo = "Archivos/temp/$usuario/".$nombreArchivo."autoZIP_practicas.zip";

    if(file_exists($folderPracticas))
    {
      //Obteniendo la ruta real del directorio de las practicas
      $directorioRaizPracticas = realpath($folderPracticas);

      //Contador que verificara si existen arcivos a comprimir
      $contador=0;

      $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directorioRaizPracticas),RecursiveIteratorIterator::LEAVES_ONLY);
        
      foreach($files as $name => $file)
      {
          // Saltandonos los directorios
          if (!$file->isDir())
          {
            $contador++;
          }
      }

      if(!($contador==0))
      {
        // instanciando ZipArchive para la segunda compresion; la de las practicas
        $zip = new ZipArchive();

        $zip->open($archivo, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        //Creando iterador recursivo de directorios
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directorioRaizPracticas),RecursiveIteratorIterator::LEAVES_ONLY);
        

        foreach($files as $name => $file)
        {
            // Saltandonos los directorios
            if (!$file->isDir())
            {
                //Obtenemos la ruta real y la relativa para el archivo actual
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($directorioRaizPracticas) + 1);

                //añadimos el archivo actual al zip
                $zip->addFile($filePath, $relativePath);
            }

        }
      

      //Cerrando la instancia para que se creee el zip
      $zip->close();

      //guardamos la direccion del segundo archivo
      $archivosParaComprimir[1]=$archivo;
      }
    }



    if(isset($archivosParaComprimir))
    {
      if($archivosParaComprimir[0]!="" and !($archivosParaComprimir[1]!=""))
      {
        return $archivosParaComprimir[0];
      }
      elseif($archivosParaComprimir[1]!="" and !($archivosParaComprimir[0]!=""))
      {
        return $archivosParaComprimir[1];
      }
      elseif($archivosParaComprimir[0]!="" and $archivosParaComprimir[1]!="")
      {
        // instanciando ZipArchive para la segunda compresion; la de las practicas
        $zip = new ZipArchive();

        $archivo = "Archivos/temp/$usuario/".$nombreArchivo."autoZIP_TodosLosArchivos.zip";

        $zip->open($archivo, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        //añadimos el archivo actual al zip
        $zip->addFile($archivosParaComprimir[0],"guias.zip");

        $zip->addFile($archivosParaComprimir[1],"practicas.zip");

        //Cerrando la instancia para que se creee el zip
        $zip->close();

        return $archivo;
      }
    }
    else
    {
      return false;
    }
  }

  public function comprimirDirectorio($rutaArchivo, $arcivo)
  {
    session_start();
    $usuario=$_SESSION['usuario'];

    //Creando ruta donde se guardara el zip y el nombre que tendra
    $ruta="Archivos/temp/$usuario/";

    if(!file_exists($ruta))
    {
        mkdir($ruta,0777,true);
    }

    //nombre del archivo de guias
    $archivo = "Archivos/temp/$usuario/".$arcivo."-autoZIP.zip";

    if(file_exists($rutaArchivo))
    {
      //Obteniendo la ruta real del directorio de las guias
      $directorioRaiz = realpath($rutaArchivo);

      //Contador que verificara si existen arcivos a comprimir
      $contador=0;

      $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directorioRaiz),RecursiveIteratorIterator::LEAVES_ONLY);
        
      foreach($files as $name => $file)
      {
          // Saltandonos los directorios
          if (!$file->isDir())
          {
            $contador++;
          }
      }

      if(!($contador==0))
      {
        // instanciando ZipArchive
        $zip = new ZipArchive();

        $zip->open($archivo, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        //Creando iterador recursivo de directorios

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directorioRaiz),RecursiveIteratorIterator::LEAVES_ONLY);
        

        foreach($files as $name => $file)
        {
            // Saltandonos los directorios
            if (!$file->isDir())
            {
                //Obtenemos la ruta real y la relativa para el archivo actual
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($directorioRaiz) + 1);

                //añadimos el archivo actual al zip
                $zip->addFile($filePath, $relativePath);
            }

        }
        //Cerrando la instancia para que se creee el zip
        $zip->close();

        //guardamos la direccion del primer archivo
        return $archivo;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;
    }
  }
}

if(isset($_REQUEST['comprimir']))
{
  $rutaGuias=$_REQUEST['rutaGuias'];

  $rutaPracticas=$_REQUEST['rutaPracticas'];

  $archivo=$_REQUEST['archivo'];

  $objZip=new Zip();

  $resultado=$objZip->comprimirTodosArchivos(descifrar($rutaGuias),descifrar($archivo),descifrar($rutaPracticas));

  if(!$resultado)
  {
    echo false;
  }
  else
  {
    echo cifrar($resultado);
  }

}


if(isset($_REQUEST['comprimirPracticasPonderacion']))
{
  $rutaArchivo=$_REQUEST['rutaArchivo'];
  $archivo=$_REQUEST['archivo'];

  $objZip=new Zip();

  $resultado=$objZip->comprimirDirectorio(descifrar($rutaArchivo),descifrar($archivo));

  if(!$resultado)
  {
    echo false;
  }
  else
  {
    echo cifrar($resultado);
  }
}

if(isset($_REQUEST['comprimirDirectorio']))
{
  $ruta=$_REQUEST['ruta'];

  $archivo=$_REQUEST['archivo'];

  $objZip=new Zip();

  $resultado=$objZip->comprimirDirectorio(descifrar($ruta),descifrar($archivo));


  if(!$resultado)
  {
    echo false;
  }
  else
  {
    echo cifrar($resultado);
  }
}
?>