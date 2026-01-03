<?php
// Defensive include guard: if header has already been rendered, skip duplicate output.
if (defined('JENNINEXUS_HEADER_RENDERED') && JENNINEXUS_HEADER_RENDERED) {
  return;
}
define('JENNINEXUS_HEADER_RENDERED', true);
?>
<!-- Navigation -->
<!-- Bootstrap 5.3.8 Navbar with Offcanvas pattern (from official examples) -->
<nav class="navbar navbar-dark fixed-top shadow site-glass">
  <div class="container">
    <?php $logoClass = 'navbar-brand ps-2 ps-md-0'; include __DIR__ . '/logo.php'; ?>
    
    <!-- Desktop Navigation (hidden on mobile) -->
    <div class="d-none d-lg-flex align-items-center">
      <ul class="navbar-nav flex-row align-items-center gap-2 me-3">
        <li class="nav-item">
          <a class="nav-link <?= ($activePage ?? '') === 'home' ? 'active' : '' ?>" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($activePage ?? '') === 'gamedev' ? 'active' : '' ?>" href="/gamedev">Game Dev</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($activePage ?? '') === 'diy' ? 'active' : '' ?>" href="/diy">DIY</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($activePage ?? '') === 'blog' ? 'active' : '' ?>" href="/blog">Blog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($activePage ?? '') === 'services' ? 'active' : '' ?>" href="/services">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= ($activePage ?? '') === 'sitemap' ? 'active' : '' ?>" href="/sitemap" title="Site Map">
            <i class="fa-solid fa-sitemap"></i>
          </a>
        </li>
      </ul>
      <div class="ms-2">
        <button class="btn btn-link p-0" id="themeToggle" aria-label="Toggle theme">
          <!-- Icon injected by theme-toggle.js -->
        </button>
      </div>
    </div>
    
    <!-- Mobile Menu Button -->
    <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-label="Toggle navigation">
      <i class="fa-solid fa-bars-staggered"></i>
    </button>
  </div>
</nav>

<!-- Mobile Offcanvas Menu -->
<div class="offcanvas offcanvas-start site-glass text-white" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
  <div class="offcanvas-header border-bottom border-white border-opacity-10">
    <div class="offcanvas-title" id="mobileMenuLabel">
      <?php $logoLink = false; $logoSize = 'h5'; include __DIR__ . '/logo.php'; ?>
    </div>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body d-flex flex-column">
    <ul class="navbar-nav mb-auto">
      <li class="nav-item">
        <a class="nav-link <?= ($activePage ?? '') === 'home' ? 'active' : '' ?>" href="/"><i class="fa-solid fa-house"></i>Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= ($activePage ?? '') === 'gamedev' ? 'active' : '' ?>" href="/gamedev"><i class="fa-solid fa-gamepad"></i>Game Dev</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= ($activePage ?? '') === 'diy' ? 'active' : '' ?>" href="/diy"><i class="fa-solid fa-scissors"></i>DIY</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= ($activePage ?? '') === 'blog' ? 'active' : '' ?>" href="/blog"><i class="fa-solid fa-pen-to-square"></i>Blog</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= ($activePage ?? '') === 'services' ? 'active' : '' ?>" href="/services"><i class="fa-solid fa-briefcase"></i>Services</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= ($activePage ?? '') === 'sitemap' ? 'active' : '' ?>" href="/sitemap" title="Site Map"><i class="fa-solid fa-sitemap"></i>Sitemap</a>
      </li>
    </ul>
    
    <div class="offcanvas-footer mt-4">
      <hr class="mb-4 border-white border-opacity-10">
      
      <div class="justify-content-center social-links-badass mb-4">
        <a href="https://discord.gg/KYPh7Cp" class="link-discord" title="Discord" target="_blank">
          <i class="fa-brands fa-discord"></i>
        </a>
        <a href="https://youtube.com/@jenninexus" class="link-youtube" title="YouTube" target="_blank">
          <i class="fa-brands fa-youtube"></i>
        </a>
        <a href="https://twitch.tv/jenninexus" class="link-twitch" title="Twitch" target="_blank">
          <i class="fa-brands fa-twitch"></i>
        </a>
        <a href="https://patreon.com/jenninexus" class="link-patreon" title="Patreon" target="_blank">
          <i class="fa-brands fa-patreon"></i>
        </a>
      </div>
      
      <!-- Mobile Theme Toggle -->
      <div class="d-flex justify-content-center">
        <button class="btn btn-link p-0" id="themeToggleMobile" type="button" aria-label="Toggle theme (mobile)">
          <i class="fa-solid fa-moon-stars"></i>
        </button>
      </div>
    </div>
  </div>
</div>
