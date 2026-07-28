<div class="breadcrumb-section">
  <div class="container">
    <h1>Search Results</h1>
    <div class="breadcrumb-nav"><a href="<?= APP_URL ?>/">Home</a> <span>/</span> <span>Search</span></div>
  </div>
</div>
<section class="section">
  <div class="container" style="max-width:800px;">
    <form action="<?= APP_URL ?>/search" method="GET" class="d-flex gap-2 mb-4">
      <input type="text" name="q" value="<?= htmlspecialchars($query ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Search jobs, blogs, services..." class="form-control form-control-lg" required>
      <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-search"></i> Search</button>
    </form>

    <?php if (!empty($query)): ?>
    <h2 class="h5 font-weight-bold mb-3">Results for "<?= htmlspecialchars($query, ENT_QUOTES, 'UTF-8') ?>":</h2>
      <?php if (empty($results)): ?>
      <div class="alert alert-info">No matching pages or jobs found. Please try another keyword.</div>
      <?php else: ?>
      <div class="list-group">
        <?php foreach ($results as $r): ?>
        <a href="<?= APP_URL ?>/<?= $r['type'] === 'job' ? 'careers/' . $r['slug'] : 'blog/' . $r['slug'] ?>" class="list-group-item list-group-item-action py-3">
          <span class="badge bg-secondary me-2 text-uppercase"><?= $r['type'] ?></span>
          <strong class="h6 mb-0"><?= htmlspecialchars($r['title'], ENT_QUOTES, 'UTF-8') ?></strong>
        </a>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>
