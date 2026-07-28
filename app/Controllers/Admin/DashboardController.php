<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Core\Session;

class DashboardController extends Controller
{
    protected array $user;

    public function __construct()
    {
        $this->user = Session::get('user') ?? [];
    }

    public function index(): void
    {
        // Fetch dashboard metrics across all 5 divisions
        $metrics = [
            'visa_applications' => Database::fetchOne("SELECT COUNT(*) as c FROM visa_applications")['c'] ?? 0,
            'pending_visas' => Database::fetchOne("SELECT COUNT(*) as c FROM visa_applications WHERE status = 'Submitted' OR status = 'Under Review'")['c'] ?? 0,
            'reservations' => Database::fetchOne("SELECT COUNT(*) as c FROM reservations")['c'] ?? 0,
            'pending_reservations' => Database::fetchOne("SELECT COUNT(*) as c FROM reservations WHERE status = 'New Enquiry' OR status = 'Pending Quote'")['c'] ?? 0,
            'business_leads' => Database::fetchOne("SELECT COUNT(*) as c FROM business_leads")['c'] ?? 0,
            'new_leads' => Database::fetchOne("SELECT COUNT(*) as c FROM business_leads WHERE status = 'New'")['c'] ?? 0,
            'total_candidates' => Database::fetchOne("SELECT COUNT(*) as c FROM candidates")['c'] ?? 0,
            'active_jobs' => Database::fetchOne("SELECT COUNT(*) as c FROM jobs WHERE is_active = 1")['c'] ?? 0,
            'total_enquiries' => Database::fetchOne("SELECT COUNT(*) as c FROM contact_enquiries")['c'] ?? 0,
        ];

        $recent_visa_apps = Database::fetchAll(
            "SELECT va.*, v.title as visa_title FROM visa_applications va JOIN visas v ON va.visa_id = v.id ORDER BY va.id DESC LIMIT 5"
        );

        $recent_leads = Database::fetchAll(
            "SELECT * FROM business_leads ORDER BY id DESC LIMIT 5"
        );

        $this->renderAdmin('admin/dashboard', [
            'page_title' => 'Executive Dashboard — MS Horizon Group Admin',
            'metrics' => $metrics,
            'recent_visa_apps' => $recent_visa_apps,
            'recent_leads' => $recent_leads,
            'current_user' => $this->user
        ]);
    }

    /**
     * CSV Export Report Generator
     */
    public function exportReport(string $type): void
    {
        $filename = "mshorizon_" . $type . "_" . date('Y-m-d') . ".csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');

        if ($type === 'visas') {
            fputcsv($output, ['Ref', 'Applicant Name', 'Passport No', 'Visa Title', 'Email', 'Phone', 'Status', 'Date']);
            $rows = Database::fetchAll("SELECT va.app_reference, va.applicant_name, va.passport_number, v.title, va.email, va.phone, va.status, va.created_at FROM visa_applications va JOIN visas v ON va.visa_id = v.id");
            foreach ($rows as $r) fputcsv($output, $r);
        } elseif ($type === 'candidates') {
            fputcsv($output, ['Full Name', 'Email', 'Phone', 'Nationality', 'Experience', 'Title', 'Date']);
            $rows = Database::fetchAll("SELECT full_name, email, phone, nationality, experience_years, current_title, created_at FROM candidates");
            foreach ($rows as $r) fputcsv($output, $r);
        } elseif ($type === 'leads') {
            fputcsv($output, ['Ref', 'Name', 'Email', 'Phone', 'Setup Type', 'Budget', 'Status', 'Date']);
            $rows = Database::fetchAll("SELECT lead_ref, name, email, phone, setup_type, estimated_budget, status, created_at FROM business_leads");
            foreach ($rows as $r) fputcsv($output, $r);
        } else {
            fputcsv($output, ['Booking Ref', 'Customer Name', 'Email', 'Phone', 'Service Type', 'Travel Date', 'Status']);
            $rows = Database::fetchAll("SELECT booking_ref, customer_name, customer_email, customer_phone, service_type, travel_date, status FROM reservations");
            foreach ($rows as $r) fputcsv($output, $r);
        }

        fclose($output);
        exit;
    }
}
