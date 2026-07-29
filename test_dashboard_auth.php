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

use App\Core\Session;
use App\Controllers\Admin\DashboardController;

// Simulate active user session
Session::set('user', [
    'id' => 1,
    'name' => 'Group Super Admin',
    'email' => 'admin@mshorizontravel.com',
    'role_id' => 1,
    'role_slug' => 'super_admin',
    'role_title' => 'Super Admin',
    'avatar' => 'default-avatar.png'
]);

echo "Testing DashboardController::index()...\n";

ob_start();
$controller = new DashboardController();
$controller->index();
$output = ob_get_clean();

if (str_contains($output, 'Executive Dashboard') && str_contains($output, 'Admin Control Panel')) {
    echo "🎉 DASHBOARD LOADED SUCCESSFULLY WITHOUT ANY ERRORS!\n";
    echo "Output length: " . strlen($output) . " bytes\n";
} else {
    echo "❌ DASHBOARD FAILED TO RENDER PROPERLY\n";
}
