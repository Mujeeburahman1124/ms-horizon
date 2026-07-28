<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><i class="fas fa-laptop-code text-warning me-2"></i> Software Project Enquiries</h3>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Project Ref</th>
          <th>Client Name</th>
          <th>Project Type</th>
          <th>Budget</th>
          <th>Timeline</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (($projects ?? []) as $proj): ?>
        <tr>
          <td><strong class="text-gold"><?= htmlspecialchars($proj['project_ref'], ENT_QUOTES, 'UTF-8') ?></strong></td>
          <td><?= htmlspecialchars($proj['client_name'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($proj['project_type'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($proj['budget_range'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($proj['timeline'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><span class="badge bg-warning text-dark"><?= htmlspecialchars($proj['status'], ENT_QUOTES, 'UTF-8') ?></span></td>
          <td><a href="<?= APP_URL ?>/admin/software-projects/<?= $proj['id'] ?>" class="admin-btn admin-btn-ghost admin-btn-sm"><i class="fas fa-eye"></i> View Scope</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
