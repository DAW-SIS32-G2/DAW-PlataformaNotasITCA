<?php
session_start();
$usuario = $_SESSION['usuario'];
// Acá deberá ir el código de sesión y fetching de base de datos
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../res/css/bootstrap.min.css">
    <link rel="stylesheet" href="../res/css/iconic/font/css/open-iconic-bootstrap.min.css">
    <script src="../res/js/jquery.min.js"></script>
    <script src="../res/js/popper.min.js"></script>
    <script src="../res/js/bootstrap.min.js"></script>
    <title>ITCA Docentes</title>
  </head>
  <body style="padding-top:65px;">
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark" style="background-color: #b0181d;">
      <a class="navbar-brand" href="index.php">ITCA-FEPADE</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Horarios
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="?pg=mihorario">Mi horario</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="?pg=horariogrupo">Horarios de mis grupos</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Notas
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="?pg=progrupo">Consultar Promedios por Grupo</a>
            </div>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Estudiantes
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="?pg=nota">Ingresar Nota</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="?pg=inscribir">Inscribir estudiantes al grupo</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="?pg=restablecer">Restablecer clave del alumno</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Administración
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="?pg=admingrupo">Administrar grupos activos</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="?pg=actgrupo">Activar o desactivar grupos asignados</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="?pg=adminarchivo">Administrar archivos</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="?pg=cambarclave">Cambiar clave</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Prácticas
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="?pg=adminpract">Administrar Prácticas</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="?pg=asigpract">Asignar Prácticas</a>
            </div>
          </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Proyectos de materia
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="?pg=propuestas">Propuestas</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="?pg=grupoproy">Grupos</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="?pg=asigjurado">Asignar jurados</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="?pg=fases">Fases</a>
              </div>
            </li>
            <li class="nav-item right">
              <a class="nav-link" href="logout.php">Cerrar</a>
            </li>
        </ul>
      </div>
    </nav>
    <!-- Inicia el contenido de la página -->
    <div class="container h-100">
          <!-- Acá irán todos los form de las diversas paginas -->
          <?php
            if(isset($_GET['pg']))
            {
              include_once($_GET['pg'].".php");
            }
            else {
              ?>
              <div class="row">
                <div class="col-lg-4">
                  <img class="img-fluid" src="../res/img/logo.png"  width="315" height="70">
                </div>
                <div class="col-lg-8">
                  <h2>Escuela Especializada en Ingeniería ITCA-FEPADE</h2>
                  <h2>Regional Santa Ana</h2>
                </div>
              </div>
              <div class="row">
                <!-- Acá iría el nombre del Ingeniero segun la BD -->
                <div class="col-lg-12 text-center">
                  <h1>Bienvenido <?php echo $usuario; ?></h1>
                </div>
              </div>
              <?php
            }
              ?>
    </div>
  </body>
</html>
