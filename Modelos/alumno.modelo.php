<?php
  class alumnoModelo
  {
      function __construct()
      {

      }

      function renderView()
      {
          require_once 'Vistas/paginas/alumno/index.php';
      }
      public function seleccionarPracticas($carnet)
      {
          //relacion BD Tarea->Ponderación->Modulo->Horario->Grupo
          $conex=new funcionesBD();

          $resultado=$conex->ConsultaPersonalizada("SELECT M.nombreModulo, T.idTarea, T.nombreTarea, T.cantidadEjercicios FROM Tarea AS T INNER JOIN Ponderacion AS P ON T.idPonderacion = P.idPonderacion INNER JOIN Modulo AS M ON P.idModulo = M.idModulo INNER JOIN Horario AS H on H.idHorario = M.idHorario INNER JOIN Grupo AS G ON G.idGrupo = H.idGrupo INNER JOIN Usuario AS U on U.idGrupo = G.idGrupo WHERE U.carnet = '$carnet'");

          return $resultado;
      }

      public function verificarSubida($carnet,$idTarea)
      {
        $conex = new funcionesBD();
        $resultado = $conex->ConsultaPersonalizada("SELECT * FROM TareaSubidaPor WHERE carnet='$carnet' AND idTarea = '$idTarea'");
        $cant = mysqli_num_rows($resultado);
        return $cant;
      }

      public function verificarActivo($idTarea)
      {
        $conex = new funcionesBD();
        $resultado = $conex->ConsultaPersonalizada("SELECT activo FROM Tarea WHERE idTarea='$idTarea'");
        while($fila = $resultado->fetch_array(MYSQLI_ASSOC))
        {
          $res = $fila['activo'];
        }
        return $res;
      }
  }
?>
