</main><!-- /#main-content -->

<!-- ─── NEWSLETTER SECTION ────────────────────────────────────── -->
<section class="newsletter-section" aria-label="Newsletter signup">
  <div class="container">
    <div class="newsletter-inner">
      <div class="newsletter-text">
        <h2><i class="fas fa-envelope-open-text"></i> Stay Updated</h2>
        <p>Subscribe to the latest travel deals, visa updates, job alerts & business offers.</p>
      </div>
      <form class="newsletter-form" data-ajax="true" action="<?= APP_URL ?>/newsletter" method="POST" aria-label="Newsletter subscription form">
        <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">
        <input type="email" name="email" placeholder="Your email address" required aria-label="Email address">
        <button type="submit" class="btn"><i class="fas fa-paper-plane"></i> Subscribe</button>
      </form>
    </div>
  </div>
</section>

<!-- ─── SITE FOOTER ───────────────────────────────────────────── -->
<footer class="site-footer" role="contentinfo">
  <div class="container">
    <div class="footer-top">

      <!-- Brand Column -->
      <div class="footer-brand-col">
        <div class="footer-logo">MS <span>Horizon</span></div>
        <p class="footer-desc">
          MS Horizon Group is a trusted UAE-based corporate group delivering integrated solutions across Travel & Tourism, Reservations, Human Resource Consultancy, Business Setup, and Software Development.
        </p>
        <div class="footer-contact-item">
          <i class="fas fa-map-marker-alt footer-contact-icon"></i>
          <span>Level 28, Horizon Tower, Business Bay, Dubai, United Arab Emirates</span>
        </div>
        <div class="footer-contact-item">
          <i class="fas fa-phone footer-contact-icon"></i>
          <a href="tel:+97141234567">+971 4 123 4567</a>
        </div>
        <div class="footer-contact-item">
          <i class="fab fa-whatsapp footer-contact-icon"></i>
          <a href="https://wa.me/971501234567" target="_blank" rel="noopener">+971 50 123 4567</a>
        </div>
        <div class="footer-contact-item">
          <i class="fas fa-envelope footer-contact-icon"></i>
          <a href="mailto:info@mshorizontravel.com">info@mshorizontravel.com</a>
        </div>
        <div class="footer-social" aria-label="Follow us on social media">
          <a href="#" class="social-btn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" class="social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-btn" aria-label="Twitter/X"><i class="fab fa-x-twitter"></i></a>
          <a href="#" class="social-btn" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
      </div>

      <!-- Divisions Column -->
      <div>
        <span class="footer-col-title">Our Divisions</span>
        <ul class="footer-links">
          <li><a href="<?= APP_URL ?>/reservations"><i class="fas fa-chevron-right fa-xs me-1"></i>Reservations Services</a></li>
          <li><a href="<?= APP_URL ?>/travel"><i class="fas fa-chevron-right fa-xs me-1"></i>Travel & Tourism</a></li>
          <li><a href="<?= APP_URL ?>/careers"><i class="fas fa-chevron-right fa-xs me-1"></i>HR Consultancy</a></li>
          <li><a href="<?= APP_URL ?>/business"><i class="fas fa-chevron-right fa-xs me-1"></i>Business Consultancy</a></li>
          <li><a href="<?= APP_URL ?>/software"><i class="fas fa-chevron-right fa-xs me-1"></i>Software Development</a></li>
          <li><a href="<?= APP_URL ?>/software/portfolio"><i class="fas fa-chevron-right fa-xs me-1"></i>Our Portfolio</a></li>
        </ul>
      </div>

      <!-- Quick Links Column -->
      <div>
        <span class="footer-col-title">Quick Links</span>
        <ul class="footer-links">
          <li><a href="<?= APP_URL ?>/about"><i class="fas fa-chevron-right fa-xs me-1"></i>About Us</a></li>
          <li><a href="<?= APP_URL ?>/careers"><i class="fas fa-chevron-right fa-xs me-1"></i>Careers & Jobs</a></li>
          <li><a href="<?= APP_URL ?>/offers"><i class="fas fa-chevron-right fa-xs me-1"></i>Offers & Promotions</a></li>
          <li><a href="<?= APP_URL ?>/blog"><i class="fas fa-chevron-right fa-xs me-1"></i>News & Blog</a></li>
          <li><a href="<?= APP_URL ?>/faqs"><i class="fas fa-chevron-right fa-xs me-1"></i>FAQs</a></li>
          <li><a href="<?= APP_URL ?>/contact"><i class="fas fa-chevron-right fa-xs me-1"></i>Contact Us</a></li>
          <li><a href="<?= APP_URL ?>/travel/track"><i class="fas fa-chevron-right fa-xs me-1"></i>Track Visa Application</a></li>
        </ul>
      </div>

      <!-- Legal Column -->
      <div>
        <span class="footer-col-title">Legal & Support</span>
        <ul class="footer-links">
          <li><a href="<?= APP_URL ?>/privacy-policy"><i class="fas fa-chevron-right fa-xs me-1"></i>Privacy Policy</a></li>
          <li><a href="<?= APP_URL ?>/terms-conditions"><i class="fas fa-chevron-right fa-xs me-1"></i>Terms & Conditions</a></li>
          <li><a href="<?= APP_URL ?>/refund-policy"><i class="fas fa-chevron-right fa-xs me-1"></i>Refund Policy</a></li>
          <li><a href="<?= APP_URL ?>/cookie-policy"><i class="fas fa-chevron-right fa-xs me-1"></i>Cookie Policy</a></li>
          <li><a href="<?= APP_URL ?>/sitemap"><i class="fas fa-chevron-right fa-xs me-1"></i>Sitemap</a></li>
          <li><a href="<?= APP_URL ?>/login"><i class="fas fa-chevron-right fa-xs me-1"></i>Staff Login</a></li>
          <li><a href="<?= APP_URL ?>/candidate/register"><i class="fas fa-chevron-right fa-xs me-1"></i>Candidate Register</a></li>
        </ul>
        <div style="margin-top:1.5rem;">
          <img src="https://img.shields.io/badge/SSL-Secured-green?style=for-the-badge&logo=ssl" alt="SSL Secured" style="height:22px;margin-bottom:.5rem;">
          <p style="font-size:.7rem;color:rgba(255,255,255,.3);margin-top:.5rem;">Trade License: DED-2026-XXXXX<br>Regulated under UAE Federal Laws</p>
        </div>
      </div>

    </div><!-- /.footer-top -->

    <div class="footer-bottom">
      <span>© <?= date('Y') ?> MS Horizon Group. All rights reserved. Built with ❤ in Dubai, UAE.</span>
      <span style="display:flex;gap:1.25rem;">
        <a href="<?= APP_URL ?>/sitemap">Sitemap</a>
        <a href="<?= APP_URL ?>/privacy-policy">Privacy</a>
        <a href="<?= APP_URL ?>/terms-conditions">Terms</a>
      </span>
    </div>
  </div>
</footer>

<!-- ─── FLOATING ACTION BUTTONS ───────────────────────────────── -->
<div class="floating-buttons" aria-label="Quick contact options">
  <a href="https://wa.me/<?= SITE_WHATSAPP ?>" target="_blank" rel="noopener"
     class="float-btn float-whatsapp" aria-label="Chat on WhatsApp" data-tip="WhatsApp Us">
    <i class="fab fa-whatsapp"></i>
  </a>
  <a href="tel:<?= SITE_PHONE ?>"
     class="float-btn float-call" aria-label="Call us" data-tip="Call Now">
    <i class="fas fa-phone"></i>
  </a>
  <button class="float-btn back-to-top" aria-label="Back to top" data-tip="Back to Top">
    <i class="fas fa-chevron-up"></i>
  </button>
</div>

<!-- ─── SCRIPTS ───────────────────────────────────────────────── -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- MS Horizon Main JS -->
<script src="<?= APP_URL ?>/assets/js/main.js"></script>

<?php if (isset($extra_scripts)) echo $extra_scripts; ?>
</body>
</html>
