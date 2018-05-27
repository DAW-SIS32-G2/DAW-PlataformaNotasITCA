<?php


# Se inicia la sesión
@session_start();

/**
 * Class alumnoVista
 * Vista de interfaz de alumno
 */
class alumnoVista
{
    /**
     * @var $model : Contiene el modelo necesario para la interfaz
     * @var $controller : Contiene el controlador de la interfaz
     */
    private $model;
    private $controller;

    /**
     * alumnoVista constructor.
     * @param $controller
     * @param $model
     *
     * Se cargan el modelo y el controlador de la interfaz dentro de las propiedades correspondientes
     */
    function __construct($controller, $model)
    {
        $this->model = $model;
        $this->controller = $controller;
    }

    /**
     *  Funciones que administran el modelo y el controlador para cada vista
     */

    function index()
    {
        $this->controller->loadView();
    }

    public function ajax($pagina)
    {
        define('BaseDir', getcwd());
        require_once BaseDir . '/core/ajax/alumno/' . $pagina . '.ajax.php';
    }

    function actualizar()
    {
        include 'paginas/alumno/plantillas/head.php';
        include 'paginas/alumno/plantillas/nav.php';
        require_once 'Vistas/paginas/alumno/actualizar.php';
    }

    function buzon_archivos()
    {
        include 'paginas/alumno/plantillas/head.php';
        include 'paginas/alumno/plantillas/nav.php';
        require_once 'Vistas/paginas/alumno/buzon_archivos.php';
    }

    function notas()
    {
        include 'paginas/alumno/plantillas/head.php';
        include 'paginas/alumno/plantillas/nav.php';
        require_once 'Vistas/paginas/alumno/notas.php';
    }

    function guias()
    {
        include 'paginas/alumno/plantillas/head.php';
        include 'paginas/alumno/plantillas/nav.php';
        require_once 'Vistas/paginas/alumno/guias.php';
    }

    function inscribir()
    {
        include 'paginas/alumno/plantillas/head.php';
        include 'paginas/alumno/plantillas/nav.php';
        require_once 'Vistas/paginas/alumno/inscribir.php';
    }

    function subir_Prac()
    {
        include 'paginas/alumno/plantillas/head.php';
        include 'paginas/alumno/plantillas/nav.php';
        require_once 'Vistas/paginas/alumno/subir_Prac.php';
    }

    function descargar()
    {
        include 'paginas/alumno/plantillas/head.php';
        require_once 'core/descargar.php';
    }

    function editor()
    {
        include 'paginas/alumno/plantillas/head.php';
        include 'paginas/alumno/plantillas/nav.php';
        require_once 'Vistas/paginas/alumno/editor.php';
    }

    function res()
    {
        @include "./Archivos/Editor/resultado" . $_SESSION['usuario'] . ".html";
        $archivo = fopen("./Archivos/Editor/resultado" . $_SESSION['usuario'] . ".html", "w");
        fputs($archivo, "");
        fclose($archivo);
    }

    function html5()
    {
        include 'paginas/alumno/plantillas/head.php';
        include 'paginas/alumno/plantillas/nav.php';
        include 'paginas/alumno/html5.php';
    }

}

?>
