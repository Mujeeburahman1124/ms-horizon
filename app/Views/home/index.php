<!-- ─── HERO SECTION ───────────────────────────────────────────── -->
<section class="hero-section" aria-label="MS Horizon Group Homepage Hero">
  <div class="hero-bg-animation"></div>
  <div class="hero-grid-overlay"></div>

  <div class="hero-content">
    <!-- Hero Left Column -->
    <div class="hero-left" data-aos="fade-right">
      <div class="hero-badge">
        <i class="fas fa-crown"></i>
        <span>MS Horizon — UAE Premier Corporate Group</span>
      </div>

      <h1 class="hero-heading">
        One Group.<br>
        <span class="highlight">Multiple Enterprise</span><br>
        <span class="highlight-cyan">Solutions.</span>
      </h1>

      <p class="hero-subheading">
        Streamline your global travel, ticket reservations, executive recruitment, UAE company formation, and custom software development with one trusted corporate partner.
      </p>

      <div class="hero-actions">
        <a href="<?= APP_URL ?>/services" class="btn btn-primary btn-lg">
          <i class="fas fa-th-large"></i> Explore All Divisions
        </a>
        <a href="<?= APP_URL ?>/contact" class="btn btn-outline btn-lg">
          <i class="fas fa-headset"></i> Free Consultation
        </a>
        <a href="https://wa.me/<?= SITE_WHATSAPP ?>" target="_blank" rel="noopener" class="btn btn-emerald btn-lg">
          <i class="fab fa-whatsapp"></i> Chat on WhatsApp
        </a>
      </div>

      <div class="hero-stats">
        <div class="hero-stat-item">
          <span class="hero-stat-number" data-counter data-target="1800" data-suffix="+">1,800+</span>
          <span class="hero-stat-label">Satisfied Clients</span>
        </div>
        <div class="hero-stat-item">
          <span class="hero-stat-number" data-counter data-target="5000" data-suffix="+">5,000+</span>
          <span class="hero-stat-label">Visas Processed</span>
        </div>
        <div class="hero-stat-item">
          <span class="hero-stat-number" data-counter data-target="400" data-suffix="+">400+</span>
          <span class="hero-stat-label">Companies Setup</span>
        </div>
        <div class="hero-stat-item">
          <span class="hero-stat-number" data-counter data-target="120" data-suffix="+">120+</span>
          <span class="hero-stat-label">Software Projects</span>
        </div>
      </div>
    </div><!-- /.hero-left -->

    <!-- Hero Right Column — Quick Consultation Glass Card -->
    <div class="hero-right" data-aos="fade-left">
      <div class="hero-card-float spotlight-card">
        <h3><i class="fas fa-paper-plane text-gold"></i> Quick Service Enquiry</h3>
        <p style="color:rgba(255,255,255,.6);font-size:.825rem;margin-bottom:1.5rem;">
          Get a callback & personalized quote from our corporate advisors within 2 hours.
        </p>

        <form id="heroEnquiryForm" data-ajax="true" action="<?= APP_URL ?>/quick-enquiry" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">

          <div class="enquiry-form-group">
            <label for="hero_name">Full Name</label>
            <input type="text" id="hero_name" name="name" placeholder="e.g. Mohammed Al-Maktoum" required autocomplete="name">
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
            <input type="email" id="hero_email" name="email" placeholder="name@company.com" required autocomplete="email">
          </div>

          <div class="row g-2">
            <div class="col-6">
              <div class="enquiry-form-group">
                <label for="hero_country">Target Region</label>
                <select id="hero_country" name="country" required>
                  <option value="UAE">🇦🇪 UAE</option>
                  <option value="Qatar">🇶🇦 Qatar</option>
                  <option value="Oman">🇴🇲 Oman</option>
                  <option value="Saudi Arabia">🇸🇦 Saudi Arabia</option>
                  <option value="Bahrain">🇧🇭 Bahrain</option>
                  <option value="Europe">🇪🇺 Schengen / Europe</option>
                  <option value="UK">🇬🇧 United Kingdom</option>
                  <option value="USA">🇺🇸 USA & Canada</option>
                  <option value="India">🇮🇳 India & Sri Lanka</option>
                </select>
              </div>
            </div>
            <div class="col-6">
              <div class="enquiry-form-group">
                <label for="hero_service">Required Division</label>
                <select id="hero_service" name="service" required>
                  <option value="Reservations Services">✈ Reservations Services</option>
                  <option value="Travel and Tourism">🌍 Travel & Tourism</option>
                  <option value="Human Resource Consultancy">👥 HR Consultancy</option>
                  <option value="Business Consultancy">🏢 Business Setup</option>
                  <option value="Software Development">💻 Software Dev</option>
                </select>
              </div>
            </div>
          </div>

          <div class="enquiry-form-group">
            <label for="hero_msg">Brief Requirements</label>
            <textarea id="hero_msg" name="message" rows="2" placeholder="Tell us how we can help your business..." required></textarea>
          </div>

          <div class="enquiry-form-group">
            <label for="hero_doc">Attach Document (Optional)</label>
            <input type="file" id="hero_doc" name="document" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" class="form-control" style="background:rgba(255,255,255,.06);color:white;border-color:rgba(255,255,255,.15);">
          </div>

          <button type="submit" class="btn btn-primary" style="width:100%;margin-top:.5rem;">
            <i class="fas fa-paper-plane"></i> Submit Request
          </button>
        </form>
      </div>
    </div><!-- /.hero-right -->
  </div><!-- /.hero-content -->
