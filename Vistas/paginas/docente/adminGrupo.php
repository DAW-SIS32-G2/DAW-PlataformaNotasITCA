<?php 

	require_once('././././core/funcionesbd.php');

	$objDocenteModelo=new docenteModelo();

	if (isset($_REQUEST['guardarPonderaciones']))
	{
		$idPonderacionesG=$_REQUEST['idPonderaciones'];
		$nombrePonderacionesG=$_REQUEST['nombrePonderaciones'];
		$porcentajePonderacionesG=$_REQUEST['porcentajePonderaciones'];

		$cantidadG=count($idPonderacionesG);

		$cantidadG2=count($nombrePonderacionesG);

		$cantidadG3=count($porcentajePonderacionesG);

		$funcionoActualizacion=False;

		for ($i=0;$i<$cantidadG;$i++)
		{ 

			$resultado=$objDocenteModelo->actualizarPonderaciones($porcentajePonderacionesG[$i],$idPonderacionesG[$i]);

			if (gettype($resultado)=="string")
			{
				echo "<br>".$resultado;
			}
			else
			{
				$funcionoActualizacion=true;
			}

		}

		if ($funcionoActualizacion)
		{
			echo "<br><br><br>Ponderaciones actualizadas.";
		}
	}
 ?>

<div class="container">

	<br><br><br>

	<table border="2px">

		<tr>

			<th>ID</th>
			<th>Grupo</th>
			<th>Guias</th>
			<th>Estado</th>
			<th>Grupo Cerrado</th>
			<th>Modulo</th>
			<th>Ponderaciones</th>
			<th>X</th>

		</tr>

		<?php 


			$resultado=$objDocenteModelo->CargarGrupos();

			$cantidad=$resultado->num_rows;


			
			/*Guardando los grupos en un array*/
			$i=0;
			while($arrayGrupos=$resultado->fetch_array(MYSQLI_ASSOC))
			{
				$idModulo[$i]=$arrayGrupos['idModulo'];
				$nombreGrupos[$i]=$arrayGrupos['nombreGrupo'];
				$anyoGrupos[$i]=$arrayGrupos['anyo'];
				$nombreModulos[$i]=$arrayGrupos['nombreModulo'];
				$i++;
			}




			for ($k=0;$k<$cantidad;$k++)
			{
			
		 	?>

			<tr>

				<td>
					<?php echo $idModulo[$k]; ?>
				</td>

				<td>
					<?php echo $nombreGrupos[$k]."-".$anyoGrupos[$k]; ?>
				</td>

				<td>*botno subir archivos*<br>*boton ver practicas*<br>*boton descargar todas las guias*</td>

				<td>Grupo Activo<br>*boton ponerle clave al grupo*</td>

				<td>*boton Cerrar inscripciones en el grupo*</td>

				<td>
					<?php echo $nombreModulos[$k]; ?>
				</td>

				<td>

					<form action="http://localhost/repositorios/DAW-PlataformaNotasITCA/docente/admingrupo" method="post">



							<?php

								$ponderaciones=$objDocenteModelo->BuscarPonderaciones($idModulo[$k]);

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
										echo "Este modulo no tiene ponderaciones asignadas.<br> Por favor comuniquese con el administrador.";
									}
									else
									{
										for ($j=0;$j<$cantidadPonderaciones;$j++)
										{
											?>

												<span>

													<?php 
													echo '<input type="hidden" name="idPonderaciones[]" value="'.$idPonderaciones[$j].'">';

													echo '<input type="text" name="nombrePonderaciones[]" value="'.$ponderacionesOrdenadas[$j].'" style="width: 60px;"> ';

													echo '<label><input type="number" max="100" min="0" name="porcentajePonderaciones[]" value="'.$porcentajesOrdenados[$j].'" style="width: 40px;">%</label>'; ?>

												</span>

												<br>
											<?php
										}

										?>

											<button name="guardarPonderaciones">Guardar Ponderaciones</button>

										<?php
									}


									

								}

							?>



					</form>

			</td>
			<td>*boton que no se para que es*</td>

		</tr>

		<?php } ?>

	</table>

</div>



<?php


	 echo "<br><br>administrfacion de ponderaciones prro";



 ?>
