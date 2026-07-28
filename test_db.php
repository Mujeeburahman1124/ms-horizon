<?php
/**
 * MS Horizon Group - Manual Database Connection & Diagnostic Tool
 * Open this file in your browser: http://localhost/ms-horizon/test_db.php
 * Or on Hostinger: https://yourdomain.com/test_db.php
 */

require_once __DIR__ . '/config.php';

$host = $_GET['host'] ?? DB_HOST;
$port = $_GET['port'] ?? DB_PORT;
$dbname = $_GET['dbname'] ?? DB_NAME;
$user = $_GET['user'] ?? DB_USER;
$pass = $_GET['pass'] ?? DB_PASS;

$status = null;
$message = '';
$tables = [];

if (isset($_GET['test']) || isset($_POST['test'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $host = $_POST['host'] ?? $host;
        $port = $_POST['port'] ?? $port;
        $dbname = $_POST['dbname'] ?? $dbname;
        $user = $_POST['user'] ?? $user;
        $pass = $_POST['pass'] ?? $pass;
    }

    try {
        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        $status = 'success';
        $message = "Successfully connected to MySQL database [{$dbname}] on {$host}:{$port}!";

        // Fetch tables list
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    } catch (PDOException $e) {
        $status = 'error';
        $message = "Database Connection Failed: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manual Database Connection Test — MS Horizon Group</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body { background: #0A1628; color: #E2E8F0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 3rem 0; }
    .card { background: #112240; border: 1px solid rgba(212,175,55,.3); border-radius: 16px; color: white; }
    .btn-gold { background: linear-gradient(135deg, #D4AF37, #F0CC5A); color: #0A1628; font-weight: 700; border: none; }
    .btn-gold:hover { background: #F0CC5A; color: #0A1628; }
  </style>
</head>
<body>
<div class="container" style="max-width: 650px;">
  <div class="card shadow-lg p-4 p-md-5">
    <div class="text-center mb-4">
      <h1 class="h3 font-weight-bold text-warning">MS Horizon Group</h1>
      <p class="text-muted small">Manual Database Connection Tester</p>
    </div>

    <?php if ($status === 'success'): ?>
      <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
        <div>
          <strong>Connection Successful!</strong><br>
          <?= htmlspecialchars($message) ?>
        </div>
      </div>
      <h2 class="h5 text-warning mb-3">Database Tables Found (<?= count($tables) ?>):</h2>
      <?php if (!empty($tables)): ?>
        <ul class="list-group list-group-flush bg-transparent border rounded mb-4" style="max-height: 200px; overflow-y: auto;">
          <?php foreach ($tables as $tbl): ?>
            <li class="list-group-item bg-dark text-white border-secondary">
              <i class="fas fa-table text-warning me-2"></i> <?= htmlspecialchars($tbl) ?>
            </li>
          <?php endforeach; ?>
        </ul>
      <?php else: ?>
        <div class="alert alert-warning">Database connected, but no tables found. Please run <code>install.php</code> or import <code>database/schema.sql</code>.</div>
      <?php endif; ?>
    <?php elseif ($status === 'error'): ?>
      <div class="alert alert-danger mb-4" role="alert">
        <strong>Connection Failed!</strong><br>
        <?= htmlspecialchars($message) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="test_db.php">
      <input type="hidden" name="test" value="1">

      <div class="row g-3 mb-3">
        <div class="col-8">
          <label class="form-label small text-uppercase text-muted">DB Host</label>
          <input type="text" name="host" value="<?= htmlspecialchars($host) ?>" class="form-control bg-dark text-white border-secondary" required>
        </div>
        <div class="col-4">
          <label class="form-label small text-uppercase text-muted">Port</label>
          <input type="text" name="port" value="<?= htmlspecialchars($port) ?>" class="form-control bg-dark text-white border-secondary" required>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label small text-uppercase text-muted">Database Name</label>
        <input type="text" name="dbname" value="<?= htmlspecialchars($dbname) ?>" class="form-control bg-dark text-white border-secondary" required>
      </div>

      <div class="row g-3 mb-4">
        <div class="col-6">
          <label class="form-label small text-uppercase text-muted">DB User</label>
          <input type="text" name="user" value="<?= htmlspecialchars($user) ?>" class="form-control bg-dark text-white border-secondary" required>
        </div>
        <div class="col-6">
          <label class="form-label small text-uppercase text-muted">DB Password</label>
          <input type="password" name="pass" value="<?= htmlspecialchars($pass) ?>" class="form-control bg-dark text-white border-secondary" placeholder="(blank if none)">
        </div>
      </div>

      <button type="submit" class="btn btn-gold w-100 py-3">
        Test Database Connection Now
      </button>
    </form>

    <div class="text-center mt-4">
      <a href="install.php" class="btn btn-outline-light btn-sm">Run Database Migration Wizard (install.php) &rarr;</a>
    </div>
  </div>
</div>
</body>
</html>
