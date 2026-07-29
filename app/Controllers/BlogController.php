<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index(): void
    {
        $page = (int)Request::get('page', 1);
        $limit = 6;
        $offset = ($page - 1) * $limit;

        $blogs = Blog::getPublished($limit, $offset);
        $total = Blog::countPublished();

        $this->render('pages/blog', [
            'page_title' => 'News & Corporate Blog — MS Horizon Group',
            'page_description' => 'Latest news, business setup insights, travel tips, and technology trends from MS Horizon Group.',
            'blogs' => $blogs,
            'current_page' => $page,
            'total_pages' => max(1, ceil($total / $limit))
        ]);
    }

    public function show(string $slug): void
    {
        $blog = Blog::findBySlug($slug);
        if (!$blog) {
            $this->redirect('/blog');
            return;
        }

        $this->render('pages/blog', [
            'page_title' => $blog['title'] . ' — MS Horizon Blog',
            'page_description' => $blog['excerpt'] ?? '',
            'blogs' => [$blog],
            'current_page' => 1,
            'total_pages' => 1
        ]);
    }
}
