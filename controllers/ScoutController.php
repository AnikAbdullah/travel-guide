<?php

session_start();

require_once "../../config/db.php";
require_once "../../models/Scout.php";

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
?>