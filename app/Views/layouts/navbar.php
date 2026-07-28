<?php
// Shared divisions data for mega menu
$nav_divisions = [
    ['slug' => 'reservations-services', 'title' => 'Reservations', 'icon' => 'fa-plane-departure', 'desc' => 'Flights, Hotels, Transfers', 'url' => '/reservations'],
    ['slug' => 'travel-tourism', 'title' => 'Travel & Tourism', 'icon' => 'fa-passport', 'desc' => 'Visa & Holiday Packages', 'url' => '/travel'],
    ['slug' => 'hr-consultancy', 'title' => 'HR Consultancy', 'icon' => 'fa-users-gear', 'desc' => 'Recruitment & Careers', 'url' => '/careers'],
    ['slug' => 'business-consultancy', 'title' => 'Business Setup', 'icon' => 'fa-building-columns', 'desc' => 'UAE Company Formation', 'url' => '/business'],
    ['slug' => 'software-development', 'title' => 'Software Dev', 'icon' => 'fa-laptop-code', 'desc' => 'Web, Apps & Automation', 'url' => '/software'],
];
$currentUri = \App\Core\Request::getUri();
?>

<!-- ─── LOADING SCREEN ─────────────────────────────────────────── -->
<div id="page-loader" role="status" aria-label="Loading MS Horizon">
  <div class="loader-logo">MS <span>Horizon</span></div>
  <div class="loader-bar"><div class="loader-bar-fill"></div></div>
</div>

<!-- ─── NAVIGATION ────────────────────────────────────────────── -->
<header>
<nav class="navbar-msh" role="navigation" aria-label="Main navigation" id="main-navbar">
  <div class="container" style="display:flex;align-items:center;justify-content:space-between;width:100%;max-width:100%;padding:0;">

    <!-- Brand -->
    <a href="<?= APP_URL ?>/" class="nav-brand" aria-label="MS Horizon Group Home">
      <div>
        <span class="nav-brand-logo">MS <span>Horizon</span></span>
        <span class="nav-brand-tagline">Group of Companies</span>
      </div>
    </a>

    <!-- Desktop Navigation Links -->
    <ul class="nav-links" id="navLinks" role="menubar">
      <li class="nav-item" role="none">
        <a href="<?= APP_URL ?>/" class="nav-link-btn" role="menuitem"><i class="fas fa-home"></i> Home</a>
      </li>

      <li class="nav-item" role="none">
        <button class="nav-link-btn" role="menuitem" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-th-large"></i> Services <i class="fas fa-chevron-down chevron"></i>
        </button>
        <div class="mega-menu" role="menu" aria-label="Services submenu">
          <?php foreach ($nav_divisions as $div): ?>
          <a href="<?= APP_URL . $div['url'] ?>" class="mega-menu-item" role="menuitem">
            <div class="mega-icon"><i class="fas <?= $div['icon'] ?>"></i></div>
            <div class="mega-info">
              <h4><?= $div['title'] ?></h4>
              <p><?= $div['desc'] ?></p>
            </div>
          </a>
          <?php endforeach; ?>
        </div>
      </li>

      <li class="nav-item" role="none">
        <button class="nav-link-btn" role="menuitem" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-globe"></i> Countries <i class="fas fa-chevron-down chevron"></i>
        </button>
        <div class="mega-menu" style="min-width:520px;grid-template-columns:repeat(2,1fr);" role="menu">
          <a href="<?= APP_URL ?>/travel/countries" class="mega-menu-item" role="menuitem">
            <div class="mega-icon"><i class="fas fa-map-marked-alt"></i></div>
            <div class="mega-info"><h4>UAE & GCC Countries</h4><p>UAE, Qatar, Oman, Saudi, Bahrain</p></div>
          </a>
          <a href="<?= APP_URL ?>/travel/countries" class="mega-menu-item" role="menuitem">
            <div class="mega-icon"><i class="fas fa-globe-americas"></i></div>
            <div class="mega-info"><h4>Global Destinations</h4><p>Sri Lanka, India, Europe, USA, Canada</p></div>
          </a>
        </div>
      </li>

      <li class="nav-item" role="none">
        <a href="<?= APP_URL ?>/offers" class="nav-link-btn" role="menuitem"><i class="fas fa-tags"></i> Offers</a>
      </li>
      <li class="nav-item" role="none">
        <a href="<?= APP_URL ?>/careers" class="nav-link-btn" role="menuitem"><i class="fas fa-briefcase"></i> Careers</a>
      </li>
      <li class="nav-item" role="none">
        <a href="<?= APP_URL ?>/about" class="nav-link-btn" role="menuitem"><i class="fas fa-info-circle"></i> About Us</a>
      </li>
      <li class="nav-item" role="none">
        <a href="<?= APP_URL ?>/contact" class="nav-link-btn" role="menuitem"><i class="fas fa-envelope"></i> Contact Us</a>
      </li>
    </ul>

    <!-- Right Actions -->
    <div class="nav-actions">
      <!-- Multilingual Language Selector (EN, AR, TA) -->
      <div class="dropdown">
        <button class="btn-theme-toggle dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Select Language" style="width:auto;padding:0 .75rem;border-radius:99px;font-size:.78rem;font-weight:700;">
          <i class="fas fa-language me-1"></i> EN
        </button>
        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end shadow-lg border-secondary">
          <li><a class="dropdown-item active" href="?lang=en">🇬🇧 English</a></li>
          <li><a class="dropdown-item" href="?lang=ar">🇦🇪 العربية (Arabic)</a></li>
          <li><a class="dropdown-item" href="?lang=ta">🇱🇰 தமிழ் (Tamil)</a></li>
        </ul>
      </div>

      <!-- Search -->
      <a href="<?= APP_URL ?>/search" class="btn-theme-toggle" aria-label="Search" title="Search">
        <i class="fas fa-search"></i>
      </a>

      <!-- Theme Toggle -->
      <button class="btn-theme-toggle" aria-label="Toggle dark mode" id="themeToggle">
        <i class="fas fa-moon"></i>
      </button>

      <!-- Portal Login -->
      <?php if ($current_user = \App\Core\Session::get('user')): ?>
      <a href="<?= APP_URL ?>/admin/dashboard" class="btn-nav-portal">
        <i class="fas fa-th-large"></i> Dashboard
      </a>
      <?php else: ?>
      <a href="<?= APP_URL ?>/login" class="btn-nav-portal">
        <i class="fas fa-user"></i> Portal Login
      </a>
      <?php endif; ?>

      <!-- Hamburger (mobile) -->
      <button class="nav-hamburger" aria-label="Open menu" aria-expanded="false" id="hamburgerBtn">
        <span></span><span></span><span></span>
      </button>
    </div>

  </div><!-- /.container -->
