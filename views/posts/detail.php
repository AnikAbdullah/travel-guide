<!DOCTYPE html>
<html>

<head>
    <title>
        <?= htmlspecialchars($post["title"]) ?>
    </title>
</head>

<body>

<h1>
    <?= htmlspecialchars($post["title"]) ?>
</h1>

<p>
    <?= htmlspecialchars($post["short_history"]) ?>
</p>

<p>
    <strong>Country:</strong>
    <?= htmlspecialchars($post["country"]) ?>
</p>

<p>
    <strong>Genre:</strong>
    <?= htmlspecialchars($post["genre"]) ?>
</p>

<p>
    <strong>Travel Info:</strong>
    <?= htmlspecialchars($post["travel_medium_info"]) ?>
</p>

</body>

</html>