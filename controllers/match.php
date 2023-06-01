<?php
session_start();

// Aquí incluye los archivos necesarios y realiza cualquier configuración adicional

// Verificar si se envió una solicitud AJAX de coincidencia
if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'match') {
    // Obtener el ID del perfil desde la solicitud
    $profileId = $_REQUEST['profile_id'];

    // Llamar a la función addMatch del modelo de usuario
    require_once __DIR__ . "/../models/conn.php";
    require_once __DIR__ . "/../models/user_model.php";

    $userModel = new UserModel($conn);
    $userModel->addMatch($_SESSION['user_id'], $profileId);

    // Enviar la respuesta en formato JSON
    echo json_encode(['success' => true]);
    exit;
}

// Si no se cumple ninguna condición, devuelve un mensaje de error
echo json_encode(['success' => false, 'message' => 'Invalid request']);
exit;
?>
