<?php

// Add to wishlist.
function addToWishlist($conn, $userId, $postId)
{
    $sql = "INSERT IGNORE INTO wishlist
            (user_id, post_id)
            VALUES (?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $userId,
        $postId
    );

    $ok = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $ok;
}

// Remove from wishlist.
function removeFromWishlist($conn, $userId, $postId)
{
    $sql = "DELETE FROM wishlist
            WHERE user_id = ?
            AND post_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $userId,
        $postId
    );

    mysqli_stmt_execute($stmt);

    $affected = mysqli_affected_rows($conn);

    mysqli_stmt_close($stmt);

    return $affected > 0;
}

// Get wishlist by user.
function getWishlistByUserId($conn, $userId)
{
    $sql = "SELECT
                p.id,
                p.title,
                p.country,
                p.genre,
                p.cost_level,
                w.added_at
            FROM wishlist w
            JOIN posts p
            ON p.id = w.post_id
            WHERE w.user_id = ?
            ORDER BY w.added_at DESC";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $userId
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

// Check wishlist item.
function isInWishlist($conn, $userId, $postId)
{
    $sql = "SELECT id
            FROM wishlist
            WHERE user_id = ?
            AND post_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $userId,
        $postId
    );

    mysqli_stmt_execute($stmt);

    mysqli_stmt_store_result($stmt);

    $found = mysqli_stmt_num_rows($stmt) > 0;

    mysqli_stmt_close($stmt);

    return $found;
}
