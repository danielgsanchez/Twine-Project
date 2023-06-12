<?php

session_start();

// Verificar la autenticación del usuario
if (!isset($_SESSION["user_id"])) {
    // Redirigir a la página de inicio de sesión si el usuario no está autenticado
    header("Location: login.php");
    exit;
}

require_once "../models/conn.php";

// Obtener el ID del usuario actual
$userID = $_SESSION["user_id"];

// Verificar si existe un match mutuo
$matchFound = false;

// Realizar la consulta en la base de datos para verificar el match mutuo
$sql = "SELECT * FROM twn_matches WHERE (user1_id = ? AND user2_id IN (SELECT user1_id FROM twn_matches WHERE user2_id = ?))
        OR (user2_id = ? AND user1_id IN (SELECT user2_id FROM twn_matches WHERE user1_id = ?))";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $userID, $userID, $userID, $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $matchFound = true;
    echo "match_found";
} else {
    echo "no_match";
}
