<div class="res" style="padding-top: 65px;">
    <?php

    # se crea una instancia de la clase alumnoModelo
    $objAlumno = new alumnoModelo();

    # se ejecuta la funcion para seleccionar las practicas
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

                        # se almacena la consulta encargada de listar los modulos inscritos
                        $sql = "Select Modulo.idModulo, Modulo.nombreModulo, Modulo.tipoModulo from UsuarioActivo INNER JOIN Modulo ON UsuarioActivo.idModulo = Modulo.idModulo Where UsuarioActivo.carnet = '" . $_SESSION['usuario'] . "'";

                        # se crea una instancia de la clase funcionesBD
                        $objBD = new funcionesBD();

                        # se ejecuta la consulta
                        $res = $objBD->ConsultaPersonalizada($sql);

                        # se recuperan los datos de la consulta y se generan los campos "option" del select
                        while ($fila = mysqli_fetch_assoc($res)) {
                            echo "<option value='" . $fila['idModulo'] . "'>" . $fila['nombreModulo'] . " (" . $fila['tipoModulo'] . ")</option>";
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