<?php
session_start();

require_once "models/conn.php";
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtener los valores ingresados en el formulario
  $email = $_REQUEST['email'];

  // Sanitizar el valor del correo electrónico
  $email = $conn->real_escape_string($email);

  //Crear la query
  $query = "SELECT first_name FROM twn_users WHERE email = '$email'";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    // El correo electrónico existe en la base de datos
    $row = $result->fetch_assoc();
    $nombre = $row['first_name'];
    $tkn = md5($email);

    //Creamos un token para la recuperación del correo
    $query = "UPDATE twn_users SET confirmation_code = '$tkn' WHERE email = '$email'";
    $result = $conn->query($query);
    if ($result == true) {
      $error = "Revisa tu correo electrónico.";
      // Actualización exitosa
      //¡¡¡¡OJO A LA RUTA!!!
      $link = "<a href='localhost/pfinal/resetpwd.php?key=" . $email . "&tkn=" . $tkn . "'>haz click aquí</a>";
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
        $mail->addAddress('no-reply@twine.com', 'Twine');
        $mail->IsHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = "Reinicio de contraseña en Twine";
        $mail->Body = "Si no has pedido reiniciar tu contraseña, ignora este mensaje.\nSi quieres continuar con el reinicio de tu contraseña, $link";
        $mail->send();
      } catch (Exception $e) {
        $e->errorMessage();
      }
    } else {
      // Error en la actualización
      $error = "El correo electrónico no existe en la base de datos.";
    }
  } else {
    // El correo electrónico no existe en la base de datos
    $error = "El correo electrónico no existe en la base de datos.";
  }

  $conn->close();
}

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
  <title>Twine - Has olvidado tu contraseña?</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #F2F2F2;
    }

    .card {
      width: 600px;
      padding: 30px;
      background-color: #FFFFFF;
      border-radius: 8px;
      box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.15);
    }

    .error {
      color: red;
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
            <li class="nav-item p-2">
              <a href="home.php" class="text-decoration-none" style="color: black;">
                <span class="icon"><i class="fas fa-2x fa-home"></i></span>
              </a>
            </li>
            <li class="nav-item p-2">
              <a href="logout.php" class="text-decoration-none" style="color:black;">
                <span class=icon"><i class="fas fa-2x fa-power-off"></i></span>
              </a>
            </li>
          </ul>
        <?php }
        ?>
      </div>
    </div>
  </nav>
  <!-- /NAVBAR -->
  <div class="card">
    <h2 class="text-center">¿Has olvidado tu contraseña?</h2><br />
    <p class="text-center">No te preocupes, podemos ayudarte a restablecerla. Por favor, introduce la dirección de
      correo electrónico asociada a tu cuenta y te enviaremos las instrucciones para recuperar tu contraseña.</p>
    <br />
    <form class="text-center" action="newpwd.php" method="post" id="resetPwd">
      <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input type="email" class="form-control" id="email" name="email" required>
        <br />
        <?php
        if (!empty($error)) { ?>
          <p class="error"><?php echo $error ?></p>
        <?php } ?>
      </div>
      <button type="submit" class="btn btn-primary">Restablecer contraseña</button>
    </form>
  </div>
  <script type="text/javascript" src="helpers/jquery-3.6.3.js"></script>
  <script type="text/javascript" src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
</body>

</html>