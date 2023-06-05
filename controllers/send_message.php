<?php

session_start();

// Verificar la autenticación del usuario
if (!isset($_SESSION["user_id"])) {
    // Redirigir a la página de inicio de sesión si el usuario no está autenticado
    header("Location: login.php");
    exit;
}

// Obtener el ID del usuario actual
$userID = $_SESSION["user_id"];

// Obtener el mensaje enviado por AJAX
$message = $_POST["message"];

// Guardar el mensaje en la base de datos

// ... Código para guardar el mensaje en la base de datos ...


?>