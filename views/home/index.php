<?php
$pageTitle = 'Home - Travel Guide';
$pageScript = 'wishlist.js';
require __DIR__ . '/../partials/header.php';
?>

<section class="hero">
  <?php if (!is_logged_in()): ?>
    <h1>Discover Your Next Adventure</h1>
    <p>Travel Guide helps visitors from around the world find amazing places to visit.</p>
    <div class="hero-actions">
      <a class="btn" href="<?= e($baseUrl) ?>/register">Get Started</a>
      <a class="btn btn-outline" href="<?= e($baseUrl) ?>/login">Login</a>
    </div>
  <?php elseif (!is_verified_user()): ?>
    <h1>Hello, <?= e($_SESSION['name']) ?>!</h1>
    <div class="alert alert-warning">Your account is pending admin approval. Detailed site features will be available once verified.</div>
  <?php else: ?>
    <h1>Welcome, <?= e($_SESSION['name']) ?>!</h1>
    <p>Explore the latest approved travel destinations below.</p>
    <a class="text-link" href="#">Browse all posts (Task 4)</a>
  <?php endif; ?>
</section>

<?php if (is_verified_user()): ?>
  <section class="posts-section">
    <h2>Latest Approved Posts</h2>
    <?php if (empty($posts)): ?>
      <p class="empty-state">No approved posts yet. Check back soon.</p>
    <?php else: ?>
      <div class="post-grid">
        <?php foreach ($posts as $post): ?>
          <article class="post-card" data-post-id="<?= (int) $post['id'] ?>">
            <div class="post-card-body">
              <span class="tag"><?= e(ucfirst($post['genre'])) ?></span>
              <h3><?= e($post['title']) ?></h3>
              <p class="meta"><?= e($post['country']) ?> &middot; <?= e(ucfirst($post['cost_level'])) ?> cost</p>
              <p><?= e(mb_strimwidth($post['short_history'], 0, 120, '...')) ?></p>
            </div>
            <?php if (current_user_role() === 'user'): ?>
              <button type="button" class="btn btn-small wishlist-add-btn" data-post-id="<?= (int) $post['id'] ?>">
                Add to Wishlist
              </button>
            <?php endif; ?>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
<?php endif; ?>

<?php require __DIR__ . '/../partials/footer.php'; ?>
