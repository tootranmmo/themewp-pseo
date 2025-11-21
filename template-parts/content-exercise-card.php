<?php
/**
 * Template part for displaying exercise cards
 *
 * @package FitLife_Pro
 */

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
            <?php if ($calories) : ?>
                <span class="badge badge-calories"><?php echo esc_html($calories); ?> cal</span>
            <?php endif; ?>
            <span class="badge badge-<?php echo esc_attr($difficulty_class); ?>">
                <?php echo $difficulty_terms ? esc_html($difficulty_terms[0]->name) : __('Beginner', 'fitlife-pro'); ?>
            </span>
        </div>

        <h3 class="card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>

        <div class="card-meta">
            <?php if ($duration) : ?>
                <span>⏱️ <?php echo esc_html($duration); ?> min</span>
            <?php endif; ?>

            <?php
            $muscle_terms = get_the_terms(get_the_ID(), 'muscle_group');
            if ($muscle_terms && !is_wp_error($muscle_terms)) :
                ?>
                <span>💪 <?php echo esc_html($muscle_terms[0]->name); ?></span>
            <?php endif; ?>
        </div>

        <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-block">
            <?php _e('View Details', 'fitlife-pro'); ?>
        </a>
    </div>
</div>
