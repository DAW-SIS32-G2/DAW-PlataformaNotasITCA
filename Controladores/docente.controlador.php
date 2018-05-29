<?php

/**
 * Class docenteControlador
 *  Clase que administra el controlador para cada vista del modulo docente
 */
class docenteControlador
{
    /**
     * @var $model : Almacena el nombre modelo necesario para la vista
     */
    private $model;

    /**
     * docenteControlador constructor.
     * @param $model
     */
    function __construct($model)
    {
        $this->model = new $model;
    }

    /**
     * @return mixed
     */
    public function loadView()
    {
        return $this->model->renderView();
    }

    /**
     * @param $file : Archivo subido
     * @param $idModulo : Identificador del modulo al cual se piensa entregar la guia
     */
    public function GuardarGuia($file, $idModulo)
    {
        # se almacena el nombre temporal del archivo
        $nombreTemporal = $file['tmp_name'];

        # se comprueba si existe el archivo subido
        if (file_exists($nombreTemporal))
        {
            # en caso de que exista

            # se obtiene los datos del modulo especificado
            $resultado = $this->model->CargarGrupoIndividual($idModulo);

            # se recuperan las columnas siglas del grupo y el año respectivo
            while ($arrayGrupos = $resultado->fetch_array(MYSQLI_ASSOC))
            {
                $siglasModulos = $arrayGrupos['siglas'];
                $anyosModulos = $arrayGrupos['anyo'];
            }

            # se le asigna el fotrmato de nombre necesario al archivo
            $nombre = $siglasModulos . "_" . str_replace(' ', '_', $_FILES['guia']['name']);

            # se asigna la ruta del archivo
            $rutaArchivo = "Archivos/Guias/" . $siglasModulos . "-" . $anyosModulos . "/" . $nombre;

            # se inicializa la variable contador con valor de '2'
            $contador = 2;

            # se verifica la existencia del archivo
            while (file_exists($rutaArchivo))
            {
                $rutaArchivo = "Archivos/Guias/" . $siglasModulos . "-" . $anyosModulos . "/($contador)" . $nombre;
                $yaExiste = "Ya existe un archivo con ese nombre. El archivo fue guardado como: ($contador)" . $nombre;
                $contador++;
            }

            # se crea la carpeta contenedora en caso de no existir
            if (!file_exists("Archivos/Guias/" . $siglasModulos . "-" . $anyosModulos))
            {
                mkdir("Archivos/Guias/" . $siglasModulos . "-" . $anyosModulos, 0777, true);
            }

            # se mueve el archivo a la carpeta final
            move_uploaded_file($nombreTemporal, $rutaArchivo);

            # se devuelve un mensaje para el usuario
            $estado = @$yaExiste . "\\nArchivo subido con exito. Ocupara " . $file['size'] . " bytes de memoria en disco";

            # se almacenan los datos en la BD
            $this->model->GuardarGuiasBaseDatos($nombre, $rutaArchivo, $idModulo);
            ?>
            <script type="text/javascript">
                swal({
                    text: "<?= $estado ?>",
                    icon: "success",
                    button: "Aceptar"
                })
            </script>
            <?php
        }
        else
        {
            # se devuelve un mensaje de error error
            $estado = "Ocurrio un error al subir el archivo: El error es el numero " . $file['error'];

            ?>
            <script type="text/javascript">
                swal({
                    text: "<?= $estado ?>",
                    icon: "error",
                    button: "Aceptar"
                })
            </script>
            <?php
        }
    }

    /**
     * Obtiene las siglas de un modulo
     * @param $idModulo
     * @return mixed
     */
    public function ObtenerSiglas($idModulo)
    {
        $resultado = $this->model->ObtenerSiglas($idModulo);
        return $resultado;
    }

    /**
     * Obtiene la cantidad de tareas asignadas
     * @param $idPonderacion
     * @return mixed
     */
    public function obtenerCantidadTareas($idPonderacion)
    {
        $resultado = $this->model->obtenerCantidadTareas($idPonderacion);
        return $resultado;
    }

    /**
     * Obtiene los porcentajes asignados a un modulo
     * @param $idPonderacion
     * @return mixed
     */
    public function obtenerPorcentajePonderacion($idPonderacion)
    {
        $resultado = $this->model->obtenerPorcentajePonderacion($idPonderacion);
        return $resultado;
    }

    /**
     * Agrega una practica a un modulo
     * @param $nombrePractica
     * @param $porcentajeTarea
     * @param $cantidadEjercicios
     * @param $idPonderacion
     * @param $carpetaMod
     * @param $anyoModulo
     * @return mixed
     */
    public function InsertarPracticas($nombrePractica, $porcentajeTarea, $cantidadEjercicios, $idPonderacion, $carpetaMod, $anyoModulo)
    {
        $resultado = $this->model->InsertarPracticas($nombrePractica, $porcentajeTarea, $cantidadEjercicios, $idPonderacion, $carpetaMod, $anyoModulo);
        return $resultado;
    }

