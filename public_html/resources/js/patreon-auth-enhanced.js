// Patreon client helpers (minimal)
const RESOURCE_BASE = (typeof window !== 'undefined' && window.RES_ROOT) ? window.RES_ROOT : '/resources';

async function fetchPatreonPosts(containerSelector) {
  const container = document.querySelector(containerSelector);
  if (!container) return;
  container.innerHTML = '<div class="placeholder-grid">Loading posts...</div>';

  try {
    const resp = await fetch(`${RESOURCE_BASE}/api/get-patreon-posts.php`);
    const json = await resp.json();
    if (json.status === 'no_token' || !json.posts || json.posts.length === 0) {
      // show blurred placeholders
      container.innerHTML = Array.from({length:3}).map(()=>`<div class="patreon-post blurred">Locked content</div>`).join('');
      return;
    }
    // Render posts (unblurred for now - server should validate auth)
    container.innerHTML = json.posts.map(p => `<div class="patreon-post">${p.title}</div>`).join('');
  } catch (err) {
    console.error('Patreon fetch failed', err);
    container.innerHTML = '<div class="alert alert-warning">Unable to load Patreon posts</div>';
  }
}

function startPatreonAuth() {
  window.location.href = '/patreon-auth-start.php';
}

// expose helpers to global scope for inline onclick handlers
window.fetchPatreonPosts = fetchPatreonPosts;
window.startPatreonAuth = startPatreonAuth;
/**
 * Enhanced Patreon Authentication System for JenniNexus
 * Provides access to:
 * - VIP/Patreon exclusive playlists
 * - Embedded CC4 PDF viewer
 * - Premium content sections
 */

