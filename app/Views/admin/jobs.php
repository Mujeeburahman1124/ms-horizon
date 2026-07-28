<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><i class="fas fa-briefcase text-warning me-2"></i> All Job Vacancies</h3>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Job Title</th>
          <th>Category</th>
          <th>Location</th>
          <th>Salary</th>
          <th>Applications</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (($jobs ?? []) as $j): ?>
        <tr>
          <td><strong class="text-gold"><?= htmlspecialchars($j['title'], ENT_QUOTES, 'UTF-8') ?></strong></td>
          <td><?= htmlspecialchars($j['category'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($j['location'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($j['salary_range'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><span class="badge bg-primary rounded-pill"><?= $j['applications'] ?> Applicants</span></td>
          <td><?= $j['is_active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
