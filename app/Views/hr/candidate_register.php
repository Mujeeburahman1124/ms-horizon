<div class="breadcrumb-section">
  <div class="container">
    <h1><i class="fas fa-user-plus text-warning me-2"></i> Candidate Registration</h1>
    <div class="breadcrumb-nav">
      <a href="<?= APP_URL ?>/">Home</a> <span>/</span>
      <a href="<?= APP_URL ?>/careers">Careers</a> <span>/</span>
      <span>Candidate Register</span>
    </div>
  </div>
</div>

<section class="section">
  <div class="container" style="max-width:750px;">
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
      <h2 class="h4 font-weight-bold mb-2">Create Your Candidate Profile</h2>
      <p class="text-muted mb-4">Register your details and upload your CV to apply for jobs and get headhunted by top GCC employers.</p>

      <form data-ajax="true" action="<?= APP_URL ?>/candidate/register" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">

        <div class="row g-3">
          <div class="col-md-6">
            <div class="form-group">
              <label>Full Name</label>
              <input type="text" name="name" class="form-control" placeholder="John Doe" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Email Address</label>
              <input type="email" name="email" class="form-control" placeholder="john@example.com" required>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label>Password</label>
              <input type="password" name="password" class="form-control" placeholder="Minimum 8 characters" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Mobile / WhatsApp</label>
              <input type="tel" name="phone" class="form-control" placeholder="+971 50 XXX XXXX" required>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label>Nationality</label>
              <input type="text" name="nationality" class="form-control" placeholder="e.g. Indian, British, Egyptian" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Years of Experience</label>
              <input type="number" name="experience_years" class="form-control" placeholder="e.g. 5" min="0" required>
            </div>
          </div>

          <div class="col-12">
            <div class="form-group">
              <label>Current / Most Recent Job Title</label>
              <input type="text" name="current_title" class="form-control" placeholder="e.g. Senior Accountant, Sales Executive">
            </div>
          </div>

          <div class="col-12">
            <div class="form-group">
              <label>Upload CV / Resume (PDF, DOCX)</label>
              <input type="file" name="cv" accept=".pdf,.doc,.docx" class="form-control" required>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100 justify-content-center mt-4">
          <i class="fas fa-check-circle me-2"></i> Register & Create Profile
        </button>

        <div class="text-center mt-3 small text-muted">
          Already have an account? <a href="<?= APP_URL ?>/login" class="text-warning font-weight-bold">Sign In here</a>
        </div>
      </form>
    </div>
  </div>
</section>
