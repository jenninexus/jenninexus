import assert from 'assert/strict';
import { normalizeTag, extractVideoIdsFromRss, takeTopN } from './import-youtube-tags.js';

// test normalizeTag
assert.equal(normalizeTag('Hello World'), 'hello world');
assert.equal(normalizeTag(" C# "), 'c#');
assert.equal(normalizeTag("  indie-game!!  "), 'indie-game');

// test RSS extraction
const sampleRss = `<?xml version="1.0" encoding="UTF-8"?>
<feed xmlns:yt="http://www.youtube.com/xml/schemas/2015">
  <entry>
    <yt:videoId>abcd1234</yt:videoId>
  </entry>
  <entry>
    <yt:videoId>XYZ_987</yt:videoId>
  </entry>
</feed>`;
const ids = extractVideoIdsFromRss(sampleRss);
assert.deepEqual(ids, ['abcd1234', 'XYZ_987']);

// test takeTopN
const counts = { 'a': 5, 'b': 10, 'c': 2 };
const top = takeTopN(counts, 2);
assert.equal(top.length, 2);
assert.equal(top[0].tag, 'b');
assert.equal(top[0].count, 10);

console.log('All importer unit tests passed.');
