<?php
require_once("core/funcionesbd.php");
$sql = "SELECT CONCAT(nombres,' ',apellidos) as estudiante, foto FROM usuario WHERE carnet='".$_SESSION['usuario']."'";
$objBD = new funcionesBD();
$res = $objBD->ConsultaPersonalizada($sql);
while($fila = mysqli_fetch_assoc($res))
{
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
                            if(@$datos['foto'] != "")
                            {
                                ?>
                                <img src="<?= $datos['foto'] ?>" alt="Foto" class="img-fluid">
                                <?php
                            }
                            else
                            {
                                ?>
                                <img src="<?= imagenes ?>foto.png" alt="Foto" class="img-fluid">
                                <?php
                            }
                        ?>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <h3>Nombre del Estudiante: <?= $nombreAlumno ?></h3>
            <h4>Carnet: <?= $_SESSION['usuario'] ?></h4>
            <form action="">
                <label>Materia:
                    <select name="materia" id="materia" class="form-control">
                        <option value="">--Seleccione Uno--</option>
                        <?php
                        $sql = "Select Modulo.idModulo, Modulo.nombreModulo, Modulo.tipoModulo from UsuarioActivo INNER JOIN Modulo ON UsuarioActivo.idModulo = Modulo.idModulo Where UsuarioActivo.carnet = '".$_SESSION['usuario']."'";
                        $objBD = new funcionesBD();
                        $res = $objBD->ConsultaPersonalizada($sql);
                        while($fila = mysqli_fetch_assoc($res))
                        {
                            echo "<option value='".$fila['idModulo']."'>".$fila['nombreModulo']." (".$fila['tipoModulo'].")</option>";
                        }
                        ?>
                    </select>
                </label>
            </form>
        </div>
    </div>
</div>
