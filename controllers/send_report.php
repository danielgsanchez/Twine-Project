<?php

session_start();

// Verificar la autenticación del usuario
if (!isset($_SESSION["user_id"])) {
    // Redirigir a la página de inicio de sesión si el usuario no está autenticado
    header("Location: login.php");
    exit;
}

require_once "../models/conn.php";

// Verificar si se recibieron los datos esperados
if (isset($_REQUEST['userID']) && isset($_REQUEST['reason'])) {
    // Obtener los valores enviados
    $reportedUser = $_REQUEST['userID'];
    $reason = $_REQUEST['reason'];
    $userID = $_SESSION['user_id'];

    // Aquí puedes realizar el procesamiento adicional, como guardar el reporte en la base de datos o realizar acciones relacionadas con el reporte
    $stmt = $conn->prepare("INSERT INTO twn_reports (user1_id, user2_id, reason) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $userID, $reportedUser, $reason);

    // Ejecutar la consulta de inserción
    if ($stmt->execute()) {
        // La inserción se realizó correctamente
        $response = "report_sent";
        echo $response;
    } else {
        // Si hubo un error en la consulta, enviar una respuesta de error
        $response = "error";
        echo $response;
    }
} else {
    // Si los datos no se recibieron correctamente, enviar una respuesta de error
    $response = "error";
    echo $response;
}
