<?php
$activePage = 'patreon';
$pageTitle = 'Patreon - JenniNexus';
$pageDescription = 'Support JenniNexus on Patreon and unlock exclusive VIP content, tutorials, and resources.';
$pageKeywords = 'patreon, vip, jenninexus, memberships';
$customCSS = [
  RES_ROOT . '/css/patreon-theme' . ($assetSuffix ?? '') . '.css',
  RES_ROOT . '/css/media' . ($assetSuffix ?? '') . '.css'
];
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<?php include_once 'includes/head.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
  <script src="/resources/js/youtube-grid.js"></script>
<body>
<?php include_once 'includes/header.php'; ?>

  <!-- Hero / Featured -->
  <section class="py-5 patreon-hero text-white">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-7">
          <h1 class="display-4 fw-bold mb-3"><i class="bi bi-heart-fill me-2" style="color: var(--patreon-coral);"></i>Support JenniNexus on Patreon</h1>
          <p class="lead mb-4">Help keep the creative projects alive — get exclusive downloads, VIP playlists, early access, and Discord perks.</p>
          <div class="d-flex gap-2 flex-wrap">
            <a href="https://patreon.com/jenninexus" target="_blank" class="btn btn-patreon-coral btn-lg">
              <i class="bi bi-heart-fill me-2"></i>Become a Patron
            </a>
            <a id="patreonConnect" href="/patreon-auth-start.php" class="btn btn-outline-light btn-lg">
              <i class="bi bi-unlock me-2"></i>Connect (Sign in)
            </a>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="card border-0 shadow-lg patreon-tier-card bg-glass-dark">
            <div class="card-body p-4">
              <h5 class="card-title mb-2 text-white">Why support?</h5>
              <p class="card-text small opacity-75 text-white">Your support funds tutorials, music releases, and free community resources. Patrons get VIP content and backstage access.</p>

              <ul class="list-unstyled mb-3">
                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: var(--patreon-coral);"></i><span class="text-white">VIP Playlists & exclusive videos</span></li>
                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: var(--patreon-coral);"></i><span class="text-white">Downloadable assets & PDFs</span></li>
                <li class="mb-2"><i class="bi bi-check-circle-fill me-2" style="color: var(--patreon-coral);"></i><span class="text-white">VIP Discord channels</span></li>
              </ul>

              <a href="https://patreon.com/jenninexus" target="_blank" class="btn btn-patreon-coral w-100">
                <i class="bi bi-heart-fill me-2"></i>Visit Patreon Page
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Tiers & Highlights -->
  <section class="py-5">
    <div class="container">
      <h2 class="mb-4 text-center">Membership Tiers</h2>
      <div class="row g-4">
        <div id="tiersRow" class="col-12">
          <!-- Tiers will be injected here by client JS. Fallback static content remains in HTML for no-JS clients. -->
          <div id="tiersFallback" class="row g-4">
            <div class="col-md-6 col-lg-4">
              <div class="card h-100 shadow-sm">
                <div class="card-header bg-secondary text-white text-center">
                  <h5 class="mb-0">Supporter</h5>
                  <small>$3 / month</small>
                </div>
                <div class="card-body">
                  <ul class="mb-0">
                    <li>Discord access</li>
                    <li>Patron-only posts</li>
                    <li>Community voting</li>
                  </ul>
                </div>
                <div class="card-footer text-center">
                  <a href="https://patreon.com/jenninexus" target="_blank" class="btn btn-outline-secondary">Join</a>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-4">
              <div class="card h-100 border-primary shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                  <h5 class="mb-0">VIP</h5>
                  <small>$10 / month</small>
                </div>
                <div class="card-body">
                  <ul class="mb-0">
                    <li><strong>VIP playlists</strong></li>
                    <li>Exclusive PDFs & assets</li>
                    <li>Early access to projects</li>
                  </ul>
                </div>
                <div class="card-footer text-center">
                  <a href="https://patreon.com/jenninexus" target="_blank" class="btn btn-primary">Join VIP</a>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-4">
              <div class="card h-100 shadow-sm">
                <div class="card-header bg-warning text-dark text-center">
                  <h5 class="mb-0">Elite</h5>
                  <small>$25 / month</small>
                </div>
                <div class="card-body">
                  <ul class="mb-0">
                    <li>All VIP benefits</li>
                    <li>Monthly 1-on-1 session</li>
                    <li>Custom content requests</li>
                  </ul>
                </div>
                <div class="card-footer text-center">
                  <a href="https://patreon.com/jenninexus" target="_blank" class="btn btn-warning text-dark">Join Elite</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- VIP Content (client-gated) -->
  <section id="vipArea" class="py-5 bg-body-secondary">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <h3 id="vipTitle">VIP Content <span class="badge badge-patreon-vip ms-2 pulse-animation">VIP</span></h3>
          <p id="vipIntro" class="text-muted">This area is reserved for patrons. Sign in to unlock VIP playlists and resources.</p>

          <div id="vipContentWrapper">
            <div id="vipMessage" class="alert alert-info">Checking authentication status…</div>

            <!-- vipGrid is visible to all visitors but cards are blurred for non-authenticated users -->
            <div id="vipGrid" class="row g-3 vip-guest-view" data-category="patreon" data-tags="patreon,vip">
              <div class="col-md-6">
                <div class="card h-100 bg-glass-light">
                  <img src="<?= RES_ROOT ?>/images/patreon-preview-gamedev.jpg" class="card-img-top" alt="Dev preview" loading="lazy" onerror="this.onerror=null;this.src='<?= RES_ROOT ?>/images/placeholder-180.png'">
                  <div class="card-body">
                    <h5 class="card-title text-theme-adaptive">Game Dev Tutorials</h5>
                    <p class="card-text small text-muted">Exclusive tutorial series for patrons.</p>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card h-100 bg-glass-light">
                  <img src="<?= RES_ROOT ?>/images/patreon-preview-assets.jpg" class="card-img-top" alt="Assets" loading="lazy" onerror="this.onerror=null;this.src='<?= RES_ROOT ?>/images/placeholder-180.png'">
                  <div class="card-body">
                    <h5 class="card-title text-theme-adaptive">Asset Packs</h5>
                    <p class="card-text small text-muted">Downloadable assets and templates.</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- VIP Playlists (loaded from patreon.yaml) -->
            <div id="vip-playlists-section" class="mt-4" style="display: none;">
              <h5 class="mb-3"><i class="bi bi-collection-play me-2"></i>VIP Exclusive Playlists</h5>
              <div id="vip-playlists" class="row g-3 vip-guest-view">
                <!-- Skeletons/Playlists injected here -->
                <div class="col-12 text-center py-4">
                  <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading VIP playlists...</span>
                  </div>
                </div>
              </div>
            </div>

            <div id="vipDownloads" class="mt-3">
              <!-- show a small embedded preview for the CC4 PDF (half-width) -->
              <div id="cc4PreviewWrapper" class="d-flex align-items-start gap-3">
                <div style="flex: 1 1 50%; max-width:50%;">
                  <div class="card p-2 shadow-sm">
                    <div class="card-body p-1">
                      <h6 class="card-title mb-2">CC4 Guide (VIP preview)</h6>
                      <div class="ratio ratio-4x3">
                        <iframe id="cc4Preview" src="<?= RES_ROOT ?>/pdfs/jenninexus_cc4_2025.pdf#toolbar=0&navpanes=0&zoom=page-width" title="CC4 Guide Preview"></iframe>
                      </div>
                    </div>
                  </div>
                </div>
                <div style="flex: 1 1 50%; max-width:50%;" class="d-flex flex-column justify-content-center">
                  <a id="cc4PdfLink" href="<?= RES_ROOT ?>/pdfs/jenninexus_cc4_2025.pdf" class="btn btn-outline-primary me-2" download>
                    <i class="bi bi-file-earmark-pdf me-1"></i>Download Sexy 3D Characters (VIP)
                  </a>
                  <p class="small text-muted mt-2">Preview available to all visitors (blurred) and becomes clear after signing in as a patron.</p>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="col-lg-4">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Featured for Patrons</h5>
              <p class="card-text small text-muted">Exclusive behind-the-scenes posts, early releases, and VIP playlists.</p>
              <a href="https://patreon.com/jenninexus" target="_blank" class="btn btn-patreon w-100" style="background:#ff424d;color:#fff;">Become a Patron</a>
              <button id="patreonSignOut" class="btn btn-link w-100 mt-2" style="color:var(--bs-white);">Sign Out (local)</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ / CTA -->
  <section class="py-5">
    <div class="container">
      <h3 class="mb-3">Frequently Asked Questions</h3>
      <div class="accordion" id="patreonFaq">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqOne">How do I access VIP content?</button>
          </h2>
          <div id="faqOne" class="accordion-collapse collapse show" data-bs-parent="#patreonFaq">
            <div class="accordion-body">After becoming a patron, use the "Connect" button on this page to verify your membership. If you prefer you can always visit the Patreon page directly.</div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqTwo">Can I cancel anytime?</button>
          </h2>
          <div id="faqTwo" class="accordion-collapse collapse" data-bs-parent="#patreonFaq">
            <div class="accordion-body">Yes — Patreon billing is managed on Patreon; cancel any time from your account.</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include_once 'includes/footer.php'; ?>

  <!-- Scripts -->
  <script>
    // Compute resource base (uses window.RES_ROOT injected by includes/head.php)
    const RESOURCE_BASE = (typeof window !== 'undefined' && window.RES_ROOT) ? window.RES_ROOT : '/resources';

    // Helper: safe JSON fetch to the patreon posts stub
    async function fetchPatreonPosts() {
      try {
        const res = await fetch(`${RESOURCE_BASE}/api/get-patreon-posts.php`);
        if (!res.ok) throw new Error('Network error');
        return await res.json();
      } catch (err) {
        console.warn('Patreon posts fetch failed:', err);
        return { status: 'no_token', posts: [] };
      }
    }

    // SVG data-URI placeholder (small blurred neutral image)
    const PATREON_PLACEHOLDER_SVG = 'data:image/svg+xml;utf8,' + encodeURIComponent(
      '<svg xmlns="http://www.w3.org/2000/svg" width="600" height="400" viewBox="0 0 600 400"><rect width="100%" height="100%" fill="#2b2f33"/><g fill="#3a3f44" opacity="0.9"><rect x="20" y="20" width="560" height="120" rx="6"/><rect x="20" y="160" width="340" height="14" rx="4"/><rect x="20" y="186" width="260" height="12" rx="4"/></g></svg>'
    );

    // Render simple loading skeletons while posts are fetched
    function renderLoadingSkeleton(count = 2) {
      const grid = document.getElementById('vipGrid');
      if (!grid) return;
      grid.innerHTML = '';
      for (let i = 0; i < count; i++) {
        const col = document.createElement('div');
        col.className = 'col-md-6';
        const card = document.createElement('div');
        card.className = 'card h-100';
        const img = document.createElement('div');
        img.className = 'patreon-skeleton card-img-top skeleton-img';
        const body = document.createElement('div');
        body.className = 'card-body';
        const h5 = document.createElement('h5');
        h5.className = 'card-title placeholder-glow';
        h5.innerHTML = '<span class="placeholder col-6"></span>';
        const ptxt = document.createElement('p');
        ptxt.className = 'card-text small text-muted placeholder-glow';
        ptxt.innerHTML = '<span class="placeholder col-7"></span>';
        body.appendChild(h5);
        body.appendChild(ptxt);
        card.appendChild(img);
        card.appendChild(body);
        // keep skeletons blurred until reveal (no change needed)
        col.appendChild(card);
        grid.appendChild(col);
      }
    }

    // Render posts into the vipGrid; uses preview_image or placeholder
    function renderPatreonPosts(posts) {
      const grid = document.getElementById('vipGrid');
      if (!grid) return;
      grid.innerHTML = ''; // clear existing placeholder cards
      const placeholder = `${RESOURCE_BASE}/images/placeholder-180.png`;

      posts.forEach(p => {
        const col = document.createElement('div');
        col.className = 'col-md-6';

        const card = document.createElement('div');
        card.className = 'card h-100';

        const img = document.createElement('img');
        img.className = 'card-img-top';
        img.loading = 'lazy';
        img.alt = p.title || 'Patreon preview';
        img.src = p.preview_image || placeholder;
        img.onerror = function() { this.onerror=null; this.src = placeholder; };

        const body = document.createElement('div');
        body.className = 'card-body';
        const h5 = document.createElement('h5');
        h5.className = 'card-title';
        h5.textContent = p.title || 'Untitled';
        const ptxt = document.createElement('p');
        ptxt.className = 'card-text small text-muted';
        ptxt.textContent = p.excerpt || '';

        body.appendChild(h5);
        body.appendChild(ptxt);

        card.appendChild(img);
        card.appendChild(body);

        // Only apply the guest blur class when the current visitor is not authenticated.
        // The membership check sets localStorage.patreon_authenticated = 'true' for patrons
        // and revealVIP() will remove blur classes for revealed patrons.
        try {
          const isPatron = localStorage.getItem('patreon_authenticated') === 'true';
          if (!isPatron) {
            card.classList.add('vip-blur');
          }
        } catch (e) {
          // If localStorage isn't available for some reason, default to blurred previews
          card.classList.add('vip-blur');
        }

        col.appendChild(card);
        grid.appendChild(col);
      });
    }

    // Local auth simulation & UI wiring (dev-safe)
    function isLocallyAuthenticated() {
      return localStorage.getItem('patreon_authenticated') === 'true';
    }

    function showVIP() {
      document.getElementById('vipMessage').style.display = 'none';
      document.getElementById('vipGrid').style.display = 'flex';
      document.getElementById('vip-playlists-section').style.display = 'block';
      document.getElementById('vipDownloads').style.display = 'block';
    }

    function hideVIP() {
      // Keep the VIP grid visible but blurred for guests so previews are visible.
      const msg = document.getElementById('vipMessage');
      msg.textContent = 'Preview is available but blurred for non-patrons. Sign in to unlock.';
      msg.style.display = 'block';

      const grid = document.getElementById('vipGrid');
      if (grid) {
        grid.style.display = 'flex';
        // enforce guest-view blur class so CSS applies
        grid.classList.add('vip-guest-view');
      }

      const playlists = document.getElementById('vip-playlists');
      if (playlists) {
        playlists.classList.add('vip-guest-view');
      }

      // Ensure individual cards and download previews show the blurred style
      document.querySelectorAll('#vipGrid .card, #vip-playlists .card').forEach(c => c.classList.add('vip-blur'));

      const downloads = document.getElementById('vipDownloads');
      if (downloads) {
        downloads.style.display = 'block';
        // blur iframes/links inside downloads so preview is obscured for guests
        downloads.querySelectorAll('iframe, a').forEach(el => el.style.filter = 'blur(6px) saturate(0.9)');
      }
    }

    // Robust reveal helper: remove blur classes and any inline blur styles
    function revealVIP() {
      // remove guest view and message
      const msg = document.getElementById('vipMessage');
      if (msg) msg.style.display = 'none';

      const grid = document.getElementById('vipGrid');
      if (grid) {
        grid.style.display = 'flex';
        grid.classList.remove('vip-guest-view');
      }

      const playlistsSection = document.getElementById('vip-playlists-section');
      if (playlistsSection) playlistsSection.style.display = 'block';

      const playlists = document.getElementById('vip-playlists');
      if (playlists) {
        playlists.classList.remove('vip-guest-view');
      }

      // remove blur classes from cards
      document.querySelectorAll('#vipGrid .card, #vip-playlists .card').forEach(c => {
        c.classList.remove('vip-blur');
        // also clear any inline filter
        if (c.style) c.style.filter = 'none';
      });

      // reveal downloads/iframes/links and clear inline filters
      const downloads = document.getElementById('vipDownloads');
      if (downloads) {
        downloads.style.display = 'block';
        downloads.querySelectorAll('iframe, a').forEach(el => {
          try { el.style.filter = 'none'; } catch (e) {}
        });
      }
    }

    document.addEventListener('DOMContentLoaded', async () => {
      const connectBtn = document.getElementById('patreonConnect');
      const signOutBtn = document.getElementById('patreonSignOut');

      if (connectBtn) {
        connectBtn.addEventListener('click', (e) => {
          e.preventDefault();
          // Use absolute path so Patreon receives the exact redirect URI registered
          // in the Patreon developer dashboard (https://jenninexus.com/patreon-callback.php).
          // Add loading state
          connectBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Connecting...';
          connectBtn.classList.add('disabled');
          window.location.href = '/patreon-auth-start.php';
        });
      }

      if (signOutBtn) {
        signOutBtn.addEventListener('click', () => {
          localStorage.removeItem('patreon_authenticated');
          hideVIP();
          alert('Signed out (local)');
        });
      }

      // Show blurred preview by default, then ask the membership API
      hideVIP(); // sets initial messaging and leaves previews blurred

      // Fetch tiers and render them (replace static fallback)
      try {
        const tierRes = await fetch(`${RESOURCE_BASE}/api/get-patreon-tiers.php`);
        if (tierRes.ok) {
          const tj = await tierRes.json();
          if (tj.status === 'ok' && Array.isArray(tj.tiers) && tj.tiers.length) {
            const row = document.getElementById('tiersRow');
            if (row) {
              const container = document.createElement('div');
              container.className = 'row g-4';
              tj.tiers.forEach(t => {
                const col = document.createElement('div');
                col.className = 'col-md-6 col-lg-4';
                const card = document.createElement('div');
                card.className = 'card h-100 shadow-sm';
                const header = document.createElement('div');
                header.className = 'card-header text-center';
                header.innerHTML = `<h5 class="mb-0">${t.title}</h5><small>${t.amount_cents ? ('$' + (t.amount_cents/100).toFixed(0) + ' / month') : ''}</small>`;
                const body = document.createElement('div');
                body.className = 'card-body';
                body.innerHTML = `<p class="card-text small text-muted">${t.description || ''}</p>`;
                const footer = document.createElement('div');
                footer.className = 'card-footer text-center';
                footer.innerHTML = `<a href="https://patreon.com/jenninexus" target="_blank" class="btn btn-primary">Join</a>`;
                card.appendChild(header);
                card.appendChild(body);
                card.appendChild(footer);
                col.appendChild(card);
                container.appendChild(col);
              });
              // Replace fallback
              const fallback = document.getElementById('tiersFallback');
              if (fallback && fallback.parentNode) {
                fallback.parentNode.replaceChild(container, fallback);
              }
            }
          }
        }
      } catch (e) {
        console.warn('Failed to load tiers', e);
      }

      // Ask the membership API if the visitor is authenticated / is a patron
      try {
        const mem = await fetch(`${RESOURCE_BASE}/api/check-patreon-membership.php`, { credentials: 'same-origin' });
        if (mem.ok) {
          const j = await mem.json();
          if (j.authenticated && j.is_patron) {
            // mark locally and reveal VIP content
            localStorage.setItem('patreon_authenticated', 'true');
            revealVIP();
            // fetch posts and render
            // show skeletons while fetching
            renderLoadingSkeleton(2);
            const postsRes = await fetchPatreonPosts();
            if (postsRes && postsRes.status === 'ok' && Array.isArray(postsRes.posts)) {
              // use SVG placeholder when preview_image missing
              postsRes.posts.forEach(p => { if (!p.preview_image) p.preview_image = PATREON_PLACEHOLDER_SVG; });
              renderPatreonPosts(postsRes.posts);
            } else {
              // no posts or no token: show two static placeholders using data-uri
              renderPatreonPosts([{ title: 'Preview', excerpt: '', preview_image: PATREON_PLACEHOLDER_SVG }, { title: 'Preview', excerpt: '', preview_image: PATREON_PLACEHOLDER_SVG }]);
            }

            // Load VIP playlists from YAML
            if (window.YouTubeGrid) {
              await window.YouTubeGrid.loadPageConfig('patreon');
              // Ensure newly loaded playlists are unblurred
              revealVIP();
            }
          } else {
            // Not a patron; keep previews blurred and show message
            hideVIP();
          }
        }
      } catch (err) {
        console.warn('Membership check failed:', err);
        if (isLocallyAuthenticated()) {
          revealVIP();
        } else {
          hideVIP();
        }
      }
    });
  </script>
</body>
</html>

