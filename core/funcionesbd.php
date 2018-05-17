<?php
@define("__ROOT__", dirname(dirname(__FILE__)));
require_once(__ROOT__."/config/bd.php");
require_once "criptografia.php";
class funcionesBD
{
	private $bd;
	public function __CONSTRUCT()
	{
		try
		{
			$this->bd = BaseDatos::conexion();
			if (gettype($this->bd) == "string")
			{
				echo "<br><br><br>Error en la conexión: ".utf8_encode($this->bd);
				exit();
			}
		}
		catch (Exception $e) {
			die($e->getMessage());
		}

	}
	//Funcion para registro de un docente nuevo SOLO para inicio de sesión
	public function registroDocente($carnet,$nombres,$apellidos,$tipoUsuario,$pass,$idDepartamento)
	{
		$consulta = "INSERT into Docente(carnet,nombres,apellidos,tipoUsuario,contra,idDepartamento) VALUES ('$carnet', '$nombres', '$apellidos', '$tipoUsuario', '$pass', $idDepartamento)";
		if($this->bd->query($consulta))
		{
			//Cerrando conexión
			$this->bd->close();
			return "Docente Registrado correctamente";
		}
		else
		{
			$error=$this->bd->error;
			//Cerrando conexión
			$this->bd->close();
			return "Error en la consulta: ". $error;
		}
	}

	//Funcion para registro de alumnos elemental
	public function registroAlumno($carnet,$nombres,$apellidos,$contra,$anyo,$modif,$idCarrera,$idGrupo)
	{
		$consulta = "INSERT INTO Usuario(carnet,nombres,apellidos,contra,anyoIngreso,permiteModificacion,idCarrera,idGrupo) VALUES ('$carnet','$nombres','$apellidos','$contra',$anyo,$modif,$idCarrera,$idGrupo)";
		if($this->bd->query($consulta))
		{
			//Cerrando conexión
			$this->bd->close();
			return "Alumno Registrado correctamente";
		}
		else
		{
			$error=$this->bd->error;
			//Cerrando conexión
			$this->bd->close();
			return "Error en la consulta: ". $error;
		}
	}
	//Función de inicio de sesión
	public function logueo($carnet,$pass,$tabla)
	{
		$sql = "SELECT carnet, contra FROM $tabla WHERE carnet='$carnet'";
		$resultado = $this->bd->query($sql);


		if($resultado->num_rows > 0)
		{
			$fila = $resultado->fetch_assoc();
			if($pass == descifrar($fila['contra']))
			{
				//Cerrando conexión
				$this->bd->close();
				return 1;
			}
			else
			{
				//Cerrando conexión
				$this->bd->close();
				return 2;
			}
		}
		else
		{
			//Cerrando conexión
			$this->bd->close();
			return 3;
		}
	}

	//Funcion para inserción de registros
	public function insertar($tabla,$campos,$valores)
	{
		$sql = "INSERT INTO $tabla($campos) VALUES ($valores)";
		if($this->bd->query($sql) === TRUE)
		{
			//Cerrando conexión
			$this->bd->close();
			return "Registro Insertado Correctamente";
		}
		else
		{
			$error=$this->bd->error;
			//Cerrando conexión
			$this->bd->close();
			return "Error al insertar el registro: ".$error;
		}
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
			//Cerrando conexión
			$this->bd->close();
	}


	//Funcion para actualizar registros
	public function ActualizarRegistro($tabla,$campo,$valor,$condicion)
	{
		$resultado=$this->bd->query("UPDATE $tabla set $campo=$valor where $condicion");


		if ($resultado)
		{
			//Cerrando conexión
			$this->bd->close();
			return $resultado;
		}
		else
		{
			$error=$this->bd->error;
			//Cerrando conexión
			$this->bd->close();
			return "Error en la actualizacion de campo: ". $error;
		}
	}

	//Funcion de consulta general
	public function ConsultaGeneral($tabla,$condicion)
	{
		if ($condicion!="")
		{
			$resultado=$this->bd->query("SELECT * from $tabla where $condicion");
		}
		else
		{
			$resultado=$this->bd->query("SELECT * from $tabla");
		}

		if ($resultado)
		{
			//Cerrando conexión
			$this->bd->close();
			return $resultado;
		}
		else
		{
			$error=$this->bd->error;
			//Cerrando conexión
			$this->bd->close();
			return "Error en la consulta: ". $error;
		}

	}

	public function ConsultaPersonalizada($sql)
	{
		$resultado=$this->bd->query($sql);

		if ($resultado)
		{
			//Cerrando conexión
			$this->bd->close();
			return $resultado;
		}
		else
		{
			$error=$resultado->error;
			//Cerrando conexión
			$this->bd->close();
			return "Error en la consulta: ". $error;
		}
	}

	//Select 	que devuelve un array
	public function SelectArray($tabla,$campos,$condicion)
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
		//Cerrando conexión
		$this->bd->close();

		return $res;
	}


}
?>
