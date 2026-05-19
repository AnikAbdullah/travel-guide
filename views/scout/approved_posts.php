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
$pageTitle   = "Approved Posts";

$scout = scoutOnly();

$posts          = getApprovedPostsByScoutId($conn, (int) $scout["id"]);
$successMessage = $_SESSION["flash_success"] ?? "";
unset($_SESSION["flash_success"]);

require_once "../layout/header.php";

?>

<section class="request-page-header">
    <div class="breadcrumb">
        <a href="dashboard.php">Dashboard</a>
        <span class="breadcrumb-separator">/</span>
        <span>Approved Posts</span>
    </div>
    <h2>Approved Posts</h2>
    <p>Posts published from your submissions. Request changes if anything needs updating.</p>
</section>

<?php if ($successMessage): ?>
    <div class="alert alert-success" style="margin-bottom:20px">
        <span><?= e($successMessage) ?></span>
    </div>
<?php endif; ?>

<?php if (empty($posts)): ?>
    <div class="empty-state">
        <span class="empty-icon">🌐</span>
        <h3>No approved posts yet</h3>
        <p>None of your submissions have been approved yet.</p>
        <a href="create_request.php" class="primary-btn">+ Create Request</a>
    </div>
<?php else: ?>
    <div class="requests-grid">
        <?php foreach ($posts as $post):
            $date = date("M d, Y", strtotime($post["updated_at"]));
        ?>
        <div class="request-card">
            <div class="request-card-header">
                <h3 class="request-title"><?= e($post["title"]) ?></h3>
                <span class="badge badge-approved">Approved</span>
            </div>

            <div class="request-card-body">
                <?php if ($post["short_history"]): ?>
                    <p class="request-excerpt"><?= e($post["short_history"]) ?></p>
                <?php endif; ?>
                <div class="request-meta">
                    <span class="meta-tag"><?= e(ucfirst($post["genre"])) ?></span>
                    <span class="meta-tag"><?= e(ucfirst($post["cost_level"])) ?> cost</span>
                    <span class="meta-tag"><?= e($post["country"]) ?></span>
                </div>
            </div>

            <div class="request-card-footer">
                <span class="request-date"><?= e($date) ?></span>
                <div class="request-actions">
                    <a href="request_changes.php?post_id=<?= (int) $post["id"] ?>" class="btn-change">Request Changes</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once "../layout/footer.php"; ?>
