<?php
session_start();

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = $_REQUEST["nombre"];
  $nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
  $email = $_REQUEST["email"];
  $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
  $comentario = $_REQUEST["comentario"];
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

  try {
    $mail->setFrom($email, $nombre);
    $mail->addReplyTo($email, $nombre);
    $mail->addAddress('contacto@twine.com', 'Twine');
    $mail->CharSet = 'UTF-8';
    $mail->Subject = "Comentario de $nombre";
    $mail->Body = 'Nombre: '.$nombre."\n".'Email: '.$email."\n".'Comentario: '.$comentario;
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
  <script type="text/javascript" src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="helpers/jquery-3.6.3.js"></script>
  <title>Twine - Contacta con nosotros</title>
  <style>
    .message {
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      font-weight: bold;
      text-align: center;
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
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-md navbar-light bg-light p-2 fixed-top" id="navbar">
    <div class="container-fluid">
      <a class="navbar-brand text-decoration-none active" href="index.php">
        <img width="40" src="images/logo_vf.svg">
        Twine
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navegacion">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navegacion">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="info.php">Información</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contacto.php">Contacta con nosotros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="download.php">Descarga la app</a>
          </li>
        </ul>
        <?php
        if (empty($_SESSION["email"])) { ?>
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a href="registro.php" class="text-decoration-none text-white">
                <button class="btn btn-primary me-2" type="button">
                  Regístrate
                </button>
              </a>
            </li>
            <li class="nav-item">
              <a href="login.php" class="text-decoration-none text-white">
                <button class="btn btn-primary" type="button">
                  Conéctate
                </button>
              </a>
            </li>
          </ul>
        <?php } else { ?>
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a href="home.php" class="text-decoration-none" style="color: black;">
                <span class="icon"><i class="fas fa-2x fa-home"></i></span>
              </a>
            </li>
          </ul>
        <?php }
        ?>
      </div>
    </div>
  </nav>
  <!-- /NAVBAR -->
  <br><br>
  <!-- FORMULARIO -->
  <div class="container px-4 py-5 my-5" style="min-height: 73vh;">
    <div class="row text-center">
      <h1>¡Contacta con nosotros!</h1>
      <p>
        ¡Hey! ¿Necesitas ayuda con algo? ¿Tienes alguna pregunta o sugerencia sobre Twine? ¡Estamos aquí para ayudarte!
        Nos encanta escuchar a nuestros usuarios, y nos tomamos en serio cualquier comentario o sugerencia que tengas.
        Puedes contactarnos en cualquier momento a través de nuestro formulario de contacto, y te responderemos lo más
        pronto posible.
      </p>
    </div>
    <br>
    <form class="row g-3" id="form_contacto" action="contacto.php" method="post">
      <div class="col-md-6">
        <span><img src="icons/person-circle.svg"></span>
        <label for="nombre" class="form-label">Nombre: </label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
      </div>
      <div class="col-md-6">
        <span><img src="icons/envelope-heart-fill.svg"></span>
        <label for="email" class="form-label">Tu email: </label>
        <input type="text" class="form-control" id="email" name="email" required>
      </div>
      <div class="col-md-12">
        <span><img src="icons/send-fill.svg"></span>
        <label for="comentario" class="form-lab">¿Cómo podemos ayudarte?</label>
        <textarea class="form-control" id="comentario" rows="3" name= "comentario" required></textarea>
      </div>
      <div class="col-md-12">
        <button type="submit" name="submit" class="btn btn-primary">Enviar</button>
      </div>
    </form>
  </div>
<?php if (!empty($message)): ?>
  <div class="message <?php echo $messageClass; ?>">
    <?php echo $message; ?>
  </div>
<?php endif; ?>
  <!-- /FORMULARIO -->
  <!-- FOOTER -->
  <footer class="bg-light">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 text-center">
          <div class="justify-content-between p-3">
            <a href="https://es-es.facebook.com/" class="p-3"><img src="icons/facebook.svg" width="30px"></a>
            <a href="https://twitter.com/" class="p-3"><img src="icons/twitter.svg" width="30px"></a>
            <a href="https://www.instagram.com/" class="p-3"><img src="icons/instagram.svg" width="30px"></a>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center p-3" id="footercopy">
      <h6><a href="index.php" class="text-decoration-none">Twine</a> © 2023 Copyright</h6>
  </footer>
  <!-- /FOOTER -->
  <script type="text/javascript" src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="helpers/jquery-3.6.3.js"></script>
</body>

</html>