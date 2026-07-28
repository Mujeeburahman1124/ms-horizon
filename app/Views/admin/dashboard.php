<!-- ─── KPI METRIC CARDS ────────────────────────────────────────── -->
<div class="kpi-grid">
  <div class="kpi-card gold">
    <div class="kpi-header">
      <span class="kpi-label">Visa Applications</span>
      <div class="kpi-icon"><i class="fas fa-passport"></i></div>
    </div>
    <div class="kpi-number"><?= $metrics['visa_applications'] ?? 0 ?></div>
    <div class="kpi-meta"><span class="positive"><?= $metrics['pending_visas'] ?? 0 ?> Pending Review</span></div>
  </div>

  <div class="kpi-card emerald">
    <div class="kpi-header">
      <span class="kpi-label">Reservations</span>
      <div class="kpi-icon"><i class="fas fa-plane-departure"></i></div>
    </div>
    <div class="kpi-number"><?= $metrics['reservations'] ?? 0 ?></div>
    <div class="kpi-meta"><span class="positive"><?= $metrics['pending_reservations'] ?? 0 ?> Pending Quote</span></div>
  </div>

  <div class="kpi-card blue">
    <div class="kpi-header">
      <span class="kpi-label">Business Leads</span>
      <div class="kpi-icon"><i class="fas fa-building-columns"></i></div>
    </div>
    <div class="kpi-number"><?= $metrics['business_leads'] ?? 0 ?></div>
    <div class="kpi-meta"><span class="positive"><?= $metrics['new_leads'] ?? 0 ?> New Leads</span></div>
  </div>

  <div class="kpi-card orange">
    <div class="kpi-header">
      <span class="kpi-label">Job Candidates</span>
      <div class="kpi-icon"><i class="fas fa-user-tie"></i></div>
    </div>
    <div class="kpi-number"><?= $metrics['total_candidates'] ?? 0 ?></div>
    <div class="kpi-meta"><span class="positive"><?= $metrics['active_jobs'] ?? 0 ?> Active Jobs</span></div>
  </div>

  <div class="kpi-card red">
    <div class="kpi-header">
      <span class="kpi-label">Contact Enquiries</span>
      <div class="kpi-icon"><i class="fas fa-envelope"></i></div>
    </div>
    <div class="kpi-number"><?= $metrics['total_enquiries'] ?? 0 ?></div>
    <div class="kpi-meta">All Division Messages</div>
  </div>
</div>

<!-- ─── RECENT ACTIVITY DATA TABLES ───────────────────────────── -->
<div class="row g-4">
  <!-- Recent Visa Applications -->
  <div class="col-lg-6">
    <div class="admin-card">
      <div class="admin-card-header">
        <h3 class="admin-card-title"><i class="fas fa-passport"></i> Recent Visa Applications</h3>
        <a href="<?= APP_URL ?>/admin/visas" class="admin-btn admin-btn-ghost admin-btn-sm">View All</a>
      </div>
      <div class="table-responsive">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Ref</th>
              <th>Applicant</th>
              <th>Visa</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach (($recent_visa_apps ?? []) as $app): ?>
            <tr>
              <td><a href="<?= APP_URL ?>/admin/visas/<?= $app['id'] ?>" class="text-gold"><?= htmlspecialchars($app['app_reference'], ENT_QUOTES, 'UTF-8') ?></a></td>
              <td><?= htmlspecialchars($app['applicant_name'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($app['visa_title'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><span class="status-badge status-<?= strtolower(str_replace(' ', '-', $app['status'])) ?>"><?= htmlspecialchars($app['status'], ENT_QUOTES, 'UTF-8') ?></span></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Recent Business Leads -->
  <div class="col-lg-6">
    <div class="admin-card">
      <div class="admin-card-header">
        <h3 class="admin-card-title"><i class="fas fa-building-columns"></i> Recent Business Leads</h3>
        <a href="<?= APP_URL ?>/admin/business-leads" class="admin-btn admin-btn-ghost admin-btn-sm">View All</a>
      </div>
      <div class="table-responsive">
        <table class="admin-table">
          <thead>
            <tr>
              <th>Ref</th>
              <th>Name</th>
              <th>Setup Type</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach (($recent_leads ?? []) as $lead): ?>
            <tr>
              <td><a href="<?= APP_URL ?>/admin/business-leads/<?= $lead['id'] ?>" class="text-gold"><?= htmlspecialchars($lead['lead_ref'], ENT_QUOTES, 'UTF-8') ?></a></td>
              <td><?= htmlspecialchars($lead['name'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><?= htmlspecialchars($lead['setup_type'], ENT_QUOTES, 'UTF-8') ?></td>
              <td><span class="status-badge status-<?= strtolower(str_replace(' ', '-', $lead['status'])) ?>"><?= htmlspecialchars($lead['status'], ENT_QUOTES, 'UTF-8') ?></span></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
