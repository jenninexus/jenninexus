<?php
$activePage = 'gamedev';
$pageTitle = 'Cat-As-Trophy Game | JenniNexus';
$pageDescription = 'Cat-As-Trophy - A quirky platformer adventure where you play as a cat collecting trophies and exploring unique levels.';
$pageKeywords = 'cat game, platformer, unity game, indie game, cat-as-trophy, adventure game';

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
    <style>
      .gallery-image {
        cursor: pointer;
        transition: transform 0.3s ease, opacity 0.3s ease;
        height: 200px;
        object-fit: cover;
      }
      
      .gallery-image:hover {
        transform: scale(1.05);
        opacity: 0.9;
      }
    </style>
  </head>
  <body>
    
  <?php include __DIR__ . '/../includes/header.php'; ?>

<!-- Hero Section -->
    <div class="hero-section bg-dark text-white py-5" style=" background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-8 glass-panel p-4 rounded-4">
            <nav aria-label="breadcrumb" class="mb-3">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/gamedev" class="text-white">Game Dev</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Cat-As-Trophy</li>
              </ol>
            </nav>
            <h1 class="display-4 fw-bold mb-3 hero-title">
              <i class="fa-solid fa-cat text-white me-3"></i>Cat-As-Trophy
            </h1>
            <p class="lead mb-4">
              A quirky platformer adventure where you play as a cat collecting trophies and exploring unique, whimsical levels filled with challenges and surprises!
            </p>
            <div class="d-flex gap-2 flex-wrap mb-4">
              <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="unity" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('unity') : null">Unity</button>
              <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="platformer" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('platformer') : null">Platformer</button>
              <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="indie" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('indie') : null">Indie</button>
              <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="webgl" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('webgl') : null">WebGL</button>
              <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="gamedev" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('gamedev') : null">Game Dev</button>
            </div>
            <div class="d-flex gap-3 flex-wrap">
              <a href="https://gamejolt.com/@JenniNexus" target="_blank" class="btn btn-lg btn-light">
                <i class="fa-solid fa-gamepad me-2"></i>Play on GameJolt
              </a>
              <a href="#videos" class="btn btn-lg btn-outline-light">
                <i class="fa-brands fa-youtube me-2"></i>Watch Gameplay
              </a>
            </div>
          </div>
          <div class="col-lg-4 text-center mt-4 mt-lg-0">
            <i class="fa-solid fa-trophy" style="font-size: 8rem; color: gold;"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Cat as Trophy Playlist CTA -->
    <?php renderGameCTA('catgame'); ?>

    <!-- Main Content -->
    <div class="container my-5">
      
      <!-- Game Description -->
      <section class="mb-5">
        <div class="row">
          <div class="col-lg-8 glass-panel p-4 rounded-4">
            <h2 class="mb-4">About the Game</h2>
            <p class="lead mb-4">
              Cat-As-Trophy is a charming platformer where players control an adorable cat on a quest to collect trophies across 
              various themed levels. Jump, climb, and navigate through pizza parlors, snowy landscapes, and birthday parties!
            </p>
            <h4 class="mb-3">Features</h4>
            <ul class="list-unstyled">
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Unique platformer gameplay with cat physics</li>
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Multiple themed levels (Pizza, Snow, Birthday)</li>
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Trophy collection system</li>
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Quirky humor and art style</li>
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Challenging but rewarding level design</li>
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Built with Unity for smooth performance</li>
            </ul>
            
            <!-- GameJolt Widget -->
            <div class="mt-4">
              <h4 class="mb-3">Play on GameJolt</h4>
              <iframe src="https://widgets.gamejolt.com/package/v1?key=4MUnpuoV" 
                      frameborder="0" 
                      width="500" 
                      height="245"
                      style="max-width: 100%;"
                      loading="lazy"></iframe>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card border-0 shadow-lg">
              <div class="card-body">
                <h5 class="card-title mb-3">Game Info</h5>
                <div class="mb-3">
                  <small class="text-muted d-block">Developer</small>
                  <strong>JenniNexus</strong>
                </div>
                <div class="mb-3">
                  <small class="text-muted d-block">Engine</small>
                  <strong>Unity</strong>
                </div>
                <div class="mb-3">
                  <small class="text-muted d-block">Platform</small>
                  <strong>PC / Web</strong>
                </div>
                <div class="mb-3">
                  <small class="text-muted d-block">Genre</small>
                  <strong>Platformer / Adventure</strong>
                </div>
                <div class="mb-3">
                  <small class="text-muted d-block">Players</small>
                  <strong>Single Player</strong>
                </div>
                <div class="mb-3">
                  <small class="text-muted d-block">Status</small>
                  <span class="badge bg-success">Released</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Screenshot Gallery -->
      <section class="mb-5">
        <h2 class="mb-4">Screenshots</h2>
        <div class="row g-3">
          <div class="col-md-4">
            <img src="<?= RES_ROOT ?>/images/gamedev/catgame/catgame.png" 
                 class="img-fluid rounded shadow gallery-image" 
                 alt="Cat-As-Trophy Main Menu" 
                 data-bs-toggle="modal" 
                 data-bs-target="#galleryModal" 
                 data-bs-slide-to="0">
          </div>
          <div class="col-md-4">
            <img src="<?= RES_ROOT ?>/images/gamedev/catgame/catastrophygame-pizzacat-x9sighas.png" 
                 class="img-fluid rounded shadow gallery-image" 
                 alt="Pizza Cat Level" 
                 data-bs-toggle="modal" 
                 data-bs-target="#galleryModal" 
                 data-bs-slide-to="1">
          </div>
          <div class="col-md-4">
            <img src="<?= RES_ROOT ?>/images/gamedev/catgame/catastrophygame-snowlevel.png" 
                 class="img-fluid rounded shadow gallery-image" 
                 alt="Snow Level" 
                 data-bs-toggle="modal" 
                 data-bs-target="#galleryModal" 
                 data-bs-slide-to="2">
          </div>
          <div class="col-md-4">
            <img src="<?= RES_ROOT ?>/images/gamedev/catgame/bday-level-yt_2-dastchna.png" 
                 class="img-fluid rounded shadow gallery-image" 
                 alt="Birthday Level" 
                 data-bs-toggle="modal" 
                 data-bs-target="#galleryModal" 
                 data-bs-slide-to="3">
          </div>
          <div class="col-md-4">
            <img src="<?= RES_ROOT ?>/images/gamedev/catgame/old-sdmazvc8.png" 
                 class="img-fluid rounded shadow gallery-image" 
                 alt="Early Version" 
                 data-bs-toggle="modal" 
                 data-bs-target="#galleryModal" 
                 data-bs-slide-to="4">
          </div>
        </div>
      </section>

      <!-- Development Videos -->
      <section id="videos" class="mb-5">
        <h2 class="mb-4">Gameplay Videos</h2>
        <div id="catgame-videos" class="row g-4">
          <!-- Videos will be rendered here by youtube-grid.js -->
        </div>
      </section>

      <!-- Back to Game Dev -->
      <section class="text-center py-5">
        <a href="/gamedev" class="btn btn-lg btn-outline-primary">
          <i class="fa-solid fa-arrow-left me-2"></i>Back to Game Development
        </a>
      </section>

    </div>

    <!-- Gallery Modal -->
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-dark">
          <div class="modal-header border-0">
            <h5 class="modal-title" id="galleryModalLabel">Cat-As-Trophy Screenshots</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-0">
            <div id="galleryCarousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="<?= RES_ROOT ?>/images/gamedev/catgame/catgame.png" class="d-block w-100" alt="Cat-As-Trophy Main">
                </div>
                <div class="carousel-item">
                  <img src="<?= RES_ROOT ?>/images/gamedev/catgame/catastrophygame-pizzacat-x9sighas.png" class="d-block w-100" alt="Pizza Level">
                </div>
                <div class="carousel-item">
                  <img src="<?= RES_ROOT ?>/images/gamedev/catgame/catastrophygame-snowlevel.png" class="d-block w-100" alt="Snow Level">
                </div>
                <div class="carousel-item">
                  <img src="<?= RES_ROOT ?>/images/gamedev/catgame/bday-level-yt_2-dastchna.png" class="d-block w-100" alt="Birthday Level">
                </div>
                <div class="carousel-item">
                  <img src="<?= RES_ROOT ?>/images/gamedev/catgame/old-sdmazvc8.png" class="d-block w-100" alt="Early Version">
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <!-- Bootstrap 5.3.8 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    
    <!-- js-yaml already loaded in head.php -->
    
  <!-- Custom Scripts -->
  <script src="<?= RES_ROOT ?>/js/tag-filter-api<?= $assetSuffix ?? '' ?>.js"></script>
  <script src="<?= RES_ROOT ?>/js/youtube-grid<?= $assetSuffix ?? '' ?>.js"></script>
  <script src="<?= RES_ROOT ?>/js/tag-system<?= $assetSuffix ?? '' ?>.js"></script>
    
    <!-- Initialize tag filter and gallery modal -->
    <script>
      // Initialize tag filter API
      if (window.tagFilter && typeof window.tagFilter.init === 'function') {
        window.tagFilter.init();
      }
      
      // Gallery modal click handler - Open carousel at the clicked image
      document.addEventListener('DOMContentLoaded', function() {
        const galleryModal = document.getElementById('galleryModal');
        if (galleryModal) {
          galleryModal.addEventListener('show.bs.modal', function (event) {
            const trigger = event.relatedTarget;
            const slideTo = parseInt(trigger.getAttribute('data-bs-slide-to') || '0', 10);
            const carousel = galleryModal.querySelector('#galleryCarousel');
            if (carousel && window.bootstrap && window.bootstrap.Carousel) {
              const carouselInstance = bootstrap.Carousel.getOrCreateInstance(carousel);
              carouselInstance.to(slideTo);
            }
          });
        }
      });

      // Load Cat-As-Trophy videos - Show 4 videos in responsive grid (1x4 on desktop)
      (function(){
        function loadCatGameVideos() {
          if (window.YouTubeGrid && typeof window.YouTubeGrid.renderPlaylist === 'function') {
            try {
              // Cat-As-Trophy Playlist ID from gamedev.yaml
              const playlistId = 'PLLzfSGTgy8YBL97yf_JRzcc3NWwk8FXyN';
              
              // Render 5 videos in a responsive grid
              // Mobile (xs): 1 col, Tablet (sm): 2 cols, Medium (md): 3 cols, Desktop (lg): 5 cols (1 row)
              window.YouTubeGrid.renderPlaylist('catgame-videos', playlistId, {
                layout: 'multi-video',
                videos_per_playlist: 5,
                columns: { xs: 1, sm: 2, md: 3, lg: 5 },
                aspect_ratio: '16:9',
                show_playlist_title: false,
                enable_hover_effects: true,
                lazy_load: true
              });
              
              console.log('✅ Cat-As-Trophy: Loaded 5 videos in 1x5 responsive grid');
            } catch(e) {
              console.error('❌ Cat-As-Trophy: Failed to load videos', e);
            }
          } else {
            console.warn('⚠️ YouTubeGrid not available, retrying...');
            setTimeout(loadCatGameVideos, 100);
          }
        }
        
        if (document.readyState === 'loading') {
          document.addEventListener('DOMContentLoaded', loadCatGameVideos);
        } else {
          loadCatGameVideos();
        }
      })();
    </script>
  </body>
</html>
