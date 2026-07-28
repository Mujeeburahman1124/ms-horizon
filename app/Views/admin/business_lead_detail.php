<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><i class="fas fa-building-columns text-warning me-2"></i> Business Lead #<?= $lead['id'] ?> Details</h3>
    <a href="<?= APP_URL ?>/admin/business-leads" class="admin-btn admin-btn-ghost admin-btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
  </div>
  <div class="p-4">
    <p><strong>Lead Ref:</strong> <span class="text-gold"><?= htmlspecialchars($lead['lead_ref'], ENT_QUOTES, 'UTF-8') ?></span></p>
    <p><strong>Client Name:</strong> <?= htmlspecialchars($lead['name'], ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Jurisdiction / Setup:</strong> <?= htmlspecialchars($lead['setup_type'], ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($lead['email'], ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($lead['phone'], ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Budget Range:</strong> <?= htmlspecialchars($lead['estimated_budget'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></p>
  </div>
</div>
