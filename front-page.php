<?php
/**
 * Homepage Template - FitLife Pro v2.0
 * Built with Tailwind CSS & Semantic HTML5
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

<!-- Main Content -->
<main id="main" class="site-main" role="main">

    <!-- Hero Section -->
    <section class="relative min-h-[600px] flex items-center justify-center bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800 text-white overflow-hidden">
        <!-- Pattern Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-20 pattern-grid"></div>

        <!-- Animated Background Shapes -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-primary-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse"></div>
            <div class="absolute bottom-20 right-10 w-72 h-72 bg-accent-500 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-pulse animation-delay-2000"></div>
        </div>

        <!-- Content -->
        <div class="container mx-auto px-4 lg:px-6 relative z-10">
            <div class="max-w-5xl mx-auto text-center py-16 lg:py-24">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 text-white drop-shadow-lg animate-fade-in-up">
                    <?php _e('Transform Your Body, Elevate Your Life', 'fitlife-pro'); ?>
                </h1>
                <p class="text-lg md:text-xl lg:text-2xl mb-12 text-gray-100 opacity-95 animate-fade-in-up">
                    <?php _e('Discover thousands of exercises tailored to your fitness goals', 'fitlife-pro'); ?>
                </p>

                <!-- Search Box -->
                <div class="bg-white rounded-2xl shadow-2xl p-6 lg:p-8 animate-fade-in-up" data-animation-delay="400">
                    <form id="exercise-search-form" class="exercise-search-form" role="search" aria-label="<?php _e('Exercise search', 'fitlife-pro'); ?>">
                        <!-- Search Input -->
                        <div class="relative mb-5">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input
                                type="text"
                                id="search-input"
                                name="search"
                                class="block w-full pl-12 pr-4 py-4 text-lg border-2 border-gray-300 rounded-xl focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 focus:border-primary-500 transition-all duration-300"
                                placeholder="<?php _e('Search exercises... (e.g., push-ups, squats)', 'fitlife-pro'); ?>"
                                aria-label="<?php _e('Search for exercises', 'fitlife-pro'); ?>"
                            >
                        </div>

                        <!-- Filter Selects -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <select name="muscle_group" id="muscle-group-filter"
                                    class="px-4 py-3 text-base border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 focus:border-primary-500 transition-all duration-300 bg-white"
                                    aria-label="<?php _e('Filter by muscle group', 'fitlife-pro'); ?>">
                                <option value=""><?php _e('All Muscle Groups', 'fitlife-pro'); ?></option>
                                <?php
                                $all_muscles = get_terms(array('taxonomy' => 'muscle_group', 'hide_empty' => false));
                                foreach ($all_muscles as $muscle) {
                                    echo '<option value="' . esc_attr($muscle->slug) . '">' . esc_html($muscle->name) . '</option>';
                                }
                                ?>
                            </select>

                            <select name="equipment" id="equipment-filter"
                                    class="px-4 py-3 text-base border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 focus:border-primary-500 transition-all duration-300 bg-white"
                                    aria-label="<?php _e('Filter by equipment', 'fitlife-pro'); ?>">
                                <option value=""><?php _e('All Equipment', 'fitlife-pro'); ?></option>
                                <?php
                                $all_equipment = get_terms(array('taxonomy' => 'equipment', 'hide_empty' => false));
                                foreach ($all_equipment as $equip) {
                                    echo '<option value="' . esc_attr($equip->slug) . '">' . esc_html($equip->name) . '</option>';
                                }
                                ?>
                            </select>

                            <select name="difficulty" id="difficulty-filter"
                                    class="px-4 py-3 text-base border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 focus:border-primary-500 transition-all duration-300 bg-white"
                                    aria-label="<?php _e('Filter by difficulty level', 'fitlife-pro'); ?>">
                                <option value=""><?php _e('All Levels', 'fitlife-pro'); ?></option>
                                <?php
                                $all_difficulties = get_terms(array('taxonomy' => 'difficulty', 'hide_empty' => false));
                                foreach ($all_difficulties as $diff) {
                                    echo '<option value="' . esc_attr($diff->slug) . '">' . esc_html($diff->name) . '</option>';
                                }
                                ?>
                            </select>

                            <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-primary-500 to-accent-500 text-white font-bold text-base rounded-lg shadow-soft hover:shadow-primary hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50">
                                <?php _e('Search', 'fitlife-pro'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Dashboard -->
    <section class="py-16 lg:py-20 -mt-16 relative z-20">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <!-- Stat Card 1 -->
                <div class="bg-white rounded-xl shadow-soft hover:shadow-strong p-6 lg:p-8 hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 text-5xl" aria-hidden="true">🏋️</div>
                        <div class="flex-1">
                            <div class="text-3xl lg:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-primary-500 to-accent-500" data-stat="<?php echo $stats['total_exercises']; ?>">
                                <?php echo number_format($stats['total_exercises']); ?>
                            </div>
                            <p class="text-sm lg:text-base text-gray-600 font-medium mt-1">
                                <?php _e('Total Exercises', 'fitlife-pro'); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white rounded-xl shadow-soft hover:shadow-strong p-6 lg:p-8 hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 text-5xl" aria-hidden="true">💪</div>
                        <div class="flex-1">
                            <div class="text-3xl lg:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-primary-500 to-accent-500" data-stat="<?php echo $stats['muscle_groups']; ?>">
                                <?php echo number_format($stats['muscle_groups']); ?>
                            </div>
                            <p class="text-sm lg:text-base text-gray-600 font-medium mt-1">
                                <?php _e('Muscle Groups', 'fitlife-pro'); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white rounded-xl shadow-soft hover:shadow-strong p-6 lg:p-8 hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 text-5xl" aria-hidden="true">🔥</div>
                        <div class="flex-1">
                            <div class="text-3xl lg:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-primary-500 to-accent-500" data-stat="<?php echo $stats['total_calories']; ?>">
                                <?php echo number_format($stats['total_calories']); ?>+
                            </div>
                            <p class="text-sm lg:text-base text-gray-600 font-medium mt-1">
                                <?php _e('Calories Burned', 'fitlife-pro'); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-white rounded-xl shadow-soft hover:shadow-strong p-6 lg:p-8 hover:-translate-y-2 transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="flex-shrink-0 text-5xl" aria-hidden="true">⚡</div>
                        <div class="flex-1">
                            <div class="text-3xl lg:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-primary-500 to-accent-500" data-stat="<?php echo $stats['equipment_types']; ?>">
                                <?php echo number_format($stats['equipment_types']); ?>
                            </div>
                            <p class="text-sm lg:text-base text-gray-600 font-medium mt-1">
                                <?php _e('Equipment Types', 'fitlife-pro'); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Calorie Burning Exercises -->
    <section class="top-exercises-section py-16 lg:py-20 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="text-center mb-12 lg:mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    <span class="inline-block mr-2" aria-hidden="true">🔥</span>
                    <?php _e('Top Calorie Burning Exercises', 'fitlife-pro'); ?>
                </h2>
                <p class="text-lg lg:text-xl text-gray-600 max-w-2xl mx-auto">
                    <?php _e('Maximize your workout with these high-intensity exercises', 'fitlife-pro'); ?>
                </p>
            </div>

            <?php if ($top_exercises->have_posts()) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    <?php while ($top_exercises->have_posts()) : $top_exercises->the_post();
                        $calories = get_post_meta(get_the_ID(), '_exercise_calories', true);
                        $duration = get_post_meta(get_the_ID(), '_exercise_duration', true);
                        $difficulty_terms = get_the_terms(get_the_ID(), 'difficulty');
                        $difficulty_class = $difficulty_terms ? strtolower($difficulty_terms[0]->slug) : 'beginner';
                        $badge_color = $difficulty_class == 'beginner' ? 'bg-green-500' : ($difficulty_class == 'intermediate' ? 'bg-yellow-500 text-gray-900' : 'bg-red-500');
                        ?>
                        <article class="bg-white rounded-xl shadow-soft hover:shadow-strong overflow-hidden hover:-translate-y-2 transition-all duration-300 flex flex-col">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="aspect-w-16 aspect-h-12 overflow-hidden">
                                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'exercise-thumb'); ?>"
                                         alt="<?php the_title_attribute(); ?>"
                                         class="w-full h-48 object-cover hover:scale-110 transition-transform duration-500">
                                </div>
                            <?php else : ?>
                                <div class="h-48 bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center">
                                    <span class="text-6xl" aria-hidden="true">🏋️</span>
                                </div>
                            <?php endif; ?>

                            <div class="p-6 flex flex-col flex-1">
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <?php if ($calories) : ?>
                                        <span class="inline-flex items-center px-3 py-1 bg-primary-500 text-white text-xs font-semibold rounded-full">
                                            <?php echo esc_html($calories); ?> cal
                                        </span>
                                    <?php endif; ?>
                                    <span class="inline-flex items-center px-3 py-1 <?php echo $badge_color; ?> text-white text-xs font-semibold rounded-full">
                                        <?php echo $difficulty_terms ? esc_html($difficulty_terms[0]->name) : __('Beginner', 'fitlife-pro'); ?>
                                    </span>
                                </div>

                                <h3 class="text-xl font-bold text-gray-900 mb-3 hover:text-primary-500 transition-colors">
                                    <a href="<?php the_permalink(); ?>" class="no-underline">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <p class="text-gray-600 mb-4 flex-1 line-clamp-3">
                                    <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                </p>

                                <?php if ($duration) : ?>
                                    <div class="flex items-center text-sm text-gray-500 mb-4">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <?php echo esc_html($duration); ?> <?php _e('min', 'fitlife-pro'); ?>
                                    </div>
                                <?php endif; ?>

                                <a href="<?php the_permalink(); ?>"
                                   class="inline-flex items-center justify-center w-full px-6 py-3 border-2 border-primary-500 text-primary-500 font-semibold rounded-lg hover:bg-primary-500 hover:text-white transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 no-underline">
                                    <?php _e('View Details', 'fitlife-pro'); ?>
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>

                <div class="text-center mt-12">
                    <a href="<?php echo esc_url(home_url('/exercises')); ?>"
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary-500 to-accent-500 text-white font-bold text-lg rounded-xl shadow-soft hover:shadow-primary hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 no-underline">
                        <?php _e('Browse All Exercises', 'fitlife-pro'); ?>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            <?php else : ?>
                <div class="text-center py-12">
                    <p class="text-gray-600 text-lg">
                        <?php _e('No exercises found. Please add some exercises from the admin panel.', 'fitlife-pro'); ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Popular Muscle Groups -->
    <section class="py-16 lg:py-20">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="text-center mb-12 lg:mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    <span class="inline-block mr-2" aria-hidden="true">💪</span>
                    <?php _e('Train by Muscle Group', 'fitlife-pro'); ?>
                </h2>
                <p class="text-lg lg:text-xl text-gray-600 max-w-2xl mx-auto">
                    <?php _e('Target specific muscle groups for balanced development', 'fitlife-pro'); ?>
                </p>
            </div>

            <?php if (!empty($muscle_groups) && !is_wp_error($muscle_groups)) :
                $muscle_icons = array(
                    'chest' => '🫁', 'back' => '🔙', 'shoulders' => '💪', 'arms' => '💪',
                    'legs' => '🦵', 'core' => '⚡', 'abs' => '📦', 'glutes' => '🍑',
                ); ?>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 lg:gap-6">
                    <?php foreach ($muscle_groups as $muscle) :
                        $icon = isset($muscle_icons[strtolower($muscle->slug)]) ? $muscle_icons[strtolower($muscle->slug)] : '💪';
                        ?>
                        <a href="<?php echo get_term_link($muscle); ?>"
                           class="group bg-white rounded-xl shadow-soft hover:shadow-strong p-6 lg:p-8 text-center hover:-translate-y-2 hover:bg-gradient-to-br hover:from-primary-500 hover:to-accent-500 transition-all duration-300 no-underline">
                            <div class="text-5xl lg:text-6xl mb-4 group-hover:scale-110 transition-transform duration-300" aria-hidden="true">
                                <?php echo $icon; ?>
                            </div>
                            <h3 class="text-base lg:text-lg font-bold text-gray-900 group-hover:text-white transition-colors mb-2">
                                <?php echo esc_html($muscle->name); ?>
                            </h3>
                            <p class="text-sm text-gray-600 group-hover:text-white group-hover:text-opacity-90 transition-colors">
                                <?php echo $muscle->count; ?> <?php _e('exercises', 'fitlife-pro'); ?>
                            </p>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p class="text-center text-gray-600">
                    <?php _e('No muscle groups found. Please add some from the admin panel.', 'fitlife-pro'); ?>
                </p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Equipment Types -->
    <section class="py-16 lg:py-20 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="text-center mb-12 lg:mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    <span class="inline-block mr-2" aria-hidden="true">⚡</span>
                    <?php _e('Equipment Categories', 'fitlife-pro'); ?>
                </h2>
                <p class="text-lg lg:text-xl text-gray-600 max-w-2xl mx-auto">
                    <?php _e('Choose exercises based on available equipment', 'fitlife-pro'); ?>
                </p>
            </div>

            <?php if (!empty($equipment_types) && !is_wp_error($equipment_types)) :
                $equipment_icons = array(
                    'barbell' => '🏋️', 'dumbbell' => '💪', 'kettlebell' => '🔔',
                    'bodyweight' => '🧘', 'machine' => '🔧', 'cable' => '🔗',
                    'bands' => '🎀', 'none' => '🆓',
                ); ?>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 lg:gap-6">
                    <?php foreach ($equipment_types as $equipment) :
                        $icon = isset($equipment_icons[strtolower($equipment->slug)]) ? $equipment_icons[strtolower($equipment->slug)] : '⚡';
                        ?>
                        <a href="<?php echo get_term_link($equipment); ?>"
                           class="group bg-white rounded-xl shadow-soft hover:shadow-strong p-6 lg:p-8 text-center hover:-translate-y-2 hover:bg-gradient-to-br hover:from-primary-500 hover:to-accent-500 transition-all duration-300 no-underline">
                            <div class="text-5xl lg:text-6xl mb-4 group-hover:scale-110 transition-transform duration-300" aria-hidden="true">
                                <?php echo $icon; ?>
                            </div>
                            <h3 class="text-base lg:text-lg font-bold text-gray-900 group-hover:text-white transition-colors mb-2">
                                <?php echo esc_html($equipment->name); ?>
                            </h3>
                            <p class="text-sm text-gray-600 group-hover:text-white group-hover:text-opacity-90 transition-colors">
                                <?php echo $equipment->count; ?> <?php _e('exercises', 'fitlife-pro'); ?>
                            </p>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p class="text-center text-gray-600">
                    <?php _e('No equipment types found. Please add some from the admin panel.', 'fitlife-pro'); ?>
                </p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Difficulty Levels -->
    <section class="py-16 lg:py-20">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="text-center mb-12 lg:mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    <span class="inline-block mr-2" aria-hidden="true">📊</span>
                    <?php _e('Choose Your Level', 'fitlife-pro'); ?>
                </h2>
                <p class="text-lg lg:text-xl text-gray-600 max-w-2xl mx-auto">
                    <?php _e('Find exercises that match your fitness level', 'fitlife-pro'); ?>
                </p>
            </div>

            <?php if (!empty($difficulty_levels) && !is_wp_error($difficulty_levels)) :
                $difficulty_data = array(
                    'beginner' => array(
                        'icon' => '🌱',
                        'color' => 'border-green-500',
                        'bg' => 'bg-green-50',
                        'text' => 'text-green-600',
                        'description' => __('Perfect for those just starting their fitness journey', 'fitlife-pro'),
                    ),
                    'intermediate' => array(
                        'icon' => '🔥',
                        'color' => 'border-yellow-500',
                        'bg' => 'bg-yellow-50',
                        'text' => 'text-yellow-600',
                        'description' => __('For those with some experience looking to level up', 'fitlife-pro'),
                    ),
                    'advanced' => array(
                        'icon' => '⚡',
                        'color' => 'border-red-500',
                        'bg' => 'bg-red-50',
                        'text' => 'text-red-600',
                        'description' => __('Challenging exercises for experienced athletes', 'fitlife-pro'),
                    ),
                ); ?>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 max-w-5xl mx-auto">
                    <?php foreach ($difficulty_levels as $difficulty) :
                        $slug = strtolower($difficulty->slug);
                        $data = isset($difficulty_data[$slug]) ? $difficulty_data[$slug] : $difficulty_data['beginner'];
                        ?>
                        <div class="bg-white rounded-xl shadow-soft hover:shadow-strong p-8 border-t-4 <?php echo $data['color']; ?> hover:-translate-y-2 transition-all duration-300">
                            <div class="text-center">
                                <div class="text-6xl mb-6 <?php echo $data['text']; ?>" aria-hidden="true">
                                    <?php echo $data['icon']; ?>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">
                                    <?php echo esc_html($difficulty->name); ?>
                                </h3>
                                <p class="text-gray-600 mb-6 leading-relaxed">
                                    <?php echo $data['description']; ?>
                                </p>
                                <div class="inline-flex items-center px-4 py-2 <?php echo $data['bg']; ?> <?php echo $data['text']; ?> font-semibold text-sm rounded-full mb-6">
                                    <?php echo $difficulty->count; ?> <?php _e('exercises', 'fitlife-pro'); ?>
                                </div>
                                <a href="<?php echo get_term_link($difficulty); ?>"
                                   class="block w-full px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:border-primary-500 hover:text-primary-500 hover:bg-gray-50 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 no-underline text-center">
                                    <?php _e('Start Training', 'fitlife-pro'); ?>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <p class="text-center text-gray-600">
                    <?php _e('No difficulty levels found. Please add Beginner, Intermediate, and Advanced from the admin panel.', 'fitlife-pro'); ?>
                </p>
            <?php endif; ?>
        </div>
    </section>

    <!-- FAQ Section with Schema Markup -->
    <section class="py-16 lg:py-20 bg-gray-50">
        <div class="container mx-auto px-4 lg:px-6">
            <div class="text-center mb-12 lg:mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    <span class="inline-block mr-2" aria-hidden="true">❓</span>
                    <?php _e('Frequently Asked Questions', 'fitlife-pro'); ?>
                </h2>
                <p class="text-lg lg:text-xl text-gray-600 max-w-2xl mx-auto">
                    <?php _e('Everything you need to know about fitness and our platform', 'fitlife-pro'); ?>
                </p>
            </div>

            <div class="max-w-3xl mx-auto space-y-4">
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
                    $schema['mainEntity'][] = array(
                        '@type' => 'Question',
                        'name' => $faq['question'],
                        'acceptedAnswer' => array(
                            '@type' => 'Answer',
                            'text' => $faq['answer'],
                        ),
                    );
                    ?>
                    <div class="faq-item bg-white rounded-xl shadow-soft overflow-hidden">
                        <button
                            type="button"
                            class="faq-question w-full px-6 py-5 flex justify-between items-center gap-4 text-left bg-white hover:bg-gray-50 transition-colors duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50"
                            data-faq-question="faq-<?php echo $index; ?>"
                            aria-expanded="false"
                            aria-controls="faq-<?php echo $index; ?>">
                            <span class="text-lg font-semibold text-gray-900 flex-1">
                                <?php echo esc_html($faq['question']); ?>
                            </span>
                            <span class="faq-toggle text-2xl font-bold text-primary-500 flex-shrink-0 transition-transform duration-300">
                                +
                            </span>
                        </button>
                        <div id="faq-<?php echo $index; ?>" class="faq-answer max-h-0 overflow-hidden transition-all duration-300">
                            <div class="px-6 py-5 text-gray-600 leading-relaxed">
                                <?php echo esc_html($faq['answer']); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Schema Markup Output -->
            <script type="application/ld+json">
            <?php echo json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
            </script>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 lg:py-28 bg-gradient-to-br from-primary-600 via-primary-700 to-accent-600 text-white relative overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 bg-black bg-opacity-10 pattern-grid"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-white rounded-full mix-blend-soft-light filter blur-3xl opacity-10"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-white rounded-full mix-blend-soft-light filter blur-3xl opacity-10"></div>

        <div class="container mx-auto px-4 lg:px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold mb-6 drop-shadow-lg">
                    <?php _e('Ready to Transform Your Fitness Journey?', 'fitlife-pro'); ?>
                </h2>
                <p class="text-lg md:text-xl lg:text-2xl mb-10 text-white text-opacity-95 max-w-2xl mx-auto">
                    <?php _e('Start exploring thousands of exercises and build your perfect workout routine today', 'fitlife-pro'); ?>
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="<?php echo esc_url(home_url('/exercises')); ?>"
                       class="inline-flex items-center px-8 py-4 bg-white text-primary-600 font-bold text-lg rounded-xl shadow-strong hover:shadow-2xl hover:scale-105 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-50 no-underline">
                        <?php _e('Get Started Now', 'fitlife-pro'); ?>
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                    <a href="<?php echo esc_url(home_url('/about')); ?>"
                       class="inline-flex items-center px-8 py-4 bg-transparent border-2 border-white text-white font-bold text-lg rounded-xl hover:bg-white hover:text-primary-600 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-white focus:ring-opacity-50 no-underline">
                        <?php _e('Learn More', 'fitlife-pro'); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
