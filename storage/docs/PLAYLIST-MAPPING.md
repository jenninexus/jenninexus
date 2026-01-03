# YouTube Playlist Mapping & Configuration

**Version:** 3.7
**Last Updated:** January 1, 2026  
**Purpose:** Complete reference for all YouTube playlists, channels, page mappings, and YAML configuration system

**IMPORTANT:** JenniNexus uses **RSS feeds exclusively** - no YouTube API required. All video data is fetched via RSS feed URLs through the server-side proxy (`get-youtube.php`). If you encounter 502 errors on API endpoints, these are non-critical as the site's core functionality (static content, blog posts, navigation) works independently of video grids.

**Recent Updates:**
- **January 1, 2026:** Added glass effect styling to responsibilities matrix. All video cards now use theme-aware lavender glass backgrounds.

---

## 🎯 System Responsibilities Matrix

**Purpose:** Clear separation of concerns between YAML config, youtube-grid.js, and Bootstrap 5.3.8

| Feature | YAML Configuration | youtube-grid.js | Bootstrap 5.3.8 | CSS (all-themes.css, media.css) | Notes |
|---------|-------------------|-----------------|-----------------|----------------------------------|-------|
| **Thumbnails** | N/A | `fetchPlaylistVideos()` fetches RSS XML, extracts `<media:thumbnail>` URL | N/A | N/A | RSS feed provides 480x360 hqdefault images |
| **Aspect Ratios** | `aspect_ratio: "16:9"` field | `getAspectRatioClass()` converts "16:9" → "ratio-16x9" | `.ratio-16x9` CSS class sets padding-top: 56.25% | N/A | Supported: 16:9, 9:16, 4:3, 1:1, 21:9 |
| **Grid Columns** | `columns: {xs:1, sm:2, md:3}` object | `getResponsiveColClasses()` converts to "col-12 col-sm-6 col-md-4" | `.col-*` flexbox classes | N/A | Mobile-first responsive breakpoints |
| **Tags** | `tags: ["gaming", "horror"]` array | Sets `data-tags="gaming,horror"` attribute | N/A | N/A | tag-system.js reads data-tags for filtering |
| **Playlist ID** | `id: "PL..."` string | Fetches RSS from `/resources/api/get-youtube.php?playlist_id=...` | N/A | N/A | No YouTube API key required |
| **Icons** | `icon: "play-circle"` string | Renders `<i class="bi bi-play-circle">` | Bootstrap Icons font | N/A | icon name without 'bi-' prefix |
| **Badges** | `badge: "Featured"` string | Creates `<span class="badge bg-primary">` | `.badge` component | N/A | Optional per-playlist badge |
| **Video Count** | `grid_config.videos_per_playlist: 6` | Limits thumbnail grid to first N videos | N/A | N/A | Default 6, configurable per section |
| **Hover Effects** | `grid_config.enable_hover_effects: true` | Adds `.hover-lift` class | N/A | Custom CSS transform animations | Lift effect on hover |
| **Glass Effects** | N/A | Applies `.card` class | N/A | Theme-aware backgrounds via CSS variables | Lavender glass (light), dark glass (dark) |
| **Cache** | N/A | localStorage cache (24hr), server cache (10min) | N/A | N/A | Reduces API calls and load times |

### Key Takeaways

1. **YAML = Content Definition**
   - What playlists to show
   - How to display them (columns, aspect ratio)
   - What metadata to include (tags, icons, badges)
   - Never contains rendering logic

2. **youtube-grid.js = Rendering Engine**
   - Fetches data from YouTube RSS feeds
   - Converts YAML config to HTML structure
   - Applies Bootstrap classes based on YAML settings
   - Manages caching and error handling
   - Never defines content (reads from YAML only)

3. **Bootstrap 5.3.8 = Visual Presentation**
   - Provides responsive grid system (`.row`, `.col-*`)
   - Aspect ratio containers (`.ratio-*`)
   - Component styles (`.card`, `.badge`)
   - Never contains logic (pure CSS framework)

---

## Playlist verification & recovery (operational protocol)

An automated verification script validates configured playlists by requesting each playlist's RSS feed and writing a JSON report to `public_html/storage/logs/` as `playlist-check-<timestamp>.json`.

Guidance:
- Run checks:
  ```powershell
  pwsh -File "scripts\check-youtube-playlists.ps1"
  ```
- Summarize and optionally annotate YAML with `status: missing` (report-only by default, use `-Apply` to edit YAML in-place with a backup):
  ```powershell
  pwsh -File "scripts\annotate-missing-playlists.ps1" -YamlFile "public_html/resources/playlists/music.yaml"
  pwsh -File "scripts\annotate-missing-playlists.ps1" -YamlFile "public_html/resources/playlists/music.yaml" -Apply
  ```
- Recovery strategy: prefer **channel uploads** fallback (`UC` → `UU`), search for replacement playlists, or mark/remove the entry if deleted.
- Integrate checks into CI/cron for periodic monitoring and alerting.



### Data Flow Example

**YAML Config (gaming.yaml):**
```yaml
featured_section:
  aspect_ratio: "16:9"
  columns: { xs: 1, sm: 2, md: 3 }
  playlists:
    - id: "PL6WnzXOaRqA16UY1KibrFUHu4gDZ8hmep"
      title: "Ori and the Blind Forest"
      icon: "tree"
      tags: ["gaming", "platformer", "adventure"]
```

**↓ Fetched by YouTubeGrid.loadPageConfig('gaming')**

**youtube-grid.js Processing:**
```javascript
// 1. Parse YAML
const sectionConfig = yaml.featured_section;

// 2. Get aspect ratio
const aspectRatio = sectionConfig.aspect_ratio || '16:9';  // "16:9"
const ratioClass = getAspectRatioClass(aspectRatio);      // "ratio-16x9"

// 3. Get columns
const columns = sectionConfig.columns;                     // {xs:1, sm:2, md:3}
const colClasses = getResponsiveColClasses(columns);       // "col-12 col-sm-6 col-md-4"

// 4. Build HTML
return `
  <div class="${colClasses}">
    <div class="card">
      <div class="${ratioClass}">
        <iframe src="..."></iframe>
      </div>
    </div>
  </div>
