<div class="breadcrumb-section">
  <div class="container">
    <h1>Group News & Editorial Blog</h1>
    <div class="breadcrumb-nav"><a href="<?= APP_URL ?>/">Home</a> <span>/</span> <span>Blog</span></div>
  </div>
</div>
<section class="section">
  <div class="container">
    <div class="row g-4">
      <?php foreach (($blogs ?? []) as $b): ?>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
          <div class="p-4 bg-dark text-white">
            <span class="badge bg-warning text-dark mb-2"><?= htmlspecialchars($b['category'], ENT_QUOTES, 'UTF-8') ?></span>
            <h3 class="h5 font-weight-bold"><?= htmlspecialchars($b['title'], ENT_QUOTES, 'UTF-8') ?></h3>
          </div>
          <div class="card-body p-4 d-flex flex-column justify-content-between">
            <p class="text-muted small"><?= substr(strip_tags($b['content']), 0, 120) ?>...</p>
            <div class="d-flex align-items-center justify-content-between">
              <small class="text-muted"><i class="fas fa-user me-1"></i> <?= htmlspecialchars($b['author'], ENT_QUOTES, 'UTF-8') ?></small>
              <a href="<?= APP_URL ?>/blog/<?= $b['slug'] ?>" class="btn btn-primary btn-sm">Read Article</a>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
