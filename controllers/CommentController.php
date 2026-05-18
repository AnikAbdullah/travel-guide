<?php

require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Comment.php";

// Save comment.
function saveComment($postId, $userId, $comment)
{
    global $conn;

    return addComment(
        $conn,
        $postId,
        $userId,
        $comment
    );
}

// Get comments.
function getPostComments($postId)
{
    global $conn;

    return getCommentsByPostId(
        $conn,
        $postId
    );
}