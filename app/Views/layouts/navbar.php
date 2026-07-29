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
<script>
(function(){
  function dismissLoader(){
    var el = document.getElementById('page-loader');
    if (el) {
      el.classList.add('loaded');
      setTimeout(function(){ el.style.display = 'none'; }, 400);
    }
  }
  if (document.readyState === 'complete' || document.readyState === 'interactive') {
    setTimeout(dismissLoader, 200);
  } else {
    window.addEventListener('DOMContentLoaded', function(){ setTimeout(dismissLoader, 200); });
  }
  setTimeout(dismissLoader, 600);
})();
</script>

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

        <!-- Mega Menu -->
        <div class="mega-menu" role="menu">
          <div class="mega-menu-grid">

            <?php foreach ($nav_divisions as $div): ?>
            <a href="<?= APP_URL . $div['url'] ?>" class="mega-card" role="menuitem">
              <div class="mega-card-icon">
                <i class="fas <?= $div['icon'] ?>"></i>
              </div>
              <div class="mega-card-info">
                <h4><?= $div['title'] ?></h4>
                <p><?= $div['desc'] ?></p>
              </div>
            </a>
            <?php endforeach; ?>

          </div>
          <div class="mega-menu-footer">
            <span><i class="fas fa-shield-halved"></i> Registered Corporate Group in Dubai, UAE</span>
            <a href="<?= APP_URL ?>/services" style="color:var(--clr-gold);font-weight:600;">View All Services &rsaquo;</a>
          </div>
        </div>
      </li>

      <li class="nav-item" role="none">
        <a href="<?= APP_URL ?>/travel/countries" class="nav-link-btn" role="menuitem"><i class="fas fa-globe"></i> Countries</a>
      </li>

      <li class="nav-item" role="none">
        <a href="<?= APP_URL ?>/offers" class="nav-link-btn" role="menuitem"><i class="fas fa-tags"></i> Offers</a>
      </li>

      <li class="nav-item" role="none">
        <a href="<?= APP_URL ?>/careers" class="nav-link-btn" role="menuitem"><i class="fas fa-briefcase"></i> Careers</a>
      </li>

      <li class="nav-item" role="none">
        <a href="<?= APP_URL ?>/about" class="nav-link-btn" role="menuitem"><i class="fas fa-building"></i> About Us</a>
      </li>

      <li class="nav-item" role="none">
        <a href="<?= APP_URL ?>/contact" class="nav-link-btn" role="menuitem"><i class="fas fa-envelope"></i> Contact Us</a>
      </li>
    </ul>

    <!-- Right Controls -->
    <div class="nav-controls">
      <!-- Language Selector -->
      <div class="dropdown d-inline-block">
        <button class="nav-ctrl-btn dropdown-toggle" type="button" id="langDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Change Language">
          <i class="fas fa-language"></i> <span class="d-none d-md-inline ms-1">EN</span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="langDropdown" style="background:var(--clr-navy-light);border:1px solid rgba(255,255,255,.1);">
          <li><a class="dropdown-item text-white" href="?lang=en"><span class="me-2">🇦🇪</span> English (EN)</a></li>
          <li><a class="dropdown-item text-white" href="?lang=ar"><span class="me-2">🇦🇪</span> العربية (AR)</a></li>
          <li><a class="dropdown-item text-white" href="?lang=ta"><span class="me-2">🇮🇳</span> தமிழ் (TA)</a></li>
        </ul>
      </div>

      <!-- Theme Toggle -->
      <button class="nav-ctrl-btn btn-theme-toggle" aria-label="Toggle dark/light theme" title="Toggle Theme">
        <i class="fas fa-moon"></i>
      </button>

      <!-- User Account / Login Button -->
      <?php if (!empty($current_user)): ?>
        <a href="<?= APP_URL ?>/admin/dashboard" class="btn btn-gold btn-sm d-none d-sm-inline-flex" style="border-radius:20px;padding:.4rem 1rem;">
          <i class="fas fa-user-circle me-1"></i> Dashboard
        </a>
      <?php else: ?>
        <a href="<?= APP_URL ?>/login" class="btn btn-outline-gold btn-sm d-none d-sm-inline-flex" style="border-radius:20px;padding:.4rem 1rem;">
          <i class="fas fa-lock me-1"></i> Portal Login
        </a>
      <?php endif; ?>

      <!-- Mobile Hamburger -->
      <button class="nav-hamburger" id="hamburgerBtn" aria-label="Toggle navigation menu" aria-expanded="false">
        <span></span>
        <span></span>
        <span></span>
      </button>
    </div>

  </div>
</nav>
</header>
