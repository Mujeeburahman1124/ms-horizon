<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><i class="fas fa-shield-halved text-warning me-2"></i> Security Audit Logs</h3>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>User Email</th>
          <th>Action</th>
          <th>Details</th>
          <th>IP Address</th>
          <th>Timestamp</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (($logs ?? []) as $log): ?>
        <tr>
          <td><strong><?= htmlspecialchars($log['user_email'] ?? 'System', ENT_QUOTES, 'UTF-8') ?></strong></td>
          <td><span class="badge bg-secondary"><?= htmlspecialchars($log['action'], ENT_QUOTES, 'UTF-8') ?></span></td>
          <td><?= htmlspecialchars($log['details'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
          <td><code><?= htmlspecialchars($log['ip_address'], ENT_QUOTES, 'UTF-8') ?></code></td>
          <td><?= date('d M Y, h:i:s A', strtotime($log['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
