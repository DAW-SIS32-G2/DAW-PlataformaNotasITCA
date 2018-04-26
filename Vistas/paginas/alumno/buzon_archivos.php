<div class="container" style="padding-top:65px;">
    <div class="row">
        <div class="col-md-2">
            <div class="card" style="border-color: red;">
                <div class="card-body">
                    <img src="<?= imagenes ?>foto.png" alt="Foto" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <h3 contenteditable="true">Nombre del Estudiante: <!--poner el nombre con php aqui--></h3>
            <h4>Carnet: <!--poner el numero de carnet con php aqui--></h4>
            <form action="" enctype="multipart/form-data">
                <label for="f">Subir Un Archivo</label>
                <input type="file" name="subir" id="f" class="form-control col-md-9 btn btn-secondary" >
            </form>
            <div class="row col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Lista de archivos subidos</h5>
                    </div>
                    <div class="card-body">
                        <table class="table-hover table-bordered">
                            <tr style="background-color: #9f0b06; color: #fff;">
                                <th class="col-md-9">Nombre </th>
                                <th class="col-md-3">Tamaño</th>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer">
                        Tamaño maxino total: 35MB
                    </div>
                </div>
                <span></span>
            </div>
        </div>
    </div>
</div>
