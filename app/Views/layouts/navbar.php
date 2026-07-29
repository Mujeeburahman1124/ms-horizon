<?php
// Shared divisions data for mega menu
$nav_divisions = [
    ['slug' => 'reservations-services', 'title' => 'Reservations',    'icon' => 'fa-plane-departure', 'desc' => 'Flights, Hotels, Transfers',  'url' => '/reservations'],
    ['slug' => 'travel-tourism',        'title' => 'Travel & Tourism', 'icon' => 'fa-passport',        'desc' => 'Visa & Holiday Packages',     'url' => '/travel'],
    ['slug' => 'hr-consultancy',        'title' => 'HR Consultancy',   'icon' => 'fa-users-gear',      'desc' => 'Recruitment & Careers',       'url' => '/careers'],
    ['slug' => 'business-consultancy',  'title' => 'Business Setup',   'icon' => 'fa-building-columns', 'desc' => 'UAE Company Formation',      'url' => '/business'],
    ['slug' => 'software-development',  'title' => 'Software Dev',     'icon' => 'fa-laptop-code',     'desc' => 'Web, Apps & Automation',      'url' => '/software'],
];
$currentUri = \App\Core\Request::getUri();
?>

<!-- ─── LOADING SCREEN ─────────────────────────────────────── -->
<div id="page-loader" role="status" aria-label="Loading MS Horizon">
  <div class="loader-logo">MS <span>Horizon</span></div>
  <div class="loader-bar"><div class="loader-bar-fill"></div></div>
</div>

<!-- ─── MOBILE NAV OVERLAY ────────────────────────────────────── -->
<div id="mobileNavOverlay" style="display:none;position:fixed;inset:0;background:rgba(5,10,20,.75);backdrop-filter:blur(4px);z-index:998;opacity:0;transition:opacity .3s;" aria-hidden="true"></div>

<!-- ─── NAVIGATION ──────────────────────────────────────────── -->
<header>
<nav class="navbar-msh" role="navigation" aria-label="Main navigation" id="main-navbar">
  <div style="display:flex;align-items:center;justify-content:space-between;width:100%;gap:.75rem;">

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
        <a href="<?= APP_URL ?>/" class="nav-link-btn <?= $currentUri === '/' ? 'active-nav' : '' ?>" role="menuitem">
          <i class="fas fa-home"></i> <?= __t('Home') ?>
        </a>
      </li>

      <!-- Services Mega Menu -->
      <li class="nav-item" role="none">
        <button class="nav-link-btn" role="menuitem" aria-haspopup="true" aria-expanded="false" type="button">
          <i class="fas fa-th-large"></i> <?= __t('Services') ?> <i class="fas fa-chevron-down chevron"></i>
        </button>
        <div class="mega-menu" role="menu">
          <div class="mega-menu-grid">
            <?php foreach ($nav_divisions as $div): ?>
            <a href="<?= APP_URL . $div['url'] ?>" class="mega-card" role="menuitem">
              <div class="mega-card-icon"><i class="fas <?= $div['icon'] ?>"></i></div>
              <div class="mega-card-info">
                <h4><?= $div['title'] ?></h4>
                <p><?= $div['desc'] ?></p>
              </div>
            </a>
            <?php endforeach; ?>
          </div>
          <div class="mega-menu-footer">
            <span><i class="fas fa-shield-halved"></i> Registered Corporate Group in Dubai, UAE</span>
            <a href="<?= APP_URL ?>/services" style="color:var(--clr-gold);font-weight:600;">All Services &rsaquo;</a>
          </div>
        </div>
      </li>

      <li class="nav-item" role="none">
        <a href="<?= APP_URL ?>/travel/countries" class="nav-link-btn" role="menuitem">
          <i class="fas fa-globe"></i> <?= __t('Countries') ?>
        </a>
      </li>

      <li class="nav-item" role="none">
        <a href="<?= APP_URL ?>/offers" class="nav-link-btn" role="menuitem">
          <i class="fas fa-tags"></i> <?= __t('Offers') ?>
        </a>
      </li>

      <li class="nav-item" role="none">
        <a href="<?= APP_URL ?>/careers" class="nav-link-btn" role="menuitem">
          <i class="fas fa-briefcase"></i> <?= __t('Careers') ?>
        </a>
      </li>

      <li class="nav-item" role="none">
        <a href="<?= APP_URL ?>/about" class="nav-link-btn" role="menuitem">
          <i class="fas fa-building"></i> <?= __t('About Us') ?>
        </a>
      </li>

      <li class="nav-item" role="none">
        <a href="<?= APP_URL ?>/contact" class="nav-link-btn" role="menuitem">
          <i class="fas fa-envelope"></i> <?= __t('Contact Us') ?>
        </a>
      </li>
    </ul>

    <!-- Right Controls -->
    <div class="nav-controls">

      <!-- Language Switcher -->
      <?php $currUri = strtok($_SERVER['REQUEST_URI'] ?? '/', '?'); ?>
      <div class="dropdown">
        <button class="nav-ctrl-btn dropdown-toggle" type="button" id="langSelectBtn"
                data-bs-toggle="dropdown" aria-expanded="false" title="Select Language">
          <i class="fas fa-globe"></i>
          <span style="font-weight:700;"><?= strtoupper(APP_LANG) ?></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="langSelectBtn"
            style="background:#0F172A;border:1px solid rgba(212,175,55,.25);border-radius:12px;padding:.5rem;min-width:160px;">
          <li><a class="dropdown-item text-white rounded-2 py-2" href="<?= $currUri ?>?lang=en"><span class="me-2">🇦🇪</span> English (EN)</a></li>
          <li><a class="dropdown-item text-white rounded-2 py-2" href="<?= $currUri ?>?lang=ar"><span class="me-2">🇦🇪</span> العربية (AR)</a></li>
          <li><a class="dropdown-item text-white rounded-2 py-2" href="<?= $currUri ?>?lang=ta"><span class="me-2">🇮🇳</span> தமிழ் (TA)</a></li>
        </ul>
      </div>

      <!-- Theme Toggle -->
      <button class="btn-theme-toggle" aria-label="Toggle Theme" title="Toggle Dark/Light Mode">
        <i class="fas fa-moon"></i>
      </button>

      <!-- Portal Button -->
      <?php if (!empty($current_user)): ?>
        <a href="<?= APP_URL ?>/admin/dashboard" class="btn-portal-pill d-none d-sm-inline-flex">
          <i class="fas fa-chart-line"></i> <span><?= __t('Dashboard') ?></span>
        </a>
      <?php else: ?>
        <a href="<?= APP_URL ?>/login" class="btn-portal-pill d-none d-sm-inline-flex">
          <i class="fas fa-lock"></i> <span><?= __t('Portal Login') ?></span>
        </a>
      <?php endif; ?>

      <!-- Mobile Hamburger -->
      <button class="nav-hamburger" id="hamburgerBtn"
              aria-label="Toggle navigation menu" aria-expanded="false"
              aria-controls="navLinks">
        <span></span>
        <span></span>
        <span></span>
      </button>

    </div>
  </div>
</nav>
</header>
