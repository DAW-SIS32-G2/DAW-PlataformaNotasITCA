<?php
echo "<br><br><br>";
define("__ROOT__", dirname(__FILE__,4));
require_once(__ROOT__.'/core/funcionesbd.php');

$objDocenteModelo=new docenteModelo();

if (isset($_REQUEST['guardarPonderaciones']))
{
	$idPonderacionesG=$_REQUEST['idPonderaciones'];
	$nombrePonderacionesG=$_REQUEST['nombrePonderaciones'];
	$porcentajePonderacionesG=$_REQUEST['porcentajePonderaciones'];

	$porcentajeTotal=0;
	foreach ($porcentajePonderacionesG as $porcentaje)
	{
		$porcentajeTotal+=$porcentaje;
	}

	if ($porcentajeTotal>100)
	{
		echo "Error. La suma de los porcentajes de las ponderaciones debe ser menor o igual que 100%";
	}
	else
	{
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
			echo "Ponderaciones actualizadas.";
		}
	}


}

if(isset($_REQUEST['GuardarGuia']))
{
	$guia=$_FILES['guia'];

	$idModulo=$_REQUEST['idModulo'];

	$objDocenteControlador=new docenteControlador('docenteModelo');

	$objDocenteControlador->GuardarGuia($guia,$idModulo);
}
?>
 <div class="container" style="padding-top: 65px">

<div class="container">

	<div id="divPracticas" class="oculto">

	</div>

	<div id="divSubirGuias" class="oculto">

	</div>

	<div id="divContra" class="oculto">

	</div>

	<br><br><br>

	<table class="table table-bordered table-light table-hover">

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

			if (gettype($resultado)=="string")
			{
				echo $resultado;
			}
			else
			{
				$res=$resultado;

				$cantidad=$res->num_rows;

				/*Guardando los grupos en un array*/
				unset($idModulo);
				$i=0;
				while($arrayGrupos=$resultado->fetch_array(MYSQLI_ASSOC))
				{
					$idModulo[$i]=$arrayGrupos['idModulo'];
					$nombreGrupos[$i]=$arrayGrupos['nombreGrupo'];
					$seccion[$i]=$arrayGrupos['seccion'];
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
						<?php echo $nombreGrupos[$k].$seccion[$k]."-".$anyoGrupos[$k]; ?>
					</td>

					<td>
						<button class="btn btn-info" onclick="mostrarDiv('SubirGuias','<?= $idModulo[$k]; ?>')">Subir guias</button>
						<br><br>

						<button class="btn btn-info" onclick="mostrarDiv('Practicas','<?= $idModulo[$k]; ?>')">Ver guias</button><br>
						<br>

						<?php


						$resultado=$objDocenteModelo->CargarGrupoIndividual($idModulo[$k]);

		                while($arrayGrupos=$resultado->fetch_array(MYSQLI_ASSOC))
		                {
		                    $siglasModulos=$arrayGrupos['siglas'];
		                    $anyosModulos=$arrayGrupos['anyo'];
		                }



		                $rutaArchivo="Archivos/Guias/".$siglasModulos."-".$anyosModulos."/";
		                $archivo=$siglasModulos."-".$anyosModulos."_";

						 ?>

						<button class="btn btn-info" onclick="comprimirGuias('<?= $rutaArchivo ?>','<?= $archivo ?>')">Descargar<br>todas las<br>guias</button>
					</td>

					<td>
						Grupo Activo<br>
						<button class="btn btn-info" onclick="mostrarDiv('Contra','<?= $idModulo[$k] ?>')">Administrar<br>seguridad</button>
					</td>

					<td>*boton Cerrar inscripciones en el grupo*</td>

					<td>
						<?php echo $nombreModulos[$k]; ?>
					</td>

					<td>

						<form action="<?= urlBase ?>docente/admingrupo" method="post">



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
											$totalPorcentajes=0;
											for ($j=0;$j<$cantidadPonderaciones;$j++)
											{
												?>
													<span>
														<input type="hidden" name="idPonderaciones[]" value="<?= $idPonderaciones[$j] ?>">

														<input type="text" onfocus="this.blur()" name="nombrePonderaciones[]" value="<?= $ponderacionesOrdenadas[$j] ?>" style="width: 60px;">

														<label>
															<input type="number" step="0.1" max="100" min="0" id="<?= $idPonderaciones[$j] ?>" name="porcentajePonderaciones[]" value="<?= $porcentajesOrdenados[$j] ?>" style="width: 50px;"  onkeyup="actualizarTotal(<?= $idModulo[$k] ?>,<?= $idPonderaciones[$j] ?>,<?= $porcentajesOrdenados[$j] ?>)" onchange="actualizarTotal(<?= $idModulo[$k] ?>,<?= $idPonderaciones[$j] ?>,<?= $porcentajesOrdenados[$j] ?>)">%
														</label>
													</span>
													<br>
												<?php
												$totalPorcentajes+=$porcentajesOrdenados[$j];

											}

											?>
												<font>Total:</font>
												<input type="text" id="<?= $idModulo[$k] ?>" name="total" value="<?= $totalPorcentajes ?>" onfocus="this.blur()" style="width: 70px;">%

												<button class="btn btn-info" name="guardarPonderaciones" onclick="return verificarPonderaciones(<?= $idModulo[$k] ?>)">Guardar<br>Ponderaciones</button>

											<?php
										}




									}

								?>



						</form>

				</td>
				<td>*boton que no se para que es*</td>

			</tr>

			<?php }

			}

			 ?>

	</table>
<br><br>
</div>
