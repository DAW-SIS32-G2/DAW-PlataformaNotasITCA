<?php
# se almacena el usuario de la sesion
$usuario = $_SESSION['usuario'];
# se define la constante __ROOT__
define("__ROOT__", dirname(dirname(__FILE__, 3)));
# se incluye la clase funcionesBD
require_once(__ROOT__ . '/core/funcionesbd.php');
# se crea una nueva instancia de la clase docenteModelo
$objDocenteModelo = new DocenteModelo();
# Aca van las verificaciones de sesion y otras
?>
<body style="padding-top:65px">
<div class="container">
    <div class="text-center">
        <h1>Hoja de control de prácticas y laboratorios</h1>
    </div>
    <div class="row">
        <div class="col-lg-4"></div>
        <div class="col-lg-4 text-center">
            <form class="form-group" action="" method="post">
                <div class="form-inline">
                    <label class="form-label" for="grupo">Seleccione un grupo:</label>
                    <select class="form-control" name="grupo" onchange="consultarNotas(this.value)">
                        <?php
                        # se cargan los gupos disponibles
                        $resultado = $objDocenteModelo->CargarGruposActivos();

                        # se verifican los resultados
                        if (gettype($resultado) == "string") {
                            echo "Error al cargar los grupos...";
                        } else {
                            # se inicializa el contador en 0
                            $i = 0;

                            # se recuperan los datos de grupos
                            while ($arrayGrupos = $resultado->fetch_array(MYSQLI_ASSOC)) {
                                $nombreModulos[] = $arrayGrupos['nombreModulo'];
                                $nombreGrupos[] = $arrayGrupos['nombreGrupo'] . $arrayGrupos['seccion'];
                                $idModulos[] = $arrayGrupos['idModulo'];
                                $tipo[] = $arrayGrupos['tipoModulo'];
                                $i++;
                            }

                            # se cuenta el numero de grupos encontrados
                            $conteo = count($nombreModulos);
                            echo "<option value=''>--Seleccione una opcion--</option>";
                            # se imprimen los resultados
                            for ($j = 0; $j < $conteo; $j++) {
                                ?>
                                <option value='<?php echo $idModulos[$j]; ?>'>
                                    <?php echo $nombreGrupos[$j] . " - " . $nombreModulos[$j] . " (" . $tipo[$j] . ")"; ?>
                                </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </form>
        </div>
        <div class="col-lg-4"></div>
    </div>
    <div id="resultado">
        <!-- Acá se cargan los datos de AJAX -->
    </div>
</div>
</body>
<script type="text/javascript">
    function consultarNotas(val) {
        //procesar
        $.ajax({
            type: 'post',
            url: 'ajax/progrupo',
            data: {grupo: val},
            success: function (respuesta) {
                $('#resultado').html(respuesta);
            }
        });
    }
</script>
