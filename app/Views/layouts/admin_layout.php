<?php
/**
 * Admin Layout Shell — wraps all admin panel views
 * Includes sidebar, topbar, and injects the view content
 */
$current_user = $current_user ?? \App\Core\Session::get('user');
$adminNav = [
    ['section' => 'Main'],
    ['title' => 'Dashboard',        'icon' => 'fa-chart-line',       'url' => '/admin/dashboard'],
    ['section' => 'Operations'],
    ['title' => 'Visa Applications','icon' => 'fa-passport',          'url' => '/admin/visas'],
    ['title' => 'Reservations',     'icon' => 'fa-plane-departure',   'url' => '/admin/reservations'],
    ['title' => 'Candidates',       'icon' => 'fa-user-tie',          'url' => '/admin/candidates'],
    ['title' => 'Job Listings',     'icon' => 'fa-briefcase',         'url' => '/admin/jobs'],
    ['title' => 'Business Leads',   'icon' => 'fa-building-columns',  'url' => '/admin/business-leads'],
    ['title' => 'Software Projects','icon' => 'fa-laptop-code',       'url' => '/admin/software-projects'],
    ['section' => 'Content'],
    ['title' => 'Offers & Promos',  'icon' => 'fa-tags',              'url' => '/admin/offers'],
    ['title' => 'Blog Posts',       'icon' => 'fa-newspaper',         'url' => '/admin/blog'],
    ['title' => 'Enquiries',        'icon' => 'fa-envelope',          'url' => '/admin/enquiries'],
    ['section' => 'System'],
    ['title' => 'Users & Staff',    'icon' => 'fa-users',             'url' => '/admin/users'],
    ['title' => 'Audit Logs',       'icon' => 'fa-shield-halved',     'url' => '/admin/audit-logs'],
    ['title' => 'View Website',     'icon' => 'fa-external-link-alt', 'url' => '/'],
    ['title' => 'Sign Out',         'icon' => 'fa-right-from-bracket','url' => '/logout'],
];
$currentUri = \App\Core\Request::getUri();
$userInitials = strtoupper(substr($current_user['name'] ?? 'A', 0, 1));
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title><?= htmlspecialchars($page_title ?? 'Admin Panel — MS Horizon Group', ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/admin.css">
</head>
<body class="admin-body">

<!-- ─── SIDEBAR ─────────────────────────────────────────────── -->
<aside class="admin-sidebar" id="adminSidebar" aria-label="Admin navigation">
  <div class="sidebar-brand">
    <span class="sidebar-logo">MS <span>Horizon</span></span>
    <span class="sidebar-tagline">Admin Control Panel</span>
  </div>

  <nav aria-label="Sidebar navigation">
    <?php foreach ($adminNav as $item): ?>
      <?php if (isset($item['section'])): ?>
        <div class="sidebar-section-label"><?= $item['section'] ?></div>
      <?php else: ?>
        <a href="<?= APP_URL . $item['url'] ?>"
           class="sidebar-nav-item <?= (str_starts_with($currentUri, rtrim($item['url'], '/')) && $item['url'] !== '/') ? 'active' : '' ?>"
           <?= $item['url'] === '/logout' ? '' : '' ?>>
          <div class="sidebar-nav-icon">
            <i class="fas <?= $item['icon'] ?>"></i>
          </div>
          <?= $item['title'] ?>
          <?php if (!empty($item['badge'])): ?>
            <span class="sidebar-nav-badge"><?= $item['badge'] ?></span>
          <?php endif; ?>
        </a>
      <?php endif; ?>
    <?php endforeach; ?>
  </nav>
</aside>

<!-- ─── MAIN WRAPPER ─────────────────────────────────────────── -->
<div class="admin-main">

  <!-- TOP HEADER -->
  <header class="admin-header">
    <div class="admin-header-left">
      <button class="admin-notif-btn" id="sidebarToggle" aria-label="Toggle sidebar">
        <i class="fas fa-bars"></i>
      </button>
      <div>
        <div class="admin-page-title"><?= htmlspecialchars($page_title ?? 'Dashboard', ENT_QUOTES, 'UTF-8') ?></div>
        <div class="admin-breadcrumb">
          <a href="<?= APP_URL ?>/admin/dashboard">Dashboard</a>
          <?php if (isset($breadcrumb)): ?> &rsaquo; <?= $breadcrumb ?><?php endif; ?>
        </div>
      </div>
    </div>

    <div class="admin-header-right">
      <!-- Flash alerts -->
      <?php $flash_success = \App\Core\Session::getFlash('success'); $flash_error = \App\Core\Session::getFlash('error'); ?>
      <?php if ($flash_success || $flash_error): ?>
      <div id="admin-flash" data-type="<?= $flash_success ? 'success' : 'error' ?>"
           data-message="<?= htmlspecialchars($flash_success ?: $flash_error, ENT_QUOTES, 'UTF-8') ?>" style="display:none;"></div>
      <?php endif; ?>

      <button class="admin-notif-btn" aria-label="Notifications" title="Notifications">
        <i class="fas fa-bell"></i>
        <span class="notif-dot"></span>
      </button>

      <div class="admin-user-btn" id="adminUserBtn">
        <div class="admin-avatar"><?= $userInitials ?></div>
        <div>
          <span class="admin-user-name"><?= htmlspecialchars($current_user['name'] ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></span>
          <span class="admin-user-role"><?= htmlspecialchars($current_user['role_title'] ?? 'Super Admin', ENT_QUOTES, 'UTF-8') ?></span>
        </div>
        <i class="fas fa-chevron-down fa-xs" style="color:rgba(255,255,255,.4);"></i>
      </div>
    </div>
  </header>

  <!-- ─── VIEW CONTENT INJECTED HERE ─────────────────────────── -->
  <div class="admin-content">
    <?php require $viewPath; ?>
  </div>

  <!-- Admin Footer -->
  <footer style="padding:1.25rem 2rem;border-top:1px solid rgba(255,255,255,.05);text-align:center;font-size:.75rem;color:rgba(255,255,255,.25);">
    © <?= date('Y') ?> MS Horizon Group — Admin Panel. All rights reserved.
    | CSRF Token: Valid | Session: Active
  </footer>

</div><!-- /.admin-main -->

<!-- ─── TOAST CONTAINER (admin) ──────────────────────────────── -->
<div class="toast-container" id="adminToastContainer"></div>

<!-- ─── SCRIPTS ───────────────────────────────────────────────── -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= APP_URL ?>/assets/js/main.js"></script>
<script>
(function() {
  // Sidebar toggle
  var sidebar = document.getElementById('adminSidebar');
  var toggle = document.getElementById('sidebarToggle');
  if (toggle && sidebar) {
    toggle.addEventListener('click', function() {
      sidebar.classList.toggle('open');
    });
  }

  // Flash auto-toast
  var flash = document.getElementById('admin-flash');
  if (flash && typeof showToast === 'function') {
    showToast(flash.dataset.message, flash.dataset.type);
  }

  // Admin AJAX form handler
  document.querySelectorAll('form[data-admin-ajax="true"]').forEach(function(form) {
    form.addEventListener('submit', async function(e) {
      e.preventDefault();
      var btn = form.querySelector('[type="submit"]');
      var orig = btn ? btn.innerHTML : '';
      if (btn) { btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...'; }
      try {
        var fd = new FormData(form);
        var resp = await fetch(form.action, { method:'POST', body:fd, headers:{'X-Requested-With':'XMLHttpRequest'} });
        var data = await resp.json();
        showToast(data.message || 'Done.', data.status === 'success' ? 'success' : 'error');
        if (data.status === 'success') {
          setTimeout(function(){ location.reload(); }, 1500);
        }
      } catch(err) {
        showToast('Network error. Please try again.', 'error');
      } finally {
        if (btn) { btn.disabled = false; btn.innerHTML = orig; }
      }
    });
  });

  // Admin status update dropdowns
  document.querySelectorAll('.status-change-select').forEach(function(sel) {
    sel.addEventListener('change', async function() {
      var url = sel.dataset.url;
      var csrf = document.querySelector('meta[name="csrf-token"]')?.content
                 || document.querySelector('input[name="<?= CSRF_TOKEN_NAME ?>"]')?.value || '';
      if (!url) return;
      var fd = new FormData();
      fd.append('status', sel.value);
      fd.append('<?= CSRF_TOKEN_NAME ?>', csrf);
      try {
        var resp = await fetch(url, { method:'POST', body:fd, headers:{'X-Requested-With':'XMLHttpRequest'} });
        var data = await resp.json();
        showToast(data.message, data.status === 'success' ? 'success' : 'error');
      } catch(e) {
        showToast('Failed to update status.', 'error');
      }
    });
  });
})();
</script>

<?php if (isset($extra_scripts)) echo $extra_scripts; ?>
</body>
</html>
