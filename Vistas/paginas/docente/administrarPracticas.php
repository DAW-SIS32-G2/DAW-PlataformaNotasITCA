<?php
echo "<br><br><br>";
	@define("__ROOT__", dirname(__FILE__,4));
	require_once(__ROOT__.'/core/funcionesbd.php');
	require_once(__ROOT__.'/controladores/docente.controlador.php');
	$objDocenteModelo=new DocenteModelo();

	if (isset($_REQUEST['guardarPracticas']))
	{
		$nombrePractica=$_REQUEST['nombre'];
		$cantidadEjercicios=$_REQUEST['cantidad'];
		$idPonderacion=$_REQUEST['ponderacion'];
		$idModulo = $_REQUEST['modulo'];

		$objDocenteControlador=new DocenteControlador('DocenteModelo');

		$resultado=$objDocenteControlador->ObtenerSiglas($idModulo);

		while($arrayModulo=$resultado->fetch_array(MYSQLI_ASSOC))
        {
            $carpetaMod = $arrayModulo['siglas'];
            $anyoModulo=$arrayModulo['anyo'];
        }

		$cantidadTareas=$objDocenteModelo->obtenerCantidadTareas($idPonderacion);

		if(gettype($cantidadTareas)=="string")
		{
			echo $cantidadTareas;
		}
		else
		{
			$resultado=$objDocenteModelo->obtenerPorcentajePonderacion($idPonderacion);

			$porcentajePonderacion=$resultado->fetch_array(MYSQLI_ASSOC);

			$cantidadTareas++;


			$porcentajeTarea=number_format(($porcentajePonderacion['porcentaje']/$cantidadTareas),2);


			$resultado=$objDocenteModelo->InsertarPracticas($nombrePractica,$porcentajeTarea,$cantidadEjercicios,$idPonderacion,$carpetaMod,$anyoModulo);

			if(gettype($resultado)=="string")
			{
				echo $resultado;
			}
			else
			{
				$resultado=$objDocenteModelo->actualizarPorcentajesPracticas($idPonderacion,$porcentajeTarea);

				if(gettype($resultado)=="string")
				{
					echo $resultado;
				}
				else
				{
					echo "practica agregada";
				}
			}
		}


	}
?>
<div class="container" style="padding-top: 65px">

	<script type="text/javascript">
	function mostrarPonderaciones()
	{
	  //Procesar
	  $.ajax({
	      type      : 'post',
	      url       : 'ajax/administrarPracticas',
	      data      : {modulo: $('#moduloIngresar').val(),administrar: "true"},
	      success   : function(respuesta)
	      {
	        document.getElementById('resultado').innerHTML = respuesta;
	      }
	  })

	}

	function mostrarPracticas()
	{
	  //Procesar
	  $.ajax({
	      type      : 'post',
	      url       : 'ajax/administrarPracticas',
	      data      : {modulo: $('#moduloMostrar').val(),mostrar: "true"},
	      success   : function(respuesta)
	      {
	        document.getElementById('resultadoPracticas').innerHTML = respuesta;
	      }
	  })

	}
	</script>

	<form method="post">
		<table class="table">
			<tr>
				<th colspan="2">Agregar prácticas</th>
			</tr>
			<tr>
				<td colspan="2">
					<font>Grupo:</font>
					<select name="modulo" class="form-control" id="moduloIngresar" onchange="mostrarPonderaciones()">

						<?php



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
									$secciones[]=$arrayGrupos['seccion'];
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
											<?php echo $nombreGrupos[$j].$secciones[$j]."-".$nombreModulos[$j]; ?>
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
					<input type="text" class="form-control" name="nombre" required>
				</td>
			</tr>
			<tr>
				<td>
					<label for="cantidad">Cantidad de ejercicios:</label>
				</td>
				<td>
					<input type="number" class="form-control" min="1" name="cantidad" required>
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
			<tr>
				<td colspan="2" align="center">
					<button class="btn btn-secondary" name="guardarPracticas">Guardar practica</button>
				</td>
			</tr>
		</table>
	</form>
</div>

<br><br>

<div class="container">

	<font>Practicas</font><br>

		<select name="modulo" id="moduloMostrar" class="form-control" onchange="mostrarPracticas()">

			<?php

				$resultado=$objDocenteModelo->CargarGrupos();

				if (gettype($resultado)=="string")
				{
					echo "Error al cargar los grupos...";
				}
				else
				{
					unset($nombreModulos,$nombreGrupos,$idModulos);
					$i=0;
					while($arrayGrupos=$resultado->fetch_array(MYSQLI_ASSOC))
					{
						$nombreModulos[]=$arrayGrupos['nombreModulo'];
						$secciones[]=$arrayGrupos['seccion'];
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
								<?php echo $nombreGrupos[$j].$secciones[$j]."-".$nombreModulos[$j]; ?>
							</option>

						<?php
					}
				}
			 ?>

		</select>


		<div class="container" id="resultadoPracticas">

		</div>
</div>
