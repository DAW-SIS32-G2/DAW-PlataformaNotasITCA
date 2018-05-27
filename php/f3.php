<div class="conts" style="display:none">
    <?php
    require_once 'f4.php';
    $act = new install($_POST['user'], $_POST['passwd'], false);
    $f1=$act->createDB();
    $f2=$act->unzip('recursos/DAW-PlataformaNotasITCA.zip');
    if($f1 == 1 && $f2 == 1){
        ?>
        <script>
            swal({
                title: "Instalación Exitosa!",
                text: "A partir de este momento usted puede empezar a usar su sistema",
                icon: "success",
                button: "ok",

            });
        </script>
        <?php
    }elseif ($f1!= true && $f2 == 1){
        ?>
        <script>
            swal({
                title: "Fallo en la instalación",
                text: "Al parecer no se pudo crear la base de datos",
                icon: "error",
            });
        </script>
        <?php
    }elseif ($f1 == 1 && $f2 != true){
        ?>
        <script>
            swal({
                title: "Fallo en la instalación",
                text: "Al parecer no se pudieron extraer los archivo del sistema",
                icon: "error",
            });
        </script>
        <?php
    }else{
        ?>
        <script>
            swal({
                title: "Error Fatal",
                text: "No se pudo crear la base de datos. Además ocurrio un fallo en la extracción de los archivos del sistema",
                icon: "error",
            });
        </script>
        <?php
    }
 ?>
</div>