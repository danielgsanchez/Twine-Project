<?php
session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}

require_once "models/conn.php";


if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    // Construir la consulta SQL para obtener el valor de gold_sub del usuario específico
    $sql = "SELECT gold_sub FROM twn_users WHERE email = '$email'";

    // Ejecutar la consulta
    $result = $conn->query($sql);

    // Verificar si se encontró el usuario
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $goldSub = $row['gold_sub'];

        // Redireccionar a la página correspondiente según el valor de gold_sub
        if ($goldSub == 0) { ?>
            <!DOCTYPE html>
            <html>

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="icon" type="image/x-icon" href="icons/favicon.png">
                <link rel="stylesheet" href="helpers/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css" />
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
                <link rel="stylesheet" href="style.css" />
                <title>Twine - Suscribirse a Twine Gold</title>
                <style>
                    body {
                        background-color: #ff92c6;
                    }

                    .card-header {
                        position: relative;
                    }

                    .card-header .btn-link {
                        width: 100%;
                        text-align: left;
                        padding-right: 2.5rem;
                    }

                    .card-header .btn-link::after {
                        position: absolute;
                        content: "\f138";
                        font-family: "Font Awesome 5 Free";
                        font-weight: 900;
                        top: 50%;
                        right: 1rem;
                        transform: translateY(-50%);
                    }

                    .card-header.collapsed .btn-link::after {
                        content: "\f139";
                    }

                    .card-body .input-group-prepend .input-group-text {
                        background-color: #ff6190;
                        color: #fff;
                        border-color: #ff6190;
                    }

                    .card-body .form-control {
                        padding-left: 2.5rem;
                    }

                    .card-body .input-icon {
                        position: absolute;
                        top: 50%;
                        left: 1rem;
                        transform: translateY(-50%);
                        color: #ff6190;
                        font-size: 1.25rem;
                    }

                    .card-body .btn-primary {
                        background-color: #940242;
                        border-color: #940242;
                    }

                    .card-body .btn-primary:hover {
                        background-color: #ff6190;
                        border-color: #ff6190;
                    }

                    .custom-link {
                        color: #ff6190;
                        text-decoration: none !important;
                    }

                    .custom-link:hover {
                        color: #940242;
                        text-decoration: none !important;
                    }

                    .btn-check:checked+.btn,
                    .btn.active,
                    .btn.show,
                    .btn:first-child:active,
                    :not(.btn-check)+.btn:active {
                        color: #940242;
                        text-decoration: none !important;
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
                <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card p-3">
                                    <h4 class="mb-4">Opciones de Pago</h4>
                                    <div id="accordion">
                                        <div class="card">
                                            <div class="card-header" id="paypalHeading">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link custom-link" data-toggle="collapse" data-target="#paypalCollapse" aria-expanded="true" aria-controls="paypalCollapse">
                                                        <i class="fab fa-paypal"></i> PayPal
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="paypalCollapse" class="collapse show" aria-labelledby="paypalHeading" data-parent="#accordion">
                                                <div class="card-body">
                                                    <form>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="fas fa-envelope"></i>
                                                                </span>
                                                            </span>
                                                            <input type="email" class="form-control" id="paypalEmail" placeholder="Ingresa tu email de PayPal">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" id="creditCardHeading">
                                                <h5 class="mb-0">
                                                    <button class="btn btn-link custom-link collapsed" data-toggle="collapse" data-target="#creditCardCollapse" aria-expanded="false" aria-controls="creditCardCollapse">
                                                        <i class="far fa-credit-card"></i> Tarjeta de Crédito
                                                    </button>
                                                </h5>
                                            </div>
                                            <div id="creditCardCollapse" class="collapse" aria-labelledby="creditCardHeading" data-parent="#accordion">
                                                <div class="card-body">
                                                    <form>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <img src="icons/credit-card-2-back-fill.svg" style="filter: invert();">
                                                                </span>
                                                            </span>
                                                            <input type="text" class="form-control" id="creditCardNumber" placeholder="Ingresa el número de tu tarjeta de crédito" pattern="[0-9]{4}\s?[0-9]{4}\s?[0-9]{4}\s?[0-9]{4}" title="Introduce un número de tarjeta de crédito válido">
                                                        </div>
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="fas fa-user"></i>
                                                                </span>
                                                            </span>
                                                            <input type="text" class="form-control" id="creditCardName" placeholder="Ingresa el nombre del titular de la tarjeta">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-calendar-alt"></i>
                                                                        </span>
                                                                    </span>
                                                                    <input type="text" class="form-control" id="expirationDate" placeholder="MM/AA" pattern="(0[1-9]|1[0-2])\/[0-9]{2}" title="Introduce una fecha de expiración válida (MM/AA)">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-prepend">
                                                                        <span class="input-group-text">
                                                                            <i class="fas fa-lock"></i>
                                                                        </span>
                                                                    </span>
                                                                    <input type="text" class="form-control" id="cvv" placeholder="CVV/CVC" pattern="[0-9]{3,4}" title="Introduce un código CVV/CVC válido">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form class="card p-3">
                                    <h4 class="mb-4">Resumen</h4>
                                    <div class="mb-3">
                                        <label for="plan" class="form-label">Plan de Pago</label>
                                        <select class="form-select" id="plan" name="plan">
                                            <option value="monthly" selected>Mensual</option>
                                            <option value="annual">Anual</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="precioBase" class="form-label">Precio base</label>
                                        <p id="precioBase" class="form-control-plaintext mb-0 fw-bold">15€</p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="iva" class="form-label">IVA (21%)</label>
                                        <p id="iva" class="form-control-plaintext mb-0 fw-bold">3.15€</p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="precioFinal" class="form-label">Precio final</label>
                                        <p id="precioFinal" class="form-control-plaintext mb-0 fw-bold">18.15€</p>
                                    </div>
                                    <div id="descuento" style="display:none;">
                                        <p class="mb-3 fw-bold" style="color: #940242;">
                                            <i class="fas fa-tags"></i> Descuento por suscripción anual: 10%
                                        </p>
                                        <div class="mb-3">
                                            <label for="precioDescuento" class="form-label">Precio final con descuento</label>
                                            <p id="precioDescuento" class="form-control-plaintext mb-0 fw-bold"></p>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="paySub" id="payButton">Realizar el pago</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="helpers/jquery-3.6.3.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

                <script>
                    const selectPlan = document.getElementById('plan');
                    const precioBaseText = document.getElementById('precioBase');
                    const ivaText = document.getElementById('iva');
                    const precioFinalText = document.getElementById('precioFinal');
                    const descuentoText = document.getElementById('descuento');
                    const precioDescuento = document.getElementById('precioDescuento');

                    selectPlan.addEventListener('change', function() {
                        const selectedOption = selectPlan.value;

                        if (selectedOption === 'monthly') {
                            precioBaseText.textContent = '15€';
                            ivaText.textContent = '3.15€';
                            precioFinalText.textContent = '18.15€';
                            descuentoText.style.display = 'none';
                            precioDescuento.style.display = 'none';
                        } else if (selectedOption === 'annual') {
                            precioBaseText.textContent = '180€';
                            ivaText.textContent = '37.80€';
                            precioFinalText.textContent = '217.80€';
                            descuentoText.style.display = 'block';
                            precioDescuento.style.display = 'block';
                            precioDescuento.textContent = '196.00 €'
                        }
                    });
                </script>
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
            </body>

            </html>
        <?php
        } elseif ($goldSub == 1) { ?>
            <!DOCTYPE html>
            <html>

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="icon" type="image/x-icon" href="icons/favicon.png">
                <link rel="stylesheet" href="helpers/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css" />
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
                <link rel="stylesheet" href="style.css" />
                <title>Twine - Finalizar pago</title>
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
        }
    } else {
        echo "No se encontró el usuario.";
    }

    // Cerrar la conexión
    $conn->close();
} else {
    header("Location: error.php");
}

?>