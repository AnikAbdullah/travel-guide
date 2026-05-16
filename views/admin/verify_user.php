<?php

include "../../config/db.php";

if(isset($_GET['id']) && isset($_GET['status'])){

    $id = $_GET['id'];
    $status = $_GET['status'];

    mysqli_query($conn, "UPDATE users SET is_verified='$status' WHERE id='$id'");
}

header("Location: users.php");
exit;

?>