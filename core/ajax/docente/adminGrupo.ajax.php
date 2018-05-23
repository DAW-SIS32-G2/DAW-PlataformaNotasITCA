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
                    <h5>Modificar contraseña actual</h5>
                    <form action="" method="post">
                        <label for="contra">Nueva contraseña:
                            <input type="password" name="contra" class="form-control" required>
                        </label><br>

                        <label for="contra">Contraseña actual de docente:
                            <input type="password" name="contraDocente" class="form-control" required>
                        </label><br>

                        <input type="hidden" name="idModulo" value="<?= $idModulo ?>">
                        <input type="submit" name="modificarContra" value="Modificar contraseña" class="btn btn-info">
                    </form>
                    <br>
                <?php
            }
        }
    }
    
            
}
?>