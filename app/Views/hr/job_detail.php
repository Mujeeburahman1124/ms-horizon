<div class="breadcrumb-section">
  <div class="container">
    <h1><?= htmlspecialchars($job['title'], ENT_QUOTES, 'UTF-8') ?></h1>
    <div class="breadcrumb-nav">
      <a href="<?= APP_URL ?>/">Home</a> <span>/</span>
      <a href="<?= APP_URL ?>/careers">Careers</a> <span>/</span>
      <span>Job Detail</span>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <span class="badge bg-warning text-dark px-3 py-2 fs-6"><?= htmlspecialchars($job['job_type'], ENT_QUOTES, 'UTF-8') ?></span>
            <span class="text-muted"><i class="fas fa-calendar-alt me-1"></i> Posted: <?= date('d M Y', strtotime($job['created_at'])) ?></span>
          </div>

          <h2 class="h3 font-weight-bold mb-3"><?= htmlspecialchars($job['title'], ENT_QUOTES, 'UTF-8') ?></h2>

          <div class="row g-3 py-3 border-top border-bottom my-3">
            <div class="col-6 col-md-3">
              <small class="text-muted d-block text-uppercase">Location</small>
              <strong><?= htmlspecialchars($job['location'], ENT_QUOTES, 'UTF-8') ?></strong>
            </div>
            <div class="col-6 col-md-3">
              <small class="text-muted d-block text-uppercase">Salary Range</small>
              <strong class="text-success"><?= htmlspecialchars($job['salary_range'], ENT_QUOTES, 'UTF-8') ?></strong>
            </div>
            <div class="col-6 col-md-3">
              <small class="text-muted d-block text-uppercase">Experience</small>
              <strong><?= htmlspecialchars($job['experience_level'], ENT_QUOTES, 'UTF-8') ?></strong>
            </div>
            <div class="col-6 col-md-3">
              <small class="text-muted d-block text-uppercase">Category</small>
              <strong><?= htmlspecialchars($job['category'], ENT_QUOTES, 'UTF-8') ?></strong>
            </div>
          </div>

          <h3 class="h5 font-weight-bold mt-4 mb-3">Job Description</h3>
          <div><?= nl2br(htmlspecialchars($job['description'], ENT_QUOTES, 'UTF-8')) ?></div>

          <h3 class="h5 font-weight-bold mt-4 mb-3">Requirements & Qualifications</h3>
          <div><?= nl2br(htmlspecialchars($job['requirements'], ENT_QUOTES, 'UTF-8')) ?></div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center" style="background:var(--clr-navy-mid);color:white;">
          <h3 class="h5 font-weight-bold text-warning mb-3"><i class="fas fa-paper-plane me-2"></i> Apply for Position</h3>
          <p class="small text-muted mb-4">Click below to submit your application with your saved CV profile.</p>

          <form data-ajax="true" action="<?= APP_URL ?>/careers/<?= htmlspecialchars($job['slug'], ENT_QUOTES, 'UTF-8') ?>/apply" method="POST">
            <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
            
            <div class="mb-3 text-start">
              <label class="form-label small text-uppercase text-muted">Cover Letter / Note (Optional)</label>
              <textarea name="cover_letter" rows="4" placeholder="Brief statement about your interest in this role..." class="form-control bg-dark text-white border-secondary"></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100 justify-content-center">
              <i class="fas fa-check-circle me-2"></i> Submit Application
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
