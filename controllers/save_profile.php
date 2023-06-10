<?php

session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}

require_once(__DIR__ . '/../models/user_model.php');


$userModel = new UserModel($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $msg = "";
    $nombre = $userModel->sanitizeInput($_POST['first_name']);
    $apellido = $userModel->sanitizeInput($_POST['last_name']);
    $nick = $userModel->sanitizeInput($_POST['screen_name']);
    $genero = $userModel->sanitizeInput($_POST['gender']);
    $descripcion = $userModel->sanitizeInput($_POST['description']);
    $img = "";

    if (isset($_FILES["profile-image"]) && $_FILES["profile-image"]["error"] === UPLOAD_ERR_OK) {
        // Obtener información del archivo
        $file_name = $_FILES["profile-image"]["name"];
        $file_tmp = $_FILES["profile-image"]["tmp_name"];
        // Mover el archivo a una ubicación permanente
        $destination = "../chat_imgs/avatares/" . $file_name;
        move_uploaded_file($file_tmp, $destination);
        $img = "chat_imgs\avatares\\".$file_name; // Guardar el nombre del archivo en la variable $img
    }

    if (empty($nombre) || empty($apellido) || empty($nick) || empty($genero)) {
        $pfmsg = "Por favor, complete todos los campos obligatorios.";
        header("Location: ../perfil.php?pfmsg=".urlencode($pfmsg));
        exit();
    } else {
        $pfmsg = $userModel->updateProfile($_SESSION["user_id"], $nombre, $apellido, $nick, $genero, $descripcion, $img);
        header("Location: ../perfil.php?pfmsg=".urlencode($pfmsg));
        exit();
    }
}