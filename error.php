<?php
?>

<!DOCTYPE html>
<html>

<head>

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="icons/favicon.png">
    <link rel="stylesheet" type="text/css" href="helpers/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css" />
    <script type="text/javascript" src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="helpers/jquery-3.6.3.js"></script>
    <title>Twine - Error 404</title>
    <style>
      body {
        background-color: #000;
      }

      .error-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
      }

      .error-title {
        font-size: 3rem;
        color: #fff;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
      }

      .error-message {
        font-size: 1.5rem;
        color: #fff;
        margin-top: 1rem;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
      }

      .error-link {
        margin-top: 2rem;
      }

      .error-link a {
        color: #fff;
        font-weight: bold;
        text-decoration: underline;
      }
    </style>
  </head>

<body>
  <div class="container error-container">
    <h1 class="error-title">Error 404</h1>
    <p class="error-message">Lo sentimos, la página que estás buscando no se encuentra.</p>
    <p class="error-message">Por favor, regresa a <a href="index.php">Twine</a> o intenta nuevamente más tarde.</p>
  </div>
</body>

</html>