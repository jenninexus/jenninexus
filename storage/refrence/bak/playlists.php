<?php
if (!defined('MARTIAN_GAMES_SECURE')) define('MARTIAN_GAMES_SECURE', true);

$pageTitle = 'Video Playlists - Martian Games';
$pageDescription = 'Watch our curated playlists featuring game development, gameplay showcases, and behind-the-scenes content from Martian Games.';
$pageKeywords = 'martian games, video playlists, gameplay videos, game development, devlogs, unity 3D games';
$ogImage = EnvLoader::get('OG_IMAGE_URL') ?: EnvLoader::get('APP_URL', '') . '/resources/images/martiangames_logo_thumb.png';
$currentUrl = EnvLoader::pageUrl('PAGE_PLAYLISTS_URL', '/playlists');
$ogType = 'website';
$resourcesPath = EnvLoader::get('RESOURCES_PATH') ?: '/resources';
$cssPath = EnvLoader::get('CSS_PATH') ?: '/resources/css/customMG.css';
$resourcesPath = '/' . ltrim($resourcesPath, '/');
$cssPath = '/' . ltrim($cssPath, '/');
$relativeResourcesPath = $resourcesPath;

// NO EXTERNAL SCRIPTS - Playlist loader embedded below
require_once __DIR__ . '/../includes/header.php';
?>

