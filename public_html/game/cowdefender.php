<?php
$activePage = 'gamedev';
$pageTitle = 'Cow Defender - Martian Games | JenniNexus';
$pageDescription = 'Cow Defender - A rescue and delivery game where you save cows from UFO abductions and deliver them safely to the base. Part of the Martian Games collection!';
$pageKeywords = 'cow defender, rescue game, martian games, unity, indie game, aliens, ufo, delivery';

// Define RES_ROOT for asset loading
if (!defined('RES_ROOT')) {
  define('RES_ROOT', '/resources');
}

// Load gamedev theme CSS
$customCSS = [
  RES_ROOT . '/css/gamedev-theme.min.css',
  RES_ROOT . '/css/media.min.css'
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
    <div class="bg-dark text-white py-5" style=" background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-3">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/gamedev" class="text-white">Game Dev</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Cow Defender</li>
              </ol>
            </nav>
            <h1 class="display-4 fw-bold mb-3">
              <i class="fa-solid fa-truck text-warning me-3"></i>Cow Defender
            </h1>
            <p class="lead mb-4">
              A fast-paced rescue and delivery game from Martian Games! Rescue cows from UFO abductions and deliver them safely to the base before it's too late!
            </p>
            <div class="d-flex gap-2 flex-wrap mb-4">
              <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="unity" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('unity') : null">Unity</button>
              <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="martiangames" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('martiangames') : null">Martian Games</button>
              <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="action-adventure" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('action-adventure') : null">Action</button>
              <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="indie" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('indie') : null">Indie</button>
              <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="game-jam" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('game-jam') : null">Game Jam</button>
            </div>
            <div class="d-flex gap-3 flex-wrap">
              <a href="https://www.crazygames.com/game/cow-defender" target="_blank" rel="noopener" class="btn btn-lg btn-light">
                <i class="fa-solid fa-circle-play me-2"></i>Play on CrazyGames
              </a>
              <a href="#videos" class="btn btn-lg btn-outline-light">
                <i class="fa-brands fa-youtube me-2"></i>Watch Gameplay
              </a>
            </div>
          </div>
          <div class="col-lg-4 text-center mt-4 mt-lg-0">
            <i class="fa-solid fa-shield-halved" style="font-size: 8rem; color: white;"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Cow Defender CTA -->
    <?php renderGameCTA('cowdefender'); ?>

    <!-- Main Content -->
    <div class="container my-5">
      
      <!-- Game Description -->
      <section class="mb-5">
        <div class="row">
          <div class="col-lg-8">
            <h2 class="mb-4">About the Game</h2>
            <p class="lead mb-4">
              Cow Defender is a Martian Games rescue and delivery game where you drive a vehicle to save cows from UFO abductions!
              Race against time to rescue cows and deliver them safely to the airplane hangar base before the aliens get them.
            </p>
            
            <h4 class="mb-3">Martian Games Collection</h4>
            <p class="mb-4">
              Part of the Martian Games studio portfolio, Cow Defender showcases fast-paced arcade action with time pressure. 
              Navigate your vehicle, rescue the cows, and make it back to base safely!
            </p>
            
            <h4 class="mb-3">Features</h4>
            <ul class="list-unstyled">
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Fast-paced rescue and delivery gameplay</li>
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Drive vehicles to transport cows</li>
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Race against UFO abductions</li>
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Deliver cows to airplane hangar base</li>
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Time-based challenge gameplay</li>
              <li class="mb-2"><i class="fa-solid fa-circle-check text-success me-2"></i>Complete with sound effects and music</li>
            </ul>
            
            <div class="alert alert-info mt-4">
              <i class="fa-solid fa-circle-info me-2"></i>
              <strong>Pro Tip:</strong> Speed is key! Rescue cows quickly and plan your route to the hangar efficiently to save as many cows as possible.
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
                  <small class="text-muted d-block">Studio</small>
                  <strong>Martian Games</strong>
                </div>
                <div class="mb-3">
                  <small class="text-muted d-block">Genre</small>
                  <strong>Rescue & Delivery / Action</strong>
                </div>
                <div class="mb-3">
                  <small class="text-muted d-block">Players</small>
                  <strong>Single Player</strong>
                </div>
                <div class="mb-3">
                  <small class="text-muted d-block">Platform</small>
                  <strong>CrazyGames</strong>
                </div>
              </div>
            </div>
            
            <!-- Play Now Card -->
            <div class="card border-primary border-2 mt-4">
              <div class="card-body text-center">
                <i class="fa-solid fa-gamepad text-primary display-4 mb-3"></i>
                <h5 class="card-title">Play Now</h5>
                <p class="small text-muted mb-3">Available on CrazyGames</p>
                <a href="https://www.crazygames.com/game/cow-defender" target="_blank" rel="noopener" class="btn btn-primary w-100">
                  <i class="fa-solid fa-circle-play me-2"></i>Play Game
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Screenshot Section -->
      <section class="mb-5">
        <h2 class="mb-4">Game Screenshot</h2>
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card border-0 shadow-lg">
              <img src="<?= RES_ROOT ?>/images/gamedev/cowdefender/cow-defender.PNG" class="card-img-top" alt="Cow Defender Gameplay">
              <div class="card-body">
                <p class="text-muted mb-0">Gameplay screenshot showing tower placement and enemy waves</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Development Process -->
      <section class="mb-5">
        <h2 class="mb-4">Development Process</h2>
        <div class="row g-4">
          <div class="col-md-6">
            <div class="card h-100 border-0 shadow">
              <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                  <i class="fa-solid fa-clock-rotate-left fs-2 text-primary me-3"></i>
                  <h5 class="card-title mb-0">Day 1 - Foundation</h5>
                </div>
                <p class="text-muted">
                  Established core tower defense mechanics, implemented basic enemy AI, and created the grid system for tower placement.
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card h-100 border-0 shadow">
              <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                  <i class="fa-solid fa-wand-magic-sparkles fs-2 text-warning me-3"></i>
                  <h5 class="card-title mb-0">Day 2 - Polish</h5>
                </div>
                <p class="text-muted">
                  Added multiple turret types, balanced difficulty progression, implemented sound effects, and created the final artwork.
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Game Jam Videos -->
      <section id="videos" class="mb-5">
        <h2 class="mb-4">Game Jam Highlights</h2>
        <p class="lead mb-4">Watch development footage and gameplay from this exciting 48-hour game jam project!</p>
        <div id="gamejam-videos" class="row g-4">
          <div class="col-12 text-center py-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading videos...</span>
            </div>
          </div>
        </div>
      </section>

      <!-- More Game Jam Projects -->
      <section class="mb-5">
        <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
          <div class="card-body p-4 p-md-5 text-white text-center">
            <i class="fa-solid fa-bolt display-4 mb-3"></i>
            <h3 class="mb-3">Love Game Jams?</h3>
            <p class="lead mb-4">Check out more of our game jam entries and rapid prototypes</p>
            <a href="/gamedev#indie-gamejam-section" class="btn btn-lg btn-light">
              <i class="fa-solid fa-layer-group me-2"></i>View All Game Jams
            </a>
          </div>
        </div>
      </section>

      <!-- Back to Game Dev -->
      <section class="text-center py-5">
        <a href="/gamedev" class="btn btn-lg btn-outline-primary">
          <i class="fa-solid fa-arrow-left me-2"></i>Back to Game Development
        </a>
      </section>

    </div>

    <?php include __DIR__ . '/../includes/tag-filter-offcanvas.php'; ?>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <!-- Bootstrap 5.3.8 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    
    <!-- js-yaml already loaded in head.php -->
    
  <!-- Custom Scripts -->
    <script src="<?= RES_ROOT ?>/js/tag-filter-api<?= $assetSuffix ?? '' ?>.js"></script>
    <script src="<?= RES_ROOT ?>/js/youtube-grid<?= $assetSuffix ?? '' ?>.js"></script>
    <script src="<?= RES_ROOT ?>/js/tag-system<?= $assetSuffix ?? '' ?>.js"></script>
    
    <!-- Initialize and load game jam videos -->
    <script>
      // Initialize tag filter API
      if (window.tagFilter && typeof window.tagFilter.init === 'function') {
        window.tagFilter.init();
      }
      
      if (window.YouTubeGrid) {
        // Game Jam Highlights playlist: PL9QBjNDhgNwTFn7QSZRbZGoKCCIsUlemX
        window.YouTubeGrid.renderPlaylistSection('gamejam-videos', 'PL9QBjNDhgNwTFn7QSZRbZGoKCCIsUlemX', {
          columns: 3,
          maxVideos: 12,
          showPlaylistTitle: false
        });
      }
      
      // Add specific Cow Defender gameplay video as featured
      document.addEventListener('DOMContentLoaded', function() {
        const videoSection = document.getElementById('gamejam-videos');
        if (videoSection && window.YouTubeGrid) {
          // Insert featured video at the top
          const featuredHTML = `
            <div class="col-12 mb-4">
              <div class="card border-0 shadow-lg">
                <div class="card-body p-4">
                  <h4 class="text-center mb-4">
                    <i class="fa-solid fa-star text-warning me-2"></i>Featured Gameplay
                  </h4>
                  <div class="ratio ratio-16x9 rounded overflow-hidden">
                    <iframe src="https://www.youtube.com/embed/W5CG2HbtR3g" 
                            title="Cow Defender Gameplay" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen></iframe>
                  </div>
                </div>
              </div>
            </div>
          `;
          videoSection.insertAdjacentHTML('afterbegin', featuredHTML);
        }
      });
    </script>
  </body>
</html>
