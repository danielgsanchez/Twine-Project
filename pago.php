<?php

session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}

require_once "models/conn.php";
require_once "models/user_model.php";
require_once "models/payment_model.php";

$userModel = new UserModel($conn);
$goldSub = $userModel->getGold($_SESSION["user_id"]);
$paymentModel = new PaymentClass($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_REQUEST["paymentMethod"] == "paypal") {
        $result = $paymentModel->validatePaypal($_REQUEST["paypalEmail"], $_SESSION["email"]);
        $msg = json_decode($result, true);
        if ($msg["success"]) {
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
                window.location.replace("pago.php");
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
    } else {
        $result = $paymentModel->validateCard($_REQUEST["cardNumber"], $_REQUEST['cardName'], $_REQUEST['cardExpiry'], $_REQUEST['cardCVC'], $_SESSION["email"]);
        $msg = json_decode($result, true);
        if ($msg["success"]) {
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
                window.location.replace("pago.php");
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
}

?>

<?php if ($goldSub == 0) { ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="icons/favicon.png">
        <link rel="stylesheet" type="text/css" href="helpers/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="style.css" />
        <title>Suscríbete a Twine Gold!</title>
        <style>
            .payment-container {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .payment-card {
                background-color: #f8f0f4;
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
                min-width: 600px;
                margin: 0 auto;
                width: 100%;
            }

            .payment-card .form-row {
                margin-bottom: 20px;
            }

            .payment-card .form-group label {
                font-weight: bold;
            }

            .payment-card .form-text.text-danger {
                color: red;
            }

            .payment-card .btn-primary {
                background-color: #ff80ab;
                border-color: #ff80ab;
            }

            .payment-card .btn-primary:hover {
                background-color: #ff4081;
                border-color: #ff4081;
            }

            .payment-card .btn-primary:focus {
                box-shadow: none;
            }

            .payment-card .payment-plan p {
                margin-bottom: 0;
            }

            .payment-card .payment-plan p:last-child {
                font-weight: bold;
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
        <!-- FORMA DE PAGO -->
        <div class="payment-container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="payment-card p-4">
                        <h4>Forma de pago</h4>
                        <form id="paymentForm" method="post" action="pago.php">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Método de pago</h6>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="paymentMethod" id="paypalRadio" value="paypal" checked>
                                            <label class="form-check-label" for="paypalRadio">
                                                <i class="fab fa-paypal"></i> PayPal
                                            </label>
                                        </div>
                                        <div id="paypalFields">
                                            <label for="paypalEmail">Email de PayPal</label>
                                            <input type="email" class="form-control" id="paypalEmail" name="paypalEmail" placeholder="Introduce tu email de PayPal">
                                            <small class="form-text text-danger"></small>
                                        </div><br/>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="paymentMethod" id="cardRadio" value="card">
                                            <label class="form-check-label" for="cardRadio">
                                                <i class="far fa-credit-card"></i> Tarjeta
                                            </label>
                                        </div>
                                        <div id="cardFields" style="display: none;">
                                            <div class="form-group">
                                                <label for="cardNumber">
                                                    <i class="far fa-credit-card"></i> Número de tarjeta
                                                </label>
                                                <input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="Introduce el número de tarjeta">
                                                <small class="form-text text-danger"></small>
                                            </div><br/>
                                            <div class="form-group">
                                                <label for="cardName">
                                                    <i class="far fa-user"></i> Propietario de la tarjeta
                                                </label>
                                                <input type="text" class="form-control" id="cardName" name="cardName" placeholder="Introduce el nombre del titular de la tarjeta">
                                                <small class="form-text text-danger"></small>
                                            </div><br/>
                                            <div class="form-row">
                                                <div class="col">
                                                    <label for="cardExpiry">
                                                        <i class="far fa-calendar-alt"></i> Fecha de vencimiento
                                                    </label>
                                                    <input type="text" class="form-control" id="cardExpiry" name="cardExpiry" placeholder="MM/YY">
                                                    <small class="form-text text-danger"></small>
                                                </div><br/>
                                                <div class="col">
                                                    <label for="cardCVC">
                                                        <i class="fas fa-lock"></i> CVC/CVV
                                                    </label>
                                                    <input type="password" class="form-control" id="cardCVC" name="cardCVC" placeholder="Introduce el CVC/CVV">
                                                    <small class="form-text text-danger"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>Plan de pago</h6>
                                    <div class="form-group">
                                        <select class="form-control" id="paymentPlan" name="paymentPlan">
                                            <option value="monthly">Mensual</option>
                                            <option value="yearly">Anual</option>
                                        </select>
                                    </div>
                                    <div class="payment-plan">
                                        <p><strong>Precio:</strong> 15 €</p>
                                        <p><strong>IVA (21%):</strong> 3.75 €</p>
                                        <p>Precio final: 18.75 €</p>
                                    </div>
                                </div>
                            </div><br/>
                            <button type="submit" id="payButton" name="payButton" class="btn btn-primary">Realizar pago</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /FORMA DE PAGO -->
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
        <!-- SCRIPTS -->
        <script src="helpers/jquery-3.6.3.js"></script>
        <script src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

        <script>
            $(document).ready(function() {
                // Mostrar y ocultar campos según método de pago
                $('input[name="paymentMethod"]').change(function() {
                    if ($(this).val() === 'paypal') {
                        $('#paypalFields').show();
                        $('#cardFields').hide();
                    } else {
                        $('#paypalFields').hide();
                        $('#cardFields').show();
                    }
                });

                // Texto dependiendo del plan de pago
                $('#paymentPlan').change(function() {
                    var selectedPlan = $(this).val();
                    var planDetails = $('.payment-plan');

                    if (selectedPlan === 'monthly') {
                        planDetails.html(`
                        <p><strong>Precio:</strong> 15 €</p>
                        <p><strong>IVA (21%):</strong> 3.75 €</p>
                        <p>Precio final: 18.75 €</p>
                    `);
                    } else {
                        planDetails.html(`
                        <p><strong>Precio:</strong> 180 €</p>
                        <p><strong>IVA (21%):</strong> 37.80 €</p>
                        <p class="plan-details" style="color:#FF1493;">
                            <i class="fas fa-tag"></i><strong> Descuento por suscripción anual:</strong> -21.78 €
                        </p>
                        <p>Precio final: 196.02 €</p>
                    `);
                    }
                });

                // Validación
                $('#paymentForm').submit(function(event) {
                    event.preventDefault();
                    var paymentMethod = $('input[name="paymentMethod"]:checked').val();

                    if (paymentMethod === 'paypal') {
                        var paypalEmail = $('#paypalEmail').val();

                        if (!paypalEmail) {
                            $('#paypalEmail').siblings('.form-text').text('PayPal Email is required.').show();
                        } else if (!isValidEmail(paypalEmail)) {
                            $('#paypalEmail').siblings('.form-text').text('Please enter a valid PayPal Email.').show();
                        } else {
                            $('#paypalEmail').siblings('.form-text').text('').hide();
                            $('#paymentForm')[0].submit();
                        }
                    } else {
                        var cardNumber = $('#cardNumber').val();
                        var cardName = $('#cardName').val();
                        var cardExpiry = $('#cardExpiry').val();
                        var cardCVC = $('#cardCVC').val();

                        if (!cardNumber) {
                            $('#cardNumber').siblings('.form-text').text('Debe figurar el número de la tarjeta.').show();
                        } else if (!isValidCardNumber(cardNumber)) {
                            $('#cardNumber').siblings('.form-text').text('Ingrese un número de tarjeta válido (16 dígitos).').show();
                        } else {
                            $('#cardNumber').siblings('.form-text').text('').hide();
                        }

                        if (!cardName) {
                            $('#cardName').siblings('.form-text').text('Debe figurar el nombre del titular de la tarjeta.').show();
                        } else if (!isValidCardName(cardName)) {
                            $('#cardName').siblings('.form-text').text('El nombre solo puede contener letras.').show();
                        } else {
                            $('#cardName').siblings('.form-text').text('').hide();
                        }

                        if (!cardExpiry) {
                            $('#cardExpiry').siblings('.form-text').text('Debe figurar la fecha de expiración.').show();
                        } else if (!isValidExpiryDate(cardExpiry)) {
                            $('#cardExpiry').siblings('.form-text').text('Ingrese una fecha de expiración válida (MM/YY).').show();
                        } else {
                            $('#cardExpiry').siblings('.form-text').text('').hide();
                        }

                        if (!cardCVC) {
                            $('#cardCVC').siblings('.form-text').text('Debe figurar el CVC/CVV de la tarjeta.').show();
                        } else if (!isValidCVC(cardCVC)) {
                            $('#cardCVC').siblings('.form-text').text('Ingrese un CVC/CVV válido (3 dígitos).').show();
                        } else {
                            $('#cardCVC').siblings('.form-text').text('').hide();
                        }

                        if (cardNumber && isValidCardNumber(cardNumber) && cardName && cardExpiry && isValidExpiryDate(cardExpiry) && cardCVC && isValidCVC(cardCVC)) {
                            $('#paymentForm')[0].submit();
                        }
                    }
                });

                // Función de validación de email
                function isValidEmail(email) {
                    // validación de email
                    var emailRegex = /^\S+@\S+\.\S+$/;
                    return emailRegex.test(email);
                }

                // Función de validación de número de tarjeta
                function isValidCardNumber(cardNumber) {
                    // (16 dígitos)
                    var cardNumberRegex = /^\d{16}$/;
                    return cardNumberRegex.test(cardNumber);
                }

                // Función de validación de fecha de vencimiento
                function isValidExpiryDate(expiryDate) {
                    // (formato MM/YY)
                    var expiryDateRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
                    return expiryDateRegex.test(expiryDate);
                }

                // Función de validación de CVC
                function isValidCVC(cvc) {
                    // (3 dígitos)
                    var cvcRegex = /^\d{3}$/;
                    return cvcRegex.test(cvc);
                }

                // Función de validar nombre
                function isValidCardName(cardName) {
                    // solo letras
                    var nameRegex = /^[a-zA-Z ]+$/;
                    return nameRegex.test(cardName);
                }

                // PayPal por defecto
                $('#paypalRadio').prop('checked', true);
                $('#paypalFields').show();
                $('#cardFields').hide();
            });
        </script>
    </body>

    </html>
<?php } else { ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="icons/favicon.png">
        <link rel="stylesheet" type="text/css" href="helpers/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="style.css" />
        <title>¡Disfruta de Twine Gold!</title>
        <style>
            .container-center {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
                background-color: #f8f9fa;
            }

            .gold-card {
                background-color: gold;
                color: #333;
                padding: 40px;
                text-align: center;
                border-radius: 5px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                max-width: 400px;
                margin: 0 auto;
                transition: background-color 0.3s ease-in-out;
            }

            .gold-card:hover {
                background-color: #ffc107;
            }

            .gold-card i {
                font-size: 70px;
                margin-bottom: 20px;
            }

            .gold-card h3 {
                font-size: 30px;
                margin-bottom: 20px;
            }

            .gold-card p {
                font-size: 20px;
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
        <!-- CONTENT -->
        <div class="container-center">
            <div class="gold-card">
                <i class="fas fa-star" style="font-size: 75px;"></i>
                <h3>¡Ya eres Oro!</h3>
                <p>Disfruta de todas tus ventajas en <a href="home.php" class="text-decoration-none">Twine</a></p>
            </div>
        </div>
        <!-- /CONTENT -->
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
        <script src="helpers/jquery-3.6.3.js"></script>
        <script src="helpers/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    </body>

    </html>
<?php } ?>