</nav>
</header>

<!-- ─── FLASH MESSAGES ─────────────────────────────────────────── -->
<?php
$flash_success = \App\Core\Session::getFlash('success');
$flash_error   = \App\Core\Session::getFlash('error');
$flash_info    = \App\Core\Session::getFlash('info');
?>
<?php if ($flash_success || $flash_error || $flash_info): ?>
<div id="flash-auto-toast" style="display:none;"
  data-type="<?= $flash_success ? 'success' : ($flash_error ? 'error' : 'info') ?>"
  data-message="<?= htmlspecialchars($flash_success ?: $flash_error ?: $flash_info, ENT_QUOTES, 'UTF-8') ?>">
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const el = document.getElementById('flash-auto-toast');
  if (el && typeof showToast === 'function') {
    showToast(el.dataset.message, el.dataset.type);
  }
});
</script>
<?php endif; ?>

<!-- ─── COOKIE BANNER ─────────────────────────────────────────── -->
<div id="cookie-banner" style="display:none;position:fixed;bottom:0;left:0;right:0;z-index:9000;background:rgba(10,22,40,0.97);backdrop-filter:blur(16px);border-top:1px solid rgba(212,175,55,.3);padding:1rem 2rem;align-items:center;justify-content:space-between;gap:1.5rem;flex-wrap:wrap;">
  <p style="color:rgba(255,255,255,.75);font-size:.82rem;margin:0;max-width:640px;">
    <i class="fas fa-cookie-bite" style="color:#D4AF37;margin-right:.5rem;"></i>
    We use cookies to enhance your browsing experience. By continuing, you agree to our
    <a href="<?= APP_URL ?>/cookie-policy" style="color:#D4AF37;">Cookie Policy</a>.
  </p>
  <button class="cookie-accept btn btn-primary btn-sm" id="cookieAccept">
    <i class="fas fa-check"></i> Accept & Continue
  </button>
</div>

<!-- ─── MAIN CONTENT BEGINS ──────────────────────────────────── -->
<main id="main-content">
