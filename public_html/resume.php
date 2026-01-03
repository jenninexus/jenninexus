<?php
$activePage = 'resume';
$pageTitle = 'Resume - Professional Game Developer | JenniNexus | Seattle/Tacoma';
$pageDescription = 'Professional resume: Game Developer, 3D Artist, Voice Actor based in Tacoma/Seattle. Unity, Unreal Engine, Blender, Character Creator 4, VR development. Seattle Indies & SOBA member. Open to opportunities with game studios, tech companies, and investors.';
$pageKeywords = 'game developer resume Seattle, 3D artist CV Tacoma, Unity developer portfolio, Unreal Engine experience, voice actor resume, Seattle Indies developer, game industry professional Washington, hire experienced game developer, VR developer credentials, Steam published developer, Character Creator artist, Blender professional, technical artist resume, Seattle game studio jobs, Pacific Northwest game developer, game development experience, indie game developer CV, Seattle tech talent, Washington game industry';
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<?php include __DIR__ . '/includes/head.php'; ?>
<body>
<?php include __DIR__ . '/includes/header.php'; ?>



  <!-- Hero Section -->
  <section class="py-5" style="background: linear-gradient(135deg, #ec4899, #8b5cf6, #3b82f6); min-height: 40vh;">
    <div class="container" >
      <div class="row align-items-center" style="min-height: 30vh;">
        <div class="col-lg-8 mx-auto text-center text-white">
          <i class="fa-solid fa-file-user fa-spin display-1 mb-4" style="--fa-animation-duration: 4s;"></i>
          <h1 class="display-2 mb-4">Professional Resume</h1>
          <p class="lead">Voice Actor | Game Developer | 3D Artist | Content Creator</p>
          <div class="mt-4">
            <a href="<?= RES_ROOT ?>/pdfs/resume_jenninexus_2025.pdf" download class="btn btn-lg btn-light">
              <i class="fa-solid fa-download me-2"></i>Download Resume (PDF)
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Embedded Resume -->
  <section class="py-5">
    <div class="container">
      <div class="card border-0 shadow-lg" style="background: var(--bs-body-bg) !important;">
        <div class="card-body p-0" style="background: var(--bs-body-bg) !important;">
          <div class="ratio" style="--bs-aspect-ratio: 130%; background: var(--bs-body-bg);">
              <object 
              data="<?= RES_ROOT ?>/pdfs/resume_jenninexus_2025.pdf#view=FitH&toolbar=1&navpanes=0"
              type="application/pdf"
              title="JenniNexus Resume"
              style="border: none; width: 100%; height: 100%;">
                <embed 
                src="<?= RES_ROOT ?>/pdfs/resume_jenninexus_2025.pdf#view=FitH&toolbar=1&navpanes=0"
                type="application/pdf"
                title="JenniNexus Resume"
                style="border: none; width: 100%; height: 100%;">
              <p class="p-5 text-center" style="color: var(--bs-body-color);">
                <i class="fa-solid fa-file-pdf display-1 text-danger mb-3"></i><br>
                <strong style="color: var(--bs-body-color);">PDF viewer not available</strong><br>
                <span class="text-muted">Please download the PDF to view the resume</span>
                  <a href="<?= RES_ROOT ?>/pdfs/resume_jenninexus_2025.pdf" download class="btn btn-primary mt-3">
                  <i class="fa-solid fa-download me-2"></i>Download PDF Resume
                </a>
              </p>
            </object>
          </div>
        </div>
        <div class="card-footer bg-transparent border-0 text-center py-4" style="background: var(--bs-body-bg) !important;">
          <div class="d-flex flex-wrap gap-2 justify-content-center">
            <a href="<?= RES_ROOT ?>/pdfs/resume_jenninexus_2025.pdf" download class="btn btn-primary">
              <i class="fa-solid fa-download me-2"></i>Download Resume
            </a>
            <a href="/services" class="btn btn-outline-primary">
              <i class="fa-solid fa-briefcase me-2"></i>View Services
            </a>
            <a href="/media" class="btn btn-outline-secondary">
              <i class="fa-solid fa-newspaper me-2"></i>Media Kit
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Skills Section -->
  <section class="py-5 bg-body-secondary">
    <div class="container">
      <h2 class="text-center mb-5 text-theme-adaptive">Core Skills & Expertise</h2>
      <div class="row g-4">
        <div class="col-md-3">
          <div class="card h-100 text-center" style="background: var(--bs-body-bg) !important;">
            <div class="card-body">
              <i class="bi bi-mic-fill display-4 text-primary mb-3"></i>
              <h5 class="text-theme-adaptive">Voice Acting</h5>
              <p class="text-muted small">Character voices, narration, game dialogue</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card h-100 text-center" style="background: var(--bs-body-bg) !important;">
            <div class="card-body">
              <i class="bi bi-controller display-4 text-primary mb-3"></i>
              <h5 class="text-theme-adaptive">Game Development</h5>
              <p class="text-muted small">Unity, Unreal Engine, game design</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card h-100 text-center" style="background: var(--bs-body-bg) !important;">
            <div class="card-body">
              <i class="bi bi-box display-4 text-primary mb-3"></i>
              <h5 class="text-theme-adaptive">3D Modeling</h5>
              <p class="text-muted small">Character Creator 4, Blender, asset creation</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card h-100 text-center" style="background: var(--bs-body-bg) !important;">
            <div class="card-body">
              <i class="bi bi-camera-video-fill display-4 text-primary mb-3"></i>
              <h5 class="text-theme-adaptive">Content Creation</h5>
              <p class="text-muted small">YouTube, tutorials, community building</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section class="py-5 bg-body-secondary">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
          <h2 class="mb-4 text-theme-adaptive">
            <i class="bi bi-envelope text-primary me-2"></i>Get In Touch
          </h2>
          <p class="lead text-muted mb-4">
            Interested in working together? I'd love to hear from you!
          </p>
          
          <div class="row g-4 mb-4">
            <div class="col-md-6">
              <div class="card h-100" style="background: var(--bs-body-bg) !important;">
                <div class="card-body">
                  <i class="bi bi-envelope-fill display-5 text-primary mb-3"></i>
                  <h5 class="text-theme-adaptive">Email</h5>
                  <a href="mailto:jenninexus@gmail.com" class="btn btn-primary mt-2">
                    <i class="bi bi-envelope me-2"></i>jenninexus@gmail.com
                  </a>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card h-100" style="background: var(--bs-body-bg) !important;">
                <div class="card-body">
                  <i class="bi bi-discord display-5 text-primary mb-3"></i>
                  <h5 class="text-theme-adaptive">Discord</h5>
                  <a href="https://discord.gg/KYPh7Cp" target="_blank" class="btn btn-outline-primary mt-2">
                    <i class="bi bi-discord me-2"></i>Join Discord Server
                  </a>
                </div>
              </div>
            </div>
          </div>
          
          <div class="card border-0 shadow-sm" style="background: var(--background-secondary, var(--bs-secondary-bg)) !important;">
            <div class="card-body py-4">
              <h6 class="mb-3 text-theme-adaptive">Other Ways to Connect</h6>
              <div class="d-flex gap-3 justify-content-center flex-wrap">
                <a href="https://instagram.com/jenninexus" target="_blank" class="btn btn-outline-primary">
                  <i class="bi bi-instagram me-1"></i>Instagram
                </a>
                <a href="https://facebook.com/jenninexus" target="_blank" class="btn btn-outline-primary">
                  <i class="bi bi-facebook me-1"></i>Facebook
                </a>
                <a href="https://twitch.tv/jenninexus" target="_blank" class="btn btn-outline-primary">
                  <i class="bi bi-twitch me-1"></i>Twitch
                </a>
                <a href="links.php" class="btn btn-outline-primary">
                  <i class="bi bi-link-45deg me-1"></i>All Links
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="py-5 bg-body-secondary">
    <div class="container text-center">
      <h2 class="mb-4 text-theme-adaptive">Let's Work Together</h2>
      <p class="lead mb-4 text-theme-adaptive">Interested in collaborating? Check out my services or get in touch!</p>
      <div class="d-flex flex-wrap gap-3 justify-content-center">
        <a href="services.php" class="btn btn-primary btn-lg">
          <i class="bi bi-briefcase me-2"></i>View Services
        </a>
        <a href="links.php" class="btn btn-outline-primary btn-lg">
          <i class="bi bi-link-45deg me-2"></i>Contact & Social
        </a>
      </div>
    </div>
  </section>

  <?php include __DIR__ . '/includes/footer.php'; ?>

  
  </body>
</html>
