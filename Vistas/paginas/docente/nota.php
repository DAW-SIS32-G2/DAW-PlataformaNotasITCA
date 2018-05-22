<?php
define("__ROOT__",dirname(dirname(dirname(dirname(__FILE__)))));
require_once(__ROOT__."/core/funcionesbd.php");
$carnet = $_SESSION['usuario'];
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
                <select class="form-control" id="grupo" onchange="cargarPracticas(this.value)">
                  <?php 
                    $resultado=$objDocenteModelo->CargarGrupos();
                    if (gettype($resultado)=="string")
                    {
                      echo "Error al cargar los grupos...";
                    }
                    else
                    {
                      $i=0;
                      while($arrayGrupos=$resultado->fetch_array(MYSQLI_ASSOC))
                      {
                        $nombreModulos[]=$arrayGrupos['nombreModulo'];
                        $nombreGrupos[]=$arrayGrupos['nombreGrupo'];
                        $idModulos[]=$arrayGrupos['idModulo'];
                        $i++;
                      }
                      $conteo=count($nombreModulos);
                      echo "<option value=''>--Seleccione una opcion--</option>";
                      for($j=0;$j<$conteo;$j++)
                      { 
                        ?>
                          <option value='<?php echo $idModulos[$j]; ?>'>
                            <?php echo $nombreGrupos[$j]."-".$nombreModulos[$j]; ?>
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
</body>
