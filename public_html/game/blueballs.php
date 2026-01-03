<?php
$activePage = 'gamedev';
$pageTitle = 'Blue Balls - Puzzle Platform Game | JenniNexus';
$pageDescription = 'Blue Balls - A challenging puzzle platform game. Available on GameJolt.';
$pageKeywords = 'blue balls, puzzle game, platform game, indie game, gamejolt';
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
  <?php 
    include __DIR__ . '/../includes/head.php';
    include __DIR__ . '/../includes/game-cta-helper.php';
  ?>
  
  <style>
    .game-header {
      background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    }
  </style>
</head>

<body>
  <?php include __DIR__ . '/../includes/header.php'; ?>

  <main>
    <div class="container-fluid px-0">
      <!-- Hero Section -->
      <section class="py-5 game-header text-white">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-8">
              <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/index" class="text-white text-decoration-none">Home</a></li>
                  <li class="breadcrumb-item"><a href="/gamedev" class="text-white text-decoration-none">Game Dev</a></li>
                  <li class="breadcrumb-item active text-white" aria-current="page">Blue Balls</li>
                </ol>
              </nav>
              
              <h1 class="display-3 mb-4">
                <i class="fa-solid fa-circle me-2"></i> Blue Balls
              </h1>
              <p class="lead mb-4">A challenging puzzle platform game that will test your skills!</p>
              
              <div class="d-flex gap-2 flex-wrap mb-4">
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="puzzle" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('puzzle') : null">Puzzle</button>
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="platformer" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('platformer') : null">Platformer</button>
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="indie" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('indie') : null">Indie</button>
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="unity" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('unity') : null">Unity</button>
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="webgl" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('webgl') : null">WebGL</button>
              </div>
              
              <div class="d-flex gap-3 mb-4 flex-wrap">
                <a href="https://gamejolt.com/games/BlueBalls/292942" 
                   class="btn btn-lg btn-light" 
                   target="_blank" 
                   rel="noopener">
                  <i class="fa-solid fa-gamepad me-2"></i>Play on GameJolt
                </a>
                <a href="/gamedev" class="btn btn-lg btn-outline-light">
                  <i class="fa-solid fa-arrow-left me-2"></i>Back to Game Dev
                </a>
              </div>
            </div>
            
            <div class="col-lg-4 text-center">
              <img src="<?= RES_ROOT ?>/images/gamedev/blueballs/blueballs-featured.png" 
                   class="img-fluid rounded shadow-lg" 
                   alt="Blue Balls">
            </div>
          </div>
        </div>
      </section>

      <!-- Blue Balls Playlist CTA -->
      <?php renderGameCTA('blueballs'); ?>

      <!-- Videos Section -->
      <section class="py-5 section-pastel">
        <div class="container">
          <h2 class="text-white text-center mb-5">
            <i class="fa-solid fa-circle-play text-danger me-2"></i> Gameplay Videos
          </h2>
          
          <div class="row g-3 g-md-4">
            <div class="col-12 col-md-6 col-lg-4">
              <div class="ratio ratio-16x9 rounded shadow-lg overflow-hidden">
                <iframe src="https://www.youtube.com/embed/DpiUJU-xwAU" 
                        title="Blue Balls Gameplay" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen></iframe>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
              <div class="ratio ratio-16x9 rounded shadow-lg overflow-hidden">
                <iframe src="https://www.youtube.com/embed/IsNfGNDplNw" 
                        title="Blue Balls Gameplay 2" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen></iframe>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
              <div class="ratio ratio-16x9 rounded shadow-lg overflow-hidden">
                <iframe src="https://www.youtube.com/embed/DpiUJU-xwAU" 
                        title="Blue Balls Gameplay 3" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen></iframe>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Game Info -->
      <section class="py-5 section-pastel">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="glass-card hover-lift">
                <div class="card-body p-4">
                  <h3 class="mb-4"><i class="fa-solid fa-circle-info me-2"></i> About the Game</h3>
                  <p class="lead">Blue Balls is a challenging puzzle platformer that requires precision and timing.</p>
                  
                  <div class="mt-4">
                    <a href="https://gamejolt.com/games/BlueBalls/292942" 
                       class="btn btn-lg btn-light" 
                       target="_blank" 
                       rel="noopener">
                      <i class="fa-solid fa-gamepad me-2"></i>Play Now on GameJolt
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>

  <?php include __DIR__ . '/../includes/footer.php'; ?>
  
  <!-- Bootstrap 5.3.8 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  
  <!-- Custom Scripts -->
  <script src="<?= RES_ROOT ?>/js/tag-filter-api<?= $assetSuffix ?? '' ?>.js"></script>
  <script src="<?= RES_ROOT ?>/js/tag-system<?= $assetSuffix ?? '' ?>.js"></script>
  <script src="<?= RES_ROOT ?>/js/ui-effects.js"></script>
  
  <script>
    // Initialize tag filter API
    if (window.tagFilter && typeof window.tagFilter.init === 'function') {
      window.tagFilter.init();
    }
  </script>
</body>

</html>
