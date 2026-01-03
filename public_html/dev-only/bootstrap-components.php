<!-- ====================================================================
     BOOTSTRAP 5.3.8 COMPONENTS
     Dynamic showcase using CSS variables from all-themes.css
     ==================================================================== -->
<section id="bootstrap-components" class="theme-section bg-pastel">
    <h2 class="display-5 mb-4">🅱️ Bootstrap 5.3.8 Components</h2>
    
    <!-- Alerts -->
    <h3 class="h4 mb-3">Alerts</h3>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="alert alert-primary" role="alert">
                <i class="fa-solid fa-circle-info me-2"></i>
                <strong>Primary Alert</strong> - Uses <code>--primary</code> color variable
            </div>
        </div>
        <div class="col-md-6">
            <div class="alert alert-secondary" role="alert">
                <i class="fa-solid fa-palette me-2"></i>
                <strong>Secondary Alert</strong> - Uses <code>--secondary</code> color variable
            </div>
        </div>
    </div>
    
    <!-- Cards -->
    <h3 class="h4 mb-3 mt-5">Cards</h3>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="fa-solid fa-star text-primary me-2"></i>Featured Card
                </div>
                <div class="card-body">
                    <h5 class="card-title">Glass Panel Design</h5>
                    <p class="card-text">Uses <code>--glass-panel-bg</code> and <code>--glass-panel-border</code> from all-themes.css</p>
                    <a href="#" class="btn btn-primary">Action</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Adaptive Colors</h5>
                    <p class="card-text">Background: <code>var(--bs-body-bg)</code></p>
                    <p class="card-text">Text: <code>var(--bs-body-color)</code></p>
                    <span class="badge bg-secondary">Dynamic</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Theme Variables</h5>
                    <div class="mb-2">
                        <span class="badge" style="background: var(--primary); color: white;">Primary</span>
                        <span class="badge" style="background: var(--secondary); color: white;">Secondary</span>
                        <span class="badge" style="background: var(--accent); color: white;">Accent</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Badges -->
    <h3 class="h4 mb-3 mt-5">Badges</h3>
    <div class="mb-4">
        <span class="badge bg-primary me-2">Primary</span>
        <span class="badge bg-secondary me-2">Secondary</span>
        <span class="badge bg-success me-2">Success</span>
        <span class="badge bg-danger me-2">Danger</span>
        <span class="badge bg-warning text-dark me-2">Warning</span>
        <span class="badge bg-info text-dark me-2">Info</span>
        <span class="badge bg-light text-dark me-2">Light</span>
        <span class="badge bg-dark me-2">Dark</span>
    </div>
    
    <!-- Buttons -->
    <h3 class="h4 mb-3 mt-5">Button Styles</h3>
    <div class="mb-4">
        <button type="button" class="btn btn-primary me-2">Primary</button>
        <button type="button" class="btn btn-secondary me-2">Secondary</button>
        <button type="button" class="btn btn-success me-2">Success</button>
        <button type="button" class="btn btn-danger me-2">Danger</button>
        <button type="button" class="btn btn-warning me-2">Warning</button>
        <button type="button" class="btn btn-info me-2">Info</button>
    </div>
    
    <!-- Outline Buttons -->
    <div class="mb-4">
        <button type="button" class="btn btn-outline-primary me-2">Primary</button>
        <button type="button" class="btn btn-outline-secondary me-2">Secondary</button>
        <button type="button" class="btn btn-outline-success me-2">Success</button>
        <button type="button" class="btn btn-outline-danger me-2">Danger</button>
    </div>
    
    <!-- Progress Bars -->
    <h3 class="h4 mb-3 mt-5">Progress Indicators</h3>
    <div class="mb-3">
        <div class="progress mb-3" style="height: 25px;">
            <div class="progress-bar" role="progressbar" style="width: 75%; background: var(--primary);" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
        </div>
        <div class="progress mb-3" style="height: 25px;">
            <div class="progress-bar" role="progressbar" style="width: 50%; background: var(--secondary);" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
        </div>
        <div class="progress" style="height: 25px;">
            <div class="progress-bar" role="progressbar" style="width: 25%; background: var(--accent);" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
        </div>
    </div>
    
    <!-- List Groups -->
    <h3 class="h4 mb-3 mt-5">List Groups</h3>
    <div class="row g-3">
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item active">Active item using <code>--primary</code></li>
                <li class="list-group-item">Second item</li>
                <li class="list-group-item">Third item</li>
                <li class="list-group-item">Fourth item</li>
            </ul>
        </div>
        <div class="col-md-6">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fa-solid fa-house me-2"></i>Home
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fa-solid fa-gamepad me-2"></i>Gaming
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <i class="fa-solid fa-code me-2"></i>Game Dev
                </a>
            </div>
        </div>
    </div>
    
    <!-- Forms -->
    <h3 class="h4 mb-3 mt-5">Form Controls</h3>
    <div class="row g-3">
        <div class="col-md-6">
            <form>
                <div class="mb-3">
                    <label for="exampleInput" class="form-label">Text Input</label>
                    <input type="text" class="form-control" id="exampleInput" placeholder="Enter text">
                </div>
                <div class="mb-3">
                    <label for="exampleSelect" class="form-label">Select Dropdown</label>
                    <select class="form-select" id="exampleSelect">
                        <option selected>Choose option...</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck">
                    <label class="form-check-label" for="exampleCheck">
                        Check me out
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="col-md-6">
            <form>
                <div class="mb-3">
                    <label for="exampleTextarea" class="form-label">Textarea</label>
                    <textarea class="form-control" id="exampleTextarea" rows="3" placeholder="Enter multiple lines..."></textarea>
                </div>
                <div class="mb-3">
                    <label for="exampleRange" class="form-label">Range Input</label>
                    <input type="range" class="form-range" id="exampleRange" min="0" max="100" value="50">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                    <label class="form-check-label" for="flexSwitchCheckDefault">
                        Toggle Switch
                    </label>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Spinners -->
    <h3 class="h4 mb-3 mt-5">Spinners</h3>
    <div class="mb-4">
        <div class="spinner-border text-primary me-3" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-border text-secondary me-3" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-primary me-3" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="spinner-grow text-secondary me-3" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    
    <!-- Toast Notification Example -->
    <h3 class="h4 mb-3 mt-5">Toast Notification</h3>
    <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fa-solid fa-bell text-primary me-2"></i>
            <strong class="me-auto">Notification</strong>
            <small>Just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            This toast uses CSS variables from all-themes.css
        </div>
    </div>
</section>
