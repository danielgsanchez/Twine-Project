<?php
require_once "models/conn.php";

// Obtener los datos del mensaje enviados por el usuario
$chatID = $_POST['chat_id'];
$userID = $_POST['user_id'];
$messageText = $_POST['message_text'];
$currentTime = date('Y-m-d H:i:s');

// Insertar el mensaje en la tabla twn_chat_msg
$sql = "INSERT INTO twn_chat_msg (chat_id, user_id, msg_text, time_sent)
        VALUES ('$chatID', '$userID', '$messageText', '$currentTime')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(array('success' => true));
} else {
    echo json_encode(array('success' => false, 'error' => $conn->error));
}

$conn->close();
?>