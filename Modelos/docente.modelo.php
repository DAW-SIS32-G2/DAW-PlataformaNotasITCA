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

        public function actualizarPonderaciones($valor,$idPonderacion)
        {
            @$conex=new funcionesBD();

            $resultado=$conex->ActualizarRegistro('Ponderacion','porcentaje',$valor,"idPonderacion=$idPonderacion");

            return $resultado;
        }

    }
?>
