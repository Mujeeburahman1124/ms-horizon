<?php
/**
 * MS HORIZON GROUP — Railway Cloud DB Migration Script v2.0
 * Handles "MySQL server has gone away" by reconnecting and importing statement by statement.
 * Run: php migrate_railway.php
 */

define('SCRIPT_START', microtime(true));
set_time_limit(300);
ini_set('memory_limit', '256M');

// ─── Config ──────────────────────────────────────────────────────
$host     = getenv('DB_HOST')  ?: 'sakura.proxy.rlwy.net';
$port     = getenv('DB_PORT')  ?: '49932';
$dbname   = getenv('DB_NAME')  ?: 'railway';
$user     = getenv('DB_USER')  ?: 'root';
$password = getenv('DB_PASS')  ?: 'nIILZhVZJnSzcrcMdXzVhbLFiwGfgrPh';
$charset  = 'utf8mb4';

$schema_file  = __DIR__ . '/database/schema.sql';
$seeder_file  = __DIR__ . '/database/seeders.sql';

// ─── Helper: Create fresh PDO connection ─────────────────────────
function createConnection(string $host, string $port, string $dbname, string $user, string $password, string $charset): PDO
{
    $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset={$charset}";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => true,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$charset}, SESSION wait_timeout=300, SESSION interactive_timeout=300",
        PDO::ATTR_TIMEOUT            => 60,
    ]);
    return $pdo;
}

// ─── Helper: Parse SQL file into individual statements ───────────
function parseSqlStatements(string $filePath): array
{
    $content = file_get_contents($filePath);
    if ($content === false) {
        die("❌ Cannot read file: {$filePath}\n");
    }

    // Remove BOM if present
    $content = ltrim($content, "\xEF\xBB\xBF");

    $statements = [];
    $current    = '';
    $inString   = false;
    $stringChar = '';
    $escaped    = false;

    for ($i = 0; $i < strlen($content); $i++) {
        $char = $content[$i];

        if ($escaped) { $escaped = false; $current .= $char; continue; }
        if ($char === '\\' && $inString) { $escaped = true; $current .= $char; continue; }

        if (!$inString && ($char === "'" || $char === '"' || $char === '`')) {
            $inString = true; $stringChar = $char; $current .= $char; continue;
        }
        if ($inString && $char === $stringChar) {
            $inString = false; $current .= $char; continue;
        }

        // Skip line comments outside strings
        if (!$inString && $char === '-' && isset($content[$i+1]) && $content[$i+1] === '-') {
            while ($i < strlen($content) && $content[$i] !== "\n") $i++;
            $current .= "\n";
            continue;
        }
        // Skip block comments
        if (!$inString && $char === '/' && isset($content[$i+1]) && $content[$i+1] === '*') {
            $end = strpos($content, '*/', $i + 2);
            if ($end !== false) { $i = $end + 1; continue; }
        }

        if (!$inString && $char === ';') {
            $stmt = trim($current);
            if ($stmt !== '') $statements[] = $stmt;
            $current = '';
        } else {
            $current .= $char;
        }
    }

    $last = trim($current);
    if ($last !== '') $statements[] = $last;

    return array_filter($statements, fn($s) => strlen(trim($s)) > 2);
}

