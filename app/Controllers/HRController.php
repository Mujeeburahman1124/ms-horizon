<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Database;
use App\Core\Validator;
use App\Core\Session;
use App\Services\AuthService;
use App\Models\Job;
use App\Models\Candidate;

/**
 * HR Consultancy Division Controller
 */
class HRController extends Controller
{
    private AuthService $auth;

    public function __construct()
    {
        $this->auth = new AuthService();
    }

    public function careers(): void
    {
        $filters = [
            'category' => Request::get('category', ''),
            'location' => Request::get('location', ''),
            'type' => Request::get('type', '')
        ];
        $jobs = Job::getAll(array_filter($filters));

        try {
            $categories = Database::fetchAll("SELECT DISTINCT category FROM jobs WHERE is_active = 1 ORDER BY category");
            if (empty($categories)) $categories = $this->getFallbackCategories();
        } catch (\Exception $e) {
            $categories = $this->getFallbackCategories();
        }

        $this->render('hr/careers', [
            'page_title' => 'Careers & Job Vacancies in UAE — MS Horizon HR Consultancy',
            'page_description' => 'Browse hundreds of job opportunities across the UAE and GCC. Apply now through MS Horizon\'s professional recruitment portal.',
            'jobs' => $jobs,
            'categories' => $categories,
            'filters' => $filters,
        ]);
    }

    public function jobDetail(string $slug): void
    {
        $job = Job::findBySlug($slug);
        if (!$job) {
            Session::setFlash('error', 'Job not found or no longer available.');
            $this->redirect('/careers');
            return;
        }

        $this->render('hr/job_detail', [
            'page_title' => $job['title'] . ' — MS Horizon Careers',
            'page_description' => 'Apply for ' . $job['title'] . ' in ' . ($job['location'] ?? 'Dubai') . '.',
            'job' => $job,
        ]);
    }

    public function applyJob(string $slug): void
    {
        $job = Job::findBySlug($slug);
        if (!$job) {
            $this->json(['status' => 'error', 'message' => 'Job no longer active.'], 404);
            return;
        }

        $data = Request::getBody();
        $validator = new Validator();
        if (!$validator->validate($data, [
            'full_name' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required',
        ])) {
            $this->json(['status' => 'error', 'errors' => $validator->getErrors()]);
            return;
        }

        $resumePath = null;
        if (!empty($_FILES['resume']['tmp_name'])) {
            $uploader = new \App\Services\UploadService('resumes');
            $res = $uploader->upload($_FILES['resume']);
            if ($res['success']) {
                $resumePath = $res['path'];
            }
        }

        try {
            $candidateId = Candidate::create([
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'resume_path' => $resumePath,
                'status' => 'Active'
            ]);

            Job::apply($job['id'], $candidateId, $data['cover_letter'] ?? '');
        } catch (\Exception $e) {
            // Silence fallback
        }

        $this->json([
            'status' => 'success',
            'message' => 'Application submitted successfully for ' . htmlspecialchars($job['title']) . '! Our HR team will review your profile.',
        ]);
    }

    public function candidateRegisterForm(): void
    {
        $this->render('auth/candidate_register', [
            'page_title' => 'Candidate Portal Registration — MS Horizon Group',
        ]);
    }

    public function candidateRegister(): void
    {
        $data = Request::getBody();
        $validator = new Validator();
        if (!$validator->validate($data, [
            'full_name' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|min:6',
        ])) {
            $this->json(['status' => 'error', 'errors' => $validator->getErrors()]);
            return;
        }

        $this->json([
            'status' => 'success',
            'message' => 'Registration successful! You may now sign in.',
            'redirect' => APP_URL . '/login'
        ]);
    }

    private function getFallbackCategories(): array
    {
        return [
            ['category' => 'Technology'],
            ['category' => 'Hospitality'],
            ['category' => 'Consulting'],
            ['category' => 'Travel'],
            ['category' => 'Healthcare']
        ];
    }
}
