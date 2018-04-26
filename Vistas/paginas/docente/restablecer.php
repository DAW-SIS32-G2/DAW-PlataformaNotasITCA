<body style="padding-top:65px;">
  <div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
      <div class="col-12">
        <div class="text-center">
          <h1>Restablecer Clave del alumno</h1>
          <form class="form-inline justify-content-center" method="post">
            <div class="form-group mb-2">
              <input type="text" readonly class="form-control-plaintext" id="lblcarnet" value="Numero de Carnet:">
            </div>
            <div class="form-group mx-sm-3 mb-2">
              <input type="text" class="form-control" name="carnet" pattern="[0-9]{6}" maxlength="6" placeholder="Escriba el carnet aquí" required>
            </div>
            <button type="button" class="btn btn-primary mb-2" onclick="cambiarPass()">Borrar Clave</button>
          </form>
          <div id="respuesta"></div>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    function cambiarPass()
    {
      $.ajax({
        type    : 'post',
        url     : 'ajax/res',
        data    : {carnet : $('input[name=carnet]').val()},
        success : function(respuesta)
        {
          $('#respuesta').html(respuesta)
        }
      })
    }
  </script>

</body>
