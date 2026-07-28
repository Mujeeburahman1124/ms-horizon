<div class="breadcrumb-section">
  <div class="container">
    <h1><i class="fas fa-laptop-code text-warning me-2"></i> Software Development Division</h1>
    <div class="breadcrumb-nav">
      <a href="<?= APP_URL ?>/">Home</a> <span>/</span>
      <span>Software Development</span>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="row align-items-center g-5 mb-5">
      <div class="col-lg-6">
        <span class="section-eyebrow">Enterprise Software Solutions</span>
        <h2 class="section-title">Web Portals, Mobile Apps & <span class="highlight">Custom Software</span></h2>
        <p class="section-subtitle">
          We design, engineer, and deploy high-performance business websites, e-commerce stores, mobile apps, custom software, 
          CRM systems, HR management systems, booking engines, travel portals, recruitment portals, visa tracking systems, business automation, and API integrations.
        </p>

        <div class="d-flex flex-wrap gap-2 mb-4">
          <span class="badge bg-dark text-warning p-2"><i class="fab fa-php me-1"></i> PHP 8+ / MVC</span>
          <span class="badge bg-dark text-warning p-2"><i class="fas fa-database me-1"></i> MySQL 8 / PDO</span>
          <span class="badge bg-dark text-warning p-2"><i class="fab fa-js me-1"></i> ES6 JavaScript</span>
          <span class="badge bg-dark text-warning p-2"><i class="fab fa-bootstrap me-1"></i> Bootstrap 5</span>
          <span class="badge bg-dark text-warning p-2"><i class="fas fa-plug me-1"></i> API Integrations</span>
        </div>

        <a href="<?= APP_URL ?>/software/portfolio" class="btn btn-navy me-2"><i class="fas fa-cubes"></i> View Portfolio</a>
      </div>

      <!-- Detailed Software Project Enquiry Form -->
      <div class="col-lg-6">
        <div class="hero-card-float style-dark" style="background:var(--clr-navy-mid);border-color:var(--clr-gold);">
          <h3 style="color:var(--clr-gold);"><i class="fas fa-code-branch"></i> Project Enquiry Form</h3>
          <form data-ajax="true" action="<?= APP_URL ?>/software/enquire" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">

            <div class="row g-2">
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="sw_client_name">Client Name</label>
                  <input type="text" id="sw_client_name" name="client_name" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="sw_company_name">Company Name</label>
                  <input type="text" id="sw_company_name" name="company_name" required>
                </div>
              </div>
            </div>

            <div class="row g-2">
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="sw_email">Email Address</label>
                  <input type="email" id="sw_email" name="client_email" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="sw_phone">Phone Number</label>
                  <input type="tel" id="sw_phone" name="client_phone" required>
                </div>
              </div>
            </div>

            <div class="enquiry-form-group">
              <label for="sw_type">Project Type</label>
              <select id="sw_type" name="project_type" required>
                <option value="Business Website">Business Website Development</option>
                <option value="E-commerce Store">E-commerce Website Development</option>
                <option value="Mobile App">Mobile App Development (iOS/Android)</option>
                <option value="Custom Software">Custom Software Development</option>
                <option value="CRM System">CRM System</option>
                <option value="HR Management System">HR Management System</option>
                <option value="Booking System">Booking System</option>
                <option value="Travel Portal">Travel Portal (GDS Integrated)</option>
                <option value="Recruitment Portal">Recruitment Portal</option>
                <option value="Visa Tracking System">Visa Tracking System</option>
                <option value="Business Automation">Business Automation & API Integration</option>
              </select>
            </div>

            <div class="row g-2">
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="sw_budget">Estimated Budget</label>
                  <select id="sw_budget" name="budget_range">
                    <option value="$2,000 - $5,000">$2,000 - $5,000</option>
                    <option value="$5,000 - $10,000">$5,000 - $10,000</option>
                    <option value="$10,000+">$10,000+</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="sw_launch_date">Expected Launch Date</label>
                  <input type="date" id="sw_launch_date" name="timeline">
                </div>
              </div>
            </div>

            <div class="enquiry-form-group">
              <label for="sw_ref_site">Reference Website URL (Optional)</label>
              <input type="url" id="sw_ref_site" name="reference_website" placeholder="https://example.com">
            </div>

            <div class="enquiry-form-group">
              <label for="sw_desc">Project Description & Required Features</label>
              <textarea id="sw_desc" name="requirements" rows="3" placeholder="Detail main functions, user roles, integrations needed..." required></textarea>
            </div>

            <div class="enquiry-form-group">
              <label for="sw_file">File Upload (RFP, Wireframes, Brief PDF)</label>
              <input type="file" id="sw_file" name="attachment" accept=".pdf,.doc,.docx,.png,.jpg" class="form-control" style="background:rgba(255,255,255,.05);color:white;">
            </div>

            <button type="submit" class="btn btn-primary w-100 justify-content-center mt-2">
              <i class="fas fa-paper-plane"></i> Submit Project Proposal Request
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
