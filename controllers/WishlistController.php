<?php

declare(strict_types=1);

require_once __DIR__ . '/../helpers/functions.php';
require_once __DIR__ . '/../models/Wishlist.php';
require_once __DIR__ . '/../models/Post.php';

class WishlistController
{
    public function __construct(private PDO $pdo)
    {
    }

    public function index(): void
    {
        require_verified_general_user();

        $wishlistModel = new Wishlist($this->pdo);
        $items = $wishlistModel->getByUser((int) $_SESSION['user_id']);

        require __DIR__ . '/../views/wishlist/index.php';
    }

    public function add(): void
    {
        require_verified_general_user();

        $postId = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
        if (!$postId) {
            json_response(['success' => false, 'message' => 'Invalid post ID.'], 400);
        }

        $postModel = new Post($this->pdo);
        if (!$postModel->findApprovedById($postId)) {
            json_response(['success' => false, 'message' => 'Post not found or not approved.'], 404);
        }

        $wishlistModel = new Wishlist($this->pdo);
        if ($wishlistModel->exists((int) $_SESSION['user_id'], $postId)) {
            json_response(['success' => false, 'message' => 'Post is already in your wishlist.'], 409);
        }

        if (!$wishlistModel->add((int) $_SESSION['user_id'], $postId)) {
            json_response(['success' => false, 'message' => 'Could not add post to wishlist.'], 500);
        }

        json_response(['success' => true, 'message' => 'Added to wishlist.']);
    }

    public function remove(): void
    {
        require_verified_general_user();

        $postId = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
        if (!$postId) {
            json_response(['success' => false, 'message' => 'Invalid post ID.'], 400);
        }

        $wishlistModel = new Wishlist($this->pdo);
        if (!$wishlistModel->remove((int) $_SESSION['user_id'], $postId)) {
            json_response(['success' => false, 'message' => 'Wishlist item not found.'], 404);
        }

        json_response(['success' => true, 'message' => 'Removed from wishlist.']);
    }
}
