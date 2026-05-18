<?php

declare(strict_types=1);

class Post
{
    public function __construct(private PDO $pdo)
    {
    }

    public function getLatestApproved(int $limit = 6): array
    {
        $stmt = $this->pdo->prepare(
            "SELECT id, title, country, genre, cost_level, short_history, created_at
             FROM posts
             WHERE status = 'approved'
             ORDER BY created_at DESC
             LIMIT :limit"
        );
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findApprovedById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM posts WHERE id = :id AND status = 'approved' LIMIT 1"
        );
        $stmt->execute(['id' => $id]);
        $post = $stmt->fetch();
        return $post ?: null;
    }
}
