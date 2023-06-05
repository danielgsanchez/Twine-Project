<?php

session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}
elseif ($_SESSION["email"] != "admin@admin.es"){
    header("Location: error.php");
    exit;
}

require_once "../models/admin_model.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'ban') {
        if (isset($_POST['userId'])) {
            $userId = $_POST['userId'];

            $adminModel = new AdminModel($conn);
            $success = $adminModel->banUser($userId); // Banear al usuario

            if ($success) {
                echo json_encode('success');
            } else {
                echo json_encode('error');
            }
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'unban') {
        if (isset($_POST['userId'])) {
            $userId = $_POST['userId'];

            $adminModel = new AdminModel($conn);
            $success = $adminModel->unbanUser($userId); // Banear al usuario

            if ($success) {
                echo json_encode('success');
            } else {
                echo json_encode('error');
            }
        }
    }
}
?>