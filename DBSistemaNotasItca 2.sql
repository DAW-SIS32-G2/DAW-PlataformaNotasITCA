drop database if exists SistemaNotasItca;

create database if not exists SistemaNotasItca;

use SistemaNotasItca;

create table Carrera(
	'idCarrera' int auto_increment not null,
	'nombreCarrera' varchar(60) not null,
	'iddepto' int(11) null,
	'corto' varchar(60) null,
	'estadocarrera' varchar(10) DEFAULT 'A',
	primary key pkCarrera(idCarrera)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `carrera` VALUES("2","Técnico en Sistemas Informáticos","1",NULL,"A");
INSERT INTO `carrera` VALUES("3","Técnico en Ingenierí­a Eléctrica","2",NULL,"A");
INSERT INTO `carrera` VALUES("4","Técnico en Mantenimiento de Computadoras","2",NULL,"A");
INSERT INTO `carrera` VALUES("5","Técnico en Gestión Tecnológica del Patrimonio Cultural","5",NULL,"A");
INSERT INTO `carrera` VALUES("6","Cursos libres","7",NULL,"A");

CREATE TABLE `departamento` (
  `id_departamento` int(11) NOT NULL AUTO_INCREMENT,
  `departamento` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_departamento`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=24 ROW_FORMAT=DYNAMIC;

INSERT INTO `departamento` VALUES("1","Computación");
INSERT INTO `departamento` VALUES("2","Eléctrica");
INSERT INTO `departamento` VALUES("3","Área básica");
INSERT INTO `departamento` VALUES("4","Administración");
INSERT INTO `departamento` VALUES("5","Patrimonio");
INSERT INTO `departamento` VALUES("7","Servicio Desarrollo prof.");


DROP TABLE IF EXISTS `docente`;

CREATE TABLE `docente` (
  `id_docente` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `carnet` char(20) NOT NULL,
  -- `nom_usuario` char(30) NOT NULL DEFAULT '',
  -- `ape_usuario` char(30) NOT NULL DEFAULT '',
  -- `tipo` char(30) DEFAULT NULL,
  -- `telcasa` char(9) DEFAULT NULL,
  -- `celular` char(9) DEFAULT NULL,
  -- `email` char(100) DEFAULT NULL,
  -- `estado` char(20) DEFAULT NULL,
  `clave` char(84),
  -- `id_depto` int(2) DEFAULT NULL,
  -- `contrato` char(4) DEFAULT NULL,
  -- `fechai` date DEFAULT NULL,
  -- `fechaf` date DEFAULT NULL,
  -- `nhoras` int(4) DEFAULT NULL,
  -- `hpagadas` int(4) DEFAULT NULL,
  -- `permanente` int(1) DEFAULT '0',
  -- `accesosistemas` int(4) DEFAULT '0',
  -- `esadministrador` int(1) DEFAULT '0' COMMENT '1=si 0=no 3=soporte 4=practicaProf',
  -- `esasesor` int(1) DEFAULT '1' COMMENT '1=si  0=no',
  -- `esjurado` int(1) DEFAULT '1' COMMENT '1=si  0=no',
  -- `sipublica` int(1) DEFAULT '0' COMMENT '1=puede publicas 0=no puede',
  PRIMARY KEY (`id_docente`),
  UNIQUE KEY `id_docente` (`id_docente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `alumno`;

CREATE TABLE `alumno` (
  `idalumno` int(11) NOT NULL AUTO_INCREMENT,
  `carnet` varchar(15) DEFAULT NULL,
  -- `nombre` varchar(20) DEFAULT NULL,
  -- `apellido` varchar(20) DEFAULT NULL,
  -- `telefono` varchar(9) DEFAULT NULL,
  -- `jornada` varchar(15) DEFAULT NULL,
  -- `idgrupo` int(11) DEFAULT NULL,
  -- `sexo` varchar(1) DEFAULT NULL,
  -- `foto` varchar(50) DEFAULT NULL,
  -- `email` varchar(150) DEFAULT 'no@tiene.com',
  -- `estadoAlumno` varchar(2) NOT NULL DEFAULT 'H' COMMENT 'H alumno activo I alumno inactivo D alumno desertor',
  `clave` varchar(84),
  -- `yearingreso` int(4) DEFAULT NULL,
  -- `id_carrera` int(11) DEFAULT NULL,
  -- `fotoal` varchar(250) DEFAULT 'no',
  -- `carta` varchar(2) DEFAULT 'n',
  PRIMARY KEY (`idalumno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table BuzonArchivos(
idBuzonArchivos int auto_increment not null,
carnet varchar(6) not null,
estado boolean not null,
primary key pkBuzonArchivos(idBuzonArchivos)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table Grupo(
idGrupo int auto_increment not null,
nombreGrupo varchar(10) not null,
primary key pkGrupo(idGrupo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table Archivo(
idArchivo int auto_increment not null,
nombreArchivo varchar(256) not null,
ruta varchar(256) not null,
tamanyo int not null comment 'Tamaño reflejado en MB',
compartido boolean not null comment 'Campo para saber si el archivo ha sido compartido con otro alumno',
idUsuario int not null comment 'foranea',
idBuzonArchivos int not null comment 'foranea',
primary key pkArchivo(idArchivo),
foreign key fkArchivoXUsuario(idUsuario) references Usuario(idUsuario),
foreign key fkArchivoXBuzonArchivos(idBuzonArchivos) references BuzonArchivos(idBuzonArchivos)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table ArchivoCompartido(
idArchivoCompartido int auto_increment not null,
carnet varchar(6) not null,
fechaCompartido date not null,
idArchivo int not null comment 'foranea',
primary key pkArchivoCompartido(idArchivoCompartido),
foreign key fkArchivoCompartidoXArchivo(idArchivo) references Archivo(idArchivo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table Horario(
idHorario int auto_increment not null,
anyo int not null,
periodo int not null,
idGrupo int not null comment 'foranea',
primary key pkHorario(idHorario),
foreign key fkHorarioXGrupo(idGrupo) references Grupo(idGrupo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table Modulo(
idModulo int auto_increment not null,
nombreModulo varchar(50) not null,
siglas varchar(6) not null,
tipoModulo varchar(10) not null comment 'Practico | teorico',
aula varchar(20) null,
horaInicio time null,
horaFin time not null,
dia varchar(10) null comment 'Lunes a viernes',
activo boolean not null comment '0 => el grupo esta visible unicamente para docentes | 1=> el grupo esta visible para todos los usuarios',
estado varchar(10) null comment 'Abierto | Cerrado (sirve para permitir inscripciones o no a dicho modulo por parte de los alumnos)',
contraModulo varchar(20) null comment 'Sirve para proteger las inscripciones de los alumnos al modulo',
idHorario int not null comment 'foranea',
primary key pkModulo(idModulo),
foreign key fkModuloXHorario(idHorario) references Horario(idHorario)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table GuiaModulo(
idGuiaModulo int auto_increment not null,
nombreGuia varchar(200) not null,
ruta varchar(200) not null,
idModulo int not null comment 'foranea',
primary key pkGuiaModulo(idGuiaModulo),
foreign key fkGuiaModuloXModulo(idModulo) references Modulo(idModulo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table UsuarioActivo(
idUsuarioActivo int auto_increment not null,
carnet varchar(6) not null,
idModulo int not null comment 'foranea',
primary key pkUsuarioActivo(idUsuarioActivo),
foreign key fkUsuarioActivoXModulo(idModulo) references Modulo(idModulo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table ArchivoSubido(
idArchivoSubido int auto_increment not null,
nombre varchar(200) not null,
ruta varchar(200) not null,
carnet varchar(6) not null,
idModulo int not null comment 'foranea',
primary key pkArchivoSubido(idArchivoSubido),
foreign key fkArchivoSubidoXModulo(idModulo) references Modulo(idModulo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table Ponderacion(
idPonderacion int auto_increment not null,
nombrePonderacion varchar(20) not null,
porcentaje int not null,
idModulo int not null comment 'foranea',
primary key pkPonderacion(idPonderacion),
foreign key fkPonderacionXModulo(idModulo) references Modulo(idModulo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table Tarea(
idTarea int auto_increment not null,
nombreTarea varchar(30) not null,
porcentaje int not null,
fechaInicio date null,
fechaFin date null,
cantidadEjercicios int null,
idPonderacion int not null comment 'foranea',
primary key pkTarea(idTarea),
foreign key fkTareaXPonderacion(idPonderacion) references Ponderacion(idPonderacion)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table Nota(
idNota int auto_increment not null,
carnet varchar(6) not null,
valor int not null,
idTarea int not null comment 'foranea',
primary key pkNota(idNota),
foreign key fkNotaXTarea(idTarea) references Tarea(idTarea)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
