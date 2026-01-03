<?php
// Dual-mode sitemap: HTML (default) and XML (when ?format=xml, Accept: application/xml, or requested as sitemap.xml)
$activePage = 'sitemap';
$pageTitle = 'Sitemap - JenniNexus';
$pageDescription = 'Human-readable sitemap for JenniNexus. Quickly find main pages, games, and blog posts.';
$pageKeywords = 'sitemap, site map, jenni nexus, games, blog';

// Determine whether to emit XML
// Only emit XML if explicitly requested via ?format=xml or .xml extension
// DO NOT auto-detect from Accept header (causes issues with dev servers)
$wantXml = false;
if (isset($_GET['format']) && $_GET['format'] === 'xml') {
    $wantXml = true;
} else {
    // If requested URL ends with sitemap.xml (basic router compatibility)
    $uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    if (substr($uri, -11) === 'sitemap.xml') {
        $wantXml = true;
    }
}

// Helper: collect pages
function collect_pages()
{
    $pages = [];

    // Main pages (path relative to site root)
    $main = ['/' => 'Home', '/ai' => 'AI', '/gamedev' => 'Game Dev', '/gaming' => 'Gaming', '/music' => 'Music', '/diy' => 'DIY', '/live' => 'Live', '/blog' => 'Blog', '/media' => 'Media', '/resume' => 'Resume', '/services' => 'Services', '/links' => 'Links', '/patreon' => 'Patreon', '/vip' => 'VIP', '/youtube' => 'YouTube'];
    foreach ($main as $path => $label) {
        $pages[] = ['loc' => $path, 'label' => $label, 'file' => __DIR__ . ltrim($path, '/') . '.php'];
    }

    // Games
    $gameDir = __DIR__ . '/game';
    if (is_dir($gameDir)) {
        $gameFiles = glob($gameDir . '/*.php');
        // Custom game name mappings for proper capitalization
        $gameNames = [
            'blueballs' => 'Blue Balls',
            'botborgs' => 'BotBorgs',
            'catgame' => 'Cat Game',
            'cleanupinisle3' => 'Clean Up in Isle 3',
            'cowdefender' => 'Cow Defender',
            'gamejams' => 'Game Jams',
            'graveyardsmashers' => 'Graveyard Smashers',
            'jennistyles' => 'Jenni Styles',
            'martiangames' => 'Martian Games',
            'momshouse' => 'Mom\'s House',
            'purgatoryfell' => 'Purgatory Fell',
            'soccercow' => 'Soccer Cow'
        ];
        foreach ($gameFiles as $gf) {
            $base = basename($gf, '.php');
            $label = isset($gameNames[$base]) ? $gameNames[$base] : ucwords(str_replace('-', ' ', $base));
            $pages[] = ['loc' => '/game/' . $base, 'label' => $label, 'file' => $gf];
        }
    }

    // Blog posts
    $blogDir = __DIR__ . '/blog';
    if (is_dir($blogDir)) {
        $blogFiles = glob($blogDir . '/*.php');
        foreach ($blogFiles as $bf) {
            $base = basename($bf, '.php');
            $pages[] = ['loc' => '/blog/' . $base, 'label' => ucwords(str_replace('-', ' ', $base)), 'file' => $bf];
        }
    }

    return $pages;
}

// Build full absolute URL from path
function absolute_url($path)
{
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'jenninexus.com';
    $base = $scheme . '://' . $host;
    // Ensure single slash
    if ($path === '/') return $base . '/';
    return $base . '/' . ltrim($path, '/');
}

// If XML requested, output sitemap XML
if ($wantXml) {
    $pages = collect_pages();
    header('Content-Type: application/xml; charset=utf-8');
    $xml = new XMLWriter();
    $xml->openMemory();
    $xml->startDocument('1.0', 'UTF-8');
    $xml->setIndent(true);
    $xml->startElement('urlset');
    $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

    foreach ($pages as $p) {
        $loc = absolute_url($p['loc']);
        $lastmod = '';
        if (!empty($p['file']) && file_exists($p['file'])) {
            $lastmod = date('Y-m-d', filemtime($p['file']));
        }

        $xml->startElement('url');
        $xml->writeElement('loc', $loc);
        if ($lastmod) $xml->writeElement('lastmod', $lastmod);
        $xml->writeElement('changefreq', 'weekly');
        $xml->writeElement('priority', '0.5');
        $xml->endElement(); // url
    }

    $xml->endElement(); // urlset
    echo $xml->outputMemory();
    exit;
}

