<script type="text/javascript">
function proceso(val)
{
  //Procesar
  $.ajax({
      type      : 'post',
      url       : 'ajax/horariogrupo',
      data      : {grupo:val},
      success   : function(respuesta)
      {
        document.getElementById('resultado').innerHTML = respuesta;
      }
  })

}
</script>
<body style="padding-top:65px;">
  <div class="container">
    <div class="text-center">
      <form class="form-group" method="post">
          <div class="form-inline">
            <label for="grupo" class="col-lg-4">Seleccione un grupo</label>
            <select class="form-control col-lg-4" name="grupo" id="grupo" onchange="proceso(this.value);" >
              <option value="">Seleccione Uno...</option>
              <option value="Grupo 1">Grupo 1</option>
              <option value="Grupo 2">Grupo 2</option>
              <option value="Grupo 3">Grupo 3</option>
              <option value="Grupo 4">Grupo 4</option>
            </select>
          </div>
      </form>
    </div>
    <div id="resultado">
      <!--Acá cargara el resultado del fetch-->
    </div>
  </div>
</body>
