<?php

session_start();

require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Scout.php";
require_once __DIR__ . "/../models/PostRequest.php";

// Scout auth.
function scoutOnly()
{
    global $conn;

    if (!isset($_SESSION["user_id"])) {
        header("Location: ../auth/login.php");
        exit;
    }

    if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "scout") {
        header("Location: forbidden.php");
        exit;
    }

    $scout = getScoutById($conn, $_SESSION["user_id"]);

    if (!$scout || $scout["is_verified"] != 1) {
        header("Location: forbidden.php");
        exit;
    }

    return $scout;
}

// Validate form.
function validatePostRequestForm($data)
{
    $errors = [];
    $validGenres = ["beach", "mountain", "city", "historical", "adventure", "religious", "nature", "other"];
    $validCosts = ["low", "medium", "high"];

    if (empty($data["title"])) {
        $errors["title"] = "Title is required.";
    }

    if (empty($data["short_history"])) {
        $errors["short_history"] = "Short history is required.";
    }

    if (empty($data["country_representation"])) {
        $errors["country_representation"] = "Country representation is required.";
    }

    if (empty($data["travel_medium_info"])) {
        $errors["travel_medium_info"] = "Travel medium information is required.";
    }

    if ($data["title"] !== "" && strlen($data["title"]) > 150) {
        $errors["title"] = "Title must be 150 characters or less.";
    }

    if (!in_array($data["genre"], $validGenres)) {
        $errors["genre"] = "Select a valid genre.";
    }

    if (!in_array($data["cost_level"], $validCosts)) {
        $errors["cost_level"] = "Select a valid cost level.";
    }

    return $errors;
}

// Upload image.
function uploadPostRequestImage($file, $scoutId)
{
    if (!isset($file["error"]) || $file["error"] === UPLOAD_ERR_NO_FILE) {
        return ["path" => null, "error" => null];
    }

    if ($file["error"] !== UPLOAD_ERR_OK) {
        return ["path" => null, "error" => "Image upload failed."];
    }

    if ((int) $file["size"] > 2 * 1024 * 1024) {
        return ["path" => null, "error" => "Image size must be 2MB or less."];
    }

    $mimeType = mime_content_type($file["tmp_name"]);

    $allowedTypes = [
        "image/jpeg" => "jpg",
        "image/png" => "png",
        "image/webp" => "webp",
    ];

    if (!isset($allowedTypes[$mimeType])) {
        return ["path" => null, "error" => "Only JPG, PNG, or WebP images are allowed."];
    }

    $uploadDir = __DIR__ . "/../public/uploads/posts";
    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
        return ["path" => null, "error" => "Could not prepare upload folder."];
    }

    $fileName = "post_" . (int) $scoutId . "_" . time() . "_" . rand(1000, 9999) . "." . $allowedTypes[$mimeType];
    $targetPath = $uploadDir . "/" . $fileName;

    if (!move_uploaded_file($file["tmp_name"], $targetPath)) {
        return ["path" => null, "error" => "Could not save uploaded image."];
    }

    return ["path" => "public/uploads/posts/" . $fileName, "error" => null];
}

// Handle submit.
function handleCreatePostRequest($conn, $scout)
{
    $input = [
        "title" => trim($_POST["title"] ?? ""),
        "short_history" => trim($_POST["short_history"] ?? ""),
        "country_representation" => trim($_POST["country_representation"] ?? ""),
        "genre" => trim($_POST["genre"] ?? ""),
        "cost_level" => trim($_POST["cost_level"] ?? ""),
        "travel_medium_info" => trim($_POST["travel_medium_info"] ?? ""),
    ];
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        return ["input" => $input, "errors" => $errors];
    }

    $errors = validatePostRequestForm($input);

    if (!$errors) {
        $upload = uploadPostRequestImage($_FILES["post_image"] ?? [], $scout["id"]);
        if ($upload["error"]) {
            $errors["image"] = $upload["error"];
        }
    }

    if ($errors) {
        return ["input" => $input, "errors" => $errors];
    }

    $postData = $input;
    $postData["image_path"] = $upload["path"];

    if (!createPostRequest($conn, (int) $scout["id"], $postData)) {
        $errors["form"] = "Post request could not be saved. Please check the scout account and try again.";
        return ["input" => $input, "errors" => $errors];
    }

    $_SESSION["flash_success"] = "Post request submitted for admin review.";
    header("Location: create_request.php");
    exit;
}
