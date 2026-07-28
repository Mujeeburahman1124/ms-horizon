<div class="breadcrumb-section">
  <div class="container">
    <h1><i class="fas fa-search-location text-warning me-2"></i> Track Visa Application</h1>
    <div class="breadcrumb-nav">
      <a href="<?= APP_URL ?>/">Home</a> <span>/</span>
      <a href="<?= APP_URL ?>/travel">Travel</a> <span>/</span>
      <span>Track Application</span>
    </div>
  </div>
</div>

<section class="section">
  <div class="container" style="max-width:700px;">
    <div class="card border-0 shadow-sm rounded-4 p-4 text-center mb-4">
      <h2 class="h4 font-weight-bold mb-3">Real-time Visa Status Tracker</h2>
      <p class="text-muted mb-4">Track your application instantly using your <strong>Application Number (VISA-XXXX)</strong>, <strong>Passport Number</strong>, or <strong>Registered Mobile Number</strong>.</p>

      <form action="<?= APP_URL ?>/travel/track" method="POST" class="row g-2 justify-content-center">
        <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
        <div class="col-sm-8">
          <input type="text" name="reference" value="<?= htmlspecialchars($ref ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="App Ref, Passport #, or Mobile #" class="form-control form-control-lg text-center font-weight-bold" required>
        </div>
        <div class="col-sm-4">
          <button type="submit" class="btn btn-primary btn-lg w-100 justify-content-center">
            <i class="fas fa-search"></i> Track Status
          </button>
        </div>
      </form>

      <?php if (!empty($track_error)): ?>
      <div class="alert alert-danger mt-4" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i> <?= htmlspecialchars($track_error, ENT_QUOTES, 'UTF-8') ?>
      </div>
      <?php endif; ?>
    </div>

    <?php if (!empty($application)): ?>
    <div class="card border-0 shadow-lg rounded-4 p-4" style="background:var(--clr-navy);color:white;">
      <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
        <div>
          <span class="text-muted small">Application Reference</span>
          <h3 class="h5 font-weight-bold text-warning mb-0"><?= htmlspecialchars($application['app_reference'], ENT_QUOTES, 'UTF-8') ?></h3>
        </div>
        <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $application['status'])) ?> py-2 px-3 fs-6">
          <?= htmlspecialchars($application['status'], ENT_QUOTES, 'UTF-8') ?>
        </span>
      </div>

      <div class="row g-3 text-start mb-3">
        <div class="col-6">
          <small class="text-muted d-block">Applicant Name</small>
          <strong><?= htmlspecialchars($application['applicant_name'], ENT_QUOTES, 'UTF-8') ?></strong>
        </div>
        <div class="col-6">
          <small class="text-muted d-block">Visa Service</small>
          <strong><?= htmlspecialchars($application['visa_title'], ENT_QUOTES, 'UTF-8') ?></strong>
        </div>
        <div class="col-6">
          <small class="text-muted d-block">Passport Number</small>
          <strong><?= htmlspecialchars($application['passport_number'], ENT_QUOTES, 'UTF-8') ?></strong>
        </div>
        <div class="col-6">
          <small class="text-muted d-block">Registered Mobile</small>
          <strong><?= htmlspecialchars($application['phone'], ENT_QUOTES, 'UTF-8') ?></strong>
        </div>
        <div class="col-12">
          <small class="text-muted d-block">Submission Timestamp</small>
          <strong><?= date('d M Y, h:i A', strtotime($application['created_at'])) ?></strong>
        </div>
      </div>

      <?php if (!empty($application['admin_notes'])): ?>
      <div class="p-3 rounded-3 bg-dark text-warning small border border-warning">
        <strong>Case Officer Update:</strong> <?= htmlspecialchars($application['admin_notes'], ENT_QUOTES, 'UTF-8') ?>
      </div>
      <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
</section>
