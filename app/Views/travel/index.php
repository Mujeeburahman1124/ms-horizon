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
            <div style="width:42px;height:42px;border-radius:50%;background:rgba(212,175,55,.15);display:flex;align-items:center;justify-content:center;color:var(--clr-gold);font-size:1.1rem;"><i class="fas fa-bolt"></i></div>
            <div><strong>Express Processing:</strong> UAE Visas issued in 24 - 48 hours.</div>
          </div>
          <div class="d-flex align-items-center gap-3">
            <div style="width:42px;height:42px;border-radius:50%;background:rgba(0,184,148,.15);display:flex;align-items:center;justify-content:center;color:var(--clr-emerald);font-size:1.1rem;"><i class="fas fa-file-check"></i></div>
            <div><strong>98% Approval Rate:</strong> Thorough document verification before filing.</div>
          </div>
          <div class="d-flex align-items-center gap-3">
            <div style="width:42px;height:42px;border-radius:50%;background:rgba(41,128,185,.15);display:flex;align-items:center;justify-content:center;color:var(--clr-blue-acc);font-size:1.1rem;"><i class="fas fa-lock"></i></div>
            <div><strong>Secure Uploads:</strong> Passport & document privacy guarantee.</div>
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
                <option value="<?= (int)($v['id'] ?? 1) ?>"><?= htmlspecialchars((string)($v['country_name'] ?? 'UAE') . ' — ' . (string)($v['title'] ?? 'Visa') . ' (AED ' . number_format((float)($v['price'] ?? 350), 0) . ')', ENT_QUOTES, 'UTF-8') ?></option>
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
    <div class="section-header text-center mb-5">
      <span class="section-eyebrow">Popular Packages</span>
      <h2 class="section-title">Featured <span class="highlight">Visa Packages</span></h2>
      <p class="section-subtitle">Select a visa package to review eligibility criteria, processing times, and submit your application online.</p>
    </div>

    <div class="row g-4 justify-content-center">
      <?php foreach (($featured_visas ?? []) as $visa): 
        $vType = !empty($visa['visa_type']) ? (string)$visa['visa_type'] : 'Tourist';
        $vTitle = !empty($visa['title']) ? (string)$visa['title'] : 'Visa Package';
        $vCountry = !empty($visa['country_name']) ? (string)$visa['country_name'] : 'UAE';
        $vTime = !empty($visa['processing_time']) ? (string)$visa['processing_time'] : '24-48 Hours';
        $vPrice = (float)($visa['price'] ?? 350);
        $vSlug = !empty($visa['slug']) ? (string)$visa['slug'] : 'uae-30-day-tourist-visa';
      ?>
      <div class="col-sm-6 col-lg-4 col-xl-3">
        <div class="card h-100 border-0 shadow-md rounded-4 overflow-hidden" style="background:white;transition:transform .25s ease, box-shadow .25s ease;">
          <div class="p-4" style="background:linear-gradient(135deg, #0A1628 0%, #1A3558 100%);color:white;">
            <span class="badge bg-warning text-dark font-weight-bold mb-2 px-2.5 py-1" style="font-size:.75rem;border-radius:6px;"><?= htmlspecialchars($vType, ENT_QUOTES, 'UTF-8') ?></span>
            <h4 class="h5 font-weight-bold mb-1 text-white" style="line-height:1.3;"><?= htmlspecialchars($vTitle, ENT_QUOTES, 'UTF-8') ?></h4>
            <div style="color:rgba(255,255,255,.65);font-size:.82rem;"><?= htmlspecialchars($vCountry, ENT_QUOTES, 'UTF-8') ?></div>
          </div>
          <div class="card-body p-4 d-flex flex-column justify-content-between">
            <div>
              <div class="h3 font-weight-bold mb-3" style="color:#B8860B;">
                AED <?= number_format($vPrice, 0) ?>
              </div>
              <ul class="list-unstyled small text-muted mb-4" style="line-height:1.8;">
                <li class="mb-2"><i class="fas fa-clock text-primary me-2"></i> Processing: <strong><?= htmlspecialchars($vTime, ENT_QUOTES, 'UTF-8') ?></strong></li>
                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Document Verification Included</li>
                <li class="mb-2"><i class="fas fa-headset text-info me-2"></i> Dedicated Case Manager</li>
              </ul>
            </div>
            <a href="<?= APP_URL ?>/travel/visa/<?= urlencode($vSlug) ?>" class="btn btn-outline-primary btn-sm w-100 rounded-pill justify-content-center font-weight-bold">
              View Details & Apply
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