<main id="main-content" class="flex-grow-1 page-container">
    <div class="mg-page-inner">
        <div class="container">
            
            <!-- Page Title Section -->
            <section class="p-4 p-md-5 mb-4 mb-md-2">
                <div class="row">
                    <div class="col-12">
                        <div class="panel glass-panel text-center p-4">
                            <h1 class="mb-3">📺 Video Playlists</h1>
                            <p class="lead">Watch our curated playlists featuring game development, gameplay showcases, and community content</p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Martian Games Devlogs -->
            <section class="p-4 p-md-5 mb-4 mb-md-2">
                <div class="row">
                    <div class="col-12">
                        <div class="panel glass-panel p-4">
                            <h2 class="h3 mb-4">🎮 Martian Games Devlogs</h2>
                            <p class="text-muted small mb-4">Development videos featuring games from Martian Games</p>
                            <div id="devlogs-grid" class="row g-4 playlist-grid" data-playlist-id="PL5RIMPpbzR6iA9rAMaDX-B2QfKMQkODwq">
                                <!-- Loading placeholders -->
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="playlist-card loading">
                                        <div class="playlist-thumbnail placeholder-shimmer"></div>
                                        <div class="playlist-content">
                                            <div class="placeholder-shimmer mb-2" style="height:18px;width:80%;border-radius:4px;"></div>
                                            <div class="placeholder-shimmer" style="height:14px;width:100%;border-radius:4px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="playlist-card loading">
                                        <div class="playlist-thumbnail placeholder-shimmer"></div>
                                        <div class="playlist-content">
                                            <div class="placeholder-shimmer mb-2" style="height:18px;width:80%;border-radius:4px;"></div>
                                            <div class="placeholder-shimmer" style="height:14px;width:100%;border-radius:4px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="playlist-card loading">
                                        <div class="playlist-thumbnail placeholder-shimmer"></div>
                                        <div class="playlist-content">
                                            <div class="placeholder-shimmer mb-2" style="height:18px;width:80%;border-radius:4px;"></div>
                                            <div class="placeholder-shimmer" style="height:14px;width:100%;border-radius:4px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="playlist-card loading">
                                        <div class="playlist-thumbnail placeholder-shimmer"></div>
                                        <div class="playlist-content">
                                            <div class="placeholder-shimmer mb-2" style="height:18px;width:80%;border-radius:4px;"></div>
                                            <div class="placeholder-shimmer" style="height:14px;width:100%;border-radius:4px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Martian Games Gameplay -->
            <section class="p-4 p-md-5 mb-4 mb-md-2">
                <div class="row">
                    <div class="col-12">
                        <div class="panel glass-panel p-4">
                            <h2 class="h3 mb-4">✈️ Martian Games Gameplay</h2>
                            <p class="text-muted small mb-4">JenniPlaysGames showcasing various Martian Games titles</p>
                            <div id="gameplay-grid" class="row g-4 playlist-grid" data-playlist-id="PL6WnzXOaRqA1sfMS1N7EoESHKaTZ2RHh4">
                                <!-- Loading placeholders -->
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="playlist-card loading">
                                        <div class="playlist-thumbnail placeholder-shimmer"></div>
                                        <div class="playlist-content">
                                            <div class="placeholder-shimmer mb-2" style="height:18px;width:80%;border-radius:4px;"></div>
                                            <div class="placeholder-shimmer" style="height:14px;width:100%;border-radius:4px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="playlist-card loading">
                                        <div class="playlist-thumbnail placeholder-shimmer"></div>
                                        <div class="playlist-content">
                                            <div class="placeholder-shimmer mb-2" style="height:18px;width:80%;border-radius:4px;"></div>
                                            <div class="placeholder-shimmer" style="height:14px;width:100%;border-radius:4px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="playlist-card loading">
                                        <div class="playlist-thumbnail placeholder-shimmer"></div>
                                        <div class="playlist-content">
                                            <div class="placeholder-shimmer mb-2" style="height:18px;width:80%;border-radius:4px;"></div>
                                            <div class="placeholder-shimmer" style="height:14px;width:100%;border-radius:4px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="playlist-card loading">
                                        <div class="playlist-thumbnail placeholder-shimmer"></div>
                                        <div class="playlist-content">
                                            <div class="placeholder-shimmer mb-2" style="height:18px;width:80%;border-radius:4px;"></div>
                                            <div class="placeholder-shimmer" style="height:14px;width:100%;border-radius:4px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Purgatory Fell VR -->
            <section class="p-4 p-md-5 mb-4 mb-md-2">
                <div class="row">
                    <div class="col-12">
                        <div class="panel glass-panel p-4">
                            <h2 class="h3 mb-4">🎧 Purgatory Fell VR</h2>
                            <p class="text-muted small mb-4">Immersive VR horror experience on Steam</p>
                            <div id="purgatoryfell-grid" class="row g-4 playlist-grid" data-playlist-id="PL9QBjNDhgNwTsF4Es4jEftJR2Tto1CU53">
                                <!-- Loading placeholders -->
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="playlist-card loading">
                                        <div class="playlist-thumbnail placeholder-shimmer"></div>
                                        <div class="playlist-content">
                                            <div class="placeholder-shimmer mb-2" style="height:18px;width:80%;border-radius:4px;"></div>
                                            <div class="placeholder-shimmer" style="height:14px;width:100%;border-radius:4px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="playlist-card loading">
                                        <div class="playlist-thumbnail placeholder-shimmer"></div>
                                        <div class="playlist-content">
                                            <div class="placeholder-shimmer mb-2" style="height:18px;width:80%;border-radius:4px;"></div>
                                            <div class="placeholder-shimmer" style="height:14px;width:100%;border-radius:4px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="playlist-card loading">
                                        <div class="playlist-thumbnail placeholder-shimmer"></div>
                                        <div class="playlist-content">
                                            <div class="placeholder-shimmer mb-2" style="height:18px;width:80%;border-radius:4px;"></div>
                                            <div class="placeholder-shimmer" style="height:14px;width:100%;border-radius:4px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="playlist-card loading">
                                        <div class="playlist-thumbnail placeholder-shimmer"></div>
                                        <div class="playlist-content">
                                            <div class="placeholder-shimmer mb-2" style="height:18px;width:80%;border-radius:4px;"></div>
                                            <div class="placeholder-shimmer" style="height:14px;width:100%;border-radius:4px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Botborgs -->
            <section class="p-4 p-md-5 mb-4 mb-md-2">
                <div class="row">
                    <div class="col-12">
                        <div class="panel glass-panel p-4">
                            <h2 class="h3 mb-4">🤖 Botborgs</h2>
                            <p class="text-muted small mb-4">Web3 game featuring 3D 'Botborg' characters and an interplanetary society</p>
                            <div id="botborgs-grid" class="row g-4 playlist-grid" data-playlist-id="PL9QBjNDhgNwQYrXaiRwC0RROYmkppbssY">
                                <!-- Loading placeholders -->
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="playlist-card loading">
                                        <div class="playlist-thumbnail placeholder-shimmer"></div>
                                        <div class="playlist-content">
                                            <div class="placeholder-shimmer mb-2" style="height:18px;width:80%;border-radius:4px;"></div>
                                            <div class="placeholder-shimmer" style="height:14px;width:100%;border-radius:4px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="playlist-card loading">
                                        <div class="playlist-thumbnail placeholder-shimmer"></div>
                                        <div class="playlist-content">
                                            <div class="placeholder-shimmer mb-2" style="height:18px;width:80%;border-radius:4px;"></div>
                                            <div class="placeholder-shimmer" style="height:14px;width:100%;border-radius:4px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="playlist-card loading">
                                        <div class="playlist-thumbnail placeholder-shimmer"></div>
                                        <div class="playlist-content">
                                            <div class="placeholder-shimmer mb-2" style="height:18px;width:80%;border-radius:4px;"></div>
                                            <div class="placeholder-shimmer" style="height:14px;width:100%;border-radius:4px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                    <div class="playlist-card loading">
                                        <div class="playlist-thumbnail placeholder-shimmer"></div>
                                        <div class="playlist-content">
                                            <div class="placeholder-shimmer mb-2" style="height:18px;width:80%;border-radius:4px;"></div>
                                            <div class="placeholder-shimmer" style="height:14px;width:100%;border-radius:4px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Subscribe CTA Section -->
            <section class="p-4 p-md-5 mb-4 mb-md-2">
                <div class="row">
                    <div class="col-12">
                        <div class="panel glass-panel text-center p-4" style="background: rgba(255, 0, 0, 0.08); border: 1px solid rgba(255, 0, 0, 0.25);">
                            <h2 class="h3 text-primary mb-3">📺 Subscribe for More Content</h2>
                            <p class="lead mb-4">Never miss a new video! Subscribe to our YouTube channel for gameplay, devlogs, and community content.</p>
                            <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
                                <?php
                                $youtubeUrl = EnvLoader::get('SOCIAL_YOUTUBE_URL') ?: '#';
                                ?>
                                <a href="<?= htmlspecialchars($youtubeUrl) ?>" 
                                   target="_blank" 
                                   rel="noopener noreferrer" 
                                   class="social-brand-btn btn-lg" 
                                   data-brand="youtube" 
                                   role="button" 
                                   aria-label="Subscribe on YouTube">
                                    <svg class="svg-brand-icon" width="18" height="18" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/>
                                    </svg>
                                    <span class="social-brand-label">Subscribe on YouTube</span>
                                </a>
                                <?php
                                $discordUrl = EnvLoader::get('SOCIAL_DISCORD_URL') ?: '#';
                                ?>
                                <a href="<?= htmlspecialchars($discordUrl) ?>" 
                                   target="_blank" 
                                   rel="noopener noreferrer" 
                                   class="social-brand-btn btn-lg" 
                                   data-brand="discord" 
                                   role="button" 
                                   aria-label="Join Discord">
                                    <svg class="svg-brand-icon" width="18" height="18" viewBox="0 0 640 512" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M524.531,69.836a1.5,1.5,0,0,0-.764-.7A485.065,485.065,0,0,0,404.081,32.03a1.816,1.816,0,0,0-1.923.91,337.461,337.461,0,0,0-14.9,30.6,447.848,447.848,0,0,0-134.426,0,309.541,309.541,0,0,0-15.135-30.6,1.89,1.89,0,0,0-1.924-.91A483.689,483.689,0,0,0,116.085,69.137a1.712,1.712,0,0,0-.788.676C39.068,183.651,18.186,294.69,28.43,404.354a2.016,2.016,0,0,0,.765,1.375A487.666,487.666,0,0,0,176.02,479.918a1.9,1.9,0,0,0,2.063-.676A348.2,348.2,0,0,0,208.12,430.4a1.86,1.86,0,0,0-1.019-2.588,321.173,321.173,0,0,1-45.868-21.853,1.885,1.885,0,0,1-.185-3.126c3.082-2.309,6.166-4.711,9.109-7.137a1.819,1.819,0,0,1,1.9-.256c96.229,43.917,200.41,43.917,295.5,0a1.812,1.812,0,0,1,1.924.233c2.944,2.426,6.027,4.851,9.132,7.16a1.884,1.884,0,0,1-.162,3.126,301.407,301.407,0,0,1-45.89,21.83,1.875,1.875,0,0,0-1,2.611,391.055,391.055,0,0,0,30.014,48.815,1.864,1.864,0,0,0,2.063.7A486.048,486.048,0,0,0,610.7,405.729a1.882,1.882,0,0,0,.765-1.352C623.729,277.594,590.933,167.465,524.531,69.836ZM222.491,337.58c-28.972,0-52.844-26.587-52.844-59.239S193.056,219.1,222.491,219.1c29.665,0,53.306,26.82,52.843,59.239C275.334,310.993,251.924,337.58,222.491,337.58Zm195.38,0c-28.971,0-52.843-26.587-52.843-59.239S388.437,219.1,417.871,219.1c29.667,0,53.307,26.82,52.844,59.239C470.715,310.993,447.538,337.58,417.871,337.58Z"/>
                                    </svg>
                                    <span class="social-brand-label">Join Discord Community</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            
        </div> <!-- Close container -->
    </div> <!-- Close mg-page-inner -->
