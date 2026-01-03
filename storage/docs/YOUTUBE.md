# YouTube Integration Documentation

**Version:** 3.3 (RSS-Only, Responsive Grid)  
**Last Updated:** December 30, 2025  
**Status:** ✅ PRODUCTION READY - RSS FEEDS ONLY

---

## 🎯 Overview

JenniNexus uses **YouTube RSS feeds exclusively** - no API key required! This document explains the complete YouTube integration system including RSS fetching, caching, thumbnail extraction, grid display, and tag filtering integration.

**IMPORTANT:** If you see 502 errors on `get-youtube.php` endpoints, these are **non-critical**. The site's static content works perfectly, and video grids are a secondary feature that can be debugged separately. RSS feed implementation means no API keys, no rate limits, and no authentication complexity.

**Architecture Note:** JenniNexus does NOT use the YouTube Data API. Video data is cached on the remote SSH server at `/var/www/jenninexus/storage/cache/youtube/` (Project Root Storage) via RSS feed fetching.
**Important:** The cache is located at the **project root** (`/var/www/jenninexus/storage/`), NOT inside `public_html`. If you see `public_html/storage/`, it is a deployment artifact and should be ignored or deleted.

**Recent Updates:**
- **January 1, 2026:** Glass effect integration - all video cards now use lavender glass backgrounds in light mode (`rgba(249, 243, 251, 0.9)`), dark purple glass in dark mode (`rgba(20, 20, 30, 0.8)`). Brand color hover glow with purple primary + pink accent. See [links.php](../../public_html/links.php) for reference implementation.
- **December 31, 2025:** Accessibility & CSS consolidation: added contrast-safety rules to theme files, replaced a hardcoded GitHub hover color with a theme-aware variable, and made tag-badge active styling theme-aware (see `custom.css`/`media.css` and `src/assets/scss/base/_mixins.scss` for the proposed mixins).
- **December 30, 2025:** Responsive video grid system - automatically adapts from 1 to 6 columns based on screen size (xs:1, sm:2, md:3, lg:4, xl:6). Updated `youtube-grid.js` and `media.css` for consistent responsive behavior across all pages.
- **December 30, 2025:** Back-to-top button now uses `fa-chevron-up` icon for consistency.
- **November 23, 2025:** Enhanced Multi-Video Layout (DIY page) - linked titles, removed redundant buttons, improved vertical alignment.
- **November 23, 2025:** Standardized CSS theme integration for dynamic grids in DIY and GameDev themes.
- **November 10, 2025:** Fixed youtube.php RSS feed property access (video.videoId vs video['yt:videoId']), added live.php tag-system.js, documented XML-to-JSON namespace conversion in get-youtube.php
- **November 4, 2025:** Clarified RSS-only architecture - API debugging not required for site functionality
- **November 2, 2025:** Fixed CSS Grid conflict breaking responsive layouts - removed custom grid rules from gamedev-theme.css
- **November 1, 2025:** Tag filtering system fully integrated across all pages, 49 tags available
- Offcanvas filter panels working on gaming.php, diy.php, gamedev.php
- Apply Filters button redirects to /tags.php correctly

---

## 📐 Responsive Video Grid System (v3.3)

### Breakpoint Behavior

The video grid automatically adapts to screen size using Bootstrap 5.3.8 responsive classes:

| Screen Size | Breakpoint | Videos Per Row | Bootstrap Class |
|-------------|------------|----------------|-----------------|
| Mobile | xs (0-575px) | 1 | `col-12` |
| Small | sm (576-767px) | 2 | `col-sm-6` |
| Medium | md (768-991px) | 3 | `col-md-4` |
| Large | lg (992-1199px) | 4 | `col-lg-3` |
| Extra Large | xl (1200px+) | 6 | `col-xl-2` |

**Default Column Classes:** `col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2`

### Implementation

**youtube-grid.js:**
```javascript
function getColumnClass(columns) {
  const columnMap = {
    1: 'col-12',                                                    
    2: 'col-12 col-md-6',                                           
    3: 'col-12 col-sm-6 col-md-4',                                  
    4: 'col-12 col-sm-6 col-md-4 col-lg-3',                         
    5: 'col-12 col-sm-6 col-md-4 col-lg-2-4',                       
    6: 'col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2'  // 6-column responsive              
  };
  return columnMap[columns] || 'col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2';
}
```

**media.css:**
- Full-width container support: `.video-row-container`, `.playlist-videos-container`
- Responsive card styling with glassmorphism
- Hover effects that scale with screen size

### Visual Styling (Glass Effects)

**All video cards use theme-aware lavender glass styling:**

```css
/* Light mode - soft lavender glass (no white backgrounds) */
:root[data-bs-theme="light"] .video-card .card,
:root[data-bs-theme="light"] .playlist-card-single .card,
:root[data-bs-theme="light"] .playlist-card-multi .card {
  background: rgba(249, 243, 251, 0.9) !important;
  backdrop-filter: blur(10px);
  border-color: rgba(165, 99, 209, 0.25) !important;
}

/* Dark mode - dark purple glass */
:root[data-bs-theme="dark"] .video-card .card,
:root[data-bs-theme="dark"] .playlist-card-single .card,
:root[data-bs-theme="dark"] .playlist-card-multi .card {
  background: rgba(20, 20, 30, 0.8) !important;
  backdrop-filter: blur(12px);
  border-color: rgba(165, 99, 209, 0.3) !important;
}

/* Hover - brand color glow (purple primary + pink accent) */
.video-card:hover .card,
.playlist-card-single:hover .card {
  box-shadow: 0 0.5rem 1.5rem rgba(165, 99, 209, 0.3),
              0 0 20px rgba(255, 46, 136, 0.2) !important;
}

:root[data-bs-theme="dark"] .video-card:hover .card {
  box-shadow: 0 0.5rem 1.5rem rgba(165, 99, 209, 0.5),
              0 0 30px rgba(255, 46, 136, 0.3) !important;
}
```

**Color Variables (all-themes.css):**
- `--jenni-primary`: `#A563D1` (purple)
- `--jenni-secondary`: `#FF2E88` (pink)
- `--background`: `#F9F3FB` (light lavender) in light mode
- `--background`: `#0A0A0A` (rich black) in dark mode
- `--glass-panel-bg`: Theme-specific glass background
- `--glass-panel-blur`: `10px` (light), `12px` (dark)

**Implementation:** See [links.php](../../public_html/links.php), [sitemap.php](../../public_html/sitemap.php) for reference.

---

## 📦 Dependencies

### js-yaml Library (v4.1.0) — REQUIRED

**Purpose:** Parse YAML playlist configuration files  
**Source:** `https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js`  
**Loaded:** `includes/head.php` (global script, loaded on every page)  
**Used By:** `youtube-grid.js` for loading `*.yaml` playlist configs

**Why Required:**
- All playlist configurations are stored in YAML format (gamedev.yaml, gaming.yaml, etc.)
- YAML is more human-readable than JSON for complex nested structures
- js-yaml converts YAML text to JavaScript objects at runtime

**Loading Code (includes/head.php):**
```html
<!-- js-yaml for YAML parsing (required by youtube-grid.js) -->
<script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
```

**Usage in youtube-grid.js:**
```javascript
async function loadYAMLConfig(pageName) {
  const yamlPath = `${CONFIG.playlistsPath}${pageName}.yaml`;
  const response = await fetch(yamlPath);
  const yamlText = await response.text();
  
  // js-yaml library exposes itself as jsyaml when loaded via script tag
  if (typeof jsyaml === 'undefined') {
    throw new Error('js-yaml library not loaded');
  }
  
  const config = jsyaml.load(yamlText);
  return config;
}
```

**Troubleshooting:**
- **Error:** `ReferenceError: jsyaml is not defined`
  - **Fix:** Add js-yaml script tag to `includes/head.php` (see code above)
  - **Check:** View page source, search for "js-yaml" to verify script loaded
- **Error:** `Failed to load YAML config`
  - **Fix:** Verify YAML file exists at `/resources/playlists/{page}.yaml`
  - **Check:** Open YAML file directly in browser to test path

---

## 📺 YouTube Channels

### Main Channels (3 Active Channels)

