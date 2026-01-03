/**
 * Back to top button functionality
 * Simple and reliable implementation
 * Updated: 2025-01-06
 */
(function() {
    'use strict';
    
    // Configuration
    const config = {
        scrollThreshold: 300,
        scrollDuration: 500,
        selectors: [
            '#backToTop',
            '.back-to-top',
            '[data-back-to-top]'
        ],
        classes: {
            show: 'show',
            visible: 'visible',
            active: 'active'
        }
    };
    
    let isInitialized = false;
    let backToTopButton = null;
    let ticking = false;
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        init();
    });
    
    /**
     * Initialize back to top functionality
     */
    function init() {
        if (isInitialized) return;
        
        // Find button using multiple selectors
        for (const selector of config.selectors) {
            backToTopButton = document.querySelector(selector);
            if (backToTopButton) break;
        }
        
        if (!backToTopButton) {
            console.warn('Back to top button not found');
            return;
        }
        
        console.log('Back to top button found:', backToTopButton);
        
        // Setup event listeners
        setupEventListeners();
        
        // Initial state check
        updateButtonVisibility();
        
        isInitialized = true;
        console.log('Back to top functionality initialized');
    }
    
    /**
     * Setup event listeners
     */
    function setupEventListeners() {
        // Button click handler
        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            scrollToTop();
        });
        
        // Scroll handler with throttling
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    updateButtonVisibility();
                    ticking = false;
                });
                ticking = true;
            }
        });
        
        // Resize handler
        window.addEventListener('resize', updateButtonVisibility);
    }
    
    /**
     * Update button visibility based on scroll position
     */
    function updateButtonVisibility() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const shouldShow = scrollTop > config.scrollThreshold;
        
        if (shouldShow) {
            showButton();
        } else {
            hideButton();
        }
    }
    
    /**
     * Show the back to top button
     */
    function showButton() {
        if (!backToTopButton) return;
        
        backToTopButton.classList.add(config.classes.show);
        backToTopButton.classList.add(config.classes.visible);
        backToTopButton.classList.add(config.classes.active);
        backToTopButton.style.display = 'flex'; // Changed from 'block' to 'flex' for centered icon
        backToTopButton.setAttribute('aria-hidden', 'false');
    }
    
    /**
     * Hide the back to top button
     */
    function hideButton() {
        if (!backToTopButton) return;
        
        backToTopButton.classList.remove(config.classes.show);
        backToTopButton.classList.remove(config.classes.visible);
        backToTopButton.classList.remove(config.classes.active);
        backToTopButton.setAttribute('aria-hidden', 'true');
        
        // Don't set display: none immediately to allow CSS transitions
        setTimeout(() => {
            if (!backToTopButton.classList.contains(config.classes.show)) {
                backToTopButton.style.display = 'none';
            }
        }, 300);
    }
    
    /**
     * Scroll to top with smooth animation
     */
    function scrollToTop() {
        // Try native smooth scrolling first
        if (window.scrollTo && 'behavior' in document.documentElement.style) {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        } else {
            // Fallback for older browsers
            smoothScrollPolyfill();
        }
        
        console.log('Scrolling to top');
    }
    
    /**
     * Smooth scroll polyfill for older browsers
     */
    function smoothScrollPolyfill() {
        const start = window.pageYOffset || document.documentElement.scrollTop;
        const startTime = performance.now();
        
        function scroll() {
            const elapsed = performance.now() - startTime;
            const progress = Math.min(elapsed / config.scrollDuration, 1);
            
            // Easing function (ease-out)
            const easeOut = 1 - Math.pow(1 - progress, 3);
            const position = start * (1 - easeOut);
            
            window.scrollTo(0, position);
            
            if (progress < 1) {
                requestAnimationFrame(scroll);
            }
        }
        
        requestAnimationFrame(scroll);
    }
    
    // Export for external use
    window.JenniBackToTop = {
        isInitialized: () => isInitialized,
        scrollToTop: scrollToTop,
        show: showButton,
        hide: hideButton
    };
    
})();