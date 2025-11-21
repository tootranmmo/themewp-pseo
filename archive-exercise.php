<?php
/**
 * Archive template for exercises
 *
 * @package FitLife_Pro
 * @version 2.0.0
 */

get_header();
?>

<main id="main" class="site-main">
    <!-- Archive Header -->
    <div class="archive-header relative bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-800 text-white py-16 lg:py-20 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10 pattern-grid" aria-hidden="true"></div>

        <div class="container mx-auto px-4 lg:px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl lg:text-5xl font-extrabold mb-4 text-white drop-shadow-lg">
                    <?php
                    if (is_tax()) {
                        single_term_title();
                    } else {
                        _e('All Exercises', 'fitlife-pro');
                    }
                    ?>
                </h1>

                <?php if (is_tax() && term_description()) : ?>
                    <div class="archive-description text-lg text-white/90 leading-relaxed max-w-2xl mx-auto">
                        <?php echo term_description(); ?>
                    </div>
                <?php endif; ?>

                <!-- Exercise Count -->
                <?php
                global $wp_query;
                $total_exercises = $wp_query->found_posts;
                if ($total_exercises > 0) :
                    ?>
                    <p class="mt-6 text-white/80 text-sm">
                        <?php
                        printf(
                            /* translators: %s: number of exercises */
                            _n('%s exercise found', '%s exercises found', $total_exercises, 'fitlife-pro'),
                            '<span class="font-bold text-white">' . number_format_i18n($total_exercises) . '</span>'
                        );
                        ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Archive Content -->
    <div class="container mx-auto px-4 lg:px-6 py-12 lg:py-16">
        <!-- Filters Section -->
        <div class="archive-filters bg-white rounded-xl shadow-soft p-6 lg:p-8 mb-8 lg:mb-12">
            <div class="flex items-center gap-3 mb-6">
                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                <h2 class="text-xl font-bold text-gray-900">
                    <?php _e('Filter Exercises', 'fitlife-pro'); ?>
                </h2>
            </div>

            <form method="get" class="filter-form grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"
                  role="search"
                  aria-label="<?php _e('Filter exercises by criteria', 'fitlife-pro'); ?>">

                <!-- Muscle Group Filter -->
                <div>
                    <label for="muscle_group" class="block text-sm font-semibold text-gray-700 mb-2">
                        <?php _e('Muscle Group', 'fitlife-pro'); ?>
                    </label>
                    <select name="muscle_group" id="muscle_group"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 focus:border-primary-500 transition-all duration-300 bg-white">
                        <option value=""><?php _e('All Muscle Groups', 'fitlife-pro'); ?></option>
                        <?php
                        $muscle_groups = get_terms(array('taxonomy' => 'muscle_group', 'hide_empty' => false));
                        if ($muscle_groups && !is_wp_error($muscle_groups)) :
                            foreach ($muscle_groups as $term) :
                                $selected = isset($_GET['muscle_group']) && $_GET['muscle_group'] == $term->slug ? 'selected' : '';
                                ?>
                                <option value="<?php echo esc_attr($term->slug); ?>" <?php echo $selected; ?>>
                                    <?php echo esc_html($term->name); ?> (<?php echo $term->count; ?>)
                                </option>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>

                <!-- Equipment Filter -->
                <div>
                    <label for="equipment" class="block text-sm font-semibold text-gray-700 mb-2">
                        <?php _e('Equipment', 'fitlife-pro'); ?>
                    </label>
                    <select name="equipment" id="equipment"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 focus:border-primary-500 transition-all duration-300 bg-white">
                        <option value=""><?php _e('All Equipment', 'fitlife-pro'); ?></option>
                        <?php
                        $equipment_terms = get_terms(array('taxonomy' => 'equipment', 'hide_empty' => false));
                        if ($equipment_terms && !is_wp_error($equipment_terms)) :
                            foreach ($equipment_terms as $term) :
                                $selected = isset($_GET['equipment']) && $_GET['equipment'] == $term->slug ? 'selected' : '';
                                ?>
                                <option value="<?php echo esc_attr($term->slug); ?>" <?php echo $selected; ?>>
                                    <?php echo esc_html($term->name); ?> (<?php echo $term->count; ?>)
                                </option>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>

                <!-- Difficulty Filter -->
                <div>
                    <label for="difficulty" class="block text-sm font-semibold text-gray-700 mb-2">
                        <?php _e('Difficulty Level', 'fitlife-pro'); ?>
                    </label>
                    <select name="difficulty" id="difficulty"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 focus:border-primary-500 transition-all duration-300 bg-white">
                        <option value=""><?php _e('All Levels', 'fitlife-pro'); ?></option>
                        <?php
                        $difficulty_terms = get_terms(array('taxonomy' => 'difficulty', 'hide_empty' => false));
                        if ($difficulty_terms && !is_wp_error($difficulty_terms)) :
                            foreach ($difficulty_terms as $term) :
                                $selected = isset($_GET['difficulty']) && $_GET['difficulty'] == $term->slug ? 'selected' : '';
                                ?>
                                <option value="<?php echo esc_attr($term->slug); ?>" <?php echo $selected; ?>>
                                    <?php echo esc_html($term->name); ?> (<?php echo $term->count; ?>)
                                </option>
                            <?php
                            endforeach;
                        endif;
                        ?>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="flex items-end">
                    <button type="submit"
                            class="w-full px-6 py-3 bg-gradient-to-r from-primary-500 to-accent-500 text-white font-bold rounded-lg shadow-soft hover:shadow-strong hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50">
                        <span class="inline-flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            <?php _e('Apply Filters', 'fitlife-pro'); ?>
                        </span>
                    </button>
                </div>
            </form>

            <!-- Active Filters Display -->
            <?php
            $active_filters = array();
            if (isset($_GET['muscle_group']) && !empty($_GET['muscle_group'])) {
                $active_filters['muscle_group'] = $_GET['muscle_group'];
            }
            if (isset($_GET['equipment']) && !empty($_GET['equipment'])) {
                $active_filters['equipment'] = $_GET['equipment'];
            }
            if (isset($_GET['difficulty']) && !empty($_GET['difficulty'])) {
                $active_filters['difficulty'] = $_GET['difficulty'];
            }

            if (!empty($active_filters)) :
                ?>
                <div class="active-filters mt-6 pt-6 border-t border-gray-200">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-sm font-semibold text-gray-700">
                            <?php _e('Active filters:', 'fitlife-pro'); ?>
                        </span>
                        <?php foreach ($active_filters as $key => $value) : ?>
                            <a href="<?php echo esc_url(remove_query_arg($key)); ?>"
                               class="inline-flex items-center gap-2 px-3 py-1 bg-primary-100 text-primary-700 text-sm rounded-full hover:bg-red-100 hover:text-red-700 transition-colors duration-300 no-underline">
                                <span><?php echo esc_html(ucfirst(str_replace('_', ' ', $value))); ?></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                        <?php endforeach; ?>
                        <a href="<?php echo esc_url(remove_query_arg(array_keys($active_filters))); ?>"
                           class="text-sm text-gray-500 hover:text-red-600 transition-colors no-underline">
                            <?php _e('Clear all', 'fitlife-pro'); ?>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Exercise Results -->
        <div class="exercise-results">
            <?php if (have_posts()) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mb-12">
                    <?php
                    while (have_posts()) :
                        the_post();
                        get_template_part('template-parts/content', 'exercise-card');
                    endwhile;
                    ?>
                </div>

                <!-- Pagination -->
                <nav class="pagination mt-12" role="navigation" aria-label="<?php _e('Exercises pagination', 'fitlife-pro'); ?>">
                    <?php
                    the_posts_pagination(array(
                        'mid_size'           => 2,
                        'prev_text'          => '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg> ' . __('Previous', 'fitlife-pro'),
                        'next_text'          => __('Next', 'fitlife-pro') . ' <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
                        'before_page_number' => '<span class="screen-reader-text">' . __('Page', 'fitlife-pro') . ' </span>',
                        'class'              => 'flex flex-wrap justify-center items-center gap-2',
                    ));
                    ?>
                </nav>

            <?php else : ?>
                <!-- No Results -->
                <div class="no-results bg-white rounded-xl shadow-soft p-8 lg:p-12 text-center">
                    <div class="mb-6">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">
                        <?php _e('No exercises found.', 'fitlife-pro'); ?>
                    </h2>
                    <p class="text-gray-600 mb-6">
                        <?php _e('Try adjusting your filters or browse all exercises.', 'fitlife-pro'); ?>
                    </p>
                    <a href="<?php echo esc_url(get_post_type_archive_link('exercise')); ?>"
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-500 to-accent-500 text-white font-bold rounded-lg shadow-soft hover:shadow-strong hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 no-underline">
                        <?php _e('View All Exercises', 'fitlife-pro'); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<style>
