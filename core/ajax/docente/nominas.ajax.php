<?php
require_once("core/funcionesbd.php");
$idGrupo = $_POST['grupo'];
$sql = "Select Grupo.nombreGrupo, Grupo.seccion, Usuario.carnet, Usuario.nombres, Usuario.apellidos FROM Grupo INNER JOIN Usuario ON Grupo.idGrupo = Usuario.idGrupo WHERE Grupo.idGrupo = '$idGrupo'";
$objBD = new funcionesBD();
$res = $objBD->ConsultaPersonalizada($sql);
if(mysqli_num_rows($res) > 0)
{
	?>
	<table class="table table-hover table-responsive d-table w-100">
		<thead class="thead-dark">
			<tr>
				<th width="20%">Carnet</th>
				<th width="40%">Nombres</th>
				<th width="40%">Apellidos</th>
			</tr>
		</thead>
	<?php
	while($fila = mysqli_fetch_assoc($res))
	{
		?>
		<tr>
			<td><?= $fila['carnet'] ?></td>
			<td><?= $fila['nombres'] ?></td>
			<td><?= $fila['apellidos'] ?></td>
		</tr>
		<?
	}
	?>
	</table>
	<?php
}
else
{
	echo "No hay alumnos en esta sección";
}
?>