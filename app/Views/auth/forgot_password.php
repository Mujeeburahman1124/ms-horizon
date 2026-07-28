<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<section class="section" style="padding-top:140px;background:var(--bg-body);min-height:80vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="glass-card p-4 p-md-5" style="border-radius:20px;border:1px solid rgba(212,175,55,.3);">
          <div class="text-center mb-4">
            <h1 class="h3 font-weight-bold" style="font-family:'Outfit',sans-serif;">Forgot <span style="color:#D4AF37;">Password</span></h1>
            <p class="text-muted small">Enter your email address to receive a real-time OTP recovery code.</p>
          </div>

          <form id="forgotPassForm" onsubmit="handleForgotPass(event)">
            <input type="hidden" name="<?= CSRF_TOKEN_NAME ?>" value="<?= \App\Core\Session::getCsrfToken() ?>">

            <!-- Step 1: Request OTP -->
            <div id="stepRequest">
              <div class="mb-3">
                <label class="form-label small text-muted font-weight-bold">REGISTERED EMAIL ADDRESS</label>
                <input type="email" id="forgot_email" class="form-control" placeholder="your@email.com" required>
              </div>
              <button type="button" onclick="sendResetOtp()" class="btn btn-primary w-100 py-2">
                <i class="fas fa-paper-plane me-2"></i> Send OTP Recovery Code
              </button>
            </div>

            <!-- Step 2: Verify & Reset -->
            <div id="stepReset" style="display:none;" class="mt-3">
              <div class="alert alert-info small">
                <i class="fas fa-info-circle me-1"></i> Check your email for the 6-digit OTP code.
              </div>
              <div class="mb-3">
                <label class="form-label small text-muted font-weight-bold">6-DIGIT OTP CODE</label>
                <input type="text" id="forgot_otp" class="form-control" placeholder="123456" maxlength="6" required>
              </div>
              <div class="mb-3">
                <label class="form-label small text-muted font-weight-bold">NEW PASSWORD</label>
                <input type="password" id="new_password" class="form-control" placeholder="Minimum 6 characters" required>
              </div>
              <button type="submit" class="btn btn-emerald w-100 py-2">
                <i class="fas fa-key me-2"></i> Reset Password & Sign In
              </button>
            </div>
          </form>

          <div class="text-center mt-4 pt-3 border-top">
            <a href="<?= APP_URL ?>/login" class="text-muted small"><i class="fas fa-arrow-left me-1"></i> Back to Login</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
async function sendResetOtp() {
  const email = document.getElementById('forgot_email').value;
  if(!email) { alert('Please enter your email address'); return; }
  
  try {
    const res = await fetch('<?= APP_URL ?>/auth/send-reset-otp', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'email=' + encodeURIComponent(email)
    });
    const data = await res.json();
    alert(data.message);
    if(data.status === 'success') {
      document.getElementById('stepRequest').style.display = 'none';
      document.getElementById('stepReset').style.display = 'block';
    }
  } catch(e) {
    alert('Failed to send OTP code. Please try again.');
  }
}

async function handleForgotPass(e) {
  e.preventDefault();
  const email = document.getElementById('forgot_email').value;
  const otp = document.getElementById('forgot_otp').value;
  const new_password = document.getElementById('new_password').value;

  try {
    const res = await fetch('<?= APP_URL ?>/auth/reset-password', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `email=${encodeURIComponent(email)}&otp=${encodeURIComponent(otp)}&new_password=${encodeURIComponent(new_password)}`
    });
    const data = await res.json();
    alert(data.message);
    if(data.status === 'success' && data.redirect) {
      window.location.href = data.redirect;
    }
  } catch(e) {
    alert('Failed to reset password. Please try again.');
  }
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
