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