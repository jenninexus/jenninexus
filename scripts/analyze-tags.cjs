#!/usr/bin/env node
/**
 * Tag Usage Analyzer
 * Identifies which tags from tags.json are actually used vs unused
 */

const fs = require('fs');
const path = require('path');

const tagsPath = path.join(__dirname, '../public_html/resources/playlists/tags.json');
const contentTagsPath = path.join(__dirname, '../public_html/resources/playlists/content_tags.json');

// Load data files
const tags = JSON.parse(fs.readFileSync(tagsPath, 'utf8'));
const contentTags = JSON.parse(fs.readFileSync(contentTagsPath, 'utf8'));

// Extract all used tag IDs from content_tags.json
const usedIds = new Set();
Object.values(contentTags).forEach(val => {
  if (Array.isArray(val)) {
    val.forEach(id => usedIds.add(id));
  } else if (val && val.tags && Array.isArray(val.tags)) {
    val.tags.forEach(id => usedIds.add(id));
  }
});

// Find unused tags
const unused = tags.filter(tag => !usedIds.has(tag.id));
const used = tags.filter(tag => usedIds.has(tag.id));

// Group unused by category
const unusedByCategory = unused.reduce((acc, tag) => {
  const cat = Array.isArray(tag.category) ? tag.category[0] : tag.category;
  if (!acc[cat]) acc[cat] = [];
  acc[cat].push(tag);
  return acc;
}, {});

console.log('═══════════════════════════════════════════════════════');
console.log('  TAG USAGE ANALYSIS');
console.log('═══════════════════════════════════════════════════════\n');

console.log(`SUMMARY: ${used.length} tags used, ${unused.length} tags unused out of ${tags.length} total\n`);

console.log('UNUSED TAGS BY CATEGORY:\n');
Object.entries(unusedByCategory).sort().forEach(([category, catTags]) => {
  console.log(`${category} (${catTags.length} unused):`);
  catTags.forEach(tag => {
    console.log(`  • ID ${tag.id}: ${tag.name} (${tag.slug})`);
  });
  console.log('');
});

console.log('\nRECOMMENDATION:');
console.log('Remove unused tags from tags.json to prevent "No content matched" errors.');
console.log('Or add content that uses these tags before including them in the tag index.\n');
