<?php
$activePage = 'youtube';
$customCSS = [RES_ROOT . '/css/media' . ($assetSuffix ?? '') . '.css'];
include __DIR__ . '/includes/head.php';
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <title>YouTube Channel | JenniNexus</title>
  <meta name="description" content="Watch the latest videos from the JenniNexus YouTube channel - gaming, game dev, DIY, and more.">
  
  <style>
    .youtube-hero {
      background: linear-gradient(135deg, #FF0000 0%, #C4302B 50%, #8B0000 100%);
    }
    
    .playlist-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .playlist-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(255, 0, 0, 0.3);
    }
  </style>
</head>

<body>
  <?php include __DIR__ . '/includes/header.php'; ?>

  <main>
    <!-- Hero Section -->
    <section class="hero-section youtube-hero py-5 text-white">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-8">
            <div class="glass-panel p-5 rounded-4 shadow-lg">
              <h1 class="display-4 mb-3 hero-title">
                <i class="fa-brands fa-youtube me-3"></i>JenniNexus YouTube
              </h1>
              <p class="lead mb-4 hero-title">
                Game development, gaming content, DIY projects, and creative tech - all in one place.
              </p>
              <div class="d-flex gap-3 flex-wrap hero-title">
                <a href="https://youtube.com/@jenninexus" class="btn btn-light btn-lg" target="_blank" rel="noopener">
                  <i class="fa-brands fa-youtube me-2"></i>Subscribe
                </a>
                <a href="#latest-videos" class="btn btn-outline-light btn-lg">
                  <i class="fa-solid fa-play me-2"></i>Watch Latest
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-4 text-center mt-4 mt-lg-0">
            <i class="fa-brands fa-youtube pulse-animation" style="font-size: 10rem; opacity: 0.3;"></i>
          </div>
        </div>
      </div>
    </section>

    <!-- Tag Filter Section -->
    <section class="py-3 bg-body-secondary">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <div class="text-center mb-3">
              <h5 class="mb-2">Filter by Category</h5>
              <p class="small text-muted mb-3">Click tags to filter playlists by content type</p>
            </div>
            
            <!-- Category Tags -->
            <div class="mb-3">
              <div class="d-flex flex-wrap justify-content-center gap-2">
                <button class="badge bg-danger bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="gaming">
                  <i class="fa-solid fa-gamepad me-1"></i>Gaming
                </button>
                <button class="badge bg-success bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="gamedev">
                  <i class="fa-solid fa-code me-1"></i>Game Dev
                </button>
                <button class="badge bg-warning bg-opacity-75 text-dark p-2 border-0" style="cursor: pointer;" data-tag="diy">
                  <i class="fa-solid fa-scissors me-1"></i>DIY
                </button>
                <button class="badge bg-info bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="ai">
                  <i class="fa-solid fa-robot me-1"></i>AI & Tech
                </button>
                <button class="badge bg-primary bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="music">
                  <i class="fa-solid fa-music me-1"></i>Music
                </button>
                <button class="badge bg-secondary bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="live">
                  <i class="fa-solid fa-tower-broadcast me-1"></i>Live
                </button>
                <button class="badge bg-dark bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="voice-acting">
                  <i class="fa-solid fa-microphone me-1"></i>Voice Acting
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
      </div>
    </section>

    <!-- Latest Videos Section (RSS Feed) -->
    <section id="latest-videos" class="py-5 bg-dark">
      <div class="container">
        <div class="row mb-4">
          <div class="col-12 text-center">
            <h2 class="display-6 mb-3">Latest Videos</h2>
            <p class="lead text-muted">Fresh content from the JenniNexus channel</p>
          </div>
        </div>
        
        <div id="youtube-feed" class="row g-4">
          <!-- Videos will be loaded via RSS feed -->
          <div class="col-12 text-center">
            <div class="spinner-border text-danger" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3 text-muted">Loading latest videos...</p>
          </div>
        </div>
      </div>
    </section>

    <!-- YouTube Channels -->
    <section class="py-5">
    <!-- Featured Playlists Section (from youtube.yaml) -->
    <section class="py-5 bg-dark-subtle">
      <div class="container">
        <div class="row mb-4">
          <div class="col-12 text-center">
            <h2 class="display-6 mb-3">Featured Playlists</h2>
            <p class="lead text-muted">Curated collections from gaming, game dev, DIY, AI, music, and more</p>
          </div>
        </div>
        
        <div id="youtube-playlists" class="row g-4">
          <!-- Playlists will be rendered via youtube-grid.js loading youtube.yaml -->
          <div class="col-12 text-center">
            <div class="spinner-border text-danger" role="status">
              <span class="visually-hidden">Loading playlists...</span>
            </div>
            <p class="mt-3 text-muted">Loading featured playlists...</p>
          </div>
        </div>
      </div>
    </section>

    <!-- YouTube Channels -->
    <section class="py-5">
      <div class="container">
        <div class="row mb-4">
          <div class="col-12 text-center">
            <h2 class="display-6 mb-3">YouTube Channels</h2>
            <p class="lead text-muted">Follow all three channels for complete content coverage</p>
          </div>
        </div>
        
        <div class="row g-4 justify-content-center">
          <div class="col-md-4">
            <a href="https://www.youtube.com/@jenninexus?sub_confirmation=1" target="_blank" class="text-decoration-none">
              <div class="card h-100 border-0 shadow-lg" style="background: linear-gradient(135deg, #FF0000, #CC0000);">
                <div class="card-body text-center text-white p-4">
                  <i class="fa-brands fa-youtube" style="font-size: 3rem; opacity: 0.9;"></i>
                  <h4 class="mt-3 mb-2">JenniNexus</h4>
                  <p class="mb-3" style="opacity: 0.9;">Main channel - Game dev, music, creative content</p>
                  <span class="btn btn-light btn-sm">
                    <i class="fa-solid fa-plus-circle me-1"></i>Subscribe
                  </span>
                </div>
              </div>
            </a>
          </div>
          
          <div class="col-md-4">
            <a href="https://www.youtube.com/@jenniplaysgames?sub_confirmation=1" target="_blank" class="text-decoration-none">
              <div class="card h-100 border-0 shadow-lg" style="background: linear-gradient(135deg, #9146FF, #772CE8);">
                <div class="card-body text-center text-white p-4">
                  <i class="fa-solid fa-gamepad" style="font-size: 3rem; opacity: 0.9;"></i>
                  <h4 class="mt-3 mb-2">Jenni Plays Games</h4>
                  <p class="mb-3" style="opacity: 0.9;">Gaming channel - Let's plays, horror, indie games</p>
                  <span class="btn btn-light btn-sm">
                    <i class="fa-solid fa-plus-circle me-1"></i>Subscribe
                  </span>
                </div>
              </div>
            </a>
          </div>
          
          <div class="col-md-4">
            <a href="https://www.youtube.com/@diywjenni?sub_confirmation=1" target="_blank" class="text-decoration-none">
              <div class="card h-100 border-0 shadow-lg" style="background: linear-gradient(135deg, #E91E63, #C2185B);">
                <div class="card-body text-center text-white p-4">
                  <i class="fa-solid fa-scissors" style="font-size: 3rem; opacity: 0.9;"></i>
                  <h4 class="mt-3 mb-2">DIY w/ Jenni</h4>
                  <p class="mb-3" style="opacity: 0.9;">DIY channel - Fashion, beauty, nail art, crafts</p>
                  <span class="btn btn-light btn-sm">
                    <i class="fa-solid fa-plus-circle me-1"></i>Subscribe
                  </span>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Browse by Category -->
    <section class="py-5 bg-dark">
      <div class="container">
        <div class="row mb-4">
          <div class="col-12 text-center">
            <h2 class="display-6 mb-3">Browse by Category</h2>
            <p class="lead text-muted">Explore content by topic</p>
          </div>
        </div>
        
        <div class="row g-3">
          <div class="col-md-4">
            <a href="/gaming" class="text-decoration-none">
              <div class="card playlist-card h-100 border-0 shadow" style="background: linear-gradient(135deg, #007bff, #0056b3);">
                <div class="card-body text-center text-white p-4">
                  <i class="fa-solid fa-gamepad" style="font-size: 3rem; opacity: 0.9; margin-bottom: 1rem;"></i>
                  <h3 class="h4 mb-2">Gaming</h3>
                  <p class="mb-0" style="opacity: 0.9;">Let's Plays, Reviews & Streams</p>
                </div>
              </div>
            </a>
          </div>
          
          <div class="col-md-4">
            <a href="/gamedev" class="text-decoration-none">
              <div class="card playlist-card h-100 border-0 shadow" style="background: linear-gradient(135deg, #28a745, #1e7e34);">
                <div class="card-body text-center text-white p-4">
                  <i class="fa-solid fa-code" style="font-size: 3rem; opacity: 0.9; margin-bottom: 1rem;"></i>
                  <h3 class="h4 mb-2">Game Dev</h3>
                  <p class="mb-0" style="opacity: 0.9;">Tutorials, Devlogs & Tips</p>
                </div>
              </div>
            </a>
          </div>
          
          <div class="col-md-4">
            <a href="/diy" class="text-decoration-none">
              <div class="card playlist-card h-100 border-0 shadow" style="background: linear-gradient(135deg, #ffc107, #e0a800);">
                <div class="card-body text-center text-white p-4">
                  <i class="fa-solid fa-scissors" style="font-size: 3rem; opacity: 0.9; margin-bottom: 1rem;"></i>
                  <h3 class="h4 mb-2">DIY & Beauty</h3>
                  <p class="mb-0" style="opacity: 0.9;">Fashion, Nails & Self-Care</p>
                </div>
              </div>
            </a>
          </div>
          
          <div class="col-md-4">
            <a href="/ai" class="text-decoration-none">
              <div class="card playlist-card h-100 border-0 shadow" style="background: linear-gradient(135deg, #17a2b8, #117a8b);">
                <div class="card-body text-center text-white p-4">
                  <i class="fa-solid fa-robot" style="font-size: 3rem; opacity: 0.9; margin-bottom: 1rem;"></i>
                  <h3 class="h4 mb-2">AI & Tech</h3>
                  <p class="mb-0" style="opacity: 0.9;">AI Tools & Research</p>
                </div>
              </div>
            </a>
          </div>
          
          <div class="col-md-4">
            <a href="/music" class="text-decoration-none">
              <div class="card playlist-card h-100 border-0 shadow" style="background: linear-gradient(135deg, #dc3545, #bd2130);">
                <div class="card-body text-center text-white p-4">
                  <i class="fa-solid fa-music" style="font-size: 3rem; opacity: 0.9; margin-bottom: 1rem;"></i>
                  <h3 class="h4 mb-2">Music</h3>
                  <p class="mb-0" style="opacity: 0.9;">DJ Sets & Productions</p>
                </div>
              </div>
            </a>
          </div>
          
          <div class="col-md-4">
            <a href="/live" class="text-decoration-none">
              <div class="card playlist-card h-100 border-0 shadow" style="background: linear-gradient(135deg, #6c757d, #545b62);">
                <div class="card-body text-center text-white p-4">
                  <i class="fa-solid fa-video" style="font-size: 3rem; opacity: 0.9; margin-bottom: 1rem;"></i>
                  <h3 class="h4 mb-2">Live Streams</h3>
                  <p class="mb-0" style="opacity: 0.9;">Twitch & YouTube Live</p>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Tag Filter Offcanvas -->
  <?php include __DIR__ . '/includes/tag-filter-offcanvas.php'; ?>

  <?php include __DIR__ . '/includes/footer.php'; ?>

  <!-- Scripts must load in this order: js-yaml → youtube-grid → tag-system → page init -->
  <script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
  <script src="<?= RES_ROOT ?>/js/youtube-grid.js"></script>
  <script src="<?= RES_ROOT ?>/js/tag-system.js"></script>

  <script>
    // Initialize tag filtering system AFTER youtube-grid loads playlist cards
    document.addEventListener('YouTubeGrid:usedTagsUpdated', function() {
      console.log('YouTube Grid loaded, initializing tag filter...');
      if (window.tagFilter && typeof window.tagFilter.init === 'function') {
        window.tagFilter.init({
          seedFromUrl: true,
          persistUrl: true
        });
        
        window.tagFilter.onChange(function(active) {
          console.log('Active tags changed:', active);
          if (typeof window.tagFilter.syncToDom === 'function') {
            window.tagFilter.syncToDom();
          }
        });
      }
    });
    
    // Load YouTube channel RSS feed and display latest 8 videos
    async function loadYouTubeFeed() {
      const channelId = 'UCMdVZ64zYbNZ5jBhaa7VxQA'; // @jenninexus main channel (correct ID)
      const feedContainer = document.getElementById('youtube-feed');
      
      try {
        // Use our server-side proxy instead of rss2json.com for consistency
        const proxyUrl = `<?= RES_ROOT ?>/api/get-youtube.php?channel_id=${channelId}`;
        const response = await fetch(proxyUrl);
        
        if (!response.ok) {
          throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        const data = await response.json();
        
        // Handle both array and single entry responses
        const entries = data.entry ? (Array.isArray(data.entry) ? data.entry : [data.entry]) : [];
        
        if (entries.length > 0) {
          const videos = entries.slice(0, 8); // Show 8 latest videos
          
          feedContainer.innerHTML = videos.map(video => {
            // Extract video ID - get-youtube.php converts yt:videoId to videoId property
            const videoId = video.videoId || video['yt:videoId'] || '';
            const title = video.title || 'Untitled Video';
            const link = video.link?.href || video.link?.['@attributes']?.href || `https://www.youtube.com/watch?v=${videoId}`;
            const pubDate = video.published || new Date().toISOString();
            
            // Use thumbnail from get-youtube.php or construct URL
            const thumbnail = video.thumbnail || `https://i.ytimg.com/vi/${videoId}/mqdefault.jpg`;
            
            // Detect tags from title for RSS feed videos (@jenninexus main channel = all categories)
            const titleLower = title.toLowerCase();
            const detectedTags = [];
            
            // Category detection
            if (titleLower.includes('gaming') || titleLower.includes('gameplay') || titleLower.includes('let\'s play') || titleLower.includes('playthrough')) {
              detectedTags.push('gaming');
            }
            if (titleLower.includes('game dev') || titleLower.includes('gamedev') || titleLower.includes('unity') || titleLower.includes('unreal')) {
              detectedTags.push('gamedev');
            }
            if (titleLower.includes('diy') || titleLower.includes('craft') || titleLower.includes('tutorial') || titleLower.includes('how to')) {
              detectedTags.push('diy');
            }
            if (titleLower.includes('ai') || titleLower.includes('tech') || titleLower.includes('artificial intelligence')) {
              detectedTags.push('ai');
            }
            if (titleLower.includes('music') || titleLower.includes('song') || titleLower.includes('cover') || titleLower.includes('original')) {
              detectedTags.push('music');
            }
            if (titleLower.includes('live') || titleLower.includes('stream') || titleLower.includes('vod')) {
              detectedTags.push('live');
            }
            if (titleLower.includes('voice') || titleLower.includes('acting') || titleLower.includes('character')) {
              detectedTags.push('voice-acting');
            }
            
            // Default to youtube tag if no category detected
            if (detectedTags.length === 0) {
              detectedTags.push('youtube');
            }
            
            // Always add youtube and videos tags
            detectedTags.push('youtube', 'videos');
            const dataTagsAttr = detectedTags.join(',');
            
            // Generate tag badges (clickable buttons with data-tag attribute)
            const tagBadges = detectedTags.filter(tag => tag !== 'youtube' && tag !== 'videos').map(tag => {
              const tagConfig = {
                'gaming': { color: 'danger', icon: 'gamepad', label: 'Gaming' },
                'gamedev': { color: 'success', icon: 'code', label: 'Game Dev' },
                'diy': { color: 'warning', icon: 'scissors', label: 'DIY' },
                'ai': { color: 'info', icon: 'robot', label: 'AI & Tech' },
                'music': { color: 'primary', icon: 'music', label: 'Music' },
                'live': { color: 'secondary', icon: 'tower-broadcast', label: 'Live' },
                'voice-acting': { color: 'dark', icon: 'microphone', label: 'Voice Acting' }
              };
              const config = tagConfig[tag] || { color: 'secondary', icon: 'tag', label: tag };
              const textClass = config.color === 'warning' ? 'text-dark' : 'text-white';
              return `<button class="badge bg-${config.color} bg-opacity-75 ${textClass} border-0" style="cursor: pointer;" data-tag="${tag}" onclick="(window.tagFilter && window.tagFilter.toggle) ? window.tagFilter.toggle('${tag}') : null"><i class="fa-solid fa-${config.icon} me-1"></i>${config.label}</button>`;
            }).join(' ');
            
            // Create primary tag link (first detected tag, or youtube if none)
            const primaryTag = detectedTags.find(tag => tag !== 'youtube' && tag !== 'videos') || 'youtube';
            const tagLink = `/tags.php?filters=${primaryTag}`;
            
            return `
              <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 bg-dark border-secondary playlist-card" data-tags="${dataTagsAttr}">
                  <a href="${tagLink}" class="text-decoration-none">
                    <div class="ratio ratio-16x9">
                      <img src="${thumbnail}" class="card-img-top object-fit-cover" alt="${title}" loading="lazy">
                    </div>
                    <div class="card-body">
                      <h5 class="card-title text-white">${title}</h5>
                      <p class="card-text text-muted small">
                        <i class="fa-regular fa-calendar me-2"></i>${new Date(pubDate).toLocaleDateString()}
                      </p>
                      ${tagBadges ? `<div class="mt-2">${tagBadges}</div>` : ''}
                    </div>
                  </a>
                </div>
              </div>
            `;
          }).join('');
        } else {
          feedContainer.innerHTML = '<div class="col-12"><p class="text-center text-muted">Unable to load videos. <a href="https://youtube.com/@jenninexus" target="_blank">Visit YouTube Channel</a></p></div>';
        }
      } catch (err) {
        console.error('Error loading YouTube feed:', err);
        feedContainer.innerHTML = '<div class="col-12"><p class="text-center text-muted">Unable to load videos. <a href="https://youtube.com/@jenninexus" target="_blank">Visit YouTube Channel</a></p></div>';
      }
    }
    
    // Load everything when DOM is ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', loadYouTubeFeed);
    } else {
      loadYouTubeFeed();
    }
  </script>

  <!-- Initialize YouTube Grid to load playlists -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      if (window.YouTubeGrid && typeof window.YouTubeGrid.loadPageConfig === 'function') {
        window.YouTubeGrid.loadPageConfig('youtube');
      }
    });
  </script>
</body>
</html>
