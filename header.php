<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class('antialiased'); ?>>
<?php wp_body_open(); ?>

<!-- Skip to Content Link for Accessibility -->
<a href="#main" class="skip-link screen-reader-text focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-[100000] focus:px-6 focus:py-3 focus:bg-gray-900 focus:text-white focus:rounded-lg focus:shadow-lg">
    <?php _e('Skip to content', 'fitlife-pro'); ?>
</a>

<!-- Header -->
<header id="masthead" class="site-header bg-white shadow-soft sticky top-0 z-50 transition-shadow duration-300" role="banner">
    <nav class="container mx-auto px-4 lg:px-6" role="navigation" aria-label="<?php _e('Main Navigation', 'fitlife-pro'); ?>">
        <div class="flex items-center justify-between gap-6 py-4">

            <!-- Site Branding -->
            <div class="site-branding flex-shrink-0">
                <?php if (has_custom_logo()) : ?>
                    <div class="custom-logo-link">
                        <?php the_custom_logo(); ?>
                    </div>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>"
                       class="site-title flex items-center gap-2 text-2xl font-bold text-gray-900 hover:text-primary-500 transition-colors duration-300 no-underline"
                       rel="home"
                       aria-label="<?php bloginfo('name'); ?> - <?php _e('Home', 'fitlife-pro'); ?>">
                        <span class="logo-icon text-3xl" aria-hidden="true">💪</span>
                        <span><?php bloginfo('name'); ?></span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Toggle -->
            <button
                type="button"
                class="mobile-menu-toggle lg:hidden flex flex-col gap-1 p-2 bg-transparent border-none cursor-pointer focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 rounded transition-all duration-300"
                data-mobile-toggle
                aria-expanded="false"
                aria-controls="primary-menu"
                aria-label="<?php _e('Toggle mobile menu', 'fitlife-pro'); ?>">
                <span class="block w-6 h-0.5 bg-gray-900 rounded transition-transform duration-300"></span>
                <span class="block w-6 h-0.5 bg-gray-900 rounded transition-opacity duration-300"></span>
                <span class="block w-6 h-0.5 bg-gray-900 rounded transition-transform duration-300"></span>
            </button>

            <!-- Primary Navigation -->
            <div
                id="primary-menu"
                class="main-navigation hidden lg:flex flex-1 justify-center"
                data-mobile-menu
                role="menubar">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu-list',
                    'menu_class'     => 'nav-menu flex flex-col lg:flex-row items-start lg:items-center gap-4 lg:gap-8 list-none m-0 p-0',
                    'container'      => false,
                    'fallback_cb'    => 'fitlife_default_menu',
                    'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menu">%3$s</ul>',
                    'link_before'    => '<span class="menu-text">',
                    'link_after'     => '</span>',
                ));
                ?>
            </div>

            <!-- Header Actions -->
            <div class="header-actions hidden lg:flex flex-shrink-0 gap-3">
                <a href="<?php echo esc_url(home_url('/exercises')); ?>"
                   class="inline-flex items-center px-5 py-2 bg-gradient-to-r from-primary-500 to-accent-500 text-white font-semibold text-sm rounded-lg shadow-soft hover:shadow-primary hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 no-underline"
                   aria-label="<?php _e('Browse all exercises', 'fitlife-pro'); ?>">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <?php _e('Browse Exercises', 'fitlife-pro'); ?>
                </a>
            </div>
        </div>

        <!-- Mobile Menu (Hidden by default, shown via JavaScript) -->
        <div
            class="mobile-menu-panel lg:hidden hidden bg-white border-t border-gray-200 py-4"
            id="mobile-menu-panel"
            role="dialog"
            aria-modal="true"
            aria-label="<?php _e('Mobile menu', 'fitlife-pro'); ?>">
            <!-- Menu items are already rendered above, this is just the container for mobile styling -->
        </div>
    </nav>
</header>

<!-- Main Content Wrapper -->
<div id="page" class="site min-h-screen flex flex-col">

<style>
/* Custom styles for navigation items with Tailwind */
.nav-menu a {
    @apply text-gray-700 font-medium py-2 px-0 lg:px-1 block transition-colors duration-300 no-underline;
}

.nav-menu a:hover,
.nav-menu a:focus {
    @apply text-primary-500;
}

.nav-menu li {
    @apply relative;
}

.nav-menu .current-menu-item > a,
.nav-menu .current_page_item > a {
    @apply text-primary-500 font-semibold;
}

/* Mobile menu active state */
.main-navigation.active {
    @apply flex absolute top-full left-0 right-0 bg-white shadow-strong p-6 animate-slide-down;
}

/* Mobile menu toggle animation */
.mobile-menu-toggle[aria-expanded="true"] span:first-child {
    @apply rotate-45 translate-y-1.5;
}

.mobile-menu-toggle[aria-expanded="true"] span:nth-child(2) {
    @apply opacity-0;
}

.mobile-menu-toggle[aria-expanded="true"] span:last-child {
    @apply -rotate-45 -translate-y-1.5;
}

/* Custom logo styling */
.custom-logo-link img {
    @apply max-h-12 w-auto;
}

/* Sticky header shadow enhancement */
.site-header.scrolled {
    @apply shadow-medium;
}

/* Mobile menu panel */
@media (max-width: 1023px) {
    .main-navigation.active {
        display: flex !important;
    }

    .nav-menu {
        width: 100%;
    }

    .nav-menu li {
        width: 100%;
    }

    .nav-menu a {
        @apply py-3 px-4 rounded-lg hover:bg-gray-50;
    }
}

/* High contrast mode support */
@media (prefers-contrast: high) {
    .site-header {
        @apply border-b-2 border-gray-900;
    }

    .nav-menu a {
        @apply border border-transparent;
    }

    .nav-menu a:hover,
    .nav-menu a:focus {
        @apply border-gray-900;
    }
}

/* Reduced motion */
@media (prefers-reduced-motion: reduce) {
    .site-header,
    .nav-menu a,
    .mobile-menu-toggle span,
    .header-actions a {
        @apply transition-none;
    }
}

/* Print styles */
@media print {
    .site-header {
        @apply static shadow-none;
    }

    .mobile-menu-toggle,
    .header-actions {
        @apply hidden;
    }
}
</style>

<?php
/**
 * Default menu fallback with Tailwind classes
 */
function fitlife_default_menu() {
    $menu_items = array(
        array(
            'url' => home_url('/'),
            'title' => __('Home', 'fitlife-pro'),
            'current' => is_front_page()
        ),
        array(
            'url' => home_url('/exercises'),
            'title' => __('Exercises', 'fitlife-pro'),
            'current' => is_post_type_archive('exercise')
        ),
        array(
            'url' => home_url('/about'),
            'title' => __('About', 'fitlife-pro'),
            'current' => is_page('about')
        ),
        array(
            'url' => home_url('/contact'),
            'title' => __('Contact', 'fitlife-pro'),
            'current' => is_page('contact')
        ),
    );

    echo '<ul class="nav-menu flex flex-col lg:flex-row items-start lg:items-center gap-4 lg:gap-8 list-none m-0 p-0" role="menu">';

    foreach ($menu_items as $item) {
        $current_class = $item['current'] ? ' current-menu-item' : '';
        echo '<li class="menu-item' . $current_class . '" role="none">';
        echo '<a href="' . esc_url($item['url']) . '" role="menuitem">' . esc_html($item['title']) . '</a>';
        echo '</li>';
    }

    echo '</ul>';
}
?>