</main>

<script type="application/ld+json" nonce="<?= CSP_NONCE ?>">
    <?= json_encode([
        "@context" => "https://schema.org",
        "@type" => "CollectionPage",
        "name" => "Martian Games Video Playlists",
        "url" => rtrim(EnvLoader::get('APP_URL') ?: '', '/') . "/playlists",
        "description" => "Curated video playlists featuring Martian Games gameplay, development, and community content",
        "mainEntity" => [
            "@type" => "Organization",
            "name" => "Martian Games",
            "url" => EnvLoader::get('APP_URL'),
            "logo" => EnvLoader::get('OG_IMAGE_URL'),
            "sameAs" => [
                EnvLoader::get('SOCIAL_YOUTUBE_URL'),
                EnvLoader::get('SOCIAL_DISCORD_URL'),
                EnvLoader::get('SOCIAL_STEAM_URL'),
                EnvLoader::get('SOCIAL_PATREON_URL')
            ]
        ]
    ], JSON_PRETTY_PRINT) ?>
</script>

<!-- Embedded YouTube RSS Playlist Loader (No API Key Required) -->
<script nonce="<?= CSP_NONCE ?>">
(function() {
    'use strict';
    
    // Try alternative CORS proxy (more reliable than allorigins.win)
    const CORS_PROXY = 'https://corsproxy.io/?';
    
    /**
     * Fetch and parse YouTube playlist RSS feed
     */
    async function fetchPlaylistVideos(playlistId) {
        const rssUrl = `https://www.youtube.com/feeds/videos.xml?playlist_id=${playlistId}`;
        const proxyUrl = CORS_PROXY + encodeURIComponent(rssUrl);
        
        console.log(`🌐 Fetching RSS feed for playlist: ${playlistId}`);
        console.log(`📡 Proxy URL: ${proxyUrl}`);
        
        try {
            const response = await fetch(proxyUrl);
            console.log(`📥 Response status: ${response.status}`);
            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            
            const xmlText = await response.text();
            console.log(`📄 XML length: ${xmlText.length} characters`);
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(xmlText, 'text/xml');
            
            const parserError = xmlDoc.querySelector('parsererror');
            if (parserError) throw new Error('XML parsing error');
            
            const entries = xmlDoc.querySelectorAll('entry');
            console.log(`✅ Found ${entries.length} video entries`);
            const videos = [];
            
            entries.forEach(entry => {
                const videoId = entry.querySelector('videoId, yt\\:videoId')?.textContent;
                const title = entry.querySelector('title')?.textContent;
                
                if (videoId && title) {
                    videos.push({
                        id: videoId,
                        title: title,
                        thumbnail: `https://i.ytimg.com/vi/${videoId}/mqdefault.jpg`,
                        url: `https://www.youtube.com/watch?v=${videoId}`
                    });
                }
            });
            
            console.log(`🎥 Parsed ${videos.length} videos successfully`);
            return videos;
        } catch (error) {
            console.error('❌ Error fetching playlist:', error);
            return [];
        }
    }
    
    /**
     * Create video card HTML
     */
    function createVideoCard(video) {
        return `
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="${video.url}" target="_blank" rel="noopener noreferrer" class="playlist-card">
                    <div class="playlist-thumbnail">
                        <img src="${video.thumbnail}" alt="${escapeHtml(video.title)}" loading="lazy">
                        <div class="playlist-play-icon">
                            <svg width="48" height="48" viewBox="0 0 68 48" fill="none">
                                <path d="M66.52 7.74c-.78-2.93-2.49-5.41-5.42-6.19C55.79.13 34 0 34 0S12.21.13 6.9 1.55c-2.93.78-4.63 3.26-5.42 6.19C.06 13.05 0 24 0 24s.06 10.95 1.48 16.26c.78 2.93 2.49 5.41 5.42 6.19C12.21 47.87 34 48 34 48s21.79-.13 27.1-1.55c2.93-.78 4.64-3.26 5.42-6.19C67.94 34.95 68 24 68 24s-.06-10.95-1.48-16.26z" fill="red"/>
                                <path d="M45 24L27 14v20" fill="white"/>
                            </svg>
                        </div>
                    </div>
                    <div class="playlist-content">
                        <h3 class="playlist-title">${escapeHtml(video.title)}</h3>
                    </div>
                </a>
            </div>
        `;
    }
    
    /**
     * Load playlist into grid
     */
    async function loadPlaylistGrid(gridElement) {
        const playlistId = gridElement.dataset.playlistId;
        if (!playlistId) return;
        
        const videos = await fetchPlaylistVideos(playlistId);
        
        if (videos.length === 0) {
            gridElement.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-warning">
                        <h4>Unable to Load Videos</h4>
                        <p>Please try again later or visit our <a href="https://www.youtube.com/@martiangames" target="_blank">YouTube channel</a>.</p>
                    </div>
                </div>
            `;
            return;
        }
        
        gridElement.innerHTML = videos.map(v => createVideoCard(v)).join('');
    }
    
    /**
     * Escape HTML
     */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    /**
     * Initialize all playlist grids
     */
    function init() {
        console.log('🎬 Playlist loader initialized');
        const grids = document.querySelectorAll('.playlist-grid');
        console.log(`📺 Found ${grids.length} playlist grids`);
        grids.forEach((grid, index) => {
            const playlistId = grid.dataset.playlistId;
            console.log(`🔄 Loading playlist ${index + 1}: ${playlistId}`);
            loadPlaylistGrid(grid);
        });
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>

<?php
$showPolicyAgreement = true;
require_once __DIR__ . '/../includes/footer.php';
?>
