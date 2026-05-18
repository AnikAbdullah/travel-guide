<?php

include "../../config/db.php";

header("Content-Type: application/json");

if(isset($_POST['id'])){

    $id = $_POST['id'];

    $deleteQuery = mysqli_query($conn, "DELETE FROM comments WHERE id=$id");

    if($deleteQuery){
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }

} else {
    echo json_encode(["success" => false]);
}

?>