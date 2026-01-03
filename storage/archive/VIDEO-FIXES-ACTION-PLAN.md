# Video & Playlist Fixes - Action Plan
## October 15, 2025

## Critical Issues Found

### 1. **Live.php - CSS Error** 🔴
**Location:** End of file (lines 328-330)
**Issue:** Orphaned CSS keyframe rules outside of style tags
```css
0%, 100% { opacity: 1; }
50% { opacity: 0.5; }
}
```
**Fix:** Remove orphaned CSS or wrap in proper `<style>` tags

### 2. **Gaming.php - Missing Playlists** 🔴
**Issue:** Page shows no curated gaming playlists
**Expected:** Grid display of gaming playlists (Let's Plays, Walkthroughs, PAX coverage)
**Fix:** Add YouTube playlist embeds using grid layout

### 3. **Jennistyles.php - Missing Videos** 🔴
**Issue:** No development videos/gameplay footage
**Expected:** Gameplay videos and devlog content
**Fix:** Add YouTube video embeds

### 4. **Game Pages - Inconsistent Video Embeds** 🟡
**Working Example:** `/cowdefender` - Has proper 16:9 responsive video embed
**Issues:** Other game pages missing or have oversized embeds
**Pages to Check:**
- /purgatoryfell
- /botborgs
- /jennistyles
- /martiangames
- /catgame
- /blueballs
- /graveyardsmashers
- /cleanupinisle3
- /momshouse
- /soccercow

### 5. **Martiangames - Videos Not Showing** 🔴
**Issue:** Playlists/videos don't display
**Fix:** Check YouTube Grid implementation, add fallback embeds

## Video Embed Standards

### ✅ GOOD Example (from cowdefender.php):
```html
<div class="ratio ratio-16x9 rounded overflow-hidden">
  <iframe src="https://www.youtube.com/embed/VIDEO_ID" 
          title="Video Title" 
          frameborder="0" 
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
          allowfullscreen></iframe>
</div>
```

**Why This Works:**
- Uses Bootstrap's `.ratio` utility class
- `ratio-16x9` maintains proper aspect ratio
- Responsive - scales to container width
- Not "huge" - respects card/section width
- Rounded corners with `rounded`
- Clean overflow handling

### ❌ AVOID:
- Fixed width/height iframes
- Missing ratio container
- Full-width without constraints
- No responsive sizing

## Fix Priority

### Phase 1: Critical Bugs (Do Now)
1. ✅ Fix live.php CSS error
2. ✅ Add gaming.php playlists
3. ✅ Add jennistyles.php videos
4. ✅ Fix martiangames videos

### Phase 2: Game Page Videos (Next)
5. ✅ Check all game pages for video embeds
6. ✅ Standardize video embed code across all pages
7. ✅ Ensure all use cowdefender.php method

### Phase 3: Header/Footer Consistency (After Videos)
8. Update gaming.php to use includes/header.php
9. Update live.php to use includes/header.php
10. Update jennistyles.php to use includes/header.php

## Implementation Notes

### For Playlists (Gaming, DIY, Music pages):
```html
<div class="row g-4">
  <div class="col-md-6 col-lg-4">
    <div class="card h-100 border-0 shadow-sm">
      <div class="ratio ratio-16x9">
        <iframe src="https://www.youtube.com/embed/videoseries?list=PLAYLIST_ID" 
                title="Playlist Title" 
                frameborder="0" 
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                allowfullscreen></iframe>
      </div>
      <div class="card-body">
        <h5 class="card-title">Playlist Name</h5>
        <p class="card-text small text-muted">Description</p>
      </div>
    </div>
  </div>
</div>
```

### For Single Videos (Game pages):
```html
<section class="mb-5">
  <h2 class="mb-4">Gameplay Video</h2>
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card border-0 shadow-lg">
        <div class="card-body p-0">
          <div class="ratio ratio-16x9">
            <iframe src="https://www.youtube.com/embed/VIDEO_ID" 
                    title="Video Title" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen></iframe>
          </div>
        </div>
        <div class="card-body">
          <h5>Video Title</h5>
          <p class="text-muted mb-0">Video description</p>
        </div>
      </div>
    </div>
  </div>
</section>
```

## Playlist IDs Needed

### Gaming Playlists:
- Let's Plays: `PLxxxxxx`
- Walkthroughs: `PLxxxxxx`
- PAX West Coverage: `PLxxxxxx`
- Gaming Highlights: `PLxxxxxx`

### DIY Playlists:
- Fashion Tutorials: `PLxxxxxx`
- Nail Art: `PLxxxxxx`
- Hair Tutorials: `PLxxxxxx`
- Beauty & Makeup: `PLxxxxxx`

### Game-Specific Videos:
- Jenni Styles: `VIDEO_ID`
- Martian Games: `PLAYLIST_ID`
- Purgatory Fell: `VIDEO_ID`
- Botborgs: `VIDEO_ID`

## Testing Checklist

### After Each Fix:
- [ ] Video loads properly
- [ ] Maintains 16:9 aspect ratio
- [ ] Responsive on mobile
- [ ] Not oversized on desktop
- [ ] Card layout looks good
- [ ] No console errors

### Pages to Verify:
- [ ] /gaming - Playlists display
- [ ] /live - CSS error gone, footer correct
- [ ] /jennistyles - Videos show, pretty URL works
- [ ] /martiangames - Videos/playlists working
- [ ] All game pages - Consistent video embeds

---
*Last Updated: October 15, 2025*
