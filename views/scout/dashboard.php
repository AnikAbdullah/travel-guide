<?php

require_once "../../controllers/ScoutController.php";

// $scout = scoutOnly();
$currentPage = "dashboard";
$pageTitle   = "Scout Dashboard";

// Temp bypass — remove once auth (Task 1) is merged
$scout = ["name" => "Test Scout"];

require_once "../layout/header.php";

?>

<section class="dashboard-hero">
    <div class="hero-content">
        <span class="section-label">Scout Dashboard</span>

        <h2>Welcome back, <?php echo htmlspecialchars($scout["name"]); ?></h2>

        <p>
            Discover visiting places, document their history and details,
            then submit them for admin review. Track all your submissions
            and request changes to published posts — right from here.
        </p>

        <div class="hero-actions">
            <a href="create_request.php" class="primary-btn">+ New Post Request</a>
            <a href="my_requests.php"    class="secondary-btn">My Requests</a>
        </div>

        <div class="genre-tags">
            <span>🏖️ Beach</span>
            <span>🏔️ Mountain</span>
            <span>🏙️ City</span>
            <span>🏛️ Historical</span>
            <span>🌿 Nature</span>
            <span>⛺ Adventure</span>
            <span>🛕 Religious</span>
        </div>
    </div>

    <div class="hero-card">
        <span class="hero-icon">🧭</span>
        <h3>Scout Workflow</h3>
        <ul class="hero-steps">
            <li>
                <span class="step-icon">📍</span>
                Discover a place
            </li>
            <li>
                <span class="step-icon">✍️</span>
                Document details
            </li>
            <li>
                <span class="step-icon">📤</span>
                Submit for review
            </li>
            <li>
                <span class="step-icon">🌐</span>
                Goes live on approval
            </li>
        </ul>
    </div>
</section>

<section class="dashboard-grid">

    <div class="dashboard-card">
        <div class="card-image beach-theme">
            <span>🗺️</span>
        </div>
        <div class="card-content">
            <h3>Create Post Request</h3>
            <p>
                Document a new visiting place — its history, cultural significance,
                genre, cost level, travel medium, and an optional image.
            </p>
            <a href="create_request.php" class="card-btn orange-btn">+ Create Request</a>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-image nature-theme">
            <span>📍</span>
        </div>
        <div class="card-content">
            <h3>My Requests</h3>
            <p>
                View every post request you have submitted. Edit or delete
                pending ones, and track the admin review status of each.
            </p>
            <a href="my_requests.php" class="card-btn green-btn">View Requests</a>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-image city-theme">
            <span>🌐</span>
        </div>
        <div class="card-content">
            <h3>Approved Posts</h3>
            <p>
                Browse posts that went live from your submissions.
                You can also raise a change request if the published
                details need an update.
            </p>
            <a href="approved_posts.php" class="card-btn blue-btn">View Published</a>
        </div>
    </div>

</section>

<section class="responsibility-box">
    <h3>Scout Responsibility</h3>
    <p>
        A Scout collects accurate place information — short history, cultural significance,
        genre, cost level, and travel medium details. Every submitted request is reviewed
        by an admin before it becomes a published post on the platform.
    </p>
</section>

<?php require_once "../layout/footer.php"; ?>
