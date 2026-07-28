<?php
require_once __DIR__ . '/config.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    $sql = "CREATE TABLE IF NOT EXISTS `otp_verifications` (
      `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `email` VARCHAR(150) NOT NULL,
      `otp_code` VARCHAR(10) NOT NULL,
      `purpose` VARCHAR(50) DEFAULT 'login',
      `expires_at` DATETIME NOT NULL,
      `is_used` TINYINT(1) DEFAULT 0,
      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;";
    
    $pdo->exec($sql);
    echo "SUCCESS: Table otp_verifications created successfully in ms_horizon database!";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
