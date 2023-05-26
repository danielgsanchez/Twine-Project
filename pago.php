<?php
session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
} else {
    $selEmail = $_SESSION["email"];
}

require_once "models/conn.php";

// Consulta para comprobar si es usuario de Twine Gold
$email = $_SESSION["email"];
$sql = "SELECT gold_sub FROM twn_users WHERE email = '$email'";

// Ejecutar la consulta
$result = $conn->query($sql);

// Verificar si se encontró el usuario
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $goldSub = $row['gold_sub'];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE twn_users SET gold_sub = 1 WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selEmail);

    if ($stmt->execute()) {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
          var successBox = document.createElement("div");
          successBox.classList.add("success-box");
          successBox.textContent = "Compra exitosa. Disfruta de Twine Gold!";

          var closeButton = document.createElement("button");
          closeButton.classList.add("close-button");
          closeButton.innerHTML = "&#10006;";

          successBox.appendChild(closeButton);
          document.body.appendChild(successBox);

          setTimeout(function() {
            successBox.style.display = "none";
          }, 3000);

          closeButton.addEventListener("click", function() {
            successBox.style.display = "none";
          });
        });
      </script>';
    } else {
        echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
          var errorBox = document.createElement("div");
          errorBox.classList.add("error-box");
          errorBox.textContent = "Se ha producido algún error durante la compra.";

          var closeButton = document.createElement("button");
          closeButton.classList.add("close-button");
          closeButton.innerHTML = "&#10006;";

          errorBox.appendChild(closeButton);
          document.body.appendChild(errorBox);

          setTimeout(function() {
            errorBox.style.display = "none";
          }, 3000);

          closeButton.addEventListener("click", function() {
            errorBox.style.display = "none";
          });
        });
      </script>';
    }
}

?>

<!DOCTYPE html>
<html>

