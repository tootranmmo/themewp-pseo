    </div><!-- #page -->

    <!-- Footer -->
    <footer id="colophon" class="site-footer bg-gradient-dark text-white mt-16" role="contentinfo">
        <!-- Footer Widgets Section -->
        <section class="footer-widgets py-16 lg:py-20" aria-label="<?php _e('Footer', 'fitlife-pro'); ?>">
            <div class="container mx-auto px-4 lg:px-6">
                <div class="footer-widgets-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">

                    <!-- Footer Widget Area 1 -->
                    <div class="footer-widget-area">
                        <?php if (is_active_sidebar('footer-1')) : ?>
                            <?php dynamic_sidebar('footer-1'); ?>
                        <?php else : ?>
                            <h3 class="text-white text-xl font-bold mb-6 pb-3 border-b-4 border-primary-500 inline-block">
                                <?php _e('About FitLife', 'fitlife-pro'); ?>
                            </h3>
                            <p class="text-gray-300 leading-relaxed mb-4">
                                <?php _e('Your comprehensive fitness companion. Discover thousands of exercises, track your progress, and achieve your fitness goals.', 'fitlife-pro'); ?>
                            </p>
                            <div class="flex items-center gap-2 text-primary-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                </svg>
                                <span class="text-sm"><?php _e('Your fitness journey starts here', 'fitlife-pro'); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Footer Widget Area 2 -->
                    <div class="footer-widget-area">
                        <?php if (is_active_sidebar('footer-2')) : ?>
                            <?php dynamic_sidebar('footer-2'); ?>
                        <?php else : ?>
                            <h3 class="text-white text-xl font-bold mb-6 pb-3 border-b-4 border-primary-500 inline-block">
                                <?php _e('Quick Links', 'fitlife-pro'); ?>
                            </h3>
                            <nav aria-label="<?php _e('Footer navigation', 'fitlife-pro'); ?>">
                                <ul class="footer-links list-none m-0 p-0 space-y-3">
                                    <li>
                                        <a href="<?php echo esc_url(home_url('/')); ?>"
                                           class="text-gray-300 hover:text-primary-400 hover:pl-2 transition-all duration-300 inline-block no-underline">
                                            <?php _e('Home', 'fitlife-pro'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo esc_url(home_url('/exercises')); ?>"
                                           class="text-gray-300 hover:text-primary-400 hover:pl-2 transition-all duration-300 inline-block no-underline">
                                            <?php _e('Exercises', 'fitlife-pro'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo esc_url(home_url('/about')); ?>"
                                           class="text-gray-300 hover:text-primary-400 hover:pl-2 transition-all duration-300 inline-block no-underline">
                                            <?php _e('About Us', 'fitlife-pro'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo esc_url(home_url('/contact')); ?>"
                                           class="text-gray-300 hover:text-primary-400 hover:pl-2 transition-all duration-300 inline-block no-underline">
                                            <?php _e('Contact', 'fitlife-pro'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>

                    <!-- Footer Widget Area 3 -->
                    <div class="footer-widget-area">
                        <?php if (is_active_sidebar('footer-3')) : ?>
                            <?php dynamic_sidebar('footer-3'); ?>
                        <?php else : ?>
                            <h3 class="text-white text-xl font-bold mb-6 pb-3 border-b-4 border-primary-500 inline-block">
                                <?php _e('Connect With Us', 'fitlife-pro'); ?>
                            </h3>
                            <div class="social-links flex gap-4 mb-4" role="list" aria-label="<?php _e('Social media links', 'fitlife-pro'); ?>">
                                <a href="#"
                                   class="inline-flex items-center justify-center w-12 h-12 bg-white bg-opacity-10 hover:bg-opacity-20 rounded-full text-2xl hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50"
                                   aria-label="<?php _e('Follow us on Facebook', 'fitlife-pro'); ?>"
                                   role="listitem">
                                    <span aria-hidden="true">📘</span>
                                </a>
                                <a href="#"
                                   class="inline-flex items-center justify-center w-12 h-12 bg-white bg-opacity-10 hover:bg-opacity-20 rounded-full text-2xl hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50"
                                   aria-label="<?php _e('Follow us on Instagram', 'fitlife-pro'); ?>"
                                   role="listitem">
                                    <span aria-hidden="true">📷</span>
                                </a>
                                <a href="#"
                                   class="inline-flex items-center justify-center w-12 h-12 bg-white bg-opacity-10 hover:bg-opacity-20 rounded-full text-2xl hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50"
                                   aria-label="<?php _e('Follow us on Twitter', 'fitlife-pro'); ?>"
                                   role="listitem">
                                    <span aria-hidden="true">🐦</span>
                                </a>
                                <a href="#"
                                   class="inline-flex items-center justify-center w-12 h-12 bg-white bg-opacity-10 hover:bg-opacity-20 rounded-full text-2xl hover:-translate-y-1 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50"
                                   aria-label="<?php _e('Subscribe to our YouTube channel', 'fitlife-pro'); ?>"
                                   role="listitem">
                                    <span aria-hidden="true">📺</span>
                                </a>
                            </div>
                            <p class="text-gray-300 text-sm leading-relaxed">
                                <?php _e('Follow us for daily workout tips and motivation!', 'fitlife-pro'); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer Bottom / Copyright Section -->
        <div class="footer-bottom bg-black bg-opacity-30 py-6 border-t border-white border-opacity-10">
            <div class="container mx-auto px-4 lg:px-6">
                <div class="footer-bottom-content flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="copyright text-gray-400 text-sm m-0 text-center md:text-left">
                        &copy; <?php echo esc_html(date('Y')); ?>
                        <span class="font-semibold text-white"><?php bloginfo('name'); ?></span>.
                        <?php _e('All rights reserved.', 'fitlife-pro'); ?>
                    </p>
                    <div class="credits text-gray-400 text-sm m-0 text-center md:text-right">
                        <?php
                        printf(
                            /* translators: %s: WordPress link */
                            __('Powered by %s', 'fitlife-pro'),
                            '<a href="https://wordpress.org" target="_blank" rel="noopener noreferrer" class="text-primary-400 hover:text-primary-300 transition-colors duration-300 no-underline">WordPress</a>'
                        );
                        ?>
                        <span class="mx-2 text-gray-600" aria-hidden="true">|</span>
                        <span class="text-primary-400"><?php _e('FitLife Pro v2.0', 'fitlife-pro'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Top Button (Optional) -->
        <button
            id="back-to-top"
            class="fixed bottom-8 right-8 w-12 h-12 bg-gradient-to-r from-primary-500 to-accent-500 text-white rounded-full shadow-strong opacity-0 invisible hover:shadow-primary hover:scale-110 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-primary-500 focus:ring-opacity-50 z-40"
            aria-label="<?php _e('Back to top', 'fitlife-pro'); ?>"
            title="<?php _e('Back to top', 'fitlife-pro'); ?>">
            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
        </button>
    </footer>

    <style>
    /* Widget Titles in Footer */
    .footer-widget-area .widget-title,
    .footer-widget-area h3 {
        @apply text-white text-xl font-bold mb-6 pb-3 border-b-4 border-primary-500 inline-block;
    }

    /* Widget Text */
    .footer-widget-area p {
        @apply text-gray-300 leading-relaxed;
    }

    /* Widget Lists */
    .footer-widget-area ul {
        @apply list-none m-0 p-0 space-y-3;
    }

    .footer-widget-area ul li a {
        @apply text-gray-300 hover:text-primary-400 hover:pl-2 transition-all duration-300 inline-block no-underline;
    }

    /* Back to Top Button - Show when scrolled */
    #back-to-top.show {
        @apply opacity-100 visible;
    }

    /* High Contrast Mode */
    @media (prefers-contrast: high) {
        .site-footer {
            @apply border-t-4 border-white;
        }

        .footer-widget-area a {
            @apply border-b-2 border-transparent;
        }

        .footer-widget-area a:hover,
        .footer-widget-area a:focus {
            @apply border-b-2 border-current;
        }
    }

    /* Reduced Motion */
    @media (prefers-reduced-motion: reduce) {
        .social-links a,
        .footer-links a,
        #back-to-top {
            @apply transition-none;
        }
    }

    /* Print Styles */
    @media print {
        .site-footer {
            @apply text-black bg-white mt-8 pt-8 border-t-2 border-gray-900;
        }

        .footer-widgets {
            @apply py-8;
        }

        .footer-widget-area h3 {
            @apply text-gray-900;
        }

        .footer-widget-area p,
        .footer-widget-area a {
            @apply text-gray-900;
        }

        .social-links,
        #back-to-top {
            @apply hidden;
        }

        .footer-bottom {
            @apply bg-transparent border-t border-gray-300;
        }

        .footer-bottom-content {
            @apply flex-row justify-between;
        }

        .copyright,
        .credits {
            @apply text-gray-900;
        }
    }
    </style>

    <script>
    // Back to Top Button
    (function() {
        const backToTopBtn = document.getElementById('back-to-top');
        if (!backToTopBtn) return;

        // Show/hide button on scroll
        let ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    if (window.pageYOffset > 300) {
                        backToTopBtn.classList.add('show');
                    } else {
                        backToTopBtn.classList.remove('show');
                    }
                    ticking = false;
                });
                ticking = true;
            }
        });

        // Scroll to top on click
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    })();
    </script>

    <?php wp_footer(); ?>
</body>
</html>
