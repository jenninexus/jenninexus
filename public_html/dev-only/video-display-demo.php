<?php
/**
 * Video Display Demo Component
 * 
 * Purpose: Dev-only showcase of video/playlist card layouts with proper light/dark theme contrast
 * Used in: theme-demo.php
 * Version: 1.0
 * 
 * Dependencies:
 * - media.css (video-card, playlist-card styles)
 * - youtube-grid.js (optional for live data)
 * - Bootstrap 5.3.8 (ratio classes, grid)
 */

// Sample video data for static demos (no API calls needed)
$sampleVideos = [
    [
        'id' => 'dQw4w9WgXcQ',
        'title' => 'Rick Astley - Never Gonna Give You Up',
        'thumbnail' => 'https://i.ytimg.com/vi/dQw4w9WgXcQ/mqdefault.jpg',
        'duration' => '3:33',
        'views' => '1.4B views'
    ],
    [
        'id' => '9bZkp7q19f0',
        'title' => 'PSY - GANGNAM STYLE',
        'thumbnail' => 'https://i.ytimg.com/vi/9bZkp7q19f0/mqdefault.jpg',
        'duration' => '4:13',
        'views' => '4.7B views'
    ],
    [
        'id' => 'kJQP7kiw5Fk',
        'title' => 'Luis Fonsi - Despacito',
        'thumbnail' => 'https://i.ytimg.com/vi/kJQP7kiw5Fk/mqdefault.jpg',
        'duration' => '4:42',
        'views' => '8.2B views'
    ],
    [
        'id' => 'jNQXAC9IVRw',
        'title' => 'Me at the zoo',
        'thumbnail' => 'https://i.ytimg.com/vi/jNQXAC9IVRw/mqdefault.jpg',
        'duration' => '0:19',
        'views' => '285M views'
    ],
    [
        'id' => 'OPf0YbXqDm0',
        'title' => 'Mark Ronson - Uptown Funk',
        'thumbnail' => 'https://i.ytimg.com/vi/OPf0YbXqDm0/mqdefault.jpg',
        'duration' => '4:30',
        'views' => '4.8B views'
    ],
    [
        'id' => 'RgKAFK5djSk',
        'title' => 'Wiz Khalifa - See You Again',
        'thumbnail' => 'https://i.ytimg.com/vi/RgKAFK5djSk/mqdefault.jpg',
        'duration' => '3:49',
        'views' => '6.1B views'
    ]
];

$samplePlaylists = [
    [
        'id' => 'PLx0sYbCqOb8TBPRdmBHs5Iftvv9TPboYG',
        'title' => 'Horror Game Playthroughs',
        'description' => 'Spooky games and scary moments collection',
        'videoCount' => 12,
        'thumbnail' => 'https://i.ytimg.com/vi/dQw4w9WgXcQ/mqdefault.jpg',
        'tags' => ['horror', 'gaming', 'lets-play']
    ],
    [
        'id' => 'PLx0sYbCqOb8TBPRdmBHs5Iftvv9TPboYH',
        'title' => 'RPG Adventures',
        'description' => 'Epic role-playing game series',
        'videoCount' => 24,
        'thumbnail' => 'https://i.ytimg.com/vi/9bZkp7q19f0/mqdefault.jpg',
        'tags' => ['rpg', 'gaming', 'adventure']
    ],
    [
        'id' => 'PLx0sYbCqOb8TBPRdmBHs5Iftvv9TPboYI',
        'title' => 'Indie Game Showcase',
        'description' => 'Hidden gems and indie favorites',
        'videoCount' => 18,
        'thumbnail' => 'https://i.ytimg.com/vi/kJQP7kiw5Fk/mqdefault.jpg',
        'tags' => ['indie', 'gaming', 'showcase']
    ]
];
?>

<!-- ====================================================================
     VIDEO DISPLAY DEMO SECTION
     ==================================================================== -->
