
# Game Pages Documentation - JenniNexus
**Last Updated:** November 9, 2025  
**Status:** ✅ ACTIVE - RSS Feed Video System  
**Purpose:** Complete documentation of game page architecture, video embedding, and YAML configuration

---

## 🎯 Executive Summary

JenniNexus game pages use a **YouTube RSS feed system** (no API key required) integrated with Bootstrap 5.3.8 for responsive video grids. All video data is fetched via RSS feeds, cached, and rendered using `youtube-grid.js`.

**Key Architecture Points:**
- ✅ **No YouTube API** - All video data via RSS feeds
- ✅ **Bootstrap 5.3.8 Grid** - Proper responsive column classes
- ✅ **RSS Proxy** - Server-side `get-youtube.php` handles CORS and caching
- ✅ **YAML Configuration** - gamedev.yaml is single source of truth
- ✅ **Tag System Integration** - All videos have clickable tag badges

---

## � Game Page Template

This template shows the complete structure for a game page with all required scripts, includes, and functionality.

### Required Files

**PHP Includes (in <head>):**
```php
<?php
$activePage = 'gamedev';
$pageTitle = 'Game Name | JenniNexus';
$pageDescription = 'Description of your game';
$pageKeywords = 'game, unity, indie, keywords';
$customCSS = ['resources/css/gamedev-theme.min.css'];
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <?php 
    include __DIR__ . '/../includes/head.php';
    include __DIR__ . '/../includes/game-cta-helper.php';  // REQUIRED for CTA buttons
  ?>
```

**JavaScript Scripts (before </body>):**
```php
<!-- Bootstrap 5.3.8 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
        crossorigin="anonymous"></script>

<!-- js-yaml already loaded in head.php -->

<!-- Custom Scripts (LOAD IN THIS ORDER) -->
<script src="<?= RES_ROOT ?>/js/tag-filter-api<?= $assetSuffix ?? '' ?>.js"></script>  <!-- REQUIRED for tag badges -->
<script src="<?= RES_ROOT ?>/js/youtube-grid<?= $assetSuffix ?? '' ?>.js"></script>     <!-- REQUIRED if videos -->
<script src="<?= RES_ROOT ?>/js/tag-system<?= $assetSuffix ?? '' ?>.js"></script>       <!-- REQUIRED for tag system -->

<script>
  // Initialize tag filter API
  if (window.tagFilter && typeof window.tagFilter.init === 'function') {
    window.tagFilter.init();
  }
  
  // Video loading code (if page has videos)
  // See "Modern Video Embedding Pattern" section below
</script>
```

### Complete Template Structure

```php
<?php
$activePage = 'gamedev';
$pageTitle = 'Game Name | JenniNexus';
$pageDescription = 'Game description';
$pageKeywords = 'keywords';
$customCSS = ['resources/css/gamedev-theme.min.css'];
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <?php 
    include __DIR__ . '/../includes/head.php';
    include __DIR__ . '/../includes/game-cta-helper.php';
  ?>
  <body>
    
  <?php include __DIR__ . '/../includes/header.php'; ?>

    <!-- Hero Section -->
    <div class="bg-dark text-white py-5 hero-section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-3">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/gamedev" class="text-white">Game Dev</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Game Name</li>
              </ol>
            </nav>
            <h1 class="display-4 fw-bold mb-3">Game Name</h1>
            <p class="lead mb-4">Game description</p>
            
            <!-- Tag Badges (MUST have tag-filter-api.js loaded) -->
            <div class="d-flex gap-2 flex-wrap mb-4">
              <a href="/tags.php?filters=unity" class="badge bg-secondary me-1 text-decoration-none tag-badge">Unity</a>
              <a href="/tags.php?filters=indie" class="badge bg-secondary me-1 text-decoration-none tag-badge">Indie</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Game CTA (uses game-cta-helper.php) -->
    <?php renderGameCTA('game-slug'); ?>

    <!-- Main Content -->
    <div class="container my-5">
      <!-- Game description, screenshots, etc. -->
      
      <!-- Videos Section (if applicable) -->
      <section class="mb-5" id="videos">
        <h2 class="mb-4">Videos</h2>
        <div id="game-videos" class="row g-4" data-tags="unity,indie,gamedev">
          <!-- Video cards rendered by youtube-grid.js -->
        </div>
      </section>
    </div>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <!-- Scripts (in order) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
            crossorigin="anonymous"></script>
    <script src="<?= RES_ROOT ?>/js/tag-filter-api<?= $assetSuffix ?? '' ?>.js"></script>
    <script src="<?= RES_ROOT ?>/js/youtube-grid<?= $assetSuffix ?? '' ?>.js"></script>
    <script src="<?= RES_ROOT ?>/js/tag-system<?= $assetSuffix ?? '' ?>.js"></script>
    
    <script>
      // Initialize tag filter
      if (window.tagFilter && typeof window.tagFilter.init === 'function') {
        window.tagFilter.init();
      }
      
      // Load videos (if applicable)
      // See "Modern Video Embedding Pattern" section
    </script>
  </body>
</html>
```

