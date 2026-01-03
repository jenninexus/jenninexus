# Page-Level Tag Filtering Implementation Plan

**Date:** October 30, 2025  
**Goal:** Add instant page-level filtering to gamedev.php, gaming.php, and diy.php (like blog.php)

---

## 🎯 Overview

Currently, blog.php has perfect instant filtering. We want the same for gamedev, gaming, and DIY pages.

### Current State (Offcanvas Redirect)
- User clicks "Filter Tags" button
- Opens offcanvas panel
- Selects multiple tags
- Clicks "Apply Filters" → **redirects to /tags.php**
- Shows site-wide results

### Desired State (Instant Page Filtering)
- User clicks tag button on page
- Content filters **instantly** (no page reload)
- Shows only matching playlists/content
- Works exactly like blog.php

---

## 📋 Implementation Checklist

### ✅ Already Working: blog.php
- Loads blog-posts.yaml directly
- Tag buttons at top filter posts instantly
- Simple JavaScript array filter
- **Reference:** `/public_html/blog.php` (lines 50-180)

### 🚧 TODO: gamedev.php
- [ ] Add tag filter buttons section
- [ ] Load gamedev.yaml via js-yaml (or use existing youtube-grid.js data)
- [ ] Extract unique tags from playlists
- [ ] Wire filter buttons to filter playlist cards
- [ ] Important tags: `gamedev`, `devlog`, `unity`, `3d-modeling`, `martiangames`, `game-jam`

### 🚧 TODO: gaming.php
- [ ] Add game-specific tag filter buttons
- [ ] Load gaming.yaml via js-yaml
- [ ] Extract tags including **game titles**
- [ ] Create filter sections: Platforms, Genres, Game Titles
- [ ] Wire buttons to filter playlist cards
- [ ] Important tags: `dead-space`, `resident-evil`, `ori`, `ps5`, `horror`, `fps`

### 🚧 TODO: diy.php
- [ ] Add category tag filter buttons
- [ ] Load diy.yaml + blog-posts.yaml
- [ ] Filter blog posts with DIY tags
- [ ] Show mixed content: playlists + blog posts
- [ ] Wire buttons to filter both types
- [ ] Blog posts link to `/blog/{slug}.php` with "Back to DIY" button
- [ ] Important tags: `diy`, `fashion`, `hair`, `nails`, `beauty`, `self-care`

---

## 🎨 Implementation Pattern (From blog.php)

### 1. Add Tag Filter Buttons

```html
<!-- Add this section near top of page, after hero -->
<section class="py-3 bg-body-secondary">
  <div class="container">
    <div class="d-flex justify-content-center gap-2 flex-wrap">
      <button class="btn btn-primary active" data-tag="all">All</button>
      <button class="btn btn-outline-primary" data-tag="gamedev">Game Dev</button>
      <button class="btn btn-outline-primary" data-tag="unity">Unity</button>
      <button class="btn btn-outline-primary" data-tag="3d-modeling">3D Modeling</button>
      <button class="btn btn-outline-primary" data-tag="martiangames">Martian Games</button>
    </div>
  </div>
</section>

<!-- Content container -->
<div class="container my-5">
  <div id="content-container" class="row g-4">
    <!-- Cards rendered here by JavaScript -->
  </div>
</div>
```

---

### 2. Load YAML Content via JavaScript

