<?php

session_start();

require_once "../models/conn.php";
require_once "../models/user_model.php";

$userModel = new UserModel($conn);

if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];
    $profile = $userModel->getFullProfile($userID);
    echo json_encode($profile);
}
