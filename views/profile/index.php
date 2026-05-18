<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>

<title>Profile</title>

<link
rel="stylesheet"
href="../../public/css/style.css"
>

</head>
<body>

<?php include '../partials/navbar.php'; ?>

<div class="container">

<h2>My Profile</h2>

<form
action="../../controllers/ProfileController.php"
method="POST"
>

<input
type="text"
name="name"
value="<?php echo $_SESSION['name']; ?>"
required
>

<button type="submit">
Update Profile
</button>

</form>

</div>

</body>
</html>
