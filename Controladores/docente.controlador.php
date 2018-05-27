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
                        $yaExiste="Ya existe un archivo con ese nombre. El archivo fue guardado como: ($contador)".$nombre;
                        $contador++;
                }

                if(!file_exists("Archivos/Guias/".$siglasModulos."-".$anyosModulos))
                {
                    mkdir("Archivos/Guias/".$siglasModulos."-".$anyosModulos,0777,true);
                }

                move_uploaded_file($nombreTemporal,$rutaArchivo);

                $estado =  @$yaExiste."\\nArchivo subido con exito. Ocupara ". $file['size']." bytes de memoria en disco";

                $this->model->GuardarGuiasBaseDatos($nombre,$rutaArchivo,$idModulo);
                ?>
                <script type="text/javascript">
                    swal({
                        text    : "<?= $estado ?>",
                        icon    : "success",
                        button  : "Aceptar"
                    })
                </script>
                <?php
            }
            else
            {
                $estado =  "Ocurrio un error al subir el archivo: El error es el numero ".$file['error'];

                ?>
                <script type="text/javascript">
                    swal({
                        text    : "<?= $estado ?>",
                        icon    : "error",
                        button  : "Aceptar"
                    })
                </script>
                <?php
            }
        }

        public function ObtenerSiglas($idModulo)
        {
            $resultado = $this->model->ObtenerSiglas($idModulo);
            return $resultado;
        }

        public function obtenerCantidadTareas($idPonderacion)
        {
            $resultado = $this->model->obtenerCantidadTareas($idPonderacion);
            return $resultado;
        }

        public function obtenerPorcentajePonderacion($idPonderacion)
        {
            $resultado = $this->model->obtenerPorcentajePonderacion($idPonderacion);
            return $resultado;
        }

        public function InsertarPracticas($nombrePractica,$porcentajeTarea,$cantidadEjercicios,$idPonderacion,$carpetaMod,$anyoModulo)
        {
            $resultado = $this->model->InsertarPracticas($nombrePractica,$porcentajeTarea,$cantidadEjercicios,$idPonderacion,$carpetaMod,$anyoModulo);
            return $resultado;
        }

        public function actualizarPorcentajesPracticas($idPonderacion,$porcentajeTarea)
        {
            $resultado = $this->model->actualizarPorcentajesPracticas($idPonderacion,$porcentajeTarea);
            return $resultado;
        }

        public function obtenerInfoSeguridadModulo($idModulo)
        {
            $resultado = $this->model->obtenerInfoSeguridadModulo($idModulo);
            return $resultado;
        }

        public function CargarGrupoIndividual($idModulo)
        {
            $resultado = $this->model->CargarGrupoIndividual($idModulo);
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

        public function obtenerNombrePonderacion($idPonderacion)
        {
            $resultado=$this->model->obtenerNombrePonderacion($idPonderacion);
            return $resultado;
        }

        public function eliminarDirectoriosPonderaciones($idPonderacion,$idModulo)
        {
            $resultado=$this->model->CargarGrupoIndividual($idModulo);

            if($arrayGrupos=$resultado->fetch_array(MYSQLI_ASSOC))
            {
                $siglasModulos=$arrayGrupos['siglas'];
                $anyosModulos=$arrayGrupos['anyo'];

                $resultado=$this->model->obtenerNombrePonderacion($idPonderacion);

                $arrayPonderacion=$resultado->fetch_array(MYSQLI_ASSOC);

                $nombrePonderacion=$arrayPonderacion['nombrePonderacion'];

                $ruta="Archivos/Practicas/".$siglasModulos."-".$anyosModulos."/Ponderacion_".$nombrePonderacion."_".$idPonderacion."/";

                if(file_exists($ruta))
                {
                    $resultado=$this->borrarDirectorio($ruta);
                }

                if($resultado)
                {
                    return $resultado;
                }
            }
        }

        public function borrarDirectorio($ruta)
        {
            $resultados=scandir($ruta);

            foreach($resultados as $resultado)
            {
                if(!($resultado=="." or $resultado==".."))
                {
                    if(is_dir($ruta.$resultado))
                    {
                        $this->borrarDirectorio($ruta.$resultado."/");
                    }
                    elseif(is_file($ruta.$resultado))
                    {
                        unlink($ruta.$resultado);
                    }
                }
            }
            if(rmdir($ruta))
            {
                return true;
            }
        }

        public function eliminarPonderacion($idPonderacion)
        {
            $resultado=$this->model->eliminarPonderacion($idPonderacion);
            return $resultado;
        }

        public function descargarPracticasPonderacion($idPonderacion,$idModulo)
        {
            $resultado=$this->model->descargarPracticasPonderacion($idPonderacion,$idModulo);
            return $resultado;
        }

        public function cerrarGrupo($idModulo)
        {
            $resultado=$this->model->cerrarGrupo($idModulo);
            return $resultado;
        }

        public function abrirGrupo($idModulo)
        {
            $resultado=$this->model->abrirGrupo($idModulo);
            return $resultado;
        }

        public function desactivarModulo($idModulo)
        {
            $resultado=$this->model->desactivarModulo($idModulo);
            return $resultado;
        }

        public function activarModulo($idModulo)
        {
            $resultado=$this->model->activarModulo($idModulo);
            return $resultado;
        }

        public function agregarPonderacion($idModulo,$nombrePonderacion,$porcentajePonderacion)
        {
            $resultado=$this->model->agregarPonderacion($idModulo,$nombrePonderacion,$porcentajePonderacion);
            return $resultado;
        }

        public function CargarGrupos()
        {
            $resultado=$this->model->CargarGrupos();
            return $resultado;
        }
    }
  ?>
