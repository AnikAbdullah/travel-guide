<?php

include "../../config/db.php";

if(isset($_POST['add'])){

    $name = $_POST['new_name'];
    $email = $_POST['new_email'];
    $password = $_POST['new_password'];

    $role = $_POST['role'];
    $is_verified = $_POST['is_verified'];

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    
    $emailCheck = mysqli_query($conn,
    "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($emailCheck) > 0){

        echo "<script>
                alert('Email already exists');
                window.location.href='add_user.php';
              </script>";

        exit;
    }

    
    mysqli_query($conn,
    "INSERT INTO users (name, email, password_hash, role, is_verified)
    VALUES ('$name', '$email', '$password_hash', '$role', '$is_verified')");

    header("Location: users.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Add User</title>

    <link rel="stylesheet" href="../../public/css/style.css">

</head>

<body>

    <div class="sidebar">

        <h2>Travel Guide</h2>

        <a href="dashboard.php">Dashboard</a>
        <a href="users.php">User Management</a>
        <a href="post_requests.php">Post Requests</a>
        <a href="posts.php">Posts Management</a>
        <a href="comments.php">Comments Management</a>

    </div>

    <div class="main">

        <h1>Add New User</h1>

        <form method="POST" autocomplete="off">

            <label>Name</label><br>

            <input type="text"
                   name="new_name"
                   autocomplete="off"
                   required><br>

            <label>Email</label><br>

            <input type="email"
                   name="new_email"
                   autocomplete="off"
                   required><br>

            <label>Password</label><br>

            <input type="password"
                   name="new_password"
                   autocomplete="new-password"
                   required><br>

            <label>Role</label><br>

            <select name="role">

                <option value="admin">Admin</option>
                <option value="scout">Scout</option>
                <option value="user">User</option>

            </select><br>

            <label>Verified Status</label><br>

            <select name="is_verified">

                <option value="1">Verified</option>
                <option value="0">Unverified</option>

            </select><br>

            <button class="edit-btn"
                    type="submit"
                    name="add">

                Add User

            </button>

        </form>

    </div>

</body>

</html>