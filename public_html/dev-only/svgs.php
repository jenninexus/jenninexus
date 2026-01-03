<?php
/**
 * SVG Icon System Showcase - Development Only
 * 
 * Purpose: Comprehensive demonstration of SVG sizing, animations, and theme-aware coloring
 * 
 * @see custom.css (lines 591-673) - SVG utility classes
 * @see FONTAWESOME-SVGS.md - SVG system documentation
 * @see theme-toggle.js - Theme-aware SVG icon implementation
 * 
 * Last Updated: January 2, 2026
 */
?>

<!-- SVG Icon System Section -->
<section id="svg-system" class="theme-section bg-pastel">
    <div class="container">
        <h2 class="mb-4 text-theme-safe">
            <i class="fa-solid fa-icons me-2"></i>SVG Icon System
        </h2>
        
        <!-- Sizing Utilities -->
        <div class="glass-card p-4 mb-5">
            <h3 class="h4 mb-4 text-theme-safe">
                <i class="fa-solid fa-ruler me-2"></i>Size Utilities
            </h3>
            
            <div class="row g-4">
                <!-- Em-based Sizing -->
                <div class="col-lg-6">
                    <h5 class="text-theme-safe mb-3">Em-Based Sizing</h5>
                    <div class="d-flex flex-wrap align-items-center gap-3 p-3 bg-theme-adaptive rounded">
                        <div class="text-center">
                            <i class="fa-solid fa-heart svg-xs text-danger"></i>
                            <p class="small mb-0 mt-1 text-theme-safe-muted">.svg-xs<br>0.75em</p>
                        </div>
                        <div class="text-center">
                            <i class="fa-solid fa-heart svg-sm text-danger"></i>
                            <p class="small mb-0 mt-1 text-theme-safe-muted">.svg-sm<br>0.875em</p>
                        </div>
                        <div class="text-center">
                            <i class="fa-solid fa-heart svg-md text-danger"></i>
                            <p class="small mb-0 mt-1 text-theme-safe-muted">.svg-md<br>1.125em</p>
                        </div>
                        <div class="text-center">
                            <i class="fa-solid fa-heart svg-lg text-danger"></i>
                            <p class="small mb-0 mt-1 text-theme-safe-muted">.svg-lg<br>1.25em</p>
                        </div>
                        <div class="text-center">
                            <i class="fa-solid fa-heart svg-xl text-danger"></i>
                            <p class="small mb-0 mt-1 text-theme-safe-muted">.svg-xl<br>1.5em</p>
                        </div>
                        <div class="text-center">
                            <i class="fa-solid fa-heart svg-2xl text-danger"></i>
                            <p class="small mb-0 mt-1 text-theme-safe-muted">.svg-2xl<br>2em</p>
                        </div>
                        <div class="text-center">
                            <i class="fa-solid fa-heart svg-3xl text-danger"></i>
                            <p class="small mb-0 mt-1 text-theme-safe-muted">.svg-3xl<br>3em</p>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <pre class="code-preview"><code>&lt;i class="fa-solid fa-heart svg-xs"&gt;&lt;/i&gt;
&lt;i class="fa-solid fa-heart svg-sm"&gt;&lt;/i&gt;
&lt;i class="fa-solid fa-heart svg-md"&gt;&lt;/i&gt;
&lt;i class="fa-solid fa-heart svg-lg"&gt;&lt;/i&gt;
&lt;i class="fa-solid fa-heart svg-xl"&gt;&lt;/i&gt;
&lt;i class="fa-solid fa-heart svg-2xl"&gt;&lt;/i&gt;
&lt;i class="fa-solid fa-heart svg-3xl"&gt;&lt;/i&gt;</code></pre>
                    </div>
                </div>
                
                <!-- Multiplier Sizing -->
                <div class="col-lg-6">
                    <h5 class="text-theme-safe mb-3">Multiplier Sizing</h5>
                    <div class="d-flex flex-wrap align-items-center gap-3 p-3 bg-theme-adaptive rounded">
                        <div class="text-center">
                            <i class="fa-solid fa-star svg-1x" style="color: var(--jenni-secondary);"></i>
                            <p class="small mb-0 mt-1 text-theme-safe-muted">.svg-1x<br>1em</p>
                        </div>
                        <div class="text-center">
                            <i class="fa-solid fa-star svg-2x" style="color: var(--jenni-secondary);"></i>
                            <p class="small mb-0 mt-1 text-theme-safe-muted">.svg-2x<br>2em</p>
                        </div>
                        <div class="text-center">
                            <i class="fa-solid fa-star svg-3x" style="color: var(--jenni-secondary);"></i>
                            <p class="small mb-0 mt-1 text-theme-safe-muted">.svg-3x<br>3em</p>
                        </div>
                        <div class="text-center">
                            <i class="fa-solid fa-star svg-4x" style="color: var(--jenni-secondary);"></i>
                            <p class="small mb-0 mt-1 text-theme-safe-muted">.svg-4x<br>4em</p>
                        </div>
                        <div class="text-center">
                            <i class="fa-solid fa-star svg-5x" style="color: var(--jenni-secondary);"></i>
                            <p class="small mb-0 mt-1 text-theme-safe-muted">.svg-5x<br>5em</p>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <pre class="code-preview"><code>&lt;i class="fa-solid fa-star svg-1x"&gt;&lt;/i&gt;
