<?php
$activePage = 'ui-showcase';
$pageTitle = 'UI Showcase - Interactive Features | JenniNexus';
$pageDescription = 'Demonstration of enhanced UI effects, glass panels, and interactive features.';
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
<?php include 'includes/head.php'; ?>
<body>
  
  <?php include 'includes/header.php'; ?>

  <!-- Hero Section -->
  <section class="hero-section py-5" style="background: linear-gradient(135deg, var(--jenni-primary), var(--jenni-secondary)); min-height: 40vh;">
    <div class="container">
      <div class="row align-items-center" style="min-height: 30vh;">
        <div class="col-lg-8 mx-auto text-center text-white">
          <div class="glass-panel p-5 rounded-4 shadow-lg">
            <i class="fa-solid fa-wand-magic-sparkles svg-spin display-1 mb-4 hero-title" style="--fa-animation-duration: 3s;"></i>
            <h1 class="display-2 mb-4 hero-title">UI Showcase</h1>
            <p class="lead hero-title">Interactive Features & Glass Panel System</p>
            <div class="mt-4 hero-title">
              <button class="btn btn-outline-light btn-lg me-3" data-copy="https://jenninexus.com/ui-showcase">
                <i class="fa-solid fa-copy me-2"></i>Copy Page URL
              </button>
              <button class="btn btn-outline-light btn-lg" onclick="window.scrollTo({top: 300, behavior: 'smooth'})">
                <i class="fa-solid fa-arrow-down svg-bounce me-2"></i>Explore Features
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Glass Panel Showcase -->
  <section class="py-5">
    <div class="container">
      <div class="row mb-5">
        <div class="col-lg-10 mx-auto">
          <h2 class="text-center mb-4">
            <i class="fa-solid fa-layer-group me-2"></i>Glass Panel System
          </h2>
          <p class="text-center text-muted mb-5">Different glass effects for various UI components</p>
          
          <div class="row g-4">
            <!-- Standard Glass Card -->
            <div class="col-md-4">
              <div class="glass-card p-4 hover-lift">
                <i class="fa-solid fa-gem svg-2xl text-primary mb-3"></i>
                <h5>Glass Card</h5>
                <p class="text-muted small mb-3">Standard glass panel with hover effects</p>
                <button class="btn btn-outline-primary btn-sm" data-copy="glass-card">
                  <i class="fa-solid fa-copy me-1"></i>Copy Class
                </button>
              </div>
            </div>

            <!-- Glass Badge -->
            <div class="col-md-4">
              <div class="card border-0 shadow-sm p-4 hover-lift">
                <h5 class="mb-3">Glass Badges</h5>
                <div class="d-flex flex-wrap gap-2">
                  <span class="glass-badge">Featured</span>
                  <span class="glass-badge">New</span>
                  <span class="glass-badge">Popular</span>
                </div>
                <p class="text-muted small mt-3">Theme-adaptive glass badges</p>
              </div>
            </div>

            <!-- Glass Shimmer Effect -->
            <div class="col-md-4">
              <div class="glass-shimmer glass-medium p-4 rounded-3 hover-lift">
                <i class="fa-solid fa-sparkles svg-2xl text-warning mb-3"></i>
                <h5>Glass Shimmer</h5>
                <p class="text-muted small mb-0">Animated shimmer overlay effect</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Interactive Features -->
  <section class="py-5 bg-theme-adaptive">
    <div class="container">
      <div class="row mb-5">
        <div class="col-lg-10 mx-auto">
          <h2 class="text-center mb-4">
            <i class="fa-solid fa-hand-pointer me-2"></i>Interactive Features
          </h2>
          
          <div class="row g-4">
            <!-- Stat Counters -->
            <div class="col-md-6">
              <div class="card border-0 shadow-sm p-4 interactive-card" tabindex="0">
                <h5 class="mb-4">Animated Stat Counters</h5>
                <div class="row text-center">
                  <div class="col-4">
                    <h3 class="text-primary"><span class="stat-number" data-target="150">0</span>+</h3>
                    <small class="text-muted">Videos</small>
                  </div>
                  <div class="col-4">
                    <h3 class="text-success"><span class="stat-number" data-target="5000">0</span>+</h3>
                    <small class="text-muted">Followers</small>
                  </div>
                  <div class="col-4">
                    <h3 class="text-warning"><span class="stat-number" data-target="25">0</span>+</h3>
                    <small class="text-muted">Projects</small>
                  </div>
                </div>
              </div>
            </div>

            <!-- Copy to Clipboard Demo -->
            <div class="col-md-6">
              <div class="card border-0 shadow-sm p-4 interactive-card" tabindex="0">
                <h5 class="mb-4">Copy to Clipboard</h5>
                <div class="d-grid gap-2">
                  <button class="btn btn-outline-primary" data-copy="jenninexus@gmail.com">
                    <i class="fa-solid fa-envelope me-2"></i>Copy Email
                  </button>
                  <button class="btn btn-outline-secondary" data-copy="https://discord.gg/KYPh7Cp">
                    <i class="fa-brands fa-discord me-2"></i>Copy Discord Link
                  </button>
                  <button class="btn btn-outline-success" data-copy="npm install ui-effects">
                    <i class="fa-solid fa-terminal me-2"></i>Copy Command
                  </button>
                </div>
              </div>
            </div>

            <!-- Hover Lift Variants -->
            <div class="col-md-4">
              <div class="card border-0 shadow-sm p-4 text-center hover-lift-sm">
                <i class="fa-solid fa-feather svg-2xl text-info mb-3"></i>
                <h6>Small Lift</h6>
                <small class="text-muted">hover-lift-sm</small>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card border-0 shadow-sm p-4 text-center hover-lift">
                <i class="fa-solid fa-rocket svg-2xl text-primary mb-3"></i>
                <h6>Standard Lift</h6>
                <small class="text-muted">hover-lift</small>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card border-0 shadow-sm p-4 text-center hover-lift-lg">
                <i class="fa-solid fa-star svg-2xl text-warning mb-3"></i>
                <h6>Large Lift</h6>
                <small class="text-muted">hover-lift-lg</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Social Media Cards with Copy URLs -->
  <section class="py-5">
    <div class="container">
      <div class="row mb-5">
        <div class="col-lg-10 mx-auto">
          <h2 class="text-center mb-4">
            <i class="fa-solid fa-share-nodes me-2"></i>Enhanced Social Cards
          </h2>
          <p class="text-center text-muted mb-5">Hover to reveal copy buttons</p>
          
          <div class="row g-4">
            <div class="col-md-4">
              <div class="social-card card border-0 shadow-sm hover-lift">
                <div class="card-body p-4 text-center">
                  <i class="fa-brands fa-youtube text-danger fs-1 mb-3"></i>
                  <h6>YouTube Channel</h6>
                  <p class="text-muted small mb-0">JenniNexus</p>
                  <button class="copy-url" data-copy="https://youtube.com/@jenninexus">
                    <i class="fa-solid fa-copy"></i>
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="social-card card border-0 shadow-sm hover-lift">
                <div class="card-body p-4 text-center">
                  <i class="fa-brands fa-discord text-primary fs-1 mb-3"></i>
                  <h6>Discord Server</h6>
                  <p class="text-muted small mb-0">Community</p>
                  <button class="copy-url" data-copy="https://discord.gg/KYPh7Cp">
                    <i class="fa-solid fa-copy"></i>
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="social-card card border-0 shadow-sm hover-lift">
                <div class="card-body p-4 text-center">
                  <i class="fa-brands fa-github fs-1 mb-3"></i>
                  <h6>GitHub Profile</h6>
                  <p class="text-muted small mb-0">Open Source</p>
                  <button class="copy-url" data-copy="https://github.com/jenninexus">
                    <i class="fa-solid fa-copy"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- SVG Animation Showcase -->
  <section class="py-5 bg-theme-adaptive">
    <div class="container">
      <div class="row mb-5">
        <div class="col-lg-10 mx-auto">
          <h2 class="text-center mb-4">
            <i class="fa-solid fa-play svg-pulse me-2"></i>SVG Animation System
          </h2>
          
          <div class="row g-4 text-center">
            <div class="col-md-2 col-sm-4">
              <div class="card border-0 shadow-sm p-3">
                <i class="fa-solid fa-cog svg-spin svg-2xl text-primary mb-2"></i>
                <small>svg-spin</small>
              </div>
            </div>
            <div class="col-md-2 col-sm-4">
              <div class="card border-0 shadow-sm p-3">
                <i class="fa-solid fa-heart svg-beat svg-2xl text-danger mb-2"></i>
                <small>svg-beat</small>
              </div>
            </div>
            <div class="col-md-2 col-sm-4">
              <div class="card border-0 shadow-sm p-3">
                <i class="fa-solid fa-star svg-pulse svg-2xl text-warning mb-2"></i>
                <small>svg-pulse</small>
              </div>
            </div>
            <div class="col-md-2 col-sm-4">
              <div class="card border-0 shadow-sm p-3">
                <i class="fa-solid fa-gem svg-bounce svg-2xl text-info mb-2"></i>
                <small>svg-bounce</small>
              </div>
            </div>
            <div class="col-md-2 col-sm-4">
              <div class="card border-0 shadow-sm p-3">
                <i class="fa-solid fa-bell svg-shake svg-2xl text-success mb-2"></i>
                <small>svg-shake</small>
              </div>
            </div>
            <div class="col-md-2 col-sm-4">
              <div class="card border-0 shadow-sm p-3">
                <i class="fa-solid fa-moon svg-fade svg-2xl text-secondary mb-2"></i>
                <small>svg-fade</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Implementation Guide -->
  <section class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-10 mx-auto">
          <div class="glass-card p-5">
            <h3 class="mb-4">
              <i class="fa-solid fa-code me-2"></i>Implementation Guide
            </h3>
            
            <div class="row g-4">
              <div class="col-md-6">
                <h5>Glass Panels</h5>
                <ul class="list-unstyled">
                  <li class="mb-2"><code>.glass-card</code> - Content blocks</li>
                  <li class="mb-2"><code>.glass-badge</code> - Tags & pills</li>
                  <li class="mb-2"><code>.glass-navbar</code> - Navigation bars</li>
                  <li class="mb-2"><code>.glass-modal</code> - Modal dialogs</li>
                  <li class="mb-2"><code>.glass-shimmer</code> - Animated effect</li>
                </ul>
              </div>

              <div class="col-md-6">
                <h5>Interactive Features</h5>
                <ul class="list-unstyled">
                  <li class="mb-2"><code>data-copy=""</code> - Copy to clipboard</li>
                  <li class="mb-2"><code>data-target=""</code> - Animated counters</li>
                  <li class="mb-2"><code>.hover-lift</code> - 3D hover effects</li>
                  <li class="mb-2"><code>.svg-*</code> - Icon animations</li>
                  <li class="mb-2"><code>.interactive-card</code> - Enhanced cards</li>
                </ul>
              </div>
            </div>

            <div class="mt-4 pt-4 border-top">
              <p class="text-muted mb-0">
                <i class="fa-solid fa-lightbulb me-1"></i>
                All features respect <code>prefers-reduced-motion</code> and work across light/dark themes.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>
</body>
</html>