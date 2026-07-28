<?php
namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;

/**
 * CSRF Protection Middleware
 */
class CsrfMiddleware
{
    public static function handle(): void
    {
        // Only validate CSRF on mutating requests (POST, PUT, DELETE, PATCH)
        if (Request::isPost()) {
            $sessionToken = Session::get(CSRF_TOKEN_NAME);
            $submittedToken = Request::get(CSRF_TOKEN_NAME)
                ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? null);

            if (!$sessionToken || !$submittedToken || !hash_equals($sessionToken, $submittedToken)) {
                if (Request::isAjax()) {
                    Response::json(['status' => 'error', 'message' => 'Invalid or expired CSRF security token. Please refresh the page and try again.'], 403);
                } else {
                    Session::setFlash('error', 'Invalid security token. Please try again.');
                    Response::redirect($_SERVER['HTTP_REFERER'] ?? '/');
                }
                exit;
            }
        }
    }
}
