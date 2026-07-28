<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><i class="fas fa-envelope text-warning me-2"></i> All Contact Enquiries</h3>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Department</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Subject</th>
          <th>Message</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (($enquiries ?? []) as $eq): ?>
        <tr>
          <td><span class="badge bg-primary"><?= htmlspecialchars($eq['department'], ENT_QUOTES, 'UTF-8') ?></span></td>
          <td><strong><?= htmlspecialchars($eq['name'], ENT_QUOTES, 'UTF-8') ?></strong></td>
          <td><?= htmlspecialchars($eq['email'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($eq['phone'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($eq['subject'], ENT_QUOTES, 'UTF-8') ?></td>
          <td style="max-width:250px;"><?= htmlspecialchars($eq['message'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= date('d M Y', strtotime($eq['created_at'])) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