// ─── Helper: Execute statements with auto-reconnect ──────────────
function executeStatements(array $statements, string $host, string $port, string $dbname, string $user, string $password, string $charset): array
{
    $pdo     = createConnection($host, $port, $dbname, $user, $password, $charset);
    $errors  = [];
    $success = 0;
    $total   = count($statements);

    foreach ($statements as $idx => $sql) {
        // Skip USE statements that reference a different DB name
        if (preg_match('/^\s*USE\s+`?ms_horizon`?\s*$/i', $sql)) {
            echo "  ⏭  Skipped USE ms_horizon statement (running on Railway DB: {$dbname})\n";
            continue;
        }
        // Skip CREATE DATABASE statements
        if (preg_match('/^\s*CREATE\s+DATABASE/i', $sql)) {
            echo "  ⏭  Skipped CREATE DATABASE statement\n";
            continue;
        }

        $preview = substr(preg_replace('/\s+/', ' ', $sql), 0, 80);
        try {
            $pdo->exec($sql);
            $success++;
            echo "  ✅ [{$success}/{$total}] " . $preview . "\n";
        } catch (PDOException $e) {
            $errCode = $e->getCode();
            // 2006 = MySQL server has gone away, 2013 = Lost connection
            if (in_array($errCode, ['2006', '2013', 'HY000'])) {
                echo "  🔄 Connection lost. Reconnecting...\n";
                sleep(2);
                try {
                    $pdo = createConnection($host, $port, $dbname, $user, $password, $charset);
                    $pdo->exec($sql);
                    $success++;
                    echo "  ✅ [{$success}/{$total}] (after reconnect) " . $preview . "\n";
                } catch (PDOException $e2) {
                    $errors[] = ['sql' => $preview, 'error' => $e2->getMessage()];
                    echo "  ❌ Failed after reconnect: " . $e2->getMessage() . "\n";
                }
            } else {
                // Non-fatal: skip duplicate/existing table errors (42S01 = table already exists)
                if (strpos($e->getMessage(), 'already exists') !== false) {
                    echo "  ⚠️  Table already exists (skipped): " . $preview . "\n";
                } else {
                    $errors[] = ['sql' => $preview, 'error' => $e->getMessage()];
                    echo "  ❌ Error: " . $e->getMessage() . "\n     SQL: " . $preview . "\n";
                }
            }
        }

        // Small pause every 10 statements to avoid connection saturation
        if ($idx > 0 && $idx % 10 === 0) usleep(100000); // 100ms
    }

    return ['success' => $success, 'errors' => $errors];
}

// ─── Main Execution ───────────────────────────────────────────────
echo "\n========================================================\n";
echo "  MS Horizon Group — Railway DB Migration v2.0\n";
echo "  Host: {$host}:{$port}  DB: {$dbname}\n";
echo "========================================================\n\n";

// Test connection
echo "🔌 Testing Railway MySQL connection...\n";
try {
    $testPdo = createConnection($host, $port, $dbname, $user, $password, $charset);
    $ver = $testPdo->query("SELECT VERSION() as v")->fetch()['v'];
    echo "✅ Connected! MySQL version: {$ver}\n\n";
    $testPdo = null;
} catch (PDOException $e) {
    die("❌ Connection FAILED: " . $e->getMessage() . "\n");
}

// ─── Phase 1: Schema ─────────────────────────────────────────────
echo "━━━ PHASE 1: Schema Tables ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
if (!file_exists($schema_file)) {
    die("❌ Schema file not found: {$schema_file}\n");
}

$schemaStatements = parseSqlStatements($schema_file);
echo "📄 Parsed " . count($schemaStatements) . " schema statements\n\n";
$schemaResult = executeStatements($schemaStatements, $host, $port, $dbname, $user, $password, $charset);

echo "\n📊 Schema: {$schemaResult['success']} executed, " . count($schemaResult['errors']) . " errors\n\n";

// ─── Phase 2: Seed Data ──────────────────────────────────────────
echo "━━━ PHASE 2: Seed Data ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
if (!file_exists($seeder_file)) {
    echo "⚠️  Seeder file not found: {$seeder_file} — skipping seed data.\n\n";
} else {
    $seederStatements = parseSqlStatements($seeder_file);
    echo "📄 Parsed " . count($seederStatements) . " seeder statements\n\n";
    $seederResult = executeStatements($seederStatements, $host, $port, $dbname, $user, $password, $charset);
    echo "\n📊 Seeders: {$seederResult['success']} executed, " . count($seederResult['errors']) . " errors\n\n";
}

