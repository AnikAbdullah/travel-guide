<?php

include "../../config/db.php";

$requestQuery = mysqli_query($conn, "SELECT * FROM post_requests");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Post Requests</title>

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

        <h1>Post Requests</h1>

        <table>

            <tr>

                <th>ID</th>
                <th>Scout ID</th>
                <th>Post Data</th>
                <th>Status</th>
                <th>Requested At</th>
                <th>Action</th>

            </tr>

            <?php while($request = mysqli_fetch_assoc($requestQuery)) { ?>

            <?php 
                $postData = json_decode($request['post_data'], true);
            ?>

            <tr>

                <td><?php echo $request['id']; ?></td>

                <td><?php echo $request['scout_id']; ?></td>

                <td>

                    Title: <?php echo $postData['title']; ?><br>

                    Country: <?php echo $postData['country']; ?><br>

                    Genre: <?php echo $postData['genre']; ?><br>

                    Cost: <?php echo $postData['cost_level']; ?>

                </td>

                <td><?php echo $request['status']; ?></td>

                <td><?php echo $request['requested_at']; ?></td>

                <td>

                    <?php if($request['status'] == 'pending'){ ?>

                        <a class="verified-btn"
                           href="approve_request.php?id=<?php echo $request['id']; ?>">
                           Approve
                        </a>

                        <a class="delete-btn"
                           href="reject_request.php?id=<?php echo $request['id']; ?>">
                           Reject
                        </a>

                    <?php } elseif($request['status'] == 'approved'){ ?>

                        <a class="delete-btn"
                           href="reject_request.php?id=<?php echo $request['id']; ?>">
                           Reject
                        </a>

                    <?php } elseif($request['status'] == 'rejected'){ ?>

                        <a class="verified-btn"
                           href="approve_request.php?id=<?php echo $request['id']; ?>">
                           Approve
                        </a>

                    <?php } ?>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</body>

</html>