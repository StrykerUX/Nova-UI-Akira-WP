/**
 * Layout functionality for Nova UI Akira theme
 */
(function($) {
    'use strict';
    
    // Global variables
    var body = $('body');
    var window_width = $(window).width();
    
    // Function to handle responsive menu
    function handleResponsiveMenu() {
        $('.sidenav-toggle-button').on('click', function(e) {
            e.preventDefault();
            $('html').toggleClass('sidebar-enable');
            
            if (window_width >= 992) {
                var sidenavSize = $('html').attr('data-sidenav-size');
                
                if (sidenavSize === 'condensed') {
                    $('html').attr('data-sidenav-size', 'default');
                } else {
                    $('html').attr('data-sidenav-size', 'condensed');
                }
            }
        });
        
        // Close menu when clicking outside
        $(document).on('click', function(e) {
            if ($(e.target).closest('.sidenav-toggle-button, .sidenav-menu').length === 0) {
                $('html').removeClass('sidebar-enable');
            }
        });
    }
    
    // Initialize layout
    $(document).ready(function() {
        handleResponsiveMenu();
    });
    
})(jQuery);