### Critical Requirements Checklist

✅ **PHP Includes:**
- [ ] `include __DIR__ . '/../includes/head.php';` - Site header and meta
- [ ] `include __DIR__ . '/../includes/game-cta-helper.php';` - CTA button helper
- [ ] `include __DIR__ . '/../includes/header.php';` - Navigation header
- [ ] `include __DIR__ . '/../includes/footer.php';` - Site footer

✅ **JavaScript Scripts (in order):**
- [ ] Bootstrap 5.3.8 bundle (with SRI hash)
- [ ] `tag-filter-api.js` - **REQUIRED** for clickable tag badges
- [ ] `youtube-grid.js` - REQUIRED if page displays videos
- [ ] `tag-system.js` - REQUIRED for tag filtering
- [ ] `window.tagFilter.init()` - Initialize tag system

✅ **HTML Elements:**
- [ ] Hero section with `.hero-section` class
- [ ] Tag badges with `.tag-badge` class and `data-tag-slug` attribute
- [ ] Tag badges with `onclick="window.tagFilter.toggle('slug')"` handler
- [ ] Video container with `id` matching JavaScript config (if videos)
- [ ] Video container with `data-tags` attribute for filtering

✅ **Constants:**
- [ ] `RES_ROOT` - Used in script `src` paths (defined by game-cta-helper.php)
- [ ] `$assetSuffix` - Minified vs dev file selection

---

## �📺 Video System Architecture (RSS Feed Based)

### How It Works

1. **YAML Configuration** (gamedev.yaml)
   - Defines playlists with IDs, titles, tags, icons
   - Example: `id: "PL9QBjNDhgNwS8zNaKAFjuWf4NTfk3Ul3g"` (Jenni Styles playlist)

2. **JavaScript Fetch** (jennistyles.php, catgame.php, purgatoryfell.php)
   - Loads gamedev.yaml via fetch()
   - Finds playlist by ID
   - Calls `window.YouTubeGrid.renderSection()` with configuration

3. **youtube-grid.js Processing**
   - `renderSection()` creates Bootstrap grid structure (`row g-4`)
   - `fetchPlaylistVideos()` calls RSS proxy
   - `createVideoThumbnail()` generates Bootstrap cards with `ratio-16x9`

4. **RSS Proxy** (get-youtube.php)
   - Receives: `?playlist_id=PL9QBjNDhgNwS8zNaKAFjuWf4NTfk3Ul3g`
   - Fetches: `https://www.youtube.com/feeds/videos.xml?playlist_id=...`
   - Caches: `/var/www/jenninexus/storage/cache/youtube/` (10 minute TTL)
   - Returns: JSON with video objects (id, title, thumbnail, publishedAt)

5. **Bootstrap Grid Rendering**
   - Responsive columns via `getResponsiveColClasses()`:
     - `{ xs: 1, sm: 2, md: 2, lg: 4 }` → `"col-12 col-sm-6 col-md-6 col-lg-3"`
   - Aspect ratio via `getAspectRatioClass()`:
     - `"16:9"` → `"ratio-16x9"` (Bootstrap utility class)
   - Each video wrapped in Bootstrap card component

