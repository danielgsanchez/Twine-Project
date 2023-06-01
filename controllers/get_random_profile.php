<?php

session_start();

// models/conn.php - Tu archivo de conexión a la base de datos
require_once "../models/conn.php";
// models/user_model.php - Tu archivo con el modelo de usuario
require_once "../models/user_model.php";

// Crear una instancia del modelo de usuario
$userModel = new UserModel($conn);

// Obtener un perfil aleatorio
$randomProfile = $userModel->getRandomProfile($_SESSION["user_id"]);

// Verificar si se encontró un perfil aleatorio
if ($randomProfile) {
    // Crear un array con los datos del perfil
    $profile = array(
        'id' => $randomProfile['id'],
        'link' => $randomProfile['link'],
        'first_name' => $randomProfile['first_name'],
        'gender_id' => $randomProfile['gender_id'],
        'description' => $randomProfile['description']
    );

    // Devolver el perfil como respuesta en formato JSON
    echo json_encode(array('success' => true, 'profile' => $profile));
} else {
    // No se encontraron perfiles disponibles
    echo json_encode(array('success' => false));
}