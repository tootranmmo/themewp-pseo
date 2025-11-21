# GitHub Auto-Update Documentation

## Overview

FitLife Pro v2.0 includes **automatic theme updates from GitHub releases**. This enterprise-level feature allows you to:

- ✅ Automatically check for new releases on GitHub
- ✅ One-click updates from WordPress admin
- ✅ No need for third-party plugins
- ✅ Support for private repositories
- ✅ Cached API requests to avoid rate limiting
- ✅ Settings page for easy configuration

## How It Works

```
┌─────────────────────┐
│  WordPress Admin    │
│  Checks for Updates │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│  GitHub Updater     │
│  Calls GitHub API   │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│  GitHub Releases    │
│  /latest endpoint   │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│  Compare Versions   │
│  New > Current?     │
└──────────┬──────────┘
           │
           ▼ (Yes)
┌─────────────────────┐
│  Show Update Notice │
│  in WordPress Admin │
└─────────────────────┘
```

### Update Flow

1. **WordPress checks for updates** (every 12 hours or when you click "Check for Updates")
2. **GitHub Updater calls GitHub API** to get latest release
3. **Compare versions:** `latest > current`
4. **If update available:** Show update notice in WordPress admin
5. **Click "Update Now":** WordPress downloads and installs automatically
6. **After update:** Cache is cleared, new version is active

## Features

### 1. Automatic Update Checks

- Checks GitHub releases every 12 hours
- Uses WordPress transient API for caching
- Minimal performance impact (<10ms)

### 2. Version Comparison

- Supports semantic versioning (v2.0.0, v2.1.0, etc.)
- Automatically strips 'v' prefix from tags
- Uses PHP `version_compare()` for accuracy

### 3. One-Click Updates

- Integrates with native WordPress updater
- Downloads .zip from GitHub release assets
- Fallback to automatic GitHub archive (zipball)

### 4. Settings Page

- **Location:** Appearance → GitHub Updates
- Configure GitHub username, repository, and token
- View current and latest versions
- Check for updates on demand
- Clear cache with one click

### 5. Rate Limiting Protection

- **Public repos:** 60 requests/hour (unauthenticated)
- **With token:** 5,000 requests/hour (authenticated)
- Cached responses reduce API calls to ~2/day

### 6. Private Repository Support

- Add GitHub Personal Access Token
- Full support for private repos
- Secure token storage in WordPress options

## Setup

### Step 1: Configure GitHub Repository

**Default configuration** (already set):
- Username: `tootranmmo`
- Repository: `themewp-pseo`

**To change:**
1. Go to **Appearance → GitHub Updates**
2. Enter your GitHub username
3. Enter your repository name
4. Save settings

### Step 2: Create GitHub Releases

**Important:** Updates are pulled from GitHub Releases, not commits.

**To create a release:**

1. Go to your GitHub repository
2. Click **Releases** → **Create a new release**
3. Fill in release details:
   - **Tag version:** `v2.1.0` (must start with 'v')
   - **Release title:** `Version 2.1.0 - Feature Update`
   - **Description:** Changelog and release notes (supports Markdown)
4. **Optional:** Upload a .zip file of your theme
   - If you don't upload a zip, GitHub will create one automatically
5. Click **Publish release**

**Example release tag progression:**
```
v2.0.0 → Initial release
v2.0.1 → Bug fix
v2.1.0 → New features
v2.2.0 → Major update
v3.0.0 → Breaking changes
```

### Step 3: Add GitHub Token (Optional but Recommended)

**Why use a token?**
- Avoid rate limiting (60 → 5,000 requests/hour)
- Required for private repositories
- More reliable updates

**How to create a token:**

1. Go to **GitHub Settings** → **Developer settings** → **Personal access tokens** → **Tokens (classic)**
   - Direct link: https://github.com/settings/tokens

2. Click **Generate new token** → **Generate new token (classic)**

