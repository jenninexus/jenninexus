<!-- Tag Filter Offcanvas -->
<div class="offcanvas offcanvas-end glass-sidebar" tabindex="-1" id="tagFilterOffcanvas" aria-labelledby="tagFilterOffcanvasLabel">
  <div class="offcanvas-header border-bottom" style="border-color: var(--glass-panel-border) !important;">
    <h5 id="tagFilterOffcanvasLabel">Filter by Tags</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <!-- "Show all tags" toggle is injected here by tag-system.js -->

    <!-- GameDev Tags -->
    <div id="gamedevTagsSection" class="tag-section mb-3 d-none">
      <h6 class="mb-2">Game Development</h6>
      <div id="gamedevTagsList" class="d-flex flex-wrap gap-2"></div>
    </div>

    <!-- Gaming Tags -->
    <div id="gamingTagsSection" class="tag-section mb-3 d-none">
      <h6 class="mb-2">Gaming</h6>
      <div id="gamingTagsList" class="d-flex flex-wrap gap-2"></div>
    </div>

    <!-- DIY Tags -->
    <div id="diyTagsSection" class="tag-section mb-3 d-none">
      <h6 class="mb-2">DIY & Lifestyle</h6>
      <div id="diyTagsList" class="d-flex flex-wrap gap-2"></div>
    </div>

    <!-- Voice Acting Tags -->
    <div id="voiceTagsSection" class="tag-section mb-3 d-none">
      <h6 class="mb-2">Voice Acting</h6>
      <div id="voiceTagsList" class="d-flex flex-wrap gap-2"></div>
    </div>
    
    <hr>
    <div class="d-grid">
      <button id="applyFilters" class="btn btn-primary" type="button">Apply Filters</button>
      <button id="clearFilters" class="btn btn-outline-secondary mt-2" type="button">Clear</button>
    </div>
  </div>
</div>

<script>
// Simple script to show sections only when they have tags
document.addEventListener('DOMContentLoaded', function() {
  const sections = [
    { listId: 'gamedevTagsList', sectionId: 'gamedevTagsSection' },
    { listId: 'gamingTagsList', sectionId: 'gamingTagsSection' },
    { listId: 'diyTagsList', sectionId: 'diyTagsSection' },
    { listId: 'voiceTagsList', sectionId: 'voiceTagsSection' }
  ];

  sections.forEach(item => {
    const list = document.getElementById(item.listId);
    const section = document.getElementById(item.sectionId);
    
    if (list && section) {
      // Check initially
      if (list.children.length > 0) section.classList.remove('d-none');
      
      // Watch for changes
      const observer = new MutationObserver(() => {
        if (list.children.length > 0) {
          section.classList.remove('d-none');
        } else {
          section.classList.add('d-none');
        }
      });
      observer.observe(list, { childList: true });
    }
  });
});
</script>
