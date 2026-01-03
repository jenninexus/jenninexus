// Archived: diy-playlists-deployed.js
// Original file moved from project root on 2025-10-18
// If you need the original content, restore this file to the project root.

/* Original content archived for reference. */
// Archived copy of diy-playlists-deployed.js
// Original location: /diy-playlists-deployed.js

// DIY Playlists Loader with RSS Feed Support
// Loads recent videos from RSS feed + featured playlists from playlist-ids.json

const DIY_RSS_FEED = "https://www.youtube.com/feeds/videos.xml?channel_id=UCk2SWSg1fvdZGnrN0XAt6NQ";

const DIY_PLAYLISTS = [
  'diy_3d_gfx',
  'jennis_take_on_fashion',
  'diy_fashion_crafts',
  'tshirt_cutting_no_sewing',
  'diy_tutorials',
  'diy_hair_ideas',
  'diy_gel_nails',
  'nail_art_diary',
  'diy_self_care',
  'diy_nail_care'
];

async function loadDIYPlaylists() {
  const container = document.getElementById('diyPlaylistsContainer');
  if (!container) return;
  // Clear any loading placeholder and track whether we produced content
  container.innerHTML = '';
  try {
    // Load recent videos from RSS feed first
    const recentAdded = await loadRecentVideos(container);

    // Then load featured playlists
    const featuredAdded = await loadFeaturedPlaylists(container);

    // If nothing was added, show a friendly warning
    if (!recentAdded && !featuredAdded) {
      container.innerHTML = `
        <div class="col-12 text-center">
          <div class="alert alert-warning" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Unable to load tutorials. Please try again later.
          </div>
        </div>
      `;
    }

  } catch (error) {
    console.error('Error loading DIY content:', error);
    container.innerHTML = `
      <div class="col-12 text-center">
        <div class="alert alert-warning" role="alert">
          <i class="bi bi-exclamation-triangle me-2"></i>
          Unable to load tutorials. Please try again later.
        </div>
      </div>
    `;
  }
}

async function loadRecentVideos(container) {
  try {
  // Use the server-side proxy to avoid CORS/rate limits and cache responses
  const response = await fetch(`/resources/api/get-youtube.php?rss=${encodeURIComponent(DIY_RSS_FEED)}`);
  const data = await response.json();

    if (!data.items || data.items.length === 0) {
      console.warn('No recent videos found in RSS feed');
      return false;
    }

    // Create "Recent Videos" section header
    const headerHtml = `
      <div class="col-12 mb-4">
        <div class="d-flex align-items-center justify-content-between">
          <h3 class="diy-text-gradient mb-0">
            <i class="fa-solid fa-sparkles me-2"></i>Latest from DIYwJenni
          </h3>
          <span class="badge badge-diy-fashion fs-6">New!</span>
        </div>
        <hr class="mt-3" style="border-color: var(--diy-pink); opacity: 0.5;">
      </div>
    `;
    container.insertAdjacentHTML('beforeend', headerHtml);

    // Display recent videos (max 8)
    const recentVideos = data.items.slice(0, 8).map(video => {
      const videoId = video.link.split("v=")[1]?.split("&")[0];
      if (!videoId) return '';
      
      const thumbnail = `https://img.youtube.com/vi/${videoId}/hqdefault.jpg`;
      const pubDate = new Date(video.pubDate).toLocaleDateString();
      
      return `
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card h-100 border-0 shadow-sm diy-video-card" style="cursor:pointer;" data-video-id="${videoId}">
            <div class="position-relative">
              <img src="${thumbnail}" class="card-img-top" alt="${video.title}">
              <div class="play-overlay position-absolute top-50 start-50 translate-middle">
                <i class="fa-solid fa-play-circle fa-3x text-white opacity-75"></i>
              </div>
              <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                <i class="fa-solid fa-clock me-1"></i>${pubDate}
              </span>
            </div>
            <div class="card-body">
              <h6 class="card-title" style="font-size: 0.9rem; line-height: 1.3;">${video.title}</h6>
            </div>
          </div>
        </div>`;
    }).join("");

    container.insertAdjacentHTML('beforeend', recentVideos);

    // Inject a small TikTok samples row (9:16) after the recent videos
    // These are lightweight blockquote embeds that the TikTok embed script will upgrade.
    const tiktokHeader = `
      <div class="col-12 mt-3">
        <h4 class="diy-text-gradient">Also on TikTok</h4>
        <hr style="border-color: var(--diy-pink); opacity: 0.5;">
      </div>`;
    container.insertAdjacentHTML('beforeend', tiktokHeader);

    const tiktokHtml = `
      <div class="col-12">
        <div class="row g-3">
          <div class="col-md-4 col-sm-6">
            <div class="ratio ratio-9x16 tiktok-wrapper">
              <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@diywjenni/video/7407485167624916266" data-video-id="7407485167624916266"></blockquote>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="ratio ratio-9x16 tiktok-wrapper">
              <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@diywjenni/video/7431629602189004078" data-video-id="7431629602189004078"></blockquote>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="ratio ratio-9x16 tiktok-wrapper">
              <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@diywjenni/video/7445892807388122414" data-video-id="7445892807388122414"></blockquote>
            </div>
          </div>
        </div>
      </div>
    `;
    container.insertAdjacentHTML('beforeend', tiktokHtml);

  // Add click handlers for video playback
    const videoCards = container.querySelectorAll('.diy-video-card');
    videoCards.forEach(card => {
      const videoId = card.getAttribute('data-video-id');
      
      // Hover effect - optional thumbnail quality change
      card.addEventListener('mouseenter', () => {
        const img = card.querySelector('img');
        if (img) {
          img.src = `https://img.youtube.com/vi/${videoId}/mqdefault.jpg`;
        }
      });

      // Click to play video
      card.addEventListener('click', () => {
        const iframe = `
          <div class='ratio ratio-16x9'>
            <iframe 
              src='https://www.youtube.com/embed/${videoId}?autoplay=1' 
              frameborder='0' 
              allow='accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture' 
              allowfullscreen>
            </iframe>
          </div>`;
        card.innerHTML = iframe;
      });
    });
    return true;

  } catch (error) {
    console.error('Error loading recent videos:', error);
    // Non-critical error - continue to load playlists
    return false;
  }
}

