<?php
require_once("core/funcionesbd.php");
if(isset($_POST['cargar']))
{
	$idGrupo = $_POST['grupo'];
	$sql = "SELECT Grupo.nombreGrupo, Grupo.seccion, BuzonArchivo.idGrupo, BuzonArchivo.estado FROM Grupo INNER JOIN BuzonArchivo ON Grupo.idGrupo = BuzonArchivo.idGrupo WHERE Grupo.idGrupo ='$idGrupo'";
	$objBD = new funcionesBD();
	$res = $objBD->ConsultaPersonalizada($sql);
	if(mysqli_num_rows($res) > 0)
	{
		?>
		<table class="table table-hover table-responsive d-table w-100">
			<thead class="thead-dark">
				<tr>
					<th width="50%">Grupo</th>
					<th width="25%">Estado</th>
					<th width="25%">Acciones</th>
				</tr>
			</thead>
		<?php
		while($fila = mysqli_fetch_assoc($res))
		{
			?>
			<tr>
				<td><?= $fila['nombreGrupo']." ".$fila['seccion'] ?></td>
				<?php
				if($fila['estado'] == 1)
				{
					?>
					<td><div class="alert alert-info">El buzón está activo</div></td>
					<td><button class="btn btn-info" onclick="desactBuzon()">Desactivar Buzón</button></td>
					<?php
				}
				else
				{
					?>
					<td><div class="alert alert-warning">El buzón está inactivo</div></td>
					<td><button class="btn btn-info" onclick="actBuzon()">Activar Buzón</button></td>
					<?php
				}
				?>
			</tr>
			<?
		}
		?>
		</table>
		<?php
	}
	else
	{
		echo "Seleccione un grupo para continuar";
	}
}
elseif(isset($_POST['actBuzon']))
{
	$idGrupo = $_POST['grupo'];
	$sql = "UPDATE BuzonArchivo SET estado='1' WHERE idGrupo='$idGrupo'";
	$objBD = new funcionesBD();
	$res = $objBD->ConsultaPersonalizada($sql);

	if($res === TRUE)
	{
		echo 1;
	}
	else
	{
		echo $res;
	}
}
elseif(isset($_POST['desactBuzon']))
{
	$idGrupo = $_POST['grupo'];
	$sql = "UPDATE BuzonArchivo SET estado='0' WHERE idGrupo='$idGrupo'";
	$objBD = new funcionesBD();
	$res = $objBD->ConsultaPersonalizada($sql);

	if($res === TRUE)
	{
		echo 1;
	}
	else
	{
		echo $res;
	}
}
?>