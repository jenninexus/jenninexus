# Martian Games Organization Update
**Date:** 2025-01-28
**Status:** ✅ COMPLETED

## Overview
Updated all Botborgs references across the site and organized Martian Games structure on martiangames.php to distinguish between featured games (full sections) and additional games (simple listings).

## Changes Made

### 1. Botborgs Description Standardization
**New Description:** "Web3 game featuring 3D 'Botborg' characters and an interplanetary society and economic system"

**Files Updated:**
- ✅ `public_html/game/martiangames.php` - Botborgs section
  - Updated description
  - Changed badge from "Sci-Fi Action" to "Web3 • 3D Modeling"
  - Added Kotaku link: "Featured on Kotaku"
  
- ✅ `public_html/index.php` - Botborgs card
  - Updated card description from "Robot battle game featuring strategic combat and unique character designs" to new standard

- ✅ `public_html/game/purgatoryfell.php` - "More from Martian Games" section
  - Updated Botborgs card description
  - Changed badge from "Sci-Fi Action" to "Web3 • 3D"
  
- ✅ `public_html/game/botborgs.php` - Dedicated Botborgs page
  - Updated page meta description
  - Updated lead paragraph description
  - Enhanced Kotaku link with icon
  - Added GameJolt button with icon
  - Updated "About Botborgs" section description

**Note:** `public_html/gamedev.php` Botborgs card uses generic text "Gameplay & devlog playlists" - left as is since it's just a navigation card.

### 2. Martian Games Structure on martiangames.php

**Featured Games (Full Sections):**
1. **Purgatory Fell VR** - Complete section with Steam Early Access, YouTube playlist
2. **Tank Off** - Complete section with Steam link, YouTube playlist
3. **Botborgs** - Complete section with GameJolt, image gallery, YouTube playlist

**Additional Games Section:**
Added new "More Martian Games" section after Botborgs section featuring:

**Simple Listings (via martian-games.js):**
- Air Wars 3 (CrazyGames)
- Air Wars 2 (CrazyGames)
- Motor Wars 2 (CrazyGames)
- Air Toons (CrazyGames)
- Tank Off (original) (CrazyGames)
- Tank Off 2 (CrazyGames)

**Special Collaboration Card:**
- Cow Defender - Added dedicated card noting "JenniNexus Collaboration" with link to `/game/cowdefender.php`

### 3. Kotaku Coverage Integration

**Botborgs Kotaku Links Added/Enhanced:**
- `martiangames.php`: Added "Featured on Kotaku" text with link
- `botborgs.php`: Enhanced Kotaku link with newspaper icon, added as button alongside GameJolt
- All links use `target="_blank" rel="noopener"` for security

### 4. Game Jams Verification

**Verified Files:**
- ✅ `public_html/game/gamejams.php` - Clean, functional structure
- ✅ `public_html/resources/playlists/gamejams.yaml` - Well organized with 7 playlists:
  1. Ludum Dare gameplay
  2. Ludum Dare 46
  3. Ludum Dare 44
  4. Kitty McBlubberton
  5. Let's play LDJAM 38 entries
  6. Let's play LDJAM 40 entries
  7. Red Friday

**Grid Config:**
- 3 columns
- 6 videos per playlist
- Lazy loading enabled

## Martian Games Structure Summary

### Games with Full Features on JenniNexus:
1. **Purgatory Fell VR** - `/game/purgatoryfell.php`
2. **Tank Off** - Featured on `/game/martiangames.php#tankoff`
3. **Botborgs** - `/game/botborgs.php`
4. **Cow Defender** - `/game/cowdefender.php` (game jam collaboration)
5. **Soccer Cows** - `/game/soccercow.php` (game jam entry)

### Games with External Links Only:
- Air Wars 3, Air Wars 2, Motor Wars 2, Air Toons, Tank Off (original), Tank Off 2
- Listed in "More Martian Games" section via `martian-games.js`
- No dedicated JenniNexus pages
- No YouTube playlists in `playlist-ids.json`

## Technical Implementation

### martian-games.js Integration
The "More Martian Games" section on `martiangames.php` now uses:
```html
<div class="row g-4" id="martian-games-grid">
  <!-- Populated by martian-games.js -->
</div>
```

The JavaScript creates Bootstrap cards with:
- Game title
- CrazyGames link
- Thumbnail image
- Steam-inspired gradient styling

### Cow Defender Special Treatment
Added as a dedicated card below the martian-games.js grid:
- Badge: "JenniNexus Collaboration"
- Description: "A Ludum Dare game jam entry - defend the cows from alien invaders!"
- Link: Internal link to `/game/cowdefender.php`

## Files Modified
1. `public_html/game/martiangames.php`
2. `public_html/index.php`
3. `public_html/game/purgatoryfell.php`
4. `public_html/game/botborgs.php`

## Files Verified (No Changes Needed)
1. `public_html/game/gamejams.php`
2. `public_html/resources/playlists/gamejams.yaml`
3. `public_html/gamedev.php` (Botborgs card is generic navigation)
4. `public_html/resources/playlists/gamedev.yaml` (already updated by user)

## Testing Checklist
- [ ] Load `http://localhost:8002/game/martiangames.php`
- [ ] Verify Botborgs section shows new description
- [ ] Verify "More Martian Games" section displays 6 games from martian-games.js
- [ ] Verify Cow Defender card displays below the grid
- [ ] Click Kotaku link - should open in new tab
- [ ] Click GameJolt button - should open in new tab
- [ ] Load `/game/botborgs.php` - verify updated description
- [ ] Load `/index.php` - verify Botborgs card updated
- [ ] Load `/game/purgatoryfell.php` - verify "More from Martian Games" Botborgs card updated
- [ ] Load `/game/gamejams.php` - verify 7 playlists render correctly

## Next Steps
1. Test all updated pages on dev server (http://localhost:8002)
2. Proceed with CTA helper rollout to remaining 11 game pages
3. Implement "More Game Jams" sections on individual game pages
4. Add "Show More Indie Games" sections where specified in rollout plan

## Related Documents
- `GAME-PAGES-ROLLOUT-PLAN.md` - Comprehensive CTA helper implementation plan
- `TAG-SYSTEM.md` v2.1 - Unified tag system documentation
- `10-28.md` - Session notes and progress tracking