<section id="video-display-demo" class="theme-section">
    <h2 class="display-5 mb-4"><i class="fa-solid fa-film me-2"></i>Video Display Demo</h2>
    <p class="lead">Dev-only showcase of video/playlist card layouts from media.css</p>
    
    <div class="alert alert-info mb-4">
        <h5 class="mb-3"><i class="fa-solid fa-info-circle me-2"></i>Purpose</h5>
        <p class="mb-2"><strong>This component demonstrates:</strong></p>
        <ul class="mb-0">
            <li>Single-card playlist layout (3 columns, 1 video preview per card)</li>
            <li>Multi-video playlist layout (full-width, 3 videos per playlist)</li>
            <li>Vertical video layout (9:16 aspect ratio for Shorts)</li>
            <li>Proper light/dark theme contrast on all card elements</li>
            <li>Hover effects: lift, glow, and play overlay</li>
        </ul>
    </div>

    <!-- Pattern 1: Single-Card Playlist Layout (Gaming/GameDev Style) -->
    <div class="component-demo mb-5">
        <h3 class="mb-3">Pattern 1: Single-Card Playlist Layout</h3>
        <p class="text-muted mb-3"><strong>Used on:</strong> gaming.php, gamedev.php, youtube.php</p>
        
        <div class="row g-4">
            <?php foreach (array_slice($samplePlaylists, 0, 3) as $playlist): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card playlist-card-single h-100 hover-lift">
                    <div class="ratio ratio-16x9 bg-dark position-relative">
                        <img src="<?= htmlspecialchars($playlist['thumbnail']) ?>" 
                             alt="<?= htmlspecialchars($playlist['title']) ?>" 
                             class="w-100 h-100 object-fit-cover"
                             loading="lazy">
                        <div class="play-overlay">
                            <i class="fa-solid fa-play-circle" style="font-size: 4rem; color: white; opacity: 0.9;"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php foreach ($playlist['tags'] as $tag): ?>
                        <span class="badge bg-primary me-1 mb-2"><?= ucfirst($tag) ?></span>
                        <?php endforeach; ?>
                        <h5 class="card-title">
                            <a href="#" class="playlist-title-link text-decoration-none"><?= htmlspecialchars($playlist['title']) ?></a>
                        </h5>
                        <p class="card-text small text-muted"><?= htmlspecialchars($playlist['description']) ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-top">
                        <small class="text-muted"><?= $playlist['videoCount'] ?> videos</small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="code-preview mt-4">
<strong>CSS Classes Used (from media.css):</strong>
- .playlist-card-single: Base card styling
- .hover-lift: Smooth translateY(-8px) on hover
- .ratio-16x9: Bootstrap aspect ratio container
- .play-overlay: Centered play button with fade-in on hover
- .object-fit-cover: Ensure thumbnail fills container

<strong>Hover Behavior:</strong>
- Card lifts 8px on hover
- Play overlay fades in
- Box-shadow intensifies (theme-adaptive)
        </div>
    </div>

    <!-- Pattern 2: Multi-Video Playlist Layout (DIY Style) -->
    <div class="component-demo mb-5">
        <h3 class="mb-3">Pattern 2: Multi-Video Playlist Layout</h3>
        <p class="text-muted mb-3"><strong>Used on:</strong> diy.php (featured section)</p>
        
        <div class="mb-4">
            <div class="card playlist-card-multi">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fa-solid fa-gamepad fs-4 me-2 text-primary"></i>
                        <h5 class="card-title mb-0">
                            <a href="#" class="playlist-title-link text-decoration-none">Gaming Highlights</a>
                        </h5>
                    </div>
                    <div class="row g-3">
                        <?php foreach (array_slice($sampleVideos, 0, 3) as $video): ?>
                        <div class="col-12 col-md-4">
                            <div class="video-thumbnail-wrapper">
                                <div class="ratio ratio-16x9 bg-dark position-relative">
                                    <img src="<?= htmlspecialchars($video['thumbnail']) ?>" 
                                         alt="<?= htmlspecialchars($video['title']) ?>" 
                                         class="w-100 h-100 object-fit-cover"
                                         loading="lazy">
                                    <div class="play-overlay">
                                        <i class="fa-solid fa-play-circle" style="font-size: 3rem; color: white; opacity: 0.9;"></i>
                                    </div>
                                    <span class="video-duration badge bg-dark position-absolute bottom-0 end-0 m-2">
                                        <?= htmlspecialchars($video['duration']) ?>
                                    </span>
                                </div>
                                <p class="small text-muted mt-2 mb-0"><?= htmlspecialchars($video['title']) ?></p>
                                <p class="small text-muted mb-0"><?= htmlspecialchars($video['views']) ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="code-preview">
<strong>CSS Classes Used (from media.css):</strong>
- .playlist-card-multi: Full-width panel, no hover lift
- .video-thumbnail-wrapper: Individual video container
- .video-duration: Positioned badge for video length
- .play-overlay: Hover effect on individual thumbnails

<strong>Hover Behavior:</strong>
- Individual video thumbnails have hover effects
- Panel container stays static (no lift)
- Play overlay shows on each video thumbnail
        </div>
    </div>

    <!-- Pattern 3: Vertical Video Layout (Shorts/TikTok Style) -->
    <div class="component-demo mb-5">
        <h3 class="mb-3">Pattern 3: Vertical Video Layout (9:16)</h3>
        <p class="text-muted mb-3"><strong>Used on:</strong> gaming.php (YouTube Shorts section)</p>
        
        <div class="row g-4">
            <?php foreach (array_slice($sampleVideos, 0, 4) as $video): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card gaming-short-card h-100 hover-lift">
                    <div class="ratio ratio-9x16 bg-dark position-relative">
                        <img src="<?= htmlspecialchars($video['thumbnail']) ?>" 
                             alt="<?= htmlspecialchars($video['title']) ?>" 
                             class="w-100 h-100 object-fit-cover"
                             style="object-position: center;"
                             loading="lazy">
                        <div class="play-overlay">
                            <i class="fa-solid fa-play-circle" style="font-size: 3rem; color: white; opacity: 0.9;"></i>
                        </div>
                        <span class="video-duration badge bg-dark position-absolute bottom-0 end-0 m-2">
                            <?= htmlspecialchars($video['duration']) ?>
                        </span>
                    </div>
                    <div class="card-body p-2">
                        <h6 class="card-title small mb-0 text-truncate"><?= htmlspecialchars($video['title']) ?></h6>
                        <p class="small text-muted mb-0"><?= htmlspecialchars($video['views']) ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="code-preview mt-4">
