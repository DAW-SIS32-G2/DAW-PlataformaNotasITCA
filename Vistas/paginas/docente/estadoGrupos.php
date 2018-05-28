<?php
echo '<div class="container" style="padding-top: 65px">';

# se define la constante __ROOT__
define("__ROOT__", dirname(__FILE__, 4));

# se incluye la clase funcionesBD
require_once(__ROOT__ . '/core/funcionesbd.php');

# se crea una nueva instancia de la clase docenteControlador
$objDocenteModelo = new docenteModelo();

# se verifica la accion
if (isset($_REQUEST['activarGrupo'])) {

    # se almacena el identificador del modulo en cuestion
    $idModulo = $_REQUEST['idModulo'];

    # se crea una nueva instancia de la clase docenteControlador
    $objDocenteControlador = new docenteControlador('docenteModelo');

    # se ejecuta la consulta
    $resultado = $objDocenteControlador->activarModulo($idModulo);

    # se verifica el resultado
    if (gettype($resultado) == "string") {
        ?>
        <script type="text/javascript">
            swal({
                text: "<?= $resultado ?>",
                icon: "error",
                button: "Aceptar"
            });
        </script>
        <?php
    } else {
        ?>
        <script type="text/javascript">
            swal({
                text: "El módulo ha sido activado",
                icon: "success",
                button: "Aceptar"
            });
        </script>
        <?php
    }
}

?>
<table class="table table-bordered table-light table-hover">
    <thead>
    <tr>

        <th scope="col">ID</th>
        <th scope="col">Grupo</th>
        <th scope="col">Modulo</th>
        <th scope="col">Opciones</th>

    </tr>
    </thead>
    <tbody>
    <?php
    # se cargan todos los grupos
    $resultado = $objDocenteModelo->CargarGrupos();

    # se verifica el resultado
    if (gettype($resultado) == "string") {
        echo $resultado;
    } else {

        # se transfiere el resultado a una nueva variable
        $res = $resultado;

        # se recupera el numero de filas afectadas
        $cantidad = $res->num_rows;

        # se guardan los grupos en un arreglo
        unset($idModulo);
        $i = 0;
        while ($arrayGrupos = $resultado->fetch_array(MYSQLI_ASSOC)) {
            $idModulo[$i] = $arrayGrupos['idModulo'];
            $nombreGrupos[$i] = $arrayGrupos['nombreGrupo'];
            $seccion[$i] = $arrayGrupos['seccion'];
            $anyoGrupos[$i] = $arrayGrupos['anyo'];
            $nombreModulos[$i] = $arrayGrupos['nombreModulo'];
            $estadoGrupo[$i] = $arrayGrupos['activo'];
            $i++;
        }

        # se imprimen los datos
        for ($k = 0; $k < $cantidad; $k++) {

            ?>

            <tr>

                <td scope="row">
                    <?php echo $idModulo[$k]; ?>
                </td>

                <td>
                    <?= $nombreGrupos[$k] . $seccion[$k] . "-" . $anyoGrupos[$k] ?>
                </td>

                <td>
                    <?php echo $nombreModulos[$k]; ?>
                </td>

                <td>
                    <?php
                    if ($estadoGrupo[$k] == 1) {
                        echo '<div class="alert alert-success">El grupo esta activo</div>';
                    } elseif ($estadoGrupo[$k] == 0) {
                        ?>
                        <form action="" method="post">
                            <input type="hidden" name="idModulo" value="<?= $idModulo[$k] ?>">
                            <button class="btn btn-info" name="activarGrupo">Activar<br>modulo</button>
                        </form>
                        <?php
                    }
                    ?>
                </td>

            </tr>

        <?php }

    }

    ?>
    </tbody>
</table>
<br><br>
</div>