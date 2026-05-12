<?php

$currentPage = "";
$pageTitle   = "Access Denied";

require_once "../layout/header.php";

?>

<section class="forbidden-section">
    <span class="forbidden-icon">🔒</span>

    <h2>Access Denied</h2>

    <p>
        This page is restricted to verified scouts only.
        Please log in with a scout account or contact an admin
        to verify your account.
    </p>

    <a href="../auth/login.php" class="primary-btn">Go to Login</a>
</section>

<?php require_once "../layout/footer.php"; ?>
