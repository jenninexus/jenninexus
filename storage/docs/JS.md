# JavaScript Architecture - JenniNexus
**Last Updated:** January 2, 2026  
**Status:** ✅ CONSOLIDATED & CURRENT  
**Purpose:** Complete JavaScript file inventory, loading patterns, and integration documentation

---

## 📊 JavaScript File Inventory

### Core Scripts (Loaded on ALL Pages via footer.php)

| File | Size | Purpose | Exports | Dependencies |
|------|------|---------|---------|--------------|
| **theme-toggle.js** | 3.2 KB | Dark/light mode switching | `window.themeToggle` | localStorage |
| **back-to-top.js** | 2.8 KB | Scroll-to-top button | `window.JenniBackToTop` | None |
| **performance-optimizer.js** | 4.1 KB | Device/connection detection | `window.performanceOptimizer` | None |
| **polyfills.js** | 2.3 KB | Browser compatibility shims | None | None |
| **ui-effects.js** | 6.7 KB | Parallax, card tilt, stat counters | `window.uiEffects` | None |
| **tag-filter-api.js** | 5.4 KB | Tag state management | `window.tagFilter` | localStorage |

**Total Core Scripts:** 24.5 KB (unminified) → ~9.8 KB (minified + gzip)

### Page-Specific Scripts (Loaded via $pageScripts)

