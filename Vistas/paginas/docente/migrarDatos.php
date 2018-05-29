<?php
/*Condiciones para el correcto funcionamiento del script de migracion*/
/*


Especialmente para las tablas alumno y docente los carnet's no se pueden repetir por ningun motivo y todos los idGrupos deben corresponder a un grupo si no es asi el script fallara.


IMPORTANTE: La base de datos en donde se guardara la copia debe estar vacia totalmente por que este script la borrara

Las tablas con los respectivos campos que se mostraran a continuacion deben existir y no ser nulos. Ya que de no ser asi el script no podra migrar correctamente. Además los campos deben estar llenados correctamente (si un grupo tiene id 2 el usuario perteneciente a ese grupo debe tener id 2) ya que cualquier anomalia en los identificadores causara el fallo del script.


tabla departamento: id_departamento,departamento.

tabla carrera: idcarrera,carrera,iddepto.

tabla grupo: id_grupo,grupo,tipo,year.

tabla alumno: carnet,nombre,apellido,telefono,jornada,sexo,foto,email,clave,yearingreso,id_carrera,idgrupo.

tabla docente: nom_usuario,ape_usuario,esadministrador,celular,telcasa,email,clave,id_depto.

tabla materia:  nombreModulo,siglas,tipoModulo,anyo,activo,estado,protegidoPorContra,idHorario,carnet

Con respecto a la tabla materia se necesita que se le hagan modificaciones para que funcione con el script de migracion.

Se necesita que se agreguen los siguientes campos:

- el campo "siglas" del modulo o materia, ejemplo: "DAW-SIS32B-2018" .
- el campo "tipoModulo". ejemplo: practico o teorico
- el campo "anyo"

*/
define("__ROOT__", dirname(__FILE__,4));
require_once(__ROOT__.'/controladores/docente.controlador.php');
$objDocenteControlador=new DocenteControlador('DocenteModelo'); 
?>
<div class="container" style="padding-top: 65px">
	<form action="" method="post">
		<font>Migrar datos: </font><br>
		<button class="btn btn-info" name="dbItcaToSistemaItca">De DB_itca hacia sistemaNotasItca</button><br><br>
	</form>

