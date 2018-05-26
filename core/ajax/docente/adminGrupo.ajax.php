<?php 
define("__ROOT__", dirname(__FILE__,4));
require_once(__ROOT__.'/controladores/docente.controlador.php');
require_once(__ROOT__.'/core/funcionesbd.php');
require_once(__ROOT__.'/core/criptografia.php');

if(isset($_REQUEST['mostrarGuias']))
{
    $idModulo=$_REQUEST['idModulo'];

    $objDocenteControlador=new DocenteControlador('DocenteModelo');

    $resultado=$objDocenteControlador->ObtenerSiglas($idModulo);

    while($arrayModulo=$resultado->fetch_array(MYSQLI_ASSOC))
    {
        $carpetaMod = $arrayModulo['siglas'];
        $anyoModulo=$arrayModulo['anyo'];
    }

    $directorio="Archivos/Guias/".$carpetaMod."-".$anyoModulo;

    $guias=scandir($directorio);

    $contador=0;
    foreach ($guias as $guia)
    {
        if(!($guia == ".") and !($guia==".."))
        {
            echo "$contador - ".$guia." ";
            $contador++;
            
            $rutaArchivo=$directorio."/".$guia;

            $archivoAux=cifrar($rutaArchivo);

            ?>
                    <button onclick='descargar(<?php echo '"'.$archivoAux.'"';?>)'>Descargar</button>
            <?php 
            echo "<br><br>";
        }

    }
    if($contador==0)
    {
        echo "No hay guias en este modulo";
    }
}


if(isset($_REQUEST['adminSeguridad']))
{
    $idModulo=$_REQUEST['idModulo'];

    $objDocenteControlador=new DocenteControlador('DocenteModelo');

    $resultado=$objDocenteControlador->obtenerInfoSeguridadModulo($idModulo);

    if (gettype($resultado)=="string")
    {
        echo $resultado;
    }
    else
    {
        if($arraySeguridad=$resultado->fetch_assoc())
        {
            $tieneContra=$arraySeguridad['protegidoPorContra'];
            $contraModulo=$arraySeguridad['contraModulo'];

            if($tieneContra==0)
            {
                ?>
                    <div class="alert alert-info">El modulo no tiene contraseña</div>
                    <form action="" method="post">
                        <label for="contra">Nueva contraseña:
                            <input type="password" name="contra" class="form-control" required>
                        </label><br>
                        <input type="hidden" name="idModulo" value="<?= $idModulo ?>">
                        <input type="submit" name="asignarContra" value="Asignar contraseña" class="btn btn-info">
                    </form>
                    <br>
                <?php
            }
            elseif($tieneContra==1)
            {
                ?>
                
                    <div class="alert alert-info">El modulo esta protegido por contraseña</div>

                    <button class="btn btn-info" onclick="mostrarModificarContra('<?= $idModulo ?>')">Modificar<br>contraseña</button>

                    <button class="btn btn-info" onclick="mostrarEliminarContra('<?= $idModulo ?>')">Eliminar<br>contraseña</button>
                <?php
            }
        }
    }
    
            
}

if(isset($_REQUEST['mostrarModificarContra']))
{
    session_start();
    $idModulo=$_REQUEST['idModulo'];
    $carnetDocente=$_SESSION['usuario'];

    ?>
        <h5>Modificar contraseña actual</h5>
        <form action="" method="post">
            <label for="contra">Nueva contraseña:
                <input type="password" name="contra" id="contra" class="form-control" required>
            </label><br>

            <label for="contra">Contraseña actual de docente:
                <input type="password" name="contraDocente" id="contraDocente" class="form-control" required>
            </label><br>

            <input type="hidden" name="idModulo" value="<?= $idModulo ?>">
            <input type="hidden" name="carnetDocente" id="carnetDocente" value="<?= $carnetDocente ?>">
            <input type="submit" name="modificarContra" value="Modificar contraseña" onclick="return verificarDocente()" class="btn btn-info">
        </form>
        <br>
    <?php
}

if(isset($_REQUEST['mostrarEliminarContra']))
{
    session_start();
    $idModulo=$_REQUEST['idModulo'];
    $carnetDocente=$_SESSION['usuario'];

    ?>
        <h5>Eliminar contraseña actual</h5>
        <form action="" method="post">

            <label for="contra">Contraseña actual de docente:
                <input type="password" name="contraDocente" id="contraDocente" class="form-control" required>
            </label><br>

            <input type="hidden" name="idModulo" value="<?= $idModulo ?>">
            <input type="hidden" name="carnetDocente" id="carnetDocente" value="<?= $carnetDocente ?>">
            <input type="submit" name="eliminarContra" value="Eliminar contraseña" onclick="return verificarDocente()" class="btn btn-info">
        </form>
        <br>
    <?php
}


