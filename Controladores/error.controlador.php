<?php

/**
 * Class controladorNoEnc
 *
 * Se encarga de manejar los posibles errores 404 dentro del servidor
 */
class controladorNoEnc
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
