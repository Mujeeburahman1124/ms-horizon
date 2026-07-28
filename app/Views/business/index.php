<div class="breadcrumb-section">
  <div class="container">
    <h1><i class="fas fa-building-columns text-warning me-2"></i> Business Consultancy</h1>
    <div class="breadcrumb-nav">
      <a href="<?= APP_URL ?>/">Home</a> <span>/</span>
      <span>Business Setup</span>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="row align-items-center g-5 mb-5">
      <div class="col-lg-6">
        <span class="section-eyebrow">UAE & Regional Business Setup</span>
        <h2 class="section-title">Start Your Business in <span class="highlight">Dubai & GCC</span></h2>
        <p class="section-subtitle">
          Turnkey business setup solutions for global entrepreneurs and investors. We handle Free Zone, 
          Mainland, and Offshore company formation, trade licence assistance, PRO services, establishment cards, 
          immigration, corporate bank account opening, VAT, accounting, document clearing, and co-working space leasing.
        </p>

        <div class="row g-3 mt-3">
          <div class="col-6">
            <div class="p-3 border rounded-3 bg-white shadow-sm">
              <i class="fas fa-city text-warning fa-2x mb-2"></i>
              <h4 class="h6 font-weight-bold">Mainland (DED)</h4>
              <p class="small text-muted mb-0">100% Foreign Ownership inside UAE local market.</p>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 border rounded-3 bg-white shadow-sm">
              <i class="fas fa-boxes-stacked text-warning fa-2x mb-2"></i>
              <h4 class="h6 font-weight-bold">Free Zone (IFZA/DMCC)</h4>
              <p class="small text-muted mb-0">0% corporate tax for qualifying entities & zero customs tariff.</p>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 border rounded-3 bg-white shadow-sm">
              <i class="fas fa-id-card text-warning fa-2x mb-2"></i>
              <h4 class="h6 font-weight-bold">PRO & Visas</h4>
              <p class="small text-muted mb-0">Establishment card, investor & employee visa stamping.</p>
            </div>
          </div>
          <div class="col-6">
            <div class="p-3 border rounded-3 bg-white shadow-sm">
              <i class="fas fa-landmark text-warning fa-2x mb-2"></i>
              <h4 class="h6 font-weight-bold">Bank & VAT Support</h4>
              <p class="small text-muted mb-0">Corporate bank account assistance & FTA VAT filing.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Business Setup Form -->
      <div class="col-lg-6">
        <div class="hero-card-float style-dark" style="background:var(--clr-navy-mid);border-color:var(--clr-gold);">
          <h3 style="color:var(--clr-gold);"><i class="fas fa-calculator"></i> Business Setup Consultation Form</h3>
          <form data-ajax="true" action="<?= APP_URL ?>/business/enquire" method="POST">
            <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">

            <div class="row g-2">
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="biz_name">Full Name</label>
                  <input type="text" id="biz_name" name="name" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="biz_phone">Mobile Number</label>
                  <input type="tel" id="biz_phone" name="phone" required>
                </div>
              </div>
            </div>

            <div class="row g-2">
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="biz_email">Email Address</label>
                  <input type="email" id="biz_email" name="email" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="biz_nationality">Nationality</label>
                  <input type="text" id="biz_nationality" name="nationality" placeholder="e.g. Indian, British" required>
                </div>
              </div>
            </div>

            <div class="row g-2">
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="biz_pref_country">Preferred Country / Jurisdiction</label>
                  <select id="biz_pref_country" name="setup_type" required>
                    <option value="Mainland">UAE Mainland (DED)</option>
                    <option value="Free Zone">UAE Free Zone (IFZA, DMCC, SHAMS)</option>
                    <option value="Offshore">UAE Offshore (RAK ICC)</option>
                    <option value="Qatar">Qatar Business Setup</option>
                    <option value="Saudi Arabia">Saudi Arabia SAGIA / MISA</option>
                    <option value="Oman">Oman Business Setup</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="biz_activity">Business Activity</label>
                  <input type="text" id="biz_activity" name="business_activity" placeholder="e.g. General Trading, IT Consulting" required>
                </div>
              </div>
            </div>

            <div class="row g-2">
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="biz_shareholders">Number of Shareholders</label>
                  <input type="number" id="biz_shareholders" name="shareholders_count" value="1" min="1" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="biz_visa_req">Visa Requirement</label>
                  <select id="biz_visa_req" name="visa_requirement">
                    <option value="0 Visas">Zero Visas (License Only)</option>
                    <option value="1 Visa">1 Investor Visa</option>
                    <option value="2-3 Visas">2 - 3 Investor/Employee Visas</option>
                    <option value="4+ Visas">4+ Visas</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row g-2">
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="biz_office">Office Requirement</label>
                  <select id="biz_office" name="office_requirement">
                    <option value="Flexi Desk">Virtual / Flexi Desk</option>
                    <option value="Physical Office">Physical Office Space</option>
                    <option value="Co-Working">Co-Working Space</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="biz_budget">Estimated Budget</label>
                  <select id="biz_budget" name="budget">
                    <option value="10k-15k">10,000 - 15,000 AED</option>
                    <option value="15k-25k">15,000 - 25,000 AED</option>
                    <option value="25k+">25,000+ AED</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="enquiry-form-group">
              <label for="biz_contact_method">Preferred Contact Method</label>
              <select id="biz_contact_method" name="contact_method">
                <option value="WhatsApp">WhatsApp Message</option>
                <option value="Phone Call">Direct Phone Call</option>
                <option value="Email">Email Proposal</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary w-100 justify-content-center mt-3">
              <i class="fas fa-headset me-2"></i> Submit Consultation Request
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
