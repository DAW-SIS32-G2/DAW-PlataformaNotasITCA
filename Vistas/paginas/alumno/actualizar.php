<div id="da" style="padding-top:65px;">
    <div class="container">

        <div class="row">
            <div class="col-md-2">
                <div class="card" style="border-color: red;">
                    <div class="card-body">
                        <img src="<?= imagenes ?>foto.png" alt="Foto" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="col-md-10">

                <form action="">
                    <div class="row">
                        <label class="col-md-5">Carnet
                            <input type="text" value="" class="form-control" readonly>
                        </label>
                    </div>
                    <div class="row">
                        <label class="col-md-12">Apellidos:
                            <input type="text" value="" class="form-control" readonly>
                        </label>
                    </div>
                    <div class="row">
                        <label class="col-md-12">Nombres:
                            <input type="text" value="" class="form-control" readonly>
                        </label>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <label>Tel&eacute;fono:
                                <input type="tel" name="tel" class="form-control"
                                       id="tel">
                            </label>
                        </div>
                        <div class="row">
                            <label>Jornada:
                                <input type="text" value="" class="form-control">
                            </label>
                        </div>
                        <div class="row">
                            <label>Sexo:
                                <select name="" id="sexo" class="form-control">
                                    <option value="m">Masculino</option>
                                    <option value="f">Femenino</option>
                                </select>
                            </label>
                        </div>
                        <div class="row">
                            <label>Grupo:
                                <select name="" id="group" class="form-control">
                                    <option value=""></option>
                                </select>
                            </label>
                        </div>
                        <div class="row">
                            <label>Correo Electronico:
                                <input type="text" value="" class="form-control">
                            </label>
                        </div>
                        <div class="row">
                            <label>Cambiar Contraseña:
                                <button class="btn btn-info" type="button"
                                        data-toggle="modal" data-target="#mod">Cambiar
                                </button>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // document.getElementById('tel').addEventListener('keypress', tel);

        function vali(e) {
            var key = window.event ? e.keyCode : e.which;
            return (48 <= key && key <= 57) || (key == 0) || (key == 8);
        }

        function tel(event) {
            var pat = /[1-9]/;
            var key = keyd.which || keyd.keyCode,
                value = keyd.target.value,
                n = value + String.fromCharCode(key);
            var ok = pat.exec(n);
            if (!ok) {
            } else {
                keyd.preventDefault();
            }
        }
    </script>
</div>

<div class="modal fade" id="mod" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cambio de contraseña</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form class="form-group" action="index.html" method="post">
            <div class="modal-body">

                   <div class="container-fluid">
                       <div class="form-group row">
                           <input class="form-control" type="password" placeholder="Clave actual" required>
                       </div>
                       <div class="form-group row">
                           <input class="form-control" type="password" placeholder="Nueva Clave" required>
                       </div>
                       <div class="form-group row">
                           <input class="form-control" type="password" placeholder="Repetir Nueva Clave" required>
                       </div>
                   </div>
            </div>


            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary" data-dismiss="modal">Enviar</button>
                <button type="button" class="btn btn-primary">Cerrar</button>
            </div>
            </form>
        </div>
    </div>
</div>
﻿