### RSS Feed URL Format

```
https://www.youtube.com/feeds/videos.xml?playlist_id={PLAYLIST_ID}
```

**No authentication required** - Public RSS feeds only

### Cache Architecture

**Client-Side Cache:**
- localStorage key: `playlist_{playlistId}_{maxResults}`
- TTL: 24 hours (86400000ms)
- Used by: `fetchPlaylistVideos()` in youtube-grid.js

**Server-Side Cache:**
- Location: `/var/www/jenninexus/storage/cache/youtube/`
- Filename: `{md5_hash}.json`
- TTL: 10 minutes (600s)
- Managed by: get-youtube.php proxy
- Fallback: Serves stale cache if fresh fetch fails

---

## 🏗️ Modern Video Embedding Pattern (RECOMMENDED)

This is the pattern used by jennistyles.php, catgame.php, and purgatoryfell.php:

### 1. HTML Container

```php
<!-- Video Section -->
<section class="mb-5" id="videos">
  <h2 class="mb-4">Jenni Styles Videos</h2>
  <div id="jennistyles-videos" class="row g-4" data-tags="jennistyles,gamedev,unity,fashion">
    <!-- Video cards will be rendered here by youtube-grid.js -->
  </div>
</section>
```

**Key Requirements:**
- `id="container-id"` - Matches `container_id` in JavaScript config
- `class="row g-4"` - Bootstrap grid row with gutter spacing (optional - script creates if missing)
- `data-tags="..."` - Tag slugs for filtering system

### 2. JavaScript Configuration

```javascript
function loadJenniStylesVideos() {
  console.log('🎮 Starting to load videos...');
  
  // 1. Fetch gamedev.yaml configuration
  fetch('<?= RES_ROOT ?>/playlists/gamedev.yaml')
    .then(response => {
      if (!response.ok) throw new Error(`HTTP ${response.status}`);
      return response.text();
    })
    .then(yamlText => {
      console.log('📄 Loaded gamedev.yaml');
      const config = jsyaml.load(yamlText);
      
      // 2. Find playlist by ID
      const playlist = config.featured_section.playlists.find(
        p => p.id === 'PL9QBjNDhgNwS8zNaKAFjuWf4NTfk3Ul3g'
      );
      
      if (playlist) {
        console.log('✅ Found playlist:', playlist);
        
        // 3. Configure rendering
        const sectionConfig = {
          container_id: 'jennistyles-videos',
          render_mode: 'videos',                    // 'videos' = individual thumbnails, 'cards' = playlist cards
          columns: { xs: 1, sm: 2, md: 2, lg: 4 },  // Responsive breakpoints
          videos_per_playlist: 8,                   // Number of videos to fetch
          aspect_ratio: '16:9',                     // Video thumbnail aspect ratio
          playlists: [playlist]                     // Array of playlist objects
        };
        
        console.log('📺 Rendering videos with config:', sectionConfig);
        
        // 4. Render videos
        window.YouTubeGrid.renderSection('jennistyles-videos', sectionConfig, config.grid_config || {})
          .then(() => console.log('✅ Videos rendered successfully'))
          .catch(err => console.error('❌ Render error:', err));
      } else {
        console.error('❌ Playlist not found in gamedev.yaml');
      }
    })
    .catch(e => console.error('❌ Failed to load gamedev.yaml:', e));
}

// Wait for DOM and YouTubeGrid to be ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', loadJenniStylesVideos);
} else {
  loadJenniStylesVideos();
}
```

### 3. Bootstrap Integration Details

**Responsive Columns:**
```javascript
columns: { xs: 1, sm: 2, md: 2, lg: 4 }
```
↓ Converted by `getResponsiveColClasses()` ↓
```html
<div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4">
```

**Result:** 1 column mobile, 2 tablet, 2 medium, 4 desktop

**Aspect Ratio:**
```javascript
aspect_ratio: '16:9'
```
↓ Converted by `getAspectRatioClass()` ↓
```html
<div class="ratio ratio-16x9">
```

