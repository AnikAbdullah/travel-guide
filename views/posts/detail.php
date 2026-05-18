<?php

require_once "../../controllers/PostController.php";

$postId = (int) ($_GET["id"] ?? 0);

$post = getPostDetails($postId);

if (!$post) {
    die("Post not found.");
}

function e($value)
{
    return htmlspecialchars($value ?? "");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>
        <?= e($post["title"]) ?>
    </title>

    <link rel="stylesheet" href="../../public/css/style.css">

</head>

<body>

<div class="details-container">

    <a href="index.php" class="back-btn">
        ← Back to Posts
    </a>

    <h1>
        <?= e($post["title"]) ?>
    </h1>

    <?php if (!empty($post["image_path"])): ?>

        <img
            src="../../<?= e($post["image_path"]) ?>"
            class="details-image"
            alt="Post Image"
        >

    <?php endif; ?>

    <div class="details-card">

        <p>
            <strong>Genre:</strong>
            <?= e($post["genre"]) ?>
        </p>

        <p>
            <strong>Cost Level:</strong>
            <?= e($post["cost_level"]) ?>
        </p>

        <p>
            <strong>Short History:</strong>
            <?= e($post["short_history"]) ?>
        </p>

        <p>
            <strong>Country Representation:</strong>
            <?= e($post["country_representation"]) ?>
        </p>

        <p>
            <strong>Travel Medium Info:</strong>
            <?= e($post["travel_medium_info"]) ?>
        </p>

    </div>

</div>

</body>

</html>