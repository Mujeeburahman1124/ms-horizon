<div class="breadcrumb-section">
  <div class="container">
    <h1><i class="fas fa-user-circle text-warning me-2"></i> Candidate Portal</h1>
    <div class="breadcrumb-nav">
      <a href="<?= APP_URL ?>/">Home</a> <span>/</span>
      <span>Candidate Dashboard</span>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="row g-4">
      <!-- Profile Card -->
      <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
          <div style="width:80px;height:80px;border-radius:50%;background:var(--grad-gold);display:flex;align-items:center;justify-content:center;font-size:2.5rem;color:var(--clr-navy);margin:0 auto 1rem;font-weight:700;">
            <?= strtoupper(substr($candidate['full_name'] ?? 'C', 0, 1)) ?>
          </div>
          <h2 class="h5 font-weight-bold mb-1"><?= htmlspecialchars($candidate['full_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></h2>
          <p class="text-muted small mb-3"><?= htmlspecialchars($candidate['current_title'] ?? 'Candidate', ENT_QUOTES, 'UTF-8') ?></p>
          
          <div class="p-3 bg-light rounded-3 text-start small mb-3">
            <div class="mb-2"><i class="fas fa-envelope text-primary me-2"></i> <?= htmlspecialchars($candidate['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
            <div class="mb-2"><i class="fas fa-phone text-success me-2"></i> <?= htmlspecialchars($candidate['phone'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
            <div><i class="fas fa-flag text-warning me-2"></i> <?= htmlspecialchars($candidate['nationality'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
          </div>

          <a href="<?= APP_URL ?>/careers" class="btn btn-primary w-100 mb-2"><i class="fas fa-search"></i> Browse Vacancies</a>
          <a href="<?= APP_URL ?>/logout" class="btn btn-outline-danger w-100 btn-sm"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
      </div>

      <!-- Applied Jobs List -->
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
          <h3 class="h5 font-weight-bold mb-4"><i class="fas fa-paper-plane text-warning me-2"></i> My Job Applications</h3>

          <?php if (empty($applications)): ?>
          <div class="text-center py-5">
            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
            <p class="text-muted">You haven't applied for any jobs yet.</p>
            <a href="<?= APP_URL ?>/careers" class="btn btn-primary btn-sm">Explore Open Positions</a>
          </div>
          <?php else: ?>
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>Job Title</th>
                  <th>Location</th>
                  <th>Applied On</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($applications as $app): ?>
                <tr>
                  <td><strong><?= htmlspecialchars($app['job_title'], ENT_QUOTES, 'UTF-8') ?></strong></td>
                  <td><?= htmlspecialchars($app['location'], ENT_QUOTES, 'UTF-8') ?></td>
                  <td><?= date('d M Y', strtotime($app['applied_at'])) ?></td>
                  <td>
                    <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $app['status'])) ?>">
                      <?= htmlspecialchars($app['status'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
