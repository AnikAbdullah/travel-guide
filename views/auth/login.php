<?php

require_once "../../config/db.php";
require_once "../../controllers/AuthController.php";

/** @var mysqli $conn */
if (!isset($conn)) {
    die("Database connection not available.");
}

function e($value)
{
    return htmlspecialchars($value ?? "");
}

requireGuest();

$pageTitle   = "Login";
$currentPage = "login";

$result = handleLogin($conn);
$input  = $result["input"];
$errors = $result["errors"];

$success = flashGet("success");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= e($pageTitle) ?> | Travel Guide</title>
    <link rel="stylesheet" href="../../public/css/auth.css">
</head>
<body>

<?php require_once "../partials/navbar.php"; ?>

<main class="auth-container">
    <h2>Login</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= e($success) ?></div>
    <?php endif; ?>

    <?php if (isset($errors["form"])): ?>
        <div class="alert alert-error"><?= e($errors["form"]) ?></div>
    <?php endif; ?>

    <form name="loginForm" method="POST" action="login.php" onsubmit="return validateLoginForm()">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= e($input["email"]) ?>" required>
        <span class="form-error" id="email_error"></span>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <span class="form-error" id="password_error"></span>

        <label>
            <input type="checkbox" name="remember" value="1"> Remember me
        </label>

        <button type="submit">Login</button>
    </form>

    <p style="text-align:center;margin-top:16px">
        New here? <a href="register.php">Create an account</a>
    </p>
</main>

<script src="../../public/js/auth.js"></script>

</body>
</html>