<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Core\Session;
use App\Models\Visa;

class VisaAdminController extends DashboardController
{
    public function index(): void
    {
        $status = Request::get('status', '');
        $sql = "SELECT va.*, v.title as visa_title, c.name as country_name 
                FROM visa_applications va 
                JOIN visas v ON va.visa_id = v.id 
                JOIN countries c ON v.country_id = c.id";
        $params = [];
        if ($status) {
            $sql .= " WHERE va.status = :status";
            $params['status'] = $status;
        }
        $sql .= " ORDER BY va.id DESC";
        $applications = Database::fetchAll($sql, $params);

        $this->renderAdmin('admin/visas', [
            'page_title' => 'Visa Applications — MS Horizon Admin',
            'applications' => $applications,
            'selected_status' => $status,
        ]);
    }

    public function show(string $id): void
    {
        $application = Database::fetchOne(
            "SELECT va.*, v.title as visa_title, c.name as country_name 
             FROM visa_applications va 
             JOIN visas v ON va.visa_id = v.id 
             JOIN countries c ON v.country_id = c.id 
             WHERE va.id = :id",
            ['id' => $id]
        );

        if (!$application) {
            Session::setFlash('error', 'Visa application not found.');
            $this->redirect('/admin/visas');
            return;
        }

        $documents = Database::fetchAll(
            "SELECT * FROM visa_documents WHERE application_id = :id",
            ['id' => $id]
        );

        $this->renderAdmin('admin/visa_detail', [
            'page_title' => 'Visa Application #' . $id . ' — Admin',
            'application' => $application,
            'documents' => $documents,
        ]);
    }

    public function updateStatus(string $id): void
    {
        $data = Request::getBody();
        $status = $data['status'] ?? '';
        $notes = $data['admin_notes'] ?? '';

        $allowed = ['Submitted', 'Under Review', 'Documents Required', 'Approved', 'Rejected'];
        if (!in_array($status, $allowed)) {
            $this->json(['status' => 'error', 'message' => 'Invalid status value.']);
            return;
        }

        Database::update('visa_applications', [
            'status' => $status,
            'admin_notes' => $notes
        ], 'id = :id', ['id' => $id]);

        // Audit log
        $user = Session::get('user');
        Database::insert('audit_logs', [
            'user_id' => $user['id'],
            'user_email' => $user['email'],
            'action' => 'VISA_STATUS_UPDATE',
            'details' => "Visa Application #{$id} status changed to {$status}",
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'
        ]);

        $this->json(['status' => 'success', 'message' => 'Visa application status updated to: ' . $status]);
    }
}
