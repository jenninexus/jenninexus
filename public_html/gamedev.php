<?php
$activePage = 'gamedev';
$pageTitle = 'Game Development Portfolio - JenniNexus | Seattle Indie Game Developer';
$pageDescription = 'Professional game development portfolio featuring Unity, Unreal Engine, VR games, and 3D character art. Seattle Indies member specializing in indie game development, game jams, and technical art. Available for hire.';
$pageKeywords = 'Seattle game developer, Tacoma indie games, Unity game development, Unreal Engine projects, VR game developer Seattle, Steam games, game jam developer, Seattle Indies member, hire game developer Washington, 3D game artist, technical artist Seattle, Purgatory Fell VR, indie game studio Seattle, game development portfolio, freelance game developer, Pacific Northwest game dev, Washington state game industry, game design services, Martian Games, professional game developer for hire';

// Page-specific CSS
$customCSS = [
  '/resources/css/gamedev-theme.min.css'
];
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <?php include __DIR__ . '/includes/head.php'; ?>
  <body>
    
  <?php include __DIR__ . '/includes/header.php'; ?>
  
    <!-- Mobile offcanvas removed: using shared offcanvas from includes/header.php -->

    <!-- Hero Section -->
    <div class="gamedev-hero text-white py-5 hero-section">
      <div class="container py-5" >
        <div class="row align-items-center">
          <div class="col-lg-8 glass-panel p-4 rounded-4">
            <h1 class="display-4 fw-bold mb-3 hero-title">
              <span class="fs-2 fs-md-1">Game Development</span>
            </h1>
            <p class="lead mb-4 fs-5 fs-md-4">
              Explore original game projects, VR experiences, and comprehensive tutorials covering Unity, Unreal Engine, Blender, and more.
            </p>
          </div>
          <div class="col-lg-4 text-center d-none d-lg-block">
            <i class="fa-solid fa-gamepad gamedev-icon-glow" style="font-size: 8rem; color: #66c0f4;"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Featured Games Section with Proper Container -->
    <section id="our-games-section" class="py-5 gamedev-section-alt">
      <div class="container">
        <!-- Section Title -->
        <div class="row mb-4">
          <div class="col-12 text-center">
            <h2 class="display-6 mb-3">Featured Game Projects</h2>
            <p class="text-muted">Original games and development showcases</p>
          </div>
        </div>

        <!-- DYNAMIC ROW – youtube-grid.js fills this -->
        <div id="featured-playlists" class="row g-4 mb-4" data-tags="gamedev,playlists,youtube">
          <!-- Playlist cards will be rendered here by youtube-grid.js -->
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <div class="container my-5">
      <!-- Content Categories (index-style tag UI) -->
      <div class="row mb-4">
        <div class="col-lg-8 mx-auto text-center">
          <h2 class="h4 mb-2">Content Categories</h2>
          <p class="small text-muted">Quick filters for site content (tags)</p>

          <div class="d-flex flex-wrap justify-content-center gap-2 mt-2">
            <button class="btn btn-sm btn-primary active" data-filter="all">All Content</button>
            <button class="btn btn-sm btn-outline-primary" data-filter="gamedev">Game Dev</button>
            <button class="btn btn-sm btn-outline-primary" data-filter="gaming">Gaming</button>
            <button class="btn btn-sm btn-outline-primary" data-filter="diy">DIY</button>
            <button class="btn btn-sm btn-outline-primary" data-filter="music">Music</button>
            <button class="btn btn-sm btn-outline-primary" data-filter="voice-acting">Voice Acting</button>
          </div>

          <div class="d-flex justify-content-center align-items-center gap-3 mt-3">
            <button class="btn btn-outline-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#tagFilterOffcanvas" aria-controls="tagFilterOffcanvas">
              <i class="fa-solid fa-filter"></i> Filter by Tags
            </button>
            <!-- activeFiltersContainer already present near footer in this page; no duplicate element added here -->
          </div>
        </div>
      </div>

      <!-- Game Jams Call-to-Action -->
      <div class="row g-4 mb-5">
        <div class="col-12 text-center">
          <h4 class="mb-2 fs-4">Game Jams & Ludum Dare</h4>
          <p class="text-muted mb-3 fs-6">All Ludum Dare and game jam playlists have moved to a dedicated page.</p>
          <a href="/game/gamejams.php" class="btn btn-lg btn-primary px-4 py-2 d-inline-flex align-items-center justify-content-center">
            <i class="fa-solid fa-bolt me-2 fs-4"></i>
            <span class="fs-5">View Game Jams</span>
          </a>
        </div>
      </div>
    </div>

    <!-- Learning Resources Section -->
      <section class="py-5 section-pastel gamedev-surface">
        <div class="container">
          <!-- Section Title -->
          <div class="row mb-4">
            <div class="col-12 text-center">
              <h2 class="display-6 mb-3">Learning Resources</h2>
              <p class="text-muted">Tutorials and tips for game development</p>
            </div>
          </div>
          
          <div id="learning-playlists" class="row g-4 mb-4" data-tags="gamedev,learning,playlists">
            <!-- Playlist cards will be rendered here by youtube-grid.js -->
          </div>
        </div>
      </section>
    </div>

    <script>
      (function(){
        const RES_ROOT = (typeof window !== 'undefined' && window.RES_ROOT) ? window.RES_ROOT : '/resources';
        const scriptUrl = RES_ROOT + '/js/youtube-grid.js';

        function loadGrid() {
          if (window.YouTubeGrid && typeof window.YouTubeGrid.loadPageConfig === 'function') {
            try { window.YouTubeGrid.loadPageConfig('gamedev'); } catch (e) { console.error('YouTubeGrid.loadPageConfig failed', e); }
            return;
          }
          const s = document.createElement('script');
          s.src = scriptUrl;
          s.defer = true;
          s.onload = function(){
            if (window.YouTubeGrid && typeof window.YouTubeGrid.loadPageConfig === 'function') {
              try { window.YouTubeGrid.loadPageConfig('gamedev'); } catch (e) { console.error('YouTubeGrid.loadPageConfig failed after load', e); }
            } else {
              console.warn('YouTubeGrid not available after script load');
              showFallbackMessage();
            }
          };
          s.onerror = function(){
            console.warn('Failed to load', scriptUrl);
            showFallbackMessage();
          };
          document.head.appendChild(s);
        }

        function showFallbackMessage(){
          const nodes = ['featured-playlists', 'learning-playlists', 'martian_games-playlists'];
          nodes.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
              el.innerHTML = '<div class="col-12"><div class="alert alert-secondary">Video grid unavailable. Refresh or try again later.</div></div>';
            }
          });
        }

        if (document.readyState === 'loading') {
          document.addEventListener('DOMContentLoaded', loadGrid);
        } else {
          loadGrid();
        }
      })();
    </script>

  <script src="<?= RES_ROOT ?>/js/tag-system.js"></script>

  <!-- Martian Games Section (updated to match Gaming page panel style) -->
  <div class="container my-5">
    <section class="mb-5">
        <div class="card border-0 shadow-lg martian-games-section">
          <div class="card-body p-4 p-md-5">
            <!-- Martian Games Header -->
            <div class="text-center mb-4">
              <h2 class="mb-3" style="font-family: 'Alien League', 'Alien League Bold', 'Montserrat', sans-serif; font-size: clamp(2rem, 5vw, 3.5rem); color: #66c0f4; text-shadow: 0 0 20px rgba(102, 192, 244, 0.5);">
                MARTIAN GAMES
              </h2>
              <p class="lead text-white-50 mb-2">Indie game development by Shade Muse featuring retro-inspired multiplayer mayhem</p>
              <div class="mb-4">
                <a href="https://martiangames.com" target="_blank" rel="noopener" class="btn btn-sm btn-outline-info">
                  <i class="bi bi-globe me-1"></i>Visit MartianGames.com
                </a>
                <a href="/game/martiangames" class="btn btn-sm btn-outline-primary ms-2">
                  <i class="bi bi-collection me-1"></i>View Full Martian Games Page
                </a>
              </div>

              <!-- Martian Games Social Links -->
              <div class="d-flex gap-3 justify-content-center mb-4 flex-wrap">
                <a href="https://steamcommunity.com/groups/martian-games" 
                   class="btn btn-steam d-inline-flex align-items-center gap-2" 
                   target="_blank" rel="noopener">
                  <i class="fa-brands fa-steam fs-5"></i>
                  <span>Steam Group</span>
                </a>
                <a href="https://www.youtube.com/@martiangames" 
                   class="btn btn-youtube d-inline-flex align-items-center gap-2" 
                   target="_blank" rel="noopener">
                  <i class="fa-brands fa-youtube fs-5"></i>
                  <span>YouTube</span>
                </a>
                <a href="https://www.patreon.com/cw/martiangames" 
                   class="btn btn-patreon d-inline-flex align-items-center gap-2" 
                   target="_blank" rel="noopener">
                  <i class="fa-brands fa-patreon fs-5"></i>
                  <span>Patreon</span>
                </a>
              </div>

              <!-- Martian Games Description -->
              <div class="row justify-content-center">
                <div class="col-lg-8">
                  <p class="text-white-50">Experience fast-paced retro multiplayer action with Tank Off, Air Wars, Motor Wars, and more! Classic arcade-style gameplay with modern online multiplayer.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Martian Games Playlists Section -->
      <section class="mb-5">
        <div class="container">
          <div class="text-center mb-4">
            <h3 class="mb-3" style="color: #66c0f4;">Martian Games Playlists</h3>
            <p class="text-muted">Development videos and gameplay from Shade Muse's Martian Games</p>
          </div>
          
          <!-- DYNAMIC ROW – youtube-grid.js fills this with playlist cards -->
          <div id="martian_games-playlists" class="row g-4" data-tags="martiangames,playlists,gamedev">
            <!-- Playlist cards will be rendered here by youtube-grid.js -->
          </div>
        </div>
      </section>

      <!-- More Featured Games Section -->
      <section id="other-games-preview" class="mb-5">
        <div class="text-center mb-4">
          <h3 class="mb-3 text-theme-adaptive">More Featured Games</h3>
          <p class="text-theme-adaptive opacity-75">Selected games from the game directory</p>
        </div>
        <div class="row g-4">
          <div class="col-md-4 content-item video-card" data-tags="cat-game,indie">
            <div class="card h-100 border-0 shadow-sm hover-lift">
              <div class="ratio ratio-16x9 overflow-hidden">
                <img src="<?= RES_ROOT ?>/images/gamedev/catgame/catgame.png" class="card-img-top" alt="Cat As Trophy" style="object-fit: cover; object-position: center;" onerror="this.onerror=null;this.src='<?= RES_ROOT ?>/images/placeholder-180.png';">
              </div>
              <div class="card-body d-flex flex-column">
                <h5 class="card-title text-theme-adaptive">Cat-As-Trophy</h5>
                <p class="text-muted small mb-3">Quirky cat-themed platformer</p>
                <div class="mt-auto">
                  <a href="/game/catgame.php" class="btn btn-outline-primary w-100">View</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 content-item video-card" data-tags="diy-fashion,indie">
            <div class="card h-100 border-0 shadow-sm hover-lift">
              <div class="ratio ratio-16x9 overflow-hidden">
                <img src="<?= RES_ROOT ?>/images/gamedev/jennistyles/jenni-styles.jpg" class="card-img-top" alt="Jenni Styles" style="object-fit: cover; object-position: center;" onerror="this.onerror=null;this.src='<?= RES_ROOT ?>/images/placeholder-180.png';">
              </div>
              <div class="card-body d-flex flex-column">
                <h5 class="card-title text-theme-adaptive">Jenni Styles</h5>
                <p class="text-muted small mb-3">Dress-up and style game</p>
                <div class="mt-auto">
                  <a href="/game/jennistyles.php" class="btn btn-outline-primary w-100">View</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 content-item video-card" data-tags="game-jam,arcade">
            <div class="card h-100 border-0 shadow-sm hover-lift">
              <div class="ratio ratio-16x9 overflow-hidden">
                <img src="<?= RES_ROOT ?>/images/gamedev/cowdefender/cow-defender.PNG" class="card-img-top" alt="Cow Defender" style="object-fit: cover; object-position: center;" onerror="this.onerror=null;this.src='<?= RES_ROOT ?>/images/placeholder-180.png';">
              </div>
              <div class="card-body d-flex flex-column">
                <h5 class="card-title text-theme-adaptive">Cow Defender</h5>
                <p class="text-muted small mb-3">Arcade shooter from game jams</p>
                <div class="mt-auto">
                  <a href="/game/cowdefender.php" class="btn btn-outline-primary w-100">View</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

    </div>

  <!-- Active Filters container (used by tag-system.js) -->
  <div id="activeFiltersContainer" style="display:none;">
    <div id="activeFilters" class="d-flex gap-2"></div>
  </div>

  <!-- Tag Filter Offcanvas (shared) -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="tagFilterOffcanvas" aria-labelledby="tagFilterOffcanvasLabel">
    <div class="offcanvas-header">
      <h5 id="tagFilterOffcanvasLabel">Filter by Tags</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="mb-3 jn-show-all-tags">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="jnShowAllTagsToggle">
          <label class="form-check-label small text-muted" for="jnShowAllTagsToggle">Show all tags</label>
        </div>
      </div>

      <div class="mb-3">
        <h6>Game Dev Tags</h6>
        <div id="gamedevTagsList" class="d-flex flex-wrap gap-2 mb-3"></div>
      </div>
      <div class="mb-3">
        <h6>Gaming Tags</h6>
        <div id="gamingTagsList" class="d-flex flex-wrap gap-2 mb-3"></div>
      </div>
      <div class="mb-3">
        <h6>DIY Tags</h6>
        <div id="diyTagsList" class="d-flex flex-wrap gap-2 mb-3"></div>
      </div>
      <div class="mb-3">
        <h6>Voice Acting Tags</h6>
        <div id="voiceTagsList" class="d-flex flex-wrap gap-2 mb-3"></div>
      </div>

      <div class="d-flex gap-2 mt-4">
        <button id="applyFilters" class="btn btn-primary">Apply Filters</button>
        <button id="clearFilters" class="btn btn-outline-secondary">Clear</button>
        <a href="/tags.php" class="btn btn-link ms-auto">View all tags</a>
      </div>
    </div>
  </div>

    <script>
      document.addEventListener('DOMContentLoaded', function () {
        if (window.YouTubeGrid && typeof window.YouTubeGrid.loadPageConfig === 'function') {
          window.YouTubeGrid.loadPageConfig('gamedev');
        }
        
        // Connect "Content Categories" buttons to the central TagFilter API
        const filterButtons = document.querySelectorAll('[data-filter]');
        
        // 1. Handle clicks
        filterButtons.forEach(button => {
          button.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            if (window.tagFilter) {
              if (filter === 'all') {
                window.tagFilter.clear();
              } else {
                // Exclusive filter behavior for these buttons: clear others, set this one
                // We use clear() then add() to simulate "radio button" behavior
                window.tagFilter.clear(); 
                window.tagFilter.add(filter);
              }
            }
          });
        });

        // 2. Listen for changes to update button states
        if (window.tagFilter) {
          window.tagFilter.onChange(activeFilters => {
            const activeSet = new Set(activeFilters);
            
            // "All" button state
            const allBtn = document.querySelector('[data-filter="all"]');
            if (allBtn) {
              if (activeSet.size === 0) {
                 allBtn.classList.remove('btn-outline-primary');
                 allBtn.classList.add('btn-primary', 'active');
              } else {
                 allBtn.classList.remove('btn-primary', 'active');
                 allBtn.classList.add('btn-outline-primary');
              }
            }
            
            // Other buttons
            filterButtons.forEach(btn => {
              const f = btn.dataset.filter;
              if (f === 'all') return;
              
              if (activeSet.has(f)) {
                btn.classList.remove('btn-outline-primary');
                btn.classList.add('btn-primary', 'active');
              } else {
                btn.classList.remove('btn-primary', 'active');
                btn.classList.add('btn-outline-primary');
              }
            });
          });
        }
      });
    </script>

    <!-- Seattle Indies block intentionally removed - shared in footer include -->

  <?php include __DIR__ . '/includes/footer.php'; ?>

  </body>
</html>
