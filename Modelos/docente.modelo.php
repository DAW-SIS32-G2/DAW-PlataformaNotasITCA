<?php

    class docenteModelo
    {
        private $pagina;

        function __construct()
        {
            @$this->pagina = $pagina;
        }

        public function renderView()
        {
            require_once 'Vistas/paginas/docente/index.php';
        }

        public function BuscarPonderaciones($idModulo)
        {
            @$conex=new funcionesBD();

            @$resultado=$conex->ConsultaPersonalizada("select * from Ponderacion as P inner join Modulo as M on M.idModulo=P.idModulo where P.idModulo='$idModulo'");

            return $resultado;
        }

        public function CargarGrupos()
        {
            $conex=new funcionesBD();

            $resultado=$conex->ConsultaPersonalizada("select * from Modulo as M inner join Horario as H on M.idHorario = H.idHorario inner join Grupo as G on H.idGrupo = G.idGrupo where M.carnet='".$_SESSION['usuario']."'");

            return $resultado;
        }

        public function actualizarPonderaciones($nombrePonderacion,$valor,$idPonderacion)
        {
            @$conex=new funcionesBD();

            $resultado=$conex->ActualizarRegistro('Ponderacion','porcentaje',$valor,"idPonderacion=$idPonderacion");

            @$conex=new funcionesBD();

            $resultado=$conex->ActualizarRegistro('Ponderacion','nombrePonderacion',$nombrePonderacion,"idPonderacion=$idPonderacion");


            return $resultado;
        }

        public function obtenerCantidadTareas($idPonderacion)
        {
            $conex=new funcionesBD();

            $resultado=$conex->ConsultaGeneral('Tarea',"idPonderacion=$idPonderacion");

            if(gettype($resultado)=="string")
            {
                return $resultado;
            }
            else
            {
                $resultadoFinal=$resultado->num_rows;

                return $resultadoFinal;
            }
        }

        public function InsertarPracticas($nombreTarea,$porcentaje,$cantidadEjercicios,$idPonderacion,$carpetaMod,$anyoModulo)
        {
            $directorio = "Archivos/Practicas/".$carpetaMod."-$anyoModulo/Ponderacion_$idPonderacion/".$nombreTarea;

            if(file_exists($directorio))
            {
                return "Error. El directorio ya existe";
            }
            else
            {
                $conex=new funcionesBD();

                $resultado=$conex->insertar("Tarea","nombreTarea,porcentaje,cantidadEjercicios,idPonderacion,directorio,activo","'$nombreTarea',$porcentaje,$cantidadEjercicios,$idPonderacion,'$directorio',1");

                if($resultado)
                {
                    if(mkdir($directorio,0777,true))
                    {
                        return $resultado;
                    }
                    else
                    {
                        return "Falló al crear el directorio";
                    }
                }
                else
                {
                    return $resultado;
                }
            }
        }

        public function obtenerPorcentajePonderacion($idPonderacion)
        {
            $conex=new funcionesBD();

            $resultado=$conex->ConsultaPersonalizada("SELECT porcentaje from Ponderacion where idPonderacion=$idPonderacion");

            return $resultado;

        }

        public function actualizarPorcentajesPracticas($idPonderacion,$porcentaje)
        {
            $conex=new funcionesBD();

            $resultado=$conex->ActualizarRegistro('Tarea','porcentaje',$porcentaje,"idPonderacion=$idPonderacion");

            return $resultado;
        }
    

        public function mostrarPracticas($idModulo)
        {
            $conex=new funcionesBD();

            $resultado=$conex->ConsultaPersonalizada("SELECT P.nombrePonderacion,T.nombreTarea,T.cantidadEjercicios, T.idTarea from Ponderacion as P inner join Tarea as T on P.idPonderacion=T.idPonderacion where P.idModulo=$idModulo");

            return $resultado;
        }

        public function GuardarGuiasBaseDatos($nombreArchivo,$ruta,$idModulo)
        {
            $conex=new funcionesBD();

            $resultado=$conex->insertar('GuiaModulo','nombreGuia,ruta,idModulo',"'$nombreArchivo','$ruta',$idModulo");

            return $resultado;
        }

        public function CargarGrupoIndividual($idModulo)
        {
             $conex=new funcionesBD();

             $resultado=$conex->ConsultaGeneral('Modulo',"idModulo=$idModulo");

             return $resultado;
        }

        public function ObtenerSiglas($idModulo)
        {
            $conex=new funcionesBD();

            $resultado=$conex->ConsultaPersonalizada("SELECT M.siglas,M.anyo FROM Modulo AS M WHERE M.idModulo= '$idModulo'");

            return $resultado;
        }

        public function obtenerInfoSeguridadModulo($idModulo)
        {
            $conex=new funcionesBD();

            $resultado=$conex->ConsultaPersonalizada("SELECT M.protegidoPorContra, M.contraModulo from Modulo as M where idModulo=$idModulo");

            return $resultado;
        }

        public function asignarContra($idModulo,$contra)
        {
            $conex=new funcionesBD();

            $resultado1=$conex->ActualizarRegistro('Modulo','protegidoPorContra','1',"idModulo=$idModulo");

            if(gettype($resultado1)=="string")
            {
                return $resultado1;
            }

            $conex=new funcionesBD();

            $contraCifrada=cifrar($contra);

            $resultado2=$conex->ActualizarRegistro('Modulo','contraModulo',"$contraCifrada","idModulo=$idModulo");

            if(gettype($resultado2)=="string")
            {
                $conex=new funcionesBD();

                $conex->ActualizarRegistro('Modulo','protegidoPorContra','0',"idModulo=$idModulo");

                return $resultado2;
            }

            return $resultado=[$resultado1,$resultado2];
        } 

        public function obtenerClaveDocente($carnetDocente)
        {
            $conex=new funcionesBD();

            $resultado=$conex->ConsultaGeneral('Docente',"carnet='$carnetDocente'");

            return $resultado;
        }

        public function modificarContra($idModulo,$contra)
        {
            $conex=new funcionesBD();

            $contraCifrada=cifrar($contra);

            $resultado=$conex->ActualizarRegistro('Modulo','contraModulo',"$contraCifrada","idModulo=$idModulo");
        }

        public function eliminarContra($idModulo)
        {
            $conex=new funcionesBD();

            $conex->ActualizarRegistro('Modulo','protegidoPorContra','0',"idModulo=$idModulo");

            $conex=new funcionesBD();

            $resultado2=$conex->ActualizarRegistro('Modulo','contraModulo',"","idModulo=$idModulo");
        }
    }
?>
