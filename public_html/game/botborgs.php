<?php
$activePage = 'game-botborgs';
$pageTitle = 'Botborgs - JenniNexus';
$pageDescription = 'Botborgs - Web3 game featuring 3D Botborg characters and an interplanetary society and economic system by Martian Games.';
$pageKeywords = 'botborgs, web3 game, martian games, indie game, 3d-modeling, borgverse';

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
  <body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <!-- Botborgs Playlist CTA -->
    <?php renderGameCTA('botborgs'); ?>

    <main class="py-5 hero-section">
      <div class="container">
        <div class="row mb-4">
          <div class="col-lg-8 mx-auto text-center glass-panel p-5 rounded-4">
            <h1 class="display-4 hero-title">Botborgs</h1>
            <p class="lead text-muted">Web3 game featuring 3D 'Botborg' characters and an interplanetary society and economic system. Explore the development process, gameplay highlights, and community coverage.</p>
            <p class="small text-muted">Featured on: <a href="https://kotaku.com/games/botborgs" target="_blank" rel="noopener" class="text-info"><i class="bi bi-newspaper me-1"></i>Kotaku</a></p>
          </div>
        </div>

        <div class="row g-4">
          <div class="col-lg-8">
            <div class="card h-100 border-0 shadow-sm content-item site-glass" data-tags="web3,3d-modeling,martiangames,botborgs,gamedev">
              <div class="card-body p-4">
                <h3 class="h5 mb-3">About Botborgs</h3>
                <p class="text-muted">Botborgs is a Web3 game featuring 3D 'Botborg' characters and an interplanetary society and economic system, originally developed as part of the Martian Games collaboration. This page collects devlogs, gameplay highlights, and assets related to the project.</p>

                <h4 class="mt-4">Featured Playlist</h4>
                <div id="botborgs-playlist" class="mb-3"></div>

                <p class="mt-3">
                  <a href="https://gamejolt.com/games/botborgs" target="_blank" class="btn btn-outline-primary me-2" rel="noopener">
                    <i class="bi bi-joystick me-1"></i>Play on GameJolt
                  </a>
                  <a href="https://kotaku.com/games/botborgs" target="_blank" class="btn btn-outline-info" rel="noopener">
                    <i class="bi bi-newspaper me-1"></i>Read on Kotaku
                  </a>
                </p>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body">
                <h5 class="mb-3">Project Tags</h5>
                <div class="d-flex flex-wrap gap-2">
                  <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="web3" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('web3') : null">Web3</button>
                  <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="modeling" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('modeling') : null">3D Modeling</button>
                  <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="martiangames" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('martiangames') : null">Martian Games</button>
                  <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="indie" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('indie') : null">Indie</button>
                  <button type="button" class="badge bg-secondary me-1 tag-badge" data-tag-slug="gamedev" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('gamedev') : null">Game Dev</button>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

    <!-- Bootstrap 5.3.8 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
            crossorigin="anonymous"></script>

    <!-- Custom Scripts -->
    <script src="<?= RES_ROOT ?>/js/tag-filter-api<?= $assetSuffix ?? '' ?>.js"></script>
    <script src="<?= RES_ROOT ?>/js/youtube-grid<?= $assetSuffix ?? '' ?>.js"></script>
    <script src="<?= RES_ROOT ?>/js/tag-system<?= $assetSuffix ?? '' ?>.js"></script>
    
    <script>
      // Initialize tag filter API
      if (window.tagFilter && typeof window.tagFilter.init === 'function') {
        window.tagFilter.init();
      }
      
      document.addEventListener('DOMContentLoaded', function(){
        // Render Botborgs playlist using multi-video layout (Format 2)
        function loadBotborgsVideos() {
          try {
            const playlistId = 'PL9QBjNDhgNwQYrXaiRwC0RROYmkppbssY';
            
            if (window.YouTubeGrid && typeof window.YouTubeGrid.renderPlaylist === 'function') {
              console.log('🤖 Botborgs: Loading videos in multi-video layout...');
              
              // Render with multi-video layout (show 5 videos in responsive grid)
              window.YouTubeGrid.renderPlaylist({
                container_id: 'botborgs-playlist',
                playlist_id: playlistId,
                layout: 'multi-video',
                videos_per_playlist: 5,
                columns: { xs: 1, sm: 2, md: 3, lg: 5 }, // 5-column grid on desktop
                aspect_ratio: '16:9',
                show_playlist_title: false,
                enable_hover_effects: true,
                lazy_load: true
              })
              .then(() => console.log('✅ Botborgs: 5 videos rendered successfully'))
              .catch(err => console.error('❌ Botborgs render error:', err));
            } else {
              console.warn('⚠️ YouTubeGrid not available, retrying in 100ms...');
              setTimeout(loadBotborgsVideos, 100);
            }
          } catch (e) {
            console.error('❌ Botborgs: Failed to render playlist', e);
          }
        }
        
        loadBotborgsVideos();
      });
    </script>
  </body>
</html>
