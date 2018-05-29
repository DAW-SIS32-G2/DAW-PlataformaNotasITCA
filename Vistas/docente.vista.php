<?php

/**
 * Class docenteVista
 *  Clase que se encarga de proveer de su modelo y controlador respectivos a cada vista.
 */
    class docenteVista
    {
        /**
         * @var $model : Contiene el modelo necesario para la interfaz
         * @var $controller : Contiene el controlador de la interfaz
         */
        private $model;

        private $controller;

        /**
         * docenteVista constructor.
         * @param $controller
         * @param $model
         *
         * Se cargan el modelo y el controlador de la interfaz dentro de las propiedades correspondientes
         */
        function __construct($controller, $model)
        {
            $this->controller = $controller;
            $this->model = $model;
        }

        /**
         *  Funciones que administran el modelo y el controlador para cada vista
         */

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

        function registrar()
        {
          include 'paginas/docente/plantillas/cabecera.php';
          include 'paginas/docente/plantillas/menu.php';
          require_once 'Vistas/paginas/docente/registrar.php';
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

        function administrarPracticas()
        {
          include 'paginas/docente/plantillas/cabecera.php';
          include 'paginas/docente/plantillas/menu.php';
          require_once 'Vistas/paginas/docente/administrarPracticas.php';
        }

        function restablecer()
        {
          include 'paginas/docente/plantillas/cabecera.php';
          include 'paginas/docente/plantillas/menu.php';
          require_once 'Vistas/paginas/docente/restablecer.php';
        }

        function descargar()
        {
          include 'paginas/docente/plantillas/cabecera.php';
          require_once 'core/descargar.php';
        }

        function cambiarclave()
        {
          include 'paginas/docente/plantillas/cabecera.php';
          include 'paginas/docente/plantillas/menu.php';
          require_once 'Vistas/paginas/docente/cambiarclave.php';
        }

        function estadoGrupos()
        {
          include 'paginas/docente/plantillas/cabecera.php';
          include 'paginas/docente/plantillas/menu.php';
          require_once 'Vistas/paginas/docente/estadoGrupos.php';
        }

        function notificaciones()
        {
          include 'paginas/docente/plantillas/cabecera.php';
          include 'paginas/docente/plantillas/menu.php';
          require_once 'Vistas/paginas/docente/notificaciones.php';
        }

        function nominas()
        {
          include 'paginas/docente/plantillas/cabecera.php';
          include 'paginas/docente/plantillas/menu.php';
          require_once 'Vistas/paginas/docente/nominas.php';
        }
            
        function actBuzon()
        {
          include 'paginas/docente/plantillas/cabecera.php';
          include 'paginas/docente/plantillas/menu.php';
          require_once 'Vistas/paginas/docente/actBuzon.php';
        }
    }
?>
