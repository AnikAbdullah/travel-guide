<?php

require_once "../../config/db.php";
require_once "../../helpers/auth.php";

bootSession();

function e($value)
{
    return htmlspecialchars($value ?? "");
}

$pageTitle   = "Home";
$currentPage = "home";

$isLoggedIn = isset($_SESSION["user_id"]);
$isVerified = (int) ($_SESSION["is_verified"] ?? 0) === 1;
$role       = $_SESSION["role"] ?? "";
$name       = $_SESSION["name"] ?? "";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= e($pageTitle) ?> | Travel Guide</title>
    <link rel="stylesheet" href="../../public/css/auth.css">
</head>
<body>

<?php require_once "../partials/navbar.php"; ?>
s
<main class="home-container">
    <?php if (!$isLoggedIn): ?>
        <h2>Welcome to Travel Guide</h2>
        <p>Discover places worldwide. <a href="../auth/register.php">Register</a> or <a href="../auth/login.php">log in</a> to get started.</p>
    <?php elseif (!$isVerified): ?>
        <h2>Hello, <?= e($name) ?></h2>
        <div class="alert alert-info">Your account is pending admin approval. You will be able to access full features once verified.</div>
    <?php else: ?>
        <h2>Hello, <?= e($name) ?></h2>
        <p>Browse the latest places below.</p>
        <!-- TODO commit 2: pull latest approved posts via getLatestApprovedPosts($conn) and render cards -->
    <?php endif; ?>
</main>

</body>
</html>