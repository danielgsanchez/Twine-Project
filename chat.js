$(document).ready(function() {
    // Función para cargar los mensajes iniciales del chat
    function loadChatMessages() {
        // Aquí puedes realizar una llamada AJAX para obtener los mensajes del chat
        // y mostrarlos en el elemento con el id "chat-messages"
        $.ajax({
            url: 'get_chat_messages.php', // Ruta del script PHP que obtiene los mensajes del chat
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // Aquí puedes procesar la respuesta y mostrar los mensajes en el chat
                if (response.success) {
                    var chatMessages = response.messages;
                    var chatMessagesContainer = $('#chat-messages');
                    chatMessagesContainer.empty();

                    for (var i = 0; i < chatMessages.length; i++) {
                        var message = chatMessages[i];
                        var messageElement = $('<div>').text(message);
                        chatMessagesContainer.append(messageElement);
                    }
                } else {
                    console.error('Error al cargar los mensajes del chat.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    }

    // Función para enviar un mensaje
    function sendMessage(message) {
        // Aquí puedes realizar una llamada AJAX para enviar el mensaje al servidor
        // y guardarlo en la base de datos
        $.ajax({
            url: 'send_message.php', // Ruta del script PHP que envía el mensaje
            method: 'POST',
            dataType: 'json',
            data: {
                message: message
            },
            success: function(response) {
                // Aquí puedes procesar la respuesta y actualizar el chat si es necesario
                if (response.success) {
                    // El mensaje se envió exitosamente, puedes realizar alguna acción adicional
                } else {
                    console.error('Error al enviar el mensaje.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    }

    // Cargar los mensajes iniciales del chat al cargar la página
    loadChatMessages();

    // Manejar el envío del formulario de chat
    $('#chat-form').submit(function(e) {
        e.preventDefault();
        var messageInput = $('#message-input');
        var message = messageInput.val().trim();

        if (message !== '') {
            sendMessage(message);
            messageInput.val('');
        }
    });

    // Actualizar los mensajes del chat cada cierto intervalo de tiempo (por ejemplo, cada 5 segundos)
    setInterval(loadChatMessages, 5000);
});