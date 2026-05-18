<?php

session_start();

require_once '../config/database.php';
require_once '../models/Post.php';

$db = (new Database())->connect();

$postModel = new Post($db);

$posts = $postModel->getAllPosts();

?>

<!DOCTYPE html>
<html>
<head>

<title>Travel Guide</title>

<link
rel="stylesheet"
href="../public/css/style.css"
>

</head>
<body>

<div class="navbar">

<a href="home.php">
Home
</a>

<?php if(isset($_SESSION['user_id'])): ?>

<a href="profile/profile.php">
Profile
</a>

<a href="wishlist/wishlist.php">
Wishlist
</a>

<a href="../controllers/LogoutController.php">
Logout
</a>

<?php endif; ?>

</div>

<div class="card">

<h1>
Travel Guide System
</h1>

<p>
Explore Amazing Tourist Places
</p>

<?php if(!isset($_SESSION['user_id'])): ?>

<a href="auth/register.php">

<button>
Create Account
</button>

</a>

<br><br>

<a href="auth/login.php">

<button>
Login
</button>

</a>

<?php else: ?>

<h3>
Welcome,
<?php echo $_SESSION['name']; ?>
</h3>

<?php if($_SESSION['verified']==0): ?>

<p>
Your Account Is Pending Approval
</p>

<?php else: ?>

<p>
Your Account Is Verified
</p>

<?php endif; ?>

<?php endif; ?>

</div>

<h2 style="text-align:center;">
Tourist Places
</h2>

<?php foreach($posts as $post): ?>

<div class="card">

<h3>
<?php echo $post['title']; ?>
</h3>

<p>
<?php echo $post['short_history']; ?>
</p>

<p>
Country:
<?php echo $post['country']; ?>
</p>

<p>
Genre:
<?php echo $post['genre']; ?>
</p>

<p>
Cost:
<?php echo $post['cost_level']; ?>
</p>

<?php if(isset($_SESSION['user_id'])): ?>

<button
onclick="addWishlist(
<?php echo $post['id']; ?>
)"
>
Add To Wishlist
</button>

<?php endif; ?>

</div>

<?php endforeach; ?>

<script
src="../public/js/wishlist.js"
></script>

</body>
</html>