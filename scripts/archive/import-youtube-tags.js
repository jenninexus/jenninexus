#!/usr/bin/env node
/**
 * Simple YouTube tag importer (RSS-first)
 * - Reads public_html/resources/playlists/playlist-ids.json to discover playlists/channels
 * - Uses RSS feeds (feeds/videos.xml) to collect recent video IDs
 * - Looks for local cache files under storage/cache/youtube/{videoId}.json and extracts `tags` if present
 * - Aggregates and normalizes tags and writes generated JSON outputs
 *
 * Safe defaults: no YouTube Data API calls unless --use-api is provided and YT_API_KEY present.
 */

import fs from 'fs/promises';
import path from 'path';
import { existsSync } from 'fs';
// prefer global fetch (Node 18+). If not available, try dynamic import of node-fetch.
async function fetchTextWrapper(url){
  if (typeof fetch === 'function') {
    try{ const r = await fetch(url, { timeout: 15000 }); if(!r.ok) throw new Error('Bad reply'); return await r.text(); }catch(e){ log('fetch error', url, e.message || e); return null; }
  }
  try{
    const mod = await import('node-fetch');
    const r = await mod.default(url);
    if(!r.ok) throw new Error('Bad reply');
    return await r.text();
  }catch(e){ log('fetch error (node-fetch)', url, e.message || e); return null; }
}

const ROOT = path.resolve(new URL('.', import.meta.url).pathname, '..');
const PLAYLIST_IDS_PATH = path.join(ROOT, 'public_html', 'resources', 'playlists', 'playlist-ids.json');
const OUTPUT_DIR = path.join(ROOT, 'public_html', 'resources', 'playlists');
const CACHE_DIR = path.join(ROOT, 'storage', 'cache', 'youtube');
const SECRETS_PATH = path.join(ROOT, 'public_html', 'resources', 'secrets.json');

function log(...args){ console.log('[import-youtube-tags]', ...args); }

async function readJson(p){
  try{ const s = await fs.readFile(p, 'utf8'); return JSON.parse(s); }catch(e){ return null; }
}

