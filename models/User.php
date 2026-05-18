<?php

declare(strict_types=1);

class User
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM users WHERE email = :email LIMIT 1'
        );
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM users WHERE id = :id LIMIT 1'
        );
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    /**
     * Create a new user. Password is hashed here.
     * is_verified defaults to 0 — admin must verify.
     */
    public function create(array $data): bool
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO users (name, email, password_hash, role, is_verified)
             VALUES (:name, :email, :password_hash, :role, 0)'
        );

        return $stmt->execute([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'          => $data['role'],
        ]);
    }

    /**
     * Update name, email, and optionally profile_picture.
     */
    public function updateProfile(int $id, array $data): bool
    {
        $sql    = 'UPDATE users SET name = :name, email = :email';
        $params = [
            'name'  => $data['name'],
            'email' => $data['email'],
            'id'    => $id,
        ];

        if (!empty($data['profile_picture'])) {
            $sql .= ', profile_picture = :profile_picture';
            $params['profile_picture'] = $data['profile_picture'];
        }

        $sql .= ' WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Update password hash directly (already hashed by caller).
     */
    public function updatePassword(int $id, string $passwordHash): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE users SET password_hash = :password_hash WHERE id = :id'
        );
        return $stmt->execute([
            'password_hash' => $passwordHash,
            'id'            => $id,
        ]);
    }

    /**
     * Store or clear the remember_token column.
     */
    public function setRememberToken(int $id, ?string $token): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE users SET remember_token = :token WHERE id = :id'
        );
        return $stmt->execute(['token' => $token, 'id' => $id]);
    }
}
