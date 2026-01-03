/**
 * Tag System for JenniNexus Landing Page
 * Manages tag filtering, display, and content categorization
 * 
 * IMPORTANT: Tags are loaded dynamically from tags.json
 * To add/edit/remove tags, modify: public_html/resources/playlists/tags.json
 */

(function() {
  'use strict';

  // Tags data - loaded dynamically from tags.json
  let TAGS = [];
  let tagsLoaded = false;

  let activeFilters = new Set();
  // Persisted setting key: whether to show all tags in the offcanvas
  const SHOW_ALL_TAGS_KEY = 'jn_showAllTags';
  let showAllTags = (function(){ try { return localStorage.getItem(SHOW_ALL_TAGS_KEY) === '1'; } catch(e){ return false; } })();

  /**
   * Load tags from tags.json dynamically
   */
  async function loadTags() {
    if (tagsLoaded) return true;
    
    try {
      const response = await fetch(window.RES_ROOT + '/playlists/tags.json');
      if (!response.ok) {
        throw new Error(`Failed to load tags.json: ${response.status}`);
      }
      
      TAGS = await response.json();
      tagsLoaded = true;
      console.log(`✅ Tag System: Loaded ${TAGS.length} tags from tags.json`);
      return true;
    } catch (error) {
      console.error('❌ Tag System: Failed to load tags.json:', error);
      // Fallback: try to continue with empty tags array
      TAGS = [];
      tagsLoaded = true;
      return false;
    }
  }

  /**
   * Initialize the tag system
   */
  async function initTagSystem() {
    // Load tags from tags.json first
    await loadTags();
    
    // Then initialize UI
    populateTagLists();
    initContentFilter();
    initTagClickHandlers();
    
    // If a central tagFilter API is present, subscribe to updates so offcanvas and
    // page filtering react to changes from other UI (tag cloud)
    if (window.tagFilter && typeof window.tagFilter.onChange === 'function') {
      window.tagFilter.onChange(function(active){
        updateActiveFiltersDisplay();
        // apply filters to page content
        filterContent();
      });
    }
  }

  /**
   * Populate tag lists in the offcanvas
   */
  function populateTagLists() {
    const categories = {
      gamedev: document.getElementById('gamedevTagsList'),
      gaming: document.getElementById('gamingTagsList'),
      diy: document.getElementById('diyTagsList'),
      'voice-acting': document.getElementById('voiceTagsList')
    };

    // Group tags by category
    const tagsByCategory = TAGS.reduce((acc, tag) => {
      if (!acc[tag.category]) acc[tag.category] = [];
      acc[tag.category].push(tag);
      return acc;
    }, {});

  // If YouTubeGrid has already exposed used tag slugs for this page, prefer to only
  // render tags that are actually used on the page. Users can override with the
  // "Show all tags" toggle which persists in localStorage.
  const usedSlugsArray = Array.isArray(window.__usedTagSlugs) ? window.__usedTagSlugs : null;
  const usedSlugs = usedSlugsArray ? new Set(usedSlugsArray) : null;

    // Render tags in each category (filtered by usedSlugs if available and not overridden)
    Object.entries(tagsByCategory).forEach(([category, tags]) => {
      const container = categories[category];
      if (!container) return;
      container.innerHTML = '';

      tags.forEach(tag => {
        // If we have a used-tags filter, only render tags that are present in that set
        if (!showAllTags && usedSlugs && usedSlugs.size > 0 && !usedSlugs.has(tag.slug)) return;
        const badge = createTagBadge(tag);
        container.appendChild(badge);
      });
    });

    // If no used tag information yet, listen once for the event and refresh lists
    if (!usedSlugs) {
      document.addEventListener('YouTubeGrid:usedTagsUpdated', function onUsed(e) {
        try {
          window.__usedTagSlugs = Array.isArray(e.detail) ? e.detail : (window.__usedTagSlugs || []);
        } catch (err) { /* ignore */ }
        // Re-populate lists now that used tags are known
        populateTagLists();
      }, { once: true });
    }

    // Ensure the "Show all tags" toggle exists in the offcanvas so users can opt out
    // of automatic used-tag filtering. We add the control once at the top of the offcanvas body.
    try {
      const offcanvas = document.getElementById('tagFilterOffcanvas');
      if (offcanvas) {
        let ctrl = offcanvas.querySelector('.jn-show-all-tags');
        if (!ctrl) {
          const wrapper = document.createElement('div');
          wrapper.className = 'mb-3 jn-show-all-tags';
          wrapper.innerHTML = `
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="jnShowAllTagsToggle">
              <label class="form-check-label small text-muted" for="jnShowAllTagsToggle">Show all tags</label>
            </div>
          `;
          const body = offcanvas.querySelector('.offcanvas-body') || offcanvas;
          body.insertBefore(wrapper, body.firstChild);
          ctrl = wrapper;
        }
        const checkbox = ctrl.querySelector('#jnShowAllTagsToggle');
        if (checkbox) {
          checkbox.checked = !!showAllTags;
          checkbox.addEventListener('change', function(){
            try { localStorage.setItem(SHOW_ALL_TAGS_KEY, this.checked ? '1' : '0'); } catch(e){}
            showAllTags = !!this.checked;
            // Rebuild lists with the new preference
            populateTagLists();
          });
        }
      }
    } catch (e) { /* non-fatal UI enhancement */ }
  }

  /**
   * Create a tag badge element
   */
  function createTagBadge(tag) {
    const badge = document.createElement('span');
    badge.className = 'glass-badge tag-badge';
    badge.textContent = tag.name;
    badge.dataset.tagId = tag.id;
    badge.dataset.tagSlug = tag.slug;
    badge.dataset.category = tag.category;
    badge.style.cursor = 'pointer';
    badge.style.userSelect = 'none'; // Prevent text selection on click
    badge.style.display = 'inline-flex'; // Match glass-badge default
    badge.style.alignItems = 'center';
    badge.style.marginBottom = '0.25rem';
    
    // Check if this tag is currently active
    if (activeFilters.has(tag.slug)) {
      badge.classList.add('active');
    }
    
    // Click handler - glass-badge has hover built-in
    badge.addEventListener('click', () => {
      toggleTagFilter(tag);
      // Update visual state immediately
      if (activeFilters.has(tag.slug)) {
        badge.classList.add('active');
      } else {
        badge.classList.remove('active');
      }
    });
    
    return badge;
  }

  /**
   * Toggle tag filter
   */
  function toggleTagFilter(tag) {
    const key = tag.slug || String(tag.id);
    if (window.tagFilter && typeof window.tagFilter.toggle === 'function') {
      window.tagFilter.toggle(key);
      return;
    }

    if (activeFilters.has(key)) {
      activeFilters.delete(key);
    } else {
      activeFilters.add(key);
    }

    updateActiveFiltersDisplay();
    filterContent();
  }

  /**
   * Update active filters display
   */
  function updateActiveFiltersDisplay() {
    const container = document.getElementById('activeFilters');
    const containerWrapper = document.getElementById('activeFiltersContainer');
    const clearBtn = document.getElementById('clearAllFilters');
    
    // determine active filters from central API if available
    const active = (window.tagFilter && typeof window.tagFilter.getActive === 'function') ? window.tagFilter.getActive() : Array.from(activeFilters);
    
    if (!active || active.length === 0) {
      if (containerWrapper) containerWrapper.style.display = 'none';
      if (clearBtn) clearBtn.style.display = 'none';
      return;
    }
    
    if (containerWrapper) containerWrapper.style.display = 'block';
    if (clearBtn) clearBtn.style.display = 'inline-block';
    if (!container) return;
    
    container.innerHTML = '';
    
    active.forEach(slug => {
      const tag = TAGS.find(t => t.slug === slug);
      if (!tag) return;
      
      const badge = document.createElement('span');
      badge.className = 'badge bg-primary';
      badge.innerHTML = `${tag.name} <i class="fa-solid fa-circle-xmark ms-1" style="cursor: pointer;"></i>`;
      badge.querySelector('i').addEventListener('click', () => {
        if (window.tagFilter && typeof window.tagFilter.toggle === 'function') {
          window.tagFilter.toggle(slug);
        } else {
          activeFilters.delete(slug);
          updateActiveFiltersDisplay();
          filterContent();
        }
      });
      
      container.appendChild(badge);
    });
    
    // Update tag badges to show active state
    document.querySelectorAll('.tag-badge').forEach(badge => {
      const slug = badge.dataset.tagSlug;
      const isActive = (window.tagFilter && typeof window.tagFilter.getActive === 'function') ? (window.tagFilter.getActive().indexOf(slug) !== -1) : activeFilters.has(slug);
      if (isActive) {
        badge.classList.remove('bg-outline-primary');
        badge.classList.add('bg-primary');
      } else {
        badge.classList.remove('bg-primary');
        badge.classList.add('bg-outline-primary');
      }
    });
  }

  /**
   * Filter content based on active filters
   */
  function filterContent() {
    const filters = (window.tagFilter && typeof window.tagFilter.getActive === 'function') ? window.tagFilter.getActive().map(s => String(s).trim()).filter(Boolean) : Array.from(activeFilters).map(s => s.trim()).filter(Boolean);
    //console.log('Active filters:', filters);

    const contentItems = document.querySelectorAll('.content-item');
    if (!contentItems || contentItems.length === 0) {
      // Nothing to filter on the page
      return;
    }

    // If no filters active, show all
    if (filters.length === 0) {
      contentItems.forEach(item => {
        item.style.display = '';
      });
      return;
    }

    // Check if any content matches the selected filters
    let hasMatches = false;
    contentItems.forEach(item => {
      const raw = item.dataset.tags || item.getAttribute('data-tags') || '';
      if (!raw) {
        // When item has no data-tags, default to hiding (or you can change to show)
        item.style.display = 'none';
        return;
      }
      const itemTags = raw.split(',').map(t => t.trim()).filter(Boolean);
      const matches = itemTags.some(t => filters.indexOf(t) !== -1);
      item.style.display = matches ? '' : 'none';
      if (matches) hasMatches = true;
    });

    // If no matches found on current page, offer to redirect to /tags.php with filters
    if (!hasMatches && filters.length > 0) {
      // Check if we're already on tags.php to avoid redirect loop
      const currentPath = window.location.pathname;
      if (!currentPath.includes('tags.php') && !currentPath.includes('/tag/')) {
        // Show notification and redirect option
        const container = document.getElementById('activeFiltersContainer');
        if (container) {
          const existingNotice = container.querySelector('.no-results-notice');
          if (!existingNotice) {
            const notice = document.createElement('div');
            notice.className = 'alert alert-warning no-results-notice mt-3';
            notice.innerHTML = `
              <i class="fa-solid fa-circle-info me-2"></i>
              <strong>No content matched on this page.</strong>
              <p class="mb-2 small">The selected tags don't appear on the current page.</p>
              <button class="btn btn-sm btn-primary view-all-results-btn" type="button">
                <i class="fa-solid fa-magnifying-glass me-1"></i>View All Results
              </button>
            `;
            container.appendChild(notice);
            
            // Add click handler for "View All Results" button
            notice.querySelector('.view-all-results-btn').addEventListener('click', function() {
              // Map tag slugs back to display names for URL
              const tagNames = filters.map(slug => {
                const tag = TAGS.find(t => t.slug === slug);
                return tag ? tag.name : slug;
              });
              const filterParam = encodeURIComponent(tagNames.join(','));
              window.location.href = `/tags.php?filters=${filterParam}`;
            });
          }
        }
      }
    } else {
      // Remove no-results notice if it exists (user changed filters and now has matches)
      const notice = document.querySelector('.no-results-notice');
      if (notice) notice.remove();
    }
  }

  /**
   * Initialize content category filter buttons
   */
  function initContentFilter() {
    // Scope the filter buttons to the #content section on the home page so other pages
    // with different data-* attributes (e.g., blog tag buttons) are not picked up.
    const contentRoot = document.getElementById('content');
    if (!contentRoot) return; // nothing to do on pages without the content grid

    const filterButtons = contentRoot.querySelectorAll('[data-filter]');
    const contentItems = contentRoot.querySelectorAll('.content-item');
    
    filterButtons.forEach(button => {
      button.addEventListener('click', () => {
        // Update active button
        filterButtons.forEach(btn => {
          btn.classList.remove('active');
          btn.classList.remove('btn-primary');
          btn.classList.add('btn-outline-primary');
        });
        button.classList.add('active');
        button.classList.add('btn-primary');
        button.classList.remove('btn-outline-primary');
        
        // Filter content
  const filter = button.dataset.filter;
        
        contentItems.forEach(item => {
          if (filter === 'all' || item.dataset.category === filter) {
            item.style.display = '';
            // Add fade-in animation (only set briefly)
            item.style.animation = 'fadeInUp 0.5s ease-out';
            // remove animation after it finishes to avoid interfering with future filters
            setTimeout(() => { item.style.animation = ''; }, 600);
          } else {
            item.style.display = 'none';
          }
        });
      });
    });
  }

  /**
   * Initialize tag click handlers
   */
  function initTagClickHandlers() {
    const clearFiltersBtn = document.getElementById('clearFilters');
    if (clearFiltersBtn) {
      clearFiltersBtn.addEventListener('click', () => {
        if (window.tagFilter && typeof window.tagFilter.clear === 'function') {
          window.tagFilter.clear();
        } else {
          activeFilters.clear();
          updateActiveFiltersDisplay();
          filterContent();
        }
        if (window.mgShowToast) {
          window.mgShowToast('Filters cleared', 'info');
        }
      });
    }
    const applyFiltersBtn = document.getElementById('applyFilters');
    if (applyFiltersBtn) {
      applyFiltersBtn.addEventListener('click', () => {
        // Get active filters
        const filters = (window.tagFilter && typeof window.tagFilter.getActive === 'function') 
          ? window.tagFilter.getActive().map(s => String(s).trim()).filter(Boolean) 
          : Array.from(activeFilters).map(s => s.trim()).filter(Boolean);
        
        // If no filters selected, just close the offcanvas
        if (filters.length === 0) {
          return;
        }
        
        // Map tag slugs to display names for cleaner URLs
        const tagNames = filters.map(slug => {
          const tag = TAGS.find(t => t.slug === slug);
          return tag ? tag.name : slug;
        });
        
        // Redirect to tags.php with filters
        const filterParam = encodeURIComponent(tagNames.join(','));
        window.location.href = `/tags.php?filters=${filterParam}`;
      });
    }
  }

  /**
   * Initialize when DOM is ready
   */
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTagSystem);
  } else {
    initTagSystem();
  }

})();
