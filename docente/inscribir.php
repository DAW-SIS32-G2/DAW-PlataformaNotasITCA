<div class="text-center">
  <h1>Inscribir alumno en el grupo</h1>
</div>
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th>Año</th>
              <th>Ciclo</th>
              <th>Grupo</th>
              <th>Materia</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>2018</td>
              <td>v1</td>
              <td>SIS32B</td>
              <td>Desarrollo de Aplicaciones para la Web</td>
              <td class="text-center">
                <a href="#" data-toggle="modal" data-target="#modalInscribir" data-whatever="DAW">
                  <span class="oi oi-plus"></span>Inscribir
                </a>
              </td>
            </tr>
          </tbody>
      </table>
    </div>
  </div>
</div>

<!-- modal para inscribir a un alumno -->
<div class="modal fade" id="modalInscribir" tabindex="-1" role="dialog" aria-labelledby="Inscribir" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Inscribir alumno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-group" method="post">
        <div class="modal-body">
              <div class="form-inline">
                <label for="carnet">Carnet del estudiante</label>
                <input type="text" name="carnet" maxlength="6" pattern="[0-9]{6}" class="form-control" required>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Inscribir</button>
        </div>
      </form>
    </div>
  </div>
</div>