// Otherwise render the human-friendly HTML sitemap
$pages = collect_pages();
$customCSS = [RES_ROOT . '/css/link-cards' . ($assetSuffix ?? '') . '.css'];
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
<?php include __DIR__ . '/includes/head.php'; ?>
<body>

<?php include __DIR__ . '/includes/header.php'; ?>

<!-- Hero Section -->
<section class="py-5" style="background: linear-gradient(135deg, var(--jenni-primary), var(--jenni-secondary)); min-height: 40vh;">
  <div class="container" >
    <div class="row align-items-center" style="min-height: 30vh;">
      <div class="col-lg-8 mx-auto text-center text-white">
        <i class="fa-solid fa-sitemap fa-spin display-1 mb-4" style="--fa-animation-duration: 4s;"></i>
        <h1 class="display-2 mb-4">Site Map</h1>
        <p class="lead">Explore all pages and content on JenniNexus</p>
        
        <!-- Cross-Linking Buttons -->
        <div class="d-flex gap-3 justify-content-center flex-wrap mt-4 mb-3">
          <a href="/links" class="btn btn-outline-light btn-sm px-3 py-2 rounded-3">
            <i class="fa-solid fa-link me-2"></i>Social Links
          </a>
          <a href="/media" class="btn btn-outline-light btn-sm px-3 py-2 rounded-3">
            <i class="fa-solid fa-newspaper me-2"></i>Media Kit
          </a>
        </div>
        
        <p class="mb-0">
          <a href="<?= RES_ROOT ?>/sitemap.php?format=xml" class="text-white-50 small">
            <i class="fa-solid fa-code me-1"></i>View XML Sitemap
          </a>
        </p>
      </div>
    </div>
  </div>
</section>

<!-- Sitemap Links -->
<section class="py-5 section-pastel">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <h2 class="text-center mb-5">All Pages</h2>
        
        <?php 
        $categories = [
          'Main Pages' => [],
          'Game Pages' => [],
          'Blog Posts' => []
        ];
        
        // Categorize pages
        foreach ($pages as $p) {
          $loc = $p['loc'];
          if (strpos($loc, '/game/') !== false) {
            $categories['Game Pages'][] = $p;
          } elseif (strpos($loc, '/blog/') !== false) {
            $categories['Blog Posts'][] = $p;
          } else {
            $categories['Main Pages'][] = $p;
          }
        }
        
        // Render each category
        foreach ($categories as $catName => $catPages):
          if (empty($catPages)) continue;
        ?>
          <div class="mb-5">
            <h3 class="h4 mb-4">
              <?php 
                $icons = [
                  'Main Pages' => 'house-fill',
                  'Game Pages' => 'controller',
                  'Blog Posts' => 'pen-fill'
                ];
                echo '<i class="fa-solid fa-' . $icons[$catName] . ' me-2"></i>';
                echo $catName . ' <span class="text-muted">(' . count($catPages) . ')</span>';
              ?>
            </h3>
            
            <div class="row g-3">
              <?php foreach ($catPages as $p): ?>
                <div class="col-md-6 col-lg-4">
                  <a href="<?= htmlspecialchars($p['loc']) ?>" class="text-decoration-none d-block h-100">
                    <div class="glass-card h-100 hover-lift">
                      <div class="card-body p-4 d-flex align-items-center">
                        <i class="fa-solid fa-link me-3 fs-5 sitemap-link-icon"></i>
                        <span class="flex-grow-1"><?= htmlspecialchars($p['label']) ?></span>
                        <i class="fa-solid fa-arrow-right text-muted small ms-2"></i>
                      </div>
                    </div>
                  </a>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
        
        <!-- Quick Stats -->
        <div class="row mt-5">
          <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));">
              <div class="card-body text-center py-5">
                <h4 class="mb-4"><i class="fa-solid fa-chart-simple me-2"></i>Site Statistics</h4>
                <div class="row">
                  <div class="col-6 col-md-3 mb-3 mb-md-0">
                    <div class="fs-1 fw-bold text-primary"><?= count($categories['Main Pages']) ?></div>
                    <div class="small text-muted">Main Pages</div>
                  </div>
                  <div class="col-6 col-md-3 mb-3 mb-md-0">
                    <div class="fs-1 fw-bold text-success"><?= count($categories['Game Pages']) ?></div>
                    <div class="small text-muted">Games</div>
                  </div>
                  <div class="col-6 col-md-3">
                    <div class="fs-1 fw-bold text-info"><?= count($categories['Blog Posts']) ?></div>
                    <div class="small text-muted">Blog Posts</div>
                  </div>
                  <div class="col-6 col-md-3">
                    <div class="fs-1 fw-bold text-warning"><?= count($pages) ?></div>
                    <div class="small text-muted">Total Pages</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>

