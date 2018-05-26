<div class="res" style="padding-top: 65px;">
  <?php 

    //Funcion para seleccionar las prácticas
    $objAlumno = new alumnoModelo();
    $respuesta = $objAlumno->seleccionarPracticas($_SESSION['usuario']);
  ?>
  <div class="container">
    <h1 class="text-center">Subir Practicas</h1>
    <div align="center">
      <form action="">
        <label>Materia:
          <select name="materia" id="materia" class="form-control" onchange="cargarPracticas()">
            <option value="">--Seleccione Uno--</option>
            <?php
            $sql = "Select Modulo.idModulo, Modulo.nombreModulo, Modulo.tipoModulo from UsuarioActivo INNER JOIN Modulo ON UsuarioActivo.idModulo = Modulo.idModulo Where UsuarioActivo.carnet = '".$_SESSION['usuario']."'";
            $objBD = new funcionesBD();
            $res = $objBD->ConsultaPersonalizada($sql);
            while($fila = mysqli_fetch_assoc($res))
            {
              echo "<option value='".$fila['idModulo']."'>".$fila['nombreModulo']." (".$fila['tipoModulo'].")</option>";
            }
            ?>
        </select>
      </label>
    </form>
    </div>
    <div id="practicas">
      
    </div>
  </div>
</div>
<script type="text/javascript">
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
</script>