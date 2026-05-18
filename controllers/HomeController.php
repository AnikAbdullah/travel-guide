<?php

declare(strict_types=1);

require_once __DIR__ . '/../helpers/functions.php';
require_once __DIR__ . '/../models/Post.php';

class HomeController
{
    public function __construct(private PDO $pdo)
    {
    }

    public function index(): void
    {
        $posts = [];
        if (is_verified_user()) {
            $postModel = new Post($this->pdo);
            $posts = $postModel->getLatestApproved();
        }

        require __DIR__ . '/../views/home/index.php';
    }
}
