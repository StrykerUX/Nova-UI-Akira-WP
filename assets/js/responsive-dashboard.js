/**
 * Responsive Dashboard & IA Chat JS
 * Handles mobile menu functionality
 */

(function($) {
    'use strict';
    
    // Global variables
    var body = $('body');
    var mobileBreakpoint = 767;
    
    // Function to handle mobile menu
    function handleMobileMenu() {
        // Elements
        var $mobileMenuOverlay = $('.nova-mobile-menu-overlay');
        var $mobileMenuToggle = $('.nova-mobile-menu-toggle');
        var $mobileMenuClose = $('.nova-mobile-menu-close');
        
        // Mobile menu toggle button click
        $mobileMenuToggle.on('click', function() {
            $mobileMenuOverlay.addClass('active');
            body.css('overflow', 'hidden'); // Prevent scrolling
        });
        
        // Close mobile menu when close button is clicked
        $mobileMenuClose.on('click', function() {
            closeMobileMenu();
        });
        
        // Close menu when clicking outside the menu
        $mobileMenuOverlay.on('click', function(e) {
            if ($(e.target).is($mobileMenuOverlay)) {
                closeMobileMenu();
            }
        });
        
        // Close menu when pressing ESC key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && $mobileMenuOverlay.hasClass('active')) {
                closeMobileMenu();
            }
        });
        
        // Close menu when clicking on a menu link (except dropdown toggles)
        $mobileMenuOverlay.find('a[href]').not('[data-bs-toggle]').on('click', function() {
            closeMobileMenu();
        });
        
        // Sync light/dark mode toggle with main toggle
        $('#mobile-light-dark-mode').on('click', function() {
            // This will trigger the existing light/dark toggle functionality
            $('#light-dark-mode').trigger('click');
        });
    }
    
    // Function to close mobile menu
    function closeMobileMenu() {
        $('.nova-mobile-menu-overlay').removeClass('active');
        body.css('overflow', ''); // Restore scrolling
    }
    
    // Handle window resize
    function handleResize() {
        $(window).on('resize', function() {
            // If window width exceeds breakpoint and menu is open, close it
            if ($(window).width() > mobileBreakpoint && $('.nova-mobile-menu-overlay').hasClass('active')) {
                closeMobileMenu();
            }
        });
    }
    
    // Ensure only mobile menu visibility on small screens
    function adjustForMobile() {
        if ($(window).width() <= mobileBreakpoint) {
            // Hide main header and sidebar
            $('.sidenav-menu, .app-topbar').hide();
            // Show mobile header
            $('.nova-mobile-header').show();
        } else {
            // Show main header and sidebar
            $('.sidenav-menu, .app-topbar').show();
            // Hide mobile header
            $('.nova-mobile-header').hide();
        }
    }
    
    // Initialize when document is ready
    $(document).ready(function() {
        handleMobileMenu();
        handleResize();
        adjustForMobile();
        
        // Also adjust when window is resized
        $(window).on('resize', function() {
            adjustForMobile();
        });
        
        // Handle user dropdown in mobile header
        $('.nova-mobile-user-avatar').on('click', function() {
            // If dropdown exists, show it
            if ($('.user-dropdown-menu').length) {
                $('.user-dropdown-menu').toggleClass('show');
            }
        });
    });
    
})(jQuery);
