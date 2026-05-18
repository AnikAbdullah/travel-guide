<?php

// Start session if not already started.
function bootSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Redirect helper.
function goTo($path)
{
    header("Location: " . $path);
    exit;
}

// Require login.
function requireLogin()
{
    bootSession();
    if (!isset($_SESSION["user_id"])) {
        goTo("../auth/login.php");
    }
}

// Require guest (not logged in).
function requireGuest()
{
    bootSession();
    if (isset($_SESSION["user_id"])) {
        goTo("../home/index.php");
    }
}

// Require verified general user.
function requireVerifiedGeneralUser()
{
    requireLogin();
    if (($_SESSION["role"] ?? "") !== "user" || (int) ($_SESSION["is_verified"] ?? 0) !== 1) {
        goTo("../auth/access_denied.php");
    }
}

// Flash set.
function flashSet($key, $message)
{
    bootSession();
    $_SESSION["flash_" . $key] = $message;
}

// Flash get.
function flashGet($key)
{
    bootSession();
    $sessionKey = "flash_" . $key;
    if (!empty($_SESSION[$sessionKey])) {
        $value = $_SESSION[$sessionKey];
        unset($_SESSION[$sessionKey]);
        return $value;
    }
    return "";
}

// Redirect after login by role.
function redirectByRole($role)
{
    if ($role === "scout") {
        goTo("../scout/dashboard.php");
    } elseif ($role === "admin") {
        // Task 3 not built yet, send to home.
        goTo("../home/index.php");
    } else {
        goTo("../home/index.php");
    }
}