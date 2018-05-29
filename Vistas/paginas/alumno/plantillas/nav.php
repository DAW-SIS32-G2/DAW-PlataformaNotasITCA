<nav class="navbar navbar-expand-lg fixed-top navbar-dark" style="background-color: #b0181d !important; color: #fff;">
    <a class="navbar-brand" style="" href="#">Sistema de notas</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link nav-but" href="<?= urlBase ?>alumno"><i class="material-icons">home</i>&nbsp;Inicio</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link nav-but" href="<?= urlBase ?>alumno/actualizar"><i class="material-icons">update</i>&nbsp;Actualizar Datos</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link nav-but" href="<?= urlBase ?>alumno/notas"><i class="material-icons">assignment_turned_in</i>&nbsp;Notas</a>
            </li>
            <li class="nav-item dropdown active">
                <a class="nav-link nav-but dropdown-toggle"  id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">dashboard</i>&nbsp;Servicios
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item nav-but" href="<?= urlBase ?>alumno/programas">Programas</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item nav-but" href="<?= urlBase ?>alumno/buzon_archivos">Buz&oacute;n de Archivos</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item nav-but" href="<?= urlBase ?>alumno/html5">HTML5</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item nav-but" href="<?= urlBase ?>alumno/editor">Editor Web Html</a>
            </li>
            <li class="nav-item dropdown active">
                <a class="nav-link nav-but dropdown-toggle"  id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">assignment</i>&nbsp;Modulos
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item nav-but" href="<?= urlBase ?>alumno/guias">Guias</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item nav-but" href="<?= urlBase ?>alumno/subir_Prac">Subir Practicas</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item nav-but" href="<?= urlBase ?>alumno/inscribir">Inscribir</a>
                </div>
            </li>
            <li class="nav-item dropdown active">
                <a class="nav-link nav-but dropdown-toggle"  id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">mail</i>&nbsp;Notificaciones&nbsp;<span class="badge badge-pill badge-light" id="cont"></span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown" id="notificaciones">
                               
                </div>
            </li>
            <li class="nav-item active">
                <a class="nav-link nav-but" href="<?= urlBase ?>logout"><i class="material-icons">arrow_back</i>&nbsp;Cerrar</a>
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
<script type="text/javascript">
    $(document).ready(function(){
        verificarNotificaciones();
        setInterval(verificarNotificaciones(),5000);
    })

    function verificarNotificaciones()
    {
        $.ajax({
            type    : "post",
            url     : "ajax/nav",
            data    : {"cont" : true},
            success : function(contador)
                      {
                         $("#cont").text(contador);
                      }
        })

        $.ajax({
            type    : "post",
            url     : "ajax/nav",
            data    : {"noti" : true},
            success : function(notificaciones)
                      {
                         $("#notificaciones").html(notificaciones);
                      },
            complete: function()
                      {
                         setTimeout(verificarNotificaciones, 5000);
                      }
        })
    }
</script>
