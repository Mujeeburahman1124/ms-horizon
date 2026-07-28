<?php
/**
 * MS Horizon Group - Embedded Database Web Admin (Mini phpMyAdmin alternative)
 * No XAMPP or external phpMyAdmin required!
 * Access in browser: http://localhost/ms-horizon/db_admin.php
 */

require_once __DIR__ . '/config.php';

$pdo = null;
$dbError = null;

try {
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    $dbError = $e->getMessage();
}

$tables = [];
if ($pdo) {
    try {
        $stmt = $pdo->query("SHOW TABLES");
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    } catch (Exception $e) {
        $dbError = $e->getMessage();
    }
}

$selectedTable = $_GET['table'] ?? ($tables[0] ?? null);
$action = $_GET['action'] ?? 'browse';
$sqlQuery = $_POST['sql_query'] ?? '';
$queryResult = null;
$queryError = null;

// Handle Custom SQL Execution
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($sqlQuery) && $pdo) {
    try {
        $stmt = $pdo->query($sqlQuery);
        if (str_starts_with(strtolower(trim($sqlQuery)), 'select') || str_starts_with(strtolower(trim($sqlQuery)), 'show')) {
            $queryResult = $stmt->fetchAll();
        } else {
            $queryResult = "Query executed successfully. Affected rows: " . $stmt->rowCount();
        }
    } catch (Exception $e) {
        $queryError = $e->getMessage();
    }
}

// Fetch Table Data / Columns if table selected
$tableColumns = [];
$tableRows = [];
$tableCount = 0;

