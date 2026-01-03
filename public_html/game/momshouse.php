<!DOCTYPE html>
<html lang="en">

<head>
  <?php 
    include __DIR__ . '/../includes/head.php';
    include __DIR__ . '/../includes/game-cta-helper.php';
  ?>
  
  <title>Mom's House Quest | JenniNexus - Hilarious Adventure Game</title>
  <meta name="description" content="Mom's House Quest - A funny adventure game where you navigate through Mom's house. Available on GameJolt.">
  <meta name="keywords" content="moms house quest, indie game, adventure game, funny game, gamejolt">
  
  <style>
    .game-header {
      background: linear-gradient(135deg, #2f7f6f 0%, #31a591 100%);
    }
    
    .gallery-image {
      cursor: pointer;
      transition: transform 0.3s ease, opacity 0.3s ease;
      height: 250px;
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

  <main>
    <div class="container-fluid px-0">
      <!-- Hero Section -->
      <section class="py-5 game-header text-white">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-8">
              <!-- Breadcrumb -->
              <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/index" class="text-white text-decoration-none">Home</a></li>
                  <li class="breadcrumb-item"><a href="/gamedev" class="text-white text-decoration-none">Game Dev</a></li>
                  <li class="breadcrumb-item active text-white" aria-current="page">Mom's House Quest</li>
                </ol>
              </nav>
              
              <h1 class="display-3 mb-4" style="font-size: clamp(2.5rem, 6vw, 4.5rem);">
                <i class="fa-solid fa-house me-2"></i> Mom's House Quest
              </h1>
              <p class="lead mb-4">A hilarious adventure game where you navigate through Mom's house. Watch out for Giant Granny!</p>
              
              <div class="d-flex gap-2 flex-wrap mb-4">
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="funny-games" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('funny-games') : null">Funny</button>
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="adventure" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('adventure') : null">Adventure</button>
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="indie" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('indie') : null">Indie</button>
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="unity" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('unity') : null">Unity</button>
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="webgl" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('webgl') : null">WebGL</button>
              </div>
              
              <!-- Action Buttons -->
              <div class="d-flex gap-3 mb-4 flex-wrap">
                <a href="https://gamejolt.com/games/Moms-House-Quest/453743" 
                   class="btn btn-lg btn-light" 
                   target="_blank" 
                   rel="noopener">
                  <i class="fa-solid fa-gamepad me-2"></i>Play on GameJolt
                </a>
                <a href="https://youtu.be/kje1yDVMPx4" 
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
              <img src="<?= RES_ROOT ?>/images/gamedev/momshouse/momshousequest_featured.png" 
                   class="img-fluid rounded shadow-lg" 
                   alt="Mom's House Quest"
                   style="max-height: 400px; object-fit: cover;">
            </div>
          </div>
        </div>
      </section>

      <!-- Mom's House Quest CTA -->
      <?php renderGameCTA('momshouse'); ?>

      <!-- Game Info & Development Highlight -->
      <section class="py-5 bg-dark text-white">
        <div class="container">
          <div class="row g-4">
            <div class="col-lg-6">
              <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.1);">
                <div class="card-body p-4">
                  <h3 class="mb-4"><i class="fa-solid fa-circle-info me-2"></i> About the Game</h3>
                  <p class="lead">Mom's House Quest is a funny adventure game that takes you through various rooms in Mom's house. Watch out for the Giant Granny!</p>
                  <p>This quirky indie game features humorous scenarios and unexpected encounters as you explore the house. Perfect for a lighthearted gaming experience.</p>
                  
                  <div class="mt-4">
                    <a href="https://gamejolt.com/games/Moms-House-Quest/453743" 
                       class="btn btn-lg" 
                       target="_blank" 
                       rel="noopener"
                       style="background: linear-gradient(135deg, #2f7f6f, #31a591); border: 2px solid #31a591; color: white;">
                      <i class="fa-solid fa-gamepad me-2"></i>Play Now on GameJolt
                    </a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-lg-6">
              <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.1);">
                <div class="card-body p-4">
                  <h3 class="mb-4"><i class="fa-solid fa-circle-play text-danger me-2"></i> Development Highlight</h3>
                  <div class="ratio ratio-16x9 rounded overflow-hidden">
                    <iframe src="https://www.youtube.com/embed/kje1yDVMPx4" 
                            title="Mom's House Quest Development Highlight" 
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

      <!-- Screenshot Gallery -->
      <section id="screenshots" class="py-5 bg-secondary bg-gradient">
        <div class="container">
          <h2 class="text-white text-center mb-5">
            <i class="fa-solid fa-images me-2"></i> Screenshots
          </h2>
          
          <div class="row g-3 g-md-4">
            <div class="col-6 col-md-4 col-lg-3">
              <img src="<?= RES_ROOT ?>/images/gamedev/momshouse/momshousequest_featured.png" 
                   class="img-fluid rounded shadow gallery-image w-100" 
                   alt="Mom's House Quest"
                   data-bs-toggle="modal" 
                   data-bs-target="#galleryModal"
                   data-bs-slide-to="0">
            </div>
            <div class="col-6 col-md-4 col-lg-3">
              <img src="<?= RES_ROOT ?>/images/gamedev/momshouse/moms-house.png" 
                   class="img-fluid rounded shadow gallery-image w-100" 
                   alt="Mom's House"
                   data-bs-toggle="modal" 
                   data-bs-target="#galleryModal"
                   data-bs-slide-to="1">
            </div>
            <div class="col-6 col-md-4 col-lg-3">
              <img src="<?= RES_ROOT ?>/images/gamedev/momshouse/giantessgranny.png" 
                   class="img-fluid rounded shadow gallery-image w-100" 
                   alt="Giant Granny"
                   data-bs-toggle="modal" 
                   data-bs-target="#galleryModal"
                   data-bs-slide-to="2">
            </div>
            <div class="col-6 col-md-4 col-lg-3">
              <img src="<?= RES_ROOT ?>/images/gamedev/momshouse/momshouse-bedroom.jpg" 
                   class="img-fluid rounded shadow gallery-image w-100" 
                   alt="Bedroom"
                   data-bs-toggle="modal" 
                   data-bs-target="#galleryModal"
                   data-bs-slide-to="3">
            </div>
            <div class="col-6 col-md-4 col-lg-3">
              <img src="<?= RES_ROOT ?>/images/gamedev/momshouse/momshouse-familyroom.jpg" 
                   class="img-fluid rounded shadow gallery-image w-100" 
                   alt="Family Room"
                   data-bs-toggle="modal" 
                   data-bs-target="#galleryModal"
                   data-bs-slide-to="4">
            </div>
            <div class="col-6 col-md-4 col-lg-3">
              <img src="<?= RES_ROOT ?>/images/gamedev/momshouse/momshouse-tree.jpg" 
                   class="img-fluid rounded shadow gallery-image w-100" 
                   alt="Tree Scene"
                   data-bs-toggle="modal" 
                   data-bs-target="#galleryModal"
                   data-bs-slide-to="5">
            </div>
            <div class="col-6 col-md-4 col-lg-3">
              <img src="<?= RES_ROOT ?>/images/gamedev/momshouse/tvroom_1-vrvefybb.jpg" 
                   class="img-fluid rounded shadow gallery-image w-100" 
                   alt="TV Room"
                   data-bs-toggle="modal" 
                   data-bs-target="#galleryModal"
                   data-bs-slide-to="6">
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>

  <?php include __DIR__ . '/../includes/footer.php'; ?>

  <!-- Gallery Modal -->
  <div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content bg-dark">
        <div class="modal-header border-secondary">
          <h5 class="modal-title text-white" id="galleryModalLabel">Mom's House Quest Gallery</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="galleryCarousel" class="carousel slide" data-bs-ride="false">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="<?= RES_ROOT ?>/images/gamedev/momshouse/momshousequest_featured.png" class="d-block w-100" alt="Mom's House Quest">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/momshouse/moms-house.png" class="d-block w-100" alt="Mom's House">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/momshouse/giantessgranny.png" class="d-block w-100" alt="Giant Granny">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/momshouse/momshouse-bedroom.jpg" class="d-block w-100" alt="Bedroom">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/momshouse/momshouse-familyroom.jpg" class="d-block w-100" alt="Family Room">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/momshouse/momshouse-tree.jpg" class="d-block w-100" alt="Tree Scene">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/momshouse/tvroom_1-vrvefybb.jpg" class="d-block w-100" alt="TV Room">
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
