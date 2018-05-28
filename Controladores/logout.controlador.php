<?php

    class logoutControlador
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
