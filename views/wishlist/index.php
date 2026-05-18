<?php
$pageTitle = 'Wishlist - Travel Guide';
$pageScript = 'wishlist.js';
require __DIR__ . '/../partials/header.php';
?>

<section class="wishlist-section">
  <h1>My Wishlist</h1>
  <p class="subtitle">Saved destinations you want to visit.</p>

  <div id="wishlistAlert" class="alert hidden" role="alert"></div>

  <?php if (empty($items)): ?>
    <p class="empty-state">Your wishlist is empty. Add posts from the home page.</p>
  <?php else: ?>
    <div class="wishlist-table-wrap">
      <table class="wishlist-table">
        <thead>
          <tr>
            <th>Title</th>
            <th>Country</th>
            <th>Cost Level</th>
            <th>Added</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="wishlistBody">
          <?php foreach ($items as $item): ?>
            <tr data-post-id="<?= (int) $item['id'] ?>">
              <td><?= e($item['title']) ?></td>
              <td><?= e($item['country']) ?></td>
              <td><?= e(ucfirst($item['cost_level'])) ?></td>
              <td><?= e(date('M j, Y', strtotime($item['added_at']))) ?></td>
              <td>
                <button type="button" class="btn btn-danger btn-small wishlist-remove-btn" data-post-id="<?= (int) $item['id'] ?>">
                  Remove
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>
