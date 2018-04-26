<h1>REGISTRO DE ALUMNO</h1>
<form method="post">
	<label for="carnet">Carnet</label><br>
	<input type="text" name="carnet" maxlength="15" required><br>
	<label for="carnet">Password</label><br>
	<input type="password" name="pass" maxlength="20" required><br>

	<!--Campos extra por la actualizacion de la DB-->

	<label for="nombres">Nombres:
		<input type="text" name="nombres" maxlength="50" required>
	</label><br>

	<label for="apellidos">Apellidos:
		<input type="text" name="apellidos" maxlength="50" required>
	</label><br>

<label for="carrera">Carrera: </label>
	<select name="carrera">
		<option value="2" selected>Sistemas</option>
	</select><br>

	<label for="grupo">Grupo: </label>
		<select name="grupo">
			<option value="1" selected>Sistemas</option>
		</select><br>

	<input type="submit" name="registrar" value="registrar">
</form>
<?php
if(isset($_POST['registrar']))
{
		require_once("core/criptografia.php");
		require_once("core/funcionesbd.php");

		//datos a insertar
		$carnet = $_POST['carnet'];
		$pass = cifrar($_POST['pass']);
		$nombres=$_REQUEST['nombres'];
		$apellidos=$_REQUEST['apellidos'];
		$carrera = $_REQUEST['carrera'];
		$grupo = $_REQUEST['grupo'];



		$conn = new funcionesBD();
		$mensaje = $conn->registroAlumno($carnet,$nombres,$apellidos,$pass,2018,TRUE,$carrera,$grupo);

		echo $mensaje;
}
?>
