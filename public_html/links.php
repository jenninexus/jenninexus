<?php
$activePage = 'links';
$pageTitle = 'Links - JenniNexus';
$pageDescription = 'JenniNexus - Game Dev, Music, DIY, and Creative Content';
$pageKeywords = 'game development, music production, DIY crafts, creative content';
$customCSS = [RES_ROOT . '/css/link-cards' . ($assetSuffix ?? '') . '.css'];
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
<?php include __DIR__ . '/includes/head.php'; ?>
<body>
  
  <?php include __DIR__ . '/includes/header.php'; ?>

  <!-- Hero -->
  <section class="hero-section py-5" style="background: linear-gradient(135deg, rgba(255, 46, 136, 0.3), rgba(165, 99, 209, 0.3)), var(--background); min-height: 40vh;">
    <div class="container" >
      <div class="row align-items-center" style="min-height: 30vh;">
        <div class="col-lg-8 mx-auto text-center">
          <div class="glass-panel p-5 rounded-4 shadow-lg">
            <i class="fa-solid fa-link fa-spin display-1 mb-4 hero-title" style="--fa-animation-duration: 4s; color: var(--jenni-primary); opacity: 0.85;"></i>
            <h1 class="display-2 mb-4 hero-title"><?php $logoLink = false; include __DIR__ . '/includes/logo.php'; ?> Links</h1>
            <p class="lead hero-title">Connect with me across all platforms</p>
            <div class="mt-4 hero-title">
              <button class="btn btn-outline-primary btn-sm px-4 rounded-pill" data-copy="https://jenninexus.com/links">
                <i class="fa-solid fa-copy me-2"></i>Copy Links Page URL
              </button>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Social Links -->
  <section class="py-5 section-pastel">
    <div class="container">
      
      <!-- Main Platforms -->
      <div class="row g-4 mb-5">
        <div class="col-lg-8 mx-auto">
          <h2 class="text-center mb-4">Main Platforms</h2>
          
          <!-- YouTube Main -->
          <a href="https://www.youtube.com/@jenninexus" target="_blank" class="link-card d-block mb-3 text-decoration-none" data-tags="main,featured">
            <div class="card border-0 shadow-sm">
              <div class="card-body p-4 d-flex align-items-center">
                <div class="link-icon me-4">
                  <i class="fa-brands fa-youtube text-danger fs-1"></i>
                </div>
                <div class="flex-grow-1">
                  <h5 class="mb-1">YouTube - JenniNexus</h5>
                  <p class="text-muted mb-0 small">Game dev, tech, AI, voice acting • 150+ videos</p>
                </div>
                <i class="fa-solid fa-arrow-right fs-4 text-muted"></i>
              </div>
            </div>
          </a>

          <!-- YouTube Gaming -->
          <a href="https://www.youtube.com/@jenniplaysgames" target="_blank" class="link-card d-block mb-3 text-decoration-none" data-tags="youtube,gaming">
            <div class="card border-0 shadow-sm">
              <div class="card-body p-4 d-flex align-items-center">
                <div class="link-icon me-4">
                  <i class="fa-brands fa-youtube text-danger fs-1"></i>
                </div>
                <div class="flex-grow-1">
                  <h5 class="mb-1">YouTube - Jenni Plays Games</h5>
                  <p class="text-muted mb-0 small">Let's Plays & gaming content • 100+ videos</p>
                </div>
                <i class="fa-solid fa-arrow-right fs-4 text-muted"></i>
              </div>
            </div>
          </a>

          <!-- YouTube DIY -->
          <a href="https://www.youtube.com/@diywjenni" target="_blank" class="link-card d-block mb-3 text-decoration-none" data-tags="youtube,diy">
            <div class="card border-0 shadow-sm">
              <div class="card-body p-4 d-flex align-items-center">
                <div class="link-icon me-4">
                  <i class="fa-brands fa-youtube text-danger fs-1"></i>
                </div>
                <div class="flex-grow-1">
                  <h5 class="mb-1">YouTube - DIY w/ Jenni</h5>
                  <p class="text-muted mb-0 small">Fashion, beauty, nail art • 75+ videos</p>
                </div>
                <i class="fa-solid fa-arrow-right fs-4 text-muted"></i>
              </div>
            </div>
          </a>

          <!-- Patreon -->
          <a href="https://patreon.com/jenninexus" target="_blank" class="link-card d-block mb-3 text-decoration-none" data-tags="patreon,community">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #FF424D, #FF5B60);">
              <div class="card-body p-4 d-flex align-items-center text-white">
                <div class="link-icon me-4">
                  <i class="fa-brands fa-patreon fs-1" style="color: #ffffff;"></i>
                </div>
                <div class="flex-grow-1">
                  <h5 class="mb-1 text-white">Patreon</h5>
                  <p class="mb-0 small opacity-75">Support my work • Exclusive content</p>
                </div>
                <i class="fa-solid fa-arrow-right fs-4 opacity-75"></i>
              </div>
            </div>
          </a>

          <!-- Discord Main -->
          <a href="https://discord.gg/KYPh7Cp" target="_blank" class="link-card d-block mb-3 text-decoration-none" data-tags="community,social-media">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #5865F2, #7289DA);">
              <div class="card-body p-4 d-flex align-items-center text-white">
                <div class="link-icon me-4">
                  <i class="fa-brands fa-discord fs-1" style="color: #ffffff;"></i>
                </div>
                <div class="flex-grow-1">
                  <h5 class="mb-1 text-white">Discord - Main Community</h5>
                  <p class="mb-0 small opacity-75">Join the community • Chat & collaborate</p>
                </div>
                <i class="fa-solid fa-arrow-right fs-4 opacity-75"></i>
              </div>
            </div>
          </a>
        </div>
      </div>

      <!-- Professional Links -->
      <div class="row g-4 mb-5">
        <div class="col-lg-8 mx-auto">
          <h2 class="text-center mb-4">Professional</h2>
          
          <div class="row g-3">
            <div class="col-md-4">
              <a href="https://github.com/jenninexus" target="_blank" class="link-card d-block text-decoration-none" data-tags="code,github">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body p-4 text-center">
                    <i class="fa-brands fa-github fs-1 mb-3 d-block" style="color: var(--github-dark, #333333);"></i>
                    <h5>GitHub</h5>
                    <p class="text-muted small mb-0">Open source projects</p>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-4">
              <a href="https://linkedin.com/in/jenninexus" target="_blank" class="link-card d-block text-decoration-none" data-tags="professional,linkedin">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body p-4 text-center">
                    <i class="fa-brands fa-linkedin fs-1 mb-3 d-block" style="color: #0077b5;"></i>
                    <h5>LinkedIn</h5>
                    <p class="text-muted small mb-0">Professional network</p>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-4">
              <a href="https://www.artstation.com/jenninexus" target="_blank" class="link-card d-block text-decoration-none" data-tags="professional,portfolio">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body p-4 text-center">
                    <i class="fa-brands fa-artstation fs-1 mb-3 d-block" style="color: #13aff0;"></i>
                    <h5>ArtStation</h5>
                    <p class="text-muted small mb-0">3D art & portfolio</p>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Social Media -->
      <div class="row g-4 mb-5">
        <div class="col-lg-8 mx-auto">
          <h2 class="text-center mb-4">Social Media</h2>
          
          <div class="row g-3">
            <div class="col-md-4">
              <a href="https://twitch.tv/jenninexus" target="_blank" class="link-card d-block text-decoration-none" data-tags="twitch,live">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body p-4 text-center">
                    <i class="fa-brands fa-twitch fs-1 mb-3 d-block" style="color: #9146ff;"></i>
                    <h6>Twitch</h6>
                    <p class="text-muted small mb-0">Live streams</p>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-4">
              <a href="https://twitter.com/jenninexus" target="_blank" class="link-card d-block text-decoration-none" data-tags="twitter,social">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body p-4 text-center">
                    <i class="fa-brands fa-x-twitter fs-1 mb-3 d-block" style="color: #000000;"></i>
                    <h6>Twitter/X</h6>
                    <p class="text-muted small mb-0">Updates</p>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-4">
              <a href="https://instagram.com/jenninexus" target="_blank" class="link-card d-block text-decoration-none" data-tags="instagram,photos">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body p-4 text-center">
                    <i class="fa-brands fa-instagram fs-1 mb-3 d-block" style="color: #e4405f;"></i>
                    <h6>Instagram</h6>
                    <p class="text-muted small mb-0">Photos</p>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-4">
              <a href="https://facebook.com/jenninexus" target="_blank" class="link-card d-block text-decoration-none" data-tags="facebook,community">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body p-4 text-center">
                    <i class="fa-brands fa-facebook fs-1 mb-3 d-block" style="color: #1877f2;"></i>
                    <h6>Facebook</h6>
                    <p class="text-muted small mb-0">Community</p>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-4">
              <a href="https://tiktok.com/@jenninexus" target="_blank" class="link-card d-block text-decoration-none" data-tags="tiktok,shorts">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body p-4 text-center">
                    <i class="fa-brands fa-tiktok fs-1 mb-3 d-block" style="color: var(--tiktok-black, #000000);"></i>
                    <h6>TikTok</h6>
                    <p class="text-muted small mb-0">Short videos</p>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-4">
              <a href="https://open.spotify.com/user/1230189762?si=88ab5e59959a4368" target="_blank" class="link-card d-block text-decoration-none" data-tags="spotify,music">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body p-4 text-center">
                    <i class="fa-brands fa-spotify fs-1 mb-3 d-block" style="color: var(--spotify-green, #1DB954);"></i>
                    <h6>Spotify</h6>
                    <p class="text-muted small mb-0">Playlists</p>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Cross-Linking Buttons -->
      <div class="row g-4 mb-5">
        <div class="col-lg-8 mx-auto">
          <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="/media" class="btn btn-outline-primary btn-lg px-4 py-3 rounded-3 d-inline-flex align-items-center">
              <i class="fa-solid fa-chart-line me-2"></i>
              <span>View Stats & Media Kit</span>
            </a>
            <a href="/sitemap" class="btn btn-outline-secondary btn-lg px-4 py-3 rounded-3 d-inline-flex align-items-center">
              <i class="fa-solid fa-sitemap me-2"></i>
              <span>Browse Full Site</span>
            </a>
          </div>
        </div>
      </div>

      <!-- Discord Channels -->
      <div class="row g-4 mb-5">
        <div class="col-lg-8 mx-auto">
          <h2 class="text-center mb-4">Discord Channels</h2>
          
          <div class="row g-3">
            <div class="col-md-4">
              <a href="https://discord.gg/dc86JqBntj" target="_blank" class="link-card d-block text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body p-4 text-center">
                    <i class="fa-solid fa-gamepad text-success fs-1 mb-3 d-block"></i>
                    <h6>Gaming Channel</h6>
                    <p class="text-muted small mb-0">Game dev & let's plays</p>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-4">
              <a href="https://discord.gg/pKSyR4A9Tb" target="_blank" class="link-card d-block text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body p-4 text-center">
                    <i class="fa-solid fa-scissors text-danger fs-1 mb-3 d-block"></i>
                    <h6>DIY Channel</h6>
                    <p class="text-muted small mb-0">Beauty & crafts</p>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-4">
              <a href="https://discord.gg/zwcfR2BpDb" target="_blank" class="link-card d-block text-decoration-none">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body p-4 text-center">
                    <i class="fa-solid fa-music text-warning fs-1 mb-3 d-block"></i>
                    <h6>Music Channel</h6>
                    <p class="text-muted small mb-0">Music production</p>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>


    </div>
  </section>

  <?php include 'includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="<?= RES_ROOT ?>/js/ui-effects.js"></script>
</body>
</html>

