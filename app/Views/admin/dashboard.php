<!-- ─── KPI METRIC CARDS ROW 1 ────────────────────────────────── -->
<div class="kpi-grid" style="grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1.25rem;margin-bottom:1.5rem;">

  <div class="kpi-card gold">
    <div class="kpi-header">
      <span class="kpi-label">Visa Applications</span>
      <div class="kpi-icon"><i class="fas fa-passport"></i></div>
    </div>
    <div class="kpi-number"><?= number_format($metrics['visa_applications'] ?? 0) ?></div>
    <div class="kpi-meta"><span class="positive"><i class="fas fa-clock fa-xs"></i> <?= $metrics['pending_visas'] ?? 0 ?> Pending</span></div>
  </div>

  <div class="kpi-card emerald">
    <div class="kpi-header">
      <span class="kpi-label">Reservations</span>
      <div class="kpi-icon"><i class="fas fa-plane-departure"></i></div>
    </div>
    <div class="kpi-number"><?= number_format($metrics['reservations'] ?? 0) ?></div>
    <div class="kpi-meta"><span class="positive"><?= $metrics['pending_reservations'] ?? 0 ?> Pending Quote</span></div>
  </div>

  <div class="kpi-card blue">
    <div class="kpi-header">
      <span class="kpi-label">Business Leads</span>
      <div class="kpi-icon"><i class="fas fa-building-columns"></i></div>
    </div>
    <div class="kpi-number"><?= number_format($metrics['business_leads'] ?? 0) ?></div>
    <div class="kpi-meta"><span class="positive"><?= $metrics['new_leads'] ?? 0 ?> New</span></div>
  </div>

  <div class="kpi-card orange">
    <div class="kpi-header">
      <span class="kpi-label">Candidates</span>
      <div class="kpi-icon"><i class="fas fa-user-tie"></i></div>
    </div>
    <div class="kpi-number"><?= number_format($metrics['total_candidates'] ?? 0) ?></div>
    <div class="kpi-meta"><span class="positive"><?= $metrics['active_jobs'] ?? 0 ?> Active Jobs</span></div>
  </div>

  <div class="kpi-card red">
    <div class="kpi-header">
      <span class="kpi-label">Enquiries</span>
      <div class="kpi-icon"><i class="fas fa-envelope"></i></div>
    </div>
    <div class="kpi-number"><?= number_format($metrics['total_enquiries'] ?? 0) ?></div>
    <div class="kpi-meta">All Divisions</div>
  </div>

  <div class="kpi-card purple" style="--kpi-accent:#7C3AED;">
    <div class="kpi-header">
      <span class="kpi-label">Software Projects</span>
      <div class="kpi-icon"><i class="fas fa-laptop-code"></i></div>
    </div>
    <div class="kpi-number"><?= number_format($metrics['software_projects'] ?? 0) ?></div>
    <div class="kpi-meta">Development Queue</div>
  </div>

</div>

<!-- ─── QUICK EXPORT ACTIONS ───────────────────────────────────── -->
<div class="admin-card" style="margin-bottom:1.5rem;">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><i class="fas fa-download"></i> Quick Export Reports</h3>
  </div>
  <div style="display:flex;gap:.75rem;flex-wrap:wrap;padding:.25rem 0;">
    <a href="<?= APP_URL ?>/admin/export/visas" class="admin-btn admin-btn-primary admin-btn-sm">
      <i class="fas fa-passport"></i> Visa CSV
    </a>
    <a href="<?= APP_URL ?>/admin/export/reservations" class="admin-btn admin-btn-ghost admin-btn-sm">
      <i class="fas fa-plane"></i> Reservations CSV
    </a>
    <a href="<?= APP_URL ?>/admin/export/candidates" class="admin-btn admin-btn-ghost admin-btn-sm">
      <i class="fas fa-user-tie"></i> Candidates CSV
    </a>
    <a href="<?= APP_URL ?>/admin/export/leads" class="admin-btn admin-btn-ghost admin-btn-sm">
      <i class="fas fa-building"></i> Business Leads CSV
    </a>
  </div>
</div>

