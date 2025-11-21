<?php
/**
 * Single Exercise Template
 *
 * @package FitLife_Pro
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
    ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('single-exercise'); ?>>
        <div class="container">
            <div class="exercise-content">
                <header class="exercise-header">
                    <h1 class="exercise-title"><?php the_title(); ?></h1>

                    <div class="exercise-meta-badges">
                        <?php if ($difficulty && !is_wp_error($difficulty)) : ?>
                            <span class="badge badge-<?php echo esc_attr(strtolower($difficulty[0]->slug)); ?>">
                                <?php echo esc_html($difficulty[0]->name); ?>
                            </span>
                        <?php endif; ?>

                        <?php if ($calories) : ?>
                            <span class="badge badge-calories"><?php echo esc_html($calories); ?> cal</span>
                        <?php endif; ?>
                    </div>
                </header>

                <div class="exercise-grid">
                    <div class="exercise-main">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="exercise-image">
                                <?php the_post_thumbnail('exercise-large'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="exercise-description">
                            <h2><?php _e('Exercise Description', 'fitlife-pro'); ?></h2>
                            <?php the_content(); ?>
                        </div>

                        <?php if ($video_url) : ?>
                            <div class="exercise-video">
                                <h2><?php _e('Video Tutorial', 'fitlife-pro'); ?></h2>
                                <div class="video-wrapper">
                                    <?php
                                    // Simple embed for YouTube/Vimeo
                                    echo wp_oembed_get($video_url);
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <aside class="exercise-sidebar">
                        <div class="exercise-info-card card">
                            <h3><?php _e('Exercise Details', 'fitlife-pro'); ?></h3>

                            <div class="exercise-info-list">
                                <?php if ($duration) : ?>
                                    <div class="info-item">
                                        <span class="info-icon">⏱️</span>
                                        <div class="info-content">
                                            <strong><?php _e('Duration', 'fitlife-pro'); ?></strong>
                                            <span><?php echo esc_html($duration); ?> <?php _e('minutes', 'fitlife-pro'); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($sets) : ?>
                                    <div class="info-item">
                                        <span class="info-icon">🔢</span>
                                        <div class="info-content">
                                            <strong><?php _e('Sets', 'fitlife-pro'); ?></strong>
                                            <span><?php echo esc_html($sets); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($reps) : ?>
                                    <div class="info-item">
                                        <span class="info-icon">🔁</span>
                                        <div class="info-content">
                                            <strong><?php _e('Reps', 'fitlife-pro'); ?></strong>
                                            <span><?php echo esc_html($reps); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($muscle_groups && !is_wp_error($muscle_groups)) : ?>
                                    <div class="info-item">
                                        <span class="info-icon">💪</span>
                                        <div class="info-content">
                                            <strong><?php _e('Muscle Groups', 'fitlife-pro'); ?></strong>
                                            <span>
                                                <?php echo implode(', ', wp_list_pluck($muscle_groups, 'name')); ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if ($equipment && !is_wp_error($equipment)) : ?>
                                    <div class="info-item">
                                        <span class="info-icon">⚡</span>
                                        <div class="info-content">
                                            <strong><?php _e('Equipment', 'fitlife-pro'); ?></strong>
                                            <span>
                                                <?php echo implode(', ', wp_list_pluck($equipment, 'name')); ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <a href="<?php echo esc_url(home_url('/exercises')); ?>" class="btn btn-primary btn-block">
                                <?php _e('Browse More Exercises', 'fitlife-pro'); ?>
                            </a>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </article>

    <style>
    .single-exercise .exercise-content {
        padding: 40px 0;
    }

    .exercise-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .exercise-title {
        font-size: 2.5rem;
        margin-bottom: 20px;
    }

    .exercise-meta-badges {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .exercise-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
    }

    .exercise-main h2 {
        font-size: 1.75rem;
        margin-bottom: 20px;
        margin-top: 30px;
    }

    .exercise-image {
        margin-bottom: 30px;
        border-radius: var(--border-radius);
        overflow: hidden;
    }

    .exercise-image img {
        width: 100%;
        height: auto;
    }

    .exercise-description {
        line-height: 1.8;
    }

    .video-wrapper {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        border-radius: var(--border-radius);
    }

    .video-wrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .exercise-info-card {
        position: sticky;
        top: 100px;
        padding: 25px;
    }

    .exercise-info-card h3 {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid var(--border-color);
    }

    .exercise-info-list {
        margin-bottom: 25px;
    }

    .info-item {
        display: flex;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-icon {
        font-size: 1.5rem;
    }

    .info-content {
        flex: 1;
    }

    .info-content strong {
        display: block;
        margin-bottom: 5px;
        color: var(--dark-color);
    }

    .info-content span {
        color: var(--text-secondary);
    }

    @media (max-width: 992px) {
        .exercise-grid {
            grid-template-columns: 1fr;
        }

        .exercise-info-card {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .exercise-title {
            font-size: 2rem;
        }

        .exercise-meta-badges {
            flex-wrap: wrap;
        }
    }
    </style>

    <?php
endwhile;

get_footer();
