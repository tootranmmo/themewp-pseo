<?php
/**
 * FitLife Pro Theme Functions
 *
 * @package FitLife_Pro
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Theme Constants
define('FITLIFE_VERSION', '2.0.0');
define('FITLIFE_THEME_DIR', get_template_directory());
define('FITLIFE_THEME_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function fitlife_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'fitlife-pro'),
        'footer' => __('Footer Menu', 'fitlife-pro'),
    ));

    // Add image sizes
    add_image_size('exercise-thumb', 400, 300, true);
    add_image_size('exercise-large', 800, 600, true);
    add_image_size('muscle-group-thumb', 300, 300, true);
}
add_action('after_setup_theme', 'fitlife_theme_setup');

/**
 * Enqueue Scripts and Styles
 */
function fitlife_enqueue_scripts() {
    // Google Fonts - Inter for modern typography
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap', array(), null);

    // Tailwind CSS Play CDN (JIT compiler) - Perfect for development
    // Note: For production, consider building Tailwind CSS locally with npm
    wp_enqueue_script('tailwindcss', 'https://cdn.tailwindcss.com', array(), '3.4.1', false);

    // Main stylesheet (for custom CSS on top of Tailwind)
    wp_enqueue_style('fitlife-style', get_stylesheet_uri(), array(), FITLIFE_VERSION);

    // Custom Tailwind extensions and utilities
    wp_enqueue_style('fitlife-custom', FITLIFE_THEME_URI . '/assets/css/custom.css', array(), FITLIFE_VERSION);

    // Vanilla JavaScript (no jQuery dependency for better performance)
    wp_enqueue_script('fitlife-main', FITLIFE_THEME_URI . '/assets/js/main.js', array(), FITLIFE_VERSION, true);

    // Localize script for AJAX
    wp_localize_script('fitlife-main', 'fitlife_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('fitlife_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'fitlife_enqueue_scripts');

/**
 * Add Tailwind CSS Configuration inline
 */
function fitlife_tailwind_config() {
    ?>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#FF6B35',
                            50: '#FFE8E0',
                            100: '#FFD8CC',
                            200: '#FFB8A3',
                            300: '#FF987A',
                            400: '#FF8257',
                            500: '#FF6B35',
                            600: '#FF4500',
                            700: '#CC3700',
                            800: '#992900',
                            900: '#661C00',
                        },
                        secondary: {
                            DEFAULT: '#004E89',
                            50: '#E6F1F7',
                            100: '#CCE4EF',
                            200: '#99C9DF',
                            300: '#66AECF',
                            400: '#3393BF',
                            500: '#004E89',
                            600: '#003E6E',
                            700: '#002F52',
                            800: '#001F37',
                            900: '#00101B',
                        },
                        accent: {
                            DEFAULT: '#1AA7EC',
                            50: '#E7F6FD',
                            100: '#CFEDFB',
                            200: '#9FDBF7',
                            300: '#6FC9F3',
                            400: '#3FB7EF',
                            500: '#1AA7EC',
                            600: '#1486BD',
                            700: '#0F648E',
                            800: '#0A435E',
                            900: '#05212F',
                        },
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <?php
}
add_action('wp_head', 'fitlife_tailwind_config', 5);

/**
 * Register Custom Post Type: Exercise
 */
