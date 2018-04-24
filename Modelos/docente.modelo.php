<?php

    class docenteModelo
    {
        private $pagina;

        function __construct()
        {
            $this->pagina = $pagina;
        }
        public function renderView()
        {
            require_once 'Vistas/paginas/docente/index.php';
        }

        public function BuscarPonderaciones()
        {
            @$conex=new mysqli('localhost','root','mysql','SistemaNotasItca');

            if($conex->connect_error)
            {
                echo "error de conexion: ".$conex->connect_error;
                exit();
            }

            $resultado=$conex->query('Select * from Ponderacion');

            

            return $resultado;


        }
    }
?>
