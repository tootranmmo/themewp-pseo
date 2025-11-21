/**
 * FitLife Pro Theme JavaScript
 * Version: 2.0.0
 * Pure Vanilla JavaScript - No Dependencies
 *
 * Features:
 * - Mobile menu toggle
 * - FAQ accordion
 * - AJAX exercise search
 * - Smooth scrolling
 * - Intersection Observer for animations
 * - Stats counter animation
 * - Client-side filtering
 * - Accessibility enhancements
 *
 * @package FitLife_Pro
 */

(function() {
    'use strict';

    // DOM Elements Cache
    const DOM = {
        body: document.body,
        html: document.documentElement,
        header: document.querySelector('.site-header'),
        mobileToggle: document.querySelector('[data-mobile-toggle]'),
        mobileMenu: document.querySelector('[data-mobile-menu]'),
        faqQuestions: document.querySelectorAll('[data-faq-question]'),
        searchForm: document.getElementById('exercise-search-form'),
        searchInput: document.getElementById('search-input'),
        filterInputs: document.querySelectorAll('[data-filter]'),
        statsNumbers: document.querySelectorAll('[data-stat]'),
        smoothLinks: document.querySelectorAll('a[href^="#"]'),
        darkModeToggle: document.getElementById('dark-mode-toggle'),
    };

    /**
     * Initialize App
     */
    function init() {
        initDarkMode(); // Initialize dark mode first
        initMobileMenu();
        initFAQAccordion();
        initExerciseSearch();
        initSmoothScroll();
        initIntersectionObserver();
        initStatsAnimation();
        initStickyHeader();
        initAccessibilityFeatures();
        initClientSideFiltering();
        initRatingSystem(); // Initialize rating system
    }

    /**
     * ========================================================================
     * DARK MODE
     * ========================================================================
     */

    /**
     * Initialize Dark Mode
     */
    function initDarkMode() {
        if (!DOM.darkModeToggle) return;

        // Check for saved preference in localStorage
        const savedTheme = localStorage.getItem('fitlife-theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        // Apply saved theme or system preference
        if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
            enableDarkMode();
        } else {
            disableDarkMode();
        }

        // Toggle button click handler
        DOM.darkModeToggle.addEventListener('click', toggleDarkMode);

        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('fitlife-theme')) {
                if (e.matches) {
                    enableDarkMode();
                } else {
                    disableDarkMode();
                }
            }
        });
    }

    /**
     * Toggle Dark Mode
     */
    function toggleDarkMode() {
        if (DOM.html.classList.contains('dark')) {
            disableDarkMode();
        } else {
            enableDarkMode();
        }
    }

    /**
     * Enable Dark Mode
     */
    function enableDarkMode() {
        DOM.html.classList.add('dark');
        localStorage.setItem('fitlife-theme', 'dark');

        // Update aria-label
        if (DOM.darkModeToggle) {
            DOM.darkModeToggle.setAttribute('aria-label', 'Switch to light mode');
            DOM.darkModeToggle.setAttribute('title', 'Switch to light mode');
        }

        // Announce to screen readers
        announceToScreenReader('Dark mode enabled');
    }

    /**
     * Disable Dark Mode
     */
    function disableDarkMode() {
        DOM.html.classList.remove('dark');
        localStorage.setItem('fitlife-theme', 'light');

        // Update aria-label
        if (DOM.darkModeToggle) {
            DOM.darkModeToggle.setAttribute('aria-label', 'Switch to dark mode');
            DOM.darkModeToggle.setAttribute('title', 'Switch to dark mode');
        }

        // Announce to screen readers
        announceToScreenReader('Light mode enabled');
    }

    /**
     * Announce to screen reader (for accessibility)
     */
    function announceToScreenReader(message) {
        const announcement = document.createElement('div');
        announcement.setAttribute('role', 'status');
        announcement.setAttribute('aria-live', 'polite');
        announcement.className = 'sr-only';
        announcement.textContent = message;
        document.body.appendChild(announcement);

        // Remove after announcement
        setTimeout(() => {
            document.body.removeChild(announcement);
        }, 1000);
    }

    /**
     * Mobile Menu Toggle
     */
    function initMobileMenu() {
        if (!DOM.mobileToggle || !DOM.mobileMenu) return;

        DOM.mobileToggle.addEventListener('click', function() {
            const isExpanded = this.getAttribute('aria-expanded') === 'true';

            this.setAttribute('aria-expanded', !isExpanded);
            DOM.mobileMenu.classList.toggle('active');
            DOM.body.classList.toggle('mobile-menu-open');

            // Trap focus in menu when open
            if (!isExpanded) {
                trapFocus(DOM.mobileMenu);
            }
        });

        // Close menu on outside click
        document.addEventListener('click', function(e) {
            if (!DOM.mobileMenu.contains(e.target) && !DOM.mobileToggle.contains(e.target)) {
                closeMobileMenu();
            }
        });

        // Close menu on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && DOM.mobileMenu.classList.contains('active')) {
                closeMobileMenu();
                DOM.mobileToggle.focus();
            }
        });
    }

    function closeMobileMenu() {
        if (!DOM.mobileMenu) return;

        DOM.mobileMenu.classList.remove('active');
        DOM.mobileToggle.setAttribute('aria-expanded', 'false');
        DOM.body.classList.remove('mobile-menu-open');
    }

    /**
     * FAQ Accordion with ARIA
     */
    function initFAQAccordion() {
        DOM.faqQuestions.forEach(function(button) {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-faq-question');
                const answer = document.getElementById(targetId);
                const isExpanded = this.getAttribute('aria-expanded') === 'true';

                // Close other FAQ items (optional - for accordion behavior)
                DOM.faqQuestions.forEach(function(otherButton) {
                    if (otherButton !== button) {
                        otherButton.classList.remove('active');
                        otherButton.setAttribute('aria-expanded', 'false');
                        const otherId = otherButton.getAttribute('data-faq-question');
                        const otherAnswer = document.getElementById(otherId);
                        if (otherAnswer) {
                            otherAnswer.classList.remove('active');
                        }
                    }
                });

                // Toggle current FAQ
                this.classList.toggle('active');
                this.setAttribute('aria-expanded', !isExpanded);
                if (answer) {
                    answer.classList.toggle('active');
                }
            });
        });
    }

    /**
     * AJAX Exercise Search
     */
    function initExerciseSearch() {
        if (!DOM.searchForm) return;

        DOM.searchForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const params = {
                action: 'search_exercises',
                nonce: window.fitlife_ajax.nonce,
                search: formData.get('search') || '',
                muscle_group: formData.get('muscle_group') || '',
                equipment: formData.get('equipment') || '',
                difficulty: formData.get('difficulty') || ''
            };

            performSearch(params);
        });

        // Real-time search (debounced)
        if (DOM.searchInput) {
            let searchTimeout;
            DOM.searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    if (DOM.searchInput.value.length >= 3) {
                        DOM.searchForm.dispatchEvent(new Event('submit'));
                    }
                }, 500);
            });
        }
    }

    /**
     * Perform AJAX Search
     */
    function performSearch(params) {
        const submitButton = DOM.searchForm.querySelector('button[type="submit"]');
        const resultsContainer = getOrCreateResultsContainer();

        // Show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="loading-spinner"></span> Searching...';
        resultsContainer.innerHTML = '<div class="text-center py-12"><span class="loading-spinner"></span> Loading...</div>';

        // Build query string
        const queryString = new URLSearchParams(params).toString();

        // Fetch with error handling
        fetch(window.fitlife_ajax.ajax_url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: queryString
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displaySearchResults(data.data.html);
            } else {
                showError('Failed to load exercises. Please try again.');
            }
        })
        .catch(error => {
            console.error('Search error:', error);
            showError('An error occurred. Please try again later.');
        })
        .finally(() => {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Search';
        });
    }

    /**
     * Display Search Results
     */
    function displaySearchResults(html) {
        const resultsContainer = getOrCreateResultsContainer();
        resultsContainer.innerHTML = '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">' + html + '</div>';

        // Scroll to results
        resultsContainer.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

        // Announce to screen readers
        announceToScreenReader(`${resultsContainer.querySelectorAll('.exercise-card').length} exercises found`);
    }

    /**
     * Get or Create Results Container
     */
    function getOrCreateResultsContainer() {
        let container = document.getElementById('search-results-container');

        if (!container) {
            container = document.createElement('section');
            container.id = 'search-results-container';
            container.className = 'py-16 bg-gray-50';
            container.innerHTML = '<div class="container mx-auto px-4"><h2 class="text-3xl font-bold mb-8 text-center">Search Results</h2><div id="search-results-grid"></div></div>';

            const topSection = document.querySelector('.top-exercises-section');
            if (topSection) {
                topSection.insertAdjacentElement('afterend', container);
            }
        }

        return document.getElementById('search-results-grid') || container;
    }

    /**
     * Show Error Message
     */
    function showError(message) {
        const resultsContainer = getOrCreateResultsContainer();
        resultsContainer.innerHTML = `
            <div class="bg-red-50 border border-red-200 rounded-lg p-6 text-center" role="alert">
                <p class="text-red-800 font-semibold">${message}</p>
            </div>
        `;
        announceToScreenReader(message);
    }

    /**
     * Smooth Scroll for Anchor Links
     */
    function initSmoothScroll() {
        DOM.smoothLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                const target = document.querySelector(targetId);

                if (target) {
                    e.preventDefault();
                    const headerOffset = 80;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });

                    // Set focus for accessibility
                    target.setAttribute('tabindex', '-1');
                    target.focus();
                }
            });
        });
    }

    /**
     * Sticky Header on Scroll
     */
    function initStickyHeader() {
        if (!DOM.header) return;

        let lastScrollTop = 0;
        let ticking = false;

        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                    if (scrollTop > 100) {
                        DOM.header.classList.add('scrolled', 'shadow-md');
                    } else {
                        DOM.header.classList.remove('scrolled', 'shadow-md');
                    }

                    lastScrollTop = scrollTop;
                    ticking = false;
                });

                ticking = true;
            }
        });
    }

    /**
     * Intersection Observer for Animations
     */
    function initIntersectionObserver() {
        if (!('IntersectionObserver' in window)) return;

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in-up');

                    // Animate stats when visible
                    if (entry.target.classList.contains('stats-section')) {
                        animateStats();
                    }

                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        // Observe sections
        document.querySelectorAll('section[class*="section"]').forEach(function(section) {
            observer.observe(section);
        });
    }

    /**
     * Animate Statistics Counter
     */
    function initStatsAnimation() {
        // Will be triggered by IntersectionObserver
    }

    function animateStats() {
        DOM.statsNumbers.forEach(function(stat) {
            const target = parseInt(stat.getAttribute('data-stat'));
            if (isNaN(target)) return;

            let current = 0;
            const increment = target / 60; // Animate over ~1 second
            const timer = setInterval(function() {
                current += increment;
                if (current >= target) {
                    stat.textContent = formatNumber(target);
                    clearInterval(timer);
                } else {
                    stat.textContent = formatNumber(Math.floor(current));
                }
            }, 16); // ~60fps
        });
    }

    /**
     * Format Number with Commas
     */
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    /**
     * Client-Side Filtering (for faster UX)
     */
    function initClientSideFiltering() {
        const cards = document.querySelectorAll('[data-exercise-card]');

        DOM.filterInputs.forEach(function(filter) {
            filter.addEventListener('change', function() {
                const filterType = this.getAttribute('data-filter');
                const filterValue = this.value;

                cards.forEach(function(card) {
                    const cardValue = card.getAttribute('data-' + filterType);

                    if (!filterValue || cardValue === filterValue) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Announce filter change
                const visibleCount = Array.from(cards).filter(c => c.style.display !== 'none').length;
                announceToScreenReader(`Showing ${visibleCount} exercises`);
            });
        });
    }

    /**
     * Accessibility Features
     */
    function initAccessibilityFeatures() {
        // Skip to main content
        const skipLink = document.querySelector('.skip-link');
        if (skipLink) {
            skipLink.addEventListener('click', function(e) {
                e.preventDefault();
                const main = document.getElementById('main');
                if (main) {
                    main.setAttribute('tabindex', '-1');
                    main.focus();
                }
            });
        }

        // Keyboard navigation for cards
        document.querySelectorAll('[role="button"]').forEach(function(button) {
            button.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });
    }

    /**
     * Trap Focus in Element
     */
    function trapFocus(element) {
        const focusableElements = element.querySelectorAll(
            'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
        );

        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];

        element.addEventListener('keydown', function(e) {
            if (e.key !== 'Tab') return;

            if (e.shiftKey) {
                if (document.activeElement === firstElement) {
                    e.preventDefault();
                    lastElement.focus();
                }
            } else {
                if (document.activeElement === lastElement) {
                    e.preventDefault();
                    firstElement.focus();
                }
            }
        });

        // Focus first element
        if (firstElement) {
            firstElement.focus();
        }
    }

    /**
     * Announce to Screen Readers
     */
    function announceToScreenReader(message) {
        const liveRegion = getOrCreateLiveRegion();
        liveRegion.textContent = message;

        // Clear after announcement
        setTimeout(function() {
            liveRegion.textContent = '';
        }, 1000);
    }

    function getOrCreateLiveRegion() {
        let region = document.getElementById('sr-live-region');

        if (!region) {
            region = document.createElement('div');
            region.id = 'sr-live-region';
            region.className = 'sr-only';
            region.setAttribute('role', 'status');
            region.setAttribute('aria-live', 'polite');
            region.setAttribute('aria-atomic', 'true');
            document.body.appendChild(region);
        }

        return region;
    }

    /**
     * Window Load Event
     */
    window.addEventListener('load', function() {
        document.body.classList.add('loaded');
    });

    /**
     * ========================================================================
     * RATING SYSTEM
     * ========================================================================
     */

    /**
     * Initialize Rating System
     */
    function initRatingSystem() {
        const ratingContainers = document.querySelectorAll('.exercise-rating-container');

        ratingContainers.forEach(container => {
            const postId = container.dataset.postId;
            const ratingStars = container.querySelectorAll('.rating-star');
            const ratingMessage = container.querySelector('.rating-message');

            // Hover effect
            ratingStars.forEach((star, index) => {
                star.addEventListener('mouseenter', () => {
                    highlightStars(ratingStars, index + 1);
                });

                star.addEventListener('mouseleave', () => {
                    resetStars(ratingStars);
                });

                // Click to submit rating
                star.addEventListener('click', () => {
                    const rating = star.dataset.rating;
                    submitRating(postId, rating, container, ratingMessage);
                });

                // Keyboard support
                star.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        const rating = star.dataset.rating;
                        submitRating(postId, rating, container, ratingMessage);
                    }
                });
            });
        });
    }

    /**
     * Highlight stars on hover
     */
    function highlightStars(stars, count) {
        stars.forEach((star, index) => {
            if (index < count) {
                star.classList.add('text-yellow-400');
                star.classList.remove('text-gray-300', 'dark:text-gray-600');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300', 'dark:text-gray-600');
            }
        });
    }

    /**
     * Reset stars to default
     */
    function resetStars(stars) {
        stars.forEach(star => {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-300', 'dark:text-gray-600');
        });
    }

    /**
     * Submit rating via AJAX
     */
    function submitRating(postId, rating, container, messageElement) {
        // Show loading state
        messageElement.textContent = 'Submitting...';
        messageElement.className = 'rating-message mt-2 text-sm text-gray-600 dark:text-gray-400';

        // AJAX request
        const formData = new FormData();
        formData.append('action', 'fitlife_submit_rating');
        formData.append('post_id', postId);
        formData.append('rating', rating);
        formData.append('nonce', fitlife_ajax.nonce);

        fetch(fitlife_ajax.ajax_url, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update UI
                updateRatingDisplay(container, data.data);

                // Show success message
                messageElement.textContent = data.data.message;
                messageElement.className = 'rating-message mt-2 text-sm text-green-600 dark:text-green-400 font-semibold';

                // Hide rating form after successful submission
                const ratingForm = container.querySelector('.rating-form');
                if (ratingForm) {
                    setTimeout(() => {
                        ratingForm.style.opacity = '0';
                        setTimeout(() => {
                            ratingForm.style.display = 'none';
                        }, 300);
                    }, 2000);
                }

                // Announce to screen reader
                announceToScreenReader(`Rating submitted successfully. New average: ${data.data.data.average} stars`);
            } else {
                // Show error message
                messageElement.textContent = data.data.message || 'Error submitting rating';
                messageElement.className = 'rating-message mt-2 text-sm text-red-600 dark:text-red-400';

                // Announce to screen reader
                announceToScreenReader(`Error: ${data.data.message}`);
            }
        })
        .catch(error => {
            console.error('Rating submission error:', error);
            messageElement.textContent = 'Error submitting rating. Please try again.';
            messageElement.className = 'rating-message mt-2 text-sm text-red-600 dark:text-red-400';
        });
    }

    /**
     * Update rating display with new data
     */
    function updateRatingDisplay(container, data) {
        const ratingDisplay = container.querySelector('.rating-display');
        if (!ratingDisplay) return;

        const average = data.average;
        const count = data.count;

        // Update stars
        const stars = ratingDisplay.querySelectorAll('.stars svg');
        stars.forEach((star, index) => {
            if (index < Math.round(average)) {
                star.classList.add('text-yellow-400');
                star.classList.remove('text-gray-300', 'dark:text-gray-600');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300', 'dark:text-gray-600');
            }
        });

        // Update rating info text
        const ratingInfo = ratingDisplay.querySelector('.rating-info');
        if (ratingInfo) {
            const ratingText = count === 1 ? 'rating' : 'ratings';
            ratingInfo.innerHTML = `
                <span class="font-semibold text-gray-900 dark:text-white">${average}</span>
                <span>(${count} ${ratingText})</span>
            `;
        }

        // Update aria-label
        const starsContainer = ratingDisplay.querySelector('.stars');
        if (starsContainer) {
            starsContainer.setAttribute('aria-label', `Average rating: ${average} out of 5`);
        }
    }

    /**
     * Responsive Handler
     */
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            if (window.innerWidth > 992) {
                closeMobileMenu();
            }
        }, 250);
    });

    /**
     * Initialize on DOM Ready
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
