<?php
// tag/index.php - handles /tag/{slug} or /tag/index.php?slug={slug}
// Supports multi-tag selection via ?slug=tag1,tag2,tag3 or ?filters=tag1,tag2
$activePage = 'tag';
$slugs = [];

// Check for filters parameter first (from tags.php redirect)
if (!empty($_GET['filters'])) {
  $slugs = array_filter(array_map('trim', explode(',', $_GET['filters'])));
}

// Try PATH_INFO for single tag (if using pretty URLs)
if (empty($slugs) && !empty($_SERVER['PATH_INFO'])) {
  $parts = explode('/', trim($_SERVER['PATH_INFO'], '/'));
  if (isset($parts[0]) && $parts[0] !== '') {
    $slugs = array_filter(array_map('trim', explode(',', $parts[0])));
  }
}

// Fallback to GET slug parameter (supports comma-separated for multi-tag)
if (empty($slugs) && !empty($_GET['slug'])) {
  $slugs = array_filter(array_map('trim', explode(',', $_GET['slug'])));
}

// If no tags specified, redirect to main tags page
if (empty($slugs)) {
  header('Location: /tags.php');
  exit;
}

// Sanitize slugs
$slugs = array_map(function($s) {
  return preg_replace('/[^a-z0-9\-]+/i', '', $s);
}, $slugs);

// Load tags for display name resolution
$tagDisplayNames = [];
$tagsPath = __DIR__ . '/../resources/playlists/tags.json';
if (file_exists($tagsPath)) {
  $allTags = json_decode(file_get_contents($tagsPath), true) ?: [];
  foreach ($allTags as $t) {
    if (!empty($t['slug']) && in_array($t['slug'], $slugs)) {
      $tagDisplayNames[$t['slug']] = $t['name'];
    }
  }
}

// Build page title
if (count($slugs) === 1) {
  $displayName = $tagDisplayNames[$slugs[0]] ?? ucwords(str_replace('-', ' ', $slugs[0]));
  $pageTitle = 'Tag: ' . htmlspecialchars($displayName) . ' — JenniNexus';
} else {
  $pageTitle = 'Tags: ' . htmlspecialchars(implode(', ', array_map(function($s) use ($tagDisplayNames) {
    return $tagDisplayNames[$s] ?? ucwords(str_replace('-', ' ', $s));
  }, $slugs))) . ' — JenniNexus';
}

