<?php
$config = app_config();
$baseUrl = rtrim($config['app']['base_url'], '/');
$role = current_user_role();
$verified = is_verified_user();
?>
<nav class="navbar">
  <div class="container navbar-inner">
    <a class="brand" href="<?= e($baseUrl) ?>/home">Travel Guide</a>
    <ul class="nav-links">
      <li><a href="<?= e($baseUrl) ?>/home">Home</a></li>
      <?php if (is_logged_in()): ?>
        <li><a href="<?= e($baseUrl) ?>/profile">Profile</a></li>
        <?php if ($verified && $role === 'user'): ?>
          <li><a href="<?= e($baseUrl) ?>/wishlist">Wishlist</a></li>
        <?php endif; ?>
        <?php if ($role === 'scout' && $verified): ?>
          <li><span class="nav-badge">Scout</span></li>
        <?php endif; ?>
        <?php if ($role === 'admin' && $verified): ?>
          <li><span class="nav-badge admin">Admin</span></li>
        <?php endif; ?>
        <li><a href="<?= e($baseUrl) ?>/logout">Logout</a></li>
      <?php else: ?>
        <li><a href="<?= e($baseUrl) ?>/login">Login</a></li>
        <li><a class="btn btn-small" href="<?= e($baseUrl) ?>/register">Register</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