(function() {
  'use strict';

  // Patreon configuration
  const PATREON_CONFIG = {
    clientId: 'rpG5M7dfBT8HsnSkDtPhbu7Bwe7RAdpcHKX-MpiVwqg7zsS3--97aMxXTFNI1nGt',
    redirectUri: window.location.origin + '/',
    campaignId: '117499'
  };

  // VIP Playlists from playlist-ids.json
  const VIP_PLAYLISTS = [
    'vip',
    'sub_updates',
    'sexy_music',
    'fire_dancing_hoop_yoga'
  ];

  /**
   * Initialize Patreon auth system
   */
  function initPatreonAuth() {
    // Check authentication status
    checkAuthStatus();
    
    // Handle download button
    const downloadBtn = document.querySelector('a[download]');
    if (downloadBtn) {
      downloadBtn.addEventListener('click', handleDownloadClick);
    }

    // Check for OAuth callback
    checkPatreonCallback();
    
    // Initialize VIP content sections
    initVIPSections();
  }

  /**
   * Check if user is authenticated
   */
  function checkAuthStatus() {
    const token = localStorage.getItem('patreon_token');
    const verified = localStorage.getItem('patreon_verified');
    
    if (token && verified === 'true') {
      // User is authenticated, show VIP content
      showVIPContent();
      updateUIForAuthUser();
    } else {
      // Hide VIP content
      hideVIPContent();
    }
  }

  /**
   * Initialize VIP content sections
   */
  function initVIPSections() {
    // Create VIP content section if it doesn't exist
    const patreonSection = document.getElementById('patreon');
    if (patreonSection) {
      createVIPContentSection(patreonSection);
    }
  }

  /**
   * Create VIP content section in Patreon area
   */
  function createVIPContentSection(parentSection) {
    // Check if VIP section already exists
    if (document.getElementById('vip-content-section')) {
      return;
    }

    const vipSection = document.createElement('div');
    vipSection.id = 'vip-content-section';
    vipSection.className = 'vip-content mt-5';
    vipSection.style.display = 'none'; // Hidden by default
    
    vipSection.innerHTML = `
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, var(--jenni-primary), var(--jenni-secondary));">
              <div class="card-body p-5 text-white text-center">
                <i class="fa-solid fa-crown fs-1 mb-3 d-block"></i>
                <h2 class="display-5 mb-4">Welcome, Patron! 👑</h2>
                <p class="lead">Thank you for your support! Here's your exclusive content:</p>
              </div>
            </div>
          </div>
        </div>

        <!-- CC4 PDF Viewer -->
        <div class="row mt-5">
          <div class="col-lg-12">
            <div class="card border-0 shadow-lg">
              <div class="card-header bg-primary text-white">
                <h3 class="mb-0">
                  <i class="fa-solid fa-file-pdf me-2"></i>Character Creator 4 Guide (Exclusive PDF)
                </h3>
              </div>
              <div class="card-body p-0">
                <div class="pdf-viewer-container" style="height: 600px; overflow: hidden;">
                    <iframe 
                      src="${(typeof window !== 'undefined' && window.RES_ROOT) ? window.RES_ROOT : '/resources'}/pdfs/jenninexus_cc4_2025.pdf" 
                    width="100%" 
                    height="100%" 
                    style="border: none;"
                    title="Character Creator 4 Guide">
                  </iframe>
                </div>
                <div class="card-footer">
                  <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                      <i class="fa-solid fa-circle-info me-1"></i>
                      Exclusive guide for Patreon supporters
                    </small>
                    <a href="${(typeof window !== 'undefined' && window.RES_ROOT) ? window.RES_ROOT : '/resources'}/pdfs/jenninexus_cc4_2025.pdf" download class="btn btn-sm btn-primary">
                        <i class="fa-solid fa-download me-2"></i>Download PDF
                      </a>
                      <a href="${(typeof window !== 'undefined' && window.RES_ROOT) ? window.RES_ROOT : '/resources'}/pdfs/jenninexus_cc4_2025.pdf" download class="btn btn-sm btn-primary">
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- VIP Playlists -->
        <div class="row mt-5">
          <div class="col-lg-12">
            <div class="card border-0 shadow">
              <div class="card-header bg-secondary text-white">
                <h3 class="mb-0">
                  <i class="fa-solid fa-clapperboard me-2"></i>VIP Exclusive Playlists
                </h3>
              </div>
              <div class="card-body">
                <div class="row g-4" id="vip-playlists-container">
                  <!-- Playlists will be loaded here -->
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Additional VIP Benefits -->
        <div class="row mt-5 mb-5">
          <div class="col-lg-12">
            <div class="card border-0 shadow">
              <div class="card-header bg-info text-white">
                <h3 class="mb-0">
                  <i class="fa-solid fa-gift me-2"></i>Your Patron Benefits
                </h3>
              </div>
              <div class="card-body p-4">
                <div class="row g-3">
                  <div class="col-md-6 col-lg-3">
                    <div class="text-center p-3">
                      <i class="bi bi-film fs-1 text-primary mb-3 d-block"></i>
                      <h5>VIP Playlists</h5>
                      <p class="small text-muted">Exclusive video content</p>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-3">
                    <div class="text-center p-3">
                      <i class="bi bi-file-earmark-pdf fs-1 text-secondary mb-3 d-block"></i>
                      <h5>PDF Guides</h5>
                      <p class="small text-muted">Technical resources</p>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-3">
                    <div class="text-center p-3">
                      <i class="bi bi-code-square fs-1 text-success mb-3 d-block"></i>
                      <h5>Source Files</h5>
                      <p class="small text-muted">Project assets</p>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-3">
                    <div class="text-center p-3">
                      <i class="bi bi-discord fs-1 text-info mb-3 d-block"></i>
                      <h5>VIP Discord</h5>
                      <p class="small text-muted">Exclusive community</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;

    // Insert after Patreon tier cards
    parentSection.appendChild(vipSection);
    
    // Load VIP playlists
    loadVIPPlaylists();
  }

  /**
   * Load VIP playlists
   */
  async function loadVIPPlaylists() {
    const container = document.getElementById('vip-playlists-container');
    if (!container) return; // Silently skip if container doesn't exist

    try {
      const RESOURCE_BASE = (typeof window !== 'undefined' && window.RES_ROOT) ? window.RES_ROOT : '/resources';
      
      // Try loading from patreon.yaml via youtube-grid.js if available
      if (window.YouTubeGrid && window.YouTubeGrid.loadPageConfig) {
        await window.YouTubeGrid.loadPageConfig('patreon');
        return;
      }
      
      // Fallback: show message that playlists are managed via YAML now
      container.innerHTML = '<div class="col-12"><p class="text-muted text-center">VIP playlists loading...</p></div>';

    } catch (error) {
      // Silently handle - container exists but config not found
      console.debug('VIP playlists container found but config not loaded:', error.message);
    }
  }

  /**
   * Create playlist card element
   */
  function createPlaylistCard(playlist) {
    const col = document.createElement('div');
    col.className = 'col-md-6 col-lg-3';
    
    col.innerHTML = `
      <div class="card h-100 border-0 shadow-sm playlist-card">
        <div class="card-body text-center p-4">
          <div class="playlist-icon mb-3">
            <i class="bi bi-play-circle-fill fs-1 text-danger"></i>
          </div>
          <h5 class="card-title">${playlist.title}</h5>
          <p class="card-text small text-muted">${playlist.description}</p>
          <span class="badge bg-warning text-dark mb-3">
            <i class="bi bi-crown-fill me-1"></i>VIP EXCLUSIVE
          </span>
          <div class="d-grid">
            <a href="https://www.youtube.com/playlist?list=${playlist.id}" 
               target="_blank" 
               class="btn btn-outline-danger btn-sm">
              <i class="bi bi-youtube me-2"></i>Watch Playlist
            </a>
          </div>
        </div>
      </div>
    `;

    return col;
  }

  /**
   * Show VIP content
   */
  function showVIPContent() {
    const vipSection = document.getElementById('vip-content-section');
    if (vipSection) {
      vipSection.style.display = 'block';
    }
  }

  /**
   * Hide VIP content
   */
  function hideVIPContent() {
    const vipSection = document.getElementById('vip-content-section');
    if (vipSection) {
      vipSection.style.display = 'none';
    }
  }

  /**
   * Update UI for authenticated user
   */
  function updateUIForAuthUser() {
    // Update download button text
    const downloadBtn = document.querySelector('a[download]');
    if (downloadBtn) {
      downloadBtn.innerHTML = '<i class="bi bi-check-circle me-2"></i>Download Resume (Verified Patron)';
      downloadBtn.classList.remove('btn-primary');
      downloadBtn.classList.add('btn-success');
    }

    // Show success badge in navbar (optional)
    const navbar = document.querySelector('.navbar-nav');
    if (navbar && !document.getElementById('patron-badge')) {
      const badge = document.createElement('li');
      badge.id = 'patron-badge';
      badge.className = 'nav-item';
      badge.innerHTML = '<span class="badge bg-success ms-2"><i class="bi bi-check-circle me-1"></i>Patron</span>';
      navbar.appendChild(badge);
    }
  }

  /**
   * Handle resume download click
   */
  function handleDownloadClick(e) {
    const patreonToken = localStorage.getItem('patreon_token');
    
    if (patreonToken) {
      verifyPatreonToken(patreonToken).then(isValid => {
        if (!isValid) {
          e.preventDefault();
          showPatreonModal();
        }
      });
    } else {
      e.preventDefault();
      showPatreonModal();
    }
  }

  /**
   * Show Patreon authentication modal
   */
  function showPatreonModal() {
    let modal = document.getElementById('patreonAuthModal');
    
    if (!modal) {
      modal = createPatreonModal();
      document.body.appendChild(modal);
    }

    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
  }

  /**
   * Create Patreon modal element
   */
  function createPatreonModal() {
    const modal = document.createElement('div');
    modal.className = 'modal fade';
    modal.id = 'patreonAuthModal';
    modal.tabIndex = -1;
    
    modal.innerHTML = `
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header" style="background: linear-gradient(135deg, var(--jenni-primary), var(--jenni-secondary));">
            <h5 class="modal-title text-white">
              <i class="bi bi-crown-fill me-2"></i>Patreon Supporter Exclusive Content
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-5">
            <div class="text-center mb-4">
              <i class="bi bi-lock-fill fs-1 text-primary mb-3 d-block"></i>
              <h4 class="mb-3">Unlock Exclusive Content</h4>
              <p class="lead mb-4">Become a patron to access VIP content including:</p>
            </div>
            
            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <div class="d-flex align-items-start">
                  <i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>
                  <div>
                    <h6 class="mb-1">Full Resume & Portfolio</h6>
                    <p class="small text-muted mb-0">Detailed professional experience</p>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex align-items-start">
                  <i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>
                  <div>
                    <h6 class="mb-1">CC4 Technical Guide</h6>
                    <p class="small text-muted mb-0">Character Creator 4 PDF tutorial</p>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex align-items-start">
                  <i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>
                  <div>
                    <h6 class="mb-1">VIP Playlists</h6>
                    <p class="small text-muted mb-0">Exclusive video content & tutorials</p>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex align-items-start">
                  <i class="bi bi-check-circle-fill text-success fs-4 me-3 mt-1"></i>
                  <div>
                    <h6 class="mb-1">Project Source Files</h6>
                    <p class="small text-muted mb-0">Game assets & templates</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="alert alert-info mb-4">
              <i class="bi bi-info-circle me-2"></i>
              <strong>Note:</strong> After logging in with Patreon, all exclusive content will be immediately accessible on this page.
            </div>

            <div class="d-grid gap-3">
              <button class="btn btn-primary btn-lg" onclick="window.patreonAuth.login()">
                <i class="bi bi-box-arrow-in-right me-2"></i>Login with Patreon
              </button>
              <a href="https://patreon.com/jenninexus" target="_blank" class="btn btn-outline-primary btn-lg">
                <i class="bi bi-heart-fill me-2"></i>Become a Patron ($5/month)
              </a>
            </div>
          </div>
        </div>
      </div>
    `;
    
    return modal;
  }

  /**
   * Initiate Patreon OAuth login
   */
  function patreonLogin() {
    const authUrl = 'https://www.patreon.com/oauth2/authorize?' + new URLSearchParams({
      response_type: 'code',
      client_id: PATREON_CONFIG.clientId,
      redirect_uri: PATREON_CONFIG.redirectUri,
      scope: 'identity identity[email] campaigns campaigns.members'
    });

    localStorage.setItem('patreon_intent', 'access_vip_content');
    window.location.href = authUrl;
  }

  /**
   * Check if returning from Patreon OAuth
   */
  function checkPatreonCallback() {
    const urlParams = new URLSearchParams(window.location.search);
    const code = urlParams.get('code');
    
    if (code) {
      console.log('Patreon auth code received:', code);
      handlePatreonSuccess();
      
      // Clean URL
      window.history.replaceState({}, document.title, window.location.pathname);
    }
  }

  /**
   * Handle successful Patreon authentication
   */
  function handlePatreonSuccess() {
    // Store authentication (in production, verify with backend)
    localStorage.setItem('patreon_token', 'verified_' + Date.now());
    localStorage.setItem('patreon_verified', 'true');
    
    // Show VIP content
    showVIPContent();
    updateUIForAuthUser();
    
    // Show success message
    showSuccessMessage('Success! Welcome, Patron! VIP content is now unlocked.');
    
    // Scroll to VIP content
    setTimeout(() => {
      const vipSection = document.getElementById('vip-content-section');
      if (vipSection) {
        vipSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    }, 1000);
  }

  /**
   * Verify Patreon token
   */
  async function verifyPatreonToken(token) {
    // In production, call backend API to verify
    const verified = localStorage.getItem('patreon_verified');
    return verified === 'true';
  }

  /**
   * Show success message
   */
  function showSuccessMessage(message) {
    if (window.mgShowToast) {
      window.mgShowToast(message, 'success');
    } else {
      // Fallback to alert if toast system not loaded
      const alert = document.createElement('div');
      alert.className = 'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-5';
      alert.style.zIndex = '9999';
      alert.style.minWidth = '300px';
      alert.innerHTML = `
        <i class="bi bi-check-circle-fill me-2"></i>
        <strong>${message}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      `;
      document.body.appendChild(alert);
      setTimeout(() => alert.remove(), 5000);
    }
  }

  /**
   * Logout function (for testing)
   */
  function logout() {
    localStorage.removeItem('patreon_token');
    localStorage.removeItem('patreon_verified');
    localStorage.removeItem('patreon_intent');
    
    hideVIPContent();
    
    // Remove patron badge
    const badge = document.getElementById('patron-badge');
    if (badge) badge.remove();
    
    // Reset download button
    const downloadBtn = document.querySelector('a[download]');
    if (downloadBtn) {
      downloadBtn.innerHTML = '<i class="bi bi-download me-2"></i>Download Resume';
      downloadBtn.classList.remove('btn-success');
      downloadBtn.classList.add('btn-primary');
    }
    
    showSuccessMessage('Logged out successfully');
  }

  // Export to global scope
  window.patreonAuth = {
    init: initPatreonAuth,
    login: patreonLogin,
    logout: logout
  };

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPatreonAuth);
  } else {
    initPatreonAuth();
  }

})();
