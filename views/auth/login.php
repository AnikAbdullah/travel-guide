<?php
$pageTitle = 'Login - Travel Guide';
$pageScript = 'auth.js';
require __DIR__ . '/../partials/header.php';
?>

<section class="auth-card">
  <h1>Welcome Back</h1>
  <p class="subtitle">Sign in to explore destinations worldwide.</p>

  <?php if ($success = flash('success')): ?>
    <div class="alert alert-success"><?= e($success) ?></div>
  <?php endif; ?>
  <?php if ($warning = flash('warning')): ?>
    <div class="alert alert-warning"><?= e($warning) ?></div>
  <?php endif; ?>
  <?php if ($error = flash('error')): ?>
    <div class="alert alert-error"><?= e($error) ?></div>
  <?php endif; ?>
  <?php if (!empty($errors['general'])): ?>
    <div class="alert alert-error"><?= e($errors['general']) ?></div>
  <?php endif; ?>

  <form method="post" action="<?= e($baseUrl) ?>/login" id="loginForm" novalidate>
    <?= csrf_field() ?>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?= e($old['email']) ?>" required>
      <?php if (!empty($errors['email'])): ?><span class="field-error"><?= e($errors['email']) ?></span><?php endif; ?>
      <span class="field-error" data-error-for="email"></span>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
      <?php if (!empty($errors['password'])): ?><span class="field-error"><?= e($errors['password']) ?></span><?php endif; ?>
      <span class="field-error" data-error-for="password"></span>
    </div>

    <label class="checkbox-row">
      <input type="checkbox" name="remember_me" value="1">
      Remember Me for 30 days
    </label>

    <button type="submit" class="btn">Login</button>
  </form>

  <p class="form-footer">New here? <a href="<?= e($baseUrl) ?>/register">Create an account</a></p>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
