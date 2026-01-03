<?php
$activePage = 'blog';
$pageTitle = 'Blog - JenniNexus';
$pageDescription = 'JenniNexus - Game Dev, Music, DIY, and Creative Content';
$pageKeywords = 'game development, music production, DIY crafts, creative content';
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
<?php include __DIR__ . '/includes/head.php'; ?>
<body>
  
  <?php include __DIR__ . '/includes/header.php'; ?>

  <!-- Hero -->
  <section class="hero-section py-5" style="background: linear-gradient(135deg, var(--jenni-primary), var(--jenni-secondary)); min-height: 40vh;">
    <div class="container" >
      <div class="row align-items-center" style="min-height: 30vh;">
        <div class="col-lg-8 mx-auto text-center text-white">
          <div class="glass-panel p-5 rounded-4 shadow-lg">
            <i class="fa-solid fa-pen-to-square fa-beat-fade display-1 mb-4 hero-title" style="--fa-animation-duration: 3s;"></i>
            <h1 class="display-2 mb-4 hero-title">Blog</h1>
            <p class="lead hero-title">Insights on game development, DIY projects, voice acting, and creative tech</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Blog Posts -->
  <section class="py-5">
    <div class="container">
      <div class="glass-panel p-4 rounded-4 shadow-sm">
      <!-- Tag Filter Section -->
      <div class="row mb-4">
        <div class="col-lg-10 mx-auto">
          <div class="text-center mb-3">
            <h5 class="mb-2">Filter Blog Posts</h5>
            <p class="small text-muted mb-3">Click tags to filter posts by topic</p>
          </div>
          
          <!-- Category Tags -->
          <div class="mb-3">
            <div class="d-flex flex-wrap justify-content-center gap-2">
              <button class="badge bg-primary bg-opacity-75 text-white p-2 border-0 btn-outline-primary" style="cursor: pointer;" data-tag="gamedev">
                <i class="fa-solid fa-code me-1"></i>Game Dev
              </button>
              <button class="badge bg-danger bg-opacity-75 text-white p-2 border-0 btn-outline-primary" style="cursor: pointer;" data-tag="gaming">
                <i class="fa-solid fa-gamepad me-1"></i>Gaming
              </button>
              <button class="badge bg-warning bg-opacity-75 text-dark p-2 border-0 btn-outline-primary" style="cursor: pointer;" data-tag="diy">
                <i class="fa-solid fa-scissors me-1"></i>DIY
              </button>
              <button class="badge bg-info bg-opacity-75 text-white p-2 border-0 btn-outline-primary" style="cursor: pointer;" data-tag="ai">
                <i class="fa-solid fa-robot me-1"></i>AI
              </button>
              <button class="badge bg-success bg-opacity-75 text-white p-2 border-0 btn-outline-primary" style="cursor: pointer;" data-tag="voice-acting">
                <i class="fa-solid fa-microphone me-1"></i>Voice Acting
              </button>
              <button class="badge bg-secondary bg-opacity-75 text-white p-2 border-0 btn-outline-primary" style="cursor: pointer;" data-tag="tutorial">
                <i class="fa-solid fa-book me-1"></i>Tutorials
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
      
      <div class="row g-4" id="blog-posts">
        <!-- Posts will be loaded here -->
      </div>
      </div><!-- /.glass-panel -->
    </div>
  </section>

  <!-- Tag Filter Offcanvas -->
  <?php include 'includes/tag-filter-offcanvas.php'; ?>

  <?php include 'includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
  <script src="<?= RES_ROOT ?>/js/tag-system.js"></script>
    <script>
    // Load blog posts from YAML so we can manage posts in one place.
    const container = document.getElementById('blog-posts');

    async function loadAndRenderPosts(filter = 'all') {
      try {
        const res = await fetch('<?= RES_ROOT ?>/playlists/blog-posts.yaml');
        const txt = await res.text();
        const parsed = jsyaml.load(txt);
        const blogPosts = Array.isArray(parsed) ? parsed : [];

        // Sort posts by date (newest first)
        blogPosts.sort((a, b) => {
          const dateA = new Date(a.date || '1970-01-01');
          const dateB = new Date(b.date || '1970-01-01');
          return dateB - dateA; // Descending order (newest first)
        });

        // Load tags.json once so we can resolve friendly tag names -> slugs
        let tagsIndex = [];
        try {
          const tRes = await fetch((window.RES_ROOT || '<?= RES_ROOT ?>') + '/playlists/tags.json');
          if (tRes.ok) tagsIndex = await tRes.json();
        } catch (e) { /* ignore - we'll fallback to simple slugify */ }

        const nameToSlug = {};
        const slugSet = {};
        if (Array.isArray(tagsIndex)) {
          tagsIndex.forEach(t => {
            if (t && t.slug) {
              slugSet[t.slug.toLowerCase()] = t.slug;
            }
            if (t && t.name) {
              nameToSlug[t.name.toLowerCase()] = t.slug || t.name.toLowerCase().replace(/\s+/g,'-');
            }
          });
        }

        function resolveTagSlug(tagText) {
          if (!tagText) return '';
          const t = String(tagText).trim();
          const lower = t.toLowerCase();
          if (slugSet[lower]) return slugSet[lower];
          if (nameToSlug[lower]) return nameToSlug[lower];
          return lower.replace(/\s+/g, '-');
        }

        function renderPosts(posts, filterTag = 'all') {
          container.innerHTML = '';

          // Ensure each post has normalized slug tags for reliable filtering
          posts.forEach(post => {
            const rawTags = (post.tags || []).map(t => String(t || '').trim()).filter(Boolean);
            post._tagSlugs = rawTags.map(t => resolveTagSlug(t));
            post._tagDisplay = rawTags; // preserve display names in same order
          });

          const filtered = filterTag === 'all' ? posts : posts.filter(post => (post._tagSlugs || []).some(s => s === filterTag || (s || '').includes(filterTag)));

          filtered.forEach(post => {
            const col = document.createElement('div');
            col.className = 'col-md-6 col-lg-4 content-item';
            const tagAttr = (post._tagSlugs || []).join(',');
            col.dataset.tags = tagAttr;

            // Truncate excerpt to 150 characters
            const excerpt = post.excerpt || '';
            const truncatedExcerpt = excerpt.length > 150 ? excerpt.substring(0, 150) + '...' : excerpt;

            col.innerHTML = `
              <article class="card h-100 border-0 shadow-sm blog-post-card" style="overflow: hidden;">
                <div class="card-body p-4 d-flex flex-column">
                  <div class="mb-3">
                    <span class="badge bg-primary">${escapeHtml(post.category || '')}</span>
                    <small class="text-muted ms-2">${new Date(post.date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })}</small>
                  </div>
                  <h3 class="h5 card-title mb-3">${escapeHtml(post.title || '')}</h3>
                  <p class="card-text text-muted mb-3">${escapeHtml(truncatedExcerpt)}</p>
                  <div class="mt-auto">
                    <div class="mb-3 d-flex flex-wrap gap-1 tag-badges"></div>
                    <a href="/blog/${encodeURIComponent(post.slug)}.php" class="btn btn-sm btn-outline-primary">
                      Read More <i class="fa-solid fa-arrow-right ms-2"></i>
                    </a>
                  </div>
                </div>
              </article>
            `;

            // Build badges element using normalized slugs for href/data-tag and original display names
            const badges = (post._tagSlugs || []).slice(0,3).map((slug, i) => {
              const disp = (post._tagDisplay && post._tagDisplay[i]) ? post._tagDisplay[i] : slug;
              return `<a href="/tag/index.php?slug=${encodeURIComponent(slug)}" class="badge bg-secondary text-decoration-none me-1" data-tag="${escapeHtml(slug)}">${escapeHtml(disp)}</a>`;
            }).join('');
            const badgeContainer = col.querySelector('.tag-badges');
            if (badgeContainer) badgeContainer.innerHTML = badges;

            // Image: build path relative to RES_ROOT. Many blog images are stored under /images/blog
            // Use 16:9 ratio container for consistent display
            if (post.image) {
              let src = '';
              if (post.image.startsWith('/')) {
                // If the path already begins with /images use it, otherwise assume it's relative to /images
                if (post.image.startsWith('/images')) {
                  src = window.RES_ROOT + post.image;
                } else {
                  src = window.RES_ROOT + '/images' + post.image;
                }
              } else {
                // no leading slash: treat as relative to /images
                src = window.RES_ROOT + '/images/' + post.image.replace(/^\//, '');
              }
              
              const imgContainer = document.createElement('div');
              imgContainer.className = 'ratio ratio-16x9 mb-3';
              const img = document.createElement('img');
              img.className = 'card-img-top rounded';
              img.alt = post.title || '';
              img.style.objectFit = 'cover';
              img.src = src;
              imgContainer.appendChild(img);
              col.querySelector('.card-body').insertBefore(imgContainer, col.querySelector('.card-body').firstChild);
            }

            container.appendChild(col);
          });
        }

        // expose function for reuse
        window.renderBlogPosts = (filterTag='all') => renderPosts(blogPosts, filterTag);

        // initial render
        renderPosts(blogPosts, filter);

        // wire up top filter buttons
        document.querySelectorAll('[data-tag]').forEach(btn => {
          btn.addEventListener('click', () => {
            document.querySelectorAll('[data-tag]').forEach(b => {
              b.classList.remove('active', 'btn-primary');
              b.classList.add('btn-outline-primary');
            });
            btn.classList.remove('btn-outline-primary');
            btn.classList.add('active', 'btn-primary');
            renderPosts(blogPosts, btn.dataset.tag);

            // Re-run UI initializers so dynamically loaded content gets interactions and animations
            if (window.mgInitUiEffects) {
              window.mgInitUiEffects();
            }
          });
        });

      } catch (err) {
        console.error('Failed to load blog posts YAML', err);
      }
    }

    function escapeHtml(str) {
      return String(str || '').replace(/[&<>\"'`]/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','\"':'&quot;',"'":'&#39;','`':'&#96;'})[s]);
    }

    // Start
    document.addEventListener('DOMContentLoaded', () => loadAndRenderPosts('all'));
  </script>
</body>
</html>
