<?php
namespace App\Controllers\Admin;

use App\Core\Database;
use App\Core\Request;
use App\Core\Session;
use App\Models\Job;

class HRAdminController extends DashboardController
{
    public function candidates(): void
    {
        $candidates = Database::fetchAll(
            "SELECT c.*, u.email FROM candidates c JOIN users u ON c.user_id = u.id ORDER BY c.id DESC"
        );
        $this->renderAdmin('admin/candidates', [
            'page_title' => 'Candidate Management — MS Horizon Admin',
            'candidates' => $candidates,
        ]);
    }

    public function showCandidate(string $id): void
    {
        $candidate = Database::fetchOne(
            "SELECT c.*, u.email FROM candidates c JOIN users u ON c.user_id = u.id WHERE c.id = :id",
            ['id' => $id]
        );
        if (!$candidate) { $this->redirect('/admin/candidates'); return; }

        // Phone/email visible only if admin or unlocked
        $user = Session::get('user');
        $showContact = in_array($user['role_slug'], ['super_admin', 'recruitment_manager', 'group_manager']);
        if (!$showContact && !$candidate['is_contact_unlocked']) {
            $candidate['phone'] = '***LOCKED***';
            $candidate['email'] = '***@***';
        }

        $applications = Database::fetchAll(
            "SELECT ja.*, j.title as job_title FROM job_applications ja 
             JOIN jobs j ON ja.job_id = j.id 
             WHERE ja.candidate_id = :id ORDER BY ja.applied_at DESC",
            ['id' => $id]
        );

        $this->renderAdmin('admin/candidate_detail', [
            'page_title' => 'Candidate #' . $id . ' — Admin',
            'candidate' => $candidate,
            'applications' => $applications,
            'show_contact' => $showContact,
        ]);
    }

    public function unlockContact(string $id): void
    {
        $user = Session::get('user');
        if (!in_array($user['role_slug'], ['super_admin', 'recruitment_manager'])) {
            $this->json(['status' => 'error', 'message' => 'Only Recruitment Manager or Super Admin can unlock candidate contact details.']);
            return;
        }
        Database::update('candidates', ['is_contact_unlocked' => 1], 'id = :id', ['id' => $id]);
        Database::insert('audit_logs', [
            'user_id' => $user['id'],
            'user_email' => $user['email'],
            'action' => 'CANDIDATE_CONTACT_UNLOCK',
            'details' => "Candidate #{$id} contact details unlocked.",
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0'
        ]);
        $this->json(['status' => 'success', 'message' => 'Candidate contact details are now visible to employer.']);
    }

    public function jobs(): void
    {
        $jobs = Database::fetchAll(
            "SELECT j.*, e.company_name, COUNT(ja.id) as applications 
             FROM jobs j LEFT JOIN employers e ON j.employer_id = e.id 
             LEFT JOIN job_applications ja ON j.id = ja.job_id 
             GROUP BY j.id ORDER BY j.id DESC"
        );
        $this->renderAdmin('admin/jobs', [
            'page_title' => 'Job Listings — MS Horizon Admin',
            'jobs' => $jobs,
        ]);
    }

    public function createJob(): void
    {
        $data = Request::getBody();
        $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $data['title'] ?? 'job')) . '-' . time();
        Job::create([
            'title' => $data['title'],
            'slug' => $slug,
            'category' => $data['category'],
            'location' => $data['location'],
            'job_type' => $data['job_type'],
            'experience_level' => $data['experience_level'] ?? '',
            'salary_range' => $data['salary_range'],
            'description' => $data['description'],
            'requirements' => $data['requirements'],
        ]);
        $this->json(['status' => 'success', 'message' => 'Job posted successfully.']);
    }

    public function deleteJob(string $id): void
    {
        Database::update('jobs', ['is_active' => 0], 'id = :id', ['id' => $id]);
        $this->json(['status' => 'success', 'message' => 'Job deactivated.']);
    }
}
