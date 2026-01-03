/**
 * YouTube Playlist Loader (RSS-Based, No API Key Required)
 * Loads YouTube playlist videos via RSS feeds through CORS proxy
 * Adapted from standalone demo page
 */

(function () {
    'use strict';

    // CORS proxy options (try multiple if one fails)
    const CORS_PROXIES = [
        'https://api.allorigins.win/raw?url=',
        'https://corsproxy.io/?',
        'https://api.codetabs.com/v1/proxy?quest='
    ];
    let currentProxyIndex = 0;

    /**
     * Fetch and parse YouTube playlist RSS feed
     * @param {string} playlistId - YouTube playlist ID
     * @returns {Promise<Array>} Array of video objects
     */
    async function fetchPlaylist(playlistId, retryCount = 0) {
        const rssUrl = `https://www.youtube.com/feeds/videos.xml?playlist_id=${playlistId}`;
        const corsProxy = CORS_PROXIES[currentProxyIndex];
        const proxyUrl = corsProxy + encodeURIComponent(rssUrl);

        console.log(`📡 Fetching playlist ${playlistId} via proxy ${currentProxyIndex + 1}/${CORS_PROXIES.length}`);

        try {
            const response = await fetch(proxyUrl, {
                method: 'GET',
                headers: {
                    'Accept': 'application/xml, text/xml, */*'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const xmlText = await response.text();
            console.log(`✅ Received ${xmlText.length} bytes of XML data`);

            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(xmlText, 'text/xml');

            // Check for XML parsing errors
            const parserError = xmlDoc.querySelector('parsererror');
            if (parserError) {
                console.error('❌ XML parsing error:', parserError.textContent);
                throw new Error('XML parsing error');
            }

            // Extract video entries from RSS feed (Atom format with yt: namespace)
            const entries = xmlDoc.querySelectorAll('entry');
            console.log(`📊 Found ${entries.length} video entries in feed`);

            const videos = [];

            entries.forEach(entry => {
                // YouTube RSS uses yt:videoId namespace
                const videoId = entry.querySelector('videoId, yt\\:videoId')?.textContent;
                const title = entry.querySelector('title')?.textContent;
                const published = entry.querySelector('published')?.textContent;

                // Try multiple selectors for thumbnail
                let thumbnail = entry.querySelector('media\\:thumbnail, thumbnail')?.getAttribute('url');

                if (videoId && title) {
                    videos.push({
                        id: videoId,
                        title: title,
                        published: published ? new Date(published) : null,
                        thumbnail: thumbnail || `https://i.ytimg.com/vi/${videoId}/mqdefault.jpg`,
                        url: `https://www.youtube.com/watch?v=${videoId}`
                    });
                }
            });

            if (videos.length > 0) {
                console.log(`✅ Successfully parsed ${videos.length} videos`);
                return videos;
            } else {
                throw new Error('No videos found in feed');
            }

        } catch (error) {
            console.error(`❌ Error with proxy ${currentProxyIndex + 1}:`, error.message);

            // Try next proxy if available
            if (currentProxyIndex < CORS_PROXIES.length - 1 && retryCount < CORS_PROXIES.length) {
                currentProxyIndex++;
                console.log(`🔄 Retrying with next proxy (${currentProxyIndex + 1}/${CORS_PROXIES.length})...`);
                return fetchPlaylist(playlistId, retryCount + 1);
            }

            console.error('❌ All proxies failed');
            return [];
        }
    }

    /**
     * Create video card HTML
     * @param {Object} video - Video object with id, title, thumbnail, url
     * @returns {string} HTML string for video card
     */
    function createVideoCard(video) {
        // Use high-res thumbnail if available, fallback to mqdefault (16:9)
        // We prefer mqdefault over hqdefault (4:3) to avoid cropping if maxres is missing
        // But mqdefault is low res. Let's try to use the feed thumbnail which is usually hqdefault.
        // To ensure "fill the card view", we rely on CSS object-fit: cover.

        return `
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <a href="${video.url}" target="_blank" rel="noopener noreferrer" class="playlist-card h-100" data-video-id="${video.id}">
                    <div class="playlist-thumbnail">
                        <img src="${video.thumbnail}" alt="${video.title}" loading="lazy">
                        <div class="playlist-play-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor" class="text-white">
                                <path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="playlist-content">
                        <h3 class="h6 mb-0 text-truncate-2 video-title">${video.title}</h3>
                    </div>
                </a>
            </div>
        `;
    }

    /**
     * Load playlist into grid container
     * @param {HTMLElement} gridElement - Container element with data-playlist-id attribute
     */
    async function loadPlaylistGrid(gridElement) {
        const playlistId = gridElement.dataset.playlistId;
        if (!playlistId) {
            console.error('No playlist ID specified');
            return;
        }

        // Fetch videos
        const videos = await fetchPlaylist(playlistId);

        if (videos.length === 0) {
            const youtubeUrl = EnvLoader?.get ? EnvLoader.get('SOCIAL_YOUTUBE_URL', 'https://youtube.com/MartianGames') : 'https://youtube.com/MartianGames';
            const playlistUrl = `https://www.youtube.com/playlist?list=${playlistId}`;
            
            gridElement.innerHTML = `
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">Unable to Load Videos</h4>
                        <p>We couldn't load the playlist at this time. Please try again later or visit our <a href="${playlistUrl}" target="_blank" rel="noopener noreferrer">YouTube playlist</a> directly.</p>
                    </div>
                </div>
            `;
            return;
        }

        // Check for limit attribute (e.g., data-limit="4")
        const limit = gridElement.dataset.limit ? parseInt(gridElement.dataset.limit, 10) : null;
        const displayVideos = limit ? videos.slice(0, limit) : videos;

        console.log(`📊 Displaying ${displayVideos.length} of ${videos.length} videos${limit ? ` (limited to ${limit})` : ''}`);

        // Create video cards HTML
        const cardsHtml = displayVideos.map(video => createVideoCard(video)).join('');

        // Update grid with video cards
        gridElement.innerHTML = cardsHtml;
    }

    /**
     * Initialize all playlist grids on page load
     */
    function initializePlaylistGrids() {
        const grids = document.querySelectorAll('.playlist-grid');
        grids.forEach(grid => loadPlaylistGrid(grid));
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializePlaylistGrids);
    } else {
        initializePlaylistGrids();
    }
})();
