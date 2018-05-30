<?php

# se define la contante root
define("__ROOT__", dirname(__FILE__, 2));

# se incluye la clase funcionesBD
require_once(__ROOT__ . '/core/funcionesbd.php');

/**
 * Class docenteModelo
 * Administra el modelo para las vistas del modulo docente
 */
class docenteModelo
{
    public function renderView()
    {
        require_once 'Vistas/paginas/docente/index.php';
    }

    /**
     * Busca todas las ponderaciones existentes
     * @param $idModulo
     * @return bool|mysqli_result|string
     */
    public function BuscarPonderaciones($idModulo)
    {
        @$conex = new funcionesBD();

        @$resultado = $conex->ConsultaPersonalizada("select * from Ponderacion as P inner join Modulo as M on M.idModulo=P.idModulo where P.idModulo='$idModulo'");

        return $resultado;
    }

    /**
     * Selecciona todos los grupos encontrados en la BD
     * @return bool|mysqli_result|string
     */
    public function CargarGrupos()
    {
        $conex = new funcionesBD();

        $resultado = $conex->ConsultaPersonalizada("select * from Modulo as M inner join Horario as H on M.idHorario = H.idHorario inner join Grupo as G on H.idGrupo = G.idGrupo where M.carnet='" . $_SESSION['usuario'] . "'");

        return $resultado;
    }

    /**
     * Selecciona todos los grupos que esten activos en la BD
     * @return bool|mysqli_result|string
     */
    public function CargarGruposActivos()
    {
        $conex = new funcionesBD();

        $resultado = $conex->ConsultaPersonalizada("select * from Modulo as M inner join Horario as H on M.idHorario = H.idHorario inner join Grupo as G on H.idGrupo = G.idGrupo where M.carnet='" . $_SESSION['usuario'] . "' and M.activo=1");

        return $resultado;
    }

    /**
     * Actualiza una ponderacion asignada a un modulo
     * @param $nombrePonderacion
     * @param $valor
     * @param $idPonderacion
     * @return bool|mysqli_result|string
     */
    public function actualizarPonderaciones($nombrePonderacion, $valor, $idPonderacion)
    {
        @$conex = new funcionesBD();

        $resultado = $conex->ActualizarRegistro('Ponderacion', 'porcentaje', $valor, "idPonderacion=$idPonderacion");

        @$conex = new funcionesBD();

        $resultado = $conex->ActualizarRegistro('Ponderacion', 'nombrePonderacion', $nombrePonderacion, "idPonderacion=$idPonderacion");


        return $resultado;
    }

    /**
     * Retorna el numero de tareas de una ponderación
     * @param $idPonderacion
     * @return bool|int|mysqli_result|string
     */
    public function obtenerCantidadTareas($idPonderacion)
    {
        $conex = new funcionesBD();

        $resultado = $conex->ConsultaGeneral('Tarea', "idPonderacion=$idPonderacion");

        if (gettype($resultado) == "string")
        {
            return $resultado;
        }
        else
        {
            $resultadoFinal = $resultado->num_rows;

            return $resultadoFinal;
        }
    }

