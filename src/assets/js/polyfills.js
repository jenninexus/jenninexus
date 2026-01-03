/**
 * Polyfills and fallbacks for browsers with limited support
 * 
 * This file contains polyfills and fallbacks for various browser features
 * that might not be supported in all browsers, particularly older Safari versions.
 */

(function() {
  // CSS Feature Detection and Fallback Classes
  // =========================================
  const html = document.documentElement;
  
  // Test for CSS Variables support
  const supportsCssVars = (function() {
    try {
      const el = document.createElement('div');
      el.style.setProperty('--test-var', '0');
      return Boolean(el.style.getPropertyValue('--test-var') !== null);
    } catch (e) {
      return false;
    }
  })();
  
  if (!supportsCssVars) {
    html.classList.add('supports-no-cssvariables');
  }
  
  // Test for background-clip: text support
  const supportsBackgroundClip = (function() {
    try {
      const el = document.createElement('div');
      el.style.backgroundClip = 'text';
      return Boolean(el.style.backgroundClip === 'text');
    } catch (e) {
      return false;
    }
  })();
  
  if (!supportsBackgroundClip) {
    html.classList.add('supports-no-backgroundclip');
  }
  
  // Test for -webkit-background-clip: text support
  const supportsWebkitBackgroundClip = (function() {
    try {
      const el = document.createElement('div');
      el.style.webkitBackgroundClip = 'text';
      return Boolean(el.style.webkitBackgroundClip === 'text');
    } catch (e) {
      return false;
    }
  })();
  
  if (!supportsWebkitBackgroundClip) {
    html.classList.add('supports-no-webkitbackgroundclip');
  }
  
  // Test for CSS Animations support
  const supportsCssAnimations = (function() {
    try {
      return 'animation' in document.documentElement.style || 
             'webkitAnimation' in document.documentElement.style;
    } catch (e) {
      return false;
    }
  })();
  
  if (!supportsCssAnimations) {
    html.classList.add('supports-no-cssanimations');
  }
  
  // Test for CSS Filters support (used for glow/shadow effects)
  const supportsCssFilters = (function() {
    try {
      const el = document.createElement('div');
      el.style.filter = 'blur(2px)';
      return Boolean(el.style.filter);
    } catch (e) {
      return false;
    }
  })();
  
  if (!supportsCssFilters) {
    html.classList.add('supports-no-cssfilters');
  }
  
  // Test for backdrop-filter support
  const supportsBackdropFilter = (function() {
    try {
      const el = document.createElement('div');
      el.style.webkitBackdropFilter = 'blur(2px)'; // Test webkit prefix first
      if (el.style.webkitBackdropFilter) return true;
      
      el.style.backdropFilter = 'blur(2px)'; // Then test standard property
      return Boolean(el.style.backdropFilter);
    } catch (e) {
      return false;
    }
  })();
  
  if (!supportsBackdropFilter) {
    html.classList.add('supports-no-backdropfilter');
  }
  
  // Test for inset property support (shorthand for top/right/bottom/left)
  const supportsInset = (function() {
    try {
      const el = document.createElement('div');
      el.style.inset = '0';
      return Boolean(el.style.inset !== undefined);
    } catch (e) {
      return false;
    }
  })();
  
  if (!supportsInset) {
    html.classList.add('supports-no-inset');
  }
  
  // Check if scroll-behavior is supported
  const supportsScrollBehavior = 'scrollBehavior' in document.documentElement.style;
  
  if (!supportsScrollBehavior) {
    html.classList.add('supports-no-scrollbehavior');
    
    // Add our own smooth scrolling implementation
    document.addEventListener('DOMContentLoaded', function() {
      const anchorLinks = document.querySelectorAll('a[href^="#"]');
      
      for (let anchor of anchorLinks) {
        anchor.addEventListener('click', function(e) {
          const targetId = this.getAttribute('href');
          if (targetId === '#') return;
          
          const targetElement = document.querySelector(targetId);
          if (!targetElement) return;
          
          e.preventDefault();
          
          // Get the target's position
          const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
          const startPosition = window.pageYOffset;
          const distance = targetPosition - startPosition;
          const duration = 300; // ms
          let startTime = null;
          
          // Implement smooth scrolling with requestAnimationFrame
          function animateScroll(currentTime) {
            if (startTime === null) startTime = currentTime;
            const timeElapsed = currentTime - startTime;
            const progress = Math.min(timeElapsed / duration, 1);
            
            // Easing function for smoother animation
            const easeInOutQuad = progress => 
              progress < 0.5
                ? 2 * progress * progress
                : 1 - Math.pow(-2 * progress + 2, 2) / 2;
            
            window.scrollTo(0, startPosition + distance * easeInOutQuad(progress));
            
            if (timeElapsed < duration) {
              requestAnimationFrame(animateScroll);
            }
          }
          
          requestAnimationFrame(animateScroll);
        });
      }
    });
  }
  
  // CSS Custom Properties (Variables) Polyfill Reference
  // This is minimalist as most modern browsers support CSS variables
  // If you need complete support, consider cssvar-ponyfill or a similar library
  if (!supportsCssVars) {
    // Here you'd load a proper CSS Variables polyfill or implement theme switching via class toggle
    console.log('CSS Variables not supported in this browser. Using fallback styling.');
  }
  
  // Event listener to ensure the logo styles are properly applied after full page load
  window.addEventListener('load', function() {
    // Re-check feature detection after page load (some browsers need this)
    
    // Force a repaint to ensure fallback styles are applied
    if (html.classList.contains('supports-no-backgroundclip') || 
        html.classList.contains('supports-no-cssvariables')) {
      
      const logos = document.querySelectorAll('.logo-text');
      logos.forEach(logo => {
        // Force a repaint
        logo.style.display = 'none';
        // Layout thrashing is necessary here to force a repaint
        void logo.offsetHeight;
        logo.style.display = '';
      });
    }
    
    // Apply backdrop-filter fallbacks if needed
    if (html.classList.contains('supports-no-backdropfilter')) {
      const glassElements = document.querySelectorAll('.glass-panel, [class*="glass-"], [class*="-glass"]');
      glassElements.forEach(el => {
        // Increase background opacity to compensate for missing blur
        el.style.backgroundColor = 'rgba(var(--bg-rgb, 255, 255, 255), 0.85)';
      });
    }
    
    // Apply inset property fallbacks
    if (html.classList.contains('supports-no-inset')) {
      const elements = document.querySelectorAll('[style*="inset:"]');
      elements.forEach(el => {
        const computedStyle = getComputedStyle(el);
        if (computedStyle.inset) {
          const insetValue = computedStyle.inset;
          // Set individual properties as fallback
          el.style.top = insetValue;
          el.style.right = insetValue;
          el.style.bottom = insetValue;
          el.style.left = insetValue;
        }
      });
    }
  });
})(); 