| Channel | ID | RSS Feed | Purpose |
|---------|----|----|---------|
| **@jenninexus** | UCu1S6_Gza2Y06pT1n5U_L4Q | [RSS](https://www.youtube.com/feeds/videos.xml?channel_id=UCu1S6_Gza2Y06pT1n5U_L4Q) | Main content hub |
| **@jenniplaysgames** | UC4byqahPWuY9WPJNvDgbQMQ | [RSS](https://www.youtube.com/feeds/videos.xml?channel_id=UC4byqahPWuY9WPJNvDgbQMQ) | Gaming content |
| **@diywjenni** | UCk2SWSg1fvdZGnrN0XAt6NQ | [RSS](https://www.youtube.com/feeds/videos.xml?channel_id=UCk2SWSg1fvdZGnrN0XAt6NQ) | DIY & beauty |

**Configuration File:** `public_html/resources/playlists/playlist-ids.json`

---

## 🏗️ Architecture: RSS-Only System (v3.0)

### Why RSS Instead of API?

✅ **No authentication required** - Public RSS feeds always available  
✅ **No rate limits** - No quota restrictions  
✅ **No API key management** - Zero configuration needed  
✅ **Real thumbnails included** - `<media:thumbnail>` tags in RSS  
✅ **Faster** - Server-side caching (10 min) + Client-side caching (24 hrs)  
✅ **Simpler** - Less code, fewer dependencies  

### Data Flow

```
Browser Request
       ↓
youtube-grid.js (v3.0)
       ↓
get-youtube.php (server-side proxy)
       ↓
Check cache: storage/cache/youtube/*.json (10 min TTL)
       ↓
Fresh? → Return cached JSON
Stale? → Fetch RSS from YouTube
       ↓
Parse XML → Extract videos + thumbnails
       ↓
Save to cache: storage/cache/youtube/[MD5_HASH].json
       ↓
Return JSON to browser (cached 24 hrs client-side)
```

---

## 📁 File Structure

### Server-Side Files

**`public_html/resources/api/get-youtube.php`** - RSS Proxy & Cache Manager
- Fetches YouTube RSS feeds (avoids CORS)
- Converts XML → JSON
- Server-side caching (10 minutes)
- Auto-creates `storage/cache/youtube/` directory
- Cache files: MD5(RSS_URL).json (e.g., `a1c302444120.json`)

**`storage/cache/youtube/*.json`** - Server Cache Files
- 10-minute TTL (time-to-live)
- Auto-regenerates when stale
- Contains parsed RSS feed data with video IDs, titles, thumbnails
- **Excluded from deployment** (server creates these)
- Safe to delete (will regenerate)

### Configuration Files

**`public_html/resources/playlists/playlist-ids.json`** - Master Registry
- Channel IDs and RSS feed URLs
- Playlist metadata (titles, descriptions)
- Discord invite links
- **Version 2.1** (updated Nov 8, 2025)

**`public_html/resources/playlists/gaming.yaml`** - Gaming Page Config
- 30 gaming playlists
- Single-card layout (show_single_video: true)
- Genre tags (horror, fps, rpg, indie, action, multiplayer, survival, puzzle, platformer)

**`public_html/resources/playlists/youtube.yaml`** - YouTube Hub Page Config
- 8 featured playlists across all categories
- Multi-video grid layout (show_single_video: false)
- 4-column responsive grid (xs:1, sm:2, md:3, lg:4)
- Categories: gaming, gamedev, diy, ai, music, live, game-jam, voice-acting

**`public_html/resources/playlists/gamedev.yaml`** - Game Dev Page Config
- Featured projects (Purgatory Fell, BotBorgs, etc.)
- Martian Games section (vertical layout, columns: 1)
- Learning resources (tutorials, Unity, Unreal)
- Archive games

**`public_html/resources/playlists/diy.yaml`** - DIY Page Config
- Fashion section (4 playlists)
- Hair styling (1 playlist)
- Nail art & self care (4 playlists)
- Brand collaborations (2 playlists)
- Creative tech (1 playlist)

**`public_html/resources/playlists/gamejams.yaml`** - Game Jams Config
- Ludum Dare playlists (7 playlists)
- Game jam highlights compilation
- 3-column grid layout

---

## 🎨 CSS Theme Integration

**Shared vs Page-Specific Styles (Policy):**
To keep the design consistent and reduce duplication, **place all shared layout and interactive rules in** `src/assets/css/custom.css` and `src/assets/css/media.css` (grid behavior, `.play-overlay`, ratio handling, `.playlist-card-*` transitions, and glass-panel utilities). **Page theme files** (e.g., `diy-theme.css`, `gamedev-theme.css`, `gaming-theme.css`, `home-theme.css`) should only contain **color variables, brand accents, slight spacing tweaks, and very small, scoped overrides** (prefer container-scoped selectors like `#diyPlaylistsContainer .card`). This prevents accidental white-on-white or low-contrast sections and makes maintenance simpler.

**Recommended SCSS workflow (if/when migrating):**
- Create an `_mixins.scss` with utilities like `ensure-contrast($bg, $fg-fallback)` and `theme-variant($name, $primary, $accent)` (example added at `src/assets/scss/base/_mixins.scss`).
- Move common rules to `custom.css`/`media.css` and replace duplicated snippets in theme files with small variable/utility calls.
- Convert individual theme files incrementally to `.scss` and substitute duplicated logic with mixin calls; keep changes minimal and test visually after each conversion.

**One-time compiled CSS (what we use today):**
- A precompiled CSS snippet is committed for production to avoid adding an SCSS toolchain. The compiled rules live in: `src/assets/css/generated/mixins.css` (authoritative) and `src/assets/css/mixins.css` (top-level copy included during build).
- To regenerate the compiled CSS from SCSS:
  - Preferred (local): install Dart Sass (https://sass-lang.com/install) and run `pwsh scripts/compile-mixins.ps1` (script will call `sass` automatically).
  - Direct CLI: `sass src/assets/scss/generated/mixins-usage.scss:src/assets/css/generated/mixins.css --no-source-map --style=compressed`
- After regenerating, re-run `pwsh scripts/build.ps1` to pick up the updated CSS into `public_html/resources/css/`.


**Migration Checklist (actionable):**
1. Audit theme files for duplicated layout/behavior styles (transitions, hover, `.ratio`, `.play-overlay`).
2. Move duplicates into `custom.css` or `media.css`.
3. Replace moved rules in theme files with color variables and container-scoped overrides.
4. Add `ensure-contrast()` calls (or CSS fallbacks) where badges/cards may sit on light backgrounds.

**Dynamic Grid Styling:**
The `youtube-grid.js` script generates standard Bootstrap cards (`.card`). To apply theme-specific styles (like `.diy-playlist-card` or `.gamedev-playlist-card`), we target the dynamic containers in the theme CSS files.

**Example (diy-theme.css):**
```css
/* Apply theme styles to dynamic grid containers */
.diy-playlist-card,
#diyPlaylistsContainer .card,
#diySecondaryContainer .card {
  /* Theme-specific styles */
  border-radius: 1rem;
  transition: all 0.4s ease;
  /* ... */
}
```

**Supported Containers:**
- **DIY:** `#diyPlaylistsContainer`, `#diySecondaryContainer`
- **GameDev:** `#featured-playlists`, `#martian_games-playlists`, `#learning-playlists`

---

## 📐 Aspect Ratio System (v3.2)

**Added:** November 9, 2025  
**Purpose:** Control video thumbnail aspect ratios across different content types

### How It Works

The aspect ratio system flows through three layers:

1. **YAML Configuration** → Define `aspect_ratio` in playlist config files
2. **youtube-grid.js** → Reads `aspect_ratio` and converts to Bootstrap classes
3. **Bootstrap 5.3.8** → Applies responsive ratio classes to maintain aspect

**IMPORTANT:** Aspect ratio control requires **BOTH** Bootstrap 5.3.8 **AND** youtube-grid.js. Bootstrap provides the CSS classes (`.ratio-16x9`, `.ratio-9x16`, etc.), but youtube-grid.js reads the YAML config and applies the correct class to each video thumbnail. Without youtube-grid.js, you must manually add Bootstrap ratio classes to HTML.

**Two Implementation Approaches:**

1. **youtube-grid.js + YAML (Recommended)** - Set `aspect_ratio: "16:9"` in YAML, youtube-grid.js handles the rest
2. **Manual HTML** - Add `<div class="ratio ratio-16x9">` directly in PHP/HTML (used in music.php, ai.php hardcoded iframes)

### YAML Configuration

Add `aspect_ratio` to section configs or individual playlists:

```yaml
# Section-level aspect ratio (applies to all playlists in section)
featured_section:
  title: "Gaming Playlists"
  aspect_ratio: "16:9"  # All playlists use landscape
  playlists:
    - id: "PL6WnzXOaRqA16UY1KibrFUHu4gDZ8hmep"
      title: "Ori and the Blind Forest"
      
# Playlist-level aspect ratio (overrides section default)
recent_shorts:
  title: "Latest Gaming Shorts"
  aspect_ratio: "9:16"  # Portrait format for YouTube Shorts
  playlists:
    - id: "PL..."
```

### Supported Aspect Ratios

| Ratio | Bootstrap Class | Use Case | Example Content |
|-------|----------------|----------|-----------------|
| **16:9** | `ratio-16x9` | Standard landscape video | YouTube videos, gaming content, tutorials |
| **9:16** | `ratio-9x16` | Portrait/vertical video | YouTube Shorts, Instagram Reels, TikTok |
| **4:3** | `ratio-4x3` | Classic/retro format | Retro games, old TV shows, presentations |
| **1:1** | `ratio-1x1` | Square format | Social media posts, album art, icons |
| **21:9** | `ratio-21x9` | Ultrawide/cinematic | Ultrawide gameplay, cinematic trailers |

**Default:** If `aspect_ratio` is not specified, youtube-grid.js defaults to `16:9` (standard landscape).

### How youtube-grid.js Implements It

**Helper Function (Line 66-80):**
```javascript
/**
 * Convert aspect ratio format from YAML to Bootstrap class
 * @param {string} ratio - Aspect ratio in format "16:9", "9:16", "4:3", "1:1", "21:9"
 * @returns {string} Bootstrap ratio class (e.g., 'ratio-16x9', 'ratio-9x16')
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
```

**Applied In:**
- `createPlaylistCard()` - Reads from sectionConfig or playlist config
- `createVideoThumbnail()` - Accepts aspectRatio parameter
- `loadSingleVideoPreview()` - Passes aspectRatio to preview rendering
- `loadPlaylistVideos()` - Passes aspectRatio to thumbnail creation
- `renderFallbackPlaylistThumbnail()` - Uses aspectRatio for placeholder

### Page-Specific Implementations

**gaming.php - Featured Carousel:**
- Uses hardcoded `<div class="ratio ratio-16x9">` for iframe embeds
- Carousel slides: 16:9 landscape format
- Location: Lines 207-285 (gaming.php)

**gaming.php - Playlist Cards:**
- Uses YAML config: `gaming.yaml` → `aspect_ratio: "16:9"`
- Location: gaming.yaml line 16 (changed from 9:16 on Nov 9, 2025)
- Single-card layout with large thumbnail preview

**youtube.php - Latest Videos (RSS Feed):**
- Hardcoded in JavaScript: `ratio ratio-16x9`
- Location: youtube.php lines 231-256
- RSS feed cards in 3-column grid

**blog.php - Blog Post Cards:**
- Uses CSS `object-fit: cover` with `max-height: 200px`
- Not aspect-ratio constrained (fills card width, crops height)
- Location: blog.php lines 135-148

**gamedev.php / diy.php - Playlist Grids:**
- Uses YAML configs: `gamedev.yaml`, `diy.yaml`
- All default to `16:9` (not explicitly set)
- youtube-grid.js applies ratio-16x9 automatically

### When to Use Each Ratio

**16:9 (Standard Landscape) - 95% of content:**
- All standard YouTube videos
- Gaming Let's Plays, tutorials, vlogs
- Horizontal gameplay footage
- Desktop screen recordings
- **Default for all playlists unless specified otherwise**

**9:16 (Portrait) - YouTube Shorts & Social:**
- YouTube Shorts (vertical video < 60 seconds)
- Instagram Reels, TikTok reposts
- Mobile-first vertical content
- Behind-the-scenes phone footage

**4:3 (Classic/Retro) - Legacy Content:**
- Retro game playthroughs (NES, SNES, PS1)
- Old TV show clips
- Vintage recorded media
- Presentations/slides

**1:1 (Square) - Social Media:**
- Instagram posts (square format)
- Album artwork displays
- Profile pictures/avatars
- Minimalist design elements

**21:9 (Ultrawide/Cinematic) - Specialty:**
- Ultrawide gaming (3440x1440, 5120x1440)
- Cinematic trailers with letterboxing
- Professional cinematography

### Troubleshooting

**Problem: Videos appear stretched or squashed**
- **Cause:** Wrong aspect_ratio in YAML config
- **Fix:** Check gaming.yaml, youtube.yaml, etc. - ensure aspect_ratio matches actual video format
- **Example:** If gaming.yaml has `aspect_ratio: "9:16"` but videos are landscape, change to `"16:9"`

**Problem: Aspect ratio not applying**
- **Cause:** youtube-grid.js not reading YAML correctly
- **Fix:** Check browser console for `Invalid aspect ratio` warnings
- **Verify:** Inspect element - should see `<div class="ratio ratio-16x9">` (or ratio-9x16, etc.)

**Problem: Fallback images extending past container**
- **Cause:** Hardcoded ratio-16x9 in older code
- **Fix:** Ensure renderFallbackPlaylistThumbnail() receives aspectRatio parameter
- **Check:** youtube-grid.js lines 600-650

**Problem: Blog images not maintaining ratio**
- **Cause:** blog.php uses object-fit: cover, not ratio classes
- **Expected:** Blog cards deliberately crop to fixed height (200px)
- **Not a bug:** Different design pattern for blog vs video grids

### Future Considerations

**Potential Additions:**
- `aspect_ratio: "auto"` - Detect from first video in playlist
- Per-playlist override in YAML (already supported, document examples)
- Responsive aspect ratios (mobile portrait, desktop landscape)

**Breaking Changes:**
- None - defaults to 16:9 if not specified
- Existing pages without aspect_ratio config continue working

### Thumbnail Testing Tool

**Location:** `/theme-demo.php#youtube-testing` (Development Only). Also see `/theme-demo.php#video-grid-showcase` and `/theme-demo.php#svg-protocol` for live examples and SVG protocol guidance.  
**Purpose:** Visual testing of YouTube thumbnail qualities and Bootstrap aspect ratios  
**Added:** November 9, 2025

**Features:**
- **Interactive Bootstrap Ratio Selector:** Test ratio-16x9, ratio-9x16, ratio-4x3, ratio-1x1, ratio-21x9
- **Thumbnail Quality Comparison:** Compare default.jpg, mqdefault.jpg, hqdefault.jpg, sddefault.jpg, maxresdefault.jpg
- **Live Preview Grid:** Side-by-side comparison of different aspect ratios with selected thumbnail quality
- **Generated Code Display:** Shows exact HTML/CSS for implementing selected configuration

**How to Use:**
1. Open `http://localhost:8002/theme-demo.php` (local dev only)
2. Scroll to "YouTube Thumbnail & Aspect Ratio Testing" section
3. Click aspect ratio buttons (16:9, 9:16, etc.) to see different Bootstrap ratio classes
4. Click thumbnail quality buttons to test different YouTube thumbnail URLs
5. Observe how vertical videos (9:16) crop/display in different aspect ratio containers
6. Copy generated HTML from code preview for implementation

**Thumbnail Quality Reference:**
```javascript
// YouTube Thumbnail URL Patterns
const thumbnailQualities = {
  default: '120x90 (4:3)',        // Very small, legacy
  mqdefault: '320x180 (16:9)',    // Current default - good balance
  hqdefault: '480x360 (4:3)',     // Higher quality, older aspect
  sddefault: '640x480 (4:3)',     // Standard definition
  maxresdefault: '1280x720 (16:9)' // Full HD (not always available)
};

// Example URL:
// https://i.ytimg.com/vi/VIDEO_ID/mqdefault.jpg
```

**Key Findings:**
- **For vertical videos (Shorts/TikTok):** YouTube thumbnails ARE portrait, regardless of quality
- **For landscape videos:** All qualities provide proper 16:9 thumbnails
- **Best practice:** Use `mqdefault.jpg` (320x180) for most content - good quality, fast loading
- **For high-res cards:** Use `maxresdefault.jpg` (1280x720) with fallback handling
- **Aspect ratio:** Match container to content - use ratio-9x16 for Shorts playlists, ratio-16x9 for standard videos

**Implementation Example:**
```html
<!-- Standard landscape video -->
<div class="ratio ratio-16x9">
  <img src="https://i.ytimg.com/vi/VIDEO_ID/mqdefault.jpg" 
       alt="Video Thumbnail"
       loading="lazy"
       style="object-fit: cover;">
</div>

<!-- Vertical video (Shorts) -->
<div class="ratio ratio-9x16">
  <img src="https://i.ytimg.com/vi/VIDEO_ID/mqdefault.jpg" 
       alt="Shorts Thumbnail"
       loading="lazy"
       style="object-fit: cover;">
</div>
```

**When to Use Each Quality:**
| Quality | Use Case | File Size | Loading Speed |
|---------|----------|-----------|---------------|
| `default` | Tiny thumbnails, mobile list views | ~5KB | Fastest |
| `mqdefault` | **Default choice** - playlist cards, grids | ~15KB | Fast |
| `hqdefault` | Larger cards, hero sections | ~30KB | Medium |
| `sddefault` | High-res displays, featured content | ~60KB | Slow |
| `maxresdefault` | Full-screen previews, hero banners | ~100KB | Slowest |

**Performance Recommendation:** Stick with `mqdefault.jpg` (320x180) unless you need higher resolution for specific design requirements. Use `loading="lazy"` attribute for all thumbnail images.

---

## 🎯 Complete Setup Guide: Adding Video Grids to Pages

**Purpose:** Step-by-step guide for future agents to set up video grids with correct thumbnails, aspect ratios, grid columns, and tags.

### Prerequisites

1. ✅ **js-yaml library loaded** - Required for YAML parsing
   - Location: `includes/head.php` line 50
   - CDN: `https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js`
   - Check: View page source, search for "js-yaml"

2. ✅ **youtube-grid.js loaded** - Main grid renderer
   - Location: Page footer (before closing `</body>`)
   - Path: `<?= RES_ROOT ?>/js/youtube-grid<?= $assetSuffix ?? '' ?>.js`
   - Minified version auto-selected in production

3. ✅ **RSS proxy working** - Server-side YouTube RSS fetcher
   - File: `public_html/resources/api/get-youtube.php`
   - Cache dir: `storage/cache/youtube/` (auto-created)
   - No API key needed - RSS feeds are public

### Step 1: Create YAML Configuration File

**Location:** `public_html/resources/playlists/{page}.yaml`

**Template:**
```yaml
# Page identifier (matches YouTubeGrid.loadPageConfig() param)
page: "mypage"
title: "My Page Title"
description: "Brief description of page content"

# Section definition (becomes #mysection-playlists container in HTML)
mysection_section:
  title: "Section Title"
  aspect_ratio: "16:9"          # Optional: Default is 16:9
  columns:                       # Optional: Responsive breakpoints
    xs: 1                        # Mobile: 1 column
    sm: 2                        # Tablet: 2 columns
    md: 3                        # Desktop: 3 columns
    lg: 4                        # Large: 4 columns
  playlists:
    - id: "PL6WnzXOaRqA16UY1KibrFUHu4gDZ8hmep"  # YouTube playlist ID
      title: "Playlist Name"
      description: "Brief description"
      icon: "play-circle"        # Bootstrap icon (without 'bi-' prefix)
      badge: "Featured"          # Optional badge text
      tags: ["gaming", "horror", "fps"]  # Tag slugs for filtering
      aspect_ratio: "16:9"       # Optional: Override section default

# Grid configuration (applies to all sections if not overridden)
grid_config:
  columns: { xs: 1, sm: 2, md: 3, lg: 4 }  # Default responsive grid
  videos_per_playlist: 6         # How many video thumbnails to show
  show_single_video: false       # true = single large thumbnail, false = grid of videos
  aspect_ratio: "16:9"           # Default aspect ratio for all videos
  enable_hover_effects: true     # Enable hover animations
  responsive: true               # Enable responsive behavior
```

**Key Points:**
- Section names ending in `_section` → Container ID becomes `{name}-playlists`
- Playlist ID format: `PL...` (starts with PL)
- Tags must exist in `tags.json` or filtering breaks
- Aspect ratio: `"16:9"` (landscape), `"9:16"` (portrait), `"4:3"` (retro), `"1:1"` (square), `"21:9"` (ultrawide)

### Step 2: Add HTML Container to Page

**Location:** Your page PHP file (e.g., `mypage.php`)

**Pattern:**
```html
<!-- Section container (ID matches YAML section name) -->
<section class="py-5">
  <div class="container">
    <h2 class="display-6 text-center mb-4">Section Title</h2>
    
    <!-- Grid container (youtube-grid.js will populate this) -->
    <div id="mysection-playlists" class="row g-4">
      <!-- Loading spinner (removed by youtube-grid.js when loaded) -->
      <div class="col-12 text-center">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading playlists...</span>
        </div>
      </div>
    </div>
  </div>
</section>
```

**Critical Requirements:**
- Container ID must match YAML section name pattern: `{section}-playlists`
- Must have `row g-4` classes for Bootstrap grid spacing
- Loading spinner is optional but recommended for UX

### Step 3: Load YAML Config with JavaScript

**Location:** Page footer, after youtube-grid.js script tag

**Code:**
```html
<script src="<?= RES_ROOT ?>/js/youtube-grid<?= $assetSuffix ?? '' ?>.js"></script>
<script>
  (function() {
    function loadMyPagePlaylists() {
      if (window.YouTubeGrid && typeof window.YouTubeGrid.loadPageConfig === 'function') {
        console.log('✅ Loading playlists from mypage.yaml');
        
        // Load YAML config and render all sections
        window.YouTubeGrid.loadPageConfig('mypage')
          .then(() => console.log('✅ Playlists loaded successfully'))
          .catch(err => console.error('❌ Failed to load playlists:', err));
      } else {
        console.error('❌ YouTubeGrid not loaded');
      }
    }
    
    // Wait for DOM ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', loadMyPagePlaylists);
    } else {
      loadMyPagePlaylists();
    }
  })();
</script>
```

**What Happens:**
1. `YouTubeGrid.loadPageConfig('mypage')` fetches `/resources/playlists/mypage.yaml`
2. youtube-grid.js parses YAML with js-yaml library
3. For each section, creates playlist cards with proper:
   - Grid columns (responsive based on YAML config)
   - Aspect ratio (from YAML or default 16:9)
   - Tags (for filtering integration)
   - Thumbnails (from RSS feed or fallback)
4. Renders cards into `#{section}-playlists` containers

### Step 4: Fetch Real Thumbnails (Optional but Recommended)

**Why:** RSS feeds include thumbnails, but downloading static versions improves load times and provides fallbacks.

**Command:**
```powershell
cd "C:\Users\Owner\Projects\www\jenninexus"
pwsh -File "scripts\download-playlist-thumbnails.ps1" -YamlFile "mypage.yaml"
```

**What It Does:**
1. Reads `mypage.yaml` and extracts all playlist IDs
2. Fetches each playlist's RSS feed from YouTube
3. Extracts first video thumbnail (highest quality available)
4. Downloads image to `public_html/resources/images/playlists/{PLAYLIST_ID}.jpg`
5. Includes 1-second delay between requests (rate limiting)

**Result:** Static thumbnails for faster loading and offline fallback

**Handling Empty Playlists:**
If a playlist has no videos, youtube-grid.js will show a gradient placeholder with playlist icon.

### Step 5: Configure Tags for Filtering

**Location:** `public_html/resources/playlists/tags.json`

**Verify Tags Exist:**
```powershell
# Generate content tags index (scans all YAML files)
cd "C:\Users\Owner\Projects\www\jenninexus"
pwsh -File "scripts\generate-playlist-tags.ps1" -Verbose
```

**Add Missing Tags:**
```json
{
  "id": 999,
  "name": "New Tag",
  "slug": "new-tag",
  "category": "gaming"
}
```

**Tag Categories:**
- `gaming` - Game-specific, genre, platform tags
- `gamedev` - Development tools, engines, processes
- `diy` - Beauty, fashion, crafts, tutorials
- `music` - Instruments, genres, production
- `meta` - Content types, streaming, social media
- `blog` - Topics, tools, events

### Step 6: Configure Grid Columns

**Grid columns are set in 3 places (priority order):**

1. **Section-level `columns`** (highest priority)
```yaml
mysection_section:
  columns: { xs: 1, sm: 2, md: 2, lg: 3 }  # Section-specific
  playlists: [...]
```

2. **Grid config by section name**
```yaml
grid_config:
  mysection_columns: 3  # Applies only to mysection_section
```

3. **Grid config global default**
```yaml
grid_config:
  columns: { xs: 1, sm: 2, md: 3, lg: 4 }  # Fallback for all sections
```

4. **Hardcoded fallback in youtube-grid.js** (3 columns)

**How youtube-grid.js Resolves Columns:**
```javascript
// Priority chain (renderSection function, line ~290)
const columns = sectionConfig.columns ||              // Section columns
                gridConfig[`${sectionId}_columns`] || // Grid config by name
                gridConfig.columns ||                 // Grid config default
                3;                                    // Hardcoded fallback
```

**Responsive Column Mapping:**
```javascript
// Bootstrap 5.3.8 column classes (getResponsiveColClasses function)
{ xs: 1 } → 'col-12'           // 1 column on mobile
{ sm: 2 } → 'col-sm-6'         // 2 columns on tablet
{ md: 3 } → 'col-md-4'         // 3 columns on desktop
{ lg: 4 } → 'col-lg-3'         // 4 columns on large screens
```

**Common Layouts:**
- **3-column (default):** `{ xs: 1, sm: 2, md: 3 }` - Mobile 1, Tablet 2, Desktop 3
- **4-column (dense):** `{ xs: 1, sm: 2, md: 3, lg: 4 }` - Adds 4th column on large screens
- **2-column (wide cards):** `{ xs: 1, sm: 1, md: 2 }` - Tablet stays 1, Desktop 2
- **Single column (vertical):** `{ xs: 1 }` - All breakpoints 1 column

### Step 7: Set Aspect Ratios

**Aspect ratio is set in 3 places (priority order):**

1. **Playlist-level `aspect_ratio`** (highest priority)
```yaml
playlists:
  - id: "PL..."
    aspect_ratio: "9:16"  # Portrait for YouTube Shorts
```

2. **Section-level `aspect_ratio`**
```yaml
mysection_section:
  aspect_ratio: "16:9"  # Applies to all playlists in section
```

3. **Grid config `aspect_ratio`** (global default)
```yaml
grid_config:
  aspect_ratio: "16:9"  # Fallback for all sections
```

4. **Hardcoded fallback in youtube-grid.js** (`"16:9"`)

**How youtube-grid.js Applies It:**
```javascript
// Priority chain (createPlaylistCard function, line ~324)
const aspectRatio = sectionConfig.aspect_ratio || 
                    playlist.aspect_ratio || 
                    '16:9';  // Default

// Convert to Bootstrap class (getAspectRatioClass function)
const ratioClass = getAspectRatioClass(aspectRatio);
// "16:9" → "ratio-16x9"
// "9:16" → "ratio-9x16"
// etc.
```

**When to Use Each Ratio:**
- **16:9** - Standard YouTube videos (95% of content)
- **9:16** - YouTube Shorts, vertical mobile videos
- **4:3** - Retro games, legacy content
- **1:1** - Square social media posts
- **21:9** - Ultrawide gaming, cinematic content

### Step 8: Build and Test

**Build Assets:**
```powershell
cd "C:\Users\Owner\Projects\www\jenninexus"
.\scripts\build-all.ps1
```

**What Gets Minified:**
- `youtube-grid.js` → `youtube-grid.min.js` (automatic)
- `mypage.yaml` → No minification (YAML loaded directly)

**Test Checklist:**
1. ✅ Visit page in browser (e.g., `http://localhost:8002/mypage`)
2. ✅ Check browser console for errors:
   - `✅ Loading playlists from mypage.yaml` - YAML loading started
   - `✅ Playlists loaded successfully` - All sections rendered
   - No 404 errors on RSS proxy (`/resources/api/get-youtube.php`)
3. ✅ Verify grid layout:
   - Desktop: Correct number of columns per section
   - Tablet: Columns adjust responsively
   - Mobile: Single column layout
4. ✅ Verify aspect ratios:
   - Inspect thumbnail divs: `<div class="ratio ratio-16x9">` (or ratio-9x16, etc.)
   - Videos not stretched or squashed
5. ✅ Verify thumbnails:
   - Real thumbnails from RSS feed
   - Fallback images if available
   - Gradient placeholders for empty playlists
6. ✅ Verify tags:
   - Playlist cards have `data-tags` attribute
   - Tag badges clickable and link to `/tag/index.php?slug=...`
   - Tag filtering works correctly

### Common Issues and Solutions

**Issue 1: "Failed to load YAML config"**
- **Cause:** YAML file doesn't exist or has syntax errors
- **Fix:** Verify file exists at `/resources/playlists/mypage.yaml`
- **Check:** Open YAML file directly in browser to test path
- **Validate:** Use online YAML validator for syntax

**Issue 2: Grid not rendering / Empty containers**
- **Cause:** Container ID mismatch between HTML and YAML
- **Fix:** Ensure YAML section `mysection_section` → HTML `#mysection-playlists`
- **Pattern:** Remove `_section` suffix, add `-playlists`, replace underscores with hyphens

**Issue 3: Wrong number of columns**
- **Cause:** Column config priority not understood
- **Fix:** Check section columns first, then grid config, then default
- **Debug:** Add console.log in youtube-grid.js renderSection function
- **Verify:** Inspect element - should see `col-12 col-sm-6 col-lg-4` classes

**Issue 4: Stretched/squashed thumbnails**
- **Cause:** Wrong aspect ratio for video type
- **Fix:** Check actual video format (landscape vs portrait)
- **Correct:** 16:9 for standard, 9:16 for Shorts
- **Verify:** Inspect element - should see `ratio ratio-16x9` (or ratio-9x16)

**Issue 5: RSS proxy 502 errors**
- **Cause:** Cache directory not writable or playlist is private
- **Fix:** Check `storage/cache/youtube/` permissions (775 or 777)
- **Workaround:** Download static thumbnails (Step 4)
- **Note:** RSS errors don't break site - static content still works

**Issue 6: Tags not filtering**
- **Cause:** Tags used in YAML but not defined in tags.json
- **Fix:** Run `generate-playlist-tags.ps1` to find missing tags
- **Add:** Missing tags to `tags.json` with proper slugs
- **Verify:** Check `/tags.php` shows all tags with counts

### Troubleshooting by System

#### Thumbnail Issues

**Problem: Thumbnails not appearing**
1. **Check RSS feed has <media:thumbnail>:**
   ```powershell
   curl "https://www.youtube.com/feeds/videos.xml?playlist_id=PL..." | findstr "media:thumbnail"
   ```
2. **Verify static fallback exists:**
   ```powershell
   Test-Path "public_html/resources/images/playlists/PL....jpg"
   ```
3. **Check console for fetch errors:**
   - Open DevTools → Console
   - Look for "Failed to fetch RSS feed" or 502 errors
   - Verify `/resources/api/get-youtube.php` is accessible

**Problem: Low quality thumbnails**
1. **Verify using RSS extraction (480x360) not constructed URL (320x180):**
   - youtube-grid.js should extract from `<media:thumbnail url="...">`
   - Inspect network tab: Thumbnail URL should contain "hqdefault" (high quality)
2. **Check fallback chain:**
   - RSS thumbnail (hqdefault 480x360) → Static JPG (1280x720) → Gradient placeholder
3. **Re-download thumbnails:**
   ```powershell
   pwsh -File "scripts\download-playlist-thumbnails.ps1" -YamlFile "mypage.yaml" -Force
   ```

**Problem: Empty playlist handling**
1. **Generate gradient placeholders:**
   ```powershell
   pwsh -File "scripts\create-gaming-placeholders.ps1"
   ```
2. **Verify icon rendering:**
   - Empty playlists show gradient with Bootstrap icon overlay
   - Check playlist has `icon: "..."` field in YAML
3. **Check placeholder directory:**
   - Gradients stored in `resources/images/playlists/`
   - Named `{PLAYLIST_ID}_placeholder.jpg`

---

## Playlist verification & recovery protocol ✅

When playlists return empty results or the RSS feed responds with HTTP 404, follow this protocol to triage and recover content:

1. Run the automated verification script to collect HTTP statuses for all playlists on a page (writes a JSON report to `public_html/storage/logs/`):

```powershell
pwsh -File "scripts\check-youtube-playlists.ps1"
```

2. Inspect the generated report (e.g., `public_html/storage/logs/playlist-check-<timestamp>.json`) and identify playlists that returned non-200 status codes (404/403/500 etc.).

3. Attempt client-side and server-side fallbacks:
   - Re-run the server-side proxy for the single playlist to see detailed error output:
     ```text
     GET /resources/api/get-youtube.php?playlist_id=<PLAYLIST_ID>
     ```
     Check `http_code` and `curl_error` fields in the JSON response for diagnostics.
   - Try client-side CORS proxy fallbacks (already allowed in CSP): AllOrigins, CorsProxy, Codetabs — these are attempted automatically by `youtube-grid.js` before it fails.

4. If the playlist feed is 404 or empty, try these recovery options (in order):
   a. **Channel uploads fallback** — If you know the channel ID, the uploads playlist ID is usually the channel ID with the `UC` prefix replaced by `UU` (e.g., `UCabcd...` → `UUabcd...`). Try substituting that playlist ID and re-run the check.
   b. **Search for replacement playlist** — Manually search the channel or YouTube for a playlist with the same title (or recent uploads). Replace the playlist ID in the YAML if you find a good match.
   c. **Flag for review** — If no replacement exists, annotate the YAML (or add a `status: missing` field) so editors can review it later.
   d. **Remove from YAML** — If the playlist has been removed permanently and no replacement exists, remove it from the YAML to avoid a poor user experience.

5. Use the annotation helper to generate a report or optionally annotate YAML entries (report-only by default):

```powershell
pwsh -File "scripts\annotate-missing-playlists.ps1" -YamlFile "public_html/resources/playlists/music.yaml"
# To apply annotations in place (backup created):
# pwsh -File "scripts\annotate-missing-playlists.ps1" -YamlFile "public_html/resources/playlists/music.yaml" -Apply
```

6. After making changes to YAML (replacement, removal, or annotation), run the default build and validate the Music page visually:

```powershell
pwsh -File "scripts\build.ps1"
# Optionally run the site validation script
pwsh -File "scripts\page-validation.ps1" -DryRun -TimeoutMs 10000
```

7. Add the verification script to a scheduled CI check or cron job to run daily/weekly and report regressions (recommended). Example cron entry (server):

```
0 6 * * * pwsh -File /path/to/jenninexus/scripts/check-youtube-playlists.ps1 -NoProfile -ExecutionPolicy Bypass
```

**Notes & Tips:**
- A 404 often means the playlist was deleted or set private; channel uploads are a common and safe fallback.
- Keep `playlist-ids.json` (master registry) updated when replacing IDs so multiple YAML files can reference a centralized source in the future.
- The annotate script will create backups before modifying YAML; review the backup before committing changes.

---

**Problem: Cache issues**
1. **Clear server cache:**
   ```powershell
   Remove-Item "storage/cache/youtube/*" -Recurse -Force
   ```
2. **Clear browser localStorage:**
   ```javascript
   // In browser console
   localStorage.clear();
   location.reload();
   ```
3. **Force refresh:**
   - Hold Ctrl+Shift+R (Windows) or Cmd+Shift+R (Mac)

#### Aspect Ratio Issues

**Problem: Videos stretched/squashed**
1. **Check video actual format:**
   - Standard YouTube videos = 16:9 landscape
   - YouTube Shorts = 9:16 portrait
   - Retro content = 4:3 or 1:1
2. **Verify YAML aspect_ratio field:**
   ```yaml
   featured_section:
     aspect_ratio: "16:9"  # Should match video format
   ```
3. **Inspect rendered HTML:**
   ```html
   <!-- Should see correct Bootstrap class -->
   <div class="ratio ratio-16x9">  <!-- For landscape -->
   <div class="ratio ratio-9x16">  <!-- For portrait -->
   ```
4. **Check getAspectRatioClass() validation:**
   - Invalid ratios default to "16:9"
   - Console shows warning: "Invalid aspect ratio: ..."

**Problem: Aspect ratio not applying**
1. **Verify priority chain:**
   - Playlist-level `aspect_ratio` overrides section-level
   - Section-level overrides grid_config default
2. **Check Bootstrap 5.3.8 CSS loaded:**
   - `.ratio-16x9` class should exist in Bootstrap CSS
   - Verify `bootstrap.min.css` loaded in page head
3. **Test with hardcoded ratio:**
   ```javascript
   // In youtube-grid.js temporarily
   const ratioClass = 'ratio-16x9';  // Force specific ratio
   ```

**Problem: Fallback images overflow**
1. **Static thumbnails have wrong aspect ratio:**
   - Re-download with correct dimensions
   - Use `object-fit: cover` CSS for static images
2. **Gradient placeholders too tall/wide:**
   - Regenerate with correct aspect ratio parameter
   - Check create-*-placeholders.ps1 scripts

#### Grid Column Issues

**Problem: Wrong number of columns**
1. **Check column priority chain:**
   ```yaml
   # Priority 1: Section-level (highest)
   mysection_section:
     columns: { xs: 1, sm: 2, md: 3 }
   
   # Priority 2: Grid config by section name
   grid_config:
     mysection_columns: 3
   
   # Priority 3: Grid config global (lowest)
   grid_config:
     columns: { xs: 1, sm: 2, md: 3, lg: 4 }
   ```
2. **Verify responsive breakpoints:**
   - Mobile (xs) < 576px
   - Tablet (sm) ≥ 576px
   - Desktop (md) ≥ 768px
   - Large (lg) ≥ 992px
3. **Inspect Bootstrap classes:**
   ```html
   <!-- Should see responsive col-* classes -->
   <div class="col-12 col-sm-6 col-md-4">
   ```
4. **Test with browser resize:**
   - Columns should adjust at breakpoints
   - Use DevTools responsive mode

**Problem: Columns not responsive**
1. **Check Bootstrap grid system loaded:**
   - Verify `bootstrap.min.css` includes grid classes
2. **Verify container has `.row` class:**
   ```html
   <div id="mysection-playlists" class="row g-4">
   ```
3. **Check column object format:**
   ```yaml
   columns: { xs: 1, sm: 2, md: 3, lg: 4 }  # Correct
   columns: "3"  # Wrong - not responsive
   ```

**Problem: Too many/few columns**
1. **Adjust breakpoint values:**
   ```yaml
   # For denser layout
   columns: { xs: 1, sm: 2, md: 3, lg: 4, xl: 5 }
   
   # For wider cards
   columns: { xs: 1, sm: 1, md: 2, lg: 2 }
   ```
2. **Override in section config:**
   ```yaml
   mysection_section:
     columns: { xs: 1, sm: 2, md: 2 }  # Override global
   ```

#### Tag System Issues

**Problem: Tags not filtering**
1. **Verify tags exist in tags.json:**
   ```powershell
   pwsh -File "scripts\generate-playlist-tags.ps1" -Verbose
   ```
2. **Check data-tags attribute:**
   ```html
   <div data-tags="gaming,platformer,adventure">
   ```
3. **Verify tag-system.js loaded:**
   - Check page footer for tag-system.js script
   - Console should not show "tag-system.js not found"
4. **Check tag slug format:**
   - Must be lowercase, hyphenated
   - Example: "Game Development" → "game-development"

**Problem: Tag counts incorrect**
1. **Regenerate tag index:**
   ```powershell
   pwsh -File "scripts\generate-playlist-tags.ps1" -UpdateCounts
   ```
2. **Check YAML tag arrays:**
   ```yaml
   tags: ["gaming", "horror", "fps"]  # Must match tags.json slugs
   ```
3. **Verify tag-system.js counting logic:**
   - Counts `[data-tags]` attributes containing tag slug
   - Case-insensitive matching

**Problem: Tag badges not clickable**
1. **Check tag-system.js badge rendering:**
   ```javascript
   // Should generate links to /tag/index.php?slug=...
   <a href="/tag/index.php?slug=gaming" class="badge">
   ```
2. **Verify tag pages exist:**
   - `/tag/index.php` with filtering logic
   - Query param `?slug=...` handled correctly

### Example: gaming.php Implementation

**YAML Config:** `gaming.yaml`
```yaml
page: gaming
title: "Gaming Content"
description: "Let's Plays, highlights, and collaborations"

featured_section:
  title: "Gaming Playlists"
  aspect_ratio: "16:9"
  playlists:
    - id: "PL6WnzXOaRqA16UY1KibrFUHu4gDZ8hmep"
      title: "Ori and the Blind Forest"
      icon: "tree"
      tags: ["gaming", "platformer", "adventure"]

grid_config:
  columns: { xs: 1, sm: 2, md: 3, lg: 3 }
  videos_per_playlist: 6
  show_single_video: true  # Single large thumbnail per playlist
  aspect_ratio: "16:9"
```

**HTML Container:** `gaming.php` line 298
```html
<div id="featured-playlists" class="row g-4 mb-4" data-tags="gaming,playlists,youtube">
  <!-- Playlist cards rendered here -->
</div>
```

**JavaScript Loader:** `gaming.php` lines 540-565
```javascript
function loadGamingPlaylists() {
  if (window.YouTubeGrid && typeof window.YouTubeGrid.loadPageConfig === 'function') {
    console.log('✅ Loading playlists from gaming.yaml');
    window.YouTubeGrid.loadPageConfig('gaming')
      .then(() => console.log('✅ Gaming playlists loaded'))
      .catch(err => console.error('❌ Error loading playlists:', err));
  }
}
```

**Result:**
- 30 gaming playlists in 3-column grid (mobile 1, tablet 2, desktop 3)
- Single large thumbnail per playlist (16:9 aspect ratio)
- Real thumbnails from RSS feed with gradient fallbacks
- Tags enabled for filtering (gaming, platformer, adventure, etc.)

---

### Client-Side JavaScript

**`public_html/resources/js/youtube-grid.js`** - Main Grid Renderer (v3.0)
- **Version:** 3.0 (RSS-Only, No API)
- **Lines:** 846+ lines
- **Purpose:** Universal YouTube playlist grid renderer
- **Features:**
  - RSS feed fetching via proxy
  - Real thumbnail extraction from `<media:thumbnail>` tags
  - Single-card layout mode (gaming page)
  - Multi-video grid mode (gamedev, diy pages)
  - Tag canonicalization
  - Client-side caching (24 hours)
  - Video modal playback
  - **Tag filtering integration** (Nov 1, 2025)
  - **data-tags attributes on all content** (Nov 1, 2025)
  - Responsive grid (3/2/1 columns)

**Key Functions:**
```javascript
// Fetch playlist videos via RSS
async function fetchPlaylistVideos(playlistId, maxResults = 6)

// Extract real thumbnails from RSS feed
const thumb = item['media:group']['media:thumbnail']['@attributes'].url

// Load YAML config and render playlists
async YouTubeGrid.loadPageConfig(pageName)

// Create single-card preview (gaming page)
async function loadSingleVideoPreview(playlistId, container)
```

**`public_html/resources/js/gaming-playlists.js`** - Gaming Page Specific
- **Status:** ⚠️ DEPRECATED (use youtube-grid.js instead)
- **Reason:** gaming.yaml + youtube-grid.js handles all functionality
- **Keep for reference only**

---

## 🖼️ Thumbnail System (v3.0)

### How Thumbnails Work

**RSS Feed Includes Real Thumbnails:**
```xml
<media:group>
  <media:thumbnail url="https://i3.ytimg.com/vi/VIDEO_ID/hqdefault.jpg" width="480" height="360"/>
</media:group>
```

**youtube-grid.js v3.0 Extracts Them:**
```javascript
// Try to get thumbnail from RSS feed's media:group (best quality)
if (item['media:group'] && item['media:group']['media:thumbnail']) {
  const mediaThumbnail = item['media:group']['media:thumbnail'];
  thumb = mediaThumbnail['@attributes']?.url || '';
}
// Fallback to standard YouTube URL pattern if RSS doesn't provide one
if (!thumb && vid) {
  thumb = `https://img.youtube.com/vi/${vid}/mqdefault.jpg`;
}
```

### Thumbnail Quality Comparison

| Source | Resolution | Quality | Usage |
|--------|-----------|---------|-------|
| **RSS Feed** | 480x360 (hqdefault) | ✅ High | Primary (v3.0) |
| **Constructed URL** | 320x180 (mqdefault) | ⚠️ Medium | Fallback only |
| **Static Fallback** | 1280x720 (local JPG) | ✅ High | Empty playlists |

**Result:** Gaming page shows 30 high-quality thumbnails - real thumbnails from RSS or gradient placeholders for empty playlists!

### Downloading Thumbnails for All Pages

**Process:** Run the download script for each YAML file to fetch real thumbnails:

```powershell
# Download thumbnails for gaming page (30 playlists)
cd "C:\Users\Owner\Projects\www\jenninexus"
pwsh -File "scripts\download-playlist-thumbnails.ps1" -YamlFile "gaming.yaml"

# Download thumbnails for gamejams page (8 playlists)
pwsh -File "scripts\download-playlist-thumbnails.ps1" -YamlFile "gamejams.yaml"

# Download thumbnails for gamedev page
pwsh -File "scripts\download-playlist-thumbnails.ps1" -YamlFile "gamedev.yaml"

# Download thumbnails for diy page
pwsh -File "scripts\download-playlist-thumbnails.ps1" -YamlFile "diy.yaml"
```

**Rate Limiting:**
- Script includes 1-second delay between requests
- 30 playlists = ~30 seconds total
- No YouTube API quota consumed (uses RSS feeds only)

**Handling Empty Playlists:**

When playlists return no videos (private, unlisted, or deleted), create gradient placeholders:

```powershell
# Create themed placeholders for empty playlists
pwsh -File "scripts\create-gaming-placeholders.ps1"     # Gaming theme (purple gradient)
pwsh -File "scripts\create-ludumdare-placeholders.ps1"  # Ludum Dare theme (orange gradient)
```

**Fallback System:**

youtube-grid.js automatically tries 3 sources in order:
1. **RSS feed thumbnail** - Real YouTube thumbnail from `<media:thumbnail>`
2. **Static fallback image** - `/resources/images/playlists/{PLAYLIST_ID}.jpg`
3. **Gradient placeholder** - Purple gaming icon with "Playlist Preview" text

**Verification:**

```powershell
# Check how many playlists have thumbnails
cd "C:\Users\Owner\Projects\www\jenninexus\public_html\resources\images\playlists"
Get-ChildItem *.jpg | Measure-Object | Select-Object Count
```

---

## 🎨 Grid Display System

### Layout Modes Overview

JenniNexus supports **4 distinct layout modes** for displaying YouTube content. Choose the right mode based on your content strategy:

| Layout Mode | Use Case | Example Page | Videos Per Card |
|-------------|----------|--------------|-----------------|
| **Playlist Cards (Single Video)** | Browse many playlists quickly | Gaming page | 1 large thumbnail |
| **Playlist Cards (Multi-Video)** | Show playlist depth | Game Dev page | 3-8 videos in vertical list |
| **Video Grid (Direct)** | Show all videos from playlists | Martian Games section | All videos in 3-column grid |
| **Channel RSS Grid** | Latest uploads from channel | DIY recent videos | 8 most recent videos |
| **Hybrid Layout** | Mix of featured & standard content | DIY page | Mixed (3 videos / 1 video) |

---

### Layout Mode 1: Playlist Cards (Single Video) — "Gallery Mode"

**Use Case:** Display many playlists (e.g., 30+ gaming playlists) with quick visual browsing  
**Example:** Gaming page  
**Appearance:** Large 16:9 thumbnail cards, one per playlist, showing first video only

**YAML Configuration:**
```yaml
page: gaming
title: "Gaming Playlists"

gaming_section:
  title: "All Gaming Playlists"
  playlists:
    - id: "PL6WnzXOaRqA0MiE5cffmM2ZZcuSTl9DcS"
      title: "Dead Space 2 Playthrough"
      tags: ["horror", "fps", "survival"]
    - id: "PL6WnzXOaRqA1sfMS1N7EoESHKaTZ2RHh4"
      title: "Ori and the Blind Forest"
      tags: ["platformer", "indie"]
    # ... more playlists

grid_config:
  columns: 3                # 3 playlist cards per row
  videos_per_playlist: 1    # Show only 1 video per playlist
  show_single_video: true   # Enable single-card mode
  enable_hover_effects: true
```

**Result:**
```
┌─────────────┬─────────────┬─────────────┐
│ Dead Space 2│ Ori Blind F │ Apex Legends│
│ [thumbnail] │ [thumbnail] │ [thumbnail] │
│ Horror, FPS │ Platformer  │ FPS, Multi  │
└─────────────┴─────────────┴─────────────┘
```

**Key Settings:**
- `show_single_video: true` — Forces single-card layout
- `columns: 3` — How many playlist cards per row
- `videos_per_playlist: 1` — Only first video displayed

---

### Layout Mode 2: Playlist Cards (Multi-Video) — "Vertical List Mode"

**Use Case:** Show depth of each playlist with multiple video previews  
**Example:** Game Dev featured section, DIY sections  
**Appearance:** Vertical cards with 3-8 video thumbnails stacked inside each card

**YAML Configuration:**
```yaml
page: gamedev
title: "Game Development"

featured_section:
  title: "Featured Projects"
  playlists:
    - id: "PL9QBjNDhgNwRsznW8e3-KVmwfEuwvr7Yi"
      title: "Devlogs"
      icon: "camera-video"
      badge: "Featured"
    - id: "PL9QBjNDhgNwS8zNaKAFjuWf4NTfk3Ul3g"
      title: "Jenni Styles Game"
      icon: "emoji-smile"
    # ... more playlists

grid_config:
  featured_columns: 3       # 3 playlist cards per row
  videos_per_playlist: 8    # Show 8 videos inside each card
  show_single_video: false  # Disable single-card mode (show multiple videos)
  enable_hover_effects: true
```

**Result:**
```
┌─────────────┬─────────────┬─────────────┐
│  DEVLOGS    │ JENNI STYLES│  BOTBORGS   │
│ ┌─────────┐ │ ┌─────────┐ │ ┌─────────┐ │
│ │ Video 1 │ │ │ Video 1 │ │ │ Video 1 │ │
│ └─────────┘ │ └─────────┘ │ └─────────┘ │
│ ┌─────────┐ │ ┌─────────┐ │ ┌─────────┐ │
│ │ Video 2 │ │ │ Video 2 │ │ │ Video 2 │ │
│ └─────────┘ │ └─────────┘ │ └─────────┘ │
│ ┌─────────┐ │ ┌─────────┐ │ ┌─────────┐ │
│ │ Video 3 │ │ │ Video 3 │ │ │ Video 3 │ │
│ └─────────┘ │ └─────────┘ │ └─────────┘ │
└─────────────┴─────────────┴─────────────┘
```

**Key Settings:**
- `show_single_video: false` — Enables multi-video display
- `videos_per_playlist: 8` — Number of videos shown per card
- `featured_columns: 3` — Playlist cards per row

**Vertical List Inside Cards:** Videos stack vertically within each playlist card. Each video is clickable to open modal.

---

### Layout Mode 3: Video Grid (Direct) — "Unified Grid Mode"

**Use Case:** Display all videos from multiple playlists in a single unified grid  
**Example:** Martian Games section (combining Devlogs + Gameplay playlists)  
**Appearance:** No playlist card wrappers, all videos in one continuous grid

**YAML Configuration:**
```yaml
page: gamedev
title: "Game Development"

martian_games_playlists:
  title: "Martian Games YouTube Content"
  description: "All Martian Games videos in one grid"
  columns: 3                  # 3 videos per row
  render_mode: "videos"       # ⭐ KEY: Renders videos directly, no playlist cards
  playlists:
    - id: "PL5RIMPpbzR6iA9rAMaDX-B2QfKMQkODwq"
      title: "Martian Games Devlogs"
    - id: "PL6WnzXOaRqA1sfMS1N7EoESHKaTZ2RHh4"
      title: "Martian Games Gameplay"

grid_config:
  videos_per_playlist: 12     # Fetch 12 videos from each playlist
  show_single_video: false    # Not used in "videos" mode
```

**Result:**
```
┌─────────────┬─────────────┬─────────────┐
│ Devlog #1   │ Devlog #2   │ Gameplay #1 │
│ [thumbnail] │ [thumbnail] │ [thumbnail] │
└─────────────┴─────────────┴─────────────┘
┌─────────────┬─────────────┬─────────────┐
│ Gameplay #2 │ Devlog #3   │ Gameplay #3 │
│ [thumbnail] │ [thumbnail] │ [thumbnail] │
└─────────────┴─────────────┴─────────────┘
```

**Key Settings:**
- `render_mode: "videos"` — ⭐ **CRITICAL**: Renders videos directly, skips playlist card wrappers
- `columns: 3` — Videos per row (not playlist cards)
- Videos from ALL playlists appear in one unified grid

**Perfect for:** Sections where you want to show content from multiple playlists as if they're one collection.

---

### Layout Mode 4: Channel RSS Grid — "Latest Uploads Mode"

**Use Case:** Display recent uploads from a YouTube channel  
**Example:** DIY page "Recent Videos" section  
**Appearance:** Grid of most recent videos from channel RSS feed

**YAML Configuration:**
```yaml
page: diy
title: "DIY Projects"

recent_section:
  title: "Recent DIY Videos"
  description: "Latest uploads from @diywjenni"
  channel_rss: true           # ⭐ Indicates this is a channel feed, not playlist
  channel_id: "UCk2SWSg1fvdZGnrN0XAt6NQ"  # @diywjenni channel ID
  columns: 3
  max_videos: 8               # Show 8 most recent uploads

grid_config:
  columns: 3
  enable_hover_effects: true
```

**Alternative (Simplified):**
```yaml
recent_section:
  title: "Recent DIY Videos"
  playlists:
    - id: "CHANNEL:UCk2SWSg1fvdZGnrN0XAt6NQ"  # Channel RSS feed
      title: "Latest Uploads"
      max_videos: 8
```

**Result:**
```
┌─────────────┬─────────────┬─────────────┐
│ Upload 1    │ Upload 2    │ Upload 3    │
│ (2 days ago)│ (3 days ago)│ (5 days ago)│
└─────────────┴─────────────┴─────────────┘
```

**Key Settings:**
- Use channel RSS feed URL instead of playlist ID
- Shows videos in chronological order (newest first)
- Good for "Recent Videos" or "Latest Uploads" sections

---

### Layout Mode 5: Hybrid Layout — "Featured + Gallery Mode"

**Use Case:** Highlight specific featured playlists with rich content (Multi-Video) while keeping the rest compact (Single-Card).
**Example:** DIY page
**Appearance:** Top section shows full-width cards with 3 videos each; bottom section shows a grid of single-video cards.

**YAML Configuration:**
```yaml
page: diy
title: "DIY Projects"

# Top Section: Multi-Video
featured_section:
  container_id: "diyPlaylistsContainer"
  columns: 1                  # Full width
  show_single_video: false    # Show 3 videos per card
  layout: "multi-video"

# Bottom Section: Single-Card
secondary_section:
  container_id: "diySecondaryContainer"
  columns: 3                  # Grid layout
  show_single_video: true     # Show 1 video per card
  layout: "single-card"
```

**Result:**
```
┌───────────────────────────────────────────┐
│ Featured Playlist 1                       │
│ ┌─────────┐ ┌─────────┐ ┌─────────┐       │
│ │ Video 1 │ │ Video 2 │ │ Video 3 │       │
│ └─────────┘ └─────────┘ └─────────┘       │
└───────────────────────────────────────────┘

┌─────────────┬─────────────┬─────────────┐
│ Playlist A  │ Playlist B  │ Playlist C  │
│ [thumbnail] │ [thumbnail] │ [thumbnail] │
└─────────────┴─────────────┴─────────────┘
```

---

### Layout Mode Comparison Table

| Feature | Single Video | Multi-Video | Video Grid | Channel RSS |
|---------|-------------|-------------|------------|-------------|
| **Playlist Cards** | ✅ Yes | ✅ Yes | ❌ No | ❌ No |
| **Videos Per Card** | 1 | 3-8 | N/A | N/A |
| **Unified Grid** | ❌ No | ❌ No | ✅ Yes | ✅ Yes |
| **Best For** | Many playlists | Playlist depth | Combined playlists | Recent uploads |
| **Config Key** | `show_single_video: true` | `show_single_video: false` | `render_mode: "videos"` | `channel_id` |

---

### Column Configuration (All Modes)

**How Columns Work:**

Columns control how many items appear per row. The meaning changes based on layout mode:

| Layout Mode | `columns: 3` means... |
|-------------|----------------------|
| **Playlist Cards (Single/Multi)** | 3 playlist cards per row |
| **Video Grid (Direct)** | 3 videos per row |
| **Channel RSS** | 3 videos per row |

**Column Priority Logic:**

1. **Section-specific** (highest priority)
   ```yaml
   featured_section:
     columns: 3  # Overrides everything else
   ```

2. **Grid config by section name**
   ```yaml
   grid_config:
     featured_columns: 3  # Applies only to featured_section
   ```

3. **Grid config global default**
   ```yaml
   grid_config:
     columns: 3  # Applies to all sections without specific config
   ```

4. **Hardcoded fallback** (3 columns)

**Responsive Behavior:**
- Desktop (≥992px): Full column count (e.g., 3 columns)
- Tablet (768-991px): 2 columns
- Mobile (<768px): 1 column (stacked)

---

### Complete Example: Mixed Layout Page

**Use Case:** Game Dev page with different sections using different layouts

**YAML Configuration:**
```yaml
page: gamedev
title: "Game Development Showcase"

# Section 1: Single-Video Playlist Cards (Gallery Mode)
featured_section:
  title: "Featured Projects"
  playlists:
    - id: "PL9QBjNDhgNwRsznW8e3-KVmwfEuwvr7Yi"
      title: "Devlogs"
    - id: "PL9QBjNDhgNwS8zNaKAFjuWf4NTfk3Ul3g"
      title: "Jenni Styles"
  # Uses: grid_config.featured_columns = 3, show_single_video = false (multi-video)

# Section 2: Video Grid (Unified Grid Mode)
martian_games_playlists:
  title: "Martian Games Videos"
  columns: 3
  render_mode: "videos"       # All videos in unified grid
  playlists:
    - id: "PL5RIMPpbzR6iA9rAMaDX-B2QfKMQkODwq"
      title: "Devlogs"
    - id: "PL6WnzXOaRqA1sfMS1N7EoESHKaTZ2RHh4"
      title: "Gameplay"

# Section 3: Multi-Video Playlist Cards (Vertical List Mode)
learning_section:
  title: "Learning Resources"
  playlists:
    - id: "PL9QBjNDhgNwTnv3qzgtrxReBySCOv7SFN"
      title: "Tips & Tutorials"
    - id: "PL9QBjNDhgNwRUXxQ6Ygp2V1LvFQrCTDSa"
      title: "Unity 3D"
  # Uses: grid_config.learning_columns = 2, videos_per_playlist = 8

grid_config:
  featured_columns: 3         # Featured: 3 playlist cards per row
  martian_games_columns: 3    # Martian Games: 3 videos per row
  learning_columns: 2         # Learning: 2 playlist cards per row
  videos_per_playlist: 8      # Show 8 videos in multi-video cards
  show_single_video: false    # Use multi-video mode by default
  enable_hover_effects: true
```

**Result:** Each section uses a different layout optimized for its content!

---

### Quick Reference: How to Achieve Each Layout

**Want gallery of playlists (1 video each)?**
```yaml
grid_config:
  show_single_video: true
  columns: 3
```

**Want playlists with videos listed inside?**
```yaml
grid_config:
  show_single_video: false
  videos_per_playlist: 8
  columns: 3
```

**Want all videos from multiple playlists in one grid?**
```yaml
section_name:
  render_mode: "videos"
  columns: 3
  playlists:
    - id: "playlist1"
    - id: "playlist2"
```

**Want recent uploads from a channel?**
```yaml
section_name:
  playlists:
    - id: "CHANNEL:UCxxxxxx"
      max_videos: 8
```



---

## 🏷️ Tag Strategy & Optimization

### Tag Philosophy

**Goal:** Enable powerful content filtering across all YouTube playlists using consistent, discoverable tags.

### Tag Categories for YouTube Content

**Gaming Tags (30 tags):**
- **Genres:** horror, fps, rpg, indie, action, multiplayer, survival, puzzle, platformer
- **Platforms:** steam, ps5, nintendo-switch, retro, vr
- **Gameplay:** playthrough, live, highlights, co-op, single-player
- **Content:** funny, moments, speedrun, walkthrough

**Game Dev Tags (37 tags):**
- **Engines:** unity, unreal, godot, blender
- **Skills:** 3d-modeling, animation, shader, vfx, lighting
- **Specific Games:** purgatory-fell, botborgs, jenni-styles, cat-as-trophy
- **Process:** devlog, tutorial, game-jam, ludum-dare

**DIY Tags (20 tags):**
- **Fashion:** fashion, style, no-sew, upcycle
- **Beauty:** hair, nails, makeup, self-care
- **Crafts:** 3d-printing, gfx, creative-tech

### Tag Application in YAML

**gaming.yaml Example:**
```yaml
- id: "PL6WnzXOaRqA0MiE5cffmM2ZZcuSTl9DcS"
  title: "Dead Space 2 [PC] - 1st Playthrough"
  tags: ["gaming", "dead-space", "horror", "survival"]
```

**Tag Canonicalization:**
```javascript
// youtube-grid.js automatically canonicalizes tags
function canonicalizeTags(tags) {
  // "Horror" → "horror"
  // "FPS Games" → "fps"
  // "Nintendo Switch" → "nintendo-switch"
}
```

### Tag Filtering Workflow

```
User clicks tag badge → tag-system.js activates filter
                             ↓
          Filter content by data-tags attribute
                             ↓
          Show only matching playlists/videos
                             ↓
          Display active filter badge with [✕] button
```

**Planned Enhancements:**
- ✅ Genre-specific tag pages (e.g., /tag/horror)
- ✅ Tag clouds on main pages
- 🔄 Multi-tag filtering (OR logic)
- 🔄 Tag analytics (most popular tags)
- 🔄 Related tag suggestions

---

## 🗂️ Page Configurations

### Gaming Page (`gaming.yaml`)

**Playlists:** 30 total
**Layout:** Single-card (1 large thumbnail per playlist)
**Grid:** 3 columns → 2 columns → 1 column (responsive)
**Tags:** Genre + Platform tags displayed on each card
**Special Features:**
- Genre badges (Horror, FPS, RPG, Indie, Action, etc.)
- Platform badges (Steam, PS5, Nintendo Switch, Retro, VR)
- Tag filtering enabled
- Click thumbnail → open video modal

**Example Playlists:**
- Ori and the Blind Forest (platformer, indie)
- Dead Space 2 (horror, survival, fps)
- Resident Evil 2 Remake (horror, survival)
- Apex Legends (multiplayer, fps)

### Game Dev Page (`gamedev.yaml`)

**Sections:**
1. **Featured Projects** (3 cols, 8 videos each)
   - Devlogs
   - Jenni Styles Dress Up Game
   - Cat-As-Trophy
   - Game Jam Highlights
   - Purgatory Fell VR
   - Botborgs

2. **Martian Games** (1 col vertical)
   - Martian Games Devlogs

3. **Learning Resources** (2-3 cols mixed)
   - Tips & Tutorials
   - Unity 3D
   - Unreal Engine

### YouTube Hub Page (`youtube.php` + `youtube.yaml`)

**Purpose:** Central hub for all YouTube content with RSS feed integration and category browsing  
**Added:** November 8, 2025  

**Features:**
1. **RSS Feed Section**
   - Fetches latest 12 videos from main channel via rss2json.com API
   - 4-column responsive grid (xs:1, sm:2, md:3, lg:4)
   - Falls back to channel link if RSS fails

2. **Featured Playlists** (8 total)
   - Curated selection across all content categories
   - 4-column responsive grid matching RSS section
   - 6 videos per playlist

3. **Category Browsing**
   - 6 category cards with tag links
   - Gaming → /tags.php?tag=gaming
   - Game Dev → /tags.php?tag=gamedev
   - DIY → /tags.php?tag=diy
   - AI & Tech → /tags.php?tag=ai
   - Music → /tags.php?tag=music
   - Live Streams → /tags.php?tag=live

4. **Channel Stats**
   - Subscribe button
   - Channel description
   - Social links

**Playlists:**
- Horror Gaming (PL6WnzXOaRqA16UY1KibrFUHu4gDZ8hmep)
- Botborgs Devlog (PL9QBjNDhgNwQYrXaiRwC0RROYmkppbssY)
- Nail Art Tutorials (PL9QBjNDhgNwSp0KPbZ8QqVz-JqGYQn-Ov)
- AI Tools + Info (PL9QBjNDhgNwQygOzxOAYImp0L3zC6pBO2)
- DJ Sets & Music (PLLzfSGTgy8YBL97yf_JRzcc3NWwk8FXyN)
- Live Stream Archive (PL9QBjNDhgNwT6x_pweTniLZxubDvVgKFO)
- Game Jam Highlights (PL6WnzXOaRqA1Bg2Kg_oalYaInTyBCGIUu)
- Voice Acting Reel (PL9QBjNDhgNwQbaceJmfZzc3x4L80gvh8J)

**Grid Configuration:**
```yaml
grid_config:
  columns: { xs: 1, sm: 2, md: 3, lg: 4 }
  videos_per_playlist: 6
  show_single_video: false
  enable_hover_effects: true
  responsive: true
```

**JavaScript Integration:**
```javascript
// youtube.php uses two async loaders:
async function loadYouTubeFeed() {
  // Fetch RSS via rss2json.com API
  // Render latest 12 videos in #youtube-feed-videos
}

async function loadFeaturedPlaylists() {
  // Load youtube.yaml via YouTubeGrid.loadPageConfig('youtube')
  // Render 8 playlists in #youtube-playlists container
}
```

**Routing:**
- `/youtube` → youtube.php
- `/youtube/` → youtube.php
- `/youtube.php` → youtube.php
   - Blender

### DIY Page (`diy.yaml`)

**Sections:**
1. **Recent Videos** (RSS feed, 8 videos)
2. **Fashion & Style** (4 playlists)
3. **Hair Styling** (1 playlist)
4. **Nail Art & Self Care** (4 playlists)
5. **Brand Collaborations** (2 playlists)
6. **Creative Tech** (1 playlist)

**Grid:** 3 columns, 6 videos per playlist

---

## 🔧 Server-Side Proxy: get-youtube.php

### Purpose

- **Avoid CORS issues** - Browser can't directly fetch YouTube RSS
- **Server-side caching** - Reduce YouTube requests
- **XML → JSON conversion** - Easier to parse in JavaScript
- **Auto-create cache directory** - No manual setup needed

### How It Works

```php
<?php
// 1. Accept playlist_id or rss URL
$playlistId = $_GET['playlist_id'];
$rss = 'https://www.youtube.com/feeds/videos.xml?playlist_id=' . $playlistId;

// 2. Check cache (10 min TTL)
$cacheFile = "storage/cache/youtube/" . md5($rss) . ".json";
if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 600)) {
  readfile($cacheFile); // Serve from cache
  exit;
}

// 3. Fetch RSS from YouTube
$xml = file_get_contents($rss);
$parsed = simplexml_load_string($xml);

// 4. Convert to JSON
$json = json_encode($parsed);
file_put_contents($cacheFile, $json); // Cache it

// 5. Return JSON
echo $json;
```

**IMPORTANT: XML Namespace Conversion**

When `json_encode()` serializes SimpleXMLElement objects, **namespace prefixes are removed** from property names:

- `<yt:videoId>` in RSS XML → `video.videoId` in JSON (NOT `video['yt:videoId']`)
- `<media:thumbnail>` in RSS XML → `video.thumbnail` in JSON (after get-youtube.php processing)

**Why This Matters for JavaScript:**

```javascript
// ❌ WRONG - This will fail after json_encode()
const videoId = video['yt:videoId'];

// ✅ CORRECT - Access direct property, with namespace fallback
const videoId = video.videoId || video['yt:videoId'] || '';

// ✅ ALSO CORRECT - Thumbnail added by get-youtube.php
const thumbnail = video.thumbnail || `https://i.ytimg.com/vi/${videoId}/mqdefault.jpg`;
```

**get-youtube.php Enhancement:**

The server-side proxy explicitly adds `videoId` and `thumbnail` as child elements to make JavaScript access easier:

```php
// Extract from namespace-prefixed XML tags
$videoId = (string)$entry->children('yt', true)->videoId;
$thumbnail = (string)$entry->children('media', true)->group->thumbnail->attributes()->url;

// Add as direct child elements for easy JS access
$entry->addChild('videoId', $videoId);
$entry->addChild('thumbnail', $thumbnail);
```

See `public_html/resources/api/get-youtube.php` lines 113-152 for full implementation.

### Cache Files

**Location:** `storage/cache/youtube/`  
**Format:** `[MD5_HASH].json`  
**Example:** `a1c302444120.json` = MD5 of RSS feed URL  
**TTL:** 10 minutes  
**Auto-cleanup:** No (files overwrite themselves when stale)  

### Client Usage

```javascript
const proxyUrl = `${RESOURCE_BASE}/api/get-youtube.php?playlist_id=${playlistId}`;
const response = await fetch(proxyUrl);
const data = await response.json();
```

---

## 💾 Caching Strategy

### Two-Tier Caching System

**Tier 1: Server-Side Cache (10 minutes)**
- Location: `storage/cache/youtube/*.json`
- Reduces YouTube RSS requests
- Shared across all users
- Auto-regenerates when stale

**Tier 2: Client-Side Cache (24 hours)**
- Location: JavaScript Map() in memory
- Per-user caching
- Persists during browser session
- Key: `playlist_${ID}_${maxResults}`

### Cache Performance

| Scenario | Server Requests | YouTube Requests |
|----------|----------------|------------------|
| **First visit** | 1 per playlist | 1 per playlist |
| **Reload (< 10 min)** | 1 per playlist | 0 (served from server cache) |
| **Reload (< 24 hrs)** | 0 | 0 (served from client cache) |
| **After 24 hrs** | 1 per playlist | 1 per playlist (if server cache stale) |

**Result:** Gaming page with 30 playlists:
- First visit: 30 requests
- Subsequent visits: 0 requests (for 24 hours)

---

## 🚀 Deployment

### Files to Deploy

**✅ Include:**
- `public_html/resources/api/get-youtube.php` (RSS proxy)
- `public_html/resources/js/youtube-grid.js` (v3.0)
- `public_html/resources/playlists/*.yaml` (all configs)
- `public_html/resources/playlists/playlist-ids.json` (master registry)
- `public_html/resources/playlists/tags.json` (tag database)

**❌ Exclude:**
- `storage/cache/youtube/*.json` (server creates these)
- `src/` (development files)
- `scripts/` (build scripts)
- `storage/docs/` (documentation)

### Post-Deploy (Server)

```bash
# Auto-run by deployment script:
./scripts/fix-permissions-jenninexus-remote.sh

# Creates runtime directories:
storage/cache/youtube/     (755, www-data:www-data)
storage/secrets/           (700, www-data:www-data)
storage/patreon/           (755, www-data:www-data)
storage/logs/              (755, www-data:www-data)
```

**First Page Load:** Server auto-creates cache files as playlists are requested.

---

## 🧪 Testing Checklist

### RSS Feed Testing

- [ ] Visit http://localhost:8002/gaming.php
- [ ] Check console: "✅ Gaming page: Loading playlists from gaming.yaml"
- [ ] Verify all 30 playlists display with thumbnails
- [ ] Check Network tab: RSS requests go to `/resources/api/get-youtube.php`
- [ ] Verify cache files created: `storage/cache/youtube/*.json`

### Thumbnail Quality Testing

- [ ] Inspect thumbnail URLs: Should be `i3.ytimg.com` (RSS feed URLs)
- [ ] Check resolution: 480x360 (hqdefault) not 320x180 (mqdefault)
- [ ] Verify fallback works: If RSS fails, constructed URL used
- [ ] Test image error handling: Purple gradient fallback displayed

### Tag Filtering Testing

- [ ] Click genre tag badge (e.g., "Horror")
- [ ] Verify filter activates: Active badge appears
- [ ] Check results: Only horror playlists visible
- [ ] Test multi-tag: Click another tag (OR logic)
- [ ] Test clear filters: All playlists return

### Cache Testing

```powershell
# Clear cache
Remove-Item .\storage\cache\youtube\*.json -Force

# First page load (cold cache)
# - Check Network tab: 30 RSS requests
# - Verify cache files created

# Reload page (warm cache)
# - Check Network tab: 0 RSS requests
# - Verify served from cache
```

---

## 🐛 Troubleshooting

### No Thumbnails Showing

**Symptom:** Dark/empty playlist cards  
**Causes:**
1. RSS feed returning 404 (playlist ID invalid)
2. Playlist has 0 videos
3. Network timeout fetching RSS

**Solution:**
- Check console for errors
- Verify playlist ID in YAML file
- Test RSS URL manually: `https://www.youtube.com/feeds/videos.xml?playlist_id=YOUR_ID`
- Check if fallback purple gradient appears (expected for empty playlists)

### Cache Not Updating

**Symptom:** Old videos still showing after 10+ minutes  
**Cause:** Server cache file timestamp not expiring  

**Solution:**
```bash
# Delete cache files
rm /var/www/jenninexus/storage/cache/youtube/*.json

# Reload page (will regenerate cache)
```

### CORS Errors

**Symptom:** "CORS policy blocked" in console  
**Cause:** Trying to fetch YouTube RSS directly from browser  

**Solution:** Always use the proxy:
```javascript
// ✅ CORRECT
const url = '/resources/api/get-youtube.php?playlist_id=...';

// ❌ WRONG
const url = 'https://www.youtube.com/feeds/videos.xml?playlist_id=...';
```

### Missing Playlists on Page

**Symptom:** Some playlists don't render  
**Causes:**
1. Playlist ID typo in YAML
2. RSS feed returns empty (private playlist)
3. JavaScript error in youtube-grid.js
4. Missing js-yaml library

**Solution:**
- Check browser console for errors
- Validate YAML syntax (use online YAML validator)
- Test each playlist ID manually
- Check container div exists in HTML (e.g., `#featured-playlists`)
- Verify js-yaml script loaded (search page source for "js-yaml")

### Playlists Not Rendering (Oct 30, 2025 Fix)

**Symptom:** Gray placeholders never replace with videos, console error: `ReferenceError: jsyaml is not defined`  
**Cause:** js-yaml library not loaded from CDN  

**Solution:**
1. **Add js-yaml to includes/head.php:**
   ```html
   <script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
   ```

2. **Verify script loaded:**
   - View page source (Ctrl+U)
   - Search for "js-yaml"
   - Should see script tag in `<head>`

3. **Check console:**
   - Open browser console (F12)
   - Type: `typeof jsyaml`
   - Should return: `"object"` (not "undefined")

4. **Hard refresh page:**
   - Press Ctrl+Shift+R to clear browser cache
   - Playlists should now render

**Grid Config Issues:**

**Symptom:** Wrong number of columns (all playlists showing in 3 columns when expecting 2)  
**Cause:** Missing section-specific column config OR section.columns not being read  

**Solution:**
1. **Check YAML file has grid_config:**
   ```yaml
   grid_config:
     featured_columns: 3      # Featured section
     learning_columns: 2      # Learning section
     martian_games_columns: 2 # Martian Games section
     columns: 3               # Global fallback
   ```

2. **Or add columns to section:**
   ```yaml
   martian_games_playlists:
     columns: 2  # Section-specific override
     playlists:
       - id: "PL..."
   ```

3. **Column priority logic:**
   - Priority 1: `section.columns` (highest)
   - Priority 2: `grid_config.{section}_columns`
   - Priority 3: `grid_config.columns` (global default)
   - Priority 4: Hardcoded fallback (3)

**Test Column Logic:**
```javascript
// In browser console after page loads
console.log('Featured config:', window.YouTubeGrid);
// Check which column count is being used
```

### Video Grid Not Responsive / Cards Stacking Vertically (Nov 2, 2025 Fix)

**Symptom:** All playlist cards display in a single vertical column instead of responsive grid layout  
**Cause:** Custom CSS Grid rules overriding Bootstrap's flexbox grid system  

**Problem Code (gamedev-theme.css):**
```css
#featured-playlists,
#learning-playlists {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 1.5rem;
}
```

**Why This Breaks:**
- Bootstrap uses flexbox with `row` and `col-*` classes
- CSS Grid with `display: grid` overrides Bootstrap's flexbox layout
- Column classes like `col-md-6 col-lg-4` become ineffective
- Forces single-column layout on all screen sizes

**Solution:**
1. **Remove custom grid CSS** from theme files (gamedev-theme.css, gaming-theme.css, etc.):
   ```css
   /* REMOVE these rules: */
   #featured-playlists,
   #learning-playlists {
     display: grid;
     grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
   }
   ```

2. **Ensure HTML uses Bootstrap row class:**
   ```html
   <div id="featured-playlists" class="row g-4 mb-4">
     <!-- youtube-grid.js will populate with col-* divs -->
   </div>
   ```

3. **Verify youtube-grid.js creates column wrappers:**
   - Cards are wrapped in divs with responsive classes: `col-12 col-sm-6 col-md-4 col-lg-4`
   - Responsive column classes handle breakpoints automatically

4. **Rebuild CSS:**
   ```powershell
   .\scripts\build.ps1
   ```

5. **Hard refresh browser:** Ctrl+Shift+R to clear cached CSS

**Correct Approach:**
- Let Bootstrap's grid system handle responsiveness
- YAML config controls columns: `columns: { xs: 1, sm: 2, md: 3, lg: 3 }`
- youtube-grid.js generates proper Bootstrap column classes
- No custom CSS Grid needed on container elements

### Cache Clearing Steps (Complete Reset)

**When to use:** After major changes to playlists, tags, or YAML configs

**Client-Side (Browser):**
```
1. Hard refresh: Ctrl+Shift+R (Chrome/Firefox)
2. Clear localStorage: F12 → Application → Local Storage → Clear All
3. Clear cache: Ctrl+Shift+Delete → Check "Cached images/files"
```

**Server-Side (Production):**
```bash
# SSH into server
ssh jenni@jenninexus.com

