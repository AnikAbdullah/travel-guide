<?php

include "../../config/db.php";

$userQuery = mysqli_query($conn, "SELECT * FROM users");

?>

<!DOCTYPE html>
<html>

<head>

    <title>User Management</title>

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

        <h1>User Management</h1>

        <a class="add-btn" href="add_user.php">Add New User</a>

        <br><br>

        <table>

            <tr>

                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Verified</th>
                <th>Action</th>

            </tr>

            <?php while($user = mysqli_fetch_assoc($userQuery)) { ?>

            <tr>

                <td><?php echo $user['id']; ?></td>

                <td><?php echo $user['name']; ?></td>

                <td><?php echo $user['email']; ?></td>

                <td><?php echo $user['role']; ?></td>

                <td>

                    <?php if($user['is_verified'] == 1){ ?>

                        <a class="verified-btn"
                           href="verify_user.php?id=<?php echo $user['id']; ?>&status=0">
                           Verified
                        </a>

                    <?php } else { ?>

                        <a class="unverified-btn"
                           href="verify_user.php?id=<?php echo $user['id']; ?>&status=1">
                           Unverified
                        </a>

                    <?php } ?>

                </td>

                <td>

                    <a class="edit-btn"
                       href="edit_user.php?id=<?php echo $user['id']; ?>">
                       Edit
                    </a>

                    <a class="delete-btn"
                       href="delete_user.php?id=<?php echo $user['id']; ?>">
                       Delete
                    </a>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

    <script src="../../public/js/script.js"></script>

</body>

</html>