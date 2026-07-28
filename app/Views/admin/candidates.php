<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><i class="fas fa-user-tie text-warning me-2"></i> Candidate Database</h3>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Nationality</th>
          <th>Experience</th>
          <th>Current Title</th>
          <th>Contact Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (($candidates ?? []) as $c): ?>
        <tr>
          <td><strong><?= htmlspecialchars($c['full_name'], ENT_QUOTES, 'UTF-8') ?></strong></td>
          <td><?= htmlspecialchars($c['nationality'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= $c['experience_years'] ?> Years</td>
          <td><?= htmlspecialchars($c['current_title'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></td>
          <td>
            <?php if ($c['is_contact_unlocked']): ?>
            <span class="badge bg-success"><i class="fas fa-lock-open"></i> Unlocked</span>
            <?php else: ?>
            <span class="badge bg-secondary"><i class="fas fa-lock"></i> Masked</span>
            <?php endif; ?>
          </td>
          <td>
            <a href="<?= APP_URL ?>/admin/candidates/<?= $c['id'] ?>" class="admin-btn admin-btn-ghost admin-btn-sm"><i class="fas fa-eye"></i> View Profile</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
