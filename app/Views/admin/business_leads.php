<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><i class="fas fa-building-columns text-warning me-2"></i> UAE Business Setup Leads</h3>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Lead Ref</th>
          <th>Client Name</th>
          <th>Setup Jurisdiction</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (($leads ?? []) as $lead): ?>
        <tr>
          <td><strong class="text-gold"><?= htmlspecialchars($lead['lead_ref'], ENT_QUOTES, 'UTF-8') ?></strong></td>
          <td><?= htmlspecialchars($lead['name'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($lead['setup_type'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($lead['email'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($lead['phone'], ENT_QUOTES, 'UTF-8') ?></td>
          <td>
            <select class="admin-form-control status-change-select" style="padding:.25rem .5rem;font-size:.75rem;" data-url="<?= APP_URL ?>/admin/business-leads/<?= $lead['id'] ?>/status">
              <option value="New" <?= $lead['status'] === 'New' ? 'selected' : '' ?>>New</option>
              <option value="Contacted" <?= $lead['status'] === 'Contacted' ? 'selected' : '' ?>>Contacted</option>
              <option value="Proposal Sent" <?= $lead['status'] === 'Proposal Sent' ? 'selected' : '' ?>>Proposal Sent</option>
              <option value="Closed Won" <?= $lead['status'] === 'Closed Won' ? 'selected' : '' ?>>Closed Won</option>
              <option value="Closed Lost" <?= $lead['status'] === 'Closed Lost' ? 'selected' : '' ?>>Closed Lost</option>
            </select>
          </td>
          <td><?= date('d M Y', strtotime($lead['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
