<?php

declare(strict_types=1);

function app_config(): array
{
    static $config = null;
    if ($config === null) {
        $configFile = __DIR__ . '/../config/config.php';
        if (!file_exists($configFile)) {
            $configFile = __DIR__ . '/../config/config.example.php';
        }
        $config = require $configFile;
    }
    return $config;
}

function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): never
{
    $base = rtrim(app_config()['app']['base_url'], '/');
    header('Location: ' . $base . $path);
    exit;
}

function flash(string $key, ?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['flash'][$key] = $message;
        return null;
    }

    if (!empty($_SESSION['flash'][$key])) {
        $value = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $value;
    }

    return null;
}

function is_logged_in(): bool
{
    return isset($_SESSION['user_id']);
}

function current_user_role(): ?string
{
    return $_SESSION['role'] ?? null;
}

function is_verified_user(): bool
{
    return is_logged_in() && !empty($_SESSION['is_verified']);
}

function require_login(): void
{
    if (!is_logged_in()) {
        flash('error', 'Please log in to continue.');
        redirect('/login');
    }
}

function require_verified(): void
{
    require_login();
    if (empty($_SESSION['is_verified'])) {
        flash('error', 'Your account is pending admin approval.');
        redirect('/home');
    }
}

function require_verified_general_user(): void
{
    require_verified();
    if (current_user_role() !== 'user') {
        http_response_code(403);
        exit('Only verified general users can access this feature.');
    }
}

function json_response(array $data, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function validate_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validate_password(string $password): bool
{
    return strlen($password) >= 8;
}

function validate_role(string $role): bool
{
    return in_array($role, ['admin', 'scout', 'user'], true);
}

function handle_profile_upload(array $file, string $uploadDir): array
{
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['success' => true, 'filename' => null];
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Profile picture upload failed.'];
    }

    if ($file['size'] > 2 * 1024 * 1024) {
        return ['success' => false, 'error' => 'Profile picture must be 2MB or smaller.'];
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    if (!isset($allowed[$mime])) {
        return ['success' => false, 'error' => 'Only JPG, PNG, and WEBP images are allowed.'];
    }

    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
        return ['success' => false, 'error' => 'Upload directory is not writable.'];
    }

    $filename = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
    $destination = rtrim($uploadDir, '/\\') . DIRECTORY_SEPARATOR . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        return ['success' => false, 'error' => 'Could not save uploaded file.'];
    }

    return ['success' => true, 'filename' => $filename];
}

function restore_remember_me(PDO $pdo): void
{
    if (is_logged_in()) {
        return;
    }

    $config = app_config()['app'];
    $cookieName = $config['remember_cookie'];

    if (empty($_COOKIE[$cookieName])) {
        return;
    }

    $parts = explode(':', $_COOKIE[$cookieName], 2);
    if (count($parts) !== 2) {
        return;
    }

    [$selector, $validator] = $parts;
    $stmt = $pdo->prepare('SELECT id, name, role, is_verified, remember_token FROM users WHERE remember_token LIKE :selector LIMIT 1');
    $stmt->execute(['selector' => $selector . ':%']);
    $user = $stmt->fetch();

    if (!$user || empty($user['remember_token'])) {
        return;
    }

    $stored = explode(':', $user['remember_token'], 2);
    if (count($stored) !== 2 || !hash_equals($stored[0], $selector)) {
        return;
    }

    if (!password_verify($validator, $stored[1])) {
        return;
    }

    $_SESSION['user_id'] = (int) $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['is_verified'] = (int) $user['is_verified'];
}

function set_remember_me(PDO $pdo, int $userId): void
{
    $config = app_config()['app'];
    $selector = bin2hex(random_bytes(12));
    $validator = bin2hex(random_bytes(32));
    $hashedValidator = password_hash($validator, PASSWORD_DEFAULT);
    $token = $selector . ':' . $hashedValidator;

    $stmt = $pdo->prepare('UPDATE users SET remember_token = :token WHERE id = :id');
    $stmt->execute(['token' => $token, 'id' => $userId]);

    $cookieValue = $selector . ':' . $validator;
    setcookie(
        $config['remember_cookie'],
        $cookieValue,
        [
            'expires' => time() + ($config['remember_days'] * 86400),
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]
    );
}

function clear_remember_me(PDO $pdo, ?int $userId = null): void
{
    $config = app_config()['app'];
    $cookieName = $config['remember_cookie'];

    if ($userId !== null) {
        $stmt = $pdo->prepare('UPDATE users SET remember_token = NULL WHERE id = :id');
        $stmt->execute(['id' => $userId]);
    }

    setcookie($cookieName, '', [
        'expires' => time() - 3600,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    unset($_COOKIE[$cookieName]);
}
