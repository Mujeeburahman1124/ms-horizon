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
        $portfolio = Database::fetchAll("SELECT * FROM software_portfolio WHERE featured = 1 ORDER BY id DESC LIMIT 6");
        $this->render('software/index', [
            'page_title' => 'Software Development | Web Apps, Mobile & Automation — MS Horizon Group',
            'page_description' => 'Custom PHP web applications, e-commerce platforms, mobile apps, CRM systems, and travel portal development across UAE and GCC.',
            'portfolio' => $portfolio,
        ]);
    }

    public function portfolio(): void
    {
        $category = Request::get('category', '');
        $sql = "SELECT * FROM software_portfolio";
        $params = [];
        if ($category) {
            $sql .= " WHERE category = :cat";
            $params['cat'] = $category;
        }
        $sql .= " ORDER BY id DESC";
        $portfolio = Database::fetchAll($sql, $params);
        $categories = Database::fetchAll("SELECT DISTINCT category FROM software_portfolio ORDER BY category");

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
        $project = Database::fetchOne("SELECT * FROM software_portfolio WHERE slug = :slug", ['slug' => $slug]);
        if (!$project) {
            $this->redirect('/software/portfolio');
            return;
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

        $this->json([
            'status' => 'success',
            'message' => 'Project enquiry <strong>' . $ref . '</strong> submitted! Our development team will contact you within 24 hours.',
            'reference' => $ref
        ]);
    }
}
