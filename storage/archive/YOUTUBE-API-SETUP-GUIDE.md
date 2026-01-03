# 🎬 YouTube API Credentials Setup Guide

## Current Status

✅ **API Key Added:** `AIzaSyCOj_-MrezshnV3dPyUvLr--8_3Xs9_JLg`  
⏳ **Client ID:** Needed (for OAuth authentication)  
⏳ **Client Secret:** Needed (for OAuth authentication)

---

## Do You Need Client ID & Client Secret?

### ✅ API Key ONLY (What You Have Now)
**Good for:**
- ✅ Reading public playlist data
- ✅ Displaying videos from playlists
- ✅ Getting video thumbnails, titles, descriptions
- ✅ Fetching view counts, like counts (public data)
- ✅ Most of what JenniNexus needs!

**Your current API key is sufficient for:**
- All the playlist grids (gamedev, diy, gaming, music)
- YouTube embeds on all pages
- Public video data display

### 🔐 Client ID & Secret (OAuth Credentials)
**Only needed for:**
- ❌ Uploading videos programmatically
- ❌ Managing playlists (create/delete/reorder)
- ❌ Accessing private videos
- ❌ Posting comments on behalf of users
- ❌ Accessing channel analytics

**For JenniNexus:** You probably **DON'T need** OAuth credentials unless you're building features to upload/manage videos from your website.

---

## Decision: Which Do You Need?

### Option 1: ✅ Use API Key Only (Recommended)

**If you just want to:**
- Display playlist videos on your pages
- Show video thumbnails and metadata
- Embed YouTube players
- **You're DONE! No Client ID/Secret needed.**

**Action:** Skip to "Testing Your API Key" section below.

---

### Option 2: Get OAuth Credentials (Advanced Features)

**Only if you need to:**
- Upload videos from your website
- Programmatically manage playlists
- Access private content

**Follow the guide below.**

---

## How to Get YouTube Client ID & Client Secret

### Step 1: Go to Google Cloud Console

1. Open: https://console.cloud.google.com/
2. Sign in with your Google account (same one as your YouTube channel)

### Step 2: Select or Create a Project

**If you already have a project** (the one with the API key):
- Click the project dropdown at the top
- Select your existing project

**If you need a new project:**
- Click "Select a project" → "New Project"
- Name: "JenniNexus YouTube API"
- Click "Create"

### Step 3: Enable YouTube Data API v3

1. In the left sidebar: **APIs & Services** → **Library**
2. Search for: **"YouTube Data API v3"**
3. Click on it
4. Click **"Enable"** (if not already enabled)

### Step 4: Create OAuth 2.0 Credentials

1. In the left sidebar: **APIs & Services** → **Credentials**
2. Click **"+ CREATE CREDENTIALS"** at the top
3. Select **"OAuth client ID"**

#### Configure OAuth Consent Screen (First Time Only)

If prompted to configure the consent screen:

1. Click **"Configure Consent Screen"**
2. Choose **"External"** (or Internal if Google Workspace)
3. Click **"Create"**

**Fill in OAuth Consent Screen:**
- **App name:** JenniNexus
- **User support email:** Your email
- **Developer contact:** Your email
- **Scopes:** Leave default for now
- Click **"Save and Continue"** through all steps

#### Create OAuth Client ID

1. Back to **Credentials** → **"+ CREATE CREDENTIALS"** → **"OAuth client ID"**
2. **Application type:** Choose one:
   - **Web application** (if uploading from website)
   - **Desktop app** (if using scripts/tools locally)

**For Web Application:**
- **Name:** JenniNexus Website
- **Authorized JavaScript origins:**
  ```
  http://localhost:8002
  https://jenninexus.com
  ```
- **Authorized redirect URIs:**
  ```
  http://localhost:8002/auth/callback
  https://jenninexus.com/auth/callback
  ```

3. Click **"Create"**

### Step 5: Copy Your Credentials

A modal will appear with:
- ✅ **Client ID** (looks like: `123456789-abcdefg.apps.googleusercontent.com`)
- ✅ **Client Secret** (looks like: `GOCSPX-ABC123xyz...`)

**Copy both values** and paste them into `secrets.json`:

```json
{
  "YOUTUBE_API_KEY": "AIzaSyCOj_-MrezshnV3dPyUvLr--8_3Xs9_JLg",
  "YOUTUBE_CLIENT_ID": "123456789-abcdefg.apps.googleusercontent.com",
  "YOUTUBE_CLIENT_SECRET": "GOCSPX-ABC123xyz..."
}
```

---

## Testing Your API Key

Let's verify your API key works for playlist data:

### Test 1: Simple API Call

Open this URL in your browser (replace with your actual playlist ID):