**Result:** Bootstrap aspect ratio container (56.25% padding-top)

**Card Structure:**
```html
<div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4">
  <div class="card h-100 border border-secondary border-opacity-25 shadow-sm hover-lift">
    <div class="ratio ratio-16x9 rounded-top overflow-hidden" data-video-id="{VIDEO_ID}">
      <img src="{THUMBNAIL_URL}" alt="{VIDEO_TITLE}" class="object-fit-cover hover-zoom" loading="lazy">
      <div class="play-overlay">
        <i class="bi bi-play-circle-fill fs-1 text-white"></i>
      </div>
    </div>
    <div class="card-body p-3">
      <h6 class="card-title mb-2">{VIDEO_TITLE}</h6>
      <div class="d-flex flex-wrap gap-1 mt-2">
        <span class="badge bg-secondary bg-opacity-50 text-white tag-badge" data-tag-slug="unity">Unity</span>
        <span class="badge bg-secondary bg-opacity-50 text-white tag-badge" data-tag-slug="gamedev">Game Dev</span>
      </div>
    </div>
  </div>
</div>
```

---

## 📋 Game Pages Implementation Status

### Pattern A: Modern gamedev.yaml Fetch ✅ PERFECT

| Page | Playlist ID | Config | Status |
|------|------------|--------|--------|
| **jennistyles.php** | PL9QBjNDhgNwS8zNaKAFjuWf4NTfk3Ul3g | 8 videos, 1/2/2/4 columns, 16:9 | ✅ COMPLETE |
| **catgame.php** | PLLzfSGTgy8YBL97yf_JRzcc3NWwk8FXyN | 4 videos, 1/2/3/4 columns, 16:9 | ✅ COMPLETE |
| **purgatoryfell.php** | PL9QBjNDhgNwTsF4Es4jEftJR2Tto1CU53 | 8 videos, 1/2/3/4 columns, 16:9 | ✅ COMPLETE |

**Benefits:**
- Single source of truth (gamedev.yaml)
- Automatic tag badges from YAML config
- Consistent responsive grid across all pages
- 16:9 aspect ratio enforcement
- RSS feed caching (no API rate limits)

### Pattern B: Legacy renderPlaylist() ✅ STABLE

| Page | Method | Status | Recommendation |
|------|--------|--------|---------------|
| **botborgs.php** | `renderPlaylist()` | ✅ STABLE | Optional: Migrate to Pattern A |
| **martiangames.php** | `renderPlaylist()` | ✅ STABLE | Optional: Migrate to Pattern A |
| **cowdefender.php** | `renderPlaylistSection()` | ✅ STABLE | Optional: Migrate to Pattern A |

**Status**: These methods are **STABLE** and will remain supported in youtube-grid.js v3.0+

**Current Implementation** (botborgs.php lines 95-101):
```javascript
window.YouTubeGrid.renderPlaylist('botborgs-playlist', playlistId, { 
  columns: { xs: 1, sm: 2, md: 3, lg: 4 }, 
  maxVideos: 8 
});
```

**Advantages of Current Pattern**:
- ✅ Simple API - single function call
- ✅ Works without YAML config files
- ✅ No js-yaml.js dependency
- ✅ Perfect for single-playlist pages

**When to Keep Pattern B**:
- Single playlist per page (botborgs, martiangames, cowdefender)
- Simple game showcase pages
- No need for complex section layouts

**When to Migrate to Pattern A**:
- Multiple playlists on one page
- Need section-based layouts (Featured, Learning, Archive)
- Want centralized YAML configuration
- Using tag system extensively

### Pattern C: Static HTML (No Videos)

| Page | Type | Status |
|------|------|--------|
| **blueballs.php** | Static game page | ✅ CLEAN |
| **cleanupinisle3.php** | Static game page | ✅ CLEAN |
| **graveyardsmashers.php** | Static game page | ✅ CLEAN |
| **momshouse.php** | Static game page | ✅ CLEAN |
| **soccercow.php** | Static game page | ✅ CLEAN |

---

## 🔧 youtube-grid.js Bootstrap Integration

### Key Functions

