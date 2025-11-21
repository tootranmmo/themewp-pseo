<?php
/**
 * Single Exercise Template
 *
 * @package FitLife_Pro
 * @version 2.0.0
 */

get_header();

while (have_posts()) :
    the_post();

    // Get exercise meta data
    $calories = get_post_meta(get_the_ID(), '_exercise_calories', true);
    $duration = get_post_meta(get_the_ID(), '_exercise_duration', true);
    $sets = get_post_meta(get_the_ID(), '_exercise_sets', true);
    $reps = get_post_meta(get_the_ID(), '_exercise_reps', true);
    $video_url = get_post_meta(get_the_ID(), '_exercise_video_url', true);

    // Get taxonomies
    $muscle_groups = get_the_terms(get_the_ID(), 'muscle_group');
    $equipment = get_the_terms(get_the_ID(), 'equipment');
    $difficulty = get_the_terms(get_the_ID(), 'difficulty');
    $difficulty_slug = $difficulty && !is_wp_error($difficulty) ? strtolower($difficulty[0]->slug) : 'beginner';

    // Difficulty colors
    $difficulty_colors = array(
        'beginner'     => 'bg-green-500 text-white',
        'intermediate' => 'bg-yellow-500 text-white',
        'advanced'     => 'bg-red-500 text-white',
    );
    $difficulty_color = isset($difficulty_colors[$difficulty_slug]) ? $difficulty_colors[$difficulty_slug] : $difficulty_colors['beginner'];
    ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('single-exercise'); ?>>
        <!-- Exercise Header -->
        <div class="exercise-header bg-gradient-to-br from-gray-50 to-gray-100 py-12 lg:py-16 border-b border-gray-200">
            <div class="container mx-auto px-4 lg:px-6">
                <div class="max-w-4xl mx-auto text-center">
                    <!-- Breadcrumbs -->
                    <nav class="flex justify-center mb-6" aria-label="<?php _e('Breadcrumb', 'fitlife-pro'); ?>">
                        <ol class="inline-flex items-center space-x-2 text-sm text-gray-500">
                            <li>
                                <a href="<?php echo esc_url(home_url('/')); ?>"
                                   class="hover:text-primary-500 transition-colors no-underline">
                                    <?php _e('Home', 'fitlife-pro'); ?>
                                </a>
                            </li>
                            <li>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </li>
                            <li>
                                <a href="<?php echo esc_url(get_post_type_archive_link('exercise')); ?>"
                                   class="hover:text-primary-500 transition-colors no-underline">
                                    <?php _e('Exercises', 'fitlife-pro'); ?>
                                </a>
                            </li>
                            <li>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </li>
                            <li class="text-gray-900 font-semibold" aria-current="page">
                                <?php the_title(); ?>
                            </li>
                        </ol>
                    </nav>

                    <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-6 leading-tight">
                        <?php the_title(); ?>
                    </h1>

                    <!-- Meta Badges -->
                    <div class="flex flex-wrap justify-center items-center gap-3">
                        <?php if ($difficulty && !is_wp_error($difficulty)) : ?>
                            <span class="inline-flex items-center px-4 py-2 <?php echo esc_attr($difficulty_color); ?> text-sm font-semibold rounded-full uppercase tracking-wide">
                                <?php echo esc_html($difficulty[0]->name); ?>
                            </span>
                        <?php endif; ?>

                        <?php if ($calories) : ?>
                            <span class="inline-flex items-center px-4 py-2 bg-primary-500 text-white text-sm font-semibold rounded-full">
                                🔥 <?php echo esc_html($calories); ?> cal
                            </span>
                        <?php endif; ?>

                        <?php if ($duration) : ?>
                            <span class="inline-flex items-center px-4 py-2 bg-accent-500 text-white text-sm font-semibold rounded-full">
                                ⏱️ <?php echo esc_html($duration); ?> min
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exercise Content -->
        <div class="exercise-content py-12 lg:py-16">
            <div class="container mx-auto px-4 lg:px-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                    <!-- Main Content -->
                    <div class="lg:col-span-2">
                        <!-- Featured Image -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="exercise-image bg-white rounded-xl shadow-soft overflow-hidden mb-8">
                                <?php the_post_thumbnail('large', array(
                                    'class' => 'w-full h-auto',
                                    'loading' => 'eager'
                                )); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Exercise Description -->
                        <div class="exercise-description bg-white rounded-xl shadow-soft p-6 lg:p-8 mb-8">
                            <div class="flex items-center gap-3 mb-6">
                                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h2 class="text-2xl font-bold text-gray-900">
                                    <?php _e('Exercise Description', 'fitlife-pro'); ?>
                                </h2>
                            </div>

                            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                                <?php the_content(); ?>
                            </div>
                        </div>

                        <!-- Video Tutorial -->
                        <?php if ($video_url) : ?>
                            <div class="exercise-video bg-white rounded-xl shadow-soft p-6 lg:p-8">
                                <div class="flex items-center gap-3 mb-6">
                                    <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    <h2 class="text-2xl font-bold text-gray-900">
                                        <?php _e('Video Tutorial', 'fitlife-pro'); ?>
                                    </h2>
                                </div>

                                <div class="video-wrapper relative rounded-lg overflow-hidden bg-black" style="padding-bottom: 56.25%; height: 0;">
                                    <?php echo wp_oembed_get($video_url); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Sidebar -->
                    <aside class="lg:col-span-1">
                        <!-- Exercise Details Card -->
                        <div class="exercise-info-card bg-white rounded-xl shadow-soft p-6 lg:p-8 sticky top-24">
                            <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-200">
                                <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="text-xl font-bold text-gray-900">
                                    <?php _e('Exercise Details', 'fitlife-pro'); ?>
                                </h3>
                            </div>

                            <div class="exercise-info-list space-y-4">
                                <?php if ($duration) : ?>
                                    <div class="info-item flex items-start gap-4 pb-4 border-b border-gray-100">
                                        <div class="info-icon flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-xl">
                                            ⏱️
                                        </div>
                                        <div class="info-content flex-1">
                                            <strong class="block text-sm font-semibold text-gray-900 mb-1">
                                                <?php _e('Duration', 'fitlife-pro'); ?>
                                            </strong>
                                            <span class="text-gray-600">
                                                <?php echo esc_html($duration); ?> <?php _e('minutes', 'fitlife-pro'); ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($sets) : ?>
                                    <div class="info-item flex items-start gap-4 pb-4 border-b border-gray-100">
                                        <div class="info-icon flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-xl">
                                            🔢
                                        </div>
                                        <div class="info-content flex-1">
                                            <strong class="block text-sm font-semibold text-gray-900 mb-1">
                                                <?php _e('Sets', 'fitlife-pro'); ?>
                                            </strong>
                                            <span class="text-gray-600">
                                                <?php echo esc_html($sets); ?> sets
                                            </span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($reps) : ?>
                                    <div class="info-item flex items-start gap-4 pb-4 border-b border-gray-100">
                                        <div class="info-icon flex-shrink-0 w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center text-xl">
                                            🔁
                                        </div>
                                        <div class="info-content flex-1">
                                            <strong class="block text-sm font-semibold text-gray-900 mb-1">
                                                <?php _e('Repetitions', 'fitlife-pro'); ?>
                                            </strong>
                                            <span class="text-gray-600">
                                                <?php echo esc_html($reps); ?> reps
                                            </span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($muscle_groups && !is_wp_error($muscle_groups)) : ?>
                                    <div class="info-item flex items-start gap-4 pb-4 border-b border-gray-100">
                                        <div class="info-icon flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center text-xl">
                                            💪
                                        </div>
                                        <div class="info-content flex-1">
                                            <strong class="block text-sm font-semibold text-gray-900 mb-1">
                                                <?php _e('Muscle Groups', 'fitlife-pro'); ?>
                                            </strong>
                                            <div class="flex flex-wrap gap-2 mt-2">
                                                <?php foreach ($muscle_groups as $muscle) : ?>
                                                    <a href="<?php echo esc_url(get_term_link($muscle)); ?>"
                                                       class="inline-flex items-center px-3 py-1 bg-gray-100 hover:bg-primary-500 text-gray-700 hover:text-white text-sm rounded-full transition-colors duration-300 no-underline">
                                                        <?php echo esc_html($muscle->name); ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($equipment && !is_wp_error($equipment)) : ?>
                                    <div class="info-item flex items-start gap-4">
                                        <div class="info-icon flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center text-xl">
                                            ⚡
                                        </div>
                                        <div class="info-content flex-1">
                                            <strong class="block text-sm font-semibold text-gray-900 mb-1">
                                                <?php _e('Equipment', 'fitlife-pro'); ?>
                                            </strong>
                                            <div class="flex flex-wrap gap-2 mt-2">
                                                <?php foreach ($equipment as $equip) : ?>
                                                    <a href="<?php echo esc_url(get_term_link($equip)); ?>"
                                                       class="inline-flex items-center px-3 py-1 bg-gray-100 hover:bg-accent-500 text-gray-700 hover:text-white text-sm rounded-full transition-colors duration-300 no-underline">
                                                        <?php echo esc_html($equip->name); ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Browse More Button -->
                            <div class="mt-8 pt-6 border-t border-gray-200">
                                <a href="<?php echo esc_url(get_post_type_archive_link('exercise')); ?>"
                                   class="inline-flex items-center justify-center w-full px-6 py-3 bg-gradient-to-r from-primary-500 to-accent-500 text-white font-bold rounded-lg shadow-soft hover:shadow-strong hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 no-underline">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                                    </svg>
                                    <?php _e('Browse More Exercises', 'fitlife-pro'); ?>
                                </a>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </article>

    <style>
    /* Prose Styles for Exercise Content */
    .exercise-description .prose p {
        @apply mb-4;
    }

    .exercise-description .prose h2,
    .exercise-description .prose h3,
    .exercise-description .prose h4 {
        @apply font-bold text-gray-900 mt-6 mb-3;
    }

    .exercise-description .prose h2 {
        @apply text-xl lg:text-2xl;
    }

    .exercise-description .prose h3 {
        @apply text-lg lg:text-xl;
    }

    .exercise-description .prose ul,
    .exercise-description .prose ol {
        @apply mb-4 pl-6;
    }

    .exercise-description .prose ul {
        @apply list-disc;
    }

    .exercise-description .prose ol {
        @apply list-decimal;
    }

    .exercise-description .prose li {
        @apply mb-2;
    }

    .exercise-description .prose strong {
        @apply font-bold text-gray-900;
    }

    .exercise-description .prose a {
        @apply text-primary-500 hover:text-primary-600 underline;
    }

    /* Video Wrapper */
    .video-wrapper iframe {
        @apply absolute top-0 left-0 w-full h-full;
    }

    /* Sticky Sidebar */
    @supports (position: sticky) {
        .exercise-info-card {
            position: sticky;
            top: 6rem; /* 96px */
        }
    }

    /* Reduced Motion Support */
    @media (prefers-reduced-motion: reduce) {
        .exercise-info-card a {
            transition: none !important;
        }
    }

    /* Print Styles */
    @media print {
        .exercise-header {
            @apply bg-white py-8;
        }

        .video-wrapper,
        .exercise-info-card a {
            @apply hidden;
        }

        .exercise-info-card {
            @apply static shadow-none border border-gray-300;
        }

        .exercise-content {
            @apply py-8;
        }
    }
    </style>

    <?php
endwhile;

get_footer();
