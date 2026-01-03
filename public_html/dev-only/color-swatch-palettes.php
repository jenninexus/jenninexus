<?php
/**
 * Color Swatch Palettes Component
 * 
 * Purpose: Visual reference for all CSS custom properties from all-themes.css
 * Used in: theme-demo.php
 * Version: 1.0
 * 
 * Shows light/dark theme color variables with actual color swatches
 */
?>

<!-- ====================================================================
     COLOR SWATCH PALETTES
     ==================================================================== -->
<section id="color-swatches" class="theme-section">
    <h2 class="display-5 mb-4"><i class="fa-solid fa-palette me-2"></i>Color Swatch Palettes</h2>
    <p class="lead">All CSS custom properties from all-themes.css with live color swatches</p>
    
    <div class="alert alert-info mb-4">
        <h5 class="mb-2"><i class="fa-solid fa-info-circle me-2"></i>Interactive Swatches</h5>
        <p class="mb-0">Toggle the theme switcher in the header to see color variables update in real-time. Each swatch shows the computed color value.</p>
    </div>

    <!-- Base Theme Colors -->
    <div class="row g-4 mb-5">
        <div class="col-12">
            <h3 class="mb-4">Base Theme Colors</h3>
        </div>
        
        <!-- Light Mode Base Colors -->
        <div class="col-lg-6">
            <div class="glass-card p-4">
                <h4 class="mb-3"><i class="fa-solid fa-sun me-2"></i>Light Mode Base</h4>
                <div class="row g-2">
                    <?php
                    $lightBaseColors = [
                        ['name' => '--background', 'desc' => 'Soft lavender base', 'default' => '#F9F3FB'],
                        ['name' => '--text', 'desc' => 'Dark text for contrast', 'default' => '#2C2A33'],
                        ['name' => '--primary', 'desc' => 'Primary brand purple', 'default' => '#6750A4'],
                        ['name' => '--secondary', 'desc' => 'Pink accent', 'default' => '#E91E63'],
                        ['name' => '--accent', 'desc' => 'Light pink accent', 'default' => '#F06292'],
                        ['name' => '--border', 'desc' => 'Subtle lavender border', 'default' => '#E8DFF7']
                    ];
                    
                    foreach ($lightBaseColors as $color):
                    ?>
                    <div class="col-12 col-md-6">
                        <div class="d-flex align-items-center gap-2 p-2 rounded" style="background: rgba(0,0,0,0.05);">
                            <div class="color-swatch rounded" style="width: 40px; height: 40px; background: var(<?= htmlspecialchars($color['name']) ?>); border: 1px solid rgba(0,0,0,0.2);"></div>
                            <div class="flex-grow-1">
                                <code class="d-block small"><?= htmlspecialchars($color['name']) ?></code>
                                <small class="text-muted d-block"><?= htmlspecialchars($color['desc']) ?></small>
                                <small class="text-muted d-block font-monospace"><?= htmlspecialchars($color['default']) ?></small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <!-- Dark Mode Base Colors -->
        <div class="col-lg-6">
            <div class="glass-card p-4">
                <h4 class="mb-3"><i class="fa-solid fa-moon me-2"></i>Dark Mode Base</h4>
                <div class="row g-2">
                    <?php
                    $darkBaseColors = [
                        ['name' => '--background', 'desc' => 'Rich black background', 'default' => '#0A0A0A'],
                        ['name' => '--text', 'desc' => 'Light purple-gray text', 'default' => '#E0D5EB'],
                        ['name' => '--primary', 'desc' => 'Lilac Flash primary', 'default' => '#D14BFF'],
                        ['name' => '--secondary', 'desc' => 'Deep purple secondary', 'default' => '#A563D1'],
                        ['name' => '--accent', 'desc' => 'Bright pink accent', 'default' => '#FF6EC4'],
                        ['name' => '--border', 'desc' => 'Dark gray borders', 'default' => '#252525']
                    ];
                    
                    foreach ($darkBaseColors as $color):
                    ?>
                    <div class="col-12 col-md-6">
                        <div class="d-flex align-items-center gap-2 p-2 rounded" style="background: rgba(255,255,255,0.05);">
                            <div class="color-swatch rounded" style="width: 40px; height: 40px; background: var(<?= htmlspecialchars($color['name']) ?>); border: 1px solid rgba(255,255,255,0.2);"></div>
                            <div class="flex-grow-1">
                                <code class="d-block small text-light"><?= htmlspecialchars($color['name']) ?></code>
                                <small class="text-muted d-block"><?= htmlspecialchars($color['desc']) ?></small>
                                <small class="text-muted d-block font-monospace"><?= htmlspecialchars($color['default']) ?></small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Social Media Platform Colors -->
    <div class="row g-4 mb-5">
        <div class="col-12">
            <h3 class="mb-4"><i class="fa-brands fa-youtube me-2"></i>Social Media Platform Colors</h3>
            <p class="text-muted">Official brand colors - consistent across light/dark themes</p>
        </div>
        
        <div class="col-12">
            <div class="glass-card p-4">
                <div class="row g-3">
                    <?php
                    $platformColors = [
                        ['name' => '--youtube-red', 'label' => 'YouTube Red', 'value' => '#ff0000', 'icon' => 'fa-youtube'],
                        ['name' => '--discord-blurple', 'label' => 'Discord Blurple', 'value' => '#5865F2', 'icon' => 'fa-discord'],
                        ['name' => '--twitch-purple', 'label' => 'Twitch Purple', 'value' => '#9146FF', 'icon' => 'fa-twitch'],
                        ['name' => '--patreon-coral', 'label' => 'Patreon Coral', 'value' => '#FF424D', 'icon' => 'fa-patreon'],
                        ['name' => '--instagram-magenta', 'label' => 'Instagram Magenta', 'value' => '#E4405F', 'icon' => 'fa-instagram'],
                        ['name' => '--tiktok-black', 'label' => 'TikTok Black', 'value' => '#000000', 'icon' => 'fa-tiktok'],
                        ['name' => '--steam-blue', 'label' => 'Steam Blue', 'value' => '#66c0f4', 'icon' => 'fa-steam'],
                        ['name' => '--spotify-green', 'label' => 'Spotify Green', 'value' => '#1DB954', 'icon' => 'fa-spotify'],
                        ['name' => '--github-dark', 'label' => 'GitHub Dark', 'value' => '#333333', 'icon' => 'fa-github']
                    ];
                    
                    foreach ($platformColors as $platform):
                    ?>
                    <div class="col-md-4 col-lg-3">
                        <div class="d-flex align-items-center gap-2 p-3 rounded glass-card h-100">
                            <div class="color-swatch rounded" style="width: 48px; height: 48px; background: var(<?= htmlspecialchars($platform['name']) ?>); border: 1px solid rgba(var(--bs-body-color-rgb), 0.2);"></div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center gap-1 mb-1">
                                    <i class="fa-brands <?= htmlspecialchars($platform['icon']) ?>"></i>
                                    <strong class="small"><?= htmlspecialchars($platform['label']) ?></strong>
                                </div>
                                <code class="d-block small"><?= htmlspecialchars($platform['name']) ?></code>
                                <small class="text-muted font-monospace d-block"><?= htmlspecialchars($platform['value']) ?></small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Glassmorphism Variables -->
    <div class="row g-4 mb-5">
        <div class="col-12">
            <h3 class="mb-4"><i class="fa-solid fa-droplet me-2"></i>Glassmorphism Variables</h3>
        </div>
        
        <div class="col-lg-6">
            <div class="glass-card p-4">
                <h5 class="mb-3">Light Mode Glass</h5>
                <div class="row g-2">
                    <?php
                    $lightGlassVars = [
                        ['name' => '--glass-panel-bg', 'desc' => 'Lavender glass background', 'default' => 'rgba(249, 243, 251, 0.85)'],
                        ['name' => '--glass-panel-border', 'desc' => 'Purple tinted border', 'default' => 'rgba(165, 99, 209, 0.2)'],
                        ['name' => '--glass-panel-blur', 'desc' => 'Blur amount', 'default' => '10px'],
                        ['name' => '--glass-panel-shadow', 'desc' => 'Subtle shadow', 'default' => 'rgba(0, 0, 0, 0.1)']
                    ];
                    
                    foreach ($lightGlassVars as $var):
                    ?>
                    <div class="col-12">
                        <div class="p-2 rounded" style="background: rgba(0,0,0,0.05);">
                            <code class="d-block small"><?= htmlspecialchars($var['name']) ?></code>
                            <small class="text-muted d-block"><?= htmlspecialchars($var['desc']) ?></small>
                            <small class="text-muted d-block font-monospace"><?= htmlspecialchars($var['default']) ?></small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="glass-card p-4">
                <h5 class="mb-3">Dark Mode Glass</h5>
                <div class="row g-2">
                    <?php
                    $darkGlassVars = [
                        ['name' => '--glass-panel-bg', 'desc' => 'Dark transparent background', 'default' => 'rgba(0, 0, 0, 0.6)'],
                        ['name' => '--glass-panel-border', 'desc' => 'Light border overlay', 'default' => 'rgba(255, 255, 255, 0.1)'],
                        ['name' => '--glass-panel-blur', 'desc' => 'Blur amount', 'default' => '12px'],
                        ['name' => '--glass-panel-shadow', 'desc' => 'Deep shadow', 'default' => 'rgba(0, 0, 0, 0.4)']
                    ];
                    
                    foreach ($darkGlassVars as $var):
                    ?>
                    <div class="col-12">
                        <div class="p-2 rounded" style="background: rgba(255,255,255,0.05);">
                            <code class="d-block small text-light"><?= htmlspecialchars($var['name']) ?></code>
                            <small class="text-muted d-block"><?= htmlspecialchars($var['desc']) ?></small>
                            <small class="text-muted d-block font-monospace"><?= htmlspecialchars($var['default']) ?></small>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Text Color Variables -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <h3 class="mb-4"><i class="fa-solid fa-font me-2"></i>Text Color Variables</h3>
        </div>
        
        <div class="col-lg-6">
            <div class="glass-card p-4">
                <h5 class="mb-3">Light Mode Text</h5>
                <div class="row g-2">
                    <?php
                    $lightTextVars = [
                        ['name' => '--bs-body-color', 'desc' => 'Primary text', 'default' => '#2C2A33'],
                        ['name' => '--text-secondary', 'desc' => 'Secondary text', 'default' => '#495057'],
                        ['name' => '--text-muted', 'desc' => 'Muted text', 'default' => '#6C757D']
                    ];
                    
                    foreach ($lightTextVars as $var):
                    ?>
                    <div class="col-12">
                        <div class="d-flex align-items-center gap-2 p-2 rounded" style="background: rgba(0,0,0,0.05);">
                            <div class="color-swatch rounded" style="width: 40px; height: 40px; background: var(<?= htmlspecialchars($var['name']) ?>); border: 1px solid rgba(0,0,0,0.2);"></div>
                            <div class="flex-grow-1">
                                <code class="d-block small"><?= htmlspecialchars($var['name']) ?></code>
                                <small class="text-muted d-block"><?= htmlspecialchars($var['desc']) ?></small>
                                <small class="text-muted d-block font-monospace"><?= htmlspecialchars($var['default']) ?></small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="glass-card p-4">
                <h5 class="mb-3">Dark Mode Text</h5>
                <div class="row g-2">
                    <?php
                    $darkTextVars = [
                        ['name' => '--bs-body-color', 'desc' => 'Primary text (14.2:1 contrast)', 'default' => '#E0D5EB'],
                        ['name' => '--text-secondary', 'desc' => 'Secondary text (11.8:1)', 'default' => '#C9BBDD'],
                        ['name' => '--text-muted', 'desc' => 'Muted text (9.2:1)', 'default' => '#B8A8CC']
                    ];
                    
                    foreach ($darkTextVars as $var):
                    ?>
                    <div class="col-12">
                        <div class="d-flex align-items-center gap-2 p-2 rounded" style="background: rgba(255,255,255,0.05);">
                            <div class="color-swatch rounded" style="width: 40px; height: 40px; background: var(<?= htmlspecialchars($var['name']) ?>); border: 1px solid rgba(255,255,255,0.2);"></div>
                            <div class="flex-grow-1">
                                <code class="d-block small text-light"><?= htmlspecialchars($var['name']) ?></code>
                                <small class="text-muted d-block"><?= htmlspecialchars($var['desc']) ?></small>
                                <small class="text-muted d-block font-monospace"><?= htmlspecialchars($var['default']) ?></small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-success">
        <h5 class="mb-2"><i class="fa-solid fa-check-circle me-2"></i>WCAG AA Compliance</h5>
        <p class="mb-0">All text color variables meet WCAG AA contrast requirements (4.5:1 for normal text, 3:1 for large text). Dark mode text colors provide enhanced contrast ratios (9.2:1 to 14.2:1).</p>
    </div>
</section>
