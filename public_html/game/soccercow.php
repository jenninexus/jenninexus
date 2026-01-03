<!DOCTYPE html>
<html lang="en">

<head>
  <?php 
    include __DIR__ . '/../includes/head.php';
    include __DIR__ . '/../includes/game-cta-helper.php';
  ?>
  
  <title>Soccer Cows | JenniNexus - Martian Games Sports Game</title>
  <meta name="description" content="Soccer Cows - A fun soccer game featuring cows. Part of the Martian Games collection.">
  <meta name="keywords" content="soccer cows, sports game, martian games, indie game">
  
  <style>
    .game-header {
      background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
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
                  <li class="breadcrumb-item"><a href="/game/martiangames" class="text-white text-decoration-none">Martian Games</a></li>
                  <li class="breadcrumb-item active text-white" aria-current="page">Soccer Cows</li>
                </ol>
              </nav>
              
              <h1 class="display-3 mb-4">
                <i class="fa-solid fa-trophy me-2"></i> Soccer Cows
              </h1>
              <p class="lead mb-4">A hilarious sports game featuring cows playing soccer! Part of the Martian Games collection.</p>
              
              <div class="d-flex gap-2 flex-wrap mb-4">
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="martiangames" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('martiangames') : null">Martian Games</button>
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="indie" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('indie') : null">Indie</button>
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="game-jam" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('game-jam') : null">Game Jam</button>
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="multiplayer" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('multiplayer') : null">Multiplayer</button>
              </div>
              
              <div class="d-flex gap-3 mb-4 flex-wrap">
                <a href="/game/martiangames" class="btn btn-lg btn-outline-light">
                  <i class="fa-solid fa-arrow-left me-2"></i>Back to Martian Games
                </a>
              </div>
            </div>
            
            <div class="col-lg-4 text-center">
              <i class="fa-solid fa-gamepad" style="font-size: 8rem; opacity: 0.8;"></i>
            </div>
          </div>
        </div>
      </section>

      <!-- Soccer Cows Video CTA -->
      <?php renderGameCTA('soccercow'); ?>

      <!-- Game Info & Gameplay Video -->
      <section class="py-5 section-pastel text-white">
        <div class="container">
          <div class="row g-4">
            <div class="col-lg-6">
              <div class="glass-card hover-lift h-100">
                <div class="card-body p-4">
                  <h3 class="mb-4"><i class="fa-solid fa-circle-info me-2"></i> About the Game</h3>
                  <p class="lead">Soccer Cows is a fun and quirky sports game jam entry from Martian Games where cows play soccer!</p>
                  <p>This lighthearted game combines sports action with humorous gameplay featuring our bovine athletes. Created as a game jam project, it showcases creative rapid prototyping.</p>
                  <p class="mt-3"><strong>Looking for more cow-related action?</strong> Check out <a href="cowdefender.php" class="text-warning">Cow Defender</a>, where you rescue cows from UFOs and deliver them safely to the airplane hangar base!</p>
                </div>
              </div>
            </div>
            
            <div class="col-lg-6">
              <div class="glass-card hover-lift h-100">
                <div class="card-body p-4">
                  <h3 class="mb-4"><i class="fa-solid fa-circle-play text-danger me-2"></i> Gameplay Video</h3>
                  <div class="ratio ratio-16x9 rounded overflow-hidden">
                    <iframe src="https://www.youtube.com/embed/4tke1Q6XKtE" 
                            title="Soccer Cows Gameplay" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen></iframe>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Screenshots -->
      <section class="py-5 section-pastel">
        <div class="container">
          <h2 class="text-white text-center mb-5">
            <i class="fa-solid fa-images me-2"></i> Screenshots
          </h2>
          
          <div class="row g-4 justify-content-center">
            <div class="col-md-4">
              <img src="<?= RES_ROOT ?>/images/gamedev/soccer-cow/soccer-cow_1.png" 
                   class="img-fluid rounded shadow w-100" 
                   alt="Soccer Cows Screenshot 1"
                   style="height: 300px; object-fit: cover;">
            </div>
            <div class="col-md-4">
              <img src="<?= RES_ROOT ?>/images/gamedev/soccer-cow/soccer-cow_2.png" 
                   class="img-fluid rounded shadow w-100" 
                   alt="Soccer Cows Screenshot 2"
                   style="height: 300px; object-fit: cover;">
            </div>
            <div class="col-md-4">
              <img src="<?= RES_ROOT ?>/images/gamedev/soccer-cow/soccer-cow_3.png" 
                   class="img-fluid rounded shadow w-100" 
                   alt="Soccer Cows Screenshot 3"
                   style="height: 300px; object-fit: cover;">
            </div>
          </div>
        </div>
      </section>

      <!-- More Martian Games -->
      <section class="py-5 section-pastel text-white">
        <div class="container">
          <h2 class="text-center mb-5">
            <i class="fa-solid fa-gamepad me-2"></i> More from Martian Games
          </h2>
          
          <div class="row g-4">
            <div class="col-md-4">
              <div class="glass-card h-100 hover-lift">
                <img src="<?= RES_ROOT ?>/images/gamedev/cowdefender/cow-defender.PNG" class="card-img-top" alt="Cow Defender" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title text-white mb-0">Cow Defender</h5>
                    <span class="badge bg-danger">Rescue</span>
                  </div>
                  <p class="card-text text-white-50 small">Rescue cows from UFOs and deliver them to the hangar base!</p>
                  <div class="mt-auto">
                    <a href="cowdefender.php" class="btn btn-sm btn-outline-light w-100">
                      <i class="fa-solid fa-play me-1"></i>View Game
                    </a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="glass-card h-100 hover-lift">
                <img src="<?= RES_ROOT ?>/images/gamedev/purgatory fell/purgatoryfell.jpg" class="card-img-top" alt="Purgatory Fell VR" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title text-white">Purgatory Fell VR</h5>
                  <p class="card-text text-white-50 small">Immersive VR horror experience</p>
                  <div class="mt-auto">
                    <a href="purgatoryfell.php" class="btn btn-sm btn-outline-light w-100">View Details</a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="glass-card h-100 hover-lift">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center py-5">
                  <i class="fa-solid fa-table-cells" style="font-size: 4rem; color: #66c0f4;"></i>
                  <h5 class="card-title mt-3 text-white">View All Games</h5>
                  <p class="card-text text-white-50 mb-4 small">Explore the complete Martian Games collection</p>
                  <a href="/game/martiangames" class="btn btn-outline-light">
                    <i class="fa-solid fa-arrow-right me-2"></i>Martian Games
                  </a>
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
  
  <script>
    if (window.tagFilter && typeof window.tagFilter.init === 'function') {
      window.tagFilter.init();
    }
  </script>
</body>

</html>