</section>

<!-- ─── SVG WAVE DIVIDER 1 ────────────────────────────────────── -->
<div class="svg-divider">
  <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
    <path d="M0,0 C150,90 350,-40 500,55 C650,150 900,10 1200,40 L1200,120 L0,120 Z" class="shape-fill"></path>
  </svg>
</div>

<!-- ─── 5 MAIN SERVICE DIVISIONS SECTION ───────────────────────── -->
<section class="section" aria-labelledby="divisions-heading">
  <div class="container">
    <div class="section-header animate-on-scroll">
      <span class="section-eyebrow"><i class="fas fa-layer-group me-1"></i> Core Capabilities</span>
      <h2 class="section-title" id="divisions-heading">
        Five Strategic <span class="highlight">Service Divisions</span>
      </h2>
      <p class="section-subtitle">
        Empowering global individuals and enterprises with integrated corporate solutions under MS Horizon Group.
      </p>
    </div>

    <div class="division-grid">
      <!-- 1. Reservations Services -->
      <div class="division-card" style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=800&auto=format&fit=crop');" onclick="window.location='<?= APP_URL ?>/reservations'">
        <div class="division-card-overlay"></div>
        <div class="division-card-content">
          <span class="division-card-badge" style="background:rgba(212,175,55,.2);color:#D4AF37;border:1px solid rgba(212,175,55,.4);">
            <i class="fas fa-plane-departure"></i> Division 01
          </span>
          <div class="division-card-icon" style="background:var(--grad-gold);color:#0A1628;">
            <i class="fas fa-plane"></i>
          </div>
          <h3>Reservations Services</h3>
          <p>Flight booking, luxury hotel suites, airport transfers, tour reservations, and 24/7 corporate travel management.</p>
          <div class="division-subpills">
            <span class="subpill">Airline Tickets</span>
            <span class="subpill">Hotel Suites</span>
            <span class="subpill">Airport Transfers</span>
          </div>
          <div class="division-card-link" style="color:var(--clr-gold);">
            Learn More <i class="fas fa-arrow-right"></i>
          </div>
        </div>
      </div>

      <!-- 2. Travel and Tourism -->
      <div class="division-card" style="background-image: url('https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=800&auto=format&fit=crop');" onclick="window.location='<?= APP_URL ?>/travel'">
        <div class="division-card-overlay"></div>
        <div class="division-card-content">
          <span class="division-card-badge" style="background:rgba(0,184,148,.2);color:#00B894;border:1px solid rgba(0,184,148,.4);">
            <i class="fas fa-passport"></i> Division 02
          </span>
          <div class="division-card-icon" style="background:var(--grad-emerald);color:white;">
            <i class="fas fa-globe-americas"></i>
          </div>
          <h3>Travel & Tourism</h3>
          <p>Worldwide tourist visas, custom holiday packages, flight bookings, visa documentation & fast-track application processing.</p>
          <div class="division-subpills">
            <span class="subpill">Tourist Visas</span>
            <span class="subpill">Holiday Packages</span>
            <span class="subpill">Fast Track</span>
          </div>
          <div class="division-card-link" style="color:var(--clr-emerald);">
            Learn More <i class="fas fa-arrow-right"></i>
          </div>
        </div>
      </div>

      <!-- 3. HR Consultancy -->
      <div class="division-card" style="background-image: url('https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&auto=format&fit=crop');" onclick="window.location='<?= APP_URL ?>/careers'">
        <div class="division-card-overlay"></div>
        <div class="division-card-content">
          <span class="division-card-badge" style="background:rgba(37,99,235,.2);color:#3B82F6;border:1px solid rgba(37,99,235,.4);">
            <i class="fas fa-users-gear"></i> Division 03
          </span>
          <div class="division-card-icon" style="background:var(--grad-sapphire);color:white;">
            <i class="fas fa-user-tie"></i>
          </div>
          <h3>HR Consultancy</h3>
          <p>Executive talent acquisition, overseas manpower sourcing, CV optimization, interview prep & workforce outsourcing.</p>
          <div class="division-subpills">
            <span class="subpill">Executive Search</span>
            <span class="subpill">Overseas Hiring</span>
            <span class="subpill">Outsourcing</span>
          </div>
          <div class="division-card-link" style="color:var(--clr-blue-acc);">
            Learn More <i class="fas fa-arrow-right"></i>
          </div>
        </div>
      </div>

      <!-- 4. Business Setup -->
      <div class="division-card" style="background-image: url('https://images.unsplash.com/photo-1512453979798-5ea266f8880c?q=80&w=800&auto=format&fit=crop');" onclick="window.location='<?= APP_URL ?>/business'">
        <div class="division-card-overlay"></div>
        <div class="division-card-content">
          <span class="division-card-badge" style="background:rgba(139,92,246,.2);color:#A855F7;border:1px solid rgba(139,92,246,.4);">
            <i class="fas fa-building-columns"></i> Division 04
          </span>
          <div class="division-card-icon" style="background:var(--grad-amethyst);color:white;">
            <i class="fas fa-city"></i>
          </div>
          <h3>Business Consultancy</h3>
          <p>UAE business formation in Freezone, Mainland & Offshore jurisdictions, PRO services, investor visas & corporate bank account opening.</p>
          <div class="division-subpills">
            <span class="subpill">Freezone & Mainland</span>
            <span class="subpill">Trade License</span>
            <span class="subpill">Corporate Banking</span>
          </div>
          <div class="division-card-link" style="color:var(--clr-violet);">
            Learn More <i class="fas fa-arrow-right"></i>
          </div>
        </div>
      </div>

      <!-- 5. Software Development -->
      <div class="division-card" style="background-image: url('https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=800&auto=format&fit=crop');" onclick="window.location='<?= APP_URL ?>/software'">
        <div class="division-card-overlay"></div>
        <div class="division-card-content">
          <span class="division-card-badge" style="background:rgba(231,76,60,.2);color:#E74C3C;border:1px solid rgba(231,76,60,.4);">
            <i class="fas fa-laptop-code"></i> Division 05
          </span>
          <div class="division-card-icon" style="background:linear-gradient(135deg, #E74C3C, #FF7675);color:white;">
            <i class="fas fa-code"></i>
          </div>
          <h3>Software Development</h3>
          <p>Enterprise web applications, iOS/Android mobile apps, custom CRM & ERP systems, travel portals & AI automation.</p>
          <div class="division-subpills">
            <span class="subpill">Custom Web & SaaS</span>
            <span class="subpill">Mobile Apps</span>
            <span class="subpill">AI & Portals</span>
          </div>
          <div class="division-card-link" style="color:var(--clr-red);">
            Learn More <i class="fas fa-arrow-right"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ─── DESTINATIONS & VISA EXPLORER SECTION ─────────────────────── -->
