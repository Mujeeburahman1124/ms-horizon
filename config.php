<?php
/**
 * MS Horizon Group - Enterprise Configuration (Real-Time Gmail SMTP Connected)
 */

// Application Environment
define('APP_ENV', getenv('APP_ENV') ?: 'development'); // 'development' or 'production'
define('APP_NAME', getenv('APP_NAME') ?: 'MS Horizon Group');
define('APP_SLOGAN', 'Empowering Global Progress through Integrated Solutions');
define('APP_URL', getenv('APP_URL') ?: 'http://localhost/ms-horizon');

// Database Configuration (MySQL 8)
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'ms_horizon');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');
define('DB_CHARSET', 'utf8mb4');

// Real-Time SMTP Email Configuration (Verified Gmail App Password Connected)
define('SMTP_ENABLED', true);
define('SMTP_HOST', getenv('SMTP_HOST') ?: 'smtp.gmail.com');
define('SMTP_PORT', getenv('SMTP_PORT') ?: 587);
define('SMTP_USER', getenv('SMTP_USER') ?: 'aqeelamrahman@gmail.com');
define('SMTP_PASS', getenv('SMTP_PASS') ?: 'zkeqpvtqxfpzngjz');
define('SMTP_ENCRYPTION', getenv('SMTP_ENCRYPTION') ?: 'tls');
define('MAIL_FROM_ADDRESS', getenv('MAIL_FROM_ADDRESS') ?: 'aqeelamrahman@gmail.com');
define('MAIL_FROM_NAME', getenv('MAIL_FROM_NAME') ?: 'MS Horizon Group');

// Company Contacts
define('SITE_PHONE', '+971 4 123 4567');
define('SITE_WHATSAPP', '971501234567');
define('SITE_EMAIL', 'info@mshorizontravel.com');

// Security Configuration
define('APP_KEY', getenv('APP_KEY') ?: 'mshorizon_secure_encryption_key_2026_enterprise_x89!');
define('SESSION_LIFETIME', 7200); // 2 hours
define('CSRF_TOKEN_NAME', 'mshorizon_csrf_token');

// Upload Paths
define('UPLOAD_DIR', __DIR__ . '/public/assets/uploads/');
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024); // 10MB
define('ALLOWED_FILE_EXTENSIONS', ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'webp']);

// Auto-Archive Expired Offers
if (date('H') === '00' && rand(1, 100) === 1) {
    @\App\Models\Offer::autoArchiveExpired();
}
