<?php

include "../../config/db.php";

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $requestQuery = mysqli_query($conn, "SELECT * FROM post_requests WHERE id=$id");
    $request = mysqli_fetch_assoc($requestQuery);

    if($request){

        $scout_id = $request['scout_id'];
        $postData = json_decode($request['post_data'], true);

        $title = $postData['title'];
        $country = $postData['country'];
        $genre = $postData['genre'];
        $cost_level = $postData['cost_level'];

        mysqli_query($conn,
        "INSERT INTO posts (scout_id, title, country, genre, cost_level, status)
        VALUES ('$scout_id', '$title', '$country', '$genre', '$cost_level', 'approved')");

        mysqli_query($conn, "UPDATE post_requests SET status='approved' WHERE id=$id");
    }
}

header("Location: post_requests.php");
exit;

?>