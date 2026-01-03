<?php
$activePage = 'media';
$pageTitle = 'Media Kit & Social Stats | JenniNexus';
$pageDescription = 'Media kit, social stats, and assets for press and collaborators.';
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<?php include __DIR__ . '/includes/head.php'; ?>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section py-5 reveal-on-scroll" style="background: linear-gradient(135deg, var(--jenni-primary), var(--jenni-secondary)); min-height: 40vh;">
  <div class="container" >
    <div class="row align-items-center" style="min-height: 30vh;">
      <div class="col-lg-8 mx-auto text-center text-white">
        <div class="glass-panel p-5 rounded-4 shadow-lg reveal-up" data-parallax-speed="0.05">
          <i class="fa-solid fa-newspaper fa-spin display-1 mb-4 hero-title" style="--fa-animation-duration: 4s;" data-parallax-speed="0.08"></i>
          <h1 class="display-2 mb-4 hero-title" data-parallax-speed="0.12">Media Kit</h1>
          <p class="lead hero-title" data-parallax-speed="0.10">Press resources, social stats, and brand assets</p>
          <div class="mt-4">
            <a href="<?= RES_ROOT ?>/media/media-kit.zip" class="btn btn-lg btn-light">
              <i class="fa-solid fa-download me-2"></i>Media Kit
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5 reveal-on-scroll">
  <div class="container">

    <!-- Social Stats -->
    <div class="row mb-5">
      <div class="col-lg-10 mx-auto">
        <h2 class="text-center mb-4 reveal-up" data-parallax-speed="0.06">
          <i class="fa-solid fa-chart-line me-2"></i>Social Media Stats
        </h2>
        <div id="social-stats-container" class="row g-4 parallax-layer reveal-up" data-parallax-speed="0.04">
          <div class="col-12 text-center py-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Brand Assets & Contact -->
    <div class="row g-4 reveal-on-scroll">
      <div class="col-lg-10 mx-auto">
        <div class="row g-4 parallax-layer" data-parallax-speed="0.05">
          <div class="col-md-6 reveal-left">
            <div class="card border-0 shadow-sm h-100 hover-lift" data-tilt>
              <div class="card-body p-4">
                <h3 class="h5 mb-4">
                  <i class="fa-solid fa-palette me-2"></i>Brand Assets
                </h3>
                <ul class="list-unstyled">
                  <li class="mb-3">
                    <a href="<?= RES_ROOT ?>/media/jenninexus_logo.png" class="text-decoration-none" download>
                      <i class="fa-solid fa-file-image text-primary me-2"></i>Logo (PNG)
                    </a>
                  </li>
                  <li class="mb-3">
                    <a href="<?= RES_ROOT ?>/media/jenninexus.png" class="text-decoration-none" download>
                      <i class="fa-solid fa-user-circle text-primary me-2"></i>Headshot (PNG)
                    </a>
                  </li>
                  <li class="mb-3">
                    <a href="<?= RES_ROOT ?>/media/media-kit.zip" class="text-decoration-none" download>
                      <i class="fa-solid fa-file-zipper text-danger me-2"></i>Media Kit (ZIP)
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          
          <!-- Contact Card -->
          <div class="col-md-6 reveal-right">
            <div class="card border-0 shadow-sm h-100 hover-lift" data-tilt>
              <div class="card-body p-4">
                <h3 class="h5 mb-4">
                  <i class="fa-solid fa-envelope me-2"></i>Contact
                </h3>
                <p>For press inquiries, collaborations, or speaking engagements:</p>
                <div class="d-flex gap-2">
                  <a href="mailto:jenninexus@gmail.com" class="btn btn-outline-primary">
                    <i class="fa-solid fa-paper-plane me-2"></i>Email Me
                  </a>
                  <button class="btn btn-outline-secondary" data-copy="jenninexus@gmail.com" title="Copy Email" data-copy-success-icon="fa-check">
                    <i class="fa-solid fa-copy"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- Cross-Linking Buttons -->
      <div class="row mt-5 reveal-up">
        <div class="col-lg-8 mx-auto">
          <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="/links" class="btn btn-outline-primary btn-lg px-4 py-3 rounded-3 d-inline-flex align-items-center">
              <i class="fa-solid fa-link me-2"></i>
              <span>Follow Me</span>
            </a>
            <a href="/sitemap" class="btn btn-outline-secondary btn-lg px-4 py-3 rounded-3 d-inline-flex align-items-center">
              <i class="fa-solid fa-sitemap me-2"></i>
              <span>Browse Content</span>
            </a>
          </div>
        </div>
      </div>

    </div>

  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>

