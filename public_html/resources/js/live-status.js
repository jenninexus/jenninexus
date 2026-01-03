/**
 * Live Status Detection for JenniNexus
 * Checks Twitch and YouTube for live streams
 */

(function() {
  'use strict';

  const TWITCH_USERNAME = 'jenninexus';
  const CHECK_INTERVAL = 60000; // Check every 60 seconds when on /live page

  /**
   * Check if JenniNexus is live on Twitch
   */
  async function checkTwitchLive() {
    try {
      const response = await fetch(`https://decapi.me/twitch/uptime/${TWITCH_USERNAME}`);
      const uptime = await response.text();
      
      // DecAPI returns stream uptime if live, or error message if offline
      const isLive = !uptime.toLowerCase().includes('offline') && 
                     !uptime.toLowerCase().includes('error') &&
                     uptime.trim().length > 0;
      
      return {
        platform: 'twitch',
        isLive: isLive,
        uptime: isLive ? uptime : null,
        url: 'https://twitch.tv/jenninexus'
      };
    } catch (error) {
      console.warn('Twitch live check failed:', error);
      return { platform: 'twitch', isLive: false };
    }
  }

  /**
   * Check if a YouTube channel is live via RSS feed
   * YouTube RSS shows recent uploads; live streams appear as recent videos
   */
  async function checkYouTubeLive(channelId, channelName) {
    try {
      const rssUrl = `https://www.youtube.com/feeds/videos.xml?channel_id=${channelId}`;
      const response = await fetch(`https://api.rss2json.com/v1/api.json?rss_url=${encodeURIComponent(rssUrl)}`);
      const data = await response.json();
      
      if (!data.items || data.items.length === 0) {
        return { platform: 'youtube', channel: channelName, isLive: false };
      }

      // Check if most recent video is a live stream (uploaded very recently)
      const mostRecent = data.items[0];
      const uploadTime = new Date(mostRecent.pubDate);
      const now = new Date();
      const minutesAgo = (now - uploadTime) / 1000 / 60;

      // If uploaded in last 15 minutes, likely live or just finished
      const isLive = minutesAgo < 15;

      return {
        platform: 'youtube',
        channel: channelName,
        isLive: isLive,
        title: mostRecent.title,
        url: `https://www.youtube.com/@${channelName}/live`,
        thumbnail: mostRecent.thumbnail
      };
    } catch (error) {
      console.warn(`YouTube live check failed for ${channelName}:`, error);
      return { platform: 'youtube', channel: channelName, isLive: false };
    }
  }

  /**
   * Update UI with live status
   */
  function updateLiveStatus(statuses) {
    const liveIndicator = document.getElementById('live-status-indicator');
    if (!liveIndicator) return;

    const activeLive = statuses.filter(s => s.isLive);

    if (activeLive.length > 0) {
      // Show live badge
      liveIndicator.classList.remove('d-none');
      
      const liveInfo = activeLive[0]; // Show first live stream
      const platformName = liveInfo.platform === 'twitch' ? 'Twitch' : `YouTube (${liveInfo.channel})`;
      
      liveIndicator.innerHTML = `
        <a href="${liveInfo.url}" target="_blank" class="btn btn-danger btn-lg pulse-animation">
          <i class="bi bi-broadcast me-2"></i>
          <strong>LIVE NOW</strong> on ${platformName}
        </a>
      `;

      // Update hero background for live status
      const hero = document.querySelector('.live-hero');
      if (hero) {
        if (liveInfo.platform === 'twitch') {
          hero.style.background = 'linear-gradient(135deg, #9146ff 0%, #772ce8 100%)';
        } else {
          hero.style.background = 'linear-gradient(135deg, #ff0000 0%, #c4302b 100%)';
        }
      }
    } else {
      // Hide live badge if not live
      liveIndicator.classList.add('d-none');
    }
  }

  /**
   * Check all platforms for live status
   */
  async function checkAllPlatforms() {
    const statuses = await Promise.all([
      checkTwitchLive(),
      checkYouTubeLive('UCu1S6_Gza2Y06pT1n5U_L4Q', 'JenniNexus'),
      checkYouTubeLive('UCk2SWSg1fvdZGnrN0XAt6NQ', 'DIYwJenni')
    ]);

    updateLiveStatus(statuses);
    return statuses;
  }

  /**
   * Initialize live status checking
   */
  function initLiveStatus() {
    // Only run on /live page or if live indicator exists
    const onLivePage = window.location.pathname.includes('live');
    const hasIndicator = document.getElementById('live-status-indicator');

    if (onLivePage || hasIndicator) {
      // Initial check
      checkAllPlatforms();

      // Periodic checks (every 60 seconds)
      if (onLivePage) {
        setInterval(checkAllPlatforms, CHECK_INTERVAL);
      }
    }
  }

  // Initialize on DOM ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLiveStatus);
  } else {
    initLiveStatus();
  }

  // Export for manual triggering
  window.checkLiveStatus = checkAllPlatforms;
})();
