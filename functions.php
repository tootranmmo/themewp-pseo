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
            darkMode: 'class', // Enable dark mode with class strategy
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

    // Add AggregateRating if ratings exist
    $rating_data = fitlife_get_exercise_rating($post_id);
    if ($rating_data['count'] > 0) {
        $schema['aggregateRating'] = array(
            '@type' => 'AggregateRating',
            'ratingValue' => $rating_data['average'],
            'ratingCount' => $rating_data['count'],
            'bestRating' => 5,
            'worstRating' => 1,
        );
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
 * OPEN GRAPH & TWITTER CARDS
 * ========================================================================
 * Rich social media previews for Facebook, Twitter, LinkedIn
 */

/**
 * Output Open Graph meta tags
 */
function fitlife_output_og_tags() {
    // Site name
    $site_name = get_bloginfo('name');
    $site_description = get_bloginfo('description');

    // Default values
    $og_title = $site_name;
    $og_description = $site_description;
    $og_type = 'website';
    $og_url = home_url('/');
    $og_image = FITLIFE_THEME_URI . '/screenshot.png'; // Default fallback
    $og_image_width = 1200;
    $og_image_height = 630;

    // Page-specific overrides
    if (is_singular()) {
        global $post;

        // Title
        $og_title = get_the_title();

        // Description
        if (has_excerpt()) {
            $og_description = get_the_excerpt();
        } else {
            $og_description = wp_trim_words(strip_tags($post->post_content), 30, '...');
        }

        // URL
        $og_url = get_permalink();

        // Type
        $og_type = is_singular('exercise') ? 'article' : 'article';

        // Image
        if (has_post_thumbnail()) {
            $thumbnail_id = get_post_thumbnail_id();
            $image_data = wp_get_attachment_image_src($thumbnail_id, 'full');
            if ($image_data) {
                $og_image = $image_data[0];
                $og_image_width = $image_data[1];
                $og_image_height = $image_data[2];
            }
        }

        // Exercise-specific metadata
        if (is_singular('exercise')) {
            $calories = get_post_meta($post->ID, '_exercise_calories', true);
            $duration = get_post_meta($post->ID, '_exercise_duration', true);

            if ($calories && $duration) {
                $og_description .= sprintf(
                    ' | %s calories in %s minutes',
                    $calories,
                    $duration
                );
            }
        }
    } elseif (is_tax()) {
        // Taxonomy archive
        $term = get_queried_object();
        $og_title = $term->name . ' - ' . $site_name;
        $og_description = $term->description ? $term->description : sprintf(__('Browse all %s exercises', 'fitlife-pro'), $term->name);
        $og_url = get_term_link($term);
    } elseif (is_post_type_archive('exercise')) {
        // Exercise archive
        $og_title = __('All Exercises', 'fitlife-pro') . ' - ' . $site_name;
        $og_description = __('Browse our complete exercise database with detailed instructions and videos', 'fitlife-pro');
        $og_url = get_post_type_archive_link('exercise');
    } elseif (is_home() || is_front_page()) {
        // Homepage
        $og_title = $site_name;
        $og_description = $site_description;
        $og_url = home_url('/');
    }

    // Sanitize
    $og_title = esc_attr(wp_strip_all_tags($og_title));
    $og_description = esc_attr(wp_strip_all_tags($og_description));
    $og_url = esc_url($og_url);
    $og_image = esc_url($og_image);

    // Output Open Graph tags
    ?>
    <!-- Open Graph Meta Tags -->
    <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>" />
    <meta property="og:title" content="<?php echo $og_title; ?>" />
    <meta property="og:description" content="<?php echo $og_description; ?>" />
    <meta property="og:type" content="<?php echo esc_attr($og_type); ?>" />
    <meta property="og:url" content="<?php echo $og_url; ?>" />
    <meta property="og:image" content="<?php echo $og_image; ?>" />
    <meta property="og:image:width" content="<?php echo esc_attr($og_image_width); ?>" />
    <meta property="og:image:height" content="<?php echo esc_attr($og_image_height); ?>" />
    <meta property="og:locale" content="<?php echo esc_attr(get_locale()); ?>" />
    <?php

    // Article-specific tags
    if ($og_type === 'article' && is_singular()) {
        $published_time = get_the_date('c');
        $modified_time = get_the_modified_date('c');
        $author = get_the_author();
        ?>
        <meta property="article:published_time" content="<?php echo esc_attr($published_time); ?>" />
        <meta property="article:modified_time" content="<?php echo esc_attr($modified_time); ?>" />
        <meta property="article:author" content="<?php echo esc_attr($author); ?>" />
        <?php

        // Exercise taxonomies
        if (is_singular('exercise')) {
            $muscle_groups = get_the_terms(get_the_ID(), 'muscle_group');
            if ($muscle_groups && !is_wp_error($muscle_groups)) {
                foreach ($muscle_groups as $term) {
                    echo '<meta property="article:tag" content="' . esc_attr($term->name) . '" />' . "\n";
                }
            }
        }
    }
}

/**
 * Output Twitter Card meta tags
 */
function fitlife_output_twitter_cards() {
    // Site Twitter handle (customize this)
    $twitter_site = '@fitlifepro'; // Change to your Twitter handle

    // Card type
    $card_type = 'summary_large_image';

    // Get OG data (reuse logic)
    $twitter_title = '';
    $twitter_description = '';
    $twitter_image = FITLIFE_THEME_URI . '/screenshot.png';

    if (is_singular()) {
        global $post;

        $twitter_title = get_the_title();

        if (has_excerpt()) {
            $twitter_description = get_the_excerpt();
        } else {
            $twitter_description = wp_trim_words(strip_tags($post->post_content), 30, '...');
        }

        if (has_post_thumbnail()) {
            $thumbnail_id = get_post_thumbnail_id();
            $image_data = wp_get_attachment_image_src($thumbnail_id, 'full');
            if ($image_data) {
                $twitter_image = $image_data[0];
            }
        }

        // Exercise-specific
        if (is_singular('exercise')) {
            $calories = get_post_meta($post->ID, '_exercise_calories', true);
            $duration = get_post_meta($post->ID, '_exercise_duration', true);

            if ($calories && $duration) {
                $twitter_description .= sprintf(
                    ' | %s calories in %s minutes',
                    $calories,
                    $duration
                );
            }
        }
    } elseif (is_tax()) {
        $term = get_queried_object();
        $twitter_title = $term->name . ' - ' . get_bloginfo('name');
        $twitter_description = $term->description ? $term->description : sprintf(__('Browse all %s exercises', 'fitlife-pro'), $term->name);
    } elseif (is_post_type_archive('exercise')) {
        $twitter_title = __('All Exercises', 'fitlife-pro') . ' - ' . get_bloginfo('name');
        $twitter_description = __('Browse our complete exercise database', 'fitlife-pro');
    } else {
        $twitter_title = get_bloginfo('name');
        $twitter_description = get_bloginfo('description');
    }

    // Sanitize
    $twitter_title = esc_attr(wp_strip_all_tags($twitter_title));
    $twitter_description = esc_attr(wp_strip_all_tags($twitter_description));
    $twitter_image = esc_url($twitter_image);

    // Output Twitter Card tags
    ?>
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="<?php echo esc_attr($card_type); ?>" />
    <meta name="twitter:site" content="<?php echo esc_attr($twitter_site); ?>" />
    <meta name="twitter:title" content="<?php echo $twitter_title; ?>" />
    <meta name="twitter:description" content="<?php echo $twitter_description; ?>" />
    <meta name="twitter:image" content="<?php echo $twitter_image; ?>" />
    <?php
}

/**
 * Hook Open Graph and Twitter Cards into wp_head
 */
function fitlife_output_social_meta_tags() {
    fitlife_output_og_tags();
    fitlife_output_twitter_cards();
}
add_action('wp_head', 'fitlife_output_social_meta_tags', 2);

/**
 * ========================================================================
 * WEBP IMAGE SUPPORT & LAZY LOADING
 * ========================================================================
 * Modern image optimization for better performance
 */

/**
 * Add WebP support for uploaded images
 */
function fitlife_add_webp_mime_types($mimes) {
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter('upload_mimes', 'fitlife_add_webp_mime_types');

/**
 * Generate WebP version when image is uploaded
 * Only if GD library supports WebP
 */
function fitlife_generate_webp_on_upload($metadata, $attachment_id) {
    if (!function_exists('imagewebp')) {
        return $metadata; // GD doesn't support WebP
    }

    $file = get_attached_file($attachment_id);
    $mime_type = get_post_mime_type($attachment_id);

    // Only process JPEG and PNG images
    if (!in_array($mime_type, array('image/jpeg', 'image/png'))) {
        return $metadata;
    }

    // Create WebP version of original image
    fitlife_create_webp_image($file, $mime_type);

    // Create WebP versions of all generated sizes
    if (isset($metadata['sizes']) && is_array($metadata['sizes'])) {
        $upload_dir = wp_upload_dir();
        $base_dir = dirname($file);

        foreach ($metadata['sizes'] as $size => $size_data) {
            $size_file = $base_dir . '/' . $size_data['file'];
            fitlife_create_webp_image($size_file, $size_data['mime-type']);
        }
    }

    return $metadata;
}
add_filter('wp_generate_attachment_metadata', 'fitlife_generate_webp_on_upload', 10, 2);

/**
 * Create WebP version of an image file
 */
function fitlife_create_webp_image($file, $mime_type) {
    if (!file_exists($file)) {
        return false;
    }

    $webp_file = preg_replace('/\.(jpe?g|png)$/i', '.webp', $file);

    // Skip if WebP already exists
    if (file_exists($webp_file)) {
        return true;
    }

    // Load image based on type
    if ($mime_type === 'image/jpeg') {
        $image = @imagecreatefromjpeg($file);
    } elseif ($mime_type === 'image/png') {
        $image = @imagecreatefrompng($file);

        // Preserve transparency for PNG
        if ($image) {
            imagealphablending($image, false);
            imagesavealpha($image, true);
        }
    } else {
        return false;
    }

    if (!$image) {
        return false;
    }

    // Create WebP with 85% quality (good balance)
    $result = @imagewebp($image, $webp_file, 85);
    imagedestroy($image);

    return $result;
}

/**
 * Add lazy loading and srcset to images
 */
function fitlife_add_lazy_loading_attributes($content) {
    // Skip if in admin or RSS feed
    if (is_admin() || is_feed()) {
        return $content;
    }

    // Add loading="lazy" and decoding="async" to all images
    $content = preg_replace_callback(
        '/<img([^>]+?)\/?>/',
        function($matches) {
            $img_tag = $matches[0];

            // Skip if already has loading attribute
            if (strpos($img_tag, 'loading=') !== false) {
                return $img_tag;
            }

            // Add loading="lazy" and decoding="async"
            $img_tag = str_replace('<img', '<img loading="lazy" decoding="async"', $img_tag);

            return $img_tag;
        },
        $content
    );

    return $content;
}
add_filter('the_content', 'fitlife_add_lazy_loading_attributes', 20);
add_filter('post_thumbnail_html', 'fitlife_add_lazy_loading_attributes', 20);

/**
 * Add WebP support to WordPress image generation
 */
function fitlife_webp_file_is_displayable($result, $path) {
    if ($result === false) {
        $displayable_image_types = array(IMAGETYPE_WEBP);
        $info = @getimagesize($path);

        if (empty($info)) {
            $result = false;
        } elseif (!in_array($info[2], $displayable_image_types)) {
            $result = false;
        } else {
            $result = true;
        }
    }

    return $result;
}
add_filter('file_is_displayable_image', 'fitlife_webp_file_is_displayable', 10, 2);

/**
 * Enable WebP preview in WordPress admin
 */
function fitlife_webp_is_displayable($result, $path) {
    if ($result === false) {
        $info = @getimagesize($path);
        if ($info !== false && $info[2] === IMAGETYPE_WEBP) {
            $result = true;
        }
    }
    return $result;
}
add_filter('file_is_displayable_image', 'fitlife_webp_is_displayable', 10, 2);

/**
 * Add responsive image attributes (srcset)
 */
function fitlife_add_responsive_image_attributes($attr, $attachment, $size) {
    // Skip if in admin
    if (is_admin()) {
        return $attr;
    }

    // Add srcset and sizes if not present
    if (empty($attr['srcset'])) {
        $image_meta = wp_get_attachment_metadata($attachment->ID);

        if (is_array($image_meta)) {
            $size_array = array(
                absint($attr['width']),
                absint($attr['height'])
            );
            $srcset = wp_calculate_image_srcset($size_array, $attr['src'], $image_meta, $attachment->ID);

            if ($srcset) {
                $attr['srcset'] = $srcset;
                $attr['sizes'] = wp_calculate_image_sizes($size_array, $attr['src'], $image_meta, $attachment->ID);
            }
        }
    }

    // Add lazy loading
    if (empty($attr['loading'])) {
        $attr['loading'] = 'lazy';
    }

    // Add async decoding
    if (empty($attr['decoding'])) {
        $attr['decoding'] = 'async';
    }

    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'fitlife_add_responsive_image_attributes', 10, 3);

/**
 * ========================================================================
 * CRITICAL CSS INLINE
 * ========================================================================
 * Inline critical CSS for faster First Contentful Paint
 */

/**
 * Output critical CSS inline in <head>
 */
function fitlife_output_critical_css() {
    ?>
    <style id="fitlife-critical-css">
        /* Critical CSS for above-the-fold content */

        /* Reset & Base */
        *,::before,::after{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}
        html{line-height:1.5;-webkit-text-size-adjust:100%;tab-size:4;font-family:Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif}
        body{margin:0;line-height:inherit;background-color:#f9fafb}

        /* Header & Navigation - Critical for LCP */
        .site-header{position:sticky;top:0;z-index:50;background-color:#fff;box-shadow:0 1px 3px 0 rgba(0,0,0,.1)}
        .site-header .container{max-width:80rem;margin:0 auto;padding:1rem 1.5rem;display:flex;justify-content:space-between;align-items:center}
        .site-branding{display:flex;align-items:center}
        .site-title{font-size:1.5rem;font-weight:800;color:#111827;margin:0}
        .primary-navigation{display:none}
        @media(min-width:1024px){.primary-navigation{display:flex;gap:2rem}}
        .mobile-menu-button{display:block;background:none;border:none;cursor:pointer}
        @media(min-width:1024px){.mobile-menu-button{display:none}}

        /* Hero Section - Critical for LCP */
        .hero-section{background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff;padding:4rem 1rem;text-align:center}
        .hero-title{font-size:2.5rem;font-weight:900;margin-bottom:1rem}
        @media(min-width:1024px){.hero-title{font-size:3.75rem}}

        /* Container */
        .container{max-width:80rem;margin:0 auto;padding:0 1rem}

        /* Grid System */
        .grid{display:grid;gap:1.5rem}
        .grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}
        @media(min-width:768px){.grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}
        @media(min-width:1024px){.grid-cols-3{grid-template-columns:repeat(3,minmax(0,1fr))}}

        /* Cards - Critical for LCP */
        .exercise-card,.stat-card{background:#fff;border-radius:0.75rem;box-shadow:0 1px 3px 0 rgba(0,0,0,.1);overflow:hidden}

        /* Typography */
        h1,h2,h3{margin:0;font-weight:700;line-height:1.2;color:#111827}
        h1{font-size:2.25rem}
        h2{font-size:1.875rem}
        h3{font-size:1.5rem}
        p{margin:0 0 1rem;line-height:1.6;color:#4b5563}

        /* Buttons */
        .btn{display:inline-flex;align-items:center;justify-content:center;padding:0.75rem 1.5rem;border-radius:0.5rem;font-weight:600;text-decoration:none;transition:all .2s}
        .btn-primary{background:#ff6b35;color:#fff;border:2px solid #ff6b35}
        .btn-primary:hover{background:#e55a2b}

        /* Skip Link - Accessibility */
        .skip-link{position:absolute;top:-40px;left:0;background:#000;color:#fff;padding:8px;z-index:100;text-decoration:none}
        .skip-link:focus{top:0}

        /* Loading State */
        img{max-width:100%;height:auto;display:block}

        /* Utility Classes */
        .sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border-width:0}
        .text-center{text-align:center}
        .mb-4{margin-bottom:1rem}
        .mb-8{margin-bottom:2rem}
        .py-12{padding-top:3rem;padding-bottom:3rem}
        .px-4{padding-left:1rem;padding-right:1rem}

        /* Reduced Motion */
        @media(prefers-reduced-motion:reduce){*,::before,::after{animation-duration:.01ms!important;animation-iteration-count:1!important;transition-duration:.01ms!important}}
    </style>
    <?php
}
add_action('wp_head', 'fitlife_output_critical_css', 3);

/**
 * Defer non-critical CSS
 */
function fitlife_defer_non_critical_css($html, $handle, $href, $media) {
    // Don't defer admin styles
    if (is_admin()) {
        return $html;
    }

    // List of handles to defer (non-critical)
    $defer_handles = array(
        'fitlife-custom',
    );

    // If this is a non-critical stylesheet, defer it
    if (in_array($handle, $defer_handles)) {
        // Change media to print, then switch to all after page load
        $html = str_replace("media='all'", "media='print' onload=\"this.media='all'\"", $html);
        $html = str_replace('media="all"', 'media="print" onload="this.media=\'all\'"', $html);

        // Add noscript fallback
        $html .= '<noscript><link rel="stylesheet" href="' . esc_url($href) . '" media="all"></noscript>';
    }

    return $html;
}
add_filter('style_loader_tag', 'fitlife_defer_non_critical_css', 10, 4);

/**
 * Preload critical fonts
 */
function fitlife_preload_critical_fonts() {
    ?>
    <!-- Preload critical fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.tailwindcss.com">
    <?php
}
add_action('wp_head', 'fitlife_preload_critical_fonts', 1);

/**
 * Add resource hints for better performance
 */
function fitlife_add_resource_hints($urls, $relation_type) {
    if ('preconnect' === $relation_type) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin' => 'anonymous',
        );
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
        $urls[] = array(
            'href' => 'https://cdn.tailwindcss.com',
        );
    }

    if ('dns-prefetch' === $relation_type) {
        $urls[] = 'https://fonts.googleapis.com';
        $urls[] = 'https://fonts.gstatic.com';
        $urls[] = 'https://cdn.tailwindcss.com';
    }

    return $urls;
}
add_filter('wp_resource_hints', 'fitlife_add_resource_hints', 10, 2);

/**
 * ========================================================================
 * XML SITEMAP GENERATION
 * ========================================================================
 * Enhanced sitemap with exercises, taxonomies, and images
 */

/**
 * Add Exercise CPT to WordPress sitemap
 */
function fitlife_add_exercise_to_sitemap($post_types) {
    $post_types[] = 'exercise';
    return $post_types;
}
add_filter('wp_sitemaps_post_types', 'fitlife_add_exercise_to_sitemap');

/**
 * Add Exercise taxonomies to WordPress sitemap
 */
function fitlife_add_exercise_taxonomies_to_sitemap($taxonomies) {
    $taxonomies[] = 'muscle_group';
    $taxonomies[] = 'equipment';
    $taxonomies[] = 'difficulty';
    return $taxonomies;
}
add_filter('wp_sitemaps_taxonomies', 'fitlife_add_exercise_taxonomies_to_sitemap');

/**
 * Customize sitemap entries for exercises
 */
function fitlife_customize_exercise_sitemap($entry, $post) {
    if ($post->post_type === 'exercise') {
        // Higher priority for exercises
        $entry['priority'] = 0.8;

        // Update frequency based on post date
        $days_since_modified = (time() - strtotime($post->post_modified)) / DAY_IN_SECONDS;

        if ($days_since_modified < 7) {
            $entry['changefreq'] = 'daily';
        } elseif ($days_since_modified < 30) {
            $entry['changefreq'] = 'weekly';
        } else {
            $entry['changefreq'] = 'monthly';
        }
    }

    return $entry;
}
add_filter('wp_sitemaps_posts_entry', 'fitlife_customize_exercise_sitemap', 10, 2);

/**
 * Add image sitemap for exercises
 */
function fitlife_add_images_to_sitemap($entry, $post) {
    if ($post->post_type === 'exercise' && has_post_thumbnail($post->ID)) {
        $thumbnail_id = get_post_thumbnail_id($post->ID);
        $image_url = wp_get_attachment_image_url($thumbnail_id, 'full');

        if ($image_url) {
            $entry['image:image'] = array(
                'image:loc' => $image_url,
                'image:title' => get_the_title($post->ID),
                'image:caption' => get_post_field('post_excerpt', $thumbnail_id),
            );
        }
    }

    return $entry;
}
add_filter('wp_sitemaps_posts_entry', 'fitlife_add_images_to_sitemap', 10, 2);

/**
 * Set max URLs per sitemap
 */
function fitlife_sitemap_max_urls($max_urls) {
    return 2000; // Increase from default 2000
}
add_filter('wp_sitemaps_max_urls', 'fitlife_sitemap_max_urls');

/**
 * Add custom sitemap index for exercises
 */
function fitlife_add_exercise_sitemap_provider($provider, $name) {
    if ('exercises' === $name) {
        return new WP_Sitemaps_Posts($name);
    }

    return $provider;
}

/**
 * Create custom sitemap rewrite rules
 */
function fitlife_sitemap_rewrite_rules() {
    add_rewrite_rule(
        'sitemap-exercises\.xml$',
        'index.php?sitemap=exercises&sitemap-subtype=exercise',
        'top'
    );
}
add_action('init', 'fitlife_sitemap_rewrite_rules');

/**
 * ========================================================================
 * CANONICAL URLs & META ROBOTS
 * ========================================================================
 * SEO: Prevent duplicate content and control indexing
 */

/**
 * Output canonical URL
 */
function fitlife_output_canonical_url() {
    $canonical = '';

    if (is_singular()) {
        $canonical = get_permalink();
    } elseif (is_tax() || is_category() || is_tag()) {
        $canonical = get_term_link(get_queried_object());
    } elseif (is_post_type_archive()) {
        $canonical = get_post_type_archive_link(get_query_var('post_type'));
    } elseif (is_author()) {
        $canonical = get_author_posts_url(get_queried_object_id());
    } elseif (is_home() || is_front_page()) {
        $canonical = home_url('/');
    }

    // Remove pagination from canonical
    $canonical = preg_replace('/\/page\/[0-9]+\/?/', '/', $canonical);

    if ($canonical) {
        echo '<link rel="canonical" href="' . esc_url($canonical) . '" />' . "\n";
    }
}
add_action('wp_head', 'fitlife_output_canonical_url', 1);

/**
 * Output meta robots tags
 */
function fitlife_output_meta_robots() {
    $robots = array();

    // Default: index, follow
    if (is_singular()) {
        if (is_singular('exercise')) {
            // Index exercises
            $robots[] = 'index';
            $robots[] = 'follow';
            $robots[] = 'max-image-preview:large';
            $robots[] = 'max-snippet:-1';
        } else {
            // Index other posts
            $robots[] = 'index';
            $robots[] = 'follow';
        }
    } elseif (is_tax() || is_category() || is_tag()) {
        // Index taxonomy pages
        $robots[] = 'index';
        $robots[] = 'follow';
    } elseif (is_post_type_archive('exercise')) {
        // Index exercise archive
        $robots[] = 'index';
        $robots[] = 'follow';
    } elseif (is_home() || is_front_page()) {
        // Index homepage
        $robots[] = 'index';
        $robots[] = 'follow';
        $robots[] = 'max-image-preview:large';
    } elseif (is_search()) {
        // NoIndex search results
        $robots[] = 'noindex';
        $robots[] = 'follow';
    } elseif (is_404()) {
        // NoIndex 404 pages
        $robots[] = 'noindex';
        $robots[] = 'nofollow';
    } elseif (is_paged()) {
        // NoIndex paginated pages (rely on canonical)
        $robots[] = 'noindex';
        $robots[] = 'follow';
    } elseif (is_author() || is_date() || is_archive()) {
        // NoIndex archives
        $robots[] = 'noindex';
        $robots[] = 'follow';
    }

    // Honor WordPress privacy settings
    if (get_option('blog_public') == 0) {
        $robots = array('noindex', 'nofollow');
    }

    if (!empty($robots)) {
        $content = implode(', ', $robots);
        echo '<meta name="robots" content="' . esc_attr($content) . '" />' . "\n";
    }
}
add_action('wp_head', 'fitlife_output_meta_robots', 1);

/**
 * Add prev/next links for paginated content
 */
function fitlife_output_pagination_links() {
    global $paged;

    if (!is_singular()) {
        return;
    }

    // Multi-page posts
    global $page, $numpages;

    if ($page > 1) {
        $prev_link = get_permalink() . ($page - 1 > 1 ? $page - 1 . '/' : '');
        echo '<link rel="prev" href="' . esc_url($prev_link) . '" />' . "\n";
    }

    if ($page < $numpages) {
        $next_link = get_permalink() . ($page + 1) . '/';
        echo '<link rel="next" href="' . esc_url($next_link) . '" />' . "\n";
    }
}
add_action('wp_head', 'fitlife_output_pagination_links', 1);

/**
 * ========================================================================
 * EXERCISE RATING SYSTEM
 * ========================================================================
 * 5-star rating system with AggregateRating Schema
 */

/**
 * Get exercise rating data
 */
function fitlife_get_exercise_rating($post_id) {
    $ratings = get_post_meta($post_id, '_exercise_ratings', true);

    if (!$ratings || !is_array($ratings)) {
        return array(
            'average' => 0,
            'count' => 0,
            'total' => 0,
        );
    }

    $count = count($ratings);
    $total = array_sum($ratings);
    $average = $count > 0 ? round($total / $count, 1) : 0;

    return array(
        'average' => $average,
        'count' => $count,
        'total' => $total,
    );
}

/**
 * Add rating to exercise
 */
function fitlife_add_exercise_rating($post_id, $rating) {
    // Validate rating (1-5)
    $rating = intval($rating);
    if ($rating < 1 || $rating > 5) {
        return false;
    }

    // Get existing ratings
    $ratings = get_post_meta($post_id, '_exercise_ratings', true);
    if (!$ratings || !is_array($ratings)) {
        $ratings = array();
    }

    // Get user IP (simple anti-spam)
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Check if user already rated (based on IP)
    $user_ratings = get_post_meta($post_id, '_exercise_user_ratings', true);
    if (!$user_ratings || !is_array($user_ratings)) {
        $user_ratings = array();
    }

    // Allow re-rating after 24 hours
    $time_limit = 24 * 60 * 60; // 24 hours
    if (isset($user_ratings[$user_ip])) {
        $last_rating_time = $user_ratings[$user_ip]['time'];
        if (time() - $last_rating_time < $time_limit) {
            return array(
                'success' => false,
                'message' => __('You can rate again after 24 hours', 'fitlife-pro'),
            );
        }
    }

    // Add new rating
    $ratings[] = $rating;

    // Store user rating with timestamp
    $user_ratings[$user_ip] = array(
        'rating' => $rating,
        'time' => time(),
    );

    // Update post meta
    update_post_meta($post_id, '_exercise_ratings', $ratings);
    update_post_meta($post_id, '_exercise_user_ratings', $user_ratings);

    // Get updated rating data
    $rating_data = fitlife_get_exercise_rating($post_id);

    return array(
        'success' => true,
        'message' => __('Thank you for rating!', 'fitlife-pro'),
        'data' => $rating_data,
    );
}

/**
 * AJAX handler for rating submission
 */
function fitlife_ajax_submit_rating() {
    // Check nonce
    check_ajax_referer('fitlife_nonce', 'nonce');

    $post_id = intval($_POST['post_id']);
    $rating = intval($_POST['rating']);

    // Validate post
    if (!$post_id || get_post_type($post_id) !== 'exercise') {
        wp_send_json_error(array(
            'message' => __('Invalid exercise', 'fitlife-pro'),
        ));
    }

    // Add rating
    $result = fitlife_add_exercise_rating($post_id, $rating);

    if ($result['success']) {
        wp_send_json_success($result);
    } else {
        wp_send_json_error($result);
    }
}
add_action('wp_ajax_fitlife_submit_rating', 'fitlife_ajax_submit_rating');
add_action('wp_ajax_nopriv_fitlife_submit_rating', 'fitlife_ajax_submit_rating');

/**
 * Display rating stars HTML
 */
function fitlife_display_rating_stars($post_id, $show_form = true) {
    $rating_data = fitlife_get_exercise_rating($post_id);
    $average = $rating_data['average'];
    $count = $rating_data['count'];

    ob_start();
    ?>
    <div class="exercise-rating-container" data-post-id="<?php echo esc_attr($post_id); ?>">
        <!-- Display Current Rating -->
        <div class="rating-display flex items-center gap-3 mb-4">
            <div class="stars flex gap-1" aria-label="<?php printf(__('Average rating: %s out of 5', 'fitlife-pro'), $average); ?>">
                <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <svg class="w-6 h-6 <?php echo $i <= round($average) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'; ?>" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                <?php endfor; ?>
            </div>
            <div class="rating-info text-sm text-gray-600 dark:text-gray-400">
                <span class="font-semibold text-gray-900 dark:text-white"><?php echo esc_html($average); ?></span>
                <span>(<?php echo esc_html($count); ?> <?php echo _n('rating', 'ratings', $count, 'fitlife-pro'); ?>)</span>
            </div>
        </div>

        <?php if ($show_form) : ?>
            <!-- Rating Form -->
            <div class="rating-form">
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2"><?php _e('Rate this exercise:', 'fitlife-pro'); ?></p>
                <div class="rating-input flex gap-1" role="radiogroup" aria-label="<?php _e('Rate from 1 to 5 stars', 'fitlife-pro'); ?>">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <button
                            type="button"
                            class="rating-star w-8 h-8 text-gray-300 dark:text-gray-600 hover:text-yellow-400 transition-colors duration-200 focus:outline-none focus:ring-4 focus:ring-yellow-400 focus:ring-opacity-50 rounded"
                            data-rating="<?php echo $i; ?>"
                            role="radio"
                            aria-checked="false"
                            aria-label="<?php printf(__('%s stars', 'fitlife-pro'), $i); ?>">
                            <svg class="w-full h-full" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </button>
                    <?php endfor; ?>
                </div>
                <div class="rating-message mt-2 text-sm" role="status" aria-live="polite"></div>
            </div>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Add AggregateRating to Exercise Schema
 */
function fitlife_add_rating_to_exercise_schema($schema, $post_id) {
    if (!is_singular('exercise')) {
        return $schema;
    }

    $rating_data = fitlife_get_exercise_rating($post_id);

    // Only add if there are ratings
    if ($rating_data['count'] > 0) {
        $schema['aggregateRating'] = array(
            '@type' => 'AggregateRating',
            'ratingValue' => $rating_data['average'],
            'ratingCount' => $rating_data['count'],
            'bestRating' => 5,
            'worstRating' => 1,
        );
    }

    return $schema;
}

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
