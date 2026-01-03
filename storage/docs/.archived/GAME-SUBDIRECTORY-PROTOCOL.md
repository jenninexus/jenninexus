# Game Subdirectory Protocol

**Last Updated:** November 9, 2025  
**Status:** ✅ COMPLETE

---

## Overview

Game-specific pages are located in `/public_html/game/*.php` and require special handling for resource paths and YouTube Grid integration.

---

## Directory Structure

```
public_html/
  ├── includes/
  │   ├── head.php          # Defines RES_ROOT constant
  │   ├── header.php
  │   └── footer.php
  ├── resources/
  │   ├── css/
  │   ├── js/
  │   │   └── youtube-grid.js
  │   └── playlists/
  │       ├── gamedev.yaml
  │       ├── jennistyles.yaml
  │       ├── purgatoryfell.yaml
  │       └── ...
  └── game/
      ├── jennistyles.php
      ├── purgatoryfell.php
      ├── botborgs.php
      └── ...
```

---

## 📋 Requirements for Game Pages

### 1. Include Paths (Relative to Parent)

Game pages are **one directory deep**, so includes must use `__DIR__`:

```php
<?php
// At the top of /game/*.php
include __DIR__ . '/../includes/head.php';
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/footer.php';
```

### 2. RES_ROOT Usage

The `RES_ROOT` constant is defined in `includes/head.php` and automatically accounts for subdirectories:

```php
// In includes/head.php
define('RES_ROOT', '/resources');
```

Use `RES_ROOT` for all resource paths:

```php
<link rel="stylesheet" href="<?= RES_ROOT ?>/css/gamedev-theme.min.css">
<script src="<?= RES_ROOT ?>/js/youtube-grid.js"></script>
<img src="<?= RES_ROOT ?>/images/gamedev/jennistyles/hi.png" alt="Jenni">
```

### 3. Bootstrap 5.3.8 Integration

All game pages must use Bootstrap 5.3.8 with SRI hashes. Load via `includes/head.php` or page-specifically:

```php
<!-- Bootstrap CSS (already in includes/head.php) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
      integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
      crossorigin="anonymous" 
      rel="stylesheet">

<!-- Bootstrap JS Bundle (if not loaded in footer.php) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
        crossorigin="anonymous"></script>
```

### 4. YouTube Grid Setup

#### A. Create YAML Configuration

Create a YAML file in `/resources/playlists/` matching your page name:

**Example: `purgatoryfell.yaml`**

```yaml
page: purgatoryfell
title: "Purgatory Fell VR - Horror Gameplay Videos"
description: "Immersive VR horror gameplay videos"

featured_section:
  title: "Gameplay Videos"
  icon: "play-circle-fill"
  container_id: "purgatoryfell-videos"
  render_mode: "videos"  # Render individual videos, not playlist cards
  columns:
    xs: 1    # 1 column on mobile
    sm: 2    # 2 columns on tablet
    md: 3    # 3 columns on medium screens
    lg: 4    # 4 columns on large desktop
  aspect_ratio: "16:9"
  playlists:
    - id: "PL9QBjNDhgNwTsF4Es4jEftJR2Tto1CU53"
      title: "Purgatory Fell VR"
      icon: "play-circle-fill"
      tags: ["vr", "horror", "unity", "steam", "purgatoryfell", "martian-games"]
      description: "Immersive VR horror experience"

grid_config:
  columns:
    xs: 1
    sm: 2
    md: 3
    lg: 4
  videos_per_playlist: 8
  show_single_video: false
  layout: "multi-video"
  aspect_ratio: "16:9"
  enable_hover_effects: true
  lazy_load: true
  responsive: true
```

#### B. Add Container to HTML

Add a Bootstrap row container with a matching ID:

```php
<section id="videos" class="py-5 bg-dark">
  <div class="container">
    <h2 class="text-center mb-4">Gameplay Videos</h2>
    
    <!-- Video Grid Container -->
    <div id="purgatoryfell-videos" class="row g-4 mb-4">
      <!-- Videos will be rendered here by youtube-grid.js -->
    </div>
  </div>
</section>
```

#### C. Load youtube-grid.js

```php
<!-- Load youtube-grid.js -->
<script src="<?= RES_ROOT ?>/js/youtube-grid.js"></script>
<script>
  (function(){
    function loadGameVideos() {
      if (window.YouTubeGrid && typeof window.YouTubeGrid.loadPageConfig === 'function') {
        try {
          window.YouTubeGrid.loadPageConfig('purgatoryfell');
          console.log('✅ Loading videos from purgatoryfell.yaml');
        } catch(e) {
          console.error('❌ Failed to load config', e);
        }
      } else {
        console.warn('⚠️ YouTubeGrid not available, retrying...');
        setTimeout(loadGameVideos, 100);
      }
    }
    
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', loadGameVideos);
    } else {
      loadGameVideos();
    }
  })();
</script>
```

---

## 🎨 Styling Game Pages

### Theme CSS

Game pages should use `gamedev-theme.css` for consistent styling:

```php
<link rel="stylesheet" href="<?= RES_ROOT ?>/css/gamedev-theme.min.css">
```

### Video Card Styling

