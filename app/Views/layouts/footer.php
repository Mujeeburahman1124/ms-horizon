</main><!-- /#main-content -->

<!-- ─── NEWSLETTER SECTION ────────────────────────────────────── -->
<section class="newsletter-section" aria-label="Newsletter subscription">
  <div class="container">
    <div class="newsletter-inner">
      <div class="newsletter-text">
        <h2><i class="fas fa-paper-plane me-2"></i> Stay Connected & Updated</h2>
        <p>Subscribe to receive exclusive travel deals, visa updates, job vacancies & business offers directly.</p>
      </div>
      <form class="newsletter-form" data-ajax="true" action="<?= APP_URL ?>/newsletter" method="POST" aria-label="Newsletter subscription form">
        <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
        <input type="email" name="email" placeholder="Enter your official email address" required aria-label="Email address">
        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Subscribe</button>
      </form>
    </div>
  </div>
</section>

<!-- ─── SITE FOOTER ───────────────────────────────────────────── -->
<footer class="site-footer" role="contentinfo">
  <div class="container">
    <div class="footer-top">

      <!-- Brand & Contact Column -->
      <div class="footer-brand-col">
        <div class="footer-logo">MS <span>Horizon</span></div>
        <p class="footer-desc">
          MS Horizon Group is a premier corporate organization headquartered in Dubai, UAE. We specialize in delivering end-to-end solutions across Travel & Tourism, Reservations, Human Resources, Business Setup, and Software Engineering.
        </p>
        <div class="footer-contact-item">
          <i class="fas fa-map-marker-alt footer-contact-icon"></i>
          <span>Level 28, Horizon Tower, Business Bay, Dubai, UAE</span>
        </div>
        <div class="footer-contact-item">
          <i class="fas fa-phone footer-contact-icon"></i>
          <a href="tel:+97141234567" style="color:white;font-weight:600;">+971 4 123 4567</a>
        </div>
        <div class="footer-contact-item">
          <i class="fab fa-whatsapp footer-contact-icon"></i>
          <a href="https://wa.me/<?= SITE_WHATSAPP ?>" target="_blank" rel="noopener" style="color:var(--clr-emerald);font-weight:700;">+971 50 123 4567</a>
        </div>
        <div class="footer-contact-item">
          <i class="fas fa-envelope footer-contact-icon"></i>
          <a href="mailto:info@mshorizontravel.com" style="color:white;">info@mshorizontravel.com</a>
        </div>
        <div class="footer-social" aria-label="Follow us on social media">
          <a href="#" class="social-btn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" class="social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-btn" aria-label="Twitter/X"><i class="fab fa-x-twitter"></i></a>
          <a href="#" class="social-btn" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
      </div>

      <!-- Divisions Directory Column -->
      <div>
        <span class="footer-col-title">Our Divisions</span>
        <ul class="footer-links">
          <li><a href="<?= APP_URL ?>/reservations"><i class="fas fa-chevron-right fa-xs me-1"></i> Reservations Services</a></li>
          <li><a href="<?= APP_URL ?>/travel"><i class="fas fa-chevron-right fa-xs me-1"></i> Travel & Tourism</a></li>
          <li><a href="<?= APP_URL ?>/careers"><i class="fas fa-chevron-right fa-xs me-1"></i> HR Consultancy</a></li>
          <li><a href="<?= APP_URL ?>/business"><i class="fas fa-chevron-right fa-xs me-1"></i> Business Consultancy</a></li>
          <li><a href="<?= APP_URL ?>/software"><i class="fas fa-chevron-right fa-xs me-1"></i> Software Development</a></li>
          <li><a href="<?= APP_URL ?>/software/portfolio"><i class="fas fa-chevron-right fa-xs me-1"></i> Enterprise Portfolio</a></li>
        </ul>
      </div>

      <!-- Quick Navigation Column -->
      <div>
        <span class="footer-col-title">Quick Links</span>
        <ul class="footer-links">
          <li><a href="<?= APP_URL ?>/about"><i class="fas fa-chevron-right fa-xs me-1"></i> About MS Horizon</a></li>
          <li><a href="<?= APP_URL ?>/travel/countries"><i class="fas fa-chevron-right fa-xs me-1"></i> Country Visas</a></li>
          <li><a href="<?= APP_URL ?>/offers"><i class="fas fa-chevron-right fa-xs me-1"></i> Special Offers</a></li>
          <li><a href="<?= APP_URL ?>/blog"><i class="fas fa-chevron-right fa-xs me-1"></i> Latest News</a></li>
          <li><a href="<?= APP_URL ?>/faqs"><i class="fas fa-chevron-right fa-xs me-1"></i> FAQs</a></li>
          <li><a href="<?= APP_URL ?>/contact"><i class="fas fa-chevron-right fa-xs me-1"></i> Contact Us</a></li>
          <li><a href="<?= APP_URL ?>/travel/track"><i class="fas fa-chevron-right fa-xs me-1"></i> Track Visa Status</a></li>
        </ul>
      </div>

      <!-- Legal & Accreditations Column -->
      <div>
        <span class="footer-col-title">Legal & Security</span>
        <ul class="footer-links">
          <li><a href="<?= APP_URL ?>/privacy-policy"><i class="fas fa-chevron-right fa-xs me-1"></i> Privacy Policy</a></li>
          <li><a href="<?= APP_URL ?>/terms-conditions"><i class="fas fa-chevron-right fa-xs me-1"></i> Terms & Conditions</a></li>
          <li><a href="<?= APP_URL ?>/refund-policy"><i class="fas fa-chevron-right fa-xs me-1"></i> Refund Policy</a></li>
          <li><a href="<?= APP_URL ?>/cookie-policy"><i class="fas fa-chevron-right fa-xs me-1"></i> Cookie Policy</a></li>
          <li><a href="<?= APP_URL ?>/sitemap"><i class="fas fa-chevron-right fa-xs me-1"></i> Sitemap</a></li>
          <li><a href="<?= APP_URL ?>/login"><i class="fas fa-chevron-right fa-xs me-1"></i> Staff Login</a></li>
        </ul>
        <div style="margin-top:1.5rem;">
          <span class="badge bg-success py-2 px-3 mb-2" style="font-size:.75rem;"><i class="fas fa-lock me-1"></i> 256-Bit SSL Encrypted</span>
          <p style="font-size:.75rem;color:rgba(255,255,255,.4);margin-top:.5rem;">
            DED License: DED-2026-88491<br>
            Regulated under UAE Federal Business Laws
          </p>
        </div>
      </div>

    </div><!-- /.footer-top -->

    <!-- Footer Bottom Copyright Bar -->
    <div class="footer-bottom">
      <div>
        &copy; <?= date('Y') ?> <strong>MS Horizon Group</strong>. All rights reserved. Registered Corporate Entity in Dubai, United Arab Emirates.
      </div>
      <div style="display:flex;gap:1.5rem;">
        <a href="<?= APP_URL ?>/privacy-policy" style="color:rgba(255,255,255,.5);">Privacy</a>
        <a href="<?= APP_URL ?>/terms-conditions" style="color:rgba(255,255,255,.5);">Terms</a>
        <a href="<?= APP_URL ?>/sitemap" style="color:rgba(255,255,255,.5);">Sitemap</a>
      </div>
    </div>
  </div>
</footer>

<!-- ─── FLOATING BACK TO TOP ────────────────────────────────────── -->
<button class="back-to-top" aria-label="Back to Top" title="Back to top">
  <i class="fas fa-arrow-up"></i>
</button>

<!-- ─── STICKY MOBILE BOTTOM NAVIGATION BAR ────────────────────── -->
<div class="mobile-bottom-bar" aria-label="Mobile quick actions">
  <a href="<?= APP_URL ?>/"><i class="fas fa-home"></i> <span>Home</span></a>
  <a href="<?= APP_URL ?>/travel"><i class="fas fa-plane-departure"></i> <span>Travel</span></a>
  <a href="<?= APP_URL ?>/careers"><i class="fas fa-briefcase"></i> <span>Careers</span></a>
  <a href="<?= APP_URL ?>/business"><i class="fas fa-building"></i> <span>Business</span></a>
  <a href="https://wa.me/<?= SITE_WHATSAPP ?>" target="_blank" rel="noopener"><i class="fab fa-whatsapp" style="color:var(--clr-emerald);"></i> <span>WhatsApp</span></a>
</div>

<!-- Bootstrap 5 Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- MS Horizon Main JS -->
<script src="<?= APP_URL ?>/assets/js/main.js"></script>

</body>
</html>
