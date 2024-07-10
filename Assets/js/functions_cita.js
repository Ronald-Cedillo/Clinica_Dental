let tableCita;
let rowTable = ""; 
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableCita = $('#tableCita').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Cita/getCitas",
            "dataSrc":""
        },
        "columns":[
            { "data": "cit_id" },
            { "data": "per_nombre_completo" },
            { "data": "pac_nombre_completo" },
            { "data": "ser_nombre" },
            { "data": "cit_fecha" },
            { "data": "cit_tipo" }, // No necesitas renderizar aquí si ya viene con las etiquetas span
            { "data": "status" }, // Ya viene con las etiquetas span según PHP
            { "data": "options" }
        ],
        'dom': 'lBfrtip',
        'buttons': [
            {
                "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]  
    });

    if(document.querySelector("#formCita")){
        let formCita = document.querySelector("#formCita");
        formCita.onsubmit = function(e) {
            e.preventDefault();
            let intDentista = document.querySelector('#listDentistaid').value;
            let intPersona = document.querySelector('#listClienteid').value;
            let intServicio = document.querySelector('#listServicioid').value;
            let strDescripcion = document.querySelector('#txtDescripcion').value;
            let strFecha = document.querySelector('#fechaSeleccionada').value;
            let strHora = document.querySelector('#horaSeleccionada').value;
            
            let intStatus = document.querySelector('#listStatus').value;

            if(
                intDentista == '' ||
                intPersona == '' ||
                intServicio == '' ||
                strDescripcion == '' ||
                strFecha == '' ||
                strHora == '' ||
                intStatus == '' )
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }

           
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Cita/setCita'; 
            let formData = new FormData(formCita);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        
                        $('#modalFormCita').modal("hide");
                        formCita.reset();
                        swal("Cita", objData.msg ,"success");
                        tableCita.api().ajax.reload();
                    }else{
                        swal("Error", objData.msg , "error");
                    }
                }
                divLoading.style.display = "none";
                return false;
            }
        }
    }
   
   

}, false);


window.addEventListener('load', function() {
    fntServicio();
    fntPaciente();
    fntDentista();
}, false);

function fntDentista(){
    if(document.querySelector('#listDentistaid')){
        let ajaxUrl = base_url+'/Usuarios/getSelectDentista';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listDentistaid').innerHTML = request.responseText;
                $('#listDentistaid').selectpicker('render');
            }
        }
    }
}

function fntPaciente(){
    if(document.querySelector('#listClienteid')){
        let ajaxUrl = base_url+'/Paciente/getSelectPaciente';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listClienteid').innerHTML = request.responseText;
                $('#listClienteid').selectpicker('render');
            }
        }
    }
}

function fntServicio(){
    if(document.querySelector('#listServicioid')){
        let ajaxUrl = base_url+'/Servicio/getSelectServicio';
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                document.querySelector('#listServicioid').innerHTML = request.responseText;
                $('#listServicioid').selectpicker('render');
            }
        }
    }
}

function fntViewCita(idpersona){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Cita/getCita/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
               let estadoCita = objData.data.status == 1 ? 
                '<span class="badge badge-success">Activo</span>' : 
                '<span class="badge badge-danger">Inactivo</span>';

                document.querySelector("#celIDDentista").innerHTML = objData.data.per_nombre_completo;
                document.querySelector("#celIDPaciente").innerHTML = objData.data.pac_nombre_completo;
                document.querySelector("#celIDServicio").innerHTML = objData.data.ser_nombre;
                document.querySelector("#celFecha").innerHTML = objData.data.cit_fecha;
                document.querySelector("#celHora").innerHTML = objData.data.cit_hora;
                document.querySelector("#celDescripcion").innerHTML = objData.data.cit_descripcion;
                document.querySelector("#celEstado").innerHTML = estadoCita;
                $('#modalViewCita').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditCita(element,idpersona){
    rowTable = element.parentNode.parentNode.parentNode; 
    document.querySelector('#titleModal').innerHTML ="Actualizar Cita";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Cita/getCita/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                document.querySelector("#idCita").value = objData.data.cit_id;
                document.querySelector("#listDentistaid").value = objData.data.cit_per_id;
                $('#listDentistaid').selectpicker('render');
                document.querySelector("#listClienteid").value = objData.data.cit_pac_id;
                $('#listClienteid').selectpicker('render');
                document.querySelector("#listServicioid").value = objData.data.cit_ser_id;
                $('#listServicioid').selectpicker('render');
                document.querySelector("#txtDescripcion").value = objData.data.cit_descripcion;
                document.querySelector("#fechaSeleccionada").value = objData.data.cit_fecha;
                document.querySelector("#horaSeleccionada").value = objData.data.cit_hora;
                

                if(objData.data.status == 1){
                    document.querySelector("#listStatus").value = 1;
                }else{
                    document.querySelector("#listStatus").value = 2;
                }
                $('#listStatus').selectpicker('render');
            }
        }
    
        $('#modalFormCita').modal('show');
    }
}