<section class="section section-sm" style="background:var(--clr-smoke);" aria-labelledby="countries-heading">
  <div class="container">
    <div class="section-header animate-on-scroll">
      <span class="section-eyebrow"><i class="fas fa-globe me-1"></i> Global Reach</span>
      <h2 class="section-title" id="countries-heading">
        Popular Destination <span class="highlight">Visa Services</span>
      </h2>
      <p class="section-subtitle">
        Fast, hassle-free visa processing with guaranteed documentation support for top destinations worldwide.
      </p>
    </div>

    <div class="country-grid">
      <?php
      $countries = [
        ['flag'=>'🇦🇪', 'name'=>'United Arab Emirates', 'tag'=>'Express 24-48 hr Visa', 'url'=>'/travel/countries/uae'],
        ['flag'=>'🇶🇦', 'name'=>'Qatar',                 'tag'=>'Tourist & Business',   'url'=>'/travel/countries/qatar'],
        ['flag'=>'🇸🇦', 'name'=>'Saudi Arabia',          'tag'=>'Umrah & Tourist Visa', 'url'=>'/travel/countries/saudi'],
        ['flag'=>'🇴🇲', 'name'=>'Oman',                  'tag'=>'E-Visa Processing',    'url'=>'/travel/countries/oman'],
        ['flag'=>'🇧🇭', 'name'=>'Bahrain',               'tag'=>'Fast Approval',        'url'=>'/travel/countries/bahrain'],
        ['flag'=>'🇪🇺', 'name'=>'Schengen / Europe',     'tag'=>'Appointment Assist',   'url'=>'/travel/countries/schengen'],
        ['flag'=>'🇬🇧', 'name'=>'United Kingdom',        'tag'=>'Standard & Priority',  'url'=>'/travel/countries/uk'],
        ['flag'=>'🇺🇸', 'name'=>'USA & Canada',           'tag'=>'B1/B2 & Visitor',      'url'=>'/travel/countries/usa'],
        ['flag'=>'🇱🇰', 'name'=>'Sri Lanka',             'tag'=>'ETA Clearance',        'url'=>'/travel/countries/srilanka'],
        ['flag'=>'🇮🇳', 'name'=>'India',                 'tag'=>'E-Tourist & Business', 'url'=>'/travel/countries/india'],
      ];
      foreach ($countries as $c): ?>
      <div class="country-card" onclick="window.location='<?= APP_URL . $c['url'] ?>'">
        <span class="country-flag"><?= $c['flag'] ?></span>
        <div class="country-name"><?= $c['name'] ?></div>
        <span class="country-visa-tag"><?= $c['tag'] ?></span>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ─── FEATURED OFFERS SECTION ───────────────────────────────── -->
