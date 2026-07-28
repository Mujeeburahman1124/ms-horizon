<?php
/**
 * MS Horizon Group - Web-Based Database Setup & Migration Wizard
 * Open in browser: http://localhost/ms-horizon/install.php
 * Or on Hostinger: https://yourdomain.com/install.php
 */

require_once __DIR__ . '/config.php';

$step = $_POST['step'] ?? 1;
$status = null;
$message = '';
$logs = [];

$host = $_POST['host'] ?? DB_HOST;
$port = $_POST['port'] ?? DB_PORT;
$dbname = $_POST['dbname'] ?? DB_NAME;
$user = $_POST['user'] ?? DB_USER;
$pass = $_POST['pass'] ?? DB_PASS;
$app_url = $_POST['app_url'] ?? APP_URL;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['execute_install'])) {
    try {
        // Step 1: Connect to MySQL Server (without dbname first in case db needs creating)
        $dsnNoDb = "mysql:host={$host};port={$port};charset=utf8mb4";
        $pdoServer = new PDO($dsnNoDb, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $logs[] = "Connected to MySQL server at {$host}:{$port}";

        // Step 2: Create database if not exists
        $pdoServer->exec("CREATE DATABASE IF NOT EXISTS `{$dbname}` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $logs[] = "Database [`{$dbname}`] created or verified.";

        // Step 3: Connect to the specific database
        $dsnDb = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
        $pdo = new PDO($dsnDb, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]);

        // Step 4: Import database/schema.sql
        $schemaSql = file_get_contents(__DIR__ . '/database/schema.sql');
        if ($schemaSql) {
            // Execute schema SQL commands
            $pdo->exec($schemaSql);
            $logs[] = "Imported database/schema.sql successfully (All tables, foreign keys, and indexes created).";
        } else {
            throw new Exception("File database/schema.sql not found or empty.");
        }

        // Step 5: Import database/seeders.sql
        $seedersSql = file_get_contents(__DIR__ . '/database/seeders.sql');
        if ($seedersSql) {
            $pdo->exec($seedersSql);
            $logs[] = "Imported database/seeders.sql successfully (Default Super Admin, 11 Roles, Visas, Jobs & Packages seeded).";
        } else {
            $logs[] = "Warning: database/seeders.sql not found or empty.";
        }

        // Step 6: Update config.php automatically
        $configContent = file_get_contents(__DIR__ . '/config.php');
        if ($configContent) {
            $configContent = preg_replace("/define\('DB_HOST',\s*'.*'\);/", "define('DB_HOST', '{$host}');", $configContent);
            $configContent = preg_replace("/define\('DB_PORT',\s*'.*'\);/", "define('DB_PORT', '{$port}');", $configContent);
            $configContent = preg_replace("/define\('DB_NAME',\s*'.*'\);/", "define('DB_NAME', '{$dbname}');", $configContent);
            $configContent = preg_replace("/define\('DB_USER',\s*'.*'\);/", "define('DB_USER', '{$user}');", $configContent);
            $configContent = preg_replace("/define\('DB_PASS',\s*'.*'\);/", "define('DB_PASS', '{$pass}');", $configContent);
            $configContent = preg_replace("/define\('APP_URL',\s*'.*'\);/", "define('APP_URL', '{$app_url}');", $configContent);

            file_put_contents(__DIR__ . '/config.php', $configContent);
            $logs[] = "Updated config.php with new database credentials and App URL.";
        }

        $status = 'success';
        $message = "Installation Completed Successfully! You can now log into your Admin Panel.";

    } catch (Exception $e) {
        $status = 'error';
        $message = "Installation Failed: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Database Installation & Setup Wizard — MS Horizon Group</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <style>
    body { background: #0A1628; color: #E2E8F0; font-family: 'Segoe UI', system-ui, sans-serif; min-height: 100vh; padding: 4rem 0; }
    .install-card { background: #112240; border: 1px solid rgba(212,175,55,.3); border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,.5); }
    .btn-gold { background: linear-gradient(135deg, #D4AF37, #F0CC5A); color: #0A1628; font-weight: 700; border: none; border-radius: 99px; }
    .btn-gold:hover { background: #F0CC5A; color: #0A1628; transform: translateY(-2px); }
  </style>
</head>
<body>
<div class="container" style="max-width: 720px;">
  <div class="install-card p-4 p-md-5">
    <div class="text-center mb-4">
      <div class="display-6 font-weight-bold text-white mb-1">MS <span style="color:#D4AF37;">Horizon</span></div>
      <p class="text-muted small">Database Migration & Setup Wizard</p>
    </div>

    <?php if ($status === 'success'): ?>
      <div class="alert alert-success p-4 rounded-4 mb-4" role="alert">
        <h4 class="alert-heading font-weight-bold mb-2"><i class="fas fa-check-circle me-2"></i> Database Connected & Migrated!</h4>
        <p><?= htmlspecialchars($message) ?></p>
        <hr>
        <div class="small">
          <strong>Setup Logs:</strong>
          <ul class="mb-0 mt-2 ps-3">
            <?php foreach ($logs as $log): ?>
              <li><?= htmlspecialchars($log) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <div class="p-4 bg-dark rounded-4 mb-4 border border-secondary">
        <h5 class="text-warning mb-2"><i class="fas fa-key me-2"></i> Default Admin Sign In Credentials:</h5>
        <div class="small">
          <div><strong>Login URL:</strong> <a href="<?= APP_URL ?>/login" class="text-gold"><?= APP_URL ?>/login</a></div>
          <div><strong>Email Address:</strong> <code>admin@mshorizontravel.com</code></div>
          <div><strong>Password:</strong> <code>AdminPass2026!</code></div>
        </div>
      </div>

      <div class="d-flex gap-3">
        <a href="<?= APP_URL ?>/" class="btn btn-outline-light btn-lg flex-grow-1"><i class="fas fa-home me-2"></i> Visit Homepage</a>
        <a href="<?= APP_URL ?>/login" class="btn btn-gold btn-lg flex-grow-1"><i class="fas fa-sign-in-alt me-2"></i> Go to Admin Panel</a>
      </div>

    <?php else: ?>

      <?php if ($status === 'error'): ?>
        <div class="alert alert-danger p-4 rounded-4 mb-4" role="alert">
          <h4 class="alert-heading font-weight-bold mb-2"><i class="fas fa-exclamation-triangle me-2"></i> Setup Error</h4>
          <p class="mb-0"><?= htmlspecialchars($message) ?></p>
        </div>
      <?php endif; ?>

      <form method="POST" action="install.php">
        <input type="hidden" name="execute_install" value="1">

        <h3 class="h5 text-warning mb-3"><i class="fas fa-database me-2"></i> Enter MySQL Database Credentials:</h3>
        
        <div class="row g-3 mb-3">
          <div class="col-md-8">
            <label class="form-label small text-uppercase text-muted">Database Host</label>
            <input type="text" name="host" value="<?= htmlspecialchars($host) ?>" class="form-control bg-dark text-white border-secondary" required>
            <div class="form-text text-muted">Use <code>127.0.0.1</code> or <code>localhost</code> for local / Hostinger.</div>
          </div>
          <div class="col-md-4">
            <label class="form-label small text-uppercase text-muted">Port</label>
            <input type="text" name="port" value="<?= htmlspecialchars($port) ?>" class="form-control bg-dark text-white border-secondary" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label small text-uppercase text-muted">Database Name</label>
          <input type="text" name="dbname" value="<?= htmlspecialchars($dbname) ?>" class="form-control bg-dark text-white border-secondary" required>
          <div class="form-text text-muted">Will be created automatically if it doesn't exist yet.</div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label small text-uppercase text-muted">Database Username</label>
              <input type="text" name="user" value="<?= htmlspecialchars($user) ?>" class="form-control bg-dark text-white border-secondary" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label small text-uppercase text-muted">Database Password</label>
              <input type="password" name="pass" value="<?= htmlspecialchars($pass) ?>" class="form-control bg-dark text-white border-secondary" placeholder="Leave empty if none">
            </div>
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label small text-uppercase text-muted">Website App URL</label>
          <input type="url" name="app_url" value="<?= htmlspecialchars($app_url) ?>" class="form-control bg-dark text-white border-secondary" required>
          <div class="form-text text-muted">Example: <code>http://localhost/ms-horizon</code> or <code>https://yourdomain.com</code></div>
        </div>

        <button type="submit" class="btn btn-gold w-100 py-3 font-weight-bold fs-5">
          <i class="fas fa-cogs me-2"></i> Connect Database & Execute Migrations
        </button>
      </form>

      <div class="text-center mt-4">
        <a href="test_db.php" class="text-warning small">&larr; Quick Diagnostic Connection Test (test_db.php)</a>
      </div>

    <?php endif; ?>
  </div>
</div>
</body>
</html>
