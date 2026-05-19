<?php $navPage = $currentPage ?? ''; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> | Travel Guide</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

<div id="top"></div>

<header class="site-header">
    <div class="header-inner">

        <div class="brand">
            <div class="brand-logo">🌍</div>
            <div class="brand-text">
                <h1>Travel Guide</h1>
                <p>Scout submission panel</p>
            </div>
        </div>

        <div class="module-tag">Scout Module</div>

    </div>

    <nav class="main-nav">
        <a href="dashboard.php"      class="<?= $navPage === 'dashboard' ? 'active' : '' ?>">Dashboard</a>
        <a href="create_request.php" class="<?= $navPage === 'create'    ? 'active' : '' ?>">+ Create Request</a>
        <a href="my_requests.php"    class="<?= $navPage === 'requests'  ? 'active' : '' ?>">My Requests</a>
        <a href="approved_posts.php" class="<?= $navPage === 'approved'  ? 'active' : '' ?>">Approved Posts</a>
    </nav>
</header>

<main class="container">
