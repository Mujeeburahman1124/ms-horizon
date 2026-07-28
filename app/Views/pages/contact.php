<div class="breadcrumb-section">
  <div class="container">
    <h1>Contact MS Horizon Group</h1>
    <div class="breadcrumb-nav">
      <a href="<?= APP_URL ?>/">Home</a> <span>/</span>
      <span>Contact Us</span>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <!-- Contact Info -->
      <div class="col-lg-5">
        <span class="section-eyebrow">Get in Touch</span>
        <h2 class="section-title mb-4">We are Here to <span class="highlight">Assist You</span></h2>
        
        <div class="d-flex flex-column gap-4 mb-4">
          <div class="d-flex gap-3 align-items-start">
            <div style="width:48px;height:48px;border-radius:12px;background:var(--grad-gold);display:flex;align-items:center;justify-content:center;color:var(--clr-navy);font-size:1.2rem;flex-shrink:0;">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div>
              <h4 class="h6 font-weight-bold mb-1">Dubai Headquarters Office Address</h4>
              <p class="small text-muted mb-0">Level 28, Horizon Tower, Business Bay, Dubai, United Arab Emirates</p>
            </div>
          </div>

          <div class="d-flex gap-3 align-items-start">
            <div style="width:48px;height:48px;border-radius:12px;background:var(--grad-gold);display:flex;align-items:center;justify-content:center;color:var(--clr-navy);font-size:1.2rem;flex-shrink:0;">
              <i class="fas fa-phone"></i>
            </div>
            <div>
              <h4 class="h6 font-weight-bold mb-1">Phone & WhatsApp Numbers</h4>
              <p class="small text-muted mb-0">Direct Phone: +971 4 123 4567<br>WhatsApp: +971 50 123 4567</p>
            </div>
          </div>

          <div class="d-flex gap-3 align-items-start">
            <div style="width:48px;height:48px;border-radius:12px;background:var(--grad-gold);display:flex;align-items:center;justify-content:center;color:var(--clr-navy);font-size:1.2rem;flex-shrink:0;">
              <i class="fas fa-envelope"></i>
            </div>
            <div>
              <h4 class="h6 font-weight-bold mb-1">Email Addresses</h4>
              <p class="small text-muted mb-0">General: info@mshorizontravel.com<br>Support: support@mshorizontravel.com</p>
            </div>
          </div>

          <div class="d-flex gap-3 align-items-start">
            <div style="width:48px;height:48px;border-radius:12px;background:var(--grad-gold);display:flex;align-items:center;justify-content:center;color:var(--clr-navy);font-size:1.2rem;flex-shrink:0;">
              <i class="fas fa-clock"></i>
            </div>
            <div>
              <h4 class="h6 font-weight-bold mb-1">Working Hours</h4>
              <p class="small text-muted mb-0">Monday – Saturday: 9:00 AM – 7:00 PM (GST)<br>Sunday: Closed (24/7 WhatsApp Emergency Assistance)</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5" style="background:var(--bg-card,#fff);">
          <h3 class="h4 font-weight-bold mb-3">General Enquiry Form</h3>
          <form data-ajax="true" action="<?= APP_URL ?>/contact" method="POST">
            <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">

            <div class="row g-3">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Your Full Name</label>
                  <input type="text" name="name" class="form-control" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Email Address</label>
                  <input type="email" name="email" class="form-control" required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Phone / WhatsApp Number</label>
                  <input type="tel" name="phone" class="form-control" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Department Selection</label>
                  <select name="department" class="form-control" required>
                    <option value="Reservations">✈ Reservations</option>
                    <option value="Travel and Visa">🌍 Travel and Visa</option>
                    <option value="Human Resources">👥 Human Resources</option>
                    <option value="Business Consultancy">🏢 Business Consultancy</option>
                    <option value="Software Development">💻 Software Development</option>
                    <option value="Accounts">💳 Accounts</option>
                    <option value="Customer Support">🎧 Customer Support</option>
                  </select>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <label>Subject</label>
                  <input type="text" name="subject" class="form-control" required>
                </div>
              </div>

              <div class="col-12">
                <div class="form-group">
                  <label>Your Message</label>
                  <textarea name="message" rows="5" class="form-control" required></textarea>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100 justify-content-center mt-3">
              <i class="fas fa-paper-plane me-2"></i> Send General Enquiry
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
