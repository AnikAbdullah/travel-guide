<?php
$pageTitle  = 'My Wishlist — Travel Guide';
$pageScript = 'wishlist.js';
require __DIR__ . '/../partials/header.php';
?>

<div class="page-header">
  <div class="container">
    <h1>&#9825; My Wishlist</h1>
    <p>Destinations you've saved — your personal travel bucket list.</p>
  </div>
</div>

<div class="container" style="padding-bottom:3rem;">

  <div id="wishlistAlert" class="alert hidden" role="alert"></div>

  <?php if (empty($items)): ?>
    <div class="card" style="text-align:center;padding:4rem 2rem;">
      <div style="font-size:4rem;margin-bottom:1rem;">&#128564;</div>
      <h2 style="margin-bottom:.5rem;">Your wishlist is empty</h2>
      <p style="color:#64748b;margin-bottom:1.5rem;">Browse destinations and click <strong>&#9825; Save</strong> to add them here.</p>
      <a class="btn" href="<?= e($baseUrl) ?>/home">Explore Destinations</a>
    </div>

  <?php else: ?>

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;flex-wrap:wrap;gap:.5rem;">
      <p style="color:#64748b;font-size:.9rem;">
        You have <strong><?= count($items) ?></strong> saved destination<?= count($items) !== 1 ? 's' : '' ?>.
      </p>
      <a class="btn btn-outline btn-small" href="<?= e($baseUrl) ?>/home">+ Add More</a>
    </div>

    <div class="wishlist-table-wrap">
      <table class="wishlist-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Destination</th>
            <th>Country</th>
            <th>Cost Level</th>
            <th>Saved On</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="wishlistBody">
          <?php foreach ($items as $i => $item): ?>
            <tr data-post-id="<?= (int)$item['id'] ?>">
              <td style="color:#94a3b8;font-size:.85rem;"><?= $i + 1 ?></td>
              <td>
                <strong><?= e($item['title']) ?></strong>
              </td>
              <td>&#127757; <?= e($item['country']) ?></td>
              <td>
                <span class="cost-badge cost-<?= e($item['cost_level']) ?>">
                  <?= e(ucfirst($item['cost_level'])) ?>
                </span>
              </td>
              <td style="color:#64748b;font-size:.85rem;">
                <?= e(date('d M Y', strtotime($item['added_at']))) ?>
              </td>
              <td>
                <button type="button"
                        class="btn btn-danger btn-small wishlist-remove-btn"
                        data-post-id="<?= (int)$item['id'] ?>">
                  &#128465; Remove
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  <?php endif; ?>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
