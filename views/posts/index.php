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

    <?php if (empty($posts)): ?>

        <p>No approved posts found.</p>

    <?php else: ?>

        <div class="posts-grid">

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

</body>

</html>