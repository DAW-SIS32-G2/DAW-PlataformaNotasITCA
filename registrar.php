
<h1>REGISTRO DE DOCENTES</h1>
<form method="post">
	<label for="carnet">Carnet</label><br>
	<input type="text" name="carnet" maxlength="15" required><br>
	<label for="carnet">Password</label><br>
	<input type="password" name="pass" maxlength="20" required><br>
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
		$conn = new funcionesBD();
		$mensaje = $conn->registroDocente($carnet,$pass);

		echo $mensaje;
}
?>
