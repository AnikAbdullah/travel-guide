<?php

require_once "../../controllers/PostController.php";
require_once "../../controllers/CommentController.php";

$postId = (int) ($_GET["id"] ?? 0);
$post = getPostDetails($postId);

function e($value)
{
    return htmlspecialchars($value ?? "");
}

if (!$post) {
    die("Post not found.");
}
// Temporary login bypass.
$userId = $_SESSION["user_id"] ?? 1;

// Add comment.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $comment = trim($_POST["comment"] ?? "");

    if ($comment !== "") {

        saveComment(
            $postId,
            $userId,
            $comment
        );
    }
}

// Load comments.
$comments = getPostComments($postId);


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
        
        <hr>

<div class="comments-section">

    <h2>Comments</h2>

    <!-- Comment form -->
    <form method="POST">

        <textarea
            name="comment"
            rows="4"
            placeholder="Write your comment..."
            required
        ></textarea>

        <br><br>

        <button type="submit">
            Add Comment
        </button>

    </form>

    <br>

    <!-- Comments list -->
    <?php if (empty($comments)): ?>

        <p>No comments yet.</p>

    <?php else: ?>

        <?php foreach ($comments as $comment): ?>

            <div class="comment-card">

                <h4>
                    <?= e($comment["name"]) ?>
                </h4>

                <p>
                    <?= e($comment["comment"]) ?>
                </p>

                <small>
                    <?= e($comment["created_at"]) ?>
                </small>

            </div>

            <br>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

    </div>

</div>

</body>

</html>