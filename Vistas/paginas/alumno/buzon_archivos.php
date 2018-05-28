<?php
require_once("core/funcionesbd.php");
$sql = "SELECT BuzonArchivo.estado, CONCAT(Usuario.nombres,' ',Usuario.apellidos) as estudiante, foto FROM BuzonArchivo INNER JOIN Grupo ON Grupo.idGrupo = BuzonArchivo.idGrupo INNER JOIN Usuario ON Usuario.idGrupo = Grupo.idGrupo WHERE carnet='".$_SESSION['usuario']."'";
$objBD = new funcionesBD();
$res = $objBD->ConsultaPersonalizada($sql);
while($fila = mysqli_fetch_assoc($res))
{
    $nombreAlumno = $fila['estudiante'];
    $foto = $fila['foto'];
    $estado = $fila['estado'];
}
$objModelo = new alumnoModelo();
?>
<div class="container" style="padding-top:65px;">
   <div class="row">
        <div class="col-md-2">
            <div class="card" style="border-color: red;">
                <div class="card-body">
                    <?php
                            if($foto != "")
                            {
                                ?>
                                <img src="<?= $foto ?>" alt="Foto" class="img-fluid">
                                <?php
                            }
                            else
                            {
                                ?>
                                <img src="<?= imagenes ?>foto.png" alt="Foto" class="img-fluid">
                                <?php
                            }
                        ?>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <h3>Nombre del Estudiante: <?= $nombreAlumno ?></h3>
            <h4>Carnet: <?= $_SESSION['usuario'] ?></h4>
            <?php
            if($estado == 1)
            {
                ?>
                <div class="container">
                    <div class="row">
                        <form action="" method="post" enctype="multipart/form-data" class="form-group col-md-12" id="subirArchivo">
                            <div class="form-group row">
                                <label class="col-md-2 form-label" for="f">Subir Un Archivo</label>
                                <input type="file" name="subir" id="f" class="col-md-6 form-control" >
                                <input type="submit" value="Subir" class="col-md btn btn-info">
                            </div>
                            <div class="form-group row">
                                <div class="col" id="respuesta"></div>
                            </div>
                        </form>
                    </div>
                    <br>
                    <div class="row">
                        <div class="card col-md-12">
                            <div class="card-header">
                                <h5>Lista de archivos subidos</h5>
                            </div>
                            <div class="card-body">
                                <?php
                                $objModelo->BuscarBuzon($_SESSION['usuario']);
                                ?>
                            </div>
                            <span></span>
                        </div>
                    </div>
                </div>
                <?php
            }
            else
            {
                ?>
                <div class="container">
                    <div class="alert alert-warning">
                        <strong>El buzón de archivos está desactivado para este grupo, comuníquese con su docente para más información</strong>
                    </div>
                </div>
                <?php
            }
            ?>
    </div>
