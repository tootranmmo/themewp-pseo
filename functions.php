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
define('FITLIFE_VERSION', '1.0.0');
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
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap', array(), null);

    // Main stylesheet
    wp_enqueue_style('fitlife-style', get_stylesheet_uri(), array(), FITLIFE_VERSION);

    // Homepage styles
    if (is_front_page()) {
        wp_enqueue_style('fitlife-homepage', FITLIFE_THEME_URI . '/assets/css/homepage.css', array('fitlife-style'), FITLIFE_VERSION);
    }

    // Main JavaScript
    wp_enqueue_script('fitlife-main', FITLIFE_THEME_URI . '/assets/js/main.js', array('jquery'), FITLIFE_VERSION, true);

    // Localize script for AJAX
    wp_localize_script('fitlife-main', 'fitlife_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('fitlife_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'fitlife_enqueue_scripts');

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