```
https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=10&playlistId=PL9QBjNDhgNwRsznW8e3-KVmwfEuwvr7Yi&key=AIzaSyCOj_-MrezshnV3dPyUvLr--8_3Xs9_JLg
```

**Expected Result:** JSON data with video information from that playlist

**If you see JSON data:** ✅ Your API key is working!  
**If you see an error:** ❌ Check the error message

### Test 2: Using JavaScript (In Browser Console)

```javascript
// Test your YouTube API Key
const API_KEY = 'AIzaSyCOj_-MrezshnV3dPyUvLr--8_3Xs9_JLg';
const PLAYLIST_ID = 'PL9QBjNDhgNwRsznW8e3-KVmwfEuwvr7Yi'; // Devlogs playlist

fetch(`https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=10&playlistId=${PLAYLIST_ID}&key=${API_KEY}`)
  .then(response => response.json())
  .then(data => {
    console.log('✅ API Key works!');
    console.log('Videos found:', data.items?.length);
    console.table(data.items?.map(item => ({
      title: item.snippet.title,
      videoId: item.snippet.resourceId.videoId
    })));
  })
  .catch(error => console.error('❌ Error:', error));
```

---

## Quota Limits

**Free Tier YouTube API Quota:** 10,000 units per day

**Typical Costs:**
- **Playlist read:** 1 unit
- **Video details:** 1 unit
- **Search:** 100 units

**For JenniNexus:**
- Loading 10 playlists × 6 videos each = ~60 units
- With caching, you can serve thousands of page views per day

**Recommendation:** Implement caching to reduce API calls:
```javascript
// Cache playlist data for 1 hour
const CACHE_DURATION = 60 * 60 * 1000; // 1 hour in ms
```

---

## Common API Errors

### Error: "The request cannot be completed because you have exceeded your quota"
**Solution:** Wait until quota resets (midnight Pacific Time) or enable billing

### Error: "API key not valid"
**Solution:** 
1. Check if API key is copied correctly (no spaces)
2. Verify YouTube Data API v3 is enabled
3. Check API key restrictions (if any)

### Error: "Access Not Configured"
**Solution:** Enable YouTube Data API v3 in Google Cloud Console

---

## Security Best Practices

### ✅ API Key (Current)
- ✅ Already in `secrets.json` (excluded from git)
- ✅ Not exposed in client-side code
- ✅ Loaded server-side or build-time only

### 🔐 Client ID & Secret (If You Get Them)
- ✅ Keep in `secrets.json` (never commit to git)
- ✅ Never expose Client Secret in browser
- ✅ Use server-side OAuth flow only
- ✅ Rotate credentials if compromised

### Verify `.gitignore` Excludes Secrets
```bash
# Check if secrets.json is ignored
git check-ignore src/assets/secrets.json
# Should output: src/assets/secrets.json

# If not, add to .gitignore:
echo "src/assets/secrets.json" >> .gitignore
echo "public_html/resources/secrets.json" >> .gitignore
```

---

## Recommended Next Steps

### If You Only Need Public Playlist Data (Most Likely)

1. ✅ **You're done!** Your API key is sufficient
2. 🔨 Test the API key using the tests above
3. 🔨 Build the gamedev.html page
4. 🔨 Update youtube-grid.js to use the API key
5. 🎉 Deploy and test all playlist grids

### If You Need OAuth (Advanced Features)

1. 📋 Follow "How to Get YouTube Client ID & Client Secret" above
2. 🔐 Update `secrets.json` with Client ID and Secret
3. 💻 Implement OAuth flow in your application
4. ✅ Test authentication and authorized requests

---

## Resources

- **Google Cloud Console:** https://console.cloud.google.com/
- **YouTube Data API Docs:** https://developers.google.com/youtube/v3
- **API Explorer:** https://developers.google.com/youtube/v3/docs/playlistItems/list
- **Quota Calculator:** https://developers.google.com/youtube/v3/determine_quota_cost

---

## Questions?

**Q: Do I really need Client ID/Secret?**  
A: Probably not! If you're just displaying playlist videos, the API key is all you need.

**Q: How do I know if my API key is working?**  
A: Use Test 1 or Test 2 above to verify.

**Q: What if I hit quota limits?**  
A: Implement caching (1-hour cache recommended) and consider enabling billing for higher limits.

**Q: Is my API key secure in the code?**  
A: Yes, as long as it's in `secrets.json` and that file is in `.gitignore`. Never hardcode it in HTML/JS files.

---

**Summary:** Your API key (`AIzaSyCOj_-MrezshnV3dPyUvLr--8_3Xs9_JLg`) is ready to use! Test it with the methods above, and you can start building the playlist grids. OAuth credentials are only needed for advanced features like uploading videos or managing playlists programmatically.
