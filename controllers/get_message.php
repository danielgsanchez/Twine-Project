<?php
session_start();

if (empty($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}

require_once "../models/conn.php";
$userId = $_SESSION["user_id"];
// Verificar si el índice "matchUserID" existe en $_GET
if (isset($_GET["matchUserID"])) {
    $matchUserID = $_GET["matchUserID"];

    // Obtener los mensajes del chat de la base de datos
    $messages = getChatMessages($conn, $userId, $matchUserID);

    // Mostrar los mensajes
    foreach ($messages as $message) {
        echo '<div><strong>' . $message["username"] . ':</strong> ' . $message["msg_text"] . '</div>';
    }
} else {
    echo "El índice 'matchUserID' no está presente en la matriz \$_GET.";
}

// Función para obtener los mensajes del chat
function getChatMessages($conn, $userId, $matchUserID)
{
    $sql = "SELECT m.*, CONCAT(u.first_name, ' ', u.last_name) AS username
            FROM twn_chat_msg AS m
            INNER JOIN twn_chats AS c ON m.chat_id = c.id
            INNER JOIN twn_users AS u ON m.sender_id = u.id
            WHERE (c.user1_id = ? AND c.user2_id = ?)
                AND (m.sender_id = ? OR m.sender_id = ?)
            ORDER BY m.timestamp ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $userId, $matchUserID, $userId, $matchUserID);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = array();
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    return $messages;
}