&lt;i class="fa-solid fa-star svg-2x"&gt;&lt;/i&gt;
&lt;i class="fa-solid fa-star svg-3x"&gt;&lt;/i&gt;
&lt;i class="fa-solid fa-star svg-4x"&gt;&lt;/i&gt;
&lt;i class="fa-solid fa-star svg-5x"&gt;&lt;/i&gt;</code></pre>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Animation Utilities -->
        <div class="glass-card p-4 mb-5">
            <h3 class="h4 mb-4 text-theme-safe">
                <i class="fa-solid fa-play me-2"></i>Animation Utilities
            </h3>
            
            <div class="row g-4">
                <div class="col-md-4 col-sm-6">
                    <div class="text-center p-4 bg-theme-adaptive rounded">
                        <i class="fa-solid fa-spinner svg-spin svg-3x mb-3" style="color: var(--jenni-primary);"></i>
                        <h5 class="text-theme-safe">.svg-spin</h5>
                        <p class="small text-theme-safe-muted mb-3">Continuous rotation</p>
                        <pre class="code-preview text-start"><code>&lt;i class="fa-solid fa-spinner
   svg-spin svg-3x"&gt;
&lt;/i&gt;</code></pre>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-6">
                    <div class="text-center p-4 bg-theme-adaptive rounded">
                        <i class="fa-solid fa-heart svg-pulse svg-3x mb-3 text-danger"></i>
                        <h5 class="text-theme-safe">.svg-pulse</h5>
                        <p class="small text-theme-safe-muted mb-3">8-step rotation</p>
                        <pre class="code-preview text-start"><code>&lt;i class="fa-solid fa-heart
   svg-pulse svg-3x"&gt;
&lt;/i&gt;</code></pre>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-6">
                    <div class="text-center p-4 bg-theme-adaptive rounded">
                        <i class="fa-solid fa-heart svg-beat svg-3x mb-3 text-danger"></i>
                        <h5 class="text-theme-safe">.svg-beat</h5>
                        <p class="small text-theme-safe-muted mb-3">Scale pulse</p>
                        <pre class="code-preview text-start"><code>&lt;i class="fa-solid fa-heart
   svg-beat svg-3x"&gt;
&lt;/i&gt;</code></pre>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-6">
                    <div class="text-center p-4 bg-theme-adaptive rounded">
                        <i class="fa-solid fa-star svg-fade svg-3x mb-3" style="color: var(--jenni-accent);"></i>
                        <h5 class="text-theme-safe">.svg-fade</h5>
                        <p class="small text-theme-safe-muted mb-3">Opacity pulse</p>
                        <pre class="code-preview text-start"><code>&lt;i class="fa-solid fa-star
   svg-fade svg-3x"&gt;
&lt;/i&gt;</code></pre>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-6">
                    <div class="text-center p-4 bg-theme-adaptive rounded">
                        <i class="fa-solid fa-arrow-up svg-bounce svg-3x mb-3" style="color: var(--jenni-secondary);"></i>
                        <h5 class="text-theme-safe">.svg-bounce</h5>
                        <p class="small text-theme-safe-muted mb-3">Vertical bounce</p>
                        <pre class="code-preview text-start"><code>&lt;i class="fa-solid fa-arrow-up
   svg-bounce svg-3x"&gt;
