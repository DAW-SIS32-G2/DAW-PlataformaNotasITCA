<?php
echo "<br><br><br>";
define("__ROOT__", dirname(__FILE__,4));
require_once(__ROOT__.'/core/funcionesbd.php');

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

if(isset($_REQUEST['asignarContra']))
{
	$contra=$_REQUEST['contra'];
	$idModulo=$_REQUEST['idModulo'];

	$objDocenteControlador=new docenteControlador('docenteModelo');

	$resultado=$objDocenteControlador->asignarContra($idModulo,$contra);

	if (gettype($resultado)=="string")
	{
		echo '<div class="alert alert-danger">'.$resultado.'</div>';
	}
	else
	{
		echo '<div class="alert alert-success"> Contraseña asignada.</div>';
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
		echo '<div class="alert alert-danger">'.$resultado.'</div>';
	}
	else
	{
		echo '<div class="alert alert-success"> Contraseña modificada.</div>';
	}
}

if(isset($_REQUEST['eliminarContra']))
{
	$idModulo=$_REQUEST['idModulo'];

	$objDocenteControlador=new docenteControlador('docenteModelo');

	$resultado=$objDocenteControlador->eliminarContra($idModulo);

	if (gettype($resultado)=="string")
	{
		echo '<div class="alert alert-danger">'.$resultado.'</div>';
	}
	else
	{
		echo '<div class="alert alert-success"> Contraseña eliminada.</div>';
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
            echo '<div class="alert alert-danger">'.$resultado.'</div>';
        }
        else
        {
        	echo '<div class="alert alert-success"> La ponderacion y sus archivos relacionados han sido eliminados.</div>';
        }
	}
	else
	{
		echo "Error: No se pudo borrar el directorio.";
	}
}

if(isset($_REQUEST['cerrarGrupo']))
{
	$idModulo=$_REQUEST['idModulo'];

	$objDocenteControlador=new docenteControlador('docenteModelo');

	$resultado=$objDocenteControlador->cerrarGrupo($idModulo);


	if(gettype($resultado)=="string")
    {
        echo '<div class="alert alert-danger">'.$resultado.'</div>';
    }
    else
    {
    	echo '<div class="alert alert-success"> El grupo ha sido cerrado.</div>';
    }
}

if(isset($_REQUEST['abrirGrupo']))
{
	$idModulo=$_REQUEST['idModulo'];

	$objDocenteControlador=new docenteControlador('docenteModelo');

	$resultado=$objDocenteControlador->abrirGrupo($idModulo);


	if(gettype($resultado)=="string")
    {
        echo '<div class="alert alert-danger">'.$resultado.'</div>';
    }
    else
    {
    	echo '<div class="alert alert-success"> El grupo ha sido abierto.</div>';
    }
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

	<div id="divPonderaciones" class="oculto">

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

			$resultado=$objDocenteModelo->CargarGruposActivos();

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
						
						<button class="btn btn-info" onclick="mostrarDiv('Contra','<?= $idModulo[$k] ?>')">Administrar<br>seguridad</button>
					</td>

					<td>*boton Cerrar inscripciones en el grupo*</td>

					<td>
						<?php echo $nombreModulos[$k]; ?>
					</td>

					<td>
						<button class="btn btn-info" onclick="mostrarDiv('Ponderaciones','<?= $idModulo[$k] ?>')">Administrar<br>ponderaciones</button>
					</td>
					<td>*boton que no se para que es*</td>

					</tr>

			<?php }

			}

			 ?>

	</table>
<br><br>
</div>