`;
```

**↓ Rendered HTML**

**Browser Output:**
```html
<div class="col-12 col-sm-6 col-md-4" data-tags="gaming,platformer,adventure">
  <div class="card hover-lift">
    <div class="ratio ratio-16x9">
      <iframe src="https://www.youtube.com/embed/..." loading="lazy"></iframe>
    </div>
    <div class="card-body">
      <h5 class="card-title">
        <i class="bi bi-tree"></i> Ori and the Blind Forest
      </h5>
    </div>
  </div>
</div>
```

**↓ Styled by Bootstrap 5.3.8**

**Visual Result:**
- **Mobile (xs):** 1 column (col-12 = 100% width)
- **Tablet (sm):** 2 columns (col-sm-6 = 50% width)
- **Desktop (md):** 3 columns (col-md-4 = 33.33% width)
- **Aspect ratio:** 16:9 landscape (ratio-16x9 = padding-top: 56.25%)
- **Tags:** data-tags enables filtering on /tags.php
- **Icon:** bi-tree rendered from Bootstrap Icons font

---

## 📡 RSS Feed Data Structure (Updated Nov 10, 2025)

### XML-to-JSON Conversion in get-youtube.php

**Critical Insight:** When `get-youtube.php` converts YouTube RSS XML to JSON using `json_encode(simplexml_load_string($xml))`, **namespace prefixes are removed** from property names.

**XML Input (from YouTube RSS):**
```xml
<entry>
  <yt:videoId>dQw4w9WgXcQ</yt:videoId>
  <title>Video Title</title>
  <media:group>
    <media:thumbnail url="https://i.ytimg.com/vi/dQw4w9WgXcQ/hqdefault.jpg" />
  </media:group>
</entry>
```

**JSON Output (after json_encode):**
```json
{
  "videoId": "dQw4w9WgXcQ",
  "title": "Video Title",
  "thumbnail": "https://i.ytimg.com/vi/dQw4w9WgXcQ/hqdefault.jpg"
}
```

**JavaScript Access Patterns:**

```javascript
// ❌ WRONG - Will fail because namespace prefix removed
const videoId = video['yt:videoId'];

// ✅ CORRECT - Access direct property with namespace fallback
const videoId = video.videoId || video['yt:videoId'] || '';

// ✅ CORRECT - Use thumbnail added by get-youtube.php
const thumbnail = video.thumbnail || `https://i.ytimg.com/vi/${videoId}/mqdefault.jpg`;

// ✅ CORRECT - Handle both array and single entry
const entries = data.entry ? (Array.isArray(data.entry) ? data.entry : [data.entry]) : [];
```

**Why get-youtube.php Adds videoId and thumbnail:**

The server-side proxy explicitly extracts these properties and adds them as direct child elements to simplify JavaScript access:

```php
// Extract from namespace-prefixed XML tags
$videoId = (string)$entry->children('yt', true)->videoId;
$thumbnailUrl = (string)$entry->children('media', true)->group->thumbnail->attributes()->url;

// Add as direct child elements for easy JS access
$entry->addChild('videoId', $videoId);
$entry->addChild('thumbnail', $thumbnailUrl);
```

**Files Using This Pattern:**
- ✅ `youtube.php` - Channel RSS feed (lines 271-308)
- ✅ `diy.php` - Channel RSS feed (lines 393-427)
- ✅ `youtube-grid.js` - Playlist RSS feeds (fetchPlaylistVideos function)

See `public_html/resources/api/get-youtube.php` lines 113-152 for full implementation.

---

## 🎯 FILE ORGANIZATION STRATEGY (v3.4)

### Overview: Single Source of Truth

As of **November 1, 2025**, we use a two-tier system:
1. **playlist-ids.json** - Master playlist registry (IDs, titles, metadata)
2. **YAML files** - Page-specific display configurations (layout, columns, sections)
3. **tags.json** - Canonical tag definitions (49 tags as of Nov 1, 2025)

This separation allows us to maintain playlist metadata once while configuring different displays per page.

### File Structure

```
📊 MASTER DATA SOURCE
└─ playlist-ids.json (v2.2)
    ├─ youtube.channels {...}
    ├─ youtube.playlists
    │   ├─ gamedev {...}
    │   ├─ games (6 featured_playlists + single_videos + external_games)
    │   ├─ gaming {...}
    │   ├─ diy {...}
    │   ├─ nailart {...}
    │   ├─ music {...}
    │   └─ vip {...}
    └─ discord {...}

📄 YAML PAGE CONFIGS (layout only, reference playlist-ids.json)
├─ gamedev.yaml - Game dev page sections + grid config
├─ gaming.yaml - Gaming page playlists (30 playlists, single-card layout)
├─ gamejams.yaml - Game jam collections (Ludum Dare series)
├─ diy.yaml - DIY page sections (fashion, hair, nails, etc.)
├─ youtube.yaml - YouTube hub page (8 featured playlists, RSS feed)
└─ blog-posts.yaml - Blog metadata (not YouTube related)

🔧 JS LOADERS (fetch YAML, render playlists)
├─ youtube-grid.js - Main grid renderer (all pages) ⭐ REQUIRES js-yaml
├─ gaming-playlists.js - ⚠️ DEPRECATED (use youtube-grid.js)
├─ diy-playlists.js - DIY page specific
├─ martian-games.js - Martian Games section
└─ music-playlists.js - Music page specific

📦 DEPENDENCIES
└─ js-yaml (v4.1.0) - YAML parser (loaded via CDN in includes/head.php)
```

### Data Flow

```
1. playlist-ids.json (MASTER) - Playlist metadata
        ↓
2. YAML files (PAGE CONFIGS) - Layout + section definitions
        ↓
3. JS loaders (RENDERERS) - Fetch YAML + render HTML
        ↓
4. HTML rendered with data-tags attributes
        ↓
