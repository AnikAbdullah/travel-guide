<?php
class Wishlist
{
    public function __construct(private $conn) {}

    public function add(int $userId, int $postId): bool
    {
        $stmt = mysqli_prepare($this->conn,
            'INSERT INTO wishlist (user_id, post_id) VALUES (?, ?)'
        );
        mysqli_stmt_bind_param($stmt, 'ii', $userId, $postId);
        $ok = @mysqli_stmt_execute($stmt); // suppress duplicate key warning
        mysqli_stmt_close($stmt);
        return $ok;
    }

    public function remove(int $userId, int $postId): bool
    {
        $stmt = mysqli_prepare($this->conn,
            'DELETE FROM wishlist WHERE user_id = ? AND post_id = ?'
        );
        mysqli_stmt_bind_param($stmt, 'ii', $userId, $postId);
        mysqli_stmt_execute($stmt);
        $affected = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        return $affected > 0;
    }

    public function getByUser(int $userId): array
    {
        $stmt = mysqli_prepare($this->conn,
            "SELECT w.id AS wishlist_id, p.id, p.title, p.country, p.cost_level, w.added_at
             FROM wishlist w
             INNER JOIN posts p ON p.id = w.post_id
             WHERE w.user_id = ? AND p.status = 'approved'
             ORDER BY w.added_at DESC"
        );
        mysqli_stmt_bind_param($stmt, 'i', $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
        return $rows;
    }

    public function exists(int $userId, int $postId): bool
    {
        $stmt = mysqli_prepare($this->conn,
            'SELECT id FROM wishlist WHERE user_id = ? AND post_id = ? LIMIT 1'
        );
        mysqli_stmt_bind_param($stmt, 'ii', $userId, $postId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return (bool) $row;
    }
}
