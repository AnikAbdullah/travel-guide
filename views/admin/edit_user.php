<?php

include "../../config/db.php";

$id = $_GET['id'];

$userQuery = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
$user = mysqli_fetch_assoc($userQuery);

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    if(!empty($password)){

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        mysqli_query($conn,
        "UPDATE users 
        SET name='$name',
        email='$email',
        role='$role',
        password_hash='$password_hash'
        WHERE id=$id");

    } else {

        mysqli_query($conn,
        "UPDATE users 
        SET name='$name',
        email='$email',
        role='$role'
        WHERE id=$id");
    }

    header("Location: users.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit User</title>
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

        <h1>Edit User</h1>

        <form method="POST">

            <label>Name</label><br>
            <input type="text" name="name" value="<?php echo $user['name']; ?>"><br>

            <label>Email</label><br>
            <input type="email" name="email" value="<?php echo $user['email']; ?>"><br>

            <label>New Password</label><br>
            <input type="password" name="password"><br>

            <label>Role</label><br>
            <select name="role">
                <option value="admin" <?php if($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                <option value="scout" <?php if($user['role'] == 'scout') echo 'selected'; ?>>Scout</option>
                <option value="user" <?php if($user['role'] == 'user') echo 'selected'; ?>>User</option>
            </select><br><br>

            <button class="edit-btn" type="submit" name="update">Update</button>

        </form>

    </div>

</body>

</html>