function fitlife_register_exercise_post_type() {
    $labels = array(
        'name' => __('Exercises', 'fitlife-pro'),
        'singular_name' => __('Exercise', 'fitlife-pro'),
        'menu_name' => __('Exercises', 'fitlife-pro'),
        'add_new' => __('Add New', 'fitlife-pro'),
        'add_new_item' => __('Add New Exercise', 'fitlife-pro'),
        'edit_item' => __('Edit Exercise', 'fitlife-pro'),
        'new_item' => __('New Exercise', 'fitlife-pro'),
        'view_item' => __('View Exercise', 'fitlife-pro'),
        'search_items' => __('Search Exercises', 'fitlife-pro'),
        'not_found' => __('No exercises found', 'fitlife-pro'),
        'not_found_in_trash' => __('No exercises found in Trash', 'fitlife-pro'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'exercise'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-heart',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest' => true,
    );

    register_post_type('exercise', $args);
}
add_action('init', 'fitlife_register_exercise_post_type');

/**
 * Register Taxonomies
 */
function fitlife_register_taxonomies() {
    // Muscle Groups
    register_taxonomy('muscle_group', 'exercise', array(
        'labels' => array(
            'name' => __('Muscle Groups', 'fitlife-pro'),
            'singular_name' => __('Muscle Group', 'fitlife-pro'),
            'search_items' => __('Search Muscle Groups', 'fitlife-pro'),
            'all_items' => __('All Muscle Groups', 'fitlife-pro'),
            'edit_item' => __('Edit Muscle Group', 'fitlife-pro'),
            'update_item' => __('Update Muscle Group', 'fitlife-pro'),
            'add_new_item' => __('Add New Muscle Group', 'fitlife-pro'),
            'new_item_name' => __('New Muscle Group Name', 'fitlife-pro'),
            'menu_name' => __('Muscle Groups', 'fitlife-pro'),
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'muscle-group'),
        'show_in_rest' => true,
    ));

    // Equipment
    register_taxonomy('equipment', 'exercise', array(
        'labels' => array(
            'name' => __('Equipment', 'fitlife-pro'),
            'singular_name' => __('Equipment', 'fitlife-pro'),
            'search_items' => __('Search Equipment', 'fitlife-pro'),
            'all_items' => __('All Equipment', 'fitlife-pro'),
            'edit_item' => __('Edit Equipment', 'fitlife-pro'),
            'update_item' => __('Update Equipment', 'fitlife-pro'),
            'add_new_item' => __('Add New Equipment', 'fitlife-pro'),
            'new_item_name' => __('New Equipment Name', 'fitlife-pro'),
            'menu_name' => __('Equipment', 'fitlife-pro'),
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'equipment'),
        'show_in_rest' => true,
    ));

    // Difficulty Level
    register_taxonomy('difficulty', 'exercise', array(
        'labels' => array(
            'name' => __('Difficulty Levels', 'fitlife-pro'),
            'singular_name' => __('Difficulty Level', 'fitlife-pro'),
            'search_items' => __('Search Difficulty Levels', 'fitlife-pro'),
            'all_items' => __('All Difficulty Levels', 'fitlife-pro'),
            'edit_item' => __('Edit Difficulty Level', 'fitlife-pro'),
            'update_item' => __('Update Difficulty Level', 'fitlife-pro'),
            'add_new_item' => __('Add New Difficulty Level', 'fitlife-pro'),
            'new_item_name' => __('New Difficulty Level Name', 'fitlife-pro'),
            'menu_name' => __('Difficulty Levels', 'fitlife-pro'),
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'difficulty'),
        'show_in_rest' => true,
    ));
}
add_action('init', 'fitlife_register_taxonomies');

/**
 * Add Custom Meta Boxes for Exercise
 */
function fitlife_add_exercise_meta_boxes() {
    add_meta_box(
        'exercise_details',
        __('Exercise Details', 'fitlife-pro'),
        'fitlife_exercise_details_callback',
        'exercise',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'fitlife_add_exercise_meta_boxes');

/**
 * Meta Box Callback
 */
function fitlife_exercise_details_callback($post) {
    wp_nonce_field('fitlife_exercise_details', 'fitlife_exercise_details_nonce');

    $calories = get_post_meta($post->ID, '_exercise_calories', true);
    $duration = get_post_meta($post->ID, '_exercise_duration', true);
    $sets = get_post_meta($post->ID, '_exercise_sets', true);
    $reps = get_post_meta($post->ID, '_exercise_reps', true);
    $video_url = get_post_meta($post->ID, '_exercise_video_url', true);
    ?>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div>
            <label for="exercise_calories"><strong><?php _e('Calories Burned (per session)', 'fitlife-pro'); ?></strong></label>
            <input type="number" id="exercise_calories" name="exercise_calories" value="<?php echo esc_attr($calories); ?>" style="width: 100%; margin-top: 5px;" />
        </div>

        <div>
            <label for="exercise_duration"><strong><?php _e('Duration (minutes)', 'fitlife-pro'); ?></strong></label>
            <input type="number" id="exercise_duration" name="exercise_duration" value="<?php echo esc_attr($duration); ?>" style="width: 100%; margin-top: 5px;" />
        </div>

        <div>
            <label for="exercise_sets"><strong><?php _e('Recommended Sets', 'fitlife-pro'); ?></strong></label>
            <input type="number" id="exercise_sets" name="exercise_sets" value="<?php echo esc_attr($sets); ?>" style="width: 100%; margin-top: 5px;" />
        </div>

        <div>
            <label for="exercise_reps"><strong><?php _e('Recommended Reps', 'fitlife-pro'); ?></strong></label>
            <input type="text" id="exercise_reps" name="exercise_reps" value="<?php echo esc_attr($reps); ?>" placeholder="e.g., 10-15" style="width: 100%; margin-top: 5px;" />
        </div>

        <div style="grid-column: 1 / -1;">
            <label for="exercise_video_url"><strong><?php _e('Video Tutorial URL (YouTube, Vimeo)', 'fitlife-pro'); ?></strong></label>
            <input type="url" id="exercise_video_url" name="exercise_video_url" value="<?php echo esc_attr($video_url); ?>" style="width: 100%; margin-top: 5px;" />
        </div>
    </div>
    <?php
}

/**
 * Save Meta Box Data
 */
function fitlife_save_exercise_meta($post_id) {
    if (!isset($_POST['fitlife_exercise_details_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['fitlife_exercise_details_nonce'], 'fitlife_exercise_details')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['exercise_calories'])) {
        update_post_meta($post_id, '_exercise_calories', sanitize_text_field($_POST['exercise_calories']));
    }

    if (isset($_POST['exercise_duration'])) {
        update_post_meta($post_id, '_exercise_duration', sanitize_text_field($_POST['exercise_duration']));
    }

    if (isset($_POST['exercise_sets'])) {
        update_post_meta($post_id, '_exercise_sets', sanitize_text_field($_POST['exercise_sets']));
    }

    if (isset($_POST['exercise_reps'])) {
        update_post_meta($post_id, '_exercise_reps', sanitize_text_field($_POST['exercise_reps']));
    }

    if (isset($_POST['exercise_video_url'])) {
        update_post_meta($post_id, '_exercise_video_url', esc_url_raw($_POST['exercise_video_url']));
    }
}
add_action('save_post_exercise', 'fitlife_save_exercise_meta');

/**
 * Get Exercise Statistics
 */
function fitlife_get_stats() {
    $stats = array(
        'total_exercises' => wp_count_posts('exercise')->publish,
        'muscle_groups' => wp_count_terms('muscle_group'),
        'equipment_types' => wp_count_terms('equipment'),
        'total_calories' => 0,
    );

    // Calculate total calories
    $exercises = get_posts(array(
        'post_type' => 'exercise',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ));

    foreach ($exercises as $exercise) {
        $calories = get_post_meta($exercise->ID, '_exercise_calories', true);
        $stats['total_calories'] += intval($calories);
    }

    return $stats;
}

/**
 * AJAX Search Handler
 */
function fitlife_ajax_search_exercises() {
    check_ajax_referer('fitlife_nonce', 'nonce');

    $search = sanitize_text_field($_POST['search']);
    $muscle_group = sanitize_text_field($_POST['muscle_group']);
    $equipment = sanitize_text_field($_POST['equipment']);
    $difficulty = sanitize_text_field($_POST['difficulty']);

    $args = array(
        'post_type' => 'exercise',
        'posts_per_page' => 20,
        's' => $search,
    );

    $tax_query = array('relation' => 'AND');

    if (!empty($muscle_group)) {
        $tax_query[] = array(
            'taxonomy' => 'muscle_group',
            'field' => 'slug',
            'terms' => $muscle_group,
        );
    }

    if (!empty($equipment)) {
        $tax_query[] = array(
            'taxonomy' => 'equipment',
            'field' => 'slug',
            'terms' => $equipment,
        );
    }

    if (!empty($difficulty)) {
        $tax_query[] = array(
            'taxonomy' => 'difficulty',
            'field' => 'slug',
            'terms' => $difficulty,
        );
    }

    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }

    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content', 'exercise-card');
        }
    } else {
        echo '<p>' . __('No exercises found.', 'fitlife-pro') . '</p>';
    }
    wp_reset_postdata();

    $html = ob_get_clean();

    wp_send_json_success(array('html' => $html));
}
add_action('wp_ajax_search_exercises', 'fitlife_ajax_search_exercises');
add_action('wp_ajax_nopriv_search_exercises', 'fitlife_ajax_search_exercises');

/**
 * Widget Areas
 */
function fitlife_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar', 'fitlife-pro'),
        'id' => 'sidebar-1',
        'description' => __('Add widgets here.', 'fitlife-pro'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => __('Footer 1', 'fitlife-pro'),
        'id' => 'footer-1',
        'description' => __('Footer widget area 1', 'fitlife-pro'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer 2', 'fitlife-pro'),
        'id' => 'footer-2',
        'description' => __('Footer widget area 2', 'fitlife-pro'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer 3', 'fitlife-pro'),
        'id' => 'footer-3',
        'description' => __('Footer widget area 3', 'fitlife-pro'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'fitlife_widgets_init');

/**
 * ========================================================================
 * ENTERPRISE-LEVEL SEO: Schema.org Markup (JSON-LD)
 * ========================================================================
 * Comprehensive Schema.org implementation for maximum SEO impact
 */

/**
 * Get Organization Schema
 *
 * @return array Organization schema data
 */
function fitlife_get_organization_schema() {
    $logo = get_theme_mod('custom_logo');
    $logo_url = $logo ? wp_get_attachment_image_url($logo, 'full') : FITLIFE_THEME_URI . '/assets/images/logo.png';

    return array(
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        '@id' => home_url('/#organization'),
        'name' => get_bloginfo('name'),
        'url' => home_url('/'),
        'logo' => array(
            '@type' => 'ImageObject',
            'url' => $logo_url,
            'width' => 600,
            'height' => 60,
        ),
        'description' => get_bloginfo('description'),
        'sameAs' => array(
            // Add your social media links here
            // 'https://facebook.com/yourpage',
            // 'https://twitter.com/yourhandle',
            // 'https://instagram.com/yourhandle',
        ),
        'contactPoint' => array(
            '@type' => 'ContactPoint',
            'contactType' => 'customer service',
            'email' => get_option('admin_email'),
        ),
    );
}

/**
 * Get WebSite Schema with SearchAction
 *
 * @return array WebSite schema data
 */
function fitlife_get_website_schema() {
    return array(
        '@context' => 'https://schema.org',
        '@type' => 'WebSite',
        '@id' => home_url('/#website'),
        'url' => home_url('/'),
        'name' => get_bloginfo('name'),
        'description' => get_bloginfo('description'),
        'publisher' => array(
            '@id' => home_url('/#organization'),
        ),
        'potentialAction' => array(
            '@type' => 'SearchAction',
            'target' => array(
                '@type' => 'EntryPoint',
                'urlTemplate' => home_url('/?s={search_term_string}'),
            ),
            'query-input' => 'required name=search_term_string',
        ),
    );
}

/**
 * Get BreadcrumbList Schema
 *
 * @return array|null Breadcrumb schema data or null if not applicable
 */
function fitlife_get_breadcrumb_schema() {
    if (is_front_page()) {
        return null;
    }

    $items = array();
    $position = 1;

    // Home
    $items[] = array(
        '@type' => 'ListItem',
        'position' => $position++,
        'name' => __('Home', 'fitlife-pro'),
        'item' => home_url('/'),
    );

    // Archive pages
    if (is_post_type_archive('exercise')) {
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => __('Exercises', 'fitlife-pro'),
            'item' => get_post_type_archive_link('exercise'),
        );
    }

    // Taxonomy pages
    if (is_tax()) {
        $term = get_queried_object();
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => __('Exercises', 'fitlife-pro'),
            'item' => get_post_type_archive_link('exercise'),
        );
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => $term->name,
            'item' => get_term_link($term),
        );
    }

    // Single exercise
    if (is_singular('exercise')) {
        global $post;
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => __('Exercises', 'fitlife-pro'),
            'item' => get_post_type_archive_link('exercise'),
        );
        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    }

    // Blog posts
    if (is_single() && get_post_type() === 'post') {
        if (get_option('page_for_posts')) {
            $items[] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => get_the_title(get_option('page_for_posts')),
                'item' => get_permalink(get_option('page_for_posts')),
            );
        }

        $categories = get_the_category();
        if (!empty($categories)) {
            $items[] = array(
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $categories[0]->name,
                'item' => get_category_link($categories[0]->term_id),
            );
        }

        $items[] = array(
            '@type' => 'ListItem',
            'position' => $position++,
            'name' => get_the_title(),
            'item' => get_permalink(),
        );
    }

    if (count($items) <= 1) {
        return null;
    }

    return array(
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $items,
    );
}

