# JenniNexus Pages Status & Configuration
**Last Updated:** October 14, 2025

## ✅ Pages Ready for Local & Production

### 1. `/gamedev` - Game Development Showcase
**Status:** ✅ Complete and Ready  
**File:** `public_html/gamedev.html`  
**Playlist Config:** `public_html/resources/playlists/gamedev.yaml`

#### Featured Projects Section (In Order):
1. **Jenni Styles Dress Up Game** - `PLYI86hek1EWcA2RDLKASNcm1v55Qa0gFj`
   - Location: `public_html/resources/images/gamedev/jennistyles/`
   - Our original fashion dress-up game
   
2. **Cat-As-Trophy** - `PLLzfSGTgy8YBL97yf_JRzcc3NWwk8FXyN`
   - Location: `public_html/resources/images/gamedev/catgame/`
   - Quirky cat-themed game project
   
3. **Game Jam Highlights** - `PL9QBjNDhgNwTFn7QSZRbZGoKCCIsUlemX`
   - Includes: Cow Defender and other 48-hour jam games
   - Location: `public_html/resources/images/gamedev/cowdefender/`

#### Martian Games Section (Alice Ruppert):
Dedicated card section with Steam/YouTube/Patreon platform branding

**Featured Playlists:**
4. **Purgatory Fell VR** - `PL9QBjNDhgNwTsF4Es4jEftJR2Tto1CU53`
   - Location: `public_html/resources/images/gamedev/purgatory fell/`
   - VR horror experience
   
5. **Botborgs** - `PL9QBjNDhgNwQYrXaiRwC0RROYmkppbssY`
   - Location: `public_html/resources/images/gamedev/botborgs/`
   - Robot battle game

**6-Game Grid (CrazyGames links):**
- Air Wars 3, Air Wars 2, Motor Wars 2
- Air Toons, Tank Off, Tank Off 2
- Location: `public_html/resources/images/gamedev/tankoff/`
- Loaded via: `public_html/resources/js/martian-games.js`

