<?php

    class HomeModelo
    {
        function __construct()
        {

        }

        /**
         * Carga el home requerido
         */
        public function renderView()
        {
            require_once 'Vistas/paginas/home.php';
        }
    }
?>
