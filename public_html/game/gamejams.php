<?php
$activePage = 'gamejams';
$pageTitle = 'Game Jams & Ludum Dare - JenniNexus';
$pageDescription = 'Collections of Ludum Dare and other game jam playlists.';

// Page-specific CSS
$customCSS = [
  '/resources/css/gamedev-theme.min.css',
  '/resources/css/media.min.css'
];
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <?php 
    include __DIR__ . '/../includes/head.php';
    include __DIR__ . '/../includes/game-cta-helper.php';
  ?>
  <head>
    <!-- Schema.org for SEO -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "CollectionPage",
      "name": "Game Jams & Ludum Dare",
      "description": "Ludum Dare entries, game jam submissions, and 48-hour dev challenges.",
      "url": "https://jenninexus.com/game/gamejams.php",
      "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [{
          "@type": "ListItem",
          "position": 1,
          "name": "Game Dev",
          "item": "https://jenninexus.com/gamedev.php"
        }, {
          "@type": "ListItem",
          "position": 2,
          "name": "Game Jams"
        }]
      }
    }
    </script>
    
    <style>
      /* Game jam card hover effects */
      .gamejam-card {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        transition: transform 0.3s ease;
      }
      .gamejam-card:hover {
        transform: translateY(-5px);
      }
      .gamejam-thumb {
        transition: transform 0.4s ease;
      }
      .gamejam-card:hover .gamejam-thumb {
        transform: scale(1.05);
      }
      .play-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 60px;
        height: 60px;
        background: rgba(0,0,0,0.6) url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 68 68" fill="white"><path d="M26 20v28l20-14z"/></svg>') center/40% no-repeat;
        border-radius: 50%;
        transform: translate(-50%, -50%);
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
      }
      .gamejam-card:hover .play-overlay {
        opacity: 1;
      }
    </style>
  </head>
  <body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Hero Section -->
    <div class="bg-dark text-white py-5" style="background: linear-gradient(135deg, #ff6b6b 0%, #feca57 100%) !important;">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-8 mx-auto text-center">
            <nav aria-label="breadcrumb" class="mb-4">
              <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="../gamedev.php" class="text-white text-decoration-none">Game Dev</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Game Jams</li>
              </ol>
            </nav>
            <h1 class="display-4 fw-bold mb-3">
              <i class="fa-solid fa-bolt-lightning text-warning me-2"></i> Game Jams &amp; Ludum Dare
            </h1>
            <p class="lead mb-4">48-hour dev sprints, wild ideas, and indie game jam magic</p>
            <div class="d-flex gap-2 justify-content-center flex-wrap">
              <span class="badge bg-light text-dark px-3 py-2">Ludum Dare</span>
              <span class="badge bg-light text-dark px-3 py-2">Game Jams</span>
              <span class="badge bg-light text-dark px-3 py-2">Indie Dev</span>
              <span class="badge bg-light text-dark px-3 py-2">48-Hour Challenge</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <!-- Playlists grid populated by resources/js/youtube-grid.js using resources/playlists/gamejams.yaml -->
            <div id="gamejams-playlists" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 mb-5"> 
              <div class="col-12 text-center py-5">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading game jam playlists...</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Join a Jam CTA -->
    <section class="container my-5">
      <div class="card border-0 shadow-lg text-white hover-lift" style="background: linear-gradient(135deg, #ff6b6b, #feca57);">
        <div class="card-body p-4 p-md-5 text-center">
          <i class="bi bi-trophy-fill display-4 mb-3"></i>
          <h3 class="mb-3">Explore Jams</h3>
          <p class="lead mb-4">Join the next Ludum Dare or see what's available on Devpost, or Itch.io</p>
          <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="https://ldjam.com" target="_blank" rel="noopener" class="btn btn-dark btn-lg">
              <i class="bi bi-box-arrow-up-right me-2"></i>LudumDare.com
            </a>
            <a href="https://devpost.com/" target="_blank" rel="noopener" class="btn btn-outline-dark btn-lg">
              <i class="bi bi-code-square me-2"></i>Devpost
            </a>
            <a href="https://itch.io/jams" target="_blank" rel="noopener" class="btn btn-outline-dark btn-lg">
              <i class="bi bi-calendar-event me-2"></i>Itch.io Jams
            </a>
          </div>
        </div>
      </div>
    </section>

    <script>
      (function(){
        const RES_ROOT = (typeof window !== 'undefined' && window.RES_ROOT) ? window.RES_ROOT : '/resources';
        const scriptUrl = RES_ROOT + '/js/youtube-grid.js';

        function loadGrid() {
          if (window.YouTubeGrid && typeof window.YouTubeGrid.loadPageConfig === 'function') {
            try { 
              window.YouTubeGrid.loadPageConfig('gamejams'); 
            } catch (e) { 
              console.error('YouTubeGrid.loadPageConfig failed', e); 
            }
            return;
          }
          const s = document.createElement('script');
          s.src = scriptUrl;
          s.defer = true;
          s.onload = function(){
            if (window.YouTubeGrid && typeof window.YouTubeGrid.loadPageConfig === 'function') {
              try { 
                window.YouTubeGrid.loadPageConfig('gamejams'); 
              } catch (e) { 
                console.error('YouTubeGrid.loadPageConfig failed after load', e); 
              }
            }
          };
          s.onerror = function(){
            console.error('Failed to load youtube-grid.js');
            const container = document.getElementById('gamejams-playlists');
            if (container) {
              container.innerHTML = '<div class="col-12"><div class="alert alert-warning text-center">Failed to load playlists. Please refresh the page.</div></div>';
            }
          };
          document.head.appendChild(s);
        }

        if (document.readyState === 'loading') {
          document.addEventListener('DOMContentLoaded', loadGrid);
        } else {
          loadGrid();
        }
      })();
    </script>

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
          <button id="applyFilters" class="btn btn-primary" type="button">Apply Filters</button>
          <button id="clearFilters" class="btn btn-outline-secondary">Clear</button>
          <a href="/tags.php" class="btn btn-link ms-auto">View all tags</a>
        </div>
      </div>
    </div>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
    
    <!-- Custom Scripts -->
    <script src="<?= RES_ROOT ?>/js/tag-filter-api<?= $assetSuffix ?? '' ?>.js"></script>
    <script src="<?= RES_ROOT ?>/js/tag-system<?= $assetSuffix ?? '' ?>.js"></script>
    
    <script>
      // Initialize tag filter API
      if (window.tagFilter && typeof window.tagFilter.init === 'function') {
        window.tagFilter.init();
      }
    </script>
  </body>
</html>
