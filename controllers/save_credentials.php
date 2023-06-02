<?php

session_start();
if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}

require_once(__DIR__ . '/../models/user_model.php');

$uM = new UserModel($conn);
$profileInfo = $uM->getProfile($_SESSION["user_id"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $msg = "";
    $newEmail = $uM->sanitizeInput($_POST['email']);
    $password = $uM->sanitizeInput($_POST['password']);
    $newPassword = $uM->sanitizeInput($_POST['new-password']);
    $confPassword = $uM->sanitizeInput($_POST['conf-password']);

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
                $pwdUpd = $uM->updatePassword($_SESSION["user_id"], $newPassword);
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
        $emailUpd = $uM->updateEmail($_SESSION["user_id"], $newEmail);
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

?>