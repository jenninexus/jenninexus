<?php
/**
 * Simple inline SVG icon helper for a small set of icons used in the footer and hero.
 * Progressive replacement for <i class="bi ..."> so SVGs are pixel-aligned and styleable.
 * Keep this file small — add icons here as needed.
 */

function svg_icon($name, $attrs = '') {
  $icons = [
    'envelope-fill' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path d="M.05 3.555A2 2 0 0 1 2.002 2h11.996c.89 0 1.63.58 1.95 1.395L8 8.414.05 3.555z"/><path d="M0 4.697v7.104l5.803-3.553L0 4.697zM6.761 8.83l-6.761 4.142A2 2 0 0 0 2.002 14h11.996a2 2 0 0 0 1.999-1.028L9.239 8.83 8 9.584l-1.239-.754zM16 4.697l-5.803 3.551L16 11.801V4.697z"/></svg>',
    'youtube' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path d="M8.051 1.999c-.704.002-3.33.01-4.913.197C1.95 2.28 1.13 3.03.96 4.03.76 5.29.74 7.07.74 7.99c0 .92.02 2.7.22 3.96.17 1 .99 1.75 2.178 1.83 1.583.186 4.209.195 4.913.197.704-.002 3.33-.01 4.913-.197 1.188-.08 2.01-.83 2.178-1.83.2-1.26.22-3.04.22-3.96 0-.92-.02-2.7-.22-3.96-.17-1- .99-1.75-2.178-1.83C11.381 2.009 8.755 2 8.051 1.999zM6.4 5.8l4.4 2.2-4.4 2.2V5.8z"/></svg>',
    'twitch' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4 3v14l3-3h3l3 3h4l3-3V3H4zm15 11h-2v3h-2v-3H9l-2 2V5h12v9z"/></svg>',
    'spotify' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><circle cx="8" cy="8" r="7"/></svg>',
    'heart-fill' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path d="M8 2.748C6.885 1.168 5.08.5 3.776 1.06 1.99 1.82 1.5 4.045 2.4 5.58c.9 1.536 3.03 3.072 5.6 5.06 2.57-1.99 4.7-3.524 5.6-5.06.9-1.536.41-3.76-1.376-4.52C10.92.5 9.115 1.168 8 2.748z"/></svg>',
    'discord' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 3H4a1 1 0 0 0-1 1v14l3-2 3 2 3-2 3 2 3-2V4a1 1 0 0 0-1-1z"/></svg>',
    'arrow-up' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M8 12a.5.5 0 0 0 .5-.5V4.707l3.147 3.147a.5.5 0 0 0 .707-.707l-4-4-.007-.007a.498.498 0 0 0-.69.007l-4 4a.5.5 0 1 0 .707.707L7.5 4.707V11.5A.5.5 0 0 0 8 12z"/></svg>',
    'briefcase' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path d="M0 4a2 2 0 0 1 2-2h3V1a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v1h3a2 2 0 0 1 2 2v2H0V4z"/></svg>'
  ];

  if (!isset($icons[$name])) return '';
  $svg = $icons[$name];
  // inject attributes: simple approach — insert class and aria-hidden handling
  if ($attrs) {
    // add attributes onto the root <svg ...>
    $svg = preg_replace('/<svg([^>]*)>/', '<svg$1 ' . $attrs . '>', $svg, 1);
  }
  return $svg;
}

?>
