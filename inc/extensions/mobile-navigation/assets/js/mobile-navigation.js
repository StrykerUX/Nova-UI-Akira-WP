/**
 * Mobile Navigation JS for Nova UI Akira
 */
(function($) {
    'use strict';
    
    // Mobile menu functionality
    $(document).ready(function() {
        // Toggle mobile menu
        $('#nova-mobile-menu-toggle').on('click', function(e) {
            e.preventDefault();
            toggleMobileMenu(true);
        });
        
        // Close mobile menu
        $('#nova-mobile-menu-close').on('click', function() {
            toggleMobileMenu(false);
        });
        
        // Close when clicking outside the menu
        $(document).on('click', function(e) {
            if ($(e.target).closest('#nova-mobile-menu-toggle, .nova-mobile-menu-container').length === 0 &&
                $('.nova-mobile-menu-overlay').hasClass('active')) {
                toggleMobileMenu(false);
            }
        });
        
        // Toggle dark/light mode from mobile menu
        $('#mobile-light-dark-mode').on('click', function() {
            // Trigger the main theme toggle button if it exists
            if ($('#light-dark-mode').length) {
                $('#light-dark-mode').trigger('click');
                
                // Update icon based on current theme
                setTimeout(function() {
                    updateDarkModeIcon();
                }, 100);
            }
        });
        
        // Initialize dark mode icon
        updateDarkModeIcon();
        
        // Function to toggle mobile menu
        function toggleMobileMenu(show) {
            if (show) {
                $('.nova-mobile-menu-overlay').addClass('active');
                $('body').addClass('mobile-menu-active');
            } else {
                $('.nova-mobile-menu-overlay').removeClass('active');
                $('body').removeClass('mobile-menu-active');
            }
        }
        
        // Function to update dark mode icon
        function updateDarkModeIcon() {
            var isDarkMode = $('html').attr('data-bs-theme') === 'dark';
            
            if (isDarkMode) {
                $('#mobile-light-dark-mode i').removeClass('ti-moon').addClass('ti-sun');
            } else {
                $('#mobile-light-dark-mode i').removeClass('ti-sun').addClass('ti-moon');
            }
        }
    });
    
})(jQuery);
