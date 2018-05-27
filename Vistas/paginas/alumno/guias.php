<div class="container" style="padding-top: 65px">
  <h1>
  Guias Disponibles
  </h1>
  <form action="">
    <label>Materia:
      <select name="materia" id="materia" class="form-control" onchange="buscarGuias()">
        <option value="">--Seleccione Uno--</option>
        <?php
        # se selecciona los datos del modulo para presentarlos al alumno
        $sql = "Select Modulo.idModulo, Modulo.nombreModulo, Modulo.tipoModulo from UsuarioActivo INNER JOIN Modulo ON UsuarioActivo.idModulo = Modulo.idModulo Where UsuarioActivo.carnet = '".$_SESSION['usuario']."'";

        # se crea una instancia de la clase funcionesBD
        $objBD = new funcionesBD();

        # se ejecuta el codigo sql
        $res = $objBD->ConsultaPersonalizada($sql);

        # se crean de forma dinamica las opciones dependiendo del numero de guias
        while($fila = mysqli_fetch_assoc($res))
        {
        echo "<option value='".$fila['idModulo']."'>".$fila['nombreModulo']." (".$fila['tipoModulo'].")</option>";
        }
        ?>
      </select>
    </label>
  </form>
  <div id="guias">
    
  </div>
</div>
