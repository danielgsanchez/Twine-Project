<?php
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="icons/favicon.png">
  <link rel="stylesheet" type="text/css" href="helpers/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="style.css" />
  <script type="text/javascript" src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="helpers/jquery-3.6.3.js"></script>
  <title>Iniciar sesión en Twine</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Damion&display=swap');

    body {
      background-color: #fc89ac;
    }

    .container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      height: 100vh;
      padding: 0 40px;
    }

    .login-form {
      background-color: #fff;
      padding: 40px;
      border-radius: 10px;
      text-align: center;
      flex: 1;
      margin-right: 40px;
    }

    .login-form h1 {
      color: #ff6190;
      font-family: 'Damion', cursive;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .twine-logo {
      text-align: center;
      flex: 1;
      margin-left: 40px;
    }

    .twine-logo img {
      width: 200px;
    }

    .twine-logo h2 {
      color: #fff;
      margin-top: 10px;
      font-family: 'Damion', cursive;
    }

    @media (max-width: 768px) {
      .twine-logo {
        display: none;
      }

      .login-form {
        margin-right: 0;
      }
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
      <a class="navbar-brand text-decoration-none active" href="index.html">
        <img width="40" src="images/logo_vf.svg">
        Twine
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navegacion">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navegacion">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="info.html">Información</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contacto.html">Contacta con nosotros</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="download.html">Descarga la app</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="registro.html" class="text-decoration-none text-white">
              <button class="btn btn-primary me-2" type="button">
                Regístrate
              </button>
            </a>
          </li>
          <li class="nav-item">
            <a href="login.html" class="text-decoration-none text-white">
              <button class="btn btn-primary" type="button">
                Conéctate
              </button>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- /NAVBAR -->
  <!-- LOGIN FORM -->
  <div class="container">
    <div class="login-form">
      <h1>Iniciar sesión</h1>
      <form>
        <div class="form-group">
          <label for="email">Correo electrónico</label>
          <input type="email" id="email" name="email" class="form-control" placeholder="Tu correo electrónico" required>
        </div>
        <div class="form-group">
          <label for="password">Contraseña</label>
          <input type="password" id="password" name="password" class="form-control" placeholder="Tu contraseña"
            required>
        </div>
        <p>¿Has olvidado tu contraseña?</p>
        <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
      </form>
    </div>
    <div class="twine-logo text-center">
      <img src="images/abt_logo.png" alt="Twine Logo">
      <h2>Twist around</h2>
    </div>
  </div>
  <!-- /LOGIN FORM -->
</body>

</html>