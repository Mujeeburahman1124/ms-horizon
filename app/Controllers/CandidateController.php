<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;
use App\Core\Request;
use App\Models\Job;

class CandidateController extends Controller
{
    protected array $user;

    public function __construct()
    {
        $this->user = Session::get('user') ?? [];
        if (empty($this->user)) {
            $this->redirect('/login');
            exit;
        }
    }

    public function dashboard(): void
    {
        $candidateId = $this->user['id'] ?? 0;

        try {
            $applications = Job::getApplicationsByCandidate($candidateId);
        } catch (\Exception $e) {
            $applications = [];
        }

        try {
            $savedJobs = Database::fetchAll(
                "SELECT sj.*, j.title, j.location, j.salary_range FROM saved_jobs sj JOIN jobs j ON sj.job_id = j.id WHERE sj.candidate_id = :cid ORDER BY sj.id DESC",
                ['cid' => $candidateId]
            );
        } catch (\Exception $e) {
            $savedJobs = [];
        }

        try {
            $profile = Database::fetchOne("SELECT * FROM candidates WHERE user_id = :uid", ['uid' => $candidateId]);
        } catch (\Exception $e) {
            $profile = [];
        }

        $this->render('candidate/dashboard', [
            'page_title' => 'My Candidate Portal — MS Horizon',
            'applications' => $applications,
            'saved_jobs' => $savedJobs,
            'profile' => $profile,
            'current_user' => $this->user,
        ]);
    }

    public function profile(): void
    {
        $this->render('candidate/profile', [
            'page_title' => 'My Profile — MS Horizon Candidate Portal',
            'current_user' => $this->user,
        ]);
    }

    public function updateProfile(): void
    {
        $data = Request::getBody();
        $this->json(['status' => 'success', 'message' => 'Profile updated successfully!']);
    }
}
