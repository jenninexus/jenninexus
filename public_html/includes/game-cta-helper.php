<?php
/**
 * Game CTA Helper
 * 
 * Generates call-to-action buttons for game pages based on playlist-ids.json data
 * Usage: include this file and call renderGameCTA($gameSlug)
 * 
 * @version 1.1
 * @date 2025-11-09
 * @changelog v1.1 - Added RES_ROOT constant definition for game/*.php pages
 */

// Define RES_ROOT if not already defined (for game/*.php subdirectory pages)
if (!defined('RES_ROOT')) {
    // Detect environment: localhost = dev, jenninexus.com = prod
    $isDev = (isset($_SERVER['HTTP_HOST']) && 
              (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || 
               strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false));
    define('RES_ROOT', '/resources');
}

/**
 * Get game playlist data from playlist-ids.json
 * 
 * @param string $gameSlug The game slug (e.g., 'purgatoryfell', 'martiangames')
 * @return array|null Game data or null if not found
 */
function getGamePlaylistData($gameSlug) {
    $playlistIdsPath = __DIR__ . '/../resources/playlists/playlist-ids.json';
    
    if (!file_exists($playlistIdsPath)) {
        return null;
    }
    
    $data = json_decode(file_get_contents($playlistIdsPath), true);
    
    if (!isset($data['youtube']['playlists']['games']['game_playlists'])) {
        return null;
    }
    
    $gamePlaylists = $data['youtube']['playlists']['games']['game_playlists'];
    
    foreach ($gamePlaylists as $game) {
        if (isset($game['game_slug']) && $game['game_slug'] === $gameSlug) {
            return $game;
        }
    }
    
    return null;
}

/**
 * Render CTA buttons for a game page
 * 
 * @param string $gameSlug The game slug
 * @param array $options Optional configuration
 *   - 'show_steam': bool - Show Steam button (default: false)
 *   - 'steam_url': string - Steam store URL
 *   - 'show_back': bool - Show back button (default: true)
 *   - 'back_url': string - URL for back button (default: '/gamedev')
 *   - 'back_text': string - Text for back button (default: 'Back to Game Dev')
 *   - 'button_size': string - Bootstrap button size class (default: 'btn-lg')
 */
function renderGameCTA($gameSlug, $options = []) {
    // Default options
    $defaults = [
        'show_steam' => false,
        'steam_url' => '',
        'show_back' => true,
        'back_url' => '/gamedev',
        'back_text' => 'Back to Game Dev',
        'button_size' => 'btn-lg',
        'external_url' => '',
        'external_text' => 'Play Game'
    ];
    
    $options = array_merge($defaults, $options);
    
    // Get game data from playlist-ids.json
    $gameData = getGamePlaylistData($gameSlug);
    
    if (!$gameData) {
        // No data found, show basic back button only
        if ($options['show_back']) {
            echo '<div class="d-flex gap-3 mb-4 flex-wrap">';
            echo '<a href="' . htmlspecialchars($options['back_url']) . '" class="btn ' . $options['button_size'] . ' btn-outline-light">';
            echo '<i class="fa-solid fa-arrow-left me-2"></i>' . htmlspecialchars($options['back_text']);
            echo '</a>';
            echo '</div>';
        }
        return;
    }
    
    // Start button group
    echo '<div class="d-flex gap-3 mb-4 flex-wrap">';
    
    // Steam button (if enabled)
    if ($options['show_steam'] && !empty($options['steam_url'])) {
        echo '<a href="' . htmlspecialchars($options['steam_url']) . '" ';
        echo 'class="btn ' . $options['button_size'] . '" ';
        echo 'target="_blank" rel="noopener" ';
        echo 'style="background: linear-gradient(135deg, #171a21, #1b2838); border: 2px solid #66c0f4; color: #c7d5e0;">';
        echo '<i class="fa-brands fa-steam me-2"></i>Get on Steam';
        echo '</a>';
    }
    
    // External game URL (Game Jolt, itch.io, etc.)
    if (!empty($gameData['external_url']) || !empty($options['external_url'])) {
        $extUrl = !empty($options['external_url']) ? $options['external_url'] : $gameData['external_url'];
        echo '<a href="' . htmlspecialchars($extUrl) . '" ';
        echo 'class="btn ' . $options['button_size'] . ' btn-primary" ';
        echo 'target="_blank" rel="noopener">';
        echo '<i class="fa-solid fa-circle-play me-2"></i>' . htmlspecialchars($options['external_text']);
        echo '</a>';
    }
    
    // YouTube playlist or video button
    if (!empty($gameData['id'])) {
        // Full playlist
        $playlistUrl = 'https://youtube.com/playlist?list=' . $gameData['id'];
        $buttonText = 'Watch ' . ucfirst($gameData['type'] ?? 'Videos');
        
        echo '<a href="' . htmlspecialchars($playlistUrl) . '" ';
        echo 'class="btn ' . $options['button_size'] . ' btn-danger" ';
        echo 'target="_blank" rel="noopener">';
        echo '<i class="fa-brands fa-youtube me-2"></i>' . htmlspecialchars($buttonText);
        echo '</a>';
    } elseif (!empty($gameData['video_id'])) {
        // Single video
        $videoUrl = 'https://youtube.com/watch?v=' . $gameData['video_id'];
        $buttonText = 'Watch Gameplay';
        
        echo '<a href="' . htmlspecialchars($videoUrl) . '" ';
        echo 'class="btn ' . $options['button_size'] . ' btn-danger" ';
        echo 'target="_blank" rel="noopener">';
        echo '<i class="fa-brands fa-youtube me-2"></i>' . htmlspecialchars($buttonText);
        echo '</a>';
    }
    
    // Back button
    if ($options['show_back']) {
        echo '<a href="' . htmlspecialchars($options['back_url']) . '" class="btn ' . $options['button_size'] . ' btn-outline-light">';
        echo '<i class="fa-solid fa-arrow-left me-2"></i>' . htmlspecialchars($options['back_text']);
        echo '</a>';
    }
    
    echo '</div>';
}

/**
 * Get tags for a game
 * 
 * @param string $gameSlug The game slug
 * @return array Array of tag slugs
 */
function getGameTags($gameSlug) {
    $gameData = getGamePlaylistData($gameSlug);
    return isset($gameData['tags']) ? $gameData['tags'] : [];
}

/**
 * Render tag badges for a game
 * 
 * @param string $gameSlug The game slug
 */
function renderGameTags($gameSlug) {
    $tags = getGameTags($gameSlug);
    
    if (empty($tags)) {
        return;
    }
    
    echo '<div class="d-flex gap-2 mb-4 flex-wrap">';
    foreach ($tags as $tag) {
        // Convert slug to display name
        $displayName = ucwords(str_replace('-', ' ', $tag));
        echo '<span class="badge bg-primary">' . htmlspecialchars($displayName) . '</span>';
    }
    echo '</div>';
}