/**
 * Get Exercise/Article Schema for single exercise
 *
 * @param int $post_id Post ID
 * @return array Exercise schema data
 */
function fitlife_get_exercise_schema($post_id) {
    $post = get_post($post_id);

    // Get exercise meta
    $calories = get_post_meta($post_id, '_exercise_calories', true);
    $duration = get_post_meta($post_id, '_exercise_duration', true);
    $sets = get_post_meta($post_id, '_exercise_sets', true);
    $reps = get_post_meta($post_id, '_exercise_reps', true);

    // Get taxonomies
    $muscle_groups = get_the_terms($post_id, 'muscle_group');
    $equipment = get_the_terms($post_id, 'equipment');
    $difficulty = get_the_terms($post_id, 'difficulty');

    // Get featured image
    $image_url = get_the_post_thumbnail_url($post_id, 'full');
    $image_meta = wp_get_attachment_metadata(get_post_thumbnail_id($post_id));

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'ExercisePlan',
        '@id' => get_permalink($post_id) . '#exerciseplan',
        'name' => get_the_title($post_id),
        'description' => get_the_excerpt($post_id) ?: wp_trim_words(get_the_content(null, false, $post), 30),
        'url' => get_permalink($post_id),
        'datePublished' => get_the_date('c', $post_id),
        'dateModified' => get_the_modified_date('c', $post_id),
        'author' => array(
            '@type' => 'Organization',
            '@id' => home_url('/#organization'),
        ),
        'publisher' => array(
            '@id' => home_url('/#organization'),
        ),
    );

    // Add image
    if ($image_url && $image_meta) {
        $schema['image'] = array(
            '@type' => 'ImageObject',
            'url' => $image_url,
            'width' => $image_meta['width'] ?? 1200,
            'height' => $image_meta['height'] ?? 675,
        );
    }

    // Add activity details
    if ($duration) {
        $schema['activityDuration'] = 'PT' . $duration . 'M'; // ISO 8601 duration
    }

    if ($calories) {
        $schema['estimatedCost'] = array(
            '@type' => 'MonetaryAmount',
            'value' => $calories,
            'currency' => 'CAL', // Calories as "currency"
        );
    }

    // Add exercise category
    if ($difficulty && !is_wp_error($difficulty)) {
        $schema['activityFrequency'] = $difficulty[0]->name;
    }

    // Add target muscles
    if ($muscle_groups && !is_wp_error($muscle_groups)) {
        $schema['muscleAction'] = wp_list_pluck($muscle_groups, 'name');
    }

    // Add equipment
    if ($equipment && !is_wp_error($equipment)) {
        $schema['exerciseType'] = wp_list_pluck($equipment, 'name');
    }

    return $schema;
}

