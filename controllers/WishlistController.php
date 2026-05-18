<?php

session_start();

require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Wishlist.php";
require_once __DIR__ . "/../helpers/auth.php";

// Get user wishlist.
function handleWishlistPage($conn)
{
    requireVerifiedGeneralUser();

    $userId = (int) $_SESSION["user_id"];

    return getWishlistByUserId($conn, $userId);
}