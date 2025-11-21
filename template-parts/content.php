<?php
/**
 * Template part for displaying posts
 *
 * @package FitLife_Pro
 * @version 2.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-xl shadow-soft overflow-hidden mb-8 lg:mb-12'); ?>>

    <!-- Featured Image -->
    <?php if (has_post_thumbnail()) : ?>
        <div class="post-thumbnail relative overflow-hidden h-64 lg:h-80">
            <a href="<?php the_permalink(); ?>" aria-label="<?php printf(__('View %s', 'fitlife-pro'), esc_attr(get_the_title())); ?>">
                <?php the_post_thumbnail('large', array(
                    'class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-500',
                    'loading' => 'lazy'
                )); ?>
            </a>

            <!-- Category Badge Overlay -->
            <?php if (has_category()) : ?>
                <div class="absolute top-4 left-4">
                    <?php
                    $categories = get_the_category();
                    if ($categories && !is_wp_error($categories)) :
                        ?>
                        <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>"
                           class="inline-flex items-center px-4 py-2 bg-primary-500 text-white text-sm font-semibold rounded-lg shadow-soft hover:bg-primary-600 transition-colors duration-300 no-underline">
                            <?php echo esc_html($categories[0]->name); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="p-6 lg:p-8">
        <!-- Entry Header -->
        <header class="entry-header mb-6">
            <?php
            if (is_singular()) :
                the_title('<h1 class="entry-title text-3xl lg:text-4xl font-extrabold text-gray-900 mb-4 leading-tight">', '</h1>');
            else :
                the_title(
                    '<h2 class="entry-title text-2xl lg:text-3xl font-bold text-gray-900 mb-4 leading-tight">
                        <a href="' . esc_url(get_permalink()) . '" class="text-gray-900 hover:text-primary-500 transition-colors duration-300 no-underline" rel="bookmark">',
                    '</a></h2>'
                );
            endif;
            ?>

            <?php if ('post' === get_post_type()) : ?>
                <div class="entry-meta flex flex-wrap items-center gap-4 text-sm text-gray-500">
                    <!-- Published Date -->
                    <time class="posted-on inline-flex items-center gap-1" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span><?php echo esc_html(get_the_date()); ?></span>
                    </time>

                    <!-- Author -->
                    <span class="byline inline-flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span><?php
                            printf(
                                /* translators: %s: post author */
                                __('by %s', 'fitlife-pro'),
                                '<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" class="text-gray-500 hover:text-primary-500 transition-colors no-underline">' . esc_html(get_the_author()) . '</a>'
                            );
                            ?></span>
                    </span>

                    <!-- Reading Time (estimate) -->
                    <?php
                    $word_count = str_word_count(strip_tags(get_the_content()));
                    $reading_time = ceil($word_count / 200); // Average reading speed: 200 words/min
                    if ($reading_time > 0) :
                        ?>
                        <span class="reading-time inline-flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span><?php printf(__('%d min read', 'fitlife-pro'), $reading_time); ?></span>
                        </span>
                    <?php endif; ?>

                    <!-- Comment Count -->
                    <?php if (comments_open() || get_comments_number()) : ?>
                        <span class="comments-link inline-flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            <a href="<?php comments_link(); ?>" class="text-gray-500 hover:text-primary-500 transition-colors no-underline">
                                <?php
                                printf(
                                    /* translators: %s: number of comments */
                                    _n('%s comment', '%s comments', get_comments_number(), 'fitlife-pro'),
                                    number_format_i18n(get_comments_number())
                                );
                                ?>
                            </a>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </header>

        <!-- Entry Content -->
        <div class="entry-content prose prose-lg max-w-none text-gray-700 leading-relaxed">
            <?php
            the_content(sprintf(
                wp_kses(
                    /* translators: %s: Name of current post */
                    __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'fitlife-pro'),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ));

            wp_link_pages(array(
                'before' => '<div class="page-links flex flex-wrap gap-2 mt-8 pt-6 border-t border-gray-200">
                    <span class="page-links-title font-semibold text-gray-900">' . esc_html__('Pages:', 'fitlife-pro') . '</span>',
                'after'  => '</div>',
                'link_before' => '<span class="inline-flex items-center justify-center min-w-[2.5rem] h-10 px-3 bg-white border border-gray-300 rounded-lg hover:bg-primary-500 hover:text-white hover:border-primary-500 transition-all duration-300">',
                'link_after' => '</span>',
            ));
            ?>
        </div>

        <!-- Entry Footer -->
        <?php
        $categories_list = get_the_category_list(', ');
        $tags_list = get_the_tag_list('', ', ');

        if ($categories_list || $tags_list) :
            ?>
            <footer class="entry-footer mt-8 pt-6 border-t border-gray-200">
                <div class="flex flex-col lg:flex-row gap-4">
                    <?php if ($categories_list) : ?>
                        <div class="categories-links flex flex-wrap items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-900">
                                <?php _e('Posted in:', 'fitlife-pro'); ?>
                            </span>
                            <div class="flex flex-wrap gap-2">
                                <?php
                                $categories = get_the_category();
                                foreach ($categories as $category) :
                                    ?>
                                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                                       class="inline-flex items-center px-3 py-1 bg-gray-100 hover:bg-primary-500 text-gray-700 hover:text-white text-sm rounded-full transition-all duration-300 no-underline">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($tags_list) : ?>
                        <div class="tags-links flex flex-wrap items-center gap-2">
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span class="text-sm font-semibold text-gray-900">
                                <?php _e('Tagged:', 'fitlife-pro'); ?>
                            </span>
                            <div class="flex flex-wrap gap-2">
                                <?php
                                $tags = get_the_tags();
                                if ($tags && !is_wp_error($tags)) :
                                    foreach ($tags as $tag) :
                                        ?>
                                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>"
                                           class="inline-flex items-center px-3 py-1 bg-accent-100 hover:bg-accent-500 text-accent-700 hover:text-white text-sm rounded-full transition-all duration-300 no-underline">
                                            #<?php echo esc_html($tag->name); ?>
                                        </a>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </footer>
        <?php endif; ?>
    </div>
