<!-- ─── PREMIUM LOGIN PAGE ─────────────────────────────────────── -->
<style>
body { background: var(--grad-brand) !important; min-height: 100vh; }
.login-page-wrapper {
  min-height: 100vh;
  display: flex; align-items: center; justify-content: center;
  padding: calc(var(--navbar-h) + 2rem) 1.25rem 2rem;
  background:
    radial-gradient(circle at 20% 50%, rgba(212,175,55,.07) 0%, transparent 50%),
    radial-gradient(circle at 80% 20%, rgba(0,184,148,.05) 0%, transparent 45%),
    radial-gradient(circle at 60% 80%, rgba(41,128,185,.05) 0%, transparent 40%);
}
.login-card {
  width: 100%; max-width: 460px;
  background: rgba(17,34,64,.85);
  backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);
  border: 1px solid rgba(212,175,55,.2);
  border-radius: 24px;
  padding: 2.5rem 2.25rem;
  box-shadow: 0 24px 64px rgba(0,0,0,.45), 0 0 0 1px rgba(212,175,55,.08);
  animation: fadeInUp .5s var(--ease-smooth) both;
}
@keyframes fadeInUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
.login-brand { text-align: center; margin-bottom: 2rem; }
.login-brand-name { font-family: var(--font-primary); font-size: 2rem; font-weight: 900; color: white; line-height: 1; }
.login-brand-name span { color: var(--clr-gold); }
.login-brand-sub { font-size: .72rem; color: rgba(255,255,255,.4); text-transform: uppercase; letter-spacing: 2px; margin-top: .375rem; }
.login-divider { display: flex; align-items: center; gap: 1rem; margin: 1.5rem 0; }
.login-divider hr { flex: 1; border: none; border-top: 1px solid rgba(255,255,255,.08); }
.login-divider span { font-size: .72rem; color: rgba(255,255,255,.35); text-transform: uppercase; letter-spacing: 1px; }
.login-title { font-family: var(--font-primary); font-size: 1.35rem; font-weight: 700; color: white; margin-bottom: .35rem; text-align: center; }
.login-subtitle { font-size: .82rem; color: rgba(255,255,255,.45); text-align: center; margin-bottom: 1.75rem; }

/* Login form fields */
.lf-group { margin-bottom: 1.125rem; position: relative; }
.lf-group label { display: block; font-size: .72rem; font-weight: 600; color: rgba(255,255,255,.55); text-transform: uppercase; letter-spacing: .8px; margin-bottom: .4rem; }
.lf-group .lf-input-wrap { position: relative; }
.lf-group .lf-icon { position: absolute; left: .95rem; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,.3); font-size: .875rem; pointer-events: none; z-index: 1; }
.lf-input {
  width: 100%; padding: .8rem 1rem .8rem 2.75rem;
  background: rgba(255,255,255,.07); border: 1.5px solid rgba(255,255,255,.12);
  border-radius: var(--radius-sm); color: white;
  font-family: var(--font-body); font-size: .9rem; outline: none;
  transition: border-color .2s, background .2s;
}
.lf-input::placeholder { color: rgba(255,255,255,.25); }
.lf-input:focus { border-color: var(--clr-gold); background: rgba(212,175,55,.07); }
.lf-input:focus + .lf-icon,
.lf-group .lf-input-wrap:focus-within .lf-icon { color: var(--clr-gold); }
.lf-toggle-pw { position: absolute; right: .95rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: rgba(255,255,255,.3); cursor: pointer; font-size: .875rem; transition: color .2s; padding: 0; }
.lf-toggle-pw:hover { color: var(--clr-gold); }

