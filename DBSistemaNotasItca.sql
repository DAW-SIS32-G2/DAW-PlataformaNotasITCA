drop database if exists SistemaNotasItca;

create database SistemaNotasItca;

use SistemaNotasItca;

create table Departamento(
idDepartamento int auto_increment not null,
nombreDepartamento varchar(50) not null,
primary key pkDepartamento(idDepartamento)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Insercion de departamentos*/
insert into Departamento(nombreDepartamento) values('Sistemas');
INSERT INTO Departamento(nombreDepartamento) VALUES('Eléctrica');
INSERT INTO Departamento(nombreDepartamento) VALUES('Área básica');
INSERT INTO Departamento(nombreDepartamento) VALUES('Administración');
INSERT INTO Departamento(nombreDepartamento) VALUES('Patrimonio');
INSERT INTO Departamento(nombreDepartamento) VALUES('Servicio Desarrollo prof.');

create table Carrera(
idCarrera int auto_increment not null,
nombreCarrera varchar(60) not null,
idDepartamento int not null,
primary key pkCarrera(idCarrera),
foreign key fkCarreraXDepartamento(idDepartamento) references Departamento(idDepartamento)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Insercion de carreras*/
INSERT INTO Carrera(nombreCarrera,idDepartamento) VALUES('Técnico en Sistemas Informáticos','1');
INSERT INTO Carrera(nombreCarrera,idDepartamento) VALUES('Técnico en Ingeniería Eléctrica','2');
INSERT INTO Carrera(nombreCarrera,idDepartamento) VALUES('Técnico en Mantenimiento de Computadoras','2');
INSERT INTO Carrera(nombreCarrera,idDepartamento) VALUES('Técnico en Gestión Tecnológica del Patrimonio Cultural','5');
INSERT INTO Carrera(nombreCarrera,idDepartamento) VALUES('Cursos libres','6');

create table BuzonArchivos(
idBuzonArchivos int auto_increment not null,
carnet varchar(6) not null,
estado boolean not null,
primary key pkBuzonArchivos(idBuzonArchivos)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table Grupo(
idGrupo int auto_increment not null,
nombreGrupo varchar(10) not null,
seccion varchar(1) not null,
anyo int null,
primary key pkGrupo(idGrupo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Inserción de grupos*/
insert into Grupo(nombreGrupo,seccion,anyo) values ('SIS31','A','2018');
insert into Grupo(nombreGrupo,seccion,anyo) values ('SIS31','B','2018');
insert into Grupo(nombreGrupo,seccion,anyo) values ('SIS31','U','2018');
insert into Grupo(nombreGrupo,seccion,anyo) values ('SIS32','A','2018');
insert into Grupo(nombreGrupo,seccion,anyo) values ('SIS32','B','2018');
insert into Grupo(nombreGrupo,seccion,anyo) values ('SIS32','U','2018');
insert into Grupo(nombreGrupo,seccion,anyo) values ('SIS33','A','2018');
insert into Grupo(nombreGrupo,seccion,anyo) values ('SIS33','U','2018');

create table Usuario(
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
primary key pkUsuario(carnet),
foreign key fkUsuarioXCarrera(idCarrera) references Carrera(idCarrera),
foreign key fkUsuarioXGrupo(idGrupo) references Grupo(idGrupo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table Docente(
carnet varchar(20) NOT NULL,
nombres varchar(50) not null,
apellidos varchar(50) not null,
tipoUsuario varchar(15) not null comment 'docente | administrador',
telefonoMovil varchar(12) null,
telefonoCasa varchar(12) null,
email varchar(50) null,
contra varchar(100) not null,
idDepartamento int not null,
primary key pkDocente(carnet),
foreign key fkDocenteXDepartamento(idDepartamento) references Departamento(idDepartamento)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into Docente(carnet,nombres,apellidos,tipoUsuario,contra,idDepartamento) VALUES ('funes', 'Roberto Enrique', 'Funes Rivera', 'administrador', 'elFxdU9yZmErQTdLMDY5NUJkbUcxQT09OjoAiFxAXB89guSpiWWbkSpN', 1);
insert into Docente(carnet,nombres,apellidos,tipoUsuario,contra,idDepartamento) VALUES ('vladimir', 'Vladimir Edenilson', 'Aguilar', 'docente', 'elFxdU9yZmErQTdLMDY5NUJkbUcxQT09OjoAiFxAXB89guSpiWWbkSpN', 1);
insert into Docente(carnet,nombres,apellidos,tipoUsuario,contra,idDepartamento) VALUES ('magari', 'Henry Magari', 'Vanegas', 'docente', 'elFxdU9yZmErQTdLMDY5NUJkbUcxQT09OjoAiFxAXB89guSpiWWbkSpN', 1);
insert into Docente(carnet,nombres,apellidos,tipoUsuario,contra,idDepartamento) VALUES ('quintanilla', 'Ricardo Edgardo', 'Quintanilla', 'docente', 'elFxdU9yZmErQTdLMDY5NUJkbUcxQT09OjoAiFxAXB89guSpiWWbkSpN', 1);
insert into Docente(carnet,nombres,apellidos,tipoUsuario,contra,idDepartamento) VALUES ('yaqueline', 'Yaqueline Catalina', 'Pimentel', 'docente', 'elFxdU9yZmErQTdLMDY5NUJkbUcxQT09OjoAiFxAXB89guSpiWWbkSpN', 1);
insert into Docente(carnet,nombres,apellidos,tipoUsuario,contra,idDepartamento) VALUES ('melbin', 'Melbin', 'Barrera', 'docente', 'elFxdU9yZmErQTdLMDY5NUJkbUcxQT09OjoAiFxAXB89guSpiWWbkSpN', 1);

create table InsercionDocente(
idInsercion int auto_increment not null,
carnetDoc varchar(20) not null comment 'Carnet del docente que lo registró',
carnetAlumno varchar(6) not null comment 'Carnet del alumno registrado', 
carnet varchar(20) NOT NULL comment 'foranea',
primary key pkInserDoc(idInsercion),
foreign key fkInsercionDocenteXDocente(carnet) references Docente(carnet)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table Archivo(
idArchivo int auto_increment not null,
nombreArchivo varchar(256) not null,
ruta varchar(256) not null,
tamanyo int not null comment 'Tamaño reflejado en MB',
compartido boolean not null comment 'Campo para saber si el archivo ha sido compartido con otro alumno',
carnet varchar(6) not null comment 'foranea',
idBuzonArchivos int not null comment 'foranea',
primary key pkArchivo(idArchivo),
foreign key fkArchivoXUsuario(carnet) references Usuario(carnet),
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

/*Inserción de horarios*/
/*Horario para SIS31A*/
insert into Horario(anyo, periodo, idGrupo) values('2018','1','1');
/*Horario para SIS31B*/
insert into Horario(anyo, periodo, idGrupo) values('2018','1','2');
/*Horario para SIS31U*/
insert into Horario(anyo, periodo, idGrupo) values('2018','1','3');
/*Horario para SIS32A*/
insert into Horario(anyo, periodo, idGrupo) values('2018','1','4');
/*Horario para SIS32B*/
insert into Horario(anyo, periodo, idGrupo) values('2018','1','5');
/*Horario para SIS32U*/
insert into Horario(anyo, periodo, idGrupo) values('2018','1','6');
/*Horario para SIS33A*/
insert into Horario(anyo, periodo, idGrupo) values('2018','1','7');
/*Horario para SIS33U*/
insert into Horario(anyo, periodo, idGrupo) values('2018','1','8');

create table Modulo(
idModulo int auto_increment not null,
nombreModulo varchar(100) not null,
siglas varchar(20) not null,
tipoModulo varchar(10) not null comment 'Practico | teorico',
anyo int not null,
activo boolean not null comment '0 => el grupo esta visible unicamente para docentes | 1=> el grupo esta visible para todos los usuarios',
estado boolean null comment '1 -> Abierto | 0 -> Cerrado (sirve para permitir inscripciones o no a dicho modulo por parte de los alumnos)',
protegidoPorContra boolean not null comment '0=> el modulo no esta protegido por clave | 1 => el modulo require de calve para inscribirse',
contraModulo varchar(200) null comment 'Sirve para proteger las inscripciones de los alumnos al modulo',
idHorario int not null comment 'Hace referencia al ID de cada Horario por grupo',
carnet varchar(20) NULL,
primary key pkModulo(idModulo),
foreign key fkModuloXHorario(idHorario) references Horario(idHorario)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert into Modulo(nombreModulo, siglas, tipoModulo, anyo, activo, estado, protegidoPorContra, idHorario, carnet) values('Desarrollo de Aplicaciones para la Web','DAW-SIS32A','practico','2018',1,1,0,'4','quintanilla');
insert into Modulo(nombreModulo, siglas, tipoModulo, anyo, activo, estado, protegidoPorContra, idHorario, carnet) values('Desarrollo de Aplicaciones para la Web','DAW-SIS32B','practico','2018',1,1,0,'5','magari');
insert into Modulo(nombreModulo, siglas, tipoModulo, anyo, activo, estado, protegidoPorContra, idHorario, carnet) values('Desarrollo de Aplicaciones para la Web','DAW-SIS32U','teorico','2018',1,1,0,'6','magari');
insert into Modulo(nombreModulo, siglas, tipoModulo, anyo, activo, estado, protegidoPorContra, idHorario, carnet) values('Aplicación de Metodologías Ágiles y Testeo de Software','AMATS-SIS32A','practico','2018',1,1,0,'4','vladimir');
insert into Modulo(nombreModulo, siglas, tipoModulo, anyo, activo, estado, protegidoPorContra, idHorario, carnet) values('Aplicación de Metodologías Ágiles y Testeo de Software','AMATS-SIS32B','practico','2018',1,1,0,'5','magari');
insert into Modulo(nombreModulo, siglas, tipoModulo, anyo, activo, estado, protegidoPorContra, idHorario, carnet) values('Aplicación de Metodologías Ágiles y Testeo de Software','AMATS-SIS32U','teorico','2018',1,1,0,'6','magari');
insert into Modulo(nombreModulo, siglas, tipoModulo, anyo, activo, estado, protegidoPorContra, idHorario, carnet) values('Instalación y Configuración de Software y Hardware', 'ICH-SIS32A','practico','2018',1,'activo',1,'4','vladimir');
insert into Modulo(nombreModulo, siglas, tipoModulo, anyo, activo, estado, protegidoPorContra, idHorario, carnet) values('Instalación y Configuración de Software y Hardware', 'ICH-SIS32B','practico','2018',1,1,0,'5','vladimir');
insert into Modulo(nombreModulo, siglas, tipoModulo, anyo, activo, estado, protegidoPorContra, idHorario, carnet) values('Instalación y Configuración de Software y Hardware', 'ICH-SIS32U','teorico','2018',1,1,0,'6','vladimir');
insert into Modulo(nombreModulo, siglas, tipoModulo, anyo, activo, estado, protegidoPorContra, idHorario, carnet) values('Comunicación Oral y Escrita', 'COE-SIS32U','teorico','2018',1,1,0,'6','yaqueline');
insert into Modulo(nombreModulo, siglas, tipoModulo, anyo, activo, estado, protegidoPorContra, idHorario, carnet) values('Física', 'FIS-SIS32U','teorico','2018',1,1,0,'6','melbin');

create table DetalleModulo(
id_detalle int auto_increment not null,
aula varchar(10) not null,
horaInicio time not null,
horaFin time not null,
ciclo int not null,
dia varchar(10) not null,
idGrupo int not null comment 'Foranea de Grupo',
horas int not null comment 'Cantidad de horas | Se divide por bloques de 2 horas',
idModulo int not null comment 'Hace referencia al modulo al que pertenece',
primary key pkdetmod(id_detalle),
foreign key fkmodulo(idModulo) references Modulo(idModulo)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Inserción de detalles de modulo*/
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('CC1','07:00:00','08:40:00','1','Lunes','4','2','7');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('CC1','09:00:00','10:40:00','1','Lunes','4','2','7');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('101','10:40:00','12:20:00','1','Lunes','6','2','10');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('CC1','13:00:00','14:40:00','1','Lunes','5','2','8');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('CC1','14:40:00','16:20:00','1','Lunes','5','2','8');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('CC2','07:00:00','08:40:00','1','Martes','4','2','1');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('CC1','07:00:00','08:40:00','1','Martes','5','2','2');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('CC2','09:00:00','10:40:00','1','Martes','4','2','1');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('CC1','09:00:00','10:40:00','1','Martes','5','2','2');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('CC2','10:40:00','11:30:00','1','Martes','4','1','1');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('CC1','10:40:00','11:30:00','1','Martes','5','1','2');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('101','11:30:00','12:20:00','1','Martes','6','1','9');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('C102','13:00:00','14:40:00','1','Martes','6','2','11');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('CC3','07:00:00','08:40:00','1','Miércoles','4','2','4');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('CC3','09:00:00','10:40:00','1','Miércoles','4','2','4');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('CC3','10:40:00','11:30:00','1','Miércoles','4','1','4');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('CC4','07:00:00','08:40:00','1','Miércoles','5','2','5');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('CC4','09:00:00','10:40:00','1','Miércoles','5','2','5');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('CC4','10:40:00','11:30:00','1','Miércoles','5','1','5');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('C102','09:00:00','10:40:00','1','Jueves','6','2','11');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('C102','10:40:00','12:20:00','1','Jueves','6','2','3');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('101','07:00:00','08:40:00','1','Viernes','6','2','10');
insert into DetalleModulo(aula,horaInicio,horaFin,ciclo,dia,idGrupo,horas,idModulo) values ('101','09:00:00','10:40:00','1','Viernes','6','2','6');

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

/*Insercion de ponderaciones*/
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('EVP1','15','1');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('EVP2','15','1');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('EVP3','20','1');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('EJP','10','1');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('PROY','40','1');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('EVP1','0','2');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('EVP2','0','2');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('Trabajo','0','2');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('EJP','0','2');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('PROY','0','2');

create table Tarea(
idTarea int auto_increment not null,
nombreTarea varchar(30) not null,
porcentaje decimal(5,2) not null,
fechaInicio date null,
fechaFin date null,
activo int(1) not null comment 'define si una práctica está abierta(1) o cerrada(0)',
cantidadEjercicios int not null,
directorio varchar(200) not null,
idPonderacion int not null comment 'foranea',
primary key pkTarea(idTarea),
foreign key fkTareaXPonderacion(idPonderacion) references Ponderacion(idPonderacion)  on update cascade on delete cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Inserción de tareas*/
insert into Tarea(nombreTarea,porcentaje,cantidadEjercicios,idPonderacion,directorio,activo) values('practica05',8.55,'100',5,'practica05',1);

create table TareaSubidaPor(
idTareaSubidaPor int auto_increment not null,
carnet varchar(6) not null,
idTarea int not null,
ruta varchar(250) not null comment 'Aquí se guardará donde esta el archivo subido',
primary key pkTareaSubidaPor(idTareaSubidaPor),
foreign key fkTareaSubidaPorXTarea(idTarea) references Tarea(idTarea)  on update cascade on delete cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

create table Nota(
idNota int auto_increment not null,
carnet varchar(6) not null,
valor int not null,
idTarea int not null comment 'foranea',
primary key pkNota(idNota),
foreign key fkNotaXTarea(idTarea) references Tarea(idTarea)  on update cascade on delete cascade
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

delimiter //
CREATE function activa(_idTarea int)
returns Varchar(40)
READS SQL DATA
DETERMINISTIC
begin
declare valo Varchar(40);
IF 1 = (select activo from Tarea where idTarea=_idTarea) then
if (select fechaFin from Tarea where idTarea=_idTarea) >= (select CURDATE()) then
set valo = 'Activa';
else
update Tarea
set activo = 0
where idTarea=_idTarea;
set valo = 'Desactiva';
end if;
else
set valo = 'Desactiva';
end if;
return valo;
end //
delimiter ;

/****************Select's de las tablas****************/
/* Descomentar solo cuando se usara el select*/
/*
select * from Grupo;
select * from Horario;
select * from Docente;
select * from Ponderacion;
select * from Modulo;
select * from Carrera;
select * from Usuario;
select * from Tarea;
select * from TareaSubidaPor;
select * from ArchivoSubido;
select * from GuiaModulo;

select P.nombrePonderacion from Ponderacion as P where idPonderacion=11;

select *
from Modulo as M
inner join Horario as H
on M.idHorario = H.idHorario
inner join Grupo as G
on H.idGrupo = G.idGrupo
where M.carnet='funes' and M.activo=1;

select * from Ponderacion as P
inner join Modulo as M
on M.idModulo=P.idModulo
where P.idModulo='1';

SELECT P.nombrePonderacion,T.nombreTarea,T.cantidadEjercicios
from Ponderacion as P
inner join Tarea as T
on P.idPonderacion=T.idPonderacion
where P.idModulo=1;

SELECT M.siglas,M.anyo FROM Modulo AS M WHERE M.idModulo= 100;

select M.protegidoPorContra, M.contraModulo from Modulo as M where idModulo=100;
---- Select por docente -----
Select Modulo.nombreModulo, CONCAT(Grupo.nombreGrupo,' ',Grupo.seccion) AS 'clase', DetalleModulo.horaInicio, DetalleModulo.horaFin, DetalleModulo.aula, CONCAT(Docente.nombres,' ',Docente.apellidos) as 'docente', DetalleModulo.horas, DetalleModulo.dia from modulo inner join DetalleModulo on Modulo.idModulo = DetalleModulo.idModulo INNER JOIN Grupo on Grupo.idGrupo = Modulo.idGrupo inner join Docente on Docente.carnet = Modulo.carnet WHERE Docente.carnet = '$carnet' order by DetalleModulo.horaInicio
---- Select por grupo ----
Select Modulo.nombreModulo, CONCAT(Grupo.nombreGrupo,' ',Grupo.seccion) AS 'clase', DetalleModulo.horaInicio, DetalleModulo.horaFin, DetalleModulo.aula, CONCAT(Docente.nombres,' ',Docente.apellidos) as 'docente', DetalleModulo.horas, DetalleModulo.dia from modulo inner join DetalleModulo on Modulo.idModulo = DetalleModulo.idModulo INNER JOIN Grupo on Grupo.idGrupo = Modulo.idGrupo inner join Docente on Docente.carnet = Modulo.carnet WHERE CONCAT() = '$carnet' order by DetalleModulo.horaInicio
*/

/****************Insercion de registros de prueba Roberto (no borrar)****************/
insert into grupo(idGrupo,nombreGrupo,seccion,anyo) values (100,'Prueba31','U','2018');
insert into grupo(idGrupo,nombreGrupo,seccion,anyo) values (101,'Prueba31','A','2018');
insert into grupo(idGrupo,nombreGrupo,seccion,anyo) values (102,'Prueba31','B','2018');
insert into Horario(idHorario,anyo, periodo, idGrupo) values(100,'2018','1','102');
insert into Horario(idHorario,anyo, periodo, idGrupo) values(101,'2018','1','101');

insert into
Modulo(idModulo,nombreModulo, siglas, tipoModulo, anyo, activo, estado, protegidoPorContra, idHorario, carnet)
values(100,'Desarrollo de Aplicaciones para la Web','DAW-Prueba31B','practico','2018','1','1',0,'100','funes');

insert into
Modulo(idModulo,nombreModulo, siglas, tipoModulo, anyo, activo, estado, protegidoPorContra, idHorario, carnet)
values(101,'Aplicacion de Metodologias Agiles y Testeo de Software','AMATS-Prueba31B','practico','2018','1','1',0,'100','funes');

insert into
Modulo(idModulo,nombreModulo, siglas, tipoModulo, anyo, activo, estado, protegidoPorContra, contraModulo, idHorario, carnet)
values(103,'Aplicacion de Metodologias Agiles y Testeo de Software','AMATS-Prueba31A','practico','2018','1','0',1,'AMATS-Prueba31A','101','funes');

insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('EVP1','15','100');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('EVP2','15','100');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('EVP3','20','100');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('EJP','10','100');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('PROY','40','100');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('EVP1','0','101');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('EVP2','0','101');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('Trabajo','0','101');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('EJP','0','101');
insert into Ponderacion(nombrePonderacion, porcentaje, idModulo) values('PROY','0','101');


/****************Insercion de registros de prueba Marcelo****************/
INSERT INTO 
Usuario (carnet,nombres,apellidos,telefonoMovil,jornada,sexo,foto,email,contra,anyoIngreso,permiteModificacion,idCarrera,idGrupo)
VALUES
('108117', 'José Marcelo', 'Hernández Cerritos', NULL, NULL, NULL, NULL, NULL, 'RXFORUJ2QmVsK3AvUVh1cTNyTm95Zz09OjqOQIbAqUHX3H7SAu45mQMh', 2018, 1, 1, 5);

/****************Insercion de registros de prueba Daniel****************/
/****************Insercion de registros de prueba Joaquin****************/