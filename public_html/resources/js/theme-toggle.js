/**
 * Theme Toggle Functionality for JenniNexus Landing Page
 * Handles light/dark mode switching with localStorage persistence
 */

(function() {
  'use strict';

  // Get DOM elements
  const themeToggle = document.getElementById('themeToggle');
  const themeToggleMobile = document.getElementById('themeToggleMobile');
  const html = document.documentElement;
  
  // Icon elements - using inline SVG for better reliability
  const moonIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="theme-icon"><path d="M223.5 32C100 32 0 132.3 0 256S100 480 223.5 480c60.6 0 115.5-24.2 155.8-63.4c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-9.8 1.7-19.8 2.6-30.1 2.6c-96.9 0-175.5-78.8-175.5-176c0-65.8 36-123.1 89.3-153.3c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-6.3-.5-12.6-.8-19-.8z"/></svg>';
  const sunIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="theme-icon"><path d="M361.5 1.2c5 2.1 8.6 6.6 9.6 11.9L391 121l107.9 19.8c5.3 1 9.8 4.6 11.9 9.6s1.5 10.7-1.6 15.2L446.9 256l62.3 90.3c3.1 4.5 3.7 10.2 1.6 15.2s-6.6 8.6-11.9 9.6L391 391 371.1 498.9c-1 5.3-4.6 9.8-9.6 11.9s-10.7 1.5-15.2-1.6L256 446.9l-90.3 62.3c-4.5 3.1-10.2 3.7-15.2 1.6s-8.6-6.6-9.6-11.9L121 391 13.1 371.1c-5.3-1-9.8-4.6-11.9-9.6s-1.5-10.7 1.6-15.2L65.1 256 2.8 165.7c-3.1-4.5-3.7-10.2-1.6-15.2s6.6-8.6 11.9-9.6L121 121 140.9 13.1c1-5.3 4.6-9.8 9.6-11.9s10.7-1.5 15.2 1.6L256 65.1 346.3 2.8c4.5-3.1 10.2-3.7 15.2-1.6zM160 256a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zm224 0a128 128 0 1 0 -256 0 128 128 0 1 0 256 0z"/></svg>';
  const moonIconMobile = moonIcon;
  const sunIconMobile = sunIcon;

  /**
   * Get the stored theme preference or default to current theme
   */
  function getStoredTheme() {
    // Check localStorage first
    const stored = localStorage.getItem('theme');
    if (stored) return stored;
    
    // Check current data-bs-theme attribute
    const current = html.getAttribute('data-bs-theme');
    if (current) return current;
    
    // Default to dark
    return 'dark';
  }

  /**
   * Store the theme preference
   */
  function setStoredTheme(theme) {
    localStorage.setItem('theme', theme);
  }

  /**
   * Apply the theme to the document
   */
  function setTheme(theme) {
    html.setAttribute('data-bs-theme', theme);
    updateToggleIcon(theme);
  }

  /**
   * Update the theme toggle button icon
   */
  function updateToggleIcon(theme) {
    if (themeToggle) {
      if (theme === 'dark') {
        themeToggle.innerHTML = moonIcon;
        themeToggle.setAttribute('aria-label', 'Switch to light mode');
      } else {
        themeToggle.innerHTML = sunIcon;
        themeToggle.setAttribute('aria-label', 'Switch to dark mode');
      }
    }
    
    if (themeToggleMobile) {
      if (theme === 'dark') {
        themeToggleMobile.innerHTML = moonIconMobile;
        themeToggleMobile.setAttribute('aria-label', 'Switch to light mode');
      } else {
        themeToggleMobile.innerHTML = sunIconMobile;
        themeToggleMobile.setAttribute('aria-label', 'Switch to dark mode');
      }
    }
  }

  /**
   * Toggle between light and dark themes
   */
  function toggleTheme() {
    const currentTheme = html.getAttribute('data-bs-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    setTheme(newTheme);
    setStoredTheme(newTheme);
  }

  /**
   * Initialize theme on page load
   */
  function initTheme() {
    const storedTheme = getStoredTheme();
    setTheme(storedTheme);
  }

  /**
   * Add event listeners
   */
  function initEventListeners() {
    if (themeToggle) {
      themeToggle.addEventListener('click', toggleTheme);
    }
    if (themeToggleMobile) {
      themeToggleMobile.addEventListener('click', toggleTheme);
    }
  }

  /**
   * Handle system theme preference changes
   */
  function watchSystemTheme() {
    const darkModeQuery = window.matchMedia('(prefers-color-scheme: dark)');
    
    darkModeQuery.addEventListener('change', (e) => {
      // Only auto-switch if user hasn't set a preference
      if (!localStorage.getItem('theme')) {
        const newTheme = e.matches ? 'dark' : 'light';
        setTheme(newTheme);
      }
    });
  }

  /**
   * Initialize everything when DOM is ready
   */
  function init() {
    initTheme();
    initEventListeners();
    watchSystemTheme();
  }

  // Run initialization when DOM is fully loaded
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const targetId = this.getAttribute('href');
      
      // Skip if it's just "#"
      if (targetId === '#') {
        e.preventDefault();
        return;
      }
      
      const targetElement = document.querySelector(targetId);
      
      if (targetElement) {
        e.preventDefault();
        
        // Calculate offset for fixed navbar
        const navbarHeight = document.querySelector('.navbar').offsetHeight;
        const targetPosition = targetElement.offsetTop - navbarHeight - 20;
        
        window.scrollTo({
          top: targetPosition,
          behavior: 'smooth'
        });
      }
    });
  });

  // Add scroll effect to navbar
  let lastScroll = 0;
  const navbar = document.querySelector('.navbar');

  window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;

    if (currentScroll > 100) {
      navbar.classList.add('shadow-lg');
    } else {
      navbar.classList.remove('shadow-lg');
    }

    lastScroll = currentScroll;
  });

})();
