<!-- ─── HERO SECTION ───────────────────────────────────────────── -->
<section class="hero-section" aria-label="MS Horizon Group Homepage Hero">
  <div class="hero-bg-animation"></div>
  <div class="hero-grid-overlay"></div>

  <div class="hero-content">
    <!-- Hero Left -->
    <div class="hero-left" data-aos="fade-right">
      <div class="hero-badge">
        <i class="fas fa-star"></i>
        MS Horizon — Your Global Partner for Travel, Talent, Business & Technology
      </div>

      <h1 class="hero-heading">
        One Group.<br>
        <span class="highlight">Multiple Solutions.</span>
      </h1>

      <p class="hero-subheading">
        Travel, reservations, recruitment, business consultancy and software development services under one trusted group.
      </p>

      <div class="hero-actions">
        <a href="<?= APP_URL ?>/services" class="btn btn-primary btn-lg">
          <i class="fas fa-th-large"></i> Explore Our Services
        </a>
        <a href="<?= APP_URL ?>/contact" class="btn btn-outline btn-lg">
          <i class="fas fa-headset"></i> Get a Free Consultation
        </a>
        <a href="https://wa.me/<?= SITE_WHATSAPP ?>" target="_blank" class="btn btn-emerald btn-lg">
          <i class="fab fa-whatsapp"></i> Contact on WhatsApp
        </a>
      </div>

      <div class="hero-stats">
        <div class="hero-stat-item">
          <span class="hero-stat-number" data-counter data-target="1800" data-suffix="+">1800+</span>
          <span class="hero-stat-label">Satisfied Clients</span>
        </div>
        <div class="hero-stat-item">
          <span class="hero-stat-number" data-counter data-target="5000" data-suffix="+">5000+</span>
          <span class="hero-stat-label">Visas Processed</span>
        </div>
        <div class="hero-stat-item">
          <span class="hero-stat-number" data-counter data-target="400" data-suffix="+">400+</span>
          <span class="hero-stat-label">Businesses Formed</span>
        </div>
        <div class="hero-stat-item">
          <span class="hero-stat-number" data-counter data-target="120" data-suffix="+">120+</span>
          <span class="hero-stat-label">Software Projects</span>
        </div>
      </div>
    </div><!-- /.hero-left -->

    <!-- Hero Right — Quick Enquiry Panel -->
    <div class="hero-right" data-aos="fade-left">
      <div class="hero-card-float">
        <h3><i class="fas fa-paper-plane"></i> Quick Enquiry Form</h3>
        <p style="color:rgba(255,255,255,.5);font-size:.8rem;margin-bottom:1.25rem;">
          Get a callback from our experts within 2 hours.
        </p>
        <form id="heroEnquiryForm" data-ajax="true" action="<?= APP_URL ?>/quick-enquiry" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
          
          <div class="enquiry-form-group">
            <label for="hero_name">Full Name</label>
            <input type="text" id="hero_name" name="name" placeholder="Your full name" required autocomplete="name">
          </div>
          <div class="row g-2">
            <div class="col-6">
              <div class="enquiry-form-group">
                <label for="hero_phone">Mobile Number</label>
                <input type="tel" id="hero_phone" name="phone" placeholder="+971 4 XXX XXXX" required autocomplete="tel">
              </div>
            </div>
            <div class="col-6">
              <div class="enquiry-form-group">
                <label for="hero_wa">WhatsApp Number</label>
                <input type="tel" id="hero_wa" name="whatsapp" placeholder="+971 50 XXX XXXX" required>
              </div>
            </div>
          </div>
          <div class="enquiry-form-group">
            <label for="hero_email">Email Address</label>
            <input type="email" id="hero_email" name="email" placeholder="your@email.com" required autocomplete="email">
          </div>
          <div class="row g-2">
            <div class="col-6">
              <div class="enquiry-form-group">
                <label for="hero_country">Country</label>
                <select id="hero_country" name="country" required>
                  <option value="UAE">UAE</option>
                  <option value="Qatar">Qatar</option>
                  <option value="Oman">Oman</option>
                  <option value="Saudi Arabia">Saudi Arabia</option>
                  <option value="Bahrain">Bahrain</option>
                  <option value="Sri Lanka">Sri Lanka</option>
                  <option value="India">India</option>
                  <option value="Europe">Europe</option>
                  <option value="USA">USA</option>
                  <option value="Canada">Canada</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="enquiry-form-group">
                <label for="hero_service">Required Service</label>
                <select id="hero_service" name="service" required>
                  <option value="Reservations Services">✈ Reservations Services</option>
                  <option value="Travel and Tourism">🌍 Travel and Tourism</option>
                  <option value="Human Resource Consultancy">👥 HR Consultancy</option>
                  <option value="Business Consultancy">🏢 Business Consultancy</option>
                  <option value="Software Development">💻 Software Development</option>
                </select>
              </div>
            </div>
          </div>
          <div class="enquiry-form-group">
            <label for="hero_msg">Brief Message</label>
            <textarea id="hero_msg" name="message" rows="2" placeholder="Tell us what you need..." required></textarea>
          </div>
          <div class="enquiry-form-group">
            <label for="hero_doc">Document Upload (Optional)</label>
            <input type="file" id="hero_doc" name="document" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="form-control" style="background:rgba(255,255,255,.05);color:white;">
          </div>
          <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
            <i class="fas fa-paper-plane"></i> Submit Enquiry
          </button>
        </form>
      </div>
    </div><!-- /.hero-right -->
  </div><!-- /.hero-content -->
