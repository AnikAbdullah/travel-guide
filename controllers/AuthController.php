<?php

declare(strict_types=1);

require_once __DIR__ . '/../helpers/functions.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/Wishlist.php';

class AuthController
{
    public function __construct(private PDO $pdo)
    {
    }

    public function showRegister(): void
    {
        if (is_logged_in()) {
            redirect('/home');
        }

        $errors = [];
        $old = ['name' => '', 'email' => '', 'role' => 'user'];
        require __DIR__ . '/../views/auth/register.php';
    }

    public function register(): void
    {
        if (is_logged_in()) {
            redirect('/home');
        }

        $errors = [];
        $old = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'role' => $_POST['role'] ?? 'user',
        ];
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($old['name'] === '') {
            $errors['name'] = 'Name is required.';
        } elseif (strlen($old['name']) > 100) {
            $errors['name'] = 'Name must be 100 characters or fewer.';
        }

        if ($old['email'] === '') {
            $errors['email'] = 'Email is required.';
        } elseif (!validate_email($old['email'])) {
            $errors['email'] = 'Enter a valid email address.';
        }

        if ($password === '') {
            $errors['password'] = 'Password is required.';
        } elseif (!validate_password($password)) {
            $errors['password'] = 'Password must be at least 8 characters.';
        }

        if ($confirmPassword === '') {
            $errors['confirm_password'] = 'Please confirm your password.';
        } elseif ($password !== $confirmPassword) {
            $errors['confirm_password'] = 'Passwords do not match.';
        }

        if (!validate_role($old['role'])) {
            $errors['role'] = 'Select a valid role.';
        }

        $userModel = new User($this->pdo);
        if (empty($errors['email']) && $userModel->findByEmail($old['email'])) {
            $errors['email'] = 'This email is already registered.';
        }

        if (!empty($errors)) {
            require __DIR__ . '/../views/auth/register.php';
            return;
        }

        $userModel->create([
            'name' => $old['name'],
            'email' => $old['email'],
            'password' => $password,
            'role' => $old['role'],
        ]);

        flash('success', 'Registration successful. Please log in. Your account is pending admin approval.');
        redirect('/login');
    }

    public function showLogin(): void
    {
        if (is_logged_in()) {
            redirect('/home');
        }

        $errors = [];
        $old = ['email' => ''];
        require __DIR__ . '/../views/auth/login.php';
    }

    public function login(): void
    {
        if (is_logged_in()) {
            redirect('/home');
        }

        $errors = [];
        $old = ['email' => trim($_POST['email'] ?? '')];
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember_me']);

        if ($old['email'] === '') {
            $errors['email'] = 'Email is required.';
        } elseif (!validate_email($old['email'])) {
            $errors['email'] = 'Enter a valid email address.';
        }

        if ($password === '') {
            $errors['password'] = 'Password is required.';
        }

        if (!empty($errors)) {
            require __DIR__ . '/../views/auth/login.php';
            return;
        }

        $userModel = new User($this->pdo);
        $user = $userModel->findByEmail($old['email']);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $errors['general'] = 'Invalid email or password.';
            require __DIR__ . '/../views/auth/login.php';
            return;
        }

        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['is_verified'] = (int) $user['is_verified'];

        if ($remember) {
            set_remember_me($this->pdo, (int) $user['id']);
        }

        if (!(int) $user['is_verified']) {
            flash('warning', 'Your account is pending admin approval.');
        } else {
            flash('success', 'Welcome back, ' . $user['name'] . '!');
        }

        redirect('/home');
    }

    public function logout(): void
    {
        $userId = $_SESSION['user_id'] ?? null;
        if ($userId !== null) {
            clear_remember_me($this->pdo, (int) $userId);
        }

        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();

        flash('success', 'You have been logged out.');
        redirect('/login');
    }
}