<?php 
if(isset($_POST['dbItcaToSistemaItca']))
{
	ini_set('max_execution_time', 600); //600 seconds = 10 minutes

	$tablas1=['departamento','carrera','grupo','alumno','docente','horario','materia'];

	$tablas2=['Departamento','Carrera','Grupo','Usuario','Docente','Horario','Modulo'];

	$campos1=['id_departamento,departamento','idcarrera,carrera,iddepto','id_grupo,grupo,tipo,year','carnet,nombre,apellido,telefono,jornada,sexo,foto,email,clave,yearingreso,id_carrera,idgrupo','carnet,nom_usuario,ape_usuario,esadministrador,celular,telcasa,email,clave,id_depto','id_horario','materia,id_materia'];

	$campos2=['idDepartamento,nombreDepartamento','idCarrera,nombreCarrera,idDepartamento','idGrupo,nombreGrupo,seccion,anyo','carnet,nombres,apellidos,telefonoMovil,jornada,sexo,foto,email,contra,anyoIngreso,permiteModificacion,idCarrera,idGrupo','carnet,nombres,apellidos,tipoUsuario,telefonoMovil,telefonoCasa,email,contra,idDepartamento','','nombreModulo,siglas,tipoModulo,anyo,activo,estado,protegidoPorContra,idHorario,carnet'];

	$i=0;
	$conteoErrores=0;
	foreach($tablas1 as $tabla)
	{
		$resultado=$objDocenteControlador->migrarDbToSistema("SELECT $campos1[$i] from $tabla",1);

		if(gettype($resultado)=="string")
		{
			echo "Error: ".$resultado;
		}
		elseif($resultado)
		{
			while($aux=$resultado->fetch_assoc())
			{

				if($tabla=="departamento")
				{
					$valores="'".$aux['id_departamento']."','".$aux['departamento']."'";
					$resultado2=$objDocenteControlador->migrarDbToSistema("INSERT into $tablas2[$i] ($campos2[$i]) values ($valores)",0);

					if(gettype($resultado2)=="string")
					{
						$conteoErrores++;
					}
				}
				elseif($tabla=="carrera")
				{
					$valores="'".$aux['idcarrera']."','".$aux['carrera']."','".$aux['iddepto']."'";
					$resultado2=$objDocenteControlador->migrarDbToSistema("INSERT into $tablas2[$i] ($campos2[$i]) values ($valores)",0);

					if(gettype($resultado2)=="string")
					{
						$conteoErrores++;
					}
				}
				elseif($tabla=="grupo")
				{
					$valores="'".$aux['id_grupo']."','".$aux['grupo']."','".$aux['tipo']."','".$aux['year']."'";
					$resultado2=$objDocenteControlador->migrarDbToSistema("INSERT into $tablas2[$i] ($campos2[$i]) values ($valores)",0);

					if(gettype($resultado2)=="string")
					{
						$conteoErrores++;
					}
				}
				elseif($tabla=="alumno")
				{
					if($aux['carnet']=="" or $aux['nombre']=="" or $aux['apellido']=="" or $aux['clave']=="" or $aux['yearingreso']=="" or $aux['id_carrera']=="" or $aux['idgrupo']=="")
					{
						$conteoErrores++;
					}
					else
					{
						$resultado3=$objDocenteControlador->migrarDbToSistema("SELECT * from grupo where id_grupo=".$aux['idgrupo'],1);
						$resultado4=$objDocenteControlador->migrarDbToSistema("SELECT * from Usuario where carnet=".$aux['carnet'],0);

						if($resultado3->num_rows == 0)
						{
							$conteoErrores++;
						}
						elseif($resultado4->num_rows > 0)
						{
							$conteoErrores++;
						}
						else
						{
							$valores="'".$aux['carnet']."','".$aux['nombre']."','".$aux['apellido']."','".$aux['telefono']."','".$aux['jornada']."','".$aux['sexo']."','".$aux['foto']."','".$aux['email']."','".$aux['clave']."','".$aux['yearingreso']."','1','".$aux['id_carrera']."','".$aux['idgrupo']."'";
							$resultado2=$objDocenteControlador->migrarDbToSistema("INSERT into $tablas2[$i] ($campos2[$i]) values ($valores)",0);

							if(gettype($resultado2)=="string")
							{
								$conteoErrores++;
							}
						}
					}
				}
				elseif($tabla=="docente")
				{
					if($aux['carnet']=="" or $aux['nom_usuario']=="" or $aux['ape_usuario']=="" or $aux['esadministrador']=="" or $aux['clave']=="" or $aux['id_depto']=="")
					{
						$conteoErrores++;
					}
					else
					{
						$resultado3=$objDocenteControlador->migrarDbToSistema("SELECT * from departamento where id_departamento=".$aux['id_depto'],1);
						$resultado4=$objDocenteControlador->migrarDbToSistema("SELECT * from Docente where carnet=".$aux['carnet'],0);

						if($resultado3->num_rows == 0)
						{
							$conteoErrores++;
						}
						elseif($resultado4->num_rows > 0)
						{
							$conteoErrores++;
						}
						else
						{
							if($aux['esadministrador']==0)
							{
								$nivel="docente";
							}
							else
							{
								$nivel="administrador";
							}

							$valores="'".$aux['carnet']."','".$aux['nom_usuario']."','".$aux['ape_usuario']."','".$nivel."','".$aux['celular']."','".$aux['telcasa']."','".$aux['email']."','".$aux['clave']."','".$aux['id_depto']."'";

							$resultado2=$objDocenteControlador->migrarDbToSistema("INSERT into $tablas2[$i] ($campos2[$i]) values ($valores)",0);

							if(gettype($resultado2)=="string")
							{
								$conteoErrores++;
							}
						}
					}
				}
				elseif($tabla=="horario")
				{
					$resultado3=$objDocenteControlador->migrarDbToSistema("SELECT * from Grupo",0);

					while($ayuda=$resultado3->fetch_assoc())
					{
						$anyo=date('Y');
						$mes=date('n');

						$idGrupo=$ayuda['idGrupo'];

						if($mes<=5)
						{
							$periodo=1;
						}
						else
						{
							$periodo=2;
						}

						$resultado4=$objDocenteControlador->migrarDbToSistema("INSERT into Horario (anyo, periodo, idGrupo) values ($anyo,$periodo,$idGrupo)",0);
					}

				}
				/*elseif($tabla=="materia")
				{
					$siglas=explode(" ", $aux['materia']);

					$anyo=date('Y');

					$siglasFinal="";

					foreach ($siglas as $sigla)
					{
						if(!(strlen($sigla)<=3))
						{
							$siglasFinal.=strtoupper($sigla[0]);
						}
					}


					$resultado3=$objDocenteControlador->migrarDbToSistema("SELECT id_g,id_d,tipo from detalle where id_m=".$aux['id_materia'],1);

					if($resultado3->num_rows == 0)
					{

					}
					else
					{
						while($temp=$resultado3->fetch_assoc())
						{
							$tipoModulo=$temp['tipo'];
							$idDocente=$temp['id_d'];
							$idGrupo=$temp['id_g'];
	
							$resultado3=$objDocenteControlador->migrarDbToSistema("SELECT carnet from docente where id_docente=".$idDocente,1);

							if(gettype($resultado3)=="string")
							{
								echo $resultado3;
							}
							else
							{
								if($temp=$resultado3->fetch_assoc())
								{
									$carnet=$temp['carnet'];
								}

								$resultado3=$objDocenteControlador->migrarDbToSistema("SELECT * from Modulo as M inner join Horario as H on M.idHorario=H.idHorario inner join Grupo as G on H.idGrupo=G.idGrupo where carnet=$carnet and G.idGrupo=$idGrupo",0);

								if($tipoModulo=="U")
								{
									$tipoFinalModulo="teorico";
								}
								else
								{
									$tipoFinalModulo="practico";
								}

								$resultado3=$objDocenteControlador->migrarDbToSistema("SELECT H.idHorario from Horario as H inner join Grupo as G on H.idGrupo=G.idGrupo where G.idGrupo=$idGrupo",0);

			

								if($temp=$resultado3->fetch_assoc())
								{
									$idHorario=$temp['idHorario'];
								}


								$valores="'".$aux['materia']."','".$siglasFinal."','".$tipoFinalModulo."','".$anyo."','0','0','0',$idHorario,'$carnet'";

								echo $valores."<br>";


								$resultado2=$objDocenteControlador->migrarDbToSistema("INSERT into $tablas2[$i] ($campos2[$i]) values ($valores)",0);
							}

							

						}


						
					}

					

				}*/
			}
		}
		$i++;
	}

	if($conteoErrores>0)
	{
		echo "hubieron errores";
	}

	
}
?>