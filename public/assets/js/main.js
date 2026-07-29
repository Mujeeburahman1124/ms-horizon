/**
 * MS HORIZON GROUP — Main JavaScript Module v2.0
 * Mobile-first nav, theme, counters, scroll reveal, SweetAlert2, AJAX forms
 */
(function () {
  'use strict';

  // ─── Page Loader ──────────────────────────────────────────────
  function hideLoader() {
    const loader = document.getElementById('page-loader');
    if (loader && !loader.classList.contains('loaded')) {
      loader.classList.add('loaded');
      setTimeout(() => { if (loader) loader.style.display = 'none'; }, 350);
    }
  }
  if (document.readyState === 'complete' || document.readyState === 'interactive') {
    setTimeout(hideLoader, 250);
  } else {
    window.addEventListener('DOMContentLoaded', () => setTimeout(hideLoader, 250));
    window.addEventListener('load', hideLoader);
  }
  setTimeout(hideLoader, 900);

  // ─── Theme Toggle ──────────────────────────────────────────────
  const savedTheme = localStorage.getItem('msh-theme') || 'light';
  document.documentElement.setAttribute('data-theme', savedTheme);

  function updateThemeIcon(btn, theme) {
    btn.innerHTML = theme === 'dark'
      ? '<i class="fas fa-sun"></i>'
      : '<i class="fas fa-moon"></i>';
    btn.title = theme === 'dark' ? 'Switch to Light Mode' : 'Switch to Dark Mode';
  }

  document.querySelectorAll('.btn-theme-toggle').forEach(btn => {
    updateThemeIcon(btn, savedTheme);
    btn.addEventListener('click', () => {
      const current = document.documentElement.getAttribute('data-theme');
      const next = current === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', next);
      localStorage.setItem('msh-theme', next);
      updateThemeIcon(btn, next);
    });
  });

  // ─── Sticky Navbar ────────────────────────────────────────────
  const navbar = document.querySelector('.navbar-msh');
  if (navbar) {
    const onScroll = () => navbar.classList.toggle('scrolled', window.scrollY > 50);
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  // ─── Mobile Hamburger + Overlay ───────────────────────────────
  const hamburger = document.getElementById('hamburgerBtn');
  const navLinks  = document.getElementById('navLinks');

  // Create mobile overlay element
  let overlay = document.getElementById('mobileNavOverlay');
  if (!overlay) {
    overlay = document.createElement('div');
    overlay.id = 'mobileNavOverlay';
    document.body.appendChild(overlay);
  }

  function openMobileNav() {
    navLinks.classList.add('mobile-open');
    hamburger.classList.add('active');
    hamburger.setAttribute('aria-expanded', 'true');
    overlay.style.display = 'block';
    requestAnimationFrame(() => overlay.classList.add('visible'));
    document.body.style.overflow = 'hidden';
  }

  function closeMobileNav() {
    navLinks.classList.remove('mobile-open');
    hamburger.classList.remove('active');
    hamburger.setAttribute('aria-expanded', 'false');
    overlay.classList.remove('visible');
    setTimeout(() => { overlay.style.display = 'none'; }, 300);
    document.body.style.overflow = '';
    // Close any open mega menus
    document.querySelectorAll('.nav-item.open').forEach(i => i.classList.remove('open'));
  }

  if (hamburger && navLinks) {
    hamburger.addEventListener('click', () => {
      if (navLinks.classList.contains('mobile-open')) {
        closeMobileNav();
      } else {
        openMobileNav();
      }
    });

    // Mobile mega-menu accordion toggle
    document.querySelectorAll('.nav-item').forEach(item => {
      const btn  = item.querySelector('.nav-link-btn');
      const mega = item.querySelector('.mega-menu');
      if (btn && mega) {
        btn.addEventListener('click', (e) => {
          if (window.innerWidth <= 768) {
            e.preventDefault();
            const isOpen = item.classList.toggle('open');
            // Rotate chevron
            const chevron = btn.querySelector('.chevron');
            if (chevron) chevron.style.transform = isOpen ? 'rotate(180deg)' : '';
          }
        });
      }
    });

    // Close on overlay click
    overlay.addEventListener('click', closeMobileNav);

    // Close on escape key
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && navLinks.classList.contains('mobile-open')) closeMobileNav();
    });

    // Close nav on nav link click (non-dropdown links)
    navLinks.querySelectorAll('a.nav-link-btn').forEach(link => {
      link.addEventListener('click', () => {
        if (window.innerWidth <= 768) closeMobileNav();
      });
    });

    // Close nav on mega menu link click (mobile)
    navLinks.querySelectorAll('.mega-card').forEach(card => {
      card.addEventListener('click', () => {
        if (window.innerWidth <= 768) closeMobileNav();
      });
    });
  }

  // Close desktop mega menu on outside click
  document.addEventListener('click', (e) => {
    if (navbar && !navbar.contains(e.target)) {
      document.querySelectorAll('.nav-item.open').forEach(i => i.classList.remove('open'));
    }
  });

  // ─── Back-to-Top ──────────────────────────────────────────────
  const backTop = document.querySelector('.back-to-top');
  if (backTop) {
    window.addEventListener('scroll', () => {
      backTop.classList.toggle('visible', window.scrollY > 400);
    }, { passive: true });
    backTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
  }

  // ─── Animated Counter ─────────────────────────────────────────
  function animateCounter(el) {
    const target   = parseInt(el.dataset.target || el.textContent, 10);
    if (isNaN(target)) return;
    const suffix   = el.dataset.suffix || '';
    const duration = parseInt(el.dataset.duration || 2000, 10);
    const start    = performance.now();
    const ease     = (t) => t < 0.5 ? 2*t*t : -1+(4-2*t)*t;
    const step = (now) => {
      const progress = Math.min((now - start) / duration, 1);
      el.textContent = Math.round(ease(progress) * target).toLocaleString() + suffix;
      if (progress < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  }

  // ─── Intersection Observer ────────────────────────────────────
  const observerOpts = { threshold: 0.12, rootMargin: '0px 0px -50px 0px' };

  const scrollObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animated');
        scrollObserver.unobserve(entry.target);
      }
    });
  }, observerOpts);

  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounter(entry.target);
        counterObserver.unobserve(entry.target);
      }
    });
  }, observerOpts);

  document.querySelectorAll('.animate-on-scroll').forEach(el => scrollObserver.observe(el));
  document.querySelectorAll('[data-counter]').forEach(el => counterObserver.observe(el));

  // Staggered card animations
  document.querySelectorAll('.division-grid, .offers-grid, .country-grid, .why-grid, .kpi-grid, .stats-grid').forEach(grid => {
    const cards = grid.querySelectorAll(':scope > *');
    cards.forEach((card, i) => {
      card.style.transitionDelay = `${i * 70}ms`;
      card.classList.add('animate-on-scroll');
      scrollObserver.observe(card);
    });
  });

  // ─── SweetAlert2 Toast Notification System ────────────────────
  window.showToast = function (message, type = 'success', duration = 5000) {
    if (typeof Swal !== 'undefined') {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: duration,
        timerProgressBar: true,
        background: '#0F172A',
        color: '#FFFFFF',
        customClass: { popup: 'animated fadeInDown' },
        didOpen: (t) => {
          t.addEventListener('mouseenter', Swal.stopTimer);
          t.addEventListener('mouseleave', Swal.resumeTimer);
        }
      });
      Toast.fire({ icon: type, title: message });
      return;
    }

    // DOM Fallback
    let container = document.querySelector('.toast-container');
    if (!container) {
      container = document.createElement('div');
      container.className = 'toast-container';
      document.body.appendChild(container);
    }
    const icons = { success: 'fa-check-circle', error: 'fa-times-circle', info: 'fa-info-circle', warning: 'fa-exclamation-triangle' };
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
      <i class="fas ${icons[type] || icons.info} toast-icon"></i>
      <div class="toast-message">${message}</div>
      <button class="toast-close" aria-label="Close">×</button>
    `;
    container.appendChild(toast);
    toast.querySelector('.toast-close').addEventListener('click', () => dismissToast(toast));
    setTimeout(() => dismissToast(toast), duration);
  };

  function dismissToast(toast) {
    toast.classList.add('fade-out');
    toast.addEventListener('animationend', () => toast.remove(), { once: true });
  }

  // ─── SweetAlert2 Confirm Dialog ───────────────────────────────
  window.showConfirm = function(message, onConfirm, title = 'Are you sure?') {
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        title: title,
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#D4AF37',
        cancelButtonColor: '#64748B',
        confirmButtonText: 'Yes, proceed',
        background: '#0F172A',
        color: '#FFFFFF',
      }).then((result) => {
        if (result.isConfirmed) onConfirm();
      });
    } else {
      if (window.confirm(message)) onConfirm();
    }
  };

  // ─── AJAX Form Handler ────────────────────────────────────────
  document.querySelectorAll('form[data-ajax="true"]').forEach(form => {
    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      const btn = form.querySelector('[type="submit"]');
      const originalText = btn ? btn.innerHTML : '';
      if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
      }

      // Clear previous errors
      form.querySelectorAll('.form-error').forEach(el => el.remove());
      form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

      try {
        const formData = new FormData(form);
        const response = await fetch(form.action || window.location.href, {
          method: 'POST',
          body: formData,
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        let data;
        const contentType = response.headers.get('content-type') || '';
        if (contentType.includes('application/json')) {
          data = await response.json();
        } else {
          const text = await response.text();
          try { data = JSON.parse(text); } catch {
            data = { status: 'error', message: 'Unexpected server response. Please try again.' };
          }
        }

        if (data.status === 'success') {
          window.showToast(data.message || 'Done!', 'success');
          if (data.redirect) {
            form.dataset.redirecting = '1';
            setTimeout(() => { window.location.href = data.redirect; }, 1200);
            return;
          }
          if (form.dataset.resetOnSuccess !== 'false') form.reset();
          if (form.dataset.reloadOnSuccess === 'true') setTimeout(() => location.reload(), 1500);
        } else {
          window.showToast(data.message || 'Please correct the highlighted fields.', 'error');
          if (data.errors) {
            Object.entries(data.errors).forEach(([field, errs]) => {
              const input = form.querySelector(`[name="${field}"]`);
              if (input) {
                input.classList.add('is-invalid');
                const errorEl = document.createElement('div');
                errorEl.className = 'form-error';
                errorEl.textContent = Array.isArray(errs) ? errs[0] : errs;
                input.parentNode.appendChild(errorEl);
                input.focus();
              }
            });
          }
        }
      } catch (err) {
        window.showToast('A network error occurred. Please check your connection and try again.', 'error');
      } finally {
        if (btn && !form.dataset.redirecting) {
          btn.disabled = false;
          btn.innerHTML = originalText;
        }
      }
    });
  });

  // ─── Flash Message Auto-Display ───────────────────────────────
  const flashEl = document.querySelector('[data-flash-type]');
  if (flashEl && flashEl.dataset.flashMessage) {
    setTimeout(() => {
      window.showToast(flashEl.dataset.flashMessage, flashEl.dataset.flashType || 'info');
    }, 400);
  }

  // ─── Active Nav Link Highlight ────────────────────────────────
  const currentPath = window.location.pathname;
  document.querySelectorAll('.nav-link-btn[href]').forEach(link => {
    const linkPath = new URL(link.href, window.location.origin).pathname;
    if (linkPath !== '/' && currentPath.startsWith(linkPath)) {
      link.classList.add('active-nav');
      link.style.color = 'var(--clr-gold)';
    }
  });

})();
