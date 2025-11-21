<?php
/**
 * Homepage Template
 *
 * @package FitLife_Pro
 */

get_header();

// Get statistics
$stats = fitlife_get_stats();

// Get top exercises by calories
$top_exercises = new WP_Query(array(
    'post_type' => 'exercise',
    'posts_per_page' => 6,
    'meta_key' => '_exercise_calories',
    'orderby' => 'meta_value_num',
    'order' => 'DESC',
));

// Get muscle groups
$muscle_groups = get_terms(array(
    'taxonomy' => 'muscle_group',
    'number' => 6,
    'orderby' => 'count',
    'order' => 'DESC',
));

// Get equipment types
$equipment_types = get_terms(array(
    'taxonomy' => 'equipment',
    'number' => 6,
    'orderby' => 'count',
    'order' => 'DESC',
));

// Get difficulty levels
$difficulty_levels = get_terms(array(
    'taxonomy' => 'difficulty',
    'number' => 3,
    'orderby' => 'term_order',
));
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title"><?php _e('Transform Your Body, Elevate Your Life', 'fitlife-pro'); ?></h1>
            <p class="hero-subtitle"><?php _e('Discover thousands of exercises tailored to your fitness goals', 'fitlife-pro'); ?></p>

            <!-- Advanced Search Bar -->
            <div class="search-box">
                <form id="exercise-search-form" class="exercise-search-form">
                    <div class="search-input-wrapper">
                        <span class="search-icon">🔍</span>
                        <input
                            type="text"
                            id="search-input"
                            name="search"
                            class="search-input"
                            placeholder="<?php _e('Search exercises... (e.g., push-ups, squats)', 'fitlife-pro'); ?>"
                        >
                    </div>

                    <div class="search-filters">
                        <select name="muscle_group" id="muscle-group-filter" class="search-select">
                            <option value=""><?php _e('All Muscle Groups', 'fitlife-pro'); ?></option>
                            <?php
                            $all_muscles = get_terms(array('taxonomy' => 'muscle_group', 'hide_empty' => false));
                            foreach ($all_muscles as $muscle) {
                                echo '<option value="' . esc_attr($muscle->slug) . '">' . esc_html($muscle->name) . '</option>';
                            }
                            ?>
                        </select>

                        <select name="equipment" id="equipment-filter" class="search-select">
                            <option value=""><?php _e('All Equipment', 'fitlife-pro'); ?></option>
                            <?php
                            $all_equipment = get_terms(array('taxonomy' => 'equipment', 'hide_empty' => false));
                            foreach ($all_equipment as $equip) {
                                echo '<option value="' . esc_attr($equip->slug) . '">' . esc_html($equip->name) . '</option>';
                            }
                            ?>
                        </select>

                        <select name="difficulty" id="difficulty-filter" class="search-select">
                            <option value=""><?php _e('All Levels', 'fitlife-pro'); ?></option>
                            <?php
                            $all_difficulties = get_terms(array('taxonomy' => 'difficulty', 'hide_empty' => false));
                            foreach ($all_difficulties as $diff) {
                                echo '<option value="' . esc_attr($diff->slug) . '">' . esc_html($diff->name) . '</option>';
                            }
                            ?>
                        </select>

                        <button type="submit" class="btn btn-primary">
                            <?php _e('Search', 'fitlife-pro'); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Dashboard -->
