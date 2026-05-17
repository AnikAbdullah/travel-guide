<?php

session_start();

require_once "../../config/db.php";
require_once "../../models/PostRequest.php";

header("Content-Type: application/json");

/** @var mysqli $conn */

// CSRF check.
$token = $_POST["csrf_token"] ?? "";
if (empty($token) || empty($_SESSION["csrf_token"]) || !hash_equals($_SESSION["csrf_token"], $token)) {
    echo json_encode(["success" => false, "message" => "Invalid CSRF token."]);
    exit;
}

// Auth bypass.
// $scoutId = getScoutById and verify...
$scoutId = (int) ($_SESSION["user_id"] ?? 1);

$requestId = (int) ($_POST["request_id"] ?? 0);

if (!$requestId) {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
    exit;
}

if (deletePostRequest($conn, $requestId, $scoutId)) {
    echo json_encode(["success" => true, "message" => "Request deleted successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "You cannot delete this request."]);
}
