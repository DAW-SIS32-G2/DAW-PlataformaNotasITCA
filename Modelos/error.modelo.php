<?php
  class modeloNoEnc
  {
    function __construct()
    {

    }

    # carga la pagina de error 404
    public function renderView()
    {
        require_once 'Vistas/paginas/error.php';
    }
  }
?>