5. Tag system filters content
```

---

## 📄 YAML CONFIGURATION FILES (Oct 30, 2025)

### YAML File Overview (Updated November 8, 2025)

| File | Purpose | Sections | Loaded By | Requires js-yaml | Tag Coverage |
|------|---------|----------|-----------|------------------|--------------|
| **gamedev.yaml** | Game dev page playlists | featured_section, martian_games_playlists, learning_section, archive_games, grid_config | youtube-grid.js | ✅ Yes | gamedev, unity, devlog, etc. |
| **gaming.yaml** | Gaming page playlists (30 playlists) | All gaming playlists with genre/platform tags, show_single_video: true | youtube-grid.js | ✅ Yes | **49 tags** (13 new Nov 1) |
| **gamejams.yaml** | Game jam page playlists | Game jam highlights, Ludum Dare 38/40/44/46, Kitty McBlubberton, Red Friday | youtube-grid.js | ✅ Yes | game-jam, ludum-dare |
| **diy.yaml** | DIY page playlists | Fashion, hair, nails, brand collabs, creative tech sections | youtube-grid.js | ✅ Yes | diy, fashion, beauty, hair |
| **youtube.yaml** | YouTube hub page (8 playlists) | Featured playlists across all categories, RSS feed integration | youtube-grid.js | ✅ Yes | gaming, gamedev, diy, ai, music, live |
| **blog-posts.yaml** | Blog metadata | Blog post titles, dates, excerpts (NOT YouTube related) | blog.php | ❌ No | various |

**New in v3.5 (Nov 8, 2025):**
- youtube.yaml added with 8 curated playlists across all content categories
- YouTube hub page (/youtube.php) with RSS feed integration via get-youtube.php server-side proxy
- 4-column responsive grid matching site-wide standards
- Category browsing cards linking to tag-filtered pages

**New in v3.6 (Nov 10, 2025):**
- Fixed youtube.php RSS feed to use correct property access (video.videoId instead of video['yt:videoId'])
- Documented XML namespace conversion in get-youtube.php (namespace prefixes removed by json_encode())
- Added ratio-16x9 Bootstrap class to RSS feed thumbnails for consistent aspect ratio

### YAML Structure Reference

**Top-Level Properties:**
```yaml
page: "gamedev"                  # Page identifier (matches loadPageConfig() param)
title: "Game Development Showcase"
description: "Featured game projects and tutorials"
```

**Section Properties:**
```yaml
featured_section:                # Section key (becomes #featured-playlists container)
  title: "Featured Game Projects"
  description: "Original games and showcases"
  icon: "trophy"                 # Bootstrap icon name
  columns: 3                     # Optional: Override grid_config columns
  playlists:                     # Array of playlist objects
    - id: "PL..."                # YouTube playlist ID
      title: "Devlogs"
      icon: "camera-video"
      badge: "Featured"          # Badge text
      description: "Game dev logs"
      tags: ["gamedev", "unity"] # Tag slugs for filtering
      page: "/game/..."          # Optional: Internal page link
      external_url: "https://..." # Optional: External link
```

**Grid Config Properties:**
```yaml
grid_config:
  featured_columns: 3           # Columns for featured_section
  learning_columns: 2           # Columns for learning_section
  martian_games_columns: 2      # Columns for martian_games_playlists
  columns: 3                    # Global fallback
  videos_per_playlist: 8        # Videos to show per playlist
  enable_hover_effects: true    # Enable hover animations
  enable_lazy_loading: true     # Lazy load thumbnails
  show_single_video: true       # Gaming page: Show only 1st video per playlist
```

### Column Priority Logic (Oct 30, 2025 Fix)

**Column count is determined in this priority order:**
1. **Section-specific `columns`** (highest priority)
   ```yaml
   martian_games_playlists:
     columns: 2  # This takes precedence
   ```

2. **Grid config by section name**
   ```yaml
   grid_config:
     featured_columns: 3  # Applies to featured_section
   ```

3. **Grid config global default**
   ```yaml
   grid_config:
     columns: 3  # Fallback for all sections
   ```

4. **Hardcoded fallback** (3 columns - in youtube-grid.js)

**Implementation (youtube-grid.js):**
```javascript
const columns = sectionConfig.columns || 
                gridConfig[`${sectionId}_columns`] || 
                gridConfig.columns || 
                3;
```

### Section-to-Container Mapping

**YAML section keys are converted to HTML container IDs:**

| YAML Section Key | HTML Container ID | Notes |
|------------------|-------------------|-------|
| `featured_section` | `#featured-playlists` | Suffix replaced: `_section` → `-playlists` |
| `learning_section` | `#learning-playlists` | Same pattern |
| `martian_games_playlists` | `#martian_games-playlists` | Already has `_playlists` suffix, underscore → hyphen |
| `indie_gamejam_section` | `#indie_gamejam-playlists` | Pattern applies to all sections |

**Conversion logic in youtube-grid.js:**
```javascript
// Finds sections ending in _section or _playlists
const sections = Object.keys(config).filter(key => 
  (key.endsWith('_section') || key.endsWith('_playlists'))
);

// Converts to container ID: removes suffix, adds -playlists
const sectionId = sectionKey.replace(/_(?:section|playlists)$/, '');
const containerId = `${sectionId}-playlists`;
```

---

## 🎯 FILE ORGANIZATION STRATEGY (v3.2)

### Overview: Single Source of Truth

As of **October 28, 2025**, we've consolidated all playlist data into a single master registry to eliminate duplication and improve maintainability. **Version 2.2** adds comprehensive games section with Martian Games Let's Play playlist, game jam classifications, and external game tracking.

### File Responsibilities

#### 1. `playlist-ids.json` ⭐ MASTER REGISTRY
- **Version:** 2.1 (updated Oct 28, 2025)
- **Location:** `public_html/resources/playlists/playlist-ids.json`
- **Purpose:** Single source of truth for ALL playlists
- **Contains:**
  - YouTube channel IDs & RSS feeds
  - All playlists organized by page/category
  - **NEW:** Game playlists in `youtube.playlists.games.game_playlists[]`
  - Discord invite links

