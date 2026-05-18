<?php

require_once "../../controllers/PostController.php";

$keyword = trim($_POST["keyword"] ?? "");

$posts = searchTravelPosts($keyword);

function e($value)
{
    return htmlspecialchars($value ?? "");
}

if (empty($posts)) {

    echo "<p>No posts found.</p>";
    exit;
}

foreach ($posts as $post) {

?>

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

<?php

}