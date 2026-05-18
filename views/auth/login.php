<!DOCTYPE html>
<html>
<head>

<title>Login</title>

<link
rel="stylesheet"
href="../../public/css/style.css"
>

</head>
<body>

<div class="container">

<h2>Login</h2>

<form
action="../../controllers/LoginController.php"
method="POST"
>

<input
type="email"
name="email"
placeholder="Email"
required
>

<input
type="password"
name="password"
placeholder="Password"
required
>

<button type="submit">
Login
</button>

</form>

<br>

<center>

<a href="register.php">
Create New Account
</a>

</center>

</div>

</body>
</html>
