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
            
            // Si el menú ya está abierto, cerrarlo en lugar de abrirlo
            if ($('.nova-mobile-menu-overlay').hasClass('active')) {
                toggleMobileMenu(false);
            } else {
                toggleMobileMenu(true);
            }
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
                // Primero establecer display block
                $('.nova-mobile-menu-overlay').css('display', 'block');
                
                // Pequeño retraso para que el navegador procese el cambio de display
                setTimeout(function() {
                    // Luego añadir clase active para iniciar la animación
                    $('.nova-mobile-menu-overlay').addClass('active');
                    $('body').addClass('mobile-menu-active');
                    console.log('Menu should be visible now');
                }, 10);
            } else {
                // Quitar clase active para iniciar animación de cierre
                $('.nova-mobile-menu-overlay').removeClass('active');
                $('body').removeClass('mobile-menu-active');
                
                // Esperar a que termine la animación antes de ocultar
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
