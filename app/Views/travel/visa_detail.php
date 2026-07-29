<div class="breadcrumb-section">
  <div class="container">
    <h1><?= e($visa['title'] ?? 'Visa Application') ?></h1>
    <div class="breadcrumb-nav">
      <a href="<?= APP_URL ?>/">Home</a> <span>/</span>
      <a href="<?= APP_URL ?>/travel">Travel</a> <span>/</span>
      <span><?= e($visa['country_name'] ?? 'Visa') ?></span>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="row g-5">
      <!-- Visa Specs -->
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="background:white;">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <span class="badge bg-warning text-dark px-3 py-2 fs-6 font-weight-bold"><?= e($visa['visa_type'] ?? 'Tourist') ?> Visa</span>
            <div class="h2 font-weight-bold mb-0" style="color:#B8860B;">AED <?= number_format((float)($visa['price'] ?? 350), 0) ?></div>
          </div>
          <h2 class="h4 font-weight-bold mb-3"><?= e($visa['title'] ?? 'Visa Package') ?></h2>
          
          <div class="row g-3 py-3 border-top border-bottom my-3">
            <div class="col-6 col-md-4">
              <small class="text-muted d-block text-uppercase">Country</small>
              <strong><?= e($visa['country_name'] ?? 'UAE') ?></strong>
            </div>
            <div class="col-6 col-md-4">
              <small class="text-muted d-block text-uppercase">Processing Time</small>
              <strong><?= e($visa['processing_time'] ?? '24-48 Hours') ?></strong>
            </div>
            <div class="col-6 col-md-4">
              <small class="text-muted d-block text-uppercase">Validity</small>
              <strong>30 - 60 Days</strong>
            </div>
          </div>

          <h3 class="h5 font-weight-bold mt-4 mb-3">Eligibility Requirements</h3>
          <p><?= nl2br(e($visa['eligibility'] ?? 'Open to all nationalities holding valid passport with 6 months validity.')) ?></p>

          <h3 class="h5 font-weight-bold mt-4 mb-3">Required Documents</h3>
          <ul class="list-group list-group-flush mb-4">
            <?php 
              $docs = is_array($required_docs ?? null) ? $required_docs : json_decode((string)($visa['required_docs_json'] ?? '[]'), true);
              if (empty($docs)) $docs = ['Passport First Page Copy', 'White Background Photo'];
              foreach ($docs as $doc): 
            ?>
            <li class="list-group-item bg-transparent px-0"><i class="fas fa-check-circle text-success me-2"></i> <?= e($doc) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <!-- Application Form -->
      <div class="col-lg-5">
        <div class="hero-card-float style-dark" style="background:var(--clr-navy-mid);border-color:var(--clr-gold);">
          <h3 style="color:var(--clr-gold);"><i class="fas fa-file-export"></i> Apply Now</h3>
          <form data-ajax="true" action="<?= APP_URL ?>/travel/apply" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
            <input type="hidden" name="visa_id" value="<?= (int)($visa['id'] ?? 1) ?>">

            <div class="enquiry-form-group">
              <label for="vd_name">Full Name (as in Passport)</label>
              <input type="text" id="vd_name" name="applicant_name" placeholder="John Doe" required>
            </div>
            <div class="enquiry-form-group">
              <label for="vd_passport">Passport Number</label>
              <input type="text" id="vd_passport" name="passport_number" placeholder="A1234567" required>
            </div>
            <div class="enquiry-form-group">
              <label for="vd_email">Email Address</label>
              <input type="email" id="vd_email" name="email" placeholder="john@example.com" required>
            </div>
            <div class="enquiry-form-group">
              <label for="vd_phone">Phone / WhatsApp</label>
              <input type="tel" id="vd_phone" name="phone" placeholder="+971 50 XXX XXXX" required>
            </div>
            <div class="enquiry-form-group">
              <label for="vd_file">Passport Copy (PDF or Image)</label>
              <input type="file" id="vd_file" name="passport_copy" accept=".pdf,.jpg,.jpeg,.png" required class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100 justify-content-center mt-3">
              <i class="fas fa-paper-plane"></i> Submit Application (AED <?= number_format((float)($visa['price'] ?? 350), 0) ?>)
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
