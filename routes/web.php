<?php

use App\Core\Router;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;

// ─────────────────────────────────────────────────────────────
// PUBLIC ROUTES
// ─────────────────────────────────────────────────────────────

// Home
Router::get('/', [\App\Controllers\HomeController::class, 'index']);
Router::post('/quick-enquiry', [\App\Controllers\HomeController::class, 'quickEnquiry'], [CsrfMiddleware::class]);
Router::post('/newsletter', [\App\Controllers\HomeController::class, 'newsletter'], [CsrfMiddleware::class]);

// About, Services, Policies
Router::get('/about', [\App\Controllers\PageController::class, 'about']);
Router::get('/services', [\App\Controllers\PageController::class, 'services']);
Router::get('/faqs', [\App\Controllers\PageController::class, 'faqs']);
Router::get('/sitemap', [\App\Controllers\PageController::class, 'sitemap']);
Router::get('/privacy-policy', [\App\Controllers\PageController::class, 'privacyPolicy']);
Router::get('/terms-conditions', [\App\Controllers\PageController::class, 'termsConditions']);
Router::get('/refund-policy', [\App\Controllers\PageController::class, 'refundPolicy']);
Router::get('/cookie-policy', [\App\Controllers\PageController::class, 'cookiePolicy']);
Router::get('/search', [\App\Controllers\PageController::class, 'search']);

// Contact
Router::get('/contact', [\App\Controllers\ContactController::class, 'index']);
Router::post('/contact', [\App\Controllers\ContactController::class, 'submit'], [CsrfMiddleware::class]);

// Blog
Router::get('/blog', [\App\Controllers\BlogController::class, 'index']);
Router::get('/blog/{slug}', [\App\Controllers\BlogController::class, 'show']);

// Offers
Router::get('/offers', [\App\Controllers\OfferController::class, 'index']);
Router::get('/offers/{slug}', [\App\Controllers\OfferController::class, 'show']);

// ─────────────────────────────────────────────────────────────
// TRAVEL & TOURISM DIVISION
// ─────────────────────────────────────────────────────────────
Router::get('/travel', [\App\Controllers\TravelController::class, 'index']);
Router::get('/countries', [\App\Controllers\TravelController::class, 'countries']);
Router::get('/travel/countries', [\App\Controllers\TravelController::class, 'countries']);
Router::get('/travel/visa/{slug}', [\App\Controllers\TravelController::class, 'visaDetail']);
Router::post('/travel/apply', [\App\Controllers\TravelController::class, 'applyVisa'], [CsrfMiddleware::class]);
Router::get('/travel/track', [\App\Controllers\TravelController::class, 'trackForm']);
Router::post('/travel/track', [\App\Controllers\TravelController::class, 'trackResult'], [CsrfMiddleware::class]);

// ─────────────────────────────────────────────────────────────
// RESERVATIONS DIVISION
// ─────────────────────────────────────────────────────────────
Router::get('/reservations', [\App\Controllers\ReservationController::class, 'index']);
Router::post('/reservations/enquire', [\App\Controllers\ReservationController::class, 'enquire'], [CsrfMiddleware::class]);

// ─────────────────────────────────────────────────────────────
// HR / CAREERS DIVISION
// ─────────────────────────────────────────────────────────────
Router::get('/careers', [\App\Controllers\HRController::class, 'careers']);
Router::get('/careers/{slug}', [\App\Controllers\HRController::class, 'jobDetail']);
Router::post('/careers/{slug}/apply', [\App\Controllers\HRController::class, 'applyJob'], [CsrfMiddleware::class]);

// Candidate Portal
Router::get('/candidate/register', [\App\Controllers\HRController::class, 'candidateRegisterForm']);
Router::post('/candidate/register', [\App\Controllers\HRController::class, 'candidateRegister'], [CsrfMiddleware::class]);

// ─────────────────────────────────────────────────────────────
// BUSINESS CONSULTANCY DIVISION
// ─────────────────────────────────────────────────────────────
Router::get('/business', [\App\Controllers\BusinessController::class, 'index']);
Router::get('/business/packages', [\App\Controllers\BusinessController::class, 'packages']);
Router::post('/business/enquire', [\App\Controllers\BusinessController::class, 'enquire'], [CsrfMiddleware::class]);

// ─────────────────────────────────────────────────────────────
// SOFTWARE DEVELOPMENT DIVISION
// ─────────────────────────────────────────────────────────────
Router::get('/software', [\App\Controllers\SoftwareController::class, 'index']);
Router::get('/software/portfolio', [\App\Controllers\SoftwareController::class, 'portfolio']);
Router::get('/software/portfolio/{slug}', [\App\Controllers\SoftwareController::class, 'projectDetail']);
Router::post('/software/enquire', [\App\Controllers\SoftwareController::class, 'enquire'], [CsrfMiddleware::class]);

// ─────────────────────────────────────────────────────────────
// AUTHENTICATION ROUTES
// ─────────────────────────────────────────────────────────────
Router::get('/login', [\App\Controllers\AuthController::class, 'loginForm']);
Router::post('/login', [\App\Controllers\AuthController::class, 'login'], [CsrfMiddleware::class]);
Router::get('/logout', [\App\Controllers\AuthController::class, 'logout']);

