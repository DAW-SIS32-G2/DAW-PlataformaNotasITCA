<?php
require_once("core/funcionesbd.php");
if($_POST['idmodulo'] != "")
{
	$idModulo=$_POST['idmodulo'];
	$objAlumnoModelo = new alumnoModelo();
	$resultado = $objAlumnoModelo->ObtenerSiglas($idModulo);
	while($arrayModulo=$resultado->fetch_array(MYSQLI_ASSOC))
	{
		$carpetaMod = $arrayModulo['siglas'];
		$anyoModulo=$arrayModulo['anyo'];
	}
	$directorio="Archivos/Guias/".$carpetaMod."-".$anyoModulo;
	$guias=scandir($directorio);
	?>
	<table class="table table-bordered table-light table-hover">
		<thead>
			<tr>
				<th scope="col"># de guia</th>
				<th scope="col">Nombre de la guia</th>
				<th scope="col">Opciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$contador=0;
			foreach ($guias as $guia)
			{
				if(!($guia == ".") and !($guia==".."))
				{
					echo "<tr>
						<td scope='row'>";
							echo "$contador";
						echo "</td><td>";
					echo $guia."</td><td>";
					$contador++;
					
					$rutaArchivo=$directorio."/".$guia;
					$archivoAux=cifrar($rutaArchivo);
					?>
					<button class="btn btn-info" onclick='descargar(<?php echo '"'.$archivoAux.'"';?>)'>Descargar</button>
					<?php
					echo "</td></tr>";
				}
			}
		if($contador==0)
		{
		?>
		<tr>
			<td colspan="3" scope='row'>
				No hay guias en este modulo.
			</td>
		</tr>
		<?php
		}
		?>
	</tbody>
	</table>
	<?php
}
else
{
	echo "Seleccione una materia para continuar";
}
?>