if ($selectedTable && $pdo && in_array($selectedTable, $tables)) {
    try {
        // Get structure
        $stmtCols = $pdo->query("DESCRIBE `$selectedTable`");
        $tableColumns = $stmtCols->fetchAll();

        if ($action === 'browse') {
            // Count total
            $stmtCnt = $pdo->query("SELECT COUNT(*) as c FROM `$selectedTable`");
            $tableCount = $stmtCnt->fetch()['c'] ?? 0;

            // Fetch rows
            $stmtRows = $pdo->query("SELECT * FROM `$selectedTable` LIMIT 100");
            $tableRows = $stmtRows->fetchAll();
        }
    } catch (Exception $e) {
        $dbError = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Embedded Database Admin — MS Horizon Group</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <style>
    body { background: #0A1628; color: #E2E8F0; font-family: system-ui, -apple-system, sans-serif; font-size: .875rem; }
    .top-header { background: #112240; border-bottom: 1px solid rgba(212,175,55,.2); padding: 1rem 1.5rem; display: flex; align-items: center; justify-content: space-between; }
    .brand { font-size: 1.25rem; font-weight: 800; color: white; text-decoration: none; }
    .brand span { color: #D4AF37; }
    .db-sidebar { width: 260px; background: #0D1F3C; border-right: 1px solid rgba(255,255,255,.08); padding: 1rem; height: calc(100vh - 65px); overflow-y: auto; }
    .db-main { flex: 1; padding: 1.5rem; height: calc(100vh - 65px); overflow-y: auto; }
    .table-list a { display: flex; align-items: center; justify-content: space-between; padding: .5rem .75rem; color: rgba(255,255,255,.7); text-decoration: none; border-radius: 6px; font-size: .82rem; }
    .table-list a:hover, .table-list a.active { background: rgba(212,175,55,.15); color: #D4AF37; }
    .card-dark { background: #112240; border: 1px solid rgba(255,255,255,.08); border-radius: 12px; color: white; margin-bottom: 1.5rem; }
    .btn-gold { background: linear-gradient(135deg, #D4AF37, #F0CC5A); color: #0A1628; font-weight: 700; border: none; }
    .btn-gold:hover { background: #F0CC5A; color: #0A1628; }
  </style>
</head>
<body>

<header class="top-header">
  <a href="db_admin.php" class="brand"><i class="fas fa-database text-warning me-2"></i> MS <span>Horizon</span> Database Web Admin</a>
  <div>
    <span class="badge bg-warning text-dark me-2">Database: <?= DB_NAME ?></span>
    <a href="test_db.php" class="btn btn-sm btn-outline-light me-2">Test DB</a>
    <a href="install.php" class="btn btn-sm btn-gold">Run Migration Wizard</a>
  </div>
</header>

<div class="d-flex">
  <!-- Sidebar Table List -->
  <aside class="db-sidebar">
    <div class="text-uppercase text-muted fw-bold mb-2" style="font-size:.65rem;letter-spacing:1px;">Tables (<?= count($tables) ?>)</div>
    <div class="table-list">
      <?php foreach ($tables as $t): ?>
        <a href="db_admin.php?table=<?= urlencode($t) ?>" class="<?= $selectedTable === $t ? 'active' : '' ?>">
          <span><i class="fas fa-table me-2"></i> <?= htmlspecialchars($t) ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </aside>

  <!-- Main Content Area -->
  <main class="db-main">

    <?php if ($dbError): ?>
      <div class="alert alert-danger p-4 rounded-4" role="alert">
        <h4 class="alert-heading fw-bold"><i class="fas fa-exclamation-triangle me-2"></i> Database Error</h4>
        <p class="mb-0"><?= htmlspecialchars($dbError) ?></p>
        <hr>
        <a href="install.php" class="btn btn-gold btn-sm">Click here to setup/migrate database via install.php</a>
      </div>
    <?php else: ?>

      <!-- Custom SQL Query Box -->
      <div class="card-dark p-3">
        <h5 class="fw-bold mb-2 text-warning"><i class="fas fa-code me-2"></i> SQL Command Console</h5>
        <form method="POST" action="db_admin.php?table=<?= urlencode($selectedTable ?? '') ?>">
          <div class="mb-2">
            <textarea name="sql_query" rows="2" class="form-control bg-dark text-white border-secondary font-monospace" placeholder="SELECT * FROM users;"><?= htmlspecialchars($sqlQuery) ?></textarea>
          </div>
          <button type="submit" class="btn btn-gold btn-sm"><i class="fas fa-play me-1"></i> Execute SQL</button>
        </form>

        <?php if ($queryError): ?>
          <div class="alert alert-danger mt-3 mb-0 small"><?= htmlspecialchars($queryError) ?></div>
        <?php endif; ?>

        <?php if ($queryResult !== null): ?>
          <div class="mt-3">
            <?php if (is_string($queryResult)): ?>
              <div class="alert alert-success mb-0 small"><?= htmlspecialchars($queryResult) ?></div>
            <?php elseif (empty($queryResult)): ?>
              <div class="alert alert-info mb-0 small">Query executed. 0 rows returned.</div>
            <?php else: ?>
              <div class="table-responsive mt-2" style="max-height: 250px;">
                <table class="table table-dark table-striped table-sm mb-0">
                  <thead>
                    <tr>
                      <?php foreach (array_keys($queryResult[0]) as $k): ?>
                        <th><?= htmlspecialchars($k) ?></th>
                      <?php endforeach; ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($queryResult as $row): ?>
                      <tr>
                        <?php foreach ($row as $v): ?>
                          <td><?= htmlspecialchars((string)$v) ?></td>
                        <?php endforeach; ?>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Selected Table Inspector -->
      <?php if ($selectedTable): ?>
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h4 class="fw-bold text-white mb-0">
            <i class="fas fa-table text-warning me-2"></i> Table: <span class="text-warning"><?= htmlspecialchars($selectedTable) ?></span>
            <span class="badge bg-secondary fs-6 ms-2"><?= $tableCount ?> Rows</span>
          </h4>
          <div class="btn-group">
            <a href="db_admin.php?table=<?= urlencode($selectedTable) ?>&action=browse" class="btn btn-sm <?= $action==='browse'?'btn-gold':'btn-outline-light' ?>">Browse Data</a>
            <a href="db_admin.php?table=<?= urlencode($selectedTable) ?>&action=structure" class="btn btn-sm <?= $action==='structure'?'btn-gold':'btn-outline-light' ?>">Structure</a>
          </div>
        </div>

        <?php if ($action === 'structure'): ?>
          <div class="card-dark p-3">
            <h5 class="fw-bold text-warning mb-3">Columns Structure</h5>
            <table class="table table-dark table-striped table-hover mb-0">
              <thead>
                <tr>
                  <th>Field</th>
                  <th>Type</th>
                  <th>Null</th>
                  <th>Key</th>
                  <th>Default</th>
                  <th>Extra</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($tableColumns as $col): ?>
                  <tr>
                    <td class="fw-bold text-warning"><?= htmlspecialchars($col['Field']) ?></td>
                    <td><code><?= htmlspecialchars($col['Type']) ?></code></td>
                    <td><?= htmlspecialchars($col['Null']) ?></td>
                    <td><span class="badge bg-info"><?= htmlspecialchars($col['Key']) ?></span></td>
                    <td><?= htmlspecialchars((string)$col['Default']) ?></td>
                    <td><?= htmlspecialchars($col['Extra']) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

        <?php else: ?>
          <div class="card-dark p-3">
            <?php if (empty($tableRows)): ?>
              <div class="text-center py-4 text-muted">
                <i class="fas fa-inbox fa-3x mb-3"></i>
                <p>This table is currently empty.</p>
              </div>
            <?php else: ?>
              <div class="table-responsive" style="max-height: 550px;">
                <table class="table table-dark table-striped table-hover align-middle mb-0">
                  <thead>
                    <tr>
                      <?php foreach (array_keys($tableRows[0]) as $colName): ?>
                        <th class="text-warning small text-uppercase"><?= htmlspecialchars($colName) ?></th>
                      <?php endforeach; ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($tableRows as $r): ?>
                      <tr>
                        <?php foreach ($r as $val): ?>
                          <td style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <?= htmlspecialchars((string)$val) ?>
                          </td>
                        <?php endforeach; ?>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>
        <?php endif; ?>

      <?php endif; ?>

    <?php endif; ?>

  </main>
</div>

</body>
</html>
