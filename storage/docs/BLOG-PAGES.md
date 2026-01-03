# Blog System Documentation - JenniNexus

**Version:** 1.0  
**Last Updated:** October 29, 2025  
**Status:** ✅ PRODUCTION READY

---

## 🎯 Overview

JenniNexus uses a **YAML-driven blog system** with client-side rendering. Blog posts are defined in a single YAML file and rendered dynamically by `blog.php`. Individual blog post pages are PHP files with full control over content, embeds, and styling.

---

## 📁 File Structure

### Core Blog System Files

```
📊 BLOG LISTING (Dynamic Rendering)
├─ blog.php - Main blog listing page with category filters
└─ blog-posts.yaml - Single source of truth for all blog post metadata

📄 BLOG POST PAGES (Individual Posts)
├─ blog/ai-tools-for-technical-artists.php
├─ blog/ai-tools-using-ai.php
├─ blog/build-and-deploy-2024.php
├─ blog/diy-beauty-trends-2025.php
├─ blog/game-dev-in-2025.php
├─ blog/pax-west-2022.php
├─ blog/pax-west-gaming-con.php
├─ blog/summercon-2024.php
└─ blog/voice-acting-in-games.php

🖼️ BLOG IMAGES
└─ resources/images/blog/ - All blog thumbnail images

🏷️ TAG SYSTEM INTEGRATION
├─ resources/playlists/tags.json - Tag definitions (115 tags)
├─ resources/playlists/content_tags.json - Content-to-tag mappings
├─ resources/js/tag-system.js - Tag filtering logic
└─ resources/js/tag-filter-api.js - Tag API layer
```

---

## 📝 How to Create a New Blog Post

### Step 1: Choose a Slug

**Slug Rules:**
- All lowercase
- Use hyphens for spaces (e.g., `my-new-post`)
- Keep it short but descriptive
- Must match filename: `{slug}.php`

**Example:** `ai-tools-2025` → `blog/ai-tools-2025.php`

---

### Step 2: Add Entry to `blog-posts.yaml`

**Location:** `public_html/resources/playlists/blog-posts.yaml`

**Template:**
```yaml
- slug: your-post-slug
  title: "Your Post Title"
  date: "YYYY-MM-DD"
  category: "Category Name"
  excerpt: "Short description (1-2 sentences) shown on blog listing page."
  image: "/blog/your-image.jpg"
  tags: ["tag1","tag2","tag3"]
  playlist: "PLAYLIST_ID or playlist_alias"
```

**Field Definitions:**

| Field | Required | Description | Example |
|-------|----------|-------------|---------|
| `slug` | ✅ Yes | URL-friendly identifier (matches .php filename) | `ai-tools-2025` |
| `title` | ✅ Yes | Post title (shown on listing + detail page) | `"AI Tools for 2025"` |
| `date` | ✅ Yes | Publication date (YYYY-MM-DD format) | `"2025-03-20"` |
| `category` | ✅ Yes | Category badge (AI & Technology, Game Development, etc.) | `"AI & Technology"` |
| `excerpt` | ✅ Yes | Preview text (1-2 sentences for listing page) | `"Explore the latest AI tools..."` |
| `image` | ✅ Yes | Thumbnail image path (relative to `/resources/images/`) | `"/blog/ai-tools.jpg"` |
| `tags` | ✅ Yes | Array of tag slugs for filtering | `["ai","productivity","tools"]` |
| `playlist` | ⚠️ Optional | YouTube playlist ID or alias (for video embeds) | `"PL9QBjNDhgNwQ..."` or `"devlogs"` |

**Category Options:**
- `"AI & Technology"`
- `"Game Development"`
- `"Gaming & Events"`
- `"Voice Acting"`
- `"DIY & Beauty"`
- `"DevOps"`
- `"Events"`

**Complete Example:**
```yaml
- slug: my-new-blog-post
  title: "My New Blog Post: A Complete Guide"
  date: "2025-10-29"
  category: "AI & Technology"
  excerpt: "Learn everything about creating amazing blog posts with practical examples and step-by-step instructions."
  image: "/blog/my-new-post-thumbnail.jpg"
  tags: ["ai","tutorial","productivity","blog"]
  playlist: "PL9QBjNDhgNwQYrXaiRwC0RROYmkppbssY"
```

