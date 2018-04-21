<?php
define('BaseDir', getcwd());

class ajaxVista
{
  private $model;
  private $controller;
  private $seccion;
  private $pagina;

  function __construct($controller,$model)
  {
    $this->model = $model;
    $this->controller = $controller;
  }

  function index()
  {
    $this->controller->loadView();
  }

  function ajax($seccion,$pagina)
  {
    require(BaseDir.'/core/ajax/'.$seccion.'/'.$pagina.'.ajax.php');
  }
}
?>
