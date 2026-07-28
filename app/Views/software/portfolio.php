<div class="breadcrumb-section">
  <div class="container">
    <h1>Software Engineering Portfolio</h1>
    <div class="breadcrumb-nav"><a href="<?= APP_URL ?>/">Home</a> <span>/</span> <a href="<?= APP_URL ?>/software">Software</a> <span>/</span> <span>Portfolio</span></div>
  </div>
</div>
<section class="section">
  <div class="container">
    <div class="row g-4">
      <?php foreach (($portfolio ?? []) as $p): ?>
      <div class="col-md-6">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
          <div class="p-4 bg-dark text-white d-flex align-items-center justify-content-between">
            <div>
              <span class="badge bg-warning text-dark mb-1"><?= htmlspecialchars($p['category'], ENT_QUOTES, 'UTF-8') ?></span>
              <h3 class="h5 font-weight-bold mb-0"><?= htmlspecialchars($p['title'], ENT_QUOTES, 'UTF-8') ?></h3>
            </div>
            <i class="fas fa-laptop-code fa-2x text-warning"></i>
          </div>
          <div class="card-body p-4">
            <p class="text-muted small mb-3"><?= htmlspecialchars($p['description'], ENT_QUOTES, 'UTF-8') ?></p>
            <div class="d-flex align-items-center justify-content-between">
              <span class="small text-muted"><i class="fas fa-clock me-1"></i> <?= htmlspecialchars($p['duration'], ENT_QUOTES, 'UTF-8') ?></span>
              <a href="<?= APP_URL ?>/software" class="btn btn-primary btn-sm">Request Similar App</a>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
