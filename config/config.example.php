<?php

declare(strict_types=1);

return [
    'db' => [
        'host' => '127.0.0.1',
        'port' => '3306',
        'name' => 'travel_guide',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
    ],
    'app' => [
        'name' => 'Travel Guide',
        'base_url' => '/Travel-Guide/public',
        'upload_path' => __DIR__ . '/../public/uploads/',
        'upload_url' => '/Travel-Guide/public/uploads/',
        'remember_days' => 30,
        'remember_cookie' => 'travel_guide_remember',
    ],
];
