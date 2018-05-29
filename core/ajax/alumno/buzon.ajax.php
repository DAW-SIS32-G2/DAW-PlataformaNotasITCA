<?php
session_start();
require_once("core/criptografia.php");
require_once("core/funcionesbd.php");

if(isset($_POST['eliminar']))
{
	$archivo = $_POST['archivo'];
	if(unlink(descifrar($archivo)))
	{
		$objBD = new funcionesBD();
		$sql = "DELETE FROM Archivo WHERE idArchivo = '".$_POST['idarchivo']."'";
		$res = $objBD->ConsultaPersonalizada($sql);
		if($res === TRUE)
		{
			echo 1;
		}
		else
		{
			echo "No se pudo eliminar el registro";
		}
	}
	else
	{
		echo "Ocurrió un error al eliminar el archivo";
	}
}
else if(isset($_POST['subir']))
{
	if(isset($_FILES['subir']) && $_FILES['subir']['name'] != "")
	{
		if($_FILES['subir']['size'] <= $_POST['disponible'])
		{
			$ruta = "Archivos/ArchivosBuzon/".$_SESSION['usuario']."/";
			$nombreArchivo = str_replace(" ","_",$_FILES['subir']['name']);
			$rutaArchivo = $ruta.$nombreArchivo;
			$contador = 2;
			$yaExiste = "";

			$objBD = new funcionesBD();
			$sql = "Select BuzonArchivo.idBuzon FROM BuzonArchivo INNER JOIN Grupo ON Grupo.idGrupo = BuzonArchivo.idGrupo INNER JOIN Usuario ON Usuario.idGrupo = Grupo.idGrupo WHERE Usuario.carnet = '".$_SESSION['usuario']."'";
			$res = $objBD->ConsultaPersonalizada($sql);
			while($fila = mysqli_fetch_assoc($res))
			{
				$idBuzon = $fila['idBuzon'];
			}

			while(file_exists($rutaArchivo))
			{
				$nombreArchivo = "($contador)".$nombreArchivo;
				$rutaArchivo = $ruta.$nombreArchivo;
				$yaExiste = "Ya existe un archivo con nombre \'$nombreArchivo\'. El archivo se guardó como: \'($contador)$nombreArchivo\'";
				$contador++;
			}

			move_uploaded_file($_FILES['subir']['tmp_name'], $rutaArchivo);
			$rutaCifrada = cifrar($rutaArchivo);
			$objBD = new funcionesBD();
			$sql = "INSERT INTO Archivo(nombreArchivo,ruta,carnet,idBuzon) VALUES ('$nombreArchivo','$rutaCifrada','".$_SESSION['usuario']."',$idBuzon)";
			$res = $objBD->ConsultaPersonalizada($sql);

			if(gettype($res) == "boolean" && $res === TRUE)
			{
				$estado = $yaExiste."\\n\\n Archivo subido con éxito";
				?>
		        <script type="text/javascript">
		            swal({
		                text    : "<?= $estado ?>",
		                icon    : "success",
		                button  : "Aceptar"
		            }).then((value)=>{
		            	document.location.reload();
		            })
		        </script>
		        <?php
			}
			else
			{
				unlink($rutaArchivo);
				?>
		        <script type="text/javascript">
		            swal({
		                text    : "<?= $res ?>",
		                icon    : "error",
		                button  : "Aceptar"
		            }).then((value)=>{
		            	document.location.reload();
		            })
		        </script>
		        <?php
			}
		}
		else
		{
			?>
			<script type="text/javascript">
	            swal({
	                text    : "El archivo excede a su espacio disponible, no se puede subir",
	                icon    : "error",
	                button  : "Aceptar"
	            }).then((value)=>{
	            	document.location.reload();
	            })
	        </script>
	        <?php
		}
	}
	else
	{
		?>
		<small style="color: red">Seleccione un archivo para continuar</small>
		<?
	}
}
else if(isset($_POST['compartir']))
{
	$objModelo = new alumnoModelo();
	$objModelo->compartirArchivo($_POST['id']);
}
else if(isset($_POST['generarToken']))
{
	$objModelo = new alumnoModelo();
	$objModelo->tokens("generar",$_POST['idarchivo'],null);
}
else if(isset($_POST['enviarToken']))
{
	$objModelo = new alumnoModelo();
	$objModelo->tokens("enviar",$_POST['token'],$_POST['destinatario']);
}
else if(isset($_POST['renovarToken']))
{
	$objModelo = new alumnoModelo();
	$objModelo->tokens("renovar",$_POST['idarchivo'],null);
}
else if(isset($_POST['eliminarToken']))
{
	$objModelo = new alumnoModelo();
	$objModelo->tokens("eliminar",$_POST['idarchivo'],null);
}
else if(isset($_POST['buscarDest']))
{
	$objModelo = new alumnoModelo();
	$objModelo->buscarDest($_POST['destinatario']);
}
else if(isset($_POST['buscarToken']))
{
	$tamano = strlen($_POST['token']);
	if($tamano < 9 || $tamano > 9)
	{
		echo "<div class=\"alert alert-warning\"><strong>El token no cumple el formato válido</strong><br>Un token válido tiene 9 caracteres de la A a la Z y de 0 a 9</div>";
	}
	else
	{
		$objModelo = new alumnoModelo();
		$objModelo->buscarArchivo($_POST['token']);
	}
}
?>