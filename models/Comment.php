<?php

// Add comment.
function addComment($conn, $postId, $userId, $comment)
{
    $sql = "INSERT INTO comments
            (post_id, user_id, comment)
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "iis",
        $postId,
        $userId,
        $comment
    );

    return mysqli_stmt_execute($stmt);
}

// Get comments by post.
function getCommentsByPostId($conn, $postId)
{
    $sql = "SELECT comments.*,
                   users.name
            FROM comments
            JOIN users
            ON comments.user_id = users.id
            WHERE post_id = ?
            ORDER BY created_at DESC";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $postId);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $comments = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $comments[] = $row;
    }

    return $comments;
}