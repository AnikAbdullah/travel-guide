<?php
require_once __DIR__ . '/../helpers/functions.php';
require_once __DIR__ . '/../models/User.php';

class ProfileController
{
    public function __construct(private $conn) {}

    public function show(): void
    {
        require_login();
        $userModel = new User($this->conn);
        $user = $userModel->findById((int) $_SESSION['user_id']);
        if (!$user) { flash('error', 'User not found.'); redirect('/logout'); }
        $errors  = [];
        $success = flash('success');
        require __DIR__ . '/../views/profile/index.php';
    }

    public function update(): void
    {
        require_login();
        verify_csrf();

        $userModel = new User($this->conn);
        $user = $userModel->findById((int) $_SESSION['user_id']);
        if (!$user) { flash('error', 'User not found.'); redirect('/logout'); }

        $errors          = [];
        $name            = trim($_POST['name']             ?? '');
        $email           = trim($_POST['email']            ?? '');
        $currentPassword = $_POST['current_password']      ?? '';
        $newPassword     = $_POST['new_password']          ?? '';
        $confirmPassword = $_POST['confirm_password']      ?? '';

        if ($name === '')              $errors['name']  = 'Name is required.';
        elseif (strlen($name) > 100)   $errors['name']  = 'Name must be 100 characters or fewer.';

        if ($email === '')             $errors['email'] = 'Email is required.';
        elseif (!validate_email($email)) $errors['email'] = 'Enter a valid email address.';
        else {
            $existing = $userModel->findByEmail($email);
            if ($existing && (int) $existing['id'] !== (int) $user['id']) {
                $errors['email'] = 'This email is already in use.';
            }
        }

        $profilePicture = $user['profile_picture'];
        $upload = handle_profile_upload($_FILES['profile_picture'] ?? [], app_config()['app']['upload_path']);
        if (!$upload['success'])          $errors['profile_picture'] = $upload['error'];
        elseif (!empty($upload['filename'])) $profilePicture = $upload['filename'];

        $changingPassword = $newPassword !== '' || $confirmPassword !== '' || $currentPassword !== '';
        if ($changingPassword) {
            if ($currentPassword === '')
                $errors['current_password'] = 'Current password is required to change password.';
            elseif (!password_verify($currentPassword, $user['password_hash']))
                $errors['current_password'] = 'Current password is incorrect.';

            if ($newPassword === '')
                $errors['new_password'] = 'New password is required.';
            elseif (!validate_password($newPassword))
                $errors['new_password'] = 'New password must be at least 8 characters.';

            if ($confirmPassword === '')
                $errors['confirm_password'] = 'Please confirm your new password.';
            elseif ($newPassword !== $confirmPassword)
                $errors['confirm_password'] = 'New passwords do not match.';
        }

        if (!empty($errors)) {
            $user['name']  = $name;
            $user['email'] = $email;
            require __DIR__ . '/../views/profile/index.php';
            return;
        }

        $userModel->updateProfile((int) $user['id'], [
            'name'            => $name,
            'email'           => $email,
            'profile_picture' => $profilePicture,
        ]);

        if ($changingPassword) {
            $userModel->updatePassword((int) $user['id'], password_hash($newPassword, PASSWORD_DEFAULT));
        }

        $_SESSION['name'] = $name;
        flash('success', 'Profile updated successfully.');
        redirect('/profile');
    }
}
