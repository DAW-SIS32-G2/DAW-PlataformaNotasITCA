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

                $nombre=$siglasModulos."_". str_replace(' ','_',$_FILES['guia']['name']);

                $rutaArchivo="Archivos/Guias/".$siglasModulos."-".$anyosModulos."/".$nombre;

                $contador=2;
                while(file_exists($rutaArchivo))
                {
                        $rutaArchivo="Archivos/Guias/".$siglasModulos."-".$anyosModulos."/($contador)".$nombre;
                        $yaExiste="Ya existe un archivo con ese nombre. El archivo fue guardado como: ($contador)".$nombre."<br>";
                        $contador++;
                }

                if(!file_exists("Archivos/Guias/".$siglasModulos."-".$anyosModulos))
                {
                    mkdir("Archivos/Guias/".$siglasModulos."-".$anyosModulos,0777,true);
                }
                
                move_uploaded_file($nombreTemporal,$rutaArchivo);

                echo $yaExiste."Archivo subido con exito. Ocupara ". $file['size']." bytes de memoria en disco";

                $this->model->GuardarGuiasBaseDatos($nombre,$rutaArchivo,$idModulo);
            }
            else
            {
                echo "Ocurrio un error al subir el archivo: El error es el numero ".$file['error'].". Para saber más sobre este error de click <a target='_blank' href='http://php.net/manual/es/features.file-upload.errors.php'>Aquí</a>";
            }
        }

        public function ObtenerSiglas($idModulo)
        {
            $resultado = $this->model->ObtenerSiglas($idModulo);
            return $resultado;
        }

        public function obtenerInfoSeguridadModulo($idModulo)
        {
            $resultado = $this->model->obtenerInfoSeguridadModulo($idModulo);
            return $resultado;
        }

        public function asignarContra($idModulo,$contra)
        {
            $resultado = $this->model->asignarContra($idModulo,$contra);

            $conteo=count($resultado);

            if($conteo==1)
            {
                return $resultado;
            }
            else
            {
                if(gettype($resultado[0])=="string")
                {
                    return $resultado[0];
                }
                elseif(gettype($resultado[1])=="string")
                {
                    return $resultado[1];
                }
                else
                {
                    return $resultado[1];
                }
            }
        }
        
        public function modificarContra($idModulo,$contra)
        {
        
            $resultado = $this->model->modificarContra($idModulo,$contra);
        }

        public function eliminarContra($idModulo)
        {
        
            $resultado = $this->model->eliminarContra($idModulo);
        }

        public function validarContraDocente($carnetDocente,$contraDocente)
        {
            $resultado=$this->model->obtenerClaveDocente($carnetDocente);

            if(gettype($resultado)=="string")
            {
                return $resultado;
            }

            $arrayContra=$resultado->fetch_assoc();
            $contraDocenteCifrada=$arrayContra['contra'];

            if($contraDocente == descifrar($contraDocenteCifrada))
            {
                return true;
            }
            else
            {
                return "Las claves no coinciden";
            }
        }
    }
  ?>