</section>

<!-- ─── 5 DIVISIONS SECTION ───────────────────────────────────── -->
<section class="section" style="background:var(--bg-body);" aria-labelledby="divisions-heading">
  <div class="container">
    <div class="section-header animate-on-scroll">
      <span class="section-eyebrow">Group Services</span>
      <h2 class="section-title" id="divisions-heading">
        Five Main Service <span class="highlight">Divisions</span>
      </h2>
      <p class="section-subtitle">
        Providing integrated solutions under one trusted corporate group.
      </p>
    </div>

    <div class="division-grid">
      <?php
      $divisions_data = [
        ['icon'=>'fa-plane-departure','title'=>'Reservations Services','desc'=>'Airline ticket reservations, hotel bookings, airport transfers, tour bookings, travel insurance, appointment & event bookings, corporate travel.','url'=>'/reservations','color'=>'#D4AF37'],
        ['icon'=>'fa-passport','title'=>'Travel and Tourism','desc'=>'Worldwide visit visas, tourist visas, flight tickets, holiday packages, hotel bookings, visa documentation, travel insurance & airport transfers.','url'=>'/travel','color'=>'#00B894'],
        ['icon'=>'fa-users-gear','title'=>'Human Resource Consultancy','desc'=>'Recruitment services, candidate sourcing, overseas recruitment support, CV & interview prep, employee outsourcing & workforce solutions.','url'=>'/careers','color'=>'#2980B9'],
        ['icon'=>'fa-building-columns','title'=>'Business Consultancy','desc'=>'UAE business setup, Free Zone, Mainland & Offshore company formation, trade licence, PRO, immigration, corporate bank account & accounting.','url'=>'/business','color'=>'#9B59B6'],
        ['icon'=>'fa-laptop-code','title'=>'Software Development','desc'=>'Business & E-commerce website development, mobile app development, custom software, CRM, HR, booking systems, travel & visa portals.','url'=>'/software','color'=>'#E74C3C'],
      ];
      foreach($divisions_data as $i => $div): ?>
      <div class="division-card animate-on-scroll" style="transition-delay:<?= $i*80 ?>ms;" onclick="window.location='<?= APP_URL . $div['url'] ?>'">
        <div class="division-card-icon" style="background:rgba(<?= implode(',', sscanf(ltrim($div['color'],'#'),'%02x%02x%02x')) ?>,.1);color:<?= $div['color'] ?>;border-color:rgba(<?= implode(',', sscanf(ltrim($div['color'],'#'),'%02x%02x%02x')) ?>,.2);">
          <i class="fas <?= $div['icon'] ?>"></i>
        </div>
        <h3><?= $div['title'] ?></h3>
        <p><?= $div['desc'] ?></p>
        <div class="division-card-link" style="color:<?= $div['color'] ?>;">
          Learn More <i class="fas fa-arrow-right fa-sm"></i>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ─── WHY CHOOSE MS HORIZON ──────────────────────────────────── -->
