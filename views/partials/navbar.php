<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_navUserId = $_SESSION["user_id"] ?? null;
$_navRole   = $_SESSION["role"] ?? "";
$_navName   = $_SESSION["name"] ?? "";
?>
<nav class="site-nav">
    <div class="nav-brand">
        <a href="../home/index.php">🌍 Travel Guide</a>
    </div>
    <div class="nav-links">
        <a href="../home/index.php">Home</a>
        <?php if ($_navUserId): ?>
            <?php if ($_navRole === "scout"): ?>
                <a href="../scout/dashboard.php">Scout</a>
            <?php endif; ?>
            <a href="../wishlist/index.php">Wishlist</a>
            <a href="../profile/index.php">Profile</a>
            <a href="../auth/logout.php">Logout (<?= htmlspecialchars($_navName) ?>)</a>
        <?php else: ?>
            <a href="../auth/login.php">Login</a>
            <a href="../auth/register.php">Register</a>
        <?php endif; ?>
    </div>
</nav>
