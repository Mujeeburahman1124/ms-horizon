<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><i class="fas fa-tags text-warning me-2"></i> Promotional Offers & Deals</h3>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Division</th>
          <th>Original Price</th>
          <th>Offer Price</th>
          <th>Start Date</th>
          <th>Expiry Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (($active_offers ?? []) as $off): ?>
        <tr>
          <td><strong class="text-gold"><?= htmlspecialchars($off['title'], ENT_QUOTES, 'UTF-8') ?></strong></td>
          <td><?= htmlspecialchars($off['division_name'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><s>AED <?= number_format($off['original_price'], 0) ?></s></td>
          <td><strong class="text-success">AED <?= number_format($off['offer_price'], 0) ?></strong></td>
          <td><?= date('d M Y', strtotime($off['start_date'])) ?></td>
          <td><?= date('d M Y', strtotime($off['expiry_date'])) ?></td>
          <td><span class="badge bg-success">Active</span></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
