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
}
?>
