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

$currentPage = "requests";
$pageTitle   = "Edit Request";

// Auth bypass.
// $scout = scoutOnly();
$scout = [
    "id"   => $_SESSION["user_id"] ?? 1,
    "name" => $_SESSION["name"] ?? "Test Scout",
];

$requestId = (int) ($_GET["id"] ?? $_POST["request_id"] ?? 0);
$result    = handleEditPostRequest($conn, $scout, $requestId);

if (!$result["request"]) {
    header("Location: my_requests.php");
    exit;
}

$input   = $result["input"];
$errors  = $result["errors"];
$request = $result["request"];

require_once "../layout/header.php";

?>

<!-- Header -->
<section class="request-page-header">
    <div class="breadcrumb">
        <a href="dashboard.php">Dashboard</a>
        <span class="breadcrumb-separator">/</span>
        <a href="my_requests.php">My Requests</a>
        <span class="breadcrumb-separator">/</span>
        <span>Edit Request</span>
    </div>
    <h2>Edit Request</h2>
    <p>Update the details of your pending post request.</p>
</section>

<!-- Form -->
<section class="request-form-card">
    <?php if (isset($errors["form"])): ?>
        <div class="alert alert-error">
            <span><?= e($errors["form"]) ?></span>
        </div>
    <?php endif; ?>

    <form name="postForm" method="POST" action="edit_request.php" enctype="multipart/form-data" onsubmit="return validateScoutForm()">
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
        <input type="hidden" name="request_id" value="<?= (int) $request["id"] ?>">

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
                    value="<?= e($input["title"] ?? "") ?>"
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
                ><?= e($input["short_history"] ?? "") ?></textarea>
                <span class="form-error" id="short_history_error"><?= e($errors["short_history"] ?? "") ?></span>
            </div>

            <div class="form-field">
                <label for="country_representation">Country representation / cultural significance <span class="req">*</span></label>
                <textarea
                    id="country_representation"
                    name="country_representation"
                    class="form-input"
                    rows="4"
                ><?= e($input["country_representation"] ?? "") ?></textarea>
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
                        <option value="<?= e($genre) ?>" <?= ($input["genre"] ?? "") === $genre ? "selected" : "" ?>>
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
                        <option value="<?= e($cost) ?>" <?= ($input["cost_level"] ?? "") === $cost ? "selected" : "" ?>>
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
                ><?= e($input["travel_medium_info"] ?? "") ?></textarea>
                <span class="form-error" id="travel_medium_info_error"><?= e($errors["travel_medium_info"] ?? "") ?></span>
            </div>
        </div>

        <!-- Image upload -->
        <div class="request-form-section">
            <h3 class="request-section-title">Optional Image</h3>

            <?php if (!empty($input["image_path"])): ?>
                <div class="form-field">
                    <div class="form-help">Current image: <?= e(basename($input["image_path"])) ?></div>
                </div>
            <?php endif; ?>

            <div class="form-field">
                <label for="post_image">Replace image</label>
                <input type="file" id="post_image" name="post_image" class="form-input" accept=".jpg,.jpeg,.png,.webp">
                <div class="form-help">JPG, PNG, or WebP. Maximum 2MB. Leave blank to keep existing image.</div>
                <span class="form-error" id="post_image_error"><?= e($errors["image"] ?? "") ?></span>
            </div>
        </div>

        <!-- Buttons -->
        <div class="form-actions">
            <button type="submit" class="primary-btn">Save Changes</button>
            <a href="my_requests.php" class="secondary-btn">Cancel</a>
        </div>
    </form>
</section>

<script src="../../public/js/scout.js"></script>

<?php require_once "../layout/footer.php"; ?>
