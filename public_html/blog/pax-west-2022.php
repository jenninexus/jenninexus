<?php
$activePage = 'blog';
$pageTitle = 'PAX West 2022 Recap — JenniNexus';
$pageDescription = 'PAX West 2022 highlights, photos, and a short video recap from JenniNexus.';
$pageKeywords = 'PAX West 2022, PAX 2022, gaming convention, indie games, Seattle, JenniNexus';

// Define RES_ROOT for blog subdirectory
if (!defined('RES_ROOT')) {
  define('RES_ROOT', '/resources');
}
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
<?php
// Page-level SEO / Open Graph overrides
$galleryPreview = null;
$galleryDir = __DIR__ . '/../resources/images/pax/2022';
if (is_dir($galleryDir)) {
  $files = glob($galleryDir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
  if ($files !== false && count($files) > 0) {
    // pick first image as preview
    $galleryPreview = '/resources/images/pax/2022/' . basename($files[0]);
  }
}
$pageImage = isset($galleryPreview) ? ('https://jenninexus.com' . $galleryPreview) : null;
$pageUrl = 'https://jenninexus.com/blog/pax-west-2022';
// Request Facebook SDK for embeds on this page
$needsFb = true;
?>
<?php include '../includes/head.php'; ?>
<body>

<?php include '../includes/header.php'; ?>

<article class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 mx-auto">
        <header class="mb-4">
          <div class="mb-2"><span class="badge bg-primary">Gaming & Events</span> <span class="text-muted ms-2">September 2022</span></div>
          <h1 class="display-4">PAX West 2022 — Photo Gallery & Recap</h1>
          <p class="lead text-muted">A visual trip through my PAX West 2022 highlights including demos, cosplay, and indie showcases.</p>
          <hr>
        </header>

        <section class="mb-4">
          <h3>Short video</h3>
          <div class="ratio ratio-16x9 mb-3">
            <iframe src="https://www.youtube.com/embed/36r7UeUiVkk" title="PAX West 2022 Highlights" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          </div>
        </section>

        <section class="mb-4">
          <h3>Facebook memory</h3>
          <div class="mb-4 d-flex justify-content-center">
            <iframe src="https://www.facebook.com/plugins/post.php?href=https%3A%2F%2Fwww.facebook.com%2Fmostlyjenninexus%2Fposts%2Fpfbid0Yebv2KL5hWGTTyZpvaStzkAZMk5XAH9UwTsNFEguZqqcjcsRei6rJ64YreaYK7f5l&show_text=true&width=500" width="500" height="745" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
          </div>
        </section>

        <section>
          <h3>Photo gallery</h3>
          <?php
            $galleryDir = __DIR__ . '/../resources/images/pax/2022';
            $images = [];
            if (is_dir($galleryDir)) {
              $files = glob($galleryDir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
              if ($files !== false) {
                // sort by name
                sort($files);
                foreach ($files as $f) { $images[] = basename($f); }
              }
            }
          ?>

          <?php if (count($images) === 0): ?>
            <div class="alert alert-secondary">No photos found in the PAX 2022 gallery yet — drop images in <code>public_html/resources/images/pax/2022</code>.</div>
          <?php else: ?>
            <div class="row g-2">
              <?php foreach ($images as $img): ?>
                <div class="col-6 col-md-4">
                  <a href="<?= RES_ROOT ?>/images/pax/2022/<?= rawurlencode($img) ?>" target="_blank" rel="noopener">
                    <img src="<?= RES_ROOT ?>/images/pax/2022/<?= rawurlencode($img) ?>" alt="PAX 2022 - <?= htmlspecialchars($img) ?>" class="img-fluid rounded shadow-sm">
                  </a>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </section>

        <div class="mt-4">
          <a href="../tags.php?filters=gaming" class="badge bg-secondary me-1 text-decoration-none tag-badge">Gaming</a>
          <a href="../tags.php?filters=pax-west" class="badge bg-secondary me-1 text-decoration-none tag-badge">PAX West</a>
          <a href="../tags.php?filters=indie" class="badge bg-secondary me-1 text-decoration-none tag-badge">Indie Games</a>
        </div>

        <div class="mt-5 pt-4 border-top d-flex justify-content-between align-items-center">
          <a href="/blog/pax-west-gaming-con" class="btn btn-outline-primary">Back to PAX West overview</a>
          <a href="/blog" class="btn btn-outline-secondary">Back to Blog</a>
        </div>

      </div>
    </div>
  </div>
</article>

<?php include '../includes/footer.php'; ?>

</body>
</html>