---

### Step 3: Create Blog Post PHP File

**Location:** `public_html/blog/{slug}.php`

**Filename:** Must match the `slug` field in YAML exactly.

**Basic Template:**
```php
<?php
$activePage = 'blog';
$pageTitle = 'Your Post Title | JenniNexus Blog';
$pageDescription = 'Your post description for SEO and social sharing.';
$pageKeywords = 'keyword1, keyword2, keyword3';
// If using Facebook embeds, set this flag:
// $needsFb = true;
?>
<!doctype html>
<html lang="en" data-bs-theme="dark">
<?php include '../includes/head.php'; ?>
<body>
  
  <?php include '../includes/header.php'; ?>

  <!-- Blog Post Content -->
  <article class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <!-- Post Header -->
          <header class="mb-5">
            <div class="mb-3">
              <span class="badge bg-primary">Category Name</span>
              <span class="text-muted ms-2">Month DD, YYYY</span>
            </div>
            <h1 class="display-4 mb-4">Your Post Title</h1>
            <p class="lead text-muted">Your post subtitle or lead paragraph.</p>
            <hr>
          </header>

          <!-- Post Body -->
          <div class="post-content">
            <p>Your blog post content goes here...</p>
          </div>

          <!-- Tags -->
          <div class="mt-5">
            <a href="../tags.php?filters=tag1" class="badge bg-secondary me-1 text-decoration-none tag-badge">Tag 1</a>
            <a href="../tags.php?filters=tag2" class="badge bg-secondary me-1 text-decoration-none tag-badge">Tag 2</a>
          </div>

          <!-- Share & Navigation -->
          <div class="mt-5 pt-4 border-top">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
              <a href="../blog.php" class="btn btn-outline-primary">
                <i class="fa-solid fa-arrow-left me-2"></i>Back to Blog
              </a>
              <div class="d-flex gap-2">
                <a href="https://twitter.com/intent/tweet?url=<?= urlencode('https://jenninexus.com/blog/your-slug') ?>" target="_blank" class="btn btn-outline-secondary">
                  <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('https://jenninexus.com/blog/your-slug') ?>" target="_blank" class="btn btn-outline-secondary">
                  <i class="fa-brands fa-facebook"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </article>

  <?php include '../includes/footer.php'; ?>

</body>
</html>
```

---

### Step 4: Add Thumbnail Image

**Location:** `public_html/resources/images/blog/`

**Image Requirements:**
- **Format:** JPG or PNG
- **Recommended Size:** 1200x630px (Facebook/Twitter OG image size)
- **Minimum Size:** 800x450px
- **Aspect Ratio:** 16:9 preferred
- **File Size:** < 500KB (optimize with TinyPNG or similar)

**Naming Convention:**
- Match the slug or be descriptive
- Examples: `ai-tools-2025.jpg`, `gamedev-tutorial.png`, `pax-2022.jpg`

**Upload Process:**
1. Save image to `public_html/resources/images/blog/your-image.jpg`
2. Update `blog-posts.yaml` with path: `image: "/blog/your-image.jpg"`
3. Path is relative to `/resources/images/`

---

### Step 5: Add Tags (Tag System Integration)

#### Where Tags Are Defined

**Primary Tag Source:** `public_html/resources/playlists/tags.json`
- 115 tags available
- Tags organized by category (gamedev, gaming, diy, voice-acting, ai, meta)

**Tag Categories:**
- `gamedev` (37 tags) - unity, unreal, blender, vr, game-jam, devlog, etc.
- `gaming` (30 tags) - fps, rpg, adventure, horror, indie, multiplayer, etc.
- `diy` (20 tags) - fashion, nails, hair, makeup, crafts, self-care, etc.
- `voice-acting` (3 tags) - voice-acting, voice-over, character-development
- `ai` - ai, technical-art, 3d-modeling, productivity, claude, vscode
- `meta` (11 tags) - blog, patreon, featured, community, social-media