# Clear YouTube cache
rm /var/www/jenninexus/storage/cache/youtube/*.json

# Reload PHP-FPM (optional, if changes to PHP files)
sudo systemctl reload php8.2-fpm

# Reload Nginx (optional, if changes to nginx config)
sudo systemctl reload nginx
```

**Local Development:**
```powershell
# Clear local YouTube cache (if running dev server)
Remove-Item -Path "C:\Users\Owner\Projects\www\jenninexus\storage\cache\youtube\*.json" -Force

# Restart dev server
# Ctrl+C to stop, then:
.\scripts\dev-server.ps1
```

---

## 📚 Related Documentation

- `TAG-SYSTEM.md` - Tag filtering architecture, maintenance, cleanup
- `PLAYLIST-MAPPING.md` - Complete playlist registry, YAML file explanations
- `GAMING-PAGE-UPDATE.md` - Single-card layout details
- `DEPLOYMENT-GUIDE.md` - Full deployment process
- `10-30.md` - Current session action plan

---

## 🎯 Future Enhancements

**Planned Features:**
- ✅ Real thumbnail extraction from RSS (DONE v3.0)
- ✅ Single-card layout mode (DONE)
- ✅ Tag-based filtering (DONE)
- 🔄 YouTube Shorts support (separate layout)
- 🔄 Playlist metadata caching (title, description)
- 🔄 Related videos suggestions
- 🔄 View count display (requires scraping)
- 🔄 Auto-refresh cache on deploy

**Tag System Enhancements:**
- ✅ Dynamic tag loading from tags.json (DONE v3.0)
- ✅ Tag canonicalization (DONE)
- 🔄 Tag analytics dashboard
- 🔄 Tag popularity tracking
- 🔄 Related tag suggestions
- 🔄 Tag-based playlists (auto-generated)

---

## 📝 Version History

**v3.0 (Oct 28, 2025):**
- Removed ALL YouTube API code
- RSS-only architecture
- Real thumbnail extraction from `<media:thumbnail>` tags
- Higher quality thumbnails (480x360)
- Tag system v3.0 (dynamic loading)
- Gaming page single-card layout

**v2.0 (Oct 21, 2025):**
- Updated Jenni Styles playlist ID
- Hybrid RSS + API approach
- Server-side proxy introduced

**v1.0 (2024):**
- Initial YouTube API integration
- Basic playlist display

---

**Last Updated:** October 28, 2025  
**Maintained By:** JenniNexus Development Team  
**Questions?** See `storage/10-28.md` for session notes