**New Structure (v2.2):**
```json
{
  "youtube": {
    "channels": {...},
    "playlists": {
      "gamedev": {...},
      "games": {
        "description": "Individual game playlists and Martian Games collection",
        "featured_playlists": [
          {
            "id": "PL9QBjNDhgNwRkcV9WLFJBsJnULSUDqPty",
            "title": "Martian Games Let's Play",
            "game_slug": "martiangames",
            "game_page": "/game/martiangames.php",
            "studio": "martiangames",
            "type": "letsplay"
          }
        ],
        "single_videos": [
          {
            "video_id": "4tke1Q6XKtE",
            "title": "Soccer Cows Gameplay",
            "is_game_jam": true
          }
        ],
        "external_games": [
          {
            "title": "Cow Defender",
            "is_game_jam": false,
            "studio": "martiangames",
            "external_url": "https://gamejolt.com/@JenniNexus"
          }
        ]
      }
    }
  }
}
```

### Game Classifications (v2.2)

**Important Distinctions:**
- **Soccer Cows** - IS a game jam entry (Martian Games)
- **Cow Defender** - IS NOT a game jam game, IS a Martian Games tower defense game
- **Game Jam Highlights** playlist - Includes non-Ludum Dare game jams

**Martian Games Studio Games:**
1. **Purgatory Fell VR** - Full playlist, Steam Early Access
2. **Martian Games Let's Play** - Compilation playlist (NEW in v2.2)
3. **Botborgs** - Full playlist, Kotaku featured
4. **Soccer Cows** - Single video, game jam entry
5. **Cow Defender** - GameJolt, NOT game jam
6. **Air Wars series, Motor Wars, Tank Off series** - External only (CrazyGames)

#### 2. `game-playlist-map.json` ⚠️ DEPRECATED
- **Status:** Deprecated as of Oct 28, 2025
- **Reason:** Duplicates data from playlist-ids.json
- **Migration:** Complete - all data moved to `playlist-ids.json v2.2 -> youtube.playlists.games`
- **v2.2 Updates:** Added Martian Games Let's Play, clarified game jam status (Soccer Cow YES, Cow Defender NO)
- **Action:** File kept for reference during transition, but all new code should use playlist-ids.json

#### 3. YAML Files (gamedev.yaml, gaming.yaml, etc.) 📄 PAGE CONFIGS
- **Purpose:** Page-specific display configurations ONLY
- **Should contain:** 
  - Layout preferences (columns, videos per playlist)
  - Display metadata (titles, descriptions, icons, badges)
  - Visual settings (hover effects, lazy loading)
  - Playlist IDs that reference playlist-ids.json
- **Should NOT contain:** 
  - Duplicate playlist metadata
  - Channel information
  - Tag definitions (use tags.json)

**Example:**
```yaml
page: gamedev
featured_section:
  playlists:
    - id: "PL9QBjNDhgNwTsF4Es4jEftJR2Tto1CU53"  # References playlist-ids.json
      title: "Purgatory Fell Devlogs"
      icon: "badge-vr"
      badge: "Martian Games"
```

#### 4. JavaScript Loaders 🔧 RENDERERS
- `youtube-grid.js` - Main renderer for all pages
- `gaming-playlists.js`, `diy-playlists.js`, etc. - Page-specific loaders
- **Role:** 
  - Fetch YAML configs
  - Cross-reference playlist-ids.json for full metadata
  - Render HTML with data-tags attributes
  - Expose `window.__usedTagSlugs` for tag filtering

### Best Practices

