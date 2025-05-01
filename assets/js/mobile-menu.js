/**
 * Nova UI Akira - Mobile Menu JS
 * Handles the interaction for the responsive mobile menu
 */

(function($) {
    'use strict';
    
    // Global variables
    var body = $('body');
    var window_width = $(window).width();
    var mobileBreakpoint = 991;
    
    // Function to handle mobile menu
    function handleMobileMenu() {
        // Elements
        var $mobileMenuOverlay = $('.nova-mobile-menu-overlay');
        var $menuToggleButton = $('.sidenav-toggle-button');
        var $mobileMenuClose = $('.nova-mobile-menu-close');
        
        // Check if the elements exist
        if (!$mobileMenuOverlay.length || !$menuToggleButton.length || !$mobileMenuClose.length) {
            return;
        }
        
        // Modify the existing toggle button behavior based on screen size
        $menuToggleButton.off('click'); // Remove any existing click handlers
        $menuToggleButton.on('click', function(e) {
            e.preventDefault();
            
            // If below the mobile breakpoint, toggle mobile menu
            if (window.innerWidth <= mobileBreakpoint) {
                $mobileMenuOverlay.addClass('active');
                body.css('overflow', 'hidden'); // Prevent scrolling of body
            } else {
                // Original sidebar behavior for desktop
                $('html').toggleClass('sidebar-enable');
                
                if (window_width >= 992) {
                    var sidenavSize = $('html').attr('data-sidenav-size');
                    
                    if (sidenavSize === 'condensed') {
                        $('html').attr('data-sidenav-size', 'default');
                    } else {
                        $('html').attr('data-sidenav-size', 'condensed');
                    }
                }
            }
        });
        
        // Close mobile menu when clicking close button
        $mobileMenuClose.on('click', function() {
            closeMobileMenu();
        });
        
        // Close mobile menu when clicking on the overlay (outside the menu)
        $mobileMenuOverlay.on('click', function(e) {
            if (e.target === this) {
                closeMobileMenu();
            }
        });
        
        // Close mobile menu when pressing Escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $mobileMenuOverlay.hasClass('active')) {
                closeMobileMenu();
            }
        });
        
        // Close mobile menu when clicking on a menu item
        $mobileMenuOverlay.find('a[href]').not('[data-bs-toggle]').on('click', function() {
            closeMobileMenu();
        });
        
        // Sync dark/light mode toggle
        $('#mobile-light-dark-mode').on('click', function() {
            $('#light-dark-mode').trigger('click');
        });
    }
    
    // Function to close mobile menu
    function closeMobileMenu() {
        $('.nova-mobile-menu-overlay').removeClass('active');
        body.css('overflow', ''); // Restore body scrolling
    }
    
    // Handle window resize
    function handleResize() {
        $(window).on('resize', function() {
            window_width = $(window).width();
            
            // If window resized to desktop size, close mobile menu
            if (window_width > mobileBreakpoint && $('.nova-mobile-menu-overlay').hasClass('active')) {
                closeMobileMenu();
            }
        });
    }
    
    // Initialize when document is ready
    $(document).ready(function() {
        handleMobileMenu();
        handleResize();
    });
    
})(jQuery);
