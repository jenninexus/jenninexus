<?php
// Page-specific CSS
$customCSS = [
  '/resources/css/gamedev-theme.min.css',
  '/resources/css/media.min.css'
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php 
    include __DIR__ . '/../includes/head.php';
    include __DIR__ . '/../includes/game-cta-helper.php';
  ?>
  
  <!-- Custom Font for Martian Games -->
  <style>
    @font-face {
      font-family: 'Alien League Bold';
      src: url('<?= RES_ROOT ?>/fonts/alienleaguebold.woff') format('woff');
      font-weight: bold;
      font-style: normal;
      font-display: swap;
    }
    
    /* Steam-inspired gradient backgrounds */
    .steam-gradient {
      background: linear-gradient(135deg, #171a21 0%, #1b2838 100%);
    }
    
    /* Gallery images (carousel screenshots) - specific to prevent conflicts */
    .carousel-item img {
      cursor: pointer;
      transition: transform 0.3s ease, opacity 0.3s ease;
      height: 200px;
      object-fit: cover;
    }
    
    /* Gallery image hover only applies to images inside carousels */
    #tankoffCarousel .carousel-item img:hover {
      transform: scale(1.02);
      opacity: 0.95;
    }
    
    .section-title {
      font-family: 'Alien League Bold', 'Montserrat', sans-serif;
      color: #66c0f4;
      text-shadow: 0 0 20px rgba(102, 192, 244, 0.5);
      letter-spacing: 2px;
    }
    
    /* Enhanced Video Grid Cards - Scoped to prevent hover conflicts */
    #tankoff-playlists .video-card {
      background: #0b1220;
      border: 1px solid rgba(102, 192, 244, 0.2);
      border-radius: 8px;
      overflow: hidden;
      transition: all 0.3s ease;
      height: 100%;
      text-decoration: none;
      display: block;
    }
    
    #tankoff-playlists .video-card:hover {
      transform: translateY(-8px);
      border-color: #66c0f4;
      box-shadow: 0 12px 24px rgba(102, 192, 244, 0.4);
      text-decoration: none;
    }
    
    #tankoff-playlists .video-card img {
      width: 100%;
      height: auto;
      transition: transform 0.3s ease;
    }
    
    #tankoff-playlists .video-card:hover img {
      transform: scale(1.05);
    }
    
    .video-card-body {
      padding: 1rem;
    }
    
    .video-title {
      font-size: 0.95rem;
      font-weight: 600;
      color: #c7d5e0;
      margin-bottom: 0.5rem;
      line-height: 1.4;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    
    .video-description {
      font-size: 0.85rem;
      color: #8899a6;
      line-height: 1.4;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    
    /* Carousel Controls Enhancement - Better visibility */
    .carousel-control-prev,
    .carousel-control-next {
      width: 5%;
      background: rgba(0, 0, 0, 0.5);
      border-radius: 4px;
      margin: 0 10px;
    }
    
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
      filter: invert(1) brightness(2) drop-shadow(0 0 8px rgba(255, 255, 255, 0.9));
      width: 3rem;
      height: 3rem;
      background-color: rgba(102, 192, 244, 0.5);
      border-radius: 50%;
      padding: 0.5rem;
    }
    
    .carousel-control-prev:hover,
    .carousel-control-next:hover {
      background: rgba(0, 0, 0, 0.7);
    }
    
    .carousel-indicators {
      margin-bottom: 0;
    }
    
    .carousel-item img {
      object-fit: contain;
      max-height: 600px;
      width: 100%;
    }
    
    /* Steam iframe - remove white background */
    .steam-iframe-wrapper iframe {
      background: transparent !important;
      display: block;
    }
    
    .steam-iframe-wrapper {
      background: #1b2838;
      border-radius: 8px;
      overflow: hidden;
    }
    
    /* Loading Placeholder */
    .placeholder-card {
      background: #0b1220;
      border: 1px solid rgba(102, 192, 244, 0.1);
      border-radius: 8px;
      overflow: hidden;
      height: 100%;
      padding: 1rem;
    }
    
    .placeholder-shimmer {
      background: linear-gradient(90deg, #0b1220 0%, #1b2838 50%, #0b1220 100%);
      background-size: 200% 100%;
      animation: shimmer 1.5s infinite;
    }
    
    @keyframes shimmer {
      0% { background-position: 200% 0; }
      100% { background-position: -200% 0; }
    }
  </style>
</head>

<body>
  <?php include __DIR__ . '/../includes/header.php'; ?>

  <main>
    <div class="container-fluid px-0">
  <!-- Hero Section -->
  <section class="hero-section py-5 steam-gradient text-white">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-8">
              <div class="glass-panel p-5 rounded-4 shadow-lg">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4 hero-title">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-white-50 text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="/game/martiangames.php" class="text-white-50 text-decoration-none">Martian Games</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Tank Off</li>
                  </ol>
                </nav>
                
                <h1 class="display-3 mb-4 section-title hero-title" style="font-size: clamp(2.5rem, 6vw, 4.5rem);">
                  TANK OFF
                </h1>
                <p class="lead mb-4 hero-title">Retro-inspired tank battle arena featuring explosive multiplayer mayhem and strategic combat.</p>
                
                <!-- Social Links -->
                <div class="d-flex gap-2 gap-md-3 mb-4 flex-wrap hero-title">
                  <a href="https://gamejolt.com/games/tankoff/526957" 
                     class="btn btn-lg" 
                     target="_blank" 
                     rel="noopener"
                     style="background: linear-gradient(135deg, #0b3d91, #1366d6); border: 2px solid #1366d6; color: white;">
                  <i class="fa-solid fa-gamepad me-2"></i>Play on GameJolt
                </a>
                <a href="https://www.youtube.com/@martiangames" 
                   class="btn btn-outline-light btn-lg" 
                   target="_blank" 
                   rel="noopener">
                  <i class="fa-brands fa-youtube me-2"></i>YouTube
                </a>
              </div>
            </div>
          </div>
            
            <div class="col-lg-4 text-center">
              <!-- Hero image intentionally removed per request (no profile pics) -->
            </div>
          </div>
        </div>
      </section>



  <!-- Tank Off Section -->
  <section id="tankoff" class="py-5" style="background: linear-gradient(135deg,#0b3d91 0%, #1366d6 100%);">
        <div class="container">
          <div class="row mb-4">
            <div class="col-lg-8">
              <h2 class="section-title mb-3" style="font-size: clamp(2rem, 4vw, 3rem);">
                <i class="fa-solid fa-dice-five me-2"></i> Tank Off
              </h2>
              <button type="button" class="badge bg-info fs-6 mb-3 tag-badge" data-tag-slug="multiplayer" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('multiplayer') : null" style="cursor: pointer;">Multiplayer</button>
              <p class="lead text-white-50">Retro-inspired tank battle arena featuring explosive multiplayer mayhem and strategic combat.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
          <a href="https://gamejolt.com/games/tankoff/526957" 
            class="btn btn-lg" 
                 target="_blank" 
                 rel="noopener"
            style="background: linear-gradient(135deg, #0b3d91, #1366d6); border: 2px solid #1366d6; color: white;">
                <i class="fa-solid fa-gamepad me-2"></i>Play on GameJolt
              </a>
            </div>
          </div>
          
          <!-- Screenshot Carousel -->
          <div id="tankoffCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#tankoffCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#tankoffCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#tankoffCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
              <button type="button" data-bs-target="#tankoffCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
              <button type="button" data-bs-target="#tankoffCarousel" data-bs-slide-to="4" aria-label="Slide 5"></button>
              <button type="button" data-bs-target="#tankoffCarousel" data-bs-slide-to="5" aria-label="Slide 6"></button>
              <button type="button" data-bs-target="#tankoffCarousel" data-bs-slide-to="6" aria-label="Slide 7"></button>
              <button type="button" data-bs-target="#tankoffCarousel" data-bs-slide-to="7" aria-label="Slide 8"></button>
              <button type="button" data-bs-target="#tankoffCarousel" data-bs-slide-to="8" aria-label="Slide 9"></button>
            </div>
            <div class="carousel-inner rounded shadow-lg" style="background: #000;">
              <div class="carousel-item active">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/tankoff-boxart.jpg" class="d-block w-100" alt="Tank Off Box Art">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/tank-off.png" class="d-block w-100" alt="Tank Off Logo">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/ss_383a0479a7a076ede8f0deaf167bb2057976fa69.1920x1080.jpg" class="d-block w-100" alt="Tank Off Arena">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/ss_1218ef81064355ff6aaa5be65aee57e09747a4f3.1920x1080.jpg" class="d-block w-100" alt="Tank Off Combat">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/ss_3312a4cffe4897c02a4e676f0a7187cda54f6041.1920x1080.jpg" class="d-block w-100" alt="Tank Off Battle">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/ss_3373288e1a3a39816c9773eda7b42d0e49725dc4.1920x1080.jpg" class="d-block w-100" alt="Tank Off Gameplay">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/ss_4909733d058e2fbb534b3473a21fd1ad438119b7.1920x1080.jpg" class="d-block w-100" alt="Tank Off Map">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/ss_6151639b0d5c7c31ae6774d88a743d9abdfd9722.1920x1080.jpg" class="d-block w-100" alt="Tank Off Action">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/ss_c3df6d6ddbaa55ccd0ee199f9c81d2c8e04ff165.1920x1080.jpg" class="d-block w-100" alt="Tank Off Multiplayer">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#tankoffCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#tankoffCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
          
          <!-- Video Playlist -->
          <div class="card border-0 shadow-lg steam-gradient mb-4">
            <div class="card-body p-4">
              <h3 class="text-white mb-4">
                <i class="fa-brands fa-youtube text-danger me-2"></i> Watch Trailer
              </h3>
              <div class="text-center mb-3">
                <div class="ratio ratio-16x9">
                  <iframe src="https://www.youtube.com/embed/wAnJiM3_6G0?si=QkjMW-lH5zYadVJZ" 
                          title="Tank Off Trailer" 
                          frameborder="0" 
                          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                          allowfullscreen>
                  </iframe>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Video Playlist -->
          <div class="card border-0 shadow-lg steam-gradient">
            <div class="card-body p-4">
              <h3 class="text-white mb-4">
                <i class="fa-brands fa-youtube text-danger me-2"></i> Gameplay Videos
              </h3>
              <!-- Using Martian Games Gameplay playlist - includes Tank Off and other titles -->
              <div class="video-grid-container" id="tankoff-playlists" data-playlist="PL6WnzXOaRqA1sfMS1N7EoESHKaTZ2RHh4"></div>
            </div>
          </div>
        </div>
      </section>



      <!-- Call to Action -->
      <section class="py-5 steam-gradient text-white text-center">
        <div class="container">
          <h2 class="section-title mb-4" style="font-size: clamp(2rem, 4vw, 3rem);">
            <a href="https://martiangames.com/fund" target="_blank" rel="noopener" class="text-white text-decoration-none hover-glow">
              martiangames.com/fund
            </a>
          </h2>
          <p class="lead mb-4">Help bring more retro-inspired indie games to life!</p>
          <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="https://steamcommunity.com/groups/MartianGames" 
               class="btn btn-lg" 
               target="_blank" 
               rel="noopener"
               style="background: linear-gradient(135deg, #171a21, #1b2838); border: 2px solid #66c0f4; color: #c7d5e0;">
              <i class="fa-brands fa-steam me-2"></i>Join Steam Group
            </a>
            <a href="/gamedev.php" class="btn btn-lg btn-outline-light">
              <i class="fa-solid fa-arrow-left me-2"></i>Back to Game Dev
            </a>
          </div>
        </div>
      </section>
    </div>
  </main>

  <?php include __DIR__ . '/../includes/tag-filter-offcanvas.php'; ?>

  <?php include __DIR__ . '/../includes/footer.php'; ?>



  <!-- Tank Off Modal -->
  <div class="modal fade" id="tankoffModal" tabindex="-1" aria-labelledby="tankoffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content bg-dark">
        <div class="modal-header border-secondary">
          <h5 class="modal-title text-white" id="tankoffModalLabel">Tank Off Gallery</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="tankoffCarousel" class="carousel slide" data-bs-ride="false">
              <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/tankoff-boxart.jpg" class="d-block w-100" alt="Tank Off Box Art">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/TankOff.png" class="d-block w-100" alt="Tank Off Logo">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/ss_383a0479a7a076ede8f0deaf167bb2057976fa69.1920x1080.jpg" class="d-block w-100" alt="Arena">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/ss_1218ef81064355ff6aaa5be65aee57e09747a4f3.1920x1080.jpg" class="d-block w-100" alt="Combat">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/ss_3312a4cffe4897c02a4e676f0a7187cda54f6041.1920x1080.jpg" class="d-block w-100" alt="Battle">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/ss_3373288e1a3a39816c9773eda7b42d0e49725dc4.1920x1080.jpg" class="d-block w-100" alt="Gameplay">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/ss_4909733d058e2fbb534b3473a21fd1ad438119b7.1920x1080.jpg" class="d-block w-100" alt="Map">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/ss_6151639b0d5c7c31ae6774d88a743d9abdfd9722.1920x1080.jpg" class="d-block w-100" alt="Action">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/ss_c3df6d6ddbaa55ccd0ee199f9c81d2c8e04ff165.1920x1080.jpg" class="d-block w-100" alt="Multiplayer">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#tankoffCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#tankoffCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>



  <!-- Custom Scripts -->
  <script src="<?= RES_ROOT ?>/js/tag-filter-api<?= $assetSuffix ?? '' ?>.js"></script>
  <script src="<?= RES_ROOT ?>/js/youtube-grid<?= $assetSuffix ?? '' ?>.js"></script>
  <script src="<?= RES_ROOT ?>/js/tag-system<?= $assetSuffix ?? '' ?>.js"></script>
  
  <script>
    // Initialize tag filter API
    if (window.tagFilter && typeof window.tagFilter.init === 'function') {
      window.tagFilter.init();
    }
    
    // Steam iframe graceful fallback: if the iframe fails to load or has zero height, show a link to the store page
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.steam-iframe-wrapper').forEach(function (wrapper) {
        var appid = wrapper.getAttribute('data-appid');
        var iframe = wrapper.querySelector('iframe');
        if (!iframe) return;

        // If iframe doesn't load within 2s or has no content, replace with a friendly link
        var timedOut = false;
        var timeout = setTimeout(function () {
          timedOut = true;
          showFallback();
        }, 2000);

        iframe.addEventListener('load', function () {
          clearTimeout(timeout);
          // if iframe height is very small (blocked), show fallback
          try {
            if (iframe.clientHeight < 50) showFallback();
          } catch (e) {
            // cross-origin access may throw; assume it's fine if loaded
          }
        });

        function showFallback() {
          if (timedOut && wrapper.querySelector('.steam-fallback')) return;
          wrapper.innerHTML = '<div class="steam-fallback p-3 text-center">\n' +
            '<p class="mb-2 text-white-50">Steam widget blocked or unavailable.</p>' +
            '<a class="btn btn-primary" href="https://store.steampowered.com/app/' + appid + '/" target="_blank" rel="noopener">View on Steam</a>' +
            '</div>';
        }
      });
    });

    // Add global image error fallback to replace broken images with a neutral placeholder
    document.querySelectorAll('img.gallery-image').forEach(function(img){
      img.addEventListener('error', function(){
        if (img.dataset._errored) return; // prevent loop
        img.dataset._errored = '1';
      img.src = '<?= RES_ROOT ?>/images/placeholder-180.png';
        img.classList.add('opacity-75');
      });
    });

    // YouTube Grid - render playlist videos
    (function() {
      const playlists = [
        { containerId: 'tankoff-playlists', playlistId: 'PL6WnzXOaRqA1sfMS1N7EoESHKaTZ2RHh4', columns: { xs: 1, sm: 2, md: 3, lg: 5 } }
      ];
      
      let attempts = 0;
      function renderPlaylists() {
        if (window.YouTubeGrid && typeof window.YouTubeGrid.renderPlaylist === 'function') {
          playlists.forEach(playlist => {
            window.YouTubeGrid.renderPlaylist(playlist.containerId, playlist.playlistId, {
              maxVideos: 6,
              columns: playlist.columns
            }).catch(err => console.warn(`Failed to render ${playlist.containerId}:`, err));
          });
          console.log('✅ Tank Off playlists rendered');
          return;
        }
        
        attempts++;
        if (attempts < 20) setTimeout(renderPlaylists, 200);
        else console.warn('YouTubeGrid not available for Tank Off playlists');
      }
      
      renderPlaylists();
    })();
  </script>
</body>

</html>
