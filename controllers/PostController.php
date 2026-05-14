<?php

session_start();

require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../models/Post.php";

// Browse posts page.
function browsePosts()
{
    global $conn;

    $posts = getApprovedPosts($conn);

    require_once __DIR__ . "/../views/posts/index.php";
}

// Post detail page.
function viewPostDetail($id)
{
    global $conn;

    $post = getPostById($conn, $id);

    if (!$post || $post["status"] !== "approved") {
        die("Post not found.");
    }

    $comments = getCommentsByPost($conn, $id);

    $costEstimate = getCostEstimate($conn, $id);

    require_once __DIR__ . "/../views/posts/detail.php";
}

// AJAX search.
function searchPostsAjax()
{
    global $conn;

    header("Content-Type: application/json");

    $query = trim($_GET["q"] ?? "");

    $posts = searchPosts($conn, $query);

    echo json_encode($posts);
}

// AJAX filter.
function filterPostsAjax()
{
    global $conn;

    header("Content-Type: application/json");

    $country = trim($_GET["country"] ?? "");
    $genre = trim($_GET["genre"] ?? "");
    $cost = trim($_GET["cost"] ?? "");

    $posts = filterPosts(
        $conn,
        $country,
        $genre,
        $cost
    );

    echo json_encode($posts);
}