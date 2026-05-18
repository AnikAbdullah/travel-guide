<?php
/**
 * mysqli connection helper – used by Task 2, 3, 4 controllers.
 * Reads the same config.php so credentials stay in one place.
 */

$configFile = __DIR__ . '/config.php';
if (!file_exists($configFile)) {
    $configFile = __DIR__ . '/config.example.php';
}

$_cfg = require $configFile;

$conn = mysqli_connect(
    $_cfg['db']['host'],
    $_cfg['db']['user'],
    $_cfg['db']['pass'],
    $_cfg['db']['name'],
    (int) $_cfg['db']['port']
);

if (!$conn) {
    http_response_code(500);
    die('Database connection failed: ' . mysqli_connect_error());
}

mysqli_set_charset($conn, $_cfg['db']['charset']);

unset($_cfg);
