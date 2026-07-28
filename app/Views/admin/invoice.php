<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Corporate Invoice — MS Horizon Group</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <style>
    body { background: #F8FAFC; font-family: 'Plus Jakarta Sans', sans-serif; color: #0F172A; padding: 2rem 0; }
    .invoice-card { background: white; border-radius: 16px; border: 1px solid #E2E8F0; padding: 3rem; box-shadow: 0 10px 30px rgba(0,0,0,.05); max-width: 800px; margin: 0 auto; }
    .invoice-header { display: flex; justify-content: space-between; align-items: flex-start; padding-bottom: 2rem; border-bottom: 2px solid #D4AF37; margin-bottom: 2rem; }
    .brand-title { font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 900; color: #0A1628; }
    .brand-title span { color: #D4AF37; }
    .invoice-badge { background: #D4AF37; color: #0A1628; font-weight: 800; padding: .4rem 1rem; border-radius: 99px; text-transform: uppercase; font-size: .75rem; letter-spacing: 1px; }
    .invoice-table th { background: #0A1628; color: white; text-transform: uppercase; font-size: .75rem; letter-spacing: 1px; }
  </style>
</head>
<body>
<div class="container">
  <div class="invoice-card">
    <div class="invoice-header">
      <div>
        <div class="brand-title">MS <span>Horizon</span></div>
        <p class="text-muted small mb-0">MS Horizon Group LLC — Corporate Invoice</p>
        <p class="text-muted small mb-0">TRN: 100293847500003 | DET License: DED-2026-8941</p>
        <p class="text-muted small">Level 28, Horizon Tower, Business Bay, Dubai, UAE</p>
      </div>
      <div class="text-end">
        <span class="invoice-badge">TAX INVOICE</span>
        <h3 class="h5 font-weight-bold mt-2">Invoice #INV-2026-<?= str_pad($reservation['id'] ?? 101, 5, '0', STR_PAD_LEFT) ?></h3>
        <p class="small text-muted mb-0">Date: <?= date('d M Y') ?></p>
        <p class="small text-muted">Status: <strong class="text-success">PAID / CONFIRMED</strong></p>
      </div>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-6">
        <h4 class="h6 text-uppercase text-muted">Billed To:</h4>
        <strong class="h5 d-block"><?= htmlspecialchars($reservation['customer_name'] ?? 'Corporate Client', ENT_QUOTES, 'UTF-8') ?></strong>
        <p class="small text-muted mb-0">Email: <?= htmlspecialchars($reservation['customer_email'] ?? 'client@example.com', ENT_QUOTES, 'UTF-8') ?></p>
        <p class="small text-muted mb-0">Phone: <?= htmlspecialchars($reservation['customer_phone'] ?? '+971 50 XXX XXXX', ENT_QUOTES, 'UTF-8') ?></p>
      </div>
      <div class="col-6 text-end">
        <h4 class="h6 text-uppercase text-muted">Service Division:</h4>
        <strong class="h5 d-block text-warning"><?= htmlspecialchars($reservation['service_type'] ?? 'Corporate Reservation', ENT_QUOTES, 'UTF-8') ?></strong>
        <p class="small text-muted mb-0">Booking Ref: <code><?= htmlspecialchars($reservation['booking_ref'] ?? 'MSH-8941', ENT_QUOTES, 'UTF-8') ?></code></p>
      </div>
    </div>

    <div class="table-responsive mb-4">
      <table class="table table-bordered invoice-table align-middle">
        <thead>
          <tr>
            <th>Description</th>
            <th class="text-center">Qty</th>
            <th class="text-end">Unit Price (AED)</th>
            <th class="text-end">Total (AED)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <strong><?= htmlspecialchars($reservation['service_type'] ?? 'Corporate Service Booking', ENT_QUOTES, 'UTF-8') ?></strong><br>
              <span class="small text-muted"><?= htmlspecialchars($reservation['details'] ?? 'Standard Service Processing', ENT_QUOTES, 'UTF-8') ?></span>
            </td>
            <td class="text-center"><?= $reservation['passenger_count'] ?? 1 ?></td>
            <td class="text-end"><?= number_format(($reservation['amount'] ?? 1500), 2) ?></td>
            <td class="text-end"><?= number_format(($reservation['amount'] ?? 1500), 2) ?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="row align-items-center">
      <div class="col-6">
        <div class="p-3 bg-light rounded-3 small">
          <strong>Payment Method:</strong> Bank Transfer / Credit Card<br>
          <strong>Bank:</strong> Emirates NBD, Business Bay Branch<br>
          <strong>IBAN:</strong> AE280330000012345678901
        </div>
      </div>
      <div class="col-6 text-end">
        <div class="d-flex justify-content-between py-1 border-bottom"><span>Subtotal:</span> <strong>AED <?= number_format(($reservation['amount'] ?? 1500), 2) ?></strong></div>
        <div class="d-flex justify-content-between py-1 border-bottom"><span>VAT (5%):</span> <strong>AED <?= number_format(($reservation['amount'] ?? 1500) * 0.05, 2) ?></strong></div>
        <div class="d-flex justify-content-between py-2 fs-5 font-weight-bold text-success"><span>Total Paid:</span> <span>AED <?= number_format(($reservation['amount'] ?? 1500) * 1.05, 2) ?></span></div>
      </div>
    </div>

    <div class="text-center mt-5 pt-4 border-top">
      <button onclick="window.print();" class="btn btn-dark px-4 me-2"><i class="fas fa-print me-2"></i> Print Invoice / Save PDF</button>
      <a href="<?= APP_URL ?>/admin/dashboard" class="btn btn-outline-secondary">Return to Admin Panel</a>
    </div>
  </div>
</div>
</body>
</html>
