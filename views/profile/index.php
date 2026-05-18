<?php
$pageTitle = 'Profile - Travel Guide';
$pageScript = 'profile.js';
require __DIR__ . '/../partials/header.php';
$uploadUrl = rtrim($config['app']['upload_url'], '/');
?>

<section class="profile-card">
  <h1>My Profile</h1>

  <?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= e($success) ?></div>
  <?php endif; ?>

  <?php if (!is_verified_user()): ?>
    <div class="alert alert-warning">Your account is pending admin approval.</div>
  <?php endif; ?>

  <form method="post" action="<?= e($baseUrl) ?>/profile" enctype="multipart/form-data" id="profileForm" novalidate>
    <?= csrf_field() ?>
    <div class="profile-header">
      <div class="avatar">
        <?php if (!empty($user['profile_picture'])): ?>
          <img src="<?= e($uploadUrl . '/' . $user['profile_picture']) ?>" alt="Profile picture">
        <?php else: ?>
          <span><?= e(strtoupper(substr($user['name'], 0, 1))) ?></span>
        <?php endif; ?>
      </div>
      <div>
        <p><strong>Role:</strong> <?= e(ucfirst($user['role'])) ?></p>
        <p><strong>Status:</strong> <?= (int) $user['is_verified'] ? 'Verified' : 'Pending approval' ?></p>
      </div>
    </div>

    <div class="form-group">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" value="<?= e($user['name']) ?>" required>
      <?php if (!empty($errors['name'])): ?><span class="field-error"><?= e($errors['name']) ?></span><?php endif; ?>
      <span class="field-error" data-error-for="name"></span>
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?= e($user['email']) ?>" required>
      <?php if (!empty($errors['email'])): ?><span class="field-error"><?= e($errors['email']) ?></span><?php endif; ?>
      <span class="field-error" data-error-for="email"></span>
    </div>

    <div class="form-group">
      <label for="profile_picture">Profile Picture</label>
      <input type="file" id="profile_picture" name="profile_picture" accept="image/jpeg,image/png,image/webp">
      <?php if (!empty($errors['profile_picture'])): ?><span class="field-error"><?= e($errors['profile_picture']) ?></span><?php endif; ?>
      <span class="field-error" data-error-for="profile_picture"></span>
    </div>

    <fieldset class="password-fieldset">
      <legend>Change Password (optional)</legend>
      <div class="form-group">
        <label for="current_password">Current Password</label>
        <input type="password" id="current_password" name="current_password">
        <?php if (!empty($errors['current_password'])): ?><span class="field-error"><?= e($errors['current_password']) ?></span><?php endif; ?>
        <span class="field-error" data-error-for="current_password"></span>
      </div>
      <div class="form-group">
        <label for="new_password">New Password</label>
        <input type="password" id="new_password" name="new_password" minlength="8">
        <?php if (!empty($errors['new_password'])): ?><span class="field-error"><?= e($errors['new_password']) ?></span><?php endif; ?>
        <span class="field-error" data-error-for="new_password"></span>
      </div>
      <div class="form-group">
        <label for="confirm_password">Confirm New Password</label>
        <input type="password" id="confirm_password" name="confirm_password">
        <?php if (!empty($errors['confirm_password'])): ?><span class="field-error"><?= e($errors['confirm_password']) ?></span><?php endif; ?>
        <span class="field-error" data-error-for="confirm_password"></span>
      </div>
    </fieldset>

    <button type="submit" class="btn">Save Profile</button>
  </form>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