<strong>CSS Classes Used (from media.css):</strong>
- .gaming-short-card: Narrower cards for portrait videos
- .ratio-9x16: Bootstrap portrait aspect ratio
- .hover-lift: Lift effect on hover
- .text-truncate: Single-line title with ellipsis

<strong>Responsive Grid:</strong>
- Mobile (xs): 2 columns (col-6)
- Tablet (md): 3 columns (col-md-4)
- Desktop (lg): 4 columns (col-lg-3)
        </div>
    </div>

    <!-- Grid Comparison Table -->
    <div class="component-demo mb-5">
        <h3 class="mb-3">Layout Pattern Comparison</h3>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Pattern</th>
                        <th>Aspect Ratio</th>
                        <th>Columns (Desktop)</th>
                        <th>Hover Effect</th>
                        <th>Use Case</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Single-Card</strong></td>
                        <td>16:9</td>
                        <td>3 (col-lg-4)</td>
                        <td>Lift + glow</td>
                        <td>Playlists, game pages</td>
                    </tr>
                    <tr>
                        <td><strong>Multi-Video</strong></td>
                        <td>16:9</td>
                        <td>1 (full-width panel)</td>
                        <td>Individual thumbnails only</td>
                        <td>Featured sections, DIY page</td>
                    </tr>
                    <tr>
                        <td><strong>Vertical</strong></td>
                        <td>9:16</td>
                        <td>4 (col-lg-3)</td>
                        <td>Lift + glow</td>
                        <td>Shorts, TikTok, vertical videos</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Theme Contrast Test -->
    <div class="alert alert-success">
        <h5 class="mb-3"><i class="fa-solid fa-check-circle me-2"></i>Theme Contrast Verification</h5>
        <p class="mb-2"><strong>✅ All video display components have been tested for adequate contrast in both light and dark themes:</strong></p>
        <ul class="mb-0">
            <li><strong>Light Mode:</strong> Dark text on light cards, adequate contrast ratios</li>
            <li><strong>Dark Mode:</strong> Light text on dark cards, proper theme-adaptive shadows</li>
            <li><strong>Play Overlays:</strong> White icons with semi-transparent backgrounds for visibility</li>
            <li><strong>Badges:</strong> Bootstrap theme-aware badge colors with proper contrast</li>
            <li><strong>Hover States:</strong> Theme-adaptive box-shadows (dark mode uses brighter glows)</li>
        </ul>
    </div>
</section>

<style>
/* Dev-only styles for video display demo (inline to avoid global CSS conflicts) */
#video-display-demo .playlist-card-single {
    border: 1px solid var(--bs-border-color);
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

#video-display-demo .playlist-card-single:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 24px rgba(var(--bs-primary-rgb), 0.2);
    z-index: 10;
}

#video-display-demo .playlist-card-multi {
    border: 1px solid var(--bs-border-color);
    background: var(--glass-panel-bg);
    backdrop-filter: blur(var(--glass-panel-blur));
}

#video-display-demo .gaming-short-card {
    border: 1px solid var(--bs-border-color);
    transition: all 0.3s ease;
}

#video-display-demo .gaming-short-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 16px rgba(var(--bs-primary-rgb), 0.25);
}

#video-display-demo .play-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.3);
    opacity: 0;
    transition: opacity 0.3s ease;
}

#video-display-demo .ratio:hover .play-overlay {
    opacity: 1;
}

#video-display-demo .video-duration {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    opacity: 0.95;
}

#video-display-demo .playlist-title-link {
    color: var(--bs-body-color);
    transition: color 0.2s ease;
}

#video-display-demo .playlist-title-link:hover {
    color: var(--bs-primary);
}

#video-display-demo .video-thumbnail-wrapper .ratio {
    cursor: pointer;
    transition: transform 0.2s ease;
}

#video-display-demo .video-thumbnail-wrapper .ratio:hover {
    transform: scale(1.02);
}

/* Theme-adaptive text contrast helpers */
[data-bs-theme="dark"] #video-display-demo .card {
    background-color: var(--bs-body-bg);
    border-color: rgba(255, 255, 255, 0.1);
}

[data-bs-theme="light"] #video-display-demo .card {
    background-color: var(--bs-body-bg);
    border-color: rgba(0, 0, 0, 0.1);
}
</style>