&lt;/i&gt;</code></pre>
                    </div>
                </div>
                
                <div class="col-md-4 col-sm-6">
                    <div class="text-center p-4 bg-theme-adaptive rounded">
                        <i class="fa-solid fa-bell svg-shake svg-3x mb-3" style="color: var(--jenni-warning);"></i>
                        <h5 class="text-theme-safe">.svg-shake</h5>
                        <p class="small text-theme-safe-muted mb-3">Horizontal shake</p>
                        <pre class="code-preview text-start"><code>&lt;i class="fa-solid fa-bell
   svg-shake svg-3x"&gt;
&lt;/i&gt;</code></pre>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-info mt-4">
                <i class="fa-solid fa-universal-access me-2"></i>
                <strong>Accessibility:</strong> All animations respect <code>prefers-reduced-motion</code> and will be disabled for users who prefer reduced motion.
            </div>
        </div>
        
        <!-- Theme-Aware Colors -->
        <div class="glass-card p-4 mb-5">
            <h3 class="h4 mb-4 text-theme-safe">
                <i class="fa-solid fa-palette me-2"></i>Theme-Aware Colors
            </h3>
            
            <div class="row g-4">
                <!-- currentColor Pattern -->
                <div class="col-lg-6">
                    <h5 class="text-theme-safe mb-3">currentColor (Inherits Text Color)</h5>
                    <div class="p-4 bg-theme-adaptive rounded">
                        <div class="mb-3" style="color: var(--jenni-primary);">
                            <i class="fa-solid fa-circle-check svg-2x me-2"></i>
                            <span class="text-theme-safe">Icon inherits parent color</span>
                        </div>
                        <div class="mb-3" style="color: var(--jenni-secondary);">
                            <i class="fa-solid fa-circle-check svg-2x me-2"></i>
                            <span class="text-theme-safe">Changes with parent</span>
                        </div>
                        <div style="color: var(--jenni-accent);">
                            <i class="fa-solid fa-circle-check svg-2x me-2"></i>
                            <span class="text-theme-safe">Automatic theme adaptation</span>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <pre class="code-preview"><code>&lt;div style="color: var(--jenni-primary);"&gt;
  &lt;i class="fa-solid fa-circle-check"&gt;&lt;/i&gt;
  &lt;span&gt;Icon inherits parent color&lt;/span&gt;
&lt;/div&gt;</code></pre>
                    </div>
                </div>
                
                <!-- CSS Variable Pattern -->
                <div class="col-lg-6">
                    <h5 class="text-theme-safe mb-3">CSS Variables (Direct Color)</h5>
                    <div class="p-4 bg-theme-adaptive rounded">
                        <div class="mb-3">
                            <i class="fa-solid fa-heart svg-2x me-2" style="color: var(--jenni-primary);"></i>
                            <span class="text-theme-safe">--jenni-primary</span>
                        </div>
                        <div class="mb-3">
                            <i class="fa-solid fa-star svg-2x me-2" style="color: var(--jenni-secondary);"></i>
                            <span class="text-theme-safe">--jenni-secondary</span>
                        </div>
                        <div>
                            <i class="fa-solid fa-wand-magic-sparkles svg-2x me-2" style="color: var(--jenni-accent);"></i>
                            <span class="text-theme-safe">--jenni-accent</span>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <pre class="code-preview"><code>&lt;i class="fa-solid fa-heart"
   style="color: var(--jenni-primary);"&gt;
