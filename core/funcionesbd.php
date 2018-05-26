<?php
@define("__ROOT__", dirname(dirname(__FILE__)));
require_once(__ROOT__ . "/config/bd.php");
require_once "criptografia.php";

/**
 * Class funcionesBD
 * Esta clase se encarga de almacenar todas las funciones de conexión, registro, actualización, eliminación
 * y consultas con la Base de Datos.
 * El nombre de la base de Datos es SistemaNotasItca.
 * El usuario Utilizado es usuarioItca y la contraseña requerida es 12345
 */
class funcionesBD
{
    private $bd;

    public function __CONSTRUCT()
    {
        try {
            $this->bd = BaseDatos::conexion();
            if (gettype($this->bd) == "string") {
                echo "<br><br><br>Error en la conexión: " . utf8_encode($this->bd);
                exit();
                /**
                 * Se crea la conexión con la BD
                 */
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }

    /**
     * Esta función si bien pertenece al sistema de administracion para nuestro caso
     * se incluyo para facilitar un poco el registro de docentes de prueba
     *
     * @param $carnet : Numero de carnet que utilizara el docente
     * @param $nombres : Nombres del docente
     * @param $apellidos : Apellidos del docente
     * @param $tipoUsuario : Tipo de privilegios que tendra el docente [Administrador || Docente]
     * @param $pass : Contraseña del docente
     * @param $idDepartamento : Identificador del departamento al que pertenece el docente
     * @return string : Resultado del Registro
     */
    public function registroDocente($carnet, $nombres, $apellidos, $tipoUsuario, $pass, $idDepartamento)
    {
        $consulta = "INSERT into Docente(carnet,nombres,apellidos,tipoUsuario,contra,idDepartamento) VALUES ('$carnet', '$nombres', '$apellidos', '$tipoUsuario', '$pass', $idDepartamento)";
        if ($this->bd->query($consulta)) {
            //Cerrando conexión
            $this->bd->close();
            return "Docente Registrado correctamente";
        } else {
            $error = $this->bd->error;
            //Cerrando conexión
            $this->bd->close();
            return "Error en la consulta: " . $error;
        }
    }

    /**
     * Esta función si bien pertenece al sistema de administracion para nuestro caso
     * se incluyo para facilitar un poco el registro de alumnos de prueba
     *
     * @param $carnet : Numero de carnet que utilizara el alumno
     * @param $nombres : Nombres del alumno
     * @param $apellidos : Apellidos
     * @param $contra : Contraseña a utilizar por el alumno, por defecto es 'itca' (sin comillas)
     * @param $anyo : Año de inscripción del alumno
     * @param $modif : Con este campo se verifica si el alumno ya ingreso en alguna ocacion al sistema
     *                  (Para el cambio obligatorio de contraseña)
     * @param $idCarrera : Identificador de la carrera a la que pertence el alumno
     * @param $idGrupo : Identificador del grupo al que pertenece el alumno
     * @param $carnetDoc :
     * @return string : Retorna el resultado de la inserción
     */
    public function registroAlumno($carnet, $nombres, $apellidos, $contra, $anyo, $modif, $idCarrera, $idGrupo, $carnetDoc)
    {
        $idDoc = $this->bd->query("SELECT idDocente FROM docente WHERE carnet = '$carnetDoc'");
        while($fila = mysqli_fetch_assoc($idDoc))
        {
            $idDocente = $fila['idDocente'];
        }

        $res = $this->bd->query("SELECT * FROM usuario WHERE carnet = '$carnet'");

        if (mysqli_num_rows($res) == 0) {
            $consulta = "INSERT INTO Usuario(carnet,nombres,apellidos,contra,anyoIngreso,permiteModificacion,idCarrera,idGrupo) VALUES ('$carnet','$nombres','$apellidos','$contra',$anyo,$modif,$idCarrera,$idGrupo)";
            if ($this->bd->query($consulta)) {
                $consulta = "INSERT INTO InsercionDocente(carnetDoc,CarnetAlumno,idDocente) VALUES ('$carnetDoc','$carnet','$idDocente')";
                if ($this->bd->query($consulta)) {
                    //Cerrando conexión
                    $this->bd->close();
                    return "Alumno Registrado correctamente";
                } else {
                    $error = $this->bd->error;
                    //Cerrando conexión
                    $this->bd->close();
                    return "Error en la consulta: " . $error;
                }
            } else {
                $error = $this->bd->error;
                //Cerrando conexión
                $this->bd->close();
                return "Error en la consulta: " . $error;
            }
        } else {
            return "No se puede registrar, el alumno tiene un carnet que ya está registrado";
        }
    }

    /**
     * Esta es la funcion que se utiliza cada vez que se inicia sesión ya sea desde el lado alumno o docente
     *
     * @param $carnet : Número de carnet de identificación
     * @param $pass : Contraseña de acceso al numero de carnet anterior
     * @param $tabla : [Docente || Usuario]
     * @return int :
     */
    public function logueo($carnet, $pass, $tabla)
    {
        $sql = "SELECT carnet, contra FROM $tabla WHERE carnet='$carnet'";
        $resultado = $this->bd->query($sql);


        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            if ($pass == descifrar($fila['contra'])) {
                //Cerrando conexión
                $this->bd->close();
                return 1;
            } else {
                //Cerrando conexión
                $this->bd->close();
                return 2;
            }
        } else {
            //Cerrando conexión
            $this->bd->close();
            return 3;
        }
    }

    /**
     * Función de inserción de datos en la base de datos.
     *
     * @param $tabla : Tabla de destino de los datos
     * @param $campos : Campos afectados
     * @param $valores : Datos a insertar
     * @return bool|mysqli_result|string : Resultado de la inserción
     */
    public function insertar($tabla, $campos, $valores)
    {
        $sql = "INSERT INTO $tabla($campos) VALUES ($valores)";
        if ($resultado = $this->bd->query($sql)) {
            //Cerrando conexión
            $this->bd->close();
            return $resultado;
        } else {
            $error = $this->bd->error;
            //Cerrando conexión
            $this->bd->close();
            return "Error al insertar el registro: " . $error;
        }
    }

    /**
     * Este prcedimiento se utiliza para seleccionar datos generales o filtrados de una tabla.
     * El parametro 'condicion' es opcional caso de no ser necesario puede dejarse vacio.
     *
     * @param $tabla : tabla de origen de los datos
     * @param $campos : campos que se desea consultar
     * @param $condicion : (Opcional) Filtro o condicion de la consulta
     */
    public function selectTabla($tabla, $campos, $condicion)
    {
        if ($condicion != "") {
            $sql = "SELECT $campos FROM $tabla WHERE $condicion";
        } else {
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
                while ($enc = mysqli_fetch_field($res)) {
                    echo "<th>" . $enc->name . "</th>";
                }
                ?>
            </tr>
            </thead>
            <!-- Ahora imprimimos el cuerpo -->
            <tbody>
            <?php
            for ($i = 0; $i < $ncampos; $i++) {
                while ($fila = mysqli_fetch_row($res)) {
                    echo "<tr>";
                    for ($col = 0; $col < $ncampos; $col++) {
                        echo "<td>" . $fila[$col] . "</td>";
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


    /**
     * Funcion que se encarga de actualizar un solo registro en la BD
     *
     * @param $tabla : Tabla de origen de los datos
     * @param $campo : Campo afectado
     * @param $valor : Nuevo valor
     * @param $condicion : Filtro o condicion para actualizar el registro
     * @return bool|mysqli_result|string : Resultado de la consulta
     */
    public function ActualizarRegistro($tabla, $campo, $valor, $condicion)
    {
        $resultado = $this->bd->query("UPDATE $tabla set $campo='$valor' where $condicion");
        if ($resultado) {
            //Cerrando conexión
            $this->bd->close();
            return $resultado;
        } else {
            $error = $this->bd->error;
            //Cerrando conexión
            $this->bd->close();
            return "Error en la actualizacion de campo: " . $error;
        }
    }

    /**
     * Función que se encarga de consultar todos los campos una tabla, esta consulta puede ser filtrada o no en otras
     * palabras, el parametro condicion es opcional.
     *
     * @param $tabla
     * @param $condicion
     * @return bool|mysqli_result|string
     */
    public function ConsultaGeneral($tabla, $condicion)
    {
        if ($condicion != "") {
            $resultado = $this->bd->query("select * from $tabla where $condicion");
        } else {
            $resultado = $this->bd->query("select * from $tabla");
        }

        if ($resultado) {
            //Cerrando conexión
            $this->bd->close();
            return $resultado;
        } else {
            $error = $this->bd->error;
            //Cerrando conexión
            $this->bd->close();
            return "Error en la consulta: " . $error;
        }

    }

    /**
     * Función que ejecuta una consulta personalizada.
     *
     * @param $sql
     * @return bool|mysqli_result|string
     */
    public function ConsultaPersonalizada($sql)
    {
        $resultado = $this->bd->query($sql);

        if ($resultado) {
            //Cerrando conexión
            $this->bd->close();
            return $resultado;
        } else {
            $error = $this->bd->error;
            //Cerrando conexión
            $this->bd->close();
            return "Error en la consulta: " . $error;
        }
    }

    /**
     * Función
     * @param $tabla
     * @param $campos
     * @param $condicion
     * @return bool|mysqli_result
     */
    public function SelectArray($tabla, $campos, $condicion)
    {
        if ($condicion != "") {
            $sql = "SELECT $campos FROM $tabla WHERE $condicion";
        } else {
            $sql = "SELECT $campos FROM $tabla";
        }
        //Hacemos la consulta
        $res = $this->bd->query($sql);
        //Cerrando conexión
        $this->bd->close();

        return $res;
    }

    public function EliminarRegistro($tabla,$condicion)
	{
		if($condicion!="")
		{
			$resultado=$this->bd->query("DELETE from $tabla where $condicion");
		}
		else
		{
			$resultado="Error. Por seguridad no puede hacer un DELETE sin una condición.";
		}

		if($resultado)
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



}

?>