#### How to Add Tags to Blog Posts

**1. In `blog-posts.yaml` (Listing Page):**
```yaml
tags: ["ai","productivity","tools","gamedev"]
```
- Use tag **slugs** (lowercase, hyphenated)
- Tags enable filtering on blog listing page
- Tag badges display on blog post cards

**2. In Individual Blog Post PHP File:**
```php
<!-- Tags Section -->
<div class="mt-5">
  <a href="../tags.php?filters=ai" class="badge bg-secondary me-1 text-decoration-none tag-badge">AI</a>
  <a href="../tags.php?filters=productivity" class="badge bg-secondary me-1 text-decoration-none tag-badge">Productivity</a>
</div>
```

**Tag Badge Attributes:**
- `href` - Link to tags page with filter query param (`../tags.php?filters=slug`)
- `class` - Bootstrap badge classes + `text-decoration-none`
- Badge text - Display name (can be friendly version of slug)

**Tag Badge Best Practices:**
- Use 3-5 tags per post (avoid tag spam)
- Match tags in YAML and PHP file
- Use existing tags from tags.json when possible
- Display most relevant tags first

---

### Step 6: Embed Videos/Playlists (Optional)

#### RES_ROOT & Resources Access

**Blog pages are in nested directory:** `public_html/blog/`

**RES_ROOT Definition (Defensive Pattern):**
```php
<?php
// Define RES_ROOT for blog subdirectory (before includes)
if (!defined('RES_ROOT')) {
  define('RES_ROOT', '/resources');
}
?>
```

**Why Defensive Definition?**
- Blog pages may be accessed directly or via router
- Ensures RES_ROOT exists before head.php include
- head.php also defines RES_ROOT, but uses `if (!defined())` check
- Safe to define in both places - first definition wins

**Include Paths (Relative):**
```php
include '../includes/head.php';    // Go up one level
include '../includes/header.php';
include '../includes/footer.php';
```

**Resource Paths (Web URLs):**
```php
<!-- CSS (via $customCSS before head.php) -->
<?php $customCSS = [RES_ROOT . '/css/blog-theme.min.css']; ?>

<!-- Images -->
<img src="<?= RES_ROOT ?>/images/blog/my-post.jpg" alt="Post thumbnail">

<!-- JavaScript -->
<script src="<?= RES_ROOT ?>/js/tag-system.js"></script>

<!-- YAML (from main blog.php listing) -->
fetch('<?= RES_ROOT ?>/playlists/blog-posts.yaml')
```

**Critical Rule:** Always use `<?= RES_ROOT ?>` for web URLs in PHP, never hardcode `/resources`.

**Image Directory:** `public_html/resources/images/blog/`
- All blog thumbnails go here
- YAML format: `image: "/blog/my-post.jpg"` (relative to /resources/images/)
- Resolves to: `<?= RES_ROOT ?>/images/blog/my-post.jpg`

#### YouTube Playlist Embed

**Required Scripts (auto-loaded by footer.php):**
```php
<!-- js-yaml for parsing YAML configs (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>

<!-- youtube-grid.js for video rendering -->
<script src="<?= RES_ROOT ?>/js/youtube-grid.js"></script>
```

**Option A: YouTube Grid Component (Recommended)**
```php
<!-- YouTube Playlist Grid (Auto-Init via data-playlist) -->
<section class="mt-4">
  <h3 class="mb-3">Related Videos</h3>
  <p class="text-muted">Watch the full playlist on YouTube.</p>
  <div class="video-grid-container" 
       data-playlist="PL9QBjNDhgNwQYrXaiRwC0RROYmkppbssY" 
       data-max="12" 
       data-columns="3">
  </div>
</section>
```

**How It Works:**
1. youtube-grid.js scans for `[data-playlist]` containers on DOMContentLoaded
2. Fetches video data via `/resources/api/get-youtube.php?playlist_id={ID}`
3. Proxy converts YouTube RSS to JSON (NO API key needed)
4. Renders responsive grid with Bootstrap 5.3.8 column classes
5. Caches results (10min server, 24hr client)

