<?php
# se incluye la clase funcionesBD y los archivos de criptografia
require_once("core/criptografia.php");
require_once("core/funcionesbd.php");
if (isset($_POST['registrar']))
{
    # se guardan datos a insertar
    $carnetDoc = $_SESSION['usuario'];
    $passDoc = $_POST['passDocente'];
    $carnet = $_POST['carnet'];
    $pass = cifrar("itca");
    $nombres = $_REQUEST['nombres'];
    $apellidos = $_REQUEST['apellidos'];
    $carrera = $_REQUEST['carrera'];
    $grupo = $_REQUEST['grupo'];

    # se crea una nueva instancia de la clase funcionesBD
    $objBD = new funcionesBD();

    # se almacena la consulta en una variable string
    $sql = "SELECT contra FROM docente WHERE carnet = '$carnetDoc'";

    # se ejecuta la consulta
    $res = $objBD->ConsultaPersonalizada($sql);

    # se recuperan los datos de la consulta
    while ($fila = mysqli_fetch_assoc($res)) {
        # se obtiene la contraseña del docente
        $claveDocenteReal = $fila['contra'];
    }
    # se descifra la clave
    $claveDescifrada = descifrar($claveDocenteReal);

    # se verifica la compatibilidad de las contraseñas
    if ($claveDescifrada == $passDoc) {
        # se crea una nueva instancia de la clase funcionesBD
        $conn = new funcionesBD();
        # se guardan los datos del alumno en la BD
        $mensaje = "<div class=\"alert alert-success\">" . $conn->registroAlumno($carnet, $nombres, $apellidos, $pass, 2018, 0, $carrera, $grupo, $carnetDoc) . "</div>";
    } else {
        # se retorna un mensaje
        $mensaje = "<div class='alert alert-danger'>Su clave es incorrecta, Intente nuevamente</div>";
    }


    echo "
        <body style=\"padding-top:65px\">
          $mensaje
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
            <input class='form-control' type="text" name="carnet" pattern="\d{6}" maxlength="6" required>
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
                # se crea una nueva instancia de la clase funcionesBD
                $bd = new funcionesBD();

                # se almacena la consulta en una variable de tipo string
                $sql = "Select Carrera.idCarrera, Carrera.nombreCarrera From Carrera INNER JOIN Departamento ON Carrera.idDepartamento = Departamento.idDepartamento INNER JOIN Docente ON Docente.idDepartamento = Departamento.idDepartamento WHERE Docente.carnet = '" . $_SESSION['usuario'] . "'";

                # se ejecuta la consulta
                $res = $bd->ConsultaPersonalizada($sql);

                # se recuperan e imprimen los datos
                while ($fila = mysqli_fetch_assoc($res)) {
                    echo "<option value='" . $fila['idCarrera'] . "'>" . $fila['nombreCarrera'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group row">
            <label for="grupo" class="form-label">Grupo: </label>
            <select class="form-control" name="grupo">
                <option value="" selected>--Seleccione una opcion --</option>
                <?php
                # se crea una nueva instancia de la clase funcionesBD
                $bd = new funcionesBD();

                # se almacena la consulta en una variable de tipo string
                $sql = "Select DISTINCT Grupo.nombreGrupo, Grupo.seccion, Grupo.idGrupo From Grupo INNER JOIN Horario ON Horario.idGrupo = Grupo.idGrupo INNER JOIN Modulo ON Modulo.idHorario = Horario.idHorario WHERE Modulo.carnet = '" . $_SESSION['usuario'] . "' AND Grupo.seccion != 'U'";

                # se ejecuta la consulta
                $res = $bd->ConsultaPersonalizada($sql);

                # se recuperan e imprimen los datos
                while ($fila = mysqli_fetch_assoc($res)) {
                    echo "<option value='" . $fila['idGrupo'] . "'>" . $fila['nombreGrupo'] . " " . $fila['seccion'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group row">
            <label for="claveDoc" class="form-label">Ingrese su clave de docente</label>
            <input type="password" name="passDocente" id="pass" class="form-control" required>
        </div>
        <input class="btn btn-success" type="submit" name="registrar" value="Registrar Alumno">
    </form>
    <?php
    }
    ?>
</div>
</body>
