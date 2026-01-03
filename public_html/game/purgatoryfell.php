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
  
  <title>Purgatory Fell VR | JenniNexus - Immersive VR Horror Experience</title>
  <meta name="description" content="Purgatory Fell VR - An immersive virtual reality horror experience by Martian Games. Available on Steam.">
  <meta name="keywords" content="purgatory fell, VR horror, virtual reality, martian games, steam VR, horror game">
  
  <!-- Custom Font for Martian Games -->
  <style>
    @font-face {
      font-family: 'Alien League Bold';
      src: url('<?= RES_ROOT ?>/fonts/alienleaguebold.woff') format('woff');
      font-weight: bold;
      font-style: normal;
      font-display: swap;
    }
    
    .steam-gradient {
      background: linear-gradient(135deg, #171a21 0%, #1b2838 100%);
    }
    
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
    
    .section-title {
      font-family: 'Alien League Bold', 'Montserrat', sans-serif;
      color: #66c0f4;
      text-shadow: 0 0 20px rgba(102, 192, 244, 0.5);
      letter-spacing: 2px;
    }
    
    .vr-horror-badge {
      background: linear-gradient(135deg, #dc3545, #8b0000);
      padding: 0.5rem 1rem;
      border-radius: 8px;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
  </style>
</head>

<body>
  <?php include __DIR__ . '/../includes/header.php'; ?>

  <main>
    <div class="container-fluid px-0">
      <!-- Hero Section -->
      <section class="py-5 steam-gradient text-white hero-section">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-8 glass-panel p-4 rounded-4">
              <!-- Breadcrumb -->
              <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/index" class="text-decoration-none">Home</a></li>
                  <li class="breadcrumb-item"><a href="/gamedev" class="text-decoration-none">Game Dev</a></li>
                  <li class="breadcrumb-item"><a href="/game/martiangames" class="text-decoration-none">Martian Games</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Purgatory Fell VR</li>
                </ol>
              </nav>
              
              <h1 class="display-3 mb-4 section-title hero-title" style="font-size: clamp(2.5rem, 6vw, 4.5rem);">
                <i class="fa-solid fa-vr-cardboard me-2"></i> PURGATORY FELL VR
              </h1>
              <p class="lead mb-4">An immersive virtual reality horror experience that pushes the boundaries of fear in VR. Developed by Martian Games.</p>
              
              <!-- Tags Section -->
              <div class="mb-4">
                <div class="d-flex gap-2 flex-wrap align-items-center">
                  <?php renderGameTags('purgatoryfell'); ?>
                </div>
              </div>
              
              <!-- Platform & Studio Badges -->
              <div class="d-flex gap-3 mb-4 flex-wrap align-items-center">
                <span class="badge bg-dark fs-6">
                  <i class="fa-brands fa-steam me-1"></i>Available on Steam
                </span>
                <span class="badge bg-secondary fs-6" style="cursor: default;">
                  <i class="fa-solid fa-gamepad me-1"></i>Martian Games
                </span>
              </div>
              
              <!-- Action Buttons -->
              <div class="d-flex gap-3 flex-wrap">
                <a href="#videos" class="btn btn-danger btn-lg smooth-scroll">
                  <i class="fa-brands fa-youtube me-2"></i>Purgatory Fell Videos
                </a>
                <?php 
                renderGameCTA('purgatoryfell', [
                  'show_steam' => false, // Don't show Steam button (redundant with widget below)
                  'back_url' => '/game/martiangames',
                  'back_text' => 'Back to Martian Games',
                  'button_size' => 'lg'
                ]);
                ?>
              </div>
            </div>
            
       <div class="col-lg-4 text-center">
       <img src="<?= RES_ROOT ?>/images/gamedev/purgatory%20fell/purgatoryfell.jpg" 
             class="img-fluid rounded shadow-lg" 
             alt="Purgatory Fell VR"
             style="max-height: 400px; object-fit: cover;">
           </div>
          </div>
        </div>
      </section>

      <!-- Steam Widget Section -->
      <section class="py-5 bg-dark">
        <div class="container">
          <div class="card border-0 shadow-lg steam-gradient">
            <div class="card-body p-4">
              <h2 class="text-white mb-4 text-center">
                <i class="fa-brands fa-steam text-info me-2"></i> Available on Steam
              </h2>
              <div class="text-center" style="overflow: hidden;">
                <iframe src="https://store.steampowered.com/widget/786390/" frameborder="0" width="100%" height="190" style="border: none; border-radius: 8px; overflow: hidden; min-height: 190px; max-width: 646px;" scrolling="no"></iframe>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Screenshot Gallery -->
      <section id="screenshots" class="py-5 bg-secondary bg-gradient">
        <div class="container">
          <h2 class="section-title text-center mb-5" style="font-size: clamp(2rem, 4vw, 3rem);">
            <i class="fa-solid fa-images me-2"></i> Screenshots
          </h2>
          
          <div class="row g-3">
          <div class="col-md-4">
        <img src="<?= RES_ROOT ?>/images/gamedev/purgatory%20fell/purgatoryfell.jpg" 
          class="img-fluid rounded shadow gallery-image w-100" 
          alt="Purgatory Fell VR"
             data-bs-toggle="modal" 
             data-bs-target="#galleryModal"
             data-bs-slide-to="0">
           </div>
          <div class="col-md-4">
        <img src="<?= RES_ROOT ?>/images/gamedev/purgatory%20fell/shot-.png" 
          class="img-fluid rounded shadow gallery-image w-100" 
          alt="Purgatory Fell Scene"
             data-bs-toggle="modal" 
             data-bs-target="#galleryModal"
             data-bs-slide-to="1">
           </div>
          <div class="col-md-4">
        <img src="<?= RES_ROOT ?>/images/gamedev/purgatory%20fell/ss_5a908405941a6e748e0b01e284d161145ab8d85e.1920x1080.jpg" 
          class="img-fluid rounded shadow gallery-image w-100" 
          alt="Purgatory Fell Horror"
             data-bs-toggle="modal" 
             data-bs-target="#galleryModal"
             data-bs-slide-to="2">
           </div>
          <div class="col-md-3">
        <img src="<?= RES_ROOT ?>/images/gamedev/purgatory%20fell/ss_707425c3e1949770a9751269037c02a129e8adc6.1920x1080.jpg" 
          class="img-fluid rounded shadow gallery-image w-100" 
          alt="Purgatory Fell Environment"
             data-bs-toggle="modal" 
             data-bs-target="#galleryModal"
             data-bs-slide-to="3">
           </div>
          <div class="col-md-3">
        <img src="<?= RES_ROOT ?>/images/gamedev/purgatory%20fell/ss_c4de4fa649d73f0326ac313f4c32b0dcf971f2df.1920x1080.jpg" 
          class="img-fluid rounded shadow gallery-image w-100" 
          alt="Purgatory Fell Gameplay"
             data-bs-toggle="modal" 
             data-bs-target="#galleryModal"
             data-bs-slide-to="4">
           </div>
          <div class="col-md-3">
        <img src="<?= RES_ROOT ?>/images/gamedev/purgatory%20fell/ss_c8726320b3755783d52c14be3141af6ed4edfd3d.1920x1080.jpg" 
          class="img-fluid rounded shadow gallery-image w-100" 
          alt="Purgatory Fell Scene"
             data-bs-toggle="modal" 
             data-bs-target="#galleryModal"
             data-bs-slide-to="5">
           </div>
          <div class="col-md-3">
        <img src="<?= RES_ROOT ?>/images/gamedev/purgatory%20fell/ss_cef0c2392acdecdaac49b6b9a8b59e4fdcc31232.1920x1080.jpg" 
          class="img-fluid rounded shadow gallery-image w-100" 
          alt="Purgatory Fell Horror"
             data-bs-toggle="modal" 
             data-bs-target="#galleryModal"
             data-bs-slide-to="6">
           </div>
         </div>
        </div>
      </section>

      <!-- Video Gallery - All Videos from Playlist -->
      <section id="videos" class="py-5 bg-dark">
        <div class="container">
          <h2 class="section-title text-center mb-5" style="font-size: clamp(2rem, 4vw, 3rem);">
            <i class="bi bi-play-circle-fill text-danger me-2"></i> Gameplay Videos
          </h2>
          
          <!-- Video Grid Container -->
          <div id="purgatoryfell-videos" class="row g-4 mb-4">
            <!-- Videos will be rendered here by youtube-grid.js -->
          </div>
          
          <div class="text-center mt-4">
            <a href="https://youtube.com/playlist?list=PL9QBjNDhgNwTsF4Es4jEftJR2Tto1CU53" 
               class="btn btn-lg btn-danger" 
               target="_blank" 
               rel="noopener">
              <i class="bi bi-youtube me-2"></i>View Full Playlist on YouTube
            </a>
          </div>
        </div>
      </section>

      <!-- More Martian Games -->
      <section class="py-5 steam-gradient text-white">
        <div class="container">
          <h2 class="section-title text-center mb-5" style="font-size: clamp(2rem, 4vw, 3rem);">
            More from Martian Games
          </h2>
          
          <div class="row g-4">
            <div class="col-md-4">
              <div class="card h-100 border-0 shadow-lg" style="background: #1e2329;">
                <img src="<?= RES_ROOT ?>/images/gamedev/tankoff/tank-off.png" class="card-img-top" alt="Tank Off" style="height: 250px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title mb-0 text-white">Tank Off</h5>
                    <span class="badge bg-success">Multiplayer</span>
                  </div>
                  <p class="card-text text-white-50 mb-3 small">Retro-inspired tank battle arena</p>
                  <div class="mt-auto">
                    <a href="/game/martiangames#tankoff" class="btn btn-sm btn-outline-light w-100">View Details</a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="card h-100 border-0 shadow-lg" style="background: #1e2329;">
                <img src="<?= RES_ROOT ?>/images/gamedev/botborgs/Borgverse.png" class="card-img-top" alt="Botborgs" style="height: 250px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title mb-0 text-white">Botborgs</h5>
                    <span class="badge bg-info">Web3 • 3D</span>
                  </div>
                  <p class="card-text text-white-50 mb-3 small">Web3 game featuring 3D 'Botborg' characters and an interplanetary society</p>
                  <div class="mt-auto">
                    <a href="/game/martiangames#botborgs" class="btn btn-sm btn-outline-light w-100">View Details</a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-4">
              <div class="card h-100 border-0 shadow-lg" style="background: #1e2329;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center py-5">
                  <i class="bi bi-controller" style="font-size: 4rem; color: #66c0f4;"></i>
                  <h5 class="card-title mt-3 text-white">View All Games</h5>
                  <p class="card-text text-white-50 mb-4 small">Explore the complete Martian Games collection</p>
                  <a href="/game/martiangames" class="btn btn-outline-light">
                    <i class="bi bi-arrow-right me-2"></i>Martian Games
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

  <!-- Gallery Modal -->
  <div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content bg-dark">
        <div class="modal-header border-secondary">
          <h5 class="modal-title text-white" id="galleryModalLabel">Purgatory Fell VR Gallery</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="galleryCarousel" class="carousel slide" data-bs-ride="false">
              <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="<?= RES_ROOT ?>/images/gamedev/purgatory%20fell/purgatoryfell.jpg" class="d-block w-100" alt="Purgatory Fell VR">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/purgatory%20fell/shot-.png" class="d-block w-100" alt="Purgatory Fell Scene">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/purgatory%20fell/ss_5a908405941a6e748e0b01e284d161145ab8d85e.1920x1080.jpg" class="d-block w-100" alt="Purgatory Fell Horror">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/purgatory%20fell/ss_707425c3e1949770a9751269037c02a129e8adc6.1920x1080.jpg" class="d-block w-100" alt="Purgatory Fell Environment">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/purgatory%20fell/ss_c4de4fa649d73f0326ac313f4c32b0dcf971f2df.1920x1080.jpg" class="d-block w-100" alt="Purgatory Fell Gameplay">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/purgatory%20fell/ss_c8726320b3755783d52c14be3141af6ed4edfd3d.1920x1080.jpg" class="d-block w-100" alt="Purgatory Fell Scene">
              </div>
              <div class="carousel-item">
                <img src="<?= RES_ROOT ?>/images/gamedev/purgatory%20fell/ss_cef0c2392acdecdaac49b6b9a8b59e4fdcc31232.1920x1080.jpg" class="d-block w-100" alt="Purgatory Fell Horror">
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

  <!-- Custom Scripts -->
  <script src="<?= RES_ROOT ?>/js/tag-filter-api<?= $assetSuffix ?? '' ?>.js"></script>
  <script src="<?= RES_ROOT ?>/js/youtube-grid<?= $assetSuffix ?? '' ?>.js"></script>
  <script src="<?= RES_ROOT ?>/js/tag-system<?= $assetSuffix ?? '' ?>.js"></script>
  
  <script>
    // Initialize tag filter API
    if (window.tagFilter && typeof window.tagFilter.init === 'function') {
      window.tagFilter.init();
    }
    
    // Smooth scroll for internal anchor links
    document.querySelectorAll('.smooth-scroll').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
      });
    });
    
    // Load Purgatory Fell videos from gamedev.yaml
    (function(){
      function loadPurgatoryFellVideos() {
        if (window.YouTubeGrid && typeof window.YouTubeGrid.renderSection === 'function') {
          try {
            // Load from gamedev.yaml and render only the Purgatory Fell playlist
            fetch('<?= RES_ROOT ?>/playlists/gamedev.yaml')
              .then(response => response.text())
              .then(yamlText => {
                const config = jsyaml.load(yamlText);
                const purgatoryFellPlaylist = config.featured_section.playlists.find(p => p.id === 'PL9QBjNDhgNwTsF4Es4jEftJR2Tto1CU53');
                
                if (purgatoryFellPlaylist) {
                  // Create a custom section config for rendering
                  const sectionConfig = {
                    container_id: 'purgatoryfell-videos',
                    render_mode: 'videos',
                    columns: { xs: 1, sm: 2, md: 3, lg: 5 },
                    videos_per_playlist: 5,
                    aspect_ratio: '16:9',
                    playlists: [purgatoryFellPlaylist]
                  };
                  
                  window.YouTubeGrid.renderSection('purgatoryfell-videos', sectionConfig, config);
                  console.log('✅ Purgatory Fell page: Loaded 5 videos from gamedev.yaml');
                }
              })
              .catch(e => console.error('❌ Failed to load gamedev.yaml', e));
          } catch(e) {
            console.error('❌ Purgatory Fell page: Failed to load config', e);
          }
        } else {
          console.warn('⚠️ YouTubeGrid not available, retrying...');
          setTimeout(loadPurgatoryFellVideos, 100);
        }
      }
      
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadPurgatoryFellVideos);
      } else {
        loadPurgatoryFellVideos();
      }
    })();
  </script>
</body>

</html>
