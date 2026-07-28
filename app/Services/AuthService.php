<?php
namespace App\Services;

use App\Models\User;
use App\Core\Session;
use App\Core\Database;

/**
 * Authentication Service - handles login, logout, registration, password hashing
 */
class AuthService
{
    /**
     * Attempt user login. Returns user array on success, null on failure.
     */
    public function login(string $email, string $password): ?array
    {
        $user = User::findByEmail($email);

        if (!$user) return null;
        if (!$user['is_active']) return null;
        if (!password_verify($password, $user['password_hash'])) return null;

        // Update last login timestamp
        User::update($user['id'], ['last_login_at' => date('Y-m-d H:i:s')]);

        // Record audit log
        $this->auditLog($user['id'], $user['email'], 'LOGIN', 'User logged in successfully');

        // Set session
        Session::set('user', [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role_id' => $user['role_id'],
            'role_slug' => $user['role_slug'],
            'role_title' => $user['role_title'],
            'avatar' => $user['avatar']
        ]);

        return $user;
    }

    /**
     * Register a new user (candidate, employer, customer portal)
     */
    public function register(array $data): int
    {
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);

        $userId = User::create([
            'role_id' => $data['role_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password_hash' => $hashedPassword,
            'phone' => $data['phone'] ?? null,
        ]);

        $this->auditLog($userId, $data['email'], 'REGISTER', 'New user account registered');

        return $userId;
    }

    /**
     * Destroy session and log out
     */
    public function logout(): void
    {
        $user = Session::get('user');
        if ($user) {
            $this->auditLog($user['id'], $user['email'], 'LOGOUT', 'User logged out');
        }
        Session::destroy();
    }

    /**
     * Check if a user is currently authenticated
     */
    public function isAuthenticated(): bool
    {
        return Session::has('user');
    }

    /**
     * Return the current logged-in user array
     */
    public function currentUser(): ?array
    {
        return Session::get('user');
    }

    /**
     * Write to the audit_logs table
     */
    public function auditLog(int $userId, string $email, string $action, string $details = ''): void
    {
        Database::insert('audit_logs', [
            'user_id' => $userId,
            'user_email' => $email,
            'action' => $action,
            'details' => $details,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'
        ]);
    }
}
