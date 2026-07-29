<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;
use App\Core\Request;
use App\Core\Validator;

class UserAdminController extends Controller
{
    protected array $user;

    public function __construct()
    {
        $this->user = Session::get('user') ?? [];
    }

    public function index(): void
    {
        try {
            $users = Database::fetchAll("SELECT id, name, email, role_slug, role_title, is_active, created_at FROM users ORDER BY id DESC");
        } catch (\Exception $e) {
            $users = [];
        }

        $this->renderAdmin('admin/users', [
            'page_title' => 'Users & Staff — Admin',
            'breadcrumb' => 'Users & Staff',
            'users' => $users,
            'current_user' => $this->user,
        ]);
    }

    public function create(): void
    {
        $data = Request::getBody();
        $validator = new Validator();
        if (!$validator->validate($data, [
            'name' => 'required|min:2',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role_slug' => 'required',
        ])) {
            $this->json(['status' => 'error', 'errors' => $validator->getErrors()]);
            return;
        }

        try {
            $exists = Database::fetchOne("SELECT id FROM users WHERE email = :email", ['email' => $data['email']]);
            if ($exists) {
                $this->json(['status' => 'error', 'message' => 'A user with this email already exists.']);
                return;
            }

            $roleLabels = [
                'super_admin' => 'Super Administrator',
                'group_manager' => 'Group Manager',
                'travel_manager' => 'Travel Manager',
                'reservation_officer' => 'Reservation Officer',
                'recruitment_manager' => 'Recruitment Manager',
                'recruiter' => 'Recruiter',
                'business_consultant' => 'Business Consultant',
                'software_pm' => 'Software Project Manager',
                'accounts_officer' => 'Accounts Officer',
                'customer_support' => 'Customer Support',
                'content_manager' => 'Content Manager',
            ];

            Database::insert('users', [
                'name' => $data['name'],
                'email' => $data['email'],
                'password_hash' => password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]),
                'role_slug' => $data['role_slug'],
                'role_title' => $roleLabels[$data['role_slug']] ?? ucfirst($data['role_slug']),
                'is_active' => 1,
            ]);

            $this->json(['status' => 'success', 'message' => 'Staff account created successfully!']);
        } catch (\Exception $e) {
            $this->json(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()], 500);
        }
    }

    public function toggleActive(): void
    {
        $data = Request::getBody();
        $id = $data['id'] ?? 0;
        if (!$id) {
            $this->json(['status' => 'error', 'message' => 'User ID required.'], 400);
            return;
        }
        try {
            $user = Database::fetchOne("SELECT is_active FROM users WHERE id = :id", ['id' => $id]);
            if (!$user) {
                $this->json(['status' => 'error', 'message' => 'User not found.'], 404);
                return;
            }
            $newActive = $user['is_active'] ? 0 : 1;
            Database::query("UPDATE users SET is_active = :a WHERE id = :id", ['a' => $newActive, 'id' => $id]);
            $this->json(['status' => 'success', 'message' => 'User status updated.', 'is_active' => $newActive]);
        } catch (\Exception $e) {
            $this->json(['status' => 'error', 'message' => 'DB error.'], 500);
        }
    }
}
