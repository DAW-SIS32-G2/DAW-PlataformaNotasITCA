<?php
  class alumnoControlador
  {
    private $model;

    function __construct($model)
    {
      $this->model = $model;
    }

    function loadView()
    {
       return $this->model->renderView();
    }

    function subirArchivo($archivo,$carnet,$idTarea,$ruta)
    {
        $nombreArchivo = $carnet."_".$idTarea."_".str_replace(" ","_",$archivo['name']);
        $directorio = $ruta."/".$nombreArchivo;

        if(strlen($directorio) > 250)
        {
          echo "El nombre de archivo es demasiado largo, intente con uno más corto";
        }
        else
        {
          if(move_uploaded_file($archivo["tmp_name"],$directorio))
          {
            $res = $this->model->guardarPractica($carnet,$directorio,$idTarea);
            if($res == 1)
            {
              echo "Archivo subido con éxito";
            }
            else
            {
              unlink($directorio);
              echo $res;
            }
          }
          else
          {
            echo "Ha ocurrido un error en la subida del archivo";
          }
        }
    }
  }
?>
