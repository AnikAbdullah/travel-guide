<!DOCTYPE html>
<html>
<head>

<title>Register</title>

<link
rel="stylesheet"
href="../../public/css/style.css"
>

</head>
<body>

<div class="container">

<h2>Create Account</h2>

<form
action="../../controllers/AuthController.php"
method="POST"
>

<input
type="text"
name="name"
placeholder="Full Name"
required
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

<select name="role">

<option value="user">
General User
</option>

<option value="scout">
Scout
</option>

<option value="admin">
Admin
</option>

</select>

<button type="submit">
Register
</button>

</form>

<br>

<center>

<a href="login.php">
Already Have An Account?
</a>

</center>

</div>

</body>
</html>
