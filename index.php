<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mover Algo</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/cust.css">
</head>
<body>
<script src="assets/js/jquery-latest.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/cust.js"></script>
<div class="container">
    <?php
    if (!isset($_GET['funcion'])) {
        ?>
        <div class="conts" style="display:none">
            <h1>
                Sistema de Notas ITCA-FEPADE
            </h1>
            <h3 class="text-center">Opciones</h3>
            <div class="row">
                <div class="col-md-5"></div>
                <div class="col-md-2 text-center">
                    <button class="btn btn-primary btn-lg btn-block" onclick="cambio('index.php?funcion=f2')">Instalar</button>
                    <span class="text-muted">
                        Este proceso extraera las carpetas en la raiz de su servidor. Además se le solicitara su usuario y
                        contraseña de su servidor de base de datos.
                    </span>
                </div>
                <div class="col-md-5"></div>
            </div>
            <div class="row">
                <div class="col-md-5"></div>
                <div class="col-md-2 text-center">
                    <button class="btn btn-danger btn-lg btn-block" onclick="cambio('index.php?funcion=f5')">Desintalar</button>
                </div>
                <div class="col-md-5"></div>
            </div>
            <div class="row">
                <div class="col-md-5"></div>
                <div class="col-md-2 text-center">
                    <button class="btn btn-success btn-lg btn-block">Acerca de</button>
                </div>
                <div class="col-md-5"></div>
            </div>
        </div>



        <?php
    }else{
        require_once 'php/'.$_GET['funcion'].'.php';
    }
    ?>
</div>


</body>
</html>