<?php

/**
 * Class ajaxModelo
 * Clase que administra el modelo de las paginas de ajax
 */
  class ajaxModelo
  {
      function __construct()
      {

      }

      # pagina por defecto
      function renderView()
      {
          require_once 'Vistas/paginas/docente/ajax/index.php';
      }
  }
?>
