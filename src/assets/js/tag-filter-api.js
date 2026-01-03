/**
 * Tag Filter API - Centralized State Management for Tag Filtering
 * 
 * Provides a global API (window.tagFilter) to manage active tag filters,
 * URL persistence, and event dispatching.
 * 
 * Used by:
 * - tag-system.js (Offcanvas UI)
 * - Page-specific filter buttons (e.g., gamedev.php, blog.php)
 */

(function() {
  'use strict';

  // State
  const state = {
    activeFilters: new Set(),
    listeners: [],
    initialized: false
  };

  // API Object
  const api = {
    /**
     * Initialize the API
     * @param {Object} options - { seedFromUrl: boolean, persistUrl: boolean }
     */
    init: function(options = {}) {
      if (state.initialized) return;
      
      const defaults = { seedFromUrl: true, persistUrl: true };
      const config = { ...defaults, ...options };
      
      if (config.seedFromUrl) {
        const params = new URLSearchParams(window.location.search);
        const filters = params.get('filters') || params.get('slug'); // support both
        if (filters) {
          filters.split(',').forEach(f => state.activeFilters.add(f.trim()));
        }
      }
      
      state.initialized = true;
      api.notify();
    },

    /**
     * Toggle a tag filter
     * @param {string} slug - Tag slug
     */
    toggle: function(slug) {
      if (!slug) return;
      const s = String(slug).trim();
      if (state.activeFilters.has(s)) {
        state.activeFilters.delete(s);
      } else {
        state.activeFilters.add(s);
      }
      api.updateUrl();
      api.notify();
    },

    /**
     * Add a tag filter
     * @param {string} slug 
     */
    add: function(slug) {
      if (!slug) return;
      state.activeFilters.add(String(slug).trim());
      api.updateUrl();
      api.notify();
    },

    /**
     * Remove a tag filter
     * @param {string} slug 
     */
    remove: function(slug) {
      if (!slug) return;
      state.activeFilters.delete(String(slug).trim());
      api.updateUrl();
      api.notify();
    },

    /**
     * Clear all filters
     */
    clear: function() {
      state.activeFilters.clear();
      api.updateUrl();
      api.notify();
    },

    /**
     * Get active filters as an array
     * @returns {string[]}
     */
    getActive: function() {
      return Array.from(state.activeFilters);
    },

    /**
     * Subscribe to changes
     * @param {Function} callback - Called with (activeFiltersArray)
     */
    onChange: function(callback) {
      if (typeof callback === 'function') {
        state.listeners.push(callback);
      }
    },

    /**
     * Notify listeners
     */
    notify: function() {
      const active = api.getActive();
      state.listeners.forEach(cb => {
        try { cb(active); } catch(e) { console.error('TagFilter listener error:', e); }
      });
    },

    /**
     * Update URL with current filters (without reloading)
     */
    updateUrl: function() {
      // Only persist if we are on a page that supports it (like tags.php)
      // OR if we want to support deep linking on content pages.
      // For now, let's only update if we are on tags.php OR if we explicitly want to.
      // Actually, the user wants "easy to keep track of".
      // Updating URL on gamedev.php might be nice but could be annoying if it reloads.
      // We'll use pushState to avoid reload.
      
      const active = api.getActive();
      const url = new URL(window.location);
      
      if (active.length > 0) {
        url.searchParams.set('filters', active.join(','));
      } else {
        url.searchParams.delete('filters');
        url.searchParams.delete('slug'); // clean up legacy
      }
      
      window.history.pushState({}, '', url);
    }
  };

  // Expose globally
  window.tagFilter = api;

  // Auto-init on load
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => api.init());
  } else {
    api.init();
  }

})();
