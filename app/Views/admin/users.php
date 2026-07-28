<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><i class="fas fa-users text-warning me-2"></i> System Users & Roles</h3>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Role Title</th>
          <th>Phone</th>
          <th>Status</th>
          <th>Last Login</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (($users ?? []) as $u): ?>
        <tr>
          <td><strong><?= htmlspecialchars($u['name'], ENT_QUOTES, 'UTF-8') ?></strong></td>
          <td><?= htmlspecialchars($u['email'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><span class="badge bg-warning text-dark"><?= htmlspecialchars($u['role_title'], ENT_QUOTES, 'UTF-8') ?></span></td>
          <td><?= htmlspecialchars($u['phone'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= $u['is_active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Disabled</span>' ?></td>
          <td><?= $u['last_login_at'] ? date('d M Y, h:i A', strtotime($u['last_login_at'])) : 'Never' ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
