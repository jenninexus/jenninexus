# Video Grid System Protocol

**Version:** 4.2  
**Last Updated:** December 30, 2025  
**Status:** ✅ STANDARDIZED - Responsive 3-6 Columns

---

## 📚 Table of Contents
1. [Grid Layout Standards](#-grid-layout-standards)
2. [Bootstrap 5.3.8 Integration](#-bootstrap-538-integration)
3. [Responsive Breakpoints](#-responsive-breakpoints)
4. [CSS Customization System](#-css-customization-system)
5. [Technical Implementation](#-technical-implementation)
6. [Configuration Reference](#-configuration-reference)
7. [Troubleshooting](#-troubleshooting)

---

## 🎯 Grid Layout Standards

We have established two distinct display protocols for YouTube content across the site to ensure consistency and optimal user experience.

### System Architecture Overview

**Three-Layer Responsibility Model:**
1. **Bootstrap 5.3.8** → Foundation (grid system, aspect ratios, responsive breakpoints)
2. **youtube-grid.js** → Data fetching & rendering (RSS feeds, HTML generation)
3. **Theme CSS** → Visual styling (colors, shadows, hover effects, page-specific customization)

**YAML vs. Inline playlist IDs:**
- The system supports both YAML-driven configuration (recommended for pages that need metadata, tags, and centralized management) and direct inline playlist rendering (call `YouTubeGrid.renderPlaylist(containerId, playlistId, options)` on a page when only an ID is needed).
- For JenniNexus pages we prefer YAML for cataloged sections (gaming, gamedev, diy, youtube hub) and inline IDs for simple or critical pages where exact embed markup is desirable (optionally as a fallback).

### Responsive Video Grid
**Default Behavior:** Videos per row adapt to screen size (use Bootstrap columns). Recommended range is 3–6 videos per row depending on page type and viewport; **use up to 6 videos per row only on XL screens** to preserve readability.
- **Mobile (xs):** 1 video per row
- **Small (sm):** 2 videos per row
- **Medium (md):** 3 videos per row
- **Large (lg):** 4 videos per row
- **XL (xl):** 6 videos per row (only for wide desktop layouts)

**Bootstrap Classes:** `col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2`

**Jenninexus preference:**
- Use **3 columns** as the default for content-heavy pages (game pages, blog index).
- Use **4 columns** for gallery-like pages and single-card grids where cards are compact.
- Reserve **6 columns (xl only)** for wide hub pages where many small previews are acceptable (e.g., YouTube hub).
- Prefer the YAML `columns` object to explicitly control per-section breakpoints (e.g., `columns: { xs:1, sm:2, md:3, lg:4, xl:6 }`).

### 1. Single-Card Layout (Gaming, Gamedev, YouTube)
**Use Case:** Displaying many playlists where the user browses by playlist title/cover.
- **Structure:** Grid of Playlists (3-4 columns on desktop).
- **Content:** Each card shows **1 video preview** (the latest/first video).
- **Visual:** Vertical cards with large thumbnail.
- **YAML Config:**
  \\\yaml
  columns: { xs: 1, sm: 2, md: 3, lg: 4 }
  show_single_video: true
  layout: "single-card"
  \\\

### 2. Multi-Video Layout (DIY, AI, Live)
**Use Case:** Displaying fewer playlists but showing more content *within* each playlist immediately.
- **Structure:** Stacked Playlists (1 column on desktop).
- **Content:** Each card shows **3-6 videos** arranged horizontally (responsive).
- **Visual:** Full-width playlist card containing a horizontal row of video thumbnails.
- **Responsive:** Videos per row automatically adjust (xs:1, sm:2, md:3, lg:4, xl:6)
- **Interaction:** 
  - Playlist title is a clickable link to the YouTube playlist.
  - No "View Full Playlist" button in the footer (cleaner look).
  - Icons are vertically aligned with titles.
- **YAML Config:**
  \\\yaml
  columns: { xs: 1, sm: 1, md: 1, lg: 1 } # Full width container
  show_single_video: false
  videos_per_playlist: 6 # Show up to 6 videos

### Parallax & Stat Counters (Configuration)

You can opt a section into a subtle scroll-driven parallax effect and add stat counters that animate when they come into view.

YAML Example (per-section):
```yaml
featured_section:
  playlists:
    - id: PLxxxxx
  enable_parallax: true      # default: true; set false to opt-out
  parallaxSpeed: 0.08        # optional float, typical 0.02 - 0.12
```

Notes:
- The `parallaxSpeed` value is a multiplier used by the site-wide `ui-effects.js` parallax initializer and is applied to elements with the `parallax-layer` class or `data-parallax-speed` attribute.
- Stat counters use simple markup and require no YAML. Add `<span class="stat-number" data-target="5000">0</span>` and `ui-effects.js` will animate it when it enters the viewport.
- To disable parallax for a specific section, set `enable_parallax: false` in that section's YAML.

### 3. Hybrid Layout (DIY Page)
**Use Case:** Highlighting specific featured playlists with rich content while keeping the rest compact.
- **Structure:** 
  - **Top Section:** Multi-Video Layout (Full width, 3 videos).
  - **Bottom Section:** Single-Card Layout (Grid, 1 video).
- **Implementation:**
  - Split YAML into multiple sections (e.g., `featured_section` and `secondary_section`).
  - Assign unique `container_id` to each section.
  - Configure `columns` and `show_single_video` independently for each section.
  - **Theme Integration:**
    - **Core Behavior:** `custom.css` handles the interactive "lift" effect (`.playlist-card-single`) and static positioning (`.playlist-card-multi`).
    - **Visuals:** Theme CSS files (e.g., `diy-theme.css`) handle specific colors, shadows, and gradients targeting the container IDs.

---

---

## 🎨 Bootstrap 5.3.8 Integration

### Core Bootstrap Features Used

**1. Grid System (`.container`, `.row`, `.col-*`)**
- Responsive 12-column flexbox grid
- Breakpoints: `xs` (0px), `sm` (576px), `md` (768px), `lg` (992px), `xl` (1200px), `xxl` (1400px)
- Column classes auto-generated by `youtube-grid.js` from YAML config

**2. Aspect Ratio Classes (`.ratio`, `.ratio-*`)**
```html
<!-- Bootstrap 5.3.8 provides native aspect ratio classes -->
<div class="ratio ratio-16x9">
  <iframe src="..."></iframe>
</div>
```

**Supported Ratios:**
- `.ratio-16x9` → Standard landscape (56.25% padding-top)
- `.ratio-9x16` → Portrait/shorts (177.78% padding-top)
- `.ratio-4x3` → Classic/retro (75% padding-top)
- `.ratio-1x1` → Square (100% padding-top)
- `.ratio-21x9` → Ultrawide (42.86% padding-top)

**3. Card Component (`.card`, `.card-body`, `.card-footer`)**
- Default Bootstrap card structure
- Enhanced with custom theme CSS

**4. Responsive Utilities**
- `.d-none`, `.d-md-block` → Visibility control
- `.mb-*`, `.mt-*`, `.p-*` → Spacing utilities
- `.text-*`, `.bg-*` → Color utilities

### How youtube-grid.js Uses Bootstrap

**Column Generation (Updated v4.2):**
```javascript
function getResponsiveColClasses(columns) {
  // Input: { xs: 1, sm: 2, md: 3, lg: 4, xl: 6 }
  // Output: "col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2"
  
  const breakpoints = ['xs', 'sm', 'md', 'lg', 'xl', 'xxl'];
  const classes = [];
  
  for (const bp of breakpoints) {
    if (columns[bp]) {
      const colWidth = Math.floor(12 / columns[bp]);
      const className = bp === 'xs' 
        ? `col-${colWidth}` 
        : `col-${bp}-${colWidth}`;
      classes.push(className);
    }
  }
  
  return classes.join(' ');
}

// Simplified function for standard responsive grids
function getColumnClass(columns) {
  const columnMap = {
    1: 'col-12',                                                    
    2: 'col-12 col-md-6',                                           
    3: 'col-12 col-sm-6 col-md-4',                                  
    4: 'col-12 col-sm-6 col-md-4 col-lg-3',                         
    5: 'col-12 col-sm-6 col-md-4 col-lg-2-4',                       
    6: 'col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2'                
  };
  return columnMap[columns] || 'col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2';
}
```

**Aspect Ratio Conversion:**
```javascript
function getAspectRatioClass(ratio) {
  // Input: "16:9" (from YAML)
  // Output: "ratio-16x9" (Bootstrap class)
  
  const normalized = ratio.trim().replace(':', 'x');
  const supportedRatios = ['16x9', '9x16', '4x3', '1x1', '21x9'];
  
  if (supportedRatios.includes(normalized)) {
    return `ratio-${normalized}`;
  }
  
  return 'ratio-16x9'; // Default fallback
}
```

---

## 🎨 CSS Customization System

**Consolidation Principle:**
Most page-specific style files should be **thin variants** that only modify colors, brand accents, or minor spacing; **shared behavior and layout must live in `custom.css` and `media.css`** (grid sizing, hover/overlay behavior, ratio handling, responsive utilities). This keeps visual consistency across pages and avoids theme drift where, for example, `diy-theme.css` unintentionally redefines card hover lifts or grid behavior.

### CSS File Structure

```
public_html/resources/css/
├── all-themes.css         ← Theme variables (single source of truth)
├── custom.css             ← Global base styles (all pages)
├── media.css              ← Shared media/video/card styles (ratios, overlays)
├── mixins.css             ← Utility classes (contrast, tags, YouTube button)
├── gaming-theme.css       ← Gaming page specific (colors/vars only)
├── gamedev-theme.css      ← Game Dev page specific (colors/vars only)
├── diy-theme.css          ← DIY page specific (colors/vars only)
├── tags-theme.css         ← Tags page specific
├── patreon-theme.css      ← Patreon page specific
└── *.min.css              ← Minified versions (production)
```

**Refactor Steps:**
- Search for duplicated rules (transitions, `.ratio` settings, `.play-overlay`, `.playlist-card-*`) and consolidate to `custom.css`/`media.css`.
- Replace visual differences in theme files with variable overrides and container-scoped rules.
- Add an SCSS mixin (e.g., `ensure-contrast()`) in `_mixins.scss` and use it where badges/cards may sit on translucent backgrounds.

**About the compiled mixins CSS:**
- For deployable simplicity we commit a one-time compiled CSS snippet (`src/assets/css/generated/mixins.css` + top-level `src/assets/css/mixins.css`) that contains safe defaults and theme-aware helpers. If you make changes to the SCSS sources, regenerate the compiled file with `pwsh scripts/compile-mixins.ps1` and re-run `pwsh scripts/build.ps1` to pick up the changes.

### Hierarchy: Where Each CSS Controls What

#### 1. `custom.css` - Global Foundation (All Pages)

**Scope:** Base behavior for ALL video/playlist cards site-wide

**Key Classes:**

**A. Hover Behavior Classes**
```css
/* Single-Card Layout - Interactive Lift */
.playlist-card-single {
  transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), 
              box-shadow 0.3s ease;
  position: relative;
}

.playlist-card-single:hover {
  transform: translateY(-8px);
  z-index: 10;
}

/* Multi-Video Layout - Static Container */
.playlist-card-multi {
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  transform: none !important;
}

.playlist-card-multi:hover {
  transform: none !important; /* No lift for full-width panels */
}
```

**B. Play Overlay (Universal)**
```css
.play-overlay {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 10;
  opacity: 0;
  transition: all 0.3s ease;
}

.ratio:hover .play-overlay,
.card:hover .play-overlay {
  opacity: 1;
}
```

**C. Title Link Behavior**
```css
.playlist-title-link {
  transition: color 0.3s ease;
  text-decoration: none;
  color: var(--bs-body-color);
}

.playlist-title-link:hover {
  color: var(--bs-primary) !important;
}
```

**D. Glass Effect Styling (Theme-Aware)**
```css
/* Default card - lavender glass in light mode, dark glass in dark mode */
.video-card .card,
.playlist-card-single .card,
.playlist-card-multi .card {
  background: var(--glass-panel-bg, rgba(249, 243, 251, 0.85)) !important;
  backdrop-filter: blur(var(--glass-panel-blur, 10px));
  border: 1px solid var(--glass-panel-border, rgba(165, 99, 209, 0.2)) !important;
}

/* Light theme - lavender glass */
:root[data-bs-theme="light"] .card {
  background: rgba(249, 243, 251, 0.9) !important;
  border-color: rgba(165, 99, 209, 0.25) !important;
}

/* Dark theme - dark purple glass */
:root[data-bs-theme="dark"] .card {
  background: rgba(20, 20, 30, 0.8) !important;
  border-color: rgba(165, 99, 209, 0.3) !important;
}

/* Hover - brand color glow */
.card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(165, 99, 209, 0.3),
              0 0 20px rgba(255, 46, 136, 0.2) !important;
}

:root[data-bs-theme="dark"] .card:hover {
  box-shadow: 0 0.5rem 1.5rem rgba(165, 99, 209, 0.5),
              0 0 30px rgba(255, 46, 136, 0.3) !important;
}
```

**E. Bootstrap Ratio Classes**
```css
.ratio {
  position: relative;
  overflow: hidden;
  border-radius: 0.375rem 0.375rem 0 0;
}

/* Bootstrap provides aspect ratio via padding-top */
.ratio-16x9 { /* 56.25% */ }
.ratio-9x16 { /* 177.78% */ }
```

#### 2. `gaming-theme.css` - Gaming Page Customization

**Scope:** Only applies to `/gaming.php` and `#gamingPlaylists` container

**Color Palette:**
```css
:root {
  --gaming-navy: #171a21;          /* Steam dark navy */
  --gaming-accent-blue: #66c0f4;   /* Steam bright blue */
  --gaming-dark-blue: #1b2838;     /* Steam medium blue */
}
```

**Gaming-Specific Classes:**
```css
.gaming-playlist-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  background: var(--bs-body-bg);
  border: 1px solid transparent;
}

.gaming-playlist-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 16px rgba(102, 192, 244, 0.2);
  border-color: var(--gaming-accent-blue);
}

/* Steam-style gradient badges */
.badge.bg-steam {
  background: linear-gradient(135deg, 
    var(--gaming-dark-blue), 
    var(--gaming-light-blue)) !important;
  color: var(--gaming-accent-blue) !important;
}
```

**Gaming Shorts (9:16 vertical videos):**
```css
.gaming-short-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 16px rgba(102, 192, 244, 0.3);
}

.ratio-9x16 {
  aspect-ratio: 9/16; /* Portrait orientation */
}
```

#### 3. `gamedev-theme.css` - Game Dev Page Customization

**Scope:** Only applies to `/gamedev.php` containers

**Color Palette:**
```css
:root {
  --gamedev-primary: #A563D1;      /* JenniNexus purple */
  --gamedev-secondary: #FF2E88;    /* JenniNexus pink */
  --gamedev-accent: #FF6EC4;       /* JenniNexus accent */
}
```

**Playlist Card Styling:**
```css
#featured-playlists .card,
#martian_games-playlists .card,
#learning-playlists .card {
  background: var(--bs-body-bg);
}

#featured-playlists .card:hover,
#martian_games-playlists .card:hover,
#learning-playlists .card:hover {
  box-shadow: 0 8px 20px rgba(165, 99, 209, 0.2);
  border-color: var(--gamedev-primary);
}
```

**Project Cards:**
```css
.project-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 30px rgba(165, 99, 209, 0.3);
  border-color: var(--gamedev-primary);
}
```

#### 4. `diy-theme.css` - DIY Page Customization

**Scope:** Only applies to `/diy.php` containers

**Color Palette:**
```css
:root[data-bs-theme="light"] {
  --diy-pink: #FF6EC4;
  --diy-purple: #A563D1;
  --diy-lavender: #C590E3;
}

:root[data-bs-theme="dark"] {
  --diy-pink: #FF2E88;
  --diy-purple: #A563D1;
  --diy-lavender: #B579DA;
}
```

**Dynamic Container Targeting:**
```css
.diy-playlist-card,
#diyPlaylistsContainer .card,
#diySecondaryContainer .card {
  background: var(--surface);
  border: 2px solid transparent;
  border-radius: 1rem;
}

.diy-playlist-card:hover,
#diyPlaylistsContainer .card:hover,
#diySecondaryContainer .card:hover {
  border-color: var(--diy-pink);
  box-shadow: 0 20px 50px rgba(255, 46, 136, 0.3);
}
```

**Gradient Overlay Effect:**
```css
.diy-playlist-card::before,
#diyPlaylistsContainer .card::before,
#diySecondaryContainer .card::before {
  content: '';
  position: absolute;
  background: linear-gradient(135deg, var(--diy-pink), var(--diy-purple));
  opacity: 0;
  transition: opacity 0.4s ease;
}

.diy-playlist-card:hover::before {
  opacity: 0.1;
}
```

---

## 🛠️ Technical Implementation

### youtube-grid.js Logic

**Multi-Video Row Layout:**
```javascript
// Creates a Bootstrap row inside the playlist card
const row = document.createElement('div');
row.className = 'row g-3';

videos.slice(0, 3).forEach((video) => {
  const col = document.createElement('div');
  col.className = 'col-12 col-md-4'; // Stack on mobile, 3-across on desktop
  
  const thumbnail = createVideoThumbnail(video, index, aspectRatio);
  col.appendChild(thumbnail);
  row.appendChild(col);
});

container.appendChild(row);
```

**Single-Card Preview:**
```javascript
async function loadSingleVideoPreview(playlistId, container, aspectRatio = '16:9') {
  const videos = await fetchPlaylistVideos(playlistId, 1);
  const video = videos[0];
  
  const ratioClass = getAspectRatioClass(aspectRatio);
  
  const preview = document.createElement('div');
  preview.className = `ratio ${ratioClass} rounded-top overflow-hidden`;
  preview.innerHTML = `
    <img src="${video.thumbnail}" 
         alt="${video.title}" 
         class="w-100 h-100 object-fit-cover">
    <div class="play-overlay">
      <i class="bi bi-play-circle-fill" style="font-size: 4rem; color: white;"></i>
    </div>
  `;
  
  container.appendChild(preview);
}
```

### Card HTML Structure

**Single-Card Layout:**
```html
<div class="col-12 col-sm-6 col-md-4"> <!-- Bootstrap columns -->
  <div class="card playlist-card-single h-100"> <!-- custom.css hover -->
    <div class="ratio ratio-16x9"> <!-- Bootstrap aspect ratio -->
      <img src="..." class="w-100 h-100 object-fit-cover">
      <div class="play-overlay"> <!-- custom.css overlay -->
        <i class="bi bi-play-circle-fill"></i>
      </div>
    </div>
    <div class="card-body">
      <h5 class="card-title">
        <a href="..." class="playlist-title-link">Title</a> <!-- custom.css link -->
      </h5>
    </div>
  </div>
</div>
```

**Multi-Video Layout:**
```html
<div class="col-12"> <!-- Full width container -->
  <div class="card playlist-card-multi"> <!-- custom.css no-lift -->
    <div class="card-body">
      <h5 class="card-title">
        <a href="..." class="playlist-title-link">Playlist Title</a>
      </h5>
      <div class="row g-3"> <!-- Bootstrap row for horizontal layout -->
        <div class="col-12 col-md-4"> <!-- Video 1 -->
          <div class="ratio ratio-16x9">
            <img src="..." class="w-100 h-100 object-fit-cover">
          </div>
        </div>
        <div class="col-12 col-md-4"> <!-- Video 2 -->
          ...
        </div>
        <div class="col-12 col-md-4"> <!-- Video 3 -->
          ...
        </div>
      </div>
    </div>
  </div>
</div>
```

### Responsive Behavior

| Screen Size | Single-Card Mode | Multi-Video Mode |
|-------------|------------------|------------------|
| **Mobile (xs)** | 1 Playlist/Row | 1 Playlist/Row (Videos stacked 1x3) |
| **Tablet (sm)** | 2 Playlists/Row | 1 Playlist/Row (Videos stacked 1x3) |
| **Desktop (md)**| 3 Playlists/Row | 1 Playlist/Row (Videos horizontal 3x1) |

---

## 🎯 CSS Customization Quick Reference

### Where to Edit Video Display Styles

| What You Want to Change | Edit This File | Target Selector | Example |
|------------------------|----------------|-----------------|---------|
| **Global lift behavior** | `custom.css` | `.playlist-card-single`, `.playlist-card-multi` | Change hover transform |
| **Play button overlay** | `custom.css` | `.play-overlay` | Change icon size, opacity |
| **Gaming page colors** | `gaming-theme.css` | `.gaming-playlist-card` | Change Steam blue accents |
| **Game Dev page colors** | `gamedev-theme.css` | `#featured-playlists .card` | Change purple/pink shadows |
| **DIY page colors** | `diy-theme.css` | `#diyPlaylistsContainer .card` | Change pink gradients |
| **Aspect ratio behavior** | N/A (Bootstrap) | `.ratio-16x9`, `.ratio-9x16` | Use different Bootstrap class |
| **Grid columns** | YAML config | `columns: { xs: 1, sm: 2, md: 3 }` | Change responsive breakpoints |
| **Title link hover** | `custom.css` | `.playlist-title-link` | Change hover color |

### CSS Loading Order (Cascade Priority)

```html
<!-- 1. Bootstrap 5.3.8 (Foundation) -->
<link href="/resources/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- 2. Bootstrap Icons -->
<link href="/resources/bootstrap-icons/bootstrap-icons.min.css" rel="stylesheet">

<!-- 3. Custom Base Styles (All Pages) -->
<link href="/resources/css/custom.css" rel="stylesheet">

<!-- 4. Page-Specific Theme (Last = Highest Priority) -->
<link href="/resources/css/gaming-theme.css" rel="stylesheet"> <!-- Only on gaming.php -->
<link href="/resources/css/gamedev-theme.css" rel="stylesheet"> <!-- Only on gamedev.php -->
<link href="/resources/css/diy-theme.css" rel="stylesheet"> <!-- Only on diy.php -->
```

**Priority Rules:**
- Later CSS files override earlier ones (standard CSS cascade)
- `!important` should be avoided (only used for Bootstrap overrides)
- Theme CSS can override `custom.css` without `!important`
- Container-specific selectors (`#diyPlaylistsContainer .card`) override generic (`.card`)

---

## 📋 Configuration Reference

### DIY Page (Hybrid Layout)
**File:** `resources/playlists/diy.yaml`

**Featured Section (Multi-Video):**
```yaml
featured_section:
  container_id: "diyPlaylistsContainer"
  columns: { xs: 1, sm: 1, md: 1, lg: 1 }  # Full width
  show_single_video: false
  layout: "multi-video"
  videos_per_playlist: 3
  aspect_ratio: "16:9"
```
**Result:** Top 3 playlists show 3 videos each in horizontal rows

**Secondary Section (Single-Card):**
```yaml
secondary_section:
  container_id: "diySecondaryContainer"
  columns: { xs: 1, sm: 2, md: 3, lg: 3 }  # Grid layout
  show_single_video: true
  layout: "single-card"
  videos_per_playlist: 1
  aspect_ratio: "16:9"
```
**Result:** Remaining playlists show as single cards in 3-column grid

### Gaming Page (Single-Card Grid)
**File:** `resources/playlists/gaming.yaml`

```yaml
grid_config:
  columns: { xs: 1, sm: 2, md: 3, lg: 3 }
  show_single_video: true
  layout: "single-card"
  aspect_ratio: "16:9"
  
playlists:
  - id: "PLxxx..."
    title: "Horror Games"
    tags: ["gaming", "horror", "survival"]
    badge: "🎮 Horror"
    icon: "ghost"
```
**Result:** 30 playlists in 3-column grid, one large video preview per card

### Game Dev Page (Mixed Layouts)
**File:** `resources/playlists/gamedev.yaml`

```yaml
featured_section:
  container_id: "featured-playlists"
  columns: { xs: 1, sm: 2, md: 3, lg: 3 }
  show_single_video: true
  layout: "single-card"

martian_games_playlists:
  container_id: "martian_games-playlists"
  columns: { xs: 1, sm: 1, md: 1, lg: 1 }  # Full width vertical
  show_single_video: true
  layout: "single-card"
```
**Result:** Featured projects in grid, Martian Games section stacked vertically

---

## 🐛 Troubleshooting

### Display Issues

**Issue:** Playlists appearing as narrow columns with tiny videos?  
**Diagnosis:** Incorrect column configuration for multi-video layout  
**Fix:** Ensure `columns` in YAML is set to `1` for all breakpoints:
```yaml
columns: { xs: 1, sm: 1, md: 1, lg: 1 }  # Full width for multi-video
```

**Issue:** Videos stacking vertically inside playlist card on desktop?  
**Diagnosis:** Missing Bootstrap row/col structure in youtube-grid.js  
**Fix:** Verify `youtube-grid.js` uses `row g-3` and `col-md-4` wrappers in `loadPlaylistVideos()`

**Issue:** Cards not lifting on hover?  
**Diagnosis:** Theme CSS overriding `custom.css` or wrong class applied  
**Fix:** Check if card has `.playlist-card-single` class (should be added by youtube-grid.js)
```javascript
// In youtube-grid.js createPlaylistCard()
card.classList.add('playlist-card-single'); // For single-card layout
card.classList.add('playlist-card-multi');  // For multi-video layout
```

**Issue:** Aspect ratio not working (videos stretched/squashed)?  
**Diagnosis:** Bootstrap ratio class not applied or incorrect ratio specified  
**Fix:** 
1. Check YAML: `aspect_ratio: "16:9"` (must be quoted string)
2. Verify Bootstrap CSS loaded: `.ratio-16x9` should exist
3. Check youtube-grid.js: `getAspectRatioClass()` should convert "16:9" → "ratio-16x9"

### CSS Styling Issues

**Issue:** Theme colors not applying to playlist cards?  
**Diagnosis:** CSS selector specificity issue or file not loaded  
**Fix:** 
1. Check browser DevTools → Network → Verify theme CSS loaded
2. Use container-specific selector: `#diyPlaylistsContainer .card` instead of `.card`
3. Verify page includes correct theme CSS in `<head>`

**Issue:** Play overlay not showing on hover?  
**Diagnosis:** `.play-overlay` styles missing or z-index conflict  
**Fix:** Ensure `custom.css` is loaded and contains:
```css
.ratio:hover .play-overlay,
.card:hover .play-overlay {
  opacity: 1;
}
```

**Issue:** Title links not changing color on hover?  
**Diagnosis:** Theme CSS overriding global link styles  
**Fix:** Use `!important` in theme CSS or increase specificity:
```css
#diyPlaylistsContainer .playlist-title-link:hover {
  color: var(--diy-pink) !important;
}
```

### Configuration Issues

**Issue:** All playlists showing, no filtering by tags?  
**Diagnosis:** Tag system JavaScript not loaded  
**Fix:** Ensure page includes `tag-system.js` and cards have `data-tags` attribute

**Issue:** RSS feed not loading (502 errors)?  
**Diagnosis:** Server-side cache issue or invalid playlist ID  
**Fix:** 
1. Check playlist ID is valid: Must be 34-character YouTube playlist ID
2. Clear server cache: `rm -rf /var/www/jenninexus/storage/cache/youtube/*.json`
3. Check get-youtube.php logs for XML parsing errors

### Bootstrap Integration Issues

**Issue:** Columns not responsive (stuck at desktop width on mobile)?  
**Diagnosis:** Missing responsive column classes  
**Fix:** Verify YAML has all breakpoints:
```yaml
columns: { xs: 1, sm: 2, md: 3, lg: 3 }  # NOT just "columns: 3"
```

**Issue:** Cards breaking out of container on mobile?  
**Diagnosis:** Bootstrap container classes missing  
**Fix:** Ensure page HTML wraps playlists in `.container` or `.container-fluid`

---

## 📖 Additional Resources

### Related Documentation
- **[YOUTUBE.md](./YOUTUBE.md)** → RSS feed system, aspect ratios, caching
- **[PLAYLIST-MAPPING.md](./PLAYLIST-MAPPING.md)** → YAML configuration, playlist registry
- **[TAG-SYSTEM.md](./TAG-SYSTEM.md)** → Content filtering, offcanvas panels
- **[BOOTSTRAP-5.3.8-COMPLETE.md](./BOOTSTRAP-5.3.8-COMPLETE.md)** → Bootstrap component reference

### External References
- [Bootstrap 5.3.8 Grid System](https://getbootstrap.com/docs/5.3/layout/grid/)
- [Bootstrap 5.3.8 Ratios](https://getbootstrap.com/docs/5.3/helpers/ratio/)
- [Bootstrap Icons](https://icons.getbootstrap.com/)

### Quick Links
- **Theme Demo:** `/theme-demo.php#youtube-testing` (dev only). Live examples also available at `/theme-demo.php#video-grid-showcase` and `/theme-demo.php#svg-protocol`
- **Gaming Page:** `/gaming.php` (single-card grid example)
- **Game Dev Page:** `/gamedev.php` (mixed layout example)
- **DIY Page:** `/diy.php` (hybrid layout example)

---

**Last Updated:** November 23, 2025  
**Maintainer:** Claude Sonnet 4.5 (AI Agent)  
**Version:** 4.1

