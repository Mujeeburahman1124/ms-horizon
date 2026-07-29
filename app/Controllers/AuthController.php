<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Services\AuthService;
use App\Services\OtpService;
use App\Models\User;

class AuthController extends Controller
{
    private AuthService $auth;

    public function __construct()
    {
        $this->auth = new AuthService();
    }

    public function showLoginForm(): void
    {
        $this->loginForm();
    }

    public function loginForm(): void
    {
        if ($this->auth->isAuthenticated()) {
            $this->redirect('/admin/dashboard');
            return;
        }
        $this->render('auth/login', [
            'page_title' => 'Staff & Portal Login — MS Horizon Group',
        ]);
    }

    public function login(): void
    {
        $data = Request::getBody();
        $validator = new Validator();
        if (!$validator->validate($data, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ])) {
            if (Request::isAjax()) {
                $this->json(['status' => 'error', 'message' => $validator->getFirstError()]);
            } else {
                Session::setFlash('error', $validator->getFirstError());
                $this->redirect('/login');
            }
            return;
        }

        $user = $this->auth->login($data['email'], $data['password']);

        if (!$user) {
            if (Request::isAjax()) {
                $this->json(['status' => 'error', 'message' => 'Invalid email or password. Please try again.']);
            } else {
                Session::setFlash('error', 'Invalid credentials.');
                $this->redirect('/login');
            }
            return;
        }

        // Redirect based on role
        $redirect = match($user['role_slug']) {
            'super_admin', 'group_manager', 'travel_manager', 'reservation_officer',
            'recruitment_manager', 'recruiter', 'business_consultant', 'software_pm',
            'accounts_officer', 'customer_support', 'content_manager' => '/admin/dashboard',
            default => '/candidate/dashboard'
        };

        if (Request::isAjax()) {
            $this->json(['status' => 'success', 'message' => 'Login successful! Redirecting...', 'redirect' => APP_URL . $redirect]);
        } else {
            $this->redirect($redirect);
        }
    }

    public function sendOtp(): void
    {
        $email = Request::get('email');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json(['status' => 'error', 'message' => 'Valid email address is required.'], 400);
            return;
        }

        $result = OtpService::sendOtp($email, 'login');
        $this->json($result);
    }

    public function verifyOtp(): void
    {
        $email = Request::get('email');
        $otp = Request::get('otp');

        if (!$email || !$otp) {
            $this->json(['status' => 'error', 'message' => 'Email and OTP code are required.'], 400);
            return;
        }

        $isValid = OtpService::verifyOtp($email, $otp, 'login');
        if ($isValid) {
            $this->json(['status' => 'success', 'message' => 'OTP Code verified successfully!']);
        } else {
            $this->json(['status' => 'error', 'message' => 'Invalid or expired OTP code.'], 400);
        }
    }

    public function showForgotForm(): void
    {
        $this->forgotPasswordForm();
    }

    public function forgotPasswordForm(): void
    {
        $this->render('auth/forgot_password', [
            'page_title' => 'Forgot Password & OTP Recovery — MS Horizon Group',
        ]);
    }

    public function sendPasswordResetOtp(): void
    {
        $email = Request::get('email');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->json(['status' => 'error', 'message' => 'Valid email address is required.']);
            return;
        }

        $user = User::findByEmail($email);
        if (!$user) {
            $this->json(['status' => 'error', 'message' => 'No registered account found with this email address.']);
            return;
        }

        $result = OtpService::sendOtp($email, 'password_reset');
        $this->json($result);
    }

    public function resetPassword(): void
    {
        $email = Request::get('email');
        $otp = Request::get('otp');
        $newPassword = Request::get('new_password');

        if (!$email || !$otp || strlen($newPassword ?? '') < 6) {
            $this->json(['status' => 'error', 'message' => 'Email, 6-digit OTP code, and a new password (min 6 chars) are required.']);
            return;
        }

        if (!OtpService::verifyOtp($email, $otp, 'password_reset')) {
            $this->json(['status' => 'error', 'message' => 'Invalid or expired OTP verification code.']);
            return;
        }

        $hash = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
        Database::query("UPDATE users SET password_hash = :hash WHERE email = :email", [
            'hash' => $hash,
            'email' => $email
        ]);

        $this->json(['status' => 'success', 'message' => 'Your password has been reset successfully! You may now sign in.', 'redirect' => APP_URL . '/login']);
    }

    public function logout(): void
    {
        $this->auth->logout();
        Session::setFlash('success', 'You have been signed out successfully.');
        $this->redirect('/login');
    }

    public function registerForm(): void
    {
        $this->render('auth/register', [
            'page_title' => 'Register — MS Horizon Group',
        ]);
    }

    public function register(): void
    {
        $this->redirect('/candidate/register');
    }
}
