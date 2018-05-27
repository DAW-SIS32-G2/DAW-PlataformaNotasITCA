<?php

class install{
    private $bd;

    function __construct($usuario, $passwd, $unins){
        if(empty($unins)){
            $this->bd = new mysqli('localhost', $usuario, $passwd, 'mysql', '3306');
            if ($this->bd->connect_error) {
                return '<script>console.log("La conexión ha fallado: ' . ($this->bd->connect_error) . '");</script>';
            } else {
                echo '<script>console.log("Conexion Iniciada");</script>';
            }
            $fp = fopen('recursos/usuario.sql', 'r');
            $text = '';
            while (!feof($fp)) {

                if ($linea = fgets($fp)) {
                    $text .= $linea;
                }
            }

            $array = explode(';', $text);
            foreach ($array as $l) {
                $this->bd->query($l);
                if ($this->bd->error) {
                    echo '<script>console.log("' . $this->bd->error . '");</script>';
                }
            }
            $this->bd = new mysqli('localhost', $usuario, $passwd, 'SistemaNotasItca');
        }elseif(!empty($unins) && ($unins === TRUE || $unins != '')){
            $this->bd = new mysqli('localhost', $usuario, $passwd, 'mysql', '3306');
            if ($this->bd->connect_error) {
                return '<script>console.log("La conexión ha fallado: ' . ($this->bd->connect_error) . '");</script>';
            } else {
                echo '<script>console.log("Conexion Iniciada");</script>';
            }

        }
    }

    function unzip($ruta){
        try {
            $zip = new ZipArchive();
            $zip_status = $zip->open($ruta);
            if ($zip_status === true) {
                if ($zip->setPassword('sisNotas')) {
                    if (!$zip->extractTo('../')){
                        die("<script>console.log('Failed extracting archive 0: " . @$zip->getStatusString() . " (code: " . $zip_status . ")');</script>");
                    }else
                        echo("<script>console.log('Archivo Extraido');</script>");
                }

                $zip->close();
            } else {
                die("<script>console.log('Failed opening archive: " . @$zip->getStatusString() . " (code: " . $zip_status . ")');</script>");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }

    function createDB(){
        try {
            $fp = fopen('recursos/DBSistemaNotasItca.sql', 'r');
            $text = '';
            while (!feof($fp)) {

                if ($linea = fgets($fp)) {
                    $text .= $linea;
                }
            }
            $array = explode('PHP_EOL', $text);
            foreach ($array as $l) {
                $this->bd->multi_query($l);
                $this->bd->close();
                if ($this->bd->error) {
                    echo '<script>console.log("' . $this->bd->error . '");</script>';
                } else {
                    echo '<script>console.log("Datos Insertados");</script>';
                }
            }

        } catch (Exception $e) {
            echo '<script>console.log("' . $e->getMessage() . '");</script>';
        }
    }

    function desin($dir) {
        try{
            $files = scandir($dir);
            array_shift($files);    // remove '.' from array
            array_shift($files);    // remove '..' from array

            foreach ($files as $file) {
                $file = $dir . '/' . $file;
                if (is_dir($file)) {
                    $this->desin($file);
                    rmdir($file);
                } else {
                    unlink($file);
                }
            }
            if(rmdir($dir)){
                $fp = fopen('recursos/desinstalar.sql', 'r');
                $text = '';
                while (!feof($fp)) {

                    if ($linea = fgets($fp)) {
                        $text .= $linea;
                    }
                }

                $array = explode(';', $text);
                $i=0;
                foreach ($array as $l) {
                    $this->bd->query($l);
                    if ($this->bd->error) {
                        echo '<script>console.log("' . $this->bd->error . '");</script>';
                    }else{
                        $i++;
                    }
                }
                if($i==count($array)){
                    echo '<script>console.log("Desinstalación Completa");</script>';
                }
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }
}