<?php
session_start();
unset($_SESSION["email"]);

if (empty($_SESSION["email"])){
    header("Location: index.php");
}

?>