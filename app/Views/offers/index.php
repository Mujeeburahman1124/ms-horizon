<div class="breadcrumb-section">
  <div class="container">
    <h1>Special Offers & Promotions</h1>
    <div class="breadcrumb-nav"><a href="<?= APP_URL ?>/">Home</a> <span>/</span> <span>Offers</span></div>
  </div>
</div>
<section class="section">
  <div class="container">
    <div class="section-header text-center mb-5">
      <span class="section-eyebrow">Limited Time Deals</span>
      <h2 class="section-title">Active <span class="highlight">Group Promotions</span></h2>
      <p class="section-subtitle">Save big on UAE Visas, Luxury Hotels, Executive Recruitment, and Corporate Business Setup.</p>
    </div>
    <div class="offers-grid" style="display:grid;grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));gap:2rem;">
      <?php foreach (($offers ?? []) as $off): 
        $discount = $off['discount_percentage'] ?? 20;
        $origPrice = $off['original_price'] ?? 500;
        $offerPrice = $off['offer_price'] ?? 399;
        $expiry = !empty($off['expiry_date']) ? date('d M Y', strtotime($off['expiry_date'])) : '31 Dec 2026';
      ?>
      <div class="offer-card" style="background:#0F172A;border:1px solid rgba(212,175,55,.3);border-radius:16px;padding:1.5rem;position:relative;box-shadow:0 10px 30px rgba(0,0,0,.3);">
        <div class="offer-badge" style="position:absolute;top:1rem;right:1rem;background:linear-gradient(135deg, #D4AF37, #AA7C11);color:#0A1628;font-weight:800;padding:.3rem .8rem;border-radius:20px;font-size:.8rem;"><?= $discount ?>% OFF</div>
        <div class="offer-body">
          <div class="offer-division" style="color:var(--clr-gold);font-size:.8rem;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:.5rem;"><?= htmlspecialchars($off['division_name'] ?? 'MS Horizon Group', ENT_QUOTES, 'UTF-8') ?></div>
          <h3 style="font-size:1.25rem;color:white;font-weight:700;margin-bottom:1rem;"><?= htmlspecialchars($off['title'], ENT_QUOTES, 'UTF-8') ?></h3>
          <p style="color:rgba(255,255,255,.7);font-size:.9rem;line-height:1.5;margin-bottom:1rem;"><?= htmlspecialchars($off['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
          <div class="offer-prices" style="display:flex;align-items:center;gap:1rem;margin-bottom:1rem;">
            <span class="price-original" style="text-decoration:line-through;color:rgba(255,255,255,.4);font-size:.95rem;">AED <?= number_format($origPrice, 0) ?></span>
            <span class="price-offer" style="color:#D4AF37;font-size:1.4rem;font-weight:800;">AED <?= number_format($offerPrice, 0) ?></span>
          </div>
          <div class="offer-expiry" style="color:rgba(255,255,255,.5);font-size:.8rem;margin-bottom:1rem;"><i class="fas fa-clock fa-xs me-1"></i> Expires: <?= $expiry ?></div>
          <a href="https://wa.me/<?= SITE_WHATSAPP ?>?text=Claim+Offer:+<?= urlencode($off['title']) ?>" target="_blank" class="btn btn-gold w-100 justify-content-center" style="border-radius:25px;font-weight:700;"><i class="fab fa-whatsapp me-2"></i> Claim Deal on WhatsApp</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
