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

		<tr>
			
			<td>15</td>
			<td>SIS32B-2018</td>
			<td>*botno subir archivos*<br>*boton ver practicas*<br>*boton descargar todas las guias*</td>
			<td>Grupo Activo<br>*boton ponerle clave al grupo*</td>
			<td>*boton Cerrar inscripciones en el grupo*</td>
			<td>Desarrollo de Aplicaciones para la Web</td>
			<td>
				
				<form action="">
					
					

						<?php

							$hola=new docenteModelo(); 
							$ponderaciones=$hola->BuscarPonderaciones(); 

							$i=0;
							while($arrayPonderaciones=$ponderaciones->fetch_array(MYSQLI_ASSOC))
							{
								$ponderacionesOrdenadas[$i]=$arrayPonderaciones['nombrePonderacion'];
								$i++;
							}

							$ponderaciones=$hola->BuscarPonderaciones(); 

							$i=0;
							while($arrayPorcentajes=$ponderaciones->fetch_array(MYSQLI_ASSOC))
							{
								$porcentajesOrdenados[$i]=$arrayPorcentajes['porcentaje'];
								$i++;
							}

							$cantidad=$ponderaciones->num_rows;

							

							for ($j=0;$j<$cantidad;$j++) 
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

						?>
							
				

				</form>

			</td>
			<td>*boton que no se para que es*</td>

		</tr>

	</table>

</div>



<?php


	 echo "<br><br>administrfacion de ponderaciones prro"; 



 ?>