#### 1. getResponsiveColClasses(columns)

**Purpose:** Convert YAML column config to Bootstrap classes

**Input:**
```javascript
{ xs: 1, sm: 2, md: 2, lg: 4 }
```

**Output:**
```javascript
"col-12 col-sm-6 col-md-6 col-lg-3"
```

**Bootstrap Breakpoints:**
- `xs` (< 576px) → `col-12` (100% width)
- `sm` (≥ 576px) → `col-sm-6` (50% width)
- `md` (≥ 768px) → `col-md-6` (50% width)
- `lg` (≥ 992px) → `col-lg-3` (25% width)

#### 2. getAspectRatioClass(ratio)

**Purpose:** Convert aspect ratio string to Bootstrap class

**Supported Ratios:**
- `"16:9"` → `"ratio-16x9"` (landscape video, 56.25%)
- `"9:16"` → `"ratio-9x16"` (portrait/shorts, 177.78%)
- `"4:3"` → `"ratio-4x3"` (classic TV, 75%)
- `"1:1"` → `"ratio-1x1"` (square, 100%)
- `"21:9"` → `"ratio-21x9"` (ultrawide, 42.86%)

**Default:** `"ratio-16x9"` if unspecified or invalid

#### 3. renderSection(sectionId, sectionConfig, gridConfig)

**Purpose:** Main rendering function - creates Bootstrap grid structure

**When render_mode === 'videos':**
1. Creates `<div class="row g-4">` container
2. For each playlist:
   - Calls `fetchPlaylistVideos(playlist.id, videosPerPlaylist)`
   - For each video:
     - Calls `createVideoThumbnail(video, index, aspectRatio, playlist)`
     - Wraps in column div with responsive classes
     - Appends to row
3. Appends row to container

**Bootstrap Classes Applied:**
- Container: `row g-4` (grid row with 1.5rem gutter)
- Columns: `col-* mb-4` (responsive column + bottom margin)
- Cards: `card h-100 border border-secondary border-opacity-25 shadow-sm hover-lift`
- Aspect ratio: `ratio ratio-{ratio}` (e.g., `ratio-16x9`)

#### 4. fetchPlaylistVideos(playlistId, maxResults)

**Purpose:** Fetch videos from YouTube RSS feed via proxy

**Flow:**
1. Check localStorage cache (24 hour TTL)
2. If cached and fresh → return cached data
3. If stale/missing → fetch from proxy:
   ```
   GET /resources/api/get-youtube.php?playlist_id={PLAYLIST_ID}
   ```
4. Proxy fetches YouTube RSS feed
5. Parse RSS XML entries to JSON
6. Extract: video ID, title, thumbnail URL, published date
7. Cache result in localStorage
8. Return array of video objects