    /**
     * Inserta una practica para un modulo
     * @param $nombreTarea
     * @param $porcentaje
     * @param $cantidadEjercicios
     * @param $idPonderacion
     * @param $carpetaMod
     * @param $anyoModulo
     * @return bool|mysqli_result|string
     */
    public function InsertarPracticas($nombreTarea, $porcentaje, $cantidadEjercicios, $idPonderacion, $carpetaMod, $anyoModulo)
    {
        $conex = new funcionesBD();

        $resultado = $conex->ConsultaPersonalizada("SELECT P.nombrePonderacion from Ponderacion as P where idPonderacion=$idPonderacion");

        $nombrePonderacion = $resultado->fetch_assoc();

        $directorio = "Archivos/Practicas/" . $carpetaMod . "-$anyoModulo/Ponderacion_" . $nombrePonderacion['nombrePonderacion'] . "_$idPonderacion/" . str_replace(" ", "_", $nombreTarea);

        if (!file_exists($directorio))
        {
            mkdir($directorio, 0777, true);
        }

        $conex = new funcionesBD();

        $resultado=$conex->ConsultaGeneral("Tarea","nombreTarea='".str_replace(" ", "_", $nombreTarea)."' and idPonderacion=$idPonderacion");

        if(gettype($resultado)=="string")
        {
            return $resultado;
        }
        else
        {
            $numeroRespuestas=$resultado->num_rows;

            if($numeroRespuestas>0)
            {
                return "Error. Ya existe una practica llamada: ".$nombreTarea.". Por favor ingrese uno distinto.";
            }
            else
            {
                $conex = new funcionesBD();

                $resultado = $conex->insertar("Tarea", "nombreTarea,porcentaje,cantidadEjercicios,idPonderacion,directorio,activo", "'" . str_replace(" ", "_", $nombreTarea) . "',$porcentaje,$cantidadEjercicios,$idPonderacion,'$directorio',0");

                return $resultado; 
            }
        }
    }

    /**
     * Obtiene el porcentaje asignado a una ponderacion
     * @param $idPonderacion
     * @return bool|mysqli_result|string
     */
    public function obtenerPorcentajePonderacion($idPonderacion)
    {
        $conex = new funcionesBD();

        $resultado = $conex->ConsultaPersonalizada("SELECT porcentaje from Ponderacion where idPonderacion=$idPonderacion");

        return $resultado;

    }

    /**
     * Actualiza el porcentaje aignado a una practica
     * @param $idPonderacion
     * @param $porcentaje
     * @return bool|mysqli_result|string
     */
    public function actualizarPorcentajesPracticas($idPonderacion, $porcentaje)
    {
        $conex = new funcionesBD();

        $resultado = $conex->ActualizarRegistro('Tarea', 'porcentaje', $porcentaje, "idPonderacion=$idPonderacion");

        return $resultado;
    }

    /**
     * Muestra todas las practicas diponibles para un modulo inscrito
     * @param $idModulo
     * @return bool|mysqli_result|string
     */
    public function mostrarPracticas($idModulo)
    {
        $conex = new funcionesBD();

        $resultado = $conex->ConsultaPersonalizada("SELECT P.nombrePonderacion,T.nombreTarea,T.cantidadEjercicios, T.idTarea, P.idPonderacion, T.activo, T.fechaFin from Ponderacion as P inner join Tarea as T on P.idPonderacion=T.idPonderacion where P.idModulo=$idModulo");

        return $resultado;
    }


    /**
     * Guarda la informacion de las tareas subidas por los alumnos en la BD
     * @param $nombreArchivo
     * @param $ruta
     * @param $idModulo
     * @return bool|mysqli_result|string
     */
    public function GuardarGuiasBaseDatos($nombreArchivo, $ruta, $idModulo)
    {
        $conex = new funcionesBD();

        $resultado = $conex->insertar('GuiaModulo', 'nombreGuia,ruta,idModulo', "'$nombreArchivo','$ruta',$idModulo");

        return $resultado;
    }

    /**
     * Carga la informacion de un gruo selecionado
     * @param $idModulo
     * @return bool|mysqli_result|string
     */
    public function CargarGrupoIndividual($idModulo)
    {
        $conex = new funcionesBD();

        $resultado = $conex->ConsultaGeneral('Modulo', "idModulo=$idModulo");

        return $resultado;
    }

    /**
     * Obtiene las siglas de un modulo
     * @param $idModulo
     * @return bool|mysqli_result|string
     */
    public function ObtenerSiglas($idModulo)
    {
        $conex = new funcionesBD();

        $resultado = $conex->ConsultaPersonalizada("SELECT M.siglas,M.anyo FROM Modulo AS M WHERE M.idModulo= '$idModulo'");

        return $resultado;
    }

