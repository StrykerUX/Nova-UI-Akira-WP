/**
 * Hamburger Menu JavaScript
 * Handles the toggling of hamburger menu state
 */
(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Hamburger Icon Toggle
        $('.hamburger-icon').on('click', function() {
            $(this).toggleClass('open');
        });
        
        // Sidebar Toggle with Hamburger
        $('.sidenav-toggle-button').on('click', function() {
            $('.wrapper').toggleClass('sidenav-toggled');
            
            // Save state to localStorage
            if (window.config) {
                if ($('.wrapper').hasClass('sidenav-toggled')) {
                    window.config.sidenav.size = 'collapsed';
                } else {
                    window.config.sidenav.size = 'default';
                }
                localStorage.setItem('__NOVA_CONFIG__', JSON.stringify(window.config));
            }
        });
        
        // Initialize the hamburger icon state based on sidebar state
        if ($('.wrapper').hasClass('sidenav-toggled')) {
            $('.hamburger-icon').addClass('open');
        }
    });
    
})(jQuery);
