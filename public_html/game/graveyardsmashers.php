<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <?php 
    $activePage = 'gamedev';
    $pageTitle = 'Graveyard Smashers | JenniNexus - Action Game';
    $pageDescription = 'Graveyard Smashers - An action-packed graveyard adventure game featuring spooky enemies and fast-paced combat.';
    $pageKeywords = 'graveyard smashers, action game, indie game, unity, gamejolt';
    $customCSS = [
      'resources/css/gamedev-theme.min.css',
      'resources/css/media.min.css'
    ];
    
    include __DIR__ . '/../includes/head.php';
    include __DIR__ . '/../includes/game-cta-helper.php';
  ?>
  
  <style>
    .game-header {
      background: linear-gradient(135deg, #6b21a8 0%, #8b5cf6 100%);
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
                  <li class="breadcrumb-item active text-white" aria-current="page">Graveyard Smashers</li>
                </ol>
              </nav>
              
              <h1 class="display-3 mb-4">
                <i class="fa-solid fa-moon me-2"></i> Graveyard Smashers
              </h1>
              <p class="lead mb-4">An action-packed graveyard adventure!</p>
              
              <div class="d-flex gap-2 flex-wrap mb-4">
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="action" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('action') : null">Action</button>
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="indie" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('indie') : null">Indie</button>
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="unity" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('unity') : null">Unity</button>
                <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="archive" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('archive') : null">Archive</button>
              </div>
              
              <!-- CTA Buttons will be rendered here by game-cta-helper -->
            </div>
            
            <div class="col-lg-4 text-center">
              <img src="<?= RES_ROOT ?>/images/gamedev/graveyardsmashers/graveyardsmashers_banner.jpg" 
                   class="img-fluid rounded shadow-lg" 
                   alt="Graveyard Smashers">
            </div>
          </div>
        </div>
      </section>

      <!-- Graveyard Smashers CTA -->
      <?php renderGameCTA('graveyardsmashers', ['external_url' => 'https://gamejolt.com/games/graveyardsmashers/446127', 'external_text' => 'Play on GameJolt']); ?>

      <!-- Gameplay Videos & Social -->
      <section class="py-5 bg-dark">
        <div class="container">
          <div class="row g-4">
            <!-- Instagram 9:16 Video -->
            <div class="col-lg-4">
              <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.1);">
                <div class="card-body p-4">
                  <h3 class="text-white mb-4">
                    <i class="fa-brands fa-instagram text-danger me-2"></i> Instagram Reel
                  </h3>
                  <div style="max-width: 540px; margin: 0 auto;">
                    <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/reel/DQpjFTKEurB/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
                      <div style="padding:16px;">
                        <a href="https://www.instagram.com/reel/DQpjFTKEurB/?utm_source=ig_embed&amp;utm_campaign=loading" style="background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank">
                          <div style="display: flex; flex-direction: row; align-items: center;">
                            <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div>
                            <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;">
                              <div style="background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div>
                              <div style="background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div>
                            </div>
                          </div>
                          <div style="padding: 19% 0;"></div>
                          <div style="display:block; height:50px; margin:0 auto 12px; width:50px;">
                            <svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">
                              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g transform="translate(-511.000000, -20.000000)" fill="#000000">
                                  <g>
                                    <path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path>
                                  </g>
                                </g>
                              </g>
                            </svg>
                          </div>
                          <div style="padding-top: 8px;">
                            <div style="color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this post on Instagram</div>
                          </div>
                          <div style="padding: 12.5% 0;"></div>
                        </a>
                        <p style="color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;">
                          <a href="https://www.instagram.com/reel/DQpjFTKEurB/?utm_source=ig_embed&amp;utm_campaign=loading" style="color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;" target="_blank">A post shared by jenni (@jenninexus)</a>
                        </p>
                      </div>
                    </blockquote>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- YouTube Gameplay Video -->
            <div class="col-lg-8">
              <div class="card border-0 shadow-lg h-100" style="background: rgba(255,255,255,0.1);">
                <div class="card-body p-4">
                  <h3 class="text-white mb-4">
                    <i class="fa-brands fa-youtube text-danger me-2"></i> Gameplay Video
                  </h3>
                  <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/wOrDbXrRcf8?si=MtY5gwq1DFZH_5Mw" 
                            title="Graveyard Smashers Gameplay" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen>
                    </iframe>
                  </div>
                </div>
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
          
          <div class="row g-4">
            <div class="col-md-4">
              <img src="<?= RES_ROOT ?>/images/gamedev/graveyardsmashers/graveyardsmashers_banner.jpg" 
                   class="img-fluid rounded shadow gallery-image w-100" 
                   alt="Graveyard Smashers Banner"
                   data-bs-toggle="modal" 
                   data-bs-target="#galleryModal"
                   data-bs-slide-to="0">
            </div>
            <div class="col-md-4">
              <img src="<?= RES_ROOT ?>/images/gamedev/graveyardsmashers/graveyardsmashers2.jpg" 
                   class="img-fluid rounded shadow gallery-image w-100" 
                   alt="Graveyard Smashers Gameplay"
                   data-bs-toggle="modal" 
                   data-bs-target="#galleryModal"
                   data-bs-slide-to="1">
            </div>
            <div class="col-md-4">
              <img src="<?= RES_ROOT ?>/images/gamedev/graveyardsmashers/sceen2-bmdwkwxa.jpg" 
                   class="img-fluid rounded shadow gallery-image w-100" 
                   alt="Graveyard Smashers Scene"
                   data-bs-toggle="modal" 
                   data-bs-target="#galleryModal"
                   data-bs-slide-to="2">
            </div>
          </div>
        </div>
      </section>

      <!-- Game Info -->
      <section class="py-5 bg-secondary bg-gradient text-white">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="card border-0 shadow-lg" style="background: rgba(255,255,255,0.1);">
                <div class="card-body p-4">
                  <h3 class="mb-4"><i class="fa-solid fa-circle-info me-2"></i> About the Game</h3>
                  <p class="lead">Graveyard Smashers is an action-packed game set in a spooky graveyard environment.</p>
                </div>
              </div>
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
          <h5 class="modal-title text-white" id="galleryModalLabel">Graveyard Smashers Gallery</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="galleryCarousel" class="carousel slide" data-bs-ride="false">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="<?= RES_ROOT ?>/images/gamedev/graveyardsmashers/graveyardsmashers_banner.jpg" class="d-block w-100" alt="Graveyard Smashers Banner">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/graveyardsmashers/graveyardsmashers2.jpg" class="d-block w-100" alt="Graveyard Smashers Gameplay">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/graveyardsmashers/sceen2-bmdwkwxa.jpg" class="d-block w-100" alt="Graveyard Smashers Scene">
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
  
  <!-- Instagram Embed Script -->
  <script async src="//www.instagram.com/embed.js"></script>
  
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
