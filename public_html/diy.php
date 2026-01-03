<?php
$activePage = 'diy';
$pageTitle = 'DIY w/ Jenni - JenniNexus';
$pageDescription = 'Creative DIY tutorials across fashion, beauty, hair, nails, and self-care from DIY w/ Jenni. Step-by-step guides for all skill levels.';
$pageKeywords = 'game development, music production, DIY crafts, creative content';
$customCSS = ['/resources/css/diy-theme.min.css'];
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<?php include 'includes/head.php'; ?>
<body>

  <?php include 'includes/header.php'; ?>

  <!-- Hero Section -->
  <section class="hero-section py-5 diy-hero text-white">
    <div class="container" >
      <div class="row align-items-center">
        <div class="col-lg-8">
          <div class="glass-panel p-5 rounded-4 shadow-lg">
            <div class="display-4 fw-bold mb-3 hero-title">
              <i class="fa-solid fa-scissors fa-bounce me-3" style="--fa-animation-duration: 2s;"></i>
              <?php $logoVariant = 'diy'; $logoLink = false; include __DIR__ . '/includes/logo.php'; ?>
            </div>
            <p class="lead mb-4 hero-title">
              Creative DIY tutorials across fashion, beauty, hair, nails, and self-care. Step-by-step guides for all skill levels.
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap hero-title">
                  <a href="https://www.youtube.com/@diywjenni?sub_confirmation=1" target="_blank" class="btn btn-youtube btn-lg rounded-pill">
                    <i class="fa-brands fa-youtube"></i>Sub on YouTube
                  </a>
                  <a href="https://discord.gg/pKSyR4A9Tb" target="_blank" class="btn btn-discord btn-lg rounded-pill">
                    <i class="fa-brands fa-discord"></i>Join Discord
                  </a>
                  <a href="https://www.instagram.com/diywjenni" target="_blank" class="btn btn-instagram btn-lg rounded-pill">
                    <i class="fa-brands fa-instagram"></i>Instagram
                  </a>
                  <?php
                  // DIY TikTok button - use diywjenni account from social-stats.json when available
                  $tiktokUrl = 'https://www.tiktok.com/@diywjenni';
                  $statsPath = __DIR__ . '/resources/playlists/social-stats.json';
                  if (file_exists($statsPath)) {
                    $json = json_decode(file_get_contents($statsPath), true);
                    if (!empty($json['tiktok']['accounts']['diywjenni']['url'])) {
                      $tiktokUrl = $json['tiktok']['accounts']['diywjenni']['url'];
                    }
                  }
                  ?>
                  <a href="<?php echo htmlspecialchars($tiktokUrl); ?>" target="_blank" class="btn btn-outline-light btn-lg rounded-pill">
                    <i class="fa-brands fa-tiktok"></i>Tiktok
                  </a>
                </div>
          </div>
        </div>
        <div class="col-lg-4 text-center mt-4 mt-lg-0">
          <div class="display-1">
            <i class="fa-solid fa-wand-magic-sparkles diy-sparkle" style="color: #f093fb;"></i>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Tag Filter Section (DIY Main Tags) -->
  <section class="py-4 section-pastel diy-surface">
    <div class="container">
      <div class="row">
        <div class="col-lg-10 mx-auto">
          <div class="text-center mb-3">
            <h5 class="mb-2">Filter DIY Content</h5>
            <p class="small text-muted mb-3">Click tags to filter tutorials and content</p>
          </div>
          
          <!-- DIY Main Tags -->
          <div class="mb-3">
            <h6 class="small text-muted mb-2 text-center">DIY Categories</h6>
            <div class="d-flex flex-wrap justify-content-center gap-2">
              <button class="badge bg-primary bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="fashion" onclick="window.tagFilter?.toggle('fashion')">
                <i class="fa-solid fa-scissors me-1"></i>Fashion
              </button>
              <button class="badge bg-danger bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="beauty" onclick="window.tagFilter?.toggle('beauty')">
                <i class="fa-solid fa-sparkles me-1"></i>Beauty
              </button>
              <button class="badge bg-success bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="hair" onclick="window.tagFilter?.toggle('hair')">
                <i class="fa-solid fa-scissors me-1"></i>Hair
              </button>
              <button class="badge bg-warning bg-opacity-75 text-dark p-2 border-0" style="cursor: pointer;" data-tag="nails" onclick="window.tagFilter?.toggle('nails')">
                <i class="fa-solid fa-hand me-1"></i>Nails
              </button>
              <button class="badge bg-info bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="self-care" onclick="window.tagFilter?.toggle('self-care')">
                <i class="fa-solid fa-heart me-1"></i>Self-Care
              </button>
              <button class="badge bg-secondary bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="sustainability" onclick="window.tagFilter?.toggle('sustainability')">
                <i class="fa-solid fa-leaf me-1"></i>Sustainable
              </button>
              <button class="badge bg-purple bg-opacity-75 p-2 border-0 text-theme-dark" style="cursor: pointer;" data-tag="tutorials" onclick="window.tagFilter?.toggle('tutorials')">
                <i class="fa-solid fa-book me-1"></i>Tutorials
              </button>
              <button class="badge bg-dark bg-opacity-75 text-white p-2 border-0" style="cursor: pointer;" data-tag="diy-beauty" onclick="window.tagFilter?.toggle('diy-beauty')">
                <i class="fa-solid fa-paintbrush me-1"></i>DIY Beauty
              </button>
            </div>
          </div>
          
          <!-- Advanced Filter Button -->
          <div class="text-center">
            <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#tagFilterOffcanvas">
              <i class="fa-solid fa-filter"></i>Advanced Tag Filters
            </button>
            <div id="activeFiltersContainer" class="d-inline-block ms-3" style="display:none !important;">
              <div id="activeFilters" class="d-flex gap-2 align-items-center flex-wrap"></div>
            </div>
            <button id="clearAllFilters" class="btn btn-outline-secondary btn-sm ms-2" style="display:none;" onclick="if(window.tagFilter && window.tagFilter.clear) { window.tagFilter.clear(); } document.getElementById('clearAllFilters').style.display='none';">
              <i class="fa-solid fa-times-circle"></i> Clear All
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Tag Filter Offcanvas (DIY) -->
  <!-- Tag Filter Offcanvas (DIY) -->
  <?php include 'includes/tag-filter-offcanvas.php'; ?>

  <!-- DIY Categories -->
  <section class="py-5 diy-section-alt">
    <div class="container">
      <h2 class="text-center mb-5 diy-text-gradient">What You'll Learn</h2>
      <div class="row g-4">
        <div class="col-md-4">
            <div class="card diy-category-fashion h-100 text-center content-item hover-lift" data-category="diy" data-tags="diy,fashion,diy-beauty,beauty,sustainable">
            <div class="card-body">
              <div class="diy-category-icon">
                <i class="fa-solid fa-scissors"></i>
              </div>
              <h5 class="card-title">Fashion & Clothing</h5>
              <p>T-shirt cutting, no-sew projects, and sustainable fashion</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
            <div class="card diy-category-beauty h-100 text-center content-item hover-lift" data-category="diy" data-tags="diy,hair,beauty,makeup,diy-hair,diy-hair-color,diy-beauty">
            <div class="card-body">
              <div class="diy-category-icon">
                <i class="fa-solid fa-paintbrush"></i>
              </div>
              <h5 class="card-title">Hair & Beauty</h5>
              <p>Hair styling, coloring techniques, and at-home beauty tips</p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
            <div class="card diy-category-selfcare h-100 text-center content-item hover-lift" data-category="diy" data-tags="diy,self-care,nails,diy-nail-art,beauty,diy-beauty">
            <div class="card-body">
              <div class="diy-category-icon diy-heart">
                <i class="fa-solid fa-heart"></i>
              </div>
              <h5 class="card-title">Self-Care & Nails</h5>
              <p>Nail art, wellness routines, and self-care practices</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- DIY Playlists - Loaded Dynamically -->
  <section id="tutorials" class="py-5 diy-surface">
    <div class="container">
      <!-- Featured DIY Tutorials -->
      <section id="featured-tutorials-section" class="mb-5">
        <h2 class="display-6 text-center mb-4 text-theme-adaptive">Featured Tutorials</h2>
        <div class="row g-4" id="diyPlaylistsContainer">
          <!-- Playlists will be loaded dynamically by youtube-grid.js using diy.yaml -->
          <div class="col-12 text-center py-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading DIY tutorials...</span>
            </div>
          </div>
        </div>
      </section>

      <!-- More DIY Playlists -->
      <section id="more-tutorials-section" class="mb-5">
        <h2 class="display-6 text-center mb-4 text-theme-adaptive">More DIY Playlists</h2>
        <div class="row g-4" id="diySecondaryContainer">
          <!-- Secondary playlists loaded here -->
          <div class="col-12 text-center py-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading more playlists...</span>
            </div>
          </div>
        </div>
        <!-- Show More Button -->
        <div class="text-center mt-4" id="showMorePlaylistsContainer" style="display: none;">
          <button id="showMorePlaylistsBtn" class="btn btn-diy-primary btn-lg">
            <i class="fa-solid fa-chevron-down me-2"></i>Show More Playlists
          </button>
        </div>
      </section>
    </div>
  </section>

  <!-- Featured Shop Section -->
  <section class="py-5 section-pastel diy-surface">
    <div class="container">
      <h2 class="text-center mb-5">
        <i class="bi bi-bag-fill me-2"></i>My Amazon Shop
      </h2>
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
          <p class="lead mb-4">Tools, products, and supplies I use in my DIY projects</p>
          <div class="row g-4 mb-4">
            <div class="col-md-4">
              <a href="https://amzn.to/4hiL9Nw" target="_blank" class="card h-100 text-decoration-none text-body">
                <div class="card-body">
                  <i class="bi bi-tools display-4 text-primary mb-3"></i>
                  <h6>Curated DIY Tools</h6>
                  <p class="text-muted small">Hand-picked tools for projects</p>
                </div>
              </a>
            </div>
            <div class="col-md-4">
              <a href="https://amzn.to/4he1m6u" target="_blank" class="card h-100 text-decoration-none text-body">
                <div class="card-body">
                  <i class="bi bi-palette display-4 text-primary mb-3"></i>
                  <h6>Beauty Products</h6>
                  <p class="text-muted small">Hair care and styling essentials</p>
                </div>
              </a>
            </div>
            <div class="col-md-4">
              <a href="https://amzn.to/3WctRI4" target="_blank" class="card h-100 text-decoration-none text-body">
                <div class="card-body">
                  <i class="bi bi-stars display-4 text-primary mb-3"></i>
                  <h6>Content Creator Supplies</h6>
                  <p class="text-muted small">Tools, lighting, and accessories for creators</p>
                </div>
              </a>
            </div>
          </div>
          <a href="https://www.amazon.com/shop/jenninexus" target="_blank" class="btn btn-warning btn-lg">
            <i class="bi bi-amazon"></i>Visit My Amazon Shop
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Patreon Support -->
  <section class="py-5">
    <div class="container">
      <div class="diy-community-card text-center">
        <h2 class="mb-3 diy-text-gradient">
          <i class="bi bi-heart-fill diy-heart"></i>Support My DIY Journey
        </h2>
        <p class="lead mb-4">
          Get exclusive access to behind-the-scenes content and early tutorials
        </p>
        <div class="row g-3 mb-4">
          <div class="col-sm-6 col-md-3">
            <small>✅ Early access to tutorials</small>
          </div>
          <div class="col-sm-6 col-md-3">
            <small>✅ Behind-the-scenes content</small>
          </div>
          <div class="col-sm-6 col-md-3">
            <small>✅ DIY supply discounts</small>
          </div>
          <div class="col-sm-6 col-md-3">
            <small>✅ Exclusive patterns</small>
          </div>
        </div>
        <a href="patreon.php" class="btn btn-diy-primary btn-lg">
          <i class="bi bi-heart-fill"></i>Become a Patron
        </a>
      </div>
    </div>
  </section>

  <!-- Community CTA -->
  <section class="py-5 section-pastel diy-surface">
    <div class="container text-center">
      <h2 class="mb-4">
        <i class="bi bi-people-fill"></i>Join the DIY Community!
      </h2>
      <p class="lead mb-4">Connect with fellow creators, share your projects, and get inspiration</p>
      <div class="d-flex flex-wrap gap-3 justify-content-center">
        <a href="https://www.youtube.com/@diywjenni?sub_confirmation=1" target="_blank" class="btn btn-youtube">
          <i class="bi bi-youtube"></i>Subscribe on YouTube
        </a>
        <a href="https://discord.gg/pKSyR4A9Tb" target="_blank" class="btn btn-discord">
          <i class="bi bi-discord"></i>Join Discord
        </a>
        <a href="https://www.instagram.com/diywjenni" target="_blank" class="btn btn-instagram">
          <i class="bi bi-instagram"></i>Follow on Instagram
        </a>
      </div>
    </div>
  </section>

  <!-- Latest Videos RSS Feed -->
  <section class="py-5 bg-body diy-surface">
    <div class="container">
      <h2 class="text-center mb-4">
        <i class="fa-solid fa-video"></i> Latest from DIYwJenni
      </h2>
      <div id="diy-latest-videos" class="row g-4">
        <!-- RSS feed videos will be loaded here -->
        <div class="col-12 text-center">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading latest videos...</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- DIY Blog Posts (Moved to Bottom) -->
  <section class="py-5 section-pastel diy-surface">
    <div class="container">
      <h2 class="text-center mb-5 diy-text-gradient">
        <i class="fa-solid fa-pen-to-square"></i>DIY Blog Posts & Articles
      </h2>
      <div class="row g-4" id="diyBlogPostsContainerBottom">
        <!-- Blog posts will be loaded here -->
      </div>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>

  
  <!-- Custom Scripts: Load in correct order (js-yaml → youtube-grid → tag-system) -->
  <!-- js-yaml is already loaded in head.php -->
  <script src="<?= RES_ROOT ?>/js/youtube-grid.js"></script>
  <script src="<?= RES_ROOT ?>/js/tag-system.js"></script>
  <script>
    // Initialize YouTube Grid with diy.yaml configuration
    document.addEventListener('DOMContentLoaded', () => {
      if (window.YouTubeGrid && window.YouTubeGrid.loadPageConfig) {
        window.YouTubeGrid.loadPageConfig('diy');
      }
      
      // Show More Playlists functionality
      // Hide playlists after first 2 rows (8 cards at 4 per row)
      setTimeout(() => {
        const container = document.getElementById('diySecondaryContainer');
        const cards = container.querySelectorAll('.playlist-card-multi, .playlist-card-single');
        const showMoreBtn = document.getElementById('showMorePlaylistsBtn');
        const showMoreContainer = document.getElementById('showMorePlaylistsContainer');
        
        if (cards.length > 8) {
          // Hide cards after the 8th one
          for (let i = 8; i < cards.length; i++) {
            cards[i].style.display = 'none';
            cards[i].classList.add('hidden-playlist');
          }
          
          // Show the button
          if (showMoreContainer) showMoreContainer.style.display = 'block';
          
          // Add click handler
          if (showMoreBtn) {
            showMoreBtn.addEventListener('click', () => {
              const hiddenCards = container.querySelectorAll('.hidden-playlist');
              hiddenCards.forEach(card => {
                card.style.display = '';
                card.classList.remove('hidden-playlist');
              });
              showMoreContainer.style.display = 'none';
            });
          }
        }
      }, 2000); // Wait for playlists to load
    });
  </script>
  
  <!-- Load DIY Latest Videos RSS Feed -->
  <script>
    async function loadDIYLatestVideos() {
      const container = document.getElementById('diy-latest-videos');
      if (!container) return;
      
      try {
        const channelId = 'UCk2SWSg1fvdZGnrN0XAt6NQ'; // DIYwJenni channel
        const cacheKey = `diy_rss_${channelId}`;
        const cacheDuration = 24 * 60 * 60 * 1000; // 24 hours
        
        // Check cache
        const cached = localStorage.getItem(cacheKey);
        const cacheTime = localStorage.getItem(`${cacheKey}_time`);
        if (cached && cacheTime && (Date.now() - parseInt(cacheTime) < cacheDuration)) {
          renderVideos(JSON.parse(cached));
          return;
        }
        
        // Fetch from internal proxy
        const proxyUrl = `<?= RES_ROOT ?>/api/get-youtube.php?channel_id=${channelId}`;
        const response = await fetch(proxyUrl);
        
        if (!response.ok) {
          throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        const data = await response.json();
        
        if (!data.entry || !Array.isArray(data.entry)) {
          throw new Error('Invalid RSS feed format');
        }
        
        // Cache the results
        localStorage.setItem(cacheKey, JSON.stringify(data));
        localStorage.setItem(`${cacheKey}_time`, Date.now().toString());
        
        renderVideos(data);
        
      } catch (error) {
        console.error('Error loading DIY RSS feed:', error);
        container.innerHTML = `
          <div class="col-12 text-center">
            <p class="text-muted">Unable to load latest videos. <a href="https://www.youtube.com/@diywjenni" target="_blank">Visit DIYwJenni on YouTube</a></p>
          </div>
        `;
      }
    }
    
    function renderVideos(data) {
      const container = document.getElementById('diy-latest-videos');
      if (!container || !data.entry) return;
      
      // Limit to 8 videos (2 rows of 4)
      const videos = Array.isArray(data.entry) ? data.entry.slice(0, 8) : [data.entry].slice(0, 8);
      
      // Choose column classes based on number of videos so they expand gracefully
      const n = videos.length;
      let lgClass = 'col-lg-3';
      if (n === 1) lgClass = 'col-lg-12';
      else if (n === 2) lgClass = 'col-lg-6';
      else if (n === 3) lgClass = 'col-lg-4';

      container.innerHTML = videos.map(video => {
        // get-youtube.php adds videoId as a direct child element
        const videoId = video.videoId || video['yt:videoId'] || '';
        const title = video.title || 'Untitled Video';
        // Use thumbnail from get-youtube.php or construct URL
        const thumbnail = video.thumbnail || `https://i.ytimg.com/vi/${videoId}/mqdefault.jpg`;
        const videoUrl = `https://www.youtube.com/watch?v=${videoId}`;
        
        return `
          <div class="col-12 col-sm-6 ${lgClass}">
            <a href="${videoUrl}" target="_blank" class="text-decoration-none">
              <div class="card h-100 border-0 shadow-sm video-card">
                <div class="ratio ratio-16x9">
                  <img src="${thumbnail}" class="card-img-top" alt="${escapeHtml(title)}" loading="lazy">
                </div>
                <div class="card-body p-3">
                  <h6 class="card-title" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" title="${escapeHtml(title)}">
                    ${escapeHtml(title)}
                  </h6>
                  <small class="text-muted">
                    <i class="fa-brands fa-youtube"></i> DIYwJenni
                  </small>
                </div>
              </div>
            </a>
          </div>
        `;
      }).join('');
    }
    
    function escapeHtml(str) {
      return String(str || '').replace(/[&<>"'`]/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','`':'&#96;'})[s]);
    }
    
    // Load RSS feed on page load
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', loadDIYLatestVideos);
    } else {
      loadDIYLatestVideos();
    }
  </script>
  
  <!-- Load DIY Blog Posts -->
  <script>
    async function loadDIYBlogPosts() {
      try {
        const res = await fetch('<?= RES_ROOT ?>/playlists/blog-posts.yaml');
        const txt = await res.text();
        const parsed = jsyaml.load(txt);
        const allPosts = Array.isArray(parsed) ? parsed : [];
        
        // Filter for DIY-related tags
        const diyTags = ['diy', 'beauty', 'fashion', 'hair', 'nails', 'nail-art', 'self-care', 'sustainability', 'makeup', 'diy-beauty'];
        const diyPosts = allPosts.filter(post => 
          post.tags && post.tags.some(tag => diyTags.includes(String(tag).toLowerCase().trim()))
        );
        
        const container = document.getElementById('diyBlogPostsContainerBottom');
        if (!container || diyPosts.length === 0) {
          if (container) container.innerHTML = '<p class="text-center text-muted">No DIY blog posts yet. Check back soon!</p>';
          return;
        }
        
        container.innerHTML = diyPosts.map(post => {
          const tagAttr = (post.tags || []).join(',');
          const tagBadges = (post.tags || []).slice(0, 3).map(tag => 
            `<span class="badge glass-badge me-1">${escapeHtml(tag)}</span>`
          ).join('');
          
          // Build image path relative to RES_ROOT
          let imgSrc = '';
          if (post.image) {
            if (post.image.startsWith('/images')) {
              imgSrc = window.RES_ROOT + post.image;
            } else if (post.image.startsWith('/')) {
              imgSrc = window.RES_ROOT + '/images' + post.image;
            } else {
              imgSrc = window.RES_ROOT + '/images/' + post.image.replace(/^\//, '');
            }
          }
          
          return `
            <div class="col-md-6 col-lg-4">
              <article class="card h-100 border-0 shadow-sm glass-panel hover-lift blog-post-card content-item" data-tags="${escapeHtml(tagAttr)}">
                ${post.image ? `<img src="${imgSrc}" class="card-img-top" alt="${escapeHtml(post.title)}" style="max-height: 200px; object-fit: cover;">` : ''}
                <div class="card-body p-4">
                  <div class="mb-3">
                    <span class="badge glass-badge">Blog Post</span>
                    <small class="text-muted ms-2">${new Date(post.date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</small>
                  </div>
                  <h3 class="h5 card-title mb-3">${escapeHtml(post.title)}</h3>
                  <p class="card-text text-muted">${escapeHtml(post.excerpt)}</p>
                  <div class="mb-3 d-flex flex-wrap gap-1">
                    ${tagBadges}
                  </div>
                  <a href="/blog/${encodeURIComponent(post.slug)}.php" class="btn btn-outline-primary">
                    Read More <i class="fa-solid fa-arrow-right ms-2"></i>
                  </a>
                </div>
              </article>
            </div>
          `;
        }).join('');
        
      } catch (err) {
        console.error('Failed to load DIY blog posts', err);
        const container = document.getElementById('diyBlogPostsContainerBottom');
        if (container) container.innerHTML = '<p class="text-center text-muted">Failed to load blog posts.</p>';
      }
    }
    
    function escapeHtml(str) {
      return String(str || '').replace(/[&<>"'`]/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','`':'&#96;'})[s]);
    }
    
    // Load blog posts when DOM is ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', loadDIYBlogPosts);
    } else {
      loadDIYBlogPosts();
    }
  </script>
</body>
</html>
