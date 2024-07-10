<!-- Modal -->
<div class="modal fade" id="modalFormPaciente" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Paciente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formPaciente" name="formPaciente" class="form-horizontal">
          <input type="hidden" id="idPaciente" name="idPaciente" value="">
          <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtCedula">Cédula <span class="required">*</span></label>
              <input type="text" class="form-control" id="txtCedula" name="txtCedula" required="">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtNombre">Nombre <span class="required">*</span></label>
              <input type="text" class="form-control" id="txtNombre" name="txtNombre" required="">
            </div>
            <div class="form-group col-md-6">
              <label for="txtApellido">Apellido <span class="required">*</span></label>
              <input type="text" class="form-control" id="txtApellido" name="txtApellido" required="">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtTelefono">Teléfono <span class="required">*</span></label>
              <input type="text" class="form-control" id="txtTelefono" name="txtTelefono" required="" onkeypress="return controlTag(event);">
            </div>
            <div class="form-group col-md-6">
              <label for="txtEmail">Correo Electrónico <span class="required">*</span></label>
              <input type="email" class="form-control valid validEmail" id="txtEmail" name="txtEmail" required="">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="txtDireccion">Dirección</label>
              <input type="text" class="form-control" id="txtDireccion" name="txtDireccion" required="">
            </div>
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
            <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
            <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalViewPaciente" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Identificación:</td>
              <td id="celIdentificacion">654654654</td>
            </tr>
            <tr>
              <td>Nombres:</td>
              <td id="celNombre">Jacob</td>
            </tr>
            <tr>
              <td>Apellidos:</td>
              <td id="celApellido">Jacob</td>
            </tr>
            <tr>
              <td>Teléfono:</td>
              <td id="celTelefono">Larry</td>
            </tr>
            <tr>
              <td>Email (Usuario):</td>
              <td id="celEmail">Larry</td>
            </tr>
            <tr>
              <td>Identificación Tributaria:</td>
              <td id="celIde">Larry</td>
            </tr>
            <tr>
              <td>Nombre Fiscal:</td>
              <td id="celDireccion">Larry</td>
            </tr>
            <tr>
              <td>Dirección Fiscal:</td>
              <td id="celEstado">Larry</td>
            </tr>
            <tr>
              <td>Fecha registro:</td>
              <td id="celFechaRegistro">Larry</td>
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