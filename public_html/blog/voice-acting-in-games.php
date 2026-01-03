<?php
$activePage = 'blog';
$pageTitle = 'Voice Acting in Games: Bringing Characters to Life | JenniNexus Blog';
$pageDescription = 'From Newgrounds collabs to AAA games — my journey in voice acting, plus techniques and tools for creating believable game characters.';
$pageKeywords = 'voice acting, game development, Newgrounds, character voices, animation, audio production';

// Define RES_ROOT for blog subdirectory
if (!defined('RES_ROOT')) {
  define('RES_ROOT', '/resources');
}
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
<?php include '../includes/head.php'; ?>
<body>
  <?php include '../includes/header.php'; ?>

  <article class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <header class="mb-5">
            <div class="mb-3">
              <span class="badge bg-primary">Voice Acting</span>
              <span class="text-muted ms-2">February 10, 2025</span>
            </div>
            <h1 class="display-4 mb-4">Voice Acting in Games: Bringing Characters to Life</h1>
            <p class="lead text-muted">From Newgrounds collabs to AAA games — my journey in voice acting, plus techniques and tools for creating believable game characters.</p>
            <hr>
          </header>

          <div class="post-content glass-panel p-4 rounded-4 shadow-sm">
            <p>Voice acting in video games is more than just speaking lines—it's about creating believable, memorable characters that players connect with emotionally. As a voice actor who's worked on both sides of the recording booth, I've learned that great voice work can elevate a good game to something truly special.</p>

            <h2>My Journey Began on Newgrounds</h2>
            <p>I got my start in voice acting back in the early 2010s on <strong>Newgrounds</strong>. The <a href="https://www.newgrounds.com/bbs/forum/18" target="_blank">Voice Acting Forum</a> was a goldmine for collaboration. Animators would post scripts, and I’d record lines from my closet setup. Those early collabs taught me timing, character consistency, and how to take direction — all from passionate indie creators.</p>
            <p>From Newgrounds, I branched into YouTube animations, indie games, and eventually commercial projects. Those grassroots connections are still some of my favorite credits.</p>

            <h2>The Evolution of Game Voice Acting</h2>
            <p>Early games used text. Today, voice acting is essential for immersion. Modern games demand performances rivaling film — with branching dialogue, real-time reactions, and years-long recording schedules.</p>

            <h2>Character Development Through Voice</h2>
            <p>I start with:
              <ul>
                <li><strong>Backstory Research</strong>: Who is this character?</li>
                <li><strong>Physical Presence</strong>: How do they move?</li>
                <li><strong>Emotional Range</strong>: What extremes will they face?</li>
                <li><strong>Vocal Quirks</strong>: Accents, stutters, breaths</li>
              </ul>
            </p>

            <h2>Featured: My Voice Acting Compilation</h2>
            <p>Check out my video compilation of games, animations, and voice acting content — from Newgrounds classics to recent indie titles:</p>
            <div class="video-grid-container" data-playlist="PL9QBjNDhgNwQbaceJmfZzc3x4L80gvh8J" data-max="4" data-columns="2"></div>

            <!-- Instagram embed (graceful): attempts to load Instagram's embed.js, falls back to a simple link if blocked by CSP/CORS -->
            <div class="instagram-embed-wrapper my-4">
              <div id="instaEmbedPlaceholder">
                <a href="https://www.instagram.com/p/B82iLPkgxb5/" target="_blank" rel="noopener noreferrer" class="btn btn-outline-secondary">View Instagram post</a>
              </div>
            </div>

            <script>
              (function(){
                try {
                  var url = 'https://www.instagram.com/p/B82iLPkgxb5/';
                  var container = document.getElementById('instaEmbedPlaceholder');
                  if (!container) return;
                  // Create the Instagram blockquote element the official embed script expects
                  var bq = document.createElement('blockquote');
                  bq.className = 'instagram-media';
                  bq.setAttribute('data-instgrm-permalink', url);
                  bq.setAttribute('data-instgrm-version', '14');
                  bq.style.margin = '0 auto';
                  bq.style.maxWidth = '540px';
                  bq.innerHTML = '<a href="' + url + '" target="_blank" rel="noopener noreferrer">View on Instagram</a>';
                  // Insert before the placeholder link so a link is always available if the script is blocked
                  container.insertBefore(bq, container.firstChild);

                  // Dynamically load the Instagram embed script; may be blocked by CSP.
                  var s = document.createElement('script');
                  s.async = true;
                  s.defer = true;
                  s.src = 'https://www.instagram.com/embed.js';
                  s.onload = function(){ /* instagram will parse the blockquote automatically */ };
                  s.onerror = function(){ /* gracefully fail - leave the fallback link */ };
                  document.body.appendChild(s);
                } catch (e) { /* noop - leave fallback link */ }
              })();
            </script>

            <h2>Best Practices</h2>
            <p><strong>For Actors:</strong> Warm up, stay hydrated, study the game, be collaborative.<br>
            <strong>For Devs:</strong> Plan early, budget well, give context, respect the craft.</p>
          </div>

          <div class="mt-5">
            <a href="../tags.php?filters=voice-acting" class="badge bg-secondary me-1 text-decoration-none tag-badge">Voice Acting</a>
            <a href="../tags.php?filters=game-development" class="badge bg-secondary me-1 text-decoration-none tag-badge">Game Development</a>
            <a href="../tags.php?filters=character-development" class="badge bg-secondary me-1 text-decoration-none tag-badge">Character Development</a>
            <a href="../tags.php?filters=newgrounds" class="badge bg-secondary me-1 text-decoration-none tag-badge">Newgrounds</a>
            <a href="../tags.php?filters=animation" class="badge bg-secondary me-1 text-decoration-none tag-badge">Animation</a>
          </div>

          <div class="mt-5 pt-4 border-top d-flex justify-content-between flex-wrap gap-3">
            <a href="../blog.php" class="btn btn-outline-primary"><i class="fa-solid fa-arrow-left me-2"></i>Back to Blog</a>
            <div class="d-flex gap-2">
              <a href="https://twitter.com/intent/tweet?url=<?= urlencode('https://jenninexus.com/blog/voice-acting-in-games') ?>" target="_blank" class="btn btn-outline-secondary"><i class="fa-brands fa-twitter"></i></a>
              <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('https://jenninexus.com/blog/voice-acting-in-games') ?>" target="_blank" class="btn btn-outline-secondary"><i class="fa-brands fa-facebook"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>

  <?php include '../includes/footer.php'; ?>

  <!-- YouTube Grid System for playlist rendering -->
  <script src="<?= RES_ROOT ?>/js/youtube-grid<?= $assetSuffix ?? '' ?>.js"></script>
</body>
</html>