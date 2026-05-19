<?php

session_start();

require_once '../config/database.php';
require_once '../models/Wishlist.php';

$db = (new Database())->connect();

$wishlist = new Wishlist($db);

$post_id = $_POST['post_id'];

$wishlist->removeWishlist(
    $_SESSION['user_id'],
    $post_id
);

echo "Removed Successfully";

?>