<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><i class="fas fa-plane-departure text-warning me-2"></i> All Reservation Requests</h3>
  </div>
  <div class="table-responsive">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Booking Ref</th>
          <th>Service Type</th>
          <th>Customer Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Travel Date</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (($reservations ?? []) as $res): ?>
        <tr>
          <td><strong class="text-gold"><?= htmlspecialchars($res['booking_ref'], ENT_QUOTES, 'UTF-8') ?></strong></td>
          <td><?= htmlspecialchars($res['service_type'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($res['customer_name'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($res['customer_email'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= htmlspecialchars($res['customer_phone'], ENT_QUOTES, 'UTF-8') ?></td>
          <td><?= date('d M Y', strtotime($res['travel_date'])) ?></td>
          <td>
            <select class="admin-form-control status-change-select" style="padding:.25rem .5rem;font-size:.75rem;" data-url="<?= APP_URL ?>/admin/reservations/<?= $res['id'] ?>/status">
              <option value="Pending Quote" <?= $res['status'] === 'Pending Quote' ? 'selected' : '' ?>>Pending Quote</option>
              <option value="Quoted" <?= $res['status'] === 'Quoted' ? 'selected' : '' ?>>Quoted</option>
              <option value="Confirmed" <?= $res['status'] === 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
              <option value="Voucher Issued" <?= $res['status'] === 'Voucher Issued' ? 'selected' : '' ?>>Voucher Issued</option>
              <option value="Cancelled" <?= $res['status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
            </select>
          </td>
          <td><a href="<?= APP_URL ?>/admin/reservations/<?= $res['id'] ?>" class="admin-btn admin-btn-ghost admin-btn-sm"><i class="fas fa-eye"></i> Details</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
