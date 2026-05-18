<?php

include "../../config/db.php";

if(isset($_GET['id'])){

    $id = $_GET['id'];

    mysqli_query($conn, "UPDATE post_requests SET status='rejected' WHERE id=$id");
}

header("Location: post_requests.php");
exit;

?>