<section class="stats-section section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">🏋️</div>
                <div class="stat-content">
                    <h3 class="stat-number"><?php echo number_format($stats['total_exercises']); ?></h3>
                    <p class="stat-label"><?php _e('Total Exercises', 'fitlife-pro'); ?></p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">💪</div>
                <div class="stat-content">
                    <h3 class="stat-number"><?php echo number_format($stats['muscle_groups']); ?></h3>
                    <p class="stat-label"><?php _e('Muscle Groups', 'fitlife-pro'); ?></p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🔥</div>
                <div class="stat-content">
                    <h3 class="stat-number"><?php echo number_format($stats['total_calories']); ?>+</h3>
                    <p class="stat-label"><?php _e('Calories Burned', 'fitlife-pro'); ?></p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">⚡</div>
                <div class="stat-content">
                    <h3 class="stat-number"><?php echo number_format($stats['equipment_types']); ?></h3>
                    <p class="stat-label"><?php _e('Equipment Types', 'fitlife-pro'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Top Calorie Burning Exercises -->
<section class="top-exercises-section section" style="background-color: var(--light-color);">
    <div class="container">
        <div class="section-title">
            <h2><?php _e('🔥 Top Calorie Burning Exercises', 'fitlife-pro'); ?></h2>
            <p><?php _e('Maximize your workout with these high-intensity exercises', 'fitlife-pro'); ?></p>
        </div>

        <div class="grid grid-3">
            <?php
            if ($top_exercises->have_posts()) :
                while ($top_exercises->have_posts()) : $top_exercises->the_post();
                    $calories = get_post_meta(get_the_ID(), '_exercise_calories', true);
                    $duration = get_post_meta(get_the_ID(), '_exercise_duration', true);
                    $difficulty_terms = get_the_terms(get_the_ID(), 'difficulty');
                    $difficulty_class = $difficulty_terms ? strtolower($difficulty_terms[0]->slug) : 'beginner';
                    ?>
                    <div class="exercise-card card">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'exercise-thumb'); ?>"
                                 alt="<?php the_title_attribute(); ?>"
                                 class="card-img">
                        <?php else : ?>
                            <div class="card-img" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">
                                🏋️
                            </div>
                        <?php endif; ?>

                        <div class="card-body">
                            <div class="card-badges">
                                <span class="badge badge-calories"><?php echo esc_html($calories); ?> cal</span>
                                <span class="badge badge-<?php echo esc_attr($difficulty_class); ?>">
                                    <?php echo $difficulty_terms ? esc_html($difficulty_terms[0]->name) : __('Beginner', 'fitlife-pro'); ?>
                                </span>
                            </div>
                            <h3 class="card-title"><?php the_title(); ?></h3>
                            <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                            <div class="card-meta">
                                <span>⏱️ <?php echo esc_html($duration); ?> min</span>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-block">
                                <?php _e('View Details', 'fitlife-pro'); ?>
                            </a>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p>' . __('No exercises found. Please add some exercises from the admin panel.', 'fitlife-pro') . '</p>';
            endif;
            ?>
        </div>

        <div class="text-center mt-5">
            <a href="<?php echo esc_url(home_url('/exercises')); ?>" class="btn btn-primary btn-lg">
                <?php _e('Browse All Exercises', 'fitlife-pro'); ?>
            </a>
        </div>
    </div>
</section>

<!-- Popular Muscle Groups -->
<section class="muscle-groups-section section">
    <div class="container">
        <div class="section-title">
            <h2><?php _e('💪 Train by Muscle Group', 'fitlife-pro'); ?></h2>
            <p><?php _e('Target specific muscle groups for balanced development', 'fitlife-pro'); ?></p>
        </div>

        <div class="grid grid-6">
            <?php
            if (!empty($muscle_groups) && !is_wp_error($muscle_groups)) :
                $muscle_icons = array(
                    'chest' => '🫁',
                    'back' => '🔙',
                    'shoulders' => '💪',
                    'arms' => '💪',
                    'legs' => '🦵',
                    'core' => '⚡',
                    'abs' => '📦',
                    'glutes' => '🍑',
                );

                foreach ($muscle_groups as $muscle) :
                    $icon = isset($muscle_icons[strtolower($muscle->slug)]) ? $muscle_icons[strtolower($muscle->slug)] : '💪';
                    ?>
                    <a href="<?php echo get_term_link($muscle); ?>" class="category-card">
                        <div class="category-icon"><?php echo $icon; ?></div>
                        <h3 class="category-name"><?php echo esc_html($muscle->name); ?></h3>
                        <p class="category-count"><?php echo $muscle->count; ?> <?php _e('exercises', 'fitlife-pro'); ?></p>
                    </a>
                    <?php
                endforeach;
            else :
                echo '<p>' . __('No muscle groups found. Please add some from the admin panel.', 'fitlife-pro') . '</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Equipment Types -->
