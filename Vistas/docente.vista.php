<?php

    /**
    * The home page view
    */
    class docenteVista
    {

        private $model;

        private $controller;


        function __construct($controller, $model)
        {
            $this->controller = $controller;
            $this->model = $model;
        }

        //Vistas de las distintas páginas del módulo docente
        public function index()
        {
            return $this->controller->loadView();
        }

        public function ajax($pagina)
        {
          define('BaseDir', getcwd());
            require_once BaseDir.'/core/ajax/docente/'.$pagina.'.ajax.php';
        }

        public function mihorario()
        {
            include 'paginas/docente/plantillas/cabecera.php';
            include 'paginas/docente/plantillas/menu.php';
            require_once 'Vistas/paginas/docente/mihorario.php';

        }

        public function horariogrupo()
        {
          include 'paginas/docente/plantillas/cabecera.php';
          include 'paginas/docente/plantillas/menu.php';
          require_once 'Vistas/paginas/docente/horariogrupo.php';
        }

        function progrupo()
        {
          include 'paginas/docente/plantillas/cabecera.php';
          include 'paginas/docente/plantillas/menu.php';
          require_once 'Vistas/paginas/docente/progrupo.php';
        }

        function nota()
        {
          include 'paginas/docente/plantillas/cabecera.php';
          include 'paginas/docente/plantillas/menu.php';
          require_once 'Vistas/paginas/docente/nota.php';
        }

        function inscribir()
        {
          include 'paginas/docente/plantillas/cabecera.php';
          include 'paginas/docente/plantillas/menu.php';
          require_once 'Vistas/paginas/docente/inscribir.php';
        }

        function adminGrupo()
        {
          include 'paginas/docente/plantillas/cabecera.php';
          include 'paginas/docente/plantillas/menu.php';
          require_once 'Vistas/paginas/docente/adminGrupo.php';
        }

    }
?>
