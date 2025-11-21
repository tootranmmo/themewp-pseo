<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package FitLife_Pro
 * @version 2.0.0
 */
?>

<section class="no-results not-found bg-white rounded-xl shadow-soft p-8 lg:p-12 text-center">
    <!-- Icon -->
    <div class="mb-6">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Header -->
    <header class="page-header mb-6">
        <h1 class="page-title text-3xl lg:text-4xl font-extrabold text-gray-900 mb-4">
            <?php _e('Nothing Found', 'fitlife-pro'); ?>
        </h1>
    </header>

    <!-- Content -->
    <div class="page-content max-w-2xl mx-auto">
        <?php
        if (is_home() && current_user_can('publish_posts')) :
            ?>
            <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                <?php _e('Ready to publish your first post? Get started here.', 'fitlife-pro'); ?>
            </p>
            <a href="<?php echo esc_url(admin_url('post-new.php')); ?>"
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-primary-500 to-accent-500 text-white font-bold rounded-lg shadow-soft hover:shadow-strong hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 no-underline">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <?php _e('Create Your First Post', 'fitlife-pro'); ?>
            </a>

        <?php elseif (is_search()) : ?>
            <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                <?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'fitlife-pro'); ?>
            </p>

            <!-- Search Suggestions -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 mb-8 text-left">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                    <?php _e('Search Tips:', 'fitlife-pro'); ?>
                </h2>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span><?php _e('Try more general keywords', 'fitlife-pro'); ?></span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span><?php _e('Check your spelling', 'fitlife-pro'); ?></span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span><?php _e('Try different keywords or synonyms', 'fitlife-pro'); ?></span>
                    </li>
                    <li class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span><?php _e('Use fewer keywords to broaden results', 'fitlife-pro'); ?></span>
                    </li>
                </ul>
            </div>

            <!-- Search Form -->
            <div class="bg-white border-2 border-gray-200 rounded-xl p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">
                    <?php _e('Try Another Search', 'fitlife-pro'); ?>
                </h3>
                <?php get_search_form(); ?>
            </div>

            <!-- Popular Exercises Link -->
            <?php if (post_type_exists('exercise')) : ?>
                <div class="mt-8">
                    <p class="text-gray-600 mb-4">
                        <?php _e('Or browse our popular exercises:', 'fitlife-pro'); ?>
                    </p>
                    <a href="<?php echo esc_url(home_url('/exercises')); ?>"
                       class="inline-flex items-center px-6 py-3 border-2 border-primary-500 text-primary-500 font-semibold rounded-lg hover:bg-primary-500 hover:text-white transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 no-underline">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                        <?php _e('Browse All Exercises', 'fitlife-pro'); ?>
                    </a>
                </div>
            <?php endif; ?>

        <?php else : ?>
            <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                <?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'fitlife-pro'); ?>
            </p>

            <!-- Search Form -->
            <div class="bg-white border-2 border-gray-200 rounded-xl p-6 max-w-md mx-auto">
                <?php get_search_form(); ?>
            </div>

            <!-- Quick Links -->
            <div class="mt-8">
                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    <?php _e('Quick Links', 'fitlife-pro'); ?>
                </h2>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="<?php echo esc_url(home_url('/')); ?>"
                       class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-primary-500 text-gray-700 hover:text-white font-semibold rounded-lg transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 no-underline">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <?php _e('Home', 'fitlife-pro'); ?>
                    </a>

                    <?php if (post_type_exists('exercise')) : ?>
                        <a href="<?php echo esc_url(home_url('/exercises')); ?>"
                           class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-primary-500 text-gray-700 hover:text-white font-semibold rounded-lg transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 no-underline">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            <?php _e('Exercises', 'fitlife-pro'); ?>
                        </a>
                    <?php endif; ?>

                    <a href="<?php echo esc_url(home_url('/contact')); ?>"
                       class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-primary-500 text-gray-700 hover:text-white font-semibold rounded-lg transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 no-underline">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <?php _e('Contact', 'fitlife-pro'); ?>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
/* Search Form Styling within No Results */
.no-results .search-form {
    @apply w-full;
}

.no-results .search-form label {
    @apply block w-full;
}

.no-results .search-form input[type="search"] {
    @apply w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 focus:border-primary-500 transition-all duration-300;
}

.no-results .search-form button,
.no-results .search-form input[type="submit"] {
    @apply mt-4 w-full px-6 py-3 bg-gradient-to-r from-primary-500 to-accent-500 text-white font-bold rounded-lg shadow-soft hover:shadow-strong hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 cursor-pointer border-none;
}

/* Reduced Motion Support */
@media (prefers-reduced-motion: reduce) {
    .no-results a,
    .no-results button {
        transition: none !important;
    }
}

/* Print Styles */
@media print {
    .no-results {
        @apply shadow-none border border-gray-300;
    }

    .no-results svg {
        @apply hidden;
    }

    .no-results a {
        @apply text-gray-900 no-underline;
    }

    .search-form,
    .quick-links {
        @apply hidden;
    }
}
</style>