</div>
<div class="modal fade" id="compartirMod" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Compartir Archivo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div id="compartir"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="enviarMod" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Compartir Archivo</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="form-group row">
                        <label class="form-label">
                            Token:
                        </label>
                        <input class="form-control" type="text" name="" id="inpToken" readonly>
                    </div>
                    <div class="form-group row">
                        <label class="form-label">
                            Carnet del destinatario
                        </label>
                        <input class="form-control" type="text" name="" id="inpDestinatario" >
                        <div id="validDest"></div>
                    </div>
                    <div class="form-group row">
                        <button class="btn btn-info" onclick="validarDestinatario()">Enviar Token</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function eliminar(archivo,idarchivo)
    {   
        $.ajax({
            type    : "post",
            url     : "ajax/buzon",
            data    : {"archivo" : archivo ,"idarchivo" : idarchivo, "eliminar" : true },
            success : function(mensaje)
                      {
                        if(mensaje == 1)
                        {
                            swal({
                                text    : "Archivo eliminado correctamente",
                                icon    : "success",
                                button  : "Aceptar"
                            }).then((value) => {
                                document.location.reload();
                            });
                        }
                        else
                        {
                            swal({
                                text    : mensaje,
                                icon    : "error",
                                button  : "Aceptar"
                            });
                        }
                      }
        })
    }

    function compartir(id)
    {
        $.ajax({
            type    : "post",
            url     : "ajax/buzon",
            data    : {"id" : id, "compartir" : true },
            success : function(mensaje)
                      {
                        $("#compartir").html(mensaje);
                      }
        })
    }

    $("#compartirMod").on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        compartir(id);
    })

    $("#subirArchivo").on("submit", function(e){
        e.preventDefault();
        var f = $(this);

        var formData = new FormData(document.getElementById("subirArchivo"));
        formData.append("subir",true);
        formData.append("disponible",$("#dispon").val())

        $.ajax({
            type        : "post",
            url         : "ajax/buzon",
            dataType    : "html",
            data        : formData,
            contentType : false,
            processData : false
        })
        .done(function(res){
            $("#respuesta").html(res);
        });
    });

    function generarToken(idarchivo)
    {
        $.ajax({
            type    : "post",
            url     : "ajax/buzon",
            data    : {"idarchivo" : idarchivo, "generarToken" : true },
            success : function(mensaje)
                      {
                        if(mensaje == 1)
                        {
                            $("#compartirMod").modal('hide');
                            swal({
                                text: "Se ha generado su token\n Presione nuevamente en Compartir para ver el nuevo token",
                                icon: "success",
                                button: "aceptar"
                            })
                        }
                        else
                        {
                            swal({
                                text: mensaje,
                                icon: "error",
                                button: "aceptar"
                            })   
                        }
                      }
        })
    }

    function enviarToken(token,destinatario)
    {
        $.ajax({
            type    : "post",
            url     : "ajax/buzon",
            data    : {"token" : token, "destinatario" : destinatario, "enviarToken" : true },
            success : function(mensaje)
                      {
                        if(mensaje == 1)
                        {
                            $("#inpDestinatario").val("");
                            $("#enviarMod").modal('hide');
                            swal({
                                text: "Se ha enviado el token correctamente",
                                icon: "success",
                                button: "aceptar"
                            })
                        }
                        else
                        {
                            swal({
                                text: mensaje,
                                icon: "error",
                                button: "aceptar"
                            })   
                        }
                      }
        })
    }

    function eliminarToken(idarchivo)
    {
        $.ajax({
            type    : "post",
            url     : "ajax/buzon",
            data    : {"idarchivo" : idarchivo, "eliminarToken" : true },
            success : function(mensaje)
                      {
                        if(mensaje == 1)
                        {
                            $("#compartirMod").modal('hide');
                            swal({
                                text: "El token fue eliminado",
                                icon: "success",
                                button: "aceptar"
                            })
                        }
                        else
                        {
                            swal({
                                text: mensaje,
                                icon: "error",
                                button: "aceptar"
                            })   
                        }
                      }
        })
    }

    function renovarToken(idarchivo)
    {
        $.ajax({
            type    : "post",
            url     : "ajax/buzon",
            data    : {"idarchivo" : idarchivo, "renovarToken" : true },
            success : function(mensaje)
                      {
                        if(mensaje == 1)
                        {
                            $("#compartirMod").modal('hide');
                            swal({
                                text: "Token renovado\n Presione nuevamente en Compartir para ver el nuevo token",
                                icon: "success",
                                button: "aceptar"
                            })
                        }
                        else
                        {
                            swal({
                                text: mensaje,
                                icon: "error",
                                button: "aceptar"
                            })   
                        }
                      }
        })
    }

    function cargarDestinatario(token)
    {
        $("#inpToken").val(token);
        $("#enviarMod").modal("show");
    }

    function validarDestinatario()
    {
        var destinatario = $("#inpDestinatario").val();
        var token = $("#inpToken").val();

        $.ajax({
            type    : "post",
            url     : "ajax/buzon",
            data    : {"destinatario" : destinatario, "buscarDest" : true },
            success : function(mensaje)
                      {
                        if(mensaje == 1)
                        {
                            enviarToken(token,destinatario);
                        }
                        else
                        {
                            $("#validDest").html("<p><small style='color:red'>"+mensaje+"</small></p>");
                        }
                      }
        })
    }
</script>
