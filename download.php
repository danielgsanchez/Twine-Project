<?php
session_start();

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
  <script type="text/javascript" src="helpers/jquery-3.6.3.js"></script>
  <script type="text/javascript" src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
  <title>Twine - Descarga la app</title>
  <style>
    @media (max-width: 768px) {
      .col-md-6 img {
        margin-bottom: 10px;
      }
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

  <!-- SECTION 1: botón de descarga + img -->
  <div class="px-4 py-5 my-5 text-center" id="section1">
    <h1 class="display-5 fw-bold text-center">¡Empieza ahora!</h1>
    <div class="row align-items-center p-2 m-2">
      <div class="col-md-6 text-center align-middle">
        <p class="lead mb-4">¿Estás cansado de buscar el amor en todos los lugares equivocados? ¿Te gustaría tener una
          forma más fácil y eficiente de conectarte con personas afines a ti? Entonces, Twine es la app de citas
          perfecta para ti. ¿A qué estás esperando? Descarga Twine hoy y comienza a conocer a personas increíbles que
          comparten tus intereses y valores.</p>
        <button type="button" class="btn btn-primary btn-lg px-4 gap-3">
          <a href="https://play.google.com/store/apps" class="text-decoration-none" style="color:white;">
            Descargar Twine
          </a>
        </button>
      </div>
      <div class="col-md-6">
        <br>
        <img src="images/img_dwn1.png" width="100%">
      </div>
    </div>
  </div>
  <!-- /SECTION 1 -->

  <!-- SECTION 2: plataformas disponibles -->
  <div class="px-4 py-5 my-5 bg-light-sub text-center">
    <h1 class="display-5 fw-bold text-center">Plataformas disponibles</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">Actualmente, Twine está disponible para dispositivos iOS, Android y HarmonyOS. Además de con
        nuestra app para móviles, puedes entrar en Twine.com y usar Twine para web.<br><br>

        Twine es actualmente compatible con iOS 14.0 o superior, Android 7.0 o superior, y las últimas versiones de
        todos los principales navegadores web (Chrome, Firefox, Safari, Edge, etc.).</p>
      <div class="row">
        <div class="col-md-6">
          <img src="icons/app_store_dwn.svg" width="75%" id="appstore">
        </div>
        <div class="col-md-6">
          <img src="icons/google_play_dwn.svg" width="75%" id="gplay">
        </div>
      </div>
    </div>
  </div>
  <!-- /SECTION 2 -->

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
  <script type="text/javascript" src="bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="jquery-3.6.3.js"></script>
</body>

</html>