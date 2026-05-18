<?php
class User
{
    public function __construct(private $conn) {}

    public function findByEmail(string $email): ?array
    {
        $stmt = mysqli_prepare($this->conn, 'SELECT * FROM users WHERE email = ? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $row ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = mysqli_prepare($this->conn, 'SELECT * FROM users WHERE id = ? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $row ?: null;
    }

    public function create(array $data): bool
    {
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($this->conn,
            'INSERT INTO users (name, email, password_hash, role, is_verified)
             VALUES (?, ?, ?, ?, 0)'
        );
        mysqli_stmt_bind_param($stmt, 'ssss',
            $data['name'], $data['email'], $hash, $data['role']
        );
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $ok;
    }

    public function updateProfile(int $id, array $data): bool
    {
        if (!empty($data['profile_picture'])) {
            $stmt = mysqli_prepare($this->conn,
                'UPDATE users SET name = ?, email = ?, profile_picture = ? WHERE id = ?'
            );
            mysqli_stmt_bind_param($stmt, 'sssi',
                $data['name'], $data['email'], $data['profile_picture'], $id
            );
        } else {
            $stmt = mysqli_prepare($this->conn,
                'UPDATE users SET name = ?, email = ? WHERE id = ?'
            );
            mysqli_stmt_bind_param($stmt, 'ssi', $data['name'], $data['email'], $id);
        }
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $ok;
    }

    public function updatePassword(int $id, string $passwordHash): bool
    {
        $stmt = mysqli_prepare($this->conn,
            'UPDATE users SET password_hash = ? WHERE id = ?'
        );
        mysqli_stmt_bind_param($stmt, 'si', $passwordHash, $id);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $ok;
    }

    public function setRememberToken(int $id, ?string $token): bool
    {
        $stmt = mysqli_prepare($this->conn,
            'UPDATE users SET remember_token = ? WHERE id = ?'
        );
        mysqli_stmt_bind_param($stmt, 'si', $token, $id);
        $ok = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $ok;
    }
}
