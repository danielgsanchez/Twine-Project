<?php

session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_REQUEST["name"];
    $nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
    $email = $_REQUEST["email"];
    $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    $comentario = $_REQUEST["comment"];
    $comentario = htmlspecialchars($comentario, ENT_QUOTES, 'UTF-8');

    // Conexión a Mailtrap con PHPMailer
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Username = '6558046cac0910';
    $mail->Password = '96048df3ac7453';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 2525;

    // Enviar email
    try {
        $mail->setFrom($email, $nombre);
        $mail->addReplyTo($email, $nombre);
        $mail->addAddress('contacto@twine.com', 'Twine');
        $mail->CharSet = 'UTF-8';
        $mail->Subject = "Apelación de suspensión";
        $mail->Body = 'Nombre: ' . $nombre . "\n" . 'Email: ' . $email . "\n" . 'Apelación: ' . $comentario;
        $mail->send();

        $message = '¡Tu comentario ha sido recibido!';
        $messageClass = 'success';
    } catch (Exception $e) {
        $message = 'Se ha producido un error. Inténtalo de nuevo.';
        $messageClass = 'error';
    }
}

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
    <title>Twine - Usuario baneado</title>
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .ban-container {
            text-align: center;
        }

        .ban-icon {
            font-size: 100px;
            color: #dc3545;
        }

        .ban-message {
            font-size: 24px;
            margin-top: 20px;
        }

        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
        }

        .success {
            background-color: #a6e39d;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>

    <div class="ban-container">
        <i class="fas fa-ban ban-icon"></i>
        <p class="ban-message">Tu cuenta ha sido suspendida debido a violaciones de las normas del sitio.
            Si crees que ha sido un error, <a href="#" id="contact-link">ponte en contacto con nosotros</a>.
        </p>
        <div class="text-center">
            <a href="logout.php" class="btn btn-primary">Cerrar sesión</a>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">Formulario de Contacto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Ingresa tu nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu email" value="<?php echo $_SESSION["email"] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comentario</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Escribe tu comentario" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><br>
    <?php if (!empty($message)) : ?>
        <div class="message <?php echo $messageClass; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#contact-link').click(function() {
                $('#contactModal').modal('show');
            });
        });
    </script>
</body>

</html>