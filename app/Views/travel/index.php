<!-- ─── BREADCRUMB ─────────────────────────────────────────────── -->
<div class="breadcrumb-section">
  <div class="container">
    <h1><i class="fas fa-passport text-warning me-2"></i> Travel & Tourism</h1>
    <div class="breadcrumb-nav">
      <a href="<?= APP_URL ?>/">Home</a> <span>/</span>
      <span>Travel & Tourism</span>
    </div>
  </div>
</div>

<!-- ─── INTRO & VISA SEARCH ────────────────────────────────────── -->
<section class="section">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span class="section-eyebrow">Worldwide Visa Services</span>
        <h2 class="section-title">Fast, Transparent & Reliable <span class="highlight">Visa Assistance</span></h2>
        <p class="section-subtitle mb-4">
          Whether you need a 30-day UAE tourist visa, Schengen appointment, UK visit visa, or USA B1/B2 assistance, 
          MS Horizon Travel & Tourism handles your documentation, appointments, and submission with precision.
        </p>
        
        <div class="d-flex flex-column gap-3 mb-4">
          <div class="d-flex align-items-center gap-3">
            <div style="width:40px;height:40px;border-radius:50%;background:rgba(212,175,55,.15);display:flex;align-items:center;justify-content:center;color:var(--clr-gold);"><i class="fas fa-bolt"></i></div>
            <div><strong>Express Processing:</strong> UAE Visas issued in 24-48 hours.</div>
          </div>
          <div class="d-flex align-items-center gap-3">
            <div style="width:40px;height:40px;border-radius:50%;background:rgba(0,184,148,.15);display:flex;align-items:center;justify-content:center;color:var(--clr-emerald);"><i class="fas fa-file-check"></i></div>
            <div><strong>98% Approval Rate:</strong> Thorough document verification before filing.</div>
          </div>
          <div class="d-flex align-items-center gap-3">
            <div style="width:40px;height:40px;border-radius:50%;background:rgba(41,128,185,.15);display:flex;align-items:center;justify-content:center;color:var(--clr-blue-acc);"><i class="fas fa-lock"></i></div>
            <div><strong>Secure Uploads:</strong> Passport & document protection guarantee.</div>
          </div>
        </div>

        <a href="<?= APP_URL ?>/travel/track" class="btn btn-navy">
          <i class="fas fa-search-location"></i> Track Existing Application
        </a>
      </div>

      <!-- Quick Visa Application Box -->
      <div class="col-lg-6">
        <div class="hero-card-float" style="background:var(--clr-navy-mid);border-color:rgba(212,175,55,.3);">
          <h3 style="color:var(--clr-gold);"><i class="fas fa-paper-plane"></i> Apply for a Visa</h3>
          <form data-ajax="true" action="<?= APP_URL ?>/travel/apply" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
            
            <div class="enquiry-form-group">
              <label for="app_visa">Select Visa Package</label>
              <select id="app_visa" name="visa_id" required>
                <option value="" disabled selected>Choose a visa...</option>
                <?php foreach (($featured_visas ?? []) as $v): ?>
                <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['country_name'] . ' — ' . $v['title'] . ' (AED ' . number_format($v['price'], 0) . ')', ENT_QUOTES, 'UTF-8') ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="row g-2">
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="app_name">Full Name (as in Passport)</label>
                  <input type="text" id="app_name" name="applicant_name" placeholder="John Doe" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="app_passport">Passport Number</label>
                  <input type="text" id="app_passport" name="passport_number" placeholder="A1234567" required>
                </div>
              </div>
            </div>

            <div class="row g-2">
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="app_email">Email Address</label>
                  <input type="email" id="app_email" name="email" placeholder="john@example.com" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="enquiry-form-group">
                  <label for="app_phone">Mobile / WhatsApp</label>
                  <input type="tel" id="app_phone" name="phone" placeholder="+971 50 XXX XXXX" required>
                </div>
              </div>
            </div>

            <div class="enquiry-form-group">
              <label for="app_passport_copy">Upload Passport Copy (JPG, PNG, PDF)</label>
              <input type="file" id="app_passport_copy" name="passport_copy" accept=".jpg,.jpeg,.png,.pdf" class="form-control" style="background:rgba(255,255,255,.05);color:white;" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 justify-content-center mt-2">
              <i class="fas fa-paper-plane"></i> Submit Visa Application
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ─── FEATURED VISAS ─────────────────────────────────────────── -->
<section class="section style-smoke" style="background:var(--clr-smoke,#F1F5F9);">
  <div class="container">
    <div class="section-header">
      <span class="section-eyebrow">Popular Packages</span>
      <h2 class="section-title">Featured <span class="highlight">Visa Packages</span></h2>
    </div>

    <div class="row g-4">
      <?php foreach (($featured_visas ?? []) as $visa): ?>
      <div class="col-md-6 col-lg-3">
        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
          <div class="p-4" style="background:var(--clr-navy);color:white;">
            <span class="badge bg-warning text-dark mb-2"><?= htmlspecialchars($visa['visa_type'], ENT_QUOTES, 'UTF-8') ?></span>
            <h4 class="h5 font-weight-bold mb-1"><?= htmlspecialchars($visa['title'], ENT_QUOTES, 'UTF-8') ?></h4>
            <div class="text-muted small"><?= htmlspecialchars($visa['country_name'], ENT_QUOTES, 'UTF-8') ?></div>
          </div>
          <div class="card-body p-4">
            <div class="h3 font-weight-bold text-warning mb-3">
              AED <?= number_format($visa['price'], 0) ?>
            </div>
            <ul class="list-unstyled small text-muted mb-4">
              <li class="mb-2"><i class="fas fa-clock text-primary me-2"></i> Processing: <strong><?= htmlspecialchars($visa['processing_time'], ENT_QUOTES, 'UTF-8') ?></strong></li>
              <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Document Verification Included</li>
              <li class="mb-2"><i class="fas fa-headset text-info me-2"></i> Dedicated Case Manager</li>
            </ul>
            <a href="<?= APP_URL ?>/travel/visa/<?= $visa['slug'] ?>" class="btn btn-outline-primary btn-sm w-100 rounded-pill">
              View Details & Apply
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
