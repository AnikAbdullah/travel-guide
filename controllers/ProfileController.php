<?php

session_start();

require_once '../config/database.php';

$db = (new Database())->connect();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $name = htmlspecialchars(
        trim($_POST['name'])
    );

    $query = "UPDATE users
              SET name=?
              WHERE id=?";

    $stmt = mysqli_prepare(
        $db,
        $query
    );

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $name,
        $_SESSION['user_id']
    );

    mysqli_stmt_execute($stmt);

    $_SESSION['name'] = $name;

    header(
        "Location: ../views/profile/profile.php"
    );
}

?>
