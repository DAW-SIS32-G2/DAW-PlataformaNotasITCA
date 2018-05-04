<div class="res" style="padding-top: 65px;">
  <div class="container">
    <h1 class="text-center">Subir Practicas</h1>
    <table class="table-hover">
      <tr>
        <th>ID Practica</th>
        <th>Descripcion</th>
        <th>Cantidad de ejercicios</th>
        <th>Estado</th>
        <th>Subir</th>
        <th>Finalizar</th>
        <th>Porcentaje de subida</th>
      </tr>
      <!--Fila de ejemplo-->
      <tr>
        <td>1</td>
        <td>Guia de conexion a MySql</td>
        <td>5</td>
        <td>Pendiente</td>
        <td><form action="./php/subir.php" enctype="multipart/form-data" method="post">
          <label>
            <input type="file" class="form-control" name="guia">
          </label>
        </td>
        <td>
          <button class="btn btn-info">
            Subir Practica
          </button>
        </form></td>
        <td><div class="progress">
            <div class="bar"></div>
            <div class="percent">0%</div>
        </div>

        <div id="status"></div></td>
      </tr>
    </table>



    <script src="js/jquery-latest.js"></script>
    <script src="js/jquery.form.js"></script>
    <script>
        (function () {

            var bar = $('.bar');
            var percent = $('.percent');
            var status = $('#status');

            $('form').ajaxForm({
                beforeSend: function () {
                    status.empty();
                    var percentVal = '0%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                    console.log(percentVal, position, total);
                },
                success: function () {
                    var percentVal = '100%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                },
                complete: function (xhr) {
                    status.html(xhr.responseText);
                }
            });
        })();
    </script>
  </div>
</div>
