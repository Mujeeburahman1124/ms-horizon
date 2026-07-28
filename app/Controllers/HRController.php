<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Database;
use App\Core\Validator;
use App\Core\Session;
use App\Models\Job;
use App\Services\AuthService;
use App\Services\UploadService;

/**
 * HR Consultancy Division Controller - Careers, Candidate & Employer Portals
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

        // Get distinct categories for filter dropdown
        $categories = Database::fetchAll("SELECT DISTINCT category FROM jobs WHERE is_active = 1 ORDER BY category");

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
            'page_description' => 'Apply for ' . $job['title'] . ' in ' . $job['location'] . '. ' . substr(strip_tags($job['description']), 0, 150) . '...',
            'job' => $job,
        ]);
    }

    public function applyJob(string $slug): void
    {
        if (!$this->auth->isAuthenticated()) {
            Session::setFlash('info', 'Please log in or register as a candidate to apply for jobs.');
            $this->redirect('/candidate/register');
            return;
        }

        $job = Job::findBySlug($slug);
        if (!$job) {
            $this->json(['status' => 'error', 'message' => 'Job not found.']);
            return;
        }

        $user = $this->auth->currentUser();
        $candidate = Database::fetchOne("SELECT * FROM candidates WHERE user_id = :uid", ['uid' => $user['id']]);
        if (!$candidate) {
            $this->json(['status' => 'error', 'message' => 'Please complete your candidate profile first.']);
            return;
        }

        $result = Job::apply($job['id'], $candidate['id'], Request::get('cover_letter', ''));
        if ($result === 0) {
            $this->json(['status' => 'error', 'message' => 'You have already applied for this position.']);
            return;
        }

        $this->json(['status' => 'success', 'message' => 'Application submitted successfully! You will be notified by email.']);
    }

    public function candidateRegisterForm(): void
    {
        $this->render('hr/candidate_register', [
            'page_title' => 'Candidate Registration — MS Horizon HR Portal',
            'page_description' => 'Register as a candidate on MS Horizon\'s recruitment platform to access GCC job opportunities.',
        ]);
    }

    public function candidateRegister(): void
    {
        $data = Request::getBody();
        $validator = new Validator();
        if (!$validator->validate($data, [
            'name' => 'required|min:2|max:150',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'phone' => 'required',
            'nationality' => 'required',
        ])) {
            if (Request::isAjax()) {
                $this->json(['status' => 'error', 'errors' => $validator->getErrors()]);
            } else {
                Session::setFlash('error', $validator->getFirstError());
                $this->redirect('/candidate/register');
            }
            return;
        }

        // Check email uniqueness
        $existing = Database::fetchOne("SELECT id FROM users WHERE email = :email", ['email' => $data['email']]);
        if ($existing) {
            $this->json(['status' => 'error', 'message' => 'An account with this email already exists. Please log in.']);
            return;
        }

        // Upload CV
        $cvResult = null;
        if (!empty($_FILES['cv']['tmp_name'])) {
            $uploader = new UploadService('cvs');
            $cvResult = $uploader->upload($_FILES['cv']);
            if (!$cvResult['success']) {
                $this->json(['status' => 'error', 'message' => 'CV Upload failed: ' . $cvResult['error']]);
                return;
            }
        } else {
            $this->json(['status' => 'error', 'message' => 'CV upload is required to register as a candidate.']);
            return;
        }

        // Create user account with candidate role (role_id = 6 = recruiter-level candidate)
        // Use role_id = 10 for candidate portal users
        $userId = $this->auth->register([
            'role_id' => 10, // customer_support role reused as candidate for now
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone']
        ]);

        // Create candidate profile
        Database::insert('candidates', [
            'user_id' => $userId,
            'full_name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'nationality' => $data['nationality'],
            'experience_years' => (int)($data['experience_years'] ?? 0),
            'current_title' => $data['current_title'] ?? '',
            'cv_path' => $cvResult['path'],
            'is_contact_unlocked' => 0
        ]);

        // Auto-login
        $this->auth->login($data['email'], $data['password']);

        if (Request::isAjax()) {
            $this->json(['status' => 'success', 'message' => 'Registration successful! Redirecting to your dashboard...', 'redirect' => APP_URL . '/candidate/dashboard']);
        } else {
            Session::setFlash('success', 'Welcome! Your candidate profile has been created.');
            $this->redirect('/candidate/dashboard');
        }
    }

    public function candidateDashboard(): void
    {
        $user = $this->auth->currentUser();
        $candidate = Database::fetchOne("SELECT * FROM candidates WHERE user_id = :uid", ['uid' => $user['id']]);
        $applications = $candidate ? Job::getApplicationsByCandidate($candidate['id']) : [];

        $this->render('hr/candidate_dashboard', [
            'page_title' => 'My Dashboard — MS Horizon Candidate Portal',
            'candidate' => $candidate,
            'applications' => $applications,
        ]);
    }

    public function employerRegisterForm(): void
    {
        $this->render('hr/employer_register', [
            'page_title' => 'Employer Registration — MS Horizon HR Portal',
            'page_description' => 'Register your company to access verified GCC talent through MS Horizon HR Consultancy.',
        ]);
    }

    public function employerRegister(): void
    {
        $data = Request::getBody();
        $validator = new Validator();
        if (!$validator->validate($data, [
            'company_name' => 'required|min:2',
            'trade_license' => 'required',
            'contact_person' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'industry' => 'required',
            'password' => 'required|min:8',
        ])) {
            $this->json(['status' => 'error', 'errors' => $validator->getErrors()]);
            return;
        }

        $existing = Database::fetchOne("SELECT id FROM users WHERE email = :email", ['email' => $data['email']]);
        if ($existing) {
            $this->json(['status' => 'error', 'message' => 'Email already registered.']);
            return;
        }

        $userId = $this->auth->register([
            'role_id' => 10,
            'name' => $data['contact_person'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone']
        ]);

        Database::insert('employers', [
            'user_id' => $userId,
            'company_name' => $data['company_name'],
            'trade_license' => $data['trade_license'],
            'contact_person' => $data['contact_person'],
            'phone' => $data['phone'],
            'industry' => $data['industry'],
            'is_verified' => 0
        ]);

        $this->auth->login($data['email'], $data['password']);
        $this->json(['status' => 'success', 'message' => 'Employer account created! Redirecting...', 'redirect' => APP_URL . '/employer/dashboard']);
    }

    public function employerDashboard(): void
    {
        $user = $this->auth->currentUser();
        $employer = Database::fetchOne("SELECT * FROM employers WHERE user_id = :uid", ['uid' => $user['id']]);

        $jobs = [];
        if ($employer) {
            $jobs = Database::fetchAll(
                "SELECT j.*, COUNT(ja.id) as applications 
                 FROM jobs j 
                 LEFT JOIN job_applications ja ON j.id = ja.job_id 
                 WHERE j.employer_id = :eid 
                 GROUP BY j.id 
                 ORDER BY j.id DESC",
                ['eid' => $employer['id']]
            );
        }

        $this->render('hr/employer_dashboard', [
            'page_title' => 'Employer Dashboard — MS Horizon HR Portal',
            'employer' => $employer,
            'jobs' => $jobs,
        ]);
    }

    public function postJob(): void
    {
        $user = $this->auth->currentUser();
        $employer = Database::fetchOne("SELECT * FROM employers WHERE user_id = :uid", ['uid' => $user['id']]);

        if (!$employer) {
            $this->json(['status' => 'error', 'message' => 'Employer profile not found.']);
            return;
        }

        $data = Request::getBody();
        $validator = new Validator();
        if (!$validator->validate($data, [
            'title' => 'required|min:5',
            'category' => 'required',
            'location' => 'required',
            'job_type' => 'required',
            'salary_range' => 'required',
            'description' => 'required|min:50',
            'requirements' => 'required|min:20',
        ])) {
            $this->json(['status' => 'error', 'errors' => $validator->getErrors()]);
            return;
        }

        $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $data['title'])) . '-' . time();
        Job::create([
            'employer_id' => $employer['id'],
            'title' => $data['title'],
            'slug' => $slug,
            'category' => $data['category'],
            'location' => $data['location'],
            'job_type' => $data['job_type'],
            'experience_level' => $data['experience_level'] ?? 'Not specified',
            'salary_range' => $data['salary_range'],
            'description' => $data['description'],
            'requirements' => $data['requirements'],
        ]);

        $this->json(['status' => 'success', 'message' => 'Job posted successfully! It will go live after admin review.']);
    }
}