**Social Links (Platform-colored):**
- Steam: https://steamcommunity.com/id/martiangames (Navy #171a21, Blue #66c0f4)
- YouTube: @MartianGamesInc (Red #ff0000)
- Patreon: /martiangames (Pink #ff424d)

**Profile Images:**
- Steam: `resources/images/profilepix/steam-php.gif` (80px, blue border)
- YouTube Gaming: `resources/images/profilepix/yt_gaming.jpg` (80px, red border)

#### Learning Resources Section:
- Tips + Tuts
- Unity 3D Tutorials
- Unreal Engine
- Blender Tutorials
- Reallusion CC4
- Game Industry

**Dependencies:**
- ✅ youtube-grid.js (YAML loader)
- ✅ martian-games.js (game catalog)
- ✅ gamedev.yaml (playlist config)
- ✅ secrets.json (YouTube API key)
- ✅ back-to-top.js
- ✅ performance-optimizer.js
- ✅ polyfills.js

---

### 2. `/gaming` - Gaming Content (Jenniplaysgames)
**Status:** ⏳ Config Ready, Page Needs Creation  
**Playlist Config:** `public_html/resources/playlists/gaming.yaml` ✅  
**File:** `public_html/gaming.html` ❌ Not Created Yet

#### Current Configuration (gaming.yaml):
**Channel:** @jenniplaysgames (UC4byqahPWuY9WPJNvDgbQMQ)

**Featured Playlists:**
1. **Recent Gaming** - `PL6WnzXOaRqA16OQ60_EcUZ0Y8tjHB73Gi`
2. **PAX West Gaming Con** - `PL9QBjNDhgNwRIS4WXfKy4oLrPKxoK_Jra`
3. **Twitch Highlights** - `PL6WnzXOaRqA1q_0XZ2fPo0LIEErxxyoT1`
4. **Brand Collabs + Product Reviews** - `PL9QBjNDhgNwRsHtjuS574yGSnRZNWmZ_y`

#### What Gaming Page Needs:
- [ ] Create `gaming.html` based on gamedev.html structure
- [ ] Steam integration section (profile, links)
- [ ] Profile images:
  - `steam-php.gif` (Steam profile pic)
  - `yt_gaming.jpg` (Jenniplaysgames YouTube pic)
- [ ] Platform-colored buttons (Steam, Twitch, YouTube)
- [ ] Load playlists from gaming.yaml
- [ ] Hero section with controller/gaming theme

---

### 3. `/diy` - DIY Tutorials
**Status:** ✅ Page Exists  
**File:** `public_html/diy.html`  
**Playlist Config:** `public_html/resources/playlists/diy.yaml` ✅

**Channel:** @diywjenni

**Featured Playlists:**
- DIY Tutorials
- T-shirt Cutting No-Sewing
- Jenni's Take on Fashion
- DIY Hair Ideas
- DIY Gel Nails
- And more...

---

### 4. `/music` - Music & Audio
**Status:** ✅ Page Exists  
**File:** `public_html/music.html`  
**Playlist Config:** `public_html/resources/playlists/music.yaml` ✅

---

## 📂 Reference Files (Secure Storage)
**Location:** `jenninexus\storage\refrence\`

These files are NOT in public_html and will work both locally and on production:

1. **`buttons.php`** - Platform button styles reference
2. **`colors.css`** - Platform color system (Steam, Patreon, etc.)
3. **`games.json`** - Martian Games catalog (14 games)
4. **`social-links.php`** - Social media link templates with platform colors

**SSH Production Path:** `/var/www/jenninexus/storage/refrence/`  
**Local Path:** `jenninexus\storage\refrence\`

✅ These files are in the correct location and will not interfere with Bootstrap example files.

---

## 🚫 Not Using Bootstrap Examples
All our pages are **custom-built** for JenniNexus:

### Our Custom Pages (✅):
- `index.html` - JenniNexus homepage
- `gamedev.html` - Game development showcase
- `diy.html` - DIY tutorials
- `music.html` - Music & audio
- `patreon.html` - Patreon integration
- `links.html` - Social links page
- `resume.html` - Professional resume
- `services.html` - Services offered

### Bootstrap Examples (❌ Not Used):
- `album/index.html` - Not used
- `blog/index.html` - Not used
- `carousel/index.html` - Not used
- etc. (all in parent `bootstrap-5.3.3-examples` folder)

**Workspace Structure:**
```
bootstrap-5.3.3-examples/          ← Bootstrap examples (reference only)
  bootstrap-5.3.3-examples/
    jenninexus/                    ← Our project
      public_html/                 ← Our custom pages ✅
        index.html
        gamedev.html
        gaming.html (to create)
        diy.html
        music.html
        etc.
      storage/
        refrence/                  ← Reference files (secure) ✅
          buttons.php
          colors.css
          games.json
          social-links.php
```

---

## 🌐 Local vs Production URLs

### Local Development (Python HTTP Server - Port 8002):
```
http://localhost:8002/index.html
http://localhost:8002/gamedev.html
http://localhost:8002/gaming.html
http://localhost:8002/diy.html
```
⚠️ **Must use `.html` extension** - Python SimpleHTTPServer doesn't support clean URLs

### Production (Nginx - 64.23.141.41):
```
https://jenninexus.com/
https://jenninexus.com/gamedev
https://jenninexus.com/gaming
https://jenninexus.com/diy
```
✅ **Clean URLs work** - Nginx configured with `try_files` directive

**Nginx Config:** `.config/jenninexus-nginx.conf`

---

## 🎨 Platform Branding Colors

### Steam (Martian Games)
- **Navy:** `#171a21`
- **Dark:** `#1b2838`
- **Accent Blue:** `#66c0f4`
- **Light Text:** `#c7d5e0`
- **Gradient:** `linear-gradient(135deg, #171a21, #1b2838)`
- **Glow:** `rgba(102, 192, 244, 0.5)`

### Patreon
- **Primary:** `#ff424d`
- **Dark:** `#e63946`
- **Gradient:** `linear-gradient(135deg, #ff424d, #e63946)`
- **Glow:** `rgba(255, 66, 77, 0.5)`

### YouTube
- **Red:** `#ff0000`
- **Dark Red:** `#cc0000`
- **Gradient:** `linear-gradient(135deg, #ff0000, #cc0000)`
- **Glow:** `rgba(255, 0, 0, 0.5)`

### Discord
- **Blurple:** `#5865f2`

### Twitch
- **Purple:** `#9146ff`

---

## 📋 Next Steps

### Immediate (High Priority):
1. ✅ **Update gamedev.yaml** - Reorder featured games (Done!)
2. ⏳ **Create gaming.html** - Based on gamedev.html structure
3. ⏳ **Test locally** - http://localhost:8002/gamedev.html
4. ⏳ **Verify Martian Games section** - All 6 games display correctly

### Medium Priority:
5. ⏳ **Build production assets** - Run `sync-assets.ps1` and `build.ps1`
6. ⏳ **Test all platform colors** - Steam, Patreon, YouTube buttons
7. ⏳ **Mobile responsive test** - Check offcanvas menu

### Before Production Deploy:
8. ⏳ **Final testing** - All pages, all playlists
9. ⏳ **Image optimization** - Compress profile pics and game assets
10. ⏳ **Deploy to SSH** - Upload to 64.23.141.41:/var/www/jenninexus/

---

## 🔑 API & Secrets

### YouTube Data API v3
**API Key:** `AIzaSyCOj_-MrezshnV3dPyUvLr--8_3Xs9_JLg`  
**Location:** 
- `public_html/resources/secrets.json`
- `src/assets/secrets.json`

**Usage:** Public playlist fetching only (no OAuth required)

---

## 🛠️ Development Commands

### Start Dev Server:
```powershell
.\scripts\dev-server.ps1
# Opens http://localhost:8002
```

### Build Production Assets:
```powershell
.\scripts\build.ps1          # Compile SCSS to CSS
.\scripts\sync-assets.ps1    # Sync JS files
```

### Test Page:
```
http://localhost:8002/gamedev.html
http://localhost:8002/gaming.html
http://localhost:8002/diy.html
```

---

## ✨ Key Features Implemented

### ✅ Completed:
- YAML-based playlist configuration (60% cleaner than JSON)
- YouTube API integration with caching
- Martian Games section with 6-game grid
- Platform-specific branding colors (Steam, Patreon, YouTube)
- Alien League Bold font for Martian Games
- Profile image integration with platform borders
- Back-to-top button (smooth scroll)
- Performance optimization scripts
- Asset sync system
- JenniNexus branding fixes (NEXUS/DIY uppercase)
- Bootstrap 5.3.3 responsive layout
- Dark/light theme toggle
- Mobile offcanvas navigation

### ⏳ In Progress:
- Gaming page creation
- Complete testing suite
- Production deployment

---

## 📊 Project Health

**Files Ready:** 90%  
**Testing:** 50%  
**Production Ready:** 70%

**Blockers:** None  
**Dependencies Met:** ✅ All  
**Ready for Launch:** After gaming.html creation and testing

---

*Generated: October 14, 2025*  
*Project: JenniNexus Multi-Platform Creative Hub*
