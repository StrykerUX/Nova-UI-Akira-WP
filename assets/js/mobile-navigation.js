/**
 * Nova UI Akira - Mobile Navigation Scripts
 */
(function($) {
    'use strict';
    
    // Mobile menu toggle
    $('#mobile-menu-toggle').on('click', function() {
        $('#mobile-menu-overlay').addClass('active');
        $('body').addClass('mobile-nav-active');
    });
    
    // Mobile menu close
    $('#mobile-menu-close').on('click', function() {
        $('#mobile-menu-overlay').removeClass('active');
        $('body').removeClass('mobile-nav-active');
    });
    
    // Close mobile menu when clicking outside
    $('#mobile-menu-overlay').on('click', function(e) {
        if ($(e.target).closest('.mobile-menu-container').length === 0) {
            $('#mobile-menu-overlay').removeClass('active');
            $('body').removeClass('mobile-nav-active');
        }
    });
    
    // Stop propagation on container click
    $('.mobile-menu-container').on('click', function(e) {
        e.stopPropagation();
    });
    
    // Mobile light/dark mode toggle
    $('#mobile-light-dark-mode').on('click', function() {
        // Toggle body class
        $('body').toggleClass('dark-mode');
        
        // Update icon
        if ($('body').hasClass('dark-mode')) {
            $('#mobile-light-dark-mode i').removeClass('ti-moon').addClass('ti-sun');
        } else {
            $('#mobile-light-dark-mode i').removeClass('ti-sun').addClass('ti-moon');
        }
        
        // Sync with desktop toggle
        if ($('#light-dark-mode').length) {
            $('#light-dark-mode').trigger('click');
        }
    });
    
    // Initialize mobile theme based on current theme
    $(document).ready(function() {
        const isDarkMode = $('body').hasClass('dark-mode');
        if (isDarkMode) {
            $('#mobile-light-dark-mode i').removeClass('ti-moon').addClass('ti-sun');
        }
    });
    
})(jQuery);