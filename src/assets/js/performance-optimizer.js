/**
 * Performance Optimizer
 * Detects user capabilities and applies appropriate performance classes
 * for optimal experience across all devices and connections
 */

class PerformanceOptimizer {
    constructor() {
        this.performanceMode = 'full';
        this.connectionQuality = 'fast';
        this.prefersReducedMotion = false;
        this.deviceType = 'desktop';
        
        this.init();
    }
    
    init() {
        // Detect capabilities immediately
        this.detectCapabilities();
        
        // Apply classes to body
        this.applyPerformanceClasses();
        
        // Set up observers
        this.setupObservers();
        
        // Store preferences
        this.storePreferences();
        
        // Setup performance monitoring
        this.setupPerformanceMonitoring();
    }
    
    detectCapabilities() {
        // Detect reduced motion preference
        this.detectReducedMotion();
        
        // Detect device type
        this.detectDeviceType();
        
        // Detect connection quality
        this.detectConnectionQuality();
        
        // Detect performance capabilities
        this.detectPerformanceMode();
        
        // Check for existing user preferences
        this.loadUserPreferences();
    }
    
    detectReducedMotion() {
        // Check CSS media query
        if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            this.prefersReducedMotion = true;
        }
        
        // Check for save-data header (indicates user wants to save bandwidth)
        if (navigator.connection && navigator.connection.saveData) {
            this.prefersReducedMotion = true;
        }
        
