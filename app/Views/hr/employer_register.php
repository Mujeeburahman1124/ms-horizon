<div class="breadcrumb-section">
  <div class="container">
    <h1><i class="fas fa-building text-warning me-2"></i> Employer Registration</h1>
    <div class="breadcrumb-nav">
      <a href="<?= APP_URL ?>/">Home</a> <span>/</span>
      <a href="<?= APP_URL ?>/careers">Careers</a> <span>/</span>
      <span>Employer Portal</span>
    </div>
  </div>
</div>

<section class="section">
  <div class="container" style="max-width:750px;">
    <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
      <h2 class="h4 font-weight-bold mb-2">Hire Qualified Talent in GCC</h2>
      <p class="text-muted mb-4">Register your organization to post job vacancies, screen vetted candidates, and request interviews.</p>

      <form data-ajax="true" action="<?= APP_URL ?>/employer/register" method="POST">
        <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">

        <div class="row g-3">
          <div class="col-md-6">
            <div class="form-group">
              <label>Company Name</label>
              <input type="text" name="company_name" class="form-control" placeholder="Horizon Technologies LLC" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Trade License Number</label>
              <input type="text" name="trade_license" class="form-control" placeholder="DED-123456" required>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label>Contact Person</label>
              <input type="text" name="contact_person" class="form-control" placeholder="Jane Smith" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Industry</label>
              <input type="text" name="industry" class="form-control" placeholder="e.g. IT, Travel, Healthcare" required>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label>Corporate Email</label>
              <input type="email" name="email" class="form-control" placeholder="hr@company.com" required>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Phone / WhatsApp</label>
              <input type="tel" name="phone" class="form-control" placeholder="+971 4 XXX XXXX" required>
            </div>
          </div>

          <div class="col-12">
            <div class="form-group">
              <label>Account Password</label>
              <input type="password" name="password" class="form-control" placeholder="Minimum 8 characters" required>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100 justify-content-center mt-4">
          <i class="fas fa-check-circle me-2"></i> Register Corporate Account
        </button>
      </form>
    </div>
  </div>
</section>