| File | Size | Used By | Purpose | Dependencies |
|------|------|---------|---------|--------------|
| **youtube-grid.js** | 32.1 KB | gaming.php, gamedev.php, youtube.php, game/*.php | YouTube RSS feed renderer | js-yaml |
| **tag-system.js** | 12.8 KB | All content hubs | Tag filtering & offcanvas UI | tag-filter-api.js |
| **tag-cloud.js** | 4.3 KB | tags.php | Tag cloud visualization | D3.js (optional) |
| **live-status.js** | 3.9 KB | live.php | Twitch/YouTube live detection | Fetch API |
| **patreon-auth-enhanced.js** | 18.7 KB | patreon.php, vip.php | OAuth2 + VIP content gating | youtube-grid.js |
| **diy-playlists.js** | 14.2 KB | diy.php | DIY playlist rendering (LEGACY) | Fetch API |
| **compat-resume.js** | 1.8 KB | resume.php | Resume page compatibility | None |

**Total Page-Specific:** 87.8 KB (unminified)

### External Dependencies (CDN)

| Library | Version | Used By | Purpose |
|---------|---------|---------|---------|
| **js-yaml** | 4.1.0 | youtube-grid.js | YAML config parsing |
| **Bootstrap Bundle** | 5.3.8 | All pages | Modal, Offcanvas, Carousel, etc. |

### Archived/Deprecated Scripts

| File | Status | Reason | Archived Date |
|------|--------|--------|---------------|
| **martian-games.js** | ❌ ARCHIVED | Replaced by youtube-grid.js + gamedev.yaml | Nov 10, 2025 |
| **music-playlists.js** | ❌ ARCHIVED | music.php uses hardcoded iframes | Nov 10, 2025 |

---

## 🏗️ Script Loading Architecture

### Load Order (footer.php lines 137-150)

```php
<!-- 1. Bootstrap Bundle (FIRST - provides Modal, Offcanvas) -->
<script src="<?= RES_ROOT ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- 2. Core Scripts (in dependency order) -->
<script src="<?= RES_ROOT ?>/js/theme-toggle<?= $assetSuffix ?>.js"></script>
<script src="<?= RES_ROOT ?>/js/performance-optimizer<?= $assetSuffix ?>.js"></script>
<script src="<?= RES_ROOT ?>/js/polyfills<?= $assetSuffix ?>.js"></script>
<script src="<?= RES_ROOT ?>/js/ui-effects<?= $assetSuffix ?>.js"></script>
<script src="<?= RES_ROOT ?>/js/back-to-top<?= $assetSuffix ?>.js"></script>
<script src="<?= RES_ROOT ?>/js/tag-filter-api<?= $assetSuffix ?>.js"></script>

<!-- 3. Page-Specific Scripts (via $pageScripts array) -->
<?php
if (!empty($pageScripts) && is_array($pageScripts)) {
  foreach ($pageScripts as $script) {
    echo '<script src="' . htmlspecialchars($script) . '"></script>';
  }
}
?>
```

### Environment-Aware Loading ($assetSuffix)

**Defined in footer.php:**
```php
$isLocal = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1']) 
           || strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false
           || strpos($_SERVER['HTTP_HOST'] ?? '', '8002') !== false;
$assetSuffix = $isLocal ? '' : '.min';
```

**Result:**
- **Local dev:** `theme-toggle.js` (unminified, easier debugging)
- **Production:** `theme-toggle.min.js` (minified, faster loading)

---

## 📋 Script Loading Patterns by Page Type

### Pattern A: Video Grid Pages (RECOMMENDED) ✅

**Used By:** gaming.php, gamedev.php, youtube.php, game/*.php

**Script Load Order (CRITICAL):**
```php
<?php
$pageScripts = [
    'https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js',  // 1. YAML parser
    RES_ROOT . '/js/youtube-grid.js',                                   // 2. Playlist renderer
    RES_ROOT . '/js/tag-system.js'                                      // 3. Tag event listener
];
include __DIR__ . '/includes/footer.php';
?>
<script>
  // Initialize after DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      window.YouTubeGrid.loadPageConfig('gaming');
    });
  } else {
    window.YouTubeGrid.loadPageConfig('gaming');
  }
</script>
```

**Why This Order:**
1. `js-yaml` must load FIRST (youtube-grid depends on it for YAML parsing)
2. `youtube-grid.js` loads SECOND (fires `YouTubeGrid:usedTagsUpdated` event)
3. `tag-system.js` loads LAST (listens for tag event from youtube-grid)

**Common Error:** Loading tag-system.js before youtube-grid.js causes tag detection failure

### Pattern B: Static Content Pages ✅

**Used By:** resume.php, services.php, links.php

**No Page-Specific Scripts:**
```php
<?php include __DIR__ . '/includes/footer.php'; ?>
```

**Only Core Scripts Load:**
- theme-toggle.js
- back-to-top.js
- ui-effects.js (for parallax if used)

### Pattern C: Blog Pages ✅

**Used By:** blog.php, blog/*.php

**Minimal Scripts:**
```php
<?php
// blog.php uses tag-system for filtering
$pageScripts = [RES_ROOT . '/js/tag-system.js'];
include __DIR__ . '/../includes/footer.php';
?>
```

**Individual blog posts:** No page-specific scripts (inherit core only)

### Pattern D: Authenticated Pages ✅

**Used By:** patreon.php, vip.php

**OAuth + Content Loading:**
```php
<?php
$pageScripts = [
    'https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js',
    RES_ROOT . '/js/youtube-grid.js',
    RES_ROOT . '/js/patreon-auth-enhanced.js'
];
include __DIR__ . '/includes/footer.php';
?>
```

**Features:**
- OAuth2 authentication flow
- Dynamic VIP content section creation
- Gated playlist loading
- PDF viewer embeds

---

## 🔧 Core Script Details

### 1. theme-toggle.js ✅

**Purpose:** Dark/light mode switching with system preference detection

**Features:**
- Auto-detects system theme preference
- Persists selection to localStorage
- Smooth transitions between modes
- Updates icon dynamically

**Global API:**
```javascript
window.themeToggle = {
  toggle: () => {},      // Toggle between dark/light
  setTheme: (theme) => {}, // Set specific theme ('dark'/'light')
  getTheme: () => {}     // Get current theme
};
```

**HTML Element (footer.php line 38):**
```html
<button class="btn btn-link p-0" id="themeToggle" aria-label="Toggle theme">
  <!-- Icon injected by JS -->
</button>
```

**localStorage Key:** `jn-theme`

### 2. back-to-top.js ✅

**Purpose:** Scroll-to-top button functionality

**Features:**
- Auto-shows after scrolling 300px
- Smooth scroll animation
- Supports multiple selectors: `#backToTop`, `.back-to-top`, `[data-back-to-top]`
- Throttled scroll listener (performance)

**Global API:**
```javascript
window.JenniBackToTop = {
  show: () => {},     // Manually show button
  hide: () => {},     // Manually hide button
  scrollToTop: () => {} // Trigger scroll animation
};
```

**HTML Element (footer.php lines 116-120):**
```html
<button id="backToTop" 
        class="btn btn-primary rounded-circle position-fixed bottom-0 end-0 m-2 shadow-lg"
        style="display: none !important; width: 50px; height: 50px; z-index: 1050;">
  <i class="bi bi-arrow-up fs-5"></i>
</button>
```

**CSS:** Defined in custom.css lines 2591-2612

### 3. performance-optimizer.js ✅

**Purpose:** Device/connection detection for adaptive loading

**Features:**
- Detects device type (mobile/tablet/desktop)
- Monitors network connection speed
- Provides performance hints for lazy loading
- Battery status awareness (if available)

**Global API:**
```javascript
window.performanceOptimizer = {
  isMobile: boolean,
  isSlowConnection: boolean,
  shouldLazyLoad: boolean,
  getDeviceType: () => string,
  getConnectionSpeed: () => string
};
```

**Usage Example:**
```javascript
if (window.performanceOptimizer.shouldLazyLoad) {
  // Enable lazy loading for images
}
```

### 4. polyfills.js ✅

**Purpose:** Browser compatibility shims for older browsers

**Features:**
- Adds missing Array.prototype methods
- Adds Object.assign polyfill
- Adds CustomEvent polyfill
- Adds fetch API polyfill (if needed)

**No Global API** - Patches native objects only

### 5. ui-effects.js ✅

**Purpose:** Interactive UI effects (parallax, tilt, counters)

**Features:**
- Parallax scrolling (`data-parallax-speed`)
- 3D card tilt effect
- Copy-to-clipboard functionality
- Animated stat counters (`data-target`)
- Scroll reveal animations

**Global API:**
```javascript
window.uiEffects = {
  initParallax: () => {},
  initCardTilt: () => {},
  initStatCounters: () => {},
  copyToClipboard: (text) => {}
};
```

**Data Attributes:**
- `data-parallax-speed="0.5"` - Parallax scroll speed
- `data-target="100"` - Stat counter target number
- `data-copy="text"` - Copy button text content
- `data-copy-success-icon="fa-check"` - Success icon class

### 6. tag-filter-api.js ✅

**Purpose:** Tag state management and filtering logic

**Features:**
- Add/remove/toggle tags
- Active filter persistence (localStorage)
- Tag query string parsing
- Event dispatching for UI updates

**Global API:**
```javascript
window.tagFilter = {
  init: () => {},                    // Initialize system
  toggle: (slug) => {},              // Toggle tag on/off
  add: (slug) => {},                 // Add tag to filters
  remove: (slug) => {},              // Remove tag
  clear: () => {},                   // Clear all filters
  getActive: () => [],               // Get active tag slugs
  applyFilters: (contentItems) => {} // Filter DOM elements
};
```

**localStorage Key:** `jn-active-filters`

**Events Dispatched:**
- `tagFilter:updated` - When filters change
- `tagFilter:cleared` - When filters are cleared

---

## 🎬 Page-Specific Script Details

### 1. youtube-grid.js (32.1 KB) ✅

**Purpose:** YouTube RSS feed renderer with Bootstrap grid integration

**Features:**
- YAML config parsing (requires js-yaml)
- RSS feed fetching via proxy
- Bootstrap responsive grid rendering
- Tag badge generation
- Aspect ratio handling (16:9, 9:16)
- Client-side caching (24hr)

**Global API:**
```javascript
window.YouTubeGrid = {
  loadPageConfig: (configName) => {},     // Load {configName}.yaml
  renderSection: (config) => {},          // Render specific section
  fetchPlaylistVideos: (playlistId) => {} // Fetch RSS feed
};
```

**Configuration Object:**
```javascript
{
  container_id: 'video-container',        // DOM element ID
  playlist_id: 'PL9QBjNDhgNwQ...',       // YouTube playlist ID
  columns: { xs: 1, sm: 2, md: 2, lg: 3 }, // Responsive columns
  aspect_ratio: '16:9',                   // Video aspect ratio
  max_results: 12,                        // Videos per playlist
  tags: ['gaming', 'highlights']          // Filter tags
}
```

**Dependencies:**
- js-yaml (YAML parsing)
- Fetch API (RSS proxy calls)
- Bootstrap 5.3.8 (grid classes)

**RSS Proxy:** `resources/api/get-youtube.php`

**Cache:** localStorage `playlist_{playlistId}_{maxResults}` (24hr TTL)

**Event Fired:** `YouTubeGrid:usedTagsUpdated` (for tag-system.js)

### 2. tag-system.js (12.8 KB) ✅

**Purpose:** Tag filtering UI and offcanvas management

**Features:**
- Offcanvas sidebar control
- Tag checkbox state management
- Active filter badge rendering
- Multi-tag filtering
- Query string navigation (`?filters=tag1,tag2`)

**Global API:**
```javascript
window.tagSystem = {
  init: () => {},                  // Initialize offcanvas
  showOffcanvas: () => {},         // Open filter sidebar
  applyFilters: () => {},          // Apply checked tags
  clearFilters: () => {},          // Clear all tags
  updateActiveDisplay: () => {}    // Update badge UI
};
```

**Dependencies:**
- tag-filter-api.js (state management)
- Bootstrap Offcanvas (UI component)

**HTML Required:** `includes/tag-filter-offcanvas.php`

**Event Listeners:**
- `YouTubeGrid:usedTagsUpdated` - Syncs tags from video grid
- `tagFilter:updated` - Updates UI when filters change

### 3. tag-cloud.js (4.3 KB) ✅

**Purpose:** Tag cloud visualization with size-based importance

**Features:**
- Frequency-based tag sizing
- Clickable tag navigation
- D3.js integration (optional)
- Responsive layout

**Global API:**
```javascript
window.tagCloud = {
  render: (container, tags) => {},  // Render cloud in element
  update: (tags) => {}              // Update existing cloud
};
```

**Tag Data Format:**
```javascript
[
  { slug: 'gamedev', name: 'Game Dev', count: 42 },
  { slug: 'unity', name: 'Unity', count: 28 }
]
```

**Usage:**
```html
<div id="tag-cloud-container"></div>
<script>
  window.tagCloud.render('tag-cloud-container', tagData);
</script>
```

### 4. live-status.js (3.9 KB) ⚠️

**Purpose:** Check Twitch/YouTube live status

**Features:**
- Twitch API check (via DecAPI)
- YouTube RSS feed check
- Live indicator badge updates
- 60-second polling interval

**Global API:**
```javascript
window.checkLiveStatus = () => {};  // Manual status check
```

**Auto-Initialization:** Runs on DOM ready, polls every 60s

**HTML Required:**
```html
<div id="live-status-indicator" class="d-none">
  <!-- Populated when live -->
</div>
```

**APIs Used:**
- DecAPI Twitch: `https://decapi.me/twitch/uptime/{channel}`
- YouTube RSS: Via `resources/api/get-youtube.php`

**Page-Specific:** Only loaded on live.php

### 5. patreon-auth-enhanced.js (18.7 KB) ⚠️

**Purpose:** Patreon OAuth2 + VIP content gating

**Features:**
- OAuth2 login flow (authorization code grant)
- Token storage (localStorage)
- Membership verification
- Dynamic VIP section creation
- PDF viewer embeds
- Gated playlist loading

**Global API:**
```javascript
window.patreonAuth = {
  init: () => {},                    // Initialize auth system
  startAuth: () => {},               // Begin OAuth flow
  checkMembership: () => {},         // Verify patron status
  logout: () => {}                   // Clear tokens
};

// Legacy helpers
window.fetchPatreonPosts = () => {};
window.startPatreonAuth = () => {};
```

**localStorage Keys:**
- `patreon_access_token`
- `patreon_refresh_token`
- `patreon_token_expiry`

**OAuth Flow:**
1. User clicks "Connect Patreon"
2. Redirects to Patreon OAuth
3. Callback to `patreon-callback.php`
4. Token exchange and storage
5. Membership verification
6. VIP content unlock

**Dependencies:**
- youtube-grid.js (for VIP playlist loading)
- Fetch API (for API calls)

**APIs Used:**
- `/resources/api/check-patreon-membership.php`
- `/resources/api/get-patreon-tiers.php`
- `/resources/api/get-patreon-posts.php`

**Page-Specific:** Only loaded on patreon.php and vip.php

### 6. diy-playlists.js (14.2 KB) ⚠️ LEGACY

**Purpose:** DIY playlist rendering (DUPLICATE of youtube-grid.js)

**Status:** ⚠️ **MIGRATION CANDIDATE** - 80% code duplication with youtube-grid.js

**Features:**
- RSS feed parsing
- Playlist card rendering
- Tag badge generation
- TikTok embeds (9:16 ratio)

**Issues:**
- Duplicates youtube-grid.js functionality
- Hardcoded playlist IDs
- Maintenance debt (2 renderers doing same thing)
- Tag badges implemented differently

**Migration Plan:**
1. Create/verify `diy.yaml` completeness
2. Update `diy.php` to use youtube-grid.js + YAML pattern
3. Move TikTok embed code to inline script
4. Test tag filtering and RSS feed
5. Archive diy-playlists.js

**Priority:** 🟡 Medium (works but creates maintenance debt)

### 7. compat-resume.js (1.8 KB) ✅

**Purpose:** Resume page browser compatibility

**Features:**
- Print stylesheet fixes
- PDF download link handling
- Mobile viewport adjustments

**No Global API** - Patches resume.php specifically

**Page-Specific:** Only loaded on resume.php

---

## 🎯 Integration Best Practices

### ✅ DO

**1. Use `$pageScripts` for Page-Specific JS**
```php
<?php
$pageScripts = [
    'https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js',
    RES_ROOT . '/js/youtube-grid.js'
];
include __DIR__ . '/includes/footer.php';
?>
```

**2. Export Global APIs for Reusability**
```javascript
(function() {
  // Private scope
  function privateHelper() { }
  
  // Public API
  window.myModule = {
    publicMethod: function() { }
  };
})();
```

**3. Auto-Initialize on DOM Ready**
```javascript
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}

function init() {
  // Initialization code
}
```

**4. Check for Dependencies Before Using**
```javascript
if (typeof jsyaml === 'undefined') {
  console.error('js-yaml not loaded');
  return;
}
```

### ❌ DON'T

**1. Don't Add Inline `<script>` Tags in Page HTML**
```html
<!-- BAD -->
<script src="/resources/js/youtube-grid.js"></script>

<!-- GOOD -->
<?php
$pageScripts = [RES_ROOT . '/js/youtube-grid.js'];
?>
```

**2. Don't Load Heavy Libraries Sitewide**
```php
<!-- BAD - loads js-yaml on ALL pages -->
<script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>

<!-- GOOD - only on pages that need it -->
<?php
$pageScripts = ['https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js'];
?>
```

**3. Don't Assume Dependencies Are Loaded**
```javascript
// BAD
window.YouTubeGrid.loadPageConfig('gaming');

// GOOD
if (window.YouTubeGrid && typeof window.YouTubeGrid.loadPageConfig === 'function') {
  window.YouTubeGrid.loadPageConfig('gaming');
}
```

**4. Don't Pollute Global Scope Unnecessarily**
```javascript
// BAD
var myHelper = function() { };

// GOOD
(function() {
  var myHelper = function() { };
  // Only expose what's needed
})();
```

---

## 🧪 Testing Checklist

### Core Scripts

- [x] theme-toggle.js - Loads on all pages, persists theme
- [x] back-to-top.js - Button appears after 300px scroll
- [x] performance-optimizer.js - Detects device type correctly
- [x] polyfills.js - No console errors on IE11
- [x] ui-effects.js - Parallax, tilt, stat counters work
- [x] tag-filter-api.js - Tag state persists across page loads

### Page-Specific Scripts

- [x] youtube-grid.js - Renders playlists from YAML
- [x] tag-system.js - Offcanvas opens, filters apply
- [x] tag-cloud.js - Tag cloud renders with correct sizes
- [x] live-status.js - Updates when channels go live
- [x] patreon-auth-enhanced.js - OAuth flow completes
- [ ] diy-playlists.js - To be migrated to youtube-grid.js

### Script Load Order

- [x] Bootstrap Bundle loads first
- [x] Core scripts load in dependency order
- [x] js-yaml loads before youtube-grid.js
- [x] youtube-grid.js loads before tag-system.js
- [x] Page-specific scripts load after core

### Environment Detection

- [x] Local dev uses unminified scripts (.js)
- [x] Production uses minified scripts (.min.js)
- [x] $assetSuffix correctly set in head.php and footer.php

---

## 📝 Maintenance Guidelines

### Adding a New JavaScript File

1. Create file in `src/assets/js/`
2. Add to build.ps1 copy list
3. Create minified version via optimize-assets.ps1
4. Document in this file (JS.md)
5. Add to appropriate loading pattern
6. Test in local dev and production

### Deprecating a JavaScript File

1. Remove from all page includes
2. Move to `public_html/resources/js/!bak/`
3. Add deprecation note with date
4. Update this documentation
5. Run grep to verify no remaining references

### Updating Script Load Order

1. Test locally with unminified scripts
2. Check browser console for errors
3. Verify dependent features work
4. Update this documentation
5. Deploy and monitor production

---

## 📚 Related Documentation

- **PAGES.md** - Page templates, includes, component usage
- **CSS-SCSS.md** - CSS architecture, theme system, build pipeline
- **YOUTUBE.md** - YouTube RSS system, YAML configuration
- **TAG-SYSTEM.md** - Tag filtering, badge implementation, offcanvas UI

**Last Updated:** January 2, 2026  
**Maintainer:** JenniNexus Development Team

### Verify No Regressions ✅

- [x] Archived files moved to !bak/
- [ ] gamedev.php loads correctly (Martian Games section)
- [ ] music.php loads correctly (Spotify + YouTube iframes)
- [ ] diy.php loads correctly (diy-playlists.js still works)
- [ ] Tag badges clickable on all pages
- [ ] Offcanvas filter panels work (gaming.php, gamedev.php)
- [ ] /tags.php multi-tag filtering works

### Future Migration Tests (diy.php → youtube-grid.js)

- [ ] Create/verify diy.yaml completeness
- [ ] Replace diy-playlists.js with youtube-grid.js in diy.php
- [ ] Test Recent Videos section (RSS feed)
- [ ] Test TikTok embeds (9:16 aspect ratio)
- [ ] Test Featured Playlists (16:9 aspect ratio)
- [ ] Verify tag badges work identically
- [ ] Archive diy-playlists.js

---

## 📊 Impact Summary

### Before Consolidation:
- **9 JavaScript files** managing playlists/videos
- **3 duplicate renderers** (youtube-grid.js, martian-games.js, diy-playlists.js, music-playlists.js)
- **Maintenance overhead** - 4 places to fix bugs

### After Consolidation:
- **7 JavaScript files** (2 archived)
- **1 master renderer** (youtube-grid.js) + 1 legacy (diy-playlists.js to migrate)
- **Reduced maintenance** - Single point of maintenance for 90% of pages

### File Size Savings:
- martian-games.js: ~7 KB (archived)
- music-playlists.js: ~3 KB (archived)
- **Total:** ~10 KB removed from potential page loads

---

## 🚀 Next Steps

### Immediate (Completed):
- ✅ Archive martian-games.js
- ✅ Archive music-playlists.js
- ✅ Document consolidation

### Short-term (This Session):
- ⏳ Update JS.md file inventory
- ⏳ Update YOUTUBE.md architecture
- ⏳ Update VIDEO-GRID.md usage patterns
- ⏳ Update GAME-PAGES.md patterns
- ⏳ Update PLAYLIST-MAPPING.md
- ⏳ Update TAG-SYSTEM.md
- ✅ **Consolidate CSS:** Move shared playlist/card/media rules into `custom.css` / `media.css`, leave theme files as color/variable overrides only; consider adding `_mixins.scss` with `ensure-contrast()` (documented in YOUTUBE.md / VIDEO-GRID.md)

### Medium-term (Future Sprint):
- ⏳ Migrate diy.php to youtube-grid.js pattern
- ⏳ Archive diy-playlists.js
- ⏳ Create media-embeds.css for Bootstrap ratio overrides
- ⏳ Audit all game/*.php for RES_ROOT consistency

---

**Status:** ✅ Phase 1 Complete (Archival)  
**Next Phase:** Documentation Updates  
**Date:** November 10, 2025
