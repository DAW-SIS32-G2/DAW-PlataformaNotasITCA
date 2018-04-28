<?php
define("__ROOT__", dirname(dirname(__FILE__)));
require_once(__ROOT__."/core/criptografia.php");



@$hostA=fopen(__ROOT__."host.txt", "r");
@$host=fgets($hostA);
@$userA=fopen(__ROOT__."user.txt", "r");
@$user=fgets($userA);
@$passA=fopen(__ROOT__."pass.txt", "r");
@$pass=fgets($passA);
@$databaseA=fopen(__ROOT__."database.txt", "r");
@$database=fgets($databaseA);

define('HOST',$host);
define('USER',$user);
define('PASS',$pass);
define('DATABASE',$database);

@fclose($hostA);
@fclose($userA);
@fclose($passA);
@fclose($databaseA);

class BaseDatos
{
	private $bd;

	public static function conexion()
	{
		require_once(__ROOT__."/core/criptografia.php");

		$bd = new mysqli(descifrar(HOST),descifrar(USER),descifrar(PASS),descifrar(DATABASE));
		$bd = new mysqli("localhost","usuarioItca","12345","SistemaNotasItca");
		if($bd->connect_error)
		{
			return "La conexión ha fallado: ". $bd->connect_error;
		}
		else {
			return $bd;
		}
	}
}
?>