**data-playlist Attributes:**
- `data-playlist` - YouTube playlist ID (starts with PL...)
- `data-max` - Maximum videos to show (default: 6)
- `data-columns` - Grid columns (responsive: 3 = mobile 1, tablet 2, desktop 3)
  - `"3"` → `col-12 col-md-6 col-lg-4` (1/2/3 column layout)
  - `"4"` → `col-12 col-md-6 col-lg-3` (1/2/4 column layout)
  - youtube-grid.js automatically generates Bootstrap responsive classes

**Playlist ID Source:**
- Get from `blog-posts.yaml` metadata: `playlist: "PL9QBjNDhgNwQYrXaiRwC0RROYmkppbssY"`
- Or hardcode directly in blog post PHP file
- Playlist must be public (unlisted works, private does not)

**Example: voice-acting-in-games.php (line 62):**
```php
<div class="video-grid-container" 
     data-playlist="PL9QBjNDhgNwQbaceJmfZzc3x4L80gvh8J" 
     data-max="6" 
     data-columns="3">
</div>
```

**RSS Proxy Details:**
- **Proxy:** `public_html/resources/api/get-youtube.php`
- **NO API KEY** - uses public YouTube RSS feeds only
- **Cache:** 10 minutes server-side at `/var/www/jenninexus/storage/cache/youtube/`
- **Client Cache:** 24 hours in localStorage
- **See:** `.config/video-deps.json` for complete video system architecture

**Option B: Single YouTube Video Embed**
```php
<div class="ratio ratio-16x9 mb-4">
  <iframe src="https://www.youtube.com/embed/VIDEO_ID" 
          title="Video Title" 
          frameborder="0" 
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
          referrerpolicy="strict-origin-when-cross-origin" 
          allowfullscreen>
  </iframe>
</div>
```

#### TikTok Embed

```php
<div class="mb-4 d-flex justify-content-center">
  <blockquote class="tiktok-embed" 
              cite="https://www.tiktok.com/@username/video/VIDEO_ID" 
              data-video-id="VIDEO_ID" 
              style="max-width: 605px;min-width: 325px;"> 
    <section> 
      <a target="_blank" 
         title="@username" 
         href="https://www.tiktok.com/@username?refer=embed">@username</a>
      Video description text here
    </section> 
  </blockquote> 
  <script async src="https://www.tiktok.com/embed.js"></script>
</div>
```

**Required:** TikTok script is already allowed in CSP headers.

#### Facebook Post Embed

```php
<?php
// At top of file
$needsFb = true; // Loads Facebook SDK
?>

<!-- In post content -->
<div class="mb-4 d-flex justify-content-center">
  <iframe src="https://www.facebook.com/plugins/post.php?href=POST_URL&show_text=true&width=500" 
          width="500" 
          height="745" 
          style="border:none;overflow:hidden" 
          scrolling="no" 
          frameborder="0" 
          allowfullscreen="true" 
          allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
  </iframe>
</div>
```

**Steps:**
1. Set `$needsFb = true;` at top of PHP file
2. Add Facebook iframe embed in post content
3. Replace `POST_URL` with actual Facebook post URL (URL-encoded)

#### Instagram Embed

```php
<blockquote class="instagram-media" 
            data-instgrm-permalink="https://www.instagram.com/reel/REEL_ID/?utm_source=ig_embed&amp;utm_campaign=loading" 
            data-instgrm-version="14" 
            style=" background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
  <div style="padding:16px;"> 
    <a href="https://www.instagram.com/reel/REEL_ID/?utm_source=ig_embed&amp;utm_campaign=loading" 
       style=" background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;" 
       target="_blank">View on Instagram</a>
  </div>
</blockquote>
<script async src="https://www.instagram.com/embed.js" crossorigin="anonymous"></script>
```

**Required:** Instagram script is already allowed in CSP headers.

---

## 🏷️ Tag System Integration

### How Tags Work

