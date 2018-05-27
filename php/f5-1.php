<?php
require_once 'f4.php';

$act = new install($_POST['user'], $_POST['passwd'], '');
if ($act->desin('../DAW-PlataformaNotasITCA')) {
    ?>
    <script>
        swal({
            title: "Información",
            text: "Se ha eliminado Sistema Notas ITCA de su sitema",
            icon: "info",
            catch: {
                text: 'Ok',
                value: 'Ok'
            },
        });
    </script>
    <?php
}
?>
<style>
    .cev{
        padding-top: 25vh;
    }
</style>
<div class="cev">
    <button class="btn btn-info btn-block btn-lg" onclick="cambio('index.php');">
        Volver al inicio
    </button>
</div>
