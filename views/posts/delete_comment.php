<?php

session_start();

require_once "../../controllers/CommentController.php";

header("Content-Type: application/json");

$userId = $_SESSION["user_id"] ?? 1;

$commentId = (int) ($_POST["comment_id"] ?? 0);

if (!$commentId) {

    echo json_encode([
        "success" => false,
        "message" => "Invalid comment."
    ]);

    exit;
}

$deleted = removeComment(
    $commentId,
    $userId
);

if ($deleted) {

    echo json_encode([
        "success" => true
    ]);

} else {

    echo json_encode([
        "success" => false
    ]);
}