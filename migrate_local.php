<?php
/**
 * MS Horizon Group — Local Database Migration Script
 */
$host = 'localhost';
$port = '3306';
$user = 'root';
$pass = '';
$dbname = 'ms_horizon';

try {
    $pdo = new PDO("mysql:host=$host;port=$port", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$dbname`");
    echo "✅ Database `$dbname` ready on local MySQL.\n";

    // Run schema
    $schemaSql = file_get_contents(__DIR__ . '/database/schema.sql');
    $pdo->exec($schemaSql);
    echo "✅ Schema v2.0 imported successfully into local MySQL.\n";

    // Run seeders
    $seedersSql = file_get_contents(__DIR__ . '/database/seeders.sql');
    $pdo->exec($seedersSql);
    echo "✅ Seeders v2.0 imported successfully into local MySQL.\n";

    // Check Admin user
    $adminEmail = 'admin@mshorizontravel.com';
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$adminEmail]);
    if (!$stmt->fetch()) {
        $hash = password_hash('AdminPass2026!', PASSWORD_BCRYPT, ['cost' => 12]);
        $ins = $pdo->prepare("INSERT INTO users (name, email, password_hash, role_slug, role_title, is_active) VALUES (?, ?, ?, 'super_admin', 'Super Administrator', 1)");
        $ins->execute(['Group Super Admin', $adminEmail, $hash]);
        echo "✅ Admin user created: $adminEmail / AdminPass2026!\n";
    } else {
        echo "✅ Admin user verified: $adminEmail\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
