<?php
    class LogoutModelo
    {
        function __construct()
        {

        }

        # carga la pagina de logout
        public function renderView()
        {
            require_once 'Vistas/paginas/logout.php';
        }
    }
?>
