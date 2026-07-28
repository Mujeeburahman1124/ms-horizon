<div class="breadcrumb-section">
  <div class="container">
    <h1>Special Offers & Promotions</h1>
    <div class="breadcrumb-nav"><a href="<?= APP_URL ?>/">Home</a> <span>/</span> <span>Offers</span></div>
  </div>
</div>
<section class="section">
  <div class="container">
    <div class="section-header">
      <span class="section-eyebrow">Limited Time Deals</span>
      <h2 class="section-title">Active <span class="highlight">Group Promotions</span></h2>
    </div>
    <div class="offers-grid">
      <?php foreach (($offers ?? []) as $off): ?>
      <div class="offer-card">
        <div class="offer-badge"><?= round((1 - $off['offer_price']/$off['original_price'])*100) ?>% OFF</div>
        <div class="offer-body">
          <div class="offer-division"><?= htmlspecialchars($off['division_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
          <h3><?= htmlspecialchars($off['title'], ENT_QUOTES, 'UTF-8') ?></h3>
          <div class="offer-prices">
            <span class="price-original">AED <?= number_format($off['original_price'], 0) ?></span>
            <span class="price-offer">AED <?= number_format($off['offer_price'], 0) ?></span>
          </div>
          <div class="offer-expiry"><i class="fas fa-clock fa-xs"></i> Expires: <?= date('d M Y', strtotime($off['expiry_date'])) ?></div>
          <a href="https://wa.me/<?= SITE_WHATSAPP ?>?text=Offer:+<?= urlencode($off['title']) ?>" target="_blank" class="btn btn-emerald btn-sm w-100 justify-content-center mt-2"><i class="fab fa-whatsapp me-1"></i> Claim Deal</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
