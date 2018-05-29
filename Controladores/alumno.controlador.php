<?php
  class alumnoControlador
  {
    private $model;
    private $disponible; 

    function __construct($model)
    {
      $this->model = $model;
      $this->disponible = 36700160;
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

    public function cargarBuzon($carnet)
    {
      require_once("core/funcionesbd.php");
      require_once("core/criptografia.php");

      $ruta = "Archivos/ArchivosBuzon/".$carnet;
      $verificador = 0;
      $contadorArch = 0;

      if(is_dir($ruta))
      {
        $arch = array();
        $verificador = 1;
        $archivos = array();
        $contadorArch = 0;
        $objBD = new funcionesBD();
        $sql = "Select Archivo.idArchivo, Archivo.nombreArchivo, Archivo.ruta FROM Archivo INNER JOIN BuzonArchivo ON Archivo.idBuzon = BuzonArchivo.idBuzon INNER JOIN Grupo ON BuzonArchivo.idGrupo = Grupo.idGrupo INNER JOIN Usuario ON Grupo.idGrupo = Usuario.idGrupo WHERE Usuario.carnet = '".$carnet."' AND Archivo.carnet = '".$carnet."'";
        $res = $objBD->ConsultaPersonalizada($sql);


        while($fila = mysqli_fetch_assoc($res))
        {
          $tamano = filesize(descifrar($fila['ruta']));
          $tamano = $tamano/1048576;
          $tamano = number_format($tamano,2);
          $archivos['ids'][$contadorArch] = $fila['idArchivo'];
          $archivos['nombres'][$contadorArch] = $fila['nombreArchivo'];
          $archivos['rutas'][$contadorArch] = $fila['ruta'];
          $archivos['tamanos'][$contadorArch] = $tamano;
          $contadorArch++;
        }
        @$this->disponible-=(array_sum($archivos['tamanos']))*1048576;
        if($contadorArch > 0)
        {
          $verificador = 2;
        }
      }
      else
      {
        mkdir($ruta);
        $verificador = 0;
      }
            if($verificador == 2)
      {  
        
        ?>
        <table class="table-hover table-bordered table-responsive d-table w-100">
          <tr style="background-color: #9f0b06; color: #fff;">
            <th class="w-50">Nombre </th>
            <th class="w-20">Tamaño</th>
            <th class="w-30">Acciones</th>
          </tr>
          <?php
          for($i=0;$i<$contadorArch;$i++) 
          {
            echo "
              <tr>
                <td>".$archivos['nombres'][$i]."</td>
                <td>".$archivos['tamanos'][$i]." MB</td>
                <td>
                  <button class='btn btn-info' onclick=\"descargar('".$archivos['rutas'][$i]."')\">Descargar</button>
                  <button class='btn btn-info' onclick=\"eliminar('".$archivos['rutas'][$i]."','".$archivos['ids'][$i]."')\" >Eliminar</button>
                  <button class='btn btn-info' data-toggle='modal' data-target='#compartirMod' data-id='".$archivos['ids'][$i]."' >Compartir</button>
                </td>
              </tr>
            ";
          }
          ?>
        </table>
        </div>
        <div class="card-footer">
            Total de espacio disponible: <?= number_format(($this->disponible/1024)/1024,2) ?>MB
        </div>
        <input type="hidden" name="dispon" id="dispon" value="<?= $this->disponible ?>">
        <?php
      }
      else
      {
        ?>
        <div class="alert alert-info">No hay archivos en el directorio</div>
        </div>
        <div class="card-footer">
            Total de espacio disponible: <?= number_format(($this->disponible/1024)/1024,2) ?>MB
            <input type="hidden" name="dispon" id="dispon" value="<?= $this->disponible ?>">
        </div>
        <?php
      }
    }

    public function obtenCaracterAleatorio($arreglo) {
    $clave_aleatoria = array_rand($arreglo, 1); //obten clave aleatoria
    return $arreglo[ $clave_aleatoria ];  //devolver item aleatorio
    }

    public function obtenCaracterMd5($car) {
      $md5Car = md5($car.Time()); //Codificar el caracter y el tiempo POSIX (timestamp) en md5
      $arrCar = str_split(strtoupper($md5Car)); //Convertir a array el md5
      $carToken = $this->obtenCaracterAleatorio($arrCar);  //obten un item aleatoriamente
      return $carToken;
    }

    public function obtenToken($longitud) {
      //crear alfabeto
      $mayus = "ABCDEFGHIJKMNPQRSTUVWXYZ";
      $mayusculas = str_split($mayus);  //Convertir a array
      //crear array de numeros 0-9
      $numeros = range(0,9);
      //revolver arrays
      shuffle($mayusculas);
      shuffle($numeros);
      //Unir arrays
      $arregloTotal = array_merge($mayusculas,$numeros);
      $newToken = "";
      
      for($i=0;$i<=$longitud;$i++) {
          $miCar = $this->obtenCaracterAleatorio($arregloTotal);
          $newToken .= $this->obtenCaracterMd5($miCar);
      }
      return $newToken;
    }

    public function compartirArc($id)
    {
      require_once("core/criptografia.php");        
      require_once("core/funcionesbd.php");        

      $objBD = new funcionesBD();
      $sql = "SELECT * FROM ArchivoCompartido WHERE idArchivo='$id'";
      $res = $objBD->ConsultaPersonalizada($sql);

      if(mysqli_num_rows($res) == 1)
      {
        while($fila = mysqli_fetch_assoc($res))
        {
          $token = $fila['token'];
        }
        ?>
        <div class='alert alert-info'>Este archivo <strong>SÍ</strong> se está compartiendo</div>
        <p class="text-justify">Token para compartir: <strong><?= $token ?><strong></p>
        <button class="btn btn-primary" onclick="eliminarToken('<?= $id ?>')">Dejar de Compartir</button>
        <button class="btn btn-primary" onclick="renovarToken('<?= $id ?>')">Renovar Token</button>
        <button class="btn btn-primary" onclick="cargarDestinatario('<?= $token ?>')">Enviar Token</button>
        <?php
      }
      else
      {
        ?>
        <div class='alert alert-info'>Este archivo <strong>NO</strong> se está compartiendo</div>
        <button class="btn btn-primary" onclick="generarToken('<?= $id ?>')">Compartir Archivo</button>
        <?php
      }

    }

    public function generarToken($idArchivo)
    {
        require_once("core/funcionesbd.php");
        $nuevoToken = $this->obtenToken(8);

        $objBD = new funcionesBD();
        $sql = "SELECT * FROM ArchivoCompartido WHERE token = '$nuevoToken'";
        $res = $objBD->ConsultaPersonalizada($sql);

        while(mysqli_num_rows($res) == 1)
        {
          $nuevoToken = $this->obtenToken(8);
          $objBD = new funcionesBD();
          $sql = "SELECT * FROM ArchivoCompartido WHERE token = '$nuevoToken'";
          $res = $objBD->ConsultaPersonalizada($sql); 
        }

        $objBD = new funcionesBD();
        $sql = "INSERT INTO ArchivoCompartido(token,idArchivo) VALUES ('$nuevoToken','$idArchivo')";
        $res = $objBD->ConsultaPersonalizada($sql);
        if($res === TRUE)
        {
          echo "1";
        }
        else
        {
          echo "Error. no se pudo generar el token\\n $res";
        }
    }

    public function eliminarToken($idArchivo)
    {
        require_once("core/funcionesbd.php");
        $objBD = new funcionesBD();
        $sql = "DELETE FROM ArchivoCompartido WHERE idArchivo = '$idArchivo'";
        $res = $objBD->ConsultaPersonalizada($sql);
        if($res === TRUE)
        {
          echo "1";
        }
        else
        {
          echo "Error. no se pudo eliminar el token\\n $res";
        }
    }

    public function renovarToken($idArchivo)
    {
      require_once("core/funcionesbd.php");
      $nuevoToken = $this->obtenToken(8);

      $objBD = new funcionesBD();
      $sql = "SELECT * FROM ArchivoCompartido WHERE token = '$nuevoToken'";
      $res = $objBD->ConsultaPersonalizada($sql);

      while(mysqli_num_rows($res) == 1)
      {
        $nuevoToken = $this->obtenToken(8);
        $objBD = new funcionesBD();
        $sql = "SELECT * FROM ArchivoCompartido WHERE token = '$nuevoToken'";
        $res = $objBD->ConsultaPersonalizada($sql); 
      }

      $objBD = new funcionesBD();
      $sql = "UPDATE ArchivoCompartido SET token='$nuevoToken' WHERE idArchivo = '$idArchivo'";
      $res = $objBD->ConsultaPersonalizada($sql);
        if($res === TRUE)
        {
          echo "1";
        }
        else
        {
          echo "Error. no se pudo renovar el token\n $res";
        }
    }

    public function enviarToken($token,$destinatario)
    {
        $titulo = "Han compartido un archivo contigo";
        $emisor = $_SESSION['usuario'];
        $descripcion = "El alumno con carnet <strong>$emisor</strong> te ha enviado un archivo, para poder descargarlo utiliza el token: <strong>$token</strong>";
        $objBD = new funcionesBD();
        $sql = "INSERT INTO Notificacion(emisor,destinatario,titulo,descripcion,estado) VALUES ('$emisor','$destinatario','$titulo','$descripcion',1)";
        $res = $objBD->ConsultaPersonalizada($sql);
        if($res === TRUE)
        {
          echo "1";
        }
        else
        {
          echo "Error. no se pudo enviar el token:\n $res";
        }
    }
  }
?>
