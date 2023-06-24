<?php
session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
} elseif ($_SESSION["email"] != "admin@admin.es") {
    header("Location: error.php");
    exit;
}

require_once "../models/admin_model.php";

// Obtener el ID del usuario a banear
if (isset($_REQUEST["userId"])) {
    $user_id = $_REQUEST["userId"];

    $adminModel = new AdminModel($conn);
    $success = $adminModel->banUser($user_id); // Banear al usuario

    // Redirigir a la página de administración de usuarios con un mensaje de éxito
    $response = array('success' => true, 'message' => 'Usuario baneado con éxito');
    echo json_encode($response);
    exit;
} else {
    // Si no se proporciona un ID de usuario válido, redirigir a la página de administración de usuarios sin un mensaje de éxito
    $response = array('success' => false, 'message' => 'Error al banear usuario');
    echo json_encode($response);
    exit;
}
