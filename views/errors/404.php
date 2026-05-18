<?php
$pageTitle = '404 — Page Not Found';
require __DIR__ . '/../partials/header.php';
?>
<div class="container">
  <div class="error-page">
    <div class="error-code">404</div>
    <h2>Oops — Page Not Found</h2>
    <p>The page you're looking for doesn't exist or has been moved.</p>
    <a class="btn btn-lg" href="<?= e($baseUrl) ?>/home">&#8592; Back to Home</a>
  </div>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
