<?php

require_once "../../config/db.php";
require_once "../../controllers/WishlistController.php";
require_once "../../helpers/auth.php";

bootSession();

requireVerifiedGeneralUser();

function e($value)
{
    return htmlspecialchars($value ?? "");
}

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}

$csrfToken = $_SESSION["csrf_token"];

$wishlistItems = handleWishlistPage($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Wishlist | Travel Guide</title>

    <link rel="stylesheet"
          href="../../public/css/auth.css">

    <script>
        window.CSRF_TOKEN = "<?= e($csrfToken) ?>";
    </script>
</head>
<body>

<?php require_once "../partials/navbar.php"; ?>

<main class="home-container">

    <h2>My Wishlist</h2>

    <?php if (empty($wishlistItems)): ?>

        <div class="alert alert-info">
            Your wishlist is empty.
        </div>

    <?php else: ?>

        <table class="wishlist-table">

            <thead>
                <tr>
                    <th>Title</th>
                    <th>Country</th>
                    <th>Genre</th>
                    <th>Cost</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($wishlistItems as $item): ?>

                    <tr id="wishlist-row-<?= e($item["id"]) ?>">

                        <td><?= e($item["title"]) ?></td>

                        <td><?= e($item["country"]) ?></td>

                        <td><?= e($item["genre"]) ?></td>

                        <td><?= e($item["cost_level"]) ?></td>

                        <td>

                            <button
                                onclick="removeWishlistItem(<?= e($item["id"]) ?>)"
                            >
                                Remove
                            </button>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

</main>

<script src="../../public/js/wishlist.js"></script>

</body>
</html>