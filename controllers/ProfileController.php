<?php

session_start();

require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../helpers/auth.php";

// Upload profile picture.
function uploadProfilePicture($file)
{
    if (
        empty($file["name"]) ||
        $file["error"] !== 0
    ) {
        return "";
    }

    $allowedMime = [
        "image/jpeg",
        "image/png",
        "image/webp"
    ];

    $mime = mime_content_type($file["tmp_name"]);

    if (!in_array($mime, $allowedMime)) {
        return false;
    }

    if ($file["size"] > 2 * 1024 * 1024) {
        return false;
    }

    $extension = pathinfo(
        $file["name"],
        PATHINFO_EXTENSION
    );

    $newName = uniqid("profile_", true)
             . "."
             . $extension;

    $uploadDir = __DIR__
               . "/../public/uploads/profile/";

    $destination = $uploadDir . $newName;

    if (!move_uploaded_file($file["tmp_name"], $destination)) {
        return false;
    }

    return $newName;
}

// Update user profile.
function updateUserProfile(
    $conn,
    $userId,
    $name,
    $email,
    $profilePicture
) {
    $sql = "UPDATE users
            SET name = ?,
                email = ?,
                profile_picture = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sssi",
        $name,
        $email,
        $profilePicture,
        $userId
    );

    $ok = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $ok;
}

// Change password.
function updatePassword(
    $conn,
    $userId,
    $newPassword
) {
    $passwordHash = password_hash(
        $newPassword,
        PASSWORD_DEFAULT
    );

    $sql = "UPDATE users
            SET password_hash = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $passwordHash,
        $userId
    );

    $ok = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $ok;
}

// Handle profile update.
function handleProfileUpdate($conn)
{
    requireLogin();

    $userId = (int) $_SESSION["user_id"];

    $user = getUserById($conn, $userId);

    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        return [
            "user" => $user,
            "errors" => $errors
        ];
    }

    $name  = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");

    if (empty($name)) {
        $errors["name"] = "Name is required.";
    }

    if (
        empty($email) ||
        !filter_var($email, FILTER_VALIDATE_EMAIL)
    ) {
        $errors["email"] = "Valid email required.";
    }

    $profilePicture = $user["profile_picture"];

    if (!empty($_FILES["profile_picture"]["name"])) {

        $uploaded = uploadProfilePicture(
            $_FILES["profile_picture"]
        );

        if ($uploaded === false) {
            $errors["profile_picture"] =
                "Invalid image type or size.";
        } else {
            $profilePicture = $uploaded;
        }
    }

    $currentPassword = $_POST["current_password"] ?? "";
    $newPassword     = $_POST["new_password"] ?? "";
    $confirmPassword = $_POST["confirm_new_password"] ?? "";

    if (!empty($newPassword)) {

        if (
            !password_verify(
                $currentPassword,
                $user["password_hash"]
            )
        ) {
            $errors["current_password"] =
                "Current password incorrect.";
        }

        if (strlen($newPassword) < 8) {
            $errors["new_password"] =
                "Password must be at least 8 characters.";
        }

        if ($newPassword !== $confirmPassword) {
            $errors["confirm_new_password"] =
                "Passwords do not match.";
        }
    }

    if ($errors) {
        return [
            "user" => $user,
            "errors" => $errors
        ];
    }

    updateUserProfile(
        $conn,
        $userId,
        $name,
        $email,
        $profilePicture
    );

    if (!empty($newPassword)) {
        updatePassword(
            $conn,
            $userId,
            $newPassword
        );
    }

    $_SESSION["name"] = $name;

    flashSet(
        "success",
        "Profile updated successfully."
    );

    header("Location: profile.php");
    exit;
}