```javascript
<script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
<script>
async function loadAndRenderContent(filterTag = 'all') {
  try {
    // Load YAML file
    const res = await fetch('<?= RES_ROOT ?>/playlists/gamedev.yaml');
    const txt = await res.text();
    const parsed = jsyaml.load(txt);
    
    // Extract playlists from all sections
    const allPlaylists = [];
    if (parsed.featured_section && parsed.featured_section.playlists) {
      allPlaylists.push(...parsed.featured_section.playlists);
    }
    if (parsed.martian_games_playlists && parsed.martian_games_playlists.playlists) {
      allPlaylists.push(...parsed.martian_games_playlists.playlists);
    }
    
    // Filter by tag
    const filtered = filterTag === 'all' 
      ? allPlaylists 
      : allPlaylists.filter(playlist => 
          playlist.tags && playlist.tags.includes(filterTag)
        );
    
    // Render cards
    renderPlaylists(filtered);
    
  } catch (err) {
    console.error('Failed to load content:', err);
  }
}

function renderPlaylists(playlists) {
  const container = document.getElementById('content-container');
  container.innerHTML = '';
  
  playlists.forEach(playlist => {
    const col = document.createElement('div');
    col.className = 'col-md-6 col-lg-4';
    
    col.innerHTML = `
      <div class="card h-100 border-0 shadow-sm">
        <div class="card-body">
          <h5 class="card-title">${escapeHtml(playlist.title)}</h5>
          <p class="card-text text-muted">${escapeHtml(playlist.description || '')}</p>
          <div class="mb-3 d-flex flex-wrap gap-1">
            ${(playlist.tags || []).map(tag => 
              `<span class="badge bg-secondary">${escapeHtml(tag)}</span>`
            ).join('')}
          </div>
          <a href="https://www.youtube.com/playlist?list=${encodeURIComponent(playlist.id)}" 
             target="_blank" 
             class="btn btn-primary">
            <i class="fa-brands fa-youtube me-2"></i>Watch Playlist
          </a>
        </div>
      </div>
    `;
    
    container.appendChild(col);
  });
}

function escapeHtml(str) {
  return String(str || '').replace(/[&<>"'`]/g, s => 
    ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;','`':'&#96;'})[s]
  );
}

// Wire up filter buttons
document.querySelectorAll('[data-tag]').forEach(btn => {
  btn.addEventListener('click', function() {
    const tag = this.getAttribute('data-tag');
    
    // Update button states
    document.querySelectorAll('[data-tag]').forEach(b => {
      b.classList.remove('btn-primary', 'active');
      b.classList.add('btn-outline-primary');
    });
    this.classList.remove('btn-outline-primary');
    this.classList.add('btn-primary', 'active');
    
    // Filter content
    loadAndRenderContent(tag);
  });
});

// Initial load
document.addEventListener('DOMContentLoaded', () => loadAndRenderContent('all'));
</script>
```

---

## 🎮 gamedev.php - Specific Implementation

### Tags to Include
```javascript
const gamedevTags = [
  { id: 'all', label: 'All Projects' },
  { id: 'gamedev', label: 'Game Dev' },
  { id: 'devlog', label: 'Devlogs' },
  { id: 'unity', label: 'Unity' },
  { id: 'unreal', label: 'Unreal Engine' },
  { id: '3d-modeling', label: '3D Modeling' },
  { id: 'martiangames', label: 'Martian Games' },
  { id: 'game-jam', label: 'Game Jams' },
  { id: 'ludum-dare', label: 'Ludum Dare' }
];
```

### Content Sources
- Load `gamedev.yaml`
- Parse `featured_section.playlists` (Devlogs, games)
- Parse `martian_games_playlists.playlists` (Martian Games content)

### Card Design
- Show playlist thumbnail (YouTube API or placeholder)
- Title + description
- Tag badges
- "Watch Playlist" button → YouTube
- "View Project Page" button → /game/{slug}.php (if `page` property exists)

---

## 🎲 gaming.php - Specific Implementation

### Tags to Include (3 Sections)

**Platform Tags:**
```javascript
const platformTags = [
  { id: 'ps5', label: 'PS5' },
  { id: 'nintendo-switch', label: 'Nintendo Switch' },
  { id: 'pc', label: 'PC' }
];
```

**Genre Tags:**
```javascript
const genreTags = [
  { id: 'horror', label: 'Horror' },
  { id: 'fps', label: 'FPS' },
  { id: 'platformer', label: 'Platformer' },
  { id: 'indie', label: 'Indie' },
  { id: 'metroidvania', label: 'Metroidvania' }
];
```

**Game Title Tags (Dynamic from YAML):**
```javascript
// Extract from gaming.yaml playlists
const gameTitles = [
  'dead-space',
  'resident-evil',
  'ori',
  'metro-exodus',
  'apex-legends',
  // ... etc
];
```

### UI Layout

