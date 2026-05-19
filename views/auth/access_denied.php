<?php

require_once "../../helpers/auth.php";

bootSession();

function e($value)
{
    return htmlspecialchars($value ?? "");
}

$pageTitle = "Access Denied";

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

    <h2>Access Denied</h2>

    <div class="alert alert-info">
        Your account is pending admin approval
        or you do not have permission to access this page.
    </div>

    <a class="home-btn" href="../home/index.php">
        Back To Home
    </a>

</main>

</body>
</html>