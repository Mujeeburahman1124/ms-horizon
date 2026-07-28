<?php
namespace App\Controllers\Admin;

use App\Core\Database;
use App\Core\Request;
use App\Models\Offer;
use App\Models\Blog;
use App\Services\UploadService;

class OfferAdminController extends DashboardController
{
    public function index(): void
    {
        $active = Offer::getActive();
        $archived = Offer::getArchived();
        $divisions = Database::fetchAll("SELECT * FROM divisions ORDER BY title");
        $this->renderAdmin('admin/offers', [
            'page_title' => 'Offers & Promotions — MS Horizon Admin',
            'active_offers' => $active,
            'archived_offers' => $archived,
            'divisions' => $divisions,
        ]);
    }

    public function create(): void
    {
        $data = Request::getBody();
        $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $data['title'] ?? 'offer')) . '-' . time();

        $imagePath = 'default-offer.jpg';
        if (!empty($_FILES['promotional_image']['tmp_name'])) {
            $uploader = new UploadService('offers');
            $result = $uploader->upload($_FILES['promotional_image']);
            if ($result['success']) $imagePath = $result['path'];
        }

        Offer::create([
            'division_id' => $data['division_id'],
            'title' => $data['title'],
            'slug' => $slug,
            'original_price' => $data['original_price'],
            'offer_price' => $data['offer_price'],
            'promotional_image' => $imagePath,
            'start_date' => $data['start_date'],
            'expiry_date' => $data['expiry_date'],
            'terms' => $data['terms'],
        ]);

        $this->json(['status' => 'success', 'message' => 'Offer published successfully.']);
    }

    public function delete(string $id): void
    {
        Offer::delete((int)$id);
        $this->json(['status' => 'success', 'message' => 'Offer deleted.']);
    }
}

class SoftwareAdminController extends DashboardController
{
    public function index(): void
    {
        $projects = Database::fetchAll("SELECT * FROM software_projects ORDER BY id DESC");
        $this->renderAdmin('admin/software_projects', [
            'page_title' => 'Software Project Enquiries — MS Horizon Admin',
            'projects' => $projects,
        ]);
    }

    public function show(string $id): void
    {
        $project = Database::fetchOne("SELECT * FROM software_projects WHERE id = :id", ['id' => $id]);
        if (!$project) { $this->redirect('/admin/software-projects'); return; }
        $this->renderAdmin('admin/software_project_detail', [
            'page_title' => 'Project #' . $id . ' — Admin',
            'project' => $project,
        ]);
    }
}

class ContentAdminController extends DashboardController
{
    public function blogIndex(): void
    {
        $blogs = Blog::getPublished(50);
        $this->renderAdmin('admin/blogs', [
            'page_title' => 'Blog Management — MS Horizon Admin',
            'blogs' => $blogs,
        ]);
    }

    public function createBlog(): void
    {
        $data = Request::getBody();
        $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $data['title'] ?? 'post')) . '-' . time();
        $imagePath = 'default-blog.jpg';
        if (!empty($_FILES['featured_image']['tmp_name'])) {
            $uploader = new UploadService('blog_images');
            $result = $uploader->upload($_FILES['featured_image']);
            if ($result['success']) $imagePath = $result['path'];
        }
        Blog::create([
            'title' => $data['title'],
            'slug' => $slug,
            'author' => $data['author'] ?? 'MS Horizon Editorial',
            'category' => $data['category'],
            'featured_image' => $imagePath,
            'content' => $data['content'],
            'is_published' => 1
        ]);
        $this->json(['status' => 'success', 'message' => 'Blog post published.']);
    }

    public function deleteBlog(string $id): void
    {
        Blog::delete((int)$id);
        $this->json(['status' => 'success', 'message' => 'Blog post deleted.']);
    }
}

class UserAdminController extends DashboardController
{
    public function index(): void
    {
        $users = \App\Models\User::getAll();
        $roles = Database::fetchAll("SELECT * FROM roles ORDER BY title");
        $this->renderAdmin('admin/users', [
            'page_title' => 'User & Role Management — MS Horizon Admin',
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function create(): void
    {
        $data = Request::getBody();
        $auth = new \App\Services\AuthService();
        $userId = $auth->register([
            'role_id' => $data['role_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'] ?? null,
        ]);
        $this->json(['status' => 'success', 'message' => 'Staff account created. User ID: ' . $userId]);
    }

    public function delete(string $id): void
    {
        Database::update('users', ['deleted_at' => date('Y-m-d H:i:s')], 'id = :id', ['id' => $id]);
        $this->json(['status' => 'success', 'message' => 'User soft-deleted.']);
    }
}