/**
 * Get HowTo Schema for exercise instructions
 *
 * @param int $post_id Post ID
 * @return array|null HowTo schema data or null if no content
 */
function fitlife_get_howto_schema($post_id) {
    $content = get_post_field('post_content', $post_id);

    if (empty($content)) {
        return null;
    }

    // Extract steps from content (looking for ordered lists or numbered items)
    $steps = array();

    // Try to parse ordered list
    if (preg_match_all('/<ol>(.*?)<\/ol>/s', $content, $matches)) {
        if (preg_match_all('/<li>(.*?)<\/li>/s', $matches[1][0], $li_matches)) {
            foreach ($li_matches[1] as $index => $step_text) {
                $steps[] = array(
                    '@type' => 'HowToStep',
                    'position' => $index + 1,
                    'name' => 'Step ' . ($index + 1),
                    'text' => wp_strip_all_tags($step_text),
                );
            }
        }
    }

    // If no steps found, create generic steps from paragraphs
    if (empty($steps)) {
        $paragraphs = explode("\n\n", strip_shortcodes(wp_strip_all_tags($content)));
        $paragraphs = array_filter(array_map('trim', $paragraphs));

        foreach (array_slice($paragraphs, 0, 5) as $index => $para) {
            if (strlen($para) > 20) { // Only meaningful paragraphs
                $steps[] = array(
                    '@type' => 'HowToStep',
                    'position' => $index + 1,
                    'text' => $para,
                );
            }
        }
    }

    if (empty($steps)) {
        return null;
    }

    $duration = get_post_meta($post_id, '_exercise_duration', true);
    $image_url = get_the_post_thumbnail_url($post_id, 'full');

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'HowTo',
        '@id' => get_permalink($post_id) . '#howto',
        'name' => __('How to do ', 'fitlife-pro') . get_the_title($post_id),
        'description' => get_the_excerpt($post_id) ?: wp_trim_words(get_the_content(null, false, get_post($post_id)), 30),
        'step' => $steps,
    );

    if ($duration) {
        $schema['totalTime'] = 'PT' . $duration . 'M';
    }

    if ($image_url) {
        $schema['image'] = $image_url;
    }

    return $schema;
}

