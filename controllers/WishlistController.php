<?php

session_start();

require_once '../config/database.php';
require_once '../models/Wishlist.php';

$db = (new Database())->connect();

$wishlist = new Wishlist($db);

if(isset($_POST['add'])){

    $post_id = $_POST['post_id'];

    $wishlist->addWishlist(
        $_SESSION['user_id'],
        $post_id
    );

    header(
        "Location: ../views/home.php"
    );
}

if(isset($_POST['remove'])){

    $post_id = $_POST['post_id'];

    $wishlist->removeWishlist(
        $_SESSION['user_id'],
        $post_id
    );

    header(
        "Location: ../views/wishlist/wishlist.php"
    );
}

?>
