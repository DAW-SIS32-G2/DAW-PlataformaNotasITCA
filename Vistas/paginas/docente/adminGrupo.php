<?php
echo '<div class="container" style="padding-top: 65px">';
define("__ROOT__", dirname(__FILE__,4));

$objDocenteModelo=new docenteModelo();

if(isset($_REQUEST['guardarPonderaciones']))
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
		?>
		<script type="text/javascript">
			swal({
				text: "Error. La suma de los porcentajes de las ponderaciones debe ser menor o igual que 100%",
				icon: "error",
				button: "Aceptar"
			});
		</script>
		<?php
	}
	else
	{
		$cantidadG=count($idPonderacionesG);

		$cantidadG2=count($nombrePonderacionesG);

		$cantidadG3=count($porcentajePonderacionesG);

		$funcionoActualizacion=False;

		for ($i=0;$i<$cantidadG;$i++)
		{

			$resultado=$objDocenteModelo->actualizarPonderaciones($nombrePonderacionesG[$i],$porcentajePonderacionesG[$i],$idPonderacionesG[$i]);

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
			?>
			<script type="text/javascript">
				swal({
					text: "Ponderaciones actualizadas",
					icon: "success",
					button: "Aceptar"
				});
			</script>
			<?php
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

if(isset($_REQUEST['asignarContra']))
{
	$contra=$_REQUEST['contra'];
	$idModulo=$_REQUEST['idModulo'];

	$objDocenteControlador=new docenteControlador('docenteModelo');

	$resultado=$objDocenteControlador->asignarContra($idModulo,$contra);

	if (gettype($resultado)=="string")
	{
		?>
		<script type="text/javascript">
			swal({
				text: "<?= $resultado ?>",
				icon: "error",
				button: "Aceptar"
			});
		</script>
		<?php
	}
	else
	{
		?>
		<script type="text/javascript">
			swal({
				text: "Se ha asignado la contraseña",
				icon: "success",
				button: "Aceptar"
			});
		</script>
		<?php
	}
}

if(isset($_REQUEST['modificarContra']))
{
	$contra=$_REQUEST['contra'];
	$idModulo=$_REQUEST['idModulo'];

	$objDocenteControlador=new docenteControlador('docenteModelo');

	$resultado=$objDocenteControlador->modificarContra($idModulo,$contra);

	if (gettype($resultado)=="string")
	{
		?>
		<script type="text/javascript">
			swal({
				text: "<?= $resultado ?>",
				icon: "error",
				button: "Aceptar"
			});
		</script>
		<?php
	}
	else
	{
		?>
		<script type="text/javascript">
			swal({
				text: "Se ha actualizado la contraseña",
				icon: "success",
				button: "Aceptar"
			});
		</script>
		<?php
	}
}

if(isset($_REQUEST['eliminarContra']))
{
	$idModulo=$_REQUEST['idModulo'];

	$objDocenteControlador=new docenteControlador('docenteModelo');

	$resultado=$objDocenteControlador->eliminarContra($idModulo);

	if (gettype($resultado)=="string")
	{
		?>
		<script type="text/javascript">
			swal({
				text: "<?= $resultado ?>",
				icon: "error",
				button: "Aceptar"
			});
		</script>
		<?php
	}
	else
	{
		?>
		<script type="text/javascript">
			swal({
				text: "Contraseña eliminada",
				icon: "success",
				button: "Aceptar"
			});
		</script>
		<?php
	}
}

if(isset($_REQUEST['EliminarPonderacion']))
{
	$idPonderacion=$_REQUEST['idPonderacion'];
	$idModulo=$_REQUEST['idModulo'];

	$objDocenteControlador=new docenteControlador('docenteModelo');

	$resultado=$objDocenteControlador->eliminarDirectoriosPonderaciones($idPonderacion,$idModulo);

	if($resultado)
	{
		$resultado=$objDocenteControlador->eliminarPonderacion($idPonderacion);

		if(gettype($resultado)=="string")
        {
            ?>
			<script type="text/javascript">
				swal({
					text: "<?= $resultado ?>",
					icon: "error",
					button: "Aceptar"
				});
			</script>
			<?php
        }
        else
        {
        	?>
			<script type="text/javascript">
				swal({
					text: "La ponderación y sus archivos relacionados ha sido eliminada",
					icon: "error",
					button: "Aceptar"
				});
			</script>
			<?php
        }
	}
	else
	{
		?>
		<script type="text/javascript">
			swal({
				text: "Error. No se pudo borrar el directorio",
				icon: "error",
				button: "Aceptar"
			});
		</script>
		<?php
	}
}

if(isset($_REQUEST['cerrarGrupo']))
{
	$idModulo=$_REQUEST['idModulo'];

	$objDocenteControlador=new docenteControlador('docenteModelo');

	$resultado=$objDocenteControlador->cerrarGrupo($idModulo);


	if(gettype($resultado)=="string")
    {
        ?>
		<script type="text/javascript">
			swal({
				text: "<?= $resultado ?>",
				icon: "error",
				button: "Aceptar"
			});
		</script>
		<?php
    }
    else
    {
    	?>
		<script type="text/javascript">
			swal({
				text: "El grupo ha sido cerrado.",
				icon: "success",
				button: "Aceptar"
			});
		</script>
		<?php
    }
}

if(isset($_REQUEST['abrirGrupo']))
{
	$idModulo=$_REQUEST['idModulo'];

	$objDocenteControlador=new docenteControlador('docenteModelo');

	$resultado=$objDocenteControlador->abrirGrupo($idModulo);


	if(gettype($resultado)=="string")
    {
        ?>
		<script type="text/javascript">
			swal({
				text: "<?= $resultado ?>",
				icon: "error",
				button: "Aceptar"
			});
		</script>
		<?php
    }
    else
    {
    	?>
		<script type="text/javascript">
			swal({
				text: "El grupo ha sido abierto",
				icon: "success",
				button: "Aceptar"
			});
		</script>
		<?php
    }
}


if(isset($_REQUEST['desactivarModulo']))
{
	$idModulo=$_REQUEST['idModulo'];

	$objDocenteControlador=new docenteControlador('docenteModelo');

	$resultado=$objDocenteControlador->desactivarModulo($idModulo);

	if(gettype($resultado)=="string")
    {
        ?>
		<script type="text/javascript">
			swal({
				text: "<?= $resultado ?>",
				icon: "error",
				button: "Aceptar"
			});
		</script>
		<?php
    }
    else
    {
    	?>
		<script type="text/javascript">
			swal({
				text: "El módulo ha sido desactivado",
				icon: "success",
				button: "Aceptar"
			});
		</script>
		<?php
    }
}

if(isset($_REQUEST['agregarPonderacion']))
{
	$nombrePonderacion=$_REQUEST['nombrePonderacion'];
	$porcentajePonderacion=$_REQUEST['porcentajePonderacion'];
	$porcentajeUtilizable=$_REQUEST['porcentajeUtilizable'];
	$idModulo=$_REQUEST['idModulo'];

	if($porcentajePonderacion>$porcentajeUtilizable)
	{
		echo '<div class="alert alert-danger">El porcentaje no puede ser mayor que $porcentajeUtilizable%.</div>';
	}
	else
	{
		$objDocenteControlador=new docenteControlador('docenteModelo');

		$resultado=$objDocenteControlador->agregarPonderacion($idModulo,$nombrePonderacion,$porcentajePonderacion);

		if(gettype($resultado)=="string")
	    {
	        ?>
			<script type="text/javascript">
				swal({
					text: "<?= $resultado ?>",
					icon: "error",
					button: "Aceptar"
				});
			</script>
			<?php
	    }
	    else
	    {
	    	?>
			<script type="text/javascript">
				swal({
					text: "La ponderación ha sido agregada",
					icon: "success",
					button: "Aceptar"
				});
			</script>
			<?php
	    }
	}
}

?>
<!--Divs que son usados como ventanas emergentes-->
	<div id="divPracticas" class="oculto">

	</div>

	<div id="divSubirGuias" class="oculto">

	</div>

	<div id="divContra" class="oculto">

	</div>

	<div id="divPonderaciones" class="oculto">

	</div>

	<div id="divEstadoModulo" class="oculto">

	</div>
<!--Divs que son usados como ventanas emergentes-->

	<table class="table table-bordered table-light table-hover">
	<thead>
		<tr>

			<th scope="col">ID</th>
			<th scope="col">Grupo</th>
			<th scope="col">Guias</th>
			<th scope="col">Estado</th>
			<th scope="col">Modulo</th>
			<th scope="col">Ponderaciones</th>
			<th scope="col">Opciones</th>

		</tr>
	</thead>
	<tbody>
		<?php

			$resultado=$objDocenteModelo->CargarGruposActivos();

			if (gettype($resultado)=="string")
			{
				echo $resultado;
			}
			else
			{
				$res=$resultado;

				$cantidad=$res->num_rows;

				if($cantidad==0)
				{
					echo '<tr><td colspan="7" scope="row"><div class="alert alert-info">No hay modulos activos o registrados.</div></td></tr></tbody></table>';
				}
				else
				{
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

						<td scope="row">
							<?php echo $idModulo[$k]; ?>
						</td>

						<td>
							<?= $nombreGrupos[$k].$seccion[$k]."-".$anyoGrupos[$k] ?>
						</td>

						<td>
							<!-- <button class="btn btn-info" onclick="mostrarDiv('SubirGuias','<?= $idModulo[$k]; ?>')">Subir guias</button> -->
							<button class="btn btn-info" data-toggle="modal" data-target="#subirModal"  data-mod="<?= $idModulo[$k] ?>">Subir Guías</button>
							<br><br>

							<!-- <button class="btn btn-info" onclick="mostrarDiv('Practicas','<?= $idModulo[$k]; ?>')">Ver guias</button><br> -->
							<button class="btn btn-info" data-toggle="modal" data-target="#verGuiasModal"  data-mod="<?= $idModulo[$k] ?>">Ver Guías</button>
							<br>
							<br>

							<?php


							$resultado=$objDocenteModelo->CargarGrupoIndividual($idModulo[$k]);

			                while($arrayGrupos=$resultado->fetch_array(MYSQLI_ASSOC))
			                {
			                    $siglasModulos=$arrayGrupos['siglas'];
			                    $anyosModulos=$arrayGrupos['anyo'];
			                }



			                $rutaArchivoGuias="Archivos/Guias/".$siglasModulos."-".$anyosModulos."/";
			                $rutaArchivoPracticas="Archivos/Practicas/".$siglasModulos."-".$anyosModulos."/";
			                $archivo=$siglasModulos."-".$anyosModulos."_";

			                $aux=cifrar($rutaArchivoGuias);
			                $rutaArchivoGuias=$aux;

			                $aux=cifrar($rutaArchivoPracticas);
			                $rutaArchivoPracticas=$aux;

			                $aux=cifrar($archivo);
			                $archivo=$aux;

							 ?>

							<button class="btn btn-info" onclick="comprimirGuias('<?= $rutaArchivoGuias ?>','<?= $archivo ?>','<?= $rutaArchivoPracticas ?>')">Descargar<br>todas las<br>guias</button>
						</td>

						<td>
							<?php 

								$objDocenteControlador=new docenteControlador('docenteModelo');

								$resultado=$objDocenteControlador->CargarGrupoIndividual($idModulo[$k]);

								$estadoModulo=$resultado->fetch_assoc();

								if($estadoModulo['estado']==0)
								{
									?>
										Grupo Cerrado<br>
										<form action="" method="post">
											<input type="hidden" name="idModulo" value="<?= $idModulo[$k] ?>">
											<button class="btn btn-info" name="abrirGrupo">Abrir grupo</button>
										</form><br>
									<?php
								}
								elseif($estadoModulo['estado']==1)
								{
									?>
										Grupo Abierto<br>
										<form action="" method="post">
											<input type="hidden" name="idModulo" value="<?= $idModulo[$k] ?>">
											<button class="btn btn-info" name="cerrarGrupo">Cerrar grupo</button>
										</form><br>
									<?php
								}

							?>
							
							<!-- <button class="btn btn-info" onclick="mostrarDiv('Contra','<?= $idModulo[$k] ?>')">Administrar<br>seguridad</button> -->
							<button class="btn btn-info" data-toggle="modal" data-target="#seguridadModal" data-mod="<?= $idModulo[$k] ?>">Administrar<br>Seguridad</button>
						</td>

						<td>
							<?php echo $nombreModulos[$k]; ?>
						</td>

						<td>
							<!-- <button class="btn btn-info" onclick="mostrarDiv('Ponderaciones','<?= $idModulo[$k] ?>')">Administrar<br>ponderaciones</button> -->
							<button class="btn btn-info" data-toggle="modal" data-target="#ponderacionesModal" data-mod="<?= $idModulo[$k] ?>">Administrar<br>Ponderaciones</button>
						</td>

						<td>
							<!-- <button class="btn btn-info" onclick="mostrarDiv('EstadoModulo','<?= $idModulo[$k] ?>')">Desactivar<br>modulo</button> -->
							<button class="btn btn-info" data-toggle="modal" data-target="#administracionModal" data-mod="<?= $idModulo[$k] ?>">Desactivar<br>modulo</button>
						</td>

						</tr>

					<?php
					}
				}

				

			}

			 ?>
	</tbody>
	</table>
<br><br>
</div>
<!-- Modal para subir Archivos -->
<div class="modal fade" id="subirModal" tabindex="-1" role="dialog" aria-labelledby="modal de eliminacion" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h5 class="modal-title" id="exampleModalLabel">Subir Guías</h5>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	  <form method="post" enctype="multipart/form-data" class="form-group">
	    <div class="modal-body">
	    	<input type="hidden" name="MAX_FILE_SIZE" value="62914560">
	    	<div class="container">
	    		<div class="form-group row">
	    			<label class="form-label">Archivo:</label>
					<input class="form-control" type="file" name="guia">
	    		</div>
	    	</div>
			<input type="hidden" name="idModulo" id="modulo">
	    </div>
	    <div class="modal-footer">
	      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
		  <input type="submit" class="btn btn-primary" value="Subir Guía al Módulo" name="GuardarGuia">
	    </div>
	  </form>
	  </div>
	</div>
</div>
<!-- Modal para ver Archivos -->
<div class="modal fade" id="verGuiasModal" tabindex="-1" role="dialog" aria-labelledby="modal de eliminacion" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h5 class="modal-title" id="exampleModalLabel">Subir Guías</h5>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
	    	<div class="container">
	    		<div id="practicas"></div>
	    	</div>
	    </div>
	    <div class="modal-footer">
	      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
	    </div>
	  </div>
	</div>
</div>

<!-- Modal para ver lo de las claves -->
<div class="modal fade" id="seguridadModal" tabindex="-1" role="dialog" aria-labelledby="modal de eliminacion" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h5 class="modal-title" id="exampleModalLabel">Administrar Seguridad</h5>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
	    	<div class="container">
	    		<div id="seguridadMod"></div>
	    	</div>
	    </div>
	    <div class="modal-footer">
	      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
	    </div>
	  </div>
	</div>
</div>

<!-- Modal para administrar Seguridad -->
<div class="modal fade" id="adminSeguridadModal" tabindex="-1" role="dialog" aria-labelledby="modal de eliminacion" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h5 class="modal-title" id="exampleModalLabel">Administrar Seguridad</h5>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
	    	<div class="container">
	    		<div id="adminSeguridad"></div>
	    	</div>
	    </div>
	    <div class="modal-footer">
	      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
	    </div>
	  </div>
	</div>
</div>

<!-- Modal para ponderaciones -->
<div class="modal fade" id="ponderacionesModal" tabindex="-1" role="dialog" aria-labelledby="modal de eliminacion" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h5 class="modal-title" id="exampleModalLabel">Administrar Ponderaciones</h5>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
	    	<div class="container">
	    		<div id="adminPonderaciones"></div>
	    	</div>
	    </div>
	    <div class="modal-footer">
	      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
	    </div>
	  </div>
	</div>
</div>

<!-- Modal para administracion de módulo -->
<div class="modal fade" id="administracionModal" tabindex="-1" role="dialog" aria-labelledby="modal de eliminacion" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	  <div class="modal-content">
	    <div class="modal-header">
	      <h5 class="modal-title" id="exampleModalLabel">Administrar Módulo</h5>
	      <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
	        <span aria-hidden="true">&times;</span>
	      </button>
	    </div>
	    <div class="modal-body">
	    	<div class="container">
	    		<div id="adminModulo"></div>
	    	</div>
	    </div>
	    <div class="modal-footer">
	      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
	    </div>
	  </div>
	</div>
</div>