// Load theme CSS for consistent card styling
$customCSS = [
  '/resources/css/tags-theme.min.css'
];
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <?php include __DIR__ . '/../includes/head.php'; ?>
  <body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <section class="py-5">
      <div class="container">
        <div class="row mb-4">
          <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-5">
              <?php if (count($slugs) === 1): ?>
                Tag: <?php echo htmlspecialchars($tagDisplayNames[$slugs[0]] ?? ucwords(str_replace('-', ' ', $slugs[0]))); ?>
              <?php else: ?>
                Tags: <?php echo htmlspecialchars(implode(', ', array_map(function($s) use ($tagDisplayNames) {
                  return $tagDisplayNames[$s] ?? ucwords(str_replace('-', ' ', $s));
                }, $slugs))); ?>
              <?php endif; ?>
            </h1>
            <p class="lead">
              Content tagged with 
              <strong><?php echo htmlspecialchars(implode(', ', array_map(function($s) use ($tagDisplayNames) {
                return $tagDisplayNames[$s] ?? ucwords(str_replace('-', ' ', $s));
              }, $slugs))); ?></strong>
            </p>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-10 mx-auto">
            
            <!-- Clear Tags Button (always visible) -->
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
              <p class="text-muted small mb-0">Click tags below to add/remove filters. Select multiple tags to refine results.</p>
              <a href="/tags.php" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-x-circle"></i>Clear All Tags
              </a>
            </div>
            
            <?php
            $tagsPath = __DIR__ . '/../resources/playlists/tags.json';
            $contentTagsPath = __DIR__ . '/../resources/playlists/content_tags.json';
            $tags = [];
            $contentMatches = [];
            $related = [];

            if (file_exists($tagsPath)) {
              $tags = json_decode(file_get_contents($tagsPath), true) ?: [];
            }
            
            // Build tag lookup maps
            $tagMap = [];
            $tagIdToSlug = [];
            $tagNameToSlug = [];
            $tagSlugToName = [];
            foreach ($tags as $t) {
              if (!empty($t['slug'])) {
                $tagMap[$t['slug']] = $t;
                $tagSlugToName[$t['slug']] = $t['name'];
              }
              if (isset($t['id'])) {
                $tagMap[(string)$t['id']] = $t;
                if (!empty($t['slug'])) {
                  $tagIdToSlug[(string)$t['id']] = $t['slug'];
                }
              }
              if (isset($t['name']) && !empty($t['slug'])) {
                $tagNameToSlug[$t['name']] = $t['slug'];
              }
            }

            // Convert requested slugs to normalized format
            $filterSlugs = [];
            foreach ($slugs as $s) {
              if (isset($tagMap[$s]['slug'])) {
                $filterSlugs[] = $tagMap[$s]['slug'];
              } elseif (is_numeric($s) && isset($tagIdToSlug[$s])) {
                $filterSlugs[] = $tagIdToSlug[$s];
              } else {
                $filterSlugs[] = $s;
              }
            }

            if (file_exists($contentTagsPath)) {
              $ct = json_decode(file_get_contents($contentTagsPath), true) ?: [];
              foreach ($ct as $contentId => $meta) {
                // Skip entries that are just arrays of tag IDs (category pages)
                if (!is_array($meta) || array_values($meta) === $meta) {
                  continue;
                }
                
                // Skip empty objects
                if (empty($meta)) {
                  continue;
                }
                
                $tlist = [];
                if (isset($meta['tags']) && is_array($meta['tags'])) {
                  $tlist = $meta['tags'];
                }
                
                // Convert tag IDs/names in content to slugs for comparison
                $contentSlugs = [];
                foreach ($tlist as $t) {
                  $t = is_scalar($t) ? (string)$t : '';
                  if ($t === '') continue;
                  if (isset($tagIdToSlug[$t])) {
                    $contentSlugs[] = $tagIdToSlug[$t];
                  } elseif (isset($tagNameToSlug[$t])) {
                    $contentSlugs[] = $tagNameToSlug[$t];
                  } else {
                    $contentSlugs[] = $t;
                  }
                }
                
                // Check if content matches ANY of the filter slugs
                $intersect = array_intersect($filterSlugs, $contentSlugs);
                if (!empty($intersect)) {
                  $title = is_array($meta) && isset($meta['title']) && is_scalar($meta['title']) ? (string)$meta['title'] : (is_string($contentId) ? $contentId : 'Content');
                  $url = is_array($meta) && isset($meta['url']) && is_scalar($meta['url']) ? (string)$meta['url'] : null;
                  $type = 'content';
                  $description = '';
                  $thumbnail = '';
                  
                  if (is_array($meta) && isset($meta['type']) && is_scalar($meta['type'])) {
                    $type = (string)$meta['type'];
                  }
                  
                  // Determine content type and enhance metadata
                  if (strpos($contentId, 'playlist:') === 0) {
                    $type = 'playlist';
                    $playlistId = substr($contentId, strlen('playlist:'));
                    $thumbnail = "https://img.youtube.com/vi/" . $playlistId . "/mqdefault.jpg";
                    if (!$url) {
                      $url = "https://www.youtube.com/playlist?list=" . rawurlencode($playlistId);
                    }
                  } elseif ($type === 'blog' || strpos($contentId, 'blog/') === 0 || strpos($contentId, '/blog') === 0) {
                    $type = 'blog';
                    $slug = is_array($meta) && isset($meta['slug']) ? (string)$meta['slug'] : $contentId;
                    $possibleBlog = __DIR__ . '/../blog/' . $slug . '.php';
                    if (is_file($possibleBlog) && !$url) {
                      $url = '/blog/' . rawurlencode($slug) . '.php';
                    }
                  } elseif ($type === 'game' || strpos($contentId, 'game/') === 0 || strpos($contentId, '/game') === 0) {
                    $type = 'game';
                    $slug = is_array($meta) && isset($meta['slug']) ? (string)$meta['slug'] : $contentId;
                    $gameSlug = preg_replace('#^/?game/([^/]+).*$#', '$1', $slug);
                    $thumbnail = "/resources/images/games/{$gameSlug}-thumb.jpg";
                    if (!$url) {
                      $url = '/game/' . rawurlencode($gameSlug) . '.php';
                    }
                  } elseif ($type === 'video' || preg_match('/^[a-zA-Z0-9_-]{11}$/', $contentId)) {
                    $type = 'video';
                    $thumbnail = "https://img.youtube.com/vi/{$contentId}/mqdefault.jpg";
                    if (!$url) {
                      $url = "https://www.youtube.com/watch?v=" . rawurlencode($contentId);
                    }
                  }
                  
                  // Skip page/category URLs without explicit content
                  if (strpos($contentId, '/') === 0 && !$url) {
                    continue;
                  }
                  
                  // Fallback URL generation
                  if (!$url) {
                    $possibleBlog = __DIR__ . '/../blog/' . $contentId . '.php';
                    if (is_file($possibleBlog)) {
                      $url = '/blog/' . rawurlencode($contentId) . '.php';
                      $type = 'blog';
                    } else {
                      continue;
                    }
                  }
                  
                  // Extract description
                  if (is_array($meta) && isset($meta['description'])) {
                    $description = (string)$meta['description'];
                  }
                  
                  $contentMatches[] = [
                    'title' => htmlspecialchars($title),
                    'url' => htmlspecialchars($url),
                    'tags' => $contentSlugs,
                    'type' => $type,
                    'description' => htmlspecialchars($description),
                    'thumbnail' => $thumbnail
                  ];
                  
                  // Build related tags co-occurrence
                  foreach ($contentSlugs as $otherSlug) {
                    if (!in_array($otherSlug, $filterSlugs)) {
                      $related[$otherSlug] = ($related[$otherSlug] ?? 0) + 1;
                    }
                  }
                }
              }
            }

            if (empty($contentMatches)) {
              echo "<div class=\"alert alert-warning\">No content matched those tags.</div>";
            } else {
              // Helper function to convert slug to display name
              $getTagName = function($slug) use ($tagSlugToName) {
                return isset($tagSlugToName[$slug]) ? $tagSlugToName[$slug] : ucwords(str_replace('-', ' ', $slug));
              };
              
              echo "<h3 class=\"mt-4 mb-3\">Found " . count($contentMatches) . " results</h3>\n";
              
              // Display as visual cards
              echo "<div class=\"row g-4 mb-4\">\n";
              foreach ($contentMatches as $m) {
                // Different card styles based on content type
                if ($m['type'] === 'game') {
                  // Game card with thumbnail
                  echo "<div class=\"col-md-6 col-lg-4\">\n";
                  echo "  <div class=\"card h-100 border-0 shadow-sm hover-lift\">\n";
                  if ($m['thumbnail'] && file_exists(__DIR__ . '/..' . $m['thumbnail'])) {
                    echo "    <img src=\"{$m['thumbnail']}\" class=\"card-img-top\" alt=\"{$m['title']}\" style=\"height: 200px; object-fit: cover;\">\n";
                  } else {
                    echo "    <div class=\"card-img-top bg-dark d-flex align-items-center justify-content-center\" style=\"height: 200px;\">\n";
                    echo "      <i class=\"bi bi-controller fs-1 text-primary\"></i>\n";
                    echo "    </div>\n";
                  }
                  echo "    <div class=\"card-body\">\n";
                  echo "      <span class=\"badge bg-primary mb-2\">Game</span>\n";
                  echo "      <h5 class=\"card-title\">{$m['title']}</h5>\n";
                  if ($m['description']) {
                    echo "      <p class=\"card-text small text-muted\">{$m['description']}</p>\n";
                  }
                  if (!empty($m['tags'])) {
                    echo "      <div class=\"d-flex flex-wrap gap-1 mt-2\">\n";
                    foreach ($m['tags'] as $tag) {
                      $tagName = $getTagName($tag);
                      $isSelected = in_array($tag, $filterSlugs);
                      $badgeClass = $isSelected ? 'bg-primary' : 'bg-secondary bg-opacity-50';
                      echo "        <button type=\"button\" class=\"badge {$badgeClass} border-0 tag-filter-badge\" ";
                      echo "data-tag-slug=\"" . htmlspecialchars($tag) . "\" data-tag-name=\"" . htmlspecialchars($tagName) . "\" ";
                      echo "style=\"cursor: pointer; font-size: 0.7rem;\">" . htmlspecialchars($tagName) . "</button>\n";
                    }
                    echo "      </div>\n";
                  }
                  echo "    </div>\n";
                  echo "    <div class=\"card-footer bg-transparent border-0\">\n";
                  echo "      <a href=\"{$m['url']}\" class=\"btn btn-outline-primary btn-sm w-100\">Learn More</a>\n";
                  echo "    </div>\n";
                  echo "  </div>\n";
                  echo "</div>\n";
                } elseif ($m['type'] === 'blog') {
                  // Blog card
                  echo "<div class=\"col-md-6 col-lg-4\">\n";
                  echo "  <div class=\"card h-100 border-0 shadow-sm hover-lift\">\n";
                  echo "    <div class=\"card-body\">\n";
                  echo "      <span class=\"badge bg-info mb-2\">Blog Post</span>\n";
                  echo "      <h5 class=\"card-title\">{$m['title']}</h5>\n";
                  if ($m['description']) {
                    echo "      <p class=\"card-text small text-muted\">{$m['description']}</p>\n";
                  }
                  if (!empty($m['tags'])) {
                    echo "      <div class=\"d-flex flex-wrap gap-1 mt-2\">\n";
                    foreach ($m['tags'] as $tag) {
                      $tagName = $getTagName($tag);
                      $isSelected = in_array($tag, $filterSlugs);
                      $badgeClass = $isSelected ? 'bg-primary' : 'bg-secondary bg-opacity-50';
                      echo "        <button type=\"button\" class=\"badge {$badgeClass} border-0 tag-filter-badge\" ";
                      echo "data-tag-slug=\"" . htmlspecialchars($tag) . "\" data-tag-name=\"" . htmlspecialchars($tagName) . "\" ";
                      echo "style=\"cursor: pointer; font-size: 0.7rem;\">" . htmlspecialchars($tagName) . "</button>\n";
                    }
                    echo "      </div>\n";
                  }
                  echo "    </div>\n";
                  echo "    <div class=\"card-footer bg-transparent border-0\">\n";
                  echo "      <a href=\"{$m['url']}\" class=\"btn btn-outline-info btn-sm w-100\">Read More</a>\n";
                  echo "    </div>\n";
                  echo "  </div>\n";
                  echo "</div>\n";
                } elseif ($m['type'] === 'video') {
                  // Video card with YouTube thumbnail
                  echo "<div class=\"col-md-6 col-lg-4\">\n";
                  echo "  <div class=\"card h-100 border-0 shadow-sm hover-lift\">\n";
                  if ($m['thumbnail']) {
                    echo "    <img src=\"{$m['thumbnail']}\" class=\"card-img-top\" alt=\"{$m['title']}\" style=\"height: 180px; object-fit: cover;\">\n";
                  }
                  echo "    <div class=\"card-body\">\n";
                  echo "      <span class=\"badge bg-danger mb-2\"><i class=\"bi bi-youtube\"></i> Video</span>\n";
                  echo "      <h5 class=\"card-title\">{$m['title']}</h5>\n";
                  if (!empty($m['tags'])) {
                    echo "      <div class=\"d-flex flex-wrap gap-1 mt-2\">\n";
                    foreach ($m['tags'] as $tag) {
                      $tagName = $getTagName($tag);
                      $isSelected = in_array($tag, $filterSlugs);
                      $badgeClass = $isSelected ? 'bg-primary' : 'bg-secondary bg-opacity-50';
                      echo "        <button type=\"button\" class=\"badge {$badgeClass} border-0 tag-filter-badge\" ";
                      echo "data-tag-slug=\"" . htmlspecialchars($tag) . "\" data-tag-name=\"" . htmlspecialchars($tagName) . "\" ";
                      echo "style=\"cursor: pointer; font-size: 0.7rem;\">" . htmlspecialchars($tagName) . "</button>\n";
                    }
                    echo "      </div>\n";
                  }
                  echo "    </div>\n";
                  echo "    <div class=\"card-footer bg-transparent border-0\">\n";
                  echo "      <a href=\"{$m['url']}\" class=\"btn btn-outline-danger btn-sm w-100\">Watch Video</a>\n";
                  echo "    </div>\n";
                  echo "  </div>\n";
                  echo "</div>\n";
                } elseif ($m['type'] === 'playlist') {
                  // Playlist card
                  echo "<div class=\"col-md-6 col-lg-4\">\n";
                  echo "  <div class=\"card h-100 border-0 shadow-sm hover-lift\">\n";
                  echo "    <div class=\"card-body\">\n";
                  echo "      <div class=\"d-flex align-items-start mb-3\">\n";
                  echo "        <i class=\"bi bi-collection-play fs-3 text-danger me-3\"></i>\n";
                  echo "        <div class=\"flex-grow-1\">\n";
                  echo "          <span class=\"badge bg-danger mb-2\"><i class=\"bi bi-youtube\"></i> Playlist</span>\n";
                  echo "          <h5 class=\"card-title mb-1\">{$m['title']}</h5>\n";
                  if ($m['description']) {
                    echo "          <p class=\"card-text small text-muted mt-2\">{$m['description']}</p>\n";
                  }
                  echo "        </div>\n";
                  echo "      </div>\n";
                  if (!empty($m['tags'])) {
                    echo "      <div class=\"d-flex flex-wrap gap-1 mt-2\">\n";
                    foreach ($m['tags'] as $tag) {
                      $tagName = $getTagName($tag);
                      $isSelected = in_array($tag, $filterSlugs);
                      $badgeClass = $isSelected ? 'bg-primary' : 'bg-secondary bg-opacity-50';
                      echo "        <button type=\"button\" class=\"badge {$badgeClass} border-0 tag-filter-badge\" ";
                      echo "data-tag-slug=\"" . htmlspecialchars($tag) . "\" data-tag-name=\"" . htmlspecialchars($tagName) . "\" ";
                      echo "style=\"cursor: pointer; font-size: 0.7rem;\">" . htmlspecialchars($tagName) . "</button>\n";
                    }
                    echo "      </div>\n";
                  }
                  echo "    </div>\n";
                  echo "    <div class=\"card-footer bg-transparent border-0\">\n";
                  echo "      <a href=\"{$m['url']}\" class=\"btn btn-outline-danger btn-sm w-100\"><i class=\"bi bi-play-circle\"></i>View Playlist</a>\n";
                  echo "    </div>\n";
                  echo "  </div>\n";
                  echo "</div>\n";
                } else {
                  // Generic content card (fallback)
                  echo "<div class=\"col-md-6 col-lg-4\">\n";
                  echo "  <div class=\"card h-100 border-0 shadow-sm hover-lift\">\n";
                  echo "    <div class=\"card-body\">\n";
                  echo "      <span class=\"badge bg-secondary mb-2\">Content</span>\n";
                  echo "      <h5 class=\"card-title\">{$m['title']}</h5>\n";
                  if (!empty($m['tags'])) {
                    echo "      <div class=\"d-flex flex-wrap gap-1 mt-2\">\n";
                    foreach ($m['tags'] as $tag) {
                      $tagName = $getTagName($tag);
                      $isSelected = in_array($tag, $filterSlugs);
                      $badgeClass = $isSelected ? 'bg-primary' : 'bg-secondary bg-opacity-50';
                      echo "        <button type=\"button\" class=\"badge {$badgeClass} border-0 tag-filter-badge\" ";
                      echo "data-tag-slug=\"" . htmlspecialchars($tag) . "\" data-tag-name=\"" . htmlspecialchars($tagName) . "\" ";
                      echo "style=\"cursor: pointer; font-size: 0.7rem;\">" . htmlspecialchars($tagName) . "</button>\n";
                    }
                    echo "      </div>\n";
                  }
                  echo "    </div>\n";
                  echo "    <div class=\"card-footer bg-transparent border-0\">\n";
                  echo "      <a href=\"{$m['url']}\" class=\"btn btn-outline-secondary btn-sm w-100\">View Content</a>\n";
                  echo "    </div>\n";
                  echo "  </div>\n";
                  echo "</div>\n";
                }
              }
              echo "</div>\n";
            }

            // Related tags
            if (count($related) > 0) {
              arsort($related);
              echo "<h5 class=\"mt-4\">Related Tags</h5>\n<div class=\"d-flex flex-wrap gap-2 mb-4\">\n";
              foreach ($related as $rslug => $count) {
                $name = $getTagName($rslug);
                echo "<button type=\"button\" class=\"badge bg-secondary text-white border-0 tag-filter-badge\" ";
                echo "data-tag-slug=\"" . htmlspecialchars($rslug) . "\" data-tag-name=\"" . htmlspecialchars($name) . "\" ";
                echo "style=\"cursor: pointer; padding: 0.5rem 0.75rem; font-size: 0.875rem;\">";
                echo htmlspecialchars($name) . " <span class=\"badge bg-dark rounded-pill ms-1 ps-2\" style=\"font-size: 0.75rem;\">" . intval($count) . "</span></button>\n";
              }
              echo "</div>\n";
            }

            ?>
          </div>
        </div>

      </div>
    </section>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
    
    <!-- Multi-tag Selection JavaScript -->
    <script>
    (function() {
      'use strict';
      
      // Track selected tags (initialize from current URL)
      let selectedTags = new Set(<?php echo json_encode($filterSlugs); ?>);
      
      // Add click handlers to all tag badges
      document.querySelectorAll('.tag-filter-badge').forEach(badge => {
        badge.addEventListener('click', function() {
          const tagSlug = this.dataset.tagSlug;
          
          if (!tagSlug) return;
          
          // Toggle tag selection
          if (selectedTags.has(tagSlug)) {
            selectedTags.delete(tagSlug);
          } else {
            selectedTags.add(tagSlug);
          }
          
          // Update URL and reload with new tag selection
          if (selectedTags.size > 0) {
            const slugParam = Array.from(selectedTags).join(',');
            window.location.href = '/tag/index.php?slug=' + encodeURIComponent(slugParam);
          } else {
            window.location.href = '/tags.php';
          }
        });
        
        // Add hover effect
        badge.addEventListener('mouseenter', function() {
          if (!this.classList.contains('bg-primary')) {
            this.style.transform = 'scale(1.05)';
            this.style.transition = 'transform 0.2s';
          }
        });
        badge.addEventListener('mouseleave', function() {
          this.style.transform = '';
        });
      });
    })();
    </script>
  </body>
</html>