















<?php
$activePage = 'blog';
$pageTitle = 'PAX West Gaming Convention 2025: My Experience & Highlights | JenniNexus Blog';
$pageDescription = 'Join me as I share my PAX West 2025 adventure - from mind-blowing indie games and cosplay highlights to creator meetups and panel insights.';
$pageKeywords = 'PAX West, gaming convention, indie games, cosplay, game events, PAX 2025';

// Define RES_ROOT for blog subdirectory
if (!defined('RES_ROOT')) {
  define('RES_ROOT', '/resources');
}
?>
<?php
// Page-level Open Graph overrides
$pageUrl = 'https://jenninexus.com/blog/pax-west-gaming-con';
$galleryDir = __DIR__ . '/../resources/images/pax/2022';
$pageImage = null;
if (is_dir($galleryDir)) {
  $g = glob($galleryDir . '/*.{jpg,jpeg,png}', GLOB_BRACE);
  if ($g !== false && count($g) > 0) $pageImage = 'https://jenninexus.com/resources/images/pax/2022/' . basename($g[0]);
}
// This page contains Facebook embeds
$needsFb = true;
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
<?php include __DIR__ . '/../includes/head.php'; ?>
<body>
  
  <?php include __DIR__ . '/../includes/header.php'; ?>

  <!-- Blog Post Content -->
  <article class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <!-- Post Header -->
          <header class="mb-5">
            <div class="mb-3">
              <span class="badge bg-primary">Gaming & Events</span>
              <span class="text-muted ms-2">March 15, 2025</span>
            </div>
            <h1 class="display-4 mb-4">PAX West Gaming Convention 2025: My Experience & Highlights</h1>
            <p class="lead text-muted">Join me as I share my PAX West 2025 adventure - from mind-blowing indie games and cosplay highlights to creator meetups and panel insights from the biggest gaming convention of the year.</p>
            <hr>
          </header>

          <!-- Post Body -->
          <div class="post-content glass-panel p-4 rounded-4 shadow-sm">
            <?php
            $mdFile = '../resources/blog posts/pax-west-gaming-con.md';
            if (file_exists($mdFile)) {
              // Read markdown file
              $content = file_get_contents($mdFile);
              // Basic markdown to HTML conversion
              $content = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $content);
              $content = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $content);
              $content = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $content);
              $content = preg_replace('/\*\*(.+?)\*\*/','<strong>$1</strong>', $content);
              $content = preg_replace('/\*(.+?)\*/','<em>$1</em>', $content);
              $content = preg_replace('/\[(.+?)\]\((.+?)\)/', '<a href="$2" target="_blank">$1</a>', $content);
              $content = nl2br($content);
              echo $content;
            } else {
              // Fallback content if markdown is not present - write an inline post highlighting PAX West
              echo '<p>I had an amazing time at <strong>PAX West (Seattle)</strong>. I attend PAX annually since 2017 and every year brings fresh energy — from indie showcases to VR demos and creator meetups. Below I collected highlights, community events, and videos from the PAX West playlist.</p>';
              echo '<p>This post focuses on three areas I love: <strong>Media & Content Creation</strong>, the hands-on <strong>VR demos</strong> I tried, and the vibrant community spaces like <em>Seattle Indies Expo</em> and the <em>Seattle Online Broadcasters Association (SOBA)</em> — my Twitch/community team that runs events and panels during the show.</p>';
              echo '<p>I hope this gives you a taste of the convention and points you to the best videos and clips.</p>';
            }
            ?>
          </div>

          <!-- PAX West Playlist Grid (auto-init by YouTubeGrid) -->
          <section class="mt-4">
            <h3 class="mb-3">PAX West — Playlist Highlights</h3>
            <p class="text-muted">Videos from the PAX West playlist (showing up to 15 videos). Click thumbnails to open videos in a modal.</p>
            <div class="video-grid-container" data-playlist="PL9QBjNDhgNwRIS4WXfKy4oLrPKxoK_Jra" data-max="15" data-columns="3"></div>
          </section>

          <!-- PAX West 2022 Gallery & FB Post -->
          <section class="mt-4">
            <h3 class="mb-3">PAX West 2022 Gallery</h3>
            <p class="text-muted">A small gallery from PAX West 2022 and a snapshot from our Facebook feed.</p>

            <div class="card mb-3">
              <div class="card-body">
                <h5 class="card-title">Facebook memory</h5>
                <div class="mb-3">
                  <div class="fb-post" data-href="https://www.facebook.com/mostlyjenninexus/posts/pfbid0Yebv2KL5hWGTTyZpvaStzkAZMk5XAH9UwTsNFEguZqqcjcsRei6rJ64YreaYK7f5l" data-width="500" data-show-text="false">
                    <blockquote cite="https://www.facebook.com/mostlyjenninexus/posts/517028877092316" class="fb-xfbml-parse-ignore">
                      <p>So glad I came to PAX on Monday bc I had a chance to see everything I missed &amp; play more demos like Splatoon 3....</p>
                      Posted by <a href="https://www.facebook.com/mostlyjenninexus">Jenni Nexus</a> on&nbsp;<a href="https://www.facebook.com/mostlyjenninexus/posts/517028877092316">Monday, September 5, 2022</a>
                    </blockquote>
                  </div>
                </div>
                <p class="small text-muted">If the embed doesn't appear, view it on <a href="https://www.facebook.com/mostlyjenninexus/posts/517028877092316" target="_blank" rel="noopener">Facebook</a>.</p>
              </div>
            </div>

            <div class="card mb-4">
              <div class="card-body">
                <h5 class="card-title">Video Snapshot</h5>
                <div class="ratio ratio-16x9 mb-3">
                  <iframe src="https://www.youtube.com/embed/lFw51RnwJfg" title="PAX West 2022 Highlights" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
              </div>
            </div>

            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Photo Gallery</h5>
                <?php
                  $galleryDir = __DIR__ . '/../resources/images/pax/2022';
                  $images = [];
                  if (is_dir($galleryDir)) {
                    $files = glob($galleryDir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                    if ($files !== false) {
                      foreach ($files as $f) { $images[] = basename($f); }
                    }
                  }
                ?>
                <style>
                  /* Reduce thumbnail hover jitter and avoid scaling while modal is open */
                  .gallery-image { transition: transform .22s ease, opacity .18s ease; will-change: transform, opacity; display: block; }
                  .gallery-image:hover { transform: scale(1.03); }
                  /* When modal is open, prevent thumbnail hover scaling */
                  body.modal-open .gallery-image { transform: none !important; }
                </style>

                <?php if (count($images) === 0): ?>
                  <div class="alert alert-secondary">No photos found in the PAX 2022 gallery yet.</div>
                <?php else: ?>
                  <div class="row g-2">
                    <?php foreach ($images as $idx => $img): ?>
                      <div class="col-6 col-md-4">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#paxGalleryModal" data-bs-slide-to="<?= $idx ?>">
                          <img src="<?= RES_ROOT ?>/images/pax/2022/<?= rawurlencode($img) ?>" alt="PAX 2022 - <?= htmlspecialchars($img) ?>" class="img-fluid rounded shadow-sm gallery-image">
                        </a>
                      </div>
                    <?php endforeach; ?>
                  </div>

                  <!-- Modal with Carousel (same pattern as other game pages) -->
                  <div class="modal fade" id="paxGalleryModal" tabindex="-1" aria-labelledby="paxGalleryModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                      <div class="modal-content bg-dark">
                        <div class="modal-header border-secondary">
                          <h5 class="modal-title text-white" id="paxGalleryModalLabel">PAX West 2022 Gallery</h5>
                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <div id="paxGalleryCarousel" class="carousel slide" data-bs-ride="false">
                            <div class="carousel-inner">
                              <?php foreach ($images as $i => $img): ?>
                                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                                  <img src="<?= RES_ROOT ?>/images/pax/2022/<?= rawurlencode($img) ?>" class="d-block w-100" alt="PAX West 2022 - <?= htmlspecialchars($img) ?>">
                                </div>
                              <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#paxGalleryCarousel" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#paxGalleryCarousel" data-bs-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Next</span>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <script>
                    // Ensure clicking a thumbnail opens the carousel at the right slide
                    document.addEventListener('DOMContentLoaded', function(){
                      var paxModal = document.getElementById('paxGalleryModal');
                      if (!paxModal) return;
                      paxModal.addEventListener('show.bs.modal', function (e) {
                        var trigger = e.relatedTarget || document.activeElement;
                        var slideTo = 0;
                        if (trigger && trigger.dataset && typeof trigger.dataset.bsSlideTo !== 'undefined') {
                          slideTo = parseInt(trigger.dataset.bsSlideTo, 10) || 0;
                        } else if (trigger && trigger.getAttribute) {
                          slideTo = parseInt(trigger.getAttribute('data-bs-slide-to') || '0', 10) || 0;
                        }
                        var carousel = paxModal.querySelector('#paxGalleryCarousel');
                        if (carousel && window.bootstrap && window.bootstrap.Carousel) {
                          var c = bootstrap.Carousel.getOrCreateInstance(carousel);
                          c.to(slideTo);
                        }
                      });
                    });
                  </script>
                <?php endif; ?>
              </div>
            </div>
          </section>

          <!-- Instagram embeds (PAX content) -->
          <section class="mt-4">
            <h3 class="mb-3">Social Highlights</h3>
            <div class="d-flex flex-column gap-3">
              <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/reel/C_3ycyay6Mc/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
                <div style="padding:16px;"> <a href="https://www.instagram.com/reel/C_3ycyay6Mc/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank">View on Instagram</a></div>
              </blockquote>

              <blockquote class="instagram-media" data-instgrm-permalink="https://www.instagram.com/reel/C_YV2vLv_Vm/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
                <div style="padding:16px;"> <a href="https://www.instagram.com/reel/C_YV2vLv_Vm/?utm_source=ig_embed&amp;utm_campaign=loading" style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" target="_blank">View on Instagram</a></div>
              </blockquote>
              <script async src="//www.instagram.com/embed.js" crossorigin="anonymous"></script>
            </div>
          </section>

          <!-- Community & Credits -->
          <section class="mt-4">
            <h3 class="mb-2">Community & Events</h3>
            <p>I regularly check out the <strong>Seattle Indies Expo</strong> which runs alongside PAX — it’s a great place to play indie demos and meet devs. I also collaborate with the <strong>Seattle Online Broadcasters Association (SOBA)</strong> — our community/Twitch team runs panels and community meetups during PAX each year.</p>
            <p>If you were at PAX and saw me around, say hi! I’m usually juggling a camera, a badge, and an over-caffeinated curiosity for VR demos.</p>
          </section>

          <!-- Tags -->
          <div class="mt-5">
            <a href="../tags.php?filters=gaming" class="badge bg-secondary me-1 text-decoration-none tag-badge">Gaming</a>
            <a href="../tags.php?filters=events" class="badge bg-secondary me-1 text-decoration-none tag-badge">Conventions</a>
            <a href="../tags.php?filters=pax-west" class="badge bg-secondary me-1 text-decoration-none tag-badge">PAX West</a>
            <a href="../tags.php?filters=indie" class="badge bg-secondary me-1 text-decoration-none tag-badge">Indie Games</a>
            <a href="../tags.php?filters=cosplay" class="badge bg-secondary me-1 text-decoration-none tag-badge">Cosplay</a>
          </div>

          <!-- Share & Navigation -->
          <div class="mt-5 pt-4 border-top">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
              <a href="../blog.php" class="btn btn-outline-primary">
                <i class="fa-solid fa-arrow-left me-2"></i>Back to Blog
              </a>
              <div class="d-flex gap-2">
                <a href="https://twitter.com/intent/tweet?url=<?= urlencode('https://jenninexus.com/blog/pax-west-gaming-con') ?>" target="_blank" class="btn btn-outline-secondary">
                  <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('https://jenninexus.com/blog/pax-west-gaming-con') ?>" target="_blank" class="btn btn-outline-secondary">
                  <i class="fa-brands fa-facebook"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>

  <?php include __DIR__ . '/../includes/footer.php'; ?>

  <!-- YouTube Grid System for playlist rendering -->
  <script src="<?= RES_ROOT ?>/js/youtube-grid<?= $assetSuffix ?? '' ?>.js"></script>
</body>
</html>
