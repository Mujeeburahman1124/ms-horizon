<?php

// ============================================================================
// MS HORIZON GROUP - APPLICATION ROUTES
// ============================================================================

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

// FAQs
Router::get('/faqs', [\App\Controllers\PageController::class, 'faqs']);

// Offers
Router::get('/offers', [\App\Controllers\OfferController::class, 'index']);
Router::get('/offers/{slug}', [\App\Controllers\OfferController::class, 'show']);

// ─────────────────────────────────────────────────────────────
// TRAVEL & TOURISM DIVISION
// ─────────────────────────────────────────────────────────────
Router::get('/travel', [\App\Controllers\TravelController::class, 'index']);
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
Router::get('/candidate/dashboard', [\App\Controllers\HRController::class, 'candidateDashboard'], [AuthMiddleware::class]);

// Employer Portal
Router::get('/employer/register', [\App\Controllers\HRController::class, 'employerRegisterForm']);
Router::post('/employer/register', [\App\Controllers\HRController::class, 'employerRegister'], [CsrfMiddleware::class]);
Router::get('/employer/dashboard', [\App\Controllers\HRController::class, 'employerDashboard'], [AuthMiddleware::class]);
Router::post('/employer/post-job', [\App\Controllers\HRController::class, 'postJob'], [AuthMiddleware::class, CsrfMiddleware::class]);

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
// AUTHENTICATION & REAL-TIME OTP ROUTES
// ─────────────────────────────────────────────────────────────
Router::get('/login', [\App\Controllers\AuthController::class, 'loginForm']);
Router::post('/login', [\App\Controllers\AuthController::class, 'login'], [CsrfMiddleware::class]);
Router::post('/auth/send-otp', [\App\Controllers\AuthController::class, 'sendOtp']);
Router::post('/auth/verify-otp', [\App\Controllers\AuthController::class, 'verifyOtp']);
Router::get('/forgot-password', [\App\Controllers\AuthController::class, 'forgotPasswordForm']);
Router::post('/auth/send-reset-otp', [\App\Controllers\AuthController::class, 'sendPasswordResetOtp']);
Router::post('/auth/reset-password', [\App\Controllers\AuthController::class, 'resetPassword']);
Router::get('/logout', [\App\Controllers\AuthController::class, 'logout'], [AuthMiddleware::class]);
Router::get('/register', [\App\Controllers\AuthController::class, 'registerForm']);
Router::post('/register', [\App\Controllers\AuthController::class, 'register'], [CsrfMiddleware::class]);

// ─────────────────────────────────────────────────────────────
// ADMIN PANEL ROUTES
// ─────────────────────────────────────────────────────────────
Router::get('/admin', [\App\Controllers\Admin\DashboardController::class, 'index'], [AuthMiddleware::class]);
Router::get('/admin/dashboard', [\App\Controllers\Admin\DashboardController::class, 'index'], [AuthMiddleware::class]);

// Admin: Visa Applications
Router::get('/admin/visas', [\App\Controllers\Admin\VisaAdminController::class, 'index'], [AuthMiddleware::class]);
Router::get('/admin/visas/{id}', [\App\Controllers\Admin\VisaAdminController::class, 'show'], [AuthMiddleware::class]);
Router::post('/admin/visas/{id}/status', [\App\Controllers\Admin\VisaAdminController::class, 'updateStatus'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Admin: Reservations
Router::get('/admin/reservations', [\App\Controllers\Admin\ReservationAdminController::class, 'index'], [AuthMiddleware::class]);
Router::get('/admin/reservations/{id}', [\App\Controllers\Admin\ReservationAdminController::class, 'show'], [AuthMiddleware::class]);
Router::post('/admin/reservations/{id}/status', [\App\Controllers\Admin\ReservationAdminController::class, 'updateStatus'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Admin: HR / Candidates / Jobs
Router::get('/admin/candidates', [\App\Controllers\Admin\HRAdminController::class, 'candidates'], [AuthMiddleware::class]);
Router::get('/admin/candidates/{id}', [\App\Controllers\Admin\HRAdminController::class, 'showCandidate'], [AuthMiddleware::class]);
Router::post('/admin/candidates/{id}/unlock', [\App\Controllers\Admin\HRAdminController::class, 'unlockContact'], [AuthMiddleware::class, CsrfMiddleware::class]);
Router::get('/admin/jobs', [\App\Controllers\Admin\HRAdminController::class, 'jobs'], [AuthMiddleware::class]);
Router::post('/admin/jobs', [\App\Controllers\Admin\HRAdminController::class, 'createJob'], [AuthMiddleware::class, CsrfMiddleware::class]);
Router::post('/admin/jobs/{id}/delete', [\App\Controllers\Admin\HRAdminController::class, 'deleteJob'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Admin: Business Leads
Router::get('/admin/business-leads', [\App\Controllers\Admin\BusinessAdminController::class, 'index'], [AuthMiddleware::class]);
Router::get('/admin/business-leads/{id}', [\App\Controllers\Admin\BusinessAdminController::class, 'show'], [AuthMiddleware::class]);
Router::post('/admin/business-leads/{id}/status', [\App\Controllers\Admin\BusinessAdminController::class, 'updateStatus'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Admin: Software Projects
Router::get('/admin/software-projects', [\App\Controllers\Admin\SoftwareAdminController::class, 'index'], [AuthMiddleware::class]);
Router::get('/admin/software-projects/{id}', [\App\Controllers\Admin\SoftwareAdminController::class, 'show'], [AuthMiddleware::class]);

// Admin: Offers
Router::get('/admin/offers', [\App\Controllers\Admin\OfferAdminController::class, 'index'], [AuthMiddleware::class]);
Router::post('/admin/offers', [\App\Controllers\Admin\OfferAdminController::class, 'create'], [AuthMiddleware::class, CsrfMiddleware::class]);
Router::post('/admin/offers/{id}/delete', [\App\Controllers\Admin\OfferAdminController::class, 'delete'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Admin: Blog
Router::get('/admin/blog', [\App\Controllers\Admin\ContentAdminController::class, 'blogIndex'], [AuthMiddleware::class]);
Router::post('/admin/blog', [\App\Controllers\Admin\ContentAdminController::class, 'createBlog'], [AuthMiddleware::class, CsrfMiddleware::class]);
Router::post('/admin/blog/{id}/delete', [\App\Controllers\Admin\ContentAdminController::class, 'deleteBlog'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Admin: Enquiries
Router::get('/admin/enquiries', [\App\Controllers\Admin\DashboardController::class, 'enquiries'], [AuthMiddleware::class]);

// Admin: Users & Roles
Router::get('/admin/users', [\App\Controllers\Admin\UserAdminController::class, 'index'], [AuthMiddleware::class]);
Router::post('/admin/users', [\App\Controllers\Admin\UserAdminController::class, 'create'], [AuthMiddleware::class, CsrfMiddleware::class]);
Router::post('/admin/users/{id}/delete', [\App\Controllers\Admin\UserAdminController::class, 'delete'], [AuthMiddleware::class, CsrfMiddleware::class]);

// Admin: Audit Logs
Router::get('/admin/audit-logs', [\App\Controllers\Admin\DashboardController::class, 'auditLogs'], [AuthMiddleware::class]);
