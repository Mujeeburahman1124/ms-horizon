<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Validator;
use App\Core\Database;
use App\Core\Session;
use App\Models\Blog;
use App\Models\Offer;

class PageController extends Controller
{
    public function about(): void
    {
        $stats = [
            'clients' => 1800,
            'visas' => 5000,
            'businesses' => 400,
            'projects' => 120,
        ];
        $this->render('pages/about', [
            'page_title' => 'About MS Horizon Group — Our Story, Mission & Values',
            'page_description' => 'Learn about MS Horizon Group: a trusted UAE-based corporate group delivering Travel, HR, Business Consultancy, and Software Development.',
            'stats' => $stats,
        ]);
    }

    public function services(): void
    {
        $divisions = Database::fetchAll("SELECT * FROM divisions ORDER BY id ASC");
        $this->render('pages/services', [
            'page_title' => 'Our Services — MS Horizon Group',
            'page_description' => 'Explore MS Horizon Group\'s five integrated service divisions: Reservations, Travel & Tourism, HR Consultancy, Business Setup, and Software Development.',
            'divisions' => $divisions,
        ]);
    }

    public function faqs(): void
    {
        $this->render('pages/faqs', [
            'page_title' => 'Frequently Asked Questions — MS Horizon Group',
            'page_description' => 'Answers to your most common questions about visa applications, reservations, job applications, and business setup with MS Horizon Group.',
        ]);
    }

    public function search(): void
    {
        $q = htmlspecialchars(trim(Request::get('q', '')), ENT_QUOTES, 'UTF-8');
        $results = [];
        if (!empty($q)) {
            $like = '%' . $q . '%';
            $jobs = Database::fetchAll(
                "SELECT 'job' as type, title, slug FROM jobs WHERE title LIKE :q AND is_active = 1 LIMIT 5",
                ['q' => $like]
            );
            $blogs = Database::fetchAll(
                "SELECT 'blog' as type, title, slug FROM blogs WHERE title LIKE :q AND is_published = 1 LIMIT 5",
                ['q' => $like]
            );
            $results = array_merge($jobs, $blogs);
        }

        $this->render('pages/search', [
            'page_title' => 'Search Results — MS Horizon Group',
            'query' => $q,
            'results' => $results,
        ]);
    }

    public function privacyPolicy(): void
    {
        $this->render('pages/privacy_policy', ['page_title' => 'Privacy Policy — MS Horizon Group']);
    }

    public function termsConditions(): void
    {
        $this->render('pages/terms', ['page_title' => 'Terms & Conditions — MS Horizon Group']);
    }

    public function refundPolicy(): void
    {
        $this->render('pages/refund_policy', ['page_title' => 'Refund Policy — MS Horizon Group']);
    }

    public function cookiePolicy(): void
    {
        $this->render('pages/cookie_policy', ['page_title' => 'Cookie Policy — MS Horizon Group']);
    }

    public function sitemap(): void
    {
        $this->render('pages/sitemap', ['page_title' => 'Sitemap — MS Horizon Group']);
    }

    public function notFound(): void
    {
        http_response_code(404);
        $this->render('pages/404', ['page_title' => '404 Page Not Found — MS Horizon Group']);
    }
}
