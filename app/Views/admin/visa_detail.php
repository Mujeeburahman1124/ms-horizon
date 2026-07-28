<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><i class="fas fa-passport text-warning me-2"></i> Visa Application #<?= $application['id'] ?> Details</h3>
    <a href="<?= APP_URL ?>/admin/visas" class="admin-btn admin-btn-ghost admin-btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
  </div>
  <div class="p-4">
    <div class="row g-4">
      <div class="col-md-6">
        <p><strong>Reference:</strong> <span class="text-gold"><?= htmlspecialchars($application['app_reference'], ENT_QUOTES, 'UTF-8') ?></span></p>
        <p><strong>Applicant Name:</strong> <?= htmlspecialchars($application['applicant_name'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Passport Number:</strong> <code><?= htmlspecialchars($application['passport_number'], ENT_QUOTES, 'UTF-8') ?></code></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($application['email'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($application['phone'], ENT_QUOTES, 'UTF-8') ?></p>
      </div>
      <div class="col-md-6">
        <p><strong>Visa Service:</strong> <?= htmlspecialchars($application['visa_title'], ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($application['country_name'], ENT_QUOTES, 'UTF-8') ?>)</p>
        <p><strong>Status:</strong> <span class="status-badge status-<?= strtolower(str_replace(' ', '-', $application['status'])) ?>"><?= htmlspecialchars($application['status'], ENT_QUOTES, 'UTF-8') ?></span></p>
        <p><strong>Submitted Date:</strong> <?= date('d M Y, h:i A', strtotime($application['created_at'])) ?></p>
      </div>
    </div>

    <h4 class="h5 font-weight-bold text-warning mt-4 mb-3">Uploaded Documents</h4>
    <?php if (empty($documents)): ?>
    <p class="text-muted">No documents uploaded.</p>
    <?php else: ?>
    <ul>
      <?php foreach ($documents as $doc): ?>
      <li><a href="<?= APP_URL ?>/assets/uploads/visa_docs/<?= $doc['file_path'] ?>" target="_blank" class="text-gold"><i class="fas fa-file-download me-1"></i> <?= htmlspecialchars($doc['original_name'], ENT_QUOTES, 'UTF-8') ?></a> (Uploaded: <?= date('d M Y', strtotime($doc['uploaded_at'])) ?>)</li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <h4 class="h5 font-weight-bold text-warning mt-4 mb-3">Update Status & Case Notes</h4>
    <form data-admin-ajax="true" action="<?= APP_URL ?>/admin/visas/<?= $application['id'] ?>/status" method="POST" style="max-width:500px;">
      <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
      <div class="mb-3">
        <label class="form-label text-muted small text-uppercase">Status</label>
        <select name="status" class="admin-form-control">
          <option value="Submitted" <?= $application['status'] === 'Submitted' ? 'selected' : '' ?>>Submitted</option>
          <option value="Under Review" <?= $application['status'] === 'Under Review' ? 'selected' : '' ?>>Under Review</option>
          <option value="Documents Required" <?= $application['status'] === 'Documents Required' ? 'selected' : '' ?>>Documents Required</option>
          <option value="Approved" <?= $application['status'] === 'Approved' ? 'selected' : '' ?>>Approved</option>
          <option value="Rejected" <?= $application['status'] === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label text-muted small text-uppercase">Case Manager Notes</label>
        <textarea name="admin_notes" class="admin-form-control" rows="3"><?= htmlspecialchars($application['admin_notes'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
      </div>
      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-save me-1"></i> Save Changes</button>
    </form>
  </div>
</div>
