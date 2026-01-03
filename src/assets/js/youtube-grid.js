/**
 * YouTube Grid System with YAML Configuration Support
 * JenniNexus - Version 3.0 (RSS-Only, No API)
 * 
 * Features:
 * - YAML configuration loading
 * - Section-based playlist rendering
 * - Bootstrap Icon integration
 * - Responsive grid layouts
 * - Hover effects and animations
 * - YouTube RSS feed integration (NO API KEY NEEDED!)
 * - Server-side caching via get-youtube.php proxy
 */

(function() {
  'use strict';

  // Configuration - derive base paths from window.RES_ROOT when available
  const RESOURCE_BASE = (typeof window !== 'undefined' && window.RES_ROOT) ? window.RES_ROOT : '/resources';
  
  // Configuration - uses YouTube RSS feeds (no API key needed!)
  const CONFIG = {
    playlistsPath: RESOURCE_BASE + '/playlists/',
    defaultVideosPerPlaylist: 6,
    cacheExpiry: 86400000 // 24 hours in milliseconds
  };

  // Canonical tags map (loaded from resources/playlists/tags.json when available)
  let CANONICAL_TAGS = null; // { byName: {lowerName: slug}, bySlug: {slug: slug} }
  const USED_TAG_SLUGS = new Set();

  // Cache for API responses
  const cache = new Map();

  // CORS proxy list (client-side fallback) - used only if server-side proxy fails
  const CORS_PROXIES = [
    'https://api.allorigins.win/raw?url=',
    'https://corsproxy.io/?',
    'https://api.codetabs.com/v1/proxy?quest='
  ];

  async function fetchPlaylistViaProxies(playlistId, maxResults = 6) {
    const rssUrl = `https://www.youtube.com/feeds/videos.xml?playlist_id=${playlistId}`;

    for (let i = 0; i < CORS_PROXIES.length; i++) {
      const proxy = CORS_PROXIES[i];
      const proxyUrl = proxy + encodeURIComponent(rssUrl);
      try {
        const res = await fetch(proxyUrl, { method: 'GET', headers: { 'Accept': 'application/xml, text/xml, */*' } });
        if (!res.ok) {
          console.warn(`Proxy ${i+1} returned status ${res.status} for playlist ${playlistId}`);
          continue;
        }
        const xmlText = await res.text();
        const parser = new DOMParser();
        const xmlDoc = parser.parseFromString(xmlText, 'text/xml');
        if (xmlDoc.querySelector('parsererror')) {
          console.warn(`Proxy ${i+1} returned invalid XML for playlist ${playlistId}`);
          continue;
        }
        const entries = xmlDoc.querySelectorAll('entry');
        if (!entries || entries.length === 0) {
          console.warn(`Proxy ${i+1} returned no entries for playlist ${playlistId}`);
          continue;
        }
        const videos = Array.from(entries).slice(0, maxResults).map(entry => {
          const videoId = entry.querySelector('videoId, yt\:videoId')?.textContent || '';
          const title = entry.querySelector('title')?.textContent || 'Untitled Video';
          const published = entry.querySelector('published')?.textContent || '';
          const thumb = entry.querySelector('media\:thumbnail, thumbnail')?.getAttribute('url') || (videoId ? `https://img.youtube.com/vi/${videoId}/mqdefault.jpg` : '');
          return { id: videoId, title: title, thumbnail: thumb, publishedAt: published };
        }).filter(v => v.id);

        if (videos.length > 0) return videos;

      } catch (err) {
        console.warn(`Proxy ${i+1} failed for playlist ${playlistId}:`, err && err.message ? err.message : err);
        continue;
      }
    }

    return [];
  }

  /**
   * Get responsive Bootstrap column classes from columns config
   * @param {Object} columns - Column configuration { xs: 1, sm: 2, md: 2, lg: 4 }
   * @returns {string} Bootstrap column classes (e.g., 'col-12 col-sm-6 col-md-6 col-lg-3')
   */
  function getResponsiveColClasses(columns) {
    if (!columns || typeof columns !== 'object') return '';
    
    // Bootstrap 5.3.8 breakpoint order (xs is implicit via col-* without infix)
    const breakpoints = ['xs', 'sm', 'md', 'lg', 'xl', 'xxl'];
    const classes = [];
    
    for (const bp of breakpoints) {
      if (columns[bp]) {
        const cols = parseInt(columns[bp], 10);
        if (cols > 0 && cols <= 12) {
          let className;
          if (cols === 5 && (bp === 'lg' || bp === 'xl' || bp === 'xxl')) {
            className = `col-${bp}-2-4`;
          } else {
            const colWidth = Math.round(12 / cols);
            // xs uses 'col-' without infix, others use 'col-{bp}-'
            className = bp === 'xs' ? `col-${colWidth}` : `col-${bp}-${colWidth}`;
          }
          classes.push(className);
        }
      }
    }
    
    return classes.join(' ');
  }

  /**
   * Map Bootstrap Icon names to FontAwesome 6.7.2 names
   * @param {string} icon - Icon name from config
   * @returns {string} FontAwesome icon name
   */
  function mapIcon(icon) {
    if (!icon) return 'circle-play';
    const mapping = {
      'play-circle': 'circle-play',
      'play-circle-fill': 'circle-play',
      'youtube': 'youtube',
      'controller': 'gamepad',
      'tree': 'tree',
      'playstation': 'playstation',
      'trophy': 'trophy',
      'camera-video': 'video',
      'emoji-smile': 'face-smile',
      'emoji-heart-eyes': 'face-heart-eyes',
      'lightning': 'bolt',
      'box-arrow-up-right': 'arrow-up-right-from-square',
      'collection-play': 'layer-group',
      'gear': 'gear',
      'tools': 'screwdriver-wrench',
      'music-note-beamed': 'music',
      'broadcast': 'tower-broadcast',
      'cpu': 'microchip',
      'robot': 'robot',
      'palette': 'palette',
      'code-slash': 'code',
      'terminal': 'terminal',
      'link-45deg': 'link',
      'share': 'share-nodes',
      'info-circle': 'circle-info',
      'question-circle': 'circle-question',
      'exclamation-triangle': 'triangle-exclamation',
      'disc': 'compact-disc',
      'disc-fill': 'compact-disc',
      'vinyl': 'record-vinyl',
      'person-dancing': 'person-walking',
      'headphones': 'headphones',
      'stars': 'stars',
      'cloud-haze': 'cloud',
      'music': 'music'
    };
    return mapping[icon] || icon;
  }

  /**
   * Convert aspect ratio format from YAML to Bootstrap class
   * @param {string} ratio - Aspect ratio in format "16:9", "9:16", "4:3", "1:1", "21:9"
   * @returns {string} Bootstrap ratio class (e.g., 'ratio-16x9', 'ratio-9x16', 'ratio-4x3', 'ratio-1x1', 'ratio-21x9')
   */
  function getAspectRatioClass(ratio) {
    if (!ratio || typeof ratio !== 'string') return 'ratio-16x9'; // Default to 16:9
    
    // Convert "16:9" format to "ratio-16x9" format
    const normalized = ratio.trim().replace(':', 'x');
    
    // Validate against supported Bootstrap 5.3.8 ratio classes
    const supportedRatios = ['16x9', '9x16', '4x3', '1x1', '21x9'];
    if (supportedRatios.includes(normalized)) {
      return `ratio-${normalized}`;
    }
    
    // Fallback to 16:9 if format is invalid
    console.warn(`Invalid aspect ratio "${ratio}", falling back to 16:9`);
    return 'ratio-16x9';
  }

  /**
   * Main YouTubeGrid API
   */
  const YouTubeGrid = {
    
    /**
     * Initialize and load page configuration
     */
    async loadPageConfig(pageName) {
      try {
        console.log(`YouTubeGrid: Loading config for page "${pageName}"`);
        
        // Load canonical tags index if present so we can normalize tag names -> slugs
        await loadCanonicalTags();
        
        // Load YAML configuration
        const config = await loadYAMLConfig(pageName);
        console.log(`YouTubeGrid: Config loaded for "${pageName}"`, config);
        
        // Render all sections from config
        await renderPageSections(config);

        // After rendering, expose the set of used tag slugs so other scripts (tag-system)
        // can restrict the offcanvas/tag lists to only tags that are actually used on the page.
        try {
          window.__usedTagSlugs = Array.from(USED_TAG_SLUGS);
          document.dispatchEvent(new CustomEvent('YouTubeGrid:usedTagsUpdated', { detail: window.__usedTagSlugs }));
        } catch (e) { /* non-fatal */ }
        
      } catch (error) {
        console.error('Error loading page configuration:', error);
        showError(`Failed to load playlist configuration for ${pageName}: ${error.message}`);
        
        // Attempt to show error in likely containers
        const likelyIds = [`${pageName}PlaylistsContainer`, `${pageName}-playlists`, 'tutorials'];
        likelyIds.forEach(id => {
          const el = document.getElementById(id);
          if (el) el.innerHTML = `<div class="alert alert-danger">Failed to load content: ${escapeHtml(error.message)}</div>`;
        });
      }
    },

    /**
     * Load specific playlist by ID
     */
    async loadPlaylist(playlistId, options = {}) {
      try {
        const videos = await fetchPlaylistVideos(playlistId, options.maxVideos || CONFIG.defaultVideosPerPlaylist);
        return videos;
      } catch (error) {
        console.error('Error loading playlist:', error);
        return [];
      }
    },

    /**
     * Render playlist in container
     */
    async renderPlaylist(containerId, playlistId, options = {}) {
      const container = document.getElementById(containerId);
      if (!container) {
        console.error(`Container #${containerId} not found`);
        return;
      }

      const videos = await this.loadPlaylist(playlistId, options);
      renderVideoGrid(container, videos, options);
    },

    /**
     * Render a section with custom configuration (exposed for advanced use cases)
     * @param {string} sectionId - Section identifier
     * @param {object} sectionConfig - Section configuration with playlists, columns, render_mode, etc.
     * @param {object} gridConfig - Grid configuration overrides
     */
    async renderSection(sectionId, sectionConfig, gridConfig = {}) {
      return renderSection(sectionId, sectionConfig, gridConfig);
    }
  };

  /**
   * Load canonical tags JSON (if present) so we can map human-friendly names to slugs.
   * Expected format: [{ name: "Unity", slug: "unity", category: "gamedev" }, ...]
   */
  async function loadCanonicalTags() {
    try {
      const resp = await fetch(`${CONFIG.playlistsPath}tags.json`);
      if (!resp.ok) {
        // No canonical tags file available; that's fine — we'll fallback to slugify
        return;
      }
      const tags = await resp.json();
      const byName = Object.create(null);
      const bySlug = Object.create(null);
      if (Array.isArray(tags)) {
        tags.forEach(t => {
          try {
            const name = (t.name || '').toString().trim();
            const slug = (t.slug || '').toString().trim();
            if (name) byName[name.toLowerCase()] = slug || slugify(name);
            if (slug) bySlug[slug.toLowerCase()] = slug;
          } catch (e) { /* ignore malformed entries */ }
        });
      }
      CANONICAL_TAGS = { byName, bySlug };
    } catch (err) {
      // Non-fatal; we will fallback to inline slugify
      console.warn('Could not load canonical tags.json, falling back to slugify:', err && err.message ? err.message : err);
    }
  }

  /**
   * Convert a free-form tag value into a canonical slug when possible.
   */
  function canonicalizeTag(t) {
    if (!t && t !== 0) return '';
    const s = String(t).trim();
    if (!s) return '';
    const lower = s.toLowerCase();
    // Prefer canonical mapping when available
    if (CANONICAL_TAGS) {
      if (CANONICAL_TAGS.bySlug[lower]) return CANONICAL_TAGS.bySlug[lower];
      if (CANONICAL_TAGS.byName[lower]) return CANONICAL_TAGS.byName[lower];
    }
    // Fallback slugify
    return String(s).trim().toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-');
  }

  /**
   * Load YAML configuration file
   */
  async function loadYAMLConfig(pageName) {
    const yamlPath = `${CONFIG.playlistsPath}${pageName}.yaml`;
    
    try {
      const response = await fetch(yamlPath);
      if (!response.ok) {
        throw new Error(`Failed to load ${yamlPath}: ${response.statusText}`);
      }
      
      const yamlText = await response.text();
      
      // js-yaml library exposes itself as jsyaml when loaded via script tag
      if (typeof jsyaml === 'undefined') {
        throw new Error('js-yaml library not loaded. Please include js-yaml script before youtube-grid.js');
      }
      
      const config = jsyaml.load(yamlText);
      
      return config;
    } catch (error) {
      console.error('Error loading YAML config:', error);
      throw error;
    }
  }

  /**
   * Render all sections from page configuration
   */
  async function renderPageSections(config) {
    // Find all sections in config (support both *_section and *_playlists keys for compatibility)
    const sections = Object.keys(config).filter(key => 
      (key.endsWith('_section') || key.endsWith('_playlists')) && typeof config[key] === 'object'
    );

    for (const sectionKey of sections) {
      const section = config[sectionKey];
      // Support both suffixes when deriving the target container id
      const sectionId = sectionKey.replace(/_(?:section|playlists)$/, '');
      
      await renderSection(sectionId, section, config.grid_config || {});
    }
  }

  /**
   * Render a specific section with its playlists
   */
  async function renderSection(sectionId, sectionConfig, gridConfig) {
    // Try to find container by ID pattern
    // sectionId may contain underscores from YAML (e.g., martian_games) - keep as-is for mapping
    // Support explicit container_id override from YAML config
    const containerId = sectionConfig.container_id || `${sectionId}-playlists`;
    const container = document.getElementById(containerId);
    
    if (!container) {
      console.warn(`Container #${containerId} not found, skipping section`);
      return;
    }

    // Clear loading spinner
    container.innerHTML = '';

    // Get playlists from section
    const playlists = sectionConfig.playlists || [];
    
    if (playlists.length === 0) {
      container.innerHTML = '<p class="text-muted">No playlists configured for this section.</p>';
      return;
    }

    // Check if we should render videos directly instead of playlist cards
    const renderMode = sectionConfig.render_mode || 'cards';
    
    if (renderMode === 'videos') {
      // Render individual videos from all playlists in a grid (no playlist card wrappers)
      const columns = sectionConfig.columns || gridConfig[`${sectionId}_columns`] || gridConfig.columns || 3;
      const videosPerPlaylist = gridConfig.videos_per_playlist || CONFIG.defaultVideosPerPlaylist;
      const aspectRatio = sectionConfig.aspect_ratio || '16:9';
      
      // Get responsive column classes
      const colClass = getResponsiveColClasses(columns) || getColumnClass(columns);
      
      // Create a Bootstrap row to hold video columns
      const row = document.createElement('div');
      row.className = 'row g-4';
      
      for (const playlist of playlists) {
        try {
          const videos = await fetchPlaylistVideos(playlist.id, videosPerPlaylist);
          videos.forEach((video, index) => {
            // Create column wrapper
            const col = document.createElement('div');
            col.className = `${colClass} mb-4 video-card`;
            
            // Pass playlist tags and metadata to video thumbnail
            const videoThumb = createVideoThumbnail(video, index, aspectRatio, playlist);
            col.appendChild(videoThumb);
            
            row.appendChild(col);
          });
        } catch (error) {
          console.error(`Error fetching videos for playlist ${playlist.id}:`, error);
        }
      }
      
      container.appendChild(row);
      return;
    }

    // Default: Render playlist cards
    // Determine columns - priority: section config > grid config by section ID > grid config default > 3
    const columns = sectionConfig.columns || gridConfig[`${sectionId}_columns`] || gridConfig.columns || 3;
    
    // Determine videos per playlist - priority: section config > grid config > default
    const videosPerPlaylist = sectionConfig.videos_per_playlist || gridConfig.videos_per_playlist || CONFIG.defaultVideosPerPlaylist;
    
    // Determine layout mode - priority: section config > grid config
    let singleCard = true; // Default to single-card for compact professional look
    if (sectionConfig.layout === 'single-card' || sectionConfig.show_single_video === true) {
      singleCard = true;
    } else if (sectionConfig.layout === 'multi-video' || sectionConfig.show_single_video === false) {
      singleCard = false;
    } else if (gridConfig.layout || gridConfig.show_single_video !== undefined) {
      // Fallback to grid config if explicitly defined
      singleCard = gridConfig.layout === 'single-card' || gridConfig.show_single_video === true;
    }

    // Adjust columns to avoid leaving empty space when we have fewer playlists than the configured column count
    let effectiveColumns = columns;
    if (typeof columns === 'object') {
      const vals = Object.values(columns).map(v => parseInt(v, 10)).filter(n => !isNaN(n));
      if (vals.length) {
        const maxCols = Math.max(...vals);
        if (playlists.length > 0 && playlists.length < maxCols) {
          effectiveColumns = Math.max(1, Math.min(playlists.length, maxCols));
        }
      }
    } else if (typeof columns === 'number') {
      if (playlists.length > 0 && playlists.length < columns) {
        effectiveColumns = Math.max(1, playlists.length);
      }
    }

    // Render each playlist using the effective columns value
    for (const playlist of playlists) {
      const playlistCard = await createPlaylistCard(playlist, {
        columns: effectiveColumns,
        maxVideos: videosPerPlaylist,
        enableHover: gridConfig.enable_hover_effects !== false,
        singleCard: singleCard,
        sectionConfig: sectionConfig
      });
      
      container.appendChild(playlistCard);
    }
  }

  /**
   * Create a playlist card element
   */
  async function createPlaylistCard(playlist, options = {}) {
    const { columns = 3, maxVideos = 6, singleCard = false, sectionConfig = {} } = options;
    
    // Check if responsive columns are configured
    const responsiveCols = getResponsiveColClasses(sectionConfig.columns);
    const columnClass = responsiveCols || getColumnClass(columns);
    
    // Get aspect ratio from section config or playlist config, fallback to 16:9
    const aspectRatio = sectionConfig.aspect_ratio || playlist.aspect_ratio || '16:9';
    const ratioClass = getAspectRatioClass(aspectRatio);
    
    // Pre-calculate badge slug for onclick handler
    const badgeSlug = playlist.badge ? canonicalizeTag(playlist.badge) : '';
    
    // If the playlist explicitly requests an embedded player (embed: true or render_mode: 'embed'), render it and return early
    if (playlist.embed === true || playlist.render_mode === 'embed') {
      const embedCard = document.createElement('div');
      embedCard.className = `${columnClass} mb-4 playlist-card-single`;
      embedCard.innerHTML = `
        <div class="card glass-card h-100 border-0 shadow-sm playlist-embed">
          <div class="ratio ${ratioClass}">
            <iframe src="https://www.youtube.com/embed/videoseries?list=${playlist.id}&controls=1&modestbranding=1&rel=0" title="${escapeHtml(playlist.title || 'Playlist')}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture; web-share" loading="lazy" allowfullscreen></iframe>
          </div>
          <div class="card-body">
            <h5 class="card-title mb-2">
              ${playlist.icon ? `<i class="fa-solid fa-${mapIcon(playlist.icon)} me-2 text-primary"></i>` : ''}
              ${playlist.title}
            </h5>
            ${playlist.description ? `<p class="small text-muted mb-2 line-clamp-2">${playlist.description}</p>` : ''}
            ${playlist.tags && playlist.tags.length ? `<div class="d-flex flex-wrap gap-1 mt-2">${playlist.tags.slice(0,3).map(tag => `<a href="/tags.php?filters=${escapeHtml(tag)}" class="badge bg-secondary bg-opacity-50 text-white tag-badge" onclick="event.stopPropagation();">${escapeHtml(tag)}</a>`).join('')}</div>` : ''}
          </div>
          <div class="card-footer bg-transparent border-0">
            <a href="https://www.youtube.com/playlist?list=${playlist.id}" target="_blank" rel="noopener" class="btn btn-sm btn-youtube w-100">
              <i class="fa-brands fa-youtube me-2"></i>View Full Playlist
            </a>
          </div>
        </div>
      `;
      // Mark as content item so tag filtering still works
      embedCard.classList.add('content-item');
      if (playlist.tags && playlist.tags.length) {
        const slugs = playlist.tags.map(canonicalizeTag).filter(Boolean);
        if (slugs.length) embedCard.setAttribute('data-tags', slugs.join(','));
      }
      return embedCard;
    }
  
  const card = document.createElement('div');
  card.className = `${columnClass} mb-4 ${singleCard ? 'playlist-card-single' : 'playlist-card-multi'}`;
    // Mark playlist cards as content items so the tag system can filter them
    card.classList.add('content-item');
    try {
      // Normalize tags to slugs for consistent filtering (prefer canonical slugs when available)
      if (playlist.tags && Array.isArray(playlist.tags) && playlist.tags.length > 0) {
        const slugs = playlist.tags.map(canonicalizeTag).filter(Boolean);
        slugs.forEach(s => USED_TAG_SLUGS.add(s));
        if (slugs.length) card.setAttribute('data-tags', slugs.join(','));
      } else if (playlist.tags && typeof playlist.tags === 'string') {
        const parts = playlist.tags.split(',').map(s => canonicalizeTag(s)).filter(Boolean);
        parts.forEach(s => USED_TAG_SLUGS.add(s));
        if (parts.length) card.setAttribute('data-tags', parts.join(','));
      }
      if (playlist.category) {
        const cat = canonicalizeTag(playlist.category);
        if (cat) {
          card.setAttribute('data-category', cat);
          USED_TAG_SLUGS.add(cat);
        }
      }
    } catch (e) {
      // Defensive - do not break rendering if tags are malformed
      console.warn('Failed to attach tags to playlist card', e);
    }
    card.style.cssText = 'animation: fadeInUp 0.6s ease-out backwards;';

    // Parallax support - add parallax-layer and data-parallax-speed when enabled
    try {
      // Enable by default unless explicitly disabled in section config
      if (sectionConfig.enable_parallax !== false) {
        const speed = sectionConfig.parallaxSpeed || (singleCard ? 0.06 : 0.04);
        card.classList.add('parallax-layer');
        card.setAttribute('data-parallax-speed', String(speed));
      }
    } catch (e) {
      // Non-fatal - continue rendering without parallax
      console.warn('Failed to attach parallax attributes to playlist card', e);
    }

    // Create card HTML - different structure for single-card layout
    if (singleCard) {
      card.innerHTML = `
        <div class="card glass-card h-100 border-0 shadow-sm hover-lift position-relative">
          <div class="playlist-video-preview" data-playlist-id="${playlist.id}">
            <div class="ratio ${ratioClass} bg-dark">
              <div class="d-flex align-items-center justify-content-center">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="flex-grow-1">
                <h5 class="card-title mb-1">
                  ${playlist.icon ? `<i class="fa-solid fa-${mapIcon(playlist.icon)} me-2 text-primary"></i>` : ''}
                  ${playlist.title}
                </h5>
                <div class="d-flex gap-2 mb-2">
                  ${playlist.featured ? `<span class="badge bg-warning text-dark"><i class="fa-solid fa-star me-1"></i>Featured</span>` : ''}
                  ${playlist.badge ? `<a href="/tags.php?filters=${escapeHtml(badgeSlug)}" class="badge bg-primary text-decoration-none" onclick="event.stopPropagation();">${playlist.badge}</a>` : ''}
                </div>
                ${playlist.description ? `<p class="small text-muted mb-0 line-clamp-2">${playlist.description}</p>` : ''}
              </div>
            </div>
            ${playlist.tags && playlist.tags.length > 0 ? `
              <div class="d-flex flex-wrap gap-1 mt-2">
                ${playlist.tags.slice(0, 3).map(tag => `<a href="/tags.php?filters=${escapeHtml(tag)}" class="badge bg-secondary bg-opacity-50 text-white text-decoration-none tag-badge" data-tag-slug="${escapeHtml(tag)}" style="font-size: 0.7rem;" onclick="event.stopPropagation();">${escapeHtml(tag)}</a>`).join('')}
              </div>
            ` : ''}
          </div>
          <div class="card-footer bg-transparent border-0 playlist-card-footer">
            <a href="https://www.youtube.com/playlist?list=${playlist.id}" 
               target="_blank" 
               rel="noopener"
               class="btn btn-sm btn-outline-primary w-100">
              <i class="fa-brands fa-youtube me-2"></i>View Full Playlist
            </a>
          </div>
        </div>
      `;
    } else {
      // Original multi-video card layout - remove hover-lift from container to prevent double lifting
      // Added playlist-card-multi class for styling targeting
      card.innerHTML = `
        <div class="card glass-card h-100 border-0 shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <div class="flex-grow-1">
                <h5 class="card-title mb-1">
                  <a href="https://www.youtube.com/playlist?list=${playlist.id}" target="_blank" class="text-decoration-none text-body playlist-title-link">
                    ${playlist.icon ? `<i class="fa-solid fa-${mapIcon(playlist.icon)} me-2 text-primary"></i>` : ''}
                    ${playlist.title}
                  </a>
                </h5>
                <div class="d-flex gap-2">
                  ${playlist.featured ? `<span class="badge bg-warning text-dark"><i class="fa-solid fa-star me-1"></i>Featured</span>` : ''}
                  ${playlist.badge ? `<a href="/tags.php?filters=${escapeHtml(badgeSlug)}" class="badge bg-primary text-decoration-none" onclick="event.stopPropagation();">${playlist.badge}</a>` : ''}
                </div>
                ${playlist.description ? `<p class="small text-muted mb-0 mt-2 line-clamp-2">${playlist.description}</p>` : ''}
              </div>
            </div>
            <div class="playlist-videos-container" data-playlist-id="${playlist.id}">
              <div class="text-center py-3">
                <div class="spinner-border spinner-border-sm text-primary" role="status">
                  <span class="visually-hidden">Loading videos...</span>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer bg-transparent border-0 playlist-card-footer">
            <!-- Footer buttons are adjusted below if playlist.page is provided -->
          </div>
        </div>
      `;
    }

    // If playlist.page is set, make the card act as a link using Bootstrap's stretched-link
    try {
      const cardEl = card.querySelector('.card');
      const footerEl = card.querySelector('.playlist-card-footer');
      // Determine page/link target: prefer internal page, then external_url
      const linkTarget = playlist.page || playlist.external_url || null;
      if (linkTarget) {
        // Ensure the card is position-relative so stretched-link can cover it
        cardEl.classList.add('position-relative');

        // Create a page/open button in the footer. If the linkTarget is external, open in new tab.
        const isExternal = /^https?:\/\//i.test(linkTarget);
        footerEl.innerHTML = `
          <div class="d-flex gap-2">
            <a href="${linkTarget}" ${isExternal ? 'target="_blank" rel="noopener"' : ''} 
               class="btn btn-sm btn-primary flex-grow-1 d-flex align-items-center justify-content-center" 
               aria-label="Open ${escapeHtml(playlist.title)} page">
              <i class="fa-solid fa-arrow-up-right-from-square me-2 fs-6"></i>
              <span class="fs-6">Game Page</span>
            </a>
            <a href="https://www.youtube.com/playlist?list=${playlist.id}" 
               target="_blank" rel="noopener" 
               class="btn btn-sm btn-outline-secondary d-flex align-items-center justify-content-center"
               style="min-width: 40px;">
              <i class="fa-brands fa-youtube fs-6"></i>
            </a>
          </div>
        `;

        // Add a stretched-link anchor so the entire card is clickable (for UX)
        const stretch = document.createElement('a');
        stretch.className = 'stretched-link';
        stretch.href = linkTarget;
        if (isExternal) stretch.setAttribute('target', '_blank');
        stretch.setAttribute('aria-hidden', 'true');
        // Append into .card-body so it will stretch across the card
        const body = card.querySelector('.card-body');
        if (body) body.appendChild(stretch);

        // Add a small open-page overlay button in the top-right for discoverability
        try {
          const overlay = document.createElement('a');
          overlay.className = 'open-page-overlay btn btn-sm btn-primary d-flex align-items-center justify-content-center';
          overlay.href = linkTarget;
          overlay.style.cssText = 'position:absolute;right:0.75rem;top:0.75rem;z-index:5;min-width:36px;min-height:36px;';
          overlay.setAttribute('aria-label', 'Open page for ' + (playlist.title || 'playlist'));
          if (isExternal) overlay.setAttribute('target', '_blank');
          // Use a small icon instead of text on very small footers
          overlay.innerHTML = '<i class="fa-solid fa-arrow-up-right-from-square fs-6"></i>';
          cardEl.appendChild(overlay);
        } catch (e) { /* non-fatal */ }
      } else if (!singleCard) {
        // Default footer for multi-video cards: No button, title is linked
        // Hide footer to avoid extra padding
        footerEl.style.display = 'none';
      }
    } catch (e) {
      console.warn('Failed to attach page link to playlist card', e);
    }

    // Load videos for this playlist with aspect ratio from config (already computed above)
    if (singleCard) {
      const previewContainer = card.querySelector('.playlist-video-preview');
      loadSingleVideoPreview(playlist.id, previewContainer, aspectRatio);
    } else {
      const videosContainer = card.querySelector('.playlist-videos-container');
      loadPlaylistVideos(playlist.id, maxVideos, videosContainer, aspectRatio);
    }

    return card;
  }

  /**
   * Get Bootstrap column class based on number of columns
   * Uses Bootstrap 5.3.8 standard responsive patterns
   * Responsive: xs:1, sm:2, md:3, lg:4, xl:6 videos per row
   */
  function getColumnClass(columns) {
    const columnMap = {
      1: 'col-12',                                                    // Always full width
      2: 'col-12 col-md-6',                                           // Mobile: 1col, Tablet+: 2col
      3: 'col-12 col-sm-6 col-md-4',                                  // Mobile: 1col, Small: 2col, Medium+: 3col
      4: 'col-12 col-sm-6 col-md-4 col-lg-3',                         // Mobile: 1col, Small: 2col, Medium: 3col, Large: 4col
      5: 'col-12 col-sm-6 col-md-4 col-lg-2-4',                       // Mobile: 1col, Small: 2col, Medium: 3col, Large: 5col
      6: 'col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2'                // Mobile: 1col, Small: 2col, Medium: 3col, Large: 4col, XL: 6col
    };
    return columnMap[columns] || 'col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2'; // Default to 6-column responsive
  }

  /**
   * Load videos from YouTube API for a playlist
   */
  async function loadPlaylistVideos(playlistId, maxResults, container, aspectRatio = '16:9') {
    try {
      const videos = await fetchPlaylistVideos(playlistId, maxResults);
      
      if (videos.length === 0) {
        // Provide a helpful fallback and a direct playlist link
        container.innerHTML = `<div class="card h-100 bg-transparent border-0 p-3">
          <div class="card-body d-flex flex-column justify-content-center align-items-start">
            <h6 class="mb-2">${escapeHtml(playlistId || 'Playlist')}</h6>
            <p class="small text-muted mb-3">No videos found in this playlist.</p>
            <a href="https://www.youtube.com/playlist?list=${encodeURIComponent(playlistId)}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">View playlist on YouTube</a>
          </div>
        </div>`;
        return;
      }

      // Render video thumbnails with aspect ratio
      container.innerHTML = '';
      
      // Create a row for the videos to display horizontally
      const row = document.createElement('div');
      row.className = 'row g-3';
      
      // Determine column width based on maxResults (responsive 3-6 per row)
      let colClass = 'col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2'; // 6-column responsive
      
      if (maxResults === 1) colClass = 'col-12';
      else if (maxResults === 2) colClass = 'col-12 col-md-6';
      else if (maxResults === 3) colClass = 'col-12 col-sm-6 col-md-4';
      else if (maxResults === 4) colClass = 'col-12 col-sm-6 col-md-4 col-lg-3';

      // After DOM insertion, re-run UI effects so play overlays and tilt effects initialize
      const runUiInits = () => { if (window.mgInitUiEffects) window.mgInitUiEffects(); };
      // Ensure run after short delay so appended elements are available
      const delayedUiInit = () => setTimeout(runUiInits, 60);

      videos.slice(0, maxResults).forEach((video, index) => {
        const col = document.createElement('div');
        col.className = colClass; // Dynamic responsive column width
        
        const videoThumb = createVideoThumbnail(video, index, aspectRatio);
        col.appendChild(videoThumb);
        row.appendChild(col);
      });
      
      container.appendChild(row);
      // Re-run UI inits after DOM insertion so play overlays, tilt, and parallax initialize correctly
      try { delayedUiInit(); } catch (e) { /* non-fatal */ }

    } catch (error) {
      console.error(`Error loading playlist ${playlistId}:`, error);
      container.innerHTML = '<p class="small text-danger">Failed to load videos</p>';
    }
  }

  /**
   * Load single video preview (first video from playlist as large thumbnail)
   */
  async function loadSingleVideoPreview(playlistId, container, aspectRatio = '16:9') {
    try {
      const videos = await fetchPlaylistVideos(playlistId, 1);
      
      if (videos.length === 0) {
        // Fallback: Use YouTube's standard playlist thumbnail URL
        renderFallbackPlaylistThumbnail(playlistId, container, aspectRatio);
        return;
      }

      const video = videos[0];
      container.innerHTML = '';
      
      // Create large clickable thumbnail with configurable aspect ratio
      const ratioClass = getAspectRatioClass(aspectRatio);
      const preview = document.createElement('div');
      preview.className = `ratio ${ratioClass} rounded-top overflow-hidden position-relative`;
      preview.style.cursor = 'pointer';
      
      preview.innerHTML = `
        <img src="${video.thumbnail}" 
             alt="${escapeHtml(video.title)}" 
             class="object-fit-cover w-100 h-100 hover-zoom"
             loading="lazy"
             onerror="this.src='https://i.ytimg.com/vi_webp/0/mqdefault.webp'; this.onerror=null;">
        <div class="play-overlay">
          <i class="fa-solid fa-circle-play" style="font-size: 4rem; color: white; text-shadow: 0 2px 8px rgba(0,0,0,0.5);"></i>
        </div>
        <div class="position-absolute bottom-0 start-0 end-0 p-2 text-white" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
          <small class="d-block text-truncate">${escapeHtml(video.title)}</small>
        </div>
      `;
      
      // Click handler to open video modal
      preview.addEventListener('click', () => openVideoModal(video));
      preview.setAttribute('role', 'button');
      preview.setAttribute('tabindex', '0');
      preview.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          openVideoModal(video);
        }
      });
      
      container.appendChild(preview);

    } catch (error) {
      console.error(`Error loading preview for playlist ${playlistId}:`, error);
      // Use fallback thumbnail instead of error message
      renderFallbackPlaylistThumbnail(playlistId, container, aspectRatio);
    }
  }

  /**
   * Render fallback playlist thumbnail when API fails
   * Uses YouTube's embed thumbnail URL pattern or static images
   */
  function renderFallbackPlaylistThumbnail(playlistId, container, aspectRatio = '16:9') {
    container.innerHTML = '';
    
    const ratioClass = getAspectRatioClass(aspectRatio);
    const preview = document.createElement('div');
    preview.className = `ratio ${ratioClass} rounded-top overflow-hidden position-relative`;
    preview.style.cursor = 'pointer';
    
    // Try to use a static thumbnail image if available
    const staticThumb = `${RESOURCE_BASE}/images/playlists/${playlistId}.jpg`;
    
    // YouTube provides playlist thumbnails via this pattern
    // We'll show a playlist icon overlay since we can't get the actual thumbnail without API
    preview.innerHTML = `
      <div class="playlist-fallback-bg d-flex align-items-center justify-content-center w-100 h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <img src="${staticThumb}" 
             alt="Playlist thumbnail" 
             class="w-100 h-100 object-fit-cover position-absolute top-0 start-0"
             style="display: none;"
             onerror="this.style.display='none';"
             onload="this.style.display='block'; this.parentElement.style.background='none'; const icon = this.parentElement.querySelector('.playlist-icon'); if(icon) icon.style.display='none';">
        <div class="text-center text-white playlist-icon" style="position: relative; z-index: 1;">
          <i class="fa-solid fa-layer-group" style="font-size: 5rem; opacity: 0.8;"></i>
          <p class="small mt-2 mb-0">Playlist Preview</p>
        </div>
      </div>
      <div class="play-overlay">
        <i class="bi bi-play-circle-fill" style="font-size: 4rem; color: white; text-shadow: 0 2px 8px rgba(0,0,0,0.5);"></i>
      </div>
    `;
    
    // Click to open YouTube playlist page (since we don't have video data)
    preview.addEventListener('click', () => {
      window.open(`https://www.youtube.com/playlist?list=${playlistId}`, '_blank', 'noopener');
    });
    preview.setAttribute('role', 'button');
    preview.setAttribute('tabindex', '0');
    preview.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        window.open(`https://www.youtube.com/playlist?list=${playlistId}`, '_blank', 'noopener');
      }
    });
    
    container.appendChild(preview);
  }

  /**
   * Fetch playlist videos from YouTube RSS feed (NO API KEY NEEDED)
   * Uses server-side proxy to avoid CORS, cached for 10 minutes
   */
  async function fetchPlaylistVideos(playlistId, maxResults = 6) {
    // Check cache first (24 hour cache)
    const cacheKey = `playlist_${playlistId}_${maxResults}`;
    const cached = cache.get(cacheKey);
    
    if (cached && Date.now() - cached.timestamp < CONFIG.cacheExpiry) {
      return cached.data;
    }

    // Use RSS feed via server-side proxy (no API needed!)
    try {
      const proxyUrl = `${RESOURCE_BASE}/api/get-youtube.php?playlist_id=${encodeURIComponent(playlistId)}`;
      const resp = await fetch(proxyUrl);
      
      if (!resp.ok) {
        console.warn(`RSS fetch failed for playlist ${playlistId}: ${resp.status}`);
        // Try client-side proxy fallbacks before giving up
        try {
          const fallback = await fetchPlaylistViaProxies(playlistId, maxResults);
          if (fallback && fallback.length) {
            // Cache and return fallback
            cache.set(cacheKey, { data: fallback, timestamp: Date.now() });
            return fallback;
          }
        } catch (e) { /* fall through */ }
        return [];
      }
      
      const data = await resp.json();
      
      // Handle both single entry (object) and multiple entries (array)
      let items = data.entry || data.items || [];
      if (!Array.isArray(items)) {
        items = [items]; // Wrap single entry in array
      }
      
      if (items.length === 0) {
        console.warn(`No videos found in playlist ${playlistId}`);
        // Try client-side proxy fallbacks before giving up
        const fallback = await fetchPlaylistViaProxies(playlistId, maxResults);
        if (fallback && fallback.length) {
          cache.set(cacheKey, { data: fallback, timestamp: Date.now() });
          return fallback;
        }
        return [];
      }
      
      // Convert RSS entries to video objects with actual RSS thumbnail URLs
      const videos = items.slice(0, maxResults).map(item => {
        const link = item.link && (item.link['@attributes'] && item.link['@attributes'].href) ? item.link['@attributes'].href : (item.link && item.link.href) || '';
        
        // Use videoId from proxy (already extracted from yt:videoId or id)
        const vid = item.videoId || (link.match(/[?&]v=([^&]+)/) || [])[1] || (item.id && item.id.split(':').pop()) || '';
        
        // Use thumbnail from proxy (already extracted from media:thumbnail or fallback)
        let thumb = item.thumbnail || '';
        
        // Final fallback to standard YouTube thumbnail URL if proxy didn't provide one
        if (!thumb && vid) {
          thumb = `https://img.youtube.com/vi/${vid}/mqdefault.jpg`;
        }
        
        return {
          id: vid || '',
          title: item.title || 'Untitled Video',
          thumbnail: thumb,
          publishedAt: item.published || item.pubDate || ''
        };
      }).filter(v => v.id); // Remove any entries without video IDs

      // Cache the result (24 hours)
      cache.set(cacheKey, { data: videos, timestamp: Date.now() });
      
      return videos;

    } catch (err) {
      console.error(`Error fetching playlist ${playlistId} via RSS:`, err);
      return [];
    }
  }

  /**
   * Create video thumbnail element with Bootstrap card styling
   * @param {Object} video - Video data object
   * @param {number} index - Video index for animation delay
   * @param {string} aspectRatio - Aspect ratio (16:9, 9:16, etc.)
   * @param {Object} playlist - Optional playlist metadata for tags/context
   */
  function createVideoThumbnail(video, index, aspectRatio = '16:9', playlist = null) {
    const ratioClass = getAspectRatioClass(aspectRatio);
    console.log(`🎬 Creating video thumbnail: aspectRatio="${aspectRatio}", ratioClass="${ratioClass}"`);
    
    // Create card wrapper
    const card = document.createElement('div');
    card.className = 'card glass-card h-100 border-0 shadow-sm hover-lift';
    card.style.cssText = `animation: fadeInUp 0.6s ease-out backwards; animation-delay: ${index * 0.1}s;`;
    
    // Add tags to card for filtering
    if (playlist && playlist.tags && Array.isArray(playlist.tags) && playlist.tags.length > 0) {
      card.classList.add('content-item');
      const slugs = playlist.tags.map(canonicalizeTag).filter(Boolean);
      slugs.forEach(s => USED_TAG_SLUGS.add(s));
      if (slugs.length) card.setAttribute('data-tags', slugs.join(','));
    }
    
    card.innerHTML = `
      <div class="ratio ${ratioClass} rounded-top overflow-hidden" style="cursor: pointer;" role="button" tabindex="0" data-video-id="${video.id}">
        <img src="${video.thumbnail}" 
             alt="${escapeHtml(video.title)}" 
             class="object-fit-cover hover-zoom"
             loading="lazy">
        <div class="play-overlay">
          <i class="fa-solid fa-circle-play" style="font-size: 3rem; color: white; text-shadow: 0 2px 8px rgba(0,0,0,0.5);"></i>
        </div>
      </div>
      <div class="card-body p-3">
        <h6 class="card-title mb-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;" title="${escapeHtml(video.title)}">${escapeHtml(video.title)}</h6>
        ${playlist && playlist.tags && playlist.tags.length > 0 ? `
          <div class="d-flex flex-wrap gap-1 mt-2">
            ${playlist.tags.slice(0, 3).map(tag => {
              const slug = canonicalizeTag(tag);
              return `<a href="/tags.php?filters=${escapeHtml(slug)}" class="badge bg-secondary bg-opacity-50 text-white text-decoration-none tag-badge" data-tag-slug="${escapeHtml(slug)}" style="font-size: 0.625rem; padding: 0.25rem 0.5rem; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='#6750A4'; this.style.transform='translateY(-2px)';" onmouseout="this.style.backgroundColor=''; this.style.transform='';">${escapeHtml(tag)}</a>`;
            }).join('')}
          </div>
        ` : ''}
      </div>
    `;

    // Add click/keyboard handlers to the video thumbnail
    const videoThumb = card.querySelector('[data-video-id]');
    if (video && video.id && videoThumb) {
      videoThumb.addEventListener('click', (e) => {
        const target = e.target || e.srcElement;
        if (target && (target.closest && target.closest('a'))) return;
        openVideoModal(video);
      });

      videoThumb.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          openVideoModal(video);
        }
      });
    } else {
      card.style.opacity = '0.9';
      if (videoThumb) {
        videoThumb.style.cursor = 'default';
        videoThumb.removeAttribute('role');
        videoThumb.removeAttribute('tabindex');
      }
    }

    return card;
  }

  /**
   * Render video grid with responsive Bootstrap columns
   */
  function renderVideoGrid(container, videos, options = {}) {
    const { columns = 3, aspectRatio = '16:9' } = options;
    
    // Clear container
    container.innerHTML = '';
    
    // Create a row wrapper for responsive grid
    const row = document.createElement('div');
    row.className = 'row g-4';
    
    // Get column class based on columns setting
    const colClass = getColumnClass(columns);
    
    videos.forEach((video, index) => {
      // Create column wrapper
      const col = document.createElement('div');
      col.className = colClass;
      
      // Create video thumbnail with aspect ratio
      const videoCard = createVideoThumbnail(video, index, aspectRatio);
      col.appendChild(videoCard);
      
      row.appendChild(col);
    });
    
    container.appendChild(row);
  }


  /**
   * Open video in modal
   */
  function openVideoModal(video) {
    let modal = document.getElementById('videoModal');
    
    if (!modal) {
      modal = createVideoModal();
      document.body.appendChild(modal);
    }

    const modalTitle = modal.querySelector('.modal-title');
    const modalBody = modal.querySelector('.modal-body');
    
    modalTitle.textContent = video.title;
    modalBody.innerHTML = `
      <div class="ratio ratio-16x9">
        <iframe src="https://www.youtube.com/embed/${video.id}?autoplay=1" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen>
        </iframe>
      </div>
    `;
    
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
    
    modal.addEventListener('hidden.bs.modal', () => {
      modalBody.innerHTML = '';
    }, { once: true });
  }

  /**
   * Create video modal
   */
  function createVideoModal() {
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.id = 'videoModal';
    modal.tabIndex = -1;
    
    modal.innerHTML = `
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Video</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-0">
            <!-- Video iframe inserted here -->
          </div>
        </div>
      </div>
    `;
    
    return modal;
  }

  /**
   * Show error message
   */
  function showError(message) {
    console.error(message);
    // Could add toast notification here
  }

  /**
   * Escape HTML to prevent XSS
   */
  function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  /**
   * Add custom styles
   */
  function addStyles() {
    if (document.getElementById('youtube-grid-styles')) return;
    
    const style = document.createElement('style');
    style.id = 'youtube-grid-styles';
    style.textContent = `
      /* Video grid responsive enhancements */
      .video-grid-container .row {
        margin-left: -0.5rem;
        margin-right: -0.5rem;
      }
      
      .video-grid-container .row > [class*="col-"] {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
      }
    `;
    document.head.appendChild(style);
  }

  /**
   * Initialize
   */
  function init() {
    addStyles();
    // Expose API globally
    window.YouTubeGrid = YouTubeGrid;
    // Backwards-compatible helper used in some pages
    if (!window.YouTubeGrid.renderPlaylistSection) {
      window.YouTubeGrid.renderPlaylistSection = function(containerId, playlistId, options) {
        // pages sometimes pass containerId as element id or as a section id; support both
        try {
          YouTubeGrid.renderPlaylist(containerId, playlistId, options);
        } catch (e) {
          console.warn('renderPlaylistSection fallback failed:', e);
        }
      };
    }
    // Auto-initialize any simple video-grid containers using data-playlist
    try {
      document.querySelectorAll('.video-grid-container[data-playlist], .video-grid[data-playlist]').forEach(function(el) {
        var playlistId = el.getAttribute('data-playlist');
        if (!playlistId) return;
        // ensure the element has an id for renderPlaylist
        if (!el.id) el.id = 'ytgrid-' + Math.random().toString(36).slice(2, 9);
        // allow optional data-max and data-columns attributes
        var opts = {};
        var max = el.getAttribute('data-max');
        if (max) opts.maxVideos = parseInt(max, 10);
        var cols = el.getAttribute('data-columns');
        if (cols) opts.columns = parseInt(cols, 10);
        // Delegate to exposed API
        window.YouTubeGrid.renderPlaylist(el.id, playlistId, opts);
      });
    } catch (e) {
      // non-fatal
      console.warn('Auto-initializing video-grid-containers failed:', e);
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();

