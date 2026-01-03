(function () {
  'use strict';

  const CONFIG = {
    TOUCH_DEVICE: 'ontouchstart' in window || navigator.maxTouchPoints > 0,
    REDUCED_MOTION: window.matchMedia('(prefers-reduced-motion: reduce)').matches
  };

  // Format number with commas
  function formatNumber(n) {
    return n.toLocaleString();
  }

  // Animate numeric counter from 0 to target
  function animateNumber(el, target, duration = 1500) {
    if (!el) return;
    if (CONFIG.REDUCED_MOTION) {
      el.textContent = formatNumber(target);
      return;
    }

    const start = 0;
    const range = target - start;
    const startTime = performance.now();

    function step(now) {
      const progress = Math.min((now - startTime) / duration, 1);
      const value = Math.floor(start + range * progress);
      el.textContent = formatNumber(value);
      if (progress < 1) requestAnimationFrame(step);
      else el.textContent = formatNumber(target);
    }

    requestAnimationFrame(step);
  }

  // IntersectionObserver to animate when visible
  function initializeStatCounters(root = document) {
    const stats = root.querySelectorAll('.stat-number[data-target]');
    if (!stats.length) return;

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const el = entry.target;
          const target = parseInt(el.dataset.target || el.getAttribute('data-target') || 0, 10) || 0;
          animateNumber(el, target);
          obs.unobserve(el);
        }
      });
    }, { threshold: 0.5, rootMargin: '0px 0px -40px 0px' });

    stats.forEach(s => observer.observe(s));
  }

  // Smooth scroll anchors
  function initializeSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        const hash = this.getAttribute('href');
        if (!hash || hash === '#') return;
        const target = document.querySelector(hash);
        if (!target) return;
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    });
  }

  // Scroll progress bar
  function initializeScrollProgress() {
    const contentHeight = document.documentElement.scrollHeight;
    const viewportHeight = window.innerHeight;
    if (contentHeight < viewportHeight * 2) return;

    let progress = document.getElementById('scroll-progress');
    if (!progress) {
      progress = document.createElement('div');
      progress.id = 'scroll-progress';
      document.body.appendChild(progress);
    }

    // Scroll to top button
    let scrollTopBtn = document.getElementById('scroll-to-top');
    if (!scrollTopBtn) {
      scrollTopBtn = document.createElement('button');
      scrollTopBtn.id = 'scroll-to-top';
      scrollTopBtn.innerHTML = '<i class="fa-solid fa-chevron-up"></i>';
      scrollTopBtn.setAttribute('aria-label', 'Scroll to top');
      document.body.appendChild(scrollTopBtn);

      scrollTopBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
      });
    }

    function update() {
      const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
      const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      const scrolled = (winScroll / height) * 100;
      
      if (progress) {
        progress.style.width = Math.min(scrolled, 100) + '%';
      }

      if (scrollTopBtn) {
        if (winScroll > 300) {
          scrollTopBtn.classList.add('visible');
        } else {
          scrollTopBtn.classList.remove('visible');
        }
      }
    }

    window.addEventListener('scroll', update, { passive: true });
    update();
  }

  // Parallax initializer - supports hero titles, layered parallax via data-parallax-speed,
  // and optional pointer-based parallax via data-parallax-pointer
  function initializeParallax() {
    if (CONFIG.TOUCH_DEVICE || CONFIG.REDUCED_MOTION) return;

    // Original hero title parallax (kept for backwards compatibility)
    const heroes = document.querySelectorAll('.hero-section .hero-title, .gamedev-hero .hero-title');

    function updateHero() {
      const scrolled = window.scrollY;
      heroes.forEach(h => {
        const rect = h.getBoundingClientRect();
        const offset = (window.scrollY + rect.top) * 0.15;
        h.style.transform = `translateY(${offset * -0.015}px)`; // subtle
      });
    }

    // Layered parallax - elements with data-parallax-speed attribute
    const layers = document.querySelectorAll('[data-parallax-speed], .parallax-layer, .parallax-element');

    function updateLayers() {
      const scrollY = window.scrollY;
      layers.forEach(el => {
        const speed = parseFloat(el.dataset.parallaxSpeed || el.getAttribute('data-parallax-speed') || el.dataset.speed || 0.08);
        // Compute a translateY based on element position and speed
        const rect = el.getBoundingClientRect();
        const base = (rect.top + scrollY);
        const y = (scrollY - base) * speed;
        el.style.transform = `translateY(${y}px)`;
      });
    }

    // Pointer-driven parallax for elements with data-parallax-pointer
    const pointerTargets = document.querySelectorAll('[data-parallax-pointer], .parallax-pointer');
    function onPointerMove(e) {
      pointerTargets.forEach(el => {
        const rect = el.getBoundingClientRect();
        const cx = rect.left + rect.width / 2;
        const cy = rect.top + rect.height / 2;
        const dx = (e.clientX - cx) / Math.max(rect.width, 200);
        const dy = (e.clientY - cy) / Math.max(rect.height, 200);
        const strength = parseFloat(el.dataset.parallaxPointer || 8);
        el.style.transform = `translate3d(${dx * strength}px, ${dy * strength}px, 0) rotate(${dx * strength * 0.2}deg)`;
      });
    }

    // Only add scroll listeners if we found anything
    if (heroes.length || layers.length) {
      const onScroll = () => { updateHero(); updateLayers(); };
      window.addEventListener('scroll', onScroll, { passive: true });
      onScroll();
    }

    if (pointerTargets.length && !CONFIG.TOUCH_DEVICE) {
      window.addEventListener('pointermove', onPointerMove);
      // Reset transforms on leave
      window.addEventListener('pointerleave', () => pointerTargets.forEach(el => el.style.transform = ''));
    }
  }

  // 3D card tilt (desktop only)
  function initializeCardTilt() {
    if (CONFIG.TOUCH_DEVICE || CONFIG.REDUCED_MOTION) return;
    const cards = document.querySelectorAll('.hover-lift, [data-tilt]');
    if (!cards.length) return;

    cards.forEach(card => {
      // Ensure card is focusable for accessibility if it's not a link
      if (card.tagName !== 'A' && !card.querySelector('a')) {
        card.setAttribute('tabindex', '0');
      }

      card.addEventListener('mousemove', e => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const cx = rect.width / 2;
        const cy = rect.height / 2;
        const dx = (x - cx) / cx; // -1..1
        const dy = (y - cy) / cy;
        const tiltX = (dy * 8).toFixed(2);
        const tiltY = (dx * -8).toFixed(2);
        
        // Apply tilt and dynamic glow based on mouse position
        card.style.transform = `perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) scale3d(1.02, 1.02, 1.02)`;
        
        // Dynamic glow effect using CSS variables
        const glowX = (x / rect.width) * 100;
        const glowY = (y / rect.height) * 100;
        card.style.setProperty('--glow-x', `${glowX}%`);
        card.style.setProperty('--glow-y', `${glowY}%`);
        card.classList.add('is-tilting');
      });

      card.addEventListener('mouseleave', () => {
        card.style.transform = '';
        card.classList.remove('is-tilting');
      });

      // Keyboard accessibility
      card.addEventListener('focus', () => {
        card.style.transform = 'perspective(1000px) rotateX(-5deg) rotateY(0deg) scale3d(1.05, 1.05, 1.05)';
      });

      card.addEventListener('blur', () => {
        card.style.transform = '';
      });
    });
  }

  // Scroll Reveal Effect
  function initializeScrollReveal() {
    if (CONFIG.REDUCED_MOTION) return;
    
    const revealElements = document.querySelectorAll('.reveal-on-scroll, .reveal-up, .reveal-left, .reveal-right');
    if (!revealElements.length) return;

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('revealed');
          // Optional: stop observing after reveal
          // observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

    revealElements.forEach(el => observer.observe(el));
  }

  // Toast
  function mgShowToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `mg-toast toast-${type}`;
    toast.innerHTML = `
      <div class="toast-content">
        <i class="fa-solid ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} me-2"></i>
        <span>${message}</span>
      </div>
    `;
    document.body.appendChild(toast);
    // Use CSS class for show animation
    requestAnimationFrame(() => toast.classList.add('show'));
    setTimeout(() => { 
      toast.classList.remove('show'); 
      setTimeout(() => toast.remove(), 400); 
    }, 3500);
  }

  // Copy to clipboard buttons
  function initializeCopyButtons() {
    document.querySelectorAll('[data-copy]').forEach(btn => {
      btn.addEventListener('click', async (e) => {
        e.preventDefault();
        const text = btn.getAttribute('data-copy');
        if (!text) return;
        
        try {
          await navigator.clipboard.writeText(text);
          mgShowToast('Copied to clipboard!', 'success');
          
          // Visual feedback on button
          const originalHtml = btn.innerHTML;
          const successIcon = btn.dataset.copySuccessIcon || 'fa-check';
          btn.innerHTML = `<i class="fa-solid ${successIcon}"></i>`;
          btn.classList.add('copy-success');
          
          setTimeout(() => {
            btn.innerHTML = originalHtml;
            btn.classList.remove('copy-success');
          }, 2000);
        } catch (err) {
          console.error('Failed to copy:', err);
          mgShowToast('Failed to copy', 'error');
        }
      });
    });

    // Add toast for download links
    document.querySelectorAll('a[download]').forEach(link => {
      link.addEventListener('click', () => {
        const fileName = link.getAttribute('download') || link.href.split('/').pop();
        mgShowToast(`Downloading ${fileName}...`, 'info');
      });
    });
  }

  window.mgShowToast = mgShowToast;

  // Init
  function init() {
    initializeStatCounters();
    initializeSmoothScroll();
    initializeScrollProgress();
    initializeParallax();
    initializeCardTilt();
    initializeCopyButtons();
    initializeScrollReveal();
  }

  // Expose helper to re-run initializers if content is loaded dynamically
  window.mgInitUiEffects = function() {
    const root = document;
    initializeStatCounters(root);
    initializeParallax();
    initializeCardTilt();
    initializeCopyButtons();
    initializeScrollReveal();
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else init();

}());