✅ **DO:**
- Add ALL new playlists to `playlist-ids.json` first
- Reference playlist IDs in YAML files (don't duplicate metadata)
- Use YAML for page-specific display settings only
- Keep tags synchronized with `tags.json`
- Document page-to-playlist relationships in this file

❌ **DON'T:**
- Create new playlist mapping JSON files
- Duplicate playlist metadata across files
- Hard-code playlist IDs in JavaScript
- Store tag definitions in YAML (use tags.json)

### Migration Checklist (v2.2)

- [x] Created `youtube.playlists.games` section in playlist-ids.json
- [x] Added 6 game featured_playlists with full metadata
- [x] Added single_videos section (Soccer Cows)
- [x] Added external_games section (Cow Defender)
- [x] Added Martian Games Let's Play playlist (PL9QBjNDhgNwRkcV9WLFJBsJnULSUDqPty)
- [x] Clarified Soccer Cows IS a game jam entry
- [x] Clarified Cow Defender is NOT a game jam game
- [x] Updated gamejams.yaml to include Game Jam Highlights playlist
- [x] Marked game-playlist-map.json as deprecated with v2.2 notes
- [x] Updated PLAYLIST-MAPPING.md with v3.2 changes
- [x] Fixed soccercow.php to remove incorrect Cow Defender game jam label
- [x] Fixed cowdefender.php to remove game jam references, clarify Martian Games
- [ ] Verify all YAML files reference playlist-ids.json correctly
- [ ] Test JS loaders work with new structure
- [ ] Continue CTA helper rollout to remaining 11 game pages

---

## 📺 YouTube Channels

| Channel Key | Channel ID | Handle | Purpose |
|------------|------------|--------|---------|
| `main` | UCu1S6_Gza2Y06pT1n5U_L4Q | @jenninexus | Main JenniNexus channel |
| `gaming` | UC4byqahPWuY9WPJNvDgbQMQ | @jenniplaysgames | Gaming content |
| `diy` | UCk2SWSg1fvdZGnrN0XAt6NQ | @jennidiy | DIY, fashion, beauty |
| `nailart` | UCO12O7SUOK0bU1tDhwld59Q | @jenninailart | Nail art tutorials |
| `martiangames` | UCxeyxi73bmMHaZP6cPZmvmg | @martiangames | Martian Games studio |
| `alice` | UCQn5dpnTZjsV6FV6D3ajutg | @alice | Alice channel |

---

## 🎨 DIY Page Featured Playlists

### FASHION Category

| Playlist | ID | Icon | Channel |
|----------|-------|------|---------|
| **DIY Tutorials** | `PLYI86hek1EWfF1TeN4oIdw2dp126OIlIc` | `scissors` | diy |
| **T-shirt Cutting No-Sewing** | `PLYI86hek1EWdEeuMYInQtfaSepBPz2yN7` | `scissors` | diy |
| **Jenni's Take on Fashion** | `PLYI86hek1EWfM9KMuZjd6W97788PBJpmu` | `bag-heart` | diy |
| **DIY Fashion & Crafts** | `PL9QBjNDhgNwSjirfHOJ5a8D-Orcj5y-Mf` | `palette` | main |

### HAIR Category

| Playlist | ID | Icon | Channel |
|----------|-------|------|---------|
| **DIY Hair Ideas & Tutorials** | `PLYI86hek1EWdw5U7AzICxzyoBir44FXKJ` | `scissors` | diy |

### NAILS Category

| Playlist | ID | Icon | Channel |
|----------|-------|------|---------|
| **DIY Gel Nails** | `PLYI86hek1EWcoJ7X5n7ys1jzQYRCjDKnN` | `paint-bucket` | diy |
| **Nail Art Diary** | `PLvTBZ29I1ijFPKNzQEL0716txhMn8osuF` | `paint-bucket` | nailart |

### BRAND COLLABS / PRODUCT REVIEWS

| Playlist | ID | Icon | Channel |
|----------|-------|------|---------|
| **Brand Collabs + Product Reviews** | `PLYI86hek1EWciC-RmY2qfLdwXI9SeUJTf` | `star-fill` | diy |
| **Glitter** | `PLYI86hek1EWeoAoTP0Ik6xsjqfuLb8IPt` | `star-fill` | diy |

### DIY SELF-CARE (Unlisted)

| Playlist | ID | Icon | Channel | Visibility |
|----------|-------|------|---------|------------|
| **DIY Self Care** | `PLYI86hek1EWdXUlDFlaFZKBxIq50vQ_-m` | `heart-pulse` | diy | unlisted |
| **DIY Nail Care** | `PLYI86hek1EWfbT2FcY2yIS37Cf89NXji-` | `droplet` | diy | unlisted |

### DIY 3D + GFX

| Playlist | ID | Icon | Channel |
|----------|-------|------|---------|
| **DIY 3D + GFX** | `PLYI86hek1EWcNBgR0ilmsUsDLWHHDxEet` | `box` | diy |

---

## 🎮 GAMING Page Featured Playlists

| Playlist | ID | Icon | Channel |
|----------|-------|------|---------|
| **Recent** | `PL6WnzXOaRqA16OQ60_EcUZ0Y8tjHB73Gi` | `clock-history` | gaming |
| **PAX West Gaming Con** | `PL9QBjNDhgNwRIS4WXfKy4oLrPKxoK_Jra` | `building` | main |
| **Twitch Highlights** | `PL6WnzXOaRqA1q_0XZ2fPo0LIEErxxyoT1` | `play-circle` | gaming |
| **Brand Collabs + Product Reviews** | `PL9QBjNDhgNwRsHtjuS574yGSnRZNWmZ_y` | `star-fill` | main |
| **Let's Plays (gameplay)** | `PL9QBjNDhgNwSTX-7daIRSKp8gfitZx1Z_` | `controller` | main |
| **Game Jam Highlights** | `PL9QBjNDhgNwTFn7QSZRbZGoKCCIsUlemX` | `trophy` | main |
| **Cat-As-Trophy** | `PLLzfSGTgy8YBL97yf_JRzcc3NWwk8FXyN` | `emoji-heart-eyes` | main |

---

## 🛠️ GAMEDEV Page Featured Playlists

| Playlist | ID | Icon | Channel |
|----------|-------|------|---------|
| **Devlogs** | `PL9QBjNDhgNwRsznW8e3-KVmwfEuwvr7Yi` | `journal-code` | main |
| **Tips + Tuts** | `PL9QBjNDhgNwTnv3qzgtrxReBySCOv7SFN` | `lightbulb` | main |
| **Unity 3D Tutorials** | `PL9QBjNDhgNwRUXxQ6Ygp2V1LvFQrCTDSa` | `box-seam` | main |
| **Unreal Engine** | `PL9QBjNDhgNwRrCtaI_VKGZgwGsrKk_Lxr` | `cube` | main |
| **Blender Tutorials** | `PL9QBjNDhgNwSEQR9F0JDcdG_W_3pmaPS4` | `box` | main |
| **Reallusion CC4** | `PL9QBjNDhgNwQMPrkDlf91fSUTns2l9-RR` | `person-circle` | main |
| **Game Industry** | `PL9QBjNDhgNwTJidiioOSGo3bGtLY7KmPr` | `briefcase` | main |
| **Game Jam Highlights** | `PL9QBjNDhgNwTFn7QSZRbZGoKCCIsUlemX` | `trophy` | main |

---

## 🎤 VOICE ACTING Page Featured Playlists

| Playlist | ID | Icon | Channel |
|----------|-------|------|---------|
| **Voice Acting Demos** | `PL9QBjNDhgNwQGtxekr9W4TvrN8aAIubTw` | `mic` | main |
| **Voice Acting Tutorials** | `PL9QBjNDhgNwSYG7c6qnwlqgRdQW-SWTHK` | `mic-fill` | main |

---

## 🎵 MUSIC Page Featured Playlists

| Playlist | ID | Icon | Channel |
|----------|-------|------|---------|
| **DJ Tutorials** | `PL9QBjNDhgNwRtiIPeSEi1HAa5ehnYpau0` | `disc` | main |
| **FL Studio (tutorials)** | `PL9QBjNDhgNwSELFNvTx9hpk3xbGduBpHY` | `music-note-beamed` | main |
| **Favorite DJ / VJ Sets** | `PL9QBjNDhgNwRaJX--_cZhEAJ8HbG9umiX` | `disc-fill` | main |
| **Music History X Gen** | `PL9QBjNDhgNwTnhBcU2WKXnjJN78OFW_JN` | `vinyl` | main |
| **EDC 2024** | `PL9QBjNDhgNwRQONB9N2tIIhP0vPrkyNvy` | `star` | main |
| **Shuffle Dance Music** | `PL9QBjNDhgNwSYG7c6qnwlqgRdQW-SWTHK` | `person-dancing` | main |

---

## 💜 TWITCH Page Featured Playlists

| Playlist | ID | Icon | Channel |
|----------|-------|------|---------|
| **Twitch Highlights** | `PL6WnzXOaRqA1q_0XZ2fPo0LIEErxxyoT1` | `play-circle-fill` | gaming |
| **Live Streaming Tips** | `PL9QBjNDhgNwSFR6BJWp4YfTl3LhQASWMi` | `broadcast` | main |

---

## 👑 VIP Page Featured Playlists

| Playlist | ID | Icon | Channel | Access |
|----------|-------|------|---------|--------|
| **VIP** | `PL9QBjNDhgNwRihbrW60bHzJPCUzfRi3bq` | `gem` | main | Patreon only |
| **Sub Updates** | `PL9QBjNDhgNwTomE8_IMCAuUepcM5xzo8p` | `crown` | main | Patreon only |
| **Sexy Music** | `PL9QBjNDhgNwQSoU9lNj3GdJLh8t2zSMSI` | `music-note-list` | main | Patreon only |
| **Fire dancing hoop yoga** | `PL9QBjNDhgNwToY2nfpDaZ_k3FwTNtX1b8` | `fire` | main | Patreon only |

---

## 🛍️ SHOP Page Featured Playlists

| Playlist | ID | Icon | Channel |
|----------|-------|------|---------|
| **Brand Collabs + Product Reviews** | `PL9QBjNDhgNwRsHtjuS574yGSnRZNWmZ_y` | `star-fill` | main |
| **Unboxing Videos** | `PL9QBjNDhgNwSg_6UWQ7myDqttIbll_mYW` | `box-seam` | main |

---

## 📝 BLOG Page Featured Playlists

| Playlist | ID | Icon | Channel |
|----------|-------|------|---------|
| **Touching Grass** | `PL9QBjNDhgNwQZtYAs0N94amcTIevtBIvG` | `tree` | main |
| **How-To: Web Design** | `PL9QBjNDhgNwQo8jtlBvhVR4TPeVFlgrIq` | `code-slash` | main |

---

## 🧘 SELF-CARE Page Featured Playlists

| Playlist | ID | Icon | Channel |
|----------|-------|------|---------|
| **Yoga Sessions** | `PL9QBjNDhgNwRtpcKQ9iEEhQPdIvPU9tJ_` | `heart` | main |
| **DIY Self Care** | `PLYI86hek1EWdXUlDFlaFZKBxIq50vQ_-m` | `heart-pulse` | diy |

---

## 🤖 AI Page Featured Playlists

| Playlist | ID | Icon | Channel |
|----------|-------|------|---------|
| **AI Tools + Info** | `PL9QBjNDhgNwQygOzxOAYImp0L3zC6pBO2` | `cpu` | main |

---

## 🚀 MARTIAN GAMES Page Featured Playlists

| Playlist | ID | Icon | Channel |
|----------|-------|------|---------|
| **Let's Play: Martian Games** | `PL9QBjNDhgNwRkcV9WLFJBsJnULSUDqPty` | `rocket-takeoff` | martiangames |

---

## 🔍 ABOUT Page Featured Playlists

| Playlist | ID | Icon | Channel |
|----------|-------|------|---------|
| **Who is Jenni?** | `PL9QBjNDhgNwQGtxekr9W4TvrN8aAIubTw` | `person-circle` | main |

---

## 🎮 NAILART Page Featured Playlists

| Playlist | ID | Icon | Channel |
|----------|-------|------|---------|
| **Nail Art Diary** | `PLvTBZ29I1ijFPKNzQEL0716txhMn8osuF` | `paint-bucket` | nailart |
| **DIY Gel Nails** | `PLYI86hek1EWcoJ7X5n7ys1jzQYRCjDKnN` | `paint-bucket` | diy |
| **DIY Tutorials** | `PLYI86hek1EWfF1TeN4oIdw2dp126OIlIc` | `scissors` | diy |
| **DIY Fashion & Crafts** | `PL9QBjNDhgNwSjirfHOJ5a8D-Orcj5y-Mf` | `palette` | main |
| **Brand Collabs + Product Reviews** | `PLYI86hek1EWciC-RmY2qfLdwXI9SeUJTf` | `star-fill` | diy |
| **Glitter** | `PLYI86hek1EWeoAoTP0Ik6xsjqfuLb8IPt` | `star-fill` | diy |
| **DIY Self Care** | `PLYI86hek1EWdXUlDFlaFZKBxIq50vQ_-m` | `heart-pulse` | diy |
| **DIY Nail Care** | `PLYI86hek1EWfbT2FcY2yIS37Cf89NXji-` | `droplet` | diy |

---

## 🎨 Bootstrap Icon Mappings

All playlists use Bootstrap Icons for consistent, professional UI. Icons support hover animations.

### Fashion & DIY Icons
- `scissors` - Cutting, DIY, Hair
- `bag-heart` - Fashion
- `palette` - Crafts, Art
- `paint-bucket` - Nails, Paint
- `box` - 3D, Modeling

### Gaming Icons
- `controller` - Gaming
- `clock-history` - Recent
- `building` - Events, Conventions
- `play-circle` / `play-circle-fill` - Videos, Highlights
- `trophy` - Game Jams, Achievements
- `rocket-takeoff` - Martian Games

### Dev Icons
- `journal-code` - Devlogs
- `lightbulb` - Tips, Tutorials
- `box-seam` - Unity
- `cube` - Unreal
- `code-slash` - Web Design
- `cpu` - AI

### Music & Performance Icons
- `mic` / `mic-fill` - Voice Acting
- `disc` / `disc-fill` - DJ Sets
- `music-note-beamed` - FL Studio
- `vinyl` - Music History
- `person-dancing` - Dance
- `broadcast` - Live Streaming

### Lifestyle Icons
- `heart` / `heart-pulse` - Self-care, Yoga
- `tree` - Nature, Touching Grass
- `star` / `star-fill` - Featured, Brands
- `crown` - VIP, Subscribers
- `gem` - VIP Content
- `fire` - Fire Dancing
- `droplet` - Nail Care

---

## 🔐 YouTube Data Access (RSS-Only, No API)

### Current Implementation: RSS Feeds

**✅ NO API KEY NEEDED!** The site uses YouTube's public RSS feeds which don't require authentication:

```
https://www.youtube.com/feeds/videos.xml?playlist_id={PLAYLIST_ID}
```

### How It Works

1. **Browser requests playlist data** → `youtube-grid.js`
2. **Server-side proxy fetches RSS** → `get-youtube.php` (avoids CORS)
3. **RSS converted to JSON** → SimpleXML parsing
4. **Cached for 10 minutes** → `storage/cache/youtube/`
5. **Thumbnails via standard URLs** → `https://img.youtube.com/vi/{VIDEO_ID}/mqdefault.jpg`

### Why RSS Instead of API?

- ✅ **No authentication required** - Public RSS feeds are always available
- ✅ **No rate limits** - RSS doesn't have strict quota limits like YouTube Data API v3
- ✅ **No API key restrictions** - No 403 Forbidden errors from IP/referrer blocks
- ✅ **Simpler setup** - Just works without Google Cloud Console configuration
- ✅ **Better caching** - Server-side cache reduces repeat requests
- ✅ **use_api: false** set in youtube.json per user preference

### API Key Status

The youtube.json file contains an API key but `"use_api": false` is set:

```json
{
  "youtube_api_key": "AIzaSy...",
  "use_api": false,  ← RSS feeds used instead
  "note": "Do NOT commit. Set use_api=true on the remote when you want API enrichment."
}
```

**Current Mode:** RSS-only (no API calls made)

### Channels Supported (via RSS)

1. **Main Channel** - `@jenninexus` (UCu1S6_Gza2Y06pT1n5U_L4Q)
2. **Gaming Channel** - `@jenniplaysgames` (UC4byqahPWuY9WPJNvDgbQMQ)
3. **DIY Channel** - `@jennidiy` (UCk2SWSg1fvdZGnrN0XAt6NQ)
4. **Nail Art Channel** - `@jenninailart` (UCO12O7SUOK0bU1tDhwld59Q)
5. **Martian Games** - `@martiangames` (UCxeyxi73bmMHaZP6cPZmvmg)

All channels work via RSS feeds without any API configuration!

---

## ✅ Verification Checklist

- [x] All playlist IDs verified and correct
- [x] Channel mappings documented
- [x] Icon suggestions for all playlists
- [x] Page-to-playlist mappings clarified
- [x] Primary featured playlists identified
- [x] API configuration requirements documented
- [x] Unlisted playlists marked
- [x] VIP/Patreon-only content identified

---

## 📋 Notes

1. **No Broken Playlists**: All playlist IDs have been verified from your original list
2. **Consistent Icons**: Bootstrap Icons are used throughout for professional appearance
3. **Hover Animations**: UI should implement cute hover effects on playlist cards
4. **Multi-Channel Support**: System supports content from 6 different YouTube channels
5. **Access Control**: VIP playlists require Patreon authentication

---

## 🔄 Last Updated

- **Date:** 2025-10-14
- **Changes:** 
  - Added all DIY and Gaming playlists
  - Mapped icons for all categories
  - Clarified channel ownership
  - Added API configuration requirements
  - Identified unlisted content

---

## 🗺️ Per-Game Playlist Mapping (Updated Oct 28, 2025)

This section lists individual `/game/{slug}.php` pages and their associated YouTube playlists. All data is now stored in `playlist-ids.json -> youtube.playlists.games.game_playlists[]`.

### Game Pages & Playlists

| Game Slug | Page | Playlist ID(s) | Type | Status |
|----------|------|----------------|------|--------|
| **purgatoryfell** | `/game/purgatoryfell.php` | `PL9QBjNDhgNwTsF4Es4jEftJR2Tto1CU53` | devlogs | ✅ Mapped |
| **martiangames** | `/game/martiangames.php` | `PL9QBjNDhgNwRkcV9WLFJBsJnULSUDqPty` | letsplay | ✅ Mapped |
| **botborgs** | `/game/botborgs.php` | `PL9QBjNDhgNwQYrXaiRwC0RROYmkppbssY` | gameplay | ✅ Mapped |
| **jennistyles** | `/game/jennistyles.php` | `PL9QBjNDhgNwS8zNaKAFjuWf4NTfk3Ul3g` | devlog | ✅ Mapped |
| **catgame** | `/game/catgame.php` | `PLLzfSGTgy8YBL97yf_JRzcc3NWwk8FXyN` | gameplay | ✅ Mapped |
| **gamejams** | `/game/gamejams.php` | `PL9QBjNDhgNwTFn7QSZRbZGoKCCIsUlemX` | collection | ✅ Mapped |
| **blueballs** | `/game/blueballs.php` | - | - | ⏳ Needs mapping |
| **cleanupinisle3** | `/game/cleanupinisle3.php` | - | - | ⏳ Needs mapping |
| **cowdefender** | `/game/cowdefender.php` | - | - | ⏳ Needs mapping |
| **graveyardsmashers** | `/game/graveyardsmashers.php` | - | - | ⏳ Needs mapping |
| **momshouse** | `/game/momshouse.php` | - | - | ⏳ Needs mapping |
| **soccercow** | `/game/soccercow.php` | - | - | ⏳ Needs mapping |

### Game Page Display Strategy

**Featured on `/gamedev.php`:**
- Purgatory Fell (hero card)
- BotBorgs (hero card)
- Jenni Styles (hero card)
- Cat as Trophy (hero card)
- Game Jams (promo card)
- Martian Games (dedicated section panel)

**Featured on `/gaming.php`:**
- Game Jam Highlights playlist
- Recent Gaming playlist (includes gameplay from various games)

**Featured on `/game/martiangames.php`:**
- Martian Games Let's Play playlist (main)
- Related games: Purgatory Fell, BotBorgs (cross-promo)

### Display Rules

1. **Hero Cards** (`/gamedev.php`):
   - Show 4 main game cards at top
   - Link to individual game pages
   - Use curated images from `/resources/images/gamedev/{game}/`

2. **Playlist Sections** (all pages):
   - Loaded via `youtube-grid.js` from YAML configs
   - Display based on `grid_config` settings
   - Include data-tags for filtering

3. **CTAs on Game Pages**:
   - "Watch Devlogs" (if devlog playlist exists)
   - "Watch Gameplay" (if gameplay playlist exists)
   - "View on Game Jolt/Steam" (if external_url exists)
   - "Back to Game Dev" (navigation)

### Martian Games Strategy

**Question:** Do we need `martiangames.yaml`?

**Answer:** **NO** - Not needed because:
1. Martian Games content is already in `gamedev.yaml` under `martian_games_playlists` section
2. `/game/martiangames.php` is a collection page that can use inline playlist rendering
3. Adding a separate YAML would duplicate data

**Current Implementation:**
- `gamedev.yaml` includes `martian_games_playlists` section
- `martian-games.js` handles specific Martian Games rendering
- `/game/martiangames.php` shows multiple related playlists inline

**Recommendation:** Keep current structure, refine `martian-games.js` if needed.

---

This section lists individual `/game/{slug}.php` pages and the primary YouTube playlist(s) associated with each game. The goal is to provide a single authoritative mapping that pages can read (server-side) to render a conservative "Watch Playlist" CTA without guessing.

| Game Slug | Page | Playlist ID(s) | Notes |
|----------|------|----------------|-------|
| purgatoryfell | `/game/purgatoryfell.php` | `PL9QBjNDhgNwTsF4Es4jEftJR2Tto1CU53` | Confirmed in page markup (`data-playlist`)
| martiangames | `/game/martiangames.php` | `PL9QBjNDhgNwRkcV9WLFJBsJnULSUDqPty`, `PL9QBjNDhgNwTsF4Es4jEftJR2Tto1CU53`, `PL9QBjNDhgNwQYrXaiRwC0RROYmkppbssY` | Multiple playlist containers present in page
| botborgs | `/game/botborgs.php` |  | Needs mapping (check `playlist-ids.json` or content owner)
| jennistyles | `/game/jennistyles.php` |  | Page has `data-tags`; no playlist container yet
| catgame | `/game/catgame.php` |  | No playlist markers found; may be covered by gamedev/gaming YAML
| cowdefender | `/game/cowdefender.php` |  | Placeholder — needs confirmation
| blueballs | `/game/blueballs.php` |  | Placeholder — needs confirmation
| graveyardsmashers | `/game/graveyardsmashers.php` |  | Placeholder — needs confirmation
| momshouse | `/game/momshouse.php` |  | Placeholder — needs confirmation
| soccercow | `/game/soccercow.php` |  | Placeholder — needs confirmation

How to use this mapping
- Create `public_html/resources/playlists/game-playlist-map.json` from the table above. Structure suggestion:

```json
{
  "purgatoryfell": ["PL9QBjNDhgNwTsF4Es4jEftJR2Tto1CU53"],
  "martiangames": ["PL9QBjNDhgNwRkcV9WLFJBsJnULSUDqPty", "PL9QBjNDhgNwTsF4Es4jEftJR2Tto1CU53"]
}
```

- Server-side pages can `json_decode(file_get_contents(__DIR__ . '/resources/playlists/game-playlist-map.json'), true)` (or include a mapping under `public_html/resources/playlists`) and render a CTA when a mapping exists.

Conservative patch plan (recommended)
1. Create `game-playlist-map.json` with confirmed entries only (do not guess). Leave placeholders empty to avoid accidental incorrect links.
2. Patch `/game/*.php` pages to render a small CTA block at the top that reads the mapping and, if present, outputs a `button.btn` linking to the internal page (if YAML `page` is present) or the YouTube playlist URL. Use `<?= RES_ROOT ?>` for any resource paths.
3. Keep changes minimal and reversible: the patch will only add the CTA when a mapping exists.

Next steps
- I'll prepare the `game-playlist-map.json` with the confirmed IDs and empty placeholders for the rest. After you confirm, I will apply the conservative server-side CTA patch to pages with confirmed mappings, then run a quick smoke test.

---

## 🎨 Bootstrap Grid Integration

### Grid System Requirements (Nov 2, 2025)

**Critical Rule:** Do NOT override Bootstrap's grid with custom CSS Grid rules on playlist containers.

**Correct HTML Structure:**
```html
<!-- Container uses Bootstrap row class -->
<div id="featured-playlists" class="row g-4 mb-4">
  <!-- youtube-grid.js populates with column-wrapped cards -->
</div>
```

**Responsive Columns (from YAML config):**
```yaml
featured_section:
  columns:
    xs: 1   # Mobile: 1 column (col-12)
    sm: 2   # Small tablet: 2 columns (col-sm-6)
    md: 3   # Tablet: 3 columns (col-md-4)
    lg: 3   # Desktop: 3 columns (col-lg-4)
```

**Generated HTML (by youtube-grid.js):**
```html
<div id="featured-playlists" class="row g-4 mb-4">
  <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4">
    <div class="card"><!-- Playlist 1 --></div>
  </div>
  <div class="col-12 col-sm-6 col-md-4 col-lg-4 mb-4">
    <div class="card"><!-- Playlist 2 --></div>
  </div>
  <!-- etc... -->
</div>
```

**❌ AVOID - This Breaks Bootstrap Grid:**
```css
/* DO NOT DO THIS - Overrides Bootstrap's flexbox */
#featured-playlists,
#learning-playlists {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
}
```

**Why This Breaks:**
1. Bootstrap uses `display: flex` on `.row` elements
2. CSS Grid (`display: grid`) overrides flexbox completely
3. Column classes (`col-md-4`, etc.) become ineffective
4. Result: Single-column vertical stack instead of responsive grid

**✅ Correct Approach:**
- Use Bootstrap's native grid system (row + col-*)
- Configure responsive columns in YAML files
- Let youtube-grid.js generate proper column wrappers
- No custom CSS Grid needed!

**Testing Responsive Layout:**
```javascript
// Browser console - check generated column classes
document.querySelectorAll('#featured-playlists > div').forEach(el => {
  console.log(el.className);
});
// Should output: "col-12 col-sm-6 col-md-4 col-lg-4 mb-4"
```

---

## 🔄 Document Update Log
- **2025-11-02** — Added Bootstrap Grid Integration section with CSS Grid conflict warning
- **2025-10-27** — Added Per-Game Playlist Mapping section and conservative patch plan (author: automation)

