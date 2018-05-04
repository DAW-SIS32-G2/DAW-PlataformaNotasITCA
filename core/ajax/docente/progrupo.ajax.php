<?php
  //Acá se va a cargar la tabLa según la BD
  define("RAIZ",dirname(__FILE__,3));
  require_once(RAIZ."/funcionesbd.php");
  $idModulo = $_POST['grupo'];
  $objDocenteModelo=new docenteModelo();
?>
<script type="text/javascript">
  $('#eliminarModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // span que llamó al evento
  var recipient = button.data('whatever') // extraer los datos del atributo data-*
  var modal = $(this)
  //modal.find('.modal-title').text('Eliminar el alumno con carnet: ' + recipient)
  modal.find('.modal-body input').val(recipient)
  })

  $('#modificarModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // span que llamó al evento
  var recipient = button.data('whatever') // extraer los datos del atributo data-*
  var modal = $(this)
  //modal.find('.modal-title').text('Eliminar el alumno con carnet: ' + recipient)
  modal.find('#carnet').val(recipient)
  modal.find('#nombres').val('Nombre de')
  modal.find('#apellidos').val('prueba')
  })
</script>
<table class="table table-bordered">
  <thead class="thead-dark">
    <tr>
      <th></th>
      <th>Carnet</th>
      <th>Nombre</th>
      <th>Apellido</th>
      <th>Foto</th>
      <th>Inasistencias</th>
      <!-- Acá se van a cargar las filas según sean las Evaluaciones en la BD -->
      <?php
      $contponderaciones = 0;
      $ponderaciones=$objDocenteModelo->BuscarPonderaciones($idModulo);
      while($arrayPonderaciones=$ponderaciones->fetch_array(MYSQLI_ASSOC))
                    {
                      echo "<th>".$arrayPonderaciones['nombrePonderacion']."</th>";
                      $contponderaciones++;
                    }
      ?>
      <!--final-->
      <th>Firma</th>
    </tr>
  </thead>
  <tbody>
    <!-- Acá se cargarán los alumnos según BD -->
    <tr>
      <!-- Iconos de editar y eliminar -->
      <td>
        <span class="oi oi-delete" data-toggle="modal" data-target="#eliminarModal" data-whatever="carnet1"></span>
        &nbsp;&nbsp;&nbsp;
        <span class="oi oi-brush" data-toggle="modal" data-target="#modificarModal" data-whatever="carnet1"></span>
      </td>
      <td><a href="#" data-toggle="modal" data-target="#notasModal" data-whatever="carnet1">carnet1</a></td><!-- carnet -->
      <td>Nombre</td><!-- nombres -->
      <td>de Prueba</td><!-- apellidos -->
      <td><img src="../assets/imagenes/user.jpg" class="img-fluid" width="80" height="80" alt="alumno"></td><!-- foto -->
      <td>1</td><!-- Inasistencias -->
      <!-- Acá se cargarán los datos segun los promedios de cada alumno -->
      <?php
        for($i=0;$i<$contponderaciones;$i++)
        {
          echo "<td>10.00</td>";
        }
      ?>
      <td>firma</td><!-- firma -->
    </tr>
  </tbody>
</table>
<!-- Modal de eliminación de datos -->
<div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="modal de eliminacion" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">¿Desea realmente eliminar este alumno?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form method="post">
      <div class="modal-body">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Carnet:</label>
            <input type="text" class="form-control" id="carnet" readonly>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Nombre del alumno</label>
            <textarea class="form-control" id="nombre" readonly>Nombre de prueba</textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger">Eliminar</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- Modal de modificación de datos -->
<div class="modal fade" id="modificarModal" tabindex="-1" role="dialog" aria-labelledby="Modal de modificación" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificar Datos del alumno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <form method="post">
      <div class="modal-body">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Carnet:</label>
            <input type="text" class="form-control" id="carnet" readonly>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Nombres del alumno</label>
            <input type="text" name="nombres" class="form-control" id="nombres" required>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Apellidos del alumno</label>
            <input type="text" name="apellidos" class="form-control" id="apellidos" required>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success">Cambiar Datos</button>
      </div>
     </form>
    </div>
  </div>
</div>

<!-- modal para ver las notas según alumno -->
<div class="modal fade" id="notasModal" tabindex="-1" role="dialog" aria-labelledby="Modal de notas" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ver notas según alumno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form class="form-group" method="post">
            <div class="container">
              <div class="row">
                  <p>Nombre de prueba</p>
              </div>
              <div class="row">
                <p>Módulo: <?php echo $grupo ?></p>
              </div>
              <div class="row">
                <div class="col-lg-4 h-100">
                  <!-- Acá debe cargar cada evaluación-->
                  <h4 class="align-middle">EV1</h4>
                </div>
                <div class="col-lg-8">
                    <!-- Acá debe cargar las notas por prácticas -->
                    <p>Promedio: 10.00</p>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                          <tr>
                            <th>Practica</th>
                            <th>Nota</th>
                            <th>Hechos</th>
                            <th>Ejercicios</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Practica 01</td>
                            <td>10.00</td>
                            <td>100</td>
                            <td>100</td>
                          </tr>
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
