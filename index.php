<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistema Notas ITCA [Instalación]</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/cust.css">
    <link rel="stylesheet" href="assets/css/material-design-iconic-font.min.css">
</head>
<body>
<script src="assets/js/jquery-latest.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/cust.js"></script>
<script src="assets/node_modules/sweetalert/dist/sweetalert.min.js"></script>
<div class="container">

    <?php
    if (!isset($_GET['funcion'])) {
        ?>
        <div class="conts" style="display:none">
            <h1 class="text-center">
                Sistema de Notas ITCA-FEPADE
            </h1>
            <h3 class="text-center">
                Bienvenido al instalador de la Plataforma de notas de ITCA Regional Santa Ana.
                Por favor elija una de las siguientes opciones:
            </h3>
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-lg btn-block" data-toggle="modal" data-target="#instal">
                        <i class="zmdi zmdi-save"></i>&nbsp;Instalar
                    </button>
                </div>
                <div class="col-md-4"></div>
            </div>

            <div class="modal fade" id="instal" tabindex="-1" role="dialog" aria-labelledby="Install-Modal"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Instalar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Este proceso extraera las carpetas en la raiz de su servidor. Además se le solicitara su
                            usuario y
                            contraseña de su servidor de base de datos.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="cambio('index.php?funcion=f2')">
                                Aceptar y continuar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-secondary btn-lg btn-block" data-toggle="modal" data-target="#unins">
                        <i class="zmdi zmdi-delete"></i>&nbsp;Desintalar
                    </button>
                </div>
                <div class="col-md-4"></div>
            </div>

            <div class="modal fade" id="unins" tabindex="-1" role="dialog" aria-labelledby="Unin-Install-Modal"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Desinstalar</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Usted esta a punto de desinstalar el sistema de notas de<br>ITCA-FEPADE Regional Santa Ana.
                            <h6 class="font-weight-bold text-danger">¿Esta usted seguro que desea continuar?</h6>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary" onclick="cambio('index.php?funcion=f5')">
                                Aceptar y continuar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-lg btn-block" data-toggle="modal" data-target="#about">
                        <i class="zmdi zmdi-info"></i>&nbsp;Acerca de
                    </button>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>


        <div class="modal fade" id="about" tabindex="-1" role="dialog" aria-labelledby="About-Modal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Acerca de los Desarrolladores</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Marcelo Cerritos</li>
                            <li class="list-group-item">Roberto Funes</li>
                            <li class="list-group-item">Joaquín Barrientos</li>
                            <li class="list-group-item">Daniel Moreno</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>

        <?php
    } else {
        require_once 'php/' . $_GET['funcion'] . '.php';
    }
    ?>
</div>


</body>
</html>