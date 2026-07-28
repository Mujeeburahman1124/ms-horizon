<div class="admin-card">
  <div class="admin-card-header">
    <h3 class="admin-card-title"><i class="fas fa-user-tie text-warning me-2"></i> Candidate #<?= $candidate['id'] ?> Profile</h3>
    <a href="<?= APP_URL ?>/admin/candidates" class="admin-btn admin-btn-ghost admin-btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
  </div>
  <div class="p-4">
    <div class="row g-4">
      <div class="col-md-6">
        <p><strong>Full Name:</strong> <?= htmlspecialchars($candidate['full_name'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Email Address:</strong> <?= htmlspecialchars($candidate['email'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Phone Number:</strong> <?= htmlspecialchars($candidate['phone'], ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Nationality:</strong> <?= htmlspecialchars($candidate['nationality'], ENT_QUOTES, 'UTF-8') ?></p>
      </div>
      <div class="col-md-6">
        <p><strong>Experience:</strong> <?= $candidate['experience_years'] ?> Years</p>
        <p><strong>Current Title:</strong> <?= htmlspecialchars($candidate['current_title'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></p>
        <p><strong>Contact Unlocked:</strong> <?= $candidate['is_contact_unlocked'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No (Masked for employers)</span>' ?></p>
        <p><strong>CV File:</strong> <a href="<?= APP_URL ?>/assets/uploads/cvs/<?= $candidate['cv_path'] ?>" target="_blank" class="text-gold"><i class="fas fa-file-download me-1"></i> Download CV</a></p>
      </div>
    </div>

    <?php if (!$candidate['is_contact_unlocked'] && $show_contact): ?>
    <form data-admin-ajax="true" action="<?= APP_URL ?>/admin/candidates/<?= $candidate['id'] ?>/unlock" method="POST" class="mt-3">
      <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
      <button type="submit" class="admin-btn admin-btn-primary"><i class="fas fa-lock-open me-1"></i> Unlock Candidate Contact Details</button>
    </form>
    <?php endif; ?>
  </div>
</div>
