<?php

require_once "../../controllers/ScoutController.php";

// $scout = scoutOnly();
$currentPage = "dashboard";
$pageTitle   = "Scout Dashboard";
$scout       = ["name" => $_SESSION["name"] ?? "Scout"];

require_once "../layout/header.php";

?>

<h2 style="margin-bottom:8px">Scout Dashboard</h2>
<p style="color:#6b7280;margin-bottom:28px">Welcome, <?= htmlspecialchars($scout["name"]) ?>. Manage your post requests from here.</p>

<div class="dash-actions">
    <a href="create_request.php" class="primary-btn">+ New Request</a>
    <a href="my_requests.php" class="secondary-btn">My Requests</a>
    <a href="approved_posts.php" class="secondary-btn">Approved Posts</a>
</div>

<?php require_once "../layout/footer.php"; ?>
