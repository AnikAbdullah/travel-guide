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
$pageTitle   = "My Requests";

$scout = scoutOnly();

$requests = getRequestsByScoutId($conn, (int) $scout["id"]);

$successMessage = $_SESSION["flash_success"] ?? "";
unset($_SESSION["flash_success"]);

require_once "../layout/header.php";

?>

<section class="request-page-header">
    <div class="breadcrumb">
        <a href="dashboard.php">Dashboard</a>
        <span class="breadcrumb-separator">/</span>
        <span>My Requests</span>
    </div>
    <h2>My Requests</h2>
    <p>Track every post request you have submitted.</p>
</section>

<?php if ($successMessage): ?>
    <div class="alert alert-success" style="margin-bottom:20px">
        <span><?= e($successMessage) ?></span>
    </div>
<?php endif; ?>

<?php if (empty($requests)): ?>
    <div class="empty-state">
        <span class="empty-icon">📭</span>
        <h3>No requests yet</h3>
        <p>You have not submitted any post requests. Start by creating your first one.</p>
        <a href="create_request.php" class="primary-btn">+ Create Request</a>
    </div>
<?php else: ?>
    <div class="requests-grid">
        <?php foreach ($requests as $req):
            $postData = $req["post_data"];
            $title    = $postData["title"] ?? "Untitled";
            $history  = $postData["short_history"] ?? "";
            $genre    = $postData["genre"] ?? "";
            $cost     = $postData["cost_level"] ?? "";
            $status   = $req["status"];
            $date     = date("M d, Y", strtotime($req["requested_at"]));

            $badgeMap = [
                "approved" => ["badge-approved", "Approved"],
                "rejected" => ["badge-rejected", "Rejected"],
                "pending"  => ["badge-pending",  "Pending"],
            ];
            [$badgeClass, $badgeText] = $badgeMap[$status] ?? ["badge-pending", "Pending"];
        ?>
        <div class="request-card" data-id="<?= (int) $req["id"] ?>">
            <div class="request-card-header">
                <h3 class="request-title"><?= e($title) ?></h3>
                <span class="badge <?= $badgeClass ?>"><?= $badgeText ?></span>
            </div>

            <div class="request-card-body">
                <?php if ($history): ?>
                    <p class="request-excerpt"><?= e($history) ?></p>
                <?php endif; ?>
                <div class="request-meta">
                    <?php if ($genre): ?><span class="meta-tag"><?= e(ucfirst($genre)) ?></span><?php endif; ?>
                    <?php if ($cost):  ?><span class="meta-tag"><?= e(ucfirst($cost)) ?> cost</span><?php endif; ?>
                </div>
            </div>

            <div class="request-card-footer">
                <span class="request-date"><?= e($date) ?></span>
                <div class="request-actions">
                    <?php if ($status === "pending"): ?>
                        <a href="edit_request.php?id=<?= (int) $req["id"] ?>" class="btn-edit">Edit</a>
                        <button class="btn-delete" onclick="confirmDelete(<?= (int) $req["id"] ?>)">Delete</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>


<script>window.CSRF_TOKEN = <?= json_encode(csrfToken()) ?>;</script>
<script src="../../public/js/scout.js"></script>

<?php require_once "../layout/footer.php"; ?>
