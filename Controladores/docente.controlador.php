<?php

    /**
    * The home page controller
    */
    class docenteControlador
    {
        private $model;

        function __construct($model)
        {
            $this->model = new $model;
        }

        public function loadView()
        {
            return $this->model->renderView();
        }

        public function GuardarGuia($file,$idModulo)
        {
            $nombreTemporal=$file['tmp_name'];

            if (file_exists($nombreTemporal))
            {
                $resultado=$this->model->CargarGrupoIndividual($idModulo);

                while($arrayGrupos=$resultado->fetch_array(MYSQLI_ASSOC))
                {
                    $siglasModulos=$arrayGrupos['siglas'];
                    $anyosModulos=$arrayGrupos['anyo'];
                }

                $nombre=$siglasModulos."_". str_replace(' ','',$_FILES['guia']['name']);

                $rutaArchivo="Archivos/".$siglasModulos."-".$anyosModulos."/".$nombre;

                $contador=2;
                while(file_exists($rutaArchivo))
                {
                        $rutaArchivo="Archivos/".$siglasModulos."-".$anyosModulos."/($contador)".$nombre;
                        $contador++;
                }

                if(!file_exists("Archivos/".$siglasModulos."-".$anyosModulos))
                {
                    mkdir("Archivos/".$siglasModulos."-".$anyosModulos);
                }
                
                move_uploaded_file($nombreTemporal,$rutaArchivo);

                echo "Archivo subido con exito. Ocupara ". $file['size']." bytes de memoria en disco";

                $this->model->GuardarGuiasBaseDatos($nombre,$rutaArchivo,$idModulo);
            }
            else
            {
                echo "Ocurrio un error al subir el archivo: El error es el numero ".$file['error'].". Para saber más sobre este error de click <a target='_blank' href='http://php.net/manual/es/features.file-upload.errors.php'>Aquí</a>";
            }
        }
    }
  ?>