<section class="equipment-section section" style="background-color: var(--light-color);">
    <div class="container">
        <div class="section-title">
            <h2><?php _e('⚡ Equipment Categories', 'fitlife-pro'); ?></h2>
            <p><?php _e('Choose exercises based on available equipment', 'fitlife-pro'); ?></p>
        </div>

        <div class="grid grid-6">
            <?php
            if (!empty($equipment_types) && !is_wp_error($equipment_types)) :
                $equipment_icons = array(
                    'barbell' => '🏋️',
                    'dumbbell' => '💪',
                    'kettlebell' => '🔔',
                    'bodyweight' => '🧘',
                    'machine' => '🔧',
                    'cable' => '🔗',
                    'bands' => '🎀',
                    'none' => '🆓',
                );

                foreach ($equipment_types as $equipment) :
                    $icon = isset($equipment_icons[strtolower($equipment->slug)]) ? $equipment_icons[strtolower($equipment->slug)] : '⚡';
                    ?>
                    <a href="<?php echo get_term_link($equipment); ?>" class="category-card">
                        <div class="category-icon"><?php echo $icon; ?></div>
                        <h3 class="category-name"><?php echo esc_html($equipment->name); ?></h3>
                        <p class="category-count"><?php echo $equipment->count; ?> <?php _e('exercises', 'fitlife-pro'); ?></p>
                    </a>
                    <?php
                endforeach;
            else :
                echo '<p>' . __('No equipment types found. Please add some from the admin panel.', 'fitlife-pro') . '</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<!-- Difficulty Levels -->
<section class="difficulty-section section">
    <div class="container">
        <div class="section-title">
            <h2><?php _e('📊 Choose Your Level', 'fitlife-pro'); ?></h2>
            <p><?php _e('Find exercises that match your fitness level', 'fitlife-pro'); ?></p>
        </div>

        <div class="difficulty-cards-wrapper">
            <?php
            if (!empty($difficulty_levels) && !is_wp_error($difficulty_levels)) :
                $difficulty_data = array(
                    'beginner' => array(
                        'icon' => '🌱',
                        'color' => '#4CAF50',
                        'description' => __('Perfect for those just starting their fitness journey', 'fitlife-pro'),
                    ),
                    'intermediate' => array(
                        'icon' => '🔥',
                        'color' => '#FFC107',
                        'description' => __('For those with some experience looking to level up', 'fitlife-pro'),
                    ),
                    'advanced' => array(
                        'icon' => '⚡',
                        'color' => '#F44336',
                        'description' => __('Challenging exercises for experienced athletes', 'fitlife-pro'),
                    ),
                );

                foreach ($difficulty_levels as $difficulty) :
                    $slug = strtolower($difficulty->slug);
                    $data = isset($difficulty_data[$slug]) ? $difficulty_data[$slug] : $difficulty_data['beginner'];
                    ?>
                    <div class="difficulty-card" style="border-top: 4px solid <?php echo $data['color']; ?>">
                        <div class="difficulty-icon" style="color: <?php echo $data['color']; ?>"><?php echo $data['icon']; ?></div>
                        <h3 class="difficulty-title"><?php echo esc_html($difficulty->name); ?></h3>
                        <p class="difficulty-description"><?php echo $data['description']; ?></p>
                        <div class="difficulty-stats">
                            <span class="difficulty-count"><?php echo $difficulty->count; ?> exercises</span>
                        </div>
                        <a href="<?php echo get_term_link($difficulty); ?>" class="btn btn-outline btn-block">
                            <?php _e('Start Training', 'fitlife-pro'); ?>
                        </a>
                    </div>
                    <?php
                endforeach;
            else :
                echo '<p>' . __('No difficulty levels found. Please add Beginner, Intermediate, and Advanced from the admin panel.', 'fitlife-pro') . '</p>';
            endif;
            ?>
        </div>
    </div>
</section>