    /**
     * Actualiza los porcentajes asignados a las practicas
     * @param $idPonderacion
     * @param $porcentajeTarea
     * @return mixed
     */
    public function actualizarPorcentajesPracticas($idPonderacion, $porcentajeTarea)
    {
        $resultado = $this->model->actualizarPorcentajesPracticas($idPonderacion, $porcentajeTarea);
        return $resultado;
    }

    /**
     * Verifica si un modulo esta protegido o no
     * @param $idModulo
     * @return mixed
     */
    public function obtenerInfoSeguridadModulo($idModulo)
    {
        $resultado = $this->model->obtenerInfoSeguridadModulo($idModulo);
        return $resultado;
    }

    /**
     * Carga los valores de un modulo en especifico
     * @param $idModulo
     * @return mixed
     */
    public function CargarGrupoIndividual($idModulo)
    {
        $resultado = $this->model->CargarGrupoIndividual($idModulo);
        return $resultado;
    }

    /**
     * Establece una contraseña para un modulo
     * @param $idModulo
     * @param $contra
     * @return mixed
     */
    public function asignarContra($idModulo, $contra)
    {
        $resultado = $this->model->asignarContra($idModulo, $contra);

        $conteo = count($resultado);

        if ($conteo == 1)
        {
            return $resultado;
        }
        else
        {
            if (gettype($resultado[0]) == "string")
            {
                return $resultado[0];
            }
            elseif(gettype($resultado[1]) == "string")
            {
                return $resultado[1];
            }
            else
            {
                return $resultado[1];
            }
        }
    }


    /**
     * Modifica la contraseña para un modulo
     * @param $idModulo
     * @param $contra
     */
    public function modificarContra($idModulo, $contra)
    {

        $resultado = $this->model->modificarContra($idModulo, $contra);
    }

    /**
     * Elimina la contraseña de un modulo
     * @param $idModulo
     */
    public function eliminarContra($idModulo)
    {
        $resultado = $this->model->eliminarContra($idModulo);
    }

    /**
     * Verifica si la contraseña ingresada concuerda con el carnet del docente
     * @param $carnetDocente
     * @param $contraDocente
     * @return bool|string
     */
    public function validarContraDocente($carnetDocente, $contraDocente)
    {
        $resultado = $this->model->obtenerClaveDocente($carnetDocente);

        if (gettype($resultado) == "string")
        {
            return $resultado;
        }

        $arrayContra = $resultado->fetch_assoc();
        $contraDocenteCifrada = $arrayContra['contra'];

        if ($contraDocente == descifrar($contraDocenteCifrada))
        {
            return true;
        }
        else
        {
            return "Las claves no coinciden";
        }
    }

    /**
     * Obtiene el nombre asignado a una ponderacion
     * @param $idPonderacion
     * @return mixed
     */
    public function obtenerNombrePonderacion($idPonderacion)
    {
        $resultado = $this->model->obtenerNombrePonderacion($idPonderacion);
        return $resultado;
    }

    /**
     * Elimina de forma recursiva un directorio para una ponderacion
     * @param $idPonderacion
     * @param $idModulo
     * @return bool
     */
    public function eliminarDirectoriosPonderaciones($idPonderacion, $idModulo)
    {
        $resultado = $this->model->CargarGrupoIndividual($idModulo);

        if ($arrayGrupos = $resultado->fetch_array(MYSQLI_ASSOC))
        {
            $siglasModulos = $arrayGrupos['siglas'];
            $anyosModulos = $arrayGrupos['anyo'];

            $resultado = $this->model->obtenerNombrePonderacion($idPonderacion);

            $arrayPonderacion = $resultado->fetch_array(MYSQLI_ASSOC);

            $nombrePonderacion = $arrayPonderacion['nombrePonderacion'];

            $ruta = "Archivos/Practicas/" . $siglasModulos . "-" . $anyosModulos . "/Ponderacion_" . $nombrePonderacion . "_" . $idPonderacion . "/";

            if (file_exists($ruta))
            {
                $resultado = $this->borrarDirectorio($ruta);
            }

            if ($resultado)
            {
                return $resultado;
            }
        }
    }

