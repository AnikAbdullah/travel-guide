  </main>

  <footer class="site-footer">
    <div class="container">
      <div class="footer-inner">
        <div>
          <div class="footer-brand"><span style="background:linear-gradient(135deg,#0ea5e9,#0284c7);border-radius:8px;padding:.2rem .5rem;font-size:1rem;margin-right:.3rem">✈</span>Travel<span>Guide</span></div>
          <p class="footer-desc">Helping travellers from around the world discover amazing destinations, plan trips, and share experiences.</p>
        </div>
        <div>
          <div class="footer-heading">Quick Links</div>
          <ul class="footer-links">
            <li><a href="<?= e($baseUrl) ?>/home">Home</a></li>
            <li><a href="<?= e($baseUrl) ?>/register">Register</a></li>
            <li><a href="<?= e($baseUrl) ?>/login">Login</a></li>
          </ul>
        </div>
        <div>
          <div class="footer-heading">Features</div>
          <ul class="footer-links">
            <li><a href="#">Browse Destinations</a></li>
            <li><a href="<?= e($baseUrl) ?>/wishlist">My Wishlist</a></li>
            <li><a href="<?= e($baseUrl) ?>/profile">My Profile</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        &copy; <?= date('Y') ?> TravelGuide &mdash; All rights reserved.
      </div>
    </div>
  </footer>

  <?php if (!empty($pageScript)): ?>
    <script src="<?= e($baseUrl) ?>/js/<?= e($pageScript) ?>"></script>
  <?php endif; ?>
</body>
</html>
