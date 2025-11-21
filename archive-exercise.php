<?php
/**
 * Archive template for exercises
 *
 * @package FitLife_Pro
 */

get_header();
?>

<div class="archive-exercise-page">
    <div class="page-header section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-align: center; padding: 60px 0;">
        <div class="container">
            <h1 class="page-title">
                <?php
                if (is_tax()) {
                    single_term_title();
                } else {
                    _e('All Exercises', 'fitlife-pro');
                }
                ?>
            </h1>

            <?php
            if (is_tax() && term_description()) {
                echo '<div class="archive-description">' . term_description() . '</div>';
            }
            ?>
        </div>
    </div>

    <div class="container section">
        <div class="archive-filters">
            <form method="get" class="filter-form">
                <select name="muscle_group" class="search-select">
                    <option value=""><?php _e('All Muscle Groups', 'fitlife-pro'); ?></option>
                    <?php
                    $muscle_groups = get_terms(array('taxonomy' => 'muscle_group', 'hide_empty' => false));
                    foreach ($muscle_groups as $term) {
                        $selected = isset($_GET['muscle_group']) && $_GET['muscle_group'] == $term->slug ? 'selected' : '';
                        echo '<option value="' . esc_attr($term->slug) . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
                    }
                    ?>
                </select>

                <select name="equipment" class="search-select">
                    <option value=""><?php _e('All Equipment', 'fitlife-pro'); ?></option>
                    <?php
                    $equipment_terms = get_terms(array('taxonomy' => 'equipment', 'hide_empty' => false));
                    foreach ($equipment_terms as $term) {
                        $selected = isset($_GET['equipment']) && $_GET['equipment'] == $term->slug ? 'selected' : '';
                        echo '<option value="' . esc_attr($term->slug) . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
                    }
                    ?>
                </select>

                <select name="difficulty" class="search-select">
                    <option value=""><?php _e('All Levels', 'fitlife-pro'); ?></option>
                    <?php
                    $difficulty_terms = get_terms(array('taxonomy' => 'difficulty', 'hide_empty' => false));
                    foreach ($difficulty_terms as $term) {
                        $selected = isset($_GET['difficulty']) && $_GET['difficulty'] == $term->slug ? 'selected' : '';
                        echo '<option value="' . esc_attr($term->slug) . '" ' . $selected . '>' . esc_html($term->name) . '</option>';
                    }
                    ?>
                </select>

                <button type="submit" class="btn btn-primary"><?php _e('Filter', 'fitlife-pro'); ?></button>
            </form>
        </div>

        <div class="exercise-results">
            <?php if (have_posts()) : ?>
                <div class="grid grid-3">
                    <?php
                    while (have_posts()) :
                        the_post();
                        get_template_part('template-parts/content', 'exercise-card');
                    endwhile;
                    ?>
                </div>

                <div class="pagination">
                    <?php
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => __('&laquo; Previous', 'fitlife-pro'),
                        'next_text' => __('Next &raquo;', 'fitlife-pro'),
                    ));
                    ?>
                </div>
            <?php else : ?>
                <p><?php _e('No exercises found.', 'fitlife-pro'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.archive-filters {
    background: white;
    padding: 25px;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    margin-bottom: 40px;
}

.filter-form {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
}

.pagination {
    margin-top: 40px;
    text-align: center;
}

.pagination .nav-links {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
}

.pagination a,
.pagination span {
    display: inline-block;
    padding: 10px 15px;
    background: white;
    border: 2px solid var(--border-color);
    border-radius: var(--border-radius);
    color: var(--text-primary);
    text-decoration: none;
    transition: var(--transition);
}

.pagination a:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.pagination .current {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

@media (max-width: 768px) {
    .filter-form {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
get_footer();