    /**
     * Seleciona los datos de seguridad de la BD
     * @param $idModulo
     * @return bool|mysqli_result|string
     */
    public function obtenerInfoSeguridadModulo($idModulo)
    {
        $conex = new funcionesBD();

        $resultado = $conex->ConsultaPersonalizada("SELECT M.protegidoPorContra, M.contraModulo from Modulo as M where idModulo=$idModulo");

        return $resultado;
    }

    /**
     * Asigna una contraseña a un grupo
     * @param $idModulo
     * @param $contra
     * @return array|bool|mysqli_result|string
     */
    public function asignarContra($idModulo, $contra)
    {
        $conex = new funcionesBD();

        $resultado1 = $conex->ActualizarRegistro('Modulo', 'protegidoPorContra', '1', "idModulo=$idModulo");

        if (gettype($resultado1) == "string") {
            return $resultado1;
        }

        $conex = new funcionesBD();

        $contraCifrada = cifrar($contra);

        $resultado2 = $conex->ActualizarRegistro('Modulo', 'contraModulo', "$contraCifrada", "idModulo=$idModulo");

        if (gettype($resultado2) == "string") {
            $conex = new funcionesBD();

            $conex->ActualizarRegistro('Modulo', 'protegidoPorContra', '0', "idModulo=$idModulo");

            return $resultado2;
        }

        return $resultado = [$resultado1, $resultado2];
    }

    /**
     * Seleciona la contraseña de un docente selecionado
     * @param $carnetDocente
     * @return bool|mysqli_result|string
     */
    public function obtenerClaveDocente($carnetDocente)
    {
        $conex = new funcionesBD();

        $resultado = $conex->ConsultaGeneral('Docente', "carnet='$carnetDocente'");

        return $resultado;
    }

    /**
     * Modifica la contraseña de un modulo
     * @param $idModulo
     * @param $contra
     */
    public function modificarContra($idModulo, $contra)
    {
        $conex = new funcionesBD();

        $contraCifrada = cifrar($contra);

        $resultado = $conex->ActualizarRegistro('Modulo', 'contraModulo', "$contraCifrada", "idModulo=$idModulo");
    }

    /**
     * Elimina la contraseña de un modulo
     * @param $idModulo
     */
    public function eliminarContra($idModulo)
    {
        $conex = new funcionesBD();

        $conex->ActualizarRegistro('Modulo', 'protegidoPorContra', '0', "idModulo=$idModulo");

        $conex = new funcionesBD();

        $resultado2 = $conex->ActualizarRegistro('Modulo', 'contraModulo', "", "idModulo=$idModulo");
    }

    /**
     * Obtiene el nombre asignado a una ponderacion
     * @param $idPonderacion
     * @return bool|mysqli_result|string
     */
    public function obtenerNombrePonderacion($idPonderacion)
    {
        $conex = new funcionesBD();

        $resultado = $conex->ConsultaGeneral('Ponderacion', "idPonderacion='$idPonderacion'");

        return $resultado;
    }

    /**
     * Elimina una ponderacion indicada
     * @param $idPonderacion
     * @return bool|mysqli_result|string
     */
    public function eliminarPonderacion($idPonderacion)
    {
        $conex = new funcionesBD();

        $resultado = $conex->EliminarRegistro('Ponderacion', "idPonderacion='$idPonderacion'");

        return $resultado;
    }

