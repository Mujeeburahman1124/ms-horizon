<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><i class="fas fa-newspaper text-warning me-2"></i> Blog Post Management</h3>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Category</th>
          <th>Author</th>
          <th>Published Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (($blogs ?? []) as $b): ?>
        <tr>
          <td><strong class="text-gold"><?= htmlspecialchars($b['title'], ENT_QUOTES, 'UTF-8') ?></strong></td>
          <td><?= htmlspecialchars($b['category'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($b['author'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= date('d M Y', strtotime($b['published_at'])) ?></td>
          <td><span class="badge bg-success">Published</span></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
