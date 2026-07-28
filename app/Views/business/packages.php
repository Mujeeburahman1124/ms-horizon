<div class="breadcrumb-section">
  <div class="container">
    <h1>UAE Business Setup Packages</h1>
    <div class="breadcrumb-nav"><a href="<?= APP_URL ?>/">Home</a> <span>/</span> <a href="<?= APP_URL ?>/business">Business</a> <span>/</span> <span>Packages</span></div>
  </div>
</div>
<section class="section">
  <div class="container">
    <div class="row g-4">
      <?php foreach (($packages ?? []) as $pkg): ?>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center h-100">
          <span class="badge bg-warning text-dark align-self-center mb-2 px-3 py-2"><?= htmlspecialchars($pkg['jurisdiction'], ENT_QUOTES, 'UTF-8') ?></span>
          <h3 class="h4 font-weight-bold mb-3"><?= htmlspecialchars($pkg['title'], ENT_QUOTES, 'UTF-8') ?></h3>
          <div class="h2 font-weight-bold text-success mb-4">AED <?= number_format($pkg['price_starting'], 0) ?></div>
          <a href="<?= APP_URL ?>/business" class="btn btn-primary w-100 mb-3">Select Package</a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
