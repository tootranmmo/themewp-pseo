<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="masthead" class="site-header">
    <nav class="navbar">
        <div class="container">
            <div class="navbar-wrapper">
                <div class="site-branding">
                    <?php
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-title">
                            <span class="logo-icon">💪</span>
                            <span><?php bloginfo('name'); ?></span>
                        </a>
                        <?php
                    }
                    ?>
                </div>

                <button class="mobile-menu-toggle" aria-label="Toggle Menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="main-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class' => 'nav-menu',
                        'container' => false,
                        'fallback_cb' => 'fitlife_default_menu',
                    ));
                    ?>
                </div>

                <div class="header-actions">
                    <a href="<?php echo esc_url(home_url('/exercises')); ?>" class="btn btn-primary btn-sm">
                        <?php _e('Browse Exercises', 'fitlife-pro'); ?>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>

<style>
/* Header Styles */
.site-header {
    background: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.navbar {
    padding: 15px 0;
}

.navbar-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 30px;
}

.site-branding {
    flex-shrink: 0;
}

.site-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark-color);
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: var(--transition);
}

.site-title:hover {
    color: var(--primary-color);
}

.logo-icon {
    font-size: 1.8rem;
}

.custom-logo-link img {
    max-height: 50px;
    width: auto;
}

.main-navigation {
    flex-grow: 1;
    display: flex;
    justify-content: center;
}

.nav-menu {
    list-style: none;
    display: flex;
    gap: 30px;
    margin: 0;
    padding: 0;
}

.nav-menu li {
    position: relative;
}

.nav-menu a {
    color: var(--text-primary);
    font-weight: 500;
    padding: 8px 0;
    display: block;
    transition: var(--transition);
}

.nav-menu a:hover {
    color: var(--primary-color);
}

.header-actions {
    flex-shrink: 0;
}

.btn-sm {
    padding: 8px 20px;
    font-size: 14px;
}

.mobile-menu-toggle {
    display: none;
    flex-direction: column;
    gap: 4px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px;
}

.mobile-menu-toggle span {
    width: 25px;
    height: 3px;
    background: var(--dark-color);
    border-radius: 2px;
    transition: var(--transition);
}

/* Responsive */
@media (max-width: 992px) {
    .main-navigation {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .main-navigation.active {
        display: block;
    }

    .nav-menu {
        flex-direction: column;
        gap: 15px;
    }

    .mobile-menu-toggle {
        display: flex;
    }

    .header-actions {
        display: none;
    }
}

@media (max-width: 576px) {
    .navbar {
        padding: 10px 0;
    }

    .site-title {
        font-size: 1.25rem;
    }
}
</style>

<?php
// Default menu fallback
function fitlife_default_menu() {
    echo '<ul class="nav-menu">';
    echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'fitlife-pro') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/exercises')) . '">' . __('Exercises', 'fitlife-pro') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/about')) . '">' . __('About', 'fitlife-pro') . '</a></li>';
    echo '<li><a href="' . esc_url(home_url('/contact')) . '">' . __('Contact', 'fitlife-pro') . '</a></li>';
    echo '</ul>';
}
?>