```html
<section class="py-3 bg-body-secondary">
  <div class="container">
    <h5 class="text-center mb-3">Filter Gaming Content</h5>
    
    <!-- Platform Section -->
    <div class="mb-3">
      <p class="small text-muted mb-2 text-center">Platforms</p>
      <div class="d-flex justify-content-center gap-2 flex-wrap">
        <button class="btn btn-sm btn-outline-primary" data-tag="ps5">PS5</button>
        <button class="btn btn-sm btn-outline-primary" data-tag="nintendo-switch">Switch</button>
        <button class="btn btn-sm btn-outline-primary" data-tag="pc">PC</button>
      </div>
    </div>
    
    <!-- Genre Section -->
    <div class="mb-3">
      <p class="small text-muted mb-2 text-center">Genres</p>
      <div class="d-flex justify-content-center gap-2 flex-wrap">
        <button class="btn btn-sm btn-outline-primary" data-tag="horror">Horror</button>
        <button class="btn btn-sm btn-outline-primary" data-tag="fps">FPS</button>
        <button class="btn btn-sm btn-outline-primary" data-tag="platformer">Platformer</button>
        <button class="btn btn-sm btn-outline-primary" data-tag="indie">Indie</button>
      </div>
    </div>
    
    <!-- Game Titles Section (Generated Dynamically) -->
    <div class="mb-3">
      <p class="small text-muted mb-2 text-center">Game Titles</p>
      <div id="game-title-tags" class="d-flex justify-content-center gap-2 flex-wrap">
        <!-- Populated by JavaScript from gaming.yaml -->
      </div>
    </div>
    
    <div class="text-center">
      <button class="btn btn-primary" data-tag="all">Show All</button>
    </div>
  </div>
</section>
```

### Content Sources
- Load `gaming.yaml`
- Parse `featured_section.playlists` (30+ gaming playlists)
- Extract unique tags for each section

---

## 💅 diy.php - Specific Implementation with Blog Integration

### Tags to Include
```javascript
const diyTags = [
  { id: 'all', label: 'All DIY' },
  { id: 'fashion', label: 'Fashion' },
  { id: 'hair', label: 'Hair' },
  { id: 'nails', label: 'Nails & Nail Art' },
  { id: 'beauty', label: 'Beauty' },
  { id: 'self-care', label: 'Self-Care' }
];
```

### Content Sources (2 Types)

**1. DIY Playlists (from diy.yaml):**
```javascript
const res1 = await fetch('/resources/playlists/diy.yaml');
const diyData = jsyaml.load(await res1.text());

const playlists = [];
if (diyData.fashion_section) playlists.push(...diyData.fashion_section.playlists);
if (diyData.hair_section) playlists.push(...diyData.hair_section.playlists);
if (diyData.nails_section) playlists.push(...diyData.nails_section.playlists);
```

**2. DIY Blog Posts (from blog-posts.yaml):**
```javascript
const res2 = await fetch('/resources/playlists/blog-posts.yaml');
const blogData = jsyaml.load(await res2.text());

const diyTagsArray = ['diy', 'beauty', 'fashion', 'hair', 'nails', 'nail-art', 'self-care', 'sustainability'];
const diyBlogs = blogData.filter(post => 
  post.tags && post.tags.some(tag => diyTagsArray.includes(tag))
);
```

### Render Mixed Content

```javascript
function renderMixedContent(playlists, blogPosts, filterTag) {
  const container = document.getElementById('content-container');
  container.innerHTML = '';
  
  // Filter playlists
  const filteredPlaylists = filterTag === 'all' 
    ? playlists 
    : playlists.filter(p => p.tags && p.tags.includes(filterTag));
  
  // Filter blog posts
  const filteredBlogs = filterTag === 'all'
    ? blogPosts
    : blogPosts.filter(b => b.tags && b.tags.includes(filterTag));
  
  // Render playlists
  filteredPlaylists.forEach(playlist => {
    container.appendChild(createPlaylistCard(playlist));
  });
  
  // Render blog posts
  filteredBlogs.forEach(blog => {
    container.appendChild(createBlogCard(blog));
  });
}

function createBlogCard(blog) {
  const col = document.createElement('div');
  col.className = 'col-md-6 col-lg-4';
  
  col.innerHTML = `
    <div class="card h-100 border-0 shadow-sm blog-post-card">
      <div class="card-body">
        <span class="badge bg-info mb-2">Blog Post</span>
        <h5 class="card-title">${escapeHtml(blog.title)}</h5>
        <p class="card-text text-muted">${escapeHtml(blog.excerpt)}</p>
        <div class="mb-3 d-flex flex-wrap gap-1">
          ${blog.tags.map(tag => 
            `<span class="badge bg-secondary">${escapeHtml(tag)}</span>`
          ).join('')}
        </div>
        <a href="/blog/${encodeURIComponent(blog.slug)}.php" class="btn btn-primary">
          Read More <i class="fa-solid fa-arrow-right ms-2"></i>
        </a>
      </div>
    </div>
  `;
  
  return col;
}
```

