<?php

require_once "../../controllers/ScoutController.php";

// $scout = scoutOnly();
$currentPage = "dashboard";
$pageTitle   = "Scout Dashboard";
$scout       = ["name" => $_SESSION["name"] ?? "Scout"];

require_once "../layout/header.php";

?>

<h2 style="margin-bottom:8px">Scout Dashboard</h2>
<p style="color:#6b7280;margin-bottom:16px">Welcome, <?= htmlspecialchars($scout["name"]) ?>.</p>

<p style="margin-bottom:28px">
    Discover amazing destinations, plan unforgettable journeys, and explore the world. Your travel adventure starts here.
</p>

<div class="dash-actions">
    <a href="create_request.php" class="primary-btn">+ New Request</a>
    <a href="my_requests.php" class="secondary-btn">My Requests</a>
    <a href="approved_posts.php" class="secondary-btn">Approved Posts</a>
</div>

<div class="dash-cards">
    <div class="dash-card">
        <span class="icon">✍️</span>
        <h3>Create Request</h3>
        <p>Submit a new visiting place with its history, cost, and travel details.</p>
        <a href="create_request.php" class="primary-btn">Start</a>
    </div>

    <div class="dash-card">
        <span class="icon">📋</span>
        <h3>My Requests</h3>
        <p>View all your submissions. Edit or delete the ones still pending review.</p>
        <a href="my_requests.php" class="secondary-btn">View</a>
    </div>

    <div class="dash-card">
        <span class="icon">🌍</span>
        <h3>Approved Posts</h3>
        <p>See which of your submissions went live. Request changes if needed.</p>
        <a href="approved_posts.php" class="secondary-btn">View</a>
    </div>
</div>

<?php require_once "../layout/footer.php"; ?>
