<?php
session_start();

// Verificar la autenticación del usuario
if (!isset($_SESSION["user_id"])) {
    // Redirigir a la página de inicio de sesión si el usuario no está autenticado
    header("Location: login.php");
    exit;
}

// Obtener el ID del usuario actual
$userID = $_SESSION["user_id"];

// Realizar la consulta en la base de datos para obtener los usuarios con match

// ... Código para realizar la consulta en la base de datos y obtener los usuarios con match ...

// Iterar sobre los resultados de la consulta y mostrar los usuarios
while ($row = mysqli_fetch_assoc($result)) {
    echo "<p>{$row['username']}</p>";
}
?>