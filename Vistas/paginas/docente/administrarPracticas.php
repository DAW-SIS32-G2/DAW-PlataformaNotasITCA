<?php
	echo '<br><br><br>';
	define("__ROOT__", dirname(dirname(__FILE__,3)));
	require_once(__ROOT__.'/core/funcionesbd.php'); 
?>
<div class="container">

	<script type="text/javascript">
	function proceso()
	{
	  //Procesar
	  $.ajax({
	      type      : 'post',
	      url       : 'ajax/administrarPracticas',
	      data      : {modulo: $('#modulo').val()},
	      success   : function(respuesta)
	      {
	        document.getElementById('resultado').innerHTML = respuesta;
	      }
	  })

	}
	</script>
	
	<table border="1px">
		<tr>
			<th colspan="2">Agregar prácticas</th>
		</tr>
		<tr>
			<td colspan="2">
				<font>Grupo:</font>
				<select name="modulo" id="modulo" onchange="proceso()">
					
					<?php 

						$objDocenteModelo=new DocenteModelo();

						$resultado=$objDocenteModelo->CargarGrupos();

						if (gettype($resultado)=="string")
						{
							echo "Error al cargar los grupos...";
						}
						else
						{
							$i=0;
							while($arrayGrupos=$resultado->fetch_array(MYSQLI_ASSOC))
							{
								$nombreModulos[]=$arrayGrupos['nombreModulo'];
								$nombreGrupos[]=$arrayGrupos['nombreGrupo'];
								$idModulos[]=$arrayGrupos['idModulo'];
								$i++;
							}

							$conteo=count($nombreModulos);

							echo "<option>--Seleccione una opcion--</option>";

							for($j=0;$j<$conteo;$j++)
							{ 
								?>
									
									<option value='<?php echo $idModulos[$j]; ?>'>
										<?php echo $nombreGrupos[$j]."-".$nombreModulos[$j]; ?>
									</option>

								<?php
							}
						}
					 ?>

				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label for="nombre">Nombre:</label>
			</td>
			<td>
				<input type="text" name="nombre" required>
			</td>
		</tr>
		<tr>
			<td>
				<label for="cantidad">Cantidad de ejercicios:</label>
			</td>
			<td>
				<input type="number" min="1" name="cantidad" required>
			</td>
		</tr>
		<tr>
			<td>
				<label for="ponderacion">Ponderacion:</label>
			</td>
			<td>
				<div id="resultado">
					<font>Seleccione un modulo.</font>
				</div>
			</td>
		</tr>
		<tr></tr>
	</table>

</div>