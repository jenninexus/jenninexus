<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  // Page opts into Facebook SDK because we render a FB embed on this page
  $needsFb = true;
  $pageUrl = 'https://jenninexus.com/ai.php';
  $pageImage = 'https://jenninexus.com/resources/blog posts/ai/robo-jenni_3.jpg';
  $customCSS = [RES_ROOT . '/css/media' . ($assetSuffix ?? '') . '.css'];
  include __DIR__ . '/includes/head.php';
  ?>
  
  <title>AI Tools & Research | JenniNexus - Technical Art & Game Dev AI</title>
  <meta name="description" content="Explore AI tools, technical art, and AI research in game development. Learn about cutting-edge AI technologies for creative workflows.">
  <meta name="keywords" content="AI tools, technical art, AI research, game development, machine learning, AI in games">
  
  <!-- Schema.org structured data for SEO -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "AI Tools & Research",
    "description": "Explore AI tools, technical art, and research in game development.",
    "url": "https://jenninexus.com/ai.php",
    "image": "https://jenninexus.com/resources/images/ai/robo-jenni_3.jpg",
    "breadcrumb": {
      "@type": "BreadcrumbList",
      "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "Home",
        "item": "https://jenninexus.com"
      }, {
        "@type": "ListItem",
        "position": 2,
        "name": "AI Tools & Research"
      }]
    }
  }
  </script>
  
  <style>
    .ai-gradient {
      background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
    }
    
    /* Scroll animations */
    .animate-on-scroll {
      opacity: 0;
      transform: translateY(30px);
      transition: all 0.6s ease;
    }
    .animate-on-scroll.visible {
      opacity: 1;
      transform: translateY(0);
    }
  </style>
</head>