    /**
     * Elimina de forma recursiva un directorio
     * @param $ruta
     * @return bool
     */
    public function borrarDirectorio($ruta)
    {
        if(file_exists($ruta))
        {
            $resultados = scandir($ruta);

            foreach($resultados as $resultado)
            {
                if(!($resultado == "." or $resultado == ".."))
                {
                    if (is_dir($ruta . $resultado))
                    {
                        $this->borrarDirectorio($ruta . $resultado . "/");
                    }
                    elseif (is_file($ruta . $resultado))
                    {
                        unlink($ruta . $resultado);
                    }
                }
            }

            if (rmdir($ruta))
            {
                return true;
            }
        }
        else
        {
            return true;
        }
    }

    /**
     * Elimina una ponderacion asignada
     * @param $idPonderacion
     * @return mixed
     */
    public function eliminarPonderacion($idPonderacion)
    {
        $resultado = $this->model->eliminarPonderacion($idPonderacion);
        return $resultado;
    }

    /**
     * Descarga en un archivo comprimido todas las practicas de una ponderacion
     * @param $idPonderacion
     * @param $idModulo
     * @return mixed
     */
    public function descargarPracticasPonderacion($idPonderacion, $idModulo)
    {
        $resultado = $this->model->descargarPracticasPonderacion($idPonderacion, $idModulo);
        return $resultado;
    }

    /**
     * Cierra o inhabilita un grupo
     * @param $idModulo
     * @return mixed
     */
    public function cerrarGrupo($idModulo)
    {
        $resultado = $this->model->cerrarGrupo($idModulo);
        return $resultado;
    }

    /**
     * Abre o habilita un grupo
     * @param $idModulo
     * @return mixed
     */
    public function abrirGrupo($idModulo)
    {
        $resultado = $this->model->abrirGrupo($idModulo);
        return $resultado;
    }

    /**
     * Desactiva un grupo
     * @param $idModulo
     * @return mixed
     */
    public function desactivarModulo($idModulo)
    {
        $resultado = $this->model->desactivarModulo($idModulo);
        return $resultado;
    }

    /**
     * Activa un modulo
     * @param $idModulo
     * @return mixed
     */
    public function activarModulo($idModulo)
    {
        $resultado = $this->model->activarModulo($idModulo);
        return $resultado;
    }

    /**
     * Agrega una ponderacion al modulo
     * @param $idModulo
     * @param $nombrePonderacion
     * @param $porcentajePonderacion
     * @return mixed
     */
    public function agregarPonderacion($idModulo, $nombrePonderacion, $porcentajePonderacion)
    {
        $resultado = $this->model->agregarPonderacion($idModulo, $nombrePonderacion, $porcentajePonderacion);
        return $resultado;
    }

    /**
     * Solicita todos los grupos disponibles
     * @return mixed
     */
    public function CargarGrupos()
    {
        $resultado = $this->model->CargarGrupos();
        return $resultado;
    }

    public function obtenerTareas($idTarea)
    {
        $resultado=$this->model->obtenerTareas($idTarea);
        return $resultado;
    }

    public function eliminarTarea($idTarea)
    {
        $resultado = $this->model->eliminarTarea($idTarea);
        return $resultado;
    }

    public function reasignarPorcentajes($idPonderacion)
    {
       $resultado=$this->model->obtenerPorcentajePonderacion($idPonderacion);

       $aux=$resultado->fetch_assoc();

       $porcentajeTotal=$aux['porcentaje'];

       $resultado=$this->model->obtenerCantidadTareas($idPonderacion);

       if($resultado==0)
       {
        return true;
       }
       else
       {
           $cantidadTareas=$resultado;

           $PorcentajeNuevo=($porcentajeTotal/$cantidadTareas);

           $resultado=$this->model->actualizarPorcentajesPracticas($idPonderacion, number_format($PorcentajeNuevo,2));

           return $resultado;
       }
    }

    public function actualizarEstadoTarea($idTarea, $estado, $fechaInicio, $fechaFin)
    {
        if($fechaInicio!="" and $fechaFin!="")
        {
            $resultado = $this->model->actualizarEstadoTarea($idTarea, $estado, $fechaInicio, $fechaFin);
            return $resultado;
        }
        else
        {
            $resultado = $this->model->actualizarEstadoTarea($idTarea, $estado,"","");
            return $resultado;
        }
    }

    public function obtenerNombreTareas($idTarea,$nombreTarea)
    {
        $resultado=$this->obtenerTareas($idTarea);

        if (gettype($resultado)=="string")
        {
            return $resultado;
        }
        else
        {
            $aux=$resultado->fetch_assoc();

            $idPonderacion=$aux['idPonderacion'];

            $resultado = $this->model->obtenerNombreTareas($idTarea,$nombreTarea,$idPonderacion);
            return $resultado;
        }
    }

    public function actualizarTarea($idTarea,$nombreTarea,$cantidadEjercicios)
    {
        $resultado=$this->model->actualizarTarea($idTarea,$nombreTarea,$cantidadEjercicios);
        return $resultado;
    }

}

?>