async function loadFeaturedPlaylists(container) {
  try {
    // load playlist-ids.json (may not be present in some builds)
    let playlists = null;
    try {
      const response = await fetch('/resources/playlists/playlist-ids.json');
      if (!response.ok) throw new Error('playlist-ids.json not found');
      const data = await response.json();
      playlists = data.youtube && data.youtube.playlists ? data.youtube.playlists : null;
      if (!playlists) throw new Error('No playlists object in playlist-ids.json');
    } catch (err) {
      console.warn('playlist-ids.json not available or invalid, skipping featured playlists:', err.message || err);
      return false;
    }
    // Create "Featured Playlists" section header
    const headerHtml = `
      <div class="col-12 mb-4 mt-5">
        <div class="d-flex align-items-center">
          <h3 class="diy-text-gradient mb-0">
            <i class="fa-solid fa-folder-open me-2"></i>Featured DIY Playlists
          </h3>
        </div>
        <hr class="mt-3" style="border-color: var(--diy-purple); opacity: 0.5;">
      </div>
    `;
    container.insertAdjacentHTML('beforeend', headerHtml);

    let added = false;
    DIY_PLAYLISTS.forEach(playlistKey => {
      if (playlists && playlists[playlistKey]) {
        const playlist = playlists[playlistKey];
        const cardHtml = createPlaylistCardHTML(playlist);
        container.insertAdjacentHTML('beforeend', cardHtml);
        added = true;
      }
    });
    return added;

  } catch (error) {
    console.error('Error loading featured playlists:', error);
    return false;
  }
}

function createPlaylistCardHTML(playlist) {
  const playlistEmbed = `https://www.youtube.com/embed/videoseries?list=${playlist.id}`;
  const playlistUrl = `https://www.youtube.com/playlist?list=${playlist.id}`;
  const categoryBadge = getCategoryBadge(playlist.category || 'diy');

  return `
    <div class="col-lg-6 mb-4">
      <div class="card diy-playlist-card h-100">
        <div class="ratio ratio-16x9 diy-video-overlay">
          <iframe 
            src="${playlistEmbed}" 
            title="${playlist.title}"
            allowfullscreen
            loading="lazy">
          </iframe>
        </div>
        <div class="card-body">
          <h5 class="card-title diy-text-gradient">${playlist.title}</h5>
          <p class="card-text text-muted">${playlist.description || 'DIY tutorial playlist'}</p>
          <div class="mt-2">
            ${categoryBadge}
          </div>
        </div>
        <div class="card-footer bg-transparent border-0">
          <a href="${playlistUrl}" target="_blank" class="btn btn-diy-primary w-100">
            <i class="bi bi-youtube me-2"></i>Watch on YouTube
          </a>
        </div>
      </div>
    </div>
  `;
}

function getCategoryBadge(category) {
  const badges = {
    'diy': '<span class="badge badge-diy-fashion">DIY</span>',
    'fashion': '<span class="badge badge-diy-fashion">Fashion</span>',
    'beauty': '<span class="badge badge-diy-beauty">Beauty</span>',
    'hair': '<span class="badge badge-diy-hair">Hair</span>',
    'nails': '<span class="badge badge-diy-nails">Nail Art</span>',
    'nailart': '<span class="badge badge-diy-nails">Nail Art</span>',
    'self_care': '<span class="badge badge-diy-selfcare">Self-Care</span>',
    'selfcare': '<span class="badge badge-diy-selfcare">Self-Care</span>',
    '3d': '<span class="badge badge-diy-beauty">3D & Graphics</span>',
    '3d_gfx': '<span class="badge badge-diy-beauty">3D & Graphics</span>',
    'brand_collabs': '<span class="badge badge-diy-fashion">Brand Collabs</span>'
  };
  return badges[category] || '<span class="badge badge-diy-fashion">DIY</span>';
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', loadDIYPlaylists);
