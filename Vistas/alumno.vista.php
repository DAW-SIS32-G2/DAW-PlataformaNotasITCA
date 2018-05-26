<?php
class alumnoVista
{
  private $model;
  private $controller;

  function __construct($controller,$model)
  {
    $this->model = $model;
    $this->controller = $controller;
  }

  function index()
  {
    $this->controller->loadView();
  }
  public function ajax($pagina)
  {
    define('BaseDir', getcwd());
      require_once BaseDir.'/core/ajax/alumno/'.$pagina.'.ajax.php';
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

  function practica_prof()
  {
    include 'paginas/alumno/plantillas/head.php';
    include 'paginas/alumno/plantillas/nav.php';
    require_once 'Vistas/paginas/alumno/practica_prof.php';
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

  function subir_Prac2()
  {
    require_once 'Vistas/paginas/alumno/subir_Prac2.php';
  }

  function editor()
  {
    include 'paginas/alumno/plantillas/head.php';
    include 'paginas/alumno/plantillas/nav.php';
    require_once 'Vistas/paginas/alumno/editor.php';
  }

  function res()
  {
    include './core/ajax/alumno/resultado.html';
  }

}
?>
