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

      public function guardarPractica($carnet,$ruta,$idTarea)
      {
         $conex = new funcionesBD();
         $resultado = $conex->insertar("TareaSubidaPor","carnet,idTarea,ruta","'$carnet','$idTarea','$ruta'");
          if(gettype($resultado) != "string")
          {
            $conex = new funcionesBD();
            $resultado = $conex->insertar("Nota","carnet,valor,idTarea","'$carnet','0','$idTarea'");
            if(gettype($resultado) != "string")
            {
               return 1;
            }
            else
            {
              return $resultado;
            }
          }
          else
          {
            return $resultado;
          }
      }

      public function ObtenerSiglas($idModulo)
      {
          $conex = new funcionesBD();

          $resultado=$conex->ConsultaPersonalizada("SELECT M.siglas,M.anyo FROM Modulo AS M WHERE M.idModulo= '$idModulo'");

          return $resultado;
      }
      
      public function BuscarBuzon($carnet)
      {
          $objControlador = new alumnoControlador('alumnoModelo');
          $resultado = $objControlador->cargarBuzon($carnet);
      }

      public function compartirArchivo($id)
      {
          $objControlador = new alumnoControlador('alumnoModelo');
          $resultado = $objControlador->compartirArc($id);  
      }

      public function tokens($accion,$dato,$destinatario)
      {
          $objControlador = new alumnoControlador('alumnoModelo');
          switch($accion)
          {
            case "generar":
            $objControlador->generarToken($dato);
            break;
            case "renovar":
            $objControlador->renovarToken($dato);
            break;
            case "eliminar":
            $objControlador->eliminarToken($dato);
            break;
            case "enviar":
            $objControlador->enviarToken($dato,$destinatario);
            break;
          }
      }

      public function buscarDest($destinatario)
      {
          if($destinatario == $_SESSION['usuario'])
          {
            echo "No se puede compartir un archivo a sí mismo";
          }
          else
          {
            $conex = new funcionesBD();
            $res = $conex->ConsultaPersonalizada("SELECT * from Usuario WHERE carnet = '$destinatario'");
            if(mysqli_num_rows($res) == 1)
            {
               echo 1;
            }
            else
            {
              echo "No se ha encontrado a nadie con ese carnet";
            }
          }
      }

      public function buscarArchivo($token)
      {
          $conex = new funcionesBD();
          $res = $conex->ConsultaPersonalizada("SELECT Archivo.nombreArchivo, Archivo.ruta, ArchivoCompartido.token FROM Archivo INNER JOIN ArchivoCompartido ON Archivo.idArchivo = ArchivoCompartido.idArchivo WHERE ArchivoCompartido.token = '$token'");
          if(mysqli_num_rows($res) == 1)
            {
              $fila = mysqli_fetch_assoc($res);
              $tamano = filesize(descifrar($fila['ruta']));
              $tamano = $tamano/1048576;
              $tamano = number_format($tamano,2);
              ?>
              <p>Archivo encontrado: </p>
              <table class="table-hover table-bordered table-responsive d-table w-100">
              <tr style="background-color: #9f0b06; color: #fff;">
                <th class="w-50">Nombre </th>
                <th class="w-20">Tamaño</th>
                <th class="w-30">Acciones</th>
              </tr>
              <tr>
                <td><?= $fila['nombreArchivo'] ?></td>
                <td><?= $tamano ?> MB</td>
                <td>
                  <button class='btn btn-info' onclick="descargar('<?= $fila['ruta'] ?>')">Descargar</button>
                </td>
              </tr>
        </table>
        <?php
        }
        else
        {
          ?>
          <div class="alert alert-warning"><strong>No se ha encontrado ningún archivo con ese token</strong><br>Esto puede deberse a dos razones:<br>1. El token no es válido<br>2. La persona que compartió el token lo ha renovado, o ha dejado de compartir el archivo</div>
          <?php
        }
      }
  }
?>
