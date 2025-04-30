/**
 * Icon Hover Effect for Nova UI Akira
 * Applies the theme accent color to icon hover states
 */
(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Get the accent color from CSS variables
        const accentColor = getComputedStyle(document.documentElement).getPropertyValue('--bs-accent') || '#7949f6';
        
        // Apply hover effect to icons using jQuery
        $('.btn-icon i, .topbar-link i, .side-nav-link i, .menu-icon i').parent().hover(
            function() {
                // On hover
                $(this).find('i').css('color', accentColor);
            },
            function() {
                // On hover out
                $(this).find('i').css('color', '');
            }
        );
        
        // Make sure the hamburger menu icon uses the accent color
        $('.sidenav-toggle-button').hover(
            function() {
                $(this).find('i').css('color', accentColor);
            },
            function() {
                $(this).find('i').css('color', '');
            }
        );
        
        // Apply to light/dark mode toggle button
        $('#light-dark-mode').hover(
            function() {
                $(this).find('i').css('color', accentColor);
            },
            function() {
                $(this).find('i').css('color', '');
            }
        );
        
        // Update hover color when theme settings change
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === 'style') {
                    const updatedAccentColor = getComputedStyle(document.documentElement).getPropertyValue('--bs-accent') || '#7949f6';
                    
                    // Update any hover event currently active
                    $('i:hover').css('color', updatedAccentColor);
                }
            });
        });
        
        // Observe document root for style changes
        observer.observe(document.documentElement, { attributes: true });
    });
    
})(jQuery);
