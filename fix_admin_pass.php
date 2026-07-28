<?php
require_once __DIR__ . '/config.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $hash = password_hash('AdminPass2026!', PASSWORD_BCRYPT, ['cost' => 12]);

    $stmt = $pdo->prepare("UPDATE users SET password_hash = :hash WHERE email = 'admin@mshorizontravel.com'");
    $stmt->execute(['hash' => $hash]);

    echo "SUCCESS: Admin password hash for admin@mshorizontravel.com updated to real BCrypt hash of AdminPass2026!";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
