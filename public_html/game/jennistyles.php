<?php
$activePage = 'gamedev';
$pageTitle = 'Jenni Styles Dress Up Game | JenniNexus';
$pageDescription = 'Jenni Styles - A fashion dress-up game featuring multiple characters, outfits, and customization options. Play now!';
$pageKeywords = 'jenni styles, dress up game, fashion game, unity game, webgl, character customization';
$customCSS = [
  'resources/css/gamedev-theme.min.css',
  'resources/css/media.min.css'
];
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <?php 
    include __DIR__ . '/../includes/head.php';
    include __DIR__ . '/../includes/game-cta-helper.php';
  ?>
  <body>
    
  <?php include __DIR__ . '/../includes/header.php'; ?>

    <!-- Hero Section -->
    <div class="hero-section bg-dark text-white py-5" style=" background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-8 glass-panel p-4 rounded-4">
            <nav aria-label="breadcrumb" class="mb-3">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/gamedev" class="text-white">Game Dev</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Jenni Styles</li>
              </ol>
            </nav>
            <h1 class="display-4 fw-bold mb-3 hero-title">
              <img src="<?= RES_ROOT ?>/images/gamedev/jennistyles/hi.png" alt="Jenni" style="height: 1.2em; vertical-align: baseline; margin-right: 0.5rem;">Jenni Styles Dress Up
            </h1>
            <p class="lead mb-4">
              Fashion dress-up game featuring multiple characters, outfits, and customization options. Express your style and create unique looks!
            </p>
            <div class="d-flex gap-2 flex-wrap mb-4">
              <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="unity" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('unity') : null">Unity</button>
              <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="webgl" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('webgl') : null">WebGL</button>
              <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="fashion" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('fashion') : null">Fashion</button>
              <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="indie" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('indie') : null">Indie</button>
              <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="gamedev" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('gamedev') : null">Game Dev</button>
            </div>
            <div class="d-flex gap-3 flex-wrap">
              <a href="https://gamejolt.com/games/jennistyles/27896" target="_blank" class="btn btn-lg btn-light">
                <i class="fa-solid fa-play me-2"></i>Jenni Styles</a>
              <a href="https://gamejolt.com/games/alter-kat/37503" target="_blank" class="btn btn-lg btn-light">
                <i class="fa-solid fa-id-badge me-2"></i>Alter Kat</a>
              <a href="#videos" class="btn btn-lg btn-outline-light">
                <i class="fa-brands fa-youtube me-2"></i>Watch Videos
              </a>
            </div>
          </div>
          <div class="col-lg-4 text-center mt-4 mt-lg-0">
            <i class="fa-solid fa-palette" style="font-size: 8rem; color: white;"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Jenni Styles Playlist CTA -->
    <?php renderGameCTA('jennistyles'); ?>

      <!-- Main Content -->
      <div class="container my-5 content-item" data-tags="jenni-styles,alter-kat,flash-game,indie-game,game-dev">
      
      <!-- Game Description -->
      <section class="mb-5">
        <div class="row">
          <div class="col-lg-8">
            <h2 class="mb-4">About the Game</h2>
            <p class="lead mb-4">
              Jenni Styles is a creative dress-up game where fashion meets fun. Play as Jenni Styles or Alter Kat — each character has their own
              unique style and a pet friend to accompany them through fashion adventures.
            </p>
            <h4 class="mb-3">Features</h4>
            <ul class="list-unstyled">
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Play as Jenni Styles or Alter Kat — each with their own pet friend</li>
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Alternative fashion, makeup and DIY looks</li>
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Hair styles, colors, and accessories</li>
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Mix and match outfits</li>
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Save and share your creations</li>
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Runs with Adobe Flash Player (Emulator required)</li>
            </ul>
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
                  <strong>Adobe Flash CS6</strong>
                </div>
                <div class="mb-3">
                  <small class="text-muted d-block">Platform</small>
                  <strong>Web</strong>
                </div>
                <div class="mb-3">
                  <small class="text-muted d-block">Genre</small>
                  <strong>Dress Up / Fashion</strong>
                </div>
                <div class="mb-3">
                  <small class="text-muted d-block">Players</small>
                  <strong>Single Player</strong>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Screenshot Gallery (single hero image as requested) -->
      <section class="mb-5">
        <h2 class="mb-4">Screenshots</h2>
        <div class="row g-4">
          <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow hover-lift overflow-hidden">
              <img src="<?= RES_ROOT ?>/images/gamedev/jennistyles/jenni-styles.jpg" class="card-img-top" alt="Jenni Styles Main" style="width: 100%; height: auto;">
            </div>
          </div>
        </div>
      </section>

      <!-- Featured Playlist Videos (Multi-Video Layout) -->
      <section class="mb-5" id="videos">
        <h2 class="mb-4">Jenni Styles Videos</h2>
        <div id="jennistyles-videos" class="row g-4" data-tags="jennistyles,gamedev,unity,fashion">
          <!-- Video cards will be rendered here by youtube-grid.js -->
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
            <h5 class="modal-title" id="galleryModalLabel">Jenni Styles Screenshots</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-0">
            <div id="galleryCarousel" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="<?= RES_ROOT ?>/images/gamedev/jennistyles/jenni-styles.jpg" class="d-block w-100" alt="Jenni Styles Main">
                </div>
                <div class="carousel-item">
                  <img src="<?= RES_ROOT ?>/images/gamedev/jennistyles/jenni-dressup.jpg" class="d-block w-100" alt="Jenni Character">
                </div>
                <div class="carousel-item">
                  <img src="<?= RES_ROOT ?>/images/gamedev/jennistyles/alter-kat.jpg" class="d-block w-100" alt="AlterKat Character">
                </div>
                <div class="carousel-item">
                  <img src="<?= RES_ROOT ?>/images/gamedev/jennistyles/alter-kat_2.jpg" class="d-block w-100" alt="AlterKat Style 2">
                </div>
                <div class="carousel-item">
                  <img src="<?= RES_ROOT ?>/images/gamedev/jennistyles/alter-kat_3.jpg" class="d-block w-100" alt="AlterKat Style 3">
                </div>
                <div class="carousel-item">
                  <img src="<?= RES_ROOT ?>/images/gamedev/jennistyles/alter-kat_red.jpg" class="d-block w-100" alt="AlterKat Red">
                </div>
                <div class="carousel-item">
                  <img src="<?= RES_ROOT ?>/images/gamedev/jennistyles/alterkat.jpg" class="d-block w-100" alt="AlterKat Full">
                </div>
                <div class="carousel-item">
                  <img src="<?= RES_ROOT ?>/images/gamedev/jennistyles/jennistyles_nature.jpg" class="d-block w-100" alt="Nature Theme">
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

  <!-- Support CTA (Patreon) -->
  <section class="py-5">
    <div class="container">
      <div class="card bg-gradient text-white">
        <div class="card-body text-center py-5">
          <h2 class="mb-3">
            Support My DIY Game Dev Projects
          </h2>
          <p class="lead mb-4">
            Help fund tools, assets, and dev time for future updates — patrons get early access to prototypes and behind-the-scenes content.
          </p>
          <a href="/patreon.php" class="btn btn-light btn-lg">
            <i class="fa-solid fa-heart me-2"></i>Become a Patron
          </a>
        </div>
      </div>
    </div>
  </section>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

  <!-- Bootstrap 5.3.8 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    
    <!-- js-yaml already loaded in head.php -->
    
  <!-- Custom Scripts -->
  <script src="<?= RES_ROOT ?>/js/tag-filter-api<?= $assetSuffix ?? '' ?>.js"></script>
  <script src="<?= RES_ROOT ?>/js/youtube-grid<?= $assetSuffix ?? '' ?>.js"></script>
  <script src="<?= RES_ROOT ?>/js/tag-system<?= $assetSuffix ?? '' ?>.js"></script>
    
  <script>
    // Initialize tag filter API
    if (window.tagFilter && typeof window.tagFilter.init === 'function') {
      window.tagFilter.init();
    }
    
    // Load Jenni Styles videos using multi-video layout (Format 2)
    (function(){
      function loadJenniStylesVideos() {
        if (window.YouTubeGrid && typeof window.YouTubeGrid.renderPlaylist === 'function') {
          try {
            console.log('🎮 Jenni Styles: Loading videos in multi-video layout...');
            
            // Jenni Styles playlist ID from gamedev.yaml
            const playlistId = 'PL9QBjNDhgNwS8zNaKAFjuWf4NTfk3Ul3g';
            
            // Render playlist directly with multi-video layout (show 5 videos in responsive grid)
            window.YouTubeGrid.renderPlaylist({
              container_id: 'jennistyles-videos',
              playlist_id: playlistId,
              layout: 'multi-video',
              videos_per_playlist: 5,
              columns: { xs: 1, sm: 2, md: 3, lg: 5 }, // 5-column grid on desktop
              aspect_ratio: '16:9',
              show_playlist_title: false,
              enable_hover_effects: true,
              lazy_load: true
            })
            .then(() => console.log('✅ Jenni Styles: 5 videos rendered successfully'))
            .catch(err => console.error('❌ Jenni Styles render error:', err));
          } catch(e) {
            console.error('❌ Jenni Styles: Failed to initialize:', e);
          }
        } else {
          console.warn('⚠️ YouTubeGrid not available, retrying in 100ms...');
          setTimeout(loadJenniStylesVideos, 100);
        }
      }
      
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadJenniStylesVideos);
      } else {
        loadJenniStylesVideos();
      }
    })();
  </script>
  </body>
</html>
