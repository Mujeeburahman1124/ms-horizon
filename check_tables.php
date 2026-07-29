<?php
$host = 'sakura.proxy.rlwy.net';
$port = 49932;
$dbname = 'railway';
$user = 'root';
$pass = 'nIILZhVZJnSzcrcMdXzVhbLFiwGfgrPh';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "Tables in Railway database (" . count($tables) . "):\n";
    print_r($tables);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
