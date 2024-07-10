let tablePaciente;
let rowTable = ""; 
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tablePaciente = $('#tablePaciente').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Paciente/getPacientes",
            "dataSrc":""
        },
        "columns":[
            {"data":"pac_id"},
            {"data":"pac_cedula"},
            {"data":"pac_nombre"},
            {"data":"pac_apellido"},
            {"data":"pac_correo_electronico"},
            {"data":"pac_telefono"},
            {"data":"status"},
            {"data":"options"}
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

    if(document.querySelector("#formPaciente")){
        let formPaciente = document.querySelector("#formPaciente");
        formPaciente.onsubmit = function(e) {
            e.preventDefault();
            let strCedula = document.querySelector('#txtCedula').value;
            let strNombre = document.querySelector('#txtNombre').value;
            let strApellido = document.querySelector('#txtApellido').value;
            let strEmail = document.querySelector('#txtEmail').value;
            let intTelefono = document.querySelector('#txtTelefono').value;
            let strDireccion = document.querySelector('#txtDireccion').value;
            let intStatus = document.querySelector('#listStatus').value;

            if(
            strCedula == '' ||
              strApellido == '' || 
              strNombre == '' || 
              strEmail == '' || 
              intTelefono == '' || 
              intStatus == '' || 
              strDireccion == '')
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }

           
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Paciente/setPaciente'; 
            let formData = new FormData(formPaciente);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                            tablePaciente.api().ajax.reload();
                        }else{
                            htmlStatus = intStatus == 1 ? 
                            '<span class="badge badge-success">Activo</span>' : 
                            '<span class="badge badge-danger">Inactivo</span>';
                            rowTable.cells[1].textContent = strNombre;
                            rowTable.cells[2].textContent = strApellido;
                            rowTable.cells[3].textContent = strEmail;
                            rowTable.cells[4].textContent = intTelefono;
                            rowTable.cells[5].textContent = strDireccion;
                            rowTable.cells[6].innerHTML = htmlStatus;
                            rowTable = ""; 
                        }
                        $('#modalFormPaciente').modal("hide");
                        formPaciente.reset();
                        swal("Paciente", objData.msg ,"success");
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
       
}, false);


function fntViewPaciente(idpersona){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Paciente/getPaciente/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
               let estadoPaciente = objData.data.status == 1 ? 
                '<span class="badge badge-success">Activo</span>' : 
                '<span class="badge badge-danger">Inactivo</span>';

                document.querySelector("#celIdentificacion").innerHTML = objData.data.pac_cedula;
                document.querySelector("#celNombre").innerHTML = objData.data.pac_nombre;
                document.querySelector("#celApellido").innerHTML = objData.data.pac_apellido;
                document.querySelector("#celTelefono").innerHTML = objData.data.pac_telefono;
                document.querySelector("#celEmail").innerHTML = objData.data.pac_correo_electronico;
                document.querySelector("#celDireccion").innerHTML = objData.data.pac_direccion;
                document.querySelector("#celEstado").innerHTML = estadoPaciente;
                document.querySelector("#celFechaRegistro").innerHTML = objData.data.pac_fecharegistro; 
                $('#modalViewPaciente').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditPaciente(element,idpersona){
    rowTable = element.parentNode.parentNode.parentNode; 
    document.querySelector('#titleModal').innerHTML ="Actualizar Paciente";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Paciente/getPaciente/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){

        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
                document.querySelector("#idPaciente").value = objData.data.pac_id;
                document.querySelector("#txtCedula").value = objData.data.pac_cedula;
                document.querySelector("#txtNombre").value = objData.data.pac_nombre;
                document.querySelector("#txtApellido").value = objData.data.pac_apellido;
                document.querySelector("#txtTelefono").value = objData.data.pac_telefono;
                document.querySelector("#txtEmail").value = objData.data.pac_correo_electronico;
                document.querySelector("#txtDireccion").value = objData.data.pac_direccion;

                if(objData.data.status == 1){
                    document.querySelector("#listStatus").value = 1;
                }else{
                    document.querySelector("#listStatus").value = 2;
                }
                $('#listStatus').selectpicker('render');
            }
        }
    
        $('#modalFormPaciente').modal('show');
    }
}

function fntDelPaciente(idpersona){
    swal({
        title: "Eliminar Paciente",
        text: "¿Realmente quiere eliminar el Paciente?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, cancelar!",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Paciente/delPaciente';
            let strData = "idPaciente="+idpersona;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminar!", objData.msg , "success");
                        tablePaciente.api().ajax.reload();
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
    document.querySelector('#idPaciente').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Paciente";
    document.querySelector("#formPaciente").reset();
    $('#modalFormPaciente').modal('show');
}

function openModalPerfil(){
    $('#modalFormPerfil').modal('show');
}