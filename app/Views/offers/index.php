<div class="breadcrumb-section">
  <div class="container">
    <h1>Special Offers & Promotions</h1>
    <div class="breadcrumb-nav">
      <a href="<?= APP_URL ?>/">Home</a> <span>/</span> <span>Offers & Promotions</span>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="section-header text-center mb-5">
      <span class="section-eyebrow">Limited Time Group Deals</span>
      <h2 class="section-title">Exclusive <span class="highlight">MS Horizon Deals</span></h2>
      <p class="section-subtitle">Save on UAE Visas, Luxury Hotel Reservations, Executive HR Recruitment, Business Setup, and Software Engineering packages.</p>
    </div>

    <div class="offers-grid" style="display:grid;grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));gap:2rem;">
      <?php foreach (($offers ?? []) as $off): 
        $discount = $off['discount_percentage'] ?? 20;
        $origPrice = $off['original_price'] ?? 500;
        $offerPrice = $off['offer_price'] ?? 399;
        $expiry = !empty($off['expiry_date']) ? date('d M Y', strtotime($off['expiry_date'])) : '31 Dec 2026';
        $code = $off['promo_code'] ?? 'MSH2026';
      ?>
      <div class="offer-card" style="background:#0F172A;border:1px solid rgba(212,175,55,.3);border-radius:20px;padding:1.75rem;position:relative;box-shadow:0 12px 36px rgba(0,0,0,.35);display:flex;flex-direction:column;justify-content:space-between;transition:transform .3s ease;">
        
        <div class="offer-badge" style="position:absolute;top:1rem;right:1rem;background:linear-gradient(135deg, #D4AF37, #AA7C11);color:#0A1628;font-weight:800;padding:.35rem .85rem;border-radius:20px;font-size:.8rem;box-shadow:0 4px 12px rgba(212,175,55,.3);">
          <?= $discount ?>% OFF
        </div>

        <div class="offer-header mb-3">
          <div class="offer-division" style="color:var(--clr-gold);font-size:.78rem;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;margin-bottom:.4rem;">
            <i class="fas fa-tag fa-xs me-1"></i> <?= htmlspecialchars($off['division_name'] ?? 'MS Horizon Group', ENT_QUOTES, 'UTF-8') ?>
          </div>
          <h3 style="font-size:1.25rem;color:white;font-weight:700;line-height:1.3;margin-bottom:.75rem;"><?= htmlspecialchars($off['title'], ENT_QUOTES, 'UTF-8') ?></h3>
          <p style="color:rgba(255,255,255,.7);font-size:.875rem;line-height:1.6;margin-bottom:1rem;"><?= htmlspecialchars($off['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
        </div>

        <div class="offer-footer" style="padding-top:1rem;border-top:1px solid rgba(255,255,255,.08);">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="offer-prices">
              <span class="price-original" style="text-decoration:line-through;color:rgba(255,255,255,.4);font-size:.9rem;display:block;">AED <?= number_format($origPrice, 0) ?></span>
              <span class="price-offer" style="color:#D4AF37;font-size:1.5rem;font-weight:800;">AED <?= number_format($offerPrice, 0) ?></span>
            </div>
            <div class="promo-code-badge" style="background:rgba(212,175,55,.15);border:1px dashed rgba(212,175,55,.5);color:#D4AF37;padding:.3rem .75rem;border-radius:8px;font-size:.75rem;font-weight:700;letter-spacing:1px;">
              <?= htmlspecialchars($code, ENT_QUOTES, 'UTF-8') ?>
            </div>
          </div>

          <div class="offer-expiry" style="color:rgba(255,255,255,.5);font-size:.78rem;margin-bottom:1.25rem;">
            <i class="fas fa-clock fa-xs me-1" style="color:#D4AF37;"></i> Valid Until: <strong><?= $expiry ?></strong>
          </div>

          <a href="https://wa.me/<?= SITE_WHATSAPP ?>?text=Claim+Deal:+<?= urlencode($off['title']) ?>+(Promo:+<?= urlencode($code) ?>)" 
             target="_blank" class="btn btn-gold w-100 justify-content-center" 
             style="border-radius:25px;font-weight:700;padding:.75rem 1.25rem;background:linear-gradient(135deg, #D4AF37 0%, #AA7C11 100%);color:#0A1628;border:none;">
            <i class="fab fa-whatsapp me-2"></i> Claim Deal on WhatsApp
          </a>
        </div>

      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
