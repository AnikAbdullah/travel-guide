<?php

require_once "../../config/db.php";
require_once "../../controllers/ScoutController.php";

/** @var mysqli $conn */
if (!isset($conn)) {
    die("Database connection not available.");
}

function e($value)
{
    return htmlspecialchars($value ?? "");
}

$currentPage = "approved";
$pageTitle   = "Request Changes";

// Auth bypass.
// $scout = scoutOnly();
$scout = [
    "id"   => $_SESSION["user_id"] ?? 1,
    "name" => $_SESSION["name"] ?? "Test Scout",
];

$postId = (int) ($_GET["post_id"] ?? $_POST["post_id"] ?? 0);
$result = handleRequestChanges($conn, $scout, $postId);

if (!$result["post"]) {
    header("Location: approved_posts.php");
    exit;
}

$post   = $result["post"];
$input  = $result["input"];
$errors = $result["errors"];

require_once "../layout/header.php";

?>

<section class="request-page-header">
    <div class="breadcrumb">
        <a href="dashboard.php">Dashboard</a>
        <span class="breadcrumb-separator">/</span>
        <a href="approved_posts.php">Approved Posts</a>
        <span class="breadcrumb-separator">/</span>
        <span>Request Changes</span>
    </div>
    <h2>Request Changes</h2>
    <p>Propose updates for <strong><?= e($post["title"]) ?></strong>. Admin will review before applying.</p>
</section>

<section class="request-form-card">
    <?php if (isset($errors["form"])): ?>
        <div class="alert alert-error">
            <span><?= e($errors["form"]) ?></span>
        </div>
    <?php endif; ?>

    <form name="postForm" method="POST" action="request_changes.php" enctype="multipart/form-data" onsubmit="return validateScoutForm()">
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
        <input type="hidden" name="post_id" value="<?= (int) $post["id"] ?>">

        <div class="request-form-section">
            <h3 class="request-section-title">Place Information</h3>

            <div class="form-field">
                <label for="title">Title <span class="req">*</span></label>
                <input type="text" id="title" name="title" class="form-input" value="<?= e($input["title"]) ?>" maxlength="150">
                <span class="form-error" id="title_error"><?= e($errors["title"] ?? "") ?></span>
            </div>

            <div class="form-field">
                <label for="short_history">Short history <span class="req">*</span></label>
                <textarea id="short_history" name="short_history" class="form-input" rows="5"><?= e($input["short_history"]) ?></textarea>
                <span class="form-error" id="short_history_error"><?= e($errors["short_history"] ?? "") ?></span>
            </div>

            <div class="form-field">
                <label for="country_representation">Country representation / cultural significance <span class="req">*</span></label>
                <textarea id="country_representation" name="country_representation" class="form-input" rows="4"><?= e($input["country_representation"]) ?></textarea>
                <span class="form-error" id="country_representation_error"><?= e($errors["country_representation"] ?? "") ?></span>
            </div>
        </div>

        <div class="request-form-section">
            <h3 class="request-section-title">Travel Details</h3>

            <div class="form-field">
                <label for="genre">Genre <span class="req">*</span></label>
                <select id="genre" name="genre" class="form-input">
                    <option value="">Select genre</option>
                    <?php foreach (["beach", "mountain", "city", "historical", "adventure", "religious", "nature", "other"] as $genre): ?>
                        <option value="<?= e($genre) ?>" <?= $input["genre"] === $genre ? "selected" : "" ?>><?= e(ucfirst($genre)) ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="form-error" id="genre_error"><?= e($errors["genre"] ?? "") ?></span>
            </div>

            <div class="form-field">
                <label for="cost_level">Cost level <span class="req">*</span></label>
                <select id="cost_level" name="cost_level" class="form-input">
                    <option value="">Select cost level</option>
                    <?php foreach (["low", "medium", "high"] as $cost): ?>
                        <option value="<?= e($cost) ?>" <?= $input["cost_level"] === $cost ? "selected" : "" ?>><?= e(ucfirst($cost)) ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="form-error" id="cost_level_error"><?= e($errors["cost_level"] ?? "") ?></span>
            </div>

            <div class="form-field">
                <label for="travel_medium_info">Travel medium info <span class="req">*</span></label>
                <textarea id="travel_medium_info" name="travel_medium_info" class="form-input" rows="4"><?= e($input["travel_medium_info"]) ?></textarea>
                <span class="form-error" id="travel_medium_info_error"><?= e($errors["travel_medium_info"] ?? "") ?></span>
            </div>
        </div>

        <div class="request-form-section">
            <h3 class="request-section-title">Optional Image</h3>

            <div class="form-field">
                <label for="post_image">Updated image</label>
                <input type="file" id="post_image" name="post_image" class="form-input" accept=".jpg,.jpeg,.png,.webp">
                <div class="form-help">JPG, PNG, or WebP. Maximum 2MB.</div>
                <span class="form-error" id="post_image_error"><?= e($errors["image"] ?? "") ?></span>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="primary-btn">Submit Change Request</button>
            <a href="approved_posts.php" class="secondary-btn">Cancel</a>
        </div>
    </form>
</section>

<script src="../../public/js/scout.js"></script>

<?php require_once "../layout/footer.php"; ?>
