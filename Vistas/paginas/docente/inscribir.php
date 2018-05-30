<?php
# se incluye la clase funcionesBD y el archivo de criptografia
require_once("core/criptografia.php");
require_once("core/funcionesbd.php");

# se crea una nueva instancia de la clase docenteModelo
$objDocenteModelo = new DocenteModelo();
?>
<body style="padding-top:65px">
<h1 class="text-center">Inscribir Alumno en una materia</h1>
<div class="container">
    <div class="row justify-content-md-center">
        <p>Inscriba un alumno en sus materias, aún si las inscripciones están cerradas</p>
        <form class="form-group" action="" method="post">
            <div class="form-group row">
                <label class="form-label" for="grupo">Seleccione un grupo: </label>
                <select class="form-control" name="grupo" required>
                    <?php
                    # se cargan todos los grupos disponibles
                    $resultado = $objDocenteModelo->CargarGruposActivos();
                    # se verifica el resultado
                    if (gettype($resultado) == "string") {
                        echo "Error al cargar los grupos...";
                    } else {
                        # se inicializa el contador en 0
                        $i = 0;

                        # se almacenan los resultados
                        while ($arrayGrupos = $resultado->fetch_array(MYSQLI_ASSOC)) {
                            $nombreModulos[] = $arrayGrupos['nombreModulo'];
                            $nombreGrupos[] = $arrayGrupos['nombreGrupo'] . $arrayGrupos['seccion'];
                            $idModulos[] = $arrayGrupos['idModulo'];
                            $tipo[] = $arrayGrupos['tipoModulo'];
                            $i++;
                        }

                        # se obtiene la cantidad de indices de un array
                        $conteo = count($nombreModulos);
                        echo "<option value=''>--Seleccione una opcion--</option>";
                        # se imprimen los modulos disponibles
                        for ($j = 0; $j < $conteo; $j++) {
                            ?>
                            <option value='<?php echo $idModulos[$j]; ?>'>
                                <?php echo $nombreGrupos[$j] . " - " . $nombreModulos[$j] . " (" . $tipo[$j] . ")"; ?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group row">
                <label class="form-label" for="carnet">Carnet del alumno: </label>
                <input type="text" class="form-control" name="carnet" pattern="[0-9]{6}" maxlength="6"
                       placeholder="Escriba el carnet aquí" required>
            </div>
            <div class="form-group row">
                <label class="form-label" for="clave">Ingrese su clave de docente</label>
                <input type="password" name="passDocente" id="pass" class="form-control" required>
            </div>
            <div class="form-group row">
                <button type="submit" class="btn btn-primary btn-block" name="inscribir">Inscribir Estudiante</button>
            </div>
        </form>
    </div>
    <div class="row justify-content-md-center">
        <?php
        # se verifica la accion del usuario
        if (isset($_POST['inscribir'])) {
            # se almacenan los datos enviados por el usuario
            $carnet = $_POST['carnet'];
            $idModulo = $_POST['grupo'];
            $clave = $_POST['passDocente'];
            # se almacenan los datos del alumno en la BD
            $res = $objDocenteModelo->inscribirAlumno($carnet, $idModulo, $clave, $_SESSION['usuario']);

            # se verifica el resultado
            if ($res == 1) {
                ?>
                <div class="alert alert-success">
                    El alumno se ha registrado correctamente
                </div>
                <?php
            } elseif ($res == 2) {
                ?>
                <div class="alert alert-danger">
                    El alumno no existe en la base de datos
                </div>
                <?php
            } else {
                ?>
                <div class="alert alert-warning">
                    <?= $res ?>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>
</body>