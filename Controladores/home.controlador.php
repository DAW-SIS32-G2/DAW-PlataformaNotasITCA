<?php

    /**
    * Pagina de inicio o tunel
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
