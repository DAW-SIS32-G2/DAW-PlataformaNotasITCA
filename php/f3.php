<div class="conts" style="display:none">
    <h3 class="text-muted">Se esta procesando la instalación</h3>
    <?php
    require_once 'f4.php';
    $act = new instalar($_POST['user'], $_POST['passwd']);
    $act->createDB();
    $act->unzip('/prueba/recursos/sisNotas.zip');
    ?>
</div>