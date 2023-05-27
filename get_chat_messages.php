<?php
require_once "models/conn.php";

// Obtener el ID del chat
$chatID = $_GET['chat_id'];

// Consulta para obtener los mensajes de chat del chat especificado
$sql = "SELECT cm.msg_text, cm.time_sent, u.username
        FROM twn_chat_msg cm
        INNER JOIN twn_chat_users cu ON cm.user_id = cu.user_id
        INNER JOIN twn_users u ON cm.user_id = u.id
        WHERE cu.chat_id = '$chatID'
        ORDER BY cm.time_sent ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $messages = array();

    while ($row = $result->fetch_assoc()) {
        $message = array(
            'msg_text' => $row['msg_text'],
            'time_sent' => $row['time_sent'],
            'username' => $row['username']
        );

        $messages[] = $message;
    }

    echo json_encode($messages);
} else {
    echo json_encode(array());
}

$conn->close();
?>