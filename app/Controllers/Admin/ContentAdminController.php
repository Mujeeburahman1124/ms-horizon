<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;
use App\Core\Request;

class ContentAdminController extends Controller
{
    protected array $user;

    public function __construct()
    {
        $this->user = Session::get('user') ?? [];
    }

    public function blogs(): void
    {
        try {
            $blogs = Database::fetchAll("SELECT * FROM blog_posts ORDER BY id DESC LIMIT 50");
        } catch (\Exception $e) {
            $blogs = [];
        }
        $this->renderAdmin('admin/blogs', [
            'page_title' => 'Blog Posts — Admin',
            'breadcrumb' => 'Blog Posts',
            'blogs' => $blogs,
            'current_user' => $this->user,
        ]);
    }

    public function offers(): void
    {
        try {
            $offers = Database::fetchAll("SELECT * FROM offers ORDER BY id DESC");
        } catch (\Exception $e) {
            $offers = [];
        }
        $this->renderAdmin('admin/offers', [
            'page_title' => 'Offers & Promotions — Admin',
            'breadcrumb' => 'Offers',
            'offers' => $offers,
            'current_user' => $this->user,
        ]);
    }

    public function enquiries(): void
    {
        try {
            $enquiries = Database::fetchAll("SELECT * FROM contact_enquiries ORDER BY id DESC LIMIT 100");
        } catch (\Exception $e) {
            $enquiries = [];
        }
        $this->renderAdmin('admin/enquiries', [
            'page_title' => 'Contact Enquiries — Admin',
            'breadcrumb' => 'Enquiries',
            'enquiries' => $enquiries,
            'current_user' => $this->user,
        ]);
    }

    public function auditLogs(): void
    {
        try {
            $logs = Database::fetchAll("SELECT * FROM audit_logs ORDER BY id DESC LIMIT 200");
        } catch (\Exception $e) {
            $logs = [];
        }
        $this->renderAdmin('admin/audit_logs', [
            'page_title' => 'Audit Logs — Admin',
            'breadcrumb' => 'Audit Logs',
            'logs' => $logs,
            'current_user' => $this->user,
        ]);
    }
}
