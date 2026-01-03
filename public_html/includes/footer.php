<?php
// ----------------------------
// Path + asset handling (unchanged)
// ----------------------------
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = array_values(array_filter(explode('/', $requestPath)));
$depth = count($segments);

$pathPrefix = '';
if ($depth >= 2) {
  $pathPrefix = str_repeat('../', $depth - 1);
}

if (!defined('RES_ROOT')) define('RES_ROOT', '/resources');

if (!isset($assetSuffix)) {
  $isLocal =
    in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1']) ||
    strpos($_SERVER['HTTP_HOST'] ?? '', 'localhost') !== false ||
    strpos($_SERVER['HTTP_HOST'] ?? '', '8002') !== false;
  $assetSuffix = $isLocal ? '' : '.min';
}
?>

<!-- ========================================================= -->
<!-- Footer -->
<!-- ========================================================= -->
<footer class="footer-themed site-glass mt-5 pt-5 pb-4">
  <div class="container">

    <!-- Top Content -->
    <div class="row gy-4 gx-lg-5">

      <!-- Brand / Identity -->
      <div class="col-12 col-md-6 col-xl-3 text-center text-md-start">
        <?php $logoLink = false; $logoSize = 'h5'; $logoClass = 'mb-3'; include __DIR__ . '/logo.php'; ?>

        <p class="small text-muted mb-3">
          Game development, music, live content, and experimental creative tech.
        </p>

        <!-- Social - Streamlined 5 icons -->
        <div class="d-flex gap-3 justify-content-center justify-content-md-start social-links-badass flex-wrap">
          <a href="https://discord.gg/KYPh7Cp" target="_blank" class="link-discord" title="Join Discord Community" aria-label="Discord">
            <i class="fa-brands fa-discord"></i>
          </a>
          <a href="https://youtube.com/@jenninexus" target="_blank" class="link-youtube" title="Subscribe on YouTube" aria-label="YouTube">
            <i class="fa-brands fa-youtube"></i>
          </a>
          <a href="https://patreon.com/jenninexus" target="_blank" class="link-patreon" title="Support on Patreon" aria-label="Patreon">
            <i class="fa-brands fa-patreon"></i>
          </a>
          <a href="mailto:jenninexus@gmail.com" class="link-email" title="Email Contact" aria-label="Email">
            <i class="fa-solid fa-envelope"></i>
          </a>
          <a href="/links" class="link-links" title="All Links & Social Media" aria-label="All Links">
            <i class="fa-solid fa-link"></i>
          </a>
        </div>
      </div>

      <!-- Explore -->
      <div class="col-6 col-md-3 col-xl-2 text-center text-md-start">
        <h6 class="mb-3">Explore</h6>
        <ul class="list-unstyled small">
          <li class="mb-2"><a href="/gamedev">Game Dev</a></li>
          <li class="mb-2"><a href="/gaming">Gaming</a></li>
          <li class="mb-2"><a href="/live">Live</a></li>
          <li class="mb-2"><a href="/music">Music</a></li>
          <li class="mb-2"><a href="/diy">DIY</a></li>
          <li class="mb-2"><a href="/blog">Blog</a></li>
          <li class="mb-2"><a href="/sitemap">Sitemap</a></li>
        </ul>
      </div>

      <!-- Connect -->
      <div class="col-6 col-md-3 col-xl-2 text-center text-md-start">
        <h6 class="mb-3">Connect</h6>
        <ul class="list-unstyled small">
          <li class="mb-2"><a href="/links">All Links</a></li>
          <li class="mb-2"><a href="/resume">Resume</a></li>
          <li class="mb-2"><a href="/services">Services</a></li>
          <li class="mb-2"><a href="/patreon">Patreon</a></li>
        </ul>
      </div>

      <!-- Professional Contact / CTA -->
      <div class="col-12 col-xl-5 text-center text-xl-start">
        <h6 class="mb-3">
          <i class="fa-solid fa-envelope me-2 text-primary"></i>
          Professional Contact
        </h6>

        <a
          href="mailto:jenninexus@gmail.com?subject=Professional Inquiry&body=Hi Jenni,%0D%0A%0D%0AI'm interested in:%0D%0A[ ] Hiring for a position%0D%0A[ ] Contract work%0D%0A[ ] Freelance project%0D%0A[ ] Collaboration%0D%0A%0D%0ADetails:%0D%0A"
          class="btn btn-primary w-100 fw-bold mb-3"
        >
          <i class="fa-solid fa-envelope me-2"></i>
          jenninexus@gmail.com
        </a>

        <div class="d-flex gap-2">
          <a href="https://discord.gg/KYPh7Cp" class="btn btn-discord btn-sm flex-fill">
            <i class="fa-brands fa-discord me-1"></i> Discord
          </a>
          <a href="/services" class="btn btn-outline-light btn-sm flex-fill">
            <i class="fa-solid fa-briefcase me-1"></i> Services
          </a>
        </div>
      </div>
    </div>

    <!-- Divider -->
    <hr class="my-4 border-secondary">

    <!-- Bottom Bar -->
    <div class="row">
      <div class="col text-center">
        <p class="small text-muted mb-0">
          &copy; <?= date('Y') ?> JenniNexus. All rights reserved.
        </p>
      </div>
    </div>
  </div>
</footer>

<!-- Back to Top -->
<button id="scroll-to-top" aria-label="Back to top">
  <i class="fa-solid fa-chevron-up"></i>
</button>

<!-- ========================================================= -->
<!-- Core JavaScript Files - Loaded on All Pages -->
<!-- ========================================================= -->
<!-- Loading Order: Bootstrap → theme-toggle → performance → polyfills → ui-effects → back-to-top → tag-filter-api -->
<!-- Environment-aware: .js for local dev, .min.js for production -->
<!-- Page-specific scripts (youtube-grid.js, tag-system.js, etc.) loaded via $pageScripts array -->

<script src="<?= RES_ROOT ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- 1. Theme Toggle - Dark/light mode switching -->
<script src="<?= RES_ROOT ?>/js/theme-toggle<?= $assetSuffix ?>.js"></script>

<!-- 2. Performance Optimizer - Lazy loading, resource hints -->
<script src="<?= RES_ROOT ?>/js/performance-optimizer<?= $assetSuffix ?>.js"></script>

<!-- 3. Polyfills - Browser compatibility shims -->
<script src="<?= RES_ROOT ?>/js/polyfills<?= $assetSuffix ?>.js"></script>

<!-- 4. UI Effects - Parallax, card tilt, copy-to-clipboard, stat counters -->
<script src="<?= RES_ROOT ?>/js/ui-effects<?= $assetSuffix ?>.js"></script>

<!-- 5. Back to Top - Scroll-to-top button functionality -->
<script src="<?= RES_ROOT ?>/js/back-to-top<?= $assetSuffix ?>.js"></script>

<!-- 6. Tag Filter API - Tag filtering utilities -->
<script src="<?= RES_ROOT ?>/js/tag-filter-api<?= $assetSuffix ?>.js"></script>

<?php if (!empty($needsFb)) : ?>
  <div id="fb-root"></div>
  <script async defer crossorigin="anonymous"
    src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v24.0&appId=331813368732871">
  </script>
<?php endif; ?>

<?php
if (!empty($pageScripts) && is_array($pageScripts)) {
  foreach ($pageScripts as $script) {
    $trim = trim($script);
    if (preg_match('#^https?://#i', $trim)) {
      echo "<script src=\"$trim\"></script>\n";
    } else {
      echo "<script src=\"" . htmlspecialchars($pathPrefix . $trim, ENT_QUOTES) . "\"></script>\n";
    }
  }
}
?>
