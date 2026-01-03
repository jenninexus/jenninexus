<?php
$activePage = 'services';
$pageTitle = 'Hire Me - Game Development, 3D Art & Voice Acting Services | JenniNexus';
$pageDescription = 'Professional game development, 3D character modeling, and voice acting services in Seattle/Tacoma. Unity/Unreal developer, Blender artist, Character Creator expert. Available for contract work, game studios, and indie projects.';
$pageKeywords = 'hire game developer Seattle, freelance game developer Tacoma, 3D character artist for hire, voice actor for games, Unity developer contract, Unreal Engine consultant, Blender 3D artist, Character Creator services, game development services Washington, technical artist for hire, indie game developer available, Seattle game development contract work, professional voice acting, game jam developer, VR developer for hire, Steam game developer, Pacific Northwest game services, game studio hiring, Allen Institute partnerships, Seattle tech talent';
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<?php include __DIR__ . '/includes/head.php'; ?>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>

  <!-- Hero Section -->
  <section class="py-5" style="background: linear-gradient(135deg, var(--jenni-primary), var(--jenni-secondary)); min-height: 40vh;">
    <div class="container text-center" >
      <div class="text-white" style="min-height: 30vh; display: flex; flex-direction: column; justify-content: center;">
        <i class="fa-solid fa-briefcase fa-spin display-1 mb-4" style="--fa-animation-duration: 4s;"></i>
        <h1 class="display-2 mb-4">Professional Services</h1>
        <p class="lead mb-2">High-quality creative work for your project</p>
        <p class="mb-4">Contact for Hire | Discuss Your Project | Collaborate</p>
        <div class="d-flex justify-content-center gap-2">
          <a href="mailto:jenninexus@gmail.com?subject=Hire%20or%20Collab" class="btn btn-light btn-lg">
            <i class="fa-solid fa-envelope me-2"></i>Email
          </a>
          <a href="https://discord.gg/pKSyR4A9Tb" target="_blank" class="btn btn-outline-light btn-lg">
            <i class="fa-brands fa-discord me-2"></i>Discord
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Grid -->
  <section class="py-5">
    <div class="container">
      <div class="row g-4">
        
        <!-- Game Development -->
        <div class="col-md-6">
          <div class="card h-100 glass-card">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <i class="fa-solid fa-gamepad display-4 text-primary me-3"></i>
                <h3 class="mb-0 text-theme-adaptive">Game Development</h3>
              </div>
              <p class="text-muted">Full-stack game development and consulting services.</p>
              <ul class="list-unstyled">
                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Unity & Unreal Engine</li>
                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Game design consulting</li>
                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Prototyping & development</li>
                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Technical art</li>
              </ul>
              <!-- per-card call-to-action removed; use central Contact for Hire buttons above -->
            </div>
          </div>
        </div>

        <!-- 3D Modeling -->
        <div class="col-md-6">
          <div class="card h-100 glass-card">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <i class="fa-solid fa-box display-4 text-primary me-3"></i>
                <h3 class="mb-0 text-theme-adaptive">3D Modeling & Assets</h3>
              </div>
              <p class="text-muted">Custom 3D character and asset creation for games and media.</p>
              <ul class="list-unstyled">
                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Character Creator 4</li>
                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Blender modeling</li>
                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Game-ready assets</li>
                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Rigging & animation</li>
                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Website Design & Hosting (WordPress, static sites, reliable hosting & uptime support)</li>
              </ul>
              <!-- per-card links removed to centralize contact actions -->
            </div>
          </div>
        </div>

        <!-- Voice Acting -->
        <div class="col-md-6">
          <div class="card h-100 glass-card">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <i class="fa-solid fa-microphone display-4 text-primary me-3"></i>
                <h3 class="mb-0 text-theme-adaptive">Voice Acting</h3>
              </div>
              <p class="text-muted">Professional voice acting for games, animations, and multimedia projects.</p>
              <ul class="list-unstyled">
                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Character voices</li>
                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Narration & voiceover</li>
                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Game dialogue</li>
                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Commercial work</li>
              </ul>
              <!-- per-card links removed to centralize contact actions -->
            </div>
          </div>
        </div>

        <!-- DIY Consulting -->
        <div class="col-md-6">
          <div class="card h-100 glass-card">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <i class="fa-solid fa-scissors display-4 text-primary me-3"></i>
                <h3 class="mb-0 text-theme-adaptive">DIY Consulting</h3>
              </div>
              <p class="text-muted">Fashion, beauty, and creative DIY consultation and tutorials.</p>
              <ul class="list-unstyled">
                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Custom tutorial creation</li>
                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Brand collaborations</li>
                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Product reviews</li>
                <li><i class="fa-solid fa-circle-check text-success me-2"></i>Sponsored content</li>
              </ul>
              <!-- per-card links removed to centralize contact actions -->
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- Why Work With Me -->
  <section class="py-5 bg-body-secondary">
    <div class="container">
      <h2 class="text-center mb-5 text-theme-adaptive">Why Work With Me?</h2>
      <div class="row g-4">
        <div class="col-md-4 text-center">
          <div class="glass-card p-4 h-100">
            <i class="fa-solid fa-star display-4 text-warning mb-3"></i>
            <h5 class="text-theme-adaptive">Multi-Disciplinary Expert</h5>
            <p class="text-muted">Unique combination of creative and technical skills across multiple fields</p>
          </div>
        </div>
        <div class="col-md-4 text-center">
          <div class="glass-card p-4 h-100">
            <i class="fa-solid fa-bolt display-4 text-primary mb-3"></i>
            <h5 class="text-theme-adaptive">Fast Turnaround</h5>
            <p class="text-muted">Professional quality delivered on time and within budget</p>
          </div>
        </div>
        <div class="col-md-4 text-center">
          <div class="glass-card p-4 h-100">
            <i class="fa-solid fa-users display-4 text-success mb-3"></i>
            <h5 class="text-theme-adaptive">Community Focused</h5>
            <p class="text-muted">Active community engagement and ongoing support</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Portfolio CTA -->
  <section class="py-5 bg-body-secondary">
    <div class="container text-center">
      <h2 class="mb-4 text-theme-adaptive">View My Work</h2>
      <p class="lead mb-4 text-theme-adaptive">Explore my portfolio across different platforms</p>
      <div class="d-flex flex-wrap gap-3 justify-content-center">
        <a href="https://www.linkedin.com/in/jenninexus" target="_blank" class="btn btn-primary">
          <i class="fa-brands fa-linkedin me-2"></i>LinkedIn
        </a>
        <a href="https://www.artstation.com/jenninexus" target="_blank" class="btn btn-dark">
          <i class="fa-solid fa-image me-2"></i>ArtStation
        </a>
        <a href="https://github.com/jenninexus" target="_blank" class="btn btn-dark">
          <i class="fa-brands fa-github me-2"></i>GitHub
        </a>
        <a href="resume.php" class="btn btn-outline-primary">
          <i class="fa-solid fa-file-lines me-2"></i>View Resume
        </a>
      </div>
    </div>
  </section>

  <!-- CONTACT SECTION - Prominent CTA for Hiring/Inquiries -->
  <section class="py-5 bg-theme-adaptive">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-8">
          <h2 class="mb-3 text-theme-adaptive">
            <i class="fa-solid fa-briefcase text-primary me-2"></i>Ready to Work Together?
          </h2>
          <p class="lead mb-3 text-theme-adaptive">Let's discuss your project! Available for:</p>
          <ul class="list-unstyled mb-0">
            <li class="mb-2 text-theme-adaptive"><i class="fa-solid fa-circle-check text-success me-2"></i>Full-time or contract game development positions</li>
            <li class="mb-2 text-theme-adaptive"><i class="fa-solid fa-circle-check text-success me-2"></i>Freelance 3D character modeling and technical art</li>
            <li class="mb-2 text-theme-adaptive"><i class="fa-solid fa-circle-check text-success me-2"></i>Voice acting for games, animations, and media</li>
            <li class="mb-2 text-theme-adaptive"><i class="fa-solid fa-circle-check text-success me-2"></i>Game jam collaborations and indie projects</li>
            <li class="mb-2 text-theme-adaptive"><i class="fa-solid fa-circle-check text-success me-2"></i>Consulting for Unity/Unreal/VR development</li>
            <li class="mb-2 text-theme-adaptive"><i class="fa-solid fa-circle-check text-success me-2"></i>Web Design & Hosting</li>
            <li class="mb-2 text-theme-adaptive"><i class="fa-solid fa-circle-check text-success me-2"></i>AI Tools for Business Consulting</li>
          </ul>
        </div>
        <div class="col-lg-4 text-center mt-4 mt-lg-0">
          <div class="glass-card border-primary border-3">
            <div class="card-body p-4">
              <h5 class="text-primary mb-3 text-theme-adaptive">Contact for Hire</h5>
              <p class="small mb-3 text-theme-adaptive">Email me directly for project inquiries, rates, and availability.</p>
              <a href="mailto:jenninexus@gmail.com?subject=Hiring Inquiry - Game Development Services&body=Hi Jenni,%0D%0A%0D%0AI'm interested in discussing:%0D%0A[ ] Game Development%0D%0A[ ] 3D Character Modeling%0D%0A[ ] Voice Acting%0D%0A[ ] Other:%0D%0A%0D%0AProject Details:%0D%0A" 
                 class="btn btn-primary btn-lg w-100 mb-2">
                <i class="fa-solid fa-envelope me-2"></i>jenninexus@gmail.com
              </a>
              <a href="/media" class="btn btn-outline-primary btn-lg w-100 mb-3">
                <i class="fa-solid fa-newspaper me-2"></i>Media Kit
              </a>
              <p class="small text-muted mb-0 mt-3">
                <i class="fa-solid fa-location-dot me-2"></i>Based in Tacoma/Seattle, WA<br>
                <i class="fa-solid fa-globe me-2"></i>Remote work available
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Support CTA -->
  <section class="py-5 bg-gradient text-white">
    <div class="container text-center">
      <h2 class="mb-3">Support My Work on Patreon</h2>
      <p class="lead mb-4">Get exclusive content, early access, and special perks</p>
      <div class="d-flex justify-content-center">
        <a href="patreon.php" class="btn btn-light btn-lg me-2">
          <i class="fa-solid fa-heart me-2"></i>Become a Patron
        </a>
        <a href="https://paypal.me/jenninexus" target="_blank" class="btn btn-outline-light btn-lg" aria-label="Tip on PayPal">
          <i class="fa-brands fa-paypal me-2"></i>Tip on PayPal
        </a>
      </div>
    </div>
  </section>

  <?php include __DIR__ . '/includes/footer.php'; ?>

  
  </body>
</html>
