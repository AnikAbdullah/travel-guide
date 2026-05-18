<?php
$pageTitle  = 'TravelGuide — Discover the World';
$pageScript = 'wishlist.js';
require __DIR__ . '/../partials/header.php';
?>

<?php if (!is_logged_in()): ?>

<section class="hero-banner">
  <div class="container">
    <div class="hero-eyebrow anim-up">✈ Your World Awaits</div>
    <h1 class="anim-up-2">Discover Your Next<br><span class="highlight">Great Adventure</span></h1>
    <p class="anim-up-3">Explore curated destinations worldwide — beaches, mountains, cities, and hidden gems. Plan smarter, travel better.</p>
    <div class="hero-actions anim-up-4">
      <a class="btn btn-accent btn-lg" href="<?= e($baseUrl) ?>/register">🚀 Get Started Free</a>
      <a class="btn btn-white btn-lg"  href="<?= e($baseUrl) ?>/login">Sign In</a>
    </div>
    <div class="hero-stats anim-up-4">
      <div class="hero-stat"><strong>500+</strong><span>Destinations</span></div>
      <div class="hero-stat"><strong>50+</strong><span>Countries</span></div>
      <div class="hero-stat"><strong>1K+</strong><span>Travellers</span></div>
    </div>
  </div>
</section>

<section class="features-section">
  <div class="container">
    <div class="section-title">
      <h2>Everything You Need to Travel Smart</h2>
      <p>From discovery to planning — we've got you covered.</p>
      <div class="line"></div>
    </div>
    <div class="feature-grid">
      <div class="feature-card anim-up">
        <div class="feature-icon-wrap">🌍</div>
        <h3>Worldwide Destinations</h3>
        <p>Curated posts covering beaches, mountains, cities, and historical sites across the globe.</p>
      </div>
      <div class="feature-card anim-up-2">
        <div class="feature-icon-wrap">♡</div>
        <h3>Personal Wishlist</h3>
        <p>Save your favourite destinations and build your dream travel checklist at your own pace.</p>
      </div>
      <div class="feature-card anim-up-3">
        <div class="feature-icon-wrap">💰</div>
        <h3>Cost Estimates</h3>
        <p>Get realistic cost breakdowns per destination so you can budget your trips effectively.</p>
      </div>
      <div class="feature-card anim-up-4">
        <div class="feature-icon-wrap">🔍</div>
        <h3>Smart Search</h3>
        <p>Filter by country, genre, and cost level to find exactly the destination you're looking for.</p>
      </div>
    </div>
  </div>
</section>

<section class="how-section">
  <div class="container">
    <div class="section-title" style="color:#fff">
      <h2 style="color:#fff">How It Works</h2>
      <p style="color:#94a3b8">Get started in three simple steps.</p>
      <div class="line"></div>
    </div>
    <div class="how-grid">
      <div class="how-step anim-up">
        <div class="how-num">1</div>
        <h3>Create Account</h3>
        <p>Register as a General User, Scout, or Admin in under a minute.</p>
      </div>
      <div class="how-step anim-up-2">
        <div class="how-num">2</div>
        <h3>Browse Destinations</h3>
        <p>Explore approved travel posts filtered by country, genre, and budget.</p>
      </div>
      <div class="how-step anim-up-3">
        <div class="how-num">3</div>
        <h3>Save & Plan</h3>
        <p>Add destinations to your wishlist and get cost estimates for your trip.</p>
      </div>
    </div>
  </div>
</section>

<?php elseif (!is_verified_user()): ?>

<div class="container" style="padding:2rem 0 4rem">
  <div class="pending-banner">
    <div class="pending-icon">⏳</div>
    <h2>Account Pending Approval</h2>
    <p>Hi <strong><?= e($_SESSION['name']) ?></strong>! Your account is awaiting admin verification.<br>
       You'll get full access to all features once approved.</p>
    <br>
    <a class="btn btn-accent" href="<?= e($baseUrl) ?>/profile">Update Your Profile</a>
  </div>
</div>

<?php else: ?>

<div class="container" style="padding:2rem 0 4rem">
  <div class="welcome-strip anim-up">
    <div>
      <h1>Welcome back, <?= e($_SESSION['name']) ?>! 👋</h1>
      <p>Here are the latest approved travel destinations just for you.</p>
    </div>
    <a class="btn btn-white" href="<?= e($baseUrl) ?>/posts">Browse All Posts →</a>
  </div>

  <div id="wishlistAlert" class="alert hidden" role="alert"></div>

  <div class="section-header">
    <h2>🌍 Latest Destinations</h2>
    <a class="btn btn-outline btn-small" href="<?= e($baseUrl) ?>/posts">View All</a>
  </div>

  <?php if (empty($posts)): ?>
    <p class="empty-state">😴 No approved posts yet — check back soon!</p>
  <?php else: ?>
    <div class="post-grid">
      <?php
      $genreIcons = ['beach'=>'🏖','mountain'=>'⛰','city'=>'🏙','historical'=>'🏛','adventure'=>'🧗','religious'=>'⛩','nature'=>'🌿','other'=>'🌍'];
      $gradients  = [
        'beach'     =>'linear-gradient(135deg,#0c4a6e,#0ea5e9)',
        'mountain'  =>'linear-gradient(135deg,#1e3a5f,#3b82f6)',
        'city'      =>'linear-gradient(135deg,#1e293b,#475569)',
        'historical'=>'linear-gradient(135deg,#451a03,#92400e)',
        'adventure' =>'linear-gradient(135deg,#14532d,#16a34a)',
        'religious' =>'linear-gradient(135deg,#3b0764,#7c3aed)',
        'nature'    =>'linear-gradient(135deg,#052e16,#059669)',
        'other'     =>'linear-gradient(135deg,#0c4a6e,#0ea5e9)',
      ];
      foreach ($posts as $post):
        $g = strtolower($post['genre']);
        $icon = $genreIcons[$g] ?? '🌍';
        $grad = $gradients[$g] ?? $gradients['other'];
      ?>
        <article class="post-card anim-up">
          <div class="post-card-img">
            <div class="post-card-img-bg" style="background:<?= $grad ?>"></div>
            <span><?= $icon ?></span>
          </div>
          <div class="post-card-body">
            <span class="tag"><?= e(ucfirst($post['genre'])) ?></span>
            <h3><?= e($post['title']) ?></h3>
            <p class="meta">
              🌐 <?= e($post['country']) ?> &nbsp;·&nbsp;
              <span class="cost-badge cost-<?= e($post['cost_level']) ?>"><?= e(ucfirst($post['cost_level'])) ?> cost</span>
            </p>
            <p style="color:#64748b;font-size:.85rem;line-height:1.6"><?= e(mb_strimwidth($post['short_history'], 0, 110, '…')) ?></p>
          </div>
          <div class="post-card-footer">
            <a class="btn btn-outline btn-small" href="<?= e($baseUrl) ?>/posts/<?= (int)$post['id'] ?>">Read More</a>
            <?php if (current_user_role() === 'user'): ?>
              <button type="button" class="btn btn-small wishlist-add-btn"
                      data-post-id="<?= (int)$post['id'] ?>"
                      aria-label="Add to wishlist">♡ Save</button>
            <?php endif; ?>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php endif; ?>

<?php require __DIR__ . '/../partials/footer.php'; ?>
