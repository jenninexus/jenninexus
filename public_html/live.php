<?php
$activePage = 'live';
$pageTitle = 'Live Streams | JenniNexus';
$pageDescription = 'Live Streams & VODs - Twitch highlights, stream replays, and live streaming content from JenniNexus';
$pageKeywords = 'live streaming, twitch, vods, stream highlights, gaming streams, jenniplaysgames';
$customCSS = ['/resources/css/live-theme.min.css'];
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <?php include __DIR__ . '/includes/head.php'; ?>
  <body>
    
    <?php include __DIR__ . '/includes/header.php'; ?>

    <!-- Mobile offcanvas removed: using shared offcanvas from includes/header.php -->

    <!-- Hero Section -->
    <div class="live-hero bg-dark text-white py-5">
      <div class="container py-5" >
        <div class="row align-items-center">
          <div class="col-lg-8 mx-auto text-center">
            <div class="mb-4">
              <i class="fa-solid fa-tower-broadcast fa-fade display-1" style="--fa-animation-duration: 3s; color: #ffffff; filter: drop-shadow(0 0 20px rgba(145, 70, 255, 0.8));"></i>
            </div>
            <h1 class="display-3 fw-bold mb-3">Live Streams & VODs</h1>
            <p class="lead mb-4">Watch live streams, highlights, Twitch VODs, and exclusive streaming content</p>
            
            <!-- Notification Info -->
            <div class="mb-4">
              <p class="text-white-50">
                <i class="fa-solid fa-bell fa-shake me-2" style="--fa-animation-iteration-count: 3;"></i>Follow to get Live Notifications
              </p>
            </div>
            
            <!-- Social Streaming Links (kept minimal) -->
            <div class="d-flex gap-3 justify-content-center flex-wrap">
              <a href="https://twitch.tv/jenninexus" target="_blank" class="btn btn-lg" style="background: linear-gradient(135deg, #9146ff, #772ce8); border: 2px solid #9146ff; color: white;">
                <i class="fa-brands fa-twitch me-2"></i>Follow on Twitch
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

  <!-- Main Content -->
  <div class="container my-5">
      
      <!-- Tag Filter Section -->
      <section class="mb-5">
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <div class="text-center mb-3">
              <h5 class="mb-2">Filter Live Content</h5>
              <p class="small text-muted mb-3">Click tags to filter streams and VODs</p>
            </div>
            
            <!-- Category Tags -->
            <div class="mb-3">
              <div class="d-flex flex-wrap justify-content-center gap-2">
                <button class="badge bg-purple bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag-slug="live" onclick="window.tagFilter?.toggle('live')">
                  <i class="fa-solid fa-tower-broadcast me-1"></i>Live Streams
                </button>
                <button class="badge bg-primary bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag-slug="twitch" onclick="window.tagFilter?.toggle('twitch')">
                  <i class="fa-brands fa-twitch me-1"></i>Twitch
                </button>
                <button class="badge bg-danger bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag-slug="gaming" onclick="window.tagFilter?.toggle('gaming')">
                  <i class="fa-solid fa-gamepad me-1"></i>Gaming
                </button>
                <button class="badge bg-success bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag-slug="gamedev" onclick="window.tagFilter?.toggle('gamedev')">
                  <i class="fa-solid fa-code me-1"></i>Game Dev
                </button>
                <button class="badge bg-info bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag-slug="creative" onclick="window.tagFilter?.toggle('creative')">
                  <i class="fa-solid fa-palette me-1"></i>Creative
                </button>
              </div>
            </div>
            
            <!-- Advanced Filter Button -->
            <div class="text-center">
              <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#tagFilterOffcanvas">
                <i class="fa-solid fa-filter me-2"></i>Advanced Tag Filters
              </button>
            </div>
          </div>
        </div>
      </section>
      
      <!-- Live Status Indicator (Hidden until live) -->
      <div id="live-status-indicator" class="d-none"></div>
      
      <!-- Live Twitch Player & Featured VOD (side-by-side, equal width) -->
      <section class="mb-5">
        <div class="d-flex align-items-center mb-4">
          <i class="fa-solid fa-broadcast-tower text-primary fs-2 me-3" style="color: #9146ff !important;"></i>
          <div>
            <h2 class="mb-1">Live & Featured VOD</h2>
            <p class="text-muted mb-0">Watch the live Twitch stream and featured video on demand</p>
          </div>
        </div>

        <div class="row g-4">
          <!-- Live Twitch Player -->
          <div class="col-lg-6">
            <div class="card glass-card border-0 shadow-lg h-100 overflow-hidden">
              <div class="card-body p-0">
                <div id="twitch-embed" class="ratio ratio-16x9"></div>
              </div>
              <div class="card-footer bg-dark-subtle border-0 text-center py-2">
                <span class="badge bg-primary">
                  <i class="fa-solid fa-circle-dot me-1"></i>Live Player
                </span>
              </div>
            </div>
          </div>

          <!-- Featured VOD -->
          <div class="col-lg-6">
            <div class="card glass-card border-0 shadow-lg h-100 overflow-hidden">
              <div class="card-body p-0">
                <div id="twitch-vod-container" class="ratio ratio-16x9">
                  <iframe src="https://player.twitch.tv/?video=510819161&parent=jenninexus.com&parent=localhost" frameborder="0" allowfullscreen="true" scrolling="no" loading="lazy"></iframe>
                </div>
              </div>
              <div class="card-footer bg-dark-subtle border-0">
                <div class="d-flex justify-content-between align-items-center">
                  <span class="badge bg-secondary">Featured VOD</span>
                  <a href="https://www.twitch.tv/videos/510819161" target="_blank" class="btn btn-sm btn-outline-light">
                    <i class="fa-solid fa-external-link-alt me-1"></i>Open on Twitch
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      
      <!-- Twitch Highlights Grid -->
      <section class="mb-5">
        <div class="d-flex align-items-center mb-4">
          <div class="d-flex align-items-center">
            <i class="fa-solid fa-film text-warning fs-2 me-3"></i>
            <div>
              <h2 class="mb-1">Twitch Highlights</h2>
              <p class="text-muted mb-0">Best moments from past streams</p>
            </div>
          </div>
        </div>
        
        <div id="live-playlists-grid" class="row g-4" data-tags="live,twitch,vod">
          <div class="col-12 text-center py-5">
            <div class="spinner-border" role="status" style="color: #9146ff;">
              <span class="visually-hidden">Loading highlights...</span>
            </div>
          </div>
        </div>
      </section>

      <!-- Follow my Live Streams CTA -->
      <section class="mb-5">
        <div class="card border-0 shadow-lg live-hero">
          <div class="card-body p-4 p-md-5">
            <div class="row align-items-center">
              <div class="col-md-8">
                <h2 class="mb-3 text-white">
                  <i class="fa-brands fa-twitch me-2"></i>Follow my Live Streams
                </h2>
                <p class="lead text-white mb-4" style="opacity: 0.9;">
                  Catch live streams, behind-the-scenes, and creative sessions. Follow to get notifications or subscribe for extra perks.
                </p>
                <div class="d-flex gap-3 flex-wrap align-items-center text-white" style="opacity: 0.85;">
                  <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-bell fa-shake" style="--fa-animation-iteration-count: 3;"></i>
                    <span>Get notified when I go live</span>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-gamepad"></i>
                    <span>Interactive gameplay & Q&A</span>
                  </div>
                </div>
              </div>
              <div class="col-md-4 text-center mt-4 mt-md-0">
                <a href="https://twitch.tv/jenninexus" target="_blank" class="btn btn-light btn-lg w-100 mb-3">
                  <i class="fa-brands fa-twitch me-2"></i>Follow on Twitch
                </a>
                <a href="https://www.twitch.tv/subs/jenninexus" target="_blank" class="btn btn-outline-light btn-lg w-100 mb-3">
                  <i class="fa-solid fa-gift me-2"></i>Subscribe on Twitch
                </a>
                <a href="https://discord.gg/KYPh7Cp" target="_blank" class="btn btn-outline-light btn-lg w-100">
                  <i class="fa-brands fa-discord me-2"></i>Join Discord
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Gaming Channel CTA -->
      <section class="mb-5">
        <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #FF0000, #CC0000);">
          <div class="card-body p-4 p-md-5">
            <div class="row align-items-center">
              <div class="col-md-8">
                <h2 class="mb-3 text-white">
                  <i class="fa-brands fa-youtube me-2"></i>Gaming Channel: Jenni Plays Games
                </h2>
                <p class="lead text-white mb-4" style="opacity: 0.9;">
                  Watch full gameplay walkthroughs, indie game reviews, and horror gaming content on my dedicated gaming channel.
                </p>
                <div class="d-flex gap-3 flex-wrap align-items-center text-white" style="opacity: 0.85;">
                  <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-gamepad"></i>
                    <span>Horror & Indie Games</span>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-video"></i>
                    <span>Full Playthroughs</span>
                  </div>
                </div>
              </div>
              <div class="col-md-4 text-center mt-4 mt-md-0">
                <a href="https://www.youtube.com/@jenniplaysgames?sub_confirmation=1" target="_blank" class="btn btn-light btn-lg w-100 mb-3">
                  <i class="fa-brands fa-youtube me-2"></i>Subscribe on YouTube
                </a>
                <a href="/gaming.php" class="btn btn-outline-light btn-lg w-100">
                  <i class="fa-solid fa-arrow-right me-2"></i>View Gaming Content
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

    </div>

  <!-- Tag Filter Offcanvas -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="tagFilterOffcanvas" aria-labelledby="tagFilterOffcanvasLabel">
    <div class="offcanvas-header">
      <h5 id="tagFilterOffcanvasLabel">Filter by Tags</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="mb-3 jn-show-all-tags">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="jnShowAllTagsToggle">
          <label class="form-check-label small text-muted" for="jnShowAllTagsToggle">Show all tags</label>
        </div>
      </div>

      <h6 class="mb-3">Category Tags</h6>
      <div id="categoryTagsList" class="d-flex flex-wrap gap-2 mb-3"></div>
      
      <h6 class="mb-3">Content Type Tags</h6>
      <div id="contentTagsList" class="d-flex flex-wrap gap-2 mb-3"></div>
      
      <h6 class="mb-3">Platform Tags</h6>
      <div id="platformTagsList" class="d-flex flex-wrap gap-2 mb-3"></div>
      
      <hr>
      <div class="d-grid">
        <button id="applyFilters" class="btn btn-primary" type="button">Apply Filters</button>
        <button id="clearFilters" class="btn btn-outline-secondary mt-2" type="button">Clear</button>
      </div>
    </div>
  </div>

      <?php include 'includes/footer.php'; ?>

    <!-- Page-specific scripts (Twitch embed, youtube-grid, live-status) -->
    <script src="https://embed.twitch.tv/embed/v1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
    <script src="<?= RES_ROOT ?>/js/youtube-grid<?= $assetSuffix ?? '' ?>.js"></script>
    <script src="<?= RES_ROOT ?>/js/tag-system<?= $assetSuffix ?? '' ?>.js"></script>
    <script src="<?= RES_ROOT ?>/js/live-status<?= $assetSuffix ?? '' ?>.js"></script>
    <script>
      // Initialize tag filtering system
      if (window.tagFilter && typeof window.tagFilter.init === 'function') {
        window.tagFilter.init({
          seedFromUrl: true,
          persistUrl: true
        });
        
        window.tagFilter.onChange(function(active) {
          console.log('Active live tags:', active);
          if (typeof window.tagFilter.syncToDom === 'function') {
            window.tagFilter.syncToDom();
          }
        });
      }
      
      // Initialize Twitch Embed Player
      new Twitch.Embed("twitch-embed", {
        width: "100%",
        height: "100%",
        channel: "jenninexus",
        layout: "video",
        autoplay: false,
        muted: false,
        parent: ["jenninexus.com", "localhost"]
      });

      // Load YouTube playlists using YouTubeGrid
      document.addEventListener('DOMContentLoaded', () => {
        if (window.YouTubeGrid && typeof window.YouTubeGrid.loadPageConfig === 'function') {
          try {
            window.YouTubeGrid.loadPageConfig('live');
            console.log('✅ Live page: Loading playlists from live.yaml');
          } catch(e) {
            console.error('❌ Live page: Failed to load config', e);
          }
        }
      });
    </script>
  </body>
</html>
