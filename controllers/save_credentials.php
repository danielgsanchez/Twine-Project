<?php

session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}

require_once(__DIR__ . '/../models/user_model.php');

$userModel = new UserModel($conn);
$profileInfo = $userModel->getProfile($_SESSION["user_id"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $msg = "";
    $newEmail = $userModel->sanitizeInput($_POST['email']);
    $password = $userModel->sanitizeInput($_POST['password']);
    $newPassword = $userModel->sanitizeInput($_POST['new-password']);
    $confPassword = $userModel->sanitizeInput($_POST['conf-password']);

    if (empty($password)){
        $msg .= "El campo contraseña actual no puede estar vacío.";
        header("Location: ../perfil.php?msg=".urlencode($msg));
        exit();
    } else if (!empty($newPassword)){
        if ($profileInfo["password"] == md5($newPassword)){
            $msg .= "Ya has utilizado esa contraseña.";
            header("Location: ../perfil.php?msg=".urlencode($msg));
            exit();
        } else {
            if ($newPassword != $confPassword){
                $msg .= "Las contraseñas no coinciden.";
                header("Location: ../perfil.php?msg=".urlencode($msg));
                exit();
            } elseif (strlen($newPassword) < 8 || !preg_match('/^(?=.*[A-Z])(?=.*\d)/', $newPassword)) {
                $msg .= "La contraseña debe tener al menos 8 caracteres y contener al menos una mayúscula y un número";
                header("Location: ../perfil.php?msg=".urlencode($msg));
                exit();
            } else {
                $pwdUpd = $userModel->updatePassword($_SESSION["user_id"], $newPassword);
                if ($pwdUpd == 1) {
                    $msg .= "Contraseña cambiada con éxito.";
                    header("Location: ../perfil.php?msg=".urlencode($msg));
                    exit();
                } else {
                    $msg .= "Error al cambiar la contraseña.";
                    header("Location: ../perfil.php?msg=".urlencode($msg));
                    exit();
                }
            }
        }
    }
    if ($newEmail != $profileInfo["email"]){
        $emailUpd = $userModel->updateEmail($_SESSION["user_id"], $newEmail);
        if ($emailUpd == 1){
            $msg .= "Correo cambiado con éxito.";
            header("Location: ../perfil.php?msg=".urlencode($msg));
            exit();
        } else {
            $msg .= "Error al cambiar el correo.";
            header("Location: ../perfil.php?msg=".urlencode($msg));
            exit();
        }
    }
}
