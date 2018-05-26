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
                    <button class="btn btn-primary btn-lg" onclick="cambio('index.php?funcion=f2')">Instalar</button>
                </div>
                <div class="col-md-5"></div>
            </div>
            <div class="row">
                <div class="col-md-5"></div>
                <div class="col-md-2 text-center">
                    <button class="btn btn-danger btn-lg">Desintalar</button>
                </div>
                <div class="col-md-5"></div>
            </div>
            <div class="row">
                <div class="col-md-5"></div>
                <div class="col-md-2 text-center">
                    <button class="btn btn-success btn-lg">Acerca de</button>
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

<script src="assets/js/jquery-latest.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/cust.js"></script>
</body>
</html>