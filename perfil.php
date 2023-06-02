<?php
session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}

require_once "models/conn.php";
require_once "models/user_model.php";

$userModel = new UserModel($conn);
$goldSub = $userModel->getGold($_SESSION["email"]);
$profileData = $userModel->getFullProfile($_SESSION["user_id"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener la información del archivo subido
    $file = $_FILES["profile-image"];

    // Verificar si se seleccionó un archivo
    if ($file["error"] === UPLOAD_ERR_OK) {
        // Obtener el nombre y la ubicación temporal del archivo
        $filename = $file["name"];
        $tempFilePath = $file["tmp_name"];

        // Mover el archivo a la ubicación deseada
        $destination = "ruta_de_destino/" . $filename;
        move_uploaded_file($tempFilePath, $destination);

        // Actualizar la ruta de la imagen en la base de datos
        // ...

        // Resto del código para procesar y guardar los otros campos del formulario
        // ...

        // Redireccionar o mostrar un mensaje de éxito
        // ...
    } else {
        // Hubo un error al subir el archivo
        // Manejar el error adecuadamente
        // ...
    }
}



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
            /* Cambiar el color de fondo a un rosa muy ligero */
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 80px;
            background-color: #f8f9fa;
            /* Cambiar el color de fondo a light */
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
            height: 100vh;
            /* Ajustar la altura al 100% del viewport */
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
            min-width: 600px;
            margin-right: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .profile-image {
            border-radius: 128px;
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
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
                border-radius: 128px;
                max-width: 100%;
                max-height: 100%;
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
        <div class="container">
            <div class="card">
                <h2>Editar perfil</h2><br />
                <form action="guardar_perfil.php" method="POST" id="perfilForm" name="perfilForm">
                    <div class="mb-3 d-flex justify-content-center align-items-center">
                        <div class="position-relative">
                            <img src="<?php echo $profileData[0]["link"] ?>" alt="Imagen de perfil" class="profile-image" style="display: block; margin: 0 auto;"><br />
                            <input type="file" id="profile-image" name="profile-image">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre:</label>
                        <input type="text" id="name" name="name" value=<?php echo $profileData[0]['first_name'] ?> class="form-control" required>
                        <small id="name-error" class="error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Apellido:</label>
                        <input type="text" id="last_name" name="last_name" value=<?php echo $profileData[0]['last_name'] ?> class="form-control" required>
                        <small id="last_name-error" class="error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Género:</label>
                        <select name="gender" id="gender" class="form-control" required>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                        <small id="gender-error" class="error-text"></small>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción:</label>
                        <textarea id="description" name="description" class="form-control" rows="4"><?php echo $profileData[0]["description"] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Guardar perfil</button>
                    </div>
                </form>
            </div>
            <div class="card">
                <h2>Cambiar credenciales</h2>
                <form action="cambiar_credenciales.php" method="POST" id="credForm" name="credForm">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña actual:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="new-password" class="form-label">Nueva contraseña:</label>
                        <input type="password" id="new-password" name="new-password" class="form-control" required>
                    </div>
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

            // Validar el campo de imagen
            var profileImage = document.getElementById("profile-image").value;
            if (profileImage === "") {
                showError("profile-image", "Por favor, seleccione una imagen de perfil.");
                isValid = false;
            } else {
                hideError("profile-image");
            }

            // Validar el campo de nombre
            var name = document.getElementById("name").value;
            if (name === "") {
                showError("name", "Por favor, ingrese su nombre.");
                isValid = false;
            } else {
                hideError("name");
            }

            // Validar el campo de apellido
            var lastName = document.getElementById("last_name").value;
            if (lastName === "") {
                showError("last_name", "Por favor, ingrese su apellido.");
                isValid = false;
            } else {
                hideError("last_name");
            }

            // Validar el campo de género
            var gender = document.getElementById("gender").value;
            if (gender === "") {
                showError("gender", "Por favor, seleccione su género.");
                isValid = false;
            } else {
                hideError("gender");
            }

            // Resto de las validaciones del formulario...

            return isValid;
        }

        
    </script>
</body>

</html>