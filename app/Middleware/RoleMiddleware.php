<?php
namespace App\Middleware;

use App\Core\Session;
use App\Core\Response;

/**
 * Granular Role-Based Access Control (RBAC) Middleware
 */
class RoleMiddleware
{
    private array $allowedRoles;

    public function __construct(array $allowedRoles = [])
    {
        $this->allowedRoles = $allowedRoles;
    }

    public function handle(): bool
    {
        Session::start();
        $user = Session::get('user');

        if (!$user) {
            Response::redirect('/login');
            return false;
        }

        $userRole = $user['role_slug'] ?? 'customer';

        // Super Admin bypasses all role restrictions
        if ($userRole === 'super_admin') {
            return true;
        }

        if (!empty($this->allowedRoles) && !in_array($userRole, $this->allowedRoles)) {
            Session::setFlash('error', 'Access denied. Insufficient role permissions.');
            Response::redirect('/dashboard');
            return false;
        }

        return true;
    }
}
