<head>
<?php 
if (!defined('RES_ROOT')) define('RES_ROOT', '/resources'); 

// Environment detection: Use non-minified assets in local dev, minified in production
$isLocal = in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1']) 
           || strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false
           || strpos($_SERVER['HTTP_HOST'] ?? '', '8002') !== false;
$assetSuffix = $isLocal ? '' : '.min';
?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="<?= $pageDescription ?? 'JenniNexus - Professional Game Developer, 3D Artist & Voice Actor in Seattle/Tacoma, WA. Unity, Unreal Engine, Blender, Character Creator. Available for hire.' ?>">
  <meta name="author" content="Jenni - JenniNexus">
  <meta name="keywords" content="<?= $pageKeywords ?? 'game development Seattle, game developer Tacoma, Unity developer Washington, Unreal Engine developer, 3D character artist, voice actor for games, Seattle Indies, indie game developer, game development for hire, VR game developer, Steam game developer, professional game developer, Seattle game studio, Tacoma game developer, Pacific Northwest game dev, character modeling, 3D art services, game design consulting, technical artist, Seattle game industry, Washington state game developer, hire game developer, freelance game developer Seattle, game jam developer, Seattle Online Broadcasters Association, SOBA member, indie game studio, Martian Games' ?>">
  
  <!-- Geographic & Organization SEO -->
  <meta name="geo.region" content="US-WA">
  <meta name="geo.placename" content="Tacoma, Seattle, Washington">
  <meta name="geo.position" content="47.2529;-122.4443">
  <meta name="ICBM" content="47.2529, -122.4443">
  
  <!-- Professional/Business SEO -->
  <meta name="rating" content="general">
  <meta name="target" content="game investors, tech investors, game studios, indie publishers, Allen Institute, Bill & Melinda Gates Foundation, Microsoft, Nintendo, Valve Corporation, Seattle tech companies, game development hiring managers, creative directors">
  <meta property="business:contact_data:locality" content="Tacoma">
  <meta property="business:contact_data:region" content="WA">
  <meta property="business:contact_data:country_name" content="USA">
  
  <!-- Organization Affiliations -->
  <meta name="organization" content="Seattle Indies, Seattle Online Broadcasters Association, Martian Games">
  <meta name="category" content="Game Development, 3D Art, Voice Acting, Content Creation">
  
  <!-- Open Graph for Social Sharing -->
  <meta property="og:title" content="<?= $pageTitle ?? 'JenniNexus - Game Developer & 3D Artist for Hire' ?>">
  <meta property="og:description" content="<?= $pageDescription ?? 'Professional game developer in Seattle/Tacoma. Unity, Unreal, Blender, VR. Available for contract work, game jams, and studio positions.' ?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= $pageUrl ?? 'https://jenninexus.com' ?>">
  <meta property="og:image" content="<?= $pageImage ?? 'https://jenninexus.com/resources/images/jenninexus-og-image.jpg' ?>">
  <meta property="og:locale" content="en_US">
  
  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="@jenninexus">
  <meta name="twitter:title" content="<?= $pageTitle ?? 'JenniNexus - Game Developer for Hire' ?>">
  <meta name="twitter:description" content="<?= $pageDescription ?? 'Seattle/Tacoma game developer specializing in Unity, Unreal, VR, and 3D character art.' ?>">
  
  <!-- Schema.org Person Markup for Rich Results -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Person",
    "name": "Jenni - JenniNexus",
    "url": "https://jenninexus.com",
    "image": "https://jenninexus.com/resources/images/profile.jpg",
    "sameAs": [
      "https://youtube.com/@jenninexus",
      "https://github.com/jenninexus",
      "https://discord.gg/KYPh7Cp",
      "https://twitch.tv/jenninexus"
    ],
    "jobTitle": "Game Developer, 3D Artist, Voice Actor",
    "worksFor": {
      "@type": "Organization",
      "name": "Martian Games"
    },
    "alumniOf": "Seattle Indies",
    "memberOf": [
      {
        "@type": "Organization",
        "name": "Seattle Indies"
      },
      {
        "@type": "Organization",
        "name": "Seattle Online Broadcasters Association"
      }
    ],
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Tacoma",
      "addressRegion": "WA",
      "addressCountry": "US"
    },
    "knowsAbout": [
      "Unity Game Development",
      "Unreal Engine",
      "Blender 3D Modeling",
      "Character Creator 4",
      "VR Game Development",
      "Voice Acting",
      "Game Design",
      "Technical Art",
      "3D Character Modeling"
    ],
    "email": "jenninexus@gmail.com",
    "offers": {
      "@type": "Offer",
      "itemOffered": {
        "@type": "Service",
        "name": "Game Development Services",
        "description": "Professional game development, 3D modeling, and voice acting services"
      }
    }
  }
  </script>
  
  <!-- Content Security Policy - Allow YouTube embeds, Google Fonts, CDN resources, Spotify, PDF embeds, TikTok, Facebook, Instagram, GameJolt, Sora -->
  <meta http-equiv="Content-Security-Policy" content="
    default-src 'self'; 
    script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://www.youtube.com https://youtube.com https://www.googleapis.com https://embed.twitch.tv https://player.twitch.tv https://www.tiktok.com https://connect.facebook.net https://www.instagram.com https://widgets.gamejolt.com https://gamejolt.com https://sora.chatgpt.com; 
    style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com https://fonts.cdnfonts.com; 
    font-src 'self' https://fonts.gstatic.com https://fonts.cdnfonts.com https://cdn.jsdelivr.net data:; 
    img-src 'self' https: data: blob:; 
    frame-src 'self' https://www.youtube.com https://youtube.com https://embed.twitch.tv https://player.twitch.tv https://open.spotify.com https://store.steampowered.com https://www.tiktok.com https://www.facebook.com https://www.instagram.com https://widgets.gamejolt.com https://gamejolt.com https://sora.chatgpt.com; 
    object-src 'self'; 
    media-src 'self' https: blob: data:; 
    worker-src 'self' blob:; 
    connect-src 'self' https://www.googleapis.com https://youtube.com https://rss2json.com https://cdn.jsdelivr.net https://store.steampowered.com https://www.tiktok.com https://www.facebook.com https://www.instagram.com https://widgets.gamejolt.com https://gamejolt.com https://sora.chatgpt.com https://api.allorigins.win https://corsproxy.io https://api.codetabs.com;
  ">
  
  <title><?= $pageTitle ?? 'JenniNexus' ?></title>

  <!-- Bootstrap 5.3.8 CSS (Local) -->
  <link href="<?= RES_ROOT ?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Parisienne&family=Montserrat:wght@900&display=swap" rel="stylesheet">
  
  <!-- Alien League Bold Font for Martian Games -->
  <link href="https://fonts.cdnfonts.com/css/alien-league" rel="stylesheet">
  
  <!-- Font Awesome 6.7.2 (Professional Icons) -->
  <link href="<?= RES_ROOT ?>/vendor/fontawesome/css/all.min.css" rel="stylesheet">
  
  <!-- Bootstrap Icons (Legacy support - will be phased out) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
  <!-- js-yaml for YAML parsing (required by youtube-grid.js) -->
  <script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
  
  <!-- ========================================================= -->
  <!-- Core CSS Files - Loaded in Order (All Pages) -->
  <!-- ========================================================= -->
  <!-- Loading Order: main → all-themes → jenni-fonts → custom → media → mixins -->
  <!-- Environment-aware: .css for local dev, .min.css for production -->
  
  <!-- 1. Main Stylesheet - Base styles and utilities -->
  <link href="<?= RES_ROOT ?>/css/main<?= $assetSuffix ?>.css" rel="stylesheet">
  
  <!-- 2. Theme System - Light/dark mode variables and platform colors -->
  <link href="<?= RES_ROOT ?>/css/all-themes<?= $assetSuffix ?>.css" rel="stylesheet">
  
  <!-- 2.5 Pastel Backgrounds - Light mode color palettes (NO WHITE) -->
  <link href="<?= RES_ROOT ?>/css/pastel-backgrounds<?= $assetSuffix ?>.css" rel="stylesheet">
  
  <!-- 3. Typography & Font Color System - Logo gradients, text contrast utilities -->
  <link href="<?= RES_ROOT ?>/css/jenni-fonts<?= $assetSuffix ?>.css" rel="stylesheet">
  
  <!-- 4. Custom CSS Overrides - Glass effects, animations, site-wide enhancements -->
  <link href="<?= RES_ROOT ?>/css/custom<?= $assetSuffix ?>.css" rel="stylesheet">
  
  <!-- 5. Media & Video Styles - Image/video display, responsive video grids -->
  <link href="<?= RES_ROOT ?>/css/media<?= $assetSuffix ?>.css" rel="stylesheet">
  
  <!-- 6. Mixins & Utility Classes - Theme-aware utilities and helper classes -->
  <link href="<?= RES_ROOT ?>/css/mixins<?= $assetSuffix ?>.css" rel="stylesheet">
  
  <!-- mobile-improvements.css archived 2025-11-05 - functionality moved to custom.css -->
  
  <!-- Favicon: prefer top-level /favicon.ico, otherwise use resources image -->
  <link rel="icon" href="<?= RES_ROOT ?>/../favicon.ico" />
  <link rel="icon" href="<?= RES_ROOT ?>/images/favicon-32x32.png" sizes="32x32" type="image/png" />
  
  <!-- Expose RES_ROOT to client-side JS so scripts can build resource paths reliably -->
  <script>
    window.RES_ROOT = window.RES_ROOT || '<?= defined("RES_ROOT") ? RES_ROOT : "/resources" ?>';
  </script>
  
  <?php
  // Page-specific custom CSS - Environment-aware loading
  if (isset($customCSS) && is_array($customCSS)) {
    foreach ($customCSS as $cssFile) {
      // Remove .min if present, then add environment-aware suffix
      $cssFile = preg_replace('/\.min\.css$/', '.css', $cssFile);
      $cssFile = preg_replace('/\.css$/', $assetSuffix . '.css', $cssFile);
      echo '<link href="' . htmlspecialchars($cssFile) . '" rel="stylesheet">' . "\n  ";
    }
  }
  ?>
</head>
