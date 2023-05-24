<?php

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="icons/favicon.png">
  <link rel="stylesheet" type="text/css" href="helpers/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="style.css" />
  <script type="text/javascript" src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="helpers/jquery-3.6.3.js"></script>
  <title>Twine - Página inicial</title>
  <style>
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

  <!-- HERO + MODAL -->
  <div class="hero d-flex align-items-center justify-content-center p-2 container-fluid" id="hero">
    <div class="container text-center p-4" id="herotext">
      <h1 id="title">Twist around</h1>
      <p><strong>¡Conoce gente!</strong></p>
      <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#registroModal">Regístrate</button>
    </div>
  </div>
  <!-- MODAL -->
  <div class="modal fade" id="registroModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registroModalLabel">Regístrate con tu correo electrónico</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="registroForm" method="post">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre"
                placeholder="Será como te conozcan los demás en Twine" required>
            </div>
            <br />
            <div class="mb-3">
              <label for="email" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" id="email" name="email"
                placeholder="Enviaremos un código de confirmación a tu correo" required>
              <div id="emailHelp" class="form-text">No compartiremos tu correo electrónico con nadie más.</div>
            </div>
            <br />
            <div class="mb-3">
              <label for="pw" class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="pw" name="pw" placeholder="Elige una contraseña segura"
                required>
              <div id="pwHelp" class="form-text">Tu contraseña debe ser de al menos 8 caracteres, alfanumérica, con
                mayúsculas y minúsculas</div>
              <span id="pwError" class="error"></span>
            </div>
            <br />
            <div class="mb-3">
              <label for="pwConfirm" class="form-label">Confirmar contraseña</label>
              <input type="password" class="form-control" id="pwConfirm" name="pwConfirm" placeholder="¡Esta es fácil!"
                required>
              <div id="pwConfirmHelp" class="form-text">Tu contraseña y este campo deben coincidir</div>
              <span id="pwConfirmError" class="error"></span>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Registrarse</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- /HERO + MODAL -->
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
      <h6><a href="index.html" class="text-decoration-none">Twine</a> © 2023 Copyright</h6>
  </footer>
  <!-- /FOOTER -->
  <script type="text/javascript" src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="helpers/jquery-3.6.3.js"></script>
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