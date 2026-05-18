<?php

session_start();

require_once '../config/database.php';
require_once '../models/User.php';

$db = (new Database())->connect();

$user = new User($db);

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $email = trim($_POST['email']);

    $password = $_POST['password'];

    $loggedUser = $user->loginUser(
        $email,
        $password
    );

    if($loggedUser){

        $_SESSION['user_id']
            = $loggedUser['id'];

        $_SESSION['name']
            = $loggedUser['name'];

        $_SESSION['role']
            = $loggedUser['role'];

        $_SESSION['verified']
            = $loggedUser['is_verified'];

        header(
            "Location: ../views/home.php"
        );

        exit();

    }else{

        echo "Invalid Login";
    }
}

?>