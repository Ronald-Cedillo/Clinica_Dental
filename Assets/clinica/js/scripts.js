document.getElementById('homeMenu').addEventListener('click', function() {
    showContent('home');
});

document.getElementById('reservasMenu').addEventListener('click', function() {
    showContent('reservas');
});

function showContent(id) {
    document.querySelectorAll('.content').forEach(function(div) {
        div.style.display = 'none';
    });
    document.getElementById(id).style.display = 'block';
}


document.addEventListener('DOMContentLoaded', function() {
    let sendButton = document.getElementById('sendButton');
    let userInput = document.getElementById('userInput');
    let chatContainer = document.getElementById('chatContainer');

    if (sendButton && userInput && chatContainer) {
        sendButton.addEventListener('click', function() {
            let userInputValue = userInput.value;

            // Agregar mensaje del usuario al contenedor de chat
            let userMessageElement = document.createElement('div');
            userMessageElement.classList.add('message', 'user');
            userMessageElement.textContent = userInputValue;
            chatContainer.appendChild(userMessageElement);

            let request = (window.XMLHttpRequest) ? 
                        new XMLHttpRequest() : 
                        new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Home/setPrueba/';
            let formData = new FormData();
            formData.append('userInput', userInputValue);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function() {
                if (request.readyState != 4) return;
                if (request.status == 200) {
                    console.log(request.responseText); // Verifica el contenido de la respuesta
                    try {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status) {  
                            // Agregar respuesta del chatbot al contenedor de chat
                            let botMessageElement = document.createElement('div');
                            botMessageElement.classList.add('message', 'bot');
                            botMessageElement.textContent = objData.msg;
                            chatContainer.appendChild(botMessageElement);
                        } else {
                            console.error("Error: ", objData.msg);
                        }
                    } catch (e) {
                        console.error("Error al analizar JSON: ", e);
                    }
                }
            };

            // Limpiar el campo de entrada después de enviar el mensaje
            userInput.value = '';
        });
    } else {
        console.error('Elementos no encontrados en el DOM');
    }
});





    // Enviar el mensaje al controlador
    
    
    /*.then(response => response.json())
    .then(data => {
        // Mostrar la respuesta del chatbot en la vista
        const botMessageElement = document.createElement('p');
        botMessageElement.className = 'botMessage';
        botMessageElement.textContent = data.reply;
        chatContainer.appendChild(botMessageElement);
    })
    .catch(error => {
        console.error('Error:', error);
    });

    // Limpiar el campo de entrada
    document.getElementById('userInput').value = '';
}*/
