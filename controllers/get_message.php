<?php

session_start();


// Obtener los mensajes del chat de la base de datos

// ... Código para obtener los mensajes del chat de la base de datos ...

// Mostrar los mensajes
while ($row = $result->fetch_assoc()) {
    echo '<div><strong>' . $row["username"] . ':</strong> ' . $row["msg_text"] . '</div>';
}
?>