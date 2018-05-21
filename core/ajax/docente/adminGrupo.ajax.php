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
                echo "El modulo no tiene contraseña";
            }
            elseif($tieneContra==1)
            {
                echo "El modulo tiene contraseña y es: $contraModulo";
            }
        }
    }
    
            
}
?>