# Updated Todo List - Site-Wide Fixes
## October 15, 2025

## ✅ COMPLETED

### Header & Navigation Fixes
- [x] Fix blog post header URLs (blog/index → home) - `includes/header.php` now uses absolute paths
- [x] Simplify header navigation to 7 items (Home, Game Dev, Blog, DIY, Patreon, Services, Links)
- [x] Blog.php uses standard header
- [x] DIY.php uses standard header
- [x] Music.php uses standard header

### Content & Text Updates
- [x] Update Discord section text (Join Discord, Channel buttons)
- [x] Update Resume download section ("Visit the Resume page")
- [x] Reword Patreon support section (removed "hundreds")
- [x] Music page Discord button ("Join the Music Channel")

### Footer & Social Icons
- [x] Replace SoundCloud with Spotify in footer
- [x] Move Patreon heart to right side of icon row
- [x] Fix all footer URLs to use pretty URLs (no .php)
- [x] Update Discord links to main server (KYPh7Cp)

### Feature Cards & Links
- [x] Fix Creative Features section links (6 cards clickable)
- [x] Fix Featured Projects links (4 cards clickable)
- [x] Fix YouTube channel cards & subscribe buttons (3 channels with ?sub_confirmation=1)

### Blog Features
- [x] Add blog tag filtering functionality
- [x] Tag filter buttons now work

### Carousel & Interactive Elements
- [x] Fix Music Production carousel (added data-bs-interval="5000")

### Bug Fixes
- [x] Fix live.php CSS error (removed orphaned CSS)

## 🔄 IN PROGRESS

### Header Consistency
- [ ] Update gaming.php to use `includes/header.php`
- [ ] Update live.php to use `includes/header.php`  
- [ ] Update jennistyles.php to use `includes/header.php`
- [ ] Update all game pages to use `includes/header.php`

### Video & Playlist Fixes (PRIORITY)
- [ ] **Gaming.php** - Add curated gaming playlists in grid display
  - Let's Plays playlist
  - Walkthroughs playlist
  - PAX West coverage playlist
  - Gaming highlights playlist

- [ ] **Jennistyles.php** - Add gameplay/devlog videos
  - Gameplay video embed
  - Development video section
  - Use cowdefender.php embed method (16:9 ratio)

- [ ] **Martiangames** - Fix missing playlists/videos
  - Check YouTube Grid implementation
  - Add fallback video embeds
  - Ensure devlog playlist loads

- [ ] **DIY.php** - Add missing content
  - YouTube playlist integration
  - RSS feed display
  - Video thumbnails/cards
  - Tutorial listings

## 📋 NEW TASKS

### Game Pages - Video Standardization
Check and fix video embeds on ALL game pages using cowdefender.php method:

**Pages to Update:**
- [ ] /purgatoryfell - Add/fix video embeds
- [ ] /botborgs - Add/fix video embeds
- [ ] /jennistyles - Add/fix video embeds (+ remove .php requirement)
- [ ] /martiangames - Fix playlist display
- [ ] /catgame - Add/fix video embeds
- [ ] /blueballs - Add/fix video embeds
- [ ] /graveyardsmashers - Add/fix video embeds
- [ ] /cleanupinisle3 - Add/fix video embeds
- [ ] /momshouse - Add/fix video embeds
- [ ] /soccercow - Add/fix video embeds

**Standard Video Embed Code:**
```html
<div class="ratio ratio-16x9 rounded overflow-hidden">
  <iframe src="https://www.youtube.com/embed/VIDEO_ID" 
          title="Video Title" 
          frameborder="0" 
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
          allowfullscreen></iframe>
</div>
```

### Content & Pages
- [ ] Add /voiceacting page (linked from Creative Features)
- [ ] Add /ai page (linked from Creative Features)
- [ ] Add /gamejams page (linked from Featured Projects)

### Tag System Enhancement
- [ ] Add data-tags attributes to content items for filtering
- [ ] Document tagging strategy
- [ ] Test Content Categories filtering after tagging

## 🎯 HIGH PRIORITY

1. **Video Fixes** (Do First)
   - Gaming.php playlists
   - Jennistyles.php videos
   - Martiangames fix
   - Standardize all game page videos

2. **Header Consistency** (Do Next)
   - Update remaining pages to use `includes/header.php`
   - Remove duplicate navigation code

3. **Missing Pages** (Do After)
   - Create /voiceacting, /ai, /gamejams pages

## 📝 NOTES

### Video Embed Best Practices
- Always use `ratio ratio-16x9` for responsive sizing
- Wrap in card for proper layout
- Max width: `col-lg-8` for single videos
- Grid: `col-md-6 col-lg-4` for playlist cards
- Never use fixed width/height

### Playlist vs Single Video
- **Single Video**: Use `youtube.com/embed/VIDEO_ID`
- **Playlist**: Use `youtube.com/embed/videoseries?list=PLAYLIST_ID`
- **First video of playlist**: `youtube.com/embed/VIDEO_ID?list=PLAYLIST_ID`

### Header Navigation Structure (Current)
Desktop: Home | Game Dev | Blog | DIY | Patreon | Services | Links | [Theme Toggle]
Mobile: Same + social icons

### Pages Using Standard Header
✅ Blog, DIY, Music, Blog Posts, Some Project Pages
❌ Gaming, Live, Jennistyles, Game Pages (need update)

## 🔍 TESTING NEEDED

After completing video fixes:
- [ ] Test all video embeds load properly
- [ ] Verify responsive sizing on mobile
- [ ] Check aspect ratios are correct (16:9)
- [ ] Ensure no videos are oversized
- [ ] Test playlist embeds work
- [ ] Verify all pretty URLs work

---
*Last Updated: October 15, 2025*
*Priority: Video & Playlist Fixes*
