<?php
namespace App\Controllers\Admin;

use App\Core\Database;
use App\Core\Request;
use App\Core\Session;
use App\Models\Job;

class HRAdminController extends DashboardController
{
    public function index(): void
    {
        $this->jobs();
    }

    public function jobs(): void
    {
        try {
            $jobs = Database::fetchAll(
                "SELECT j.*, COUNT(ja.id) as applications
                 FROM jobs j
                 LEFT JOIN job_applications ja ON j.id = ja.job_id
                 GROUP BY j.id ORDER BY j.id DESC"
            );
        } catch (\Exception $e) {
            $jobs = [];
        }
        $this->renderAdmin('admin/jobs', [
            'page_title'   => 'Job Listings — MS Horizon Admin',
            'breadcrumb'   => 'Jobs',
            'jobs'         => $jobs,
            'current_user' => $this->user,
        ]);
    }

    public function candidates(): void
    {
        try {
            $candidates = Database::fetchAll(
                "SELECT * FROM candidates ORDER BY id DESC LIMIT 100"
            );
        } catch (\Exception $e) {
            $candidates = [];
        }
        $this->renderAdmin('admin/candidates', [
            'page_title'   => 'Candidate Management — MS Horizon Admin',
            'breadcrumb'   => 'Candidates',
            'candidates'   => $candidates,
            'current_user' => $this->user,
        ]);
    }

    public function candidateDetail(int $id): void
    {
        try {
            $candidate = Database::fetchOne(
                "SELECT * FROM candidates WHERE id = :id",
                ['id' => $id]
            );
        } catch (\Exception $e) {
            $candidate = null;
        }

        if (!$candidate) {
            $this->redirect('/admin/candidates');
            return;
        }

        $user = Session::get('user');
        $showContact = in_array($user['role_slug'] ?? '', ['super_admin', 'recruitment_manager', 'group_manager']);
        if (!$showContact && empty($candidate['is_contact_unlocked'])) {
            $candidate['phone'] = '•••••••••••';
            $candidate['email'] = '•••@•••.com';
        }

        try {
            $applications = Database::fetchAll(
                "SELECT ja.*, j.title as job_title, j.location FROM job_applications ja
                 LEFT JOIN jobs j ON ja.job_id = j.id
                 WHERE ja.candidate_id = :id ORDER BY ja.applied_at DESC",
                ['id' => $id]
            );
        } catch (\Exception $e) {
            $applications = [];
        }

        $this->renderAdmin('admin/candidate_detail', [
            'page_title'   => 'Candidate #' . $id . ' — Admin',
            'breadcrumb'   => 'Candidate Detail',
            'candidate'    => $candidate,
            'applications' => $applications,
            'show_contact' => $showContact,
            'current_user' => $this->user,
        ]);
    }

    public function createJob(): void
    {
        $data = Request::getBody();
        $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $data['title'] ?? 'job')) . '-' . time();
        try {
            Job::create([
                'title'            => $data['title'] ?? '',
                'slug'             => $slug,
                'category'         => $data['category'] ?? '',
                'location'         => $data['location'] ?? 'Dubai, UAE',
                'job_type'         => $data['job_type'] ?? 'Full-time',
                'experience_level' => $data['experience_level'] ?? 'Mid-Level',
                'salary_range'     => $data['salary_range'] ?? '',
                'description'      => $data['description'] ?? '',
                'requirements'     => $data['requirements'] ?? '',
                'is_active'        => 1,
            ]);
            $this->json(['status' => 'success', 'message' => 'Job posted successfully.']);
        } catch (\Exception $e) {
            $this->json(['status' => 'error', 'message' => 'DB error: ' . $e->getMessage()], 500);
        }
    }

    public function deleteJob(int $id): void
    {
        try {
            Database::query("UPDATE jobs SET is_active = 0 WHERE id = :id", ['id' => $id]);
            $this->json(['status' => 'success', 'message' => 'Job deactivated.']);
        } catch (\Exception $e) {
            $this->json(['status' => 'error', 'message' => 'DB error.'], 500);
        }
    }

    public function unlockContact(int $id): void
    {
        $user = Session::get('user');
        if (!in_array($user['role_slug'] ?? '', ['super_admin', 'recruitment_manager'])) {
            $this->json(['status' => 'error', 'message' => 'Permission denied.'], 403);
            return;
        }
        try {
            Database::query("UPDATE candidates SET is_contact_unlocked = 1 WHERE id = :id", ['id' => $id]);
            $this->json(['status' => 'success', 'message' => 'Candidate contact details unlocked.']);
        } catch (\Exception $e) {
            $this->json(['status' => 'error', 'message' => 'DB error.'], 500);
        }
    }
}
