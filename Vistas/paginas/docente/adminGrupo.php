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

			require_once('././././core/funcionesbd.php');

			$objDocenteModelo=new docenteModelo();

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

					<form action="">



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
										$i++;
									}

									$cantidadPonderaciones=$ponderaciones->num_rows;


									for ($j=0;$j<$cantidadPonderaciones;$j++)
									{
										?>

											<span>

												<?php echo '<input type="text" value="'.$ponderacionesOrdenadas[$j].'" style="width: 60px;" disabled> ';

												echo '<label><input type="number" value="'.$porcentajesOrdenados[$j].'" style="width: 30px;">%</label>'; ?>

											</span>

											<br>
										<?php
									}

									?>

										<button>Guardar Ponderaciones</button>

									<?php

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
