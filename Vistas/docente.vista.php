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

        
        /*function descargar($idTarea)
        {
            include 'paginas/docente/plantillas/cabecera.php';
            include 'paginas/docente/plantillas/menu.php';
            // obtendremos la carpeta en donde estan los archivos
            require_once("./core/funcionesbd.php");
            require_once("./core/zip.php");
            $objBD = new funcionesBD();
            $res = $objBD->ConsultaPersonalizada("SELECT directorio from tarea where idTarea = '".$idTarea."'");
            while($fila = $res->fetch_array(MYSQLI_ASSOC))
            {
                $ruta = $fila['directorio'];
            }
            $zip = comprimir("./Practicas/".$ruta."/");
            echo "
              <script type='text/javascript'>
                window.location.replace('http://localhost/DAW-PlataformaNotasITCA/Practicas/temp/practicas.zip');
              </script>
            ";
            
        }*/


    }
?>
