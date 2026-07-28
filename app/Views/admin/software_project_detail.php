<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><i class="fas fa-laptop-code text-warning me-2"></i> Software Project #<?= $project['id'] ?> Scope</h3>
    <a href="<?= APP_URL ?>/admin/software-projects" class="admin-btn admin-btn-ghost admin-btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
  </div>
  <div class="p-4">
    <p><strong>Project Ref:</strong> <span class="text-gold"><?= htmlspecialchars($project['project_ref'], ENT_QUOTES, 'UTF-8') ?></span></p>
    <p><strong>Client Name:</strong> <?= htmlspecialchars($project['client_name'], ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($project['client_email'], ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($project['client_phone'], ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Project Type:</strong> <?= htmlspecialchars($project['project_type'], ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Budget Range:</strong> <?= htmlspecialchars($project['budget_range'], ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Timeline:</strong> <?= htmlspecialchars($project['timeline'], ENT_QUOTES, 'UTF-8') ?></p>
    <h4 class="h5 font-weight-bold text-warning mt-4 mb-2">Requirements Brief</h4>
    <div class="p-3 bg-dark rounded border border-secondary"><?= nl2br(htmlspecialchars($project['requirements'], ENT_QUOTES, 'UTF-8')) ?></div>
  </div>
</div>
