<?php
session_start();

// Verificar la autenticación del usuario
if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}
elseif ($_SESSION["email"] != "admin@admin.es"){
    header("Location: error.php");
    exit;
}

require_once "../models/admin_model.php";

$adminModel = new AdminModel($conn);

// Obtener el ID del ticket a eliminar
$ticketId = $_POST["ticketId"];

// Eliminar el ticket de la base de datos
$success = $adminModel->deleteTicket($ticketId);

if ($success) {
    echo "success";
} else {
    echo "error";
}
?>