        // Check stored preference
        const storedPreference = this.getCookie('jenni_prefers_reduced_motion');
        if (storedPreference === 'true') {
            this.prefersReducedMotion = true;
        }
    }
    
    detectDeviceType() {
        const userAgent = navigator.userAgent.toLowerCase();
        const screenWidth = window.screen.width;
        
        if (/mobile|android|iphone|ipod|blackberry|opera mini|iemobile/i.test(userAgent)) {
            this.deviceType = 'mobile';
        } else if (/ipad|tablet|kindle|silk|playbook/i.test(userAgent) || 
                   (screenWidth >= 768 && screenWidth <= 1024)) {
            this.deviceType = 'tablet';
        } else {
            this.deviceType = 'desktop';
        }
    }
    
    detectConnectionQuality() {
        // Check Network Information API
        if (navigator.connection) {
            const connection = navigator.connection;
            
            // Check effective connection type
            if (connection.effectiveType) {
                switch (connection.effectiveType) {
                    case 'slow-2g':
                    case '2g':
                        this.connectionQuality = 'slow';
                        break;
                    case '3g':
                        this.connectionQuality = 'medium';
                        break;
                    case '4g':
                    default:
                        this.connectionQuality = 'fast';
                        break;
                }
            }
            
            // Check save-data preference
            if (connection.saveData) {
                this.connectionQuality = 'slow';
            }
            
            // Check downlink speed (Mbps)
            if (connection.downlink) {
                if (connection.downlink < 1.5) {
                    this.connectionQuality = 'slow';
                } else if (connection.downlink < 5) {
                    this.connectionQuality = 'medium';
                }
            }
        }
        
        // Fallback: Measure load time
        if (window.performance && window.performance.timing) {
            const loadTime = window.performance.timing.loadEventEnd - window.performance.timing.navigationStart;
            if (loadTime > 3000) {
                this.connectionQuality = 'slow';
            } else if (loadTime > 1500) {
                this.connectionQuality = 'medium';
            }
        }
    }
    
    detectPerformanceMode() {
        let score = 0;
        
        // Device type scoring
        switch (this.deviceType) {
            case 'mobile':
                score -= 2;
                break;
            case 'tablet':
                score -= 1;
                break;
            case 'desktop':
                score += 1;
                break;
        }
        
        // Connection quality scoring
        switch (this.connectionQuality) {
            case 'slow':
                score -= 3;
                break;
            case 'medium':
                score -= 1;
                break;
            case 'fast':
                score += 1;
                break;
        }
        
        // Reduced motion preference
        if (this.prefersReducedMotion) {
            score -= 2;
        }
        
        // Hardware concurrency (CPU cores)
        if (navigator.hardwareConcurrency) {
            if (navigator.hardwareConcurrency <= 2) {
                score -= 1;
            } else if (navigator.hardwareConcurrency >= 8) {
                score += 1;
            }
        }
        
        // Memory (if available)
        if (navigator.deviceMemory) {
            if (navigator.deviceMemory <= 2) {
                score -= 2;
            } else if (navigator.deviceMemory >= 8) {
                score += 1;
            }
        }
        
        // Battery level (if available)
        if (navigator.getBattery) {
            navigator.getBattery().then(battery => {
                if (battery.level < 0.2) {
                    this.performanceMode = 'minimal';
                    this.applyPerformanceClasses();
                }
            });
        }
        
        // Determine performance mode
        if (score <= -4) {
            this.performanceMode = 'minimal';
        } else if (score <= -1) {
            this.performanceMode = 'reduced';
        } else {
            this.performanceMode = 'full';
        }
    }
    
    loadUserPreferences() {
        // Check for stored performance mode
        const storedMode = this.getCookie('jenni_performance_mode');
        if (storedMode && ['minimal', 'reduced', 'full'].includes(storedMode)) {
            this.performanceMode = storedMode;
        }
        
        // Check for stored connection quality
        const storedConnection = this.getCookie('jenni_connection_quality');
        if (storedConnection && ['slow', 'medium', 'fast'].includes(storedConnection)) {
            this.connectionQuality = storedConnection;
        }
    }
    
    applyPerformanceClasses() {
        const body = document.body;
        
        // Remove existing performance classes
        body.classList.remove(
            'perf-mode-minimal', 'perf-mode-reduced', 'perf-mode-full',
            'connection-slow', 'connection-medium', 'connection-fast',
            'device-mobile', 'device-tablet', 'device-desktop',
            'prefers-reduced-motion'
        );
        
        // Apply current classes
        body.classList.add(`perf-mode-${this.performanceMode}`);
        body.classList.add(`connection-${this.connectionQuality}`);
        body.classList.add(`device-${this.deviceType}`);
        
        if (this.prefersReducedMotion) {
            body.classList.add('prefers-reduced-motion');
        }
        
        // Add JavaScript detection class
        body.classList.remove('no-js');
        body.classList.add('js');
        
        // Dispatch custom event for other scripts
        window.dispatchEvent(new CustomEvent('performanceClassesApplied', {
            detail: {
                performanceMode: this.performanceMode,
                connectionQuality: this.connectionQuality,
                deviceType: this.deviceType,
                prefersReducedMotion: this.prefersReducedMotion
            }
        }));
    }
    
    setupObservers() {
        // Watch for connection changes
        if (navigator.connection) {
            navigator.connection.addEventListener('change', () => {
                this.detectConnectionQuality();
                this.applyPerformanceClasses();
                this.storePreferences();
            });
        }
        
        // Watch for reduced motion preference changes
        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
            mediaQuery.addListener((e) => {
                this.prefersReducedMotion = e.matches;
                this.applyPerformanceClasses();
                this.storePreferences();
            });
        }
        
        // Watch for orientation changes (affects device type)
        window.addEventListener('orientationchange', () => {
            setTimeout(() => {
                this.detectDeviceType();
                this.applyPerformanceClasses();
            }, 100);
        });
        
        // Setup resize handler with debounce
        function setupResizeHandler() {
            let performanceResizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(performanceResizeTimeout);
                performanceResizeTimeout = setTimeout(() => {
                    updateViewportCache();
                    optimizeImages();
                    checkMemoryUsage();
                }, 200);
            });
        }
    }
    
    setupPerformanceMonitoring() {
        // Monitor frame rate
        let frameCount = 0;
        let lastTime = performance.now();
        
        const checkFrameRate = () => {
            frameCount++;
            const currentTime = performance.now();
            
            if (currentTime - lastTime >= 1000) {
                const fps = frameCount;
                frameCount = 0;
                lastTime = currentTime;
                
                // If FPS is consistently low, reduce performance mode
                if (fps < 30 && this.performanceMode === 'full') {
                    this.performanceMode = 'reduced';
                    this.applyPerformanceClasses();
                    this.storePreferences();
                } else if (fps < 15 && this.performanceMode === 'reduced') {
                    this.performanceMode = 'minimal';
                    this.applyPerformanceClasses();
                    this.storePreferences();
                }
            }
            
            requestAnimationFrame(checkFrameRate);
        };
        
        // Only monitor if we're in full performance mode
        if (this.performanceMode === 'full') {
            requestAnimationFrame(checkFrameRate);
        }
        
        // Monitor memory usage (if available)
        if (performance.memory) {
            setInterval(() => {
                const memoryUsage = performance.memory.usedJSHeapSize / performance.memory.jsHeapSizeLimit;
                
                if (memoryUsage > 0.8 && this.performanceMode !== 'minimal') {
                    this.performanceMode = 'minimal';
                    this.applyPerformanceClasses();
                    this.storePreferences();
                }
            }, 5000);
        }
    }
    
    storePreferences() {
        // Store in cookies for server-side access
        this.setCookie('jenni_performance_mode', this.performanceMode, 365);
        this.setCookie('jenni_connection_quality', this.connectionQuality, 365);
        this.setCookie('jenni_prefers_reduced_motion', this.prefersReducedMotion.toString(), 365);
        this.setCookie('jenni_device_type', this.deviceType, 365);
        
        // Store in localStorage for quick access
        try {
            localStorage.setItem('jenni_performance_settings', JSON.stringify({
                performanceMode: this.performanceMode,
                connectionQuality: this.connectionQuality,
                prefersReducedMotion: this.prefersReducedMotion,
                deviceType: this.deviceType,
                timestamp: Date.now()
            }));
        } catch (e) {
            // localStorage not available
        }
    }
    
    // Public methods for manual control
    setPerformanceMode(mode) {
        if (['minimal', 'reduced', 'full'].includes(mode)) {
            this.performanceMode = mode;
            this.applyPerformanceClasses();
            this.storePreferences();
        }
    }
    
    setReducedMotion(enabled) {
        this.prefersReducedMotion = enabled;
        this.applyPerformanceClasses();
        this.storePreferences();
    }
    
    getPerformanceInfo() {
        return {
            performanceMode: this.performanceMode,
            connectionQuality: this.connectionQuality,
            deviceType: this.deviceType,
            prefersReducedMotion: this.prefersReducedMotion
        };
    }
    
    // Utility methods
    getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return null;
    }
    
    setCookie(name, value, days) {
        const expires = new Date();
        expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/;SameSite=Lax`;
    }
}

// Initialize performance optimizer when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.performanceOptimizer = new PerformanceOptimizer();
    });
} else {
    window.performanceOptimizer = new PerformanceOptimizer();
}

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = PerformanceOptimizer;
} 