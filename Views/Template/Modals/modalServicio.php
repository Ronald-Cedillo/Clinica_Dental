<!-- Modal -->
<div class="modal fade" id="modalFormServicio" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Servicio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formServicio" name="formServicio" class="form-horizontal">
          <input type="hidden" id="idServicio" name="idServicio" value="">
          <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>

          <div class="form-group">
            <label for="txtNombreServicio">Nombre del Servicio <span class="required">*</span></label>
            <input type="text" class="form-control" id="txtNombreServicio" name="txtNombreServicio" required="">
          </div>

          <div class="form-group">
            <label for="txtDescripcion">Descripción <span class="required">*</span></label>
            <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="4" required=""></textarea>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="listStatus">Status</label>
              <select class="form-control selectpicker" id="listStatus" name="listStatus" required>
                <option value="1">Activo</option>
                <option value="2">Inactivo</option>
              </select>
            </div>
          </div>

          <div class="tile-footer">
            <button id="btnActionForm" class="btn btn-primary" type="submit">
              <i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span>
            </button>
            <button class="btn btn-danger" type="button" data-dismiss="modal">
              <i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalViewServicio" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del Servicio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>

            <tr>
              <td>ID:</td>
              <td id="celID">Jacob</td>
            </tr>
            <tr>
              <td>Nombres del servicio:</td>
              <td id="celNombre">Jacob</td>
            </tr>
            <tr>
              <td>Descripción del servicio:</td>
              <td id="celDescripcion">Jacob</td>
            </tr>

            <tr>
              <td>Estado:</td>
              <td id="celEstado">Larry</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>