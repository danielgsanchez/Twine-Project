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
  <title>Twine - Contacta con nosotros</title>
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
    <form class="row g-3" id="form_contacto">
      <div class="col-md-6">
        <span><img src="icons/person-circle.svg"></span>
        <label for="nombre" class="form-label">Nombre: </label>
        <input type="text" class="form-control" id="nombre" required>
      </div>
      <div class="col-md-6">
        <span><img src="icons/envelope-heart-fill.svg"></span>
        <label for="email" class="form-label">Tu email: </label>
        <input type="text" class="form-control" id="email" required>
      </div>
      <div class="col-md-12">
        <span><img src="icons/send-fill.svg"></span>
        <label for="comentario" class="form-lab">¿Cómo podemos ayudarte?</label>
        <textarea class="form-control" id="comentario" rows="3" required></textarea>
      </div>
      <div class="col-md-12">
        <button type="submit" name="submit" class="btn btn-primary">Enviar</button>
      </div>
    </form>
  </div>
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
      <h6><a href="index.html" class="text-decoration-none">Twine</a> © 2023 Copyright</h6>
  </footer>
  <!-- /FOOTER -->
  <script type="text/javascript" src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="helpers/jquery-3.6.3.js"></script>
</body>

</html>