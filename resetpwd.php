<?php

session_start();

require_once "models/conn.php";

if ((!empty($_REQUEST["newPwd"])) && (!empty($_REQUEST["confNewPwd"]))) {
  $newPwd = $_REQUEST['newPwd'];
  $confNewPwd = $_REQUEST['confNewPwd'];
  $error = "";

  // Realizar la validación de la contraseña
  if (strlen($newPwd) < 8 || !preg_match('/^(?=.*[A-Z])(?=.*\d).+$/', $newPwd) || $newPwd !== $confNewPwd) {
    // La contraseña no cumple los requisitos o los campos de contraseña no coinciden
    $error = "La contraseña no cumple los requisitos o los campos de contraseña no coinciden.\n";
    return $error;
  } else {
    // Los campos de contraseña son válidos, proceder con la actualización

    // Hashear la nueva contraseña con MD5
    $hashedPwd = md5($newPwd);

    // Realizar la actualización en la base de datos
    $email = $_REQUEST["email"];

    // Obtener la contraseña actual del usuario
    $email = $_REQUEST["email"];
    $sql = "SELECT password FROM twn_users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $currentPwd = $row["password"];

      if ($hashedPwd === $currentPwd) {
        $error .= "La nueva contraseña no puede ser igual a la contraseña actual. \n";
      } else {
        // La nueva contraseña no es igual a la actual, proceder con la actualización
        // Realizar la actualización en la base de datos
        $sql = "UPDATE twn_users SET password='$hashedPwd' WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {
          $sql = "UPDATE twn_users SET confirmation_code = NULL WHERE email = '$email'";
          $result = $conn->query($sql);
          $msg = "Contraseña actualizada con éxito.<br/>Esta será tu nueva contraseña. ¡No la pierdas!";
        } else {
          $msg = "Error al actualizar la contraseña.";
        }
      }
    } else {
      $error .= "No se pudo obtener la contraseña actual del usuario.";
    }

    if (!empty($error)) { ?>
      <!DOCTYPE html>
      <html>

      <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="icons/favicon.png">
        <link rel="stylesheet" type="text/css" href="helpers/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script type="text/javascript" src="helpers/jquery-3.6.3.js"></script>
        <script type="text/javascript" src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
        <title>Twine - Recupera tu contraseña</title>
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

      <body>
        <div class="card">
          <h2 class="text-center">Establece tu nueva contraseña</h2><br />
          <p class="text-center">Esta será tu nueva contraseña a partir de ahora, ¡no la pierdas!</p>
          <br />
          <form class="text-center" action="resetpwd.php" method="post" id="resetPwdForm">
            <div class="mb-3">
              <input type="hidden" name="email" value="<?php echo $email; ?>">
              <input type="hidden" name="confirmation_code" value="<?php echo $token; ?>">
              <label for="newPwd" class="form-label">Nueva contraseña</label>
              <input type="password" class="form-control" id="newPwd" name="newPwd" required>
              <span id="pwError" class="error"></span><br />
              <label for="confNewPwd" class="form-label">Confirma la contraseña</label>
              <input type="password" class="form-control" id="confNewPwd" name="confNewPwd" required>
              <span id="pwConfirmError" class="error"></span>
              <span id="phperror" class="error"><?php echo $error ?></span>
              <br />
            </div>
            <button type="submit" class="btn btn-primary">Restablecer contraseña</button>
          </form>
        </div>

        <script type="text/javascript" src="helpers/jquery-3.6.3.js"></script>
        <script type="text/javascript" src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            // Referenciar los elementos del formulario
            var form = document.getElementById('resetPwdForm');
            var pwInput = document.getElementById('newPwd');
            var pwConfirmInput = document.getElementById('confNewPwd');
            var pwError = document.getElementById('pwError');
            var pwConfirmError = document.getElementById('pwConfirmError');

            // Agregar un evento al envío del formulario para realizar la validación en el lado del cliente
            form.addEventListener('submit', function(event) {
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
    <?php
    } else { ?>
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
        <title>Twine - Recupera tu contraseña</title>
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
          <h2 class="text-center">¡Contraseña actualizada!</h2><br />
          <p class="text-center"><?php echo $msg ?></p>
        </div>
        <script type="text/javascript" src="helpers/jquery-3.6.3.js"></script>
        <script type="text/javascript" src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
      </body>

      </html>
    <?php
      $conn->close();
    }
  }
} elseif (isset($_GET['key']) && isset($_GET['tkn'])) {
  $email = $_GET['key'];
  $token = $_GET['tkn'];
  $query = mysqli_query($conn, "SELECT * FROM twn_users WHERE email = '$email' AND confirmation_code = '$token'");
  if (mysqli_num_rows($query) > 0) { ?>
    <!DOCTYPE html>
    <html>

    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" type="image/x-icon" href="icons/favicon.png">
      <link rel="stylesheet" type="text/css" href="helpers/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css" />
      <link rel="stylesheet" type="text/css" href="style.css" />
      <script type="text/javascript" src="helpers/jquery-3.6.3.js"></script>
      <script type="text/javascript" src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
      <title>Twine - Recupera tu contraseña</title>
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

    <body>
      <div class="card">
        <h2 class="text-center">Establece tu nueva contraseña</h2><br />
        <p class="text-center">Esta será tu nueva contraseña a partir de ahora, ¡no la pierdas!</p>
        <br />
        <form class="text-center" action="resetpwd.php" method="post" id="resetPwdForm">
          <div class="mb-3">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <input type="hidden" name="confirmation_code" value="<?php echo $token; ?>">
            <label for="newPwd" class="form-label">Nueva contraseña</label>
            <input type="password" class="form-control" id="newPwd" name="newPwd" required>
            <span id="pwError" class="error"></span><br />
            <label for="confNewPwd" class="form-label">Confirma la contraseña</label>
            <input type="password" class="form-control" id="confNewPwd" name="confNewPwd" required>
            <span id="pwConfirmError" class="error"></span>
            <br />
          </div>
          <button type="submit" class="btn btn-primary">Restablecer contraseña</button>
        </form>
      </div>

      <script type="text/javascript" src="helpers/jquery-3.6.3.js"></script>
      <script type="text/javascript" src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          // Referenciar los elementos del formulario
          var form = document.getElementById('resetPwdForm');
          var pwInput = document.getElementById('newPwd');
          var pwConfirmInput = document.getElementById('confNewPwd');
          var pwError = document.getElementById('pwError');
          var pwConfirmError = document.getElementById('pwConfirmError');

          // Agregar un evento al envío del formulario para realizar la validación en el lado del cliente
          form.addEventListener('submit', function(event) {
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
<?php
  } else {
    header("Location: error.php");
  }
} else {
  header("Location: error.php");
}
?>