function normalizeTag(t){
  if(!t) return '';
  return String(t).toLowerCase().replace(/[\u2018\u2019\u201c\u201d"'`]/g, '')
    .replace(/[\s]+/g, ' ').trim()
    .replace(/[.,!?;:\/\\()\[\]{}<>]/g, '')
    .replace(/\s+/g, ' ');
}

function takeTopN(counts, n){
  const arr = Object.entries(counts).sort((a,b)=>b[1]-a[1]);
  return arr.slice(0,n).map(([tag,count])=>({ tag, count }));
}

async function fetchText(url){ return fetchTextWrapper(url); }

function extractVideoIdsFromRss(xml){
  // simple regex to pull <yt:videoId> tags
  const re = /<yt:videoId>([A-Za-z0-9_-]{5,})<\/yt:videoId>/g;
  const ids = [];
  let m;
  while((m = re.exec(xml))){ ids.push(m[1]); }
  return ids;
}

async function collectVideoIdsForPlaylist(entry, maxPerPlaylist=25){
  // entry may be an object with rss or id or rss url
  const rss = entry.rss || entry.rss_url || null;
  let feedUrl = rss;
  if(!feedUrl){
    // try playlist id
    if(entry.id) feedUrl = `https://www.youtube.com/feeds/videos.xml?playlist_id=${entry.id}`;
    else if(entry.channel && entry.channel.id) feedUrl = `https://www.youtube.com/feeds/videos.xml?channel_id=${entry.channel.id}`;
  }
  if(!feedUrl) return [];
  const xml = await fetchText(feedUrl);
  if(!xml) return [];
  const ids = extractVideoIdsFromRss(xml).slice(0, maxPerPlaylist);
  return ids;
}

async function readCachedTagsForVideo(videoId){
  const p1 = path.join(CACHE_DIR, `${videoId}.json`);
  if(!existsSync(p1)) return null;
  try{
    const j = JSON.parse(await fs.readFile(p1, 'utf8'));
    // attempt to find tags in common shapes
    if(Array.isArray(j.tags) && j.tags.length) return j.tags.map(normalizeTag).filter(Boolean);
    if(j.snippet && Array.isArray(j.snippet.tags) && j.snippet.tags.length) return j.snippet.tags.map(normalizeTag).filter(Boolean);
    return null;
  }catch(e){ return null; }
}

async function main(){
  const argv = process.argv.slice(2);
  const useApi = argv.includes('--use-api');
  const maxPerPlaylist = 25;
  const maxTags = 100;
  // load local secrets if available (do NOT commit secrets.json to git)
  let secrets = null;
  try { secrets = await readJson(SECRETS_PATH); } catch(e) { secrets = null; }
  const envApiKey = process.env.YT_API_KEY || process.env.YOUTUBE_API_KEY;
  const apiKey = (secrets && (secrets.YOUTUBE_API_KEY || secrets.YT_API_KEY)) || envApiKey || null;

  const playlists = await readJson(PLAYLIST_IDS_PATH);
  if(!playlists){ log('Could not read playlist-ids.json at', PLAYLIST_IDS_PATH); process.exit(1); }

  // playlists.playlists is the object we want
  const listObj = playlists.youtube && playlists.youtube.playlists ? playlists.youtube.playlists : {};
  const allVideoTags = {}; // videoId -> [tags]
  const tagCounts = {};

  for(const [key, entry] of Object.entries(listObj)){
    log('collecting for', key);
    const ids = await collectVideoIdsForPlaylist(entry, maxPerPlaylist);
    for(const vid of ids){
      // prefer cached tags
      let tags = await readCachedTagsForVideo(vid);
      if(!tags && useApi){
        // If API mode requested, attempt to fetch snippets via YouTube Data API (batched later)
        // We'll collect vidsMissingTags to batch-request after loop
        tags = null;
        // mark missing tags for later API fetch
        if(!globalThis.__yt_missing_vids) globalThis.__yt_missing_vids = new Set();
        globalThis.__yt_missing_vids.add(vid);
      }
      if(tags && tags.length){
        allVideoTags[vid] = tags;
        for(const t of tags){ tagCounts[t] = (tagCounts[t]||0)+1; }
      }
    }
  }

  // If API mode requested and apiKey is available, batch fetch missing video snippets
  if(useApi && apiKey && globalThis.__yt_missing_vids && globalThis.__yt_missing_vids.size > 0){
    log('Fetching missing video snippets via YouTube Data API (batched)');
    const missing = Array.from(globalThis.__yt_missing_vids);
    const BATCH = 50; // videos.list allows up to 50 ids
    for(let i=0;i<missing.length;i+=BATCH){
      const batch = missing.slice(i, i+BATCH);
      const url = `https://www.googleapis.com/youtube/v3/videos?part=snippet&id=${batch.join(',')}&key=${encodeURIComponent(apiKey)}`;
      try{
        const txt = await fetchText(url);
        if(!txt) continue;
        const j = JSON.parse(txt);
        if(Array.isArray(j.items)){
          j.items.forEach(item => {
            const vid = item.id;
            const tags = (item.snippet && Array.isArray(item.snippet.tags)) ? item.snippet.tags.map(normalizeTag).filter(Boolean) : null;
            if(tags && tags.length){
              allVideoTags[vid] = tags;
              for(const t of tags){ tagCounts[t] = (tagCounts[t]||0)+1; }
            }
          });
        }
      }catch(e){ log('API batch fetch failed', e.message || e); }
      // small delay to be gentle on quota (100ms)
      await new Promise(r => setTimeout(r, 100));
    }
  } else if (useApi && !apiKey){
    log('API mode requested but no API key found in', SECRETS_PATH, 'or env YT_API_KEY / YOUTUBE_API_KEY. Skipping API fetch.');
  }

  // pick top tags
  const top = takeTopN(tagCounts, maxTags);
  const topTags = top.map(t => ({ name: t.tag, slug: t.tag.replace(/\s+/g,'-'), count: t.count }));

  // build generated_content_tags mapping videoId -> [slugs]
  const contentTags = {};
  for(const [vid, tags] of Object.entries(allVideoTags)){
    contentTags[vid] = Array.from(new Set(tags.map(t => t.replace(/\s+/g,'-'))));
  }

  // write outputs
  const outTagsPath = path.join(OUTPUT_DIR, 'generated_tags.json');
  const outContentTagsPath = path.join(OUTPUT_DIR, 'generated_content_tags.json');

  const now = new Date().toISOString();
  await fs.writeFile(outTagsPath, JSON.stringify({ generated_at: now, source: 'rss-cache', top_tags: topTags }, null, 2), 'utf8');
  await fs.writeFile(outContentTagsPath, JSON.stringify({ generated_at: now, source: 'rss-cache', content_tags: contentTags }, null, 2), 'utf8');

  log('Wrote', outTagsPath, 'and', outContentTagsPath);
}

import { fileURLToPath } from 'url';
const __filename = fileURLToPath(import.meta.url);
if (process.argv[1] === __filename) {
  main().catch(e=>{ console.error(e); process.exit(1); });
}

export { normalizeTag, extractVideoIdsFromRss, takeTopN, collectVideoIdsForPlaylist };
