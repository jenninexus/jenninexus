<!-- ====================================================================
     TYPOGRAPHY & LOGO TEXT STYLES
     Font families, sizes, and brand text styles
     ==================================================================== -->
<section id="typography-samples" class="theme-section bg-pastel">
    <h2 class="display-5 mb-4">✒️ Typography & Logo Text Styles</h2>
    
    <!-- Display Headings -->
    <h3 class="h4 mb-3">Display Headings</h3>
    <div class="mb-5">
        <h1 class="display-1" style="color: var(--primary);">Display 1</h1>
        <h1 class="display-2" style="color: var(--secondary);">Display 2</h1>
        <h1 class="display-3" style="color: var(--accent);">Display 3</h1>
        <h1 class="display-4" style="color: var(--primary);">Display 4</h1>
        <h1 class="display-5" style="color: var(--secondary);">Display 5</h1>
        <h1 class="display-6" style="color: var(--accent);">Display 6</h1>
    </div>
    
    <!-- Standard Headings -->
    <h3 class="h4 mb-3">Standard Headings</h3>
    <div class="mb-5">
        <h1>Heading 1 - Default Body Color</h1>
        <h2>Heading 2 - Automatic Theme Adaptation</h2>
        <h3>Heading 3 - Uses <code>var(--bs-body-color)</code></h3>
        <h4>Heading 4 - Light mode: dark text, Dark mode: light text</h4>
        <h5>Heading 5 - Responsive to theme changes</h5>
        <h6>Heading 6 - Smallest heading size</h6>
    </div>
    
    <!-- Body Text -->
    <h3 class="h4 mb-3">Body Text Styles</h3>
    <div class="mb-5">
        <p class="lead">Lead paragraph - Larger text for emphasis using <code>.lead</code> class</p>
        <p>Regular paragraph text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Uses <code>var(--bs-body-color)</code> for automatic theme adaptation.</p>
        <p class="text-muted">Muted text using <code>.text-muted</code> - softer emphasis</p>
        <p><small>Small text using <code>&lt;small&gt;</code> tag for legal text or disclaimers</small></p>
        <p><mark style="background-color: var(--primary); color: white;">Highlighted text</mark> with primary color background</p>
    </div>
    
    <!-- Logo Text Styles -->
    <h3 class="h4 mb-3">JenniNexus Logo Styles</h3>
    <div class="mb-5">
        <div class="mb-4 p-4 border rounded text-center">
            <h1 class="display-3 fw-bold mb-0" style="
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                text-shadow: 0 0 30px var(--glow);
            ">JenniNexus</h1>
            <p class="small mt-2">Primary gradient logo</p>
        </div>
        
        <div class="mb-4 p-4 border rounded text-center">
            <h1 class="display-4 fw-bold mb-0" style="
                color: var(--primary);
                text-shadow: 0 0 20px rgba(var(--primary-rgb), 0.5);
            ">JenniNexus</h1>
            <p class="small mt-2">Glowing purple variant</p>
        </div>
        
        <div class="mb-4 p-4 border rounded text-center">
            <h1 class="display-4 fw-bold mb-0" style="
                color: var(--secondary);
                text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            ">JenniNexus</h1>
            <p class="small mt-2">Pink with shadow</p>
        </div>
    </div>
    
    <!-- Font Weights -->
    <h3 class="h4 mb-3">Font Weights</h3>
    <div class="mb-5">
        <p class="fw-light">Light weight text (300)</p>
        <p class="fw-normal">Normal weight text (400)</p>
        <p class="fw-medium">Medium weight text (500)</p>
        <p class="fw-semibold">Semibold weight text (600)</p>
        <p class="fw-bold">Bold weight text (700)</p>
        <p class="fw-bolder">Bolder weight text (900)</p>
    </div>
    
    <!-- Text Alignment -->
    <h3 class="h4 mb-3">Text Alignment</h3>
    <div class="mb-5">
        <p class="text-start">Left aligned text (start)</p>
        <p class="text-center">Center aligned text</p>
        <p class="text-end">Right aligned text (end)</p>
    </div>
    
    <!-- Text Colors with Variables -->
    <h3 class="h4 mb-3">Theme Color Variables</h3>
    <div class="mb-5">
        <p style="color: var(--primary);">Primary color text - <code>var(--primary)</code></p>
        <p style="color: var(--secondary);">Secondary color text - <code>var(--secondary)</code></p>
        <p style="color: var(--accent);">Accent color text - <code>var(--accent)</code></p>
        <p style="color: var(--bs-body-color);">Body color text - <code>var(--bs-body-color)</code></p>
    </div>
    
    <!-- Code & Preformatted Text -->
    <h3 class="h4 mb-3">Code & Preformatted</h3>
    <div class="mb-5">
        <p>Inline code: <code>var(--primary)</code> and <code>background: var(--glass-panel-bg)</code></p>
        <pre class="p-3 border rounded"><code>// CSS Variable Usage
:root[data-bs-theme="light"] {
  --primary: #A563D1;
  --secondary: #FF2E88;
  --accent: #FF6EC4;
}</code></pre>
    </div>
    
    <!-- Lists -->
    <h3 class="h4 mb-3">List Styles</h3>
    <div class="row g-3">
        <div class="col-md-6">
            <h5>Unordered List</h5>
            <ul>
                <li>Bootstrap 5.3.8 components</li>
                <li>FontAwesome 6.7.2 icons</li>
                <li>Custom CSS variables</li>
                <li>Theme-aware colors</li>
            </ul>
        </div>
        <div class="col-md-6">
            <h5>Ordered List</h5>
            <ol>
                <li>Check theme variables</li>
                <li>Update component styles</li>
                <li>Test in both themes</li>
                <li>Deploy to production</li>
            </ol>
        </div>
    </div>
    
    <!-- Blockquotes -->
    <h3 class="h4 mb-3 mt-5">Blockquotes</h3>
    <blockquote class="blockquote" style="border-left: 4px solid var(--primary); padding-left: 1rem;">
        <p>"Design is not just what it looks like and feels like. Design is how it works."</p>
        <footer class="blockquote-footer">Steve Jobs</footer>
    </blockquote>
</section>
