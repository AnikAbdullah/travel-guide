<?php

session_start();

require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Post.php";

// Browse approved posts.
function browsePosts()
{
    global $conn;

    return getAllApprovedPosts($conn);
}
// Get single post details.
function getPostDetails($id)
{
    global $conn;

    return getPostById($conn, $id);
}

// Search travel posts.
function searchTravelPosts($keyword)
{
    global $conn;

    return searchPosts($conn, $keyword);
}

// Filter travel posts.
function getFilteredPosts($genre, $cost)
{
    global $conn;

    return filterPosts($conn, $genre, $cost);
}