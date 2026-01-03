<?php
$activePage = 'gaming';
$pageTitle = 'Gaming | JenniNexus';
$pageDescription = 'Gaming Content - Let\'s Plays, walkthroughs, PAX West coverage, and gaming highlights from JenniNexus';
$pageKeywords = 'gaming, lets plays, walkthroughs, pax west, steam games, ps5, nintendo switch, gaming highlights';
$resourceRoot = defined('RES_ROOT') ? RES_ROOT : '/resources';
$customCSS = [$resourceRoot . '/css/gaming-theme.min.css'];
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <?php include __DIR__ . '/includes/head.php'; ?>
  <body>
    
    <?php include __DIR__ . '/includes/header.php'; ?>

    <!-- Mobile offcanvas removed: using shared offcanvas from includes/header.php -->

    <!-- Hero Section -->
    <div class="hero-section bg-dark text-white py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;">
      <div class="container py-5" >
        <div class="row align-items-center">
          <div class="col-lg-8 mx-auto text-center">
            <div class="glass-panel p-5 rounded-4 shadow-lg">
              <div class="mb-4 hero-title">
                <i class="fa-solid fa-gamepad fa-bounce display-1" style="--fa-animation-duration: 2s; color: #ffffff; filter: drop-shadow(0 0 20px rgba(102, 126, 234, 0.8));"></i>
              </div>
              <h1 class="display-3 fw-bold mb-3 hero-title">Gaming</h1>
              <p class="lead mb-4 hero-title">Let's Plays, walkthroughs, gaming highlights, and PAX West coverage</p>
              
              <!-- Social Gaming Links -->
              <div class="d-flex gap-3 justify-content-center flex-wrap hero-title">
                <a href="https://youtube.com/@jenniplaysgames" target="_blank" class="btn btn-lg btn-light">
                  <i class="fa-brands fa-youtube me-2"></i>JenniPlaysGames
                </a>
                <a href="https://twitch.tv/jenninexus" target="_blank" class="btn btn-lg btn-outline-light">
                  <i class="fa-brands fa-twitch me-2"></i>Watch Live
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tag Filter Section (Consolidated & Functional) -->
    <section class="py-3 section-pastel gaming-surface">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <div class="text-center mb-3">
              <h5 class="mb-2">Filter Gaming Content</h5>
              <p class="small text-muted mb-3">Click tags to filter playlists and content</p>
            </div>
            
            <!-- Platform Tags -->
            <div class="mb-3">
              <h6 class="small text-muted mb-2 text-center">Platform Tags</h6>
              <div class="d-flex flex-wrap justify-content-center gap-2">
                <button class="badge bg-dark text-white p-2 border-0" style="cursor: pointer;" data-tag="console" onclick="window.tagFilter?.toggle('console')">
                  <i class="fa-solid fa-gamepad me-1"></i>Console
                </button>
                <button class="badge bg-dark text-white p-2 border-0" style="cursor: pointer;" data-tag="steam-games" onclick="window.tagFilter?.toggle('steam-games')">
                  <i class="fa-brands fa-steam me-1"></i>Steam
                </button>
                <button class="badge bg-dark text-white p-2 border-0" style="cursor: pointer;" data-tag="ps5" onclick="window.tagFilter?.toggle('ps5')">
                  <i class="fa-brands fa-playstation me-1"></i>PS5
                </button>
                <button class="badge bg-dark text-white p-2 border-0" style="cursor: pointer;" data-tag="nintendo-switch" onclick="window.tagFilter?.toggle('nintendo-switch')">
                  <i class="fa-solid fa-gamepad me-1"></i>Switch
                </button>
                <button class="badge bg-dark text-white p-2 border-0" style="cursor: pointer;" data-tag="retro" onclick="window.tagFilter?.toggle('retro')">
                  <i class="fa-solid fa-ghost me-1"></i>Retro
                </button>
                <button class="badge bg-dark text-white p-2 border-0" style="cursor: pointer;" data-tag="vr" onclick="window.tagFilter?.toggle('vr')">
                  <i class="fa-solid fa-vr-cardboard me-1"></i>VR
                </button>
              </div>
            </div>
            
            <!-- Genre Tags -->
            <div class="mb-3">
              <h6 class="small text-muted mb-2 text-center">Genre Tags</h6>
              <div class="d-flex flex-wrap justify-content-center gap-2">
                <button class="badge bg-danger bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="horror" onclick="window.tagFilter?.toggle('horror')">
                  <i class="fa-solid fa-ghost me-1"></i>Horror
                </button>
                <button class="badge bg-warning bg-opacity-75 text-dark p-2 border-0" style="cursor: pointer;" data-tag="fps" onclick="window.tagFilter?.toggle('fps')">
                  <i class="fa-solid fa-crosshairs me-1"></i>FPS
                </button>
                <button class="badge bg-info bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="rpg" onclick="window.tagFilter?.toggle('rpg')">
                  <i class="fa-solid fa-dragon me-1"></i>RPG
                </button>
                <button class="badge bg-success bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="indie" onclick="window.tagFilter?.toggle('indie')">
                  <i class="fa-solid fa-lightbulb me-1"></i>Indie
                </button>
                <button class="badge bg-primary bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="action" onclick="window.tagFilter?.toggle('action')">
                  <i class="fa-solid fa-person-running me-1"></i>Action
                </button>
                <button class="badge bg-secondary bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="puzzle" onclick="window.tagFilter?.toggle('puzzle')">
                  <i class="fa-solid fa-puzzle-piece me-1"></i>Puzzle
                </button>
                <button class="badge bg-purple bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="platformer" onclick="window.tagFilter?.toggle('platformer')">
                  <i class="fa-solid fa-stairs me-1"></i>Platformer
                </button>
              </div>
            </div>
            
            <!-- Advanced Filter Button -->
            <div class="text-center">
              <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#tagFilterOffcanvas">
                <i class="fa-solid fa-filter me-2"></i>Advanced Tag Filters
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Quick Jump Navigation -->
    <div class="container my-4">
      <div class="row">
        <div class="col-12 text-center">
          <div class="d-flex justify-content-center gap-2 flex-wrap">
            <a href="#horror" class="btn btn-outline-danger btn-sm">Horror</a>
            <a href="#indie" class="btn btn-outline-success btn-sm">Indie</a>
            <a href="#retro" class="btn btn-outline-warning btn-sm">Retro</a>
            <a href="#gaming-playlists-container" class="btn btn-outline-info btn-sm">All Playlists</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="container my-5">
      
      <!-- Featured Series (Pattern 2: Multi-Video Layout) -->
      <section id="featured-series-section" class="mb-5">
        <h2 class="display-6 text-center mb-4 text-theme-adaptive">Featured Series</h2>
        <div id="featured-series" class="row g-4">
          <!-- Populated by youtube-grid.js from gaming.yaml -->
          <div class="col-12 text-center py-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading featured series...</span>
            </div>
          </div>
        </div>
      </section>
      
      <!-- All Gaming Playlists (Pattern 1: Single Card Layout) -->
      <section id="all-playlists-section" class="mb-5">
        <h2 class="display-6 text-center mb-4 text-theme-adaptive">Gaming Playlists</h2>
        <div id="all-playlists" class="row g-4">
          <!-- Populated by youtube-grid.js from gaming.yaml -->
          <div class="col-12 text-center py-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading playlists...</span>
            </div>
          </div>
        </div>
      </section>

      <!-- Latest Gaming Videos Section (RSS Feed from @jenniplaysgames) -->
      <section id="latest-gaming-videos" class="mb-5">
        <div class="container-fluid">
          <div class="row mb-4">
            <div class="col-12 text-center">
              <h2 class="display-6 mb-3">
                <i class="fa-solid fa-video text-danger me-2"></i>Latest Gaming Videos
              </h2>
              <p class="lead text-muted">Fresh gaming content from @jenniplaysgames</p>
            </div>
          </div>
          
          <div id="gaming-feed" class="row g-4">
            <!-- Populated by youtube-grid.js from gaming.yaml -->
            <div class="col-12 text-center py-5">
              <div class="spinner-border text-danger" role="status">
                <span class="visually-hidden">Loading latest videos...</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- JenniNexus Steam Curator Section -->
      <section class="mb-5">
        <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #1b2838 0%, #2a475e 100%);">
          <div class="card-body p-4 p-md-5">
            <div class="row align-items-center">
       <div class="col-md-3 text-center mb-4 mb-md-0">
       <img src="<?= RES_ROOT ?>/images/profilepix/steam-php.gif" 
         alt="JenniNexus Steam Curator" 
         class="rounded-circle shadow" 
         style="width: 150px; height: 150px; border: 3px solid #66c0f4;">
        </div>
              <div class="col-md-9 text-white">
                <h2 class="mb-3" style="color: #66c0f4;">
                  <i class="fa-brands fa-steam me-2"></i>JenniNexus Steam Curator
                </h2>
                <p class="lead mb-4">Follow my curated game recommendations and reviews on Steam!</p>
                <a href="https://store.steampowered.com/curator/31703576-Jenni-Nexus-Experience/" 
                   target="_blank" 
                   rel="noopener"
                   class="btn btn-lg d-inline-flex align-items-center gap-2"
                   style="background: linear-gradient(135deg, #171a21, #1b2838); border: 2px solid #66c0f4; color: #c7d5e0;">
                  <i class="fa-brands fa-steam fs-5"></i>
                  <span>View Curator Page</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Martian Games Section -->
      <section class="mb-5">
        <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #171a21 0%, #1b2838 100%);">
          <div class="card-body p-4 p-md-5">
            <!-- Martian Games Header -->
            <div class="text-center mb-4">
              <h2 class="mb-3" style="font-family: 'Alien League', 'Alien League Bold', 'Montserrat', sans-serif; font-size: clamp(2rem, 5vw, 3.5rem); color: #66c0f4; text-shadow: 0 0 20px rgba(102, 192, 244, 0.5);">
                <a href="https://martiangames.com" target="_blank" rel="noopener" style="color: inherit; text-decoration: none;">MARTIAN GAMES</a>
              </h2>
              <p class="lead text-white-50 mb-4">Indie game development by Shade Muse featuring retro-inspired multiplayer mayhem</p>
              
              <!-- Martian Games Social Links -->
              <div class="d-flex gap-3 justify-content-center mb-4 flex-wrap">
                <a href="https://steamcommunity.com/groups/martian-games" 
                   class="btn btn-steam d-inline-flex align-items-center gap-2" 
                   target="_blank" 
                   rel="noopener"
                   style="background: linear-gradient(135deg, #171a21, #1b2838); border: 2px solid #66c0f4; color: #c7d5e0;">
                  <i class="fa-brands fa-steam fs-5"></i>
                  <span>Steam Group</span>
                </a>
                <a href="https://www.youtube.com/@martiangames" 
                   class="btn btn-youtube d-inline-flex align-items-center gap-2" 
                   target="_blank" 
                   rel="noopener"
                   style="background: linear-gradient(135deg, #ff0000, #cc0000); border: 2px solid #ff0000; color: white;">
                  <i class="fa-brands fa-youtube fs-5"></i>
                  <span>YouTube</span>
                </a>
                <a href="https://www.patreon.com/cw/martiangames" 
                   class="btn btn-patreon-mg d-inline-flex align-items-center gap-2" 
                   target="_blank" 
                   rel="noopener"
                   style="background: linear-gradient(135deg, #ff424d, #e63946); border: 2px solid #ff424d; color: white;">
                  <i class="fa-brands fa-patreon fs-5"></i>
                  <span>Patreon</span>
                </a>
                <!-- Removed martiangames.com button; title now links to the Martian Games site -->
              </div>
              
              <!-- Martian Games Description -->
              <div class="row justify-content-center">
                <div class="col-lg-8">
                  <p class="text-white-50">
                    Experience fast-paced retro multiplayer action with Tank Off, Air Wars, Motor Wars, and more! 
                    Classic arcade-style gameplay with modern online multiplayer.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Community Section -->
      <section class="mb-5">
        <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
          <div class="card-body p-4 p-md-5 text-white text-center">
            <i class="fa-brands fa-discord display-4 mb-3"></i>
            <h3 class="mb-3">Join the Gaming Community</h3>
            <p class="lead mb-4">Connect with other gamers, share tips, and get updates on new content</p>
            <div class="d-flex gap-3 justify-content-center flex-wrap">
              <a href="https://discord.gg/dc86JqBntj" target="_blank" class="btn btn-lg btn-light">
                <i class="fa-brands fa-discord me-2"></i>Gaming Discord
              </a>
              <a href="https://patreon.com/jenninexus" target="_blank" class="btn btn-lg btn-outline-light">
                <i class="fa-brands fa-patreon me-2"></i>Support on Patreon
              </a>
            </div>
          </div>
        </div>
      </section>

    </div>

    <!-- Gaming Blog Posts -->
    <section class="py-5 gaming-blog-section">
      <div class="container">
        <h2 class="text-center mb-5">
          <i class="fa-solid fa-pen-to-square me-2"></i>Gaming Blog Posts & Events
        </h2>
        <div class="row g-4" id="gamingBlogPostsContainer">
          <!-- Blog posts will be loaded here -->
        </div>
      </div>
    </section>

    <!-- Tag Filter Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="tagFilterOffcanvas" aria-labelledby="tagFilterOffcanvasLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="tagFilterOffcanvasLabel">Filter by Tags</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div class="mb-3 jn-show-all-tags">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="jnShowAllTagsToggle">
            <label class="form-check-label small text-muted" for="jnShowAllTagsToggle">Show all tags</label>
          </div>
        </div>

        <h6 class="mb-3">Gaming Tags</h6>
        <div id="gamingTagsList" class="d-flex flex-wrap gap-2 mb-4">
          <!-- Tags populated by tag-system.js -->
        </div>

        <hr>

        <div class="d-grid">
          <button id="applyFilters" class="btn btn-primary" type="button">
            Apply Filters
          </button>
        </div>
      </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap 5.3.8 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    
  <!-- Performance & Compatibility -->
  <script src="<?= RES_ROOT ?>/js/polyfills.js"></script>
  <script src="<?= RES_ROOT ?>/js/performance-optimizer.js"></script>
    
  <!-- Custom Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
  <script src="<?= RES_ROOT ?>/js/youtube-grid.js"></script>
  <script src="<?= RES_ROOT ?>/js/tag-system.js"></script>
  
  <!-- Load Gaming Blog Posts -->
  <script>
    async function loadGamingBlogPosts() {
      try {
        const res = await fetch('<?= RES_ROOT ?>/playlists/blog-posts.yaml');
        const txt = await res.text();
        const parsed = jsyaml.load(txt);
        const allPosts = Array.isArray(parsed) ? parsed : [];
        
        // Filter for Gaming-related slugs and tags
        const gamingSlugs = ['pax-west-gaming-con', 'pax-west-2022', 'summercon-2024'];
        const gamingPosts = allPosts.filter(post => 
          gamingSlugs.includes(post.slug) || 
          (post.tags && post.tags.some(tag => ['gaming', 'pax-west', 'conventions', 'events'].includes(String(tag).toLowerCase())))
        );
        
        const container = document.getElementById('gamingBlogPostsContainer');
        if (!container || gamingPosts.length === 0) {
          if (container) container.innerHTML = '<p class="text-center text-muted">No gaming blog posts yet. Check back soon!</p>';
          return;
        }
        
        container.innerHTML = gamingPosts.map(post => {
          const slug = post.slug || '';
          const title = post.title || 'Untitled';
          const excerpt = post.excerpt || '';
          const image = post.image ? `<?= RES_ROOT ?>/images${post.image}` : '';
          const date = post.date || '';
          const category = post.category || 'Blog';
          const tagBadges = (post.tags || []).slice(0, 3).map(tag => 
            `<span class="badge bg-secondary me-1">${escapeHtml(tag)}</span>`
          ).join('');
          
          return `
            <div class="col-md-6 col-lg-4">
              <div class="card h-100 border-0 shadow-sm gaming-playlist-card">
                ${image ? `<img src="${escapeHtml(image)}" class="card-img-top" alt="${escapeHtml(title)}" loading="lazy" style="height: 200px; object-fit: cover;">` : ''}
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title">
                    <a href="blog/${escapeHtml(slug)}.php" class="text-decoration-none stretched-link">${escapeHtml(title)}</a>
                  </h5>
                  <div class="mb-2">
                    <span class="badge bg-primary">${escapeHtml(category)}</span>
                    <small class="text-muted ms-2">${new Date(date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</small>
                  </div>
                  <p class="card-text text-muted flex-grow-1">${escapeHtml(excerpt)}</p>
                  ${tagBadges ? `<div class="mt-2">${tagBadges}</div>` : ''}
                </div>
              </div>
            </div>
          `;
        }).join('');
        
      } catch (err) {
        console.error('Failed to load gaming blog posts', err);
        const container = document.getElementById('gamingBlogPostsContainer');
        if (container) container.innerHTML = '<p class="text-center text-muted">Failed to load blog posts.</p>';
      }
    }
    
    function escapeHtml(str) {
      return String(str || '').replace(/[&<>"'`]/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','`':'&#96;'})[s]);
    }
    
    // Load blog posts when DOM is ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', loadGamingBlogPosts);
    } else {
      loadGamingBlogPosts();
    }
  </script>
  
  <!-- Load Gaming RSS Feed from @jenniplaysgames -->
  <script>
    // Manual RSS loader removed in favor of YouTubeGrid YAML-driven system
  </script>
  
  <script>
    // Load gaming.yaml config via YouTubeGrid
    (function(){
      function loadGamingPlaylists() {
        if (window.YouTubeGrid && typeof window.YouTubeGrid.loadPageConfig === 'function') {
          try {
            window.YouTubeGrid.loadPageConfig('gaming');
            console.log('✅ Gaming page: Loading playlists from gaming.yaml');
          } catch(e) {
            console.error('❌ Gaming page: Failed to load config', e);
          }
        } else {
          console.warn('⚠️ YouTubeGrid not available, retrying...');
          setTimeout(loadGamingPlaylists, 100);
        }
      }
      
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadGamingPlaylists);
      } else {
        loadGamingPlaylists();
      }
    })();
  </script>
  </body>
</html>
