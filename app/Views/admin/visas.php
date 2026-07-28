<div class="admin-toolbar">
  <div class="admin-search-wrap">
    <i class="fas fa-search"></i>
    <input type="text" id="visaSearchInput" class="admin-search-input" placeholder="Search visa applications by name, reference, passport...">
  </div>
  <select class="admin-form-control" style="width:200px;" onchange="window.location='<?= APP_URL ?>/admin/visas?status=' + this.value">
    <option value="">All Statuses</option>
    <option value="Submitted" <?= ($selected_status ?? '') === 'Submitted' ? 'selected' : '' ?>>Submitted</option>
    <option value="Under Review" <?= ($selected_status ?? '') === 'Under Review' ? 'selected' : '' ?>>Under Review</option>
    <option value="Approved" <?= ($selected_status ?? '') === 'Approved' ? 'selected' : '' ?>>Approved</option>
    <option value="Rejected" <?= ($selected_status ?? '') === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
  </select>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><i class="fas fa-passport text-warning me-2"></i> All Visa Applications</h3>
  </div>
  <div class="table-responsive">
    <table class="admin-table" id="visaTable">
      <thead>
        <tr>
          <th>Reference</th>
          <th>Applicant Name</th>
          <th>Passport No</th>
          <th>Visa Service</th>
          <th>Phone</th>
          <th>Status</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (($applications ?? []) as $app): ?>
        <tr>
          <td><strong class="text-gold"><?= htmlspecialchars($app['app_reference'], ENT_QUOTES, 'UTF-8') ?></strong></td>
          <td><?= htmlspecialchars($app['applicant_name'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><code><?= htmlspecialchars($app['passport_number'], ENT_QUOTES, 'UTF-8') ?></code></td>
          <td><?= htmlspecialchars($app['visa_title'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($app['phone'], ENT_QUOTES, 'UTF-8') ?></td>
          <td>
            <select class="admin-form-control status-change-select" style="padding:.25rem .5rem;font-size:.75rem;" data-url="<?= APP_URL ?>/admin/visas/<?= $app['id'] ?>/status">
              <option value="Submitted" <?= $app['status'] === 'Submitted' ? 'selected' : '' ?>>Submitted</option>
              <option value="Under Review" <?= $app['status'] === 'Under Review' ? 'selected' : '' ?>>Under Review</option>
              <option value="Documents Required" <?= $app['status'] === 'Documents Required' ? 'selected' : '' ?>>Documents Required</option>
              <option value="Approved" <?= $app['status'] === 'Approved' ? 'selected' : '' ?>>Approved</option>
              <option value="Rejected" <?= $app['status'] === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
            </select>
          </td>
          <td><?= date('d M Y', strtotime($app['created_at'])) ?></td>
          <td>
            <a href="<?= APP_URL ?>/admin/visas/<?= $app['id'] ?>" class="admin-btn admin-btn-ghost admin-btn-sm"><i class="fas fa-eye"></i> View</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
