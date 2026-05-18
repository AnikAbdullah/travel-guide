<?php
$pageTitle = 'Register - Travel Guide';
$pageScript = 'auth.js';
require __DIR__ . '/../partials/header.php';
?>

<section class="auth-card">
  <h1>Create Account</h1>
  <p class="subtitle">Register as Admin, Scout, or General User.</p>

  <?php if (!empty($errors['general'])): ?>
    <div class="alert alert-error"><?= e($errors['general']) ?></div>
  <?php endif; ?>

  <form method="post" action="<?= e($baseUrl) ?>/register" id="registerForm" novalidate>
    <div class="form-group">
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" value="<?= e($old['name']) ?>" required>
      <?php if (!empty($errors['name'])): ?><span class="field-error"><?= e($errors['name']) ?></span><?php endif; ?>
      <span class="field-error" data-error-for="name"></span>
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?= e($old['email']) ?>" required>
      <?php if (!empty($errors['email'])): ?><span class="field-error"><?= e($errors['email']) ?></span><?php endif; ?>
      <span class="field-error" data-error-for="email"></span>
    </div>

    <div class="form-group">
      <label for="role">Role</label>
      <select id="role" name="role" required>
        <option value="user" <?= $old['role'] === 'user' ? 'selected' : '' ?>>General User</option>
        <option value="scout" <?= $old['role'] === 'scout' ? 'selected' : '' ?>>Scout</option>
        <option value="admin" <?= $old['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
      </select>
      <?php if (!empty($errors['role'])): ?><span class="field-error"><?= e($errors['role']) ?></span><?php endif; ?>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" minlength="8" required>
      <?php if (!empty($errors['password'])): ?><span class="field-error"><?= e($errors['password']) ?></span><?php endif; ?>
      <span class="field-error" data-error-for="password"></span>
    </div>

    <div class="form-group">
      <label for="confirm_password">Confirm Password</label>
      <input type="password" id="confirm_password" name="confirm_password" required>
      <?php if (!empty($errors['confirm_password'])): ?><span class="field-error"><?= e($errors['confirm_password']) ?></span><?php endif; ?>
      <span class="field-error" data-error-for="confirm_password"></span>
    </div>

    <button type="submit" class="btn">Register</button>
  </form>

  <p class="form-footer">Already have an account? <a href="<?= e($baseUrl) ?>/login">Log in</a></p>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
