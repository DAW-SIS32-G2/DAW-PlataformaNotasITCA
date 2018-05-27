function buscarGuias()
{
  $.ajax({
    type    : "post",
    url     : "ajax/guias",
    data    : {"idmodulo" : $("#materia").val()},
    success : function(guias)
              {
                $("#guias").html(guias);
              }
  })
}

function descargar(archivo)
{
  $.ajax({
        type      : 'post',
        url       : 'ajax/procesarDescarga',
        data      : {ruta: archivo},
        success   : function(respuesta)
        {
          window.location.href="descargar";
        }
    });
  
}



function actualizarmisDatos()
{
    var carnet = $("#carnet").val();
    var telefono = $("#telefono").val();
    var sexo = $("#sexo").val();
    var correo = $("#email").val();
    var jornada = $("#jornada").val();

    $.ajax({
        type    : "post",
        url     : "ajax/actualizarDatos",
        data    : {
                    "funcion"   : 1,
                    "carnet"    : carnet,
                    "telefono"  : telefono,
                    "sexo"      : sexo,
                    "jornada"   : jornada,
                    "correo"    : correo
                  },
        success : function(mensaje)
                {
                    if(mensaje == 1)
                    {
                        swal({
                            text    : "Sus datos se actualizaron correctamente",
                            icon    : "success",
                            button  : "Aceptar"
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

function visualizar()
{
  $.ajax({
    type  : "post",
    url   : "ajax/resultadoEditor",
    data  : {
           "html" : $("#html").val(),
           "css"  : $("#css").val(),
           "js" : $("#js").val()
          },
    success : function(mensaje)
          {
              $("#resultado").html(mensaje);
              var iframe = document.getElementById("res");
              iframe.src = iframe.src;
          }
  })
}

$("#inscribirSinClave").on("hidden.bs.modal", function(e) {
  location.reload();
})

$("#inscribirModal").on("hidden.bs.modal", function(e) {
  $("#inscribirModal").modal('dispose')
  $("#resspass").html("")
  $("#pass").val("")
})

function mandarModulo(valor)
{
  $("#idenModulo").attr("value",valor)
}

function inscribirConClave()
{
  $.ajax({
      type    : "post",
      url     : "ajax/inscribir",
      data    : {
                    "carnet"   : $("#carnetIns").val(),
                    "idModulo" : $("#idenModulo").val(),
                    "contra"   : $("#pass").val()
                },
      success : function(mensaje)
                {
                    if(mensaje == '1')
                    {
                        $("#resspass").html("<small style='color: red'>La clave es incorrecta, intente nuevamente</small>")
                    }
                    else
                    {
                        $("#inscribirModal").modal('hide');
                        $("#inscribirSinClave").modal('show');
                        $("#inscribirModal").modal('dispose');
                    }    
                }
  });
}

function inscribirSinClave(valor,carnet)
{
  $.ajax({
    type      : "post",
    url       : "ajax/inscribir",
    data      : {
                  "carnet"   : carnet,
                  "idModulo" : valor,
                  "sinClave" : 1
                },
    success   : function(mensaje)
                {
                  if(mensaje != "1")
                  {
                    $("#mensajeError").html(mensaje);
                    $("#errorModal").modal('show');
                  }
                  else
                  {
                    $("#inscribirSinClave").modal('show');
                  }
                }
  });
}

function cargarPracticas()
{
  $.ajax({
    type    : "post",
    url     : "ajax/practicas",
    data    : {"idModulo" : $("#materia").val()},
    success : function(practicas)
              {
                $("#practicas").html(practicas);
              }
  })
}