/**
 * Get CollectionPage Schema for archive pages
 *
 * @return array|null CollectionPage schema data or null if not applicable
 */
function fitlife_get_collection_schema() {
    if (!is_post_type_archive('exercise') && !is_tax()) {
        return null;
    }

    global $wp_query;

    $schema = array(
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => is_tax() ? single_term_title('', false) : __('All Exercises', 'fitlife-pro'),
        'description' => is_tax() && term_description() ? strip_tags(term_description()) : __('Browse our complete exercise database', 'fitlife-pro'),
        'url' => is_tax() ? get_term_link(get_queried_object()) : get_post_type_archive_link('exercise'),
        'numberOfItems' => $wp_query->found_posts,
        'isPartOf' => array(
            '@id' => home_url('/#website'),
        ),
    );

    // Add main entity
    if ($wp_query->have_posts()) {
        $items = array();
        $posts = $wp_query->posts;

        foreach (array_slice($posts, 0, 10) as $post) { // First 10 items
            $items[] = array(
                '@type' => 'ListItem',
                'url' => get_permalink($post->ID),
                'name' => get_the_title($post->ID),
            );
        }

        if (!empty($items)) {
            $schema['mainEntity'] = array(
                '@type' => 'ItemList',
                'itemListElement' => $items,
            );
        }
    }

    return $schema;
}

