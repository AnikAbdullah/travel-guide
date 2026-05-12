<?php

function getScoutById($conn, $id)
{
    $sql = "SELECT id, name, email, role, is_verified FROM users WHERE id = ? AND role = 'scout'";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}