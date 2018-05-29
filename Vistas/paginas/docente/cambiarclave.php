<body style="padding-top:65px;">
<h1 class="text-center">Cambiar clave de acceso</h1>
<div class="container">
    <div class="row justify-content-md-center">
        <p>Utilice esta opción para cambiar su clave para acceder al sistema</p>
    </div>
    <div class="row justify-content-md-center">
        <form class="form-group" action="" method="post">
            <div class="form-group row">
                <label class="form-label" for="carnet">Nombre de Usuario (Carnet de docente): </label>
                <input type="text" class="form-control" id="carnet" name="carnet" maxlength="20" placeholder="Escriba el carnet aquí" required>
            </div>
            <div class="form-group row">
                <label class="form-label" for="clave">Ingrese su clave de docente actual</label>
                <input type="password" name="passOrig" id="passOrig" class="form-control" maxlength="20" required>
            </div>
            <div class="form-group row">
                <label class="form-label" for="clave">Ingrese su nueva clave</label>
                <input type="password" name="passN1" id="passN1" class="form-control" maxlength="20" required>
            </div>
            <div class="form-group row">
                <label class="form-label" for="clave">Confirme su nueva clave</label>
                <input type="password" name="passN2" id="passN2" class="form-control" maxlength="20" required>
            </div>
            <div class="form-group row">
                <button type="button" class="btn btn-primary btn-block" name="cambiar" onclick="cambiarPassDocente()">Cambiar Clave</button>
            </div>
        </form>
    </div>
</div>
<div class="row justify-content-md-center" id="respuesta">

</div>
</body>