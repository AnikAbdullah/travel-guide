<?php

include "../../config/db.php";

$commentQuery = mysqli_query($conn, "
    SELECT 
        comments.id,
        comments.content,
        comments.created_at,
        users.name AS commenter_name,
        posts.title AS post_title
    FROM comments
    LEFT JOIN users ON comments.user_id = users.id
    LEFT JOIN posts ON comments.post_id = posts.id
    ORDER BY comments.id DESC
");

?>

<!DOCTYPE html>
<html>

<head>
    <title>Comments Management</title>
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

    <h1>Comments Management</h1>

    <table>

        <tr>
            <th>ID</th>
            <th>Post Title</th>
            <th>Commenter</th>
            <th>Comment</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>

        <?php while($comment = mysqli_fetch_assoc($commentQuery)) { ?>

        <tr id="comment-<?php echo $comment['id']; ?>">

            <td><?php echo $comment['id']; ?></td>

            <td><?php echo $comment['post_title']; ?></td>

            <td><?php echo $comment['commenter_name']; ?></td>

            <td><?php echo $comment['content']; ?></td>

            <td><?php echo $comment['created_at']; ?></td>

            <td class="action-buttons">

                <button class="delete-btn ajax-delete-comment"
                        data-id="<?php echo $comment['id']; ?>">
                    Delete
                </button>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

<script src="../../public/js/script.js"></script>

</body>

</html>