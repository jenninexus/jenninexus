# Tag System Status - JenniNexus

**Last Updated:** November 19, 2025  
**Version:** 6.7 (Blog Tag Integration + Content Tags Generator)  
**Status:** ✅ ACTIVE — Full site-wide tag filtering with blog post integration

---

## 🎯 LATEST UPDATE (Nov 19, 2025 - Blog Tag System Integration)

### 1. Blog Posts Now Indexed in Tag System
**✅ Problem:** 
- Blog posts were not appearing in `/tag/index.php` tag pages
- `content_tags.json` (used by tag pages) was missing blog post entries
- Selecting tags like "video-generation" showed "No content matched"

**✅ Solution:**
- Created `scripts/generate-blog-tags.ps1` to parse `blog-posts.yaml` and add entries to `content_tags.json`
- Script extracts blog metadata (title, slug, tags, excerpt, image) and creates proper content_tags entries
- Integrated into `scripts/build-all.ps1` as Step 0 (runs before asset building)
- Blog posts now prefixed with `blog:` in content_tags (e.g., `blog:sora-ai-2025`)

### 2. Fixed Blog Page In-Page Filtering
**✅ Problem:**
- Advanced Tag Filters offcanvas couldn't filter blog posts on `blog.php`
- `data-tags` attribute was on inner `<article>` element, not the container
- `tag-system.js` looks for `.content-item` elements with `data-tags`

**✅ Solution:**
- Moved `data-tags` attribute from `<article>` to the `.col` wrapper (`.content-item`)
- Added `content-item` class to blog post containers
- Tag badges on cards now link to tag pages correctly

### 3. Fixed Static Content Filtering
**✅ Problem:**
- Static game cards on `gamedev.php` had `data-tags` on inner card, not wrapper
- Offcanvas filtering couldn't find these items

**✅ Solution:**
- Moved `data-tags` to `.col` wrapper and added `content-item` class
- Ensures consistency: ALL filterable content uses same pattern

### 4. Build Pipeline Integration
- Updated `scripts/build-all.ps1` to run tag generators before asset building
- Ensures `content_tags.json` is always up-to-date with latest blog posts and playlists
- Tag generation now part of standard build workflow

---

## 🎯 PREVIOUS UPDATE (Nov 19, 2025 - Centralized API & Synchronization)

### 1. Created `tag-filter-api.js`
**✅ Problem:** 
- `gamedev.php` (and others) had inline scripts for "local" filtering buttons.
- `tag-system.js` (offcanvas) had its own filtering state.
- Clicking a local button didn't update the offcanvas, and vice versa.
- `window.tagFilter` was referenced but didn't exist.

**✅ Solution:**
- Created `public_html/resources/js/tag-filter-api.js`.
- Implements `window.tagFilter` with methods: `init`, `toggle`, `add`, `remove`, `clear`, `getActive`, `onChange`.
- Manages a central `activeFilters` Set.
- Handles URL persistence (`?filters=...`) via `pushState`.
- Dispatches `onChange` events to listeners.

### 2. Synchronized `gamedev.php`
- Updated `gamedev.php` to use `window.tagFilter` for its "Content Categories" buttons.
- Buttons now drive the central API.
- Buttons listen for API changes to update their active state (visual feedback).
- **Result:** Clicking "Game Dev" on the page updates the URL, the offcanvas state, and filters content via `tag-system.js`.

---

## 🎯 PREVIOUS UPDATE (Nov 18, 2025 - System-Wide Consistency Audit)

### Blog.php Tag Filtering Fix

**✅ Problem Identified:**
- Top row tag buttons used `data-tag-slug` + `onclick="window.tagFilter?.toggle()"` 
- Card badges used `data-tag` attribute
- JavaScript event handler looked for `[data-tag]` selector, missing top buttons
- `window.tagFilter` API doesn't exist (missing `tag-filter-api.js` file)

**✅ Root Cause:**
- blog.php was trying to use a global `window.tagFilter` API that was never implemented
- The file `tag-filter-api.js` referenced in `includes/footer.php` doesn't exist
- blog.php has its OWN filtering system via `renderBlogPosts()` function

**✅ Solution Applied:**
1. Changed top row buttons from `data-tag-slug` to `data-tag` (consistent with card badges)
2. Removed `onclick="window.tagFilter?.toggle()"` handlers (non-functional)
3. Removed tag-system.js loading and initialization code (not needed for blog page)
4. The existing `[data-tag]` event handler now matches ALL tag buttons

**Result:** Both top row buttons AND card badges now filter correctly! ✅

### Script Loading Order Standardization

**✅ Audited All Pages:**
- ✅ **youtube.php** - Correct order (js-yaml → youtube-grid → tag-system)
- ✅ **gaming.php** - Correct order (js-yaml → youtube-grid → tag-system)
- ✅ **gamedev.php** - Correct (only loads tag-system.js, no grid needed)
- ✅ **diy.php** - Fixed! Removed redundant `diy-playlists.js`, now uses youtube-grid + diy.yaml
- ✅ **blog.php** - Fixed! Removed unnecessary tag-system.js (uses inline filtering)

**Recommended Script Order (for pages with YouTube grids):**
```html
<script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
<script src="<?= RES_ROOT ?>/js/youtube-grid.js"></script>
<script src="<?= RES_ROOT ?>/js/tag-system.js"></script>
```

### Files Archived

**Scripts Archived (20 files):**
- Moved to `scripts/archive/`:
  - One-time utilities: `_tmp_check_http.ps1`, `contrast-check.ps1`, `create-*-placeholders.ps1`
  - Deprecated: `check-ssh-protection.ps1`, `verify-ssh-protection.sh`, `optimize-assets.ps1`
  - Superseded by RSS: `fetch-*-playlists.ps1`, `scrape-playlist-names.ps1`, `download-playlist-thumbnails.ps1`
  - Migration scripts: `fix-all-pages-consistency.ps1`
  - Test utilities: `smoke-*.ps1`, `test-importer.js`

**JavaScript Archived:**
- Moved to `public_html/resources/js/!bak/`:
  - `diy-playlists.js` → `diy-playlists.js.redundant-2025-11-18` (replaced by youtube-grid.js + diy.yaml)

**Playlists Config Archived:**
- Moved to `public_html/resources/playlists/archive/`:
  - `generated_tags.json` → `generated_tags.json.initial-import-2025-11-18`
  - `generated_content_tags.json` → `generated_content_tags.json.initial-import-2025-11-18`
  - **Rationale:** One-time output from `import-youtube-tags.js` seeding script, no longer used

### Documentation Updates

**✅ Created/Updated:**
1. **playlists/README.md** - Comprehensive guide to all config files
   - File inventory (17 files documented)
   - YAML structure examples
   - Tag system integration patterns
   - Maintenance commands
   - Troubleshooting guide

2. **TAG-SYSTEM.md** (this file) - Added consistency audit notes
   - Documented blog.php fix
   - Script loading order standardization
   - Archive decisions with rationale

3. **scripts/README.md** - Already documents active tag scripts:
   - `fix-tag-system.ps1` - Remove duplicates, index blog posts
   - `generate-playlist-tags.ps1` - Auto-generate playlist entries
   - `optimize-tags.ps1` - Keep top N most-used tags
   - `analyze-tags.cjs` - Identify unused tags

---

## 🎯 PREVIOUS UPDATE (Nov 11, 2025 - Session 3 Continued)

### RSS Feed Tag Detection + Button Contrast Improvements

**✅ Completed Today:**

1. **youtube.php Script Loading Order Fix**
   - **Problem:** Tag filtering wasn't working despite having all required code
   - **Root Cause:** Scripts loaded in wrong order (tag-system.js before youtube-grid.js)
   - **Solution:** Reorganized to proper order: js-yaml → youtube-grid → tag-system
   - **Event-Driven Init:** Now waits for `YouTubeGrid:usedTagsUpdated` event before initializing tagFilter
   - **Result:** Tag filtering now works correctly on youtube.php

2. **RSS Feed Tag Detection**
   - **youtube.php Latest Videos:** Added intelligent tag detection from video titles
     - Detects: gaming, gamedev, diy, ai, music, live, voice-acting
     - Adds `data-tags` attributes to RSS-loaded video cards
     - Generates category-appropriate tag badges with icons
     - Falls back to "youtube" tag if no category detected
   
   - **gaming.php Latest Gaming Videos:** Added genre detection from titles
     - Detects: horror, fps, rpg, indie, action, puzzle, platformer
     - RSS cards now filterable by genre tags
     - Shows genre-specific badges (Horror, FPS, RPG, etc.)
     - Always includes base "gaming" tag

3. **Button Contrast Fixes (WCAG Compliance)**
   - **Problem:** `bg-warning` (yellow) badges with white text had poor contrast
   - **Solution:** Changed all `bg-warning` badges to use `text-dark` instead of `text-white`
   - **Files Fixed:**
     - youtube.php - DIY tag button (line 76)
     - gaming.php - FPS tag button (line 150)
     - diy.php - Nails tag button (line 88)
   - **Tag Badge Colors Updated:**
     - Gaming: `bg-danger` (red) + `text-white` ✅
     - Game Dev: `bg-success` (green) + `text-white` ✅
     - DIY: `bg-warning` (yellow) + `text-dark` ✅ FIXED
     - AI: `bg-info` (cyan) + `text-white` ✅
     - Music: `bg-primary` (blue) + `text-white` ✅
     - Live: `bg-secondary` (gray) + `text-white` ✅
     - Voice Acting: `bg-dark` (black) + `text-white` ✅

4. **gaming.php RSS Feed Integration**
   - Added "Latest Gaming Videos" section
   - Uses @jenniplaysgames channel (UC4byqahPWuY9WPJNvDgbQMQ)
   - Shows 8 most recent gaming videos
   - RSS cards have data-tags and genre badges
   - Fully integrated with tag filtering system

### RSS Feed Tag Detection Algorithm

**Title Pattern Matching:**
```javascript
const titleLower = title.toLowerCase();

// Category detection (youtube.php @jenninexus main channel)
if (titleLower.includes('gaming') || titleLower.includes('gameplay')) detectedTags.push('gaming');
if (titleLower.includes('game dev') || titleLower.includes('unity')) detectedTags.push('gamedev');
if (titleLower.includes('diy') || titleLower.includes('tutorial')) detectedTags.push('diy');
if (titleLower.includes('ai') || titleLower.includes('tech')) detectedTags.push('ai');
if (titleLower.includes('music') || titleLower.includes('song')) detectedTags.push('music');
if (titleLower.includes('live') || titleLower.includes('stream')) detectedTags.push('live');
if (titleLower.includes('voice') || titleLower.includes('acting')) detectedTags.push('voice-acting');

// Genre detection (gaming.php @jenniplaysgames channel)
if (titleLower.includes('horror') || titleLower.includes('scary')) detectedTags.push('horror');
if (titleLower.includes('fps') || titleLower.includes('shooter')) detectedTags.push('fps');
if (titleLower.includes('rpg')) detectedTags.push('rpg');
if (titleLower.includes('indie')) detectedTags.push('indie');
if (titleLower.includes('action')) detectedTags.push('action');
if (titleLower.includes('puzzle')) detectedTags.push('puzzle');
if (titleLower.includes('platformer')) detectedTags.push('platformer');
```

**Badge Generation:**
```javascript
const tagConfig = {
  'gaming': { color: 'danger', icon: 'gamepad', label: 'Gaming' },
  'diy': { color: 'warning', icon: 'scissors', label: 'DIY' }, // text-dark for contrast
  'horror': { color: 'danger', icon: 'ghost', label: 'Horror' },
  'fps': { color: 'warning', icon: 'crosshairs', label: 'FPS' }, // text-dark for contrast
  // ... more configs
};

const textClass = config.color === 'warning' ? 'text-dark' : 'text-white';
return `<span class="badge bg-${config.color} bg-opacity-75 ${textClass}">
  <i class="fa-solid fa-${config.icon} me-1"></i>${config.label}
</span>`;
```

### Event-Driven Initialization Pattern

**Before Fix (youtube.php - BROKEN):**
```javascript
// Scripts loaded in wrong order
<script src="/js/tag-system.js"></script>
<script>
  window.tagFilter.init(); // ❌ Runs before playlist cards exist
</script>
<script src="/js/youtube-grid.js"></script> // Loads AFTER init
```

**After Fix (youtube.php - WORKING):**
```javascript
// Scripts loaded in correct order
<script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
<script src="/js/youtube-grid.js"></script>
<script src="/js/tag-system.js"></script>
<script>
  // Wait for YouTubeGrid to fire event after cards rendered
  document.addEventListener('YouTubeGrid:usedTagsUpdated', function() {
    console.log('YouTube Grid loaded, initializing tag filter...');
    window.tagFilter.init({ seedFromUrl: true, persistUrl: true });
  });
</script>
```

**Key Points:**
- js-yaml.min.js MUST load first (parses YAML configs)
- youtube-grid.js loads second (creates cards with data-tags)
- tag-system.js loads third (populates offcanvas)
- Page init waits for `YouTubeGrid:usedTagsUpdated` event
- Ensures cards exist before filter tries to find them

---

## 🎯 PREVIOUS UPDATE (Nov 11, 2025 - Complete Tag System Integration)

### Tag System Now Fully Integrated Across All Pages

**✅ Completed Today:**
1. **youtube.php** - Tag filtering for YouTube playlist cards
   - Tag filter buttons (Gaming, Game Dev, DIY, AI, Music, Live, Voice Acting)
   - Advanced tag filter offcanvas
   - Tag-filter-api.js initialization with URL persistence
   - Playlist cards automatically get `data-tags` from youtube.yaml via youtube-grid.js

2. **blog.php** - Tag filtering for blog posts
   - Tag filter buttons (Game Dev, Gaming, DIY, AI, Voice Acting, Tutorials)
   - Advanced tag filter offcanvas
   - Blog post cards have `data-tags` from blog-posts.yaml
   - Tag-filter-api.js initialization with URL persistence

3. **live.php** - Tag filtering for live streams and VODs
   - Tag filter buttons (Live Streams, Twitch, Gaming, Game Dev, Creative)
   - Advanced tag filter offcanvas
   - Playlist cards get `data-tags` from live.yaml via youtube-grid.js
  ↓
tag-filter-api.js: state.active.add('gaming')
  ↓
tag-filter-api.js: notify() → window.tagFilter.onChange callbacks
  ↓
tag-filter-api.js: syncToDom()
  ↓
Finds all [data-tags] elements (playlist cards from youtube-grid.js)
  ↓
Checks if card data-tags includes 'gaming'
  ↓
If match: card.classList.remove('d-none')
If no match: card.classList.add('d-none')
  ↓
Result: Only gaming playlists visible
```

**YAML Configuration Example:**

```yaml
# youtube.yaml
featured_section:
  playlists:
    - id: "PL6WnzXOaRqA16UY1KibrFUHu4gDZ8hmep"
      title: "Horror Gaming"
      icon: "controller"
      tags: ["gaming", "horror", "lets-play"]  # ← youtube-grid.js reads this
```

**Generated HTML (by youtube-grid.js):**

```html
<div class="col-lg-4 mb-4 content-item" data-tags="gaming,horror,lets-play">
  <div class="card">
    <!-- Card content -->
    <div class="d-flex gap-1 mt-2">
      <span class="badge tag-badge" data-tag-slug="gaming" 
            onclick="window.tagFilter?.toggle('gaming')">
        gaming
      </span>
      <!-- More tag badges -->
    </div>
  </div>
</div>
```

**Pages with Full Tag System (Nov 11, 2025):**
- ✅ **index.php** (Home) - Category cards with tag filtering
- ✅ **gaming.php** - Gaming playlists with platform/genre tags
- ✅ **gamedev.php** - Game dev playlists with technology/content tags
- ✅ **diy.php** - DIY playlists with category/project tags
- ✅ **youtube.php** - Cross-category playlists (gaming, gamedev, diy, ai, music, live, voice-acting)
- ✅ **blog.php** - Blog posts with topic tags
- ✅ **live.php** - Live streams and VODs with platform/content tags
- ✅ **music.php** - Music content with genre/platform tags

---

## 🎯 PREVIOUS UPDATE (Nov 11, 2025 - Tag System Validation & Maintenance)

### Tag System Health Check Results

**Validation Script Created:** `scripts/validate-tag-system.ps1`
- ✅ **25 checks passed** across all 5 pages with tag filtering
- ✅ **157 tags defined** in tags.json (62 used, 95 unused)
- ✅ **Tag filter offcanvas** present on index, gaming, gamedev, diy, music pages
- ✅ **tag-system.js** loaded correctly on all pages
- ✅ **youtube.php** correctly has NO tag filtering (RSS feed only)

**Maintenance Scripts Available:**
1. **`scripts/validate-tag-system.ps1`** - Comprehensive validation of tag implementation
   - Checks tag data files (tags.json, content_tags.json)
   - Validates offcanvas presence on each page
   - Verifies tag-system.js loading
   - Confirms RES_ROOT constant usage
   - Usage: `pwsh -File scripts/validate-tag-system.ps1 -CheckDataFiles`

2. **`scripts/analyze-tags.cjs`** - Find unused tags to prevent "No content matched" errors
   - Compares tags.json definitions to content_tags.json usage
   - Groups unused tags by category
   - Recommends removal or content addition
   - Usage: `node scripts/analyze-tags.cjs`

3. **`scripts/fix-tag-system.ps1`** - Repair tag data integrity
   - Removes duplicate tags from tags.json
   - Adds blog posts to content_tags.json with slug-based tags
   - Adds main pages to content_tags.json
   - Creates timestamped backups before changes
   - Usage: `pwsh -File scripts/fix-tag-system.ps1 -Verbose`

4. **`scripts/import-youtube-tags.js`** - Generate tags from YouTube RSS feeds
   - RSS-first approach (no API key required)
   - Reads playlist-ids.json, fetches feeds/videos.xml
   - Extracts tags from local cache
   - Outputs generated_tags.json and generated_content_tags.json
   - Usage: `node scripts/import-youtube-tags.js`

**Pages with Tag Filter Offcanvas (Nov 11, 2025):**
- ✅ **index.php** (Home) - 3 tag list containers found
- ✅ **gaming.php** - 1 tag list container found
- ✅ **gamedev.php** - 3 tag list containers found
- ✅ **diy.php** - 1 tag list container found
- ✅ **music.php** - 1 tag list container found
- ❌ **youtube.php** - NO tag system (shows RSS feed + channel cards only)

**Tag Usage Statistics (Nov 11, 2025):**
- Total tags: 157
- Used tags: 62 (39.5%)
- Unused tags: 95 (60.5%)
- Breakdown by category:
  - Gaming: 27 unused (action, multiplayer, specific game titles)
  - Blog: 20 unused (AI, technical-art, productivity, trends, conventions)
  - Gamedev: 15 unused (ludum-dare, game-jam, 3d-modeling, devlog)
  - Meta: 16 unused (youtube, twitch, clips, patreon, updates)
  - DIY: 11 unused (tutorial, crafts, no-sew, glitter, sustainability)
  - Music: 6 unused (music, dj, fl-studio, event, history, dance)

**Recommended Actions:**
1. Run `fix-tag-system.ps1` to add blog posts and pages to content_tags.json
2. Run `generate-playlist-tags.ps1` to update playlist mappings
3. Run `analyze-tags.cjs` again to verify improved tag usage
4. Consider removing persistently unused tags or creating content for them

---

## 🎯 PREVIOUS UPDATE (Nov 2, 2025 - Enhanced Tag Experience)

### Multi-Tag Selection with Card Previews

**Improvements:**
- **✅ Multi-tag support on `/tag/index.php`** - Users can now select multiple tags and see refined results
- **✅ Visual card previews** - Both `/tags.php` and `/tag/index.php` now show beautiful card previews instead of simple lists
- **✅ Consistent UI** - Same card rendering logic across all tag pages (Game, Blog, Video, Playlist cards)
- **✅ Interactive tag badges** - Click any tag on a card to add/remove it from active filters
- **✅ Related tags** - Shows co-occurring tags with counts for easy discovery
- **✅ Clear Tags button** - Always visible, making it easy to reset filters

**Tag System Flow:**
1. **Home Page → Tag Filter Offcanvas** → Select multiple tags → Apply Filters
2. **Redirects to** `/tags.php?filters=tag1,tag2,tag3`
3. **Shows card previews** with all matching content (games, blogs, videos, playlists)
4. **Click any tag badge on a card** → Updates URL → Shows refined results
5. **Related tags section** → Click to add more tags to filter

**Files Updated:**
- `public_html/tag/index.php` - Complete rewrite with card rendering and multi-tag support
- `public_html/gaming.php` - Fixed carousel height (max 500px) and spacing
- `public_html/resources/css/gaming-theme.css` - Fixed play overlay positioning for video thumbnails
- `public_html/index.php` - Fixed offcanvas button wrapping with flex-wrap
- `public_html/tags.php` - Clear Tags button always visible

**Technical Details:**
- Tag URLs support comma-separated slugs: `/tag/index.php?slug=fashion,beauty,diy`
- Both `?slug=` and `?filters=` parameters work for compatibility
- JavaScript handles multi-tag selection with Set for deduplication
- Cards show active tags highlighted in blue (bg-primary)
- Inactive tags shown in gray (bg-secondary bg-opacity-50)

**Video Grid Fix (Nov 2, 2025):**
- Fixed CSS Grid conflict in `gamedev-theme.css` overriding Bootstrap flexbox grid
- Removed conflicting CSS Grid rules targeting `#featured-playlists` and `#learning-playlists`
- Bootstrap grid now displays properly: 3 columns desktop, 2 tablet, 1 mobile
- Updated `YOUTUBE.md` and `PLAYLIST-MAPPING.md` with troubleshooting sections
- All game pages verified for proper responsive grid layout