With the updated `youtube-grid.js`, video cards now include:
- ✅ Bootstrap card structure (`card h-100 border-0 shadow-sm hover-lift`)
- ✅ 16:9 aspect ratio (configurable via YAML)
- ✅ Tag badges (from playlist metadata)
- ✅ Hover effects (`hover-zoom`, play overlay)
- ✅ Responsive columns (Bootstrap grid classes)

**Example rendered video card:**

```html
<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
  <div class="card h-100 border-0 shadow-sm hover-lift">
    <div class="ratio ratio-16x9 rounded-top overflow-hidden">
      <img src="[thumbnail]" alt="[title]" class="object-fit-cover hover-zoom">
      <div class="play-overlay">
        <i class="bi bi-play-circle-fill fs-1 text-white"></i>
      </div>
    </div>
    <div class="card-body p-3">
      <h6 class="card-title mb-2 text-truncate">[Video Title]</h6>
      <div class="d-flex flex-wrap gap-1 mt-2">
        <span class="badge bg-secondary bg-opacity-50 text-white tag-badge">vr</span>
        <span class="badge bg-secondary bg-opacity-50 text-white tag-badge">horror</span>
      </div>
    </div>
  </div>
</div>
```

---

## ✅ Verified Game Pages

| Page | YAML Config | Status |
|------|------------|--------|
| jennistyles.php | jennistyles.yaml | ✅ Updated Nov 9 |
| purgatoryfell.php | purgatoryfell.yaml | ✅ Updated Nov 9 |
| botborgs.php | gamedev.yaml | ⚠️ Uses gamedev config |
| martiangames.php | gamedev.yaml | ⚠️ Uses martian-games.js |

---

## 🔧 Common Issues & Fixes

### Issue 1: "RES_ROOT not defined"

**Cause:** Missing `includes/head.php` include  
**Fix:** Add `include __DIR__ . '/../includes/head.php';` at top of page

### Issue 2: "YouTubeGrid is not defined"

**Cause:** youtube-grid.js not loaded or loaded after script execution  
**Fix:** Load youtube-grid.js before your custom script, or use DOMContentLoaded retry pattern

### Issue 3: Videos not rendering

**Cause:** Container ID mismatch between HTML and YAML  
**Fix:** Verify `container_id` in YAML matches `id=""` in HTML

### Issue 4: Wrong number of columns

**Cause:** YAML uses incorrect column config format  
**Fix:** Use responsive columns object:

```yaml
columns:
  xs: 1
  sm: 2
  md: 3
  lg: 4
```

### Issue 5: Tags not showing

**Cause:** Old `createVideoThumbnail` function doesn't support tags  
**Fix:** Use updated youtube-grid.js (Nov 9, 2025+) with playlist metadata support

---

## 📚 Related Documentation

- [BOOTSTRAP-5.3.8.md](./BOOTSTRAP-5.3.8.md) - Bootstrap 5.3.8 upgrade details
- [YOUTUBE.md](./YOUTUBE.md) - YouTube RSS feed integration
- [VIDEO-GRID.md](./VIDEO-GRID.md) - Video grid system fixes
- [TAG-SYSTEM.md](./TAG-SYSTEM.md) - Tag filtering system
- [PLAYLIST-MAPPING.md](./PLAYLIST-MAPPING.md) - Playlist ID mappings

---

## 🎯 Best Practices

1. **Always use RES_ROOT** for resource paths (never hardcode `/resources/`)
2. **Create dedicated YAML configs** for game pages (don't reuse gamedev.yaml)
3. **Use render_mode: "videos"** to show individual videos instead of playlist cards
4. **Set videos_per_playlist** to control how many videos render (e.g., 4 for 1 row of 4)
5. **Include tags array** in playlist config for proper filtering
6. **Use Bootstrap 5.3.8 grid classes** (col-*, row g-4) for responsive layouts
7. **Test on mobile** (xs breakpoint) to ensure 1-column layout works

---

## Example Complete Game Page Structure

```php
<?php
$activePage = 'gamedev';
$pageTitle = 'Game Title | JenniNexus';
$pageDescription = 'Game description';
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <?php include __DIR__ . '/../includes/head.php'; ?>
  <body>
    
  <?php include __DIR__ . '/../includes/header.php'; ?>

  <!-- Hero Section -->
  <section class="py-5 bg-gradient">
    <div class="container">
      <h1>Game Title</h1>
      <p>Game description</p>
    </div>
  </section>

  <!-- Video Grid Section -->
  <section id="videos" class="py-5">
    <div class="container">
      <h2 class="text-center mb-4">Gameplay Videos</h2>
      <div id="game-videos" class="row g-4">
        <!-- Videos rendered by youtube-grid.js -->
      </div>
    </div>
  </section>

  <?php include __DIR__ . '/../includes/footer.php'; ?>

  <!-- Bootstrap JS (if not in footer) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
          integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
          crossorigin="anonymous"></script>
  
  <!-- YouTube Grid -->
  <script src="<?= RES_ROOT ?>/js/youtube-grid.js"></script>
  <script>
    (function(){
      function loadVideos() {
        if (window.YouTubeGrid && typeof window.YouTubeGrid.loadPageConfig === 'function') {
          window.YouTubeGrid.loadPageConfig('gamename');
        } else {
          setTimeout(loadVideos, 100);
        }
      }
      
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadVideos);
      } else {
        loadVideos();
      }
    })();
  </script>
  </body>
</html>
```

---

**End of Game Subdirectory Protocol**
