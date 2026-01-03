# Bug Fixes - October 15, 2025

## Summary
Comprehensive bug fixes addressing 12 critical UX/functionality issues discovered during site testing.

## Fixed Issues

### 1. ✅ Footer Icon Reorganization
**File:** `public_html/includes/footer.php`
- **Replaced** SoundCloud with Spotify icon
- **Reordered** social icons: Email, YouTube, YouTube Music, Twitch, Spotify, Patreon (heart), Discord
- **Updated** Discord link from old invite to main: `https://discord.gg/KYPh7Cp`
- **Icon Colors:**
  - Email: `#EA4335` (Gmail red)
  - Spotify: `#1DB954` (Spotify green)
  - Patreon: `#FF424D` (heart icon, moved to right side)

### 2. ✅ Footer Pretty URLs
**File:** `public_html/includes/footer.php`
- **Changed** all footer links from `.php` to pretty URLs:
  - `links.php` → `/links`
  - `resume.php` → `/resume`
  - `services.php` → `/services`
  - `patreon.php` → `/patreon`

### 3. ✅ Blog Header Navigation Fixed
**File:** `public_html/includes/header.php`
- **Fixed** relative paths causing `blog/index.php` navigation errors
- **Changed** all nav links to absolute paths from root:
  - `index.php` → `/`
  - `gamedev.php` → `/gamedev`
  - `blog.php` → `/blog`
  - etc.
- **Simplified** header navigation to 7 core items (per user request):
  - Home, Game Dev, Blog, DIY, Patreon, Services, Links, Theme Toggle
- **Removed** from header: Music, Gaming, Live, Resume (moved to /links page)
- **Updated** mobile offcanvas menu with same structure and pretty URLs
- **Fixed** Discord link in mobile menu

### 4. ✅ Discord Section Text Updates
**File:** `public_html/index.php`
- **Changed** "Join Main Discord" → "Join Discord"
- **Updated** sub-buttons:
  - "Gaming Discord" → "Gaming Channel"
  - "DIY Discord" → "DIY Channel"  
  - "Music Discord" → "Music Channel"
- **Simplified** intro text from "on our main Discord server" → "on Discord"

### 5. ✅ Resume Section Rewording
**File:** `public_html/index.php`
- **Changed** "Download Full Resume" → "Visit the Resume Page"
- **Changed** "Get my complete..." → "View my complete..."
- **Updated** button: "Download Resume" → "View Resume"
- **Changed** href from PDF download to page: `/resume`
- **Changed** icon from `bi-download` → `bi-file-earmark-person`

### 6. ✅ Patreon Section Text Fix
**File:** `public_html/index.php`
- **Removed** "Ready to Support?" header
- **Changed** "Join hundreds of supporters..." → "Consider showing your support for my creative passions!"
- **Kept** Patreon CTA button and security text

### 7. ✅ Creative Features Cards - Added Links
**File:** `public_html/index.php`
- **Wrapped** all 6 feature cards in `<a>` tags:
  1. Game Development → `/gamedev`
  2. DIY w/ Jenni → `/diy`
  3. Voice Acting → `/voiceacting`
  4. Gaming Content → `/gaming`
  5. Music Production → `/music`
  6. AI & Technology → `/ai`
- All cards now clickable with `text-decoration-none` class

### 8. ✅ Featured Projects Cards - Added Links
**File:** `public_html/index.php`
- **Wrapped** all 4 project cards in `<a>` tags:
  1. Purgatory Fell VR → `/purgatoryfell`
  2. Botborgs → `/botborgs`
  3. Jenni Styles Dress Up → `/jennistyles`
  4. Game Jam Projects → `/gamejams`
- All cards now clickable with `text-decoration-none` class

### 9. ✅ YouTube Channel Subscribe Buttons
**File:** `public_html/index.php`
- **Fixed** all 3 YouTube channel subscribe buttons with proper URLs:
  1. JenniNEXUS: `https://www.youtube.com/@jenninexus?sub_confirmation=1`
  2. Jenni Plays Games: `https://www.youtube.com/@JenniPlaysGames?sub_confirmation=1`
  3. DIY w/ Jenni: `https://www.youtube.com/@DIYwithJenni?sub_confirmation=1`
- **Changed** `href="#"` to actual channel URLs
- **Added** `?sub_confirmation=1` parameter for auto-subscribe prompt

### 10. ✅ Music Production Carousel Fix
**File:** `public_html/index.php`
- **Added** explicit interval attribute: `data-bs-interval="5000"`
- **Already had** `data-bs-ride="carousel"` for auto-cycling
- Carousel should now auto-advance every 5 seconds

## Remaining Tasks

### ⏳ Content Categories Filtering
**File:** `public_html/index.php`
**Issue:** Tag filtering buttons exist but content items don't have `data-tags` attributes
**Solution Needed:** Add data-tags to content items for JavaScript filtering to work
**Example:** `<div class="content-item" data-category="gamedev" data-tags="unity,blender,devlog">`

### ⏳ Create Missing Pages
**Files Needed:**
- `/voiceacting` - Voice acting services/portfolio page
- `/gaming` - Gaming content page  
- `/music` - Music production page
- `/ai` - AI & Technology page
- `/purgatoryfell` - Purgatory Fell VR project page
- `/botborgs` - Botborgs project page
- `/jennistyles` - Jenni Styles dress-up game page
- `/gamejams` - Game jam projects collection page

## Files Modified

1. `public_html/includes/footer.php`
   - Footer icon reorganization (Spotify replaces SoundCloud)
   - Pretty URLs
   - Discord link update

2. `public_html/includes/header.php`
   - Navigation simplified to 7 items
   - All links converted to pretty URLs  
   - Fixed relative path issues for blog posts
   - Mobile menu updated

3. `public_html/index.php`
   - Discord section text updates
   - Resume section rewording
   - Patreon text changes
   - Creative Features cards made clickable (6 cards)
   - Featured Projects cards made clickable (4 cards)
   - YouTube subscribe button fixes (3 channels)
   - Carousel auto-cycle fix

## Testing Checklist

- [ ] Build and deploy updated files
- [ ] Test blog post navigation (should go to root, not blog/index)
- [ ] Test all 6 Creative Features card links
- [ ] Test all 4 Featured Projects card links  
- [ ] Test 3 YouTube subscribe buttons
- [ ] Verify carousel auto-advances
- [ ] Check footer icons (Spotify visible, no SoundCloud)
- [ ] Test footer links (all pretty URLs)
- [ ] Verify Discord section shows "Join Discord" and "Channel" buttons
- [ ] Check resume section says "Visit the Resume Page"
- [ ] Verify Patreon section has updated text
- [ ] Test header navigation on blog posts (7 items only)

## Deploy Command
```powershell
# Build assets
.\scripts\build.ps1

# Build deploy package (test mode)
.\scripts\deploy.ps1 -BuildOnly

# Copy .htaccess
Copy-Item public_html\.htaccess deploy\.htaccess -Force

# Deploy to production (when ready)
.\scripts\deploy.ps1
```

## Notes

- Navigation now has only 7 core pages in header (Home, Game Dev, Blog, DIY, Patreon, Services, Links)
- Music, Gaming, Live, Resume, and Voice Acting pages moved to /links directory access
- All links use pretty URLs (no .php extensions visible)
- Blog post headers now correctly link to site root (/)
- Social icons reorganized with email first, Patreon heart on right
- All cards are now clickable for better UX
- YouTube subscribe buttons use proper channel URLs with confirmation parameter

---
*Last Updated: October 15, 2025*
*Author: GitHub Copilot*