<section class="section" aria-labelledby="why-heading">
  <div class="container">
    <div class="section-header animate-on-scroll">
      <span class="section-eyebrow">Why Choose Us</span>
      <h2 class="section-title" id="why-heading">
        Why Choose <span class="highlight">MS Horizon</span>
      </h2>
    </div>

    <div class="why-grid">
      <?php
      $whyPoints = [
        ['icon'=>'fa-layer-group','title'=>'Multiple Services Under One Group','desc'=>'All your travel, HR, business, and software needs solved by one trusted organisation.'],
        ['icon'=>'fa-users','title'=>'Professional Support Team','desc'=>'Certified consultants, travel specialists, recruiters, and senior software engineers.'],
        ['icon'=>'fa-eye','title'=>'Transparent Service Process','desc'=>'Clear pricing, zero hidden charges, real-time application tracking.'],
        ['icon'=>'fa-globe','title'=>'International Service Coverage','desc'=>'Seamless service execution across UAE, Qatar, Oman, Saudi Arabia, Bahrain, Sri Lanka, India, Europe, USA, Canada.'],
        ['icon'=>'fa-headset','title'=>'Fast Customer Assistance','desc'=>'24/7 dedicated support via WhatsApp, phone, email, and direct portal messaging.'],
        ['icon'=>'fa-chart-line','title'=>'Dedicated Business Solutions','desc'=>'Tailored corporate accounts, custom packages, and dedicated key account managers.'],
      ];
      foreach($whyPoints as $i => $pt): ?>
      <div class="why-card animate-on-scroll" style="transition-delay:<?= $i*60 ?>ms;">
        <div class="why-icon"><i class="fas <?= $pt['icon'] ?>"></i></div>
        <div class="why-info">
          <h4><?= $pt['title'] ?></h4>
          <p><?= $pt['desc'] ?></p>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ─── COUNTRY-WISE SERVICES ──────────────────────────────────── -->
<section class="section style-smoke" style="background:var(--clr-smoke,#F1F5F9);" aria-labelledby="countries-heading">
  <div class="container">
    <div class="section-header animate-on-scroll">
      <span class="section-eyebrow">Global Reach</span>
      <h2 class="section-title" id="countries-heading">
        Country-Wise <span class="highlight">Services</span>
      </h2>
      <p class="section-subtitle">Select a country to view available visa, travel, recruitment, business setup, and software solutions.</p>
    </div>

    <div class="country-grid">
      <?php
      $countryList = [
        ['name'=>'UAE','code'=>'AE','flag'=>'🇦🇪'],
        ['name'=>'Qatar','code'=>'QA','flag'=>'🇶🇦'],
        ['name'=>'Oman','code'=>'OM','flag'=>'🇴🇲'],
        ['name'=>'Saudi Arabia','code'=>'SA','flag'=>'🇸🇦'],
        ['name'=>'Bahrain','code'=>'BH','flag'=>'🇧🇭'],
        ['name'=>'Sri Lanka','code'=>'LK','flag'=>'🇱🇰'],
        ['name'=>'India','code'=>'IN','flag'=>'🇮🇳'],
        ['name'=>'Europe','code'=>'EU','flag'=>'🇪🇺'],
        ['name'=>'USA','code'=>'US','flag'=>'🇺🇸'],
        ['name'=>'Canada','code'=>'CA','flag'=>'🇨🇦'],
      ];
      foreach ($countryList as $c): ?>
      <a href="<?= APP_URL ?>/travel/countries" class="country-card text-decoration-none">
        <div class="country-flag"><?= $c['flag'] ?></div>
        <div class="country-name"><?= $c['name'] ?></div>
        <div class="country-visa-count"><i class="fas fa-check-circle fa-xs text-success"></i> Services Available</div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ─── FEATURED OFFERS SECTION ─────────────────────────────────── -->
