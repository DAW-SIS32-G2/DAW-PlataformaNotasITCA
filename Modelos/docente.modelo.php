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
    }
?>