<section class="section" aria-labelledby="offers-heading">
  <div class="container">
    <div class="section-header animate-on-scroll">
      <span class="section-eyebrow"><i class="fas fa-tags me-1"></i> Exclusive Deals</span>
      <h2 class="section-title" id="offers-heading">
        Featured Corporate <span class="highlight">Offers & Packages</span>
      </h2>
      <p class="section-subtitle">
        Take advantage of our limited-time special promotions across Travel, Business Setup, and Software.
      </p>
    </div>

    <div class="offers-grid">
      <!-- Offer 1 -->
      <div class="offer-card">
        <span class="offer-badge">SAVE 25%</span>
        <div class="offer-img-wrapper">
          <img src="https://images.unsplash.com/photo-1512453979798-5ea266f8880c?q=80&w=800&auto=format&fit=crop" alt="Dubai Business Setup">
        </div>
        <div class="offer-body">
          <span class="offer-division">Business Setup</span>
          <h3>Dubai IFZA Freezone Company License + Visa Package</h3>
          <div class="offer-prices">
            <span class="price-original">AED 18,500</span>
            <span class="price-offer">AED 13,900</span>
            <span class="price-currency">ALL INCLUSIVE</span>
          </div>
          <a href="<?= APP_URL ?>/offers" class="btn btn-primary btn-sm" style="width:100%;">
            <i class="fas fa-bolt"></i> Claim Offer Now
          </a>
        </div>
      </div>

      <!-- Offer 2 -->
      <div class="offer-card">
        <span class="offer-badge">HOT DEAL</span>
        <div class="offer-img-wrapper">
          <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?q=80&w=800&auto=format&fit=crop" alt="Schengen Visa Package">
        </div>
        <div class="offer-body">
          <span class="offer-division">Travel & Tourism</span>
          <h3>Express Schengen Visa Assistance & Insurance Package</h3>
          <div class="offer-prices">
            <span class="price-original">AED 1,200</span>
            <span class="price-offer">AED 799</span>
            <span class="price-currency">PER PERSON</span>
          </div>
          <a href="<?= APP_URL ?>/offers" class="btn btn-primary btn-sm" style="width:100%;">
            <i class="fas fa-bolt"></i> Claim Offer Now
          </a>
        </div>
      </div>

      <!-- Offer 3 -->
      <div class="offer-card">
        <span class="offer-badge">POPULAR</span>
        <div class="offer-img-wrapper">
          <img src="https://images.unsplash.com/photo-1555066931-4365d14bab8c?q=80&w=800&auto=format&fit=crop" alt="Corporate Software Development">
        </div>
        <div class="offer-body">
          <span class="offer-division">Software Development</span>
          <h3>Corporate Portal & E-Commerce Web App Development</h3>
          <div class="offer-prices">
            <span class="price-original">AED 6,500</span>
            <span class="price-offer">AED 4,200</span>
            <span class="price-currency">CUSTOM DESIGN</span>
          </div>
          <a href="<?= APP_URL ?>/offers" class="btn btn-primary btn-sm" style="width:100%;">
            <i class="fas fa-bolt"></i> Claim Offer Now
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ─── BUSINESS PROCESS & WORKFLOW TIMELINE ───────────────────── -->
<section class="section section-dark" aria-labelledby="process-heading">
  <div class="container">
    <div class="section-header animate-on-scroll">
      <span class="section-eyebrow"><i class="fas fa-route me-1"></i> Seamless Execution</span>
      <h2 class="section-title" id="process-heading">
        How We Deliver <span class="highlight">Excellence</span>
      </h2>
      <p class="section-subtitle">
        Our simple 4-step process guarantees transparency, speed, and 100% customer satisfaction.
      </p>
    </div>

    <div class="process-timeline">
      <div class="process-step">
        <div class="process-step-node">01</div>
        <h4>Select Service</h4>
        <p>Choose from our Travel, Reservations, HR, Business Setup, or Software divisions.</p>
      </div>
      <div class="process-step">
        <div class="process-step-node">02</div>
        <h4>Consultation & Upload</h4>
        <p>Discuss requirements with dedicated advisors & submit initial documentation online.</p>
      </div>
      <div class="process-step">
        <div class="process-step-node">03</div>
        <h4>Fast-Track Processing</h4>
        <p>Our specialists process your visa, ticket, recruitment batch, or custom software development.</p>
      </div>
      <div class="process-step">
        <div class="process-step-node">04</div>
        <h4>Delivery & 24/7 Support</h4>
        <p>Receive your completed deliverables with continuous key account assistance.</p>
      </div>
    </div>
  </div>