<?php if (!empty($offers)): ?>
<section class="section" aria-labelledby="offers-heading">
  <div class="container">
    <div class="section-header animate-on-scroll">
      <span class="section-eyebrow">Exclusive Promotions</span>
      <h2 class="section-title" id="offers-heading">
        Featured <span class="highlight">Offers & Packages</span>
      </h2>
      <p class="section-subtitle">Business licence offers, visa packages, flight ticket promotions, website development offers, recruitment packages, and seasonal travel promotions.</p>
    </div>

    <div class="offers-grid">
      <?php foreach (array_slice($offers, 0, 3) as $offer): ?>
      <div class="offer-card animate-on-scroll" data-division="<?= htmlspecialchars($offer['division_slug'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <div class="offer-badge">
          <?= round((1 - $offer['offer_price']/$offer['original_price'])*100) ?>% OFF
        </div>
        <div class="offer-img" style="background:var(--grad-brand);display:flex;align-items:center;justify-content:center;">
          <i class="fas fa-tags" style="font-size:4rem;color:rgba(212,175,55,.4);"></i>
        </div>
        <div class="offer-body">
          <div class="offer-division"><?= htmlspecialchars($offer['division_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
          <h3><?= htmlspecialchars($offer['title'], ENT_QUOTES, 'UTF-8') ?></h3>
          <div class="offer-prices">
            <span class="price-original">AED <?= number_format($offer['original_price'], 0) ?></span>
            <span class="price-offer">AED <?= number_format($offer['offer_price'], 0) ?></span>
          </div>
          <div class="offer-expiry"><i class="fas fa-clock fa-xs"></i> Expires: <?= date('d M Y', strtotime($offer['expiry_date'])) ?></div>
          <div class="offer-actions">
            <a href="<?= APP_URL ?>/offers" class="btn btn-primary btn-sm">
              <i class="fas fa-info-circle"></i> Enquiry
            </a>
            <a href="https://wa.me/<?= SITE_WHATSAPP ?>?text=I'm+interested+in+offer:+<?= urlencode($offer['title']) ?>"
               target="_blank" class="btn btn-emerald btn-sm">
              <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ─── TESTIMONIALS ───────────────────────────────────────────── -->
<section class="section style-smoke" style="background:var(--clr-smoke,#F1F5F9);" aria-labelledby="testimonials-heading">
  <div class="container">
    <div class="section-header animate-on-scroll">
      <span class="section-eyebrow">Client Feedback</span>
      <h2 class="section-title" id="testimonials-heading">
        Client <span class="highlight">Testimonials</span>
      </h2>
    </div>

    <div class="row g-4">
      <?php
      $testimonials = [
        ['name'=>'Aisha Al-Rahman','title'=>'Free Zone Setup','service'=>'Business Consultancy','text'=>'MS Horizon helped me set up my company in just 5 days. Transparent pricing and exceptional support.','rating'=>5,'initial'=>'A'],
        ['name'=>'James O\'Brien','title'=>'Executive Recruitment','service'=>'Human Resource Consultancy','text'=>'Their HR division sourced 8 qualified candidates within a week. High professionalism throughout.','rating'=>5,'initial'=>'J'],
        ['name'=>'Priya Sharma','title'=>'Schengen Tourist Visa','service'=>'Travel & Tourism','text'=>'Got my visa approved smoothly. The document checklist and appointment assistance were top-notch.','rating'=>5,'initial'=>'P'],
      ];
      foreach ($testimonials as $t): ?>
      <div class="col-md-4">
        <div class="testimonial-card animate-on-scroll">
          <div class="testimonial-quote">"</div>
          <div class="badge bg-warning text-dark mb-2"><?= $t['service'] ?></div>
          <p class="testimonial-text"><?= htmlspecialchars($t['text'], ENT_QUOTES, 'UTF-8') ?></p>
          <div class="testimonial-rating"><?= str_repeat('<i class="fas fa-star"></i>', $t['rating']) ?></div>
          <div class="testimonial-author">
            <div class="author-avatar"><?= $t['initial'] ?></div>
            <div>
              <div class="author-name"><?= htmlspecialchars($t['name'], ENT_QUOTES, 'UTF-8') ?></div>
              <div class="author-title"><?= htmlspecialchars($t['title'], ENT_QUOTES, 'UTF-8') ?></div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
