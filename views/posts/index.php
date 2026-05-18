<?php

require_once "../../controllers/PostController.php";

$posts = browsePosts();

function e($value)
{
    return htmlspecialchars($value ?? "");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Travel Posts</title>

    <link rel="stylesheet" href="../../public/css/style.css">

</head>

<body>

<div class="posts-container">

    <h1>Travel Posts</h1>
    <input type="text" id="search" placeholder="Search posts..."
    onkeyup="searchPosts()">
    <select id="genreFilter" onchange="filterPosts()">

    <option value="">All Genres</option>

    <option value="beach">Beach</option>
    <option value="mountain">Mountain</option>
    <option value="city">City</option>
    <option value="historical">Historical</option>
    <option value="adventure">Adventure</option>
    <option value="religious">Religious</option>
    <option value="nature">Nature</option>

    </select>

    <select id="costFilter" onchange="filterPosts()">

    <option value="">All Costs</option>

    <option value="low">Low</option>
    <option value="medium">Medium</option>
    <option value="high">High</option>

</select>

    <?php if (empty($posts)): ?>

        <p>No approved posts found.</p>

    <?php else: ?>

        <div class="posts-grid" id="postArea">

            <?php foreach ($posts as $post): ?>

                <div class="post-card">

                    <?php if (!empty($post["image_path"])): ?>

                        <img
                            src="../../<?= e($post["image_path"]) ?>"
                            class="post-image"
                            alt="Post Image"
                        >

                    <?php endif; ?>

                    <h2>
                        <?= e($post["title"]) ?>
                    </h2>

                    <p>
                        <strong>Genre:</strong>
                        <?= e($post["genre"]) ?>
                    </p>

                    <p>
                        <strong>Cost:</strong>
                        <?= e($post["cost_level"]) ?>
                    </p>

                    <a
                        href="detail.php?id=<?= $post["id"] ?>"
                        class="view-btn"
                    >
                        View Details
                    </a>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>
    <script src="../../public/js/search.js"></script>
    <script src="../../public/js/filter.js"></script>
</body>

</html>