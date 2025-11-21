/**
 * FitLife Pro Theme JavaScript
 *
 * @package FitLife_Pro
 */

(function($) {
    'use strict';

    // Wait for DOM to be ready
    $(document).ready(function() {

        /**
         * Mobile Menu Toggle
         */
        $('.mobile-menu-toggle').on('click', function() {
            $(this).toggleClass('active');
            $('.main-navigation').toggleClass('active');
        });

        /**
         * FAQ Accordion
         */
        $('.faq-question').on('click', function() {
            const $this = $(this);
            const $answer = $this.next('.faq-answer');
            const $allQuestions = $('.faq-question');
            const $allAnswers = $('.faq-answer');

            // Close all other FAQ items
            $allQuestions.not($this).removeClass('active');
            $allAnswers.not($answer).removeClass('active');

            // Toggle current FAQ item
            $this.toggleClass('active');
            $answer.toggleClass('active');
        });

        /**
         * Exercise Search Form - AJAX
         */
        $('#exercise-search-form').on('submit', function(e) {
            e.preventDefault();

            const $form = $(this);
            const searchValue = $('#search-input').val();
            const muscleGroup = $('#muscle-group-filter').val();
            const equipment = $('#equipment-filter').val();
            const difficulty = $('#difficulty-filter').val();

            // Show loading state
            showLoadingState();

            // Make AJAX request
            $.ajax({
                url: fitlife_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'search_exercises',
                    nonce: fitlife_ajax.nonce,
                    search: searchValue,
                    muscle_group: muscleGroup,
                    equipment: equipment,
                    difficulty: difficulty
                },
                success: function(response) {
                    if (response.success) {
                        // Display results
                        displaySearchResults(response.data.html);
                    } else {
                        showError('Failed to load exercises. Please try again.');
                    }
                },
                error: function() {
                    showError('An error occurred. Please try again later.');
                },
                complete: function() {
                    hideLoadingState();
                }
            });
        });

        /**
         * Display search results
         */
        function displaySearchResults(html) {
            // Check if results container exists, create if not
            let $resultsContainer = $('#search-results-container');

            if ($resultsContainer.length === 0) {
                $resultsContainer = $('<div id="search-results-container" class="section"><div class="container"><h2>Search Results</h2><div id="search-results-grid" class="grid grid-3"></div></div></div>');
                $('.top-exercises-section').after($resultsContainer);
            }

            // Update results
            $('#search-results-grid').html(html);

            // Scroll to results
            $('html, body').animate({
                scrollTop: $resultsContainer.offset().top - 100
            }, 500);
        }

        /**
         * Show loading state
         */
        function showLoadingState() {
            const $button = $('#exercise-search-form button[type="submit"]');
            $button.prop('disabled', true);
            $button.html('<span class="loading-spinner"></span> Searching...');
        }

        /**
         * Hide loading state
         */
        function hideLoadingState() {
            const $button = $('#exercise-search-form button[type="submit"]');
            $button.prop('disabled', false);
            $button.html('Search');
        }

        /**
         * Show error message
         */
        function showError(message) {
            alert(message); // Simple alert for now, can be replaced with custom notification
        }

        /**
         * Smooth Scroll for Anchor Links
         */
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));

            if (target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 80
                }, 800);
            }
        });

        /**
         * Sticky Header on Scroll
         */
        let lastScrollTop = 0;
        const $header = $('.site-header');

        $(window).on('scroll', function() {
            const scrollTop = $(this).scrollTop();

            if (scrollTop > 100) {
                $header.addClass('scrolled');
            } else {
                $header.removeClass('scrolled');
            }

            lastScrollTop = scrollTop;
        });

        /**
         * Animate statistics on scroll
         */
        function animateStats() {
            const $stats = $('.stat-number');

            $stats.each(function() {
                const $this = $(this);
                const targetValue = parseInt($this.text().replace(/,/g, ''));

                if (!isNaN(targetValue)) {
                    $({ Counter: 0 }).animate({ Counter: targetValue }, {
                        duration: 2000,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.ceil(this.Counter).toLocaleString());
                        },
                        complete: function() {
                            $this.text(targetValue.toLocaleString());
                        }
                    });
                }
            });
        }

        /**
         * Intersection Observer for animations
         */
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-in');

                        // Animate stats when visible
                        if (entry.target.classList.contains('stats-section')) {
                            animateStats();
                        }

                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            // Observe sections
            document.querySelectorAll('.section').forEach(function(section) {
                observer.observe(section);
            });
        }

        /**
         * Card hover effects
         */
        $('.card, .category-card, .difficulty-card').hover(
            function() {
                $(this).addClass('hover');
            },
            function() {
                $(this).removeClass('hover');
            }
        );

        /**
         * Form validation for search
         */
        $('#search-input').on('input', function() {
            const value = $(this).val();
            if (value.length > 0 && value.length < 2) {
                $(this).addClass('invalid');
            } else {
                $(this).removeClass('invalid');
            }
        });

        /**
         * Auto-complete for search (optional enhancement)
         */
        let searchTimeout;
        $('#search-input').on('keyup', function() {
            clearTimeout(searchTimeout);
            const query = $(this).val();

            if (query.length >= 3) {
                searchTimeout = setTimeout(function() {
                    // Could implement auto-suggest here
                    console.log('Searching for:', query);
                }, 500);
            }
        });

        /**
         * Print exercise details
         */
        $('.print-exercise').on('click', function(e) {
            e.preventDefault();
            window.print();
        });

        /**
         * Share functionality (if needed)
         */
        $('.share-exercise').on('click', function(e) {
            e.preventDefault();

            if (navigator.share) {
                navigator.share({
                    title: document.title,
                    url: window.location.href
                }).catch(function(error) {
                    console.log('Error sharing:', error);
                });
            } else {
                // Fallback: copy to clipboard
                const url = window.location.href;
                navigator.clipboard.writeText(url).then(function() {
                    alert('Link copied to clipboard!');
                });
            }
        });

        /**
         * Lazy load images (if needed)
         */
        if ('loading' in HTMLImageElement.prototype) {
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                img.src = img.dataset.src;
            });
        }

        /**
         * Initialize tooltips (if using)
         */
        $('[data-tooltip]').hover(
            function() {
                const tooltip = $(this).data('tooltip');
                $(this).append('<div class="tooltip">' + tooltip + '</div>');
            },
            function() {
                $(this).find('.tooltip').remove();
            }
        );

    }); // End document ready

    /**
     * Window load events
     */
    $(window).on('load', function() {
        // Hide page loader if exists
        $('.page-loader').fadeOut();

        // Trigger any load-dependent animations
        $('body').addClass('loaded');
    });

    /**
     * Window resize events
     */
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            // Handle responsive adjustments
            if ($(window).width() > 992) {
                $('.main-navigation').removeClass('active');
                $('.mobile-menu-toggle').removeClass('active');
            }
        }, 250);
    });

})(jQuery);
