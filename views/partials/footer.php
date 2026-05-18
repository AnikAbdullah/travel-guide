  </main>
  <footer class="site-footer">
    <div class="container">
      <p>&copy; <?= date('Y') ?> Travel Guide &mdash; Web Technologies Project</p>
    </div>
  </footer>
  <?php if (!empty($pageScript)): ?>
    <script src="<?= e($baseUrl) ?>/js/<?= e($pageScript) ?>"></script>
  <?php endif; ?>
</body>
</html>
