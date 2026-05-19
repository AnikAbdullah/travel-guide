<?php

// Start session if not already started.
function bootSession()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Redirect helper.
function goToUrl($path)
{
    header("Location: " . $path);
    exit;
}

// Require login.
function requireLogin()
{
    bootSession();
    if (!isset($_SESSION["user_id"])) {
        goToUrl("../auth/login.php");
    }
}

// Require guest (not logged in).
function requireGuest()
{
    bootSession();
    if (isset($_SESSION["user_id"])) {
        goToUrl("../home/index.php");
    }
}

// Require verified general user.
function requireVerifiedGeneralUser()
{
    requireLogin();
    if (($_SESSION["role"] ?? "") !== "user" || (int) ($_SESSION["is_verified"] ?? 0) !== 1) {
        goToUrl("../auth/access_denied.php");
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
        goToUrl("../scout/dashboard.php");
    } elseif ($role === "admin") {
        goToUrl("../home/index.php");
    } else {
        goToUrl("../home/index.php");
    }
}