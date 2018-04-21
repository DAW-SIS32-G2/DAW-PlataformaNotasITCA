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
}
?>
