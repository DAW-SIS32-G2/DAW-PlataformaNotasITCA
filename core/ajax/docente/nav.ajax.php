<?php
require_once("config/variables.php");
@session_start();
if(isset($_POST['cont']))
{
	require_once("core/funcionesbd.php");
	$objBD = new funcionesBD();
	$notificaciones = $objBD->buscarNotificaciones($_SESSION['usuario']);
	$contador = 0;

	while($fila = mysqli_fetch_assoc($notificaciones))
	{
	    $contador++;
	}

	echo $contador;
}
else if(isset($_POST['noti']))
{
	require_once("core/funcionesbd.php");
	$objBD = new funcionesBD();
	$notificaciones = $objBD->buscarNotificaciones($_SESSION['usuario']);
	$contador = 0;
	$notis = array();

	while($fila = mysqli_fetch_assoc($notificaciones))
	{
	    $notis['titulos'][$contador] = substr($fila['titulo'],0,50)."...";
	    $notis['desc'][$contador] = substr($fila['descripcion'],0,50)."...";
	    $contador++;
	}

	if($contador == 0)
	{
	    ?>
	    <a class="dropdown-item nav-but disabled" href="<?= urlBase ?><?= $_SESSION['tipo'] ?>/notificaciones">No hay notificaciones nuevas</a>
	    <?php
	}
	else
	{
	    if($contador < 5)
	    {
	        for($i=0;$i<$contador-1;$i++)
	        {
	            ?>
	            <a class="dropdown-item nav-but" href="#">
	                <strong><?= $notis['titulos'][$i] ?></strong><br>
	                <small><?= $notis['desc'][$i] ?></small>
	            </a>
	            <div class="dropdown-divider"></div>
	            <?php
	        }
	        ?>
	        <a class="dropdown-item nav-but" href="#">
	            <strong><?= $notis['titulos'][$contador-1] ?></strong><br>
	            <small><?= $notis['desc'][$contador-1] ?></small>
	        </a>
	        <div class="dropdown-divider"></div>
	        <a class="dropdown-item nav-but" href="<?= urlBase ?><?= $_SESSION['tipo'] ?>/notificaciones">
	            <strong clas="text-center">Ver todas las notificaciones</strong>
	        </a>
	        <?php
	    }
	    else
	    {
	        for($i=0;$i<4;$i++)
	        {
	            ?>
	            <a class="dropdown-item nav-but" href="#">
	                <strong><?= $notis['titulos'][$i] ?></strong><br>
	                <small><?= $notis['desc'][$i] ?></small>
	            </a>
	            <div class="dropdown-divider"></div>
	            <?php
	        }
	        ?>
	        <a class="dropdown-item nav-but" href="#">
	            <strong><?= $notis['titulos'][5] ?></strong><br>
	            <small><?= $notis['desc'][5] ?></small>
	        </a>
	        <div class="dropdown-divider"></div>
	        <a class="dropdown-item nav-but" href="<?= urlBase ?><?= $_SESSION['tipo'] ?>/notificaciones">
	            <strong clas="text-center">Ver todas las notificaciones</strong>
	        </a>
	        <?php
	    }
	}
}
?>         