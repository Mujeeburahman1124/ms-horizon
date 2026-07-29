<?php
require_once __DIR__ . '/config.php';

$host = 'sakura.proxy.rlwy.net';
$port = 49932;
$dbname = 'railway';
$user = 'root';
$pass = 'nIILZhVZJnSzcrcMdXzVhbLFiwGfgrPh';

echo "Connecting to Railway Cloud MySQL ($host:$port)...\n";

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    echo "✅ Connected to Railway MySQL successfully!\n";

    echo "Importing schema.sql...\n";
    $schemaSql = file_get_contents(__DIR__ . '/database/schema.sql');
    $pdo->exec($schemaSql);
    echo "✅ Schema tables created!\n";

    echo "Importing seeders.sql...\n";
    $seedersSql = file_get_contents(__DIR__ . '/database/seeders.sql');
    $pdo->exec($seedersSql);
    echo "✅ Default data and admin seeders populated!\n";

    // Also set the correct BCrypt admin password hash
    $adminHash = password_hash('AdminPass2026!', PASSWORD_BCRYPT, ['cost' => 12]);
    $stmt = $pdo->prepare("UPDATE users SET password_hash = :hash WHERE email = 'admin@mshorizontravel.com'");
    $stmt->execute(['hash' => $adminHash]);
    echo "✅ Admin password hash updated!\n";

    echo "\n🎉 RAILWAY DATABASE MIGRATION COMPLETE! YOUR CLOUD DB IS 100% READY FOR VERCEL!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