```
┌─────────────────────────────────────────────────────────────────┐
│                  BLOG TAG SYSTEM FLOW                            │
└─────────────────────────────────────────────────────────────────┘

1. USER VISITS BLOG.PHP
   ├─→ blog.php loads blog-posts.yaml
   └─→ Renders blog post cards with tag badges

2. USER CLICKS TAG BADGE
   ├─→ tag-system.js activates filter
   └─→ Shows only posts with matching tag

3. USER CLICKS TAG ON BLOG POST PAGE
   ├─→ window.tagFilter.toggle('tag-slug') executes
   ├─→ Navigates to /tag/index.php?slug=tag-slug
   └─→ Shows all content tagged with that tag
```

### Tag Badge Examples (Real Posts)

**AI Tools for Technical Artists:**
```yaml
# In blog-posts.yaml:
tags: ["ai","technical-art","3d-modeling","productivity","gamedev","unity"]
```
```php
// In ai-tools-for-technical-artists.php:
<a href="../tags.php?filters=ai" class="badge bg-secondary me-1 text-decoration-none tag-badge">AI</a>
<a href="../tags.php?filters=technical-art" class="badge bg-secondary me-1 text-decoration-none tag-badge">Technical Art</a>
<a href="../tags.php?filters=gamedev" class="badge bg-secondary me-1 text-decoration-none tag-badge">Game Dev</a>
```

**Voice Acting in Games:**
```yaml
# In blog-posts.yaml:
tags: ["voice-acting","game development","character development","newgrounds","animation"]
```
```php
// In voice-acting-in-games.php:
<a href="../tags.php?filters=voice-acting" class="badge bg-secondary me-1 text-decoration-none tag-badge">Voice Acting</a>
<a href="../tags.php?filters=game-development" class="badge bg-secondary me-1 text-decoration-none tag-badge">Game Development</a>
```

---

## 📋 Blog Post Checklist

### Pre-Publish Checklist

