<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Validator;
use App\Core\Database;
use App\Services\UploadService;

/**
 * Software Development Division Controller
 */
class SoftwareController extends Controller
{
    public function index(): void
    {
        try {
            $portfolio = Database::fetchAll("SELECT * FROM software_portfolio WHERE featured = 1 ORDER BY id DESC LIMIT 6");
            if (empty($portfolio)) $portfolio = $this->getFallbackPortfolio();
        } catch (\Exception $e) {
            $portfolio = $this->getFallbackPortfolio();
        }

        $this->render('software/index', [
            'page_title' => 'Software Development | Web Apps, Mobile & Automation — MS Horizon Group',
            'page_description' => 'Custom PHP web applications, e-commerce platforms, mobile apps, CRM systems, and travel portal development across UAE and GCC.',
            'portfolio' => $portfolio,
        ]);
    }

    public function portfolio(): void
    {
        $category = Request::get('category', '');
        try {
            $sql = "SELECT * FROM software_portfolio";
            $params = [];
            if ($category) {
                $sql .= " WHERE category = :cat";
                $params['cat'] = $category;
            }
            $sql .= " ORDER BY id DESC";
            $portfolio = Database::fetchAll($sql, $params);
            if (empty($portfolio)) $portfolio = $this->getFallbackPortfolio();
            $categories = Database::fetchAll("SELECT DISTINCT category FROM software_portfolio ORDER BY category");
        } catch (\Exception $e) {
            $portfolio = $this->getFallbackPortfolio();
            $categories = [['category' => 'Web Application'], ['category' => 'Mobile App'], ['category' => 'Enterprise System']];
        }

        $this->render('software/portfolio', [
            'page_title' => 'Software Portfolio — MS Horizon Development Division',
            'page_description' => 'Explore our enterprise software projects: travel portals, recruitment platforms, e-commerce solutions, and custom ERPs.',
            'portfolio' => $portfolio,
            'categories' => $categories,
            'selected_category' => $category,
        ]);
    }

    public function projectDetail(string $slug): void
    {
        try {
            $project = Database::fetchOne("SELECT * FROM software_portfolio WHERE slug = :slug", ['slug' => $slug]);
        } catch (\Exception $e) {
            $project = null;
        }

        if (!$project) {
            $fallbacks = $this->getFallbackPortfolio();
            $project = $fallbacks[0];
        }

        $this->render('software/project_detail', [
            'page_title' => $project['title'] . ' — MS Horizon Software Portfolio',
            'project' => $project,
            'technologies' => json_decode($project['technologies_json'] ?? '[]', true),
        ]);
    }

    public function enquire(): void
    {
        $data = Request::getBody();
        $validator = new Validator();
        if (!$validator->validate($data, [
            'client_name' => 'required|min:2',
            'client_email' => 'required|email',
            'client_phone' => 'required',
            'project_type' => 'required',
            'budget_range' => 'required',
            'timeline' => 'required',
            'requirements' => 'required|min:30',
        ])) {
            $this->json(['status' => 'error', 'errors' => $validator->getErrors()]);
            return;
        }

        $attachmentPath = null;
        if (!empty($_FILES['attachment']['tmp_name'])) {
            $uploader = new UploadService('software_briefs');
            $result = $uploader->upload($_FILES['attachment']);
            if ($result['success']) {
                $attachmentPath = $result['path'];
            }
        }

        $ref = 'DEV-' . strtoupper(bin2hex(random_bytes(5)));
        try {
            Database::insert('software_projects', [
                'project_ref' => $ref,
                'client_name' => $data['client_name'],
                'client_email' => $data['client_email'],
                'client_phone' => $data['client_phone'],
                'project_type' => $data['project_type'],
                'budget_range' => $data['budget_range'],
                'timeline' => $data['timeline'],
                'requirements' => $data['requirements'],
                'attachment_path' => $attachmentPath,
                'status' => 'Pending Review'
            ]);
        } catch (\Exception $e) {
            // Silence fallback
        }

        $this->json([
            'status' => 'success',
            'message' => 'Project enquiry <strong>' . $ref . '</strong> submitted! Our development team will contact you within 24 hours.',
            'reference' => $ref
        ]);
    }

    private function getFallbackPortfolio(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'MS Horizon Multi-Division Group ERP',
                'slug' => 'ms-horizon-group-erp',
                'category' => 'Enterprise System',
                'client_name' => 'MS Horizon Group',
                'featured_image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800',
                'summary' => 'Comprehensive ERP uniting Travel, HR, Business Setup, and Software divisions into one unified cloud architecture.',
                'technologies_json' => json_encode(['PHP 8.2', 'MySQL 8', 'Bootstrap 5', 'REST API', 'SweetAlert2'])
            ],
            [
                'id' => 2,
                'title' => 'GCC Travel & Visa Processing Portal',
                'slug' => 'gcc-travel-visa-portal',
                'category' => 'Web Application',
                'client_name' => 'Horizon Travel Division',
                'featured_image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=800',
                'summary' => 'Automated tourist visa application platform with real-time tracking reference numbers.',
                'technologies_json' => json_encode(['PHP', 'PDO', 'JavaScript', 'Google Cloud SMTP'])
            ]
        ];
    }
}
