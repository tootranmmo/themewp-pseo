<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @package FitLife_Pro
 * @version 2.0.0
 */

get_header();
?>

<main id="main" class="site-main bg-gray-50 py-12 lg:py-16 min-h-screen">
    <div class="container mx-auto px-4 lg:px-6">
        <!-- Page Header -->
        <?php if (is_home() && !is_front_page()) : ?>
            <header class="page-header bg-white rounded-xl shadow-soft p-8 lg:p-12 mb-8 lg:mb-12 text-center">
                <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4">
                    <?php single_post_title(); ?>
                </h1>
                <?php
                $blog_description = get_bloginfo('description', 'display');
                if ($blog_description) :
                    ?>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        <?php echo esc_html($blog_description); ?>
                    </p>
                <?php endif; ?>
            </header>
        <?php endif; ?>

        <div class="content-area max-w-5xl mx-auto">
            <?php
            if (have_posts()) :
                ?>
                <!-- Posts Loop -->
                <div class="posts-container space-y-8 lg:space-y-12">
                    <?php
                    while (have_posts()) :
                        the_post();

                        /*
                         * Include the Post-Type-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                         */
                        get_template_part('template-parts/content', get_post_type());
                    endwhile;
                    ?>
                </div>

                <!-- Posts Navigation -->
                <nav class="posts-navigation mt-12" role="navigation" aria-label="<?php _e('Posts navigation', 'fitlife-pro'); ?>">
                    <?php
                    the_posts_navigation(array(
                        'prev_text' => '<svg class="w-5 h-5 mr-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg> ' . __('Older posts', 'fitlife-pro'),
                        'next_text' => __('Newer posts', 'fitlife-pro') . ' <svg class="w-5 h-5 ml-2 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>',
                    ));
                    ?>
                </nav>

            <?php
            else :
                /*
                 * If no content, include the "No posts found" template.
                 */
                get_template_part('template-parts/content', 'none');
            endif;
            ?>
        </div>
    </div>
</main>

<style>
/* Posts Navigation Styling */
.posts-navigation .nav-links {
    @apply flex justify-between items-center gap-4 flex-wrap;
}

.posts-navigation .nav-previous,
.posts-navigation .nav-next {
    @apply flex-1;
}

.posts-navigation .nav-previous a,
.posts-navigation .nav-next a {
    @apply inline-flex items-center px-6 py-3 bg-white border-2 border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-primary-500 hover:text-white hover:border-primary-500 transition-all duration-300 no-underline shadow-soft hover:shadow-strong;
}

.posts-navigation .nav-previous a {
    @apply justify-start;
}

.posts-navigation .nav-next a {
    @apply justify-end ml-auto;
}

/* Responsive Adjustments */
@media (max-width: 640px) {
    .posts-navigation .nav-links {
        @apply flex-col;
    }

    .posts-navigation .nav-previous,
    .posts-navigation .nav-next {
        @apply w-full;
    }

    .posts-navigation .nav-previous a,
    .posts-navigation .nav-next a {
        @apply w-full justify-center;
    }
}

/* Reduced Motion Support */
@media (prefers-reduced-motion: reduce) {
    .posts-navigation a {
        transition: none !important;
    }
}

/* Print Styles */
@media print {
    .posts-navigation {
        @apply hidden;
    }

    .content-area {
        @apply max-w-full;
    }

    .site-main {
        @apply py-0 bg-white;
    }
}
</style>

<?php
get_footer();
