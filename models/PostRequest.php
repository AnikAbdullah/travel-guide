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

// Get all requests for a scout.
function getRequestsByScoutId($conn, $scoutId)
{
    $sql = "SELECT id, post_data, status, requested_at FROM post_requests WHERE scout_id = ? ORDER BY requested_at DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $scoutId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $row["post_data"] = json_decode($row["post_data"], true) ?: [];
        $rows[] = $row;
    }
    return $rows;
}

// Get a single request (ownership enforced).
function getRequestById($conn, $requestId, $scoutId)
{
    $sql = "SELECT id, scout_id, post_data, status, requested_at FROM post_requests WHERE id = ? AND scout_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $requestId, $scoutId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $row["post_data"] = json_decode($row["post_data"], true) ?: [];
    }
    return $row;
}

// Update a pending request (ownership enforced).
function updatePostRequest($conn, $requestId, $scoutId, $postData)
{
    $jsonData = json_encode($postData);
    $sql = "UPDATE post_requests SET post_data = ? WHERE id = ? AND scout_id = ? AND status = 'pending'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sii", $jsonData, $requestId, $scoutId);
    mysqli_stmt_execute($stmt);
    $affected = mysqli_affected_rows($conn);
    mysqli_stmt_close($stmt);
    return $affected > 0;
}

// Delete a pending request (ownership enforced).
function deletePostRequest($conn, $requestId, $scoutId)
{
    $sql = "DELETE FROM post_requests WHERE id = ? AND scout_id = ? AND status = 'pending'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $requestId, $scoutId);
    mysqli_stmt_execute($stmt);
    $affected = mysqli_affected_rows($conn);
    mysqli_stmt_close($stmt);
    return $affected > 0;
}
