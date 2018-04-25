
<h1>REGISTRO DE DOCENTES</h1>
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
	
	<label for="tipoUsuario">Tipo de usuario: </label>
	<select name="tipoUsuario">
		<option value="administrador" selected>Administrador</option>
		<option value="docente">Docente</option>
	</select><br>

	<label for="departamento">Departamento: </label>
	<select name="departamento">
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
		$tipoUsuario=$_REQUEST['tipoUsuario'];
		$idDepartamento=$_REQUEST['departamento'];



		$conn = new funcionesBD();
		$mensaje = $conn->registroDocente($carnet,$nombres,$apellidos,$tipoUsuario,$pass,$idDepartamento);

		echo $mensaje;
}
?>
