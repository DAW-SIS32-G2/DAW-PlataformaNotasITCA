<?php
session_start();
require_once("core/funcionesbd.php");
$carnet = $_SESSION['usuario'];
?>
<script type="text/javascript">
    function proceso() {
        // Procesar
        $.ajax({
            type: 'post',
            url: 'ajax/actBuzon',
            data: {grupo: $('#grupo').val(), cargar: true},
            success: function (respuesta) {
                document.getElementById('resultado').innerHTML = respuesta;
            }
        })

    }
</script>
<body style="padding-top:65px;">
<div class="container">
    <div class="text-center">
        <h1>Activar o Desactivar el buzón de archivos</h1>
        <form class="form-group" method="post">
            <div class="form-inline">
                <label for="grupo" class="col-lg-4">Seleccione un grupo</label>
                <select class="form-control col-lg-4" name="grupo" id="grupo" onchange="proceso();">
                    <option value="">--Seleccione Uno--</option>
                    <?php
                    $bd = new funcionesBD();
                    # La condicion luego se actualizará conforme a los docentes que impartan en cada grupo
                    $res = $bd->ConsultaPersonalizada("select distinct G.nombreGrupo, G.seccion, G.idGrupo from Modulo as M inner join Horario as H on M.idHorario = H.idHorario inner join Grupo as G on H.idGrupo = G.idGrupo where M.carnet='" . $_SESSION['usuario'] . "'");
                    while ($fila = $res->fetch_assoc()) {
                        echo "<option whatever=\"" . $fila['nombreGrupo'] . "\" value=\"" . $fila['idGrupo'] . "\">" . $fila['nombreGrupo']." ".$fila['seccion']."</option>";
                    }
                    ?>
                </select>
            </div>
        </form>
    </div>
    <div id="resultado">
        <!--Acá cargara el resultado del fetch-->
    </div>
</div>
<script type="text/javascript">
    function actBuzon()
    {
        $.ajax({
            type: 'post',
            url: 'ajax/actBuzon',
            data: {grupo: $('#grupo').val(), actBuzon : true},
            success: function (respuesta) {
                if(respuesta == 1)
                {
                    swal({
                        text: "Buzón activado con éxito",
                        icon: "success",
                        button: "Aceptar"
                    }).then((value)=>{
                        document.location.reload();
                    })
                }
                else
                {
                    swal({
                        text: respuesta,
                        icon: "error",
                        button: "Aceptar"
                    }).then((value)=>{
                        document.location.reload();
                    })
                }
            }
        })
    }

    function desactBuzon()
    {
        $.ajax({
            type: 'post',
            url: 'ajax/actBuzon',
            data: {grupo: $('#grupo').val(), desactBuzon : true},
            success: function (respuesta) {
                if(respuesta == 1)
                {
                    swal({
                        text: "Buzón desactivado con éxito",
                        icon: "success",
                        button: "Aceptar"
                    }).then((value)=>{
                        document.location.reload();
                    })
                }
                else
                {
                    swal({
                        text: respuesta,
                        icon: "error",
                        button: "Aceptar"
                    }).then((value)=>{
                        document.location.reload();
                    })
                }
            }
        })
    }
</script>
</body>