</section>

<!-- ─── ANIMATED METRICS & STATS COUNTER ───────────────────────── -->
<section class="stats-section" aria-label="Company metrics">
  <div class="container">
    <div class="stats-grid">
      <div class="stat-card">
        <span class="stat-number" data-counter data-target="1800" data-suffix="+">1,800+</span>
        <span class="stat-label">Satisfied Clients</span>
      </div>
      <div class="stat-card">
        <span class="stat-number" data-counter data-target="5000" data-suffix="+">5,000+</span>
        <span class="stat-label">Visas Issued</span>
      </div>
      <div class="stat-card">
        <span class="stat-number" data-counter data-target="400" data-suffix="+">400+</span>
        <span class="stat-label">Companies Formed</span>
      </div>
      <div class="stat-card">
        <span class="stat-number" data-counter data-target="120" data-suffix="+">120+</span>
        <span class="stat-label">Software Delivered</span>
      </div>
    </div>
  </div>
</section>

<!-- ─── CLIENT TESTIMONIALS & TRUST ────────────────────────────── -->
<section class="section" aria-labelledby="testimonials-heading">
  <div class="container">
    <div class="section-header animate-on-scroll">
      <span class="section-eyebrow"><i class="fas fa-star me-1"></i> Client Reviews</span>
      <h2 class="section-title" id="testimonials-heading">
        What Our Enterprise <span class="highlight">Clients Say</span>
      </h2>
      <p class="section-subtitle">
        Trusted by businesses, travelers, and executives across Dubai, GCC, and worldwide.
      </p>
    </div>

    <div class="testimonials-grid">
      <div class="testimonial-card">
        <div class="testimonial-stars">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
        <p class="testimonial-text">
          "MS Horizon helped us setup our Freezone company in Dubai within 4 days. Their business consultants handled all legal paperwork, bank account opening, and residence visas effortlessly!"
        </p>
        <div class="testimonial-user">
          <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=150&auto=format&fit=crop" alt="Client Avatar" class="testimonial-avatar">
          <div class="testimonial-info">
            <h5>Sarah Jenkins</h5>
            <span>CEO, Apex Logistics Dubai</span>
          </div>
        </div>
      </div>

      <div class="testimonial-card">
        <div class="testimonial-stars">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
        <p class="testimonial-text">
          "We engaged MS Horizon's software division to build our custom ERP and mobile app. Outstanding code quality, fast turnarounds, and exceptional post-launch support!"
        </p>
        <div class="testimonial-user">
          <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=150&auto=format&fit=crop" alt="Client Avatar" class="testimonial-avatar">
          <div class="testimonial-info">
            <h5>Tariq Al-Mansoori</h5>
            <span>Managing Director, Horizon Tech</span>
          </div>
        </div>
      </div>

      <div class="testimonial-card">
        <div class="testimonial-stars">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
        <p class="testimonial-text">
          "The visa team processed my Schengen visa in record time. Excellent communication via WhatsApp and complete guidance from start to finish. Highly recommended group!"
        </p>
        <div class="testimonial-user">
          <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=150&auto=format&fit=crop" alt="Client Avatar" class="testimonial-avatar">
          <div class="testimonial-info">
            <h5>Vikram Sharma</h5>
            <span>Frequent Traveller & Consultant</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ─── FLOATING GLASS CTA ─────────────────────────────────────── -->
<section class="section section-sm">
  <div class="container">
    <div class="glass-cta">
      <div class="glass-cta-bg"></div>
      <div class="glass-cta-content">
        <h2>Ready to Elevate Your Global Business?</h2>
        <p style="font-size:1.1rem;color:rgba(255,255,255,.8);margin-bottom:2.25rem;">
          Connect with MS Horizon advisors today for immediate assistance with Travel, HR, Business Setup, or Custom Software.
        </p>
        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
          <a href="<?= APP_URL ?>/contact" class="btn btn-primary btn-lg">
            <i class="fas fa-envelope"></i> Request Consultation
          </a>
          <a href="https://wa.me/<?= SITE_WHATSAPP ?>" target="_blank" rel="noopener" class="btn btn-emerald btn-lg">
            <i class="fab fa-whatsapp"></i> Chat on WhatsApp
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
