<!doctype html>
<html lang="en" data-bs-theme="dark">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Martian Games - Indie Game Development</title>
  <meta name="description" content="Indie game development by Shade Muse featuring retro-inspired multiplayer mayhem">
  
  <!-- Bootstrap 5.3.8 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  
  <!-- Font Awesome (for brand icons) -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
  
  <!-- Google Fonts (Martian Games Theme) -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&display=swap" rel="stylesheet">
  
  <style>
    /* Martian Games Portable Theme */
    :root {
      --mg-primary: #66c0f4;
      --mg-bg-dark: #0b1220;
      --mg-bg-darker: #171a21;
      --mg-card-bg: #1b2838;
    }
    
    body {
      font-family: 'Montserrat', sans-serif;
      background: linear-gradient(135deg, #0f1724 0%, #1b2838 100%);
      min-height: 100vh;
      padding-top: 70px; /* Account for fixed navbar */
    }
    
    /* Fixed Navbar */
    .navbar-fixed {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1030;
      transition: all 0.3s ease;
    }
    
    .navbar-fixed.scrolled {
      background: rgba(27, 40, 56, 0.95) !important;
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    }
    
    /* Mobile Offcanvas */
    .offcanvas {
      background: linear-gradient(135deg, var(--mg-bg-darker), var(--mg-card-bg));
    }
    
    .offcanvas-header {
      border-bottom: 1px solid rgba(102, 192, 244, 0.2);
    }
    
    .offcanvas .nav-link {
      color: #c7d5e0;
      padding: 0.75rem 1rem;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    
    .offcanvas .nav-link:hover {
      background: rgba(102, 192, 244, 0.1);
      color: var(--mg-primary);
      transform: translateX(8px);
    }
    
    .offcanvas .nav-link i {
      width: 24px;
      text-align: center;
    }
    
    /* Hero Section */
    .mg-hero {
      background: linear-gradient(135deg, var(--mg-bg-darker) 0%, var(--mg-card-bg) 100%);
      border-bottom: 2px solid var(--mg-primary);
    }
    
    .mg-title {
      font-family: 'Montserrat', sans-serif;
      font-weight: 800;
      font-size: clamp(2rem, 5vw, 3.5rem);
      color: var(--mg-primary);
      text-shadow: 0 0 20px rgba(102, 192, 244, 0.5);
      letter-spacing: 2px;
    }
    
    /* Social Buttons */
    .btn-steam {
      background: linear-gradient(135deg, #171a21, #1b2838);
      border: 2px solid var(--mg-primary);
      color: #c7d5e0;
      transition: all 0.3s ease;
    }
    
    .btn-steam:hover {
      background: linear-gradient(135deg, #1b2838, #171a21);
      border-color: #ffffff;
      color: #ffffff;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(102, 192, 244, 0.3);
    }
    
    .btn-youtube {
      background: linear-gradient(135deg, #ff0000, #cc0000);
      border: 2px solid #ff0000;
      color: white;
      transition: all 0.3s ease;
    }
    
    .btn-youtube:hover {
      background: linear-gradient(135deg, #cc0000, #ff0000);
      border-color: #ff4444;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(255, 0, 0, 0.4);
    }
    
    .btn-patreon-mg {
      background: linear-gradient(135deg, #ff424d, #e63946);
      border: 2px solid #ff424d;
      color: white;
      transition: all 0.3s ease;
    }
    
    .btn-patreon-mg:hover {
      background: linear-gradient(135deg, #e63946, #ff424d);
      border-color: #ff6b72;
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(255, 66, 77, 0.4);
    }
    
    /* Video Grid Cards */
    .video-card {
      background: var(--mg-bg-dark);
      border: 1px solid rgba(102, 192, 244, 0.2);
      border-radius: 8px;
      overflow: hidden;
      transition: all 0.3s ease;
      height: 100%;
    }
    
    .video-card:hover {
      transform: translateY(-8px);
      border-color: var(--mg-primary);
      box-shadow: 0 12px 24px rgba(102, 192, 244, 0.3);
    }
    
    .video-card img {
      width: 100%;
      height: auto;
      transition: transform 0.3s ease;
    }
    
    .video-card:hover img {
      transform: scale(1.05);
    }
    
    .video-card-body {
      padding: 1rem;
    }
    
    .video-title {
      font-size: 0.95rem;
      font-weight: 600;
      color: #c7d5e0;
      margin-bottom: 0.5rem;
      line-height: 1.4;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    
    .video-description {
      font-size: 0.85rem;
      color: #8899a6;
      line-height: 1.4;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    
    /* Loading Placeholder */
    .placeholder-card {
      background: var(--mg-bg-dark);
      border: 1px solid rgba(102, 192, 244, 0.1);
      border-radius: 8px;
      overflow: hidden;
      height: 100%;
      padding: 1rem;
    }
    
    .placeholder-shimmer {
      background: linear-gradient(90deg, #0b1220 0%, #1b2838 50%, #0b1220 100%);
      background-size: 200% 100%;
      animation: shimmer 1.5s infinite;
    }
    
    @keyframes shimmer {
      0% { background-position: 200% 0; }
      100% { background-position: -200% 0; }
    }
    
    /* Section Spacing */
    .mg-section {
      padding: 3rem 0;
    }
    
    .section-title {
      color: var(--mg-primary);
      font-weight: 700;
      margin-bottom: 1rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
      .mg-title { font-size: 2rem; }
      .mg-section { padding: 2rem 0; }
      body { padding-top: 60px; }
    }
    
    /* Theme Toggle Button */
    #themeToggle, #themeToggleMobile {
      background: none;
      border: none;
      color: #c7d5e0;
      cursor: pointer;
      transition: all 0.3s ease;
      padding: 0.5rem;
    }
    
    #themeToggle:hover {
      color: var(--mg-primary);
      transform: rotate(15deg) scale(1.1);
    }
    
    #themeToggleMobile {
      width: 100%;
      text-align: left;
      border: 1px solid rgba(102, 192, 244, 0.3);
      border-radius: 8px;
      padding: 0.75rem 1rem;
    }
    
    #themeToggleMobile:hover {
      background: rgba(102, 192, 244, 0.1);
      border-color: var(--mg-primary);
    }
    
    /* Light Theme Overrides */
    [data-bs-theme="light"] body {
      background: linear-gradient(135deg, #e8f4f8 0%, #d4e8f0 100%);
      color: #1b2838;
    }
    
    [data-bs-theme="light"] .navbar-fixed {
      background: rgba(255, 255, 255, 0.95) !important;
    }
    
    [data-bs-theme="light"] .mg-hero {
      background: linear-gradient(135deg, #ffffff 0%, #f0f7fa 100%);
      color: #1b2838;
    }
    
    [data-bs-theme="light"] .mg-title {
      color: #1b5e7e;
    }
    
    [data-bs-theme="light"] .video-card {
      background: #ffffff;
      border-color: rgba(27, 56, 72, 0.2);
    }
    
    [data-bs-theme="light"] .video-card:hover {
      border-color: #1b5e7e;
      box-shadow: 0 12px 24px rgba(27, 94, 126, 0.2);
    }
    
    [data-bs-theme="light"] .video-title {
      color: #1b2838;
    }
    
    [data-bs-theme="light"] .video-description {
      color: #4a5f6d;
    }
    
    [data-bs-theme="light"] .placeholder-card {
      background: #f8f9fa;
      border-color: rgba(27, 56, 72, 0.1);
    }
    
    [data-bs-theme="light"] .section-title {
      color: #1b5e7e;
    }
    
    [data-bs-theme="light"] .offcanvas {
      background: linear-gradient(135deg, #ffffff, #f0f7fa);
    }
    
    [data-bs-theme="light"] .offcanvas .nav-link {
      color: #1b2838;
    }
    
    [data-bs-theme="light"] .offcanvas .nav-link:hover {
      background: rgba(27, 94, 126, 0.1);
      color: #1b5e7e;
    }
  </style>
</head>
<body>

  <!-- Fixed Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark navbar-fixed" style="background-color: var(--mg-card-bg);">
    <div class="container">
      <a class="navbar-brand fw-bold" href="/" style="color: var(--mg-primary);">
        MARTIAN GAMES
      </a>
      
      <!-- Mobile Menu Button (visible on small screens) -->
      <div class="d-lg-none d-flex align-items-center gap-2">
        <button class="btn btn-link" id="themeToggle" aria-label="Toggle theme">
          <i class="bi bi-moon-stars-fill fs-5"></i>
        </button>
        <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" style="width: 48px; height: 48px; padding: 0;">
          <i class="bi bi-list" style="font-size: 1.5rem;"></i>
        </button>
      </div>
      
      <!-- Desktop Navigation -->
      <div class="collapse navbar-collapse d-none d-lg-block">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item">
            <a class="nav-link" href="https://martiangames.com" target="_blank">
              <i class="bi bi-globe me-1"></i>Website
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://steamcommunity.com/groups/martian-games" target="_blank">
              <i class="fa-brands fa-steam me-1"></i>Steam
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://www.youtube.com/@martiangames" target="_blank">
              <i class="fa-brands fa-youtube me-1"></i>YouTube
            </a>
          </li>
          <li class="nav-item ms-2">
            <button class="btn btn-link nav-link" id="themeToggleDesktop" aria-label="Toggle theme">
              <i class="bi bi-moon-stars-fill"></i>
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Mobile Offcanvas Menu -->
  <div class="offcanvas offcanvas-start text-white" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title fw-bold" id="mobileMenuLabel" style="color: var(--mg-primary);">
        MARTIAN GAMES
      </h5>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="navbar-nav">
        <li class="nav-item mb-2">
          <a class="nav-link" href="https://martiangames.com" target="_blank">
            <i class="bi bi-globe me-2"></i>Website
          </a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="https://steamcommunity.com/groups/martian-games" target="_blank">
            <i class="fa-brands fa-steam me-2"></i>Steam Group
          </a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="https://www.youtube.com/@martiangames" target="_blank">
            <i class="fa-brands fa-youtube me-2"></i>YouTube
          </a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="https://www.patreon.com/c/martiangames" target="_blank">
            <i class="fa-brands fa-patreon me-2"></i>Patreon
          </a>
        </li>
      </ul>
      
      <hr class="my-4 border-secondary opacity-25">
      
      <!-- Mobile Social Links -->
      <div class="d-flex gap-3 justify-content-center mb-4">
        <a href="https://steamcommunity.com/groups/martian-games" class="text-white" title="Steam">
          <i class="fa-brands fa-steam fs-4"></i>
        </a>
        <a href="https://www.youtube.com/@martiangames" class="text-white" title="YouTube">
          <i class="fa-brands fa-youtube fs-4"></i>
        </a>
        <a href="https://www.patreon.com/c/martiangames" class="text-white" title="Patreon">
          <i class="fa-brands fa-patreon fs-4"></i>
        </a>
      </div>
      
      <!-- Mobile Theme Toggle -->
      <div class="d-grid">
        <button class="btn btn-outline-light" id="themeToggleMobile" type="button" aria-label="Toggle theme">
          <i class="bi bi-moon-stars-fill me-2"></i>Dark Mode
        </button>
      </div>
    </div>
  </div>

  <!-- Hero Section -->
  <section class="mg-hero text-white py-5">
    <div class="container py-4">
      <div class="text-center">
        <h1 class="mg-title mb-3">MARTIAN GAMES</h1>
        <p class="lead text-white-50 mb-4">Indie game development by Shade Muse featuring retro-inspired multiplayer mayhem</p>
        
        <!-- Social Links -->
        <div class="d-flex gap-3 justify-content-center mb-4 flex-wrap">
          <a href="https://martiangames.com" target="_blank" rel="noopener" class="btn btn-outline-info">
            <i class="bi bi-globe me-1"></i>Visit MartianGames.com
          </a>
          <a href="https://steamcommunity.com/groups/martian-games" class="btn btn-steam d-inline-flex align-items-center gap-2" target="_blank" rel="noopener">
            <i class="fa-brands fa-steam fs-5"></i>
            <span>Steam Group</span>
          </a>
          <a href="https://www.youtube.com/@martiangames" class="btn btn-youtube d-inline-flex align-items-center gap-2" target="_blank" rel="noopener">
            <i class="fa-brands fa-youtube fs-5"></i>
            <span>YouTube</span>
          </a>
          <a href="https://www.patreon.com/c/martiangames" class="btn btn-patreon-mg d-inline-flex align-items-center gap-2" target="_blank" rel="noopener">
            <i class="fa-brands fa-patreon fs-5"></i>
            <span>Patreon</span>
          </a>
        </div>
        
        <!-- Description -->
        <div class="row justify-content-center mt-4">
          <div class="col-lg-8">
            <p class="text-white-50">Experience fast-paced retro multiplayer action with Tank Off, Air Wars, Motor Wars, and more! Classic arcade-style gameplay with modern online multiplayer.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <div class="container mg-section">
    
    <!-- Devlogs Section -->
    <section class="mb-5">
      <h2 class="section-title text-center mb-4">Martian Games Devlogs</h2>
      <p class="text-center text-muted mb-4">Behind-the-scenes development videos and updates</p>
      <div id="devlogs-grid" class="row g-4">
        <!-- Loading placeholders -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
          <div class="placeholder-card">
            <div class="placeholder-shimmer" style="height:180px;border-radius:6px;"></div>
            <div class="placeholder-shimmer mt-3" style="height:18px;width:80%;border-radius:4px;"></div>
            <div class="placeholder-shimmer mt-2" style="height:14px;width:100%;border-radius:4px;"></div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
          <div class="placeholder-card">
            <div class="placeholder-shimmer" style="height:180px;border-radius:6px;"></div>
            <div class="placeholder-shimmer mt-3" style="height:18px;width:80%;border-radius:4px;"></div>
            <div class="placeholder-shimmer mt-2" style="height:14px;width:100%;border-radius:4px;"></div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Gameplay Section -->
    <section class="mb-5">
      <h2 class="section-title text-center mb-4">Martian Games Gameplay</h2>
      <p class="text-center text-muted mb-4">Gameplay showcases and walkthroughs</p>
      <div id="gameplay-grid" class="row g-4">
        <!-- Loading placeholders -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
          <div class="placeholder-card">
            <div class="placeholder-shimmer" style="height:180px;border-radius:6px;"></div>
            <div class="placeholder-shimmer mt-3" style="height:18px;width:80%;border-radius:4px;"></div>
            <div class="placeholder-shimmer mt-2" style="height:14px;width:100%;border-radius:4px;"></div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
          <div class="placeholder-card">
            <div class="placeholder-shimmer" style="height:180px;border-radius:6px;"></div>
            <div class="placeholder-shimmer mt-3" style="height:18px;width:80%;border-radius:4px;"></div>
            <div class="placeholder-shimmer mt-2" style="height:14px;width:100%;border-radius:4px;"></div>
          </div>
        </div>
      </div>
    </section>
    
  </div>

  <!-- Bootstrap 5.3.8 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Theme Toggle Script (Embedded from JenniNexus) -->
  <script>
    (function() {
      'use strict';

      // Get DOM elements
      const themeToggle = document.getElementById('themeToggleDesktop');
      const themeToggleMobile = document.getElementById('themeToggleMobile');
      const themeToggleIcon = document.getElementById('themeToggle');
      const html = document.documentElement;
      
      // Icon elements
      const moonIcon = '<i class="bi bi-moon-stars-fill"></i>';
      const sunIcon = '<i class="bi bi-sun-fill"></i>';
      const moonIconMobile = '<i class="bi bi-moon-stars-fill me-2"></i>Dark Mode';
      const sunIconMobile = '<i class="bi bi-sun-fill me-2"></i>Light Mode';

      /**
       * Get stored theme or default to 'dark'
       */
      function getStoredTheme() {
        return localStorage.getItem('mg-theme') || 'dark';
      }

      /**
       * Store theme preference
       */
      function setStoredTheme(theme) {
        localStorage.setItem('mg-theme', theme);
      }

      /**
       * Apply theme to document
       */
      function setTheme(theme) {
        html.setAttribute('data-bs-theme', theme);
        updateToggleIcons(theme);
      }

      /**
       * Update all theme toggle button icons
       */
      function updateToggleIcons(theme) {
        const isDark = theme === 'dark';
        
        // Desktop toggle
        if (themeToggle) {
          themeToggle.innerHTML = isDark ? moonIcon : sunIcon;
          themeToggle.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
        }
        
        // Mobile icon-only toggle
        if (themeToggleIcon) {
          themeToggleIcon.innerHTML = isDark ? moonIcon : sunIcon;
          themeToggleIcon.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
        }
        
        // Mobile text toggle
        if (themeToggleMobile) {
          themeToggleMobile.innerHTML = isDark ? moonIconMobile : sunIconMobile;
          themeToggleMobile.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
        }
      }

      /**
       * Toggle between light and dark themes
       */
      function toggleTheme() {
        const currentTheme = html.getAttribute('data-bs-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        setTheme(newTheme);
        setStoredTheme(newTheme);
      }

      /**
       * Initialize theme on page load
       */
      function initTheme() {
        const storedTheme = getStoredTheme();
        setTheme(storedTheme);
      }

      /**
       * Add event listeners
       */
      function initEventListeners() {
        if (themeToggle) {
          themeToggle.addEventListener('click', toggleTheme);
        }
        if (themeToggleIcon) {
          themeToggleIcon.addEventListener('click', toggleTheme);
        }
        if (themeToggleMobile) {
          themeToggleMobile.addEventListener('click', toggleTheme);
        }
      }

      /**
       * Handle system theme preference changes
       */
      function watchSystemTheme() {
        const darkModeQuery = window.matchMedia('(prefers-color-scheme: dark)');
        
        darkModeQuery.addEventListener('change', (e) => {
          // Only auto-switch if user hasn't set a preference
          if (!localStorage.getItem('mg-theme')) {
            const newTheme = e.matches ? 'dark' : 'light';
            setTheme(newTheme);
          }
        });
      }

      /**
       * Add scroll effect to navbar
       */
      function initNavbarScroll() {
        const navbar = document.querySelector('.navbar-fixed');
        if (!navbar) return;

        window.addEventListener('scroll', () => {
          if (window.pageYOffset > 50) {
            navbar.classList.add('scrolled');
          } else {
            navbar.classList.remove('scrolled');
          }
        });
      }

      /**
       * Initialize everything when DOM is ready
       */
      function init() {
        initTheme();
        initEventListeners();
        watchSystemTheme();
        initNavbarScroll();
      }

      // Run initialization
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
      } else {
        init();
      }

    })();
  </script>
  
  <!-- Embedded YouTube RSS Loader -->
  <script>
    (function() {
      'use strict';
      
      // Configuration
      const PLAYLISTS = {
        devlogs: 'PL5RIMPpbzR6iA9rAMaDX-B2QfKMQkODwq',
        gameplay: 'PL6WnzXOaRqA1sfMS1N7EoESHKaTZ2RHh4'
      };
      
      const MAX_VIDEOS = 8; // Videos per playlist
      
      /**
       * Fetch YouTube RSS feed via CORS proxy
       */
      async function fetchPlaylistVideos(playlistId, maxVideos = 6) {
        try {
          // Use public CORS proxy to fetch YouTube RSS
          const rssUrl = `https://www.youtube.com/feeds/videos.xml?playlist_id=${playlistId}`;
          const proxyUrl = `https://api.allorigins.win/raw?url=${encodeURIComponent(rssUrl)}`;
          
          const response = await fetch(proxyUrl);
          if (!response.ok) throw new Error('Failed to fetch playlist');
          
          const xmlText = await response.text();
          const parser = new DOMParser();
          const xmlDoc = parser.parseFromString(xmlText, 'text/xml');
          
          const entries = xmlDoc.querySelectorAll('entry');
          const videos = [];
          
          for (let i = 0; i < Math.min(entries.length, maxVideos); i++) {
            const entry = entries[i];
            const videoId = entry.querySelector('videoId')?.textContent;
            const title = entry.querySelector('title')?.textContent;
            const published = entry.querySelector('published')?.textContent;
            const mediaGroup = entry.querySelector('group');
            const description = mediaGroup?.querySelector('description')?.textContent || '';
            
            if (videoId && title) {
              videos.push({
                id: videoId,
                title: title,
                description: description,
                thumbnail: `https://i.ytimg.com/vi/${videoId}/mqdefault.jpg`,
                url: `https://www.youtube.com/watch?v=${videoId}`,
                publishedAt: published
              });
            }
          }
          
          return videos;
        } catch (error) {
          console.error('Error fetching playlist:', error);
          return [];
        }
      }
      
      /**
       * Render video grid
       */
      function renderVideoGrid(containerId, videos) {
        const container = document.getElementById(containerId);
        if (!container) return;
        
        if (videos.length === 0) {
          container.innerHTML = '<div class="col-12"><div class="alert alert-secondary">No videos found</div></div>';
          return;
        }
        
        container.innerHTML = videos.map(video => `
          <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <a href="${video.url}" target="_blank" rel="noopener" class="text-decoration-none">
              <div class="video-card">
                <div class="ratio ratio-16x9">
                  <img src="${video.thumbnail}" alt="${escapeHtml(video.title)}" loading="lazy">
                </div>
                <div class="video-card-body">
                  <div class="video-title">${escapeHtml(video.title)}</div>
                  ${video.description ? `<div class="video-description">${escapeHtml(video.description)}</div>` : ''}
                </div>
              </div>
            </a>
          </div>
        `).join('');
      }
      
      /**
       * Escape HTML for safe rendering
       */
      function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
      }
      
      /**
       * Initialize and load all playlists
       */
      async function init() {
        try {
          // Load devlogs
          const devlogVideos = await fetchPlaylistVideos(PLAYLISTS.devlogs, MAX_VIDEOS);
          renderVideoGrid('devlogs-grid', devlogVideos);
          
          // Load gameplay
          const gameplayVideos = await fetchPlaylistVideos(PLAYLISTS.gameplay, MAX_VIDEOS);
          renderVideoGrid('gameplay-grid', gameplayVideos);
          
        } catch (error) {
          console.error('Error loading playlists:', error);
        }
      }
      
      // Start when DOM is ready
      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
      } else {
        init();
      }
      
    })();
  </script>

</body>
</html>
