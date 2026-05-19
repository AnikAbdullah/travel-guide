<?php

// Check if email exists.
function emailExists($conn, $email)
{
    $sql  = "SELECT id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $exists = mysqli_stmt_num_rows($stmt) > 0;
    mysqli_stmt_close($stmt);
    return $exists;
}

// Insert user.
function registerUser($conn, $name, $email, $password, $role)
{
    $hash       = password_hash($password, PASSWORD_DEFAULT);
    $isVerified = 0;
    $sql = "INSERT INTO users (name, email, password_hash, role, is_verified)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $hash, $role, $isVerified);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

// Get user by email.
function getUserByEmail($conn, $email)
{
    $sql  = "SELECT id, name, email, password_hash, role, is_verified, profile_picture
             FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// Get user by id.
function getUserById($conn, $id)
{
    $sql  = "SELECT id, name, email, role, is_verified, profile_picture
             FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// Verify password.
function verifyLoginCredentials($conn, $email, $password)
{
    $user = getUserByEmail($conn, $email);
    if (!$user) {
        return false;
    }
    if (!password_verify($password, $user["password_hash"])) {
        return false;
    }
    return $user;
}