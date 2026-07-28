<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><i class="fas fa-plane-departure text-warning me-2"></i> Reservation #<?= $reservation['id'] ?> Details</h3>
    <a href="<?= APP_URL ?>/admin/reservations" class="admin-btn admin-btn-ghost admin-btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
  </div>
  <div class="p-4">
    <p><strong>Booking Ref:</strong> <span class="text-gold"><?= htmlspecialchars($reservation['booking_ref'], ENT_QUOTES, 'UTF-8') ?></span></p>
    <p><strong>Service Type:</strong> <?= htmlspecialchars($reservation['service_type'], ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Customer Name:</strong> <?= htmlspecialchars($reservation['customer_name'], ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($reservation['customer_email'], ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($reservation['customer_phone'], ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Travel Date:</strong> <?= date('d M Y', strtotime($reservation['travel_date'])) ?></p>
    <p><strong>Requirements:</strong></p>
    <div class="p-3 bg-dark rounded border border-secondary mb-4"><?= nl2br(htmlspecialchars($reservation['details'], ENT_QUOTES, 'UTF-8')) ?></div>
  </div>
</div>