### Blog Post Page Integration

Each blog post in `/blog/*.php` should have a "Back to DIY" button if the post has DIY tags:

```php
<?php
// In blog post PHP file (e.g., diy-beauty-trends-2025.php)
$postTags = ['diy', 'beauty', 'sustainability', 'nail-art'];
$showDiyBackButton = array_intersect($postTags, ['diy', 'beauty', 'fashion', 'hair', 'nails', 'nail-art', 'self-care']);
?>

<?php if ($showDiyBackButton): ?>
<div class="container my-4">
  <a href="/diy.php" class="btn btn-outline-primary">
    <i class="fa-solid fa-arrow-left me-2"></i>Back to DIY
  </a>
</div>
<?php endif; ?>
```

---

## 🔧 Testing Checklist

### gamedev.php
- [ ] Visit http://localhost:8002/gamedev.php
- [ ] See all playlists initially
- [ ] Click "Devlogs" tag → filters to devlog playlists only
- [ ] Click "Martian Games" tag → filters to Martian Games playlists
- [ ] Click "All Projects" → shows everything again
- [ ] No page reload, instant filtering

### gaming.php
- [ ] Visit http://localhost:8002/gaming.php
- [ ] See all gaming playlists initially
- [ ] Click "PS5" tag → filters to PS5 playlists
- [ ] Click "Horror" tag → filters to horror game playlists
- [ ] Click "Dead Space" tag → filters to Dead Space specific playlists
- [ ] Click "Show All" → shows everything again
- [ ] No page reload, instant filtering

### diy.php
- [ ] Visit http://localhost:8002/diy.php
- [ ] See playlists + blog posts mixed together
- [ ] Click "Hair" tag → filters to hair playlists + hair blog posts
- [ ] Click "Beauty" tag → filters to beauty content
- [ ] Click blog post card → taken to `/blog/{slug}.php`
- [ ] See "Back to DIY" button at top of blog post
- [ ] Click "Back to DIY" → returns to /diy.php with filters intact
- [ ] No page reload, instant filtering

---

## 📝 Next Steps

1. **Update gamedev.php:**
   - Add tag filter buttons section
   - Add JavaScript to load gamedev.yaml
   - Wire up filter functionality

2. **Update gaming.php:**
   - Add 3-section filter layout (Platforms, Genres, Titles)
   - Add JavaScript to load gaming.yaml
   - Wire up filter functionality

3. **Update diy.php:**
   - Add tag filter buttons
   - Add JavaScript to load diy.yaml + blog-posts.yaml
   - Render mixed content (playlists + blog posts)
   - Wire up filter functionality

4. **Update blog post templates:**
   - Add "Back to DIY" button for DIY-tagged posts
   - Add "Back to Gaming" button for gaming-tagged posts (future)
   - Add "Back to Game Dev" button for gamedev-tagged posts (future)

5. **Test thoroughly:**
   - Run dev server
   - Test each page's filtering
   - Verify instant filtering (no reload)
   - Check tag badge clicks
   - Verify blog post integration on DIY page

---

## 🎯 Success Criteria

✅ **gamedev.php** filters playlists instantly by tag  
✅ **gaming.php** filters by platform, genre, and game title  
✅ **diy.php** shows mixed playlists + blog posts, filters both  
✅ No page reloads - instant filtering like blog.php  
✅ Blog posts link properly and have "Back" buttons  
✅ All filtering works without breaking existing offcanvas panel  

---

**Implementation Priority:** Medium  
**Estimated Time:** 3-4 hours total  
**Dependencies:** js-yaml library (already used in blog.php)  
**Impact:** High - significantly improves UX on 3 major pages
