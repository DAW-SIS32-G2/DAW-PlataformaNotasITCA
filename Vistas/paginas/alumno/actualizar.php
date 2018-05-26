<?php
require_once("core/funcionesbd.php");
$sql = "SELECT usuario.*, CONCAT(Grupo.nombreGrupo,' ',Grupo.seccion) As Grupo FROM usuario INNER JOIN Grupo ON Usuario.idGrupo = Grupo.idGrupo WHERE carnet = '".$_SESSION['usuario']."'";
$objBD = new funcionesBD();
$datosAlumno = $objBD->ConsultaPersonalizada($sql);
$datos = array();

while($fila = mysqli_fetch_assoc($datosAlumno))
{
    $datos['carnet'] = $_SESSION['usuario'];
    $datos['apellidos'] = $fila['apellidos'];
    $datos['nombres'] = $fila['nombres'];
    $datos['telefono'] = $fila['telefonoMovil'];
    $datos['jornada'] = $fila['jornada'];
    $datos['sexo'] = $fila['sexo'];
    $datos['idGrupo'] = $fila['idGrupo'];
    $datos['correo'] = $fila['email'];
    $datos['foto'] = $fila['foto'];
    $datos['grupo'] = $fila['Grupo'];
    $datos['jornada'] = $fila['jornada'];
}
?>
<div id="da" style="padding-top:65px;">
    <div class="container">

        <div class="row">
            <div class="col-md-2">
                <div class="card" style="border-color: red;">
                    <div class="card-body">
                        <?php
                            if($datos['foto'] != "")
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
                <i>NOTA: Los datos que no se pueden editar son sólo para verificación, si existe algún error en ellos, notifique a su docente para que puedan ser cambiados</i>
                <form action="">
                    <div class="row">
                        <label class="col-md-6">Carnet
                            <input type="text" value="<?= $datos['carnet'] ?>" id="carnet" class="form-control" readonly>
                        </label>
                        <label class="col-md-6">Grupo:
                            <input type="text" name="grupo" class="form-control" value="<?= $datos['grupo'] ?>" readonly>
                        </label>
                    </div>
                    <div class="row">
                        <label class="col-md-6">Apellidos:
                            <input type="text" value="<?= $datos['apellidos'] ?>" id="apellidos" class="form-control" readonly>
                        </label>
                        <label class="col-md-6">Nombres:
                            <input type="text" value="<?= $datos['nombres'] ?>" id="nombres" class="form-control" readonly>
                        </label>
                    </div>
                    <div class="row">
                        <label class="col-md-6">Tel&eacute;fono:
                            <input type="text" name="tel" class="form-control" pattern="/d{8}" placeholder="########" value="<?= $datos['telefono'] ?>" id="telefono">
                        </label>
                        <label class="col-md-6">Jornada:
                            <select name="jornada" id="jornada" class="form-control">
                                <?php
                                switch($datos['jornada'])
                                {
                                    case "matutina":
                                    ?>
                                        <option value="">--Seleccione Uno--</option>
                                        <option value="matutina" selected>Matutina</option>
                                        <option value="nocturna">Nocturna</option>
                                    <?php
                                    break;
                                    case "nocturna":
                                    ?>
                                        <option value="">--Seleccione Uno--</option>
                                        <option value="matutina">Matutina</option>
                                        <option value="nocturna" selected>Nocturna</option>
                                    <?php
                                    break;
                                    default:
                                    ?>
                                        <option value="" selected>--Seleccione Uno--</option>
                                        <option value="matutina">Matutina</option>
                                        <option value="nocturna">Nocturna</option>
                                    <?php
                                    break;
                                }
                                ?>
                            </select>
                        </label>
                    </div>
                    <div class="row">
                        <label class="col-md-4">Sexo:
                            <select name="sexo" id="sexo" class="form-control">
                                <?php
                                    switch($datos['sexo'])
                                    {
                                        case "masculino":
                                            ?>
                                                <option value="">--Seleccione Uno--</option>
                                                <option value="masculino" selected>Masculino</option>
                                                <option value="femenino">Femenino</option>
                                            <?php
                                        break;
                                        case "femenino":
                                            ?>
                                                <option value="">--Seleccione Uno--</option>
                                                <option value="masculino">Masculino</option>
                                                <option value="femenino" selected>Femenino</option>
                                            <?php
                                        break;
                                        default:
                                            ?>
                                                <option value="" selected>--Seleccione Uno--</option>
                                                <option value="masculino">Masculino</option>
                                                <option value="femenino">Femenino</option>
                                            <?php
                                        break;
                                    }
                                ?>
                            </select>
                        </label>
                        <label class="col-md-8">Correo Electronico:
                            <input type="text" value="<?= $datos['correo'] ?>" id="email" class="form-control">
                        </label>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="button" onclick="actualizarmisDatos()">Actualizar Datos
                            </button>
                            <input type="button" class="btn btn-info" type="button" data-toggle="modal" data-target="#mod" value="Cambiar Contraseña">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mod" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cambio de contraseña</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="form-group" action="index.html" method="post">
            <div class="modal-body">

                   <div class="container-fluid">
                       <div class="form-group row">
                           <input class="form-control" type="password" placeholder="Clave actual" required>
                       </div>
                       <div class="form-group row">
                           <input class="form-control" type="password" placeholder="Nueva Clave" required>
                       </div>
                       <div class="form-group row">
                           <input class="form-control" type="password" placeholder="Repetir Nueva Clave" required>
                       </div>
                   </div>
            </div>


            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary" data-dismiss="modal">Enviar</button>
                <button type="button" class="btn btn-primary">Cerrar</button>
            </div>
            </form>
        </div>
    </div>
</div>
