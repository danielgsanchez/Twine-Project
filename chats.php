<?php

session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}

require_once "models/conn.php";
require_once "models/user_model.php";

$userModel = new UserModel($conn);
$userModel->checkBan();
$user1 = $userModel->getProfile($_SESSION["user_id"]);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Función para enviar un mensaje
            function sendMessage() {
                var message = $("#message").val();

                $.ajax({
                    url: "send_message.php",
                    method: "POST",
                    data: { message: message },
                    success: function() {
                        // Limpiar el campo de entrada después de enviar el mensaje
                        $("#message").val("");
                        // Actualizar los mensajes mostrados
                        getMessages();
                    }
                });
            }

            // Función para obtener los mensajes
            function getMessages() {
                $.ajax({
                    url: "get_messages.php",
                    method: "GET",
                    success: function(data) {
                        $("#messages").html(data);
                    }
                });
            }

            // Verificar si existe un match antes de enviar un mensaje
            function checkMatchAndSendMessage() {
                $.ajax({
                    url: "check_match.php",
                    method: "GET",
                    success: function(data) {
                        if (data === "match_found") {
                            sendMessage();
                        } else {
                            alert("No tienes un match. No puedes iniciar el chat.");
                        }
                    }
                });
            }

            // Obtener los usuarios con los que hay match
            function getMatchedUsers() {
                $.ajax({
                    url: "get_matched_users.php",
                    method: "GET",
                    success: function(data) {
                        $("#matchedUsers").html(data);
                    }
                });
            }

            // Actualizar los mensajes y los usuarios con match cada cierto intervalo
            setInterval(function() {
                getMessages();
                getMatchedUsers();
            }, 1000);

            // Manejar el envío del formulario
            $("form").submit(function(e) {
                e.preventDefault();
                checkMatchAndSendMessage();
            });
        });
    </script>
</head>
<body>
    <h1>Chat</h1>
    <h2>Usuarios con match:</h2>
    <div id="matchedUsers">
        <!-- Aquí se mostrarán los usuarios con los que hay match -->
    </div>
    <h2>Mensajes:</h2>
    <div id="messages">
        <!-- Aquí se mostrarán los mensajes -->
    </div>
    <form>
        <input type="text" id="message" placeholder="Escribe tu mensaje">
        <button type="submit">Enviar</button>
    </form>
</body>
</html>
