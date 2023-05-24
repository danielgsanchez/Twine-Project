<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro en Twine</title>
  <link rel="icon" type="image/x-icon" href="icons/favicon.png">
  <link rel="stylesheet" type="text/css" href="helpers/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="style.css" />
  <script type="text/javascript" src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="helpers/jquery-3.6.3.js"></script>
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

    .registration-form {
      background-color: #fff;
      padding: 40px;
      border-radius: 10px;
      text-align: center;
      flex: 1;
      margin-right: 40px;
    }

    .registration-form h1 {
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
            <button class="btn btn-primary me-2" type="button">
              <a href="registro.html" class="text-decoration-none text-white">Regístrate</a>
            </button>
          </li>
          <li class="nav-item">
            <button class="btn btn-primary" type="button">
              <a href="login.html" class="text-decoration-none text-white">Conéctate</a>
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- /NAVBAR -->
  <div class="container">
    <div class="registration-form">
      <h1>Registro</h1>
      <form name="registroForm" id="registroForm" method="post">
        <div class="form-group">
          <label for="name">Nombre</label>
          <input type="text" class="form-control" id="nombre" name="nombre"
            placeholder="Será como te conozcan los demás en Twine" required>
        </div>
        <div class="form-group">
          <label for="email">Correo electrónico</label>
          <input type="email" class="form-control" id="email" name="email"
            placeholder="Enviaremos un código de confirmación a tu correo" required>
          <div id="emailHelp" class="form-text">No compartiremos tu correo electrónico con nadie más.</div>
        </div>
        <div class="form-group">
          <label for="password">Contraseña</label>
          <input type="password" class="form-control" id="pw" name="pw" placeholder="Elige una contraseña segura"
            required>
          <div id="pwHelp" class="form-text">Tu contraseña debe ser de al menos 8 caracteres, alfanumérica, con
            mayúsculas y minúsculas</div>
          <span id="pwError" class="error"></span>
        </div>
        <div class="form-group">
          <label for="confirm-password">Confirmar contraseña</label>
          <input type="password" class="form-control" id="pwConfirm" name="pwConfirm" placeholder="¡Esta es fácil!"
            required>
          <div id="pwConfirmHelp" class="form-text">Tu contraseña y este campo deben coincidir</div>
          <span id="pwConfirmError" class="error"></span>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
      </form>
    </div>
    <div class="twine-logo text-center">
      <img src="images/abt_logo.png" alt="Twine Logo">
      <h2>Twist around</h2>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Referenciar los elementos del formulario
      var form = document.getElementById('registroForm');
      var pwInput = document.getElementById('pw');
      var pwConfirmInput = document.getElementById('pwConfirm');
      var pwError = document.getElementById('pwError');
      var pwConfirmError = document.getElementById('pwConfirmError');

      // Agregar un evento al envío del formulario para realizar la validación en el lado del cliente
      form.addEventListener('submit', function (event) {
        pwError.textContent = ''; // Limpiar mensaje de error anterior
        pwConfirmError.textContent = ''; // Limpiar mensaje de error anterior

        if (pwInput.value.length < 8) {
          event.preventDefault();
          pwError.textContent = 'La contraseña debe tener al menos 8 caracteres';
          pwError.classList.add('error');
          pwInput.focus();
          return;
        }

        if (!/(?=.*[A-Z])(?=.*\d)/.test(pwInput.value)) {
          event.preventDefault();
          pwError.textContent = 'La contraseña debe contener al menos una mayúscula y un número';
          pwError.classList.add('error');
          pwInput.focus();
          return;
        }

        if (pwInput.value !== pwConfirmInput.value) {
          event.preventDefault();
          pwConfirmError.textContent = 'Las contraseñas no coinciden';
          pwConfirmError.classList.add('error');
          pwConfirmInput.focus();
          return;
        }
      });
    });
  </script>
</body>

</html>