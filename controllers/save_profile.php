<?php

session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}

require_once(__DIR__ . '/../models/user_model.php');


$uM = new UserModel($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $msg = "";
    $nombre = $uM->sanitizeInput($_POST['first_name']);
    $apellido = $uM->sanitizeInput($_POST['last_name']);
    $nick = $uM->sanitizeInput($_POST['screen_name']);
    $genero = $uM->sanitizeInput($_POST['gender']);
    $descripcion = $uM->sanitizeInput($_POST['description']);
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
        $pfmsg = $uM->updateProfile($_SESSION["user_id"], $nombre, $apellido, $nick, $genero, $descripcion, $img);
        header("Location: ../perfil.php?pfmsg=".urlencode($pfmsg));
        exit();
    }
}