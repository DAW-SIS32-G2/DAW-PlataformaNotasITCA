/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.1.41 : Database - sistemaglobal
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sistema` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `sistema`;

/*Table structure for table `alumno` */

DROP TABLE IF EXISTS `alumno`;

CREATE TABLE `alumno` (
  `idalumno` INT(11) NOT NULL AUTO_INCREMENT,
  `carnet` VARCHAR(6) DEFAULT NULL,
  `nombre` VARCHAR(20) DEFAULT NULL,
  `apellido` VARCHAR(20) DEFAULT NULL,
  `telefono` VARCHAR(9) DEFAULT NULL,
  `jornada` VARCHAR(15) DEFAULT NULL,
  `idgrupo` INT(11) DEFAULT NULL,
  `sexo` VARCHAR(1) DEFAULT NULL,
  `foto` VARCHAR(50) DEFAULT NULL,
  `email` VARCHAR(150) DEFAULT 'no@tiene.com',
  `estadoAlumno` VARCHAR(2) NOT NULL DEFAULT 'H' COMMENT 'H alumno activo I alumno inactivo D alumno desertor',
  `clave` VARCHAR(50) DEFAULT 'itca',
  `yearingreso` INT(4) DEFAULT NULL,
  `id_carrera` INT(11) DEFAULT NULL,
  `fotoal` VARCHAR(250) DEFAULT 'no',
  `carta` VARCHAR(2) DEFAULT 'n',
  PRIMARY KEY (`idalumno`)
) ENGINE=INNODB AUTO_INCREMENT=1732 DEFAULT CHARSET=latin1;

/*Table structure for table `aula` */

DROP TABLE IF EXISTS `aula`;

CREATE TABLE `aula` (
  `id_aula` INT(11) NOT NULL AUTO_INCREMENT,
  `aula` VARCHAR(25) DEFAULT NULL,
  `tipoa` VARCHAR(30) DEFAULT NULL,
  `descripcion` VARCHAR(30) DEFAULT NULL,
  `ubicacion` VARCHAR(30) DEFAULT NULL,
  `capacidadhoras` INT(2) DEFAULT '12',
  PRIMARY KEY (`id_aula`)
) ENGINE=MYISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=21 ROW_FORMAT=DYNAMIC;

/*Table structure for table `buzonpracticas` */

DROP TABLE IF EXISTS `buzonpracticas`;

CREATE TABLE `buzonpracticas` (
  `idbuzonpracticas` INT(11) NOT NULL AUTO_INCREMENT,
  `idpractica` INT(11) DEFAULT NULL,
  `carnetal` VARCHAR(6) DEFAULT NULL,
  `fechaup` DATE DEFAULT NULL,
  `nombrearchivo` VARCHAR(254) DEFAULT NULL,
  `nombrereal` VARCHAR(254) DEFAULT NULL,
  `eliminado` INT(1) DEFAULT '0',
  `sizefile` DOUBLE DEFAULT NULL,
  `ver` INT(1) DEFAULT '0' COMMENT '0=ver   1=oculto',
  `idgrupodocente` INT(11) DEFAULT NULL,
  `extencion` VARCHAR(100) DEFAULT NULL,
  `rev` INT(1) DEFAULT '0' COMMENT '0=norevisado  1=siRevisado',
  PRIMARY KEY (`idbuzonpracticas`)
) ENGINE=MYISAM AUTO_INCREMENT=7408 DEFAULT CHARSET=latin1;

/*Table structure for table `carrera` */

DROP TABLE IF EXISTS `carrera`;

CREATE TABLE `carrera` (
  `idcarrera` INT(11) NOT NULL AUTO_INCREMENT,
  `carrera` VARCHAR(200) DEFAULT NULL,
  `iddepto` INT(11) DEFAULT NULL,
  `corto` VARCHAR(60) DEFAULT NULL,
  `estadocarrera` VARCHAR(10) DEFAULT 'A',
  PRIMARY KEY (`idcarrera`)
) ENGINE=MYISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Table structure for table `departamento` */

DROP TABLE IF EXISTS `departamento`;

CREATE TABLE `departamento` (
  `id_departamento` INT(11) NOT NULL AUTO_INCREMENT,
  `departamento` VARCHAR(200) DEFAULT NULL,
  PRIMARY KEY (`id_departamento`)
) ENGINE=MYISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=24 ROW_FORMAT=DYNAMIC;

/*Table structure for table `docente` */

DROP TABLE IF EXISTS `docente`;

CREATE TABLE `docente` (
  `id_docente` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `carnet` CHAR(20) NOT NULL,
  `nom_usuario` CHAR(30) NOT NULL DEFAULT '',
  `ape_usuario` CHAR(30) NOT NULL DEFAULT '',
  `tipo` CHAR(30) DEFAULT NULL,
  `telcasa` CHAR(9) DEFAULT NULL,
  `celular` CHAR(9) DEFAULT NULL,
  `email` CHAR(100) DEFAULT NULL,
  `estado` CHAR(20) DEFAULT NULL,
  `clave` CHAR(50) DEFAULT NULL,
  `id_depto` INT(2) DEFAULT NULL,
  `contrato` CHAR(4) DEFAULT NULL,
  `fechai` DATE DEFAULT NULL,
  `fechaf` DATE DEFAULT NULL,
  `nhoras` INT(4) DEFAULT NULL,
  `hpagadas` INT(4) DEFAULT NULL,
  `permanente` INT(1) DEFAULT '0',
  `accesosistemas` INT(4) DEFAULT '0',
  `esadministrador` INT(1) DEFAULT '0' COMMENT '1=si 0=no 3=soporte',
  `esasesor` INT(1) DEFAULT '1' COMMENT '1=si  0=no',
  `esjurado` INT(1) DEFAULT '1' COMMENT '1=si  0=no',
  `sipublica` INT(1) DEFAULT '0' COMMENT '1=puede publicas 0=no puede',
  PRIMARY KEY (`id_docente`),
  UNIQUE KEY `id_docente` (`id_docente`)
) ENGINE=MYISAM AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

/*Table structure for table `grupo` */

DROP TABLE IF EXISTS `grupo`;

CREATE TABLE `grupo` (
  `id_grupo` INT(10) NOT NULL AUTO_INCREMENT,
  `grupo` VARCHAR(20) NOT NULL,
  `tipo` VARCHAR(50) DEFAULT NULL,
  `idcarrera` INT(11) DEFAULT NULL,
  `year` INT(4) DEFAULT NULL,
  `ciclo` VARCHAR(6) DEFAULT NULL,
  `estado` VARCHAR(15) DEFAULT 'Habilitado',
  PRIMARY KEY (`id_grupo`)
) ENGINE=MYISAM AUTO_INCREMENT=195 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=20 ROW_FORMAT=DYNAMIC;

/*Table structure for table `grupodocente` */

DROP TABLE IF EXISTS `grupodocente`;

CREATE TABLE `grupodocente` (
  `idgrupodocente` INT(11) NOT NULL AUTO_INCREMENT,
  `carnet` CHAR(20) DEFAULT NULL,
  `idgrupo` INT(11) DEFAULT NULL,
  `year` INT(4) DEFAULT NULL,
  `ciclo` CHAR(4) DEFAULT NULL,
  `estado` VARCHAR(4) DEFAULT 'H' COMMENT 'para hacer visible el modulo ante el alumno',
  `id_materia` INT(10) DEFAULT NULL,
  `bloqueado` INT(1) DEFAULT '0' COMMENT 'sirve para cuando se le pone clave al grupo',
  `claveinst` VARCHAR(250) DEFAULT NULL,
  `nombredirectorio` VARCHAR(250) DEFAULT NULL,
  `sizedir` INT(10) DEFAULT '50',
  `cerrado` INT(1) DEFAULT '0',
  `permisomod` INT(1) DEFAULT '0',
  PRIMARY KEY (`idgrupodocente`)
) ENGINE=INNODB AUTO_INCREMENT=140 DEFAULT CHARSET=latin1;

/*Table structure for table `grupodocentealumno` */

DROP TABLE IF EXISTS `grupodocentealumno`;

CREATE TABLE `grupodocentealumno` (
  `idgrupodocalumno` INT(11) NOT NULL AUTO_INCREMENT,
  `idgrupodocente` INT(11) DEFAULT NULL,
  `carnet` VARCHAR(6) DEFAULT NULL,
  `year` INT(4) DEFAULT NULL,
  `estado` VARCHAR(2) DEFAULT 'H',
  `asistencia` INT(4) DEFAULT '0',
  `horas` INT(4) DEFAULT NULL,
  PRIMARY KEY (`idgrupodocalumno`)
) ENGINE=MYISAM AUTO_INCREMENT=1987 DEFAULT CHARSET=latin1;

/*Table structure for table `grupodocentefiles` */

DROP TABLE IF EXISTS `grupodocentefiles`;

CREATE TABLE `grupodocentefiles` (
  `idgrupodocentefile` INT(11) NOT NULL AUTO_INCREMENT,
  `nombrearchivo` VARCHAR(250) DEFAULT NULL,
  `extencion` VARCHAR(6) DEFAULT NULL,
  `sizefile` DOUBLE DEFAULT NULL,
  `eliminado` INT(1) DEFAULT '0' COMMENT '0=activo',
  `visible` INT(1) DEFAULT '0' COMMENT '0=activo  3=insercio multiple',
  `nombre_original` VARCHAR(250) DEFAULT NULL,
  `visitas_totales` INT(10) DEFAULT '0',
  `fechaup` DATE DEFAULT '0000-00-00' COMMENT 'fecha subido',
  `fechadown` DATE DEFAULT '0000-00-00' COMMENT 'fecha eliminado logico',
  `idgrupodocente` INT(11) DEFAULT NULL,
  PRIMARY KEY (`idgrupodocentefile`)
) ENGINE=MYISAM AUTO_INCREMENT=997 DEFAULT CHARSET=latin1;

/*Table structure for table `grupodocponderacion` */

DROP TABLE IF EXISTS `grupodocponderacion`;

CREATE TABLE `grupodocponderacion` (
  `idponderacion` INT(11) NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(100) DEFAULT NULL,
  `porcentaje` FLOAT DEFAULT NULL,
  `idgrupodocente` INT(11) DEFAULT NULL,
  PRIMARY KEY (`idponderacion`)
) ENGINE=INNODB AUTO_INCREMENT=197 DEFAULT CHARSET=latin1;

/*Table structure for table `grupores` */

DROP TABLE IF EXISTS `grupores`;

CREATE TABLE `grupores` (
  `id_grupo` INT(10) NOT NULL DEFAULT '0',
  `grupo` VARCHAR(20) CHARACTER SET utf8 NOT NULL,
  `tipo` VARCHAR(50) CHARACTER SET utf8 DEFAULT NULL,
  `idcarrera` INT(11) DEFAULT NULL,
  `year` INT(4) DEFAULT NULL,
  `ciclo` VARCHAR(6) CHARACTER SET utf8 DEFAULT NULL,
  `estado` VARCHAR(15) CHARACTER SET utf8 DEFAULT 'Habilitado'
) ENGINE=MYISAM DEFAULT CHARSET=latin1;

/*Table structure for table `horario` */

DROP TABLE IF EXISTS `horario`;

CREATE TABLE `horario` (
  `id_horario` INT(10) NOT NULL AUTO_INCREMENT,
  `ha` TIME DEFAULT NULL,
  `hf` TIME DEFAULT NULL,
  PRIMARY KEY (`id_horario`)
) ENGINE=MYISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=20 ROW_FORMAT=DYNAMIC;

/*Table structure for table `hr_curricula` */

DROP TABLE IF EXISTS `hr_curricula`;

CREATE TABLE `hr_curricula` (
  `idcurricula` INT(11) NOT NULL AUTO_INCREMENT,
  `idcarrera` INT(11) NOT NULL,
  `estado` VARCHAR(15) DEFAULT 'A',
  `curricula` VARCHAR(15) DEFAULT NULL,
  PRIMARY KEY (`idcurricula`)
) ENGINE=MYISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Table structure for table `hr_horario_disponible` */

DROP TABLE IF EXISTS `hr_horario_disponible`;

CREATE TABLE `hr_horario_disponible` (
  `id_horario` INT(11) NOT NULL AUTO_INCREMENT,
  `dia` VARCHAR(20) DEFAULT NULL COMMENT 'dia correspondiente a la fecha',
  `hora_disponible` VARCHAR(50) DEFAULT NULL,
  `hora_inicio` TIME DEFAULT NULL,
  `hora_fin` TIME DEFAULT NULL,
  `idcorte` INT(11) NOT NULL,
  `total_horas` INT(11) DEFAULT NULL,
  `estado_horario` VARCHAR(50) DEFAULT NULL COMMENT 'habilitado, deshabilitado',
  `fecha` DATE DEFAULT NULL COMMENT 'fecha disponible yyy-mm-dd',
  `asignaciones` INT(11) DEFAULT NULL COMMENT 'aun maximo se 5',
  `tipo_horario` VARCHAR(20) DEFAULT NULL COMMENT 'tutor, consultor',
  `id_detalle_docente` INT(11) DEFAULT NULL COMMENT 'para saber aque sede pertence el horario',
  `eliminado` BIT(1) DEFAULT NULL COMMENT '1=si, 0=no',
  PRIMARY KEY (`id_horario`)
) ENGINE=MYISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

/*Table structure for table `materia` */

DROP TABLE IF EXISTS `materia`;

CREATE TABLE `materia` (
  `id_materia` INT(10) NOT NULL AUTO_INCREMENT,
  `materia` VARCHAR(200) NOT NULL,
  `id_departamento` INT(60) DEFAULT NULL,
  `curricula` VARCHAR(4) DEFAULT NULL,
  `idcarrera` INT(11) DEFAULT NULL,
  `ciclo` VARCHAR(6) DEFAULT NULL,
  `uv` VARCHAR(2) DEFAULT NULL,
  `ciclomateria` VARCHAR(6) DEFAULT NULL,
  `codigomateria` VARCHAR(15) DEFAULT NULL,
  `horasteoricas` INT(4) DEFAULT NULL,
  `horaspracticas` INT(4) DEFAULT NULL,
  `correlativo` INT(4) DEFAULT NULL,
  `ciclonumero` INT(2) DEFAULT NULL,
  `estado` INT(1) DEFAULT '1' COMMENT 'estado=1 materia activada',
  `esmateriabasica` INT(1) DEFAULT '1' COMMENT '1=si_es_basica  0=no_es_basica',
  PRIMARY KEY (`id_materia`)
) ENGINE=MYISAM AUTO_INCREMENT=188 DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=38 ROW_FORMAT=DYNAMIC;

/*Table structure for table `nt_inasistencias_alumno` */

DROP TABLE IF EXISTS `nt_inasistencias_alumno`;

CREATE TABLE `nt_inasistencias_alumno` (
  `idinasistenciaalumno` INT(11) NOT NULL AUTO_INCREMENT,
  `fechainasistencia` DATE DEFAULT NULL,
  `horas` INT(4) DEFAULT NULL,
  `carneta` VARCHAR(6) DEFAULT NULL,
  `carnetd` VARCHAR(20) DEFAULT NULL,
  `horaingreso` TIME DEFAULT NULL,
  `fechaingreso` DATE DEFAULT NULL,
  `idgrupodocentealumno` INT(11) DEFAULT NULL,
  `tipo` VARCHAR(15) DEFAULT NULL,
  PRIMARY KEY (`idinasistenciaalumno`)
) ENGINE=MYISAM AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;

/*Table structure for table `numprac` */

DROP TABLE IF EXISTS `numprac`;

CREATE TABLE `numprac` (
  `idpractica` INT(11) NOT NULL AUTO_INCREMENT,
  `practica` VARCHAR(20) DEFAULT NULL,
  `neje` INT(3) DEFAULT NULL,
  `evaluacion` INT(11) DEFAULT NULL,
  `idgrupodocente` INT(11) DEFAULT NULL,
  `estado` INT(1) DEFAULT '0' COMMENT '0=activo 1=inactivo',
  `negararchivosupfile` INT(1) DEFAULT '0' COMMENT '0=no   1=si',
  PRIMARY KEY (`idpractica`)
) ENGINE=MYISAM AUTO_INCREMENT=483 DEFAULT CHARSET=latin1;

/*Table structure for table `practicas` */

DROP TABLE IF EXISTS `practicas`;

CREATE TABLE `practicas` (
  `carnet` VARCHAR(8) NOT NULL,
  `idpractica` INT(11) NOT NULL,
  `cantecha` INT(4) DEFAULT NULL,
  `ejercicios` INT(4) DEFAULT NULL,
  `fecha` DATE DEFAULT NULL,
  `periodo` VARCHAR(8) DEFAULT NULL,
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `infejercicios` VARCHAR(200) DEFAULT NULL,
  `nota` FLOAT DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MYISAM AUTO_INCREMENT=7941 DEFAULT CHARSET=latin1;

/*Table structure for table `sc_grupos` */

DROP TABLE IF EXISTS `sc_grupos`;

CREATE TABLE `sc_grupos` (
  `idgruposc` INT(11) NOT NULL AUTO_INCREMENT,
  `nomgrupo` VARCHAR(100) DEFAULT NULL,
  `carneta` VARCHAR(10) DEFAULT NULL,
  PRIMARY KEY (`idgruposc`)
) ENGINE=MYISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


/*Table structure for table `t_usuario` */

DROP TABLE IF EXISTS `t_usuario`;

CREATE TABLE `t_usuario` (
  `id_tipo_usuario` INT(11) NOT NULL AUTO_INCREMENT,
  `tipo_usuario` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_tipo_usuario`)
) ENGINE=MYISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `idusuario` INT(11) NOT NULL AUTO_INCREMENT,
  `nombres` VARCHAR(255) NOT NULL,
  `apellidos` VARCHAR(255) NOT NULL,
  `direccion` VARCHAR(255) NOT NULL,
  `telefono` INT(9) NOT NULL,
  `id_tipo_usuario` INT(255) NOT NULL,
  `clave` VARCHAR(255) NOT NULL,
  `nick` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`idusuario`)
) ENGINE=MYISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `idusuario` VARCHAR(20) NOT NULL,
  `login` VARCHAR(200) NOT NULL,
  `clave` VARCHAR(200) NOT NULL,
  `tipo` VARCHAR(20) DEFAULT NULL,
  `eliminado` INT(1) DEFAULT '1' COMMENT '2=bloqueado,1=activo,0=eliminado',
  `privilegios` INT(1) DEFAULT NULL COMMENT '1=todos,2=ver',
  PRIMARY KEY (`idusuario`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
