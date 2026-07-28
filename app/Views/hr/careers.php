<div class="breadcrumb-section">
  <div class="container">
    <h1><i class="fas fa-briefcase text-warning me-2"></i> GCC Career Portal</h1>
    <div class="breadcrumb-nav">
      <a href="<?= APP_URL ?>/">Home</a> <span>/</span>
      <span>Careers</span>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="row align-items-center justify-content-between mb-5">
      <div>
        <span class="section-eyebrow">Recruitment & Staffing</span>
        <h2 class="section-title">Explore Active <span class="highlight">Vacancies</span></h2>
        <p class="section-subtitle">Connecting talented professionals with premier employers across Dubai & the GCC.</p>
      </div>
      <div>
        <a href="<?= APP_URL ?>/candidate/register" class="btn btn-primary me-2"><i class="fas fa-user-plus"></i> Register as Candidate</a>
        <a href="<?= APP_URL ?>/employer/register" class="btn btn-outline-dark"><i class="fas fa-building"></i> Employer Portal</a>
      </div>
    </div>

    <!-- Job Search Toolbar -->
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-5" style="background:var(--clr-navy-mid);color:white;">
      <form action="<?= APP_URL ?>/careers" method="GET" class="row g-3">
        <div class="col-md-4">
          <label class="form-label small text-uppercase text-muted">Filter Category</label>
          <select name="category" class="form-select bg-dark text-white border-secondary">
            <option value="">All Categories</option>
            <?php foreach (($categories ?? []) as $cat): ?>
            <option value="<?= htmlspecialchars($cat['category'], ENT_QUOTES, 'UTF-8') ?>" <?= ($filters['category'] ?? '') === $cat['category'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['category'], ENT_QUOTES, 'UTF-8') ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label small text-uppercase text-muted">Location</label>
          <input type="text" name="location" value="<?= htmlspecialchars($filters['location'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="e.g. Dubai, Abu Dhabi" class="form-control bg-dark text-white border-secondary">
        </div>
        <div class="col-md-4 d-flex align-items-end">
          <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Search Vacancies</button>
        </div>
      </form>
    </div>

    <!-- Job Cards List -->
    <div class="d-flex flex-column gap-3">
      <?php foreach (($jobs ?? []) as $job): ?>
      <div class="job-card">
        <div class="job-icon"><i class="fas fa-briefcase"></i></div>
        <div class="job-info flex-grow-1">
          <h4><?= htmlspecialchars($job['title'], ENT_QUOTES, 'UTF-8') ?></h4>
          <div class="job-meta">
            <span class="job-tag location"><i class="fas fa-map-marker-alt fa-xs"></i> <?= htmlspecialchars($job['location'], ENT_QUOTES, 'UTF-8') ?></span>
            <span class="job-tag"><?= htmlspecialchars($job['job_type'], ENT_QUOTES, 'UTF-8') ?></span>
            <span class="job-tag salary"><i class="fas fa-coins fa-xs"></i> <?= htmlspecialchars($job['salary_range'], ENT_QUOTES, 'UTF-8') ?></span>
            <span class="job-tag"><?= htmlspecialchars($job['category'], ENT_QUOTES, 'UTF-8') ?></span>
          </div>
        </div>
        <a href="<?= APP_URL ?>/careers/<?= htmlspecialchars($job['slug'], ENT_QUOTES, 'UTF-8') ?>" class="btn btn-primary btn-sm">
          View & Apply <i class="fas fa-arrow-right fa-xs"></i>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
