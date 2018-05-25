 <?php
  //Acá se va a cargar la tabLa según la BD
  define("RAIZ",dirname(__FILE__,3));
  require_once(RAIZ."/funcionesbd.php");
  $idModulo = $_POST['grupo'];
  $objDocenteModelo=new docenteModelo();

if(isset($_POST['modificar']))
{
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $carnet = $_POST['carnet'];
    $sql = "Update Usuario SET nombres='$nombres', apellidos='$apellidos' WHERE carnet='$carnet'";
    $objBD = new funcionesBD();
    $res = $objBD->ConsultaPersonalizada($sql);
    if(gettype($res) == "boolean" && $res === true)
    {
      echo "1";
      exit;
    }
    else
    {
      echo $res;
      exit;
    }
}
elseif(isset($_POST['eliminar']))
{
  $carnet = $_POST['carnet'];
  $idModulo = $_POST['idModulo'];

  $sql = "DELETE FROM UsuarioActivo WHERE carnet = '$carnet' AND idModulo = '$idModulo'";
  $objBD = new funcionesBD();
    $res = $objBD->ConsultaPersonalizada($sql);
    if(gettype($res) == "boolean" && $res === true)
    {
      echo "1";
      exit;
    }
    else
    {
      echo $res;
      exit;
    }
}
else
{
  if($idModulo != "")
  {
    ?>
      <script type="text/javascript">
      $('#eliminarModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // span que llamó al evento
      var recipient = button.data('whatever') // extraer los datos del atributo data-*
      var nombre = button.data('nombre')
      var apellido = button.data('apellido')
      var modulo = button.data('modulo')
      var modal = $(this)

      modal.find('.modal-title').text('Desinscribir al alumno con carnet: ' + recipient)
      modal.find('.modal-body input').val(recipient)
      modal.find("#nombre").html(nombre+' '+apellido)
      modal.find('#idmodulo').val(modulo)
      })

      $('#modificarModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // span que llamó al evento
      var recipient = button.data('whatever') // extraer los datos del atributo data-*
      var nombre = button.data('nombre')
      var apellido = button.data('apellido')
      var modal = $(this)
      modal.find('#carnet2').val(recipient)
      modal.find('#nombres').val(nombre)
      modal.find('#apellidos').val(apellido)
      })

      $("#respuestaForm").on('hidden.bs.modal', function (event) {
        consultarNotas(<?= $idModulo ?>)
      })
    </script>
    <?php
    $objeto = new funcionesBD();
    $sql = "Select DISTINCT Usuario.carnet, Usuario.nombres, Usuario.apellidos, Usuario.foto FROM Usuario INNER JOIN Nota ON Nota.carnet = Usuario.carnet INNER JOIN Tarea ON Tarea.idTarea = Nota.idTarea INNER JOIN Ponderacion ON Tarea.idPonderacion = Ponderacion.idPonderacion INNER JOIN Modulo ON Ponderacion.idModulo = Modulo.idModulo INNER JOIN UsuarioActivo ON UsuarioActivo.carnet = Usuario.carnet Where Modulo.idModulo = $idModulo AND UsuarioActivo.idModulo = $idModulo";
    $res = $objeto->ConsultaPersonalizada($sql);
    if(mysqli_num_rows($res) != 0)
    {
        ?>
          <table class="table table-bordered">
            <thead class="thead-dark">
              <tr>
                <th>Acciones</th>
                <th>Carnet</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Foto</th>
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
              </tr>
            </thead>
            <tbody>
              <?php
                $objeto = new funcionesBD();
                $sql = "SELECT DISTINCT Usuario.carnet, Usuario.nombres, Usuario.apellidos, Usuario.foto FROM Usuario INNER JOIN Nota ON Nota.carnet = Usuario.carnet INNER JOIN Tarea ON Tarea.idTarea = Nota.idTarea INNER JOIN Ponderacion ON Tarea.idPonderacion = Ponderacion.idPonderacion INNER JOIN Modulo ON Ponderacion.idModulo = Modulo.idModulo INNER JOIN UsuarioActivo ON Usuario.carnet = UsuarioActivo.carnet Where Modulo.idModulo = $idModulo";
                $res = $objeto->ConsultaPersonalizada($sql);
                while($fila = $res->fetch_array(MYSQLI_ASSOC))
                {
                  echo "
                    <tr>
                      <td>
                        <a href=\"#\" data-toggle=\"modal\" data-target=\"#eliminarModal\" data-whatever=\"".$fila['carnet']."\" data-nombre=\"".$fila['nombres']."\" data-apellido=\"".$fila['apellidos']."\" data-modulo=\"".$idModulo."\"><i class='material-icons'>backspace</i><small> Eliminar</small></a><br>                   
                        <a href=\"#\" data-toggle=\"modal\" data-target=\"#modificarModal\" data-whatever=\"".$fila['carnet']."\" data-nombre=\"".$fila['nombres']."\" data-apellido=\"".$fila['apellidos']."\"><i class='material-icons'>create</i><small> Editar</small></a>
                      </td>
                      <td>".$fila['carnet']."</td>
                      <td>".$fila['nombres']."</td>
                      <td>".$fila['apellidos']."</td>
                  ";
                  if($fila['foto'] == "")
                  {
                      echo '<td><img src="../assets/imagenes/user.jpg" class="img-fluid" width="80" height="80" alt="alumno"></td>';
                  }
                  else
                  {
                      echo '<td><img src="'.$fila['foto'].'" class="img-fluid" width="80" height="80" alt="alumno"></td>'; 
                  }
                  $ponderaciones=$objDocenteModelo->BuscarPonderaciones($idModulo);
                  while($fila2=mysqli_fetch_assoc($ponderaciones))
                  {
                    $pond = $fila2['idPonderacion'];
                    $bd = new funcionesBD();
                    $cons = "Select nota.valor, Tarea.porcentaje, Tarea.cantidadEjercicios, Ponderacion.porcentaje as 'porcentTotal' from Nota INNER JOIN Tarea on Tarea.idTarea = Nota.idTarea INNER JOIN ponderacion on Tarea.idPonderacion = Ponderacion.idPonderacion WHERE Nota.carnet = '".$fila['carnet']."' AND ponderacion.idPonderacion = '$pond'";
                    $notas = $bd->ConsultaPersonalizada($cons);
                    $promfinal = 0;
                    while($nota = mysqli_fetch_assoc($notas))
                    {
                       $not = ($nota['valor']/$nota['cantidadEjercicios'])*10;
                       $promfinal += (($not*$nota['porcentaje'])/$nota['porcentTotal']);
                    }
                    echo "<td>".number_format($promfinal,2)."</td>";
                  }
                  echo "
                    </tr>";
                }
              ?>
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
                      <p class="text-justify"><i>Nota: Desinscribir a un alumno de la materia provocará que todas sus notas y prácticas subidas se eliminen. El alumno deberá volverse a inscribir a esta materia, para lo cual debe estar habilitada su inscripción. Proceda con cuidado.</i></p>
                    </div>
                    <div class="form-group">
                      <label for="recipient-name" class="col-form-label">Carnet:</label>
                      <input type="text" class="form-control" id="carnet" readonly>
                    </div>
                    <div class="form-group">
                      <label for="message-text" class="col-form-label">Nombre del alumno</label>
                      <textarea class="form-control" id="nombre" readonly></textarea>
                      <input type="hidden" id="idmodulo">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-danger" onclick="EliminarAlumno()">Eliminar</button>
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
                      <input type="text" class="form-control" id="carnet2" readonly>
                    </div>
                    <div class="form-group">
                      <label for="message-text" class="col-form-label">Nombres del alumno</label>
                      <input type="text" name="nombres" class="form-control" id="nombres" required>
                      <div id="respuestaNom"></div>
                    </div>
                    <div class="form-group">
                      <label for="message-text" class="col-form-label">Apellidos del alumno</label>
                      <input type="text" name="apellidos" class="form-control" id="apellidos" required>
                      <div id="respuestaApe"></div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                  <button type="button" class="btn btn-success" onclick="modificarAlumno()">Cambiar Datos</button>
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

          <!-- Modal que se mostrará cuando se mande un form -->
          <div class="modal fade" id="respuestaForm" tabindex="-1" role="dialog" aria-labelledby="Acciones" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Éxito</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <p>Acción Realizada correctamente</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal">Cerrar</button>
                </div>
              </div>
            </div>
          </div>
        <?php
    }
    else
    {
        echo "<p>No existen datos para esta materia</p>";
    }
  }
  else
  {
    echo "<p>Seleccione un grupo para continuar</p>";
  }
}
?>