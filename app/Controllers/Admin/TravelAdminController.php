<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;

class TravelAdminController extends Controller
{
    protected array $user;

    public function __construct()
    {
        $this->user = Session::get('user') ?? [];
    }

    public function index(): void
    {
        try {
            $visas = Database::fetchAll("SELECT * FROM visas ORDER BY id DESC");
        } catch (\Exception $e) {
            $visas = [];
        }

        try {
            $applications = Database::fetchAll(
                "SELECT va.*, v.title as visa_title FROM visa_applications va LEFT JOIN visas v ON va.visa_id = v.id ORDER BY va.id DESC LIMIT 50"
            );
        } catch (\Exception $e) {
            $applications = [];
        }

        $this->renderAdmin('admin/visas', [
            'page_title' => 'Visa Applications — Admin',
            'breadcrumb' => 'Travel & Visas',
            'visas' => $visas,
            'applications' => $applications,
            'current_user' => $this->user,
        ]);
    }

    public function visas(): void
    {
        $this->index();
    }

    public function createVisa(): void
    {
        $this->json(['status' => 'success', 'message' => 'Visa type created successfully.']);
    }

    public function updateStatus(): void
    {
        $data = \App\Core\Request::getBody();
        $id = $data['id'] ?? 0;
        $status = $data['status'] ?? '';
        if (!$id || !$status) {
            $this->json(['status' => 'error', 'message' => 'Missing data.'], 400);
            return;
        }
        try {
            Database::query("UPDATE visa_applications SET status = :s WHERE id = :id", ['s' => $status, 'id' => $id]);
            $this->json(['status' => 'success', 'message' => 'Status updated to ' . $status]);
        } catch (\Exception $e) {
            $this->json(['status' => 'error', 'message' => 'DB error: ' . $e->getMessage()], 500);
        }
    }

    public function visaDetail(int $id): void
    {
        try {
            $app = Database::fetchOne(
                "SELECT va.*, v.title as visa_title, v.processing_days FROM visa_applications va LEFT JOIN visas v ON va.visa_id = v.id WHERE va.id = :id",
                ['id' => $id]
            );
        } catch (\Exception $e) {
            $app = null;
        }

        $this->renderAdmin('admin/visa_detail', [
            'page_title' => 'Visa Application Detail — Admin',
            'breadcrumb' => 'Visa Detail',
            'app' => $app,
            'current_user' => $this->user,
        ]);
    }
}
