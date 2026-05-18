<?php


// Get all approved posts.
function getAllApprovedPosts($conn)
{
    $sql = "SELECT *
            FROM posts
            WHERE status = 'approved'
            ORDER BY created_at DESC";

    $result = mysqli_query($conn, $sql);

    $posts = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }

    return $posts;
}

// Get single post by id.
function getPostById($conn, $id)
{
    $sql = "SELECT *
            FROM posts
            WHERE id = ?
            AND status = 'approved'";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}