/* Validation feedback */
.lf-error { font-size: .72rem; color: #fc8181; margin-top: .3rem; display: none; }
.lf-group.has-error .lf-input { border-color: #fc8181; }
.lf-group.has-error .lf-error { display: block; }

/* Submit button */
.login-btn {
  width: 100%; padding: .95rem;
  background: var(--grad-gold); color: var(--clr-navy);
  border: none; border-radius: var(--radius-xl); font-family: var(--font-primary);
  font-size: 1rem; font-weight: 700; cursor: pointer;
  transition: all .2s; display: flex; align-items: center; justify-content: center; gap: .5rem;
  box-shadow: 0 8px 24px rgba(212,175,55,.35); margin-top: 1.75rem;
}
.login-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 36px rgba(212,175,55,.5); }
.login-btn:active { transform: translateY(0); }
.login-btn:disabled { opacity: .65; cursor: not-allowed; transform: none; }

.login-footer-links { display: flex; justify-content: space-between; align-items: center; margin-top: 1.25rem; font-size: .8rem; flex-wrap: wrap; gap: .5rem; }
.login-footer-links a { color: rgba(255,255,255,.5); transition: color .2s; }
.login-footer-links a:hover { color: var(--clr-gold); }
.login-register-row { text-align: center; margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid rgba(255,255,255,.07); font-size: .82rem; color: rgba(255,255,255,.45); }
.login-register-row a { color: var(--clr-gold); font-weight: 600; }
.login-register-row a:hover { color: var(--clr-gold-light); }

/* Login info badge */
.login-role-badges { display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: 1.5rem; justify-content: center; }
.role-badge { display: inline-flex; align-items: center; gap: .35rem; padding: .25rem .7rem; border-radius: 20px; font-size: .67rem; font-weight: 600; letter-spacing: .5px; text-transform: uppercase; }
.role-badge.admin  { background: rgba(212,175,55,.15); color: var(--clr-gold); border: 1px solid rgba(212,175,55,.25); }
.role-badge.staff  { background: rgba(0,184,148,.12); color: var(--clr-emerald); border: 1px solid rgba(0,184,148,.2); }
.role-badge.cand   { background: rgba(41,128,185,.12); color: #60a5fa; border: 1px solid rgba(41,128,185,.2); }

@media (max-width: 480px) {
  .login-card { padding: 2rem 1.5rem; }
  .login-brand-name { font-size: 1.7rem; }
}
</style>

<div class="login-page-wrapper">
  <div class="login-card">

    <!-- Brand -->
    <div class="login-brand">
      <div class="login-brand-name">MS <span>Horizon</span></div>
      <div class="login-brand-sub">Group of Companies — Enterprise Portal</div>
    </div>

    <!-- Role Badges -->
    <div class="login-role-badges">
      <span class="role-badge admin"><i class="fas fa-shield-halved"></i> Admin</span>
      <span class="role-badge staff"><i class="fas fa-users-gear"></i> Staff</span>
      <span class="role-badge cand"><i class="fas fa-user-tie"></i> Candidate</span>
    </div>

    <div class="login-title">Welcome Back</div>
    <div class="login-subtitle">Sign in to access your portal</div>

    <?php
      $flash_error = \App\Core\Session::getFlash('error');
      $flash_success = \App\Core\Session::getFlash('success');
    ?>
    <?php if ($flash_error): ?>
    <div style="background:rgba(231,76,60,.15);border:1px solid rgba(231,76,60,.3);border-radius:10px;padding:.875rem 1rem;margin-bottom:1.25rem;font-size:.83rem;color:#fc8181;display:flex;gap:.625rem;align-items:flex-start;">
      <i class="fas fa-exclamation-circle" style="margin-top:.1rem;flex-shrink:0;"></i>
      <span><?= htmlspecialchars($flash_error, ENT_QUOTES, 'UTF-8') ?></span>
    </div>
    <?php endif; ?>
    <?php if ($flash_success): ?>
    <div style="background:rgba(0,184,148,.12);border:1px solid rgba(0,184,148,.25);border-radius:10px;padding:.875rem 1rem;margin-bottom:1.25rem;font-size:.83rem;color:#6ee7b7;display:flex;gap:.625rem;align-items:flex-start;">
      <i class="fas fa-check-circle" style="margin-top:.1rem;flex-shrink:0;"></i>
      <span><?= htmlspecialchars($flash_success, ENT_QUOTES, 'UTF-8') ?></span>
    </div>
    <?php endif; ?>

    <form id="loginForm" data-ajax="true" action="<?= APP_URL ?>/login" method="POST" autocomplete="on">
      <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= $csrf_token ?>">

      <div class="lf-group" id="emailGroup">
        <label for="login_email">Email Address</label>
        <div class="lf-input-wrap">
          <i class="fas fa-envelope lf-icon"></i>
          <input type="email" id="login_email" name="email" class="lf-input"
            placeholder="you@example.com" required autocomplete="email"
            inputmode="email">
        </div>
        <div class="lf-error" id="emailError">Please enter a valid email address.</div>
      </div>

      <div class="lf-group" id="passwordGroup">
        <label for="login_password">Password</label>
        <div class="lf-input-wrap">
          <i class="fas fa-lock lf-icon"></i>
          <input type="password" id="login_password" name="password" class="lf-input"
            placeholder="••••••••" required autocomplete="current-password">
          <button type="button" class="lf-toggle-pw" id="togglePw" aria-label="Toggle password visibility">
            <i class="fas fa-eye" id="togglePwIcon"></i>
          </button>
        </div>
        <div class="lf-error" id="passwordError">Password must be at least 6 characters.</div>
      </div>

      <button type="submit" class="login-btn" id="loginSubmitBtn">
        <i class="fas fa-sign-in-alt"></i> Sign In to Portal
      </button>
    </form>

    <div class="login-footer-links">
      <a href="<?= APP_URL ?>/forgot-password"><i class="fas fa-key fa-xs me-1"></i>Forgot Password?</a>
      <a href="<?= APP_URL ?>/"><i class="fas fa-home fa-xs me-1"></i>Back to Website</a>
    </div>

    <div class="login-register-row">
      New candidate? <a href="<?= APP_URL ?>/candidate/register">Create your profile →</a>
    </div>

  </div>
</div>

<?php $extra_scripts = <<<'JS'
<script>
(function() {
  // Password toggle
  var toggleBtn  = document.getElementById('togglePw');
  var pwInput    = document.getElementById('login_password');
  var toggleIcon = document.getElementById('togglePwIcon');
  if (toggleBtn && pwInput) {
    toggleBtn.addEventListener('click', function() {
      var isHidden = pwInput.type === 'password';
      pwInput.type = isHidden ? 'text' : 'password';
      toggleIcon.className = isHidden ? 'fas fa-eye-slash' : 'fas fa-eye';
    });
  }

  // Override AJAX form for login specifically
  var form = document.getElementById('loginForm');
  if (form) {
    form.addEventListener('submit', async function(e) {
      e.preventDefault();
      var btn = document.getElementById('loginSubmitBtn');
      var orig = btn.innerHTML;
      btn.disabled = true;
      btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Signing in...';

      try {
        var fd = new FormData(form);
        var resp = await fetch(form.action, {
          method: 'POST', body: fd,
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        var data = await resp.json();
        if (data.status === 'success') {
          if (typeof showToast === 'function') showToast(data.message || 'Login successful!', 'success');
          btn.innerHTML = '<i class="fas fa-check"></i> Redirecting...';
          setTimeout(function() { window.location.href = data.redirect || '/admin/dashboard'; }, 900);
        } else {
          if (typeof showToast === 'function') showToast(data.message || 'Login failed.', 'error');
          btn.disabled = false;
          btn.innerHTML = orig;
          // Shake animation
          form.style.animation = 'none';
          requestAnimationFrame(function() {
            form.style.animation = 'shake .4s ease';
          });
        }
      } catch(err) {
        if (typeof showToast === 'function') showToast('Network error. Please try again.', 'error');
        btn.disabled = false;
        btn.innerHTML = orig;
      }
    }, true);
  }
})();
</script>
<style>
@keyframes shake {
  0%,100%{transform:translateX(0)}20%,60%{transform:translateX(-6px)}40%,80%{transform:translateX(6px)}
}
</style>
JS; ?>
