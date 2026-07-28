<?php
require_once __DIR__ . '/config.php';

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = __DIR__ . '/app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) require $file;
});

use App\Services\AuthService;

$auth = new AuthService();
$user = $auth->login('admin@mshorizontravel.com', 'AdminPass2026!');

if ($user) {
    echo "🎉 LOGIN SUCCESSFUL!\n";
    echo "User Name: " . $user['name'] . "\n";
    echo "User Email: " . $user['email'] . "\n";
    echo "User Role: " . $user['role_slug'] . "\n";
    echo "Redirect Path: /admin/dashboard\n";
} else {
    echo "❌ LOGIN FAILED\n";
}