<!-- FAQ Section with Schema Markup -->
<section class="faq-section section" style="background-color: var(--light-color);">
    <div class="container">
        <div class="section-title">
            <h2><?php _e('❓ Frequently Asked Questions', 'fitlife-pro'); ?></h2>
            <p><?php _e('Everything you need to know about fitness and our platform', 'fitlife-pro'); ?></p>
        </div>

        <div class="faq-container">
            <?php
            $faqs = array(
                array(
                    'question' => __('How many exercises are in the database?', 'fitlife-pro'),
                    'answer' => sprintf(__('We currently have %d exercises covering all major muscle groups and fitness levels. Our database is constantly growing with new exercises added regularly.', 'fitlife-pro'), $stats['total_exercises']),
                ),
                array(
                    'question' => __('Can I filter exercises by equipment?', 'fitlife-pro'),
                    'answer' => __('Yes! You can filter exercises by equipment type, including barbell, dumbbell, kettlebell, bodyweight, machines, and more. This makes it easy to find exercises based on what you have available.', 'fitlife-pro'),
                ),
                array(
                    'question' => __('How accurate are the calorie calculations?', 'fitlife-pro'),
                    'answer' => __('Our calorie estimates are based on average values for a 70kg (154lb) person performing the exercise at moderate intensity. Actual calories burned will vary based on your weight, intensity, and other factors.', 'fitlife-pro'),
                ),
                array(
                    'question' => __('Are the exercises suitable for beginners?', 'fitlife-pro'),
                    'answer' => __('Absolutely! We have exercises for all fitness levels - beginner, intermediate, and advanced. Each exercise is clearly labeled with its difficulty level so you can choose what\'s right for you.', 'fitlife-pro'),
                ),
                array(
                    'question' => __('How often should I change my workout routine?', 'fitlife-pro'),
                    'answer' => __('It\'s recommended to change your workout routine every 4-6 weeks to prevent plateaus and keep your body challenged. Our database makes it easy to discover new exercises for variety.', 'fitlife-pro'),
                ),
                array(
                    'question' => __('Do I need a gym membership to use these exercises?', 'fitlife-pro'),
                    'answer' => __('Not at all! We have a large selection of bodyweight exercises that require no equipment. You can filter by "Bodyweight" or "No Equipment" to find exercises you can do anywhere.', 'fitlife-pro'),
                ),
            );

            // Schema Markup for FAQs
            $schema = array(
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => array(),
            );

            foreach ($faqs as $index => $faq) :
                // Add to schema
                $schema['mainEntity'][] = array(
                    '@type' => 'Question',
                    'name' => $faq['question'],
                    'acceptedAnswer' => array(
                        '@type' => 'Answer',
                        'text' => $faq['answer'],
                    ),
                );
                ?>
                <div class="faq-item">
                    <button class="faq-question" data-faq="<?php echo $index; ?>">
                        <span><?php echo esc_html($faq['question']); ?></span>
                        <span class="faq-toggle">+</span>
                    </button>
                    <div class="faq-answer" id="faq-<?php echo $index; ?>">
                        <p><?php echo esc_html($faq['answer']); ?></p>
                    </div>
                </div>
                <?php
            endforeach;
            ?>
        </div>

        <!-- Schema Markup Output -->
        <script type="application/ld+json">
        <?php echo json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
        </script>
    </div>
</section>

<!-- Call to Action -->
<section class="cta-section section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title"><?php _e('Ready to Transform Your Fitness Journey?', 'fitlife-pro'); ?></h2>
            <p class="cta-subtitle"><?php _e('Start exploring thousands of exercises and build your perfect workout routine today', 'fitlife-pro'); ?></p>
            <div class="cta-buttons">
                <a href="<?php echo esc_url(home_url('/exercises')); ?>" class="btn btn-primary btn-lg">
                    <?php _e('Get Started Now', 'fitlife-pro'); ?>
                </a>
                <a href="<?php echo esc_url(home_url('/about')); ?>" class="btn btn-outline btn-lg">
                    <?php _e('Learn More', 'fitlife-pro'); ?>
                </a>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
