/**
 * MS HORIZON GROUP — Main JavaScript Module
 * Sticky navbar, mega menu, dark mode, counters, spotlight effects, micro-interactions, SweetAlert2 notifications
 */
(function () {
  'use strict';

  // ─── Page Loader (Guaranteed Instant Dismissal) ───────────────
  function hideLoader() {
    const loader = document.getElementById('page-loader');
    if (loader && !loader.classList.contains('loaded')) {
      loader.classList.add('loaded');
    }
  }

  if (document.readyState === 'complete' || document.readyState === 'interactive') {
    setTimeout(hideLoader, 200);
  } else {
    window.addEventListener('DOMContentLoaded', () => setTimeout(hideLoader, 200));
    window.addEventListener('load', () => setTimeout(hideLoader, 200));
  }
  setTimeout(hideLoader, 600);

  // ─── Theme Toggle (Dark / Light) ──────────────────────────────
  const savedTheme = localStorage.getItem('msh-theme') || 'light';
  document.documentElement.setAttribute('data-theme', savedTheme);

  document.querySelectorAll('.btn-theme-toggle').forEach(btn => {
    btn.addEventListener('click', () => {
      const current = document.documentElement.getAttribute('data-theme');
      const next = current === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', next);
      localStorage.setItem('msh-theme', next);
      btn.innerHTML = next === 'dark'
        ? '<i class="fas fa-sun"></i>'
        : '<i class="fas fa-moon"></i>';
    });
  });

  // ─── Sticky Navbar ────────────────────────────────────────────
  const navbar = document.querySelector('.navbar-msh');
  if (navbar) {
    window.addEventListener('scroll', () => {
      navbar.classList.toggle('scrolled', window.scrollY > 40);
    }, { passive: true });
  }

  // ─── Mobile Hamburger Menu & Offcanvas Drawer ─────────────────
  const hamburger = document.querySelector('.nav-hamburger');
  const navLinks = document.querySelector('.nav-links');
  if (hamburger && navLinks) {
    hamburger.addEventListener('click', () => {
      navLinks.classList.toggle('mobile-open');
      const isOpen = navLinks.classList.contains('mobile-open');
      hamburger.setAttribute('aria-expanded', isOpen);
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    // Mobile mega-menu accordion
    document.querySelectorAll('.nav-item').forEach(item => {
      const link = item.querySelector('.nav-link-btn');
      if (link && item.querySelector('.mega-menu')) {
        link.addEventListener('click', (e) => {
          if (window.innerWidth <= 991) {
            e.preventDefault();
            item.classList.toggle('open');
          }
        });
      }
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
      if (navbar && !navbar.contains(e.target)) {
        navLinks.classList.remove('mobile-open');
        document.body.style.overflow = '';
      }
    });
  }

  // ─── Mouse Spotlight / Card Tilt Interactive Magnet ───────────
  document.querySelectorAll('.spotlight-card, .division-card, .country-card, .offer-card').forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      card.style.setProperty('--mouse-x', `${x}px`);
      card.style.setProperty('--mouse-y', `${y}px`);
    });
  });

  // ─── Back-to-Top Button ───────────────────────────────────────
  const backTop = document.querySelector('.back-to-top');
  if (backTop) {
    window.addEventListener('scroll', () => {
      backTop.classList.toggle('visible', window.scrollY > 350);
    }, { passive: true });

    backTop.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  // ─── Animated Counter ─────────────────────────────────────────
  function animateCounter(el) {
    const target = parseInt(el.dataset.target || el.textContent, 10);
    const suffix = el.dataset.suffix || '';
    const duration = parseInt(el.dataset.duration || 2000, 10);
    const startTime = performance.now();

    const ease = (t) => t < 0.5 ? 2*t*t : -1+(4-2*t)*t;

    const step = (now) => {
      const elapsed = now - startTime;
      const progress = Math.min(elapsed / duration, 1);
      el.textContent = Math.round(ease(progress) * target).toLocaleString() + suffix;
      if (progress < 1) requestAnimationFrame(step);
    };

    requestAnimationFrame(step);
  }

  // ─── Intersection Observer (Scroll Reveal + Counters) ─────────
  const observerOptions = { threshold: 0.12, rootMargin: '0px 0px -40px 0px' };

  const scrollObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animated');
        scrollObserver.unobserve(entry.target);
      }
    });
  }, observerOptions);

  const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        animateCounter(entry.target);
        counterObserver.unobserve(entry.target);
      }
    });
  }, observerOptions);

  document.querySelectorAll('.animate-on-scroll').forEach(el => scrollObserver.observe(el));
  document.querySelectorAll('[data-counter]').forEach(el => counterObserver.observe(el));

  // ─── Staggered Card Animations ────────────────────────────────
  document.querySelectorAll('.division-grid, .offers-grid, .country-grid, .why-grid, .stats-grid, .process-timeline').forEach(grid => {
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
        background: '#040914',
        color: '#FFFFFF',
        customClass: { popup: 'animated fadeInDown' },
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer);
          toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
      });
      Toast.fire({
        icon: type,
        title: message
      });
      return;
    }

    // DOM Fallback
    let container = document.querySelector('.toast-container');
    if (!container) {
      container = document.createElement('div');
      container.className = 'toast-container';
      document.body.appendChild(container);
    }

    const icons = { success: 'fa-check-circle', error: 'fa-times-circle', info: 'fa-info-circle' };
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

        const data = await response.json();

        if (data.status === 'success') {
          showToast(data.message, 'success');
          if (data.redirect) {
            window.location.href = data.redirect;
            return;
          }
          form.reset();
        } else {
          showToast(data.message || 'Please correct the highlighted fields.', 'error');
          if (data.errors) {
            Object.entries(data.errors).forEach(([field, errs]) => {
              const input = form.querySelector(`[name="${field}"]`);
              if (input) {
                input.classList.add('is-invalid');
                const errorEl = document.createElement('div');
                errorEl.className = 'form-error text-danger small mt-1';
                errorEl.textContent = Array.isArray(errs) ? errs[0] : errs;
                input.parentNode.appendChild(errorEl);
              }
            });
          }
        }
      } catch (err) {
        showToast('An unexpected network error occurred. Please try again.', 'error');
      } finally {
        if (btn && !form.dataset.redirecting) {
          btn.disabled = false;
          btn.innerHTML = originalText;
        }
      }
    });
  });

})();
