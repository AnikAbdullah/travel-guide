<?php

session_start();

require_once "../../config/db.php";
require_once "../../models/Scout.php";
require_once "../../models/PostRequest.php";

header("Content-Type: application/json");

/** @var mysqli $conn */

// CSRF check.
$token = $_POST["csrf_token"] ?? "";
if (empty($token) || empty($_SESSION["csrf_token"]) || !hash_equals($_SESSION["csrf_token"], $token)) {
    echo json_encode(["success" => false, "message" => "Invalid CSRF token."]);
    exit;
}

// Scout auth (JSON, no redirects on AJAX endpoint).
if (!isset($_SESSION["user_id"]) || ($_SESSION["role"] ?? "") !== "scout") {
    echo json_encode(["success" => false, "message" => "Unauthorized."]);
    exit;
}

$scout = getScoutById($conn, (int) $_SESSION["user_id"]);
if (!$scout || (int) $scout["is_verified"] !== 1) {
    echo json_encode(["success" => false, "message" => "Unauthorized."]);
    exit;
}

$scoutId = (int) $scout["id"];

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
