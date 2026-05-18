<?php
$config = app_config();
$baseUrl = rtrim($config['app']['base_url'], '/');
$role = current_user_role();
$verified = is_verified_user();
?>
<nav class="navbar">
  <div class="container navbar-inner">
    <a class="brand" href="<?= e($baseUrl) ?>/home">&#9992; Travel Guide</a>
    <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation" aria-expanded="false">&#9776;</button>
    <ul class="nav-links" id="navLinks">
      <li><a href="<?= e($baseUrl) ?>/home">Home</a></li>

      <?php if (is_logged_in()): ?>

        <?php if ($verified): ?>
          <li><a href="<?= e($baseUrl) ?>/posts">Browse Posts</a></li>
        <?php endif; ?>

        <?php if ($verified && $role === 'user'): ?>
          <li><a href="<?= e($baseUrl) ?>/wishlist">&#9825; Wishlist</a></li>
        <?php endif; ?>

        <?php if ($role === 'scout' && $verified): ?>
          <li><a href="<?= e($baseUrl) ?>/scout/requests">My Requests</a></li>
          <li><span class="nav-badge scout">Scout</span></li>
        <?php endif; ?>

        <?php if ($role === 'admin'): ?>
          <li><a href="<?= e($baseUrl) ?>/admin">Dashboard</a></li>
          <li><span class="nav-badge admin">Admin</span></li>
        <?php endif; ?>

        <li><a href="<?= e($baseUrl) ?>/profile">Profile</a></li>
        <li><a href="<?= e($baseUrl) ?>/logout" class="nav-logout">Logout</a></li>

      <?php else: ?>
        <li><a href="<?= e($baseUrl) ?>/login">Login</a></li>
        <li><a class="btn btn-small" href="<?= e($baseUrl) ?>/register">Register</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
<script>
  (function () {
    var toggle = document.getElementById('navToggle');
    var links = document.getElementById('navLinks');
    if (toggle && links) {
      toggle.addEventListener('click', function () {
        var open = links.classList.toggle('open');
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      });
    }
  })();
</script>
