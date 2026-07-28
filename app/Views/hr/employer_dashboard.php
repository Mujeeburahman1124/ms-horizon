<div class="breadcrumb-section">
  <div class="container">
    <h1><i class="fas fa-building text-warning me-2"></i> Employer Portal</h1>
    <div class="breadcrumb-nav">
      <a href="<?= APP_URL ?>/">Home</a> <span>/</span>
      <span>Employer Dashboard</span>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="row g-4 mb-4">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4">
          <h2 class="h5 font-weight-bold mb-1"><?= htmlspecialchars($employer['company_name'] ?? 'Employer', ENT_QUOTES, 'UTF-8') ?></h2>
          <p class="text-muted small mb-3">Industry: <?= htmlspecialchars($employer['industry'] ?? 'N/A', ENT_QUOTES, 'UTF-8') ?></p>
          <div class="badge bg-success mb-3">Trade License: <?= htmlspecialchars($employer['trade_license'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
          <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#postJobModal">
            <i class="fas fa-plus-circle me-2"></i> Post New Job
          </button>
        </div>
      </div>

      <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
          <h3 class="h5 font-weight-bold mb-4"><i class="fas fa-briefcase text-warning me-2"></i> Posted Vacancies</h3>

          <?php if (empty($jobs)): ?>
          <div class="text-center py-5">
            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
            <p class="text-muted">No jobs posted yet. Click 'Post New Job' to start receiving candidates.</p>
          </div>
          <?php else: ?>
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>Job Title</th>
                  <th>Location</th>
                  <th>Applications</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($jobs as $j): ?>
                <tr>
                  <td><strong><?= htmlspecialchars($j['title'], ENT_QUOTES, 'UTF-8') ?></strong></td>
                  <td><?= htmlspecialchars($j['location'], ENT_QUOTES, 'UTF-8') ?></td>
                  <td><span class="badge bg-primary rounded-pill"><?= $j['applications'] ?> Applicants</span></td>
                  <td><span class="badge bg-success">Active</span></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Post Job Modal -->
<div class="modal fade" id="postJobModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-4 border-0">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="fas fa-plus-circle text-warning me-2"></i> Post New Job Vacancy</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form data-ajax="true" action="<?= APP_URL ?>/employer/post-job" method="POST">
        <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
        <div class="modal-body p-4">
          <div class="row g-3">
            <div class="col-md-8">
              <label class="form-label font-weight-bold">Job Title</label>
              <input type="text" name="title" class="form-control" placeholder="e.g. Senior Accountant" required>
            </div>
            <div class="col-md-4">
              <label class="form-label font-weight-bold">Job Type</label>
              <select name="job_type" class="form-select" required>
                <option value="Full-time">Full-time</option>
                <option value="Part-time">Part-time</option>
                <option value="Contract">Contract</option>
                <option value="Remote">Remote</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label font-weight-bold">Category</label>
              <input type="text" name="category" class="form-control" placeholder="Accounting & Finance" required>
            </div>
            <div class="col-md-6">
              <label class="form-label font-weight-bold">Location</label>
              <input type="text" name="location" class="form-control" placeholder="Dubai, UAE" required>
            </div>
            <div class="col-md-6">
              <label class="form-label font-weight-bold">Salary Range</label>
              <input type="text" name="salary_range" class="form-control" placeholder="AED 8,000 - 12,000" required>
            </div>
            <div class="col-md-6">
              <label class="form-label font-weight-bold">Experience Level</label>
              <input type="text" name="experience_level" class="form-control" placeholder="3-5 Years" required>
            </div>
            <div class="col-12">
              <label class="form-label font-weight-bold">Job Description</label>
              <textarea name="description" rows="4" class="form-control" required></textarea>
            </div>
            <div class="col-12">
              <label class="form-label font-weight-bold">Requirements & Skills</label>
              <textarea name="requirements" rows="4" class="form-control" required></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Publish Vacancy</button>
        </div>
      </form>
    </div>
  </div>
</div>
