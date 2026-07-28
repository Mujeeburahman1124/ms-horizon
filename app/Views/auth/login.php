<div class="breadcrumb-section">
  <div class="container">
    <h1>Portal & Staff Sign In</h1>
    <div class="breadcrumb-nav">
      <a href="<?= APP_URL ?>/">Home</a> <span>/</span>
      <span>Login</span>
    </div>
  </div>
</div>

<section class="section">
  <div class="container" style="max-width:500px;">
    <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5" style="background:var(--clr-navy);color:white;">
      <div class="text-center mb-4">
        <div class="sidebar-logo fs-2 font-weight-bold mb-1">MS <span style="color:var(--clr-gold);">Horizon</span></div>
        <p class="text-muted small">Access your Portal or Admin Account</p>
      </div>

      <form action="<?= APP_URL ?>/login" method="POST">
        <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">

        <div class="form-group mb-3">
          <label class="small text-uppercase text-muted">Email Address</label>
          <input type="email" name="email" class="form-control bg-dark text-white border-secondary" placeholder="admin@mshorizontravel.com" value="admin@mshorizontravel.com" required>
        </div>

        <div class="form-group mb-4">
          <label class="small text-uppercase text-muted">Password</label>
          <input type="password" name="password" class="form-control bg-dark text-white border-secondary" placeholder="••••••••" value="AdminPass2026!" required>
        </div>

        <button type="submit" class="btn btn-primary w-100 justify-content-center btn-lg mb-3">
          <i class="fas fa-sign-in-alt me-2"></i> Sign In
        </button>
      </form>

      <div class="p-3 bg-dark rounded-3 text-start small border border-secondary mt-3">
        <strong class="text-warning">Default Admin Demo Credentials:</strong><br>
        Email: <code>admin@mshorizontravel.com</code><br>
        Password: <code>AdminPass2026!</code>
      </div>

      <div class="text-center mt-4 small text-muted">
        Are you a candidate? <a href="<?= APP_URL ?>/candidate/register" class="text-warning">Register Profile</a> | 
        <a href="<?= APP_URL ?>/employer/register" class="text-warning">Employer Portal</a>
      </div>
    </div>
  </div>
</section>
