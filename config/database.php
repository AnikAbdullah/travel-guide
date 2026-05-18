<?php

declare(strict_types=1);

$configFile = __DIR__ . '/config.php';
if (!file_exists($configFile)) {
    $configFile = __DIR__ . '/config.example.php';
}

$config = require $configFile;

$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=%s',
    $config['db']['host'],
    $config['db']['port'],
    $config['db']['name'],
    $config['db']['charset']
);

try {
    $pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    exit('Database connection failed. Import db/travel_guide.sql and db/task1_remember_token.sql.');
}

return $pdo;
