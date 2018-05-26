<nav class="navbar fixed-top navbar-expand-lg navbar-dark" style="background-color: #b0181d;">
  <a class="navbar-brand" href="<?= urlBase ?>docente">ITCA-FEPADE</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="<?= urlBase ?>docente"><i class="material-icons">home</i>&nbsp;Inicio <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="material-icons">event_note</i>&nbsp;Horarios
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?= urlBase ?>docente/mihorario">Mi horario</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?= urlBase ?>docente/horariogrupo">Horarios de mis grupos</a>
        </div>
      </li>
      <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="material-icons">assignment</i>&nbsp;Notas
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?= urlBase ?>docente/nota">Ingresar Nota</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?= urlBase ?>docente/progrupo">Consultar Promedios por Grupo</a>
        </div>
      </li>
      <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="material-icons">verified_user</i>&nbsp;Estudiantes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?= urlBase ?>docente/registrar">Registrar Estudiantes</a><div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?= urlBase ?>docente/inscribir">Inscribir Estudiantes al grupo</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?= urlBase ?>docente/restablecer">Restablecer clave del alumno</a>
        </div>
      </li>
      <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons">settings</i>&nbsp;
          Administración
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?= urlBase ?>docente/admingrupo">Administrar grupos activos</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?= urlBase ?>docente/estadoGrupos">Activar o desactivar grupos asignados</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?= urlBase ?>docente/adminarchivo">Administrar archivos</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?= urlBase ?>docente/cambiarclave">Cambiar clave docente</a>
        </div>
      </li>
      <li class="nav-item active dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="material-icons">create</i>&nbsp;Prácticas
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?= urlBase ?>docente/administrarPracticas">Administrar Prácticas</a>
          <!--<div class="dropdown-divider"></div>
          <a class="dropdown-item" href="<?= urlBase ?>docente/asigpract">Asignar Prácticas</a>-->
        </div>
      </li>
      <li class="nav-item active dropdown">
        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons">mail</i>&nbsp;Notificaciones</a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">No hay notificaciones nuevas</a>
        </div>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="<?= urlBase ?>logout"><i class="material-icons">arrow_back</i>&nbsp;Cerrar</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <!-- Usuario -->
      <li class="nav-item active">        
        <span class="nav-link">
          <i class="material-icons">person</i>&nbsp;Usuario: <?= $_SESSION['usuario'] ?>
        </span>
      </li>
    </ul>
  </div>
</nav>
