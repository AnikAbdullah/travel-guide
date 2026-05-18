<?php


// Get all approved posts.
function getAllApprovedPosts($conn)
{
    $sql = "SELECT *
            FROM posts
            WHERE status = 'approved'
            ORDER BY created_at DESC";

    $result = mysqli_query($conn, $sql);

    $posts = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }

    return $posts;
}

// Get single post by id.
function getPostById($conn, $id)
{
    $sql = "SELECT *
            FROM posts
            WHERE id = ?
            AND status = 'approved'";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}

// Search approved posts.
function searchPosts($conn, $keyword)
{
    $search = "%" . $keyword . "%";

    $sql = "SELECT *
            FROM posts
            WHERE status = 'approved'
            AND (
                title LIKE ?
                OR genre LIKE ?
                OR country_representation LIKE ?
            )
            ORDER BY created_at DESC";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $search,
        $search,
        $search
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $posts = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }

    return $posts;
}

// Filter approved posts.
function filterPosts($conn, $genre, $cost)
{
    $sql = "SELECT *
            FROM posts
            WHERE status = 'approved'";

    $params = [];
    $types = "";

    if ($genre !== "") {
        $sql .= " AND genre = ?";
        $params[] = $genre;
        $types .= "s";
    }

    if ($cost !== "") {
        $sql .= " AND cost_level = ?";
        $params[] = $cost;
        $types .= "s";
    }

    $sql .= " ORDER BY created_at DESC";

    $stmt = mysqli_prepare($conn, $sql);

    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $posts = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $posts[] = $row;
    }

    return $posts;
}