<body>
  <?php include 'includes/header.php'; ?>

  <main>
    <div class="container-fluid px-0">
      <!-- Hero Section -->
      <section class="py-5 ai-gradient text-white">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-8">
              <!-- Breadcrumb -->
              <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php" class="text-white text-decoration-none">Home</a></li>
                  <li class="breadcrumb-item active text-white" aria-current="page">AI Tools & Research</li>
                </ol>
              </nav>
              
              <h1 class="display-3 mb-4" style="font-size: clamp(2.5rem, 6vw, 4.5rem);">
                <i class="fa-solid fa-microchip me-2"></i> AI Tools & Research
              </h1>
              <p class="lead mb-4">Explore cutting-edge AI technologies for technical art, game development, and creative workflows. Stay updated with the latest AI tools and research.</p>
              
              <div class="d-flex gap-3 mb-4 flex-wrap align-items-center">
                <span class="badge bg-dark fs-6">
                  <i class="fa-solid fa-flask me-1"></i>AI Research
                </span>
                <span class="badge bg-dark fs-6">
                  <i class="fa-solid fa-palette me-1"></i>Technical Art
                </span>
                <span class="badge bg-dark fs-6">
                  <i class="fa-solid fa-gamepad me-1"></i>Game Dev AI
                </span>
              </div>
              
              <!-- Hero CTA Buttons -->
              <div class="d-flex gap-3 flex-wrap mt-4">
                <a href="#ai-content" class="btn btn-outline-light btn-lg">
                  <i class="fa-solid fa-circle-play me-2"></i>Watch Playlists
                </a>
                <a href="tags.php?tag=ai" class="btn btn-outline-light btn-lg">
                  <i class="fa-solid fa-tags me-2"></i>View All AI Posts
                </a>
              </div>
            </div>
            
            <div class="col-lg-4 text-center">
              <i class="fa-solid fa-robot" style="font-size: 12rem; opacity: 0.8;"></i>
            </div>
          </div>
        </div>
      </section>

      <!-- Overview Section -->
      <section class="py-5 bg-dark text-white animate-on-scroll">
        <div class="container">
          <div class="row">
            <div class="col-lg-10 mx-auto">
              <h2 class="text-center mb-5">
                <i class="fa-solid fa-lightbulb text-warning me-2"></i> What is AI in Game Development?
              </h2>
              
              <div class="row g-4">
                <div class="col-md-4">
                  <div class="glass-card hover-lift h-100 border-0 p-4">
                    <div class="text-center mb-3">
                      <i class="fa-solid fa-palette" style="font-size: 3rem; color: #8b5cf6;"></i>
                    </div>
                    <h4 class="text-white text-center">Technical Art</h4>
                    <p class="text-white-50 text-center">AI-powered tools for creating stunning game assets, procedural generation, and automated workflows.</p>
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="glass-card hover-lift h-100 border-0 p-4">
                    <div class="text-center mb-3">
                      <i class="fa-solid fa-chart-line" style="font-size: 3rem; color: #ec4899;"></i>
                    </div>
                    <h4 class="text-white text-center">AI Research</h4>
                    <p class="text-white-50 text-center">Latest research in machine learning, neural networks, and AI applications in creative industries.</p>
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="glass-card hover-lift h-100 border-0 p-4">
                    <div class="text-center mb-3">
                      <i class="fa-solid fa-gears" style="font-size: 3rem; color: #6366f1;"></i>
                    </div>
                    <h4 class="text-white text-center">Tool Integration</h4>
                    <p class="text-white-50 text-center">Integrating AI tools into Unity, Unreal Engine, Blender, and other game development pipelines.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Featured AI Tools & Tutorials -->
      <section id="ai-content" class="py-5 bg-dark-subtle animate-on-scroll">
        <div class="container">
          <h2 class="text-white text-center mb-5">
            <i class="fa-solid fa-circle-play text-danger me-2"></i> AI Content & Learning
          </h2>
          
          <!-- YouTube Grid Container -->
          <div id="ai-playlists" class="row g-4"></div>
        </div>
      </section>

      <!-- AI Tools Categories -->
      <section class="py-5 bg-dark text-white animate-on-scroll">
        <div class="container">
          <h2 class="text-center mb-5">
            <i class="fa-solid fa-layer-group me-2"></i> AI Tool Categories
          </h2>
          
          <div class="row g-4">
            <div class="col-md-6 col-lg-3">
              <a href="tags.php?tag=ai" class="text-decoration-none">
                <div class="glass-card hover-lift h-100 border-0 p-4 text-center">
                  <i class="fa-solid fa-image mb-3" style="font-size: 2.5rem; color: #8b5cf6;"></i>
                  <h5 class="text-white">Image Generation</h5>
                  <p class="text-white-50 small mb-0">Stable Diffusion, Midjourney, DALL-E for game assets</p>
                </div>
              </a>
            </div>
            
            <div class="col-md-6 col-lg-3">
              <a href="tags.php?tag=technical-art" class="text-decoration-none">
                <div class="glass-card hover-lift h-100 border-0 p-4 text-center">
                  <i class="fa-solid fa-cube mb-3" style="font-size: 2.5rem; color: #ec4899;"></i>
                  <h5 class="text-white">3D Generation</h5>
                  <p class="text-white-50 small mb-0">AI-powered 3D modeling and procedural generation</p>
                </div>
              </a>
            </div>
            
            <div class="col-md-6 col-lg-3">
              <a href="tags.php?tag=gamedev" class="text-decoration-none">
                <div class="glass-card hover-lift h-100 border-0 p-4 text-center">
                  <i class="fa-solid fa-comments mb-3" style="font-size: 2.5rem; color: #6366f1;"></i>
                  <h5 class="text-white">NPCs & Dialogue</h5>
                  <p class="text-white-50 small mb-0">AI-driven NPCs and dynamic dialogue systems</p>
                </div>
              </a>
            </div>
            
            <div class="col-md-6 col-lg-3">
              <a href="tags.php?tag=music" class="text-decoration-none">
                <div class="glass-card hover-lift h-100 border-0 p-4 text-center">
                  <i class="fa-solid fa-music mb-3" style="font-size: 2.5rem; color: #10b981;"></i>
                  <h5 class="text-white">Audio & Music</h5>
                  <p class="text-white-50 small mb-0">AI music generation and procedural audio</p>
                </div>
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- Resources -->
      <section class="py-5 bg-secondary bg-gradient text-white animate-on-scroll">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <h2 class="text-center mb-5">
                <i class="fa-solid fa-book me-2"></i> Learning Resources
              </h2>
              
              <div class="glass-card border-0 shadow-lg">
                <div class="card-body p-4">
                  <h4 class="mb-4">Stay Updated</h4>
                  <p class="lead mb-4">Follow along for the latest AI tools, tutorials, and research in game development!</p>
                  
                  <div class="d-flex gap-3 flex-wrap">
                    <a href="https://youtube.com/playlist?list=PL9QBjNDhgNwQygOzxOAYImp0L3zC6pBO2" 
                       class="btn btn-lg btn-danger" 
                       target="_blank" 
                       rel="noopener">
                      <i class="fa-brands fa-youtube me-2"></i>AI Tools Playlist
                    </a>
                    <!-- Link to AI tag view (uses tag filter) -->
                    <a href="tags.php?tag=ai" class="btn btn-lg btn-outline-info">
                      <i class="fa-solid fa-tags me-2"></i>See all AI posts
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- AI Blog Posts -->
      <section class="py-5 bg-body-secondary animate-on-scroll">
        <div class="container">
          <h2 class="text-center mb-5">
            <i class="fa-solid fa-pen-to-square me-2"></i>AI Blog Posts
          </h2>
          <div class="row g-4" id="aiBlogPostsContainer">
            <!-- Blog posts will be loaded here -->
          </div>
        </div>
      </section>
    </div>
  </main>

  <?php include 'includes/footer.php'; ?>

  <!-- Load AI Blog Posts -->
  <script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
  <script src="<?= RES_ROOT ?>/js/youtube-grid.js"></script>
  <script>
    // Initialize YouTube Grid
    document.addEventListener('DOMContentLoaded', () => {
      if (window.YouTubeGrid && window.YouTubeGrid.loadPageConfig) {
        window.YouTubeGrid.loadPageConfig('ai');
      }
    });

    async function loadAIBlogPosts() {
      try {
        const res = await fetch('<?= RES_ROOT ?>/playlists/blog-posts.yaml');
        const txt = await res.text();
        const parsed = jsyaml.load(txt);
        const allPosts = Array.isArray(parsed) ? parsed : [];
        
        // Filter for AI-related tags
        const aiPosts = allPosts.filter(post => {
          const tags = post.tags || [];
          return tags.some(t => ['ai', 'technical-art', 'productivity', 'tools'].includes(t.toLowerCase()));
        });

        const container = document.getElementById('aiBlogPostsContainer');
        if (!container) return;

        if (aiPosts.length === 0) {
          container.innerHTML = '<p class="text-center text-muted">No AI blog posts yet. Check back soon!</p>';
          return;
        }

        container.innerHTML = aiPosts.map(post => {
          const slug = post.slug || '';
          const title = post.title || 'Untitled';
          const excerpt = post.excerpt || '';
          const image = post.image ? `<?= RES_ROOT ?>/images${post.image}` : '';
          const date = post.date || '';
          const category = post.category || 'Blog';

          return `
            <div class="col-md-6 col-lg-4">
              <div class="card h-100 border-0 shadow-sm">
                ${image ? `<img src="${escapeHtml(image)}" class="card-img-top" alt="${escapeHtml(title)}" loading="lazy">` : ''}
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title">
                    <a href="blog/${escapeHtml(slug)}.php" class="text-decoration-none stretched-link">${escapeHtml(title)}</a>
                  </h5>
                  <div class="mb-2">
                    <span class="badge bg-primary">${escapeHtml(category)}</span>
                    <small class="text-muted ms-2">${new Date(date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</small>
                  </div>
                  <p class="card-text text-muted">${escapeHtml(excerpt)}</p>
                </div>
              </div>
            </div>
          `;
        }).join('');

      } catch (err) {
        console.error('Failed to load AI blog posts:', err);
        const container = document.getElementById('aiBlogPostsContainer');
        if (container) container.innerHTML = '<p class="text-center text-muted">Failed to load blog posts.</p>';
      }
    }
    
    function escapeHtml(str) {
      return String(str || '').replace(/[&<>"'`]/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','`':'&#96;'})[s]);
    }
    
    // Load blog posts when DOM is ready
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', loadAIBlogPosts);
    } else {
      loadAIBlogPosts();
    }
    
    // Smooth scroll for anchor links
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
          }
        });
      });
      
      // Scroll animation observer
      const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      };
      
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
          }
        });
      }, observerOptions);
      
      document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
      });
    });
  </script>
</body>

</html>
