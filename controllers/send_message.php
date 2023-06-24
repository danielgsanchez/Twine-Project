<?php

session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}

require_once "../models/conn.php";

// Obtener el ID del usuario actual
$userId = $_SESSION["user_id"];

// Obtener el mensaje enviado por AJAX
$message = $_REQUEST["message"];
$chatId = $_REQUEST["chatID"];
$matchId = $_REQUEST["matchUserID"];

// Generar la fecha actual
$msgDate = date('Y-m-d H:i:s');

// Verificar si el chat ya existe en la base de datos
$sql = "SELECT id FROM twn_chats WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $chatId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // El chat ya existe en la base de datos, simplemente guardar el mensaje
    $sql = "INSERT INTO twn_chat_msg (chat_id, sender_id, msg_text, timestamp) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $chatId, $userId, $message, $msgDate);
    $stmt->execute();

    // Verificar si el mensaje se guardó correctamente
    if ($stmt->affected_rows > 0) {
        // El mensaje se guardó exitosamente
        echo "message_sent";
    } else {
        // Ocurrió un error al guardar el mensaje
        echo "message_failed";
    }
} else {
    // El chat no existe en la base de datos, primero crear el chat y luego guardar el mensaje
    $sql = "INSERT INTO twn_chats (user1_id, user2_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $userId, $matchId);
    $stmt->execute();

    // Obtener el ID del chat recién creado
    $chatId = $stmt->insert_id;

    // Guardar el mensaje en la tabla de mensajes
    $sql = "INSERT INTO twn_chat_msg (id, sender_id, msg_text, time_sent) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $chatId, $userId, $message, $msgDate);
    $stmt->execute();

    // Verificar si el mensaje se guardó correctamente
    if ($stmt->affected_rows > 0) {
        // El mensaje se guardó exitosamente
        echo "message_sent";
    } else {
        // Ocurrió un error al guardar el mensaje
        echo "message_failed";
    }
}
