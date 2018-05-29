<?php
@session_start();
require_once("core/funcionesbd.php");
?>
<div class="container" style="padding-top: 65px">
	<h1 class="text-center">Programas y Utilidades</h1>
	<div class="row">
		<div class="col-md-12">
			<p class="text-justify">NOTA: Estos enlaces redirigen a páginas externas y debido a razones de optimización de red, pueda que no sea capaz de descargarlos. Si lo desea, también puede solicitar los programas a un docente.</p>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-responsive w-100 d-table">
				<thead class="thead-dark">
					<tr>
						<th width="15%">Programa</th>
						<th width="45%">Descripción</th>
						<th width="20%">Enlace de descarga</th>
						<th width="20%">Solicitar a un docente</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><strong>XAMPP</strong></td>
						<td><p class="text-justify">XAMPP es una distribución de Apache completamente gratuita y fácil de instalar que contiene MariaDB, PHP y Perl. El paquete de instalación de XAMPP ha sido diseñado para ser increíblemente fácil de instalar y usar.</p></td>
						<td><a href="https://www.apachefriends.org/es/index.html" target="_blank" class="btn btn-primary">Descargar</a></td>
						<td><button class="btn btn-primary" data-toggle="modal" data-target="#solicitar" data-carnet="<?= $_SESSION['usuario'] ?>" data-programa="XAMPP">Solicitar</button></td>
					</tr>
					<tr>
						<td><strong>Sublime Text</strong></td>
						<td><p class="text-justify">Sublime Text es un editor de texto y editor de código fuente está escrito en C++ y Python para los plugins. Desarrollado originalmente como una extensión de Vim, con el tiempo fue creando una identidad propia, por esto aún conserva un modo de edición tipo vi llamado Vintage mode.</p></td>
						<td><a href="https://www.sublimetext.com/3" target="_blank" class="btn btn-primary">Descargar</a></td>
						<td><button class="btn btn-primary" data-toggle="modal" data-target="#solicitar" data-carnet="<?= $_SESSION['usuario'] ?>" data-programa="Sublime Text">Solicitar</button></td>
					</tr>
					<tr>
						<td><strong>Code::blocks</strong></td>
						<td><p class="text-justify">Code::Blocks es un entorno de desarrollo integrado de código abierto, que soporta múltiples compiladores, que incluye GCC, Clang y Visual C++. Se desarrolló en C++ usando wxWidgets como el kit de herramientas GUI. Utilizando una arquitectura de complemento, sus capacidades y características están definidas por los complementos proporcionados. A la fecha octubre de 2017, Code::Blocks está orientado hacia C, C++ y Fortran. Tiene un sistema de compilación personalizado y un soporte de construcción opcional.</p></td>
						<td><a href="http://www.codeblocks.org/downloads" target="_blank" class="btn btn-primary">Descargar</a></td>
						<td><button class="btn btn-primary" data-toggle="modal" data-target="#solicitar" data-carnet="<?= $_SESSION['usuario'] ?>" data-programa="Code::Blocks">Solicitar</button></td>
					</tr>
					<tr>
						<td><strong>NetBeans</strong></td>
						<td><p class="text-justify">NetBeans es un entorno de desarrollo integrado libre, hecho principalmente para el lenguaje de programación Java. Existe además un número importante de módulos para extenderlo. NetBeans IDE es un producto libre y gratuito sin restricciones de uso.</p></td>
						<td><a href="https://netbeans.org/downloads/" target="_blank" class="btn btn-primary">Descargar</a></td>
						<td><button class="btn btn-primary" data-toggle="modal" data-target="#solicitar" data-carnet="<?= $_SESSION['usuario'] ?>" data-programa="NetBeans">Solicitar</button></td>
					</tr>
					<tr>
						<td><strong>Visual Studio Express</strong></td>
						<td><p class="text-justify">Microsoft Visual Studio Express Edition es un programa de desarrollo en entorno de desarrollo integrado (IDE, por sus siglas en inglés) para sistemas operativos Windows desarrollado y distribuido por Microsoft Corporation. Soporta varios lenguajes de programación tales como Visual C++, Visual C#, Visual J#, ASP.NET y Visual Basic .NET, aunque actualmente se han desarrollado las extensiones necesarias para muchos otros. Es de carácter gratuito y es proporcionado por la compañía Microsoft Corporation orientándose a principiantes, estudiantes y aficionados de la programación web y de aplicaciones, ofreciéndose dicha aplicación a partir de la versión 2005 de Microsoft Visual Studio.</p></td>
						<td><a href="https://www.visualstudio.com/es/vs/express/" target="_blank" class="btn btn-primary">Descargar</a></td>
						<td><button class="btn btn-primary" data-toggle="modal" data-target="#solicitar" data-carnet="<?= $_SESSION['usuario'] ?>" data-programa="Visual Studio Express">Solicitar</button></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal fade" id="solicitar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Solicitar Programa</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <?php
                    	$ojbBD = new funcionesBD();
                    	$sql = "SELECT DISTINCT Docente.carnet, CONCAT(Docente.nombres,' ',Docente.apellidos) as 'docente' FROM Docente INNER JOIN Departamento ON Docente.idDepartamento = Departamento.idDepartamento INNER JOIN Carrera ON Carrera.idDepartamento = Departamento.idDepartamento INNER JOIN Usuario ON Usuario.idCarrera = Carrera.idCarrera INNER JOIN Modulo ON Modulo.carnet = Docente.carnet INNER JOIN UsuarioActivo ON UsuarioActivo.idModulo = Modulo.idModulo WHERE Usuario.carnet = '".$_SESSION['usuario']."'";
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>