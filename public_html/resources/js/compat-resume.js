// compat-resume.js - Defensive guard for legacy resume integrations
// Ensures code that expects `window.resumeId` doesn't throw when absent.
(function(){
  'use strict';
  if (typeof window === 'undefined') return;
  if (typeof window.resumeId === 'undefined') {
    window.resumeId = null;
  }
  // Expose a tiny helper to safely consume resume IDs
  window.getResumeId = window.getResumeId || function(){ return window.resumeId; };
})();