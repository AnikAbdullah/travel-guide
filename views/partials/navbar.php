<?php
// Expect bootSession() already called by parent view.
$navRole       = $_SESSION["role"] ?? "";
$navLoggedIn   = isset($_SESSION["user_id"]);
$navIsVerified = (int) ($_SESSION["is_verified"] ?? 0) === 1;
?>
<nav class="site-nav">
    <a href="../home/index.php" class="nav-brand">🌍 Travel Guide</a>

    <div class="nav-links">
        <a href="../home/index.php">Home</a>

        <?php if (!$navLoggedIn): ?>
            <a href="../auth/login.php">Login</a>
            <a href="../auth/register.php">Register</a>
        <?php else: ?>
            <?php if ($navRole === "scout" && $navIsVerified): ?>
                <a href="../scout/dashboard.php">Scout Dashboard</a>
            <?php endif; ?>
            <?php if ($navRole === "user" && $navIsVerified): ?>
                <a href="../wishlist/index.php">Wishlist</a>
            <?php endif; ?>
            <a href="../profile/profile.php">Profile</a>
            <a href="../auth/logout.php">Logout</a>
        <?php endif; ?>
    </div>
</nav>