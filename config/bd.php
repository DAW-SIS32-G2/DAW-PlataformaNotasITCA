<?php
@define("__ROOT__", dirname(dirname(__FILE__)));
require_once(__ROOT__."/core/criptografia.php");



@$hostA=fopen(__ROOT__."/config/host.txt", "r");
@$host=fgets($hostA);
@$userA=fopen(__ROOT__."/config/user.txt", "r");
@$user=fgets($userA);
@$passA=fopen(__ROOT__."/config/pass.txt", "r");
@$pass=fgets($passA);
@$databaseA=fopen(__ROOT__."/config/database.txt", "r");
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
		/*$bd = new mysqli("localhost","usuarioItca","12345","SistemaNotasItca");*/

		if (!$bd->set_charset("utf8"))
		{
			printf("Error cargando el conjunto de caracteres utf8: %s\n", $bd->error);
			exit();
		}

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