    /**
     * Inscribi un alumno en un modulo
     * @param $carnet
     * @param $modulo
     * @param $pass
     * @param $carnetDoc
     * @return bool|int|mysqli_result|string
     */
    public function inscribirAlumno($carnet, $modulo, $pass, $carnetDoc)
    {
        $objBD = new funcionesBD();
        $sql = "SELECT contra FROM docente WHERE carnet = '$carnetDoc'";
        $res = $objBD->ConsultaPersonalizada($sql);
        while ($fila = mysqli_fetch_assoc($res)) {
            $claveDocenteReal = $fila['contra'];
        }

        $claveDescifrada = descifrar($claveDocenteReal);
        if ($claveDescifrada == $pass) {
            $conex = new funcionesBD();
            $BuscarCarnet = $conex->ConsultaPersonalizada("SELECT * FROM Usuario WHERE carnet='$carnet'");
            if (mysqli_num_rows($BuscarCarnet) == 1) {
                $conex = new funcionesBD();
                $inscripcion = $conex->ConsultaPersonalizada("SELECT * FROM UsuarioActivo WHERE carnet='$carnet' AND idModulo = '$modulo'");
                if (mysqli_num_rows($inscripcion) == 1) {
                    return "El alumno ya está inscrito en esta materia";
                } else {
                    $conex = new funcionesBD();
                    $resultado = $conex->insertar("UsuarioActivo", "carnet,idModulo", "'$carnet','$modulo'");
                    if (gettype($resultado) == "boolean" && $resultado === true) {
                        return 1;
                    } else {
                        return $resultado;
                    }
                }
            } else {
                return 2;
            }
        } else {
            return "Su clave no es correcta, Intentelo nuevamente";
        }
    }

    /**
     * 
     * @param $carnet
     * @param $passOrig
     * @param $pass1
     * @param $pass2
     * @return bool|mysqli_result|string
     */
    public function cambiarPassDocente($carnet, $passOrig, $pass1, $pass2)
    {
        $objBD = new funcionesBD();
        $sql = "SELECT contra FROM docente WHERE carnet = '$carnet'";
        $res = $objBD->ConsultaPersonalizada($sql);
        while ($fila = mysqli_fetch_assoc($res)) {
            $claveDocenteReal = $fila['contra'];
        }

        $claveDescifrada = descifrar($claveDocenteReal);

        if ($carnet != $_SESSION['usuario']) {
            return "<div class='alert alert-danger'><strong>Error:</strong> el carnet que ha escrito no existe o pertenece a otro docente</div>";
        } elseif ($claveDescifrada != $passOrig) {
            return "<div class='alert alert-danger'><strong>Error:</strong> Su contraseña actual no es correcta</div>";
        } elseif ($pass1 != $pass2) {
            return "<div class='alert alert-danger'><strong>Error:</strong> Las claves ingresadas no coinciden</div>";
        } elseif ($pass1 == $passOrig) {
            return "<div class='alert alert-warning'><strong>Advertencia:</strong> La nueva clave es igual a la clave actual. No se ha cambiado</div>";
        } else {
            $nuevaclave = cifrar($pass2);
            $objBD = new funcionesBD();
            $sql = "UPDATE docente SET contra = '$nuevaclave' WHERE carnet='$carnet'";
            $resultado = $objBD->ConsultaPersonalizada($sql);
            if (gettype($resultado) == "boolean" && $resultado === true) {
                return "<div class='alert alert-success'>Clave actualizada correctamente</div>";
            } else {
                return $resultado;
            }
        }
    }

    public function cerrarGrupo($idModulo)
    {
        $conex = new funcionesBD();

        $resultado = $conex->ActualizarRegistro('Modulo', 'estado', '0', "idModulo=$idModulo");

        return $resultado;
    }

    public function abrirGrupo($idModulo)
    {
        $conex = new funcionesBD();

        $resultado = $conex->ActualizarRegistro('Modulo', 'estado', '1', "idModulo=$idModulo");

        return $resultado;
    }

    public function desactivarModulo($idModulo)
    {
        $conex = new funcionesBD();

        $resultado = $conex->ActualizarRegistro('Modulo', 'activo', '0', "idModulo=$idModulo");

        return $resultado;
    }

