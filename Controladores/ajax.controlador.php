<?php
  class ajaxControlador
  {
    private $model;

    function __construct($model)
    {
      $this->model = $model;
    }

    function loadView()
    {
       return $this->model->renderView();
    }
  }
?>
