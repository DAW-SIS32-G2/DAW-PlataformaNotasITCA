<?php

    /**
    * The home page controller
    */
    class HomeControlador
    {
        private $model;

        function __construct($model)
        {
            $this->model = $model;
        }

        public function loadView()
        {
            return $this->model->renderView();
        }


    }
  ?>
