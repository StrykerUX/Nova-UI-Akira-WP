/**
 * Mobile Navigation JS for Nova UI Akira
 */
(function($) {
    'use strict';
    
    // Mobile menu functionality
    $(document).ready(function() {
        // Log to verify script is running
        console.log('Mobile Navigation script initialized');

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
            console.log('Toggle Mobile Menu: ' + (show ? 'show' : 'hide'));
            
            if (show) {
                // Show menu overlay
                $('.nova-mobile-menu-overlay').addClass('active');
                $('body').addClass('mobile-menu-active');
                console.log('Menu should be visible now');
                
                // Force display block before adding active class
                $('.nova-mobile-menu-overlay').css('display', 'block');
                
                // Add a small delay for CSS transition to work properly
                setTimeout(function() {
                    $('.nova-mobile-menu-overlay').addClass('active');
                }, 10);
            } else {
                // Hide menu overlay
                $('.nova-mobile-menu-overlay').removeClass('active');
                $('body').removeClass('mobile-menu-active');
                
                // Delay removing display to allow transition to complete
                setTimeout(function() {
                    if (!$('.nova-mobile-menu-overlay').hasClass('active')) {
                        $('.nova-mobile-menu-overlay').css('display', '');
                    }
                }, 300);
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