---

## 📖 TAG USAGE PROTOCOL (Added Nov 9, 2025)

This section documents **how, when, and where** to use tags across the entire JenniNexus site to ensure consistency, avoid duplicates, and maintain reliable filtering.

### Where Tags Are Used

**IMPORTANT: Pages Using Tag System vs Hardcoded Embeds**

Pages are divided into two implementation patterns:

**A. YouTubeGrid + Tag System (8 Pages):**
These pages use `youtube-grid.js` to render video/playlist cards with clickable tag badges from YAML files:
1. ✅ **gaming.php** - Uses gaming.yaml, 30 playlists with tags
2. ✅ **gamedev.php** - Uses gamedev.yaml, game dev playlists with tags
3. ✅ **diy.php** - Uses diy.yaml, DIY/beauty playlists with tags
4. ✅ **youtube.php** - Uses youtube.yaml, cross-category playlists with tags
5. ✅ **live.php** - Uses live.yaml, live stream playlists with tags
6. ✅ **jennistyles.php** - Uses jennistyles.yaml, game-specific videos with tags
7. ✅ **purgatoryfell.php** - Uses purgatoryfell.yaml, game-specific videos with tags
8. ✅ **Other game/*.php pages** - Each uses their own YAML file with tags

**B. Hardcoded Iframe Embeds (NO Tag System) (2 Pages):**
These pages use manual HTML iframe embeds for guaranteed 16:9 aspect ratio. They do NOT use youtube-grid.js or tag badges:
1. ❌ **ai.php** - Hardcoded iframe embeds (lines 186-239), ai.yaml exists but NOT used
2. ❌ **music.php** - Hardcoded iframe embeds (lines 104-200), music.yaml exists but NOT used

**Why Two Patterns?**
- **YouTubeGrid pattern:** Best for showcasing multiple playlists with tag filtering
- **Hardcoded iframe pattern:** Guaranteed 16:9 display, no RSS feed delays, simpler implementation

---

**1. Page Headers (Navigation/Filtering)**
- **Home Page (`index.php`)** - Tag filter offcanvas (lines ~540-620)
  - Uses `tag-system.js` to load all tags from `tags.json`
  - Displays tag cloud by category (gamedev, gaming, diy, voice-acting)
  - "Apply Filters" button redirects to `/tags.php?filters=slug1,slug2`
- **Gaming Page (`gaming.php`)** - Platform and genre tag badges (lines 82-131)
  - Platform badges: Steam, PS5, Nintendo Switch, Retro, VR
  - Genre badges: Horror, FPS, RPG, Indie, Action, Multiplayer, Survival, Puzzle, Platformer
  - Each badge: `onclick="window.tagFilter?.toggle('slug')"`
- **Gamedev Page (`gamedev.php`)** - Content category badges (lines ~60-80)
  - Unity, Unreal, 3D Modeling, VR, Indie Games, Game Jams
- **DIY Page (`diy.php`)** - Beauty/fashion category badges
- **Music Page (`music.php`)** - DJ, FL Studio, event badges

**2. Playlist Cards (YAML-Driven)**
- **YAML Files Location:** `public_html/resources/playlists/*.yaml`
  - `gaming.yaml` - 30 playlists with platform/genre/game-specific tags
  - `gamedev.yaml` - Game dev playlists (devlogs, tutorials, tools)
  - `gamejams.yaml` - Game jam and Ludum Dare playlists
  - `diy.yaml` - DIY/beauty/fashion playlists
  - `music.yaml` - Music/DJ playlists
  - `live.yaml` - Live stream playlists
- **Tag Placement in YAML:**
  ```yaml
  playlists:
    - id: "PL6WnzXOaRqA16UY1KibrFUHu4gDZ8hmep"
      title: "Ori and the Blind Forest"
      tags: ["gaming", "platformer", "indie", "metroidvania", "action-adventure"]
  ```
- **Rendered By:** `youtube-grid.js` - Creates playlist cards with clickable tag badges

**3. Blog Post Badges (PHP Files)**
- **Blog Post Files:** `public_html/blog/*.php`
- **Tag Badge Format (Standardized Nov 9, 2025):**
  ```php
  <a href="../tags.php?filters=gamedev" class="badge bg-secondary me-1 text-decoration-none tag-badge">Game Dev</a>
  ```
- **Critical Rules:**
  - `href` must point to `../tags.php?filters=slug`
  - `class` must include `text-decoration-none` and `tag-badge`
  - Display name should be **capitalized/friendly** version (e.g., "Game Dev", "AI Tools")
- **All 10 Blog Posts Standardized:** ai-tools-for-technical-artists.php, voice-acting-in-games.php, summercon-2024.php, pax-west-2022.php, pax-west-gaming-con.php, game-dev-in-2025.php, diy-beauty-trends-2025.php, build-and-deploy-2024.php, ai-tools-using-ai.php

**4. Game Page Tags (Individual Game Pages)**
- **Location:** `public_html/game/*.php` (e.g., purgatoryfell.php, jennistyles.php)
- **Pattern:** Same as blog posts - clickable badge buttons at bottom of page
- **Purpose:** Allow filtering by game-specific tags (vr, unity, horror, puzzle, etc.)

**5. Tag Filter Results Pages**
- **`/tags.php`** - Main tag index and multi-tag filter results
  - URL: `/tags.php?filters=slug1,slug2,slug3`
  - Shows all matching content as card previews (games, blogs, videos, playlists)
  - "Clear Tags" button always visible
  - Related tags section with click-to-add functionality
- **`/tag/index.php`** - Single tag page (also supports multi-tag)
  - URL: `/tag/index.php?slug=gaming` or `/tag/index.php?slug=horror,fps`
  - Both `?slug=` and `?filters=` parameters work
  - Same card preview rendering as tags.php

### When to Add Tags to New Content

**Adding a New Blog Post:**
1. Create `/blog/your-post-name.php`
2. Add tag badges section (copy from existing post like ai-tools-for-technical-artists.php)
3. Verify tags exist in `tags.json` - if not, add them:
   ```json
   {
     "id": 199,
     "name": "New Tag Name",
     "slug": "new-tag-name",
     "category": "blog"
   }
   ```
4. Add post to `blog-posts.yaml` with matching tags:
   ```yaml
   - slug: your-post-name
     title: "Your Post Title"
     tags: ["tag1", "tag2", "tag3"]
   ```
5. Run `pwsh -File scripts/generate-playlist-tags.ps1 -Verbose`
6. Verify post appears in `/tags.php?filters=tag1`

**Adding a New Game Page:**
1. Create `/game/your-game-name.php`
2. Add tag badges section at bottom
3. Add game to `gamedev.yaml` featured_section if it should appear on /gamedev page
4. Run generate-playlist-tags.ps1
5. Verify filtering works

**Adding a New Playlist:**
1. Add to appropriate YAML file (gaming.yaml, gamedev.yaml, etc.)
2. Include tags array:
   ```yaml
   - id: "PLxxxxxxxxxxxxxxxxxx"
     title: "Playlist Title"
     tags: ["tag1", "tag2", "tag3"]
   ```
3. Verify all tags exist in tags.json
4. Run generate-playlist-tags.ps1
5. Test playlist appears when filtering by those tags

### How to Avoid Duplicate Tags

**Before Adding Tags to YAML:**
1. Check `tags.json` for existing tag - search by slug first
2. If tag doesn't exist, add it to tags.json with unique ID
3. Use consistent category: gaming, gamedev, diy, music, meta, blog
4. Use consistent slug format: lowercase, hyphenated (e.g., `action-adventure` not `action_adventure`)

**Tag Naming Standards:**
- **Slugs:** lowercase-with-hyphens (e.g., `game-development`, `nail-art`)
- **Names:** Title Case (e.g., "Game Development", "Nail Art")
- **Avoid spaces in slugs:** They break URL routing and filtering
- **Avoid underscores:** Use hyphens for consistency

**Check for Duplicate Slugs:**
```powershell
# Run this to check for duplicate tag slugs in tags.json
Get-Content public_html/resources/playlists/tags.json | ConvertFrom-Json | 
  Select-Object -ExpandProperty tags | Group-Object slug | 
  Where-Object Count -gt 1 | Select-Object Name, Count
```

### Tag System Data Flow

```
┌─────────────────────────────────────────────────────────────────┐
│ 1. CONTENT CREATION (Human Edits YAML/PHP)                      │
├─────────────────────────────────────────────────────────────────┤
│ • Edit gaming.yaml, blog-posts.yaml, etc.                       │
│ • Add/update tags: ["gaming", "horror", "fps"]                  │
│ • Edit blog/*.php - add tag badges with data-tag-slug           │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ 2. TAG DEFINITION (Ensure Tags Exist in tags.json)              │
├─────────────────────────────────────────────────────────────────┤
│ • Check tags.json for each slug used in YAML/PHP                │
│ • If missing, add to tags.json with unique ID                   │
│ • Assign category: gaming, gamedev, diy, music, meta, blog      │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ 3. TAG INDEXING (Run PowerShell Script)                         │
├─────────────────────────────────────────────────────────────────┤
│ • Run: pwsh -File scripts/generate-playlist-tags.ps1 -Verbose   │
│ • Script reads all YAML files                                   │
│ • Extracts tags and maps them to content IDs                    │
│ • Generates content_tags.json (tag slug → content mapping)      │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ 4. CLIENT-SIDE FILTERING (JavaScript Loads Data)                │
├─────────────────────────────────────────────────────────────────┤
│ • tag-system.js loads tags.json (tag definitions)               │
│ • Pages load content_tags.json (tag → content mapping)          │
│ • User clicks tag badge or selects tags in offcanvas            │
│ • JavaScript filters content by active tags (Set-based logic)   │
└─────────────────────────────────────────────────────────────────┘
                              ↓
┌─────────────────────────────────────────────────────────────────┐
│ 5. TAG FILTER RESULTS (Server-Side PHP)                         │
├─────────────────────────────────────────────────────────────────┤
│ • /tags.php?filters=slug1,slug2                                 │
│ • PHP reads content_tags.json, finds matching content           │
│ • Renders card previews (games, blogs, videos, playlists)       │
│ • Shows related tags with click-to-add functionality            │
└─────────────────────────────────────────────────────────────────┘
```

### File References

**Core Tag System Files:**
- `public_html/resources/playlists/tags.json` - Tag definitions (198 tags)
- `public_html/resources/playlists/content_tags.json` - Tag → content mapping (generated)
- `public_html/resources/js/tag-system.js` - Client-side tag filtering
- `scripts/generate-playlist-tags.ps1` - Tag indexing script

**YAML Source Files:**
- `public_html/resources/playlists/gaming.yaml` (30 playlists, 57 gaming tags)
- `public_html/resources/playlists/gamedev.yaml` (game dev, 28 tags)
- `public_html/resources/playlists/gamejams.yaml` (game jams, ludum-dare tags)
- `public_html/resources/playlists/diy.yaml` (23 DIY tags)
- `public_html/resources/playlists/music.yaml` (6 music tags)
- `public_html/resources/playlists/live.yaml` (streaming tags)
- `public_html/resources/playlists/blog-posts.yaml` (20 blog tags)

**Tag Integration Pages:**
- `public_html/index.php` - Tag filter offcanvas (home page)
- `public_html/gaming.php` - Platform/genre tag badges
- `public_html/gamedev.php` - Game dev category badges
- `public_html/tags.php` - Main tag filter results page
- `public_html/tag/index.php` - Single/multi-tag page
- `public_html/blog/*.php` - All 10 blog posts with tag badges

**Documentation:**
- `storage/docs/TAG-SYSTEM.md` (this file) - Complete tag system documentation
- `.config/tag-deps.json` - Tag system architecture and dependencies
- `storage/docs/GAME-DEV-PAGES.md` - Game page tag integration
- `storage/docs/GAMING-PAGE.md` - Gaming page tag system

### Common Mistakes to Avoid

❌ **Using spaces in tag slugs**
```php
<!-- WRONG -->
<a href="../tags.php?filters=game development" class="badge bg-secondary me-1 text-decoration-none tag-badge">Game Development</a>

<!-- CORRECT -->
<a href="../tags.php?filters=game-development" class="badge bg-secondary me-1 text-decoration-none tag-badge">Game Development</a>
```

❌ **Mismatched data-tag-slug and onclick**
```php
<!-- WRONG -->
<a href="../tags.php?filters=events" class="badge bg-secondary me-1 text-decoration-none tag-badge">Summercon</a>

<!-- CORRECT -->
<a href="../tags.php?filters=summercon" class="badge bg-secondary me-1 text-decoration-none tag-badge">Summercon</a>
```

❌ **Adding tags to YAML without defining in tags.json**
```yaml
# WRONG - Tag "new-tag" doesn't exist in tags.json
playlists:
  - id: "PLxxxxxxxxx"
    tags: ["gaming", "new-tag"]

# CORRECT - First add to tags.json:
# { "id": 199, "name": "New Tag", "slug": "new-tag", "category": "gaming" }
# Then use in YAML
```

❌ **Forgetting to run generate-playlist-tags.ps1**
- After editing any YAML file or tags.json
- Always run: `pwsh -File scripts/generate-playlist-tags.ps1 -Verbose`
- Verify content_tags.json updated

---

## 🎯 PREVIOUS UPDATE (Nov 1, 2025 - Complete Tag Coverage Fix)

### Critical Fix: Missing Tag Definitions

**Problem:**
YAML files (gaming.yaml, gamedev.yaml, gamejams.yaml, diy.yaml, music.yaml, live.yaml, blog-posts.yaml) used 138 unique tags, but tags.json only defined 48 tags. This meant 105 tags used in YAML files had NO definitions, breaking tag filtering for:
- Game-specific tags: bioshock, portal, half-life, metro-exodus, dead-space, resident-evil, etc.
- Gameplay tags: stealth, narrative, boss-fight, blind-playthrough, open-world, metroidvania, immersive
- Content tags: highlights, moments, recent, live, playthrough, funny, nostalgia, classic
- Game jam tags: ludum-dare, jam, kitty-mcblubberton
- Music tags: dj, fl-studio, event, history, dance
- Blog tags: ai, productivity, claude, vscode, devops, pax-west, summercon

**Root Cause:**
YAML files were updated with new tags over time, but tags.json was never updated to include these tags. The tag system requires ALL tags used in YAML to be defined in tags.json for filtering to work.

**Fix Applied:**
Added 105 missing tag definitions to tags.json with proper IDs, names, slugs, and categories.

**Files Updated:**
- `public_html/resources/playlists/tags.json` - Added 105 new tags (48 → 153 total, updated to 198 on Nov 2)
- `public_html/resources/playlists/content_tags.json` - Re-indexed with all tags

**Tag System Now Complete:**
✅ **198 total tags** (was 153, now includes devlog, steam, webgl, gameplay)
- **Gaming:** 57 tags - All game-specific, genre, platform, and content tags
- **Gamedev:** 28 tags - Game dev tools, events, archive tags, devlogs  
- **DIY:** 23 tags - Beauty, fashion, nail art, crafts, sustainability
- **Music:** 6 tags - DJ, FL Studio, events, dance, history
- **Meta:** 18 tags - Streaming, social media, behind-the-scenes, tech
- **Blog:** 20 tags - AI, productivity, tools, conventions, community

**Command Run:**
```powershell
pwsh -NoProfile -ExecutionPolicy Bypass -File .\scripts\generate-playlist-tags.ps1 -Verbose
# Result: 116 content entries indexed successfully with all 198 tags (updated Nov 2, 2025)
```

**Now Working:**
✅ All 198 tags used in YAML files now have definitions  
✅ Game-specific tags filter correctly (bioshock, portal, half-life, etc.)  
✅ Gameplay tags work (stealth, narrative, boss-fight, open-world, etc.)  
✅ Content tags functional (highlights, moments, recent, live, funny, etc.)  
✅ Game jam tags operational (ludum-dare, jam, kitty-mcblubberton)  
✅ Music page tags working (dj, fl-studio, event, history, dance)  
✅ Blog tags active (ai, productivity, claude, vscode, devops, pax-west)  
✅ New game dev tags active (devlog, steam, webgl, gameplay)
✅ /tags.php shows all tags with correct counts  
✅ Offcanvas filter panels populate with all category tags  
✅ Multi-tag filtering works (e.g., "horror,fps" shows horror FPS games)  
✅ Tag badges on playlists link to correct filtered results  

---

## 📖 Tag System Architecture

**Dependency Graph:** `.config/tag-deps.json` - Complete system overview with all files, scripts, and workflows

### Core Components

**1. Tag Definition (`tags.json`)**
- Single source of truth for all tag metadata
- Each tag has: `id` (numeric), `slug` (URL-safe), `name` (display), `category` (grouping)
- Location: `public_html/resources/playlists/tags.json`
- **CRITICAL**: All tags used in YAML files MUST be defined here or filtering breaks

**2. Content Tagging (`content_tags.json`)**
- Maps content IDs to their associated tags
- Generated by `scripts/generate-playlist-tags.ps1`
- Supports multiple formats:
  ```json
  // Playlist with metadata
  "playlist:PL123...": {
    "title": "Playlist Name",
    "url": "https://youtube.com/playlist?list=PL123",
    "tags": ["gaming", "fps", "horror"],
    "type": "playlist"
  }
  
  // Blog post with metadata
  "ai-tools-for-technical-artists": {
    "title": "AI Tools for Technical Artists",
    "url": "/blog/ai-tools-for-technical-artists.php",
    "tags": ["ai", "productivity", "tools"],
    "type": "blog",
    "description": "..."
  }
  ```

**3. Tag Display Components**
- `tag-system.js` - Offcanvas filter panel on home page
- `tag-cloud.js` - Clickable tag cloud widget
- `tag-filter-api.js` - Central API for shared filter state
- `tags.php` - Main tag index page with multi-select
- `tag/index.php` - Individual tag pages with card previews

### Data Flow

```
1. Content Creation (YAML files)
   ├─ gaming.yaml (playlists with tags)
   ├─ blog-posts.yaml (posts with tags)
   ├─ diy.yaml (tutorials with tags)
   └─ ... other YAML files
           ↓
2. Tag Generation (PowerShell script)
   └─ scripts/generate-playlist-tags.ps1
      - Reads all YAML files
      - Extracts unique tags
      - Generates content_tags.json
           ↓
3. Tag Resolution (Runtime)
   └─ pages load tags.json + content_tags.json
      - Map tag slugs to display names
      - Filter content by selected tags
      - Render card previews
```

### URL Patterns

- `/tags.php` - Main tag index, shows all 153 tags
- `/tags.php?filters=fashion,beauty` - Multi-tag filter results
- `/tag/index.php?slug=gaming` - Single tag page
- `/tag/index.php?slug=horror,fps` - Multi-tag page (NEW!)
- Home page offcanvas → redirects to `/tags.php?filters=...`

### Card Types

The system renders different card styles based on content type:

- **Game Card** - Primary badge, thumbnail, description, "Learn More" button
- **Blog Card** - Info badge, no thumbnail, description, "Read More" button
- **Video Card** - Danger badge with YouTube icon, thumbnail, "Watch Video" button
- **Playlist Card** - Danger badge, playlist icon, YouTube link, "View Playlist" button
- **Generic Card** - Secondary badge for fallback content

---

## ⚠️ Critical Caveats & Best Practices

### DO NOT Break These Rules

1. **NEVER modify `tags.json` manually without updating YAML files**
   - Tags in YAML must exist in tags.json or filtering breaks
   - Use `scripts/generate-playlist-tags.ps1` to regenerate content_tags.json after changes

2. **NEVER use numeric tag IDs in new code**
   - Always use slugs (e.g., `"gaming"` not `"1"`)
   - Legacy code may have numeric IDs for backwards compatibility
   - Tag resolution supports both but slugs are preferred

3. **NEVER skip the build step before deployment**
   - CSS/JS must be minified: `scripts/build.ps1` or `scripts/build-all.ps1`
   - Unminified files are larger and slower to load

4. **NEVER edit `content_tags.json` manually**
   - Auto-generated file, will be overwritten by scripts
   - Edit source YAML files instead, then regenerate

5. **NEVER delete tags that are in use**
   - Check content_tags.json first to see what uses a tag
   - Or search YAML files: `grep -r "tag-name" public_html/resources/playlists/`

### Safe Tag System Modifications

**Adding a New Tag:**
```powershell
# 1. Add tag definition to tags.json
{
  "id": 154,
  "slug": "new-category",
  "name": "New Category",
  "category": "gaming"
}

# 2. Use tag in YAML files (gaming.yaml, diy.yaml, etc.)
tags: ["new-category", "existing-tag"]

# 3. Regenerate content index
.\scripts\generate-playlist-tags.ps1 -Verbose

# 4. Test locally
Start-Process "http://localhost:8002/tags.php"
```

**Renaming a Tag:**
```powershell
# 1. Update slug and name in tags.json
# 2. Find-replace in all YAML files
(Get-ChildItem -Path "public_html\resources\playlists\*.yaml").FullName | 
  ForEach-Object { 
    (Get-Content $_) -replace 'old-slug', 'new-slug' | 
    Set-Content $_ 
  }

# 3. Regenerate content index
.\scripts\generate-playlist-tags.ps1 -Verbose
```

**Removing a Tag:**
```powershell
# 1. Check usage first
Select-String -Path "public_html\resources\playlists\*.yaml" -Pattern "tag-to-remove"

# 2. Remove from all YAML files where used
# 3. Remove from tags.json
# 4. Regenerate content index
.\scripts\generate-playlist-tags.ps1 -Verbose
```

### CSS/JS Build Requirements

The tag system uses these minified files:
- `public_html/resources/css/gaming-theme.min.css`
- `public_html/resources/css/tags-theme.min.css`
- `public_html/resources/css/all-themes.min.css`
- `public_html/resources/js/tag-system.js` (not minified, loaded dynamically)
- `public_html/resources/js/tag-cloud.js` (not minified, loaded dynamically)
- `public_html/resources/js/tag-filter-api.js` (not minified, loaded dynamically)

**Always run build before deploy:**
```powershell
# Minify CSS (build.ps1 handles this automatically)
.\scripts\build.ps1

# Or use full pipeline
.\scripts\build-all.ps1
```

### JavaScript Dependencies

- **Bootstrap 5.3.8** - Required for offcanvas, modals, badges
- **No jQuery** - Pure vanilla JavaScript
- **Fetch API** - Modern browsers only (IE11 not supported)

### Performance Considerations

- `tags.json` - 153 tags, ~25KB uncompressed
- `content_tags.json` - 110+ entries, ~30KB uncompressed
- Both files cached by browser after first load
- Tag filtering happens client-side (JavaScript) for instant results
- Card rendering happens server-side (PHP) for SEO

---

## 🔄 Related Documentation

- `README.md` - Project overview and quick start
- `DEPLOYMENT-MANIFEST.md` - Deployment checklist
- `storage/docs/11-2.md` - Daily action log (Nov 2, 2025)
- `scripts/generate-playlist-tags.ps1` - Tag index generation script

---

**Maintained by:** JenniNexus Development Team  
**Last Review:** November 2, 2025  
**Next Review:** When adding new content categories or major tag system changes
---

## 🎯 PREVIOUS UPDATE (Nov 1, 2025 - Apply Filters Button Fix)

### Critical Fix: Apply Filters Button Behavior

**Problem:**
After clicking "Apply Filters" in the offcanvas panel on diy.php and gamedev.php, the selected tags would disappear and the offcanvas would close before the redirect to /tags.php occurred. This made it appear that the filtering wasn't working.

**Root Cause:**
Both diy.php and gamedev.php had `data-bs-dismiss="offcanvas"` attribute on the Apply Filters button, which dismissed the offcanvas immediately before the JavaScript redirect could execute.

**Files Fixed:**
- `public_html/diy.php` (line 104) - Removed `data-bs-dismiss="offcanvas"`
- `public_html/gamedev.php` (line 372) - Removed `data-bs-dismiss="offcanvas"`

**Now Working:**
✅ gaming.php Apply Filters → redirects to /tags.php with selected tags  
✅ diy.php Apply Filters → redirects to /tags.php with selected tags  
✅ gamedev.php Apply Filters → redirects to /tags.php with selected tags  
✅ Offcanvas stays open showing selections until redirect completes  
✅ Consistent behavior across all three pages

---

## 🎯 PREVIOUS UPDATE (Nov 1, 2025 - Gaming Console Tag & Tag Coverage Complete)

### Improvements Made Today

**1. Gaming Page Tag Coverage**
- Updated all 30 gaming playlists with comprehensive genre and platform tags
- Added missing tags to ensure every filter button shows content:
  - Platform tags: `console`, `steam-games`, `ps5`, `nintendo-switch`, `retro`, `vr`
  - Genre tags: `horror`, `fps`, `rpg`, `indie`, `action-adventure`, `multiplayer`, `survival`, `puzzle`, `platformer`, `action`

**2. Tags Added to tags.json**
Added 13 new gaming-related tags to tags.json for complete offcanvas filter support:
- `horror` (ID: 70) - Horror games
- `action` (ID: 71) - Action games  
- `action-adventure` (ID: 73) - Action-adventure games
- `multiplayer` (ID: 74) - Multiplayer games
- `puzzle` (ID: 75) - Puzzle games
- `platformer` (ID: 76) - Platformer games
- `rpg` (ID: 80) - Role-playing games
- `retro` (ID: 81) - Retro/classic games
- `vr` (ID: 82) - Virtual reality games
- `ps5` (ID: 83) - PlayStation 5 games
- `nintendo-switch` (ID: 84) - Nintendo Switch games
- `steam-games` (ID: 85) - Steam platform games
- `console` (ID: 69) - Console games (already existed)

**3. Console Tag Added**
- Added `console` tag to 6 console-specific playlists:
  - PS5 Playthroughs
  - Nintendo Switch Games  
  - Marvel's Spider-Man [PS4]
  - Assassin's Creed: Odyssey [PS4 - Live]
  - Far Cry 5 [PS4] - 1st Playthrough
  - Detroit: Become Human

- Added Console filter button to gaming.php (first in Platform Tags section)

**4. DIY Page Tag Coverage**
- Updated all DIY category cards with comprehensive tags
- Enhanced diy.yaml playlists with beauty, sustainable, diy-hair, diy-hair-color, etc.
- Added blog posts section that filters for DIY-related tags
- All 12 DIY filter tags now show matching content

**Files Modified:**
- `public_html/resources/playlists/tags.json` - Added 13 new gaming tags
- `public_html/resources/playlists/gaming.yaml` - Added `console` tag to 6 playlists
- `public_html/gaming.php` - Added Console filter button
- `storage/docs/TAG-SYSTEM.md` - Documented complete tag system workflow

**Offcanvas Filter Integration:**
The `tag-system.js` automatically reads tags.json and populates the offcanvas filter panel with all gaming-category tags. Now includes all platform and genre tags used on gaming.php filter buttons.

**Tag Index Re-Generated:**
```powershell
pwsh -NoProfile -ExecutionPolicy Bypass -File .\scripts\generate-playlist-tags.ps1 -Verbose
# Result: 110 content entries indexed successfully
```

**Now Working:**
✅ Gaming page: All 15 filter tags (6 platform + 9 genre) show content  
✅ DIY page: All 12 filter tags show content  
✅ Console tag filters PS5, PS4, Nintendo Switch playlists  
✅ /tags.php shows all gaming tags with correct counts  
✅ Offcanvas filter panel shows all gaming tags from tags.json  
✅ Multi-tag filtering works (e.g., "Console + Horror" shows PS5 horror games)  
✅ Apply Filters button redirects to /tags.php with selected tags  
✅ Tag badges no longer flicker on hover  
✅ Tag selection persists when Apply Filters is clicked

---

## 🔴 CRITICAL UPDATE (Nov 1, 2025 - Tag Filtering Fix)

### Issue Fixed: Tag Filter Results Not Showing DIY Content

**Problem:**
When users selected DIY tags (Fashion, Beauty, Hair, etc.) in the offcanvas filter panel and clicked "Apply Filters", the `/tags.php` page showed "No content matched those tags" even though DIY playlists existed.

**Root Cause:**
The `content_tags.json` file stores tags as **numeric IDs** (e.g., `[39, 33, 34]` for DIY, Fashion, Beauty), but `tags.php` was comparing these directly against the filter **names** from the URL (e.g., "Fashion", "Beauty"). This mismatch caused all comparisons to fail.

**Solution Implemented:**
1. **Tag ID/Name/Slug Mapping:** Created lookup tables to convert between tag IDs, slugs, and display names
2. **Normalized Comparison:** Convert all tags (both filters and content tags) to slugs before comparison
3. **Proper Display:** Use the `tagSlugToName` map to display friendly tag names on result cards instead of slugs

**Files Modified:**
- `public_html/tags.php` - Fixed tag filtering logic to handle ID→slug→name conversions

**Code Changes:**
```php
// Build lookup tables for flexible tag matching
$tagIdToSlug = [];      // 39 => "diy"
$tagNameToSlug = [];    // "DIY" => "diy"
$tagSlugToName = [];    // "diy" => "DIY"

// Convert filter names/slugs to normalized slugs
$filterSlugs = []; // ["fashion", "beauty", "diy"]

// Convert content tag IDs to slugs for comparison
$contentSlugs = []; // [39, 33] => ["diy", "fashion"]

// Compare using normalized slugs
$intersect = array_intersect($filterSlugs, $contentSlugs);

// Display friendly names on cards
$getTagName = function($slug) use ($tagSlugToName) {
  return $tagSlugToName[$slug] ?? $slug;
};
```

**Now Working:**
✅ DIY Fashion + Beauty filter → Shows DIY playlists  
✅ Tag badges display friendly names ("Fashion", not "fashion" slug)  
✅ Gaming tags work correctly  
✅ Game Dev tags work correctly  
✅ Blog posts show up in filtered results  
✅ Playlist cards render with proper thumbnails and links  
✅ Content type detection (blog, game, video, playlist) works correctly  
✅ Blog post URLs generate correctly (`/blog/{slug}.php`)  
✅ Playlist URLs link to YouTube playlists  
✅ Video URLs link to YouTube videos  
✅ Category pages (`/diy`, `/gaming`) are filtered out of results

**Testing:**
1. Visit any page with offcanvas filter (index.php, gamedev.php, diy.php)
2. Click "Filter by Tags" button
3. Select tags from any category (DIY: Fashion, Beauty, Hair)
4. Click "Apply Filters"
5. Verify `/tags.php?filters=Fashion,Beauty` shows matching DIY playlists and content

---

## 🔴 CRITICAL UPDATE (Oct 30, 2025 - Evening)

### What Happened Today
1. **Tag files were moved to archive** - `tags.json` and `content_tags.json` were moved to `.archive/` directory
2. **Tag system broke** - Tag clouds stopped displaying, filter panels were empty
3. **Files restored** - Both files copied back from `.archive/` to `/resources/playlists/`
4. **System now working** - Tag clouds, filters, and tag pages are functional again

### Current Reality
- **36 tags** in active use (NOT 115 or 136 as mentioned in older sections below)
- **110 content entries** mapped to tags
- **Files MUST stay in** `public_html/resources/playlists/` for JavaScript to find them
- **Archive contains backups** but should not be used as primary location

### Why This Matters
All JavaScript files hard-code the path `/resources/playlists/tags.json` and cannot find files in `.archive/`. Moving files breaks:
- Tag clouds on home page and sidebar
- Tag filter offcanvas on gamedev/gaming pages  
- Tags.php tag index page
- Individual tag pages at /tag/

**Do not move these files to archive again unless updating all JavaScript paths first.**

---

## 📑 Table of Contents

1. [Architecture Overview](#architecture-overview)
2. [Tag Automation](#tag-automation)
3. [How Filtering Works](#how-filtering-works)
4. [File Locations](#file-locations)
5. [JavaScript Components](#javascript-components)
6. [Page Types Explained](#page-types-explained)
7. [Blog System Integration](#blog-system-integration)
8. [Adding Tag Filtering to New Pages](#adding-tag-filtering-to-new-pages)
9. [Troubleshooting](#troubleshooting)

---

## 🏗️ Architecture Overview

### Tag Data Format - Understanding the Three Formats

The JenniNexus tag system handles **three different tag formats** across the codebase:

#### 1. Tag IDs (Numeric) - Used in `content_tags.json`
```json
{
  "playlist:PL9QBjNDhgNwSp0KPbZ8QqVz": {
    "tags": [39, 33, 34, 60],  // DIY, Fashion, Beauty, Fashion
    "title": "Fashion & Style Tutorials",
    "url": "/diy.php#playlist-fashion"
  }
}
```
**Why:** Compact storage, efficient for large content databases

#### 2. Tag Slugs (kebab-case) - Used for URLs and comparison
```
"diy", "fashion", "beauty", "diy-beauty", "game-dev", "unity"
```
**Why:** URL-friendly, consistent format for matching, SEO-optimized

#### 3. Tag Names (Display) - Used in UI
```
"DIY", "Fashion", "Beauty", "DIY Beauty", "Game Development", "Unity"
```
**Why:** User-friendly display in badges, filters, and cards

### How Tags Flow Through the System

1. **Storage** (`content_tags.json`): Tags stored as IDs
2. **Filtering** (`tags.php`): Converts IDs → Slugs for comparison
3. **Display** (`tags.php` cards): Converts Slugs → Names for UI
4. **URLs** (`?filters=Fashion,Beauty`): Uses Names, converted to Slugs internally

### Tag Conversion Pipeline

```
User Clicks "Fashion" Tag
  ↓
Filter URL: /tags.php?filters=Fashion,Beauty
  ↓
tags.php: "Fashion" → slug "fashion"
  ↓
Load content_tags.json: [39, 33, 34] → slugs ["diy", "fashion", "beauty"]
  ↓
Compare: ["fashion", "beauty"] ∩ ["diy", "fashion", "beauty"] = MATCH
  ↓
Display: slugs ["fashion", "beauty"] → names ["Fashion", "Beauty"]
```

---

## 🎯 Tag System Architecture (Updated Nov 1, 2025)

The JenniNexus tag system has **two filtering modes**:

### 1. Page-Level Filtering (Blog, Index)
**How it works:**
- Content loaded directly on the page via JavaScript
- Tag buttons filter visible content in real-time
- No page reload or navigation
- **Example:** `blog.php` - Tag buttons at top filter blog posts instantly

**Implementation:**
- Loads content from YAML (blog-posts.yaml) via js-yaml
- Simple array filtering: `posts.filter(post => post.tags.includes(selectedTag))`
- Self-contained, no complex state management

### 2. Site-Wide Filtering (Offcanvas Panel → /tags.php)
**How it works:**
- Offcanvas panel on index/gamedev/gaming/diy pages
- Select multiple tags from different categories
- Click "Apply Filters" → redirects to `/tags.php?filters=tag1,tag2,tag3`
- Shows all matching content across entire site (blog posts, playlists, pages)

**Implementation:**
- `tag-system.js` manages offcanvas panel state
- `tag-filter-api.js` provides central API for tag state
- `/tags.php` renders cards for matching content (blog, playlist, page cards)

---

## 🤖 TAG FILE LOCATIONS (Oct 30, 2025)

### Current Setup - Simple & Working
The tag system uses **2 JSON files** restored from archive:

**Live Files (Active & Required):**
```
public_html/resources/playlists/
├── tags.json (36 tags) ✅ ACTIVE (canonical)
└── content_tags.json (110 entries) ✅ ACTIVE (canonical)
```

**Optional Generated Files (Created by Automation Scripts):**
```
public_html/resources/playlists/
├── generated_tags.json ⚠️ OPTIONAL (auto-generated by import scripts)
└── generated_content_tags.json ⚠️ OPTIONAL (auto-generated by import scripts)
```

**Important Notes:**
- JavaScript tries to load generated files first, then falls back to canonical files
- 404 errors for generated files are **expected and harmless** if you haven't run import scripts
- The site works perfectly with just the canonical `tags.json` and `content_tags.json`
- Generated files are created by `scripts/import-youtube-tags.js` (optional automation)

**These files MUST stay in `/resources/playlists/` for the tag system to work.**

### How It Works (No Automation Required)
1. **tags.json** - Contains tag definitions (ID, name, slug, category)
2. **content_tags.json** - Maps content IDs to tags
3. **JavaScript loads these files** - All tag features load dynamically from these files
4. **No build step needed** - Changes to JSON files are immediately live

### JavaScript Dependencies
All these scripts expect tags at `/resources/playlists/`:
- `tag-system.js` - Loads tags.json on init, manages offcanvas filters
- `tag-cloud.js` - Renders tag clouds in footer/sidebars
- `tag-filter-api.js` - Centralized filter state management

### Page Integration
**Pages with working tag filters:**
- ✅ `gamedev.php` - Tag offcanvas with filter buttons
- ✅ `index.php` - Tag cloud in sidebar
- ✅ `tags.php` - Full tag index and multi-select filtering
- ✅ `tag/index.php` - Individual tag detail pages

### Why Files Were Restored
Earlier today, these files were moved to `.archive/` which broke the tag system. All JavaScript files hard-code the path `/resources/playlists/tags.json` and `/resources/playlists/content_tags.json`. The files have been copied back and the tag system is now functional.

### Optional: Automation Scripts
PowerShell scripts exist for advanced tag management but are **NOT required** for daily operation:
- `scripts/generate-playlist-tags.ps1` - Extracts tags from YAML playlist files
- `scripts/optimize-tags.ps1` - Reduces tags to top N most-used for SEO
- `scripts/fix-tag-system.ps1` - Removes duplicates, adds blog posts

**Current Recommendation:** Use the restored JSON files as-is. They work and contain accurate data. Only run automation scripts if you need to regenerate tags from YAML sources or optimize for SEO.

### Current Status (Oct 30, 2025 - Evening Update)
- **36 tags** in `tags.json` (canonical source, restored from archive)
- **110 content entries** in `content_tags.json` (restored from archive)
- **Files restored** from `.archive/` directory after they were moved there earlier
- **Location:** `public_html/resources/playlists/tags.json` and `content_tags.json`
- **JavaScript dependencies:** `tag-system.js`, `tag-cloud.js`, and `tag-filter-api.js` all expect files at this location

---

## 📂 File Locations

**Live Files (Managed by Automation):**
- `public_html/resources/playlists/tags.json` - Tag definitions (36 tags)
- `public_html/resources/playlists/content_tags.json` - Content mappings (110 entries)
- `public_html/resources/playlists/.archive/` - Timestamped backups (hidden from search)

**Source Files (Parsed by Scripts):**
- `storage/sources/gaming.yaml` - Gaming playlists with tags
- `storage/sources/diy.yaml` - DIY playlists with tags
- `storage/sources/gamedev.yaml` - Game dev playlists with tags
- `storage/sources/gamejams.yaml` - Game jam playlists with tags
- `public_html/resources/playlists/blog-posts.yaml` - Blog posts with tags

---

## 🎨 JavaScript Components

### ⚠️ IMPORTANT: Missing tag-filter-api.js

**Status:** ❌ **NOT IMPLEMENTED**  
**Reference:** `includes/footer.php` line 131 tries to load this file, but it doesn't exist  
**Impact:** Pages that call `window.tagFilter?.toggle()` will silently fail

**Expected API (from documentation):**
```javascript
window.tagFilter.init({ seedFromUrl: true });  // Initialize from URL params
window.tagFilter.toggle('gamedev');             // Toggle tag selection
window.tagFilter.setActive(['gamedev', 'diy']); // Set active tags
window.tagFilter.getActive();                   // Returns: ['gamedev', 'diy']
window.tagFilter.clear();                       // Clear all selections
window.tagFilter.onChange(callback);            // Subscribe to changes
window.tagFilter.syncToDom();                   // Update DOM elements
```

**Current Workaround:**
- **blog.php** - Uses inline filtering with `renderBlogPosts()` function and `[data-tag]` event handlers
- **Other pages** - Use `tag-system.js` internal functions (not exposed as `window.tagFilter`)

**TODO:** Either implement tag-filter-api.js OR remove all references to `window.tagFilter` from documentation

---

### 1. `tag-system.js` - Offcanvas Panel Manager (ACTIVE ✅)
**Purpose:** Manages offcanvas filter panel on index/gamedev/gaming/diy pages  
**Features:**
- Loads tags from tags.json dynamically
- Populates offcanvas tag lists by category
- "Show all tags" toggle (persisted in localStorage)
- "Apply Filters" → redirects to `/tags.php?filters=...`
- "Clear Filters" → removes all selections

**Pages Using It:**
- index.php
- gamedev.php
- gaming.php
- diy.php
- music.php

**Where Loaded:** Each page includes via `<script src="<?= RES_ROOT ?>/js/tag-system.js"></script>`

---

### 2. `tag-cloud.js` - Tag Cloud Widget (ACTIVE ✅)
**Purpose:** Renders clickable tag cloud in sidebar/panels  
**Features:**
- Loads tags.json and content_tags.json
- Calculates tag usage frequency
- Renders badges with size based on usage
- Integrates with tag-filter-api.js for state

**Where Used:**
- `includes/tag-cloud.php` (sidebar widget)
- `/tags.php` (tag index page)

**Where Loaded:** `includes/footer.php` (site-wide)

---

## 📄 Page Types Explained

### `/tags.php` - Multi-Tag Filter Page
**Purpose:** Site-wide tag filtering with tag cloud + results  
**URL Pattern:** `/tags.php?filters=tag1,tag2,tag3`

**Features:**
- Tag cloud at top (all 36 tags)
- Click tags to add/remove from filter
- Shows matching content cards:
  - Blog post cards (badge + title + excerpt + image)
  - Playlist cards (thumbnail + title + tags)
  - Page cards (title + description + tags)
- Each card shows matching tags as badges

**When to use:**
- Multi-tag filtering across site
- Discovering content by combining tags
- Offcanvas "Apply Filters" redirects here

---

### `/tags.php` - Site-Wide Tag Browser and Filter Results
**Purpose:** Browse ALL tags across the entire site and filter content by multiple tags  
**URL Patterns:**
- `/tags.php` - Shows all tags with counts
- `/tags.php?filters=Fashion,Beauty` - Shows filtered content cards

**How It Works:**

1. **Tag Display Mode** (No filters):
   - Loads `tags.json` (36 tags)
   - Loads `content_tags.json` (110 entries)
   - Calculates usage counts for each tag
   - Displays all tags as clickable badges with counts
   - Example: `Gaming (30) DIY (12) Beauty (8)`

2. **Filter Mode** (With ?filters= parameter):
   - Multi-select tags by clicking (tags turn blue when selected)
   - URL updates: `/tags.php?filters=Fashion,Beauty,DIY`
   - PHP searches `content_tags.json` for matching content
   - Displays **visual cards** for all matches:
     - **Blog Post Cards** (blue badge, "Read More" button)
     - **Playlist Cards** (red badge, "View Playlist" button)
     - **Video Cards** (red badge with YouTube icon, thumbnails)
     - **Game Cards** (game thumbnails, "Learn More" button)

**Tag Normalization System:**
```php
// Handles three tag formats: IDs, slugs, names
$tagIdToSlug = [];      // 39 => "diy"
$tagNameToSlug = [];    // "DIY" => "diy"
$tagSlugToName = [];    // "diy" => "DIY"

// Converts filter input to normalized slugs
$filterSlugs = []; // ["fashion", "beauty"]

// Converts content tag IDs to slugs
$contentSlugs = []; // [39, 33] => ["diy", "fashion"]

// Compares using slugs, displays using names
$intersect = array_intersect($filterSlugs, $contentSlugs);
```

**Card Rendering:**
- Each content type gets custom card styling
- Blog posts show title, excerpt, tags, "Read More" button
- Playlists show YouTube collection icon, tags, "View Playlist" button
- Videos show YouTube thumbnails, tags, "Watch Video" button
- All cards include tag badges that convert slugs → display names

**JavaScript Multi-Select:**
```javascript
// Clicking tags toggles selection
selectedTags.add('Fashion');
selectedTags.add('Beauty');

// Updates URL and reloads with new filters
window.location.href = '/tags.php?filters=Fashion,Beauty';
```

**Why No Separate tags.yaml Needed:**
- `/tags.php` reads directly from `tags.json` and `content_tags.json`
- These JSON files are generated by `generate-playlist-tags.ps1`
- The script reads ALL YAML files (gaming.yaml, diy.yaml, gamedev.yaml, etc.)
- No need for a separate tags.yaml - the system is already centralized

**Data Flow:**
```
gaming.yaml, diy.yaml, gamedev.yaml (YAML files)
  ↓ (generate-playlist-tags.ps1 reads all YAML files)
content_tags.json (110 entries with tag IDs)
  ↓ (tags.php loads and normalizes)
/tags.php displays cards (slugs → names for display)
```

**When to Use /tags.php:**
- Browse all available tags site-wide
- Filter content across multiple categories (Gaming + DIY + Game Dev)
- Find all content with specific tag combinations
- SEO landing pages for popular tag combinations

---

### `/tag/index.php` - Single Tag Page
**Purpose:** Browse all content for ONE specific tag  
**URL Pattern:** `/tag/index.php?slug=gamedev` or `/tag/gamedev` (pretty URL)

**Features:**
- Displays friendly tag name (e.g., "Game Development")
- Lists all content tagged with that slug
- Shows related tags at bottom
- Links to individual content items

**When to use:**
- Dedicated page for a specific tag
- SEO landing pages (e.g., /tag/gamedev for Google)
- Direct links from blog post badges

---

### `blog.php` - Blog Index with Built-In Filtering
**Purpose:** Blog post listing with instant tag filtering  
**URL:** `/blog.php`

**Why it's different:**
- Self-contained filtering (no redirect to /tags.php)
- Loads blog-posts.yaml directly via js-yaml in browser
- Tag buttons at top filter posts instantly
- Simple JavaScript: `posts.filter(p => p.tags.includes(tag))`

**Tag Buttons:**
```html
<button class="btn btn-primary" data-tag="gamedev">Game Dev</button>
<button class="btn btn-outline-primary" data-tag="diy">DIY</button>
```

**JavaScript:**
```javascript
// When tag clicked, re-render filtered posts
function renderPosts(posts, filterTag) {
  const filtered = filterTag === 'all' 
    ? posts 
    : posts.filter(post => post.tags.includes(filterTag));
  // ... render cards
}
```

---

## 🎯 Blog System Integration

**How Blog Posts Work:**

1. **Define post in** `blog-posts.yaml`:
   ```yaml
   - slug: my-post-slug
     title: "My Blog Post Title"
     date: "2025-01-15"
     category: "Game Development"
     excerpt: "Short description..."
     image: "/blog/image.jpg"  # Relative to RES_ROOT/images
     tags: ["gamedev", "unity", "tutorial"]
   ```

2. **Create PHP file** at `public_html/blog/my-post-slug.php`:
   - Copy template from existing blog post
   - Uses same metadata (title, tags, date, category)
   - Includes tag badges for filtering

3. **Auto-indexed by fix-tag-system.ps1**:
   - Reads blog-posts.yaml
   - Adds entries to content_tags.json
   - Format: `"blog:my-post-slug": {"title": "...", "url": "/blog/my-post-slug.php", "tags": [...]}`

4. **Shows up in filters:**
   - `/blog.php` - Tag filter buttons at top
   - `/tags.php?filters=gamedev,unity` - Filtered results with blog post cards
   - Individual tag pages like `/tag/index.php?slug=gamedev`

**Blog System Files:**
- `public_html/blog.php` - Main blog index (loads blog-posts.yaml via JS, renders cards)
- `public_html/blog/*.php` - Individual blog post files
- `public_html/resources/playlists/blog-posts.yaml` - Canonical source of blog metadata

---

## 🎮 YAML Files and Page-Specific Tags

### How YAML Files Drive Tag Filtering

Each major content page loads its content from a YAML file that defines playlists, tags, and metadata.

**File Structure:**
```
public_html/resources/playlists/
├── gamedev.yaml       # Game development playlists & projects
├── gaming.yaml        # Gaming content (Let's Plays, playthroughs)
├── diy.yaml          # DIY tutorials (fashion, hair, nails)
├── gamejams.yaml     # Game jam entries
└── blog-posts.yaml   # Blog posts metadata
```

---

### gamedev.yaml - Game Development Page

**Purpose:** Defines playlists, games, and projects for `/gamedev.php`

**Structure:**
```yaml
page: gamedev
title: "Game Development Showcase"

featured_section:
  playlists:
    - id: "PL9QBjNDhgNwRsznW8e3-KVmwfEuwvr7Yi"
      title: "Devlogs"
      description: "Game development logs"
      tags: ["gamedev", "devlog", "unity"]
      badge: "Featured"
    
    - id: "PL9QBjNDhgNwQYrXaiRwC0RROYmkppbssY"
      title: "Botborgs"
      tags: ["web3", "3d-modeling", "martiangames"]
      page: "/game/botborgs.php"

martian_games_playlists:
  title: "Martian Games YouTube Content"
  playlists:
    - id: "PL5RIMPpbzR6iA9rAMaDX-B2QfKMQkODwq"
      title: "Martian Games Devlogs"
      tags: ["martiangames", "devlog"]
```

**Important Tags for /gamedev:**
- `gamedev` - General game development
- `devlog` - Development logs and progress updates
- `unity`, `unreal` - Engine-specific content
- `3d-modeling` - 3D art and modeling
- `martiangames` - Martian Games collaborations (Botborgs, Purgatory Fell)
- `ludum-dare`, `game-jam` - Game jam entries
- `web3` - Blockchain/Web3 games

**How gamedev.php Uses Tags:**
1. Loads `gamedev.yaml` via youtube-grid.js
2. Extracts all unique tags from all playlists
3. Creates filter buttons automatically
4. Filters visible content when tag clicked (instant, no page reload)

---

### gaming.yaml - Gaming Content Page

**Purpose:** Defines gaming playlists (Let's Plays, playthroughs) for `/gaming.php`

**Structure:**
```yaml
page: gaming
title: "Gaming Content"

featured_section:
  playlists:
    - id: "PL6WnzXOaRqA16UY1KibrFUHu4gDZ8hmep"
      title: "Ori and the Blind Forest"
      tags: ["gaming", "platformer", "indie", "ori"]
    
    - id: "PL6WnzXOaRqA0MiE5cffmM2ZZcuSTl9DcS"
      title: "Dead Space 2 [PC] - 1st Playthrough"
      tags: ["gaming", "dead-space", "horror", "fps"]
    
    - id: "PL6WnzXOaRqA0AmWzg6b12-8O4eRifnTRC"
      title: "PS5 Playthroughs"
      tags: ["gaming", "ps5", "playthrough"]
```

**Important Tags for /gaming:**
- **Game titles as tags:** `dead-space`, `resident-evil`, `ori`, `metro-exodus`, `apex-legends`
- **Platform tags:** `ps5`, `nintendo-switch`, `pc`
- **Genre tags:** `horror`, `fps`, `platformer`, `indie`, `metroidvania`
- **Content type:** `playthrough`, `highlights`, `funny-moments`

**Why Game Titles Matter:**
Users want to filter by specific games they're interested in:
- "Show me all Dead Space content" → filter by `dead-space` tag
- "Show me all PS5 games" → filter by `ps5` tag
- "Show me horror games" → filter by `horror` tag

**How gaming.php Uses Tags:**
1. Loads `gaming.yaml` via youtube-grid.js
2. Creates filter sections:
   - **Platform Tags:** PS5, Switch, PC buttons
   - **Genre Tags:** Horror, FPS, Platformer buttons  
   - **Game Titles:** Dead Space, Resident Evil, Ori buttons
3. Users click tag → instant filter (no page reload)

---

### diy.yaml - DIY Content Page

**Purpose:** Defines DIY tutorial playlists for `/diy.php`

**Structure:**
```yaml
page: diy
title: "DIY Projects & Tutorials"

fashion_section:
  playlists:
    - id: "PLYI86hek1EWfF1TeN4oIdw2dp126OIlIc"
      title: "DIY Tutorials"
      tags: ["diy", "tutorial"]
    
    - id: "PLYI86hek1EWdEeuMYInQtfaSepBPz2yN7"
      title: "T-shirt Cutting No-Sewing"
      tags: ["diy", "fashion", "no-sew"]

hair_section:
  playlists:
    - id: "PLYI86hek1EWdw5U7AzICxzyoBir44FXKJ"
      title: "DIY Hair Ideas & Tutorials"
      tags: ["diy", "hair", "tutorial"]

nails_section:
  playlists:
    - id: "PLYI86hek1EWcoJ7X5n7ys1jzQYRCjDKnN"
      title: "DIY Gel Nails"
      tags: ["diy", "nails", "beauty"]
```

**Important Tags for /diy:**
- `diy` - All DIY content
- `fashion` - Clothing/style tutorials
- `hair` - Hair styling and coloring
- `nails`, `nail-art` - Nail tutorials
- `beauty` - Beauty and makeup
- `self-care` - Wellness content

**DIY + Blog Post Integration:**

The `/diy.php` page shows **both playlists AND related blog posts**:

1. **Load diy.yaml** - Get DIY playlists with tags
2. **Load blog-posts.yaml** - Get all blog posts
3. **Filter blog posts** - Keep only posts with DIY-related tags:
   ```javascript
   const diyTags = ['diy', 'beauty', 'fashion', 'hair', 'nails', 'nail-art', 'self-care', 'sustainability'];
   const diyBlogs = blogPosts.filter(post => 
     post.tags.some(tag => diyTags.includes(tag))
   );
   ```
4. **Render mixed content:**
   - Playlist cards (YouTube playlists)
   - Blog post cards (link to `/blog/{slug}.php`)
5. **Single filtering system:**
   - Click "Hair" tag → shows hair playlists + hair blog posts
   - Click "Fashion" tag → shows fashion playlists + fashion blog posts

**Blog Post Card on DIY Page:**
```html
<div class="card blog-post-card" data-tags="diy,beauty,hair">
  <div class="card-body">
    <span class="badge bg-info">Blog Post</span>
    <h5>DIY Beauty Trends 2025</h5>
    <p>Explore sustainable beauty techniques...</p>
    <div class="d-flex gap-1">
      <span class="badge bg-secondary">diy</span>
      <span class="badge bg-secondary">beauty</span>
    </div>
    <a href="/blog/diy-beauty-trends-2025.php" class="btn btn-primary">
      Read More
    </a>
  </div>
</div>
```

**User Flow:**
1. User visits `/diy.php`
2. Sees playlists + blog posts mixed together
3. Clicks "Beauty" filter tag
4. Page filters to show: beauty playlists + beauty blog posts
5. User clicks blog post card
6. Taken to `/blog/diy-beauty-trends-2025.php` (full blog post)
7. "Back to DIY" button at top → returns to `/diy.php`

---

### Adding Tags to YAML Files

**When adding new playlist:**

```yaml
playlists:
  - id: "NEW_PLAYLIST_ID"
    title: "My New Playlist"
    description: "Description here"
    tags: ["tag1", "tag2", "tag3"]  # ✅ Add tags array
```

**Tag Naming Best Practices:**
- Use lowercase: `gamedev` not `GameDev`
- Use hyphens for multi-word: `game-dev`, `3d-modeling`, `nail-art`
- Be specific for filtering: `dead-space` > `game`
- Check tags.json for existing tags
- Use game titles as tags: `dead-space`, `resident-evil`, `ori`

**After Adding Tags to YAML:**
```powershell
# Step 1: Re-index playlists from YAML files
cd c:\Users\Owner\Projects\www\jenninexus\scripts
.\generate-playlist-tags.ps1 -Verbose

# Step 2: Verify tags added to content_tags.json
Get-Content ..\public_html\resources\playlists\content_tags.json | Select-String "NEW_PLAYLIST_ID"

# Step 3: Test on dev server
.\dev-server.ps1
# Visit: http://localhost:8002/gaming.php (or gamedev.php, diy.php)
```

---

## ➕ Adding Tag Filtering to New Pages

### Option 1: Page-Level Filtering (Like blog.php)
**Use when:** Content is on one page, want instant filtering without redirect

**Steps:**
1. **Add tag filter buttons** to page:
```html
<div class="mb-4 d-flex gap-2">
  <button class="btn btn-primary active" data-tag="all">All</button>
  <button class="btn btn-outline-primary" data-tag="gamedev">Game Dev</button>
  <button class="btn btn-outline-primary" data-tag="diy">DIY</button>
</div>

<div id="content-container" class="row g-4">
  <!-- Content cards rendered here -->
</div>
```

2. **Load content via JavaScript:**
```javascript
async function loadContent() {
  const res = await fetch('/resources/playlists/your-content.yaml');
  const txt = await res.text();
  const items = jsyaml.load(txt);
  renderContent(items, 'all');
}

function renderContent(items, filterTag) {
  const container = document.getElementById('content-container');
  const filtered = filterTag === 'all' 
    ? items 
    : items.filter(item => item.tags && item.tags.includes(filterTag));
  
  container.innerHTML = filtered.map(item => `
    <div class="col-md-6 col-lg-4">
      <div class="card">
        <div class="card-body">
          <h5>${item.title}</h5>
          <div class="d-flex gap-1">
            ${item.tags.map(t => `<span class="badge bg-secondary">${t}</span>`).join('')}
          </div>
        </div>
      </div>
    </div>
  `).join('');
}

// Wire up buttons
document.querySelectorAll('[data-tag]').forEach(btn => {
  btn.addEventListener('click', function() {
    const tag = this.getAttribute('data-tag');
    renderContent(items, tag);
    
    // Update button states
    document.querySelectorAll('[data-tag]').forEach(b => {
      b.classList.remove('btn-primary', 'active');
      b.classList.add('btn-outline-primary');
    });
    this.classList.remove('btn-outline-primary');
    this.classList.add('btn-primary', 'active');
  });
});
```

3. **Include js-yaml:**
```html
<script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
```

---

### Option 2: Offcanvas Filter Panel (Like gamedev.php)
**Use when:** Want site-wide filtering that redirects to /tags.php

**Steps:**
1. **Add offcanvas panel** to page:
```html
<!-- Tag Filter Offcanvas -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="tagFilterOffcanvas">
  <div class="offcanvas-header">
    <h5 id="tagFilterOffcanvasLabel">Filter by Tags</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <h6 class="mb-3">Game Dev Tags</h6>
    <div id="gamedevTagsList" class="d-flex flex-wrap gap-2 mb-3"></div>
    
    <h6 class="mb-3">Gaming Tags</h6>
    <div id="gamingTagsList" class="d-flex flex-wrap gap-2 mb-3"></div>
    
    <hr>
    <div class="d-grid gap-2">
      <button id="applyFiltersBtn" class="btn btn-primary">Apply Filters</button>
      <button id="clearFiltersBtn" class="btn btn-outline-secondary">Clear Filters</button>
    </div>
  </div>
</div>

<!-- Filter Button (to open offcanvas) -->
<button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#tagFilterOffcanvas">
  <i class="fa-solid fa-filter"></i> Filter Tags
</button>
```

2. **Include tag-system.js:**
```html
<script src="<?= RES_ROOT ?>/js/tag-system.js"></script>
```

3. **Add apply/clear button handlers:**
```javascript
document.getElementById('applyFiltersBtn').addEventListener('click', function() {
  const active = window.tagFilter ? window.tagFilter.getActive() : [];
  if (active.length > 0) {
    window.location.href = '/tags.php?filters=' + active.join(',');
  } else {
    alert('Please select at least one tag');
  }
});

document.getElementById('clearFiltersBtn').addEventListener('click', function() {
  if (window.tagFilter) window.tagFilter.clear();
});
```

**That's it!** tag-system.js will populate the tag lists and manage state.

---

## 🔧 Troubleshooting

### "No content matched" on /tags.php
**Cause:** Content not indexed in content_tags.json  
**Fix:**
```powershell
# Re-index everything
.\scripts\fix-tag-system.ps1 -Verbose

# For playlists specifically
.\scripts\generate-playlist-tags.ps1 -Verbose
```

---

### Tags showing as numbers instead of names
**Cause:** content_tags.json using numeric IDs instead of slugs  
**Fix:** Ensure tags array uses slugs:
```json
{
  "blog:my-post": {
    "title": "My Post",
    "url": "/blog/my-post.php",
    "tags": ["gamedev", "diy"]  // ✅ Use slugs, not IDs
  }
}
```

---

### Offcanvas panel empty on gamedev/gaming pages
**Cause:** tag-system.js not loaded or tags.json fetch failed  
**Fix:**
1. Check browser console for errors
2. Verify `<script src="<?= RES_ROOT ?>/js/tag-system.js"></script>` present
3. Check tags.json loads: open `/resources/playlists/tags.json` in browser
4. Check RES_ROOT is defined: `<?php define('RES_ROOT', '/resources'); ?>`

---

### Blog filtering not working
**Cause:** js-yaml not loaded or blog-posts.yaml missing  
**Fix:**
1. Include js-yaml CDN: `<script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>`
2. Check blog-posts.yaml exists at `/resources/playlists/blog-posts.yaml`
3. Open browser console, check for 404 errors
4. Verify YAML format:
```yaml
- slug: my-post
  title: "My Post Title"
  tags: ["gamedev", "diy"]  # Must be array of slugs
```

---

### Tags duplicated in tags.json
**Cause:** Manual edits or script errors  
**Fix:**
```powershell
# Fix duplicates automatically
.\scripts\fix-tag-system.ps1 -Verbose

# Before:
# { "id": 39, "name": "DIY", "slug": "diy" }
# { "id": 39, "name": "DIY", "slug": "diy" }  # duplicate!

# After:
# { "id": 39, "name": "DIY", "slug": "diy" }  # ✅ Only one
```

---

### Too many unused tags
**Cause:** Tags added but no content using them  
**Fix:**
```powershell
# Analyze which tags are unused
node .\scripts\analyze-tags.cjs

# Remove unused tags (keeps top 50)
.\scripts\optimize-tags.ps1 -DryRun
.\scripts\optimize-tags.ps1
```

---

## 📊 SEO Tag Strategy

**Top tags by usage:** gaming (30), diy (15), indie (8), ludum-dare (7), fps (6), horror (6)

**How Tags Are Selected:**
1. Script analyzes `content_tags.json` for tag frequency
2. Ranks tags by usage count
3. Keeps top 50 most-used tags (configurable via `-KeepTopN` parameter)
4. Removes rarely-used tags that dilute SEO value

---

## 🎯 Automation Workflow

**Adding New Playlists:**
```powershell
# 1. Edit YAML file
# storage/sources/gaming.yaml
# Add: tags: ["gaming", "fps", "horror"]

# 2. Run automation
.\scripts\generate-playlist-tags.ps1 -Verbose
```

**Adding New Blog Posts:**
```powershell
# 1. Add entry to blog-posts.yaml
# 2. Create PHP file in public_html/blog/
# 3. Run fix script
.\scripts\fix-tag-system.ps1 -Verbose
```

**Optimizing Tags (Quarterly Recommended):**
```powershell
# Preview optimization
.\scripts\optimize-tags.ps1 -DryRun

# Apply optimization (keeps top 50 tags)
.\scripts\optimize-tags.ps1
```

**Fixing Duplicates:**
```powershell
# Removes duplicate tags, adds missing blog posts/pages
.\scripts\fix-tag-system.ps1 -Verbose
```

### Script Details

**`fix-tag-system.ps1` (NEW - Oct 30, 2025):**
- Removes duplicate tag entries (checks slug uniqueness)
- Parses blog-posts.yaml and adds all blog posts to content_tags.json
- Adds main pages (index.php, gamedev.php, diy.php, etc.) to content_tags.json
- Backs up files before modification
- Result: 36 unique tags, 110 content entries

**`generate-playlist-tags.ps1`:**
- Parses YAML line-by-line (fixed PowerShell quote escaping issues)
- Extracts playlists with `tags: [...]` defined
- Creates entries: `"playlist:PLxxxx": {"title": "...", "url": "/gaming.php#...", "tags": [...]}`
- Prevents duplicates, skips playlists without tags
- Result: Added 39 playlists (30 gaming, 12 DIY, 2 gamedev, 8 gamejams)

**`optimize-tags.ps1`:**
- Analyzes tag usage across all content
- Backs up to `.archive/tags.json.YYYYMMDD-HHMMSS`
- Keeps top N tags by usage frequency
- Result: 36 SEO-focused tags (after duplicate removal)

---

## 📚 Tag System Dependencies

### Pages That Use Tags

**Pages with Tag Filtering UI:**
- `public_html/tags.php` - Tag index with multi-select filtering (inline JS)
- `public_html/gaming.php` - Gaming content with tag offcanvas
- `public_html/gamedev.php` - Game dev content with tag offcanvas
- `public_html/diy.php` - DIY content with tag offcanvas
- `public_html/music.php` - Music content with tag filtering
- `public_html/game/gamejams.php` - Game jam collections with tags
- `public_html/tag/index.php` - Individual tag detail pages

**Adding Tags to New Content:**

1. **For Playlists in YAML:**
   ```yaml
   # storage/sources/gaming.yaml
   - id: "PLxxxxxx"
     title: "My Awesome Playlist"
     tags: ["gaming", "fps", "horror"]  # Add this line
   ```
   Then run: `.\scripts\generate-playlist-tags.ps1 -Verbose`

2. **For Game Pages:**
   Edit `public_html/resources/playlists/content_tags.json`:
   ```json
   "/game/mygame": {
     "title": "My Game Title",
     "url": "/game/mygame",
     "tags": ["gamedev", "unity", "indie"]
   }
   ```

3. **For Blog Posts:**
   Add to `content_tags.json` with format:
   ```json
   "blog:my-post-slug": {
     "title": "My Blog Post",
     "url": "/blog.php#my-post-slug",
     "tags": ["tutorial", "gamedev"]
   }
   ```

### JavaScript Files (NOT Duplicates)

**Different purposes - all required:**
1. **`tag-filter-api.js`** - Central filtering API (used globally)
2. **`tag-cloud.js`** - Renders tag clouds in footer/sidebars
3. **`tag-system.js`** - Page-specific filtering (gaming, DIY pages)

### PHP Includes

**Required includes for tag functionality:**
- `public_html/includes/tag-cloud.php` - Tag cloud component (footer)
- `public_html/includes/game-cta-helper.php` - Game tag badges
- `public_html/includes/footer.php` - Loads tag scripts globally

### Data Flow

```
YAML Files (storage/sources/*.yaml)
   ↓ (generate-playlist-tags.ps1)
content_tags.json (95 entries)
   ↓ (optimize-tags.ps1)
tags.json (41 optimized tags)
   ↓ (loaded by pages)
Tag UI (offcanvas, badges, filters)
```

---

## 🔧 TAG PAGES FIX (Oct 30, 2025)

### Problem Fixed
Tag pages were showing "No content found" even though content existed.

**Root Cause:** Playlists used tag slugs in YAML, but `content_tags.json` only had numeric IDs.

**Solution:** 
- Updated `content_tags.json` with slug-based tags
- Updated `tag/index.php` to handle both slug and numeric formats
- Automated playlist extraction via `generate-playlist-tags.ps1`

**Result:** Tag pages now display playlists, game pages, and blog posts correctly.

---
```javascript
// Run this in Node.js to find unused tags
const tags = require('./public_html/resources/playlists/tags.json');
const contentTags = require('./public_html/resources/playlists/content_tags.json');

const allTags = new Set(tags.map(t => t.slug));
const usedTags = new Set();

// Collect used tags from content_tags.json
Object.values(contentTags).forEach(item => {
  if (Array.isArray(item)) {
    // Numeric format: [1, 11, 17]
    item.forEach(id => {
      const tag = tags.find(t => t.id === id);
      if (tag) usedTags.add(tag.slug);
    });
  } else if (item.tags) {
    // Slug format: { tags: ["vr", "unity"] }
    item.tags.forEach(slug => usedTags.add(slug));
  }
});

// Find unused tags
const unusedTags = [...allTags].filter(slug => !usedTags.has(slug));
console.log('Unused tags:', unusedTags);
```

### Post-Cleanup Validation

**After cleanup (Option A or B):**

1. **Run tag analysis:**
   ```bash
   node scripts/analyze-tags.cjs
   ```
   Expected: 0 unused tags reported

2. **Test tag index:**
   - Visit: http://localhost:8002/tags
   - Click every tag badge
   - Verify each tag shows at least 1 content item
   - Confirm no "No content matched" errors

3. **Test tag filtering:**
   - Visit main pages (gamedev, gaming, diy)
   - Open tag filter offcanvas
   - Click multiple tags to test OR logic
   - Verify correct content filtering

4. **Verify tag badges:**
   - Visit game pages: /game/purgatoryfell, /game/botborgs
   - Click tag badges to verify filter integration
   - Confirm active state toggle works

### Preventing Future "No Content Matched" Errors

**Best Practices:**

1. **Before adding a new tag to tags.json:**
   - Add content that uses the tag FIRST
   - Update content_tags.json with the mapping
   - THEN add the tag definition to tags.json
   - Test the tag page immediately

2. **Use validation script regularly:**
   ```bash
   node scripts/analyze-tags.cjs
   ```

3. **Consider auto-hide for zero-count tags:**
   - Modify tags.php to check content_tags.json before rendering
   - Only show tags that have at least 1 content item
   - Add "Show all tags" toggle for admin/debug

4. **Document tag management workflow:**
   - Update this file with tag addition process
   - Create checklist for new tags
   - Set up automated validation in CI/CD

### Tag File Duplication Check — RESOLVED ✅

**Audit Date:** October 30, 2025

**Known Tag Files:**
```
CANONICAL SOURCE (Production - Use These):
✅ public_html/resources/playlists/tags.json (115 tags) - IDENTICAL to src/assets/
✅ public_html/resources/playlists/content_tags.json - UPDATED with slug-based game tags

DEVELOPMENT DUPLICATES (OUTDATED):
⚠️ src/assets/tags.json - IDENTICAL to public_html (hash: 545B8BB3ABAA047F74556ECF0D63F2F8BA01E86C7C592D1DEF101DCFDC095DFF)
❌ src/assets/content_tags.json - OUTDATED (missing slug-based game page tags added Oct 30)

BUILD PROCESS:
✅ No automated sync found in build-all.ps1
✅ No Copy-Item operations for tag files detected
```

**Decision: Single Source of Truth**
- **CANONICAL:** `public_html/resources/playlists/` is the ONLY active source
- **REASONING:** Build scripts do NOT sync src/assets/ to public_html/
- **ACTION:** Keep src/assets/ files for historical reference, but do NOT edit them
- **RECOMMENDATION:** Delete src/assets/tags.json and src/assets/content_tags.json OR add sync to build script

**To Sync src/assets/ (if needed):**
```powershell
# Copy canonical versions to src/assets/ (one-way sync)
Copy-Item "C:\Users\Owner\Projects\www\jenninexus\public_html\resources\playlists\tags.json" "C:\Users\Owner\Projects\www\jenninexus\src\assets\tags.json" -Force
Copy-Item "C:\Users\Owner\Projects\www\jenninexus\public_html\resources\playlists\content_tags.json" "C:\Users\Owner\Projects\www\jenninexus\src\assets\content_tags.json" -Force
```

**Verified Changes (Oct 30):**
- ✅ `public_html/resources/playlists/content_tags.json` contains slug-based game tags
- ✅ `/game/purgatoryfell` entry: `"tags": ["vr", "horror", "unity", "indie", "gamedev", "3d"]`
- ✅ All game pages now use slug format instead of numeric IDs
- ✅ Tag pages (/tag/vr) now display game content correctly

---

## 🚨 KNOWN ISSUES & IMPROVEMENT PLAN (Oct 30, 2025)

### Issue 1: "No Content Matched Those Tags" on Filtered Pages

**Symptom:** When filtering tags on `/tags.php?filters=...`, page shows text list but no visual content previews (cards/thumbnails)

**Root Cause:**
- `content_tags.json` only maps ~60 content items (blog posts, game pages, some videos)
- **Playlists (30+ gaming, 20+ DIY) are NOT in content_tags.json** - they only exist in YAML configs
- `tags.php` filtered view only shows simple list items, not visual cards
- Result: Most tag combinations show "No content matched" even though playlists exist with those tags

**Example Problem:**
- User filters by "3D Modeling, Console, Hair, Fashion, Steam Games" on `/tags.php`
- Expected: See gaming playlists, DIY videos, blog posts with those tags
- Actual: "No content matched those tags" (even though 20+ playlists have these tags)

**Solution Plan:**
1. ✅ **Add visual content cards to tags.php filtered view** (game cards, blog cards, video thumbnails)
2. ✅ **Expand content_tags.json to include playlist references** 
   - Format: `"playlist:PL123": {"title": "Dead Space 2", "url": "/gaming#playlist-PL123", "tags": ["horror", "fps"]}`
3. ⏳ **Add video count to each tag** so users know what to expect

---

### Issue 2: Cross-Page Tag Navigation

**Symptom:** User on `/gamedev` opens tag filter offcanvas, selects tags that exist but not on gamedev page (e.g., "Hair", "Fashion"), clicks Apply Filters → shows "No results"

**Root Cause:**
- Tag offcanvas shows ALL 115 tags regardless of current page
- Filter applies client-side only (filters `.content-item` elements on current page)
- No redirect to `/tags.php` when selected tags don't exist on current page

**Example Problem:**
- User on `/gamedev` page
- Opens tag offcanvas, sees "Show all tags" toggle, selects "Hair" + "Fashion"
- Clicks "Apply Filters"
- Expected: Redirect to `/tags.php?filters=hair,fashion` to see matching DIY content
- Actual: Page shows "No results" because gamedev page has no hair/fashion content

**Solution Plan:**
1. ✅ **Detect when filtered tags have zero matches on current page**
2. ✅ **Auto-redirect to `/tags.php?filters=...` with selected tags**
3. ⏳ **Add "View all results" button** as alternative to auto-redirect

---

### Issue 3: Playlist Tags Not Indexed

**Symptom:** Gaming page has 30 playlists with tags, but tag pages don't show them

**Root Cause:**
- Playlists defined in `gaming.yaml`, `gamedev.yaml`, `diy.yaml` with tags
- `youtube-grid.js` reads YAML, renders playlists with `data-tags` attributes
- BUT: `content_tags.json` doesn't include playlist entries
- Result: `tag/index.php` can't find playlists when searching content_tags.json

**Example:**
```yaml
# gaming.yaml
- id: "PL6WnzXOaRqA0MiE5cffmM2ZZcuSTl9DcS"
  title: "Dead Space 2"
  tags: ["gaming", "horror", "fps", "survival"]
```
- This playlist is tagged, but NOT in `content_tags.json`
- Visiting `/tag/horror` won't show "Dead Space 2" playlist

**Solution Plan:**
1. ✅ **Add playlist entries to content_tags.json** during build or manually
2. ⏳ **Create build script** to auto-generate playlist entries from YAML files
3. ⏳ **Add "View on Gaming Page" links** for playlist results on tag pages

---

### Issue 4: Tag Count Accuracy

**Symptom:** Tag index shows `(0)` count for tags that DO have content

**Root Cause:**
- Tag count logic in `tags.php` only counts entries in `content_tags.json`
- Playlists and dynamically-rendered content not counted
- Result: Tags like "horror" show `(0)` even though 5 horror game playlists exist

**Solution Plan:**
1. ✅ **Update tag count calculation** to include playlists from YAML
2. ⏳ **Cache tag counts** in generated JSON file for performance
3. ⏳ **Show "0 results" tags as disabled/grayed** in tag offcanvas

---

## 🎯 TAG SYSTEM ARCHITECTURE

### Single Source of Truth: `tags.json`

**⚠️ IMPORTANT: To add, edit, or remove tags, ONLY modify:**
```
public_html/resources/playlists/tags.json
```

**All tags are loaded dynamically** — tag-system.js fetches tags.json on page load.
No need to rebuild or update JavaScript when tags change!

**Tag Database:** 115 tags total (updated Oct 28, 2025)

**Tag Categories:**
- `gamedev` (37 tags) - Game development tools, engines, specific games
- `gaming` (30 tags) - Gaming genres, platforms, gameplay types  
- `diy` (20 tags) - DIY projects, beauty, fashion, self-care
- `voice-acting` (3 tags) - Voice acting and voice-over work
- `art` (2 tags) - Digital art and creative tools
- `meta` (11 tags) - Site navigation, content organization, social
- `multi-category` (12 tags) - Tags spanning multiple content areas

### Data Flow Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                  TAG SYSTEM UNIFIED FLOW (v3.0)                  │
└─────────────────────────────────────────────────────────────────┘

1. CANONICAL SOURCE
   tags.json (115 tags)
        ↓
2. DYNAMIC LOADING
   tag-system.js → fetch(tags.json) on init
        ↓
3. CONTENT MAPPINGS
   ├─→ content_tags.json (content ID → tag IDs)
   └─→ playlist-ids.json (games → tag slugs)
        ↓
4. SERVER-SIDE RENDERING
   ├─→ game-cta-helper.php (reads playlist-ids.json tags)
   └─→ includes/tag-cloud.php
        ↓
5. CLIENT-SIDE SCRIPTS
   ├─→ youtube-grid.js (canonicalizes YAML tags → slugs)
   ├─→ tag-system.js (filters, badges, offcanvas)
   ├─→ tag-filter-api.js (centralized filter state)
   └─→ tag-cloud.js (tag index visualization)
        ↓
6. PAGE RENDERING
   ├─→ data-tags attributes on .content-item elements
   ├─→ window.__usedTagSlugs exposed for filtering
   └─→ Tag filtering UI (offcanvas, active filters)
        ↓
7. TAG PAGES
   ├─→ tags.php (tag index/listing)
   └─→ tag/index.php (individual tag detail pages)
```

---

## 📊 Tag System Flow (UNIFIED)

### Complete User Interaction Flow: Badge Click → Filter → Results

```
┌─────────────────────────────────────────────────────────────────┐
│        USER CLICKS TAG BADGE → CONTENT FILTERS → RESULTS        │
└─────────────────────────────────────────────────────────────────┘

USER ACTION:
  User clicks tag badge (e.g., "VR" badge on purgatoryfell.php)
        ↓
BADGE CLICK HANDLER:
  ├─→ game-cta-helper.php renders: <span class="badge" data-tag="vr">VR</span>
  ├─→ tag-system.js listens for click on [data-tag] badges
  └─→ Click triggers: addActiveTag('vr')
        ↓
TAG FILTER API:
  ├─→ tag-filter-api.js updates active tag set: activeTags.add('vr')
  ├─→ Dispatches custom event: 'tagFilter:changed'
  └─→ Updates URL query: ?tags=vr (optional, for bookmarking)
        ↓
FILTER EXECUTION:
  ├─→ tag-system.js.filterContent() executes
  ├─→ Queries all elements: document.querySelectorAll('.content-item[data-tags]')
  ├─→ For each item:
  │   ├─→ Parse data-tags: "vr,gamedev,unity,devlog"
  │   ├─→ Check if ANY active tag matches (OR logic)
  │   └─→ Show if match, hide if no match
  └─→ Animation: fadeOut non-matching, fadeIn matching
        ↓
UI UPDATE:
  ├─→ Active filters container shows: [VR ✕] badge
  ├─→ Offcanvas "VR" badge highlights as active
  ├─→ Content grid re-renders with only matching items
  └─→ "No results" message if zero matches
        ↓
RESULT:
  User sees only content tagged with "vr"
  Can click [✕] to remove filter or click another tag to add
```

### Tag Badge Sources on Pages

| Source | Example | Renders To |
|--------|---------|------------|
| **game-cta-helper.php** | `renderGameTags('purgatoryfell')` | `<span class="badge" data-tag="vr">VR</span>` |
| **youtube-grid.js** | Playlist card tags from YAML | `<span class="badge" data-tag="unity">Unity</span>` |
| **tag-cloud.php** | Tag index page | `<a href="/tag/vr" class="badge">VR</a>` |
| **Manual HTML** | Custom page badges | `<span class="badge" data-tag="gamedev">Game Dev</span>` |

### Filter Logic (OR Mode)

```javascript
// tag-system.js filterContent() — OR logic example
function filterContent() {
  const activeTags = getActiveTags(); // ['vr', 'unity']
  const items = document.querySelectorAll('.content-item[data-tags]');
  
  items.forEach(item => {
    const itemTags = item.dataset.tags.split(',').map(t => t.trim());
    // Show if ANY active tag matches
    const matches = activeTags.some(tag => itemTags.includes(tag));
    
    if (matches || activeTags.length === 0) {
      item.style.display = ''; // Show
    } else {
      item.style.display = 'none'; // Hide
    }
  });
}
```

### Testing the Flow

**To test badge click → filter workflow:**

1. **Open page:** http://localhost:8002/game/purgatoryfell.php
2. **Click tag badge:** Click "VR" badge near hero section
3. **Observe:**
   - Active filter appears: `[VR ✕]`
   - Content filters (if other `.content-item` elements exist)
   - URL updates: `?tags=vr` (if implemented)
4. **Click another tag:** E.g., "Unity" badge
5. **Observe:**
   - Both tags active: `[VR ✕] [Unity ✕]`
   - OR logic: shows items with VR *or* Unity
6. **Clear filters:** Click `[✕]` on active badge or "Clear" button
7. **Observe:** All content returns

**No rebuild needed** — just refresh browser at http://localhost:8002

---

---

## 📊 Tag Database

### Total Tags: **36 tags** (current as of Oct 30, 2025 evening)

| Category | Count | Purpose |
|----------|-------|---------|
| **gamedev** | 37 | Game development tools, engines, specific games (IDs 118-136) |
| **gaming** | 30 | Gaming genres, platforms, gameplay types |
| **diy** | 20 | DIY projects, beauty, fashion, self-care |
| **voice-acting** | 3 | Voice acting and voice-over work |
| **art** | 2 | Digital art and creative tools |
| **meta** | 11 | Site navigation, content organization, social |
| **multi-category** | 12 | Tags spanning multiple content areas |

### Game-Specific Tags (Added Oct 28, 2025)

| ID | Name | Slug | Categories |
|----|------|------|------------|
| 118 | Purgatory Fell | `purgatory-fell` | gamedev, vr, indie |
| 119 | Jenni Styles | `jenni-styles` | gamedev, indie, fashion |
| 120 | Dress Up | `dress-up` | gaming, gamedev |
| 121 | Cat as Trophy | `cat-as-trophy` | gamedev, indie, platformer |
| 122 | Platformer | `platformer` | gaming, gamedev |
| 123 | Botborgs | `botborgs` | gamedev, indie, robot |
| 124 | Robot | `robot` | gamedev, gaming |
| 125 | Blue Balls | `blue-balls` | gamedev, indie, puzzle |
| 126 | Puzzle | `puzzle` | gaming, gamedev |
| 127 | Cleanup in Aisle 3 | `cleanup-in-aisle-3` | gamedev, indie, arcade |
| 128 | Arcade | `arcade` | gaming, retro |
| 129 | Cow Defender | `cow-defender` | gamedev, indie, rescue |
| 130 | Tower Defense | `tower-defense` | gaming, strategy |
| 131 | Graveyard Smashers | `graveyard-smashers` | gamedev, indie, action |
| 132 | Action | `action` | gaming |
| 133 | Mom's House Quest | `moms-house-quest` | gamedev, indie, adventure, funny |
| 134 | Funny | `funny` | gaming |
| 135 | Soccer Cows | `soccer-cows` | gamedev, indie, sports, martiangames |
| 136 | Sports | `sports` | gaming |

---

## 📁 Complete File Dependencies

### Core Tag System Files
```
public_html/resources/js/tag-system.js          — Main tag UI & filtering logic
public_html/resources/js/tag-cloud.js           — Tag cloud rendering UI
public_html/resources/js/tag-filter-api.js      — Tag filtering API layer
public_html/includes/tag-cloud.php              — Server-side tag cloud include
```

### Data Files (Canonical Sources)
```
public_html/resources/playlists/tags.json           — ✅ Canonical tag definitions (136 tags, updated Oct 28)
public_html/resources/playlists/content_tags.json   — Content → tag ID mappings
public_html/resources/playlists/playlist-ids.json   — Playlist master + game tags (uses slugs)
public_html/resources/playlists/social-stats.json   — Social metrics
```

### Page Configuration Files
```
public_html/resources/playlists/gamedev.yaml        — Game dev content config (references tag slugs)
public_html/resources/playlists/gaming.yaml         — Gaming content config  
public_html/resources/playlists/gamejams.yaml       — Game jam collections
public_html/resources/playlists/diy.yaml            — DIY content config
public_html/resources/playlists/blog-posts.yaml     — Blog posts config
```

### Server-Side Tag Integration
```
public_html/includes/game-cta-helper.php            — Reads playlist-ids.json → renders tag badges
  ├─→ getGamePlaylistData($gameSlug)
  ├─→ renderGameCTA($gameSlug, $options)
  ├─→ getGameTags($gameSlug)
  └─→ renderGameTags($gameSlug)
```

### Tag Pages & Endpoints
```
public_html/tags.php                — Tag listing/index page
public_html/tag/index.php           — Individual tag detail pages
public_html/tag/tag.yaml            — Per-tag configuration
```

### Content Loaders (Use Tag Data)
```
public_html/resources/js/youtube-grid.js            — Main grid renderer (adds data-tags)
public_html/resources/js/youtube-playlist-loader.js — Playlist loader
public_html/resources/js/gaming-playlists.js        — Gaming page loader
public_html/resources/js/diy-playlists.js           — DIY page loader
public_html/resources/js/martian-games.js           — Martian Games loader
public_html/resources/js/gamedev-playlists.js       — Gamedev loader (to be created)
```

### Tag System Flow Diagram
```
┌─────────────────────────────────────────────────────────────────┐
│                     TAG SYSTEM DATA FLOW                         │
└─────────────────────────────────────────────────────────────────┘

1. CANONICAL SOURCE
   └─→ tags.json (136 tags, 7 categories)
       ├─→ Game-specific tags (purgatory-fell, botborgs, etc.)
       ├─→ Genre tags (platformer, tower-defense, etc.)
       └─→ Base category tags (gamedev, gaming, etc.)

2. DATA INTEGRATION
   ├─→ content_tags.json (maps content ID → tag IDs)
   └─→ playlist-ids.json (maps game slug → tag slugs in games section)

3. SERVER-SIDE RENDERING
   ├─→ game-cta-helper.php
   │   ├─→ Reads playlist-ids.json
   │   └─→ Renders tag badges from game tags array
   └─→ includes/tag-cloud.php

4. CLIENT-SIDE RENDERING
   └─→ youtube-grid.js
       ├─→ Reads YAML configs (gamedev.yaml, gaming.yaml, etc.)
       ├─→ Canonicalizes freeform tags against tags.json
       ├─→ Adds data-tags attributes to rendered content
       └─→ Exposes window.__usedTagSlugs

3. TAG UI INITIALIZATION
   └─→ tag-system.js
       ├─→ Uses embedded TAGS array (synced from tags.json)
       ├─→ Populates offcanvas with tag badges  
       ├─→ Listens for tag clicks
       ├─→ Manages active filter state (via tag-filter-api.js)
       └─→ Shows only used tags by default (reads window.__usedTagSlugs)

4. CONTENT FILTERING
   └─→ tag-system.js filterContent()
       ├─→ Reads active filters from tag-filter-api
       ├─→ Finds all .content-item elements
       ├─→ Checks data-tags attributes
       └─→ Shows/hides items matching active filters (OR logic)

5. TAG PAGES
   ├─→ tags.php (tag index/listing)
   └─→ tag/index.php (individual tag detail pages)
       └─→ Uses content_tags.json to find related content

4. CONTENT FILTERING
   └─→ tag-system.js filterContent()
       ├─→ Reads activeFilters set
       ├─→ Queries all .content-item[data-tags]
       ├─→ Shows/hides content based on OR matching
       └─→ Updates active filters display

5. TAG PAGES
   └─→ tags.php + tag/index.php
       ├─→ Reads content_tags.json
       ├─→ Displays tag index and detail pages
       └─→ Links back to content with tags
```

---

## 📋 Current Implementation Status

### ✅ IMPLEMENTED

1. **Tag System JavaScript** (`resources/js/tag-system.js`)
   - ✅ Full tag database with 96 tags across 7 categories
   - ✅ Tag badge creation and rendering
   - ✅ Active filter management
   - ✅ Click handlers for tag filtering
   - ✅ Filter state persistence
   - ✅ Tag categories: gamedev, gaming, diy, voice-acting, art, meta, multi-category
   - ✅ Content filtering logic (filterContent())
   - ✅ Integration with youtube-grid.js for data-tags

2. **Tag Data Files**
   - ✅ `tags.json` - 96 canonical tag definitions
   - ✅ `content_tags.json` - Content to tag mappings
   - ✅ `playlist-ids.json` - Playlist master list
   - ✅ Tag categories properly structured

3. **Gaming Page** (`gaming.php`)
   - ✅ Tag filter offcanvas sidebar
   - ✅ Index-style Content Categories UI added (platform badges + featured games)
   - ✅ Container for gaming tags: `#gamingTagsList`
   - ✅ Apply filters button
   - ✅ Script inclusion: `tag-system.js` loaded
   - ✅ `data-tags` present on featured game/project cards and playlist containers
   - **STATUS:** Fully functional for gaming tags — filtering and tag navigation available

4. **Gamedev Page** (`gamedev.php`)
   - ✅ Index-style Content Categories UI and featured game cards added
   - ✅ `data-tags` present on playlists and project cards
   - ⚠️ Tag filter offcanvas may need verification
   - **STATUS:** Partial - needs tag UI verification

5. **DIY Page** (`diy.php`)
   - ✅ Hero/logo updated to `DIY w/ Jenni`
   - ✅ Category cards include `data-tags`/`data-category`
   - ✅ Playlists container includes tag data
   - ⚠️ Tag filter offcanvas may need verification
   - **STATUS:** Partial - needs tag UI verification

6. **Other Pages**
   - ✅ `links.php` - Key link cards include `data-tags`
   - ⚠️ `index.php` - Script loaded but missing tag filter UI
   - ⚠️ `martiangames.php` - Needs audit
   - ⚠️ `blog.php` - Needs audit
   - ⚠️ Individual game pages (`/game/*.php`) - Need audit

---

## ⚠️ NEEDS VERIFICATION/COMPLETION

1. **Index Page** (`index.php`)
   - ⚠️ Missing: Tag filter offcanvas
   - ⚠️ Missing: Tag list containers (`#gamedevTagsList`, `#diyTagsList`, etc.)
   - ⚠️ Missing: Active filters display
   - ⚠️ Missing: Apply/clear filters buttons
   - ✅ Script is loaded

2. **Tag Pages** (`tags.php`, `tag/index.php`)
   - ✅ Files exist
   - ⚠️ Need verification that they work correctly
   - ⚠️ Need verification of content_tags.json integration

3. **Content Filtering Across All Pages**
   - ✅ `filterContent()` implemented in tag-system.js
   - ✅ `youtube-grid.js` adds data-tags to content items
   - ⚠️ Need to verify all major pages have proper `.content-item` markup
   - ⚠️ Need to test filtering on each page

4. **Game Playlist Mapping**
   - ⚠️ `game-playlist-map.json` needs to be created
   - ⚠️ Individual game pages need playlist CTAs

5. **Used Tags Filtering**
   - ✅ `youtube-grid.js` exposes `window.__usedTagSlugs`
   - ⚠️ Tag system needs to implement "show only used tags" feature
   - ⚠️ Need "Show all tags" toggle in offcanvas

---

## 📊 Tag Database

### Categories & Tag Counts

| Category | Tag Count | Example Tags |
|----------|-----------|--------------|
| **gamedev** | 18 tags | Unity, Unreal, Blender, VR, Game Jam, Devlog, MartianGames |
| **gaming** | 22 tags | FPS, RPG, Adventure, Battle Royale, Retro, Steam Games |
| **diy** | 20 tags | Fashion, Nails, Hair, Makeup, Crafts, Self-Care, DIY Beauty |
| **voice-acting** | 2 tags | Voice Acting, Voice Over |
| **art** | 2 tags | Digital Art, Photoshop |
| **meta** | 11 tags | Blog, Patreon, Featured, Community, Social Media |
| **multi-category** | 21 tags | Tutorial, VR, AR, Cosplay, Live Streaming, Discord |

**Total Tags:** 96 unique tags

### Tag Categories Explained

- **gamedev** - Game development, tools, engines, techniques
- **gaming** - Gaming platforms, genres, gameplay types
- **diy** - DIY projects, beauty, fashion, self-care
- **voice-acting** - Voice acting and voice-over work
- **art** - Digital art and creative tools
- **meta** - Site navigation, content organization, social
- **multi-category** - Tags that span multiple content areas

---

## 🔧 Tag System Architecture

### File: `resources/js/tag-system.js`

```javascript
// Tag data structure
const TAGS = [
  {
    id: 1,
    name: "Unity",
    slug: "unity",
    category: "gamedev"
  },
  // ... 52 more tags
];

// Main functions
initTagSystem()           // Initialize on page load
populateTagLists()        // Render tags in containers
createTagBadge(tag)       // Create clickable tag badge
toggleTagFilter(tag)      // Add/remove tag from active filters
updateActiveFiltersDisplay()  // Show active filter badges
filterContent()           // Filter content (needs to call shared applyFiltersToPage)
initContentFilter()       // Category filter buttons (index page) — scoped to #content
```

## 🧭 File dependencies & RES_ROOT

The tag system and related UI expect a consistent resource root so client-side scripts can fetch JSON/YAML assets regardless of the current page path. The site exposes a global JavaScript variable `window.RES_ROOT` (set from PHP's `RES_ROOT`) and all tag-related clients should use that when building URLs.

Examples:

- Fetch tags JSON: `fetch(window.RES_ROOT + '/playlists/tags.json')`
- Fetch content tags: `fetch(window.RES_ROOT + '/playlists/content_tags.json')`
- Fetch playlist YAMLs: `fetch(window.RES_ROOT + '/playlists/gamedev.yaml')`

Ensure the following files are present and deployed under `public_html/resources` (or the configured `RES_ROOT`) so the tag system works:

- resources/js/tag-system.js  — main tag UI & filtering API
- resources/js/tag-cloud.js   — tag cloud UI (used on tags index)
- resources/js/tag-cloud.php  — server include that mounts tag cloud container (note: this is an include, file is `includes/tag-cloud.php`)
- resources/playlists/tags.json
- resources/playlists/content_tags.json
- resources/playlists/generated_tags.json (optional)
- resources/playlists/generated_content_tags.json (optional)
- resources/playlists/*.yaml  (page-specific playlist configs like `diy.yaml`, `gamedev.yaml`, `blog-posts.yaml`)

Notes:

- Pages must set `window.RES_ROOT` (usually via `<?= RES_ROOT ?>` in a template) before tag scripts run. The project header includes this by default in `includes/head.php` which prints a small inline script that sets `window.RES_ROOT`.
- Client scripts prefer generated JSON (if present) but fall back to canonical files (`tags.json`, `content_tags.json`).
- When authoring playlist or page YAML files, include a `tags:` array on playlist entries to allow `youtube-grid.js` and `diy-playlists.js` to attach `data-tags` to rendered cards.


### Required HTML Elements

For tag system to work, page needs:

```html
<!-- Tag Filter Offcanvas -->
<div class="offcanvas offcanvas-end" id="tagFilterOffcanvas">
  <div class="offcanvas-header">
    <h5 id="tagFilterOffcanvasLabel">Filter by Tags</h5>
    <button class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <!-- Tag containers per category -->
    <h6>Game Dev Tags</h6>
    <div id="gamedevTagsList"></div>
    
    <h6>Gaming Tags</h6>
    <div id="gamingTagsList"></div>
    
    <h6>DIY Tags</h6>
    <div id="diyTagsList"></div>
    
    <h6>Voice Acting Tags</h6>
    <div id="voiceTagsList"></div>
    
    <!-- Filter controls -->
    <button id="applyFilters" class="btn btn-primary">Apply Filters</button>
    <button id="clearFilters" class="btn btn-outline-secondary">Clear</button>
  </div>
</div>

<!-- Active Filters Display -->
<div id="activeFiltersContainer" style="display: none;">
  <div id="activeFilters"></div>
</div>

<!-- Content items with data-tags attributes -->
<div class="content-item" data-category="gamedev" data-tags="unity,vr,devlog">
  <!-- Content -->
</div>
```

---

## 🚀 Recommendations

### 1. Complete Index Page Implementation

Add tag filter UI to `index.php`:

```php
<!-- After hero section, before content sections -->
<section class="py-3 bg-light">
  <div class="container">
    <div class="row align-items-center">
      <div class="col">
        <button class="btn btn-outline-primary" data-bs-toggle="offcanvas" data-bs-target="#tagFilterOffcanvas">
          <i class="bi bi-filter"></i> Filter by Tags
        </button>
      </div>
      <div class="col-auto">
        <div id="activeFiltersContainer" style="display: none;">
          <div id="activeFilters" class="d-flex gap-2"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Tag Filter Offcanvas (add before footer) -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="tagFilterOffcanvas">
  <!-- (Structure from above) -->
</div>
```

### 2. Add Tag Attributes to Content

Add `data-tags` attributes to content cards:

```php
<!-- Example: YouTube playlist section -->
<div class="content-item" 
     data-category="gamedev" 
     data-tags="unity,devlog,game-dev">
  <!-- Playlist content -->
</div>
```

### 3. Implement Content Filtering

Update `filterContent()` in `tag-system.js`:

```javascript
function filterContent() {
  const contentItems = document.querySelectorAll('.content-item');
  
  if (activeFilters.size === 0) {
    // Show all content
    contentItems.forEach(item => item.style.display = '');
    return;
  }
  
  contentItems.forEach(item => {
    const itemTags = (item.dataset.tags || '').split(',');
    const hasMatchingTag = itemTags.some(tag => activeFilters.has(tag.trim()));
    
    item.style.display = hasMatchingTag ? '' : 'none';
  });
}
```

### 4. Add Tag Filters to Other Pages

Consider adding tag filters to:
- ✅ `gaming.php` (already has gaming tags)
- 🔜 `gamedev.php` (add gamedev tags)
- 🔜 `diy.php` (add diy tags)
- 🔜 `services.php` (add voice-acting tags)

---

## 🎨 Tag System Features

### Working Features ✅

1. **Tag Badge Rendering** - Tags display as clickable badges
2. **Active State Management** - Selected tags highlight
3. **Multiple Filter Support** - Can select multiple tags at once
4. **Filter Clearing** - Can remove individual tags or clear all
5. **Category Organization** - Tags grouped by category
6. **State Persistence** - Filter state maintained during session

### Missing / Next Improvements ❌

1. **Tag Counts** - No display of how many items per tag (useful UX improvement)
2. **URL Parameters** - Can't share filtered views via URL (nice-to-have)
3. **Search Integration** - No text search + tag filtering combo
4. **Animation** - Consider smooth transitions when filtering
5. **Accessibility** - Improve keyboard focus order and announce filtered results for screen readers
6. **Analytics** - Optionally track tag usage to surface popular tags

---

## 📝 Usage Example (Gaming Page)

**Current Working Implementation:**

```php
<!-- gaming.php -->

<!-- Filter Button -->
<button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#tagFilterOffcanvas">
  <i class="bi bi-filter"></i> Filter Gaming Content
</button>

<!-- Tag Filter Offcanvas -->
<div class="offcanvas offcanvas-end" id="tagFilterOffcanvas">
  <div class="offcanvas-header">
    <h5>Filter by Tags</h5>
    <button class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <h6 class="mb-3">Gaming Tags</h6>
    <div id="gamingTagsList" class="d-flex flex-wrap gap-2 mb-4">
      <!-- Tags auto-populated by tag-system.js -->
    </div>
    <button id="applyFilters" class="btn btn-primary" data-bs-dismiss="offcanvas">
      Apply Filters
    </button>
  </div>
</div>

<!-- Include script -->
<?php include 'includes/footer.php'; ?>
<!-- footer.php includes tag-system.js -->
```

**User Flow:**
1. User clicks "Filter Gaming Content" button
2. Offcanvas slides in from right
3. Gaming tags display as badges
4. User clicks tags to select/deselect
5. Selected tags highlight in primary color
6. User clicks "Apply Filters"
7. Offcanvas closes
8. **Currently:** Console logs active filters
9. **Should:** Hide non-matching content

---

## 🔍 Verification Checklist

### Deploy Verification

When deploying, verify:

- ✅ `tag-system.js` exists in `deploy/resources/js/`
- ✅ `gaming.php` includes tag filter offcanvas
- ✅ Footer includes `tag-system.js` script tag
- ✅ Bootstrap 5.3.3+ loaded (offcanvas requires Bootstrap JS)
- ✅ Tag data matches current content categories

### Browser Testing

Test in browser:

1. Open `https://jenninexus.com/gaming`
2. Click filter button → Offcanvas opens ✅
3. See gaming tags displayed ✅
4. Click tag → Badge highlights ✅
5. Check console → Logs active filters ✅
6. **Known Status:** Content filtering now active ✅ (playlist cards and content items with `data-tags` will be filtered)

---

## 📞 Quick Reference

| Question | Answer |
|----------|--------|
| **Is tag system deployed?** | ✅ Yes - JS file deployed to production |
| **Does it work?** | ✅ Yes - UI and filtering are working for pages that include `data-tags` and the tag system scripts |
| **Which pages use it?** | Only `gaming.php` has full UI |
| **How to add to new page?** | Add offcanvas + tag containers + script inclusion |
| **Are tags up to date?** | ✅ Yes - 53 tags across 4 categories |
| **Can users filter content?** | ❌ No - filterContent() not implemented |

---

## 🛠️ Next Steps

### Priority 1: Complete Content Filtering

1. Add `data-tags` attributes to all content items
2. Implement `filterContent()` logic in `tag-system.js`
3. Test filtering on gaming page
4. Deploy and verify

### Priority 2: Expand to Other Pages

1. Add tag UI to `gamedev.php`
2. Add tag UI to `diy.php`
3. Add tag UI to `index.php`
4. Update footer to conditionally load tag system

### Priority 3: Enhancement Features

1. Add tag counts (e.g., "Unity (12)")
2. Add URL parameter support for sharing
3. Add smooth animations for content filtering
4. Add "No results" messaging
5. Consider tag search/autocomplete

---

**Last Verified:** October 26, 2025  
**Recent Edits (2025-10-26):**
- Fixed playlist rendering on game pages: `game/botborgs.php` and `game/jennistyles.php` now render playlists directly by playlist ID using `YouTubeGrid.renderPlaylist(...)`, avoiding failures when page-level YAML parsing (`js-yaml`) is not present.
- `public_html/tags.php` now loads site theme CSS so tag pages display with the correct dark/light theme variants.
- Recommendation formalized: converge on `public_html/resources/tags.yaml` (or `tags.json`) as the single canonical tag source; keep derived `content_tags.json` under `resources/playlists/`.

**Script Location:** `resources/js/tag-system.js` (14,293 bytes)  
**Status:** ✅ Core tag UI and filtering implemented; next steps focus on UX improvements and wider per-page coverage

---

## 🔧 Refinement: Only list tags that are actually used on the page

To avoid showing tag options in the offcanvas that have no matching content, the playlist renderer (YouTubeGrid) exposes the set of tag slugs that were applied to content on the page. After it finishes rendering, it emits a small event and populates `window.__usedTagSlugs`.

Example listener (client-side):

```javascript
document.addEventListener('YouTubeGrid:usedTagsUpdated', (e) => {
  const usedSlugs = Array.isArray(e.detail) ? e.detail : (window.__usedTagSlugs || []);
  // When populating each category list, only render badges where tag.slug is in usedSlugs
  // Fallback: if usedSlugs is empty, render full list or offer a "Show all tags" toggle.
});
```

Recommended behavior:
- If `usedSlugs` is present and non-empty, only display badges for tags that appear in `usedSlugs`.
- Provide a small toggle in the offcanvas to "Show all tags" for advanced users.
- Log any tags present on the page that are not found in `tags.json` so we can update the canonical index.

Edge cases:
- If the canonical `tags.json` is missing, fall back to slugifying tag names and show all tags.
- If `YouTubeGrid` hasn't finished rendering when the offcanvas opens, the `tag-system` should listen for the event and refresh the lists when it arrives.


---

## 🎯 Page-Level Tag Filtering Implementation

**Status:** ✅ Implemented on blog.php, planned for gamedev.php, gaming.php, diy.php

### Current Implementation: blog.php

Blog page has **instant filtering** without page reloads:
- Tag buttons at top of page
- JavaScript loads blog-posts.yaml via js-yaml
- Filters posts in real-time: `posts.filter(p => p.tags.includes(selectedTag))`
- No redirect to /tags.php

**Code Pattern:**
```html
<section class="py-3 bg-body-secondary">
  <div class="container">
    <div class="d-flex justify-content-center gap-2 flex-wrap">
      <button class="btn btn-primary" data-tag="all">All Posts</button>
      <button class="btn btn-outline-primary" data-tag="gamedev">Game Dev</button>
      <button class="btn btn-outline-primary" data-tag="diy">DIY</button>
    </div>
  </div>
</section>
```

**JavaScript:**
```javascript
document.querySelectorAll('[data-tag]').forEach(btn => {
  btn.addEventListener('click', function() {
    const tag = this.getAttribute('data-tag');
    loadAndRenderContent(tag); // Filters and re-renders
  });
});
```

### Planned: gamedev.php, gaming.php, diy.php

**Goal:** Add same instant filtering as blog.php

**Implementation Steps:**
1. Add tag filter button section near top of page
2. Load YAML content (gamedev.yaml, gaming.yaml, diy.yaml) via js-yaml
3. Extract unique tags from content
4. Wire filter buttons to filter playlist/content cards
5. Render filtered results instantly (no page reload)

**Key Tags by Page:**
- **gamedev.php:** gamedev, devlog, unity, unreal, 3d-modeling, martiangames, game-jam
- **gaming.php:** Platforms (ps5, switch, pc), Genres (horror, fps, rpg), Game titles (dead-space, ori, etc.)
- **diy.php:** diy, fashion, hair, nails, beauty, self-care + mix in DIY blog posts

**DIY Page Special Case:**
- Mix playlists from diy.yaml + blog posts with DIY tags
- Render both types as cards
- Blog post cards link to /blog/{slug}.php
- Add "Back to DIY" button on DIY-tagged blog posts

### Two Filtering Modes

**Mode 1: Page-Level (Instant)**
- Used by: blog.php (implemented), gamedev/gaming/diy (planned)
- Behavior: Filter content on current page, no reload
- Best for: Browsing within one category/page

**Mode 2: Site-Wide (Offcanvas → /tags.php)**
- Used by: index.php, gamedev.php, gaming.php, diy.php (via offcanvas panel)
- Behavior: Select multiple tags, redirect to /tags.php with filters
- Best for: Multi-category searches across entire site

**Both modes coexist:** Pages can have BOTH instant page-level filtering AND offcanvas panel for site-wide search.

---

**Reference:** See archived PAGE-LEVEL-FILTERING-IMPLEMENTATION.md (storage/docs/archive/) for detailed implementation guide with code examples.

---

**Document Version:** 4.2  
**Last Updated:** October 31, 2025  
**Status:** Tag system active, page-level filtering documented

---

## 🛠️ How‑To: Adding Tags, Refreshing YouTube RSS Cache & Thumbnails

This practical section shows the exact commands and minimal workflow I use locally to add tags, re-index playlists, and refresh YouTube RSS cache / thumbnails when something goes missing.

Assumptions:
- You're on the development machine with the repository checked out.
- You're running the dev server via `scripts\\dev-server.ps1` (or can reach the site at http://localhost:8002).

A. Add or update a tag

1. Edit `public_html/resources/playlists/tags.json` and add your tag object (id, name, slug, category). Keep slugs lowercase and kebab-cased.

Example entry:

```json
  {
    "id": 200,
    "name": "Nintendo Switch",
    "slug": "nintendo-switch",
    "category": "gaming"
  }
```

2. Save the file. No build step required — the site fetches this file at runtime.

B. Add tags to a playlist (YAML) or blog post

1. Edit the appropriate YAML under `public_html/resources/playlists/*.yaml` (e.g. `gaming.yaml`, `diy.yaml`, or `blog-posts.yaml`). Add tags as an array of slugs:

```yaml
- id: "PL6WnzXOaRqA0AmWzg6b12-8O4eRifnTRC"
  title: "PS5 Playthroughs"
  tags: ["gaming","ps5","console","playthrough","action-adventure","action"]
```

**Example: Adding 'console' tag to gaming playlists (Nov 1, 2025)**

We added the `console` tag to 6 playlists for PS5, PS4, and Nintendo Switch content:

```yaml
# gaming.yaml - Before
- id: "PL6WnzXOaRqA0AmWzg6b12-8O4eRifnTRC"
  title: "PS5 Playthroughs"
  tags: ["gaming", "ps5", "playthrough", "action-adventure", "action"]

# gaming.yaml - After
- id: "PL6WnzXOaRqA0AmWzg6b12-8O4eRifnTRC"
  title: "PS5 Playthroughs"
  tags: ["gaming", "ps5", "console", "playthrough", "action-adventure", "action"]
```

Updated playlists:
- PS5 Playthroughs (added `console`)
- Nintendo Switch Games (added `console`)
- Marvel's Spider-Man [PS4] (added `console`)
- Assassin's Creed: Odyssey [PS4 - Live] (added `console`)
- Far Cry 5 [PS4] - 1st Playthrough (added `console`)
- Detroit: Become Human (added `console`)

Then added Console filter button to gaming.php:
```html
<button class="badge bg-dark text-white p-2 border-0 cursor-pointer" 
        data-tag="console" 
        onclick="window.tagFilter?.toggle('console')">
  <i class="fa-solid fa-gamepad me-1"></i>Console
</button>
```

2. If it's a blog post, update `public_html/resources/playlists/blog-posts.yaml` and add the `tags:` array.

C. Re-index playlists and regenerate `content_tags.json` (required after YAML changes)

Run the helper script that scans YAML and writes `content_tags.json`. From the repo root (PowerShell):

```powershell
pwsh -NoProfile -ExecutionPolicy Bypass -File .\\scripts\\generate-playlist-tags.ps1 -Verbose
```

This script:
- Parses playlist YAML files
- Converts tags to canonical slugs
- Emits/updates entries in `public_html/resources/playlists/content_tags.json`

D. Refresh YouTube RSS cache (to regenerate thumbnails used by youtube-grid)

The site uses a small RSS proxy that caches playlist/channel responses in `storage/cache/youtube/` (files named by a short hash). If thumbnails are missing or stale, force a refresh:

1. Remove the cache file for the affected playlist (or remove all to force re-fetch):

```powershell
# Example: remove a single cache file (use the filename you find under storage/cache/youtube)
Remove-Item .\\storage\\cache\\youtube\\a1c302444120.json -ErrorAction SilentlyContinue

# Or: remove all youtube cache files (careful)
Remove-Item .\\storage\\cache\\youtube\\*.json -ErrorAction SilentlyContinue
```

2. Trigger the RSS proxy by calling the endpoint (dev server must be running):

```powershell
# Replace PLAYLIST_ID with the playlist you want to refresh
Invoke-RestMethod "http://localhost:8002/resources/api/get-youtube.php?playlist_id=PL6WnzXOaRqA0AmWzg6b12-8O4eRifnTRC" | Out-Null
```

On success the proxy will re-create the cache file and include the `media:thumbnail` entries the grid uses.

E. Regenerate thumbnails with the downloader script (optional)

If you prefer locally saved thumbnails (script places them where the grid expects them), run:

```powershell
pwsh -NoProfile -ExecutionPolicy Bypass -File .\\scripts\\download-playlist-thumbnails.ps1 -Verbose
```

Notes:
- The downloader reads playlist IDs from `public_html/resources/playlists/content_tags.json` and `playlist-ids.json`.
- It will attempt to fetch each video's `media:thumbnail` via the RSS proxy — so ensure the proxy cache is fresh or reachable.

F. Quick verification steps (after re-index / cache refresh):

1. Visit the dev site tag page in your browser — e.g.:
- http://localhost:8002/tags.php?filters=nintendo-switch

2. Verify:
- matching playlist and blog cards appear
- thumbnails are visible on playlist cards
- tag badges show friendly names

If you still see 502 responses from `/resources/api/get-youtube.php`, inspect the proxy log in the dev server terminal (it prints remote feed errors). Common causes:
- transient YouTube/RSS network errors (retry after a minute)
- blocked outbound requests on the host
- badly-formed playlist ID (double-check the ID)

G. If something goes wrong — minimal debug checklist

1. Confirm dev server is running (scripts\\dev-server.ps1)
2. Check `public_html/resources/playlists/tags.json` and `content_tags.json` are present and valid JSON
3. Confirm the playlist exists in the YAML file and has `tags:` defined
4. Re-run `generate-playlist-tags.ps1` and watch for warnings
5. Remove the cache file and re-invoke `get-youtube.php` to see live error output

H. Automation & CI suggestions (optional future work)

- Add a CI job that runs `generate-playlist-tags.ps1` and validates resulting JSON before deploy.
- Add a health-check endpoint that verifies `storage/cache/youtube/*.json` covers all playlists listed in `content_tags.json` and emails/report missing caches.

---

---

## 📋 Complete Workflow: From YAML to Live Site

This section explains the complete tag workflow from adding content in YAML files to seeing it work on the live site.

### Step 1: Understanding the Tag System Files

**tags.json** - The canonical source of all tag definitions (136 tags)
```json
{
  "id": 39,
  "name": "DIY",
  "slug": "diy",
  "category": "diy"
}
```
- **Location:** `public_html/resources/playlists/tags.json`
- **Purpose:** Defines all available tags with ID, display name, URL slug, and category
- **When to edit:** When adding a NEW tag that doesn't exist yet

**YAML Files** - Content source files with tag arrays
```yaml
- id: "PL6WnzXOaRqA16UY1KibrFUHu4gDZ8hmep"
  title: "Ori and the Blind Forest"
  tags: ["gaming", "platformer", "indie", "ori"]
```
- **Locations:** 
  - `public_html/resources/playlists/gaming.yaml` (30 playlists)
  - `public_html/resources/playlists/diy.yaml` (12 playlists)
  - `public_html/resources/playlists/gamedev.yaml` (2 playlists)
  - `public_html/resources/playlists/gamejams.yaml` (8 playlists)
  - `public_html/resources/playlists/live.yaml` (livestream playlists)
  - `public_html/resources/playlists/patreon.yaml` (VIP content)
  - `public_html/resources/playlists/blog-posts.yaml` (9 blog posts)
- **Purpose:** Define content (playlists, blog posts) with tags arrays
- **When to edit:** When adding new content or updating tags on existing content

**content_tags.json** - Generated mapping file
```json
"playlist:PL6WnzXOaRqA16UY1KibrFUHu4gDZ8hmep": {
  "title": "Ori and the Blind Forest",
  "url": "/gaming.php#playlist-PL6WnzXOaRqA16UY1KibrFUHu4gDZ8hmep",
  "tags": ["gaming", "platformer", "indie", "ori"]
}
```
- **Location:** `public_html/resources/playlists/content_tags.json`
- **Purpose:** Maps content IDs to their tags (used by filtering system)
- **When to edit:** DON'T edit manually - regenerated by `generate-playlist-tags.ps1`

### Step 2: Adding a New Tag (If Needed)

**Only add a new tag if it doesn't already exist in tags.json (136 tags currently defined)**

1. Open `public_html/resources/playlists/tags.json`
2. Find the highest ID number (currently 136)
3. Add your new tag at the end:
```json
{
  "id": 137,
  "name": "My New Tag",
  "slug": "my-new-tag",
  "category": "gaming"
}
```

**Tag Naming Rules:**
- **id:** Just increment from last ID (currently 136)
- **name:** Display name with proper capitalization ("Dead Space", "Game Development")
- **slug:** Lowercase with hyphens ("dead-space", "game-development")
- **category:** One of: gaming, gamedev, diy, voice-acting, art, meta, multi-category

4. Save the file

### Step 3: Adding Tags to Content (YAML Files)

1. Open the appropriate YAML file for your content type:
   - Gaming Let's Plays → `gaming.yaml`
   - DIY Tutorials → `diy.yaml`
   - Game Dev Projects → `gamedev.yaml`
   - Game Jams → `gamejams.yaml`
   - Blog Posts → `blog-posts.yaml`

2. Find your playlist/content entry (or add a new one)

3. Add or update the `tags:` array with tag **slugs** (not names or IDs):
```yaml
- id: "PL6WnzXOaRqA16UY1KibrFUHu4gDZ8hmep"
  title: "Ori and the Blind Forest"
  description: "Beautiful platformer adventure"
  tags: ["gaming", "platformer", "indie", "ori", "metroidvania"]
```

**Important:** Use the slug format from tags.json (lowercase, hyphens)

4. Save the YAML file

### Step 4: Re-index Content Tags

After editing YAML files, regenerate `content_tags.json`:

```powershell
cd c:\Users\Owner\Projects\www\jenninexus
pwsh -NoProfile -ExecutionPolicy Bypass -File .\scripts\generate-playlist-tags.ps1 -Verbose
```

**What this script does:**
- Reads all YAML files (gaming, diy, gamedev, gamejams, live, patreon, blog-posts)
- Extracts playlists that have `tags:` arrays
- Creates entries in `content_tags.json` with format:
  - `"playlist:PLxxxxx"` → playlist entry
  - `"blog:post-slug"` → blog post entry
- Preserves existing entries
- Skips duplicates

**Expected output:**
```
📄 Processing: gaming.yaml
  ✅ Added: Ori and the Blind Forest
  ⏭️ Exists: PS5 Playthroughs
  Found 30 tagged playlists

📄 Processing: diy.yaml
  Found 12 tagged playlists

📊 Summary:
  • New playlists added: 5
  • Total entries in content_tags: 110

✅ Updated content_tags.json
```

### Step 5: Testing on Dev Server

1. Start the dev server if not already running:
```powershell
.\scripts\dev-server.ps1
```

2. Visit the appropriate page:
   - Gaming content: http://localhost:8002/gaming.php
   - DIY content: http://localhost:8002/diy.php
   - Game Dev: http://localhost:8002/gamedev.php
   - Blog posts: http://localhost:8002/blog.php

3. Test tag filtering:
   - **On page filters:** Click tag badges on playlist cards → should filter content instantly
   - **Offcanvas filters:** Click "Filter by Tags" → select tags → Apply Filters → redirects to `/tags.php?filters=tag1,tag2`
   - **Clear button:** Click "See All Content" → all content returns

4. Verify playlist cards:
   - Playlist card shows tags as clickable badges
   - Clicking badge toggles that tag filter
   - Badges have proper spacing (flexbox gap-2)

### Step 6: Refreshing YouTube RSS Cache (If Thumbnails Missing)

If playlist thumbnails don't load:

1. Clear the RSS cache:
```powershell
Remove-Item .\storage\cache\youtube\*.json -ErrorAction SilentlyContinue
```

2. Visit the page → thumbnails will re-fetch automatically from YouTube RSS

3. Or manually trigger refresh:
```powershell
Invoke-RestMethod "http://localhost:8002/resources/api/get-youtube.php?playlist_id=YOUR_PLAYLIST_ID" | Out-Null
```

### Step 7: Deploying to Production

1. Commit your changes:
```powershell
git add public_html/resources/playlists/tags.json
git add public_html/resources/playlists/gaming.yaml  # or whatever you edited
git add public_html/resources/playlists/content_tags.json
git commit -m "Add tags for new gaming content"
```

2. Deploy:
```powershell
.\scripts\deploy.ps1
```

3. Test on live site at https://jenninexus.com

### Troubleshooting Common Issues

**Problem:** "No content matched those tags" on `/tags.php`  
**Solution:** Re-run `generate-playlist-tags.ps1` to ensure content is indexed

**Problem:** Tag badges not clickable  
**Solution:** Check that `youtube-grid.js` or `diy-playlists.js` added `onclick` handlers

**Problem:** Playlist shows but no tags visible  
**Solution:** Check YAML file has `tags:` array with valid slugs from tags.json

**Problem:** Tags show as numbers (IDs) instead of names  
**Solution:** Server-side fix already implemented in tags.php (ID→slug→name conversion)

**Problem:** Filter shows content that shouldn't match  
**Solution:** Check that content's tags array matches slugs exactly (case-sensitive)

### Quick Reference Commands

```powershell
# Re-index all playlists from YAML
pwsh .\scripts\generate-playlist-tags.ps1 -Verbose

# Clear YouTube RSS cache
Remove-Item .\storage\cache\youtube\*.json

# Start dev server
.\scripts\dev-server.ps1

# Deploy to production
.\scripts\deploy.ps1

# Check tag usage
Get-Content .\public_html\resources\playlists\content_tags.json | Select-String "your-tag-slug"
```

### Tag System File Summary

| File | Purpose | Edit Manually? |
|------|---------|----------------|
| `tags.json` | Tag definitions (ID, name, slug, category) | ✅ Yes - to add new tags |
| `gaming.yaml` | Gaming playlists with tags | ✅ Yes - to add/update content |
| `diy.yaml` | DIY playlists with tags | ✅ Yes - to add/update content |
| `gamedev.yaml` | Game dev projects with tags | ✅ Yes - to add/update content |
| `gamejams.yaml` | Game jam entries with tags | ✅ Yes - to add/update content |
| `blog-posts.yaml` | Blog posts with tags | ✅ Yes - to add/update posts |
| `content_tags.json` | Content→tag mappings | ❌ No - regenerated by script |

### Summary: Complete Workflow

1. **Add new tag to tags.json** (if needed) → increment ID from 136
2. **Add tags to YAML files** → use slugs in `tags:` arrays
3. **Run generate-playlist-tags.ps1** → regenerates content_tags.json
4. **Test on dev server** → verify filtering works
5. **Clear cache if needed** → refresh thumbnails
6. **Deploy to production** → commit and deploy

---

### Apply Filters button doesn't work / tags disappear when clicked
**Cause:** Button has `data-bs-dismiss="offcanvas"` which closes offcanvas before redirect  
**Fix:**
```html
<!-- ❌ WRONG - Dismisses offcanvas immediately -->
<button id="applyFilters" class="btn btn-primary" data-bs-dismiss="offcanvas">Apply Filters</button>

<!-- ✅ CORRECT - Allows redirect to complete -->
<button id="applyFilters" class="btn btn-primary">Apply Filters</button>
```

The JavaScript in `tag-system.js` handles the redirect:
```javascript
document.getElementById('applyFilters').addEventListener('click', function() {
  const active = window.tagFilter ? window.tagFilter.getActive() : [];
  if (active.length > 0) {
    window.location.href = '/tags.php?filters=' + active.join(',');
  }
});
```

**Fixed in:** gaming.php, diy.php, gamedev.php (November 1, 2025)

---

## ✅ Completion Notes

- The server-side tag normalization fix (ID→slug→name) is implemented in `public_html/tags.php` and should resolve the "No content matched those tags" reports. Please test end-to-end on the dev server (open browser, reproduce the offcanvas flow).
- All YAML files verified: blog-posts, diy, gamedev, gamejams, gaming, live, patreon all have proper tags arrays ✅

---

## 🔐 Patreon Tag Integration & OAuth System

**Source:** Consolidated from `PATREON-TAG-AUDIT-NOV3.md` (November 3, 2025)

### Patreon System Architecture

**OAuth Flow (Public-Facing):**
- ✅ `public_html/patreon-auth-start.php` - **CANONICAL** OAuth start endpoint
- ✅ `public_html/patreon-callback.php` - OAuth callback handler, exchanges code for tokens
- ✅ `public_html/patreon.php` - Main page with VIP content gating
- 🔀 `public_html/resources/patreon-auth-start.php` - **REDIRECT PROXY** (302 to canonical, intentional)

**API Endpoints (Server-Side):**
- ✅ `resources/api/check-patreon-membership.php` - Auth status checker
- ✅ `resources/api/get-patreon-posts.php` - Fetches recent posts (cached 15min)
- ✅ `resources/api/get-patreon-tiers.php` - Fetches campaign tiers (cached 30min)
- ✅ `resources/api/patreon-webhook.php` - Receives Patreon webhooks

**Client-Side:**
- ✅ `resources/js/patreon-auth-enhanced.js` - Client auth UI & VIP content reveal

**YAML Config:**
- ✅ `resources/playlists/patreon.yaml` - 2 VIP playlists with Bootstrap responsive columns

**Secrets Location (Remote Server):**
```bash
/var/www/jenninexus/storage/secrets/patreon.json
```
```json
{
  "PATREON_CLIENT_ID": "rpG5M7dfBT8HsnSkDtPhbu7Bwe7RAdpcHKX-MpiVwqg7zsS3--97aMxXTFNI1nGt",
  "PATREON_CLIENT_SECRET": "<secret>",
  "PATREON_REDIRECT_URI": "https://jenninexus.com/patreon-callback",
  "PATREON_CREATOR_ACCESS_TOKEN": "<long-token>",
  "PATREON_CAMPAIGN_ID": "117499"
}
```

### Patreon Tag Mapping

**Tag Coverage:**
- `patreon` tag applied to 2 VIP playlists in `patreon.yaml`
- VIP content appears in tag filter results when `patreon` tag selected
- Content gated behind authentication (blurred until user connects Patreon account)

**Files with Patreon Tags:**
```yaml
# resources/playlists/patreon.yaml
patreon_section:
  title: "Patreon VIP Playlists"
  playlists:
    - name: "Martian Games: Let's Plays"
      playlist_id: "PL9QBjNDhgNwRkcV9WLFJBsJnULSUDqPty"
      tags: ["patreon", "vip", "gaming", "martiangames"]
      
    - name: "Behind the Scenes: Game Dev"
      playlist_id: "PL9QBjNDhgNwQrF4hj2p8Z3N9KqVxfYz9e"
      tags: ["patreon", "vip", "gamedev", "tutorials"]
```

**VIP Content Reveal System:**

Server-side gating in `patreon.php`:
```php
<!-- VIP Content Section (client-gated) -->
<section id="vipArea" class="py-5 bg-body-secondary">
  <div id="vipGrid" class="row g-3 vip-guest-view" 
       data-category="patreon" data-tags="patreon,vip">
    <!-- Blurred placeholders → Revealed after auth -->
  </div>
</section>
```

Client-side auth check in `patreon-auth-enhanced.js`:
```javascript
async function checkPatreonStatus() {
  const response = await fetch('/resources/api/check-patreon-membership.php');
  const data = await response.json();
  
  if (data.authenticated && data.is_patron) {
    // Remove blur, load real content from patreon.yaml
    document.getElementById('vipGrid').classList.remove('vip-guest-view');
    await window.YouTubeGrid.loadPageConfig('patreon');
  }
}
```

### OAuth Flow (Complete)

1. **User clicks "Connect with Patreon"** → `/patreon-auth-start.php`
2. **Generates CSRF state** → Stores in session
3. **Redirects to Patreon** → `https://www.patreon.com/oauth2/authorize?...`
4. **User authorizes** → Patreon redirects back
5. **`/patreon-callback.php` receives code** → Exchanges for tokens
6. **Stores tokens** → `storage/patreon/tokens.json` (0600 permissions)
7. **Fetches user identity** → Stores in `storage/patreon/user.json`
8. **Creates session** → Sets `is_patron` flag
9. **Redirects to `/patreon`** → VIP content now accessible

### Patreon Tag Filtering Integration

**Tags Page (`/tags.php`):**
- ✅ Patreon-tagged content appears in results when filtering by `patreon` tag
- ✅ VIP playlist cards show with proper thumbnails and metadata
- ✅ Click redirects to `/patreon` where authentication gate applies

**Tag Filter Offcanvas:**
- ✅ `patreon` tag appears in "Other" category (along with ai, vip, tutorials, etc.)
- ✅ Multi-tag selection works: `?filters=patreon,gaming` shows VIP gaming content
- ✅ Badge count accurate: "2 results" for patreon tag

**Content Tag Mapping (Generated):**
```json
// storage/playlists/content_tags.json (auto-generated)
{
  "patreon": {
    "videos": ["PL9QBjNDhgNwRkcV9WLFJBsJnULSUDqPty", "PL9QBjNDhgNwQrF4hj2p8Z3N9KqVxfYz9e"],
    "blogs": [],
    "games": [],
    "count": 2
  }
}
```

**Testing Checklist:**
- [ ] `/tags.php?tag=patreon` shows 2 VIP playlists
- [ ] Tag filter offcanvas shows "patreon" in Other category
- [ ] Multi-tag `?filters=patreon,gaming` shows relevant content
- [ ] Clicking VIP playlist card redirects to `/patreon`
- [ ] `/patreon` page shows blurred placeholder when not authenticated
- [ ] After Patreon OAuth, VIP content reveals properly
- [ ] Tag badge on VIP cards shows "patreon" and "vip" tags

---

## 🔧 Troubleshooting & Maintenance (Nov 11, 2025)

### Running the Validation Suite

**1. Comprehensive Tag System Validation:**
```powershell
# Check all pages, data files, and implementation
pwsh -File scripts/validate-tag-system.ps1 -CheckDataFiles
```

**Expected Output:**
- ✅ 25+ checks passed
- ✅ Tag data files loaded (tags.json: 157 tags, content_tags.json: entries)
- ✅ 5 pages with tag offcanvas verified
- ❌ 0 failures (if system is healthy)
- ⚠️ 10 warnings (Apply/Clear buttons may use inline handlers)

**2. Analyze Tag Usage:**
```bash
# Find unused tags that could cause "No content matched" errors
node scripts/analyze-tags.cjs
```

**Expected Output:**
- Summary: X tags used, Y tags unused out of 157 total
- Unused tags grouped by category (blog, gaming, gamedev, diy, meta, music)
- Recommendation to remove unused tags or add content

**3. Fix Tag Data Integrity:**
```powershell
# Remove duplicates, add blog posts and pages to content_tags.json
pwsh -File scripts/fix-tag-system.ps1 -Verbose
```

**Expected Output:**
- ✅ Removed N duplicate tags (creates backup first)
- ✅ Added N blog post entries
- ✅ Added N main page entries
- 💾 Backups created with timestamps

**4. Manual Testing Checklist:**

After running maintenance scripts, test these scenarios:

- [ ] **Home page** (`/`) - Click "Filter by Tags" button
  - Opens offcanvas with tag lists
  - Select multiple tags from different categories
  - Click "Apply Filters"
  - Redirects to `/tags.php?filters=tag1,tag2,tag3`

- [ ] **Gaming page** (`/gaming.php`) - Platform/genre badges
  - Click any platform badge (Steam, PS5, Nintendo Switch)
  - Opens offcanvas with selected tag highlighted
  - Apply filters works correctly

- [ ] **Tags page** (`/tags.php`) - Multi-tag filtering
  - URL: `/tags.php?filters=horror,fps,survival`
  - Shows card previews for matching content
  - Related tags section shows co-occurring tags
  - Click tag badge on card to refine results

- [ ] **Tag individual page** (`/tag/index.php?slug=horror`)
  - Shows single-tag results
  - Multi-select works (add more tags)
  - Cards render properly (games, blogs, videos, playlists)

### Common Issues & Solutions

**Issue: "No content matched those tags"**

**Cause:** Tag exists in tags.json but has no content in content_tags.json

**Solution:**
1. Run `node scripts/analyze-tags.cjs` to find unused tags
2. Either:
   - Remove unused tags from tags.json
   - Add content that uses those tags (update YAML files with tags)
3. Run `pwsh -File scripts/generate-playlist-tags.ps1` to regenerate content_tags.json
4. Verify with analyzer again

**Issue: Duplicate tags appear in offcanvas**

**Cause:** tags.json contains duplicate slug entries

**Solution:**
1. Run `pwsh -File scripts/fix-tag-system.ps1 -Verbose`
2. Script removes duplicates automatically
3. Verify with validation script

**Issue: Blog posts not appearing in tag results**

**Cause:** Blog posts missing from content_tags.json

**Solution:**
1. Verify blog-posts.yaml exists and has `tags:` arrays
2. Run `pwsh -File scripts/fix-tag-system.ps1 -Verbose`
3. Script adds blog posts to content_tags.json
4. Test filtering with blog-specific tags

**Issue: Tag offcanvas not populating**

**Cause:** tag-system.js not loaded or RES_ROOT path incorrect

**Solution:**
1. Run `pwsh -File scripts/validate-tag-system.ps1 -CheckDataFiles`
2. Check browser console for 404 errors
3. Verify page includes:
   ```html
   <script src="<?= RES_ROOT ?>/js/tag-system.js"></script>
   ```
4. Check tags.json is accessible at `/resources/playlists/tags.json`

**Issue: Generated files empty or outdated**

**Cause:** import-youtube-tags.js not run or cache missing

**Solution:**
```bash
# Generate tags from YouTube RSS feeds and local cache
node scripts/import-youtube-tags.js
```

This creates:
- `generated_tags.json` - Top 100 tags from YouTube content
- `generated_content_tags.json` - Video ID to tag mappings

**Issue: 95 unused tags (60.5% unused rate)**

**Status:** Expected behavior (Nov 11, 2025)

**Explanation:**
- 157 total tags defined for future content
- 62 actively used (39.5%)
- 95 prepared for upcoming videos/blogs/games
- Not an error - tags ready when content added

**Options:**
1. **Keep unused tags** for future content (recommended)
2. **Remove specific unused tags** if they're outdated:
   ```bash
   # Edit public_html/resources/playlists/tags.json
   # Remove tag entries manually
   # Or run fix-tag-system.ps1 after editing
   ```
3. **Add content for unused tags** (create playlists/blogs using them)

### Maintenance Schedule

**Weekly:**
- Run `node scripts/analyze-tags.cjs` to monitor tag usage
- Check for "No content matched" reports from users

**After Content Updates:**
- Added new playlist/blog? → Run `pwsh -File scripts/generate-playlist-tags.ps1`
- Added new tag? → Update tags.json, regenerate content_tags.json

**Monthly:**
- Run full validation suite: `pwsh -File scripts/validate-tag-system.ps1 -CheckDataFiles`
- Review unused tags with analyzer, decide to keep or remove
- Backup tags.json and content_tags.json before major changes

**Before Deployment:**
1. Validate tag system locally
2. Run analyzer to check for unused tags
3. Test multi-tag filtering on dev server
4. Deploy to production
5. Smoke test `/tags.php?filters=gaming,horror` on live site

---

- Re-indexing script ran successfully: 52 playlists processed, content_tags.json updated with 110 entries ✅
- Complete workflow documentation added to TAG-SYSTEM.md ✅
- Tag system validation suite created (Nov 11, 2025) ✅
- fix-tag-system.ps1 executed successfully (0 duplicates removed, blog posts/pages already present) ✅
- Next steps: End-to-end testing and 10-31.md action plan review

---

## 📚 IMPLEMENTATION GUIDE (Nov 19, 2025)

### Architecture Overview

The JenniNexus tag system provides **two-tier filtering**:

1. **Page-Specific Tags** - Quick filters for content on individual pages (blog, gaming, diy, gamedev)
2. **Site-Wide Tags** - Advanced filtering via offcanvas that searches across all content types

### Core Files

```
public_html/
├── resources/
│   ├── js/
│   │   ├── tag-filter-api.js      # Central filtering API (window.tagFilter)
│   │   └── tag-system.js           # Offcanvas UI and filtering logic
│   └── playlists/
│       ├── tags.json               # Master tag definitions
│       ├── content_tags.json       # Content → tag mappings (AUTO-GENERATED)
│       ├── blog-posts.yaml         # Blog post metadata
│       ├── gaming.yaml             # Gaming playlist metadata
│       ├── gamedev.yaml            # Game dev playlist metadata
│       └── diy.yaml                # DIY playlist metadata

scripts/
├── generate-blog-tags.ps1          # Parses blog-posts.yaml → content_tags.json
├── generate-playlist-tags.ps1      # Parses YAML playlists → content_tags.json
└── build-all.ps1                   # Runs tag generators + asset building
```

### Data Attribute Standards

**✅ CORRECT Pattern:**
```html
<!-- Wrapper has .content-item class and data-tags -->
<div class="col-md-4 content-item" data-tags="tag1,tag2,tag3">
  <div class="card">
    <!-- Card content -->
  </div>
</div>
```

**❌ INCORRECT Pattern:**
```html
<!-- Inner card has data-tags (won't be found by tag-system.js) -->
<div class="col-md-4">
  <div class="card content-item" data-tags="tag1,tag2,tag3">
    <!-- Card content -->
  </div>
</div>
```

**Rule:** `data-tags` must be on the **column wrapper** (`.col-*`), not the inner card.

### Tag Generation Workflow

**Automatic Generation (Build Pipeline):**
```powershell
# scripts/build-all.ps1
# Step 0: Generate Content Tags
generate-playlist-tags.ps1  # Parses gaming.yaml, gamedev.yaml, diy.yaml
generate-blog-tags.ps1      # Parses blog-posts.yaml
# → Updates content_tags.json

# Step 1: Build Assets
build.ps1                   # Minifies CSS/JS
```

**Manual Generation:**
```powershell
# Generate blog tags only
.\scripts\generate-blog-tags.ps1

# Generate playlist tags only
.\scripts\generate-playlist-tags.ps1

# Run full build (includes tag generation)
.\scripts\build-all.ps1
```

### Adding New Content

**Adding a Blog Post:**
1. Edit `blog-posts.yaml`:
```yaml
- slug: my-new-post
  title: "My New Blog Post"
  date: "2025-11-19"
  category: "AI"
  excerpt: "A great post about AI"
  image: "/blog/my-image.jpg"
  tags:
    - ai
    - video-generation
    - sora
```

2. Run tag generator:
```powershell
.\scripts\generate-blog-tags.ps1
```

3. Verify `content_tags.json` has `blog:my-new-post` entry

**Adding a Playlist:**
1. Edit appropriate YAML file (`gaming.yaml`, `gamedev.yaml`, or `diy.yaml`):
```yaml
playlists:
  - id: "PL6WnzXOaRqA1234567890"
    title: "New Gaming Series"
    icon: "controller"
    description: "Epic gameplay"
    tags: ["gaming", "fps", "action"]
```

2. Run tag generator:
```powershell
.\scripts\generate-playlist-tags.ps1
```

### Troubleshooting

**Tags Not Filtering:**
1. ✅ Does the element have `.content-item` class?
2. ✅ Is `data-tags` on the wrapper (`.col-*`), not inner card?
3. ✅ Are tag slugs lowercase and hyphenated? (e.g., `video-generation` not `Video Generation`)
4. ✅ Is `tag-system.js` loaded on the page?

**Blog Posts Not Appearing on Tag Pages:**
1. ✅ Run `.\scripts\generate-blog-tags.ps1`
2. ✅ Verify `content_tags.json` has `blog:` entries
3. ✅ Check that blog post tags match tag slug exactly

**Offcanvas Shows No Tags:**
1. ✅ Is `tags.json` present in `/resources/playlists/`?
2. ✅ Is `tag-system.js` loaded?
3. ✅ Check browser console for errors
4. ✅ Try toggling "Show all tags" switch

### Best Practices

1. **Use Canonical Tag Slugs** - Always use the slugs defined in `tags.json`
2. **Keep Tags Consistent** - Use the same tag across all content types
3. **Run Tag Generators After YAML Changes** - `.\scripts\build-all.ps1`
4. **Test Filtering Locally** - Start dev server and verify filtering works

---

**End of TAG-SYSTEM.md**