if(isset($_REQUEST['validarContraDocente']))
{
    $carnetDocente=$_REQUEST['carnetDocente'];
    $contraDocente=$_REQUEST['contraDocente'];

    $objDocenteControlador=new DocenteControlador('DocenteModelo');

    $resultado=$objDocenteControlador->validarContraDocente(trim($carnetDocente),trim($contraDocente));

    if(gettype($resultado)=="string")
    {
        echo 0;
    }
    elseif($resultado)
    {
        echo 1;
    }
}

if(isset($_REQUEST['mostrarAdminModulo']))
{
    session_start();
    $idModulo=$_REQUEST['idModulo'];
    $carnetDocente=$_SESSION['usuario'];

    ?>
        <div class="alert alert-warning">
            ¿Esta seguro que quiere desactivar el modulo?<br>
            Al borrarlo desaparecera de los grupos para administrar y ningun alumno podra visualizarlo hasta que se vuelva a activar.
        </div>
        <form action="" method="post">

            <label for="contra">Contraseña actual de docente:
                <input type="password" name="contraDocente" id="contraDocente" class="form-control" required>
            </label><br>

            <input type="hidden" name="idModulo" value="<?= $idModulo ?>">
            <input type="hidden" name="carnetDocente" id="carnetDocente" value="<?= $carnetDocente ?>">
            <input type="submit" name="desactivarModulo" value="Desactivar modulo" onclick="return verificarDocente()" class="btn btn-info">
        </form>
        <br>
    <?php
}

if(isset($_REQUEST['agregarPonderacion']))
{
    $idModulo=$_REQUEST['idModulo'];
    $totalPorcentajes=$_REQUEST['totalPorcentajes'];
    
    $porcentajeUtilizable=(100-$totalPorcentajes);

    ?>
        <div class="alert alert-info">
            Agregar ponderacion.
        </div>
        <form action="" method="post">

            <label for="nombrePonderacion">Nombre de la ponderacion:
                <input type="text" name="nombrePonderacion" id="nombrePonderacion" class="form-control" required>
            </label><br>

            <label for="porcentajePonderacion">Porcentaje de la ponderacion:
                <input type="number" name="porcentajePonderacion" id="porcentajePonderacion" min="0" max="<?= $porcentajeUtilizable ?>" class="form-control" required>
            </label><br>

            <input type="hidden" name="idModulo" value="<?= $idModulo ?>">
            <input type="hidden" name="porcentajeUtilizable" id="porcentajeUtilizable" value="<?= $porcentajeUtilizable ?>">

            <input type="submit" name="agregarPonderacion" value="Agregar ponderacion" onclick="return verificarMaximoPorcentaje('<?= $porcentajeUtilizable ?>')" class="btn btn-info">
        </form>
        <br>
    <?php
}

