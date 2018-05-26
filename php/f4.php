<?php

class instalar
{
    private $bd;

    function __construct($usuario, $passwd)
    {
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
    }

    function unzip($ruta)
    {
        try {
            $zip = new ZipArchive();
            if ($zip->open($ruta)) {
                $zip->extractTo('/jm/');
                $zip->close();
                echo 'extraccion completa';
            } else {
                echo 'fallo al abrir';
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function createDB()
    {
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
}