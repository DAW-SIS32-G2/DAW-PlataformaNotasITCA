<?php
  //Acá deberían de ir los requerimentos, tales como config de la BD etc.
  require_once "config/variables.php";

  //Está es la URL a la que se le hará el routing, se está dividiendo de la siguiente manera :
  // dir_servidor/controlador/accion/parametros
  $url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'],'/')) : '/';

  if($url == '/')
  {
    //Si la URL es solo una pleca, significa que se está en el directorio padre, es decir, el inicio, por lo tanto, se debe cargar el index

    //Cargamos el modelo
    require_once __DIR__.'/Modelos/home.modelo.php';
    //Cargamos el controlador
    require_once __DIR__.'/Controladores/home.controlador.php';
    //Cargamos la vista
    require_once __DIR__.'/Vistas/home.vista.php';

    $indexModelo = New HomeModelo();
    $indexControlador = New HomeControlador($indexModelo);
    $indexVista = New HomeVista($indexControlador,$indexModelo);

    //Renderizamos y mostramos la vista
    print $indexVista->index();
  }
  else
  {
    //Si no, significa que estamos accediendo a otra página
    //Entonces iniciaremos el controlador apropiado
    //Y renderizaremos la vista adecuada

    //El primer elemento debería ser un controlador
    $controladorRequerido = $url[0];

    //Si se añade una segunda parte a la URI
    //Deber+ia ser una acción o método
    $accionRequerida = isset($url[1])? $url[1] : '';

    //Lo restante es considerado como argumentos del metodo
    $parametrosRequeridos = array_slice($url,2);

    //Vamos a revisar si este controlador existe
    //Se debería hacer también para la vista y el modelo

    $rutaCtrl = __DIR__.'/Controladores/'.$controladorRequerido.'.controlador.php';

    if(file_exists($rutaCtrl))
    {
      require_once __DIR__.'/Modelos/'.$controladorRequerido.'.modelo.php';
      require_once __DIR__.'/Controladores/'.$controladorRequerido.'.controlador.php';
      require_once __DIR__.'/Vistas/'.$controladorRequerido.'.vista.php';

      //Creamos los nombres de las clases a partir de la URL
      $nombreModelo = ucfirst($controladorRequerido).'Modelo';
      $nombreControlador = ucfirst($controladorRequerido).'Controlador';
      $nombreVista = ucfirst($controladorRequerido).'Vista';

      //Creamos los objetos de las clases anteriores

      $ObjControlador = new $nombreControlador( new $nombreModelo);
      $ObjVista = new $nombreVista($ObjControlador, new $nombreModelo);

      //Si existen parametros dentro del metodo llamado
      if($accionRequerida != '')
      {
        //Entonces llamamos el método por medio de la vistas
        //Llamada dinámica de la vistas
        print $ObjVista->$accionRequerida($parametrosRequeridos[0],$parametrosRequeridos[1]);
      }
      else
      {
        //Si no, solo llamamos el objeto vista
        print $ObjVista->index();
      }
    }
    else
    {
       //Si no existe el controlador, significa que la página no existe, por tanto mostrmos error

       require_once __DIR__.'/Modelos/error.modelo.php';
       require_once __DIR__.'/Controladores/error.controlador.php';
       require_once __DIR__.'/Vistas/error.vista.php';

       $modeloNoEnc = New modeloNoEnc();
       $controladorNoEnc = New controladorNoEnc($modeloNoEnc);
       $vistaNoEnc = New vistaNoEnc($controladorNoEnc,$modeloNoEnc);

       print $vistaNoEnc->index();
    }
  }
?>