/**
 * Output Schema.org JSON-LD
 *
 * @param array $schema Schema data
 */
function fitlife_output_schema($schema) {
    if (empty($schema)) {
        return;
    }

    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    echo "\n" . '</script>' . "\n";
}

/**
 * Output all applicable Schema.org markup in <head>
 */
function fitlife_output_schema_markup() {
    // Always output Organization and WebSite schemas
    fitlife_output_schema(fitlife_get_organization_schema());
    fitlife_output_schema(fitlife_get_website_schema());

    // Breadcrumbs (all pages except homepage)
    $breadcrumb = fitlife_get_breadcrumb_schema();
    if ($breadcrumb) {
        fitlife_output_schema($breadcrumb);
    }

    // Single Exercise page
    if (is_singular('exercise')) {
        global $post;
        fitlife_output_schema(fitlife_get_exercise_schema($post->ID));

        // HowTo schema for instructions
        $howto = fitlife_get_howto_schema($post->ID);
        if ($howto) {
            fitlife_output_schema($howto);
        }
    }

    // Archive/Collection pages
    $collection = fitlife_get_collection_schema();
    if ($collection) {
        fitlife_output_schema($collection);
    }
}
add_action('wp_head', 'fitlife_output_schema_markup', 1);

/**
 * ========================================================================
 * GITHUB AUTO-UPDATE FUNCTIONALITY
 * ========================================================================
 * Automatic theme updates from GitHub releases
 */

// Load GitHub Updater class
require_once FITLIFE_THEME_DIR . '/inc/class-github-updater.php';

/**
 * Initialize GitHub Updater
 *
 * Configure these values for your repository
 */
function fitlife_init_github_updater() {
    // Get settings from options (with defaults)
    $username = get_option('fitlife_github_username', 'tootranmmo'); // Change to your GitHub username
    $repository = get_option('fitlife_github_repository', 'themewp-pseo'); // Change to your repository name
    $access_token = get_option('fitlife_github_token', ''); // Optional: add GitHub personal access token

    // Initialize updater
    if (class_exists('FitLife_GitHub_Updater')) {
        new FitLife_GitHub_Updater($username, $repository, $access_token);
    }
}
add_action('after_setup_theme', 'fitlife_init_github_updater');
