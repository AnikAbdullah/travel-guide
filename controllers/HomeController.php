<?php
require_once __DIR__ . '/../helpers/functions.php';
require_once __DIR__ . '/../models/Post.php';

class HomeController
{
    public function __construct(private $conn) {}

    public function index(): void
    {
        $posts = [];
        if (is_verified_user()) {
            $postModel = new Post($this->conn);
            $posts = $postModel->getLatestApproved();
        }
        require __DIR__ . '/../views/home/index.php';
    }
}
