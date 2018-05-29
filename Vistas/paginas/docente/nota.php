<?php
# se definen la constante __ROOT__
define("__ROOT__", dirname(dirname(dirname(dirname(__FILE__)))));

# se incluye la clase funcionesBD
require_once(__ROOT__ . "/core/funcionesbd.php");

# se almacenan los datos de sesion
$carnet = $_SESSION['usuario'];

# se crea una nueva instancia de la clase docenteModelo
$objDocenteModelo = new DocenteModelo();
?>
<body style="padding-top:65px;">
<div class="container">
    <div class="text-center">
        <h1>Asignar notas de prácticas</h1>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <form class="form-group" method="post">
                    <div class="form-inline">
                        <label class="form-label" for="grupo">Seleccione un grupo:</label>
                        <select class="form-control" id="grupo2" onchange="cargarPracticas(this.value)">
                            <?php
                            # se cargan los grupos disponibles
                            $resultado = $objDocenteModelo->CargarGrupos();

                            # se verivica el resultado
                            if (gettype($resultado) == "string") {
                                echo "Error al cargar los grupos...";
                            } else {

                                # se inicializa el contador en 0
                                $i = 0;
                                # se recuperan los datos de la consulta
                                while ($arrayGrupos = $resultado->fetch_array(MYSQLI_ASSOC)) {
                                    $nombreModulos[] = $arrayGrupos['nombreModulo'];
                                    $nombreGrupos[] = $arrayGrupos['nombreGrupo'];
                                    $idModulos[] = $arrayGrupos['idModulo'];
                                    $i++;
                                }

                                # se obtiene la cantidad de elementos del arreglo
                                $conteo = count($nombreModulos);

                                # se imprimen los grupos disponibles
                                echo "<option value=''>--Seleccione una opcion--</option>";
                                for ($j = 0; $j < $conteo; $j++) {
                                    ?>
                                    <option value='<?php echo $idModulos[$j]; ?>'>
                                        <?php echo $nombreGrupos[$j] . "-" . $nombreModulos[$j]; ?>
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
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <div id="practicas">
                    <!-- Aqui cargarán las prácticas-->
                </div>
            </div>
            <div class="col-lg-4"></div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div id="tablaRes">

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function eliminarPrac(ruta,idTareaSubidaPor,idTarea,carnet)
    {
        $.ajax({
            type    : "post",
            url     : "ajax/nota",
            data    : {"eliminarPrac" : true, "ruta" : ruta, "idTareaSubidaPor" : idTareaSubidaPor, "idTarea2" : idTarea, "carnet" : carnet},
            success : function(mensaje) 
                      {
                        if(mensaje == 1)
                        {
                            swal({
                                text   : "Se ha borrado la práctica correctamente",
                                icon   : "success",
                                button : "Aceptar"
                            }).then((value)=>{
                                document.location.reload();
                            })
                        }
                        else
                        {
                            swal({
                                text   : mensaje,
                                icon   : "error",
                                button : "Aceptar"
                            })
                        }
                      }
        })
    }
</script>
</body>