- [ ] **Slug chosen** (lowercase, hyphenated, matches filename)
- [ ] **Entry added to `blog-posts.yaml`** with all required fields
- [ ] **PHP file created** at `public_html/blog/{slug}.php`
- [ ] **Thumbnail image added** to `public_html/resources/images/blog/`
- [ ] **Bootstrap responsive layout used** (no inline padding styles)
- [ ] **Tags added in YAML** (3-5 tags, use existing tags from tags.json)
- [ ] **Tag badges added to PHP file** (matching YAML tags)
- [ ] **Content proofread** (spelling, grammar, formatting)
- [ ] **Images optimized** (< 500KB, proper alt text)
- [ ] **Embeds working** (YouTube, TikTok, Facebook, Instagram if used)
- [ ] **Social sharing links work** (Twitter, Facebook buttons)
- [ ] **Tested on dev server** (http://localhost:8002/blog/{slug}.php)
- [ ] **No console errors** (check browser DevTools)
- [ ] **Mobile responsive** (test on iPhone 390px, tablet, desktop)

### Post-Publish Verification

- [ ] Blog post appears on `/blog.php` listing page
- [ ] Thumbnail image displays correctly
- [ ] Category badge shows correct category
- [ ] Date displays correctly
- [ ] Excerpt text accurate
- [ ] Tag filtering works (click tag badges on listing)
- [ ] Individual post page loads without errors
- [ ] Tags on post page are clickable
- [ ] All embeds render correctly
- [ ] Social sharing buttons work
- [ ] Back to Blog link works

---

## 🔧 Troubleshooting

### Blog Post Not Showing on Listing Page

**Check:**
1. YAML syntax is valid (no tabs, proper indentation)
2. `slug` field matches .php filename exactly
3. `date` field is in YYYY-MM-DD format
4. All required fields present (slug, title, date, category, excerpt, image, tags)
5. No duplicate slugs in YAML

**Fix:** Validate YAML at https://www.yamllint.com/

### Thumbnail Image Not Loading

**Check:**
1. Image exists at `public_html/resources/images/blog/{filename}`
2. Image path in YAML starts with `/blog/` (e.g., `/blog/my-image.jpg`)
3. Image file extension matches (`.jpg` vs `.jpeg`)
4. File permissions correct (readable by web server)

**Fix:** Update image path in YAML, ensure file exists

### Tag Filtering Not Working

**Check:**
1. Tag slugs in YAML match tags in `tags.json`
2. Tag badges have correct `data-tag-slug` attribute
3. `onclick` handler present: `window.tagFilter.toggle('slug')`
4. No JavaScript errors in console

**Fix:** Match tag slugs exactly, check console for errors

### Embeds Not Rendering

**TikTok:** 
- Check CSP headers allow `https://www.tiktok.com`
- Ensure `<script async src="https://www.tiktok.com/embed.js"></script>` present

**Facebook:**
- Set `$needsFb = true;` at top of PHP file
- Check iframe `src` URL is correct
- CSP allows `https://www.facebook.com` and `https://connect.facebook.net`

**Instagram:**
- Check CSP allows `https://www.instagram.com`
- Ensure `<script async src="https://www.instagram.com/embed.js">` present

**YouTube:**
- Use `youtube-grid.js` component or standard iframe embed
- Check playlist ID is correct
- Ensure `data-playlist` attribute present on grid container

---

## 📊 Current Blog Posts (9 Total)

| Slug | Title | Category | Tags | Playlist |
|------|-------|----------|------|----------|
| `ai-tools-for-technical-artists` | AI Tools for Technical Artists | AI & Technology | ai, technical-art, 3d-modeling, productivity, gamedev, unity | ✅ |
| `game-dev-in-2025` | Game Development in 2025 | Game Development | gamedev, trends, unity, unreal | ✅ |
| `voice-acting-in-games` | Voice Acting in Games | Voice Acting | voice-acting, game development, character development, newgrounds, animation | ✅ |
| `pax-west-gaming-con` | PAX West Gaming Convention 2025 | Gaming & Events | gaming, conventions, pax-west, indie-games | ✅ |
| `pax-west-2022` | PAX West 2022 Gallery & Recap | Gaming & Events | pax-west, gaming, community | ✅ |
| `ai-tools-using-ai` | Using AI Tools | AI & Technology | ai, productivity, tools, claude, vscode, gamedev | ✅ |
| `build-and-deploy-2024` | Build & Deploy 2024 | DevOps | devops, build, deploy | ❌ |
| `summercon-2024` | Summercon Washington 2024 | Events | events, summercon, community | ❌ |
| `diy-beauty-trends-2025` | DIY Beauty Trends 2025 | DIY & Beauty | diy, beauty, sustainability, nail art | ✅ |

---

## 🎨 Content Security Policy (CSP) Headers

**Current CSP Allows:**
- YouTube embeds (`https://www.youtube.com`, `https://img.youtube.com`)
- TikTok embeds (`https://www.tiktok.com`)
- Facebook embeds (`https://www.facebook.com`, `https://connect.facebook.net`)
- Instagram embeds (`https://www.instagram.com`)

**Location:** `public_html/includes/head.php`

**If adding new embed source:**
1. Update `script-src` directive
2. Update `frame-src` directive (for iframes)
3. Update `connect-src` directive (for API calls)
4. Test embed renders correctly

---

## 📚 Related Documentation

- **TAG-SYSTEM.md** - Complete tag system documentation
- **YOUTUBE.md** - YouTube integration and playlist embedding
- **PLAYLIST-MAPPING.md** - Playlist IDs and configuration
- **DEPLOYMENT-GUIDE.md** - How to deploy blog changes to production

---

## � Bootstrap 5.3.8 Responsive Design

### Responsive Layout Requirements

**All blog posts MUST follow Bootstrap 5.3.8 responsive patterns:**

✅ **DO:**
- Use `<article class="py-5">` (no inline styles)
- Use `<div class="container">` (responsive padding via custom.css)
- Use `<div class="col-lg-8 mx-auto">` for content width
- Use Bootstrap responsive utilities (`d-flex`, `mb-3`, `mb-lg-5`)
- Let `custom.css` handle responsive padding with clamp() values

❌ **DON'T:**
- Use inline `style="padding-top: 100px;"` (not mobile responsive)
- Use inline `style="margin-top: 56px;"` (breaks on mobile)
- Override Bootstrap grid with custom CSS Grid
- Use fixed pixel values for spacing

### Responsive Breakpoints

**Bootstrap 5.3.8 Breakpoints:**
- `xs` - Extra small (<576px) - iPhone 13/14 (390px), mobile devices
- `sm` - Small (≥576px) - Large phones (landscape)
- `md` - Medium (≥768px) - Tablets
- `lg` - Large (≥992px) - Small desktops
- `xl` - Extra large (≥1200px) - Desktops
- `xxl` - Extra extra large (≥1400px) - Large desktops

### YouTube Grid Responsive Behavior

**`data-columns` attribute automatically generates Bootstrap responsive classes:**

```php
<!-- 3-column playlist grid -->
<div class="video-grid-container" data-playlist="ID" data-columns="3"></div>
<!-- youtube-grid.js generates: col-12 col-md-6 col-lg-4 -->
<!-- Result: 1 column mobile, 2 tablet, 3 desktop -->

<!-- 4-column gallery grid -->
<div class="video-grid-container" data-playlist="ID" data-columns="4"></div>
<!-- youtube-grid.js generates: col-12 col-sm-6 col-md-4 col-lg-3 -->
<!-- Result: 1 mobile, 2 small, 3 medium, 4 desktop -->
```

**Column Mapping (youtube-grid.js):**
- `columns: 1` → `col-12` (full width all screens)
- `columns: 2` → `col-md-6` (1 mobile, 2 tablet+)
- `columns: 3` → `col-md-6 col-lg-4` (1 mobile, 2 tablet, 3 desktop)
- `columns: 4` → `col-md-6 col-lg-3` (1 mobile, 2 tablet, 4 desktop)

### Responsive Images

**Use Bootstrap image utilities:**
```php
<!-- Fluid images -->
<img src="<?= RES_ROOT ?>/images/blog/image.jpg" 
     class="img-fluid rounded mb-4" 
     loading="lazy" 
     alt="Description">

<!-- Image galleries -->
<div class="row g-2 g-md-3">
  <div class="col-6 col-md-4">
    <img src="<?= RES_ROOT ?>/images/blog/img1.jpg" class="img-fluid rounded">
  </div>
  <div class="col-6 col-md-4">
    <img src="<?= RES_ROOT ?>/images/blog/img2.jpg" class="img-fluid rounded">
  </div>
</div>
<!-- Result: 2 columns mobile, 3 columns tablet+ -->
```

### Responsive Spacing

**Use Bootstrap responsive spacing utilities:**
```php
<!-- Responsive margins -->
<div class="mb-3 mb-lg-5">Content</div>
<!-- 1rem margin on mobile, 3rem on large screens -->

<!-- Responsive padding -->
<section class="py-3 py-md-5">Section</section>
<!-- 1rem padding mobile, 3rem padding tablet+ -->

<!-- Responsive gaps -->
<div class="d-flex gap-2 gap-md-4">
  <button>Button 1</button>
  <button>Button 2</button>
</div>
<!-- 0.5rem gap mobile, 1.5rem gap tablet+ -->
```

**See also:** `storage/docs/BOOTSTRAP-5.3.8.md` for comprehensive Bootstrap integration guide

---

## �🚀 Quick Start: Create Your First Blog Post

```bash
# 1. Choose a slug
SLUG="my-first-post"

# 2. Create PHP file
New-Item "public_html/blog/$SLUG.php" -ItemType File

# 3. Add thumbnail image
# Copy image to: public_html/resources/images/blog/$SLUG.jpg

# 4. Edit blog-posts.yaml
# Add new entry with all required fields

# 5. Test on dev server
# Visit: http://localhost:8002/blog.php
# Visit: http://localhost:8002/blog/$SLUG.php

# 6. Verify tags work
# Click tag badges on listing page
# Click tag badges on detail page

# 7. Deploy to production
.\scripts\build-and-deploy.ps1
```

---

**Last Updated:** November 3, 2025  
**Maintainer:** JenniNexus  
**Version:** 1.0 - Initial comprehensive documentation
