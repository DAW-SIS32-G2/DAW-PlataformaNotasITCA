<?php
session_start();
require_once("core/funcionesbd.php");
require_once("core/criptografia.php");
$idModulo = $_POST['idModulo'];
if(isset($_POST['idModulo']))
{
	if($idModulo != "")
	{
		$sql = "SELECT Tarea.nombreTarea, Tarea.cantidadEjercicios, Tarea.directorio, Tarea.idTarea, Tarea.activo from Tarea INNER JOIN Ponderacion ON Ponderacion.idPonderacion = Tarea.idPonderacion INNER JOIN Modulo ON Modulo.idModulo = Ponderacion.idModulo WHERE Modulo.idModulo = $idModulo";
		$objBD = new funcionesBD();
		$respuesta = $objBD->ConsultaPersonalizada($sql);
		if(mysqli_num_rows($respuesta) > 0)
		{
		?>
		<table class="table table-bordered">
			<thead class="thead-dark">
				<tr>
					<th>Práctica</th>
					<th>Cantidad de Ejercicios</th>
					<th>Subir</th>
					<th>Estado</th>
					<th>Descarga</th>
				</tr>
			</thead>
			<tbody>	
			<?php
			while ($fila = mysqli_fetch_assoc($respuesta))
			{
				echo "
				<tr>
					<td>".$fila['nombreTarea']."</td>
					<td>".$fila['cantidadEjercicios']."</td>";
					if($fila['activo'] == 1)
					{
						$objBD = new funcionesBD();
						$sql = "SELECT ruta from TareaSubidaPor WHERE idTarea='".$fila['idTarea']."' AND carnet = '".$_SESSION['usuario']."'";
						$res = $objBD->ConsultaPersonalizada($sql);
						if(mysqli_num_rows($res) == 1)
						{
							while($f = mysqli_fetch_assoc($res))
							{
								$ruta = cifrar($f['ruta']);
							}
							echo "
								<td>-</td>
								<td>Practica Subida</td>
								<td><button onclick=\"descargar('$ruta')\" class='btn btn-secondary'>Descargar</button></td>
							";
						}
						else
						{
							echo "
								<td><button type='button' class='btn btn-info' data-toggle='modal' data-target='#subirMod' data-idtarea='".$fila['idTarea']."' data-carnet='".$_SESSION['usuario']."' data-practica='".$fila['nombreTarea']."' data-ruta='".$fila['directorio']."'>Subir Práctica</button></td>
								<td>Sin Subir</td>
								<td>No disponible</td>
							";
						}
					}
					else
					{
						echo "
								<td>No se puede subir</td>
								<td>Práctica Cerrada</td>
						";
						$objBD = new funcionesBD();
						$sql = "SELECT ruta from TareaSubidaPor WHERE idTarea='".$fila['idTarea']."' AND carnet = '".$_SESSION['usuario']."'";
						$res = $objBD->ConsultaPersonalizada($sql);
						if(mysqli_num_rows($res) == 1)
						{
							while($f = mysqli_fetch_assoc($res))
							{
								$ruta = $f['ruta'];
							}
							echo "
								<td>*Enlace pa descargar*</td>
							";
						}
						else
						{
							echo "<td>No subió esta práctica</td>";
						}
					}
				echo "
				</tr>
				";
			}
			?>
			</tbody>
		</table>
		<div id="respuesta">
	    	
	    </div>
		<?php
		}
		else
		{
			?>Esta materia no tiene prácticas asignadas<?php
		}
	}
	else
	{
		?>Seleccione una materia para continuar<?php
	}
	?>
	<div class="modal fade" id="subirMod" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
	     aria-hidden="true">
	    <div class="modal-dialog modal-dialog-centered" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="modal-title">Cambio de contraseña</h4>
	                <button type="button" class="close" data-dismiss="modal">&times;</button>
	            </div>
	            <form class="form-group" id="subPractica" method="post" enctype="multipart/form-data">
	            <div class="modal-body">
					<div class="container">
						<div class="form-group row">
							<label class="form-label"for="archivo">Seleccione un archivo</label>
							<input class="form-control"type="file" name="archivo" id="archivo">
							<input name="idtarea" type="hidden" id="idtarea">
							<input name="carnet" type="hidden" id="carnet">
							<input name="ruta" type="hidden" id="ruta">
						</div>
					</div>
	            </div>
	            <div class="modal-footer">
	                <button type="submit" name="subirPrac" class="btn btn-secondary">Subir Práctica</button>
	                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
	            </div>
	            </form>
	        </div>
	    </div>
	</div>
	<script type="text/javascript">
		$(document).on('show.bs.modal',"#subirMod", function(event) {
		  var button = $(event.relatedTarget);
		  var practica = button.data('practica');
		  var idTarea = button.data('idtarea');
		  var carnet = button.data('carnet');
		  var ruta = button.data('ruta');
		  var modal = $(this);

		  modal.find("#idtarea").val(idTarea);
		  modal.find("#carnet").val(carnet);
		  modal.find("#ruta").val(ruta);
		  modal.find(".modal-title").text("Subir Práctica: " + practica);
		});

		$("#subirMod").on('hide.bs.modal', function(event) {
		  $("#archivo").val(null);
		})

		$("#subPractica").on("submit", function(e){
		  e.preventDefault();
		  var f = $(this);

		  var formData = new FormData(document.getElementById("subPractica"));
		  formData.append("subirPrac",1);

		  $.ajax({
		    url     : "ajax/practicas",
		    type    : "post",
		    dataType  : "html",
		    data    : formData,
		    contentType : false,
		    processData : false
		  })
		  .done(function(res){
		    $("#subirMod").modal('hide');
		    swal({
		      text: res,
		      icon: "success",
		      button: "Aceptar"
		    })
		  });
		});
	</script>
<?php
}
else if(isset($_POST['subirPrac']))
{
	$archivo = $_FILES['archivo'];
	$carnet = $_POST['carnet'];
	$ruta = $_POST['ruta'];
	$idTarea = $_POST['idtarea'];
	$objAlumnoModelo = new alumnoModelo();
	$objAlumnoControlador = new alumnoControlador($objAlumnoModelo);
	$objAlumnoControlador->subirArchivo($archivo,$carnet,$idTarea,$ruta);
}
?>