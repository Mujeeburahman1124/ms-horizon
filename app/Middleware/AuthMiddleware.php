<?php
namespace App\Middleware;

use App\Core\Session;
use App\Core\Response;

/**
 * Session Authentication Middleware
 */
class AuthMiddleware
{
    public function handle(): bool
    {
        Session::start();
        if (!Session::has('user')) {
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                Response::json(['status' => 'error', 'message' => 'Unauthorized session. Please log in.'], 401);
            } else {
                Session::setFlash('error', 'Please sign in to access this portal.');
                Response::redirect('/login');
            }
            return false;
        }
        return true;
    }
}
