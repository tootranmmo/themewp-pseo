<?php
/**
 * Template part for displaying exercise cards
 *
 * @package FitLife_Pro
 * @version 2.0.0
 */

$calories = get_post_meta(get_the_ID(), '_exercise_calories', true);
$duration = get_post_meta(get_the_ID(), '_exercise_duration', true);
$difficulty_terms = get_the_terms(get_the_ID(), 'difficulty');
$difficulty_slug = $difficulty_terms ? strtolower($difficulty_terms[0]->slug) : 'beginner';

// Difficulty badge colors (Tailwind classes)
$difficulty_colors = array(
    'beginner'     => 'bg-green-500 text-white',
    'intermediate' => 'bg-yellow-500 text-white',
    'advanced'     => 'bg-red-500 text-white',
);
$difficulty_color = isset($difficulty_colors[$difficulty_slug]) ? $difficulty_colors[$difficulty_slug] : $difficulty_colors['beginner'];
?>

<article class="exercise-card bg-white rounded-xl shadow-soft hover:shadow-strong overflow-hidden hover:-translate-y-2 transition-all duration-300 group">
    <?php if (has_post_thumbnail()) : ?>
        <div class="relative overflow-hidden h-48">
            <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'exercise-thumb')); ?>"
                 alt="<?php the_title_attribute(); ?>"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">

            <!-- Overlay gradient on hover -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        </div>
    <?php else : ?>
        <div class="h-48 bg-gradient-to-br from-purple-500 via-purple-600 to-indigo-600 flex items-center justify-center">
            <span class="text-6xl" role="img" aria-label="<?php _e('Exercise icon', 'fitlife-pro'); ?>">🏋️</span>
        </div>
    <?php endif; ?>

    <div class="p-6">
        <!-- Badges -->
        <div class="flex flex-wrap gap-2 mb-3">
            <?php if ($calories) : ?>
                <span class="inline-flex items-center px-3 py-1 bg-primary-500 text-white text-xs font-semibold rounded-full uppercase tracking-wide"
                      aria-label="<?php printf(__('Burns %s calories', 'fitlife-pro'), esc_attr($calories)); ?>">
                    🔥 <?php echo esc_html($calories); ?> cal
                </span>
            <?php endif; ?>

            <span class="inline-flex items-center px-3 py-1 <?php echo esc_attr($difficulty_color); ?> text-xs font-semibold rounded-full uppercase tracking-wide"
                  aria-label="<?php _e('Difficulty level:', 'fitlife-pro'); ?> <?php echo $difficulty_terms ? esc_attr($difficulty_terms[0]->name) : __('Beginner', 'fitlife-pro'); ?>">
                <?php echo $difficulty_terms ? esc_html($difficulty_terms[0]->name) : __('Beginner', 'fitlife-pro'); ?>
            </span>
        </div>

        <!-- Title -->
        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-primary-500 transition-colors duration-300">
            <a href="<?php the_permalink(); ?>"
               class="no-underline hover:underline focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 rounded"
               aria-label="<?php printf(__('View details about %s', 'fitlife-pro'), esc_attr(get_the_title())); ?>">
                <?php the_title(); ?>
            </a>
        </h3>

        <!-- Excerpt -->
        <p class="text-gray-600 text-sm mb-4 leading-relaxed line-clamp-3">
            <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
        </p>

        <!-- Meta Information -->
        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-4 pb-4 border-b border-gray-200">
            <?php if ($duration) : ?>
                <span class="inline-flex items-center gap-1"
                      aria-label="<?php printf(__('Duration: %s minutes', 'fitlife-pro'), esc_attr($duration)); ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <?php echo esc_html($duration); ?> min
                </span>
            <?php endif; ?>

            <?php
            $muscle_terms = get_the_terms(get_the_ID(), 'muscle_group');
            if ($muscle_terms && !is_wp_error($muscle_terms)) :
                ?>
                <span class="inline-flex items-center gap-1"
                      aria-label="<?php printf(__('Targets: %s', 'fitlife-pro'), esc_attr($muscle_terms[0]->name)); ?>">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <?php echo esc_html($muscle_terms[0]->name); ?>
                </span>
            <?php endif; ?>
        </div>

        <!-- View Details Button -->
        <a href="<?php the_permalink(); ?>"
           class="inline-flex items-center justify-center w-full px-6 py-3 border-2 border-primary-500 text-primary-500 font-semibold text-sm rounded-lg hover:bg-primary-500 hover:text-white transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 no-underline"
           aria-label="<?php printf(__('View full details about %s', 'fitlife-pro'), esc_attr(get_the_title())); ?>">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
            <?php _e('View Details', 'fitlife-pro'); ?>
        </a>
    </div>
</article>

<style>
/* Line clamp utility (for excerpt truncation) */
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Reduced Motion Support */
@media (prefers-reduced-motion: reduce) {
    .exercise-card,
    .exercise-card img,
    .exercise-card a {
        transition: none !important;
    }
}

/* Print Styles */
@media print {
    .exercise-card {
        @apply shadow-none border border-gray-300 page-break-inside-avoid;
    }

    .exercise-card a {
        @apply text-gray-900 no-underline;
    }
}
</style>
