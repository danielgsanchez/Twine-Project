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
$matches = $userModel->getMatches($_SESSION["user_id"]);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="icons/favicon.png">
    <link rel="stylesheet" type="text/css" href="helpers/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script type="text/javascript" src="helpers/jquery-3.6.3.js"></script>
    <script type="text/javascript" src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
    <title>Twine - Chats</title>
    <script>
        // Variable global para almacenar el ID del usuario seleccionado
        var selectedUserID = null;

        // Función para obtener los mensajes
        function getMessages(matchUserID) {
            $.ajax({
                url: "controllers/get_message.php",
                method: "GET",
                data: {
                    matchUserID: matchUserID
                },
                success: function(data) {
                    $("#messages").html(data);
                }
            });
        }

        // Verificar si existe un match antes de enviar un mensaje
        function checkMatchAndSendMessage() {
            var selectedUser = $("#matchedUsers").val();
            if (selectedUser !== "") {
                sendMessage(selectedUser);
            } else {
                alert("No has seleccionado un usuario. No puedes enviar mensajes.");
            }
        }

        // Función para enviar un mensaje
        function sendMessage(matchUserID) {
            var message = $("#message").val();
            var selectedChatID = $("#matchedUsers option:selected").data("chatid");

            $.ajax({
                url: "controllers/send_message.php",
                method: "GET",
                data: {
                    matchUserID: matchUserID,
                    message: message,
                    chatID: selectedChatID
                },
                success: function(data) {
                    if (data === "message_sent") {
                        // Limpiar el campo de entrada después de enviar el mensaje
                        $("#message").val("");
                        // Actualizar los mensajes mostrados
                        getMessages(matchUserID);
                    } else {
                        alert("Error al enviar el mensaje. Inténtalo de nuevo.");
                        console.log(data);
                    }
                },
                error: function() {
                    alert("Error al enviar el mensaje. Inténtalo de nuevo.");
                }
            });
        }

        $(document).ready(function() {
            // Actualizar los mensajes y los usuarios con match cada cierto intervalo
            setInterval(function() {
                var selectedUser = $("#matchedUsers").val();
                getMessages(selectedUser);
            }, 1000);

            // Manejar el envío del formulario
            $("form").submit(function(e) {
                e.preventDefault();
                var selectedUser = $("#matchedUsers").val();
                checkMatchAndSendMessage(selectedUser);
            });

            $("#matchedUsers").on("change", function() {
                // Obtener el ID del usuario seleccionado
                selectedUserID = $(this).val();
                selectedChatID = $(this).find("option:selected").data("chatid");

                // Mostrar el div de chat
                $("#chatContainer").show();

                // Obtener y mostrar los mensajes del usuario seleccionado
                getMessages(selectedUserID);
            });
        });
    </script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #fcdfe2;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 80px;
            background-color: #f8f9fa;
            transition: width 0.3s ease-in-out;
        }

        .sidebar-expanded {
            width: 200px;
        }

        .sidebar-logo {
            text-align: center;
            padding: 20px;
            color: #000;
            font-size: 24px;
        }

        .sidebar-icons {
            padding: 20px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .sidebar-icons li {
            margin-bottom: 10px;
            text-align: center;
        }

        .sidebar-icons a {
            color: #000;
            font-size: 20px;
            display: inline-block;
            vertical-align: middle;
            text-decoration: none;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-icons a:hover {
            background-color: #e9ecef;
        }

        .sidebar-icons a:active {
            background-color: #c6d2d9;
        }

        .sidebar-expanded .sidebar-icons a .icon {
            display: inline-block;
        }

        .sidebar-expanded .sidebar-icons a .text {
            display: inline-block;
            margin-left: 5px;
        }

        .sidebar .text {
            display: none;
        }

        .sidebar-expanded .text {
            display: inline-block;
        }

        .content {
            margin-left: 80px;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .home-card {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            max-width: 400px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
            }

            .sidebar-expanded {
                width: 120px;
            }

            .content {
                margin-left: 60px;
            }
        }

        #chatContainer {
            display: none;
        }

        /* Estilos para la sección de chats */
        .chats-section {
            margin-top: 40px;
        }

        .chats-section h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .matched-users-select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        /* Estilos para el contenedor de chat */
        .chat-container {
            display: none;
            margin-top: 40px;
        }

        .chat-container h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .messages {
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            max-height: 300px;
            overflow-y: auto;
        }

        .messages .message {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .messages .message.sent {
            background-color: #d6efff;
            text-align: right;
        }

        .messages .message.received {
            background-color: #e2fcd7;
            text-align: left;
        }

        .chat-form {
            display: flex;
            align-items: center;
        }

        .chat-form input[type="text"] {
            flex-grow: 1;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .chat-form button {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <a href="home.php">
                <img src="images/logo_vf.svg">
            </a>
        </div>
        <ul class="sidebar-icons">
            <li>
                <a href="perfil.php">
                    <span class="icon"><i class="fas fa-user"></i></span>
                    <span class="text">Perfil</span>
                </a>
            </li>
            <li>
                <a href="chats.php">
                    <span class="icon"><i class="fas fa-comments"></i></span>
                    <span class="text">Chats</span>
                </a>
            </li>
            <li>
                <a href="explorar.php">
                    <span class="icon"><i class="fas fa-search"></i></span>
                    <span class="text">Explorar</span>
                </a>
            </li>
            <?php
            if ((isset($goldSub)) && ($goldSub == 1)) { ?>
                <li>
                    <a href="likes.php">
                        <span class="icon"><i class="fas fa-heart"></i></span>
                        <span class="text">Likes</span>
                    </a>
                </li>
            <?php } ?>
            <li>
                <a href="index.php">
                    <span class="icon"><i class="fas fa-home"></i></span>
                    <span class="text">Home</span>
                </a>
            </li>
            <li>
                <a href="logout.php">
                    <span class="icon"><i class="fas fa-power-off"></i></span>
                    <span class="text">Desconectar</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="content">
        <h1>Chat</h1>
        <h2>Usuarios con match:</h2>
        <select id="matchedUsers" class="matched-users">
            <option value=""></option>
            <?php foreach ($matches as $match) : ?>
                <option value="<?php echo $match['id']; ?>" data-chatid="<?php echo $userModel->getChatId(($_SESSION["user_id"]), $match['id']); ?>"><?php echo $match['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <div id="chatContainer">
            <h2>Mensajes:</h2>
            <div id="messages" class="messages">
            </div>
            <form class="message-form">
                <input type="text" id="message" placeholder="Escribe tu mensaje" class="message-input">
                <button type="submit" class="send-button">Enviar</button>
            </form>
        </div>
    </div>
        <script>
            $(document).ready(function() {
                var $sidebar = $('#sidebar');
                var $content = $('.content');

                $sidebar.mouseenter(function() {
                    $sidebar.addClass('sidebar-expanded');
                    $content.css('margin-left', '200px');
                });

                $sidebar.mouseleave(function() {
                    $sidebar.removeClass('sidebar-expanded');
                    $content.css('margin-left', '80px');
                });
            });
        </script>
</body>

</html>