<!-- ─── DATA TABLES GRID ────────────────────────────────────────── -->
<div class="row g-4">

  <!-- Recent Visa Applications -->
  <div class="col-lg-6">
    <div class="admin-card h-100">
      <div class="admin-card-header">
        <h3 class="admin-card-title"><i class="fas fa-passport"></i> Recent Visa Applications</h3>
        <a href="<?= APP_URL ?>/admin/visas" class="admin-btn admin-btn-ghost admin-btn-sm">View All</a>
      </div>
      <div class="table-responsive">
        <table class="admin-table">
          <thead><tr><th>Ref</th><th>Applicant</th><th>Visa</th><th>Status</th></tr></thead>
          <tbody>
            <?php if (!empty($recent_visa_apps)): ?>
              <?php foreach ($recent_visa_apps as $app): ?>
              <tr>
                <td><a href="<?= APP_URL ?>/admin/visas/<?= $app['id'] ?>" class="text-gold"><?= htmlspecialchars($app['app_reference'] ?? '—', ENT_QUOTES, 'UTF-8') ?></a></td>
                <td><?= htmlspecialchars($app['applicant_name'] ?? '—', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($app['visa_title'] ?? '—', ENT_QUOTES, 'UTF-8') ?></td>
                <td><span class="status-badge status-<?= strtolower(str_replace(' ', '-', $app['status'] ?? 'new')) ?>"><?= htmlspecialchars($app['status'] ?? 'New', ENT_QUOTES, 'UTF-8') ?></span></td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="4" style="text-align:center;color:rgba(255,255,255,.3);padding:2rem;"><i class="fas fa-passport fa-2x" style="display:block;margin-bottom:.5rem;opacity:.2;"></i>No visa applications yet</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Recent Business Leads -->
  <div class="col-lg-6">
    <div class="admin-card h-100">
      <div class="admin-card-header">
        <h3 class="admin-card-title"><i class="fas fa-building-columns"></i> Recent Business Leads</h3>
        <a href="<?= APP_URL ?>/admin/business-leads" class="admin-btn admin-btn-ghost admin-btn-sm">View All</a>
      </div>
      <div class="table-responsive">
        <table class="admin-table">
          <thead><tr><th>Ref</th><th>Name</th><th>Setup Type</th><th>Status</th></tr></thead>
          <tbody>
            <?php if (!empty($recent_leads)): ?>
              <?php foreach ($recent_leads as $lead): ?>
              <tr>
                <td><a href="<?= APP_URL ?>/admin/business-leads/<?= $lead['id'] ?>" class="text-gold"><?= htmlspecialchars($lead['lead_ref'] ?? '—', ENT_QUOTES, 'UTF-8') ?></a></td>
                <td><?= htmlspecialchars($lead['name'] ?? '—', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($lead['setup_type'] ?? '—', ENT_QUOTES, 'UTF-8') ?></td>
                <td><span class="status-badge status-<?= strtolower(str_replace(' ', '-', $lead['status'] ?? 'new')) ?>"><?= htmlspecialchars($lead['status'] ?? 'New', ENT_QUOTES, 'UTF-8') ?></span></td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="4" style="text-align:center;color:rgba(255,255,255,.3);padding:2rem;"><i class="fas fa-building-columns fa-2x" style="display:block;margin-bottom:.5rem;opacity:.2;"></i>No business leads yet</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Recent Reservations -->
  <div class="col-lg-6">
    <div class="admin-card h-100">
      <div class="admin-card-header">
        <h3 class="admin-card-title"><i class="fas fa-plane-departure"></i> Recent Reservations</h3>
        <a href="<?= APP_URL ?>/admin/reservations" class="admin-btn admin-btn-ghost admin-btn-sm">View All</a>
      </div>
      <div class="table-responsive">
        <table class="admin-table">
          <thead><tr><th>Ref</th><th>Customer</th><th>Service</th><th>Status</th></tr></thead>
          <tbody>
            <?php if (!empty($recent_reservations)): ?>
              <?php foreach ($recent_reservations as $res): ?>
              <tr>
                <td><span class="text-gold"><?= htmlspecialchars($res['booking_ref'] ?? '—', ENT_QUOTES, 'UTF-8') ?></span></td>
                <td><?= htmlspecialchars($res['customer_name'] ?? '—', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($res['service_type'] ?? '—', ENT_QUOTES, 'UTF-8') ?></td>
                <td><span class="status-badge status-<?= strtolower(str_replace(' ', '-', $res['status'] ?? 'new')) ?>"><?= htmlspecialchars($res['status'] ?? 'New', ENT_QUOTES, 'UTF-8') ?></span></td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="4" style="text-align:center;color:rgba(255,255,255,.3);padding:2rem;"><i class="fas fa-plane fa-2x" style="display:block;margin-bottom:.5rem;opacity:.2;"></i>No reservations yet</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Recent Candidates -->
  <div class="col-lg-6">
    <div class="admin-card h-100">
      <div class="admin-card-header">
        <h3 class="admin-card-title"><i class="fas fa-user-tie"></i> Recent Candidates</h3>
        <a href="<?= APP_URL ?>/admin/candidates" class="admin-btn admin-btn-ghost admin-btn-sm">View All</a>
      </div>
      <div class="table-responsive">
        <table class="admin-table">
          <thead><tr><th>Name</th><th>Nationality</th><th>Experience</th><th>Status</th></tr></thead>
          <tbody>
            <?php if (!empty($recent_candidates)): ?>
              <?php foreach ($recent_candidates as $c): ?>
              <tr>
                <td><?= htmlspecialchars($c['full_name'] ?? '—', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($c['nationality'] ?? '—', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($c['experience_years'] ?? '—', ENT_QUOTES, 'UTF-8') ?> yrs</td>
                <td><span class="status-badge status-<?= strtolower($c['status'] ?? 'active') ?>"><?= htmlspecialchars($c['status'] ?? 'Active', ENT_QUOTES, 'UTF-8') ?></span></td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="4" style="text-align:center;color:rgba(255,255,255,.3);padding:2rem;"><i class="fas fa-users fa-2x" style="display:block;margin-bottom:.5rem;opacity:.2;"></i>No candidates yet</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div><!-- /.row -->