/* Pagination Styling */
.pagination .nav-links {
    @apply flex flex-wrap justify-center items-center gap-2;
}

.pagination .page-numbers {
    @apply inline-flex items-center justify-center min-w-[2.5rem] h-10 px-3 bg-white border-2 border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-primary-500 hover:text-white hover:border-primary-500 transition-all duration-300 no-underline;
}

.pagination .page-numbers.current {
    @apply bg-gradient-to-r from-primary-500 to-accent-500 text-white border-primary-500 shadow-soft;
}

.pagination .page-numbers.dots {
    @apply border-0 hover:bg-transparent hover:text-gray-700;
}

.pagination .prev,
.pagination .next {
    @apply inline-flex items-center px-4 py-2 bg-white border-2 border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-primary-500 hover:text-white hover:border-primary-500 transition-all duration-300 no-underline;
}

/* Grid Pattern */
.pattern-grid {
    background-image: radial-gradient(circle, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
    background-size: 30px 30px;
}

/* Reduced Motion Support */
@media (prefers-reduced-motion: reduce) {
    .archive-filters select,
    .archive-filters button,
    .pagination a {
        transition: none !important;
    }
}

/* Print Styles */
@media print {
    .archive-header {
        @apply bg-white text-gray-900 py-8;
    }

    .archive-filters,
    .pagination,
    .active-filters {
        @apply hidden;
    }

    .exercise-results {
        @apply grid-cols-2;
    }
}
</style>

<?php
get_footer();
