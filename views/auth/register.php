<?php

require_once "../../config/db.php";
require_once "../../controllers/AuthController.php";
require_once "../../helpers/auth.php";

requireGuest();

function e($value)
{
    return htmlspecialchars($value ?? "");
}

$pageTitle   = "Register";
$currentPage = "register";

$result = handleRegister($conn);

$input  = $result["input"];
$errors = $result["errors"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> | Travel Guide</title>

    <link rel="stylesheet" href="../../public/css/auth.css">
</head>
<body>

<?php require_once "../partials/navbar.php"; ?>

<main class="auth-container">

    <h2>Create Account</h2>

    <?php if (isset($errors["form"])): ?>
        <div class="alert alert-error">
            <?= e($errors["form"]) ?>
        </div>
    <?php endif; ?>

    <form
        name="registerForm"
        method="POST"
        action="register.php"
        onsubmit="return validateRegisterForm()"
    >

        <label for="name">Full Name</label>

        <input
            type="text"
            id="name"
            name="name"
            value="<?= e($input["name"]) ?>"
        >

        <span class="form-error" id="name_error">
            <?= e($errors["name"] ?? "") ?>
        </span>

        <label for="email">Email</label>

        <input
            type="email"
            id="email"
            name="email"
            value="<?= e($input["email"]) ?>"
        >

        <span class="form-error" id="email_error">
            <?= e($errors["email"] ?? "") ?>
        </span>

        <label for="password">Password</label>

        <input
            type="password"
            id="password"
            name="password"
        >

        <span class="form-error" id="password_error">
            <?= e($errors["password"] ?? "") ?>
        </span>

        <label for="confirm_password">Confirm Password</label>

        <input
            type="password"
            id="confirm_password"
            name="confirm_password"
        >

        <span class="form-error" id="confirm_password_error">
            <?= e($errors["confirm_password"] ?? "") ?>
        </span>

        <label for="role">Role</label>

        <select id="role" name="role">
            <option value="">Select Role</option>

            <option
                value="user"
                <?= ($input["role"] ?? "") === "user" ? "selected" : "" ?>
            >
                General User
            </option>

            <option
                value="scout"
                <?= ($input["role"] ?? "") === "scout" ? "selected" : "" ?>
            >
                Scout
            </option>
        </select>

        <span class="form-error" id="role_error">
            <?= e($errors["role"] ?? "") ?>
        </span>

        <button type="submit">
            Register
        </button>

    </form>

    <p class="bottom-link">
        Already have an account?
        <a href="login.php">Login</a>
    </p>

</main>

<script src="../../public/js/auth.js"></script>

</body>
</html>