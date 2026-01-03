<!DOCTYPE html>
<html lang="en">

<head>
  <?php 
    include __DIR__ . '/../includes/head.php';
    include __DIR__ . '/../includes/game-cta-helper.php';
  ?>
  
  <title>Cleanup in Aisle 3 | JenniNexus - Arcade Game</title>
  <meta name="description" content="Cleanup in Aisle 3 - A fun arcade cleaning game.">
  <meta name="keywords" content="cleanup in aisle 3, arcade game, indie game">
  
  <style>
    .game-header {
      background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    }
    
    .gallery-image {
      cursor: pointer;
      transition: transform 0.3s ease;
      height: 300px;
      object-fit: cover;
    }
    
    .gallery-image:hover {
      transform: scale(1.05);
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
                  <li class="breadcrumb-item active text-white" aria-current="page">Cleanup in Aisle 3</li>
                </ol>
              </nav>
              
              <h1 class="display-3 mb-4">
                <i class="fa-solid fa-trash-can me-2"></i> Cleanup in Aisle 3
              </h1>
              <p class="lead mb-4">A fun arcade cleaning game!</p>
              
              <div class="d-flex gap-2 flex-wrap mb-4">
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="retro" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('retro') : null">Arcade</button>
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="indie" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('indie') : null">Indie</button>
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="game-jam" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('game-jam') : null">Game Jam</button>
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="unity" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('unity') : null">Unity</button>
              </div>
              
              <div class="d-flex gap-3 mb-4 flex-wrap">
                <a href="https://youtu.be/F8N6aQCg3iI" 
                   class="btn btn-lg btn-danger" 
                   target="_blank" 
                   rel="noopener">
                  <i class="fa-brands fa-youtube me-2"></i>Watch Gameplay
                </a>
                <a href="/gamedev" class="btn btn-lg btn-outline-light">
                  <i class="fa-solid fa-arrow-left me-2"></i>Back to Game Dev
                </a>
              </div>
            </div>
            
            <div class="col-lg-4 text-center">
              <img src="<?= RES_ROOT ?>/images/gamedev/cleanupinisle3/cleanup_1.png" 
                   class="img-fluid rounded shadow-lg" 
                   alt="Cleanup in Aisle 3">
            </div>
          </div>
        </div>
      </section>

      <!-- Cleanup in Aisle 3 CTA -->
      <?php renderGameCTA('cleanupinisle3'); ?>

      <!-- Video Section -->
      <section class="py-5 bg-dark">
        <div class="container">
          <h2 class="text-white text-center mb-5">
            <i class="fa-solid fa-circle-play text-danger me-2"></i> Gameplay Video
          </h2>
          
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <div class="ratio ratio-16x9 rounded shadow-lg overflow-hidden">
                <iframe src="https://www.youtube.com/embed/F8N6aQCg3iI" 
                        title="Cleanup in Aisle 3 Gameplay" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen></iframe>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Screenshots -->
      <section class="py-5 bg-secondary bg-gradient">
        <div class="container">
          <h2 class="text-white text-center mb-5">
            <i class="fa-solid fa-images me-2"></i> Screenshots
          </h2>
          
          <div class="row g-4 justify-content-center">
            <div class="col-md-6">
              <img src="<?= RES_ROOT ?>/images/gamedev/cleanupinisle3/cleanup_1.png" 
                   class="img-fluid rounded shadow gallery-image w-100" 
                   alt="Cleanup in Aisle 3">
            </div>
            <div class="col-md-6">
              <img src="<?= RES_ROOT ?>/images/gamedev/cleanupinisle3/cleanup_2.png" 
                   class="img-fluid rounded shadow gallery-image w-100" 
                   alt="Cleanup in Aisle 3 Gameplay">
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
  
  <script>
    if (window.tagFilter && typeof window.tagFilter.init === 'function') {
      window.tagFilter.init();
    }
  </script>
</body>

</html>
