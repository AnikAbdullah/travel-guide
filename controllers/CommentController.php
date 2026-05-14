<?php

session_start();

require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Post.php";

// Add comment.
function addCommentAjax()
{
    global $conn;

    header("Content-Type: application/json");

    // User validation.
    if (
        !isset($_SESSION["user_id"]) ||
        $_SESSION["role"] !== "user"
    ) {
        echo json_encode([
            "success" => false,
            "message" => "Unauthorized."
        ]);

        exit;
    }

    $postId = (int) ($_POST["post_id"] ?? 0);

    $content = trim($_POST["content"] ?? "");

    // Validation.
    if ($content === "") {
        echo json_encode([
            "success" => false,
            "message" => "Comment cannot be empty."
        ]);

        exit;
    }

    if (strlen($content) > 500) {
        echo json_encode([
            "success" => false,
            "message" => "Comment too long."
        ]);

        exit;
    }

    // XSS protection.
    $content = htmlspecialchars($content);

    $success = addComment(
        $conn,
        $postId,
        $_SESSION["user_id"],
        $content
    );

    echo json_encode([
        "success" => $success
    ]);
}

// Delete own comment.
function deleteCommentAjax()
{
    global $conn;

    header("Content-Type: application/json");

    if (!isset($_SESSION["user_id"])) {
        echo json_encode([
            "success" => false
        ]);

        exit;
    }

    $commentId = (int) ($_POST["comment_id"] ?? 0);

    $success = deleteComment(
        $conn,
        $commentId,
        $_SESSION["user_id"]
    );

    echo json_encode([
        "success" => $success
    ]);
}