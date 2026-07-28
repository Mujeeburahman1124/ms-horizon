<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Database;
use App\Core\Validator;
use App\Core\Session;
use App\Models\Offer;
use App\Models\Job;
use App\Models\Blog;

/**
 * Home Controller - Serves the MS Horizon Group homepage with all widgets
 */
class HomeController extends Controller
{
    public function index(): void
    {
        // Fetch all homepage data
        $offers = Offer::getActive();
        $featuredJobs = Job::getFeatured(4);
        $featuredBlogs = Blog::getPublished(3);

        // Statistics from database
        $stats = [
            'visa_apps' => Database::fetchOne("SELECT COUNT(*) as c FROM visa_applications")['c'] ?? 0,
            'reservations' => Database::fetchOne("SELECT COUNT(*) as c FROM reservations")['c'] ?? 0,
            'jobs' => Database::fetchOne("SELECT COUNT(*) as c FROM jobs WHERE is_active = 1")['c'] ?? 0,
            'projects' => Database::fetchOne("SELECT COUNT(*) as c FROM software_portfolio")['c'] ?? 0,
        ];

        // Featured countries for visa section
        $countries = Database::fetchAll(
            "SELECT * FROM countries WHERE visa_available = 1 ORDER BY popularity_rank DESC LIMIT 6"
        );

        $this->render('home/index', [
            'page_title' => APP_NAME . ' — Your Trusted Group for Travel, HR, Business & Software',
            'page_description' => 'MS Horizon Group delivers premium Reservations, Travel & Tourism, HR Consultancy, Business Setup, and Software Development across the UAE and GCC region.',
            'offers' => $offers,
            'featured_jobs' => $featuredJobs,
            'featured_blogs' => $featuredBlogs,
            'stats' => $stats,
            'countries' => $countries,
        ]);
    }

    public function quickEnquiry(): void
    {
        if (!Request::isAjax()) {
            $this->redirect('/');
            return;
        }

        $data = Request::getBody();
        $validator = new Validator();
        if (!$validator->validate($data, [
            'name' => 'required|min:2|max:100',
            'email' => 'required|email',
            'phone' => 'required',
            'service' => 'required',
            'message' => 'required|min:10'
        ])) {
            $this->json(['status' => 'error', 'errors' => $validator->getErrors()]);
            return;
        }

        Database::insert('contact_enquiries', [
            'department' => $data['service'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'subject' => 'Quick Enquiry from Homepage',
            'message' => $data['message']
        ]);

        $this->json(['status' => 'success', 'message' => 'Thank you! Our team will contact you within 24 hours.']);
    }

    public function newsletter(): void
    {
        if (!Request::isAjax()) {
            $this->redirect('/');
            return;
        }
        $email = filter_var(Request::get('email'), FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $this->json(['status' => 'error', 'message' => 'Please provide a valid email address.']);
            return;
        }
        $this->json(['status' => 'success', 'message' => 'You have successfully subscribed to our newsletter!']);
    }
}
