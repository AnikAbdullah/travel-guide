<?php

include "../../config/db.php";

$postQuery = mysqli_query($conn, "SELECT * FROM posts");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Posts Management</title>

    <link rel="stylesheet" href="../../public/css/style.css">

</head>

<body>

    <div class="sidebar">

        <h2>Travel Guide</h2>

        <a href="dashboard.php">Dashboard</a>
        <a href="users.php">User Management</a>
        <a href="post_requests.php">Post Requests</a>
        <a href="posts.php">Posts Management</a>
        <a href="#">Comments Management</a>

    </div>

    <div class="main">

        <h1>Posts Management</h1>

        <table>

            <tr>

                <th>ID</th>
                <th>Scout ID</th>
                <th>Title</th>
                <th>Country</th>
                <th>Genre</th>
                <th>Cost</th>
                <th>Status</th>
                <th>Action</th>

            </tr>

            <?php while($post = mysqli_fetch_assoc($postQuery)) { ?>

            <tr>

                <td><?php echo $post['id']; ?></td>

                <td><?php echo $post['scout_id']; ?></td>

                <td><?php echo $post['title']; ?></td>

                <td><?php echo $post['country']; ?></td>

                <td><?php echo $post['genre']; ?></td>

                <td><?php echo $post['cost_level']; ?></td>

                <td><?php echo $post['status']; ?></td>

                <td class="action-buttons">

                    <a class="edit-btn"
                       href="edit_post.php?id=<?php echo $post['id']; ?>">
                       Edit
                    </a>

                    <a class="delete-btn"
                       href="delete_post.php?id=<?php echo $post['id']; ?>">
                       Delete
                    </a>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</body>

</html>