<?php
if ($goldSub == 0) { ?>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="icons/favicon.png">
        <link rel="stylesheet" type="text/css" href="helpers/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="style.css" />
        <title>Suscríbete a Twine Gold!</title>
        <style>
            body {
                background-color: #ff92c6;
            }
            .container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .card {
                background-color: #f8e6e6;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                max-width: 800px;
                width: 100%;
                margin: 0 auto;
            }

            .payment-methods {
                margin-bottom: 20px;
            }

            .payment-methods label {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
                cursor: pointer;
            }

            .payment-methods label i {
                margin-right: 10px;
            }

            .payment-fields {
                display: none;
                margin-top: 10px;
            }

            .payment-fields label {
                margin-bottom: 5px;
            }

            .discount {
                color: #ff3d6b;
                font-weight: bold;
            }

            h2 {
                color: #ff3d6b;
                margin-bottom: 20px;
            }

            select {
                background-color: #f8e6e6;
                border: 1px solid #ff3d6b;
                color: #ff3d6b;
                padding: 5px;
                border-radius: 5px;
            }

            .error-message {
                color: red;
                margin-top: 5px;
            }

            .error {
                color: red;
            }

            .success-box {
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 10px;
                background-color: #28a745;
                color: #fff;
                border-radius: 4px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                z-index: 9999;
            }

            .error-box {
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 10px;
                background-color: #ffdddd;
                color: #ff0000;
                border-radius: 4px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                z-index: 9999;
            }

            .close-button {
                position: absolute;
                top: 5px;
                right: 5px;
                background: none;
                border: none;
                color: #fff;
                font-size: 16px;
                cursor: pointer;
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
        <form id="paymentForm" action="pago.php" method="post">
            <div class="container">
                <div class="card">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>Método de Pago</h2>
                            <div class="payment-methods">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="paypal" name="paymentMethod" onchange="togglePaymentFields()">
                                    <label class="form-check-label" for="paypal"><i class="fab fa-paypal"></i> PayPal</label>
                                </div>
                                <div class="payment-fields" id="paypalFields">
                                    <label for="email"><i class="far fa-envelope"></i> Correo de PayPal:</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Introduce tu correo de PayPal">
                                </div><br />
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="creditCard" name="paymentMethod" value="creditCard" onchange="togglePaymentFields()">
                                    <label class="form-check-label" for="creditCard"><i class="far fa-credit-card"></i>
                                        Tarjeta</label>
                                </div>
                                <div class="payment-fields" id="creditCardFields">
                                    <label for="name"><i class="far fa-user"></i> Nombre:</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Introduce tu nombre completo" required><br />
                                    <label for="cardNumber"><i class="far fa-credit-card"></i> Número de Tarjeta:</label>
                                    <input type="text" id="cardNumber" name="cardNumber" class="form-control" placeholder="Introduce el número de tu tarjeta de crédito" required>
                                    <span id="cardNumberError" class="error-message"></span><br />
                                    <label for="expiration"><i class="far fa-calendar-alt"></i> Fecha de Expiración:</label>
                                    <input type="text" id="expiration" name="expiration" class="form-control" placeholder="Introduce la fecha de expiración (MM/AA)" required>
                                    <span id="expirationError" class="error-message"></span><br />
                                    <label for="cvv"><i class="fas fa-lock"></i> CVV/CVC:</label>
                                    <input type="password" id="cvv" name="cvv" class="form-control" placeholder="Introduce el código de seguridad CVV/CVC" required>
                                    <span id="cvvError" class="error-message"></span><br />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h2>Plan de Pago</h2>
                            <select id="plan" name="plan" class="form-select" onchange="updatePaymentSummary()">
                                <option>-- Elige un plan --</option>
                                <option value="monthly">Mensual</option>
                                <option value="annual">Anual</option>
                            </select><br />
                            <div id="paymentSummary">
                                <!-- La información de pago se mostrará aquí -->
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <script>
            function togglePaymentFields() {
                var paypalFields = document.getElementById("paypalFields");
                var creditCardFields = document.getElementById("creditCardFields");
                var cardFields = creditCardFields.querySelectorAll("input[required]");

                if (document.getElementById("paypal").checked) {
                    paypalFields.style.display = "block";
                    creditCardFields.style.display = "none";
                    cardFields.forEach(function(field) {
                        field.removeAttribute("required");
                    });
                } else {
                    paypalFields.style.display = "none";
                    creditCardFields.style.display = "block";
                    cardFields.forEach(function(field) {
                        field.setAttribute("required", "required");
                    });
                }

                // Limpia los mensajes de error cuando se cambia el método de pago
                document.getElementById("cardNumberError").textContent = "";
                document.getElementById("expirationError").textContent = "";
                document.getElementById("cvvError").textContent = "";
            }

            function updatePaymentSummary() {
                var plan = document.getElementById("plan").value;
                var paymentSummary = document.getElementById("paymentSummary");

                if (plan === "monthly") {
                    paymentSummary.innerHTML = `
                    <p><strong>Precio:</strong> 15€</p>
                    <p><strong>IVA (21%):</strong> 3.75€</p>
                    <p><strong>Precio Final:</strong> 18.75€</p>
                `;
                } else if (plan === "annual") {
                    paymentSummary.innerHTML = `
                    <p><strong>Precio:</strong> 180€</p>
                    <p><strong>IVA (21%):</strong> 37.80€</p>
                    <p><span class="discount"><i class="fas fa-tag"></i> Descuento por Suscripción Anual: -21.78€</span></p>
                    <p><strong>Precio Final:</strong> 196.02€</p>
                `;
                } else {
                    paymentSummary.innerHTML = "";
                }
            }

            function validateCreditCard() {
                var paymentMethod = document.querySelector('input[name="paymentMethod"]:checked');

                if (paymentMethod.value !== "creditCard") {
                    return true; // No se valida la tarjeta de crédito si no es el método de pago seleccionado
                }

                var cardNumber = document.getElementById("cardNumber").value;
                var expiration = document.getElementById("expiration").value;
                var cvv = document.getElementById("cvv").value;
                var cardNumberError = document.getElementById("cardNumberError");
                var expirationError = document.getElementById("expirationError");
                var cvvError = document.getElementById("cvvError");
                var isValid = true;

                // Validar número de tarjeta
                if (!/^\d{16}$/.test(cardNumber)) {
                    cardNumberError.textContent = "Número de tarjeta inválido";
                    isValid = false;
                } else {
                    cardNumberError.textContent = "";
                }

                // Validar fecha de expiración
                if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiration)) {
                    expirationError.textContent = "Fecha de expiración inválida (MM/AA)";
                    isValid = false;
                } else {
                    expirationError.textContent = "";
                }

                // Validar CVV/CVC
                if (!/^\d{3}$/.test(cvv)) {
                    cvvError.textContent = "CVV/CVC inválido";
                    isValid = false;
                } else {
                    cvvError.textContent = "";
                }

                return isValid;
            }

            function validatePlan() {
                var plan = document.getElementById("plan").value;

                if (plan == "-- Elige un plan --") {
                    alert("Por favor, elige un plan de pago");
                    return false;
                }

                return true;
            }

            function validateForm() {
                var paymentMethod = document.querySelector('input[name="paymentMethod"]:checked');
                var email = document.getElementById("email").value;

                if (paymentMethod.value === "creditCard") {
                    // Validar tarjeta de crédito y plan
                    if (validateCreditCard() && validatePlan()) {
                        // Envía el formulario si la validación es exitosa
                        document.getElementById("paymentForm").submit();
                        return true;
                    }
                } else if (paymentMethod.value === "paypal") {
                    // Validar correo de PayPal y plan
                    if (email === "") {
                        alert("Por favor, introduce tu correo de PayPal.");
                        return false;
                    }

                    if (validatePlan()) {
                        // Envía el formulario si la validación es exitosa
                        document.getElementById("paymentForm").submit();
                        return true;
                    }
                }

                return false;
            }
        </script>
    <?php } elseif ($goldSub == 1) { ?>
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
            <title>¡Ya eres Gold!</title>
            <style>
                body {
                    background-color: #ff92c6;
                }

                .gold-card {
                    width: 400px;
                    background-color: gold;
                    padding: 20px;
                    text-align: center;
                    border-radius: 10px;
                    margin: 0 auto;
                    margin-top: 200px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                }

                .gold-card h2 {
                    font-size: 24px;
                    margin-bottom: 20px;
                }

                .gold-card p {
                    font-size: 18px;
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
            <div class="container mt-5">
                <div class="row justify-content-center" style="height: 100vh;">
                    <div class="col-md-6">
                        <div class="gold-card">
                            <h2>¡Ya perteneces a Twine Gold!</h2>
                            <p>Disfruta de tus ventajas! ;)</p>
                        </div>
                    </div>
                </div>
            </div>
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
                    <h6><a href="index.php" class="text-decoration-none">Twine</a> © 2023 Copyright
                    </h6>
                </div>
            </footer>
            <!-- /FOOTER -->
            <script src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.bundle.min.js"></script>
        </body>

        </html>
    <?php } else {
    header("Location: error.php");
    exit;
}
