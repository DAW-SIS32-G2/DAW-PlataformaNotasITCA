
<div class="container" style="padding-top:65px">
    <h3 class="text-center">Nombre del Estudiante: <!--poner el nombre con php aqui--></h3>
    <h4 class="text-center">Carnet: <!--poner el numero de carnet con php aqui--></h4>
    <div class="row">
        <div class="col-md-2">
            <div class="card" style="border-color: red;">
                <div class="card-body">
                    <img src="<?= imagenes ?>foto.png" alt="Foto" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="container-fluid">

                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Tipo de Solicitud
                                <input class="form-control" required type="text">
                            </label>
                            <label>Alumno:
                                <input class="form-control" required type="text">
                            </label>
                            <label>Contacto:
                                <input class="form-control" required type="text">
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label>Grupo:
                                <input class="form-control" required type="text">
                            </label>
                            <label>Municipio:
                                <input class="form-control" required type="text">
                            </label>
                            <label>Empresa:
                                <input class="form-control" required type="text">
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Actividad a Realizar
                                <textarea required class="form-control" name="" id="" cols="74" rows="3"></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
