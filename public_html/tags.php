<?php
$activePage = 'tags';
$pageTitle = 'Tags - JenniNexus';
$pageDescription = 'All tags used across JenniNexus content.';
// Load theme CSS for the tag pages so the index right-side panel and tag pages
// pick up our site-wide theme variants. head.php will include these when it
// echoes $customCSS (it checks for this variable before output).
$customCSS = [
  '/resources/css/tags-theme.min.css'
];
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
  <?php include __DIR__ . '/includes/head.php'; ?>
  <body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <section class="py-5">
      <div class="container">
        <div class="row mb-4">
          <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-5">Tag Index</h1>
            <p class="lead">Browse all tags used across playlists, posts, and pages.</p>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-10 mx-auto">
            
            <!-- Popular Tag Suggestions -->
            <?php if (empty($_GET['filters'])): ?>
            <div class="mb-4 text-center">
              <h5 class="mb-3">Popular Tags</h5>
              <div class="d-flex flex-wrap justify-content-center gap-2">
                <a href="/tags.php?filters=Gaming" class="badge bg-primary text-decoration-none" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                  <i class="bi bi-controller"></i> Gaming
                </a>
                <a href="/tags.php?filters=Game%20Development" class="badge bg-success text-decoration-none" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                  <i class="bi bi-code-slash"></i> Game Dev
                </a>
                <a href="/tags.php?filters=DIY" class="badge bg-danger text-decoration-none" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                  <i class="bi bi-scissors"></i> DIY
                </a>
                <a href="/tags.php?filters=Horror" class="badge bg-warning text-decoration-none" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                  <i class="bi bi-bug"></i> Horror
                </a>
                <a href="/tags.php?filters=Unity" class="badge bg-info text-decoration-none" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                  <i class="bi bi-unity"></i> Unity
                </a>
                <a href="/tags.php?filters=Beauty" class="badge bg-secondary text-decoration-none" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                  <i class="bi bi-heart"></i> Beauty
                </a>
              </div>
            </div>
            <?php endif; ?>
            
            <?php
            $tagsPath = __DIR__ . '/resources/playlists/tags.json';
            $contentTagsPath = __DIR__ . '/resources/playlists/content_tags.json';
            $tags = [];
            $counts = [];
            if (file_exists($tagsPath)) {
              $tags = json_decode(file_get_contents($tagsPath), true) ?: [];
            }

            // Build counts from content_tags (support several shapes)
            $ct = [];
            if (file_exists($contentTagsPath)) {
              $ct = json_decode(file_get_contents($contentTagsPath), true) ?: [];
            }

            // Also try to ingest blog-posts.yaml so tag pages can reference nicer titles/URLs
            $blogYamlPath = __DIR__ . '/resources/playlists/blog-posts.yaml';
            if (file_exists($blogYamlPath)) {
              $yamlTxt = file_get_contents($blogYamlPath);
              // Very small YAML parser for our simple blog-posts.yaml structure
              $lines = preg_split('/\r?\n/', $yamlTxt);
              $current = null;
              foreach ($lines as $ln) {
                $trim = ltrim($ln);
                if (strpos($trim, '- slug:') === 0) {
                  // start new entry
                  $slug = trim(substr($trim, strlen('- slug:')));
                  $slug = trim($slug, " \t\"'");
                  $current = $slug;
                  if ($current !== '') $ct[$current] = $ct[$current] ?? [];
                  continue;
                }
                if ($current === null) continue;
                // key: value lines
                if (preg_match('/^\s+([a-zA-Z0-9_\-]+):\s*(.*)$/', $ln, $m)) {
                  $key = $m[1];
                  $val = trim($m[2]);
                  // strip surrounding single or double quotes
                  $val = preg_replace('/(^["\']|["\']$)/', '', $val);
                  if ($key === 'title') {
                    $ct[$current]['title'] = $val;
                    $ct[$current]['url'] = '/blog/' . rawurlencode($current) . '.php';
                  } elseif ($key === 'tags') {
                    // expect tags: ["a","b"] or tags: [a, b]
                    if (preg_match('/\[(.*)\]/', $val, $mm)) {
                      $inner = trim($mm[1]);
                      // split by comma and trim quotes
                      $parts = preg_split('/\s*,\s*/', $inner);
                      $tagsArr = [];
                      foreach ($parts as $p) {
                        $p = trim($p, " \t\"'");
                        if ($p !== '') $tagsArr[] = $p;
                      }
                      $ct[$current]['tags'] = $tagsArr;
                    }
                  }
                }
              }
            }

            // Now compute counts from the aggregated $ct map
            foreach ($ct as $k => $v) {
              $tlist = [];
              if (is_array($v) && array_values($v) === $v) {
                $tlist = $v;
              } elseif (is_array($v) && isset($v['tags']) && is_array($v['tags'])) {
                $tlist = $v['tags'];
              }
              foreach ($tlist as $t) {
                if (is_scalar($t)) $counts[(string)$t] = ($counts[(string)$t] ?? 0) + 1;
              }
            }

            // If filters are provided (via ?filters=tag1,tag2) show filtered content instead of just listing tags
            $filters = [];
            if (!empty($_GET['filters'])) {
              $filters = array_filter(array_map('trim', explode(',', (string)$_GET['filters'])));
            }

            // Render tags list with multi-select capability
            echo "<div class=\"mb-4\">\n";
            
            // Always show Clear All Tags button (visible but disabled when no filters)
            $hasFilters = !empty($filters);
            $btnDisabled = $hasFilters ? '' : ' disabled';
            echo "<div class=\"d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2\">\n";
            echo "  <p class=\"text-muted small mb-0\">Click tags to add/remove filters. Select multiple tags to refine results.</p>\n";
            echo "  <a href=\"/tags.php\" class=\"btn btn-sm btn-outline-secondary{$btnDisabled}\">\n";
            echo "    <i class=\"bi bi-x-circle\"></i>Clear All Tags\n";
            echo "  </a>\n";
            echo "</div>\n";
            
            echo "<div id=\"tagCloud\" class=\"d-flex flex-wrap gap-2\" style=\"opacity: 1 !important;\">\n";
            foreach ($tags as $tag) {
              if (!is_array($tag)) continue;
              $slugRaw = '';
              $nameRaw = '';
              if (isset($tag['slug']) && is_scalar($tag['slug'])) $slugRaw = (string)$tag['slug'];
              elseif (isset($tag['name']) && is_scalar($tag['name'])) $slugRaw = strtolower(preg_replace('/[^a-z0-9\-]+/','-', $tag['name']));
              if (isset($tag['name']) && is_scalar($tag['name'])) $nameRaw = (string)$tag['name'];
              $slug = htmlspecialchars($slugRaw);
              $name = htmlspecialchars($nameRaw ?: $slugRaw);
              $count = intval($counts[$slugRaw] ?? $counts[(string)($tag['id'] ?? '')] ?? 0);
              
              // Check if this tag is in the current filter
              $isActive = in_array($nameRaw, $filters) || in_array($slugRaw, $filters);
              $activeClass = $isActive ? ' active' : '';
              
              // Use glass-badge for cohesive styling
              echo "<button type=\"button\" class=\"glass-badge tag-badge tag-filter-badge{$activeClass}\" ";
              echo "data-tag-slug=\"{$slug}\" data-tag-name=\"" . htmlspecialchars($nameRaw) . "\">";
              echo $name;
              if ($count > 0) echo "<span class=\"badge bg-dark bg-opacity-75 rounded-pill ms-1\" style=\"font-size: 0.75rem;\">{$count}</span>";
              echo "</button>\n";
            }
            echo "</div>\n";
            echo "</div>\n";

            // If filters provided, build and display matching content
            if (!empty($filters)) {
              echo "<h3 class=\"mt-4\">Filtered results for: " . htmlspecialchars(implode(', ', $filters)) . "</h3>\n";
              
              // Build a map of tag ID => slug and tag name => slug for flexible matching
              $tagIdToSlug = [];
              $tagNameToSlug = [];
              $tagSlugToName = [];
              foreach ($tags as $tag) {
                if (!is_array($tag)) continue;
                $id = isset($tag['id']) && is_scalar($tag['id']) ? (string)$tag['id'] : '';
                $slug = isset($tag['slug']) && is_scalar($tag['slug']) ? (string)$tag['slug'] : '';
                $name = isset($tag['name']) && is_scalar($tag['name']) ? (string)$tag['name'] : '';
                if ($id !== '' && $slug !== '') $tagIdToSlug[$id] = $slug;
                if ($name !== '' && $slug !== '') $tagNameToSlug[$name] = $slug;
                if ($slug !== '' && $name !== '') $tagSlugToName[$slug] = $name;
              }
              
              // Convert filter names/slugs to a normalized set of slugs
              $filterSlugs = [];
              foreach ($filters as $f) {
                $f = trim($f);
                // Check if it's already a slug
                if (isset($tagSlugToName[$f])) {
                  $filterSlugs[] = $f;
                } elseif (isset($tagNameToSlug[$f])) {
                  // Convert name to slug
                  $filterSlugs[] = $tagNameToSlug[$f];
                } else {
                  // Fallback: use as-is (might be a slug we don't recognize)
                  $filterSlugs[] = strtolower(preg_replace('/[^a-z0-9\-]+/', '-', $f));
                }
              }
              
              // search content_tags for any items that match any of the filters
              $matches = [];
              if (file_exists($contentTagsPath)) {
                $ct = json_decode(file_get_contents($contentTagsPath), true) ?: [];
                foreach ($ct as $contentId => $meta) {
                  // Skip entries that are just arrays of tag IDs (category pages like /diy, /gaming)
                  if (!is_array($meta) || array_values($meta) === $meta) {
                    // This is just an array of tag IDs, not a content object - skip it
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
                    // Check if it's a numeric ID
                    if (isset($tagIdToSlug[$t])) {
                      $contentSlugs[] = $tagIdToSlug[$t];
                    } elseif (isset($tagNameToSlug[$t])) {
                      $contentSlugs[] = $tagNameToSlug[$t];
                    } else {
                      // Already a slug or unknown
                      $contentSlugs[] = $t;
                    }
                  }
                  
                  $intersect = array_intersect($filterSlugs, $contentSlugs);
                  if (!empty($intersect)) {
                    $title = is_array($meta) && isset($meta['title']) && is_scalar($meta['title']) ? (string)$meta['title'] : (is_string($contentId) ? $contentId : 'Content');
                    $url = is_array($meta) && isset($meta['url']) && is_scalar($meta['url']) ? (string)$meta['url'] : null;
                    $type = 'content'; // default type
                    $description = '';
                    $thumbnail = '';
                    
                    // Check if type is specified in metadata
                    if (is_array($meta) && isset($meta['type']) && is_scalar($meta['type'])) {
                      $type = (string)$meta['type'];
                    }
                    
                    // Determine content type and enhance metadata
                    if (strpos($contentId, 'playlist:') === 0) {
                      // Playlist entry format: "playlist:PL123..."
                      $type = 'playlist';
                      $playlistId = substr($contentId, strlen('playlist:'));
                      $thumbnail = "https://img.youtube.com/vi/" . $playlistId . "/mqdefault.jpg"; // Use first video thumb as fallback
                      if (!$url) {
                        $url = "https://www.youtube.com/playlist?list=" . rawurlencode($playlistId);
                      }
                    } elseif ($type === 'blog' || strpos($contentId, 'blog/') === 0 || strpos($contentId, '/blog') === 0) {
                      // Blog post
                      $type = 'blog';
                      $slug = is_array($meta) && isset($meta['slug']) ? (string)$meta['slug'] : $contentId;
                      $possibleBlog = __DIR__ . '/blog/' . $slug . '.php';
                      if (is_file($possibleBlog) && !$url) {
                        $url = '/blog/' . rawurlencode($slug) . '.php';
                      }
                    } elseif ($type === 'game' || strpos($contentId, 'game/') === 0 || strpos($contentId, '/game') === 0) {
                      // Game page
                      $type = 'game';
                      $slug = is_array($meta) && isset($meta['slug']) ? (string)$meta['slug'] : $contentId;
                      $gameSlug = preg_replace('#^/?game/([^/]+).*$#', '$1', $slug);
                      $thumbnail = "/resources/images/games/{$gameSlug}-thumb.jpg";
                      if (!$url) {
                        $url = '/game/' . rawurlencode($gameSlug) . '.php';
                      }
                    } elseif ($type === 'video' || preg_match('/^[a-zA-Z0-9_-]{11}$/', $contentId)) {
                      // YouTube video ID format
                      $type = 'video';
                      $thumbnail = "https://img.youtube.com/vi/{$contentId}/mqdefault.jpg";
                      if (!$url) {
                        $url = "https://www.youtube.com/watch?v=" . rawurlencode($contentId);
                      }
                    }
                    
                    // Skip entries that start with "/" - these are page/category URLs, not content items
                    if (strpos($contentId, '/') === 0 && !$url) {
                      continue;
                    }
                    
                    // Fallback URL generation - only if no URL was set above
                    if (!$url) {
                      // Check if it's a recognizable file in blog/
                      $possibleBlog = __DIR__ . '/blog/' . $contentId . '.php';
                      if (is_file($possibleBlog)) {
                        $url = '/blog/' . rawurlencode($contentId) . '.php';
                        $type = 'blog';
                      } else {
                        // Skip unknown content types without explicit URLs
                        continue;
                      }
                    }
                    
                    // Extract description from meta if available
                    if (is_array($meta) && isset($meta['description'])) {
                      $description = (string)$meta['description'];
                    }
                    
                    $matches[] = [
                      'title' => htmlspecialchars($title),
                      'url' => htmlspecialchars($url),
                      'tags' => $contentSlugs, // Use normalized slugs for display
                      'type' => $type,
                      'description' => htmlspecialchars($description),
                      'thumbnail' => $thumbnail
                    ];
                  }
                }
              }

              if (empty($matches)) {
                echo "<div class=\"alert alert-warning\">No content matched those tags.</div>";
              } else {
                // Helper function to convert slug to display name
                $getTagName = function($slug) use ($tagSlugToName) {
                  return isset($tagSlugToName[$slug]) ? $tagSlugToName[$slug] : $slug;
                };
                
                // Display as visual cards instead of simple list
                echo "<div class=\"results-header mb-5\">\n";
                echo "  <h2 class=\"display-6 fw-bold mb-2\">Filtered results for: <span class=\"text-primary\">" . htmlspecialchars(implode(', ', $filters)) . "</span></h2>\n";
                echo "  <p class=\"text-muted\">Found " . count($matches) . " matching items</p>\n";
                echo "</div>\n";

                echo "<div class=\"row g-4 mb-4\">\n";
                foreach ($matches as $m) {
                  // Different card styles based on content type
                  if ($m['type'] === 'game') {
                    // Game card with thumbnail
                    echo "<div class=\"col-md-6 col-lg-4\">\n";
                    echo "  <div class=\"card h-100 border-0 shadow-sm hover-lift glass-card\">\n";
                    if ($m['thumbnail'] && file_exists(__DIR__ . $m['thumbnail'])) {
                      echo "    <img src=\"{$m['thumbnail']}\" class=\"card-img-top\" alt=\"{$m['title']}\" style=\"height: 200px; object-fit: cover;\">\n";
                    } else {
                      echo "    <div class=\"card-img-top bg-dark d-flex align-items-center justify-content-center\" style=\"height: 200px;\">\n";
                      echo "      <i class=\"bi bi-controller fs-1 text-primary\"></i>\n";
                      echo "    </div>\n";
                    }
                    echo "    <div class=\"card-body\">\n";
                    echo "      <span class=\"badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 mb-2\">Game</span>\n";
                    echo "      <h5 class=\"card-title\">{$m['title']}</h5>\n";
                    if ($m['description']) {
                      echo "      <p class=\"card-text small text-muted line-clamp-2\">{$m['description']}</p>\n";
                    }
                    if (!empty($m['tags'])) {
                      echo "      <div class=\"d-flex flex-wrap gap-2 mt-3\">\n";
                      foreach ($m['tags'] as $tag) {
                        $tagName = $getTagName($tag);
                        $isSelected = in_array($tagName, $filters) || in_array($tag, $filters);
                        $activeClass = $isSelected ? ' active' : '';
                        echo "        <button type=\"button\" class=\"glass-badge tag-badge tag-filter-badge{$activeClass}\" ";
                        echo "data-tag-slug=\"" . htmlspecialchars($tag) . "\" data-tag-name=\"" . htmlspecialchars($tagName) . "\" ";
                        echo "style=\"font-size: 0.7rem;\">" . htmlspecialchars($tagName) . "</button>\n";
                      }
                      echo "      </div>\n";
                    }
                    echo "    </div>\n";
                    echo "    <div class=\"card-footer bg-transparent border-0 pt-0\">\n";
                    echo "      <a href=\"{$m['url']}\" class=\"btn btn-outline-primary btn-sm w-100 py-2\">Learn More</a>\n";
                    echo "    </div>\n";
                    echo "  </div>\n";
                    echo "</div>\n";
                  } elseif ($m['type'] === 'blog') {
                    // Blog card
                    echo "<div class=\"col-md-6 col-lg-4\">\n";
                    echo "  <div class=\"card h-100 border-0 shadow-sm hover-lift glass-card\">\n";
                    echo "    <div class=\"card-body\">\n";
                    echo "      <span class=\"badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 mb-2\">Blog Post</span>\n";
                    echo "      <h5 class=\"card-title\">{$m['title']}</h5>\n";
                    if ($m['description']) {
                      echo "      <p class=\"card-text small text-muted line-clamp-2\">{$m['description']}</p>\n";
                    }
                    if (!empty($m['tags'])) {
                      echo "      <div class=\"d-flex flex-wrap gap-2 mt-3\">\n";
                      foreach ($m['tags'] as $tag) {
                        $tagName = $getTagName($tag);
                        $isSelected = in_array($tagName, $filters) || in_array($tag, $filters);
                        $activeClass = $isSelected ? ' active' : '';
                        echo "        <button type=\"button\" class=\"glass-badge tag-badge tag-filter-badge{$activeClass}\" ";
                        echo "data-tag-slug=\"" . htmlspecialchars($tag) . "\" data-tag-name=\"" . htmlspecialchars($tagName) . "\" ";
                        echo "style=\"font-size: 0.7rem;\">" . htmlspecialchars($tagName) . "</button>\n";
                      }
                      echo "      </div>\n";
                    }
                    echo "    </div>\n";
                    echo "    <div class=\"card-footer bg-transparent border-0 pt-0\">\n";
                    echo "      <a href=\"{$m['url']}\" class=\"btn btn-outline-info btn-sm w-100 py-2\">Read More</a>\n";
                    echo "    </div>\n";
                    echo "  </div>\n";
                    echo "</div>\n";
                  } elseif ($m['type'] === 'video') {
                    // Video card with YouTube thumbnail
                    echo "<div class=\"col-md-6 col-lg-4 video-card\">\n";
                    echo "  <div class=\"card h-100\">\n";
                    if ($m['thumbnail']) {
                      echo "    <div class=\"ratio ratio-16x9 video-thumbnail\">\n";
                      echo "      <img src=\"{$m['thumbnail']}\" class=\"card-img-top\" alt=\"{$m['title']}\">\n";
                      echo "      <div class=\"play-overlay\"><i class=\"bi bi-play-fill\"></i></div>\n";
                      echo "    </div>\n";
                    }
                    echo "    <div class=\"card-body\">\n";
                    echo "      <span class=\"badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 mb-2\">Video</span>\n";
                    echo "      <h5 class=\"card-title\">{$m['title']}</h5>\n";
                    if (!empty($m['tags'])) {
                      echo "      <div class=\"d-flex flex-wrap gap-2 mt-3\">\n";
                      foreach ($m['tags'] as $tag) {
                        $tagName = $getTagName($tag);
                        $isSelected = in_array($tagName, $filters) || in_array($tag, $filters);
                        $activeClass = $isSelected ? ' active' : '';
                        echo "        <button type=\"button\" class=\"glass-badge tag-badge tag-filter-badge{$activeClass}\" ";
                        echo "data-tag-slug=\"" . htmlspecialchars($tag) . "\" data-tag-name=\"" . htmlspecialchars($tagName) . "\" ";
                        echo "style=\"font-size: 0.7rem;\">" . htmlspecialchars($tagName) . "</button>\n";
                      }
                      echo "      </div>\n";
                    }
                    echo "    </div>\n";
                    echo "    <div class=\"card-footer bg-transparent border-0 pt-0\">\n";
                    echo "      <a href=\"{$m['url']}\" class=\"btn btn-outline-danger btn-sm w-100 py-2\">Watch Video</a>\n";
                    echo "    </div>\n";
                    echo "  </div>\n";
                    echo "</div>\n";
                  } elseif ($m['type'] === 'playlist') {
                    // Playlist card - NEW!
                    echo "<div class=\"col-md-6 col-lg-4 playlist-card-single\">\n";
                    echo "  <div class=\"card h-100\">\n";
                    echo "    <div class=\"card-body\">\n";
                    echo "      <div class=\"d-flex align-items-start mb-3\">\n";
                    echo "        <div class=\"playlist-icon-control me-3\">\n";
                    echo "          <i class=\"bi bi-play-fill svg-inline text-danger\"></i>\n";
                    echo "        </div>\n";
                    echo "        <div class=\"flex-grow-1\">\n";
                    echo "          <span class=\"badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 mb-2\">Playlist</span>\n";
                    echo "          <h5 class=\"card-title mb-1\">{$m['title']}</h5>\n";
                    if ($m['description']) {
                      echo "          <p class=\"card-text small text-muted mt-2 line-clamp-2\">{$m['description']}</p>\n";
                    }
                    echo "        </div>\n";
                    echo "      </div>\n";
                    if (!empty($m['tags'])) {
                      echo "      <div class=\"d-flex flex-wrap gap-2 mt-3\">\n";
                      foreach ($m['tags'] as $tag) {
                        $tagName = $getTagName($tag);
                        $isSelected = in_array($tagName, $filters) || in_array($tag, $filters);
                        $activeClass = $isSelected ? ' active' : '';
                        echo "        <button type=\"button\" class=\"glass-badge tag-badge tag-filter-badge{$activeClass}\" ";
                        echo "data-tag-slug=\"" . htmlspecialchars($tag) . "\" data-tag-name=\"" . htmlspecialchars($tagName) . "\" ";
                        echo "style=\"font-size: 0.7rem;\">" . htmlspecialchars($tagName) . "</button>\n";
                      }
                      echo "      </div>\n";
                    }
                    echo "    </div>\n";
                    echo "    <div class=\"card-footer bg-transparent border-0 pt-0\">\n";
                    echo "      <a href=\"{$m['url']}\" class=\"btn btn-outline-danger btn-sm w-100 py-2\"><i class=\"bi bi-play-circle me-2\"></i>View Playlist</a>\n";
                    echo "    </div>\n";
                    echo "  </div>\n";
                    echo "</div>\n";
                  } else {
                    // Generic content card (fallback)
                    echo "<div class=\"col-md-6 col-lg-4\">\n";
                    echo "  <div class=\"card h-100 border-0 shadow-sm hover-lift glass-card\">\n";
                    echo "    <div class=\"card-body\">\n";
                    echo "      <span class=\"badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 mb-2\">Content</span>\n";
                    echo "      <h5 class=\"card-title\">{$m['title']}</h5>\n";
                    if (!empty($m['tags'])) {
                      echo "      <div class=\"d-flex flex-wrap gap-2 mt-3\">\n";
                      foreach ($m['tags'] as $tag) {
                        $tagName = $getTagName($tag);
                        $isSelected = in_array($tagName, $filters) || in_array($tag, $filters);
                        $activeClass = $isSelected ? ' active' : '';
                        echo "        <button type=\"button\" class=\"glass-badge tag-badge tag-filter-badge{$activeClass}\" ";
                        echo "data-tag-slug=\"" . htmlspecialchars($tag) . "\" data-tag-name=\"" . htmlspecialchars($tagName) . "\" ";
                        echo "style=\"font-size: 0.7rem;\">" . htmlspecialchars($tagName) . "</button>\n";
                      }
                      echo "      </div>\n";
                    }
                    echo "    </div>\n";
                    echo "    <div class=\"card-footer bg-transparent border-0 pt-0\">\n";
                    echo "      <a href=\"{$m['url']}\" class=\"btn btn-outline-secondary btn-sm w-100 py-2\">View Content</a>\n";
                    echo "    </div>\n";
                    echo "  </div>\n";
                    echo "</div>\n";
                  }
                }
                echo "</div>\n";
              }
            }
            ?>
          </div>
        </div>

      </div>
    </section>

    <?php include __DIR__ . '/includes/footer.php'; ?>
    
    <!-- Multi-tag Selection JavaScript -->
    <script>
    (function() {
      'use strict';
      
      // Track selected tags
      let selectedTags = new Set();
      
      // Parse existing filters from URL
      const urlParams = new URLSearchParams(window.location.search);
      const existingFilters = urlParams.get('filters');
      if (existingFilters) {
        existingFilters.split(',').forEach(tag => selectedTags.add(tag.trim()));
      }
      
      // Prevent flicker by hiding tag cloud during navigation
      function navigateWithTransition(url) {
        const tagCloud = document.getElementById('tagCloud');
        if (tagCloud) {
          tagCloud.style.opacity = '0.5';
          tagCloud.style.pointerEvents = 'none';
        }
        // Small delay to show visual feedback before navigation
        setTimeout(() => {
          window.location.href = url;
        }, 150);
      }
      
      // Add click handlers to all tag badges
      document.querySelectorAll('.tag-filter-badge').forEach(badge => {
        badge.addEventListener('click', function(e) {
          e.preventDefault();
          const tagName = this.dataset.tagName;
          const tagSlug = this.dataset.tagSlug;
          
          // Toggle tag selection
          if (selectedTags.has(tagName)) {
            selectedTags.delete(tagName);
          } else {
            selectedTags.add(tagName);
          }
          
          // Update URL and reload with transition
          if (selectedTags.size > 0) {
            const filterParam = Array.from(selectedTags).join(',');
            navigateWithTransition('/tags.php?filters=' + encodeURIComponent(filterParam));
          } else {
            navigateWithTransition('/tags.php');
          }
        });
      });
      
      // Add hover effect
      document.querySelectorAll('.tag-filter-badge').forEach(badge => {
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
      
      // Smooth fade-in on page load to prevent flicker
      // REMOVED: Causing visibility issues where tags disappear after load
      /*
      window.addEventListener('DOMContentLoaded', function() {
        const tagCloud = document.getElementById('tagCloud');
        if (tagCloud) {
          tagCloud.style.transition = 'opacity 0.3s ease-in';
          tagCloud.style.opacity = '1';
        }
      });
      */
    })();
    </script>
  </body>
</html>
