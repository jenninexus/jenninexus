# Playlist Organization Update v2.2
**Date:** 2025-10-28
**Status:** ✅ COMPLETED

## Overview
Updated `playlist-ids.json` to v2.2 with comprehensive games section, clarified game jam classifications, and fixed Soccer Cow vs Cow Defender details. Added Martian Games Let's Play playlist for martiangames.php featured grid.

## Changes Made

### 1. playlist-ids.json v2.2 Updates ✅

**New `youtube.playlists.games` Structure:**

```json
"games": {
  "description": "Individual game playlists and Martian Games collection",
  "featured_playlists": [
    {
      "id": "PL9QBjNDhgNwTsF4Es4jEftJR2Tto1CU53",
      "title": "Purgatory Fell VR",
      "game_slug": "purgatoryfell",
      "game_page": "/game/purgatoryfell.php",
      "type": "devlogs",
      "category": "gamedev",
      "studio": "martiangames"
    },
    {
      "id": "PL9QBjNDhgNwRkcV9WLFJBsJnULSUDqPty",
      "title": "Martian Games Let's Play", ⭐ NEW
      "game_slug": "martiangames",
      "game_page": "/game/martiangames.php",
      "type": "letsplay",
      "studio": "martiangames"
    },
    // ... 4 more featured playlists
  ],
  "single_videos": [
    {
      "video_id": "4tke1Q6XKtE",
      "title": "Soccer Cows Gameplay",
      "game_slug": "soccercow",
      "is_game_jam": true ⭐ CLARIFIED
    }
  ],
  "external_games": [
    {
      "title": "Cow Defender",
      "game_slug": "cowdefender",
      "is_game_jam": false, ⭐ FIXED
      "studio": "martiangames",
      "external_url": "https://gamejolt.com/@JenniNexus"
    }
  ]
}
```

**Key Additions:**
- **Martian Games Let's Play** playlist (`PL9QBjNDhgNwRkcV9WLFJBsJnULSUDqPty`) for `/martiangames.php` featured grid
- **Game Jam Highlights** playlist (`PL9QBjNDhgNwTFn7QSZRbZGoKCCIsUlemX`)
- Three-tier structure: `featured_playlists`, `single_videos`, `external_games`
- Studio attribution for Martian Games games
- Game jam classification flags

### 2. gamejams.yaml Updates ✅

**Added Game Jam Highlights Playlist:**
```yaml
gamejams_section:
  playlists:
    # Game Jam Highlights - General compilation (not just Ludum Dare)
    - id: "PL9QBjNDhgNwTFn7QSZRbZGoKCCIsUlemX"
      title: "Game Jam Highlights"
      tags: ["game-jam","indie","gamedev","compilation"]
      description: "48-hour game jam projects compilation"
    
    # Ludum Dare specific playlists (7 total)
    - id: "PL6WnzXOaRqA19W60NFfCJNJOrr4SBPkZe"
      title: "Ludum Dare gameplay"
```

**Total Game Jam Playlists:** 8 (1 general highlights + 7 Ludum Dare specific)

### 3. Game Detail Fixes

#### Soccer Cows (`soccercow.php`) ✅
**Status:** Already correctly labeled as game jam entry
**Badge:** "Game Jam" badge present
**Fixed:** Removed incorrect "Game Jam" badge from Cow Defender card in "More Martian Games" section
**Changed Cow Defender badge from:** "Game Jam" → "Tower Defense"

#### Cow Defender (`cowdefender.php`) ✅
**Removed ALL game jam references:**
- Page title: "Game Jam Entry" → "Martian Games"
- Meta description: "48-hour game jam" → "Martian Games tower defense game"
- Lead text: "created in 48 hours for a game jam" → "from Martian Games"
- Badge: "Game Jam" + "48 Hours" → "Martian Games" + "Strategy"
- Section title: "Game Jam Challenge" → "Martian Games Collection"
- Icon: Lightning bolt (`bi-lightning-fill`) → Shield (`bi-shield-fill`)

**Added:**
- GameJolt link: `https://gamejolt.com/@JenniNexus`
- Martian Games studio attribution throughout
- Tower defense focus instead of game jam focus

#### martiangames.php ✅
**Updated Cow Defender Card:**
- Title: "JenniNexus Collaboration" → "Martian Games Tower Defense"
- Badge: "JenniNexus Collaboration" → "Tower Defense"
- Icon: Trophy → Shield
- Description: "A Ludum Dare game jam entry" → "Strategic tower defense game"
- Added GameJolt button with link

