<?php
/**
 * GitHub Theme Updater
 *
 * Automatically check for theme updates from GitHub releases
 * and enable one-click updates from WordPress admin.
 *
 * @package FitLife_Pro
 * @version 2.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * FitLife_GitHub_Updater Class
 *
 * Handles automatic theme updates from GitHub releases
 */
class FitLife_GitHub_Updater {

    /**
     * GitHub username
     *
     * @var string
     */
    private $username;

    /**
     * GitHub repository name
     *
     * @var string
     */
    private $repository;

    /**
     * GitHub personal access token (optional, for private repos or rate limiting)
     *
     * @var string
     */
    private $access_token;

    /**
     * Theme slug
     *
     * @var string
     */
    private $theme_slug;

    /**
     * Current theme version
     *
     * @var string
     */
    private $version;

    /**
     * Transient cache key
     *
     * @var string
     */
    private $cache_key;

    /**
     * Cache expiration (12 hours)
     *
     * @var int
     */
    private $cache_expiration = 43200;

    /**
     * Constructor
     *
     * @param string $username GitHub username
     * @param string $repository GitHub repository name
     * @param string $access_token GitHub personal access token (optional)
     */
    public function __construct($username, $repository, $access_token = '') {
        $this->username = $username;
        $this->repository = $repository;
        $this->access_token = $access_token;

        // Get theme data
        $theme = wp_get_theme();
        $this->theme_slug = $theme->get_template();
        $this->version = $theme->get('Version');
        $this->cache_key = 'fitlife_github_update_' . md5($this->theme_slug);

        // Initialize hooks
        $this->init_hooks();
    }

    /**
     * Initialize WordPress hooks
     */
    private function init_hooks() {
        // Check for updates
        add_filter('pre_set_site_transient_update_themes', array($this, 'check_update'));

        // Provide update details
        add_filter('themes_api', array($this, 'theme_info'), 20, 3);

        // After update actions
        add_action('upgrader_process_complete', array($this, 'after_update'), 10, 2);

        // Add settings link
        add_action('admin_menu', array($this, 'add_settings_page'));

        // Register settings
        add_action('admin_init', array($this, 'register_settings'));

        // Clear cache on demand
        if (isset($_GET['fitlife_clear_update_cache'])) {
            $this->delete_cached_data();
            wp_redirect(admin_url('themes.php'));
            exit;
        }
    }

    /**
     * Get latest release from GitHub
     *
     * @return object|false Release data or false on failure
     */
    private function get_latest_release() {
        // Check cache first
        $cached = get_transient($this->cache_key);
        if ($cached !== false) {
            return $cached;
        }

        // GitHub API URL
        $api_url = sprintf(
            'https://api.github.com/repos/%s/%s/releases/latest',
            $this->username,
            $this->repository
        );

        // Prepare request arguments
        $args = array(
            'timeout' => 15,
            'headers' => array(
                'Accept' => 'application/vnd.github.v3+json',
                'User-Agent' => 'WordPress-Theme-Updater',
            ),
        );

        // Add authorization header if token is provided
        if (!empty($this->access_token)) {
            $args['headers']['Authorization'] = 'token ' . $this->access_token;
        }

        // Make API request
        $response = wp_remote_get($api_url, $args);

        // Check for errors
        if (is_wp_error($response)) {
            error_log('GitHub Updater Error: ' . $response->get_error_message());
            return false;
        }

        // Parse response
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body);

        // Check if we got valid data
        if (!isset($data->tag_name)) {
            error_log('GitHub Updater Error: Invalid response from GitHub API');
            return false;
        }

        // Cache the result
        set_transient($this->cache_key, $data, $this->cache_expiration);