function fntDelCita(idpersona){
    swal({
        title: "Cancelar Cita",
        text: "¿Realmente quiere Cancelar la Cita?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, Cancelar Cita!",
        cancelButtonText: "No, cerrar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Cita/delCita';
            let strData = "idCita="+idpersona;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Cita Cancelada!", objData.msg , "success");
                        tableCita.api().ajax.reload();
                    }else{
                        swal("Atención!", objData.msg , "error");
                    }
                }
            }
        }

    });

}


function openModal()
{
    rowTable = "";
    document.querySelector('#idCita').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Cita";
    document.querySelector("#formCita").reset();
    $('#modalFormCita').modal('show');
}

function openModalPerfil(){
    $('#modalFormPerfil').modal('show');
}

$(document).ready(function() {
    var eventos = [];
  
    function marcarHorasPasadas() {
      var now = moment();
  
      $('#calendar').fullCalendar('clientEvents', function(event) {
        var eventStart = moment(event.start);
        if (eventStart.isBefore(now)) {
          event.color = 'red';
        } else {
          event.color = 'lightblue';
        }
        $('#calendar').fullCalendar('updateEvent', event);
      });
    }
  
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      selectable: true,
      selectHelper: true,
      select: function(start, end) {
        var today = moment().startOf('day');
        if (start.isBefore(today)) {
          alert('No puedes seleccionar una fecha pasada.');
          $('#calendar').fullCalendar('unselect');
          return false;
        }
  
        var selectedDate = moment(start).format('YYYY-MM-DD');
        $('#fechaSeleccionada').val(selectedDate);
        $('#modalSelectTime').modal('show');
        $('#calendar').data('selectedDate', selectedDate);
      },
      editable: true,
      eventLimit: true,
      dayClick: function(date, jsEvent, view) {
        var today = moment().startOf('day');
        if (date.isBefore(today)) {
          alert('No puedes seleccionar una fecha pasada.');
          return false;
        }
  
        var selectedDate = date.format('YYYY-MM-DD');
        $('#calendar').data('selectedDate', selectedDate);
        $('.fc-day').removeClass('selected-day'); // Remove previous selection
        $('.fc-day[data-date="' + selectedDate + '"]').addClass('selected-day');
      },
      viewRender: function(view, element) {
        var selectedDate = $('#calendar').data('selectedDate');
        if (selectedDate) {
          $('.fc-day').removeClass('selected-day'); // Remove previous selection
          $('.fc-day[data-date="' + selectedDate + '"]').addClass('selected-day');
        }
        marcarHorasPasadas(); // Marcar horas pasadas en la vista actual
      },
      selectAllow: function(selectInfo) {
        // Prevenir la selección de fechas anteriores a la actual
        var today = moment().startOf('day');
        return selectInfo.start.isSameOrAfter(today);
      }
    });
  
    $('#modalFormCita').on('shown.bs.modal', function() {
      $('#calendar').fullCalendar('render');
    });
  
    $('#saveTime').on('click', function() {
      var fechaSeleccionada = $('#fechaSeleccionada').val();
      var horaSeleccionada = $('#selectHora').val();
      var fechaHoraCompleta = fechaSeleccionada + ' ' + horaSeleccionada;
  
      // Verificar si la hora seleccionada ya está ocupada
      var isTimeOccupied = eventos.some(function(event) {
        return event.start === fechaHoraCompleta;
      });
  
      if (isTimeOccupied) {
        alert('Hora no disponible, ya hay una cita programada.');
        return;
      }
  
      // Guardar la fecha y hora seleccionadas
      $('#fechaSeleccionada').val(fechaHoraCompleta);
      $('#horaSeleccionada').val(horaSeleccionada); // Guardar la hora seleccionada en el campo oculto
  
      // Añadir un evento al calendario
      var evento = {
        title: 'Cita',
        start: fechaHoraCompleta,
        allDay: false
      };
  
      $('#calendar').fullCalendar('renderEvent', evento);
      eventos.push(evento);
  
      $('#modalSelectTime').modal('hide');
  
      // Regresar el foco al modal de la cita
      setTimeout(function() {
        $('body').addClass('modal-open');
      }, 500);
  
      // Marcar horas pasadas
      marcarHorasPasadas();
    });
  
    // Asegurarse de que el modal de la hora se cierre correctamente
    $('#modalSelectTime').on('hidden.bs.modal', function () {
      $('body').addClass('modal-open');
    });
  });
  
  
  // Función para limpiar el formulario dentro del modal
  function limpiarFormulario() {
    $('#formCita')[0].reset(); // Resetear el formulario
    $('#calendar').fullCalendar('removeEvents'); // Remover todos los eventos del calendario
    $('#fechaSeleccionada').val(''); // Limpiar valor de fecha seleccionada
    $('#horaSeleccionada').val(''); // Limpiar valor de hora seleccionada
    $('#listDentistaid').val('').trigger('change'); // Resetear select de dentista
    $('#listClienteid').val('').trigger('change'); // Resetear select de cliente
    $('#listServicioid').val('').trigger('change'); // Resetear select de servicio
    $('#listStatus').val('1').selectpicker('refresh'); // Restaurar select de status a su valor predeterminado
}

// Evento cuando se oculta el modal
$('#modalFormCita').on('hidden.bs.modal', function () {
    limpiarFormulario(); // Llamar a la función para limpiar el formulario
});