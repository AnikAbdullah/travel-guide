<?php

include "../../config/db.php";

$id = $_GET['id'];

$postQuery = mysqli_query($conn, "SELECT * FROM posts WHERE id=$id");
$post = mysqli_fetch_assoc($postQuery);

if(isset($_POST['update'])){

    $title = $_POST['title'];
    $country = $_POST['country'];
    $genre = $_POST['genre'];
    $cost_level = $_POST['cost_level'];
    $status = $_POST['status'];

    mysqli_query($conn,
    "UPDATE posts SET
    title='$title',
    country='$country',
    genre='$genre',
    cost_level='$cost_level',
    status='$status'
    WHERE id=$id");

    header("Location: posts.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Post</title>
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

    <h1>Edit Post</h1>

    <form method="POST">

        <label>Title</label><br>
        <input type="text" name="title" value="<?php echo $post['title']; ?>" required><br>

        <label>Country</label><br>
        <input type="text" name="country" value="<?php echo $post['country']; ?>" required><br>

        <label>Genre</label><br>
        <input type="text" name="genre" value="<?php echo $post['genre']; ?>" required><br>

        <label>Cost Level</label><br>
        <select name="cost_level">
            <option value="low" <?php if($post['cost_level'] == 'low') echo 'selected'; ?>>Low</option>
            <option value="medium" <?php if($post['cost_level'] == 'medium') echo 'selected'; ?>>Medium</option>
            <option value="high" <?php if($post['cost_level'] == 'high') echo 'selected'; ?>>High</option>
        </select><br>

        <label>Status</label><br>
        <select name="status">
            <option value="approved" <?php if($post['status'] == 'approved') echo 'selected'; ?>>Approved</option>
            <option value="pending" <?php if($post['status'] == 'pending') echo 'selected'; ?>>Pending</option>
            <option value="rejected" <?php if($post['status'] == 'rejected') echo 'selected'; ?>>Rejected</option>
        </select><br>

        <button class="edit-btn" type="submit" name="update">Update</button>

    </form>

</div>

</body>

</html>