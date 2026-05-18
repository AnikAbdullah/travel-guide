<?php
$pageTitle  = 'Create Account — Travel Guide';
$pageScript = 'auth.js';
require __DIR__ . '/../partials/header.php';
?>

<div class="auth-wrap">
  <div class="auth-card">

    <div class="auth-logo">
      <div class="auth-logo-icon">&#127758;</div>
      <h1>Create Account</h1>
      <p class="subtitle">Join thousands of travellers worldwide.</p>
    </div>

    <?php if (!empty($errors['general'])): ?>
      <div class="alert alert-error">&#10007; <?= e($errors['general']) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= e($baseUrl) ?>/register" id="registerForm" novalidate>
      <?= csrf_field() ?>

      <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" value="<?= e($old['name']) ?>" placeholder="John Doe" required>
        <?php if (!empty($errors['name'])): ?><span class="field-error"><?= e($errors['name']) ?></span><?php endif; ?>
        <span class="field-error" data-error-for="name"></span>
      </div>

      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="<?= e($old['email']) ?>" placeholder="you@example.com" required>
        <?php if (!empty($errors['email'])): ?><span class="field-error"><?= e($errors['email']) ?></span><?php endif; ?>
        <span class="field-error" data-error-for="email"></span>
      </div>

      <div class="form-group">
        <label for="role">I am a</label>
        <select id="role" name="role" required>
          <option value="user"  <?= $old['role'] === 'user'  ? 'selected' : '' ?>>&#128100; General User</option>
          <option value="scout" <?= $old['role'] === 'scout' ? 'selected' : '' ?>>&#128269; Scout</option>
          <option value="admin" <?= $old['role'] === 'admin' ? 'selected' : '' ?>>&#9881; Admin</option>
        </select>
        <?php if (!empty($errors['role'])): ?><span class="field-error"><?= e($errors['role']) ?></span><?php endif; ?>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" minlength="8" placeholder="Min. 8 characters" required>
        <?php if (!empty($errors['password'])): ?><span class="field-error"><?= e($errors['password']) ?></span><?php endif; ?>
        <span class="field-error" data-error-for="password"></span>
      </div>

      <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Repeat password" required>
        <?php if (!empty($errors['confirm_password'])): ?><span class="field-error"><?= e($errors['confirm_password']) ?></span><?php endif; ?>
        <span class="field-error" data-error-for="confirm_password"></span>
      </div>

      <button type="submit" class="btn" style="width:100%;justify-content:center;">Create My Account &rarr;</button>
    </form>

    <p class="form-footer">Already have an account? <a href="<?= e($baseUrl) ?>/login">Sign in</a></p>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
