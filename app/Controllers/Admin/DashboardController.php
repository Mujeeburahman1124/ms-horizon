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

    private function safeCount(string $sql, array $params = []): int
    {
        try {
            $row = Database::fetchOne($sql, $params);
            return (int)($row['c'] ?? 0);
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function safeQuery(string $sql, array $params = []): array
    {
        try {
            return Database::fetchAll($sql, $params) ?? [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public function index(): void
    {
        $metrics = [
            'visa_applications'    => $this->safeCount("SELECT COUNT(*) as c FROM visa_applications"),
            'pending_visas'        => $this->safeCount("SELECT COUNT(*) as c FROM visa_applications WHERE status IN ('Submitted','Under Review')"),
            'reservations'         => $this->safeCount("SELECT COUNT(*) as c FROM reservations"),
            'pending_reservations' => $this->safeCount("SELECT COUNT(*) as c FROM reservations WHERE status IN ('New Enquiry','Pending Quote')"),
            'business_leads'       => $this->safeCount("SELECT COUNT(*) as c FROM business_leads"),
            'new_leads'            => $this->safeCount("SELECT COUNT(*) as c FROM business_leads WHERE status = 'New'"),
            'total_candidates'     => $this->safeCount("SELECT COUNT(*) as c FROM candidates"),
            'active_jobs'          => $this->safeCount("SELECT COUNT(*) as c FROM jobs WHERE is_active = 1"),
            'total_enquiries'      => $this->safeCount("SELECT COUNT(*) as c FROM contact_enquiries"),
            'software_projects'    => $this->safeCount("SELECT COUNT(*) as c FROM software_projects"),
            'total_users'          => $this->safeCount("SELECT COUNT(*) as c FROM users"),
            'total_staff'          => $this->safeCount("SELECT COUNT(*) as c FROM users WHERE role_slug != 'candidate'"),
        ];

        $recent_visa_apps = $this->safeQuery(
            "SELECT va.*, v.title as visa_title FROM visa_applications va LEFT JOIN visas v ON va.visa_id = v.id ORDER BY va.id DESC LIMIT 5"
        );
        $recent_leads = $this->safeQuery("SELECT * FROM business_leads ORDER BY id DESC LIMIT 5");
        $recent_reservations = $this->safeQuery("SELECT * FROM reservations ORDER BY id DESC LIMIT 5");
        $recent_candidates = $this->safeQuery("SELECT * FROM candidates ORDER BY id DESC LIMIT 5");

        $this->renderAdmin('admin/dashboard', [
            'page_title'          => 'Executive Dashboard — MS Horizon Group',
            'metrics'             => $metrics,
            'recent_visa_apps'    => $recent_visa_apps,
            'recent_leads'        => $recent_leads,
            'recent_reservations' => $recent_reservations,
            'recent_candidates'   => $recent_candidates,
            'current_user'        => $this->user,
        ]);
    }

    public function exportReport(string $type): void
    {
        $filename = "mshorizon_" . $type . "_" . date('Y-m-d') . ".csv";
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        $output = fopen('php://output', 'w');

        try {
            if ($type === 'visas') {
                fputcsv($output, ['Ref', 'Applicant Name', 'Passport No', 'Visa Title', 'Email', 'Phone', 'Status', 'Date']);
                $rows = Database::fetchAll("SELECT va.app_reference, va.applicant_name, va.passport_number, v.title, va.email, va.phone, va.status, va.created_at FROM visa_applications va LEFT JOIN visas v ON va.visa_id = v.id");
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
        } catch (\Exception $e) {
            fputcsv($output, ['Error: ' . $e->getMessage()]);
        }

        fclose($output);
        exit;
    }
}
