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
	    $notis['titulos'][$contador] = $fila['titulo'];
	    $notis['desc'][$contador] = $fila['descripcion'];
	    $notis['idNotis'][$contador] = $fila['idNotificacion'];
	    $contador++;
	}

	if($contador == 0)
	{
	    ?>
	    <a class="dropdown-item nav-but disabled">No hay notificaciones nuevas</a>
	    <?php
	}
	else
	{
		?>
		<table class="table-bordered table-light table-hover table-responsive d-table w-100">
			<?php
			for($i=0;$i<$contador-1;$i++)
	        {
	            ?>
	            <tr>
	        		<td width="70%">
	                	<strong><?= $notis['titulos'][$i] ?></strong><br>
	                	<small><?= $notis['desc'][$i] ?></small>
	                </td>
	                <td width="30%">
	                	<button class='btn btn-info' onclick="leida(<?= $notis['idNotis'][$i] ?>)">Marcar como leída</button>
	                	<button class='btn btn-info' onclick="eliminarNoti(<?= $notis['idNotis'][$i] ?>)">Eliminar</button>
	                </td>
	        	</tr>
	            <?php
	        }
	        ?>
	        <tr>
	        	<td width="70%">
	            	<strong><?= $notis['titulos'][$contador-1] ?></strong><br>
	            	<small><?= $notis['desc'][$contador-1] ?></small>
	        	</td>
	        	<td width="30%">
	        		<button class='btn btn-info' onclick="leida(<?= $notis['idNotis'][$contador-1] ?>)">Marcar como leída</button>
                	<button class='btn btn-info' onclick="eliminarNoti(<?= $notis['idNotis'][$contador-1] ?>)">Eliminar</button>
                </td>
	        </tr>
		</table>
	    <?php
	}
}
else if (isset($_POST['antiguas'])) 
{
	require_once("core/funcionesbd.php");
	$objBD = new funcionesBD();
	$notificaciones = $objBD->notificacionesAntiguas($_SESSION['usuario']);
	$contador = 0;
	$notis = array();

	while($fila = mysqli_fetch_assoc($notificaciones))
	{
	    $notis['titulos'][$contador] = $fila['titulo'];
	    $notis['desc'][$contador] = $fila['descripcion'];
	    $notis['idNotis'][$contador] = $fila['idNotificacion'];
	    $contador++;
	}

	if($contador == 0)
	{
	    ?>
	    <a class="dropdown-item nav-but disabled">No hay más notificaciones</a>
	    <?php
	}
	else
	{
		?>
		<table class="table-bordered table-light table-hover table-responsive d-table w-100">
			<?php
			for($i=0;$i<$contador-1;$i++)
	        {
	            ?>
	            <tr>
	        		<td width="70%">
	                	<strong><?= $notis['titulos'][$i] ?></strong><br>
	                	<small><?= $notis['desc'][$i] ?></small>
	                </td>
	                <td width="30%">
	                	<button class='btn btn-info' onclick="eliminarNoti(<?= $notis['idNotis'][$i] ?>)">Eliminar</button>
	                </td>
	        	</tr>
	            <?php
	        }
	        ?>
	        <tr>
	        	<td width="70%">
	            	<strong><?= $notis['titulos'][$contador-1] ?></strong><br>
	            	<small><?= $notis['desc'][$contador-1] ?></small>
	        	</td>
	        	<td width="30%">
                	<button class='btn btn-info' onclick="eliminarNoti(<?= $notis['idNotis'][$contador-1] ?>)">Eliminar</button>
                </td>
	        </tr>
		</table>
	    <?php
	}
}
else if(isset($_POST['leida']))
{
	require_once("core/funcionesbd.php");
	$objBD = new funcionesBD();
	$idnoti = $_POST['idnotis'];
	$sql = "UPDATE Notificacion SET estado='0' WHERE idNotificacion = '$idnoti'";
	$res = $objBD->ConsultaPersonalizada($sql);
	if($res === TRUE)
	{
		echo "1";
	}
	else
	{
		echo $res;
	}

}
else if(isset($_POST['eliminarNoti']))
{
	require_once("core/funcionesbd.php");
	$objBD = new funcionesBD();
	$idnoti = $_POST['idnotis'];
	$sql = "DELETE FROM Notificacion WHERE idNotificacion = '$idnoti'";
	$res = $objBD->ConsultaPersonalizada($sql);
	if($res === TRUE)
	{
		echo "1";
	}
	else
	{
		echo $res;
	}

}
?>         