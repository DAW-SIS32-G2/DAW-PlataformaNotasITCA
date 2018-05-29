<script type="text/javascript">
    $(document).ready(function(){
        verificarNotificaciones();
        setInterval(verificarNotificaciones(),5000);
    })

    function verificarNotificaciones()
    {
        $.ajax({
            type    : "post",
            url     : "ajax/notificaciones",
            data    : {"cont" : true},
            success : function(contador)
                      {
                         $("#cont").text(contador);
                      }
        })
        $.ajax({
          type    : "post",
            url     : "ajax/notificaciones",
            data    : {"antiguas" : true},
            success : function(contador)
                      {
                         $("#notificacionesAntiguas").html(contador);
                      }
        })
        $.ajax({
            type    : "post",
            url     : "ajax/notificaciones",
            data    : {"noti" : true},
            success : function(notificaciones)
                      {
                         $("#notificacionesNuevas").html(notificaciones);
                      },
            complete: function()
                      {
                         setTimeout(verificarNotificaciones, 5000);
                      }
        })
    }

    function leida(idnotis)
    {
        $.ajax({
            type    : "post",
            url     : "ajax/notificaciones",
            data    : {"leida": true, "idnotis" : idnotis},
            success : function(notificaciones)
                      {
                         if(notificaciones == 1)
                         {
                            swal({
                              text   : "Marcada como leída",
                              icon   : "success",
                              button : "Aceptar"
                            })
                         }
                         else
                         {
                            swal({
                              text   : notificaciones,
                              icon   : "error",
                              button : "Aceptar"
                            })
                         }
                      },
            complete: function()
                      {
                         setTimeout(verificarNotificaciones, 10);
                      }
        })
    }

    function eliminarNoti(idnotis)
    {
      $.ajax({
            type    : "post",
            url     : "ajax/notificaciones",
            data    : {"eliminarNoti": true, "idnotis" : idnotis},
            success : function(notificaciones)
                      {
                         if(notificaciones == 1)
                         {
                            swal({
                              text   : "Notificación Eliminada",
                              icon   : "success",
                              button : "Aceptar"
                            })
                         }
                         else
                         {
                            swal({
                              text   : notificaciones,
                              icon   : "error",
                              button : "Aceptar"
                            })
                         }
                      },
            complete: function()
                      {
                         setTimeout(verificarNotificaciones, 10);
                      }
        })
    }
</script>
<div class="container" style="padding-top:65px">
  <h1 class="text-center">Centro de Notificaciones</h1>
  <div class="row">
    <h3 class="text-justify">Notificaciones Nuevas</h3>
    <div id="notificacionesNuevas" class="col-md-12"></div>
  </div>
  <br>
  <div class="row">
    <h3 class="text-justify">Notificaciones Antiguas</h3>
    <div id="notificacionesAntiguas" class="col-md-12"></div>
  </div>
</div>