<?php
  class ajaxControlador
  {
    private $model;

      /**
       * ajaxControlador constructor.
       * @param $model
       */
      function __construct($model)
    {
      $this->model = $model;
    }

      /**
       * @return mixed
       */
      function loadView()
    {
       return $this->model->renderView();
    }
  }
?>
