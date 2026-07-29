<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;
use App\Core\Request;

class SoftwareAdminController extends Controller
{
    protected array $user;

    public function __construct()
    {
        $this->user = Session::get('user') ?? [];
    }

    public function index(): void
    {
        try {
            $projects = Database::fetchAll("SELECT * FROM software_projects ORDER BY id DESC LIMIT 50");
        } catch (\Exception $e) {
            $projects = [];
        }

        $this->renderAdmin('admin/software_projects', [
            'page_title' => 'Software Projects — Admin',
            'breadcrumb' => 'Software Projects',
            'projects' => $projects,
            'current_user' => $this->user,
        ]);
    }

    public function updateStatus(): void
    {
        $data = Request::getBody();
        $id = $data['id'] ?? 0;
        $status = $data['status'] ?? '';
        if (!$id || !$status) {
            $this->json(['status' => 'error', 'message' => 'Missing required fields.'], 400);
            return;
        }
        try {
            Database::query("UPDATE software_projects SET status = :s WHERE id = :id", ['s' => $status, 'id' => $id]);
            $this->json(['status' => 'success', 'message' => 'Project status updated to ' . $status]);
        } catch (\Exception $e) {
            $this->json(['status' => 'error', 'message' => 'DB error.'], 500);
        }
    }

    public function projectDetail(int $id): void
    {
        try {
            $project = Database::fetchOne("SELECT * FROM software_projects WHERE id = :id", ['id' => $id]);
        } catch (\Exception $e) {
            $project = null;
        }

        $this->renderAdmin('admin/software_project_detail', [
            'page_title' => 'Software Project Detail — Admin',
            'breadcrumb' => 'Project Detail',
            'project' => $project,
            'current_user' => $this->user,
        ]);
    }
}