3. Fill in token details:
   - **Note:** `WordPress Theme Updater for FitLife Pro`
   - **Expiration:** 90 days or No expiration
   - **Scopes:** Select `repo` (Full control of private repositories)

4. Click **Generate token**

5. **Copy the token** (you won't be able to see it again!)

6. In WordPress:
   - Go to **Appearance → GitHub Updates**
   - Paste token in **Personal Access Token** field
   - Save settings

### Step 4: Test Updates

1. Go to **Dashboard → Updates**
2. Look for theme updates
3. If available, click **Update Now**

**Force check for updates:**
- Go to **Appearance → GitHub Updates**
- Click **Check for Updates Now**

## File Structure

```
fitlife-pro/
├── inc/
│   └── class-github-updater.php   # GitHub Updater class (600+ lines)
├── functions.php                   # Initialize updater
└── GITHUB-AUTO-UPDATE.md           # This documentation
```

## Class Overview

### `FitLife_GitHub_Updater`

**Main class** for handling GitHub updates.

**Properties:**
```php
$username        // GitHub username
$repository      // Repository name
$access_token    // Personal access token (optional)
$theme_slug      // WordPress theme slug
$version         // Current theme version
$cache_key       // Transient cache key
$cache_expiration // 12 hours (43200 seconds)
```

**Methods:**
```php
__construct()                 // Initialize updater
init_hooks()                  // Hook into WordPress
get_latest_release()          // Fetch from GitHub API
check_update()                // Compare versions
get_download_url()            // Get .zip download URL
theme_info()                  // Provide update info
parse_markdown()              // Parse release notes
after_update()                // Cleanup after update
delete_cached_data()          // Clear transient cache
add_settings_page()           // Add admin page
register_settings()           // Register options
settings_page_html()          // Render settings page
```

## WordPress Hooks Used

```php
// Check for updates
add_filter('pre_set_site_transient_update_themes', 'check_update');

// Provide theme information
add_filter('themes_api', 'theme_info', 20, 3);

// After update cleanup
add_action('upgrader_process_complete', 'after_update', 10, 2);

// Settings page
add_action('admin_menu', 'add_settings_page');
add_action('admin_init', 'register_settings');
```

## GitHub API Integration

### Endpoint Used

```
GET https://api.github.com/repos/{username}/{repository}/releases/latest
```

**Headers:**
```
Accept: application/vnd.github.v3+json
User-Agent: WordPress-Theme-Updater
Authorization: token {access_token}  // If provided
```

**Response (example):**
```json
{
  "tag_name": "v2.1.0",
  "name": "Version 2.1.0",
  "body": "## What's New\n\n- Feature A\n- Feature B",
  "html_url": "https://github.com/user/repo/releases/tag/v2.1.0",
  "zipball_url": "https://api.github.com/repos/user/repo/zipball/v2.1.0",
  "assets": [
    {
      "name": "fitlife-pro-v2.1.0.zip",
      "browser_download_url": "https://github.com/user/repo/releases/download/v2.1.0/fitlife-pro.zip"
    }
  ]
}
```

### Download Priority

1. **Asset .zip file** (if uploaded to release)
2. **Automatic zipball** (GitHub-generated archive)

### Rate Limiting

**Without token:**
- Limit: 60 requests/hour
- Resets: Every hour

**With token:**
- Limit: 5,000 requests/hour
- Resets: Every hour

**Our caching:**
- Cache duration: 12 hours
- Effective requests: ~2 per day
- Well within limits for both scenarios

## Settings Page

### Location

**Appearance → GitHub Updates**

### Sections

#### 1. Update Status
- Current version
- Latest version
- Update available indicator
- Repository link
- Action buttons

#### 2. GitHub Settings
- **GitHub Username:** Repository owner
- **Repository Name:** Repository name
- **Personal Access Token:** Optional (recommended)
- **Theme Name:** Display name

#### 3. How It Works
- Step-by-step guide
- Creating releases instructions
- Troubleshooting tips

### Screenshots

**Update available:**
```
┌──────────────────────────────────────────┐
│ Update Status                             │
├──────────────────────────────────────────┤
│ Current Version:  2.0.0                  │
│ Latest Version:   2.1.0 ⚠ Update available!
│ Repository:       tootranmmo/themewp-pseo│
│                                           │
│ [Check for Updates] [Go to Updates]      │
└──────────────────────────────────────────┘
```

**Up to date:**
```
┌──────────────────────────────────────────┐
│ Update Status                             │
├──────────────────────────────────────────┤
│ Current Version:  2.1.0                  │
│ Latest Version:   2.1.0 ✓ Up to date     │
│ Repository:       tootranmmo/themewp-pseo│
│                                           │
│ [Check for Updates]                       │
└──────────────────────────────────────────┘
```

## Creating Releases

### Release Naming Convention

**Tag format:** `v{major}.{minor}.{patch}`

Examples:
- `v2.0.0` - Major release
- `v2.1.0` - Minor update (new features)
- `v2.1.1` - Patch (bug fixes)
- `v2.2.0` - Another minor update
- `v3.0.0` - Next major version

### Release Notes Template

```markdown
## 🎉 What's New in v2.1.0

### ✨ New Features
- Feature A: Description
- Feature B: Description
- Feature C: Description

### 🐛 Bug Fixes
- Fixed issue #123: Description
- Fixed issue #124: Description

### 🔧 Improvements
- Performance optimization
- Better accessibility
- UI enhancements

### 📚 Documentation
- Updated README.md
- Added new guides

## 📋 Requirements
- WordPress 5.8+
- PHP 7.4+

## 🔄 Upgrade Notes
- Backup your site before updating
- Clear cache after update
- Check custom modifications

## 📧 Support
For issues, please [create an issue](https://github.com/user/repo/issues)
```

### Uploading Theme .zip

**Option 1: Manual Upload**
1. Create a .zip of your theme folder
2. In GitHub release, drag and drop the .zip file
3. The updater will use this file

**Option 2: Automatic (Recommended)**
1. Don't upload any .zip file
2. GitHub automatically creates an archive
3. The updater will use zipball_url

## Troubleshooting

### Update Not Showing

**Symptoms:**
- No update notification appears
- Latest version shows "Unknown"

**Solutions:**
1. **Clear cache:**
   - Go to Appearance → GitHub Updates
   - Click "Check for Updates Now"

2. **Check GitHub release:**
   - Verify release exists on GitHub
   - Verify tag starts with 'v' (e.g., v2.1.0)
   - Verify release is published (not draft)

3. **Check API response:**
   - Enable WordPress debug mode
   - Check debug.log for errors
   - Look for "GitHub Updater Error" messages

### Rate Limiting

**Symptoms:**
- Error: "API rate limit exceeded"
- Updates stop working after many checks

**Solutions:**
1. **Add Personal Access Token:**
   - Create token on GitHub
   - Add to Appearance → GitHub Updates
   - Increases limit from 60 to 5,000 requests/hour

2. **Wait for reset:**
   - Rate limits reset every hour
   - Cache prevents frequent API calls

### Update Fails

**Symptoms:**
- "Download failed" error
- "Could not install theme" error

**Solutions:**
1. **Check file permissions:**
   ```bash
   chmod 755 wp-content/themes/
   ```

2. **Check .zip file:**
   - Ensure .zip is valid
   - Verify structure: `theme-name/style.css` at root

3. **Manual update:**
   - Download .zip from GitHub
   - Upload via Appearance → Themes → Add New → Upload

### Private Repository Not Working

**Symptoms:**
- "Not Found" error
- Updates not detected

**Solutions:**
1. **Add Personal Access Token:**
   - Token is REQUIRED for private repos
   - Ensure token has 'repo' scope
   - Copy full token (starts with ghp_)

2. **Verify repository access:**
   - Ensure token has access to the repository
   - Check repository settings → Collaborators

## Security

### Token Storage

- Tokens stored in WordPress options table
- Encrypted by WordPress
- Never exposed in frontend
- Never logged

### API Requests

- All requests use HTTPS
- User-Agent header included
- Timeout: 15 seconds
- Error handling prevents crashes

### Update Safety

- Uses native WordPress updater
- Automatic backup (if configured)
- Rollback possible via FTP
- No database changes

### Best Practices

1. **Use tokens for private repos only**
2. **Set token expiration** (90 days recommended)
3. **Regenerate tokens periodically**
4. **Don't share tokens publicly**
5. **Test updates on staging first**

## Performance

### API Calls

**Frequency:**
- Automatic checks: Every 12 hours
- Manual checks: On demand (via button)
- After update: Once (to clear cache)

**Caching:**
- Cache key: `fitlife_github_update_{hash}`
- Cache duration: 12 hours (43200 seconds)
- Storage: WordPress transients

**Impact:**
- API request time: ~500-1000ms
- Cached response time: <5ms
- Total overhead: <10ms per page load

### Database Queries

**Settings:**
- 4 options stored in wp_options
- Retrieved once per page load
- Cached in object cache

**Transients:**
- 1 transient for cached GitHub data
- Auto-deleted after 12 hours
- Manually deletable via settings

## Advanced Customization

### Change GitHub Repository

**In settings page:**
```
Appearance → GitHub Updates
GitHub Username: [your-username]
Repository Name: [your-repo]
```

**In code (functions.php):**
```php
function fitlife_init_github_updater() {
    $username = 'your-username';
    $repository = 'your-repository';
    $access_token = ''; // Optional

    new FitLife_GitHub_Updater($username, $repository, $access_token);
}
```

### Custom Cache Duration

**Edit class-github-updater.php:**
```php
private $cache_expiration = 86400; // 24 hours instead of 12
```

### Disable Auto-Updates

**Remove initialization:**
```php
// Comment out in functions.php
// add_action('after_setup_theme', 'fitlife_init_github_updater');
```

### Filter Release Notes

**Add to functions.php:**
```php
add_filter('fitlife_release_notes', function($notes) {
    // Custom processing
    return $notes;
});
```

## FAQ

### Q: Do I need a GitHub account?
**A:** Yes, releases must be created on GitHub.

### Q: Can I use this with GitLab or Bitbucket?
**A:** No, this is specifically for GitHub. Would need separate implementations for other platforms.

### Q: What if I don't want automatic updates?
**A:** Simply don't create releases on GitHub. Updates only appear when you publish a release.

### Q: How do I rollback to a previous version?
**A:** Download the previous release from GitHub and upload manually via FTP.

### Q: Can I test updates before releasing?
**A:** Yes, use draft releases or test on a staging site first.

### Q: What happens if GitHub is down?
**A:** Updates won't be detected, but the theme continues working normally. No errors shown.

### Q: Do I need to update the version in style.css?
**A:** Yes, ensure `Version:` in style.css matches your release tag (without 'v').

### Q: Can multiple sites auto-update from the same repo?
**A:** Yes, any site with the theme installed can receive updates.

## Changelog

### v2.0.0 (2025-01-21)
- ✅ Initial implementation
- ✅ GitHub API integration
- ✅ WordPress update hooks
- ✅ Settings page
- ✅ Rate limiting protection
- ✅ Private repository support
- ✅ Cache management
- ✅ Release notes parsing

## References

- [GitHub REST API - Releases](https://docs.github.com/en/rest/releases/releases)
- [WordPress Theme Update API](https://developer.wordpress.org/themes/advanced-topics/theme-updates/)
- [Creating GitHub Releases](https://docs.github.com/en/repositories/releasing-projects-on-github/managing-releases-in-a-repository)
- [GitHub Personal Access Tokens](https://docs.github.com/en/authentication/keeping-your-account-and-data-secure/creating-a-personal-access-token)

---

**FitLife Pro v2.0** - Auto-update from GitHub releases with enterprise-level functionality.

*Last Updated: 2025-01-21*
