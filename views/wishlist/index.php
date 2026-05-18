<?php

session_start();

require_once '../../config/database.php';
require_once '../../models/Wishlist.php';

$db = (new Database())->connect();

$wishlist = new Wishlist($db);

$items = $wishlist->getWishlist(
    $_SESSION['user_id']
);

?>

<!DOCTYPE html>
<html>
<head>

<title>Wishlist</title>

<link
rel="stylesheet"
href="../../public/css/style.css"
>

</head>
<body>

<?php include '../partials/navbar.php'; ?>

<h2>My Wishlist</h2>

<?php if(count($items) > 0): ?>

<?php foreach($items as $item): ?>

<div class="card">

<h3>
<?php echo $item['title']; ?>
</h3>

<p>
Country:
<?php echo $item['country']; ?>
</p>

<p>
Genre:
<?php echo $item['genre']; ?>
</p>

<p>
Cost:
<?php echo $item['cost_level']; ?>
</p>

<button
onclick="removeWishlist(
<?php echo $item['id']; ?>
)"
>
Remove
</button>

</div>

<?php endforeach; ?>

<?php else: ?>

<div class="card">

<p>
No Wishlist Added Yet
</p>

</div>

<?php endif; ?>

<script
src="../../public/js/wishlist.js"
></script>

</body>
</html>
