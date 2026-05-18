<?php
$pageTitle  = 'My Profile — Travel Guide';
$pageScript = 'profile.js';
require __DIR__ . '/../partials/header.php';
$uploadUrl = rtrim($config['app']['upload_url'], '/');
$roleClass = 'role-' . ($user['role'] ?? 'user');
$roleLabel = ucfirst($user['role'] ?? 'user');
?>

<div class="page-header">
  <div class="container">
    <h1>&#128100; My Profile</h1>
    <p>Manage your account details and preferences.</p>
  </div>
</div>

<div class="container" style="padding-bottom:3rem;">

  <?php if (!empty($success)): ?>
    <div class="alert alert-success">&#10003; <?= e($success) ?></div>
  <?php endif; ?>

  <?php if (!is_verified_user()): ?>
    <div class="alert alert-warning">&#9888; Your account is pending admin approval. Some features are restricted.</div>
  <?php endif; ?>

  <div class="profile-wrap">

    <!-- Sidebar -->
    <aside class="profile-sidebar">
      <div class="avatar">
        <?php if (!empty($user['profile_picture'])): ?>
          <img src="<?= e($uploadUrl . '/' . $user['profile_picture']) ?>" alt="Profile picture">
        <?php else: ?>
          <?= e(strtoupper(substr($user['name'], 0, 1))) ?>
        <?php endif; ?>
      </div>
      <h2><?= e($user['name']) ?></h2>
      <span class="role-badge <?= e($roleClass) ?>"><?= e($roleLabel) ?></span>
      <div class="profile-meta">
        <div>&#9993; <?= e($user['email']) ?></div>
        <div>&#9989; <?= (int)$user['is_verified'] ? 'Verified' : 'Pending approval' ?></div>
        <div>&#128197; Joined <?= date('M Y', strtotime($user['created_at'])) ?></div>
      </div>
    </aside>

    <!-- Form -->
    <div>
      <form method="post" action="<?= e($baseUrl) ?>/profile" enctype="multipart/form-data" id="profileForm" novalidate>
        <?= csrf_field() ?>

        <div class="profile-form-card">
          <h2>&#9999; Personal Information</h2>

          <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="<?= e($user['name']) ?>" required>
            <?php if (!empty($errors['name'])): ?><span class="field-error"><?= e($errors['name']) ?></span><?php endif; ?>
            <span class="field-error" data-error-for="name"></span>
          </div>

          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="<?= e($user['email']) ?>" required>
            <?php if (!empty($errors['email'])): ?><span class="field-error"><?= e($errors['email']) ?></span><?php endif; ?>
            <span class="field-error" data-error-for="email"></span>
          </div>

          <div class="form-group">
            <label for="profile_picture">Profile Picture</label>
            <input type="file" id="profile_picture" name="profile_picture" accept="image/jpeg,image/png,image/webp">
            <small style="color:#64748b;font-size:.8rem;">JPG, PNG or WEBP — max 2 MB</small>
            <?php if (!empty($errors['profile_picture'])): ?><span class="field-error"><?= e($errors['profile_picture']) ?></span><?php endif; ?>
            <span class="field-error" data-error-for="profile_picture"></span>
          </div>
        </div>

        <div class="profile-form-card">
          <h2>&#128274; Change Password</h2>
          <p style="color:#64748b;font-size:.88rem;margin-bottom:1.25rem;">Leave blank if you don't want to change your password.</p>

          <fieldset class="password-fieldset" style="border:none;padding:0;margin:0;">
            <div class="form-group">
              <label for="current_password">Current Password</label>
              <input type="password" id="current_password" name="current_password" placeholder="Enter current password">
              <?php if (!empty($errors['current_password'])): ?><span class="field-error"><?= e($errors['current_password']) ?></span><?php endif; ?>
              <span class="field-error" data-error-for="current_password"></span>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
              <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" minlength="8" placeholder="Min. 8 chars">
                <?php if (!empty($errors['new_password'])): ?><span class="field-error"><?= e($errors['new_password']) ?></span><?php endif; ?>
                <span class="field-error" data-error-for="new_password"></span>
              </div>
              <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Repeat new password">
                <?php if (!empty($errors['confirm_password'])): ?><span class="field-error"><?= e($errors['confirm_password']) ?></span><?php endif; ?>
                <span class="field-error" data-error-for="confirm_password"></span>
              </div>
            </div>
          </fieldset>
        </div>

        <button type="submit" class="btn btn-lg">&#10003; Save Changes</button>
      </form>
    </div>

  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
