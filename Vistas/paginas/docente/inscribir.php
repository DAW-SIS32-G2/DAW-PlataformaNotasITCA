<?php
  require_once("core/criptografia.php");
  require_once("core/funcionesbd.php");
  if(isset($_POST['registrar']))
  {
      //datos a insertar
      $carnet = $_POST['carnet'];
      $pass = cifrar($_POST['pass']);
      $nombres=$_REQUEST['nombres'];
      $apellidos=$_REQUEST['apellidos'];
      $carrera = $_REQUEST['carrera'];
      $grupo = $_REQUEST['grupo'];



      $conn = new funcionesBD();
      $mensaje = $conn->registroAlumno($carnet,$nombres,$apellidos,$pass,2018,1,$carrera,$grupo);

      echo "
        <body style=\"padding-top:65px\">
          <div class=\"alert alert-success\">".$mensaje."</div>
        </body>
      ";
  }
  else
  {
    ?>
    <body style="padding-top:65px">
      <div class="container col-6">
        <h1 class="text-center">REGISTRO DE ALUMNO</h1>
        <form method="post" class="form-group">
          <div class="form-group row">
            <label for="carnet" class="form-label">Carnet</label>
            <input class='form-control' type="text" name="carnet" maxlength="15" required>
          </div>
          <div class="form-group row">
            <label for="carnet" class='form-label'>Password</label>
            <input class="form-control" type="password" name="pass" maxlength="20" required>
          </div>
          
          <!--Campos extra por la actualizacion de la DB-->
          <div class="form-group row">
            <label class="form-label" for="nombres">Nombres:</label>
            <input class="form-control" type="text" name="nombres" maxlength="50" required>        
          </div>
          
          <div class="form-group row">
            <label class="form-label" for="apellidos">Apellidos:</label>
            <input class="form-control" type="text" name="apellidos" maxlength="50" required>  
          </div>

          <div class="form-group row">
            <label for="carrera" class="form-label">Carrera: </label>
            <select class="form-control" name="carrera" required>
              <option value="" selected>--Seleccione una opcion --</option>
              <?php
              $bd = new funcionesBD();
              $sql = "Select Carrera.idCarrera, Carrera.nombreCarrera From Carrera INNER JOIN Departamento ON Carrera.idDepartamento = Departamento.idDepartamento INNER JOIN Docente ON Docente.idDepartamento = Departamento.idDepartamento WHERE Docente.carnet = '".$_SESSION['usuario']."'";
              $res = $bd->ConsultaPersonalizada($sql);
              while($fila = mysqli_fetch_assoc($res))
              {
                echo "<option value='".$fila['idCarrera']."'>".$fila['nombreCarrera']."</option>";
              }
              ?>
            </select>
          </div>

          <div class="form-group row">
            <label for="grupo" class="form-label">Grupo: </label>
            <select class="form-control" name="grupo">
              <option value="" selected>--Seleccione una opcion --</option>
              <?php
              $bd = new funcionesBD();
              $sql = "Select DISTINCT Grupo.nombreGrupo, Grupo.seccion, Grupo.idGrupo From Grupo INNER JOIN Horario ON Horario.idGrupo = Grupo.idGrupo INNER JOIN Modulo ON Modulo.idHorario = Horario.idHorario WHERE Modulo.carnet = '".$_SESSION['usuario']."'";
              $res = $bd->ConsultaPersonalizada($sql);
              while($fila = mysqli_fetch_assoc($res))
              {
                echo "<option value='".$fila['idGrupo']."'>".$fila['nombreGrupo']." ".$fila['seccion']."</option>";
              }
              ?>
            </select>
          </div>

          <input class="btn btn-success" type="submit" name="registrar" value="Registrar Alumno">
        </form>
        <?php
    }
  ?>
  </div>
</body>
