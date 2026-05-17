<?php

require_once "../../config/db.php";
require_once "../../controllers/ScoutController.php";

// Check DB.
/** @var mysqli $conn */
if (!isset($conn)) {
    die("Database connection not available.");
}

// Escape HTML.
function e($value)
{
    return htmlspecialchars($value ?? "");
}

$currentPage = "create";
$pageTitle = "Create Post Request";

// Auth bypass.
// $scout = scoutOnly();
$scout = [
    "id" => $_SESSION["user_id"] ?? 1,
    "name" => $_SESSION["name"] ?? "Test Scout",
];

// Submit form.
$result = handleCreatePostRequest($conn, $scout);
$input = $result["input"];
$errors = $result["errors"];
$successMessage = $_SESSION["flash_success"] ?? "";
unset($_SESSION["flash_success"]);

require_once "../layout/header.php";

?>

<!-- Header -->
<section class="request-page-header">
    <div class="breadcrumb">
        <a href="dashboard.php">Dashboard</a>
        <span class="breadcrumb-separator">/</span>
        <span>Create Request</span>
    </div>
    <h2>Create Post Request</h2>
    <p>Submit a visiting place for admin review.</p>
</section>

<!-- Form -->
<section class="request-form-card">
    <!-- Success message -->
    <?php if ($successMessage): ?>
        <div class="alert alert-success">
            <span><?= e($successMessage) ?></span>
        </div>
    <?php endif; ?>

    <!-- Error message -->
    <?php if (isset($errors["form"])): ?>
        <div class="alert alert-error">
            <span><?= e($errors["form"]) ?></span>
        </div>
    <?php endif; ?>

    <form name="postForm" method="POST" action="create_request.php" enctype="multipart/form-data" onsubmit="return validateScoutForm()">
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
        <!-- Place information -->
        <div class="request-form-section">
            <h3 class="request-section-title">Place Information</h3>

            <div class="form-field">
                <label for="title">Title <span class="req">*</span></label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    class="form-input"
                    value="<?= e($input["title"]) ?>"
                    maxlength="150"
                >
                <span class="form-error" id="title_error"><?= e($errors["title"] ?? "") ?></span>
            </div>

            <div class="form-field">
                <label for="short_history">Short history <span class="req">*</span></label>
                <textarea
                    id="short_history"
                    name="short_history"
                    class="form-input"
                    rows="5"
                ><?= e($input["short_history"]) ?></textarea>
                <span class="form-error" id="short_history_error"><?= e($errors["short_history"] ?? "") ?></span>
            </div>

            <div class="form-field">
                <label for="country_representation">Country representation / cultural significance <span class="req">*</span></label>
                <textarea
                    id="country_representation"
                    name="country_representation"
                    class="form-input"
                    rows="4"
                ><?= e($input["country_representation"]) ?></textarea>
                <span class="form-error" id="country_representation_error"><?= e($errors["country_representation"] ?? "") ?></span>
            </div>
        </div>

        <!-- Travel details -->
        <div class="request-form-section">
            <h3 class="request-section-title">Travel Details</h3>

            <div class="form-field">
                <label for="genre">Genre <span class="req">*</span></label>
                <select id="genre" name="genre" class="form-input">
                    <option value="">Select genre</option>
                    <?php foreach (["beach", "mountain", "city", "historical", "adventure", "religious", "nature", "other"] as $genre): ?>
                        <option value="<?= e($genre) ?>" <?= $input["genre"] === $genre ? "selected" : "" ?>>
                            <?= e(ucfirst($genre)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="form-error" id="genre_error"><?= e($errors["genre"] ?? "") ?></span>
            </div>

            <div class="form-field">
                <label for="cost_level">Cost level <span class="req">*</span></label>
                <select id="cost_level" name="cost_level" class="form-input">
                    <option value="">Select cost level</option>
                    <?php foreach (["low", "medium", "high"] as $cost): ?>
                        <option value="<?= e($cost) ?>" <?= $input["cost_level"] === $cost ? "selected" : "" ?>>
                            <?= e(ucfirst($cost)) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <span class="form-error" id="cost_level_error"><?= e($errors["cost_level"] ?? "") ?></span>
            </div>

            <div class="form-field">
                <label for="travel_medium_info">Travel medium info <span class="req">*</span></label>
                <textarea
                    id="travel_medium_info"
                    name="travel_medium_info"
                    class="form-input"
                    rows="4"
                ><?= e($input["travel_medium_info"]) ?></textarea>
                <span class="form-error" id="travel_medium_info_error"><?= e($errors["travel_medium_info"] ?? "") ?></span>
            </div>
        </div>

        <!-- Image upload -->
        <div class="request-form-section">
            <h3 class="request-section-title">Optional Image</h3>

            <div class="form-field">
                <label for="post_image">Place image</label>
                <input type="file" id="post_image" name="post_image" class="form-input" accept=".jpg,.jpeg,.png,.webp">
                <div class="form-help">JPG, PNG, or WebP. Maximum 2MB.</div>
                <span class="form-error" id="post_image_error"><?= e($errors["image"] ?? "") ?></span>
            </div>
        </div>

        <!-- Buttons -->
        <div class="form-actions">
            <button type="submit" class="primary-btn">Submit Request</button>
            <a href="dashboard.php" class="secondary-btn">Cancel</a>
        </div>
    </form>
</section>

<script src="../../public/js/scout.js"></script>

<?php require_once "../layout/footer.php"; ?>
