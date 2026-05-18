<?php

include "../../config/db.php";

$userQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$userCount = mysqli_fetch_assoc($userQuery);

$postRequestQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM post_requests");
$postRequestCount = mysqli_fetch_assoc($postRequestQuery);

$postQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM posts");
$postCount = mysqli_fetch_assoc($postQuery);

$commentQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM comments");
$commentCount = mysqli_fetch_assoc($commentQuery);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Dashboard</title>

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

        <h1>Admin Dashboard</h1>

        <p>Welcome back, Admin</p>

        <div class="cards">

            <div class="card">

                <h3>Total Users</h3>

                <p><?php echo $userCount['total']; ?></p>

            </div>

            <div class="card">

                <h3>Pending Requests</h3>

                <p><?php echo $postRequestCount['total']; ?></p>

            </div>

            <div class="card">

                <h3>Total Posts</h3>

                <p><?php echo $postCount['total']; ?></p>

            </div>

            <div class="card">

                <h3>Total Comments</h3>

                <p><?php echo $commentCount['total']; ?></p>

            </div>

        </div>

    </div>

</body>

</html>