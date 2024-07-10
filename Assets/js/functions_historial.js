let tableHistorial;
let rowTable = ""; 
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){

    tableHistorial = $('#tableHistorial').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Historial/getHistoriaales",
            "dataSrc":""
        },
        "columns": [
            {"data": "hist_id"},
            {"data": "hist_cedula"},
            {"data": "hist_cita_id"},
            {"data": "pac_nombre_completo"},
            {"data": "hist_fecha"},
            {"data": "hist_descripcion"},
            {"data": "status"},
            {"data": "options"}
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

    if(document.querySelector("#formHistorial")){
        let formHistorial = document.querySelector("#formHistorial");
        formHistorial.onsubmit = function(e) {
            e.preventDefault();
            let strNombre = document.querySelector('#txtNombreHistorial').value;
            let strDescripcio = document.querySelector('#txtDescripcion').value;
            
            let intStatus = document.querySelector('#listStatus').value;

            if(
                strNombre == '' ||
                strDescripcio == '' ||
                intStatus == '' )
            {
                swal("Atención", "Todos los campos son obligatorios." , "error");
                return false;
            }

           
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Historial/setHistorial'; 
            let formData = new FormData(formHistorial);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        
                        $('#modalFormHistorial').modal("hide");
                        formHistorial.reset();
                        swal("Historial", objData.msg ,"success");
                        tableHistorial.api().ajax.reload();
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



function fntViewHistorial(idpersona){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Historial/getHistorial/'+idpersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);

            if(objData.status)
            {
               let estadoHistorial = objData.data.cita_estado == 1 ? 
                '<span class="badge badge-success">Activo</span>' : 
                '<span class="badge badge-danger">Cancelado</span>';

                document.querySelector("#celIDDentista").innerHTML = objData.data.persona_nombre_completo;
                document.querySelector("#celIDPaciente").innerHTML = objData.data.pac_nombre_completo;
                document.querySelector("#celIDServicio").innerHTML = objData.data.servicio_nombre;
                document.querySelector("#celFecha").innerHTML = objData.data.cita_fecha;
                document.querySelector("#celHora").innerHTML = objData.data.cita_hora;
                document.querySelector("#celDescripcion").innerHTML = objData.data.descripcion_historial;
                document.querySelector("#celEstado").innerHTML = estadoHistorial;
                $('#modalViewHistorial').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}





function openModal()
{
    rowTable = "";
    document.querySelector('#idHistorial').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Historial";
    document.querySelector("#formHistorial").reset();
    $('#modalFormHistorial').modal('show');
}

function openModalPerfil(){
    $('#modalFormPerfil').modal('show');
}