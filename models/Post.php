<?php
class Post
{
    public function __construct(private $conn) {}

    public function getLatestApproved(int $limit = 6): array
    {
        $stmt = mysqli_prepare($this->conn,
            "SELECT id, title, country, genre, cost_level, short_history, created_at
             FROM posts
             WHERE status = 'approved'
             ORDER BY created_at DESC
             LIMIT ?"
        );
        mysqli_stmt_bind_param($stmt, 'i', $limit);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        return $rows;
    }

    public function findApprovedById(int $id): ?array
    {
        $stmt = mysqli_prepare($this->conn,
            "SELECT * FROM posts WHERE id = ? AND status = 'approved' LIMIT 1"
        );
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $row ?: null;
    }
}