// ─── Phase 3: Admin User ─────────────────────────────────────────
echo "━━━ PHASE 3: Admin User Setup ━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
try {
    $pdo = createConnection($host, $port, $dbname, $user, $password, $charset);
    $adminEmail = 'admin@mshorizontravel.com';
    $existing   = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $existing->execute([$adminEmail]);
    if ($existing->fetch()) {
        echo "✅ Admin user already exists.\n";
    } else {
        $hash = password_hash('AdminPass2026!', PASSWORD_BCRYPT, ['cost' => 12]);
        $stmt = $pdo->prepare(
            "INSERT INTO users (name, email, password_hash, role_slug, role_title, is_active)
             VALUES (?, ?, ?, 'super_admin', 'Super Administrator', 1)"
        );
        $stmt->execute(['Group Super Admin', $adminEmail, $hash]);
        echo "✅ Admin user created: {$adminEmail} / AdminPass2026!\n";
    }

    // Additional staff users
    $staffUsers = [
        ['Sarah Jenkins (Recruitment)', 'recruitment@mshorizontravel.com', 'recruitment_manager', 'Recruitment Manager'],
        ['Tariq Al-Mansoor (Business)', 'business@mshorizontravel.com',    'business_consultant', 'Business Consultant'],
        ['Layla Hassan (Travel)',        'travel@mshorizontravel.com',       'travel_manager',      'Travel Manager'],
    ];
    foreach ($staffUsers as [$name, $email, $roleSlug, $roleTitle]) {
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);
        if (!$check->fetch()) {
            $hash = password_hash('StaffPass2026!', PASSWORD_BCRYPT, ['cost' => 12]);
            $ins  = $pdo->prepare(
                "INSERT INTO users (name, email, password_hash, role_slug, role_title, is_active)
                 VALUES (?, ?, ?, ?, ?, 1)"
            );
            $ins->execute([$name, $email, $hash, $roleSlug, $roleTitle]);
            echo "✅ Staff user created: {$email}\n";
        } else {
            echo "  ⏭  Staff user exists: {$email}\n";
        }
    }
} catch (PDOException $e) {
    echo "❌ Admin user setup failed: " . $e->getMessage() . "\n";
}

// ─── Phase 4: Verify Tables ──────────────────────────────────────
echo "\n━━━ PHASE 4: Table Verification ━━━━━━━━━━━━━━━━━━━━━━━━━\n";
$requiredTables = [
    'users', 'roles', 'divisions', 'services', 'countries', 'visas',
    'visa_applications', 'visa_documents', 'reservations', 'invoices',
    'candidates', 'employers', 'jobs', 'job_applications', 'saved_jobs',
    'business_packages', 'business_leads', 'software_portfolio',
    'software_projects', 'offers', 'blog_posts', 'otp_codes',
    'contact_enquiries', 'audit_logs', 'newsletter_subscribers'
];

try {
    $pdo    = createConnection($host, $port, $dbname, $user, $password, $charset);
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    $missing = [];
    foreach ($requiredTables as $tbl) {
        if (in_array($tbl, $tables)) {
            echo "  ✅ {$tbl}\n";
        } else {
            echo "  ❌ MISSING: {$tbl}\n";
            $missing[] = $tbl;
        }
    }
    echo "\n  Total tables in DB: " . count($tables) . "\n";
    if (!empty($missing)) {
        echo "\n  ⚠️  Missing tables: " . implode(', ', $missing) . "\n";
    }
} catch (PDOException $e) {
    echo "❌ Verification failed: " . $e->getMessage() . "\n";
}

// ─── Summary ─────────────────────────────────────────────────────
$elapsed = round(microtime(true) - SCRIPT_START, 2);
echo "\n========================================================\n";
echo "  Migration completed in {$elapsed}s\n";
echo "  Login URL: https://your-domain.com/login\n";
echo "  Admin:     admin@mshorizontravel.com / AdminPass2026!\n";
echo "========================================================\n\n";
