<?php
$pageTitle = '404 – Page Not Found';
require __DIR__ . '/../partials/header.php';
?>
<section class="hero" style="text-align:center;">
  <h1>404</h1>
  <p style="font-size:1.2rem; color:#64748b;">Oops — we couldn't find that page.</p>
  <a class="btn" href="<?= e($baseUrl) ?>/home">Go Home</a>
</section>
<?php require __DIR__ . '/../partials/footer.php'; ?>
