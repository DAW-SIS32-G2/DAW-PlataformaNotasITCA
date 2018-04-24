<?php
require_once "../config/bd.php";
require_once "criptografia.php";
class funcionesBD
{
	private $pdo;

	public function __CONSTRUCT()
	{
		try {
			$this->pdo = BaseDatos::conexion();
		} catch (Exception $e) {
			die($e->getMessage());
		}

	}

	public function registroDocente($carnet,$pass)
	{
		try
		{
			$consulta = "INSERT INTO docente (carnet, clave) VALUES ('$carnet', '$pass')";
			$this->pdo->exec($consulta);
			return "Registrado correctamente";
		}
		catch(PDOException $e)
		{
			return $e->getMessage();
		}

		$conn = null;
	}

	public function logueo($carnet,$pass,$tabla)
	{
		try {
			$consulta = "SELECT carnet, clave FROM $tabla WHERE carnet='$carnet'";
			$stm = $this->pdo->prepare($consulta);
			$stm->execute();
			$count = $stm->rowCount();
			if($count == 1) {
				$row = $stm->fetch(PDO::FETCH_ASSOC);
				if($pass == descifrar($row['clave'])){
					return 1;
				}
				else {
					return 2;
				}
			}
			else {
					return 3;
			}
		} catch (Exception $e) {
				return $e->getMessage();
		}

	}
}
?>
