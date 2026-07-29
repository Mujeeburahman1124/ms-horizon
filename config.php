<?php
/**
 * MS Horizon Group - Enterprise Configuration (Dynamic APP_URL Auto-Detect + Gmail SMTP + Multilingual Engine)
 */

// Language Session & Cookie Handler
if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}
if (isset($_GET['lang'])) {
    $lang = in_array($_GET['lang'], ['en', 'ar', 'ta']) ? $_GET['lang'] : 'en';
    $_SESSION['app_lang'] = $lang;
    @setcookie('app_lang', $lang, time() + 86400 * 30, '/');
}
define('APP_LANG', $_SESSION['app_lang'] ?? $_COOKIE['app_lang'] ?? 'en');

function __t(string $text): string {
    static $dictionary = [
        'ar' => [
            'Home' => 'الرئيسية',
            'Services' => 'الخدمات',
            'Countries' => 'الدول والـتأشيرات',
            'Offers' => 'العروض الخاصة',
            'Careers' => 'الوظائف والتوظيف',
            'About Us' => 'عن المجموعة',
            'Contact Us' => 'اتصل بنا',
            'Portal Login' => 'تسجيل الدخول',
            'Dashboard' => 'لوحة التحكم',
            'One Group. Multiple Solutions.' => 'مجموعة واحدة. حلول متكاملة.',
            'Get a Free Consultation' => 'احصل على استشارة مجانية',
            'Explore Our Services' => 'استكشف خدماتنا',
        ],
        'ta' => [
            'Home' => 'முகப்பு',
            'Services' => 'சேவைகள்',
            'Countries' => 'நாடுகள் & விசா',
            'Offers' => 'சிறப்பு சலுகைகள்',
            'Careers' => 'வேலைவாய்ப்பு',
            'About Us' => 'எங்களைப் பற்றி',
            'Contact Us' => 'தொடர்பு கொள்ள',
            'Portal Login' => 'போர்ட்டல் உள்நுழைவு',
            'Dashboard' => 'டேஷ்போர்டு',
            'One Group. Multiple Solutions.' => 'ஒரே குழுமம். பல தீர்வுகள்.',
            'Get a Free Consultation' => 'இலவச ஆலோசனை பெற',
            'Explore Our Services' => 'சேவைகளை அறிய',
        ]
    ];
    $lang = APP_LANG;
    return $dictionary[$lang][$text] ?? $text;
}

// Dynamic APP_URL Auto-Detection for Localhost & Cloud Vercel Hosting
if (!defined('APP_URL')) {
    $envUrl = getenv('APP_URL');
    if (!empty($envUrl)) {
        $appUrl = rtrim($envUrl, '/');
    } else {
        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') || 
                  (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') 
                  ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $basePath = (str_contains($host, 'localhost') || str_contains($host, '127.0.0.1')) ? '/ms-horizon' : '';
        $appUrl = $scheme . '://' . $host . $basePath;
    }
    define('APP_URL', $appUrl);
}

// Application Environment
define('APP_ENV', getenv('APP_ENV') ?: 'development');
define('APP_NAME', getenv('APP_NAME') ?: 'MS Horizon Group');
define('APP_SLOGAN', 'Empowering Global Progress through Integrated Solutions');

// Database Configuration (MySQL 8 / Railway Cloud MySQL)
define('DB_HOST', getenv('DB_HOST') ?: 'sakura.proxy.rlwy.net');
define('DB_PORT', getenv('DB_PORT') ?: '49932');
define('DB_NAME', getenv('DB_NAME') ?: 'railway');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : 'nIILZhVZJnSzcrcMdXzVhbLFiwGfgrPh');
define('DB_CHARSET', 'utf8mb4');

// Real-Time SMTP Email Configuration
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
define('SESSION_LIFETIME', 7200);
define('CSRF_TOKEN_NAME', 'mshorizon_csrf_token');

// Upload Paths
define('UPLOAD_DIR', __DIR__ . '/public/assets/uploads/');
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024);
define('ALLOWED_FILE_EXTENSIONS', ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'webp']);

// Auto-Archive Expired Offers
if (date('H') === '00' && rand(1, 100) === 1) {
    @\App\Models\Offer::autoArchiveExpired();
}
