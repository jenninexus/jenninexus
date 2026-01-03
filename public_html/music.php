<?php
$activePage = 'music';
$pageTitle = 'Music & Audio - JenniNexus';
$pageDescription = 'Explore curated playlists, DJ tutorials, FL Studio production tips, and audio content crafted for developers, gamers, and creative minds.';
$pageKeywords = 'game development, music production, DIY crafts, creative content';
$customCSS = [RES_ROOT . '/css/media' . ($assetSuffix ?? '') . '.css'];
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<?php include __DIR__ . '/includes/head.php'; ?>
<body>

  <?php include __DIR__ . '/includes/header.php'; ?>

  <!-- Hero Section -->
  <section class="hero-section py-5 bg-gradient">
    <div class="container" >
      <div class="row align-items-center">
        <div class="col-lg-8">
          <div class="glass-panel p-5 rounded-4 shadow-lg">
            <h1 class="display-4 fw-bold mb-3 hero-title">
              <i class="bi bi-music-note-beamed text-primary me-3"></i>Music & Audio
            </h1>
            <p class="lead mb-4 hero-title">
              Explore curated playlists, DJ tutorials, original compositions, and audio content crafted for developers, gamers, and creative minds.
            </p>
            <div class="d-flex flex-wrap gap-3 hero-title">
              <a href="https://open.spotify.com/user/1230189762?si=0df0970da002471d" target="_blank" class="btn btn-primary btn-lg">
                <i class="bi bi-spotify me-2"></i>Listen on Spotify
              </a>
              <a href="#playlists" class="btn btn-outline-primary btn-lg">
                <i class="bi bi-collection-play me-2"></i>View Playlists
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-4 text-center mt-4 mt-lg-0">
          <div class="display-1">
            <i class="bi bi-disc-fill text-primary"></i>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Spotify Playlists -->
  <section class="py-5 bg-dark bg-opacity-10">
    <div class="container">
      <h2 class="text-center mb-5">
        <i class="bi bi-spotify text-success me-2"></i>Spotify Playlists
      </h2>
      
      <div class="row g-4">
        <div class="col-md-6 col-lg-4">
          <div class="glass-card p-2 rounded-4">
            <iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/playlist/7MVFjwdhr4yDCWuedf22gb?utm_source=generator" width="100%" height="152" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="glass-card p-2 rounded-4">
            <iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/playlist/4xEyDrYbiX5Yd7h1aLIBGI?utm_source=generator" width="100%" height="152" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="glass-card p-2 rounded-4">
            <iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/playlist/6zpO7OMcfm71lMgfauAB7L?utm_source=generator" width="100%" height="152" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="glass-card p-2 rounded-4">
            <iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/playlist/5gupdTSZP295dQWpsM7p6Y?utm_source=generator" width="100%" height="152" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
          </div>
        </div>
        <div class="col-md-6 col-lg-4">
          <div class="glass-card p-2 rounded-4">
            <iframe data-testid="embed-iframe" style="border-radius:12px" src="https://open.spotify.com/embed/playlist/65NkI4wnbsZMOIgnIxwuDO?utm_source=generator" width="100%" height="152" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Genre Tags -->
  <section class="py-4">
    <div class="container">
      <div class="d-flex flex-wrap gap-2 justify-content-center">
        <!-- Note: These are decorative genre badges, not functional tag filters -->
        <!-- Music category tags don't exist in tags.json yet -->
        <span class="badge rounded-pill bg-primary bg-opacity-75 border border-primary" style="cursor: default; user-select: none;">
          <i class="bi bi-music-note-beamed me-1"></i>Electronic
        </span>
        <span class="badge rounded-pill bg-secondary bg-opacity-75 border border-secondary" style="cursor: default; user-select: none;">
          <i class="bi bi-vinyl me-1"></i>Ambient
        </span>
        <span class="badge rounded-pill bg-success bg-opacity-75 border border-success" style="cursor: default; user-select: none;">
          <i class="bi bi-disc me-1"></i>Synthwave
        </span>
        <span class="badge rounded-pill bg-info bg-opacity-75 border border-info" style="cursor: default; user-select: none;">
          <i class="bi bi-music-note me-1"></i>Indie
        </span>
        <span class="badge rounded-pill bg-warning bg-opacity-75 border border-warning text-dark" style="cursor: default; user-select: none;">
          <i class="bi bi-controller me-1"></i>Game Music
        </span>
        <span class="badge rounded-pill bg-danger bg-opacity-75 border border-danger" style="cursor: default; user-select: none;">
          <i class="bi bi-headphones me-1"></i>Lo-fi
        </span>
        <span class="badge rounded-pill bg-primary bg-opacity-75 border border-primary" style="cursor: default; user-select: none;">
          <i class="bi bi-stars me-1"></i>Experimental
        </span>
        <span class="badge rounded-pill bg-secondary bg-opacity-75 border border-secondary" style="cursor: default; user-select: none;">
          <i class="bi bi-cloud-haze me-1"></i>Chillout
        </span>
      </div>
    </div>
  </section>

  <!-- YouTube Music Playlists -->
  <section id="playlists" class="py-5">
    <div class="container">
      <h2 class="text-center mb-5">
        <i class="bi bi-collection-play me-2"></i>YouTube Music Playlists
      </h2>
      
      <!-- Dynamic containers for YouTubeGrid -->
      <div class="mb-5">
        <h3 class="mb-4"><i class="bi bi-music-note-beamed me-2 text-primary"></i>Music Production</h3>
        <div id="musicPlaylistsContainer"></div>
      </div>
      
      <div class="mb-5">
        <h3 class="mb-4"><i class="bi bi-disc-fill me-2 text-primary"></i>DJ Sets & Performances</h3>
        <div id="performances_sectionContainer"></div>
      </div>
      
      <div class="mb-5">
        <h3 class="mb-4"><i class="bi bi-vinyl me-2 text-primary"></i>Music Culture</h3>
        <div id="music_culture_sectionContainer"></div>
      </div>
    </div>
  </section>

  <!-- Music Platforms -->
  <section class="py-5 bg-dark bg-opacity-25">
    <div class="container">
      <h2 class="text-center mb-5">
        <i class="bi bi-headphones me-2"></i>Listen on Your Favorite Platform
      </h2>
      
      <div class="row g-4">
        <!-- Spotify -->
        <div class="col-md-4">
          <div class="card h-100 text-center content-item glass-card" data-category="music" data-tags="spotify,music,platform">
            <div class="card-body p-4">
              <div class="display-4 text-success mb-3">
                <i class="bi bi-spotify"></i>
              </div>
              <h5 class="card-title fw-bold">Spotify</h5>
              <p class="text-muted">Curated playlists and mixes</p>
              <a href="https://open.spotify.com/user/1230189762?si=0df0970da002471d" target="_blank" class="btn btn-success w-100 mt-3">
                <i class="bi bi-spotify me-2"></i>Follow on Spotify
              </a>
            </div>
          </div>
        </div>

        <!-- SoundCloud -->
        <div class="col-md-4">
          <div class="card h-100 text-center content-item glass-card" data-category="music" data-tags="soundcloud,music,platform">
            <div class="card-body p-4">
              <div class="display-4 mb-3" style="color: #FF5500;">
                <i class="bi bi-soundwave"></i>
              </div>
              <h5 class="card-title fw-bold">SoundCloud</h5>
              <p class="text-muted">Original mixes and tracks</p>
              <a href="https://soundcloud.com/jenninexus" target="_blank" class="btn w-100 mt-3" style="background-color: #FF5500; color: white;">
                <i class="bi bi-soundwave me-2"></i>Listen on SoundCloud
              </a>
            </div>
          </div>
        </div>

        <!-- YouTube Music -->
        <div class="col-md-4">
          <div class="card h-100 text-center content-item glass-card" data-category="music" data-tags="youtube-music,music,platform">
            <div class="card-body p-4">
              <div class="display-4 mb-3" style="color: #FF0000;">
                <i class="bi bi-music-note-beamed"></i>
              </div>
              <h5 class="card-title fw-bold">YouTube Music</h5>
              <p class="text-muted">Curated playlists & albums</p>
                <a href="https://music.youtube.com/@jenninexus" target="_blank" class="btn w-100 mt-3" style="background-color: #FF0000; color: white;">
                <i class="bi bi-music-note-beamed me-2"></i>Visit YouTube Music
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Community CTA -->
  <section class="py-5">
    <div class="container">
      <div class="card bg-primary bg-gradient text-white border-0 shadow-lg">
        <div class="card-body text-center py-5">
          <h2 class="mb-3">
            <i class="bi bi-discord me-2"></i>Join the Music Community
          </h2>
          <p class="lead mb-4">
            Connect with other music lovers, share your creations, and get feedback on your work
          </p>
          <a href="https://discord.gg/zwcfR2BpDb" target="_blank" class="btn btn-light btn-lg px-5">
            <i class="bi bi-discord me-2"></i>Join the Music Channel
          </a>
        </div>
      </div>
    </div>
  </section>

  <?php include __DIR__ . '/includes/footer.php'; ?>

  
  <!-- Custom Scripts -->
  <!-- Active Filters container (used by tag-system.js) -->
  <div id="activeFiltersContainer" style="display:none;">
    <div id="activeFilters" class="d-flex gap-2"></div>
  </div>

  <!-- Tag Filter Offcanvas (shared) -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="tagFilterOffcanvas" aria-labelledby="tagFilterOffcanvasLabel">
    <div class="offcanvas-header">
      <h5 id="tagFilterOffcanvasLabel">Filter by Tags</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="mb-3 jn-show-all-tags">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" id="jnShowAllTagsToggle">
          <label class="form-check-label small text-muted" for="jnShowAllTagsToggle">Show all tags</label>
        </div>
      </div>

      <div class="mb-3">
        <h6>Music Tags</h6>
        <div id="musicTagsList" class="d-flex flex-wrap gap-2 mb-3"></div>
      </div>
      <div class="d-flex gap-2 mt-4">
        <button id="applyFilters" class="btn btn-primary" data-bs-dismiss="offcanvas">Apply Filters</button>
        <button id="clearFilters" class="btn btn-outline-secondary">Clear</button>
        <a href="/tags.php" class="btn btn-link ms-auto">View all tags</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
  <script src="<?= RES_ROOT ?>/js/youtube-grid.js"></script>
  <script src="<?= RES_ROOT ?>/js/tag-system.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      if (typeof YouTubeGrid !== 'undefined') {
        YouTubeGrid.loadPageConfig('music');
      }
    });
  </script>
</body>
</html>
