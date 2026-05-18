<?php
$pageTitle = 'Home - Travel Guide';
$pageScript = 'wishlist.js';
require __DIR__ . '/../partials/header.php';
?>

<?php if (!is_logged_in()): ?>
  <!-- Guest hero -->
  <section class="hero">
    <h1>Discover Your Next Adventure</h1>
    <p>Travel Guide helps visitors from around the world find amazing places to visit. Browse destinations, read travel stories, and plan your next trip.</p>
    <div class="hero-actions">
      <a class="btn" href="<?= e($baseUrl) ?>/register">Get Started — It's Free</a>
      <a class="btn btn-outline" href="<?= e($baseUrl) ?>/login">Sign In</a>
    </div>
  </section>

  <section class="features-section">
    <div class="feature-grid">
      <div class="feature-card">
        <span class="feature-icon">&#127758;</span>
        <h3>Worldwide Destinations</h3>
        <p>Explore curated travel posts covering beaches, mountains, cities, and historical sites across the globe.</p>
      </div>
      <div class="feature-card">
        <span class="feature-icon">&#9825;</span>
        <h3>Personal Wishlist</h3>
        <p>Save your favourite destinations to a personal checklist and plan your trips at your own pace.</p>
      </div>
      <div class="feature-card">
        <span class="feature-icon">&#128176;</span>
        <h3>Cost Estimates</h3>
        <p>Get probable cost information for each destination so you can budget your travels effectively.</p>
      </div>
    </div>
  </section>

<?php elseif (!is_verified_user()): ?>
  <!-- Logged in but not verified -->
  <section class="hero">
    <h1>Hello, <?= e($_SESSION['name']) ?>!</h1>
    <div class="alert alert-warning">
      <strong>Account Pending Approval</strong><br>
      Your account is awaiting admin verification. You will have full access to all features once approved.
    </div>
    <p>In the meantime, feel free to update your <a href="<?= e($baseUrl) ?>/profile">profile</a>.</p>
  </section>

<?php else: ?>
  <!-- Verified user -->
  <section class="hero hero-compact">
    <h1>Welcome back, <?= e($_SESSION['name']) ?>!</h1>
    <p>Here are the latest approved travel destinations. <a href="<?= e($baseUrl) ?>/posts">Browse all posts &rarr;</a></p>
  </section>

  <section class="posts-section">
    <div class="section-header">
      <h2>Latest Destinations</h2>
      <a class="btn btn-outline btn-small" href="<?= e($baseUrl) ?>/posts">View All</a>
    </div>

    <div id="wishlistAlert" class="alert hidden" role="alert"></div>

    <?php if (empty($posts)): ?>
      <p class="empty-state">No approved posts yet. Check back soon!</p>
    <?php else: ?>
      <div class="post-grid">
        <?php foreach ($posts as $post): ?>
          <article class="post-card" data-post-id="<?= (int) $post['id'] ?>">
            <div class="post-card-body">
              <span class="tag"><?= e(ucfirst($post['genre'])) ?></span>
              <h3><?= e($post['title']) ?></h3>
              <p class="meta">
                <span>&#127757; <?= e($post['country']) ?></span>
                &middot;
                <span class="cost-badge cost-<?= e($post['cost_level']) ?>"><?= e(ucfirst($post['cost_level'])) ?> cost</span>
              </p>
              <p><?= e(mb_strimwidth($post['short_history'], 0, 130, '…')) ?></p>
            </div>
            <div class="post-card-footer">
              <a class="btn btn-outline btn-small" href="<?= e($baseUrl) ?>/posts/<?= (int) $post['id'] ?>">Read More</a>
              <?php if (current_user_role() === 'user'): ?>
                <button type="button"
                        class="btn btn-small wishlist-add-btn"
                        data-post-id="<?= (int) $post['id'] ?>"
                        aria-label="Add <?= e($post['title']) ?> to wishlist">
                  &#9825; Wishlist
                </button>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
<?php endif; ?>

<?php require __DIR__ . '/../partials/footer.php'; ?>
