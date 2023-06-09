<?php

session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}

require_once "../models/user_model.php";

// Verificar si se envió una solicitud AJAX de rechazo
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'reject') {
    // Obtener el ID del perfil desde la solicitud
    $profileId = $_REQUEST['profile_id'];

    // Llamar a la función addReject del modelo de usuario
    $userModel = new UserModel($conn);
    $userModel->addReject($_SESSION['user_id'], $profileId);

    // Enviar la respuesta en formato JSON
    echo json_encode(['success' => true]);
    exit;
}

// Si no se cumple ninguna condición, devuelve un mensaje de error
echo json_encode(['success' => false, 'message' => 'Invalid request']);
exit;
