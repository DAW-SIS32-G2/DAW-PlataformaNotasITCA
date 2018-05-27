<?php

/**
 * Class LogoutVista
 *Administra el modelo y el controlador del logout
 */
class LogoutVista
{

    private $model;

    private $controller;


    function __construct($controller, $model)
    {
        $this->controller = $controller;
        $this->model = $model;
    }

    public function index()
    {
        return $this->controller->loadView();
    }
}

?>
