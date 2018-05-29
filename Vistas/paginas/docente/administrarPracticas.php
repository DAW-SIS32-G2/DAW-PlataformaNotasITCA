<?php
	echo '<div class="container" style="padding-top: 65px">';
	define("__ROOT__", dirname(__FILE__,4));
	require_once(__ROOT__.'/controladores/docente.controlador.php');
	$objDocenteControlador=new DocenteControlador('DocenteModelo');

	if (isset($_REQUEST['guardarPracticas']))
	{
		$nombrePractica=$_REQUEST['nombre'];
		$cantidadEjercicios=$_REQUEST['cantidad'];
		$idPonderacion=$_REQUEST['ponderacion'];
		$idModulo = $_REQUEST['modulo'];

		$resultado=$objDocenteControlador->ObtenerSiglas($idModulo);

		while($arrayModulo=$resultado->fetch_array(MYSQLI_ASSOC))
        {
            $carpetaMod = $arrayModulo['siglas'];
            $anyoModulo=$arrayModulo['anyo'];
        }

		$cantidadTareas=$objDocenteControlador->obtenerCantidadTareas($idPonderacion);

		if(gettype($cantidadTareas)=="string")
		{
			echo $cantidadTareas;
		}
		else
		{
			$resultado=$objDocenteControlador->obtenerPorcentajePonderacion($idPonderacion);

			$porcentajePonderacion=$resultado->fetch_array(MYSQLI_ASSOC);

			$cantidadTareas++;


			$porcentajeTarea=number_format(($porcentajePonderacion['porcentaje']/$cantidadTareas),2);


			$resultado=$objDocenteControlador->InsertarPracticas($nombrePractica,$porcentajeTarea,$cantidadEjercicios,$idPonderacion,$carpetaMod,$anyoModulo);

			if(gettype($resultado)=="string")
			{
				echo "<div class='alert alert-danger'>".$resultado."</div>";
			}
			else
			{
				$resultado=$objDocenteControlador->actualizarPorcentajesPracticas($idPonderacion,$porcentajeTarea);

				if(gettype($resultado)=="string")
				{
					echo $resultado;
				}
				else
				{
					echo "<div class='alert alert-success'>practica agregada</div>";
				}
			}
		}


	}

	if(isset($_REQUEST['eliminarTarea']))
	{
		$idTarea=$_REQUEST['idTarea'];
		$idPonderacion=$_REQUEST['idPonderacion'];

		$resultado=$objDocenteControlador->obtenerTareas($idTarea);

		$aux=$resultado->fetch_assoc();

		$ruta=$aux['directorio'];

		$resultado=$objDocenteControlador->borrarDirectorio($ruta."/");

		if($resultado)
		{
			$resultado=$objDocenteControlador->eliminarTarea($idTarea);

			if(gettype($resultado)=="string")
			{
				echo "<div class='alert alert-danger'>".$resultado."</div>";
			}
			else
			{
				$resultado=$objDocenteControlador->reasignarPorcentajes($idPonderacion);

				if(gettype($resultado)=="string")
				{
					echo "<div class='alert alert-danger'>".$resultado."</div>";
				}
				else
				{
					echo "<div class='alert alert-success'>Tarea eliminada.</div>";
				}
			}
		}
		else
		{
			echo "<div class='alert alert-danger'>".$resultado."</div>";
		}

	}

	if(isset($_REQUEST['actualizarEstadoTarea']))
	{
		$idTarea=$_POST['idTarea'];
		$estado=$_POST['estado'];

		if($estado==0)
		{
			$resultado=$objDocenteControlador->actualizarEstadoTarea($idTarea, $estado,"","");
		}
		else
		{
			$fechaFin=$_POST['fechaFin'];
			$fechaInicio=$_POST['fechaInicio'];

			$resultado=$objDocenteControlador->actualizarEstadoTarea($idTarea, $estado, $fechaInicio, $fechaFin);
		}

		

		if(gettype($resultado)=="string")
		{
			echo "<div class='alert alert-danger'>".$resultado."</div>";
		}
		else
		{
			if($estado==0)
			{
				echo "<div class='alert alert-success'>Practica cerrada.</div>";
			}
			else
			{
				echo "<div class='alert alert-success'>Practica abierta.</div>";
			}
		}
	}
	
?>
	<div class="container">

		<font style="font-weight: bold;">Practicas guardadas</font><br>

			<select name="modulo" id="moduloMostrar" class="form-control" onchange="mostrarPracticas()">

				<?php

					$resultado=$objDocenteControlador->CargarGrupos();

					if (gettype($resultado)=="string")
					{
						echo "<div class='alert alert-danger'>".$resultado."</div>";
					}
					else
					{
						unset($nombreModulos,$nombreGrupos,$idModulos);
						while($arrayGrupos=$resultado->fetch_array(MYSQLI_ASSOC))
						{
							$nombreModulos[]=$arrayGrupos['nombreModulo'];
							$secciones[]=$arrayGrupos['seccion'];
							$nombreGrupos[]=$arrayGrupos['nombreGrupo'];
							$idModulos[]=$arrayGrupos['idModulo'];
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
			<br>

			<div class="container" id="resultadoPracticas">

				<br><br><br>

			</div>
	</div>

	<div class="container">
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
								$resultado=$objDocenteControlador->CargarGrupos();

								if (gettype($resultado)=="string")
								{
									echo "<div class='alert alert-danger'>".$resultado."</div>";
								}
								else
								{
									unset($nombreModulos);
									while($arrayGrupos=$resultado->fetch_array(MYSQLI_ASSOC))
									{
										$nombreModulos[]=$arrayGrupos['nombreModulo'];
										$secciones[]=$arrayGrupos['seccion'];
										$nombreGrupos[]=$arrayGrupos['nombreGrupo'];
										$idModulos[]=$arrayGrupos['idModulo'];
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
						<button class="btn btn-info" name="guardarPracticas">Guardar practica</button>
					</td>
				</tr>
			</table>
		</form>
	</div>

</div>