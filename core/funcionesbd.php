<?php
define("__ROOT__", dirname(dirname(__FILE__)));
require_once(__ROOT__."/config/bd.php");
require_once "criptografia.php";
class funcionesBD
{
	private $bd;
	public function __CONSTRUCT()
	{
		try {
			$this->bd = BaseDatos::conexion();
		} catch (Exception $e) {
			die($e->getMessage());
		}

	}
	//Funcion para registro de un docente nuevo SOLO para inicio de sesión
	public function registroDocente($carnet,$pass)
	{
		$consulta = "INSERT INTO docente (carnet, clave) VALUES ('$carnet', '$pass')";
		if($this->bd->query($consulta) === TRUE)
		{
			echo "Docente Registrado correctamente";
		}
		$this->bd->close();
	}

	//Función de inicio de sesión
	public function logueo($carnet,$pass,$tabla)
	{
		$sql = "SELECT carnet, clave FROM $tabla WHERE carnet='$carnet'";
		$resultado = $this->bd->query($sql);

		if($resultado->num_rows > 0)
		{
			$fila = $resultado->fetch_assoc();
			if($pass == descifrar($fila['clave']))
			{
				return 1;
			}
			else
			{
				return 2;
			}
		}
		else
		{
			return 3;
		}
	}

	//Funcion para inserción de registros
	public function insertar($tabla,$campos,$valores)
	{
		$sql = "INSERT INTO $tabla($campos) VALUES $valores";
		if($this->bd->query($sql) === TRUE)
		{
			 echo "Registro Insertado Correctamente";
		}
		$this->bd->close();
	}

	//Funcion para seleccionar datos y mostrarlos en una tabla
	//Para esta funcion, se puede pasar una condicion vacía para una consulta general, o especificarse para una filtrada
	public function selectTabla($tabla,$campos,$condicion)
	{
		if($condicion != "")
		{
			$sql = "SELECT $campos FROM $tabla WHERE $condicion";
		}
		else
		{
			$sql = "SELECT $campos FROM $tabla";
		}
		//Hacemos la consulta
		$res = $this->bd->query($sql);
		$ncampos = mysqli_num_fields($res);
		//Mostraremos la tabla

		//Primero los encabezados
		?>
			<table class="table table-bordered">
				<thead class="thead-dark">
					<tr>
						<?php
							while($enc = mysqli_fetch_field($res))
							{
								echo "<th>".$enc->name."</th>";
							}
						?>
					</tr>
				</thead>
				<!-- Ahora imprimimos el cuerpo -->
				<tbody>
						<?php
						for($i=0;$i<$ncampos;$i++)
						{
							while($fila = mysqli_fetch_row($res))
							{
								echo "<tr>";
								for($col=0;$col<$ncampos;$col++)
								{
									echo "<td>".$fila[$col]."</td>";
								}
								echo "</tr>";
							}
						}
						?>
				</tbody>
			</table>
			<?php
	}

	//Funcion para actualizar registros
	
}
?>
