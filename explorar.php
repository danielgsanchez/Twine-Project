<?php

session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
} elseif ($_SESSION["email"] == "admin@admin.es") {
    header("Location: admin_page.php");
    exit;
}

require_once "models/user_model.php";

$userModel = new UserModel($conn);
$userModel->checkBan();
$goldSub = $userModel->getGold($_SESSION["user_id"]);

$randomProfile = $userModel->getRandomProfile($_SESSION["user_id"]);

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
    <script type="text/javascript" src="explorar.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
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
            z-index: 999;
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

        .card {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-title {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .card-text {
            margin-bottom: 15px;
        }

        .card-description {
            flex-grow: 1;
        }

        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
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

        .toast-success.match {
            background-color: #ff6190;
        }

        .toast-success.reject {
            background-color: #dc3545;
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
                    <span class="text">Principal</span>
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
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card-deck">
                        <?php if ($randomProfile) : ?>
                            <div class="card">
                                <img style="display: block; margin: 0 auto;" src="<?php echo $randomProfile['link'] ? $randomProfile['link'] : 'chat_imgs/user_pics/default.png'; ?>" class="card-img-top" alt="Foto de perfil">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <strong>
                                            <p id="pfname"><?php echo $randomProfile['first_name'] . " " . $randomProfile['last_name']; ?></p>
                                        </strong>
                                    </h5>
                                    <strong>Género: </strong>
                                    <p id="gender"><?php echo $randomProfile['gender_name']; ?></p>
                                    <div class="form-group card-description">
                                        <strong>Descripción:</strong><br />
                                        <p id="description"> <?php echo $randomProfile['description']; ?></p>
                                    </div>
                                    <div class="form-group card-description">
                                        <strong>Hobbies:</strong><br />
                                        <p id="hobbies"> <?php echo $randomProfile['hobbies']; ?></p>
                                    </div>
                                    <div class="card-buttons">
                                        <button id="mBtn" data-profile-id="<?php echo $randomProfile['id']; ?>" onclick="matchProfile(this)" class="btn btn-primary">
                                            <i class="fas fa-heart"></i> ¡Enlázate!
                                        </button>
                                        <button id="rBtn" data-profile-id="<?php echo $randomProfile['id']; ?>" onclick="rejectProfile(this)" class="btn btn-danger">
                                            <i class="fas fa-ban"></i> Pasar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <p>No se encontraron perfiles disponibles.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
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