    <footer id="colophon" class="site-footer">
        <div class="footer-widgets">
            <div class="container">
                <div class="footer-widgets-grid">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-1'); ?>
                        </div>
                    <?php else : ?>
                        <div class="footer-widget-area">
                            <h3><?php _e('About FitLife', 'fitlife-pro'); ?></h3>
                            <p><?php _e('Your comprehensive fitness companion. Discover thousands of exercises, track your progress, and achieve your fitness goals.', 'fitlife-pro'); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('footer-2')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-2'); ?>
                        </div>
                    <?php else : ?>
                        <div class="footer-widget-area">
                            <h3><?php _e('Quick Links', 'fitlife-pro'); ?></h3>
                            <ul class="footer-links">
                                <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'fitlife-pro'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/exercises')); ?>"><?php _e('Exercises', 'fitlife-pro'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/about')); ?>"><?php _e('About Us', 'fitlife-pro'); ?></a></li>
                                <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php _e('Contact', 'fitlife-pro'); ?></a></li>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (is_active_sidebar('footer-3')) : ?>
                        <div class="footer-widget-area">
                            <?php dynamic_sidebar('footer-3'); ?>
                        </div>
                    <?php else : ?>
                        <div class="footer-widget-area">
                            <h3><?php _e('Connect With Us', 'fitlife-pro'); ?></h3>
                            <div class="social-links">
                                <a href="#" aria-label="Facebook">📘</a>
                                <a href="#" aria-label="Instagram">📷</a>
                                <a href="#" aria-label="Twitter">🐦</a>
                                <a href="#" aria-label="YouTube">📺</a>
                            </div>
                            <p class="mt-3"><?php _e('Follow us for daily workout tips and motivation!', 'fitlife-pro'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <p class="copyright">
                        &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.
                        <?php _e('All rights reserved.', 'fitlife-pro'); ?>
                    </p>
                    <p class="credits">
                        <?php printf(__('Powered by %s', 'fitlife-pro'), '<a href="https://wordpress.org" target="_blank">WordPress</a>'); ?>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <style>
    /* Footer Styles */
    .site-footer {
        background: linear-gradient(135deg, #1A1A2E 0%, #16213E 100%);
        color: white;
        margin-top: 60px;
    }

    .footer-widgets {
        padding: 60px 0 40px;
    }

    .footer-widgets-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 40px;
    }

    .footer-widget-area h3 {
        color: white;
        font-size: 1.25rem;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }

    .footer-widget-area h3::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background: var(--primary-color);
    }

    .footer-widget-area p {
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.8;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 10px;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.8);
        transition: var(--transition);
        display: inline-block;
    }

    .footer-links a:hover {
        color: var(--primary-color);
        padding-left: 5px;
    }

    .social-links {
        display: flex;
        gap: 15px;
        font-size: 1.5rem;
    }

    .social-links a {
        display: inline-block;
        transition: var(--transition);
    }

    .social-links a:hover {
        transform: translateY(-3px);
    }

    .footer-bottom {
        background: rgba(0, 0, 0, 0.3);
        padding: 20px 0;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .footer-bottom-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .footer-bottom p {
        margin: 0;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.9rem;
    }

    .footer-bottom a {
        color: var(--primary-color);
    }

    .footer-bottom a:hover {
        color: var(--accent-color);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .footer-widgets-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .footer-bottom-content {
            flex-direction: column;
            text-align: center;
        }
    }
    </style>

    <?php wp_footer(); ?>
</body>
</html>
