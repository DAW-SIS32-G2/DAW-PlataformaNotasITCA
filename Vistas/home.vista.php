<?php

/**
 * Class HomeVista
 *  Pagina de inicio
 */
class HomeVista
{
    /**
     * @var $model : Contiene el modelo necesario para la interfaz
     * @var $controller : Contiene el controlador de la interfaz
     */
    private $model;

    private $controller;

    /**
     * HomeVista constructor.
     * @param $controller
     * @param $model
     *
     * Se cargan el modelo y el controlador de la interfaz dentro de las propiedades correspondientes
     */
    function __construct($controller, $model)
    {
        $this->controller = $controller;
        $this->model = $model;
    }
    /**
     *  Función que administra el modelo y el controlador para la vista
     */
    public function index()
    {
        return $this->controller->loadView();
    }
}

?>