        return $data;
    }

    /**
     * Check for theme updates
     *
     * @param object $transient Update transient
     * @return object Modified transient
     */
    public function check_update($transient) {
        if (empty($transient->checked)) {
            return $transient;
        }

        // Get latest release
        $release = $this->get_latest_release();

        if ($release === false) {
            return $transient;
        }

        // Extract version number (remove 'v' prefix if present)
        $latest_version = ltrim($release->tag_name, 'v');

        // Compare versions
        if (version_compare($this->version, $latest_version, '<')) {
            // Find the zip asset
            $download_url = $this->get_download_url($release);

            if ($download_url) {
                $transient->response[$this->theme_slug] = array(
                    'theme' => $this->theme_slug,
                    'new_version' => $latest_version,
                    'url' => $release->html_url,
                    'package' => $download_url,
                );
            }
        }

        return $transient;
    }

    /**
     * Get download URL from release assets
     *
     * @param object $release Release data
     * @return string|false Download URL or false if not found
     */
    private function get_download_url($release) {
        // First, try to find a .zip asset
        if (isset($release->assets) && is_array($release->assets)) {
            foreach ($release->assets as $asset) {
                if (strpos($asset->name, '.zip') !== false) {
                    return $asset->browser_download_url;
                }
            }
        }

        // Fallback to zipball_url (automatic GitHub archive)
        if (isset($release->zipball_url)) {
            return $release->zipball_url;
        }

        return false;
    }

    /**
     * Provide theme information for update screen
     *
     * @param false|object|array $result The result object or array
     * @param string $action The type of information being requested
     * @param object $args Plugin API arguments
     * @return object Modified result
     */
    public function theme_info($result, $action, $args) {
        // Only proceed for theme_information action
        if ($action !== 'theme_information') {
            return $result;
        }

        // Only for our theme
        if ($args->slug !== $this->theme_slug) {
            return $result;
        }

        // Get latest release
        $release = $this->get_latest_release();

        if ($release === false) {
            return $result;
        }

        // Build theme info object
        $result = new stdClass();
        $result->name = get_option('fitlife_theme_name', 'FitLife Pro');
        $result->slug = $this->theme_slug;
        $result->version = ltrim($release->tag_name, 'v');
        $result->author = sprintf(
            '<a href="https://github.com/%s">%s</a>',
            $this->username,
            $this->username
        );
        $result->homepage = sprintf(
            'https://github.com/%s/%s',
            $this->username,
            $this->repository
        );
        $result->download_link = $this->get_download_url($release);
        $result->sections = array(
            'description' => $this->parse_markdown($release->body),
            'changelog' => $this->parse_markdown($release->body),
        );

        // Add requires/tested up to (if available in release notes)
        $result->requires = '5.8';
        $result->tested = '6.4';
        $result->requires_php = '7.4';

        return $result;
    }

    /**
     * Parse markdown to HTML (basic)
     *
     * @param string $markdown Markdown text
     * @return string HTML
     */
    private function parse_markdown($markdown) {
        if (empty($markdown)) {
            return '<p>No release notes available.</p>';
        }

        // Basic markdown parsing
        $html = $markdown;

        // Headers
        $html = preg_replace('/^### (.*?)$/m', '<h3>$1</h3>', $html);
        $html = preg_replace('/^## (.*?)$/m', '<h2>$1</h2>', $html);
        $html = preg_replace('/^# (.*?)$/m', '<h1>$1</h1>', $html);

        // Bold and italic
        $html = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $html);
        $html = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $html);

        // Lists
        $html = preg_replace('/^- (.*?)$/m', '<li>$1</li>', $html);
        $html = preg_replace('/(<li>.*?<\/li>\s*)+/', '<ul>$0</ul>', $html);

        // Line breaks
        $html = nl2br($html);

        // Wrap in paragraph
        $html = '<div class="github-release-notes">' . $html . '</div>';

        return $html;
    }

    /**
     * Actions after update is complete
     *
     * @param WP_Upgrader $upgrader Upgrader instance
     * @param array $options Update options
     */
    public function after_update($upgrader, $options) {
        // Only for theme updates
        if ($options['type'] !== 'theme') {
            return;
        }

        // Only for our theme
        if (!isset($options['themes']) || !in_array($this->theme_slug, $options['themes'])) {
            return;
        }

        // Clear cached data
        $this->delete_cached_data();

        // Log update
        error_log(sprintf(
            'FitLife Pro theme updated to version %s from GitHub',
            $this->version
        ));
    }

    /**
     * Delete cached GitHub data
     */
    public function delete_cached_data() {
        delete_transient($this->cache_key);
    }

    /**
     * Add settings page
     */
    public function add_settings_page() {
        add_theme_page(
            __('GitHub Updater Settings', 'fitlife-pro'),
            __('GitHub Updates', 'fitlife-pro'),
            'manage_options',
            'fitlife-github-updater',
            array($this, 'settings_page_html')
        );
    }

    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('fitlife_github_updater', 'fitlife_github_username');
        register_setting('fitlife_github_updater', 'fitlife_github_repository');
        register_setting('fitlife_github_updater', 'fitlife_github_token');
        register_setting('fitlife_github_updater', 'fitlife_theme_name');
    }

    /**
     * Settings page HTML
     */
    public function settings_page_html() {
        if (!current_user_can('manage_options')) {
            return;
        }

        // Get latest release for display
        $release = $this->get_latest_release();
        $latest_version = $release ? ltrim($release->tag_name, 'v') : 'Unknown';
        $update_available = $release && version_compare($this->version, $latest_version, '<');

        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

            <div class="card" style="max-width: 800px;">
                <h2><?php _e('Update Status', 'fitlife-pro'); ?></h2>
                <table class="form-table">
                    <tr>
                        <th><?php _e('Current Version:', 'fitlife-pro'); ?></th>
                        <td><strong><?php echo esc_html($this->version); ?></strong></td>
                    </tr>
                    <tr>
                        <th><?php _e('Latest Version:', 'fitlife-pro'); ?></th>
                        <td>
                            <strong><?php echo esc_html($latest_version); ?></strong>
                            <?php if ($update_available) : ?>
                                <span class="dashicons dashicons-warning" style="color: #d63638;"></span>
                                <span style="color: #d63638;"><?php _e('Update available!', 'fitlife-pro'); ?></span>
                            <?php else : ?>
                                <span class="dashicons dashicons-yes-alt" style="color: #00a32a;"></span>
                                <span style="color: #00a32a;"><?php _e('Up to date', 'fitlife-pro'); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Repository:', 'fitlife-pro'); ?></th>
                        <td>
                            <a href="https://github.com/<?php echo esc_attr($this->username . '/' . $this->repository); ?>" target="_blank">
                                <?php echo esc_html($this->username . '/' . $this->repository); ?>
                            </a>
                        </td>
                    </tr>
                </table>

                <p>
                    <a href="<?php echo admin_url('themes.php?fitlife_clear_update_cache=1'); ?>" class="button">
                        <?php _e('Check for Updates Now', 'fitlife-pro'); ?>
                    </a>

                    <?php if ($update_available) : ?>
                        <a href="<?php echo admin_url('update-core.php'); ?>" class="button button-primary">
                            <?php _e('Go to Updates', 'fitlife-pro'); ?>
                        </a>
                    <?php endif; ?>
                </p>
            </div>

            <form method="post" action="options.php" style="max-width: 800px;">
                <?php
                settings_fields('fitlife_github_updater');
                ?>

                <h2><?php _e('GitHub Settings', 'fitlife-pro'); ?></h2>

                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="fitlife_github_username"><?php _e('GitHub Username', 'fitlife-pro'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="fitlife_github_username" name="fitlife_github_username"
                                   value="<?php echo esc_attr(get_option('fitlife_github_username', $this->username)); ?>"
                                   class="regular-text" />
                            <p class="description">
                                <?php _e('Your GitHub username or organization name', 'fitlife-pro'); ?>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="fitlife_github_repository"><?php _e('Repository Name', 'fitlife-pro'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="fitlife_github_repository" name="fitlife_github_repository"
                                   value="<?php echo esc_attr(get_option('fitlife_github_repository', $this->repository)); ?>"
                                   class="regular-text" />
                            <p class="description">
                                <?php _e('The name of your GitHub repository', 'fitlife-pro'); ?>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="fitlife_github_token"><?php _e('Personal Access Token', 'fitlife-pro'); ?></label>
                        </th>
                        <td>
                            <input type="password" id="fitlife_github_token" name="fitlife_github_token"
                                   value="<?php echo esc_attr(get_option('fitlife_github_token', '')); ?>"
                                   class="regular-text" autocomplete="off" />
                            <p class="description">
                                <?php _e('Optional. Required for private repositories or to avoid rate limiting.', 'fitlife-pro'); ?>
                                <br>
                                <a href="https://github.com/settings/tokens" target="_blank">
                                    <?php _e('Create a token on GitHub', 'fitlife-pro'); ?>
                                </a>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">
                            <label for="fitlife_theme_name"><?php _e('Theme Name', 'fitlife-pro'); ?></label>
                        </th>
                        <td>
                            <input type="text" id="fitlife_theme_name" name="fitlife_theme_name"
                                   value="<?php echo esc_attr(get_option('fitlife_theme_name', 'FitLife Pro')); ?>"
                                   class="regular-text" />
                            <p class="description">
                                <?php _e('Display name for the theme', 'fitlife-pro'); ?>
                            </p>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>

            <div class="card" style="max-width: 800px;">
                <h2><?php _e('How It Works', 'fitlife-pro'); ?></h2>
                <ol>
                    <li><?php _e('The updater checks GitHub releases for new versions', 'fitlife-pro'); ?></li>
                    <li><?php _e('When a new release is detected, an update notification appears in WordPress', 'fitlife-pro'); ?></li>
                    <li><?php _e('Click "Update Now" to automatically download and install the latest version', 'fitlife-pro'); ?></li>
                    <li><?php _e('Updates are cached for 12 hours to reduce API calls', 'fitlife-pro'); ?></li>
                </ol>

                <h3><?php _e('Creating Releases', 'fitlife-pro'); ?></h3>
                <p><?php _e('To create a new release on GitHub:', 'fitlife-pro'); ?></p>
                <ol>
                    <li><?php _e('Go to your repository on GitHub', 'fitlife-pro'); ?></li>
                    <li><?php _e('Click "Releases" → "Create a new release"', 'fitlife-pro'); ?></li>
                    <li><?php _e('Tag version: v2.0.0 (must start with "v")', 'fitlife-pro'); ?></li>
                    <li><?php _e('Upload a .zip file of your theme (or GitHub will create one automatically)', 'fitlife-pro'); ?></li>
                    <li><?php _e('Publish the release', 'fitlife-pro'); ?></li>
                </ol>

                <h3><?php _e('Troubleshooting', 'fitlife-pro'); ?></h3>
                <ul>
                    <li><strong><?php _e('Update not showing?', 'fitlife-pro'); ?></strong> <?php _e('Click "Check for Updates Now" to clear cache', 'fitlife-pro'); ?></li>
                    <li><strong><?php _e('Rate limiting?', 'fitlife-pro'); ?></strong> <?php _e('Add a GitHub Personal Access Token', 'fitlife-pro'); ?></li>
                    <li><strong><?php _e('Private repository?', 'fitlife-pro'); ?></strong> <?php _e('Personal Access Token is required', 'fitlife-pro'); ?></li>
                </ul>
            </div>
        </div>

        <style>
            .card {
                background: #fff;
                border: 1px solid #ccd0d4;
                border-radius: 4px;
                padding: 20px;
                margin-top: 20px;
                box-shadow: 0 1px 1px rgba(0,0,0,.04);
            }

            .card h2 {
                margin-top: 0;
            }

            .card ul, .card ol {
                margin-left: 20px;
            }

            .card li {
                margin-bottom: 8px;
            }
        </style>
        <?php
    }
}
