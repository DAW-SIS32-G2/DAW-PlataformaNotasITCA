<div class="container" style="padding-top: 65px;">

  <h1>Inscribir Grupos</h1>

  <table class="table">
    <!--
    Elimine algunos campos como grupo porque en las historias de usuario decia
    que se debia filtrar de modo que el extudiante solo le aparecieran las materias de
    su grupo
   -->
    <tr>
      <th>Docente</th>
      <th>Materia</th>
      <th>Inscribir</th>
    </tr>
    <!-- ejemplo -->
    <tr>
      <td>Ing. Fulano de Tal</td>
      <td>Curso de Bicicleta</td>
      <td><button class="btn btn-primary" data-toggle="modal" data-target="#inscribir">Inscribir</button></td>
    </tr>
  </table>
<script src="js/jquery-latest.js"></script>
<script src="js/bootstrap.min.js"></script>

</div>
<div class="modal fade" id="inscribir" tabindex="-1" role="dialog" aria-labelledby="passModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="passModalLongTitle">Ingresar Contraseña</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post">
          <label for="pass">Contraseña</label>
          <input type="password" class="form-control" name="passwd" id="pass"><br>
          <button class="btn btn-primary" type="submit">Inscribir</button>
        </form>
      </div>
    </div>
  </div>
</div>