</article>

<style>
/* Prose Styles for Content */
.entry-content.prose {
    @apply text-gray-700;
}

.entry-content.prose p {
    @apply mb-4;
}

.entry-content.prose h2,
.entry-content.prose h3,
.entry-content.prose h4 {
    @apply font-bold text-gray-900 mt-8 mb-4;
}

.entry-content.prose h2 {
    @apply text-2xl lg:text-3xl;
}

.entry-content.prose h3 {
    @apply text-xl lg:text-2xl;
}

.entry-content.prose h4 {
    @apply text-lg lg:text-xl;
}

.entry-content.prose a {
    @apply text-primary-500 hover:text-primary-600 underline transition-colors;
}

.entry-content.prose ul,
.entry-content.prose ol {
    @apply mb-4 pl-6;
}

.entry-content.prose ul {
    @apply list-disc;
}

.entry-content.prose ol {
    @apply list-decimal;
}

.entry-content.prose li {
    @apply mb-2;
}

.entry-content.prose blockquote {
    @apply border-l-4 border-primary-500 pl-6 py-2 italic text-gray-600 my-6;
}

.entry-content.prose img {
    @apply rounded-lg shadow-soft my-6;
}

.entry-content.prose pre {
    @apply bg-gray-900 text-gray-100 rounded-lg p-4 overflow-x-auto my-6;
}

.entry-content.prose code {
    @apply bg-gray-100 text-primary-600 px-2 py-1 rounded text-sm;
}

.entry-content.prose pre code {
    @apply bg-transparent text-gray-100 px-0 py-0;
}

/* Reduced Motion Support */
@media (prefers-reduced-motion: reduce) {
    article,
    article img,
    article a {
        transition: none !important;
    }
}

/* Print Styles */
@media print {
    article {
        @apply shadow-none border border-gray-300 page-break-inside-avoid mb-8;
    }

    .post-thumbnail,
    .entry-meta svg,
    .entry-footer svg {
        @apply hidden;
    }

    .entry-title,
    .entry-content {
        @apply text-gray-900;
    }

    .entry-meta,
    .entry-footer {
        @apply text-gray-600;
    }

    article a {
        @apply text-gray-900 no-underline;
    }
}
</style>
