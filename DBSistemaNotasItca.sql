drop database if exists SistemaNotasItca;

create database if not exists SistemaNotasItca;

use SistemaNotasItca;


create table Departamento(
idDepartamento int auto_increment not null,
nombreDepartamento varchar(50) not null,
primary key pkDepartamento(idDepartamento)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


create table Carrera(
idCarrera int auto_increment not null,
nombreCarrera varchar(60) not null,
idDepartamento int not null,
primary key pkCarrera(idCarrera),
foreign key fkCarreraXDepartamento(idDepartamento) references Departamento(idDepartamento)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

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



create table Usuario(
idUsuario int auto_increment not null,
carnet varchar(6) not null,
nombres varchar(50) not null,
apellidos varchar(50) not null,
telefonoMovil varchar(12) null,
jornada varchar(12) null,
sexo varchar(12) null,
foto varchar(50) null,
email varchar(50) null,
contra varchar(100) not null,
anyoIngreso int not null,
permiteModificacion boolean not null comment 'campo para verificar si el usuario ya igreso por primera vez al sistema',
idCarrera int not null comment 'foranea',
idGrupo int not null comment 'foranea',
primary key pkUsuario(idUsuario),
foreign key fkUsuarioXCarrera(idCarrera) references Carrera(idCarrera),
foreign key fkUsuarioXGrupo(idGrupo) references Grupo(idGrupo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


create table Docente(
idDocente int auto_increment not null,
carnet varchar(20) NOT NULL,
nombres varchar(50) not null,
apellidos varchar(50) not null,
tipoUsuario varchar(15) not null comment 'docente | administrador',
telefonoMovil varchar(12) null,
telefonoCasa varchar(12) null,
email varchar(50) null,
contra varchar(100) not null,
idDepartamento int not null,
primary key pkDocente(idDocente),
foreign key fkDocenteXDepartamento(idDepartamento) references Departamento(idDepartamento)
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
siglas varchar(20) not null,
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

/****************Select's de las tablas****************/

select * from Grupo;
select * from Horario;


/****************Insercion de registros de prueba****************/

insert into Grupo(nombreGrupo) values('SIS32');


insert into Horario(anyo, periodo, idGrupo) values('2018','1','1');

insert into 
Modulo(nombreModulo, siglas, tipoModulo, aula, horaInicio, horaFin, dia, activo, estado, idHorario)
values('Desarrollo de Aplicaciones para la Web','DAW-SIS32B','practico','CC1','7:00','11:30','martes','1','abierto','1');

insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('EVP1','0','1');