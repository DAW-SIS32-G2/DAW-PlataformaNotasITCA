<?php

# se incluye la clase funcionesBD
require_once("core/funcionesbd.php");

# se almacena la consulta en una variable de tipo string
$sql = "SELECT CONCAT(nombres,' ',apellidos) as estudiante, foto FROM usuario WHERE carnet='" . $_SESSION['usuario'] . "'";

# se crea una instancia de la clase funcionesBD
$objBD = new funcionesBD();

# se ejecuta la consulta
$res = $objBD->ConsultaPersonalizada($sql);

# se insertan los datos en un array asociativo
while ($fila = mysqli_fetch_assoc($res)) {
    $nombreAlumno = $fila['estudiante'];
    $foto = $fila['foto'];
}
?>
<div class="container" style="padding-top:65px;">
    <div class="row">
        <div class="col-md-2">
            <div class="card" style="border-color: red;">
                <div class="card-body">
                    <?php
                    # se comprueba si hay una foto alamacenada caso contrario se muestra la imagen por defecto
                    if (@$datos['foto'] != "") {
                        ?>
                        <img src="<?= $datos['foto'] ?>" alt="Foto" class="img-fluid">
                        <?php
                    } else {
                        ?>
                        <img src="<?= imagenes ?>foto.png" alt="Foto" class="img-fluid">
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <!--            Se imprimen los datos del alumno-->
            <h3>Nombre del Estudiante: <?= $nombreAlumno ?></h3>
            <h4>Carnet: <?= $_SESSION['usuario'] ?></h4>
            <form action="">
                <label>Materia:
                    <select name="materia" id="materia" class="form-control">
                        <option value="">--Seleccione Uno--</option>
                        <?php
                        # se almacenada la consulta para obtener los modulos a los que esta inscrito el alumno
                        $sql = "Select Modulo.idModulo, Modulo.nombreModulo, Modulo.tipoModulo from UsuarioActivo INNER JOIN Modulo ON UsuarioActivo.idModulo = Modulo.idModulo Where UsuarioActivo.carnet = '" . $_SESSION['usuario'] . "'";

                        # se crea una nueva instancia de la clase funcionesBD
                        $objBD = new funcionesBD();

                        # se ejecuta la consulta
                        $res = $objBD->ConsultaPersonalizada($sql);

                        # se imprimen los datos
                        while ($fila = mysqli_fetch_assoc($res)) {
                            echo "<option value='" . $fila['idModulo'] . "'>" . $fila['nombreModulo'] . " (" . $fila['tipoModulo'] . ")</option>";
                        }
                        ?>
                    </select>
                </label>
            </form>
        </div>
    </div>
</div>
