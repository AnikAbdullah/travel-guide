<?php

// Get approved posts by scout.
function getApprovedPostsByScoutId($conn, $scoutId)
{
    $sql = "SELECT id, title, short_history, country, genre, cost_level, travel_medium_info, created_at, updated_at
            FROM posts WHERE scout_id = ? AND status = 'approved' ORDER BY updated_at DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $scoutId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// Get single approved post by scout.
function getApprovedPostByIdAndScout($conn, $postId, $scoutId)
{
    $sql = "SELECT id, title, short_history, country, genre, cost_level, travel_medium_info, created_at, updated_at
            FROM posts WHERE id = ? AND scout_id = ? AND status = 'approved'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $postId, $scoutId);
    mysqli_stmt_execute($stmt);
    return mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}
