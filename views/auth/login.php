<?php
$pageTitle  = 'Sign In — Travel Guide';
$pageScript = 'auth.js';
require __DIR__ . '/../partials/header.php';
?>

<div class="auth-wrap">
  <div class="auth-card">

    <div class="auth-logo">
      <div class="auth-logo-icon">&#9992;</div>
      <h1>Welcome Back</h1>
      <p class="subtitle">Sign in to explore destinations worldwide.</p>
    </div>

    <?php if ($success = flash('success')): ?>
      <div class="alert alert-success">&#10003; <?= e($success) ?></div>
    <?php endif; ?>
    <?php if ($warning = flash('warning')): ?>
      <div class="alert alert-warning">&#9888; <?= e($warning) ?></div>
    <?php endif; ?>
    <?php if ($error = flash('error')): ?>
      <div class="alert alert-error">&#10007; <?= e($error) ?></div>
    <?php endif; ?>
    <?php if (!empty($errors['general'])): ?>
      <div class="alert alert-error">&#10007; <?= e($errors['general']) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= e($baseUrl) ?>/login" id="loginForm" novalidate>
      <?= csrf_field() ?>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="<?= e($old['email']) ?>" placeholder="you@example.com" required>
        <?php if (!empty($errors['email'])): ?><span class="field-error"><?= e($errors['email']) ?></span><?php endif; ?>
        <span class="field-error" data-error-for="email"></span>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="••••••••" required>
        <?php if (!empty($errors['password'])): ?><span class="field-error"><?= e($errors['password']) ?></span><?php endif; ?>
        <span class="field-error" data-error-for="password"></span>
      </div>

      <label class="checkbox-row">
        <input type="checkbox" name="remember_me" value="1">
        Keep me signed in for 30 days
      </label>

      <button type="submit" class="btn" style="width:100%;justify-content:center;">Sign In &rarr;</button>
    </form>

    <p class="form-footer">Don't have an account? <a href="<?= e($baseUrl) ?>/register">Create one free</a></p>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