**RSS Thumbnail Extraction:**
```javascript
// Priority 1: RSS feed media:thumbnail
if (item['media:group'] && item['media:group']['media:thumbnail']) {
  const mediaThumbnail = item['media:group']['media:thumbnail'];
  if (Array.isArray(mediaThumbnail)) {
    // Pick highest resolution (usually last in array)
    thumb = mediaThumbnail[mediaThumbnail.length - 1]['@attributes']?.url || '';
  } else {
    thumb = mediaThumbnail['@attributes']?.url || '';
  }
}

// Priority 2: Fallback to standard YouTube thumbnail
if (!thumb && vid) {
  thumb = `https://img.youtube.com/vi/${vid}/mqdefault.jpg`;
}
```

#### 5. createVideoThumbnail(video, index, aspectRatio, playlist)

**Purpose:** Create Bootstrap card for single video

**Bootstrap Components Used:**
- `card` - Main card component
- `ratio ratio-{ratio}` - Aspect ratio container
- `rounded-top` - Rounded corners on image
- `overflow-hidden` - Clip rounded corners
- `object-fit-cover` - Scale image to fill container
- `card-body` - Card content area
- `card-title` - Video title
- `badge` - Tag badges
- `d-flex flex-wrap gap-1` - Tag badge container

**Tag Badge Integration:**
```javascript
if (playlist && playlist.tags && Array.isArray(playlist.tags)) {
  card.classList.add('content-item');
  const slugs = playlist.tags.map(canonicalizeTag).filter(Boolean);
  card.setAttribute('data-tags', slugs.join(','));
  
  // Render clickable tag badges
  playlist.tags.map(tag => {
    const slug = canonicalizeTag(tag);
    return `<span class="badge bg-secondary bg-opacity-50 text-white tag-badge" 
                   data-tag-slug="${slug}" 
                   onclick="window.tagFilter?.toggle('${slug}')">
              ${tag}
            </span>`;
  }).join('');
}
```

---

## 📊 Configuration Parameters

### sectionConfig Object

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `container_id` | string | `${sectionId}-playlists` | ID of HTML container |
| `render_mode` | string | `'cards'` | `'videos'` or `'cards'` |
| `columns` | object | `{ xs: 1, sm: 2, md: 3 }` | Responsive breakpoints |
| `videos_per_playlist` | number | `6` | Number of videos to fetch |
| `aspect_ratio` | string | `'16:9'` | Video thumbnail ratio |
| `playlists` | array | `[]` | Array of playlist objects from YAML |

### gridConfig Object (from gamedev.yaml)

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `videos_per_playlist` | number | `6` | Global default if not in sectionConfig |
| `enable_hover_effects` | boolean | `true` | Enable hover animations |
| `columns` | object | `{ xs: 1, sm: 2, md: 3 }` | Fallback if not in sectionConfig |

---

## 🚨 Common Issues & Solutions

### Issue 0: Double-Lift Hover Glitch
**Symptoms:**
- Hovering over a video makes the entire outer panel (the card wrapping the grid) lift as well.
- Glitchy, jittery animation when mouse enters/leaves video cards.

**Cause:**
Nested cards. If a `youtube-grid` container is placed inside a Bootstrap `.card`, both cards will trigger their `:hover` state simultaneously.

**Fix:**
Apply the `.card-static` class to the **outer wrapper card**. This disables the global hover lift for that specific element while allowing the inner video cards to lift normally.

```html
<!-- ✅ CORRECT: Outer card is static, inner videos will lift -->
<div class="card card-static steam-gradient">
  <div class="card-body">
    <div id="my-video-grid"></div>
  </div>
</div>
```

### Issue 1: Videos Not Displaying

**Symptoms:**
- Title shows but no video thumbnails
- Empty container

**Debug Steps:**
1. Open browser console (F12)
2. Look for logging checkpoints:
   - 🎮 Starting to load videos...
   - 📄 Loaded gamedev.yaml
   - ✅ Found playlist: {object}
   - 📺 Rendering videos with config: {object}
   - ✅ Videos rendered successfully OR ❌ Error message

**Common Causes:**

**A. Playlist ID Not Found in gamedev.yaml**
```
❌ Playlist PL... not found in gamedev.yaml
```
**Fix:** Verify playlist ID exists in gamedev.yaml featured_section.playlists array

**B. RSS Proxy 502 Error**
```
❌ RSS fetch failed for playlist PL...: 502
```
**Fix:** 
- Check dev server is running (`.\scripts\dev-server.ps1`)
- Verify cache directory exists: `/var/www/jenninexus/storage/cache/youtube/`
- Test RSS feed manually: `https://www.youtube.com/feeds/videos.xml?playlist_id={ID}`

**C. Container ID Mismatch**
```
Container #jennistyles-videos not found, skipping section
```
**Fix:** Ensure HTML `id=""` matches JavaScript `container_id: ''`

### Issue 2: Incorrect Column Layout

**Symptoms:**
- Videos not responsive
- Wrong number of columns at breakpoints

**Debug:**
```javascript
console.log('Column config:', sectionConfig.columns);
console.log('Generated classes:', getResponsiveColClasses(sectionConfig.columns));
```

**Common Causes:**

**A. Invalid Column Object**
```javascript
// ❌ WRONG
columns: 4

// ✅ CORRECT
columns: { xs: 1, sm: 2, md: 2, lg: 4 }
```

