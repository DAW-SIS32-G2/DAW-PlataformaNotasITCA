<nav class="navbar fixed-top navbar-expand-lg navbar-dark" style="background-color: #b0181d;">
  <a class="navbar-brand" href="<?= urlBase ?>docente">ITCA-FEPADE</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="<?= urlBase ?>docente">Inicio <span class="sr-only">(current)</span></a>
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
          <a class="nav-link" href="<?= urlBase ?>logout">Cerrar</a>
        </li>
    </ul>
  </div>
</nav>
