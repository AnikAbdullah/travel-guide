<?php

// Insert request.
function createPostRequest($conn, $scoutId, $postData)
{
    $jsonData = json_encode($postData);
    $status = "pending";
    $sql = "INSERT INTO post_requests (scout_id, post_data, status) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "iss", $scoutId, $jsonData, $status);
    $success = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $success;
}
