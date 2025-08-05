/**
 * BizMart Pro Theme JavaScript
 * 
 * @package BizMart Pro
 * @version 1.0.0
 */

(function($) {
    'use strict';

    // DOM Ready
    $(document).ready(function() {
        initTheme();
    });

    // Window Load
    $(window).on('load', function() {
        // Remove preloader if exists
        $('.preloader').fadeOut();
        
        // Initialize animations
        initScrollAnimations();
    });

    /**
     * Initialize Theme Functions
     */
    function initTheme() {
        initMobileMenu();
        initSearchToggle();
        initCartDropdown();
        initScrollToTop();
        initSmoothScroll();
        initProductQuickView();
        initNewsletterForm();
        initLazyLoading();
        initToolTips();
        initProductFilters();
    }

    /**
     * Mobile Menu
     */
    function initMobileMenu() {
        var $mobileToggle = $('.mobile-menu-toggle');
        var $mobileMenu = $('.mobile-menu');
        var $mobileOverlay = $('.mobile-menu-overlay');
        var $mobileClose = $('.mobile-menu-close');

        $mobileToggle.on('click', function(e) {
            e.preventDefault();
            openMobileMenu();
        });

        $mobileClose.add($mobileOverlay).on('click', function(e) {
            e.preventDefault();
            closeMobileMenu();
        });

        // Close menu on escape key
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27 && $mobileMenu.hasClass('active')) {
                closeMobileMenu();
            }
        });

        function openMobileMenu() {
            $mobileMenu.addClass('active');
            $mobileOverlay.addClass('active');
            $('body').addClass('mobile-menu-open');
        }

        function closeMobileMenu() {
            $mobileMenu.removeClass('active');
            $mobileOverlay.removeClass('active');
            $('body').removeClass('mobile-menu-open');
        }

        // Handle submenu toggles
        $('.mobile-navigation .menu-item-has-children > a').on('click', function(e) {
            e.preventDefault();
            var $submenu = $(this).next('.sub-menu');
            var $parent = $(this).parent();

            if ($parent.hasClass('open')) {
                $submenu.slideUp();
                $parent.removeClass('open');
            } else {
                $submenu.slideDown();
                $parent.addClass('open');
            }
        });
    }

    /**
     * Search Toggle
     */
    function initSearchToggle() {
        var $searchToggle = $('.search-toggle');
        var $searchWrapper = $('.search-form-wrapper');
        var $searchClose = $('.search-close');
        var $searchField = $('.search-field');

        $searchToggle.on('click', function(e) {
            e.preventDefault();
            openSearch();
        });

        $searchClose.on('click', function(e) {
            e.preventDefault();
            closeSearch();
        });

        // Close search on escape key
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27 && $searchWrapper.hasClass('active')) {
                closeSearch();
            }
        });

        function openSearch() {
            $searchWrapper.addClass('active');
            $searchField.focus();
            $('body').addClass('search-open');
        }

        function closeSearch() {
            $searchWrapper.removeClass('active');
            $('body').removeClass('search-open');
        }

        // Live search functionality
        var searchTimeout;
        $searchField.on('input', function() {
            var query = $(this).val();
            
            clearTimeout(searchTimeout);
            
            if (query.length >= 3) {
                searchTimeout = setTimeout(function() {
                    performLiveSearch(query);
                }, 300);
            }
        });
    }

    /**
     * Cart Dropdown
     */
    function initCartDropdown() {
        var $cartToggle = $('.cart-toggle');
        var $cartDropdown = $('.cart-dropdown');

        $cartToggle.on('click', function(e) {
            e.preventDefault();
            $cartDropdown.toggleClass('active');
        });

        // Close cart dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.cart-dropdown').length) {
                $cartDropdown.removeClass('active');
            }
        });

        // Update cart count animation
        $(document.body).on('added_to_cart', function() {
            $('.cart-count').addClass('bounce');
            setTimeout(function() {
                $('.cart-count').removeClass('bounce');
            }, 600);
        });
    }

    /**
     * Scroll to Top
     */
    function initScrollToTop() {
        var $backToTop = $('.back-to-top');

        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                $backToTop.addClass('show');
            } else {
                $backToTop.removeClass('show');
            }
        });

        $backToTop.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 600, 'easeInOutCubic');
        });
    }

    /**
     * Smooth Scroll
     */
    function initSmoothScroll() {
        $('a[href*="#"]:not([href="#"])').on('click', function(e) {
            var target = $(this.getAttribute('href'));
            
            if (target.length) {
                e.preventDefault();
                
                var offset = target.offset().top - 80; // Account for fixed header
                
                $('html, body').animate({
                    scrollTop: offset
                }, 800, 'easeInOutCubic');
            }
        });
    }

    /**
     * Product Quick View
     */
    function initProductQuickView() {
        $('.quick-view-btn').on('click', function(e) {
            e.preventDefault();
            
            var productId = $(this).data('product-id');
            openQuickView(productId);
        });

        function openQuickView(productId) {
            // Show loading
            showQuickViewModal();
            
            // AJAX request to get product data
            $.ajax({
                url: bizmart_ajax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'bizmart_quick_view',
                    product_id: productId,
                    nonce: bizmart_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        $('.quick-view-content').html(response.data);
                        initQuickViewSlider();
                    }
                },
                error: function() {
                    $('.quick-view-content').html('<p>Error loading product details.</p>');
                }
            });
        }

        function showQuickViewModal() {
            var modal = '<div class="quick-view-modal">' +
                           '<div class="quick-view-overlay"></div>' +
                           '<div class="quick-view-content">' +
                               '<div class="loading">Loading...</div>' +
                           '</div>' +
                           '<button class="quick-view-close">&times;</button>' +
                        '</div>';
            
            $('body').append(modal);
            $('.quick-view-modal').addClass('active');
        }

        // Close quick view
        $(document).on('click', '.quick-view-close, .quick-view-overlay', function() {
            $('.quick-view-modal').removeClass('active');
            setTimeout(function() {
                $('.quick-view-modal').remove();
            }, 300);
        });
    }

    /**
     * Newsletter Form
     */
    function initNewsletterForm() {
        $('.newsletter-form').on('submit', function(e) {
            e.preventDefault();
            
            var $form = $(this);
            var $email = $form.find('input[type="email"]');
            var $button = $form.find('button');
            var email = $email.val();

            if (!isValidEmail(email)) {
                showNotification('Please enter a valid email address.', 'error');
                return;
            }

            // Disable button and show loading
            $button.prop('disabled', true).text('Subscribing...');

            // AJAX subscription
            $.ajax({
                url: bizmart_ajax.ajaxurl,
                type: 'POST',
                data: {
                    action: 'bizmart_newsletter_subscribe',
                    email: email,
                    nonce: bizmart_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        showNotification('Thank you for subscribing!', 'success');
                        $email.val('');
                    } else {
                        showNotification(response.data || 'Subscription failed.', 'error');
                    }
                },
                error: function() {
                    showNotification('Connection error. Please try again.', 'error');
                },
                complete: function() {
                    $button.prop('disabled', false).text('Subscribe');
                }
            });
        });

        function isValidEmail(email) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    }

    /**
     * Lazy Loading
     */
    function initLazyLoading() {
        if ('IntersectionObserver' in window) {
            var imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        var img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });

            $('.lazy').each(function() {
                imageObserver.observe(this);
            });
        }
    }

    /**
     * Tooltips
     */
    function initToolTips() {
        $('[data-tooltip]').each(function() {
            var $element = $(this);
            var tooltip = $element.data('tooltip');
            
            $element.on('mouseenter', function() {
                showTooltip($element, tooltip);
            });

            $element.on('mouseleave', function() {
                hideTooltip();
            });
        });

        function showTooltip($element, text) {
            var $tooltip = $('<div class="tooltip">' + text + '</div>');
            $('body').append($tooltip);

            var position = $element.offset();
            var elementHeight = $element.outerHeight();
            
            $tooltip.css({
                top: position.top - $tooltip.outerHeight() - 10,
                left: position.left + ($element.outerWidth() / 2) - ($tooltip.outerWidth() / 2)
            }).addClass('show');
        }

        function hideTooltip() {
            $('.tooltip').remove();
        }
    }

    /**
     * Product Filters
     */
    function initProductFilters() {
        $('.product-filter').on('change', function() {
            var $form = $(this).closest('form');
            var formData = $form.serialize();

            // Show loading
            $('.products').addClass('loading');

            $.ajax({
                url: window.location.href,
                type: 'GET',
                data: formData,
                success: function(response) {
                    var $newProducts = $(response).find('.products');
                    $('.products').html($newProducts.html()).removeClass('loading');
                    
                    // Update URL without reload
                    history.pushState(null, '', '?' + formData);
                },
                error: function() {
                    $('.products').removeClass('loading');
                    showNotification('Error loading products.', 'error');
                }
            });
        });

        // Price range slider
        if ($('#price-range').length) {
            $('#price-range').slider({
                range: true,
                min: 0,
                max: 1000,
                values: [0, 1000],
                slide: function(event, ui) {
                    $('#price-min').val(ui.values[0]);
                    $('#price-max').val(ui.values[1]);
                    $('#price-display').text('$' + ui.values[0] + ' - $' + ui.values[1]);
                }
            });
        }
    }

    /**
     * Scroll Animations
     */
    function initScrollAnimations() {
        if ('IntersectionObserver' in window) {
            var animateObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate');
                    }
                });
            }, {
                threshold: 0.1
            });

            $('.animate-on-scroll').each(function() {
                animateObserver.observe(this);
            });
        }
    }

    /**
     * Live Search
     */
    function performLiveSearch(query) {
        $.ajax({
            url: bizmart_ajax.ajaxurl,
            type: 'POST',
            data: {
                action: 'bizmart_live_search',
                query: query,
                nonce: bizmart_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    showSearchResults(response.data);
                }
            }
        });
    }

    function showSearchResults(results) {
        var $resultsContainer = $('.search-results');
        
        if (!$resultsContainer.length) {
            $resultsContainer = $('<div class="search-results"></div>');
            $('.search-form-wrapper').append($resultsContainer);
        }

        $resultsContainer.html(results).addClass('show');
    }

    /**
     * Notifications
     */
    function showNotification(message, type) {
        var $notification = $('<div class="notification notification-' + type + '">' + message + '</div>');
        
        $('body').append($notification);
        
        setTimeout(function() {
            $notification.addClass('show');
        }, 100);

        setTimeout(function() {
            $notification.removeClass('show');
            setTimeout(function() {
                $notification.remove();
            }, 300);
        }, 4000);
    }

    /**
     * Custom Easing
     */
    $.easing.easeInOutCubic = function(x, t, b, c, d) {
        if ((t /= d / 2) < 1) return c / 2 * t * t * t + b;
        return c / 2 * ((t -= 2) * t * t + 2) + b;
    };

    /**
     * Header Scroll Effect
     */
    $(window).on('scroll', function() {
        var scrollTop = $(this).scrollTop();
        var $header = $('.site-header');

        if (scrollTop > 100) {
            $header.addClass('scrolled');
        } else {
            $header.removeClass('scrolled');
        }
    });

    /**
     * Product Image Zoom
     */
    $('.product-image').on('mouseenter', function() {
        $(this).find('img').addClass('zoom');
    }).on('mouseleave', function() {
        $(this).find('img').removeClass('zoom');
    });

    /**
     * Quantity Input Controls
     */
    $(document).on('click', '.qty-btn', function(e) {
        e.preventDefault();
        
        var $input = $(this).siblings('input[type="number"]');
        var currentVal = parseInt($input.val()) || 0;
        var step = parseInt($input.attr('step')) || 1;
        var min = parseInt($input.attr('min')) || 0;
        var max = parseInt($input.attr('max')) || 999;
        
        if ($(this).hasClass('qty-plus')) {
            if (currentVal < max) {
                $input.val(currentVal + step).trigger('change');
            }
        } else {
            if (currentVal > min) {
                $input.val(currentVal - step).trigger('change');
            }
        }
    });

    /**
     * Accordion
     */
    $('.accordion-header').on('click', function() {
        var $accordion = $(this).closest('.accordion-item');
        var $content = $accordion.find('.accordion-content');
        
        if ($accordion.hasClass('active')) {
            $content.slideUp();
            $accordion.removeClass('active');
        } else {
            $('.accordion-item.active .accordion-content').slideUp();
            $('.accordion-item').removeClass('active');
            
            $content.slideDown();
            $accordion.addClass('active');
        }
    });

    /**
     * Tabs
     */
    $('.tab-nav a').on('click', function(e) {
        e.preventDefault();
        
        var $tab = $(this);
        var target = $tab.attr('href');
        var $tabContainer = $tab.closest('.tabs');
        
        // Remove active classes
        $tabContainer.find('.tab-nav a').removeClass('active');
        $tabContainer.find('.tab-content').removeClass('active');
        
        // Add active classes
        $tab.addClass('active');
        $(target).addClass('active');
    });

})(jQuery);