&lt;/i&gt;</code></pre>
                    </div>
                </div>
            </div>
            
            <!-- Light/Dark Comparison -->
            <div class="mt-4">
                <h5 class="text-theme-safe mb-3">Light/Dark Theme Comparison</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-4 rounded" style="background: #F9F3FB; color: #2D1B3D;">
                            <h6 class="mb-3" style="color: #2D1B3D;">Light Mode Preview</h6>
                            <div class="d-flex gap-3 align-items-center">
                                <i class="fa-solid fa-sun svg-2x" style="color: #A563D1;"></i>
                                <i class="fa-brands fa-youtube svg-2x" style="color: #ff0000;"></i>
                                <i class="fa-brands fa-discord svg-2x" style="color: #5865F2;"></i>
                                <i class="fa-brands fa-twitch svg-2x" style="color: #9146FF;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-4 rounded" style="background: #0F0F19; color: #E0D5EB;">
                            <h6 class="mb-3" style="color: #E0D5EB;">Dark Mode Preview</h6>
                            <div class="d-flex gap-3 align-items-center">
                                <i class="fa-solid fa-moon svg-2x" style="color: #FF2E88;"></i>
                                <i class="fa-brands fa-youtube svg-2x" style="color: #ff0000;"></i>
                                <i class="fa-brands fa-discord svg-2x" style="color: #5865F2;"></i>
                                <i class="fa-brands fa-twitch svg-2x" style="color: #9146FF;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Brand Icons -->
        <div class="glass-card p-4 mb-5">
            <h3 class="h4 mb-4 text-theme-safe">
                <i class="fa-brands fa-font-awesome me-2"></i>Brand Icons (FontAwesome 6.7.2)
            </h3>
            
            <div class="row g-3">
                <div class="col-md-3 col-sm-4 col-6">
                    <div class="text-center p-3 bg-theme-adaptive rounded">
                        <i class="fa-brands fa-youtube svg-3x mb-2" style="color: var(--youtube-red);"></i>
                        <p class="small mb-0 text-theme-safe">fa-youtube</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-6">
                    <div class="text-center p-3 bg-theme-adaptive rounded">
                        <i class="fa-brands fa-discord svg-3x mb-2" style="color: var(--discord-blurple);"></i>
                        <p class="small mb-0 text-theme-safe">fa-discord</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-6">
                    <div class="text-center p-3 bg-theme-adaptive rounded">
                        <i class="fa-brands fa-twitch svg-3x mb-2" style="color: var(--twitch-purple);"></i>
                        <p class="small mb-0 text-theme-safe">fa-twitch</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-6">
                    <div class="text-center p-3 bg-theme-adaptive rounded">
                        <i class="fa-brands fa-patreon svg-3x mb-2" style="color: var(--patreon-coral);"></i>
                        <p class="small mb-0 text-theme-safe">fa-patreon</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-6">
                    <div class="text-center p-3 bg-theme-adaptive rounded">
                        <i class="fa-brands fa-steam svg-3x mb-2" style="color: var(--steam-blue);"></i>
                        <p class="small mb-0 text-theme-safe">fa-steam</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-6">
                    <div class="text-center p-3 bg-theme-adaptive rounded">
                        <i class="fa-brands fa-spotify svg-3x mb-2" style="color: var(--spotify-green);"></i>
                        <p class="small mb-0 text-theme-safe">fa-spotify</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-6">
                    <div class="text-center p-3 bg-theme-adaptive rounded">
                        <i class="fa-brands fa-instagram svg-3x mb-2" style="color: var(--instagram-magenta);"></i>
                        <p class="small mb-0 text-theme-safe">fa-instagram</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-6">
                    <div class="text-center p-3 bg-theme-adaptive rounded">
                        <i class="fa-brands fa-tiktok svg-3x mb-2" style="color: var(--tiktok-pink);"></i>
                        <p class="small mb-0 text-theme-safe">fa-tiktok</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Best Practices -->
        <div class="glass-card p-4">
            <h3 class="h4 mb-4 text-theme-safe">
                <i class="fa-solid fa-lightbulb me-2"></i>Best Practices
            </h3>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <h5 class="text-success mb-3"><i class="fa-solid fa-check-circle me-2"></i>Do</h5>
                    <ul class="text-theme-safe">
                        <li>Use <code>currentColor</code> for icons that should match text color</li>
                        <li>Use CSS variables (<code>var(--jenni-primary)</code>) for brand consistency</li>
                        <li>Apply sizing classes (<code>.svg-lg</code>) instead of inline styles</li>
                        <li>Test icons in both light and dark themes</li>
                        <li>Use semantic icon choices (fa-heart for favorites, fa-star for ratings)</li>
                        <li>Combine size and animation classes when needed</li>
                    </ul>
                </div>
                
                <div class="col-md-6">
                    <h5 class="text-danger mb-3"><i class="fa-solid fa-times-circle me-2"></i>Don't</h5>
                    <ul class="text-theme-safe">
                        <li>Don't use hard-coded hex colors (<code>#FF0000</code>) - breaks theme switching</li>
                        <li>Don't mix sizing methods (em-based + multipliers) on same icon</li>
                        <li>Don't override SVG sizing with <code>font-size</code> - use utility classes</li>
                        <li>Don't use animations on critical UI elements (loading indicators OK)</li>
                        <li>Don't assume icon colors will work on all backgrounds</li>
                        <li>Don't forget <code>prefers-reduced-motion</code> accessibility</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
