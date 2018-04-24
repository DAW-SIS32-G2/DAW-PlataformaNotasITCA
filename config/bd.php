<?php
define('HOST','localhost');
define('USER','usuarioItca');
define('PASS','12345');
define('DATABASE','SistemaNotasItca');

class BaseDatos
{
	private $pdo;

	public static function conexion()
	{
		try {
			$pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE, USER, PASS);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		} catch (PDOException $e) {
			return 'No se pudo conectar a la BD';
		}
	}
}
?>
