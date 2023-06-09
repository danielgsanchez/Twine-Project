<?php

session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
} elseif ($_SESSION["email"] == "admin@admin.es") {
    header("Location: admin_page.php");
    exit;
}

require_once "models/conn.php";
require_once "models/user_model.php";

$userModel = new UserModel($conn);
$userModel->checkBan();
$goldSub = $userModel->getGold($_SESSION["user_id"]);

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
    <title>¡Bienvenido a Twine!</title>
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
            height: 100vh;
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
    <?php
    if ((isset($goldSub)) && ($goldSub == 0)) { ?>
        <div class="content">
            <div class="home-card">
                <h2>Hazte Oro</h2>
                <p>¡Descubre todas las ventajas de suscribirte a Twine Gold, como ver quién te ha dado like y más!</p>
                <button class="btn btn-primary" type="button">
                    <a href="pago.php" class="text-decoration-none text-white">Suscríbete</a>
                </button>
            </div>
        </div>
    <?php } else { ?>
        <div class="content">
            <div class="home-card">
                <h2>Bienvenido a Twine Gold</h2>
                <p>Tu cuenta tiene una suscripción a Twine Gold. ¡Disfruta de todas las ventajas exclusivas!</p>
            </div>
        </div>
    <?php } ?>
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