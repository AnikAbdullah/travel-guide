<?php
$config = app_config();
$baseUrl = rtrim($config['app']['base_url'], '/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle ?? $config['app']['name']) ?></title>
  <link rel="stylesheet" href="<?= e($baseUrl) ?>/css/style.css">
  <meta name="base-url" content="<?= e($baseUrl) ?>">
</head>
<body>
  <?php require __DIR__ . '/navbar.php'; ?>
  <main class="container">