// Forgot Password & OTP Recovery Flow
Router::get('/forgot-password', [\App\Controllers\AuthController::class, 'forgotPasswordForm']);
Router::post('/forgot-password/send-otp', [\App\Controllers\AuthController::class, 'sendPasswordResetOtp'], [CsrfMiddleware::class]);
Router::post('/forgot-password/reset', [\App\Controllers\AuthController::class, 'resetPassword'], [CsrfMiddleware::class]);

// OTP Endpoints (AJAX)
Router::post('/auth/send-otp', [\App\Controllers\AuthController::class, 'sendOtp'], [CsrfMiddleware::class]);
Router::post('/auth/verify-otp', [\App\Controllers\AuthController::class, 'verifyOtp'], [CsrfMiddleware::class]);

// ─────────────────────────────────────────────────────────────
// PROTECTED ADMIN DASHBOARD & MANAGEMENT PORTALS
// ─────────────────────────────────────────────────────────────

// Main Dashboard
Router::get('/admin/dashboard', [\App\Controllers\Admin\DashboardController::class, 'index'], [AuthMiddleware::class]);
Router::get('/admin/export/{type}', [\App\Controllers\Admin\DashboardController::class, 'exportReport'], [AuthMiddleware::class]);

// Travel & Visa Admin
Router::get('/admin/visas', [\App\Controllers\Admin\TravelAdminController::class, 'index'], [AuthMiddleware::class]);
Router::get('/admin/visas/{id}', [\App\Controllers\Admin\TravelAdminController::class, 'visaDetail'], [AuthMiddleware::class]);
Router::post('/admin/visas/create', [\App\Controllers\Admin\TravelAdminController::class, 'createVisa'], [AuthMiddleware::class, CsrfMiddleware::class]);
Router::post('/admin/visas/update-status', [\App\Controllers\Admin\TravelAdminController::class, 'updateStatus'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Reservations Admin
Router::get('/admin/reservations', [\App\Controllers\Admin\ReservationAdminController::class, 'index'], [AuthMiddleware::class]);
Router::get('/admin/reservations/{id}', [\App\Controllers\Admin\ReservationAdminController::class, 'detail'], [AuthMiddleware::class]);
Router::post('/admin/reservations/update-status', [\App\Controllers\Admin\ReservationAdminController::class, 'updateStatus'], [AuthMiddleware::class, CsrfMiddleware::class]);

// HR Admin
Router::get('/admin/hr', [\App\Controllers\Admin\HRAdminController::class, 'index'], [AuthMiddleware::class]);
Router::get('/admin/jobs', [\App\Controllers\Admin\HRAdminController::class, 'jobs'], [AuthMiddleware::class]);
Router::post('/admin/jobs/create', [\App\Controllers\Admin\HRAdminController::class, 'createJob'], [AuthMiddleware::class, CsrfMiddleware::class]);
Router::get('/admin/candidates', [\App\Controllers\Admin\HRAdminController::class, 'candidates'], [AuthMiddleware::class]);
Router::get('/admin/candidates/{id}', [\App\Controllers\Admin\HRAdminController::class, 'candidateDetail'], [AuthMiddleware::class]);

// Business Admin
Router::get('/admin/business-leads', [\App\Controllers\Admin\BusinessAdminController::class, 'index'], [AuthMiddleware::class]);
Router::get('/admin/business-leads/{id}', [\App\Controllers\Admin\BusinessAdminController::class, 'detail'], [AuthMiddleware::class]);
Router::post('/admin/business-leads/status', [\App\Controllers\Admin\BusinessAdminController::class, 'updateStatus'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Software Admin
Router::get('/admin/software-projects', [\App\Controllers\Admin\SoftwareAdminController::class, 'index'], [AuthMiddleware::class]);
Router::get('/admin/software-projects/{id}', [\App\Controllers\Admin\SoftwareAdminController::class, 'projectDetail'], [AuthMiddleware::class]);
Router::post('/admin/software-projects/status', [\App\Controllers\Admin\SoftwareAdminController::class, 'updateStatus'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Content Admin
Router::get('/admin/blog', [\App\Controllers\Admin\ContentAdminController::class, 'blogs'], [AuthMiddleware::class]);
Router::get('/admin/offers', [\App\Controllers\Admin\ContentAdminController::class, 'offers'], [AuthMiddleware::class]);
Router::get('/admin/enquiries', [\App\Controllers\Admin\ContentAdminController::class, 'enquiries'], [AuthMiddleware::class]);
Router::get('/admin/audit-logs', [\App\Controllers\Admin\ContentAdminController::class, 'auditLogs'], [AuthMiddleware::class]);

// Users & Staff Admin
Router::get('/admin/users', [\App\Controllers\Admin\UserAdminController::class, 'index'], [AuthMiddleware::class]);
Router::post('/admin/users/create', [\App\Controllers\Admin\UserAdminController::class, 'create'], [AuthMiddleware::class, CsrfMiddleware::class]);
Router::post('/admin/users/toggle-active', [\App\Controllers\Admin\UserAdminController::class, 'toggleActive'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Candidate Portal
Router::get('/candidate/dashboard', [\App\Controllers\CandidateController::class, 'dashboard'], [AuthMiddleware::class]);
Router::get('/candidate/profile', [\App\Controllers\CandidateController::class, 'profile'], [AuthMiddleware::class]);
Router::post('/candidate/profile/update', [\App\Controllers\CandidateController::class, 'updateProfile'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Fallback 404
Router::get('/404', [\App\Controllers\PageController::class, 'notFound']);