if(isset($_REQUEST['mostrarModificarPonderaciones']))
{
    $objDocenteModelo=new docenteModelo();
    $idModulo=$_REQUEST['idModulo'];
    ?>
        <form action="<?= urlBase ?>docente/admingrupo" method="post">
            <?php

                $ponderaciones=$objDocenteModelo->BuscarPonderaciones($idModulo);

                if (gettype($ponderaciones)=="string")
                {
                    echo $ponderaciones;
                }
                else
                {
                    $i=0;

                    while($arrayPonderaciones=$ponderaciones->fetch_array(MYSQLI_ASSOC))
                    {
                        $ponderacionesOrdenadas[$i]=$arrayPonderaciones['nombrePonderacion'];
                        $porcentajesOrdenados[$i]=$arrayPonderaciones['porcentaje'];
                        $idPonderaciones[$i]=$arrayPonderaciones['idPonderacion'];
                        $i++;
                    }

                    $cantidadPonderaciones=$ponderaciones->num_rows;

                    if ($cantidadPonderaciones == 0)
                    {
                        echo "Este modulo no tiene ponderaciones asignadas.<br> Por favor comuniquese con el administrador o ponderelo usted mismo.<br>";
                       
                        ?>
                        <br>
                        <button class="btn btn-success" type="button" onclick="agregarPonderacion('<?= $idModulo ?>','0')">Ponderar modulo</button>
                        <?php
                        
                    }
                    else
                    {
                        $objDocenteControlador=new DocenteControlador('DocenteModelo');

                        $totalPorcentajes=0;
                        for ($j=0;$j<$cantidadPonderaciones;$j++)
                        {
                            $resultado=$objDocenteControlador->ObtenerSiglas($idModulo);

                            while($arrayGrupos=$resultado->fetch_array(MYSQLI_ASSOC))
                            {
                                $siglasModulos=$arrayGrupos['siglas'];
                                $anyosModulos=$arrayGrupos['anyo'];
                            }

                            $resultado=$objDocenteControlador->obtenerNombrePonderacion($idPonderaciones[$j]);

                            $nombrePonderacion=$resultado->fetch_assoc();



                            $rutaArchivo="Archivos/Practicas/".$siglasModulos."-".$anyosModulos."/Ponderacion_".$nombrePonderacion['nombrePonderacion']."_".$nombrePonderacion['idPonderacion']."/";

                            $archivo=$siglasModulos."-".$anyosModulos."_ArchivosPonderacion_".$nombrePonderacion['nombrePonderacion']."_".$nombrePonderacion['idPonderacion'];

                            $aux=cifrar($rutaArchivo);
                            $rutaArchivo=$aux;

                            $aux=cifrar($archivo);
                            $archivo=$aux;

                            ?>
                                <span>
                                    <input type="hidden" name="idPonderaciones[]" value="<?= $idPonderaciones[$j] ?>">

                                    <input type="text" name="nombrePonderaciones[]" value="<?= $ponderacionesOrdenadas[$j] ?>" style="width: 60px;">

                                    <label>
                                        <input type="number" step="0.1" max="100" min="0" id="<?= $idPonderaciones[$j] ?>" name="porcentajePonderaciones[]" value="<?= $porcentajesOrdenados[$j] ?>" style="width: 50px;"  onkeyup="actualizarTotal(<?= $idModulo ?>,<?= $idPonderaciones[$j] ?>,<?= $porcentajesOrdenados[$j] ?>)" onchange="actualizarTotal(<?= $idModulo ?>,<?= $idPonderaciones[$j] ?>,<?= $porcentajesOrdenados[$j] ?>)">%
                                    </label>

                                    <button class="btn btn-info" type="button" onclick="confirmarBorrarPonderacion(<?= $idPonderaciones[$j] ?>,<?= $idModulo ?>)">Eliminar</button>

                                    <button class="btn btn-info" type="button" onclick="comprimirPracticasPonderacion('<?= $rutaArchivo ?>','<?= $archivo ?>')">Descargar</button>

                                </span>
                                <br>
                            <?php
                            $totalPorcentajes+=$porcentajesOrdenados[$j];

                        }

                        if($totalPorcentajes<100)
                        {
                            ?>
                            <br>
                            <button class="btn btn-success" type="button" onclick="agregarPonderacion('<?= $idModulo ?>','<?= $totalPorcentajes ?>')">agregar ponderacion</button>
                            <?php
                        }
                        ?>
                            <font>Total:</font>
                            <input type="text" id="<?= $idModulo ?>" name="total" value="<?= $totalPorcentajes ?>" onfocus="this.blur()" style="width: 70px;">%<br><br>

                            <button class="btn btn-info" name="guardarPonderaciones" onclick="return verificarPonderaciones(<?= $idModulo ?>)">Guardar<br>Ponderaciones</button>
                        <?php
                    }
                }
            ?>
        </form>
    <?php
}

if(isset($_REQUEST['ConfirmarBorrarPonderacion']))
{
    session_start();
    $idPonderacion=$_REQUEST['idPonderacion'];
    $carnetDocente=$_SESSION['usuario'];
    $idModulo=$_REQUEST['idModulo'];

    $objDocenteControlador=new DocenteControlador('DocenteModelo');

    $resultado=$objDocenteControlador->obtenerNombrePonderacion($idPonderacion);

    $arrayNombre=$resultado->fetch_assoc();

    $nombrePonderacion=$arrayNombre['nombrePonderacion'];

    ?>
        <div class="alert alert-warning">
            ¿Esta seguro de borrar esta ponderacion?<br>
            "<?= $nombrePonderacion ?>"<br>
            Al borrarla se eliminaran todas las practicas y notas ligadas a esta ponderacion. Tanto archivos, directorios y registros.
        </div>
        
        <form action="" method="post">

            <label for="contra">Contraseña actual de docente:
                <input type="password" name="contraDocente" id="contraDocente" class="form-control" required>
            </label><br>

            <input type="hidden" name="idPonderacion" value="<?= $idPonderacion ?>">
            <input type="hidden" name="idModulo" value="<?= $idModulo ?>">
            <input type="hidden" name="carnetDocente" id="carnetDocente" value="<?= $carnetDocente ?>">
            <input type="submit" name="EliminarPonderacion" value="Eliminar Ponderacion" onclick="return verificarDocente()" class="btn btn-info">
        </form>
    <?php
}

if(isset($_REQUEST['descargarPracticasPonderacion']))
{
    $idPonderacion=$_REQUEST['idPonderacion'];
    $idModulo=$_REQUEST['idModulo'];

    $objDocenteControlador=new DocenteControlador('DocenteModelo');

    $resultado=$objDocenteControlador->descargarPracticasPonderacion($idPonderacion,$idModulo);
}

?>