**B. Missing Breakpoints**
```javascript
// ⚠️ INCOMPLETE (no xs/sm)
columns: { md: 3, lg: 4 }

// ✅ COMPLETE
columns: { xs: 1, sm: 2, md: 3, lg: 4 }
```

### Issue 3: Wrong Aspect Ratio

**Symptoms:**
- Videos stretched/squished
- Black bars on sides

**Debug:**
```javascript
console.log('Aspect ratio:', sectionConfig.aspect_ratio);
console.log('Ratio class:', getAspectRatioClass(sectionConfig.aspect_ratio));
```

**Fix:** Use correct ratio for content type:
- `'16:9'` - Standard landscape videos
- `'9:16'` - YouTube Shorts (portrait)
- `'1:1'` - Square videos (Instagram style)

### Issue 4: Tags Not Working

**Symptoms:**
- Tag badges don't filter content
- Clicking tags does nothing

**Causes:**
1. `tag-system.js` not loaded
2. `data-tags` attribute missing on container
3. Tag badges missing `onclick` handler

**Fix:**
```html
<!-- Container needs data-tags -->
<div id="videos" class="row g-4" data-tags="unity,gamedev,indie">

<!-- Badges need tag-badge class and onclick -->
<span class="badge bg-secondary tag-badge" 
      data-tag-slug="unity" 
      onclick="window.tagFilter?.toggle('unity')">
  Unity
</span>

<!-- Load tag-system.js -->
<script src="<?= RES_ROOT ?>/js/tag-system<?= $assetSuffix ?? '' ?>.js"></script>
```

---

## 📚 Related Documentation

### Core System Docs
- **YOUTUBE.md** - YouTube RSS integration, caching, proxy architecture
- **PLAYLIST-MAPPING.md** - Playlist IDs, YAML configuration, system responsibilities
- **BOOTSTRAP-5.3.8.md** - Bootstrap integration, SRI hashes, verification
- **TAG-SYSTEM.md** - Tag filtering, offcanvas panels, multi-tag selection

### Game Page Docs
- **GAME-PAGES-AUDIT.md** - File-by-file audit, duplicate script fixes, testing checklist
- **GAME-SUBDIRECTORY-PROTOCOL.md** - Include paths, RES_ROOT usage patterns

### Build & Deploy
- **11-9.md** - Recent changes, build verification, pending tasks
- **DEPLOYMENT-MANIFEST.md** - Deploy process, SSH configuration, remote paths

---

## 🎯 Next Steps for Game Pages

### High Priority
1. **Start dev server and test jennistyles.php**
   - Command: `.\scripts\dev-server.ps1`
   - URL: `http://localhost:8002/game/jennistyles.php`
   - Expected: 8 videos in 1/2/2/4 responsive grid
   - Console logs will show exactly where any issues occur

2. **Migrate deprecated patterns to modern gamedev.yaml fetch**
   - botborgs.php → Use Pattern A (fetch from gamedev.yaml)
   - martiangames.php → Use Pattern A (4 playlists from gamedev.yaml)
   - cowdefender.php → Use Pattern A or gamejams.yaml pattern

### Medium Priority
3. **Archive redundant YAML files**
   - jennistyles.yaml → gamedev.yaml already has playlist
   - purgatoryfell.yaml → gamedev.yaml already has playlist
   - Move to: `/resources/playlists/archived/`

4. **Standardize remaining game pages**
   - Add proper tag badges (replace static spans with clickable badges)
   - Use renderGameCTA() consistently
   - Add "More Games" sections for cross-linking

### Low Priority
5. **Update game-cta-helper.php**
   - Add RES_ROOT definition inside helper
   - Remove redundant RES_ROOT definitions from game pages

6. **Documentation consolidation**
   - Archive GAME-DEV-PAGES.md (outdated architecture details)
   - Keep GAME-PAGES-AUDIT.md (current status and testing)
   - This file (GAME-PAGES.md) becomes primary reference

---

**Author:** GitHub Copilot  
**Status:** ✅ Complete - RSS Feed Architecture Documented  
**Version:** 3.0 (RSS-Only, Bootstrap 5.3.8 Integration)
