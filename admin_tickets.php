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

$adminModel = new AdminModel($conn);
$tickets = $adminModel->getUserTickets();
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
    <title>Twine - Tickets</title>
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
                    <span class="text">Salir</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="content">
        <div class="home-card">
            <h2>Tickets de Usuario</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario 1</th>
                        <th>Usuario 2</th>
                        <th>Razón</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tickets as $ticket) : ?>
                        <tr>
                            <td><?php echo $ticket['id']; ?></td>
                            <td><?php echo $ticket['user1_first_name'] . ' ' . $ticket['user1_last_name']; ?></td>
                            <td><?php echo $ticket['user2_first_name'] . ' ' . $ticket['user2_last_name']; ?></td>
                            <td><?php echo $ticket['reason']; ?></td>
                            <td>
                                <button class="delete-ticket btn btn-primary" data-ticket-id="<?php echo $ticket['id']; ?>">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
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

            $(".delete-ticket").click(function() {
                var ticketId = $(this).data("ticket-id");
                var $button = $(this);

                // Realizar la llamada AJAX para eliminar el ticket
                $.ajax({
                    url: "controllers/delete_ticket.php",
                    method: "POST",
                    data: {
                        ticketId: ticketId
                    },
                    success: function(response) {
                        if (response == "success") {
                            // Actualizar la interfaz para mostrar el popup y eliminar la fila
                            alert("Ticket borrado");
                            $button.closest("tr").remove();
                        } else {
                            alert("Error al borrar el ticket");
                        }
                    }
                });
            })
        });
    </script>
</body>

</html>