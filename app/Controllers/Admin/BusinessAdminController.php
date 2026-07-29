<?php
namespace App\Controllers\Admin;

use App\Core\Database;
use App\Core\Request;
use App\Models\BusinessLead;

class BusinessAdminController extends DashboardController
{
    public function index(): void
    {
        try {
            $leads = Database::fetchAll("SELECT * FROM business_leads ORDER BY id DESC LIMIT 100");
        } catch (\Exception $e) {
            $leads = [];
        }
        $this->renderAdmin('admin/business_leads', [
            'page_title'   => 'Business Leads — MS Horizon Admin',
            'breadcrumb'   => 'Business Leads',
            'leads'        => $leads,
            'current_user' => $this->user,
        ]);
    }

    public function detail(int $id): void
    {
        try {
            $lead = Database::fetchOne("SELECT * FROM business_leads WHERE id = :id", ['id' => $id]);
        } catch (\Exception $e) {
            $lead = null;
        }
        if (!$lead) { $this->redirect('/admin/business-leads'); return; }

        $this->renderAdmin('admin/business_lead_detail', [
            'page_title'   => 'Lead #' . $id . ' — Admin',
            'breadcrumb'   => 'Lead Detail',
            'lead'         => $lead,
            'current_user' => $this->user,
        ]);
    }

    public function updateStatus(): void
    {
        $data = Request::getBody();
        $id = $data['id'] ?? 0;
        $status = $data['status'] ?? '';
        if (!$id || !$status) {
            $this->json(['status' => 'error', 'message' => 'Missing fields.'], 400);
            return;
        }
        try {
            Database::query("UPDATE business_leads SET status = :s WHERE id = :id", ['s' => $status, 'id' => $id]);
            $this->json(['status' => 'success', 'message' => 'Lead status updated to ' . $status]);
        } catch (\Exception $e) {
            $this->json(['status' => 'error', 'message' => 'DB error.'], 500);
        }
    }
}
