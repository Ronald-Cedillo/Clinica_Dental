<div class="modal fade" id="modalFormCita" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva Cita</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formCita" name="formCita" class="form-horizontal">
          <input type="hidden" id="idCita" name="idCita" value="">
          <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>

          <div class="form-group col-md-6">
            <label for="listDentistaid">Dentista</label>
            <select class="form-control" data-live-search="true" id="listDentistaid" name="listDentistaid" required></select>
          </div>
          <div class="form-group col-md-6">
            <label for="listClienteid">Cliente</label>
            <select class="form-control" data-live-search="true" id="listClienteid" name="listClienteid" required></select>
          </div>
          <div class="form-group col-md-6">
            <label for="listServicioid">Servicio</label>
            <select class="form-control" data-live-search="true" id="listServicioid" name="listServicioid" required></select>
          </div>

          <div class="form-group">
            <label for="txtDescripcion">Descripción <span class="required">*</span></label>
            <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="4" required=""></textarea>
          </div>

          <div class="form-group">
            <label for="calendar">Fecha y Hora <span class="required">*</span></label>
            <div id="calendar"></div>
            <input type="text" id="fechaSeleccionada" name="fechaSeleccionada" required>
            <input type="text" id="horaSeleccionada" name="horaSeleccionada" required>
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



<div class="modal fade" id="modalSelectTime" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Seleccione la Hora</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="selectHora">Hora</label>
          <select class="form-control" id="selectHora" name="selectHora">
            <!-- Aquí puedes agregar las opciones de horas disponibles -->
            <option value="08:00">08:00</option>
            <option value="09:00">09:00</option>
            <option value="10:00">10:00</option>
            <option value="11:00">11:00</option>
            <option value="12:00">12:00</option>
            <option value="13:00">13:00</option>
            <option value="14:00">14:00</option>
            <option value="15:00">15:00</option>
            <option value="16:00">16:00</option>
            <option value="17:00">17:00</option>
            <option value="18:00">18:00</option>
            <option value="19:00">19:00</option>
            <option value="20:00">20:00</option>
            <!-- Agrega más opciones según tu necesidad -->
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="saveTime">Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="modalViewCita" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos de la Cita</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Odontólogo:</td>
              <td id="celIDDentista">654654654</td>
            </tr>
            <tr>
              <td>Paciente:</td>
              <td id="celIDPaciente">Jacob</td>
            </tr>
            <tr>
              <td>Servicio:</td>
              <td id="celIDServicio">Jacob</td>
            </tr>
            <tr>
              <td>Fecha de Cita:</td>
              <td id="celFecha">Larry</td>
            </tr>
            <tr>
              <td>Hora de la Cita:</td>
              <td id="celHora">Larry</td>
            </tr>
            <tr>
              <td>Descripción:</td>
              <td id="celDescripcion">Larry</td>
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