<?php

session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
} elseif ($_SESSION["email"] == "admin@admin.es") {
    header("Location: admin_page.php");
    exit;
}

require_once "config/config.php";
require_once "models/user_model.php";

$userModel = new UserModel($conn);
$goldSub = $userModel->getGold($_SESSION["user_id"]);
$profileData = $userModel->getFullProfile($_SESSION["user_id"]);
$interested_in = $userModel->getInterestedIn($_SESSION["user_id"]);

if (isset($_REQUEST['msg'])) {
    $msg = $_REQUEST['msg'];
}

if (isset($_REQUEST['pfmsg'])) {
    $pfmsg = $_REQUEST['pfmsg'];
}

function getGenders()
{
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM twn_genders";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Error al ejecutar la consulta: " . $conn->error);
    }

    $genders = array();

    while ($row = $result->fetch_assoc()) {
        $genders[$row['id']] = $row;
    }

    $conn->close();

    return $genders;
}

$genders = getGenders();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="icons/favicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="helpers/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Twine - Perfil</title>
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
            /* Espacio adicional entre el icono y el texto */
        }

        .sidebar .text {
            display: none;
            /* Ocultar el texto por defecto */
        }

        .sidebar-expanded .text {
            display: inline-block;
            /* Mostrar el texto solo cuando la barra lateral está expandida */
        }

        .content {
            margin-left: 80px;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            resize: vertical;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            max-width: 600px;
            margin-right: 20px;
        }

        .profile-image {
            max-width: 256px;
            max-height: 256px;
            display: block;
            margin: 0 auto;
        }

        .error-text {
            color: red;
        }

        .profile-icon-large {
            font-size: 48px;
            /* Tamaño del icono */
            display: block;
            margin: 0 auto;
            text-align: center;
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

            .container {
                flex-direction: column;
                align-items: center;
            }

            .card {
                margin-right: 0;
                margin-bottom: 20px;
            }

            .profile-image {
                max-width: 75%;
                max-height: 75%;
                width: auto;
                height: auto;
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
            <div class="card">
                <h2>Editar perfil</h2><br />
                <form action="controllers/save_profile.php" method="POST" id="profileForm" name="profileForm" enctype="multipart/form-data">
                    <div class="mb-3 d-flex justify-content-center align-items-center">
                        <div class="position-relative">
                            <?php if (empty($profileData[0]["link"])) : ?>
                                <i class="fas fa-user-circle profile-icon-large"></i>
                            <?php else : ?>
                                <img src="<?php echo $profileData[0]["link"] ?>" alt="Imagen de perfil" class="profile-image img-fluid rounded">
                            <?php endif; ?>
                            <br /><input type="file" id="profile-image" name="profile-image">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">Nombre:</label>
                        <input type="text" id="first_name" name="first_name" value=<?php echo $profileData[0]['first_name'] ?> class="form-control" required>
                        <small id="name-error" class="error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Apellido:</label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo $profileData[0]['last_name'] ?>" class="form-control" required>
                        <small id="last_name-error" class="error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="screen_name" class="form-label">Nick:</label>
                        <input type="text" id="screen_name" name="screen_name" value=<?php echo $profileData[0]['screen_name'] ?> class="form-control" required>
                        <small id="screen_name-error" class="error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Género:</label>
                        <select name="gender" id="gender" class="form-control" required>
                            <?php foreach ($genders as $id => $gender) : ?>
                                <option value="<?php echo $id; ?>" <?php echo ($id == $profileData[0]['gender_id']) ? 'selected' : ''; ?>>
                                    <?php echo $gender['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small id="gender-error" class="error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="interested_in" class="form-label">Busco:</label>
                        <select name="interested_in" id="interested_in" class="form-control" required>
                            <?php foreach ($genders as $id => $gender) : ?>
                                <?php $isSelected = (!empty($interested_in) && isset($interested_in['gender_id']) && $id == $interested_in['gender_id']); ?>
                                <option value="<?php echo $id; ?>" <?php echo $isSelected ? 'selected' : ''; ?>>
                                    <?php echo $gender['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small id="gender-error" class="error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción:</label>
                        <textarea id="description" name="description" class="form-control" rows="4"><?php echo $profileData[0]["description"] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="hobbies" class="form-label">Hobbies:</label>
                        <textarea id="hobbies" name="hobbies" class="form-control" rows="4"><?php echo $profileData[0]["hobbies"] ?></textarea>
                    </div>
                    <?php
                    if (!empty($pfmsg)) {
                        echo "<p style='color:red;'>" . $pfmsg . "</p>";
                    }
                    ?>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Guardar perfil</button>
                    </div>
                </form>
            </div>
            <div class="card">
                <h2>Cambiar credenciales</h2>
                <form action="controllers/save_credentials.php" method="POST" id="credForm" name="credForm">
                    <div class="mb-3">
                        <h6>Cambiar email:</h6>
                        <label for="email" class="form-label">Correo electrónico:</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $profileData[0]["email"] ?>" required>
                        <small id="email-error" class="error-text"></small>
                    </div>
                    <hr />
                    <div class="mb-3">
                        <h6>Cambiar contraseña:</h6>
                        <label for="new-password" class="form-label">Nueva contraseña:</label>
                        <input type="password" id="new-password" name="new-password" class="form-control">
                        <small id="new-password-error" class="error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="conf-password" class="form-label">Confirmar nueva contraseña:</label>
                        <input type="password" id="conf-password" name="conf-password" class="form-control">
                        <small id="conf-password-error" class="error-text"></small>
                    </div>
                    <hr />
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña actual:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        <small id="password-error" class="error-text"></small>
                    </div>
                    <?php
                    if (!empty($msg)) {
                        echo "<p style='color:red;'>" . $msg . "</p>";
                    }
                    ?>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Cambiar credenciales</button>
                    </div>
                </form>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var profileForm = document.getElementById("profileForm");
            var credentialsForm = document.getElementById("credForm");

            document.getElementById('credForm').addEventListener('submit', function(event) {
                if (!validateCredForm()) {
                    event.preventDefault();
                }
            });

            document.getElementById('profileForm').addEventListener('submit', function(event) {
                if (!validateProfileForm()) {
                    event.preventDefault(); // Evitar el envío del formulario si la validación no es exitosa
                }
            });
        });


        // Función para mostrar un mensaje de error junto al campo
        function showError(fieldId, errorMessage) {
            var errorElement = document.getElementById(fieldId + "-error");
            errorElement.innerText = errorMessage;
            errorElement.style.display = "block";
        }

        // Función para ocultar el mensaje de error del campo
        function hideError(fieldId) {
            var errorElement = document.getElementById(fieldId + "-error");
            errorElement.innerText = "";
            errorElement.style.display = "none";
        }

        // Validación del formulario antes de enviarlo
        function validateProfileForm() {
            var isValid = true;
            var profileImage = document.getElementById("profile-image").value;
            var name = document.getElementById("first_name").value;
            var lastName = document.getElementById("last_name").value;
            var screenName = document.getElementById("screen_name").value;
            var gender = document.getElementById("gender").value;

            // Validar el campo de imagen
            if (profileImage.trim() === "") {
                isValid = false;
                showError("profile-image", "Por favor, seleccione una imagen de perfil.");
            } else {
                hideError("profile-image");
            }

            // Validar el campo de nombre
            if (name.trim() === "") {
                isValid = false;
                showError("name", "El nombre no puede estar vacío.");
            } else {
                hideError("name");
            }

            // Validar el campo de apellido
            if (lastName.trim() === "") {
                isValid = false;
                showError("last_name", "El apellido no puede estar vacío.");
            } else {
                hideError("last_name");
            }

            // Validar el campo de nick
            if (screenName.trim() === "") {
                isValid = false;
                showError("screen_name", "El nick no puede estar vacío.");
            } else {
                hideError("screen_name");
            }

            // Validar el campo de género
            if (gender.trim() === "") {
                isValid = false;
                showError("gender", "Por favor, selecciona tu género.");
            } else {
                hideError("gender");
            }

            return isValid;
        }

        function validateCredForm() {
            var isValid = true;
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            var newPassword = document.getElementById('new-password').value;
            var confPassword = document.getElementById('conf-password').value;
            // Validar la contraseña nueva utilizando una expresión regular
            var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

            // Validar el campo de correo electrónico
            if (email.trim() === "") {
                showError("email", "Por favor, ingrese su correo electrónico.");
                isValid = false;
            } else {
                hideError("email");
            }

            //Validar nueva contraseña si se introduce
            if (newPassword.trim() !== "") {
                // Validar el campo de nueva contraseña
                if (!passwordRegex.test(newPassword.trim())) {
                    showError("new-password", "La nueva contraseña debe tener al menos 8 caracteres, una letra minúscula, una letra mayúscula y un número.");
                    isValid = false;
                } else {
                    hideError("new-password");
                }
                if (newPassword !== confPassword) {
                    showError("conf-password", "Las contraseñas deben coincidir.");
                    isValid = false;
                }
            }

            // Validar el campo de contraseña
            if (password.trim() === "") {
                showError("password", "Por favor, ingrese su contraseña actual.");
                isValid = false;
            } else {
                hideError("password");
            }

            return isValid;
        }
    </script>
</body>

</html>