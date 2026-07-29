<?php
namespace App\Core;

/**
 * Base Enterprise MVC Controller
 */
abstract class Controller
{
    protected function render(string $view, array $data = [], string $layout = 'header'): void
    {
        extract($data);
        $csrf_token = Session::generateCsrf();
        $current_user = Session::get('user');

        $viewPath = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            die("View [{$view}] not found at {$viewPath}");
        }

        // Include Navbar & Header
        if ($layout === 'admin') {
            require_once __DIR__ . '/../Views/layouts/admin_layout.php';
        } else {
            require_once __DIR__ . '/../Views/layouts/header.php';
            require_once __DIR__ . '/../Views/layouts/navbar.php';
            require_once $viewPath;
            require_once __DIR__ . '/../Views/layouts/footer.php';
        }
    }

    protected function renderAdmin(string $view, array $data = []): void
    {
        $this->render($view, $data, 'admin');
    }

    protected function json(array $data, int $statusCode = 200): void
    {
        Response::json($data, $statusCode);
    }

    protected function redirect(string $url): void
    {
        Response::redirect($url);
    }
}
