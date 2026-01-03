<?php
/**
 * Theme System Showcase - Development Only
 * 
 * Purpose: Comprehensive demonstration of light/dark theme system, color palettes, and theme-aware components
 * 
 * @see all-themes.css - Theme variable definitions
 * @see theme-toggle.js - Theme switching logic
 * @see THEME-SYSTEM.md - Complete theme documentation
 * 
 * Last Updated: January 2, 2026
 */
?>

<!-- Theme System Section -->
<section id="theme-system" class="theme-section bg-pastel">
    <div class="container">
        <h2 class="mb-4 text-theme-safe">
            <i class="fa-solid fa-swatchbook me-2"></i>Theme System
        </h2>
        
        <!-- Live Theme Toggle Demo -->
        <div class="glass-card p-4 mb-5">
            <h3 class="h4 mb-4 text-theme-safe">
                <i class="fa-solid fa-toggle-on me-2"></i>Live Theme Toggle
            </h3>
            
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="text-center p-5 bg-theme-adaptive rounded">
                        <div class="mb-4">
                            <span class="badge bg-primary fs-5 px-4 py-2" id="current-theme-display">
                                Current Theme: <span id="theme-name">Dark</span>
                            </span>
                        </div>
                        
                        <button id="demo-theme-toggle" class="btn btn-primary btn-lg" onclick="toggleDemoTheme()">
                            <i class="fa-solid fa-sun me-2" id="demo-toggle-icon"></i>
                            <span id="demo-toggle-text">Switch to Light Mode</span>
                        </button>
                        
                        <p class="small text-theme-safe-muted mt-3 mb-0">
                            Theme persists via localStorage<br>
                            Attribute: <code>data-bs-theme="<span id="theme-attr">dark</span>"</code>
                        </p>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <h5 class="text-theme-safe mb-3">How It Works</h5>
                    <div class="glass-card p-3 mb-2">
                        <p class="small text-theme-safe mb-1"><strong>1. Toggle Button:</strong> Changes <code>data-bs-theme</code> attribute on <code>&lt;html&gt;</code></p>
                    </div>
                    <div class="glass-card p-3 mb-2">
                        <p class="small text-theme-safe mb-1"><strong>2. CSS Variables:</strong> All colors defined in <code>all-themes.css</code> update automatically</p>
                    </div>
                    <div class="glass-card p-3 mb-2">
                        <p class="small text-theme-safe mb-1"><strong>3. localStorage:</strong> Theme preference saved to <code>localStorage.getItem('theme')</code></p>
                    </div>
                    <div class="glass-card p-3">
                        <p class="small text-theme-safe mb-0"><strong>4. Components:</strong> All theme-aware components update via CSS custom properties</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- JenniNexus Brand Colors -->
        <div class="glass-card p-4 mb-5">
            <h3 class="h4 mb-4 text-theme-safe">
                <i class="fa-solid fa-palette me-2"></i>JenniNexus Brand Palette
            </h3>
            
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="text-center p-4 rounded" style="background: var(--jenni-primary); color: white;">
                        <i class="fa-solid fa-heart svg-3x mb-3"></i>
                        <h5 class="mb-2">Primary</h5>
                        <code class="d-block mb-1">--jenni-primary</code>
                        <small class="d-block">Light: #A563D1 (Purple)</small>
                        <small class="d-block">Dark: #FF2E88 (Pink)</small>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="text-center p-4 rounded" style="background: var(--jenni-secondary); color: white;">
                        <i class="fa-solid fa-star svg-3x mb-3"></i>
                        <h5 class="mb-2">Secondary</h5>
                        <code class="d-block mb-1">--jenni-secondary</code>
                        <small class="d-block">Light: #FF2E88 (Pink)</small>
                        <small class="d-block">Dark: #A563D1 (Purple)</small>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="text-center p-4 rounded" style="background: var(--jenni-accent); color: white;">
                        <i class="fa-solid fa-wand-magic-sparkles svg-3x mb-3"></i>
                        <h5 class="mb-2">Accent</h5>
                        <code class="d-block mb-1">--jenni-accent</code>
                        <small class="d-block">Both: #FF6EC4 (Light Pink)</small>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="text-center p-3 rounded" style="background: var(--jenni-success); color: white;">
                        <i class="fa-solid fa-check-circle svg-2x mb-2"></i>
                        <p class="small mb-1"><strong>Success</strong></p>
                        <code class="small">--jenni-success</code>
                        <small class="d-block">#00D4AA</small>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="text-center p-3 rounded" style="background: var(--jenni-warning); color: white;">
                        <i class="fa-solid fa-exclamation-triangle svg-2x mb-2"></i>
                        <p class="small mb-1"><strong>Warning</strong></p>
                        <code class="small">--jenni-warning</code>
                        <small class="d-block">#FFB020</small>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="text-center p-3 rounded" style="background: var(--jenni-error); color: white;">
                        <i class="fa-solid fa-times-circle svg-2x mb-2"></i>
                        <p class="small mb-1"><strong>Error</strong></p>
                        <code class="small">--jenni-error</code>
                        <small class="d-block">#FF4757</small>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="text-center p-3 rounded" style="background: var(--jenni-info); color: white;">
                        <i class="fa-solid fa-info-circle svg-2x mb-2"></i>
                        <p class="small mb-1"><strong>Info</strong></p>
                        <code class="small">--jenni-info</code>
                        <small class="d-block">#5352ED</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Social Media Platform Colors -->
        <div class="glass-card p-4 mb-5">
            <h3 class="h4 mb-4 text-theme-safe">
                <i class="fa-brands fa-youtube me-2"></i>Social Media Platform Colors
            </h3>
            
            <div class="row g-3">
                <!-- YouTube -->
                <div class="col-md-3 col-sm-6">
                    <div class="text-center p-3 rounded" style="background: var(--youtube-red); color: white;">
                        <i class="fa-brands fa-youtube svg-3x mb-2"></i>
                        <h6 class="mb-1">YouTube</h6>
                        <code class="small d-block">--youtube-red</code>
                        <small class="d-block">#ff0000</small>
                    </div>
                    <div class="mt-2 p-2 rounded text-center" style="background: rgba(255, 0, 0, 0.1); border: 1px solid rgba(255, 0, 0, 0.3);">
                        <small class="text-theme-safe">Hover: rgba(255, 0, 0, 0.2)</small>
                    </div>
                </div>
                
                <!-- Discord -->
                <div class="col-md-3 col-sm-6">
                    <div class="text-center p-3 rounded" style="background: var(--discord-blurple); color: white;">
                        <i class="fa-brands fa-discord svg-3x mb-2"></i>
                        <h6 class="mb-1">Discord</h6>
                        <code class="small d-block">--discord-blurple</code>
                        <small class="d-block">#5865F2</small>
                    </div>
                    <div class="mt-2 p-2 rounded text-center" style="background: rgba(88, 101, 242, 0.1); border: 1px solid rgba(88, 101, 242, 0.3);">
                        <small class="text-theme-safe">Hover: rgba(88, 101, 242, 0.2)</small>
                    </div>
                </div>
                
                <!-- Twitch -->
                <div class="col-md-3 col-sm-6">
                    <div class="text-center p-3 rounded" style="background: var(--twitch-purple); color: white;">
                        <i class="fa-brands fa-twitch svg-3x mb-2"></i>
                        <h6 class="mb-1">Twitch</h6>
                        <code class="small d-block">--twitch-purple</code>
                        <small class="d-block">#9146FF</small>
                    </div>
                    <div class="mt-2 p-2 rounded text-center" style="background: rgba(145, 70, 255, 0.1); border: 1px solid rgba(145, 70, 255, 0.3);">
                        <small class="text-theme-safe">Hover: rgba(145, 70, 255, 0.2)</small>
                    </div>
                </div>
                
                <!-- Patreon -->
                <div class="col-md-3 col-sm-6">
                    <div class="text-center p-3 rounded" style="background: var(--patreon-coral); color: white;">
                        <i class="fa-brands fa-patreon svg-3x mb-2"></i>
                        <h6 class="mb-1">Patreon</h6>
                        <code class="small d-block">--patreon-coral</code>
                        <small class="d-block">#FF424D</small>
                    </div>
                    <div class="mt-2 p-2 rounded text-center" style="background: rgba(255, 66, 77, 0.1); border: 1px solid rgba(255, 66, 77, 0.3);">
                        <small class="text-theme-safe">Hover: rgba(255, 66, 77, 0.2)</small>
                    </div>
                </div>
                
                <!-- Steam -->
                <div class="col-md-3 col-sm-6">
                    <div class="text-center p-3 rounded" style="background: var(--steam-blue); color: white;">
                        <i class="fa-brands fa-steam svg-3x mb-2"></i>
                        <h6 class="mb-1">Steam</h6>
                        <code class="small d-block">--steam-blue</code>
                        <small class="d-block">#66c0f4</small>
                    </div>
                    <div class="mt-2 p-2 rounded text-center" style="background: rgba(102, 192, 244, 0.1); border: 1px solid rgba(102, 192, 244, 0.3);">
                        <small class="text-theme-safe">Hover: rgba(102, 192, 244, 0.2)</small>
                    </div>
                </div>
                
                <!-- Spotify -->
                <div class="col-md-3 col-sm-6">
                    <div class="text-center p-3 rounded" style="background: var(--spotify-green); color: white;">
                        <i class="fa-brands fa-spotify svg-3x mb-2"></i>
                        <h6 class="mb-1">Spotify</h6>
                        <code class="small d-block">--spotify-green</code>
                        <small class="d-block">#1DB954</small>
                    </div>
                    <div class="mt-2 p-2 rounded text-center" style="background: rgba(29, 185, 84, 0.1); border: 1px solid rgba(29, 185, 84, 0.3);">
                        <small class="text-theme-safe">Hover: rgba(29, 185, 84, 0.2)</small>
                    </div>
                </div>
                
                <!-- Instagram -->
                <div class="col-md-3 col-sm-6">
                    <div class="text-center p-3 rounded" style="background: var(--instagram-magenta); color: white;">
                        <i class="fa-brands fa-instagram svg-3x mb-2"></i>
                        <h6 class="mb-1">Instagram</h6>
                        <code class="small d-block">--instagram-magenta</code>
                        <small class="d-block">#E4405F</small>
                    </div>
                    <div class="mt-2 p-2 rounded text-center" style="background: rgba(228, 64, 95, 0.1); border: 1px solid rgba(228, 64, 95, 0.3);">
                        <small class="text-theme-safe">Hover: rgba(228, 64, 95, 0.2)</small>
                    </div>
                </div>
                
                <!-- TikTok -->
                <div class="col-md-3 col-sm-6">
                    <div class="text-center p-3 rounded" style="background: #000000; color: var(--tiktok-pink); border: 2px solid var(--tiktok-pink);">
                        <i class="fa-brands fa-tiktok svg-3x mb-2"></i>
                        <h6 class="mb-1" style="color: var(--tiktok-pink);">TikTok</h6>
                        <code class="small d-block" style="color: var(--tiktok-pink);">--tiktok-pink</code>
                        <small class="d-block" style="color: var(--tiktok-pink);">#ff0050</small>
                    </div>
                    <div class="mt-2 p-2 rounded text-center" style="background: rgba(255, 0, 80, 0.1); border: 1px solid rgba(255, 0, 80, 0.3);">
                        <small class="text-theme-safe">Hover: rgba(255, 0, 80, 0.2)</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Page-Specific Theme Examples -->
        <div class="glass-card p-4 mb-5">
            <h3 class="h4 mb-4 text-theme-safe">
                <i class="fa-solid fa-layer-group me-2"></i>Page-Specific Themes
            </h3>
            
            <div class="row g-3">
                <!-- Gaming Theme -->
                <div class="col-lg-6">
                    <div class="p-4 rounded" style="background: linear-gradient(135deg, #66c0f4 0%, #1b2838 100%); color: white;">
                        <h5 class="mb-3"><i class="fa-solid fa-gamepad me-2"></i>Gaming Theme</h5>
                        <p class="small mb-2">gaming-theme.css</p>
                        <div class="d-flex gap-2 mb-2">
                            <span class="badge" style="background: #66c0f4;">#66c0f4 (Steam Blue)</span>
                            <span class="badge" style="background: #1b2838;">#1b2838 (Navy)</span>
                        </div>
                        <p class="small mb-0 opacity-75">Used on: gaming.php, Steam Curator sections</p>
                    </div>
                </div>
                
                <!-- GameDev Theme -->
                <div class="col-lg-6">
                    <div class="p-4 rounded" style="background: linear-gradient(135deg, #A563D1 0%, #FF2E88 100%); color: white;">
                        <h5 class="mb-3"><i class="fa-solid fa-code me-2"></i>GameDev Theme</h5>
                        <p class="small mb-2">gamedev-theme.css</p>
                        <div class="d-flex gap-2 mb-2">
                            <span class="badge" style="background: #A563D1;">#A563D1 (Purple)</span>
                            <span class="badge" style="background: #FF2E88;">#FF2E88 (Pink)</span>
                        </div>
                        <p class="small mb-0 opacity-75">Used on: gamedev.php, Martian Games sections</p>
                    </div>
                </div>
                
                <!-- Live Theme -->
                <div class="col-lg-6">
                    <div class="p-4 rounded" style="background: linear-gradient(135deg, #9146ff 0%, #ff0000 50%, #000000 100%); color: white;">
                        <h5 class="mb-3"><i class="fa-solid fa-broadcast-tower me-2"></i>Live Theme</h5>
                        <p class="small mb-2">live-theme.css</p>
                        <div class="d-flex gap-2 mb-2">
                            <span class="badge" style="background: #9146ff;">#9146ff (Twitch)</span>
                            <span class="badge" style="background: #ff0000;">#ff0000 (YouTube)</span>
                        </div>
                        <p class="small mb-0 opacity-75">Used on: live.php, streaming sections</p>
                    </div>
                </div>
                
                <!-- DIY Theme -->
                <div class="col-lg-6">
                    <div class="p-4 rounded" style="background: linear-gradient(135deg, #FF6EC4 0%, #A563D1 100%); color: white;">
                        <h5 class="mb-3"><i class="fa-solid fa-screwdriver-wrench me-2"></i>DIY Theme</h5>
                        <p class="small mb-2">diy-theme.css</p>
                        <div class="d-flex gap-2 mb-2">
                            <span class="badge" style="background: #FF6EC4;">#FF6EC4 (Pink)</span>
                            <span class="badge" style="background: #E6D5F5;">#E6D5F5 (Lavender)</span>
                        </div>
                        <p class="small mb-0 opacity-75">Used on: diy.php, craft sections</p>
                    </div>
                </div>
                
                <!-- Patreon Theme -->
                <div class="col-lg-6">
                    <div class="p-4 rounded" style="background: linear-gradient(135deg, #FF424D 0%, #052D49 100%); color: white;">
                        <h5 class="mb-3"><i class="fa-brands fa-patreon me-2"></i>Patreon Theme</h5>
                        <p class="small mb-2">patreon-theme.css</p>
                        <div class="d-flex gap-2 mb-2">
                            <span class="badge" style="background: #FF424D;">#FF424D (Coral)</span>
                            <span class="badge" style="background: #052D49;">#052D49 (Navy)</span>
                        </div>
                        <p class="small mb-0 opacity-75">Used on: patreon.php, VIP sections</p>
                    </div>
                </div>
                
                <!-- Tags Theme -->
                <div class="col-lg-6">
                    <div class="p-4 rounded theme-adaptive-glass" style="background: linear-gradient(135deg, rgba(255, 46, 136, 0.2) 0%, rgba(165, 99, 209, 0.2) 100%);">
                        <h5 class="mb-3 text-theme-safe"><i class="fa-solid fa-tags me-2"></i>Tags Theme</h5>
                        <p class="small mb-2 text-theme-safe">tags-theme.css</p>
                        <div class="d-flex gap-2 mb-2">
                            <span class="glass-badge">#FF2E88 (Hot Pink)</span>
                            <span class="glass-badge">#A563D1 (Purple)</span>
                        </div>
                        <p class="small mb-0 text-theme-safe-muted">Used on: tags.php, tag filtering</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- CSS Variable Inspector -->
        <div class="glass-card p-4">
            <h3 class="h4 mb-4 text-theme-safe">
                <i class="fa-solid fa-code me-2"></i>CSS Variable Inspector
            </h3>
            
            <div class="row g-4">
                <div class="col-lg-6">
                    <h5 class="text-theme-safe mb-3">Current Theme Variables</h5>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th class="text-theme-safe">Variable</th>
                                    <th class="text-theme-safe">Value</th>
                                </tr>
                            </thead>
                            <tbody class="text-theme-safe-secondary">
                                <tr>
                                    <td><code>--background</code></td>
                                    <td id="var-background-value">-</td>
                                </tr>
                                <tr>
                                    <td><code>--text</code></td>
                                    <td id="var-text-value">-</td>
                                </tr>
                                <tr>
                                    <td><code>--primary</code></td>
                                    <td id="var-primary-value">-</td>
                                </tr>
                                <tr>
                                    <td><code>--secondary</code></td>
                                    <td id="var-secondary-value">-</td>
                                </tr>
                                <tr>
                                    <td><code>--glass-bg</code></td>
                                    <td id="var-glass-bg-value">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <h5 class="text-theme-safe mb-3">Usage Example</h5>
                    <pre class="code-preview"><code>/* Component that adapts to theme */
