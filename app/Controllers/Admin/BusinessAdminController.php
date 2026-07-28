<?php
namespace App\Controllers\Admin;

use App\Core\Database;
use App\Core\Request;
use App\Models\BusinessLead;

class BusinessAdminController extends DashboardController
{
    public function index(): void
    {
        $leads = BusinessLead::getAll();
        $this->renderAdmin('admin/business_leads', [
            'page_title' => 'Business Leads — MS Horizon Admin',
            'leads' => $leads,
        ]);
    }

    public function show(string $id): void
    {
        $lead = BusinessLead::findById((int)$id);
        if (!$lead) { $this->redirect('/admin/business-leads'); return; }
        $this->renderAdmin('admin/business_lead_detail', [
            'page_title' => 'Lead #' . $id . ' — Admin',
            'lead' => $lead,
        ]);
    }

    public function updateStatus(string $id): void
    {
        $data = Request::getBody();
        BusinessLead::updateStatus((int)$id, $data['status'] ?? 'New', $data['notes'] ?? '');
        $this->json(['status' => 'success', 'message' => 'Lead status updated.']);
    }
}
