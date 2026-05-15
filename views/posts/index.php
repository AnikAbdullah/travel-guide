<!DOCTYPE html>
<html>

<head>

    <title>Browse Posts</title>

    <link rel="stylesheet"
          href="../../public/css/style.css">

</head>

<body>

<h1>Travel Posts</h1>

<!-- Search -->
<input type="text"
       id="searchText"
       placeholder="Search posts..."
       onkeyup="searchPosts()">

<br><br>

<!-- Filter -->
<select id="country" onchange="filterPosts()">

    <option value="">All Countries</option>

    <option value="Bangladesh">Bangladesh</option>

    <option value="Japan">Japan</option>

</select>

<select id="genre" onchange="filterPosts()">

    <option value="">All Genres</option>

    <option value="beach">Beach</option>

    <option value="mountain">Mountain</option>

    <option value="city">City</option>

</select>

<select id="cost" onchange="filterPosts()">

    <option value="">All Costs</option>

    <option value="low">Low</option>

    <option value="medium">Medium</option>

    <option value="high">High</option>

</select>

<hr>

<div id="postData">

<?php foreach ($posts as $post): ?>

<div class="card">

    <h2>
        <?= htmlspecialchars($post["title"]) ?>
    </h2>

    <p>
        <?= htmlspecialchars($post["country"]) ?>
    </p>

    <p>
        <?= htmlspecialchars($post["genre"]) ?>
    </p>

    <p>
        <?= htmlspecialchars($post["cost_level"]) ?>
    </p>

    <p>
        <?= htmlspecialchars(substr($post["short_history"], 0, 100)) ?>
    </p>

    <a href="../../index.php?action=details&id=<?= $post["id"] ?>">
        Read More
    </a>

</div>

<hr>

<?php endforeach; ?>

</div>

<script src="../../public/js/search.js"></script>

<script src="../../public/js/filter.js"></script>

</body>

</html>