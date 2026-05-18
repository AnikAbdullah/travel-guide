<?php

session_start();

require_once '../config/database.php';
require_once '../models/User.php';

$db = (new Database())->connect();

$user = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = htmlspecialchars(
        trim($_POST['name'])
    );

    $email = htmlspecialchars(
        trim($_POST['email'])
    );

    $password = $_POST['password'];

    $role = $_POST['role'];

    if (strlen($password) < 8) {

        die("Password Must Be 8 Characters");
    }

    if ($user->emailExists($email)) {

        die("Email Already Exists");
    }

    $result = $user->registerUser(
        $name,
        $email,
        $password,
        $role
    );

    if ($result) {

        $_SESSION['success']
            = "Registration Successful";

        header(
            "Location: ../views/auth/login.php"
        );

        exit();
    }
}
