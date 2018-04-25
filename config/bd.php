<?php
define('HOST','localhost');
define('USER','usuarioItca');
define('PASS','12345');
define('DATABASE','SistemaNotasItca');

class BaseDatos
{
	private $bd;

	public static function conexion()
	{
		$bd = new mysqli(HOST,USER,PASS,DATABASE);
		if($bd->connect_error)
		{
			die("La conexión ha fallado: ". $bd->connect_error);
		}
		else {
			return $bd;
		}
	}
}
?>