    public function activarModulo($idModulo)
    {
        $conex = new funcionesBD();

        $resultado = $conex->ActualizarRegistro('Modulo', 'activo', '1', "idModulo=$idModulo");

        return $resultado;
    }

    public function agregarPonderacion($idModulo, $nombrePonderacion, $porcentajePonderacion)
    {
        $conex = new funcionesBD();

        $resultado = $conex->insertar('Ponderacion', 'nombrePonderacion,porcentaje,idModulo', "'$nombrePonderacion','$porcentajePonderacion',$idModulo");

        return $resultado;
    }

    public function obtenerTareas($idTarea)
    {
        $conex = new funcionesBD();

        $resultado = $conex->ConsultaGeneral('Tarea', "idTarea=$idTarea");

        return $resultado;
    }

    public function eliminarTarea($idTarea)
    {
        $conex = new funcionesBD();

        $resultado = $conex->EliminarRegistro('Tarea', "idTarea=$idTarea");

        return $resultado;
    }

    public function actualizarEstadoTarea($idTarea, $estado, $fechaInicio, $fechaFin)
    {
        if($fechaInicio!="" and $fechaFin!="")
        {
            $conex = new funcionesBD();

            $resultado = $conex->ActualizarRegistros('Tarea', "activo=$estado,fechaInicio='$fechaInicio',fechaFin='$fechaFin'", "idTarea=$idTarea");

            return $resultado;
        }
        else
        {
            $conex = new funcionesBD();

            $resultado = $conex->ActualizarRegistros('Tarea', "activo=$estado,fechaFin='$fechaFin'", "idTarea=$idTarea");

            return $resultado;
        }
    }

    public function obtenerNombreTareas($idTarea,$nombreTarea,$idPonderacion)
    {
        $conex=new funcionesBD();

        $resultado=$conex->ConsultaGeneral('Tarea',"nombreTarea='".trim($nombreTarea)."' and idPonderacion=$idPonderacion");

        return $resultado;
    }

    public function actualizarTarea($idTarea,$nombreTarea,$cantidadEjercicios,$rutaNueva)
    {
        $conex=new funcionesBD();

        $resultado=$conex->ActualizarRegistros('Tarea',"nombreTarea='$nombreTarea', cantidadEjercicios=$cantidadEjercicios,directorio='$rutaNueva'","idTarea=$idTarea");

        return $resultado;
    }


    /*Migracion de DB*/
    public function migrarDbToSistema($sql,$DB)
    {
        if($DB==0)
        {
            $conex=new funcionesBD();

            $resultado=$conex->ConsultaPersonalizada($sql);

            return $resultado;
        }
        elseif($DB==1)
        {
            $conex=new funcionesBD('migrar');

            $resultado=$conex->ConsultaPersonalizada($sql);

            return $resultado;
        } 
    }


    public function borrarPrac($ruta,$idTareaSubidaPor,$idTarea,$carnet)
    {
        require_once("core/criptografia.php");
        $conex = new funcionesBD();
        $resultado = $conex->EliminarRegistro('TareaSubidaPor',"idTareaSubidaPor='$idTareaSubidaPor' AND idTarea='$idTarea'");
        if($resultado === TRUE)
        {
            $conex = new funcionesBD();
            $resultado = $conex->EliminarRegistro("Nota","idTarea='$idTarea' AND carnet='$carnet'");
            if($resultado === TRUE)
            {
                if(unlink(descifrar($ruta)))
                {
                    echo 1;
                }
                else
                {
                    echo "No se pudo borrar el archivo";
                }
            }
            else
            {
                echo "No se pudo borrar la nota";
            }
        }
        else
        {
            echo "No se pudo borrar el registro de la práctica";
        }
    }

    public function verificarVencimientoPracticas()
    {
        $conex=new funcionesBD();

        $resultado=$conex->ConsultaGeneral('Tarea',"nombreTarea='".trim($nombreTarea)."' and idPonderacion=$idPonderacion");

        return $resultado;
    }
}

?>
