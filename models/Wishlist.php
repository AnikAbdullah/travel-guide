<?php

declare(strict_types=1);

class Wishlist
{
    public function __construct(private PDO $pdo)
    {
    }

    public function add(int $userId, int $postId): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO wishlist (user_id, post_id) VALUES (:user_id, :post_id)'
        );

        try {
            return $stmt->execute(['user_id' => $userId, 'post_id' => $postId]);
        } catch (PDOException $e) {
            if ((int) $e->getCode() === 23000) {
                return false;
            }
            throw $e;
        }
    }

    public function remove(int $userId, int $postId): bool
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM wishlist WHERE user_id = :user_id AND post_id = :post_id'
        );
        $stmt->execute(['user_id' => $userId, 'post_id' => $postId]);
        return $stmt->rowCount() > 0;
    }

    public function getByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT w.id AS wishlist_id, p.id, p.title, p.country, p.cost_level, w.added_at
             FROM wishlist w
             INNER JOIN posts p ON p.id = w.post_id
             WHERE w.user_id = :user_id AND p.status = 'approved'
             ORDER BY w.added_at DESC"
        );
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function exists(int $userId, int $postId): bool
    {
        $stmt = $this->pdo->prepare(
            'SELECT id FROM wishlist WHERE user_id = :user_id AND post_id = :post_id LIMIT 1'
        );
        $stmt->execute(['user_id' => $userId, 'post_id' => $postId]);
        return (bool) $stmt->fetch();
    }
}
