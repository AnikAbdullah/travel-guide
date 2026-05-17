<?php

session_start();

require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Post.php";

// Browse approved posts.
function browsePosts()
{
    global $conn;

    // Get all approved posts from model.
    $posts = getAllApprovedPosts($conn);

    // Open view page.
    require_once __DIR__ . "/../views/posts/index.php";
}