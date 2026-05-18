<div class="navbar">

<a href="../home.php">
Home
</a>

<a href="../profile/profile.php">
Profile
</a>

<a href="../wishlist/wishlist.php">
Wishlist
</a>

<a href="../../controllers/LogoutController.php">
Logout
</a>

</div>

<script>
(function(){
  var t = document.getElementById('navToggle');
  var l = document.getElementById('navLinks');
  if(t && l){
    t.addEventListener('click', function(){
      var open = l.classList.toggle('open');
      t.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }
})();
</script>
