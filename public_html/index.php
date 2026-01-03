<?php
// Enable Whoops error handler in development
require_once __DIR__ . '/includes/error-handler.php';

$activePage = 'home';
$pageTitle = 'JenniNexus - Game Developer & 3D Artist | Seattle/Tacoma';
$pageDescription = 'Professional game developer, 3D character artist, and voice actor in Seattle/Tacoma. Unity, Unreal Engine, Blender, VR development. Seattle Indies member. Available for hire - full-time, contract, or freelance.';
$pageKeywords = 'hire game developer Seattle, Tacoma game developer, Unity developer Washington, Unreal Engine Seattle, 3D character artist, voice actor for games, Seattle Indies, indie game developer, game development for hire, VR developer, Steam game developer, Pacific Northwest game dev, freelance game developer, game studio jobs Seattle, Seattle tech jobs, Washington game industry, game development services, Martian Games, Seattle Online Broadcasters Association, SOBA, Allen Institute, Bill Gates Foundation, Microsoft game developer, Seattle game talent';

// Page-specific CSS
$customCSS = [
  '/resources/css/home-theme.css'
];
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <?php include __DIR__ . '/includes/head.php'; ?>
  <body>
    
    <?php include __DIR__ . '/includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-section">
      <div class="container px-3 px-md-4">
        <div class="row align-items-center justify-content-center">
          <div class="col-12 col-md-10 col-lg-8 mx-auto text-center py-5">
            <div class="glass-panel p-5 rounded-4 shadow-lg">
              <div class="display-4 mb-4">
                <?php $logoLink = false; include __DIR__ . '/includes/logo.php'; ?>
              </div>
              <p class="lead mb-4 text-theme-adaptive">Multi-faceted creative platform showcasing game development, gaming content, DIY tutorials, voice acting, music production, and lifestyle content</p>
              <div class="d-grid gap-3 d-sm-flex justify-content-sm-center mb-4">
                <a href="#content" class="btn btn-primary btn-lg px-4 gap-3">Explore Content</a>
                <a href="#channels" class="btn btn-outline-secondary btn-lg px-4">YouTube Channels</a>
              </div>
              
              <div class="social-links">
                <a href="https://youtube.com/@jenninexus" target="_blank" class="btn btn-outline-light d-flex align-items-center justify-content-center" title="YouTube" aria-label="YouTube">
                  <i class="fa-brands fa-youtube"></i>
                </a>
                <a href="https://twitch.tv/jenninexus" target="_blank" class="btn btn-outline-light d-flex align-items-center justify-content-center" title="Twitch" aria-label="Twitch">
                  <i class="fa-brands fa-twitch"></i>
                </a>
                <a href="https://www.linkedin.com/in/jennifer-scheerer/" target="_blank" class="btn btn-outline-light d-flex align-items-center justify-content-center" title="LinkedIn" aria-label="LinkedIn">
                  <i class="fa-brands fa-linkedin"></i>
                </a>
                <a href="https://github.com/jenninexus" target="_blank" class="btn btn-outline-light d-flex align-items-center justify-content-center" title="GitHub" aria-label="GitHub">
                  <i class="fa-brands fa-github"></i>
                </a>
                <a href="mailto:jenninexus@gmail.com" class="btn btn-outline-light d-flex align-items-center justify-content-center" title="Email" aria-label="Email">
                  <i class="fa-solid fa-envelope"></i>
                </a>
                <button class="btn btn-outline-light d-flex align-items-center justify-content-center" title="Copy Discord Tag" aria-label="Discord" data-copy="jenninexus" data-copy-success-icon="fa-check">
                  <i class="fa-brands fa-discord"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Content Carousel -->
    <section class="py-5 bg-theme-adaptive">
      <div class="container">
        <h2 class="display-6 text-center mb-4 text-theme-adaptive">Featured Content</h2>
        <div id="featuredCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#featuredCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1" data-href="/music"></button>
            <button type="button" data-bs-target="#featuredCarousel" data-bs-slide-to="1" aria-label="Slide 2" data-href="/diy"></button>
            <button type="button" data-bs-target="#featuredCarousel" data-bs-slide-to="2" aria-label="Slide 3" data-href="/gaming"></button>
            <button type="button" data-bs-target="#featuredCarousel" data-bs-slide-to="3" aria-label="Slide 4" data-href="/blog"></button>
          </div>
          <div class="carousel-inner rounded glass-carousel">
            <!-- Music Production Slide -->
            <div class="carousel-item active">
              <div class="row g-0 bg-gradient p-5 text-white" style="min-height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="col-md-7 d-flex align-items-center">
                  <div>
                    <h3 class="display-5 fw-bold mb-3">Music Production</h3>
                    <p class="lead mb-4">Explore original tracks, beats, and music production tutorials. From FL Studio workflows to sound design tips.</p>
                    <a href="music.php" class="btn btn-light btn-lg">View Playlists <i class="fa-solid fa-arrow-right ms-2"></i></a>
                  </div>
                </div>
                <div class="col-md-5 d-flex align-items-center justify-content-center">
                  <i class="fa-solid fa-music display-1" style="font-size: 8rem; opacity: 0.3;"></i>
                </div>
              </div>
            </div>
            
            <!-- DIY Tutorials Slide -->
            <div class="carousel-item">
              <div class="row g-0 bg-gradient p-5 text-white" style="min-height: 400px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="col-md-7 d-flex align-items-center">
                  <div>
                    <h3 class="display-5 fw-bold mb-3">DIY & Crafts</h3>
                    <p class="lead mb-4">Fashion hacks, beauty tips, home decor, and creative projects. Learn to create amazing things on a budget.</p>
                    <a href="/diy" class="btn btn-light btn-lg">Watch Tutorials <i class="fa-solid fa-arrow-right ms-2"></i></a>
                  </div>
                </div>
                <div class="col-md-5 d-flex align-items-center justify-content-center">
                  <i class="fa-solid fa-palette display-1" style="font-size: 8rem; opacity: 0.3;"></i>
                </div>
              </div>
            </div>
            
            <!-- Gaming Content Slide -->
            <div class="carousel-item">
              <div class="row g-0 bg-gradient p-5 text-white" style="min-height: 400px; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="col-md-7 d-flex align-items-center">
                  <div>
                    <h3 class="display-5 fw-bold mb-3">Gaming & Let's Plays</h3>
                    <p class="lead mb-4">Watch gameplay, game reviews, and entertaining Let's Play series across various genres and platforms.</p>
                    <a href="/gaming" class="btn btn-light btn-lg">Join the Fun <i class="fa-solid fa-arrow-right ms-2"></i></a>
                  </div>
                </div>
                <div class="col-md-5 d-flex align-items-center justify-content-center">
                  <i class="fa-solid fa-gamepad display-1" style="font-size: 8rem; opacity: 0.3;"></i>
                </div>
              </div>
            </div>
            
            <!-- Blog & Articles Slide -->
            <div class="carousel-item">
              <div class="row g-0 bg-gradient p-5 text-white" style="min-height: 400px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div class="col-md-7 d-flex align-items-center">
                  <div>
                    <h3 class="display-5 fw-bold mb-3">Blog & Insights</h3>
                    <p class="lead mb-4">Read articles about game dev, tech, creativity, and personal experiences in the content creation world.</p>
                    <a href="blog.php" class="btn btn-light btn-lg">Read Posts <i class="fa-solid fa-arrow-right ms-2"></i></a>
                  </div>
                </div>
                <div class="col-md-5 d-flex align-items-center justify-content-center">
                  <i class="fa-solid fa-newspaper display-1" style="font-size: 8rem; opacity: 0.3;"></i>
                </div>
              </div>
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
          <script>
            // Make carousel indicators navigate to pretty URLs when clicked.
            // Use capture-phase and prevent other handlers so clicks reliably navigate to the target page
            (function(){
              const buttons = Array.from(document.querySelectorAll('#featuredCarousel .carousel-indicators button[data-href]'));
              function navigateFromButton(e){
                // run in capture phase, prevent Bootstrap's carousel handler from hijacking
                try{ e.stopImmediatePropagation(); }catch(_){}
                try{ e.preventDefault(); }catch(_){}
                const btn = e.currentTarget || e.target;
                const href = btn && btn.getAttribute ? btn.getAttribute('data-href') : null;
                if (!href) return;
                if (e.ctrlKey || e.metaKey) { // ctrl/cmd + click -> new tab
                  window.open(href, '_blank');
                  return;
                }
                if (e.shiftKey) { // shift+click -> new window
                  window.open(href, '_blank', 'noopener');
                  return;
                }
                // normal click -> navigate
                window.location.href = href;
              }

              // Attach on pointerup and click in capture so touch/drag interactions still trigger navigation reliably
              buttons.forEach(function(btn){
                btn.addEventListener('pointerup', navigateFromButton, {capture:true});
                btn.addEventListener('click', navigateFromButton, {capture:true});
                // keyboard support
                btn.addEventListener('keydown', function(e){ if(e.key === 'Enter' || e.key === ' ') navigateFromButton(e); }, {capture:true});
              });
            })();
          </script>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-theme-adaptive">
      <div class="container">
        <div class="row g-4 justify-content-center">
          <div class="col-6 col-md-3">
            <div class="stat-card">
              <span class="stat-number" data-target="15">0</span>
              <span class="stat-label">Years Experience</span>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="stat-card">
              <span class="stat-number" data-target="50">0</span>
              <span class="stat-label">Projects Completed</span>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="stat-card">
              <span class="stat-number" data-target="1200">0</span>
              <span class="stat-label">Videos Published</span>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="stat-card">
              <span class="stat-number" data-target="5000">0</span>
              <span class="stat-label">Community Members</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5 section-pastel home-surface">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="display-4 mb-4">Welcome to <?php $logoLink = false; include __DIR__ . '/includes/logo.php'; ?></h2>
            <p class="lead">Your central hub for creativity, innovation, and entertainment across multiple platforms and disciplines.</p>
            <p class="mt-4">From game development devlogs to DIY fashion tutorials, gaming Let's Plays to music production, JenniNexus brings together diverse creative content under one unified brand.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
      <div class="container">
        <h2 class="display-5 text-center mb-5">Creative Features</h2>
        <div class="row g-4">
          <div class="col-md-4">
            <a href="/gamedev" class="text-decoration-none">
              <div class="card h-100 border-0 shadow feature-card hover-lift" data-tilt>
                <div class="card-body text-center p-4">
                  <div class="feature-icon mb-3">
                    <i class="fa-solid fa-gamepad fs-1"></i>
                  </div>
                  <h3 class="card-title h4">Game Development</h3>
                  <p class="card-text">Unity 3D, Unreal Engine, Blender tutorials, devlogs, and game jam projects showcasing the full development pipeline.</p>
                </div>
              </div>
            </a>
          </div>
          <div class="col-md-4">
            <a href="/diy" class="text-decoration-none">
              <div class="card h-100 border-0 shadow feature-card hover-lift" data-tilt>
                <div class="card-body text-center p-4">
                  <div class="feature-icon mb-3">
                    <i class="fa-solid fa-palette fs-1"></i>
                  </div>
                  <div class="card-title h4">
                    <?php $logoVariant = 'diy'; $logoLink = false; include __DIR__ . '/includes/logo.php'; ?>
                  </div>
                  <p class="card-text">Fashion tutorials, nail art, beauty content, and creative crafts with a focus on upcycling and self-expression.</p>
                </div>
              </div>
            </a>
          </div>
          <div class="col-md-4">
            <a href="/voiceacting" class="text-decoration-none">
              <div class="card h-100 border-0 shadow feature-card hover-lift" data-tilt>
                <div class="card-body text-center p-4">
                  <div class="feature-icon mb-3">
                    <i class="fa-solid fa-microphone fs-1"></i>
                  </div>
                  <h3 class="card-title h4">Voice Acting</h3>
                  <p class="card-text">Professional voice acting services, character demos, and tutorials for games, animation, and multimedia projects.</p>
                </div>
              </div>
            </a>
          </div>
          <div class="col-md-4">
            <a href="/gaming" class="text-decoration-none">
              <div class="card h-100 border-0 shadow feature-card hover-lift" data-tilt>
                <div class="card-body text-center p-4">
                  <div class="feature-icon mb-3">
                    <i class="fa-solid fa-gamepad fs-1"></i>
                  </div>
                  <h3 class="card-title h4">Gaming Content</h3>
                  <p class="card-text">Let's Plays, Twitch highlights, gaming commentary, and coverage of gaming conventions like PAX West.</p>
                </div>
              </div>
            </a>
          </div>
          <div class="col-md-4">
            <a href="/music" class="text-decoration-none">
              <div class="card h-100 border-0 shadow feature-card hover-lift" data-tilt>
                <div class="card-body text-center p-4">
                  <div class="feature-icon mb-3">
                    <i class="fa-solid fa-music fs-1"></i>
                  </div>
                  <h3 class="card-title h4">Music Production</h3>
                  <p class="card-text">FL Studio tutorials, DJ mixing techniques, EDM culture, and music festival coverage including EDC 2024.</p>
                </div>
              </div>
            </a>
          </div>
          <div class="col-md-4">
            <a href="/ai" class="text-decoration-none">
              <div class="card h-100 border-0 shadow feature-card hover-lift" data-tilt>
                <div class="card-body text-center p-4">
                  <div class="feature-icon mb-3">
                    <i class="fa-solid fa-robot fs-1"></i>
                  </div>
                  <h3 class="card-title h4">AI & Technology</h3>
                  <p class="card-text">Exploration of AI tools, emerging technology reviews, and integration of cutting-edge tech in creative workflows.</p>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Content Categories Section -->
    <section id="content" class="py-5 section-pastel home-surface">
      <div class="container">
        <div class="row mb-5">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="display-5 mb-4">Content Categories</h2>
            <p class="lead">Explore our diverse creative content across multiple disciplines</p>
            
            <!-- Tag Filter Pills -->
            <div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
              <button class="btn btn-sm btn-primary active" data-filter="all">All Content</button>
              <button class="btn btn-sm btn-outline-primary" data-filter="gamedev">Game Dev</button>
              <button class="btn btn-sm btn-outline-primary" data-filter="gaming">Gaming</button>
              <button class="btn btn-sm btn-outline-primary" data-filter="diy">DIY</button>
              <button class="btn btn-sm btn-outline-primary" data-filter="music">Music</button>
              <button class="btn btn-sm btn-outline-primary" data-filter="voice-acting">Voice Acting</button>
            </div>
            <!-- Tag Filter UI trigger and active filters -->
            <div class="d-flex justify-content-center align-items-center gap-3 mt-3">
              <button class="btn btn-outline-primary btn-sm" data-bs-toggle="offcanvas" data-bs-target="#tagFilterOffcanvas" aria-controls="tagFilterOffcanvas">
                <i class="fa-solid fa-filter"></i> Filter by Tags
              </button>
              <div id="activeFiltersContainer" style="display:none;">
                <div id="activeFilters" class="d-flex gap-2"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="row g-4" id="contentGrid">
          <!-- Game Development -->
          <div class="col-lg-6 content-item" data-category="gamedev" data-tags="gamedev,game-dev,devlogs,devlog,bts,game-jam,3d-modeling,highlights">
            <div class="content-card p-4 rounded shadow-sm h-100">
              <h3 class="h4 mb-3"><i class="fa-solid fa-code me-2"></i>Game Development</h3>
              <ul class="list-unstyled">
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> Devlogs & Behind-the-Scenes</li>
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> Unity 3D & Unreal Engine Tutorials</li>
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> Blender 3D Modeling & Animation</li>
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> Game Jam Highlights & Projects</li>
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> Industry Insights & Discussions</li>
              </ul>
              <div class="mt-3">
                <a href="/tag/index.php?slug=unity" class="badge bg-primary text-decoration-none me-2" data-tag="unity">Unity</a>
                <a href="/tag/index.php?slug=unreal" class="badge bg-primary text-decoration-none me-2" data-tag="unreal">Unreal</a>
                <a href="/tag/index.php?slug=blender" class="badge bg-primary text-decoration-none" data-tag="blender">Blender</a>
              </div>
              <!-- Video grid removed - use dedicated /gamedev page for playlists -->
            </div>
          </div>

          <!-- DIY & Fashion -->
          <div class="col-lg-6 content-item" data-category="diy" data-tags="diy,fashion,beauty,crafts">
            <div class="content-card p-4 rounded shadow-sm h-100">
              <h3 class="h4 mb-3"><i class="fa-solid fa-scissors me-2"></i>DIY Fashion & Beauty</h3>
              <ul class="list-unstyled">
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> No-Sew T-shirt Customization</li>
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> Hair Styling & Coloring Tutorials</li>
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> Nail Art & Gel Nail Tutorials</li>
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> Fashion Upcycling Projects</li>
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> Brand Collaborations & Reviews</li>
              </ul>
              <div class="mt-3">
                <a href="/tag/index.php?slug=fashion" class="badge bg-secondary text-decoration-none me-2" data-tag="fashion">Fashion</a>
                <a href="/tag/index.php?slug=beauty" class="badge bg-secondary text-decoration-none me-2" data-tag="beauty">Beauty</a>
                <a href="/tag/index.php?slug=crafts" class="badge bg-secondary text-decoration-none" data-tag="crafts">Crafts</a>
              </div>
              <!-- Video grid removed - use dedicated /diy page for playlists -->
            </div>
          </div>

          <!-- Gaming -->
          <div class="col-lg-6 content-item" data-category="gaming" data-tags="gaming,letsplay,twitch,stream,clips,youtube,highlights,live,setup">
            <div class="content-card p-4 rounded shadow-sm h-100">
              <h3 class="h4 mb-3"><i class="fa-solid fa-gamepad me-2"></i>Gaming & Streaming</h3>
              <ul class="list-unstyled">
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> Let's Plays & Game Playthroughs</li>
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> Twitch Live Stream Highlights</li>
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> PAX West Gaming Convention</li>
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> Gaming Commentary & Culture</li>
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> Streaming Tips & Setup Guides</li>
              </ul>
              <div class="mt-3">
                <a href="/tag/index.php?slug=twitch" class="badge bg-success text-decoration-none me-2" data-tag="twitch">Twitch</a>
                <a href="/tag/index.php?slug=lets-play" class="badge bg-success text-decoration-none me-2" data-tag="lets-play">Let's Play</a>
                <a href="/tag/index.php?slug=gaming" class="badge bg-success text-decoration-none" data-tag="gaming">Gaming</a>
              </div>
              <!-- Video grid removed - use dedicated /gaming page for playlists -->
            </div>
          </div>

          <!-- Music & Entertainment -->
          <div class="col-lg-6 content-item" data-category="music" data-tags="music,playlists,edm">
            <div class="content-card p-4 rounded shadow-sm h-100">
              <h3 class="h4 mb-3"><i class="fa-solid fa-music me-2"></i>Music & Entertainment</h3>
              <ul class="list-unstyled">
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> FL Studio Production Tutorials</li>
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> DJ Mixing Techniques & Tips</li>
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> EDC & Music Festival Coverage</li>
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> Music History & Gen X Culture</li>
                <li class="mb-2"><i class="fa-solid fa-chevron-right text-primary"></i> Shuffle Dance & EDM Culture</li>
              </ul>
              <div class="mt-3">
                <a href="/tag/index.php?slug=edm" class="badge bg-warning text-dark text-decoration-none me-2" data-tag="edm">EDM</a>
                <a href="/tag/index.php?slug=dj" class="badge bg-warning text-dark text-decoration-none me-2" data-tag="dj">DJ</a>
                <a href="/tag/index.php?slug=fl-studio" class="badge bg-warning text-dark text-decoration-none" data-tag="fl-studio">FL Studio</a>
              </div>
              <!-- Video grid removed - use dedicated /music page for playlists -->
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Featured Projects -->
    <section class="py-5">
      <div class="container">
        <h2 class="display-5 text-center mb-5">Featured Projects</h2>
        <div class="row g-4">
          <div class="col-md-6 col-lg-3">
            <a href="/game/purgatoryfell.php" class="text-decoration-none" data-tags="purgatory-fell,vr,gamedev">
              <div class="card h-100 border-0 shadow-sm project-card">
                <div class="card-body">
                  <div class="project-icon mb-3 text-primary">
                    <i class="fa-solid fa-vr-cardboard fs-1"></i>
                  </div>
                  <h5 class="card-title">Purgatory Fell VR</h5>
                  <p class="card-text small">Narrative VR horror game showcasing immersive storytelling and atmospheric design.</p>
                </div>
              </div>
            </a>
          </div>
          <div class="col-md-6 col-lg-3">
            <a href="/game/botborgs.php" class="text-decoration-none" data-tags="botborgs,robot,indie">
              <div class="card h-100 border-0 shadow-sm project-card">
                <div class="card-body">
                  <div class="project-icon mb-3 text-primary">
                    <i class="fa-solid fa-robot fs-1"></i>
                  </div>
                  <h5 class="card-title">Botborgs</h5>
                  <p class="card-text small">Web3 game featuring 3D 'Botborg' characters and an interplanetary society and economic system.</p>
                </div>
              </div>
            </a>
          </div>
          <div class="col-md-6 col-lg-3">
            <a href="/game/jennistyles.php" class="text-decoration-none" data-tags="jenni-styles,dress-up,indie">
              <div class="card h-100 border-0 shadow-sm project-card">
                <div class="card-body">
                  <div class="project-icon mb-3 text-primary">
                    <i class="fa-solid fa-heart fs-1"></i>
                  </div>
                  <h5 class="card-title">Jenni Styles Dress Up</h5>
                  <p class="card-text small">Fashion dress-up game combining style and creativity with interactive gameplay.</p>
                </div>
              </div>
            </a>
          </div>
          <div class="col-md-6 col-lg-3">
            <a href="/game/gamejams.php" class="text-decoration-none" data-tags="game-jams,gamejam,collection">
              <div class="card h-100 border-0 shadow-sm project-card">
                <div class="card-body">
                  <div class="project-icon mb-3 text-primary">
                    <i class="fa-solid fa-trophy fs-1"></i>
                  </div>
                  <h5 class="card-title">Game Jam Projects</h5>
                  <p class="card-text small">Rapid development showcases including Cat-As-Trophy, Blue Balls, and Cow Defender.</p>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- YouTube Channels -->
    <section id="channels" class="py-5 section-pastel home-surface">
      <div class="container">
        <h2 class="display-5 text-center mb-5">YouTube Channels</h2>
        <div class="row g-4">
          <div class="col-lg-4">
            <div class="card h-100 border-0 shadow channel-card">
              <div class="card-body text-center p-4">
                <div class="channel-icon mb-3">
                  <i class="fa-brands fa-youtube text-danger fs-1"></i>
                </div>
                <div class="h4">
                  <?php $logoLink = false; include __DIR__ . '/includes/logo.php'; ?>
                </div>
                <p class="text-muted small mb-3">Main Channel</p>
                <p class="card-text">Game development, technology, AI tools, voice acting, devlogs, and industry insights.</p>
                <a href="https://www.youtube.com/@jenninexus?sub_confirmation=1" target="_blank" class="btn btn-outline-danger mt-3">
                  <i class="fa-brands fa-youtube me-2"></i>Subscribe
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card h-100 border-0 shadow channel-card">
              <div class="card-body text-center p-4">
                <div class="channel-icon mb-3">
                  <i class="fa-brands fa-youtube text-danger fs-1"></i>
                </div>
                <h3 class="h4">Jenni Plays Games</h3>
                <p class="text-muted small mb-3">Gaming Channel</p>
                <p class="card-text">Gaming gameplay, Let's Plays, Twitch highlights, and gaming commentary.</p>
                <a href="https://www.jenninexus.com/gaming" target="_blank" class="btn btn-outline-danger mt-3">
                  <i class="fa-brands fa-youtube me-2"></i>Subscribe
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card h-100 border-0 shadow channel-card">
              <div class="card-body text-center p-4">
                <div class="channel-icon mb-3">
                  <i class="fa-brands fa-youtube text-danger fs-1"></i>
                </div>
                <div class="h4">
                  <?php $logoVariant = 'diy'; $logoLink = false; include __DIR__ . '/includes/logo.php'; ?>
                </div>
                <p class="text-muted small mb-3">DIY Channel</p>
                <p class="card-text">Fashion tutorials, nail art, hair styling, beauty content, and lifestyle crafts.</p>
                <a href="https://www.youtube.com/@DIYwithJenni?sub_confirmation=1" target="_blank" class="btn btn-outline-danger mt-3">
                  <i class="fa-brands fa-youtube me-2"></i>Subscribe
                </a>
              </div>
            </div>
          </div>
        </div>
        
        <!-- View All Videos CTA -->
        <div class="row mt-5">
          <div class="col-lg-8 mx-auto text-center">
            <a href="/youtube" class="btn btn-lg btn-primary">
              <i class="fa-solid fa-circle-play me-2"></i>View All Videos & Playlists
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="display-5 mb-4">Join the Community</h2>
            <p class="lead mb-4">Connect with the JenniNexus community on Discord</p>
            <div class="d-flex justify-content-center">
              <a href="https://discord.gg/KYPh7Cp" target="_blank" class="btn btn-primary btn-lg">
                <i class="fa-brands fa-discord me-2"></i>Join Discord
              </a>
            </div>
            
            <!-- Community Discord Links -->
            <div class="row mt-5 g-3">
              <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body text-center p-4">
                    <i class="fa-solid fa-gamepad fs-1 text-success mb-3"></i>
                    <h5 class="card-title">Gaming Community</h5>
                    <p class="card-text small">Join gamers for Let's Plays, streams, and gaming discussions</p>
                    <a href="https://discord.gg/dc86JqBntj" target="_blank" class="btn btn-outline-success">
                      <i class="fa-brands fa-discord me-2"></i>Gaming Channel
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body text-center p-4">
                    <i class="fa-solid fa-scissors fs-1 text-danger mb-3"></i>
                    <h5 class="card-title">DIY Community</h5>
                    <p class="card-text small">Share fashion, beauty, and craft projects with fellow creators</p>
                    <a href="https://discord.gg/pKSyR4A9Tb" target="_blank" class="btn btn-outline-danger">
                      <i class="fa-brands fa-discord me-2"></i>DIY Channel
                    </a>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body text-center p-4">
                    <i class="fa-solid fa-music fs-1 text-warning mb-3"></i>
                    <h5 class="card-title">Music Community</h5>
                    <p class="card-text small">Connect with music producers, DJs, and EDM enthusiasts</p>
                    <a href="https://discord.gg/zwcfR2BpDb" target="_blank" class="btn btn-outline-warning">
                      <i class="fa-brands fa-discord me-2"></i>Music Channel
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Resume/Services Section -->
    <section id="resume" class="py-5 section-pastel home-surface">
      <div class="container">
        <div class="row mb-5">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="display-5 mb-4">Resume & Services</h2>
            <p class="lead">Professional game developer, content creator, and creative specialist available for hire</p>
          </div>
        </div>

        <!-- Skills Grid -->
        <div class="row g-4 mb-5">
          <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body text-center p-4">
                <i class="fa-solid fa-code fs-1 text-primary mb-3"></i>
                <h5 class="card-title">Game Development</h5>
                <ul class="list-unstyled small text-start">
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Unity 3D & C#</li>
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Unreal Engine</li>
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Game Design</li>
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Level Design</li>
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>VR Development</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body text-center p-4">
                <i class="fa-solid fa-palette fs-1 text-secondary mb-3"></i>
                <h5 class="card-title">Creative</h5>
                <ul class="list-unstyled small text-start">
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>3D Modeling (Blender)</li>
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Video Editing</li>
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Voice Acting</li>
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Content Creation</li>
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Graphic Design</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body text-center p-4">
                <i class="fa-solid fa-laptop fs-1 text-info mb-3"></i>
                <h5 class="card-title">Technical</h5>
                <ul class="list-unstyled small text-start">
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Web Development</li>
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>PHP & JavaScript</li>
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>SCSS/CSS</li>
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Git Version Control</li>
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>API Integration</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm">
              <div class="card-body text-center p-4">
                <i class="fa-solid fa-microphone fs-1 text-warning mb-3"></i>
                <h5 class="card-title">Voice & Media</h5>
                <ul class="list-unstyled small text-start">
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Voice Acting</li>
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Audio Production</li>
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Sound Design</li>
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Podcast Production</li>
                  <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Live Streaming</li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Resume Download & Contact -->
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-lg">
              <div class="card-body p-5">
                <div class="row align-items-center">
                  <div class="col-md-8">
                    <h4 class="card-title mb-3">Visit the Resume Page</h4>
                    <p class="card-text mb-4">View my complete professional resume with detailed experience, projects, and references.</p>
                    <div class="d-flex flex-wrap gap-3">
                      <a href="/resume" class="btn btn-primary btn-lg">
                        <i class="fa-solid fa-file-lines me-2"></i>View Resume
                      </a>
                      <a href="https://www.linkedin.com/in/jenninexus" target="_blank" class="btn btn-outline-primary btn-lg">
                        <i class="fa-brands fa-linkedin me-2"></i>LinkedIn Profile
                      </a>
                    </div>
                  </div>
                  <div class="col-md-4 text-center mt-4 mt-md-0">
                    <i class="fa-solid fa-file-lines fs-1 text-primary mb-3 d-block"></i>
                    <p class="small text-muted">Updated October 2025</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Patreon/Support Section -->
    <section id="patreon" class="py-5">
      <div class="container">
        <div class="row mb-5">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="display-5 mb-4">Support My Work</h2>
            <p class="lead">Join my Patreon community and get exclusive perks, early access, and behind-the-scenes content!</p>
          </div>
        </div>

        <!-- Patreon Benefits -->
        <div class="row g-4 mb-5">
          <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-primary shadow-sm">
              <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h5 class="card-title mb-0">🎮 Game Dev Tier</h5>
                  <span class="badge bg-primary">$5/mo</span>
                </div>
                <ul class="list-unstyled">
                  <li class="mb-2"><i class="fa-solid fa-circle-check text-primary me-2"></i>Exclusive devlog videos</li>
                  <li class="mb-2"><i class="fa-solid fa-circle-check text-primary me-2"></i>Behind-the-scenes content</li>
                  <li class="mb-2"><i class="fa-solid fa-circle-check text-primary me-2"></i>Early access to tutorials</li>
                  <li class="mb-2"><i class="fa-solid fa-circle-check text-primary me-2"></i>Discord role & access</li>
                  <li class="mb-2"><i class="fa-solid fa-circle-check text-primary me-2"></i>Vote on future content</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-secondary shadow-lg" style="transform: scale(1.05);">
              <div class="card-header bg-secondary text-white text-center py-3">
                <h5 class="mb-0">⭐ MOST POPULAR</h5>
              </div>
              <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h5 class="card-title mb-0">💎 Creator Tier</h5>
                  <span class="badge bg-secondary">$10/mo</span>
                </div>
                <ul class="list-unstyled">
                  <li class="mb-2"><i class="fa-solid fa-circle-check text-secondary me-2"></i>All Game Dev Tier benefits</li>
                  <li class="mb-2"><i class="fa-solid fa-circle-check text-secondary me-2"></i>Project source files</li>
                  <li class="mb-2"><i class="fa-solid fa-circle-check text-secondary me-2"></i>Monthly Q&A sessions</li>
                  <li class="mb-2"><i class="fa-solid fa-circle-check text-secondary me-2"></i>Asset packs & templates</li>
                  <li class="mb-2"><i class="fa-solid fa-circle-check text-secondary me-2"></i>Priority support</li>
                  <li class="mb-2"><i class="fa-solid fa-circle-check text-secondary me-2"></i>Name in credits</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-4 mx-auto">
            <div class="card h-100 border-warning shadow-sm">
              <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h5 class="card-title mb-0">🌟 VIP Tier</h5>
                  <span class="badge bg-warning text-dark">$25/mo</span>
                </div>
                <ul class="list-unstyled">
                  <li class="mb-2"><i class="fa-solid fa-circle-check text-warning me-2"></i>All Creator Tier benefits</li>
                  <li class="mb-2"><i class="fa-solid fa-circle-check text-warning me-2"></i>1-on-1 mentorship (monthly)</li>
                  <li class="mb-2"><i class="fa-solid fa-circle-check text-warning me-2"></i>Custom tutorials</li>
                  <li class="mb-2"><i class="fa-solid fa-circle-check text-warning me-2"></i>Code review sessions</li>
                  <li class="mb-2"><i class="fa-solid fa-circle-check text-warning me-2"></i>Exclusive Discord channels</li>
                  <li class="mb-2"><i class="fa-solid fa-circle-check text-warning me-2"></i>Early game builds & demos</li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Patreon CTA -->
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, var(--jenni-primary), var(--jenni-secondary));">
              <div class="card-body p-5 text-white">
                <p class="lead mb-4">Consider showing your support for my creative passions!</p>
                <a href="https://patreon.com/jenninexus" target="_blank" class="btn btn-light btn-lg px-5">
                  <i class="fa-solid fa-heart me-2"></i>Become a Patron
                </a>
                <p class="small mt-3 mb-0 opacity-75">Cancel anytime • Secure payment via Patreon</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- PROFESSIONAL CONTACT SECTION - For Hiring/Investment Inquiries -->
    <section class="py-5 bg-dark text-white">
      <div class="container">
        <div class="text-center mb-5">
          <h2 class="display-5 fw-bold mb-3">
            <i class="fa-solid fa-briefcase text-primary me-2"></i>Available for Hire
          </h2>
          <p class="lead">Seattle/Tacoma-based game developer open to opportunities</p>
        </div>
        
        <div class="row g-4 align-items-center">
          <div class="col-lg-7">
            <div class="row g-3">
              <div class="col-md-6">
                <div class="card glass-card h-100">
                  <div class="card-body">
                    <h5 class="text-primary mb-3"><i class="fa-solid fa-gamepad me-2"></i>Game Development</h5>
                    <ul class="list-unstyled small mb-0">
                      <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Unity & Unreal Engine</li>
                      <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>VR/Steam development</li>
                      <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Game jams & prototyping</li>
                      <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Technical art</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card glass-card h-100">
                  <div class="card-body">
                    <h5 class="text-primary mb-3"><i class="fa-solid fa-box me-2"></i>3D Art Services</h5>
                    <ul class="list-unstyled small mb-0">
                      <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Character Creator 4</li>
                      <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Blender modeling</li>
                      <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Game-ready assets</li>
                      <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Animation & rigging</li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-12">
                <div class="card glass-card">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-md-8">
                        <h6 class="mb-2"><i class="fa-solid fa-users text-info me-2"></i>Professional Affiliations</h6>
                        <p class="small mb-0 text-muted">
                          <span class="affiliation-pill me-2">Seattle Indies</span>
                          <span class="affiliation-pill me-2">Seattle Online Broadcasters Association</span>
                          <span class="affiliation-pill me-2">Live Coders</span>
                          <span class="affiliation-pill">Martian Games</span>
                        </p>
                      </div>
                      <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <i class="fa-solid fa-location-dot text-primary me-1"></i>
                        <small class="text-muted">Tacoma/Seattle, WA</small>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-lg-5">
            <div class="card bg-gradient-primary border-0 shadow-lg">
              <div class="card-body p-4 text-center">
                <h4 class="mb-3">Let's Work Together</h4>
                <p class="mb-4">Interested in hiring for game development, 3D art, or voice acting?</p>
                
                <a href="mailto:jenninexus@gmail.com?subject=Professional Inquiry - Hiring for Game Development&body=Hi Jenni,%0D%0A%0D%0AI'm interested in discussing opportunities in:%0D%0A[ ] Full-time position%0D%0A[ ] Contract work%0D%0A[ ] Freelance project%0D%0A[ ] Investment/Partnership%0D%0A%0D%0ACompany/Project:%0D%0ARole/Position:%0D%0ABudget/Timeline:%0D%0A%0D%0AAdditional details:%0D%0A" 
                   class="btn btn-light btn-lg w-100 mb-3">
                  <i class="fa-solid fa-envelope me-2"></i>jenninexus@gmail.com
                </a>
                
                <div class="d-grid gap-2">
                  <a href="resume.php" class="btn btn-outline-light">
                    <i class="fa-solid fa-file-lines me-2"></i>View Resume
                  </a>
                  <a href="services.php" class="btn btn-outline-light">
                    <i class="fa-solid fa-briefcase me-2"></i>View Services
                  </a>
                </div>
                
                <hr class="my-3 border-white opacity-25">
                
                <p class="small mb-0 opacity-75">
                  <i class="fa-solid fa-shield-halved me-1"></i>Professional inquiries only<br>
                  Response time: 1-2 business days
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php include __DIR__ . '/includes/footer.php'; ?>

    <!-- Tag Filter Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="tagFilterOffcanvas" aria-labelledby="tagFilterOffcanvasLabel">
      <div class="offcanvas-header">
        <h5 id="tagFilterOffcanvasLabel">Filter by Tags</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <div class="mb-3 jn-show-all-tags">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="jnShowAllTagsToggle">
            <label class="form-check-label small text-muted" for="jnShowAllTagsToggle">Show all tags</label>
          </div>
        </div>

        <div class="mb-3">
          <h6>Game Dev Tags</h6>
          <div id="gamedevTagsList" class="d-flex flex-wrap gap-2 mb-3"></div>
        </div>
        <div class="mb-3">
          <h6>Gaming Tags</h6>
          <div id="gamingTagsList" class="d-flex flex-wrap gap-2 mb-3"></div>
        </div>
        <div class="mb-3">
          <h6>DIY Tags</h6>
          <div id="diyTagsList" class="d-flex flex-wrap gap-2 mb-3"></div>
        </div>
        <div class="mb-3">
          <h6>Voice Acting Tags</h6>
          <div id="voiceTagsList" class="d-flex flex-wrap gap-2 mb-3"></div>
        </div>

        <div class="d-flex flex-wrap gap-2 mt-4">
          <button id="applyFilters" class="btn btn-primary flex-grow-1" data-bs-dismiss="offcanvas" style="min-width: 120px;">Apply Filters</button>
          <button id="clearFilters" class="btn btn-outline-secondary flex-grow-1" style="min-width: 100px;">Clear</button>
          <a href="/tags.php" class="btn btn-link text-nowrap">View all tags</a>
        </div>
      </div>
    </div>

    <!-- Page-specific scripts -->
  <script src="<?= RES_ROOT ?>/js/ui-effects.js"></script>
  <script src="<?= RES_ROOT ?>/js/patreon-auth-enhanced.js"></script>
  <script src="<?= RES_ROOT ?>/js/youtube-grid.js"></script>
  <script src="<?= RES_ROOT ?>/js/tag-system.js"></script>

  <script>
    // Wire the tag offcanvas Apply / Clear buttons to navigate to a filtered tags page
    (function(){
      function getActiveFilterSlugs(){
        const container = document.getElementById('activeFilters');
        if (!container) return [];
        const items = Array.from(container.querySelectorAll('[data-tag]'));
        // Fallback: badges without data-tag might have text content as slug
        if (items.length === 0) {
          return Array.from(container.querySelectorAll('.badge')).map(b => (b.dataset.tag || b.getAttribute('data-tag') || b.textContent || '').trim()).filter(Boolean);
        }
        return items.map(i => (i.dataset.tag || i.getAttribute('data-tag') || '').trim()).filter(Boolean);
      }

      const applyBtn = document.getElementById('applyFilters');
      const clearBtn = document.getElementById('clearFilters');
      if (applyBtn) applyBtn.addEventListener('click', function(){
        try{
          const slugs = getActiveFilterSlugs();
          if (!slugs || slugs.length === 0) {
            // no filters selected -> go to full tags index
            window.location.href = '/tags.php';
            return;
          }
          const q = encodeURIComponent(slugs.join(','));
          window.location.href = '/tags.php?filters=' + q;
        } catch (err){ console.error('ApplyFilters error', err); window.location.href = '/tags.php'; }
      });

      if (clearBtn) clearBtn.addEventListener('click', function(){
        // Attempt to clear tag-system state if available, otherwise clear the UI
        if (window.tagSystem && typeof window.tagSystem.clearFilters === 'function') {
          window.tagSystem.clearFilters();
        } else {
          const container = document.getElementById('activeFilters');
          if (container) container.innerHTML = '';
        }
      });
    })();
  </script>

  </body>
</html>
