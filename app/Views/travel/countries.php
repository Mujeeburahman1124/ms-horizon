<div class="breadcrumb-section">
  <div class="container">
    <h1><i class="fas fa-globe text-warning me-2"></i> Destinations & Visa Rules</h1>
    <div class="breadcrumb-nav">
      <a href="<?= APP_URL ?>/">Home</a> <span>/</span>
      <a href="<?= APP_URL ?>/travel">Travel</a> <span>/</span>
      <span>Countries</span>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="section-header text-center mb-5">
      <span class="section-eyebrow">Global Reach</span>
      <h2 class="section-title">Select Your <span class="highlight">Destination Country</span></h2>
      <p class="section-subtitle">Click on any country to review visa eligibility, processing time, required documents, and pricing.</p>
    </div>

    <div class="country-grid">
      <?php
      $flagEmojis = [
        'AE' => '🇦🇪', 'QA' => '🇶🇦', 'OM' => '🇴🇲', 'SA' => '🇸🇦', 'BH' => '🇧🇭',
        'LK' => '🇱🇰', 'IN' => '🇮🇳', 'EU' => '🇪🇺', 'US' => '🇺🇸', 'CA' => '🇨🇦',
        'GB' => '🇬🇧', 'TR' => '🇹🇷', 'AU' => '🇦🇺', 'TH' => '🇹🇭', 'KW' => '🇰🇼'
      ];
      foreach (($countries ?? []) as $country): 
        $code = (string)($country['code'] ?? 'AE');
        $flag = $country['flag_emoji'] ?? ($flagEmojis[$code] ?? '🌍');
        $name = (string)($country['name'] ?? 'Country');
        $count = (int)($country['visa_count'] ?? 2);
      ?>
      <div class="country-card">
        <div class="country-flag"><?= e($flag) ?></div>
        <div class="country-name"><?= e($name) ?></div>
        <div class="country-visa-count"><i class="fas fa-passport fa-xs"></i> <?= $count ?> Visa Options</div>
        <a href="<?= APP_URL ?>/travel" class="btn btn-primary btn-sm mt-3 w-100">Explore Visas</a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