<script>
// Load social-stats.json and display awesome stats
document.addEventListener('DOMContentLoaded', () => {
  fetch('<?= RES_ROOT ?>/playlists/social-stats.json')
    .then(r => r.ok ? r.json() : Promise.reject('Not Found'))
    .then(data => {
      const container = document.getElementById('social-stats-container');
      if (!container) return;
      
      // Clear loading spinner
      container.innerHTML = '';
      
      // Build stats cards
      const stats = [];
      
      // YouTube channels (individual)
      if (data.youtube?.channels) {
        Object.values(data.youtube.channels).forEach(channel => {
          stats.push({
            icon: 'fa-brands fa-youtube',
            color: 'danger',
            countRaw: channel.subscribers || 0,
            count: (channel.subscribers || 0).toLocaleString(),
            label: 'YouTube',
            subtext: channel.description || '',
            url: channel.url
          });
        });
      }
      
      // Twitch
      if (data.twitch) {
        stats.push({
          icon: 'fa-brands fa-twitch',
          color: 'primary',
          countRaw: data.twitch.followers || 0,
          count: (data.twitch.followers || 0).toLocaleString(),
          label: 'Twitch Followers',
          subtext: 'Live streaming',
          url: data.twitch.url
        });
      }
      
      // Instagram accounts (individual)
      if (data.instagram?.accounts) {
        Object.entries(data.instagram.accounts).forEach(([key, account]) => {
          stats.push({
            icon: 'fa-brands fa-instagram',
            color: 'danger',
            countRaw: account.followers || 0,
            count: (account.followers || 0).toLocaleString(),
            label: 'Instagram',
            subtext: `@${key}`,
            url: account.url
          });
        });
      }
      
      // Facebook accounts (individual)
      if (data.facebook?.accounts) {
        Object.entries(data.facebook.accounts).forEach(([key, account]) => {
          const accountName = key === 'profile' ? 'JenniNexus' : 'MostlyJenniNexus';
          stats.push({
            icon: 'fa-brands fa-facebook',
            color: 'primary',
            countRaw: account.followers || 0,
            count: (account.followers || 0).toLocaleString(),
            label: 'Facebook',
            subtext: accountName,
            url: account.url
          });
        });
      }
      
      // Twitter/X
      if (data.twitter) {
        stats.push({
          icon: 'fa-brands fa-x-twitter',
          color: 'body',
          countRaw: data.twitter.followers || 0,
          count: (data.twitter.followers || 0).toLocaleString(),
          label: 'X (Twitter)',
          subtext: '@JenniNexus',
          url: data.twitter.url
        });
      }
      
      // TikTok accounts (individual)
      if (data.tiktok?.accounts) {
        Object.entries(data.tiktok.accounts).forEach(([key, account]) => {
          stats.push({
            icon: 'fa-brands fa-tiktok',
            color: 'body',
            countRaw: account.followers || 0,
            count: (account.followers || 0).toLocaleString(),
            label: 'TikTok',
            subtext: `@${key}`,
            url: account.url
          });
        });
      }
      
      // Discord
      if (data.discord) {
        stats.push({
          icon: 'fa-brands fa-discord',
          color: 'primary',
          count: data.discord.members.toLocaleString(),
          label: 'Discord Members',
          subtext: 'Community',
          url: data.discord.url
        });
      }
      
      // GitHub
      if (data.github) {
        stats.push({
          icon: 'fa-brands fa-github',
          color: 'body',
          count: data.github.followers ? data.github.followers.toLocaleString() : '',
          label: 'GitHub',
          subtext: 'Open source',
          url: data.github.url,
          hideCount: !data.github.followers
        });
      }
      
      // Add total reach card (First)
      const totalReach = (data.youtube?.total_subscribers || 0) + 
                        (data.twitch?.followers || 0) + 
                        (data.instagram?.total_followers || 0) + 
                        (data.facebook?.total_followers || 0) + 
                        (data.twitter?.followers || 0) + 
                        (data.tiktok?.total_followers || 0);
      
      const totalCol = document.createElement('div');
      totalCol.className = 'col-12 mb-4';
      totalCol.innerHTML = `
        <div class="stat-card text-center p-5 hover-lift" data-tilt>
          <i class="fa-solid fa-users fs-1 mb-3 text-primary"></i>
          <div class="stat-number display-3 mb-2" data-target="${totalReach}">0</div>
          <div class="stat-label h4 text-uppercase tracking-wider">Total Combined Reach</div>
          <p class="opacity-75 mb-0">Across all platforms</p>
        </div>
      `;
      container.appendChild(totalCol);

      // Render individual stats cards
      stats.forEach(stat => {
        const col = document.createElement('div');
        col.className = 'col-md-6 col-lg-4';
        col.innerHTML = `
          <a href="${stat.url}" target="_blank" class="text-decoration-none">
            <div class="stat-card text-center p-4 h-100 hover-lift" data-tilt>
              <i class="${stat.icon} text-${stat.color} fs-1 mb-3"></i>
              ${stat.hideCount ? '' : `<div class="stat-number h2 mb-1" data-target="${stat.countRaw || (stat.count ? parseInt(stat.count.replace(/,/g,'')) : 0)}">0</div>`}
              <div class="stat-label h5 mb-1">${stat.label}</div>
              <p class="text-muted small mb-0">${stat.subtext}</p>
            </div>
          </a>
        `;
        container.appendChild(col);
      });

      // Trigger UI effects initializers (ui-effects.js will animate these counters)
      if (window.mgInitUiEffects) {
        window.mgInitUiEffects();
      } else {
        // Fallback: populate counts without animation
        document.querySelectorAll('.stat-number').forEach(el => {
          const t = parseInt(el.dataset.target || 0, 10) || 0;
          el.textContent = t.toLocaleString();
        });
      }
      
      // Add additional platforms section (no counts)
      if (data.gamejolt || data.itch || data.sora) {
        const additionalSection = document.createElement('div');
        additionalSection.className = 'col-12 mt-4';
        additionalSection.innerHTML = `
          <h3 class="text-center mb-4">
            <i class="fa-solid fa-link me-2"></i>Additional Platforms
          </h3>
          <div class="row g-3 justify-content-center">
            ${data.gamejolt ? `
              <div class="col-md-4">
                <a href="${data.gamejolt.url}" target="_blank" class="text-decoration-none">
                  <div class="stat-card text-center p-4 h-100 hover-lift" data-tilt>
                    <i class="fa-solid fa-gamepad text-success fs-1 mb-3"></i>
                    <div class="stat-label h5 mb-2">GameJolt</div>
                    <p class="text-muted small mb-0">${data.gamejolt.description}</p>
                  </div>
                </a>
              </div>
            ` : ''}
            ${data.itch ? `
              <div class="col-md-4">
                <a href="${data.itch.url}" target="_blank" class="text-decoration-none">
                  <div class="stat-card text-center p-4 h-100 hover-lift" data-tilt>
                    <i class="fa-solid fa-joystick text-danger fs-1 mb-3"></i>
                    <div class="stat-label h5 mb-2">Itch.io</div>
                    <p class="text-muted small mb-0">${data.itch.description}</p>
                  </div>
                </a>
              </div>
            ` : ''}
            ${data.sora ? `
              <div class="col-md-4">
                <a href="${data.sora.url}" target="_blank" class="text-decoration-none">
                  <div class="stat-card text-center p-4 h-100 hover-lift" data-tilt>
                    <i class="fa-solid fa-wand-magic-sparkles text-info fs-1 mb-3"></i>
                    <div class="stat-label h5 mb-2">Sora by OpenAI</div>
                    <p class="text-muted small mb-0">${data.sora.description}</p>
                  </div>
                </a>
              </div>
            ` : ''}
          </div>
        `;
        container.appendChild(additionalSection);
      }
    })
    .catch(err => {
      console.error('Failed to load social stats:', err);
      const container = document.getElementById('social-stats-container');
      if (container) {
        container.innerHTML = `
          <div class="col-12 text-center text-muted">
            <i class="fa-solid fa-exclamation-triangle fs-1 mb-3"></i>
            <p>Unable to load social stats</p>
          </div>
        `;
      }
    });
});
</script>

</body>
</html>
