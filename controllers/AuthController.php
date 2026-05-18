<?php

session_start();

require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../helpers/auth.php";

// Validate registration.
function validateRegister($data)
{
    $errors = [];
    $validRoles = ["scout", "user"]; // admin only added by existing admin in Task 3

    if (empty($data["name"])) {
        $errors["name"] = "Name is required.";
    }
    if (empty($data["email"]) || !filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
        $errors["email"] = "A valid email is required.";
    }
    if (empty($data["password"]) || strlen($data["password"]) < 8) {
        $errors["password"] = "Password must be at least 8 characters.";
    }
    if (($data["password"] ?? "") !== ($data["confirm_password"] ?? "")) {
        $errors["confirm_password"] = "Passwords do not match.";
    }
    if (!in_array($data["role"] ?? "", $validRoles)) {
        $errors["role"] = "Select a valid role.";
    }
    return $errors;
}

// Handle registration form.
function handleRegister($conn)
{
    $input = [
        "name"             => trim($_POST["name"] ?? ""),
        "email"            => trim($_POST["email"] ?? ""),
        "password"         => $_POST["password"] ?? "",
        "confirm_password" => $_POST["confirm_password"] ?? "",
        "role"             => trim($_POST["role"] ?? ""),
    ];
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        return ["input" => $input, "errors" => $errors];
    }

    $errors = validateRegister($input);

    if (!$errors && emailExists($conn, $input["email"])) {
        $errors["email"] = "Email is already registered.";
    }

    if ($errors) {
        return ["input" => $input, "errors" => $errors];
    }

    if (!registerUser($conn, $input["name"], $input["email"], $input["password"], $input["role"])) {
        return ["input" => $input, "errors" => ["form" => "Registration failed. Try again."]];
    }

    flashSet("success", "Registration successful. Please log in. An admin will verify your account.");
    header("Location: login.php");
    exit;
}

// Handle login form.
function handleLogin($conn)
{
    $input = [
        "email"    => trim($_POST["email"] ?? ""),
        "password" => $_POST["password"] ?? "",
    ];
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        return ["input" => $input, "errors" => $errors];
    }

    if (empty($input["email"]) || empty($input["password"])) {
        $errors["form"] = "Email and password are required.";
        return ["input" => $input, "errors" => $errors];
    }

    $user = verifyLoginCredentials($conn, $input["email"], $input["password"]);
    if (!$user) {
        $errors["form"] = "Invalid email or password.";
        return ["input" => $input, "errors" => $errors];
    }

    $_SESSION["user_id"]     = (int) $user["id"];
    $_SESSION["name"]        = $user["name"];
    $_SESSION["role"]        = $user["role"];
    $_SESSION["is_verified"] = (int) $user["is_verified"];

    if ((int) $user["is_verified"] !== 1) {
        // Logged in but not yet verified — land them on home; home will show pending banner.
        header("Location: ../home/index.php");
        exit;
    }

    redirectByRole($user["role"]);
}

// Handle logout.
function handleLogout()
{
    session_start();
    $_SESSION = [];
    session_unset();
    session_destroy();
    header("Location: ../auth/login.php");
    exit;
}