<nav class="navbar navbar-expand-lg fixed-top navbar-dark" style="background-color: #b0181d !important; color: #fff;">
    <a class="navbar-brand" style="" href="#">Sistema de notas</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link nav-but" href="<?= urlBase ?>alumno">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-but" href="<?= urlBase ?>alumno/actualizar">Actualizar Datos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-but" href="<?= urlBase ?>alumno/notas">Notas</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link nav-but dropdown-toggle"  id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Servicios
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item nav-but">Programas</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item nav-but" href="<?= urlBase ?>alumno/buzon_archivos">Buz&oacute;n de Archivos</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link nav-but dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Servicios Estudiantiles
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item nav-but">Editor Web Html</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item nav-but" href="<?= urlBase ?>alumno/practica_prof">Practica Profesional</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item nav-but">Historial</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link nav-but dropdown-toggle"  id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Modulos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item nav-but" href="<?= urlBase ?>alumno/guias">Guias</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item nav-but" href="<?= urlBase ?>alumno/subir_Prac">Subir Practicas</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item nav-but" href="<?= urlBase ?>alumno/inscribir">Inscribir</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link nav-but dropdown-toggle"  id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Otros
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item nav-but" >HTML5</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item nav-but" >Grupos</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-but" href="<?= urlBase ?>logout">Cerrar</a>
            </li>
        </ul>
    </div>
</nav>
