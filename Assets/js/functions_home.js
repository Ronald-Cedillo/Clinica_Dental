/*$(document).ready(function() {
    $('#reservasMenu').click(function() {
        $('.content').hide();
        $('#reservas').show();
    });

    $('#submit-button').click(function() {
        var pregunta = $('#input-question').val();
        if (validarCampos(pregunta)) {
            realizarPregunta(pregunta);
        }
    });

    $('#input-question').keypress(function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            var pregunta = $(this).val();
            if (validarCampos(pregunta)) {
                realizarPregunta(pregunta);
            }
        }
    });

    function validarCampos(pregunta) {
        if (pregunta === '') {
            alert('Ingresa una pregunta antes de enviarla.');
            return false;
        }
        return true;
    }

    function realizarPregunta(pregunta) {
        $("#barra").show();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>/home.php?controller=home&action=handleChat",
            data: {
                message: pregunta
            },
            success: function(respuesta) {
                $("#barra").hide();
                var preguntaHtml = `<strong>😎Tu:</strong> ` + pregunta;
                var respuestaHtml = '<strong>🤖Respuesta:</strong> ' + respuesta.response;
                var chatContainer = $('#chat-container');
                chatContainer.append('<p>' + preguntaHtml + '</p>');
                chatContainer.append('<p>' + respuestaHtml + '</p>');
                $('#input-question').val('');
                chatContainer.scrollTop(chatContainer[0].scrollHeight);
            }
        });
    }
});
*/


document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('sendButton').addEventListener('click', function() {
        let userInput = document.getElementById('userInput').value;
        let chatContainer = document.getElementById('chatContainer');
        
        // Agregar mensaje del usuario al contenedor de chat
        let userMessageElement = document.createElement('div');
        userMessageElement.classList.add('message');
        userMessageElement.classList.add('user');
        userMessageElement.textContent = userInput;
        chatContainer.appendChild(userMessageElement);
        
        let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Home/setPrueba';  // Asegúrate de que base_url está definido correctamente
        let formData = new FormData();
        formData.append('userInput', userInput);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function() {
            if (request.readyState != 4) return;
            if (request.status == 200) {
                console.log(request.responseText);
                let objData = JSON.parse(request.responseText);
                if (objData.status) {  
                    // Agregar respuesta del chatbot al contenedor de chat
                    if (objData.status) {  
                        // Agregar respuesta del chatbot al contenedor de chat
                        let botMessageElement = document.createElement('div');
                        botMessageElement.classList.add('message');
                        botMessageElement.classList.add('bot');
                        botMessageElement.textContent = JSON.stringify(objData.msg); // Convertir el objeto a cadena JSON
                        chatContainer.appendChild(botMessageElement);
                    } else {
                        // Manejar el error
                        console.error("Error: ", objData.msg);
                    }
                    
                    
                } else {
                    // Manejar el error
                    console.error("Error: ", objData.msg);
                }
            }
        };
        
        // Limpiar el campo de entrada después de enviar el mensaje
        document.getElementById('userInput').value = '';
    });
});