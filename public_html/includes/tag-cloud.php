<?php
// Simple tag cloud include. Renders an empty container that is populated by JS (tag-cloud.js).
?>
<div class="glass-card my-4">
  <div class="p-4">
    <h5 class="mb-3">Tag Cloud</h5>
    <div id="tagCloud" class="tag-cloud d-flex flex-wrap" aria-live="polite">
      <!-- Tags injected by tag-cloud.js -->
      <div class="small text-muted">Loading tags…</div>
    </div>
    <p class="small text-muted mt-3 mb-0">Click a tag to filter visible content on the page.</p>
  </div>
</div>