### 4. game-playlist-map.json Updates ✅
**Deprecation Notice Updated:**
```json
{
  "_comment": "DEPRECATED: This file is kept for reference only",
  "_migration_note": "Game playlists are now in playlist-ids.json v2.2 under youtube.playlists.games",
  "_reference": "See playlist-ids.json -> youtube.playlists.games -> featured_playlists, single_videos, and external_games",
  "_last_updated": "2025-10-28",
  "_status": "MIGRATED TO playlist-ids.json v2.2",
  "_new_features": "Added Martian Games Let's Play playlist, clarified Soccer Cow as game jam, Cow Defender as NOT game jam"
}
```

### 5. PLAYLIST-MAPPING.md Documentation ✅

**Updated to v3.2:**
- Documented new three-tier games structure
- Added game classifications section explaining Soccer Cow vs Cow Defender
- Updated migration checklist with v2.2 completion items
- Clarified Martian Games studio game list

**Game Classifications Table:**
| Game | Studio | Game Jam? | Platform | Notes |
|------|--------|-----------|----------|-------|
| **Soccer Cows** | Martian Games | ✅ YES | YouTube single video | Game jam entry |
| **Cow Defender** | Martian Games | ❌ NO | GameJolt | Tower defense game |
| **Purgatory Fell VR** | Martian Games | ❌ NO | Steam Early Access | Full playlist |
| **Botborgs** | Martian Games | ❌ NO | GameJolt, Kotaku | Full playlist |
| **Air Wars series** | Martian Games | ❌ NO | CrazyGames | External only |
| **Motor Wars 2** | Martian Games | ❌ NO | CrazyGames | External only |
| **Tank Off series** | Martian Games | ❌ NO | CrazyGames | External only |

## Technical Details

### Martian Games Let's Play Playlist
**Playlist ID:** `PL9QBjNDhgNwRkcV9WLFJBsJnULSUDqPty`
**Purpose:** Featured on `/game/martiangames.php` in playlist grid
**Type:** Let's Play compilation
**Content:** Various Martian Games titles gameplay

**Current Usage:**
```html
<!-- martiangames.php line 135 -->
<div class="video-grid-container" 
     id="martiangames-letsplay" 
     data-playlist="PL9QBjNDhgNwRkcV9WLFJBsJnULSUDqPty">
</div>
```

### Game Jam vs Non-Game Jam
**Decision Criteria:**
- If created in time-constrained game jam event → `is_game_jam: true`
- If developed as full project without jam constraints → `is_game_jam: false`

**Soccer Cows:** Created during game jam = game jam entry
**Cow Defender:** Full development cycle = NOT game jam

### External Games Tracking
New `external_games` array for games without YouTube playlists:
- Still part of studio catalog
- Have JenniNexus pages
- Link to external platforms (GameJolt, CrazyGames, etc.)
- Track game jam status
- Useful for "More Games" sections

## Files Modified

1. ✅ `public_html/resources/playlists/playlist-ids.json` (v2.0 → v2.2)
2. ✅ `public_html/resources/playlists/gamejams.yaml` (added Game Jam Highlights)
3. ✅ `public_html/resources/playlists/game-playlist-map.json` (updated deprecation notice)
4. ✅ `public_html/game/soccercow.php` (fixed Cow Defender card badge)
5. ✅ `public_html/game/cowdefender.php` (removed all game jam references)
6. ✅ `public_html/game/martiangames.php` (updated Cow Defender card)
7. ✅ `storage/docs/PLAYLIST-MAPPING.md` (v3.1 → v3.2)

## Testing Checklist

- [ ] Load `http://localhost:8002/game/martiangames.php` - verify Martian Games Let's Play playlist renders
- [ ] Load `/game/gamejams.php` - verify Game Jam Highlights playlist shows first
- [ ] Load `/game/soccercow.php` - verify "Game Jam" badge present, Cow Defender card shows "Tower Defense"
- [ ] Load `/game/cowdefender.php` - verify NO game jam references, Martian Games attribution present
- [ ] Check martiangames.php "More Martian Games" - verify Cow Defender card shows "Tower Defense" badge
- [ ] Verify GameJolt link works for Cow Defender
- [ ] Test playlist-ids.json v2.2 loading in youtube-grid.js

## Next Steps

1. **Test playlist rendering** on martiangames.php with new Let's Play playlist
2. **Verify game jam classifications** are correct across all pages
3. **Continue CTA helper rollout** to remaining 11 game pages
4. **Consider adding** Game Jam Highlights to gamedev.yaml featured section

## Related Documents

- `GAME-PAGES-ROLLOUT-PLAN.md` - CTA helper implementation plan
- `TAG-SYSTEM.md` v2.1 - Unified tag system
- `martian-games-organization-update.md` - Martian Games structure changes
- `10-28.md` - Session notes

## Version History

- **v2.0** (2025-09-30): Initial playlist-ids.json structure
- **v2.1** (2025-10-28): Added initial games section with 6 playlists
- **v2.2** (2025-10-28): Added Martian Games Let's Play, game jam classifications, external games tracking