.my-component {
  background: var(--background);
  color: var(--text);
  border: 1px solid var(--border);
}

/* Glass effect with theme-aware blur */
.my-glass-panel {
  background: var(--glass-bg);
  backdrop-filter: blur(var(--glass-backdrop-blur));
  border: 1px solid var(--glass-border);
}

/* Brand colors */
.my-button {
  background: var(--jenni-primary);
  color: white;
}

.my-button:hover {
  background: var(--jenni-secondary);
}</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Theme toggle demo functionality
function toggleDemoTheme() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute('data-bs-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    // Update theme
    html.setAttribute('data-bs-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    
    // Update UI
    updateDemoThemeUI(newTheme);
    updateVariableInspector();
}

function updateDemoThemeUI(theme) {
    const isDark = theme === 'dark';
    
    document.getElementById('theme-name').textContent = isDark ? 'Dark' : 'Light';
    document.getElementById('theme-attr').textContent = theme;
    document.getElementById('demo-toggle-icon').className = isDark ? 'fa-solid fa-sun me-2' : 'fa-solid fa-moon me-2';
    document.getElementById('demo-toggle-text').textContent = isDark ? 'Switch to Light Mode' : 'Switch to Dark Mode';
}

function updateVariableInspector() {
    const root = document.documentElement;
    const style = getComputedStyle(root);
    
    document.getElementById('var-background-value').textContent = style.getPropertyValue('--background');
    document.getElementById('var-text-value').textContent = style.getPropertyValue('--text');
    document.getElementById('var-primary-value').textContent = style.getPropertyValue('--primary');
    document.getElementById('var-secondary-value').textContent = style.getPropertyValue('--secondary');
    document.getElementById('var-glass-bg-value').textContent = style.getPropertyValue('--glass-bg');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const currentTheme = document.documentElement.getAttribute('data-bs-theme') || 'dark';
    updateDemoThemeUI(currentTheme);
    updateVariableInspector();
});
</script>
