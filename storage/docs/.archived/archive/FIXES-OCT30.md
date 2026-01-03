# Fixes Required - October 30, 2025

## Issues to Fix:

### 1. ✅ Media Kit Download Button
- **File:** `media.php`
- **Issue:** Links to PDF instead of ZIP
- **Fix:** Change `/pdfs/press-kit.pdf` → `/media/jenninexus_media-kit.zip`
- **Status:** FIXED (earlier in session)

### 2. ✅ Gamedev Page Footer
- **File:** `gamedev.php`
- **Issue:** Footer not fitting to bottom of page
- **Fix:** Footer include was completely missing! Added `<?php include __DIR__ . '/includes/footer.php'; ?>` before `</body>`
- **Status:** FIXED

### 3. 📋 Gamedev Page Playlists
- **File:** `gamedev.php` + youtube-grid.js
- **Issue:** Playlists not rendering after recent mt-5 class change
- **Current State:** `mt-5` class still on line 127 of gamedev.php: `<div id="featured-playlists" class="row g-4 mb-4 mt-5">`
- **Status:** NEEDS USER TESTING - verify at http://localhost:8002/gamedev

### 4. ✅ DIY Playlist Tags
- **File:** `diy.php` + `diy-playlists.js`
- **Issue:** Playlist cards lift on hover but tags don't link to tag pages
- **Fix:** Added clickable tag badge rendering: `<a href="/tags?filter=${tagSlug}" class="badge ...">TAG</a>`
- **Status:** FIXED

### 5. ✅ Blog Post Image
- **File:** `blog-posts.yaml`
- **Issue:** "Game Development in 2025" post needs preview image
- **Fix:** Updated image path to `/gamedev/purgatory fell/purgatoryfell.jpg`
- **Status:** FIXED

### 6. ✅ Twitch Highlights Grid
- **File:** `live.php`
- **Issue:** Using wrong YouTube API method (renderPlaylistSection doesn't exist)
- **Fix:** Changed to correct method: `YouTubeGrid.renderPlaylist()` (removed "Section" from method name)
- **Status:** FIXED

### 7. ✅ Links Page Professional Section
- **File:** `links.php`
- **Issue:** Media Kit button needs to be after LinkedIn, link to /media
- **Fix:** Reordered cards: GitHub → LinkedIn → Media Kit (was Media Kit → GitHub → LinkedIn)
- **Status:** FIXED

---

## Testing Checklist:

- [ ] **live.php** - Verify Twitch highlights display as 4-column responsive grid
- [ ] **diy.php** - Click playlist tag badges, verify navigation to /tags?filter=TAG_SLUG
- [ ] **gamedev.php** - Verify footer now displays at bottom of page
- [ ] **gamedev.php** - Verify playlists render correctly with mt-5 spacing after tags
- [ ] **blog.php** - Verify "Game Development in 2025" post shows purgatory fell screenshot
- [ ] **links.php** - Verify Professional section displays: GitHub, LinkedIn, Media Kit (in order)

## Summary:

- **Total Issues:** 7
- **Fixed:** 6
- **Needs User Testing:** 1 (gamedev playlists with mt-5 spacing)
