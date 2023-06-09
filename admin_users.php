<?php

session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
} elseif ($_SESSION["email"] != "admin@admin.es") {
    header("Location: error.php");
    exit;
}

require_once "models/conn.php";
require_once "models/admin_model.php";

$aM = new AdminModel($conn);
$users = $aM->getUsersWithPhotos();
?>

<!DOCTYPE html>
<html lang="es">

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
    <title>Twine - Gestión de usuarios</title>
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
        }

        .home-card {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            max-width: 400px;
        }

        .btn-ban {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn-unban {
            background-color: green;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .btn-ban:hover,
        .btn-ban:focus-visible,
        .btn-ban:active {
            background-color: darkred;
            color: white;
        }

        .btn-unban:hover,
        .btn-unban:focus-visible,
        .btn-unban:focus-visible {
            background-color: darkgreen;
            color: white;
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
    </style>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <a href="admin_page.php">
                <img src="images/logo_vf.svg">
            </a>
        </div>
        <ul class="sidebar-icons">
            <li>
                <a href="admin_tickets.php">
                    <span class="icon"><i class="fas fa-file-alt"></i></span>
                    <span class="text">Tickets</span>
                </a>
            </li>
            <li>
                <a href="admin_users.php">
                    <span class="icon"><i class="fas fa-users"></i></span>
                    <span class="text">Gestionar usuarios</span>
                </a>
            </li>
            <li>
                <a href="https://mailtrap.io/inboxes/2233646/messages">
                    <span class="icon"><i class="fas fa-envelope"></i></span>
                    <span class="text">Comentarios</span>
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
    <h1 style="text-align: center;">Usuarios</h1>
    <div id="content" class="content">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>ID</th>
                        <th>Nombre completo</th>
                        <th>Email</th>
                        <th>Twine Gold</th>
                        <th>Baneado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user) : ?>
                        <tr>
                            <td style="align-items: center; justify-content: center; display:flex">
                                <?php if ($user['photo_link']) : ?>
                                    <img src="<?php echo $user['photo_link']; ?>" alt="Foto de perfil">
                                <?php else : ?>
                                    <i class="fas fa-user-circle fa-5x"></i>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['first_name'] . " " . $user['last_name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['gold_sub'] ? 'Sí' : 'No'; ?></td>
                            <td class="ban-status" data-user-id="<?php echo $user['id']; ?>">
                                <?php echo $user['is_banned'] ? 'Sí' : 'No'; ?>
                            </td>
                            <td>
                                <?php if ($user['is_banned']) : ?>
                                    <button id="unbanBtn_<?php echo $user['id']; ?>" class="btn btn-unban">
                                        Desbanear <i class="fa fa-times"></i>
                                    </button>
                                <?php else : ?>
                                    <button id="banBtn_<?php echo $user['id']; ?>" class="btn btn-ban">
                                        Banear <i class="fa fa-user-times"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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

            // Obtener todos los botones de desbanear
            var unbanButtons = $('[id^="unbanBtn_"]');
            unbanButtons.click(function() {
                var userId = getUserIdFromButtonId($(this).attr('id'));
                unbanUser(userId, this);
            });

            // Obtener todos los botones de banear
            var banButtons = $('[id^="banBtn_"]');
            banButtons.click(function() {
                var userId = getUserIdFromButtonId($(this).attr('id'));
                confirmBan(userId, this);
            });
        });

        function getUserIdFromButtonId(buttonId) {
            // Extraer el ID de usuario del identificador del botón
            var idParts = buttonId.split('_');
            return idParts[1];
        }

        function confirmBan(userId, button) {
            if (confirm("¿Estás seguro de que deseas banear a este usuario?")) {
                banUser(userId, button);
            }
        }

        function banUser(userId, button) {
            $.ajax({
                url: 'controllers/admin_actions.php',
                type: 'POST',
                data: {
                    action: 'ban',
                    userId: userId
                },
                success: function(response) {
                    if (response.includes('success')) {
                        alert('Usuario baneado')
                        var newButton = $('<button class="btn btn-unban" onclick="unbanUser(' + userId + ', this)">Desbanear <i class="fa fa-user-plus"></i></button>');
                        var banStatusTd = $('.ban-status[data-user-id="' + userId + '"]');
                        banStatusTd.text('Sí');
                        $(button).replaceWith(newButton);
                    } else {
                        alert('Ha ocurrido un error al banear al usuario');
                    }
                },
                error: function() {
                    alert('Ha ocurrido un error en la solicitud');
                }
            });
        }

        function unbanUser(userId, button) {
            $.ajax({
                url: 'controllers/admin_actions.php',
                type: 'POST',
                data: {
                    action: 'unban',
                    userId: userId
                },
                success: function(response) {
                    if (response.includes('success')) {
                        alert('Usuario desbaneado')
                        var newButton = $('<button class="btn btn-ban" onclick="confirmBan(' + userId + ', this)">Banear <i class="fa fa-user-times"></i></button>');
                        $(button).replaceWith(newButton);
                        var banStatusTd = $('.ban-status[data-user-id="' + userId + '"]');
                        banStatusTd.text('No');
                    } else {
                        alert('Ha ocurrido un error al desbanear al usuario');
                    }
                },
                error: function() {
                    alert('Ha ocurrido un error en la solicitud');
                }
            });
        }

        // // Escuchar el evento 'success' emitido por la llamada Ajax
        // $(document).on('success', function(event, data) {
        //     const successMessage = document.createElement('div');
        //     successMessage.classList.add('alert', 'alert-success');
        //     successMessage.textContent = data.message;

        //     const homeCard = document.querySelector('.table-responsive');
        //     homeCard.parentNode.insertBefore(successMessage, homeCard);
        // });

        // // Escuchar el evento 'error' emitido por la llamada Ajax
        // $(document).on('error', function(event, data) {
        //     const errorMessage = document.createElement('div');
        //     errorMessage.classList.add('alert', 'alert-danger');
        //     errorMessage.textContent = data.message;

        //     const homeCard = document.querySelector('.table-responsive');
        //     homeCard.parentNode.insertBefore(errorMessage, homeCard);
        // });
    </script>
</body>

</html>